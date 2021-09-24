<?php
/*
Plugin Name: Scape Core
Plugin URI: http://themeforest.net/user/whitebox-studio
Description: Extension for Theme and WPBakery Page Builder features.
Version: 1.5.2
Author: Whitebox-Studio
Author URI: http://whiteboxstud.io/
License: Envato Marketplaces Split Licence
License URI: Envato Marketplace Item License Certificate
*/



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) die;


class SCAPE_Core_Extend {

	function __construct() {
		$this->_constants();

		require_once ( 'include/portfolio_post_type.php' );
		require_once ( 'include/section_post_type.php' );
		require_once ( 'include/vc_config/custom_functions.php' );
		require_once ( 'include/post-like.php');
		require_once ( 'include/user-fields.php');
		require_once ( 'include/consent-shortcode.php');
		require_once ( 'include/mobile-detect.php');
		require_once ( 'include/share.php');

		require_once ( 'include/widgets/widget-login.php');
		require_once ( 'include/widgets/widget-recent-posts.php');
		require_once ( 'include/widgets/widget-recent-comments.php');
		require_once ( 'include/widgets/widget-author.php');
		require_once ( 'include/widgets/widget-social.php');
		require_once ( 'include/widgets/widget-newsletter.php');
		require_once ( 'include/widgets/widget-random-post.php');

		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'admin_print_footer_scripts', 'wtbx_print_admin_fonts' );
		add_action( 'admin_enqueue_scripts', 'wtbx_gutenberg_fonts' );

		add_action( 'wp_head', array($this, 'wtbx_code_head') );
		add_action( 'wtbx_body_start', array($this, 'wtbx_code_body_start') );
		add_action( 'wp_footer', array($this, 'wtbx_code_body_end') );

		add_filter( 'wbc_importer_directory_title', array($this, 'wtbx_demo_name') );

		add_filter( 'login_message', array($this, 'wtbx_login_page_before'), 10, 1 );
		add_action( 'login_footer', array($this, 'wtbx_login_page_after') );


