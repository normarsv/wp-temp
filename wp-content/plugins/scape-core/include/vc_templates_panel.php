<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class WTBX_Vc_Templates_Panel_Editor
 * @since 1.0
 */
class WTBX_Vc_Templates_Panel_Editor {
	/**
	 * @since 4.4
	 * @var string
	 */
	protected $option_name = 'wpb_js_templates';
	/**
	 * @since 4.4
	 * @var bool
	 */
	protected $scape_templates = false;
	/**
	 * @since 4.4
	 * @var bool
	 */
	protected $default_templates = false;
	/**
	 * @since 4.4
	 * Add ajax hooks, filters.
	 */
	public function init() {

		add_filter( 'vc_templates_render_category', array(
			$this,
			'renderTemplateBlock',
		), 10 );
		add_filter( 'vc_templates_render_template', array(
			$this,
			'renderTemplateWindow',
		), 10, 2 );

		add_filter( 'vc_get_all_templates', array(
			$this,
			'addTemplatesTab',
		) );

		add_action( 'wp_ajax_vc_backend_load_template', array(
			$this,
			'renderBackendTemplate',
		) );
		add_action( 'wp_ajax_vc_frontend_load_template', array(
			$this,
			'renderFrontendTemplate',
		) );

		add_action( 'template_redirect', array(
			$this,
			'loadShortcodes',
		) );

	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function addTemplatesTab( $data ) {
		if ( SCAPE_Core_Extend::is_theme_activated() ) {
			$newCategory = array(
				'category'        => 'scape_templates',
				'category_name'   => esc_html__( 'Scape templates', 'core-extension' ),
				'category_weight' => 1,
				'templates'       => $this->getAllTemplates(),
			);
			$data[] = $newCategory;
		}

		return $data;
	}

	public function getTemplates() {
		$templates = wtbx_vc_templates();
		return $templates;
	}

	protected function get_template_categories() {

		$output = '';

		$categories = array(
			'general'       => esc_html__( 'All', 'core-extension' ),
			'banner'        => esc_html__( 'Banners', 'core-extension' ),
			'blog'          => esc_html__( 'Blog', 'core-extension'),
			'categories'    => esc_html__( 'Categories', 'core-extension' ),
			'client'        => esc_html__( 'Clients', 'core-extension' ),
			'counter'       => esc_html__( 'Counters', 'core-extension' ),
			'faq_tabs'      => esc_html__( 'FAQ / Tabs', 'core-extension' ),
			'features'      => esc_html__( 'Features', 'core-extension' ),
			'footer'        => esc_html__( 'Footers', 'core-extension' ),
			'header'        => esc_html__( 'Headers', 'core-extension' ),
			'portfolio'     => esc_html__( 'Portfolio', 'core-extension'),
			'map'           => esc_html__( 'Maps', 'core-extension' ),
			'misc'          => esc_html__( 'Misc', 'core-extension' ),
			'pricing'       => esc_html__( 'Pricing', 'core-extension' ),
			'service'       => esc_html__( 'Services', 'core-extension' ),
			'team'          => esc_html__( 'Team', 'core-extension' ),
			'testimonial'   => esc_html__( 'Testimonials', 'core-extension' ),
			'text'          => esc_html__( 'Text', 'core-extension' )
		);

		$output .= '<div class="sortable_templates">';
		$output .= '<ul>';
		$i = 0;
		foreach( $categories as $key => $value ) {
			$i++;
			$active = ( $i == 1 ) ? 'class="active"' : '';
			$output .= '<li ' . $active . ' data-filter="' . $key . '">' . $value . ' <span class="count">0</span></li>';
		}
		$output .= '</ul>';
		$output .= '</div>';

		return $output;

	}

	public function renderTemplateBlock( $category ) {

		if ( 'scape_templates' === $category['category'] ) {

			$category['output'] = '<div class="vc_col-md-2 wtbx-sorting-container">';
			$category['output'] .= $this->get_template_categories();
			$category['output'] .= '</div>';


			$category['output'] .= '
			<div class="vc_column vc_col-md-12 wtbx-templates-container">
				<div class="vc_ui-template-list vc_templates-list-default_templates vc_ui-list-bar" data-vc-action="collapseAll">';
			if ( ! empty( $category['templates'] ) ) {
				foreach ( $category['templates'] as $template ) {
					$category['output'] .= $this->renderTemplateListItem( $template );
				}
			}
			$category['output'] .= '
			</div>
		</div>';

		}

		return $category;
	}

	/** Output rendered template in new panel dialog
	 * @since 4.4
	 *
	 * @param $template_name
	 * @param $template_data
	 *
	 * @return string
	 */
	function renderTemplateWindow( $template_name, $template_data ) {

		if ( 'scape_templates' === $template_data['type'] ) {
			return $this->renderTemplateWindowScapeTemplates( $template_name, $template_data );
		}

		return $template_name;
	}

	/**
	 * @since 4.4
	 *
	 * @param $template_name
	 * @param $template_data
	 *
	 * @return string
	 */
	public function renderTemplateWindowScapeTemplates( $template_name, $template_data ) {
		ob_start();
		$template_id = esc_attr( $template_data['unique_id'] );
		$template_id_hash = md5( $template_id ); // needed for jquery target for TTA
		$template_name = esc_html( $template_name );
		$preview_template_title = esc_attr( 'Preview template', 'core-extension' );
		$add_template_title = esc_attr( 'Add template', 'core-extension' );

		echo <<<HTML
		<button type="button" class="vc_ui-list-bar-item-trigger" title="$add_template_title"
			data-template-handler=""
			data-vc-ui-element="template-title">$template_name</button>
		<div class="vc_ui-list-bar-item-actions">
			<button type="button" class="vc_general vc_ui-control-button" title="$add_template_title"
					data-template-handler="">
				<i class="vc-composer-icon vc-c-icon-add"></i>
			</button>
		</div>
HTML;

		return ob_get_clean();
	}

	/**
	 * @since 4.7
	 */
	public function renderUITemplate() {
		vc_include_template( 'editors/popups/vc_ui-panel-templates.tpl.php', array(
			'box' => $this,
		) );

		return '';
	}

	/**
	 * Loading Any templates Shortcodes for backend by string $template_id from AJAX
	 * @since 4.4
	 * vc_filter: vc_templates_render_backend_template - called when unknown template requested to render in backend
	 */
	public function renderBackendTemplate() {
		vc_user_access()->checkAdminNonce()->validateDie()->wpAny( 'edit_posts', 'edit_pages' )->validateDie()->part( 'templates' )->can()->validateDie();

		$template_id = vc_post_param( 'template_unique_id' );
		$template_type = vc_post_param( 'template_type' );

		if ( ! isset( $template_id, $template_type ) || '' === $template_id || '' === $template_type ) {
			die( 'Error: Vc_Templates_Panel_Editor::renderBackendTemplate:1' );
		}
		WPBMap::addAllMappedShortcodes();
		if ( 'my_templates' === $template_type ) {
			$saved_templates = get_option( $this->option_name );

			$content = trim( $saved_templates[ $template_id ]['template'] );
			$content = str_replace( '\"', '"', $content );
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback( "/{$pattern}/s", 'vc_convert_shortcode', $content );
			// @codingStandardsIgnoreLine
			print $content;
			die();
		} else if ( strpos(strval($template_id), 'scape_') !== false ) {
			$this->getAllTemplates();
			$template_index = str_replace('scape_', '', $template_id);
			$data = $this->scape_templates[ $template_index ];

			if ( ! $data ) {
				die( 'Error: Vc_Templates_Panel_Editor::getBackendDefaultTemplate:1' );
			}

			$content = str_replace( '""', '"', trim( $data['content'] ) );
			print $content;
			die;
		} else {
			if ( 'default_templates' === $template_type ) {
				$this->getBackendDefaultTemplate();
				die();
			} else {
				// @codingStandardsIgnoreLine
				print apply_filters( 'vc_templates_render_backend_template', $template_id, $template_type );
				die();
			}
		}
	}

	/**
	 *
	 * @throws \Exception
	 */
	public function loadShortcodes() {
		if ( class_exists('Vc_Frontend_Editor') ) {
			$frontendEditor = new Vc_Frontend_Editor;
			if ( vc_is_page_editable() && vc_enabled_frontend() ) {
				$action = vc_post_param( 'action' );
				if ( 'vc_load_shortcode' === $action ) {
					$output = '';
					! defined( 'CONCATENATE_SCRIPTS' ) && define( 'CONCATENATE_SCRIPTS', false );
					ob_start();
					$frontendEditor->setPost();
					$shortcodes = (array) vc_post_param( 'shortcodes' );
					do_action( 'vc_load_shortcode', $shortcodes );
					$output .= ob_get_clean();
//					$output .= $frontendEditor->renderShortcodes( $shortcodes );
					$output .= '<div data-type="files">';
					ob_start();
					_print_styles();
					print_head_scripts();
					wp_footer();
					$output .= ob_get_clean();
					$output .= '</div>';
					// @codingStandardsIgnoreLine
					print apply_filters( 'vc_frontend_editor_load_shortcode_ajax_output', $output );
				} elseif ( 'vc_frontend_load_template' === $action ) {
					$frontendEditor->setPost();
					$this->renderFrontendTemplate();
				} elseif ( '' !== $action ) {
					do_action( 'vc_front_load_page_' . esc_attr( vc_post_param( 'action' ) ) );
				}
			}
		}
	}


	/**
	 * @since 4.4
	 * vc_filter: vc_templates_render_frontend_template - called when unknown template received to render in frontend.
	 */
	public function renderFrontendTemplate() {
		vc_user_access()->checkAdminNonce()->validateDie()->wpAny( 'edit_posts', 'edit_pages' )->validateDie()->part( 'templates' )->can()->validateDie();

		add_filter( 'vc_frontend_template_the_content', array(
			$this,
			'frontendDoTemplatesShortcodes',
		) );
		$template_id = vc_post_param( 'template_unique_id' );
		$template_type = vc_post_param( 'template_type' );
		add_action( 'wp_print_scripts', array(
			$this,
			'addFrontendTemplatesShortcodesCustomCss',
		) );

		if ( '' === $template_id ) {
			die( 'Error: Vc_Templates_Panel_Editor::renderFrontendTemplate:1' );
		}
		WPBMap::addAllMappedShortcodes();
		if ( 'my_templates' === $template_type ) {
			$saved_templates = get_option( $this->option_name );
			vc_frontend_editor()->setTemplateContent( $saved_templates[ $template_id ]['template'] );
			vc_frontend_editor()->enqueueRequired();
			vc_include_template( 'editors/frontend_template.tpl.php', array(
				'editor' => vc_frontend_editor(),
			) );
			die();
		} else if ( strpos(strval($template_id), 'scape_') !== false ) {
			$this->getAllTemplates();
			$template_index = str_replace('scape_', '', $template_id);
			$data = $this->scape_templates[ $template_index ];
			$content = str_replace( '""', '"', trim( $data['content'] ) );

			if ( ! $data ) {
				die( 'Error: Vc_Templates_Panel_Editor::renderFrontendDefaultTemplate:1' );
			}
			vc_frontend_editor()->setTemplateContent( $content );
			vc_frontend_editor()->enqueueRequired();
			vc_include_template( 'editors/frontend_template.tpl.php', array(
				'editor' => vc_frontend_editor(),
			) );
			die();
		} else {
			if ( 'default_templates' === $template_type ) {
				$this->renderFrontendDefaultTemplate();
			} else {
				// @codingStandardsIgnoreLine
				print apply_filters( 'vc_templates_render_frontend_template', $template_id, $template_type );
			}
		}
		die; // no needs to do anything more. optimization.
	}

	/**
	 * Load frontend default template content by index
	 * @since 4.4
	 */
	public function renderFrontendDefaultTemplate() {
		$template_index = (int) vc_post_param( 'template_unique_id' );
		$data = $this->getDefaultTemplate( $template_index );
		if ( ! $data ) {
			die( 'Error: Vc_Templates_Panel_Editor::renderFrontendDefaultTemplate:1' );
		}
		vc_frontend_editor()->setTemplateContent( trim( $data['content'] ) );
		vc_frontend_editor()->enqueueRequired();
		vc_include_template( 'editors/frontend_template.tpl.php', array(
			'editor' => vc_frontend_editor(),
		) );
		die();
	}

	/**
	 * @since 4.4
	 *
	 * @param $templates
	 *
	 * vc_filter: vc_load_scape_templates_limit_total - total items to show
	 *
	 * @return array
	 */
	public function loadDefaultTemplatesLimit( $templates ) {
		$start_index = 0;
		$total_templates_to_show = apply_filters( 'vc_load_default_templates_limit_total', 6 );

		return array_slice( $templates, $start_index, $total_templates_to_show );
	}

	/**
	 * Get user templates
	 *
	 * @since 4.12
	 * @return mixed
	 */
	public function getUserTemplates() {
		return apply_filters( 'vc_get_user_templates', get_option( $this->option_name ) );
	}

	/**
	 * Function to get all templates for display
	 *  - with image (optional preview image)
	 *  - with unique_id (required for do something for rendering.. )
	 *  - with name (required for display? )
	 *  - with type (required for requesting data in server)
	 *  - with category key (optional/required for filtering), if no category provided it will be displayed only in
	 * "All" category type vc_filter: vc_get_user_templates - hook to override "user My Templates" vc_filter:
	 * vc_get_all_templates - hook for override return array(all templates), hook to add/modify/remove more templates,
	 *  - this depends only to displaying in panel window (more layouts)
	 * @since 4.4
	 * @return array - all templates with name/unique_id/category_key(optional)/image
	 */
	public function getAllTemplates() {

		$data = array();
		$scape_templates = $this->getTemplates();
		$this->scape_templates = $scape_templates;
		$category_templates = array();
		foreach ( $scape_templates as $template_id => $template_data ) {
			$category_templates[] = array(
				'unique_id' => $template_id,
				'name' => $template_data['name'],
				'new' => isset( $template_data['new'] ) ? $template_data['new'] : false,
				'type' => 'scape_templates',
				'image' => isset( $template_data['image_path'] ) ? $template_data['image_path'] : false,
				'custom_class' => isset( $template_data['custom_class'] ) ? $template_data['custom_class'] : false,
				'sort_name' => isset( $template_data['sort_name'] ) ? $template_data['sort_name'] : false,
			);
			if ( ! empty( $category_templates ) ) {
				$data = $category_templates;
			}
		}

		return $data;
	}

	/**
	 * Load default templates list and initialize variable
	 * To modify you should use add_filter('vc_load_scape_templates','your_custom_function');
	 * Argument is array of templates data like:
	 *      array(
	 *          array(
	 *              'name'=>__('My custom template','my_plugin'),
	 *              'image_path'=> preg_replace( '/\s/', '%20', plugins_url( 'images/my_image.png', __FILE__ ) ), //
	 * always use preg replace to be sure that "space" will not break logic
	 *              'custom_class'=>'my_custom_class', // if needed
	 *              'content'=>'[my_shortcode]yeah[/my_shortcode]', // Use HEREDoc better to escape all single-quotes
	 * and double quotes
	 *          ),
	 *          ...
	 *      );
	 * Also see filters 'vc_load_scape_templates_panels' and 'vc_load_scape_templates_welcome_block' to modify
	 * templates in panels tab and/or in welcome block. vc_filter: vc_load_scape_templates - filter to override
	 * default templates array
	 * @since 4.4
	 * @return array
	 */
	public function loadDefaultTemplates() {
		if ( ! $this->initialized ) {
			$this->init(); // add hooks if not added already (fix for in frontend)
		}

		if ( ! is_array( $this->default_templates ) ) {
			require_once vc_path_dir( 'CONFIG_DIR', 'templates.php' );
			$templates = apply_filters( 'vc_load_default_templates', $this->default_templates );
			$this->default_templates = $templates;
			do_action( 'vc_load_default_templates_action' );
		}

		return $this->default_templates;
	}

	/**
	 * Alias for loadDefaultTemplates
	 * @since 4.4
	 * @return array - list of default templates
	 */
	public function getDefaultTemplates() {
		return $this->loadDefaultTemplates();
	}

	/**
	 * Get default template data by template index in array.
	 * @since 4.4
	 *
	 * @param number $template_index
	 *
	 * @return array|bool
	 */
	public function getDefaultTemplate( $template_index ) {
		$this->loadDefaultTemplates();
		if ( ! is_numeric( $template_index ) || ! is_array( $this->default_templates ) || ! isset( $this->default_templates[ $template_index ] ) ) {
			return false;
		}

		return $this->default_templates[ $template_index ];
	}

	/**
	 * Add custom template to default templates list ( at end of list )
	 * $data = array( 'name'=>'', 'image'=>'', 'content'=>'' )
	 * @since 4.4
	 *
	 * @param $data
	 *
	 * @return bool true if added, false if failed
	 */
	public function addDefaultTemplates( $data ) {
		if ( is_array( $data ) && ! empty( $data ) && isset( $data['name'], $data['content'] ) ) {
			if ( ! is_array( $this->scape_templates ) ) {
				$this->scape_templates = array();
			}
			$this->scape_templates[] = $data;

			return true;
		}

		return false;
	}

	/**
	 * Load default template content by index from ajax
	 * @since 4.4
	 *
	 * @param bool $return | should function return data or not
	 *
	 * @return string
	 */
	public function getBackendDefaultTemplate( $return = false ) {
		$template_index = (int) vc_request_param( 'template_unique_id' );
		$data = $this->getDefaultTemplate( $template_index );

		if ( ! $data ) {
			die( 'Error: Vc_Templates_Panel_Editor::getBackendDefaultTemplate:1' );
		}
		if ( $return ) {
			return trim( $data['content'] );
		} else {
			// @codingStandardsIgnoreLine
			print esc_html( trim( $data['content'] ) );
			die;
		}
	}

	/**
	 * @since 4.4
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function sortTemplatesByCategories( array $data ) {
		$buffer = $data;
		uasort( $buffer, array(
			&$this,
			'cmpCategory',
		) );

		return $buffer;
	}

	/**
	 * @since 4.4
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function sortTemplatesByNameWeight( array $data ) {
		$buffer = $data;
		uasort( $buffer, array(
			&$this,
			'cmpNameWeight',
		) );

		return $buffer;
	}

	/**
	 * Function should return array of templates categories
	 * @since 4.4
	 *
	 * @param array $categories
	 *
	 * @return array - associative array of category key => and visible Name
	 */
	public function getAllCategoriesNames( array $categories ) {
		$categories_names = array();

		foreach ( $categories as $category ) {
			if ( isset( $category['category'] ) ) {
				$categories_names[ $category['category'] ] = isset( $category['category_name'] ) ? $category['category_name'] : $category['category'];
			}
		}

		return $categories_names;
	}

	/**
	 * @since 4.4
	 * @return array
	 */
	public function getAllTemplatesSorted() {
		$data = $this->getAllTemplates();
		// firstly we need to sort by categories
		$data = $this->sortTemplatesByCategories( $data );
		// secondly we need to sort templates by their weight or name
		foreach ( $data as $key => $category ) {
			$data[ $key ]['templates'] = $this->sortTemplatesByNameWeight( $category['templates'] );
		}

		return $data;
	}

	/**
	 * Used to compare two templates by category, category_weight
	 * If category weight is less template will appear in first positions
	 * @since 4.4
	 *
	 * @param array $a - template one
	 * @param array $b - second template to compare
	 *
	 * @return int
	 */
	protected function cmpCategory( $a, $b ) {
		$a_k = isset( $a['category'] ) ? $a['category'] : '*';
		$b_k = isset( $b['category'] ) ? $b['category'] : '*';
		$a_category_weight = isset( $a['category_weight'] ) ? $a['category_weight'] : 0;
		$b_category_weight = isset( $b['category_weight'] ) ? $b['category_weight'] : 0;

		return $a_category_weight == $b_category_weight ? strcmp( $a_k, $b_k ) : $a_category_weight - $b_category_weight;
	}

	/**
	 * @since 4.4
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	protected function cmpNameWeight( $a, $b ) {
		$a_k = isset( $a['name'] ) ? $a['name'] : '*';
		$b_k = isset( $b['name'] ) ? $b['name'] : '*';
		$a_weight = isset( $a['weight'] ) ? $a['weight'] : 0;
		$b_weight = isset( $b['weight'] ) ? $b['weight'] : 0;

		return $a_weight == $b_weight ? strcmp( $a_k, $b_k ) : $a_weight - $b_weight;
	}

	/**
	 * Calls do_shortcode for templates.
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function frontendDoTemplatesShortcodes( $content ) {
		return do_shortcode( $content );
	}

	/**
	 * Add custom css from shortcodes from template for template editor.
	 *
	 * Used by action 'wp_print_scripts'.
	 *
	 * @todo move to autoload or else some where.
	 * @since 4.4.3
	 *
	 */
	public function addFrontendTemplatesShortcodesCustomCss() {
		$output = $shortcodes_custom_css = '';
		$shortcodes_custom_css = visual_composer()->parseShortcodesCustomCss( vc_frontend_editor()->getTemplateContent() );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
			$output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$output .= $shortcodes_custom_css;
			$output .= '</style>';
		}
		echo $output;
	}