		if ( is_admin() ) {
			require_once ( 'include/metaboxes/init-metaboxes.php');

			if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) ) {
				require_once( 'include/options-ext/redux-ext-loader.php' );
			}
		}

	}


	protected function _constants() {
		define( 'WTBX_PLUGIN_MAIN', __FILE__);
		define( 'WTBX_PLUGIN_PATH', plugin_dir_path(__FILE__) );
		define( 'WTBX_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
		define( 'WTBX_PLUGIN_VERSION', $plugin_data['Version'] );
	}


	public function wtbx_demo_name($name) {
		return ucwords(str_replace('-', ' ', $name));
	}


	public function wtbx_set_pages() {
		$front_page = get_page_by_title( 'Home' );
		$posts_page = get_page_by_title( 'Blog' );

		if ( $front_page->ID ) {
			update_option('show_on_front', 'page');
			update_option('page_on_front', $front_page->ID); // Set front page
		}

		if($posts_page->ID) {
			update_option('page_for_posts', $posts_page->ID); // Set blog Page
		}
	}


	public function init() {
		load_plugin_textdomain( 'core-extension', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		if ( ! function_exists( 'vc_map' ) ) {
			add_action('admin_notices', array( $this, 'vc_error' ) );
		} else {
			$this->vc_edit();
			$this->vc_enable_for_post_types();
			add_action('wp_enqueue_scripts', array( $this, 'vc_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_filter( 'vc_nav_front_logo', array( $this, 'vc_front_logo' ) );
		}

		// Custom login page style
		add_action( 'login_enqueue_scripts', 'wtbx_login_stylesheet' );
	}


	public static function is_theme_activated() {
		$code = '';
		if ( get_option('scape_theme_id') ) {
			$item_id = get_option('scape_theme_id');
			$code = get_option('envato_purchase_code_' . $item_id);
		}
		return !empty($code);
	}


	public function vc_front_logo() {
		$output = '<a class="vc_navbar-brand" title="' . __( 'Scape', 'core-extension' )
			. '" href="'.admin_url().'">'
			. __( 'Scape theme', 'core-extension' ) . '</a>';
		return $output;
	}


	public function widgets_init() {
		// Register widgets
		register_widget( 'wtbx_login_widget' );
		register_widget( 'wtbx_recent_posts_widget' );
		register_widget( 'wtbx_recent_comments_widget' );
		register_widget( 'wtbx_author_widget' );
		register_widget( 'wtbx_social_widget' );
		register_widget( 'wtbx_newsletter_widget' );
		register_widget( 'wtbx_random_post_widget' );
	}

	// Display notice if Visual Composer is not installed or activated
	public function vc_error() {
		echo '
		<div class="updated">
			<p>'. __( '<strong>Scape Core</strong> plugin requires WPBakery Page Builder plugin to be installed and activated on your site.', 'core-extension' ) .'</p>
		</div>';
	}


	public function admin_scripts() {
		wp_enqueue_script( 'wtbx-spectrum', WTBX_PLUGIN_URL . 'assets/js/spectrum.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wtbx-templates', WTBX_PLUGIN_URL . 'assets/js/templates.js', array( 'jquery' ), '', true );
	}


	// Enqueue scripts
	public function vc_scripts() {
		if ( wtbx_vc_is_page_editable() ) {
			$this->enqueue_all_fonts();
			wp_enqueue_style( 'wtbx-frontend-css', WTBX_PLUGIN_URL . 'assets/css/core-extension-frontend.css', false, '', 'all' );
			wp_enqueue_script( 'wtbx-frontend-js', WTBX_PLUGIN_URL . 'assets/js/extend-frontend.js', array( 'jquery', 'scape-main-js' ), '', true );
		}
	}


	public function enqueue_all_fonts() {
		$object = wtbx_vc_get_font_weight_style();
		$has_typekit = false;

		if ( !empty($object) ) {
			foreach ( (array) $object as $font_id => $font_details ) {
				if ( $font_details['type'] && isset($font_details['family']) && isset($font_details['name']) ) {
					$font_type = $font_details['type'];
					$upload_dir = wp_upload_dir();

					if ( $font_type === 'custom' ) {
						$font_link = $upload_dir['baseurl'] . '/wtbx_custom_fonts/' . $font_details['name'] . '/stylesheet.css';
					} elseif ( $font_type === 'fontsquirrel' ) {
						$font_link = $upload_dir['baseurl'] . '/wtbx_custom_fonts/' . $font_details['name'] . '/' . $font_details['family'] . '.css';
					} elseif ( $font_type === 'google' ) {
						$font_link ='//fonts.googleapis.com/css?family=' . str_replace(' ', '+', $font_details['name']) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
					} elseif ( $font_type === 'typekit' ) {
						$has_typekit = 'typekit';
					}

					if ( $font_type !== 'typekit' && !empty($font_link) ) {
						wp_enqueue_style( $font_details['name'], $font_link, false, '', 'all' );
					}
				}
			}
		}

		if ( $has_typekit ) {
			if ( isset(wtbx_vc_get_theme_fonts()['typekit_kitid']) ) {
				$typekit_kitid = wtbx_vc_get_theme_fonts()['typekit_kitid'];
				echo '<script src="https://use.typekit.net/'.$typekit_kitid.'.js"></script><script>try{Typekit.load({ async: true });}catch(e){}</script>';
			}
		}
	}


	public function vc_enable_for_post_types() {
		$post_types = array(
			'page',
			'post',
			'portfolio',
			'content_block',
		    'product'
		);
		vc_set_default_editor_post_types( $post_types );
	}


	public function wtbx_vc_has_consent($type) {
		if ( class_exists('GDPR') && $type !== '' && !has_consent($type) ) {
			return false;
		} else {
			return true;
		}
	}


	public function wtbx_code_head() {
		$code = wtbx_vc_option('gdpr-tracking-consent', array());
		if (empty($code)) { $code = array(); }
		if ( !array_key_exists('code_in_head', $code) || empty($code['code_in_head']) || wtbx_vc_has_consent('tracking') ) {
			echo wtbx_vc_option('custom-code-head');
		}
	}


	public function wtbx_code_body_start() {
		$code = wtbx_vc_option('gdpr-tracking-consent', array());
		if (empty($code)) { $code = array(); }
		if ( !array_key_exists('code_body_open', $code) || empty($code['code_in_head']) || wtbx_vc_has_consent('tracking') ) {
			echo wtbx_vc_option('custom-code-body-start');
		}
	}


	public function wtbx_code_body_end() {
		$code = wtbx_vc_option('gdpr-tracking-consent', array());
		if (empty($code)) { $code = array(); }
		if ( !array_key_exists('code_body_close', $code) || empty($code['code_in_head']) || wtbx_vc_has_consent('tracking') ) {
			echo wtbx_vc_option('custom-code-body-end');
		}
	}


	public function wtbx_login_page_before($message) {
		$content = wtbx_vc_option('login-html-before');
		return $message . wp_kses_post($content);
	}


	public function wtbx_login_page_after() {
		$content = wtbx_vc_option('login-html-after');
		echo wp_kses_post($content);
	}


	public function vc_edit() {

		// Set shortcode template dir
		$dir = WTBX_PLUGIN_PATH . '/include/templates/';
		vc_set_shortcodes_templates_dir($dir);

		require_once ( 'include/vc_config/custom_parameters.php' );

		// Remove VC elements
		vc_remove_element('vc_text_separator');
		vc_remove_element('vc_gallery');
		vc_remove_element('vc_posts_slider');
		vc_remove_element('vc_images_carousel');
		vc_remove_element('vc_posts_grid');
		vc_remove_element('vc_cta_button');
		vc_remove_element('vc_cta_button2');
		vc_remove_element('vc_message');
		vc_remove_element('vc_gmaps');

		// Add shortcodes
		require_once ('include/classes/button.php');
		require_once ('include/classes/heading.php');
		require_once ('include/classes/list.php');
		require_once ('include/classes/expandable_list.php');
		require_once ('include/classes/tabs.php');
		require_once ('include/classes/tour.php');
		require_once ('include/classes/accordion.php');
		require_once ('include/classes/service.php');
		require_once ('include/classes/content_box.php');
		require_once ('include/classes/testimonial.php');
		require_once ('include/classes/testimonial_slider.php');
		require_once ('include/classes/rating.php');
		require_once ('include/classes/pricing_box.php');
		require_once ('include/classes/content_slider.php');
		require_once ('include/classes/team.php');
		require_once ('include/classes/image_element.php');
		require_once ('include/classes/image_caption.php');
		require_once ('include/classes/image_cascade.php');
		require_once ('include/classes/counter.php');
		require_once ('include/classes/modal.php');
		require_once ('include/classes/section_divider.php');
		require_once ('include/classes/image_carousel.php');
		require_once ('include/classes/scape_post_grid.php');
		require_once ('include/classes/scape_portfolio_grid.php');
		require_once ('include/classes/scape_item_grid.php');
		require_once ('include/classes/scape_image_grid.php');
		require_once ('include/classes/video_button.php');
		require_once ('include/classes/countdown.php');
		require_once ('include/classes/scape_social_icons.php');
		require_once ('include/classes/scape_google_map.php');
		require_once ('include/classes/steps.php');
		require_once ('include/classes/split_text.php');
		require_once ('include/classes/text_element.php');
		require_once ('include/classes/animated_text.php');
		require_once ('include/classes/message_box.php');
		require_once ('include/classes/image_before_after.php');
		require_once ('include/classes/banner.php');
		require_once ('include/classes/scape_video_player.php');
		require_once ('include/classes/content_block.php');
		require_once ('include/classes/custom_pie.php');
		require_once ('include/classes/image_box.php');

		// Edit VC map
		require_once ('config/map.php');

		// Templates
		include ('include/vc_templates_panel.php');
		include ('include/vc_templates.php');
	}

}
$scape_core_extend = new SCAPE_Core_Extend();