	public function addScriptsToTemplatePreview() {
		// wp_enqueue_script( 'vc-template-preview-script', vc_asset_url( 'js/editors/vc_ui-panel-templates-preview-be.js' ), array( 'vc-backend-min-js' ), WPB_VC_VERSION, true );
	}

	public function renderTemplateListItem( $template ) {

		$output = '';
		if ( SCAPE_Core_Extend::is_theme_activated() ) {

		$name = isset($template['name']) ? esc_html($template['name']) : esc_html(__('No title', 'core-extension'));
		$new = esc_attr(isset($template['new']) ? $template['new'] : '');
		$template_id = esc_attr($template['unique_id']);
		$template_id_hash = md5($template_id); // needed for jquery target for TTA
		$template_name = esc_html($name);
		$template_name_lower = esc_attr(vc_slugify($template_name));
		$template_type = esc_attr(isset($template['type']) ? $template['type'] : 'custom');
		$custom_class = esc_attr(isset($template['custom_class']) ? $template['custom_class'] : '');
		$template_image = esc_attr(isset($template['image']) ? $template['image'] : '');
		$template_sort_name = esc_attr(isset($template['sort_name']) ? $template['sort_name'] : '');

		$output = <<<HTML
					<div class="vc_ui-template vc_templates-template-type-default_templates $custom_class"
						data-template_id="scape_$template_id"
						data-template_id_hash="$template_id_hash"
						data-category="$template_type"
						data-template_unique_id="scape_$template_id"
						data-template_name="$template_name_lower"
						data-template_type="default_templates"
						data-vc-content=".vc_ui-template-content">
						<div class="vc_ui-list-bar-item">
HTML;
		$output .= '<div class="scape-template-preview">';
		if ($new) {
			$output .= '<span class="scape-badge-new">New</span>';
		}
		$output .= '<img data-src="' . esc_url($template_image) . '" alt="' . esc_attr($name) . '" width="300" height="200" /></div>';
		$output .= apply_filters('vc_templates_render_template', $name, $template);
		$output .= '<span class="scape-template-categories">' . esc_html($template_sort_name) . '</span>';
		$output .= <<<HTML
						</div>
						<div class="vc_ui-template-content" data-js-content>
						</div>
					</div>
HTML;
		}

		return $output;
	}

	public function getOptionName() {
		return $this->option_name;
	}
}

$template_panel = new WTBX_Vc_Templates_Panel_Editor();
if ( SCAPE_Core_Extend::is_theme_activated() ) {
	$template_panel->init();
}