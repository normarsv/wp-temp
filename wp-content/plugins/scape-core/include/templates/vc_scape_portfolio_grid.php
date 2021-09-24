<?php
$output = $el_class = $meta_primary = $meta_secondary = $meta_skin = $meta_alignment = $overlay_mobile = $color_skin = $overlay_color_hover =
$hide_meta = $layout_cols = $overlay_content = $like = $meta_primary = $meta_secondary = $meta_primary_hover = $meta_secondary_hover =
$caption_primary = $caption_secondary = $overlay_color_separate = $meta_color = $min_width = $min_width_metro = $style = $disable_sequential = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style('scape-portfolio-common');
wtbx_vc_script_queue('isotope');
if ( $style === 'metro' ) { wtbx_vc_script_queue('packery'); }
if ( $style === 'panels' || $style === 'slider' ) { wtbx_vc_script_queue('scape-portfolio-slider'); }

// shortcode class
$element_class      = 'wtbx_vc_portfolio_grid';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$meta_alignment !== '' ? $shortcode_class[] = 'wtbx_meta_' . $meta_alignment : null;
$color_skin !== '' ? $shortcode_class[] = 'wtbx_meta_skin_' . $color_skin : null;
$overlay_mobile === 'yes' ? $shortcode_class[] = 'force_mobile_hover' : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// unique grid ID
$gridID = hexdec(substr(uniqid(), 6, 7));

if ( $limit === 'yes' ) $custom_categories = explode(',', $categories);
$category_term = 'portfolio_category';
$defaults =  explode(',', $defaults);
$gutter = intval($gutter);
$border = intval($border);
$portfolio_overlay = wtbx_vc_color_styles_bg($overlay_color);
$portfolio_overlay_hover = wtbx_vc_color_styles_bg($overlay_color_hover);
$portfolio_overlay_separate = wtbx_vc_color_styles_bg($overlay_color_separate);
$color_meta = wtbx_vc_color_styles_text($meta_color);
$post_type = 'portfolio';

// columns
if ( $style === 'metro' ) {
	$grid_layout = $metro_layout;
	if ( strpos($grid_layout, 'layout') !== false ) {
		$custom_layout = true;
		$layout_obj = wtbx_vc_grid_layouts($grid_layout);
		$counter = 0;
		$layout_cols = ' data-layout-cols="'.esc_attr($layout_obj['columns']).'"';
		$tiles = $layout_obj['tiles'];
	} else {
		$columns = $columns_portfolio_metro;
		$min_width = $min_width_metro;
	}
} else {
	$layout_cols = $grid_layout = '';
}

// content
if ( in_array($style, array('masonry', 'metro', 'boxed', 'panels')) ) {
	$meta_primary           = $portfolio_content_primary;
	$meta_secondary         = $portfolio_content_secondary;
	$meta_primary_hover     = $portfolio_content_primary_hover;
	$meta_secondary_hover   = $portfolio_content_secondary_hover;
} else {
	$overlay_content = $overlay_content_separate;
	$meta_primary = $portfolio_content_primary_separate;
	$meta_secondary = $portfolio_content_secondary_separate;
}

// items per page
$perpage = $perpage !== '' ? $perpage : wp_count_posts('portfolio')->publish;



// categories
$categories_array = [];
if (!empty($custom_categories)) {
	$categories_array = $custom_categories;
	$tax_query = array(
		array(
			'taxonomy' => $category_term,
			'field' => 'term_id',
			'terms' => $custom_categories,
		),
	);
} else {
	$categories = get_terms($category_term);
	if (!empty($categories) && !is_wp_error($categories)) {
		foreach ($categories as $term) {
			$categories_array[] = $term->term_id;
		}
	}
	$tax_query = '';
}

// filter
$filter_categories = $filter === '' ? false : $categories_array;
$filter_bg = $filter_bg_color;

$filter_display = ' filter-layout-' . $filter_align;
if ( $filter_align !== 'center' ) {
	$filter_display .= $filter_layout;
}

// click action
if ( $style === 'square' || $style === 'tiles' ) {
	$click_action = $click_action_separate;
}

// overlay animation
$overlay_trigger = !empty($overlay_trigger) ? ' overlay-' . str_replace('overlay_', '', $overlay_trigger) : '';

// loading limit
$post_limit = $post_limit !== '' ? ' data-limit="'.intval($post_limit).'"' : '';

// pagination skin
$pagination_skin = $nav_skin;

// define image size
$src_size       = 'large';
$srcset_size    = 'full';

// layout
if ( $style === 'metro' ) {
	$grid_layout = $metro_layout;
	if ( strpos($grid_layout, 'layout') !== false ) {
		$custom_layout = true;
		$layout_obj = wtbx_vc_grid_layouts($grid_layout);
		$counter = 0;
		$layout_cols = ' data-layout-cols="'.$layout_obj['columns'].'"';
		$tiles = $layout_obj['tiles'];
	} else {
//		$grid_layout = 'default';
//		$columns = str_replace('columns_', '', $metro_layout);
	}
} else {
	$grid_layout = 'default';
	$layout_cols = $tiles = '';
}

// object
$blog_type = $style;

$grid_style = $style;

if ( $style === 'metro' ) {
	$object = 'metro';
} elseif ( $style === 'overlap' ) {
	$object = 'overlap';
} else {
	$object = 'masonry';
}

// overlay buttons
$action_button_link = $action_button_gallery_all = $action_button_gallery_item = false;
$action_buttons_array = $action_buttons !== '' ? explode(',', $action_buttons) : '';
if ($action_buttons_array) {
	if ( in_array('link', $action_buttons_array) ) {
		$action_button_link = true;
	}

	if ( in_array('preview', $action_buttons_array) ) {
		if ( $action_button_preview === 'gallery_all' ) {
			$action_button_gallery_all = true;
		} elseif ( $action_button_preview === 'gallery_item' ) {
			$action_button_gallery_item = true;
		}
	}
}

// lightbox
if ( in_array($action_button_preview, array('gallery_all', 'gallery_item')) || in_array($click_action, array('gallery_all', 'gallery_item')) ) {
	$lightbox_atts  = wtbx_lightbox_attributes();
}

// lightbox caption
$share = '';
if ( in_array( $style, array('square', 'tiles') ) ) {
	$caption_primary = $portfolio_content_primary_lightbox_separate;
	$caption_secondary = $portfolio_content_secondary_lightbox_separate;
	$share = $lightbox_share_separate;
} else {
	if ( in_array( $overlay_hover, array('empty', 'color', 'icon', 'meta_centered', 'meta_middle', 'meta_aligned') ) ) {
		$caption_primary = $portfolio_content_primary_lightbox;
		$caption_secondary = $portfolio_content_secondary_lightbox;
		$share = $lightbox_share;
	} elseif ( $overlay_hover === 'buttons' && strpos($action_buttons, 'preview') !== false ) {
		$caption_primary = $portfolio_content_primary_lightbox_preview;
		$caption_secondary = $portfolio_content_secondary_lightbox_preview;
		$share = $lightbox_share_preview;
	}
}

// typography
$primary_typography = wtbx_font_styling($primary_typography);
$secondary_typography = wtbx_font_styling($secondary_typography);

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $grid_bg_color !== '' ? $unique_class_css.' .wtbx_item_grid_wrapper {' . wtbx_vc_color_styles_bg($grid_bg_color) .'}' : '';
$js_styles .= $portfolio_overlay !== '' ? $unique_class_css.' .portfolio-overlay-idle .portfolio-overlay-color, '.$unique_class_css.' .portfolio-overlay-idle .portfolio-overlay-icon, '.$unique_class_css.' .portfolio-overlay-idle .portfolio-overlay-meta_middle, '.$unique_class_css.' .portfolio-overlay-idle .portfolio-overlay-buttons, '.$unique_class_css.' .portfolio-overlay-idle .portfolio-entry-bg {' . $portfolio_overlay .'}' : '';
$js_styles .= $portfolio_overlay_hover !== '' ? $unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-color, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-icon, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-meta_middle, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-meta_middle_inside, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-meta_boxed, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-meta_border, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-overlay-buttons, '.$unique_class_css.' .portfolio-overlay-hover .portfolio-entry-bg {' . $portfolio_overlay_hover .'}' : '';
$js_styles .= $portfolio_overlay_separate !== '' ? $unique_class_css.' .portfolio-square-box .portfolio-entry-bg, '.$unique_class_css.' .portfolio-tiles-box .portfolio-entry-bg {' . $portfolio_overlay_separate .'}' : '';
$js_styles .= ( $primary_typography !== '' ) ? $unique_class_css.' article.portfolio-entry .portfolio-meta-primary,'.$unique_class_css.' .portfolio-panels-meta .portfolio-meta-primary,'.$unique_class_css.' .portfolio-slider-meta .portfolio-meta-primary {'.$primary_typography.'}' : '';
$js_styles .= ( $secondary_typography !== '' ) ? $unique_class_css.' article.portfolio-entry .portfolio-meta-secondary,'.$unique_class_css.' .portfolio-panels-meta .portfolio-meta-secondary,'.$unique_class_css.' .portfolio-slider-meta .portfolio-meta-secondary {'.$secondary_typography.'}' : '';
$js_styles .= $color_meta !== '' ? $unique_class_css.' .portfolio-entry .portfolio-meta-primary, '.$unique_class_css.' .portfolio-entry .portfolio-meta-secondary {' . $color_meta .'}' : '';
$js_styles .= $border !== '' && $style === 'overlap' ? $unique_class_css.' .portfolio-overlap-media-link {border-radius:' . $border .'px}' : '';

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';


$output .= '<div class="wtbx_item_grid_wrapper portfolio-' . $style . ($filter !== '' ? ' filter-'.$filter : '') . '">';

if ( !in_array($style, array('panels', 'overlap', 'slider')) && $filter !== '' ) {
	if ( !wtbx_is_archive() || is_post_type_archive() ) {
		ob_start();
		include(locate_template('templates/components/filter.php'));
		$output .= ob_get_clean();
	}
}

$output .= '<div class="wtbx-grid-wrapper">';
$output .= '<div class="portfolio-grid wtbx-grid wtbx-grid-'.$style.' wtbx-container-reveal wtbx-lightbox-container row-inner" data-columns="'.esc_attr($columns).'" data-layout="'.esc_attr($grid_layout).'" data-gutter="'.esc_attr($gutter).'" data-border="'.esc_attr($border).'" data-id="'.esc_attr($gridID).'" data-grid="portfolio" data-seq="'.$disable_sequential.'" data-minwidth="'.esc_attr(intval($min_width)).'" '.$lightbox_atts.' data-filter-prefix="portfolio_category"'.$layout_cols.esc_attr($post_limit).'>';

$paged = (get_query_var('paged')) ? get_query_var('paged') : (isset($new_wp_query->query['paged']) ? $new_wp_query->query['paged'] : 1);

$args = array();
if ( $query === 'global' || wtbx_is_archive() ) {
	global $wp_query;
//	$wp_query->query_vars['posts_per_page'] = $perpage;
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$args = $wp_query->query_vars;
	if ( wtbx_vc_is_page_editable() ) {
		$args = array('post_type' => 'portfolio',
		              'posts_per_page' => get_option( 'posts_per_page' ),
		              'paged' => $paged,
		);
	}
} elseif ( $query === 'settings' ) {
	$args = array('post_type' => 'portfolio',
		'posts_per_page' => $perpage,
		'paged' => $paged,
		'tax_query' => $tax_query,
		'suppress_filters' => 0
	);
} elseif ( $query === 'custom' ) {
	if ( !empty($custom_wp_query) ) {
		$args = 'post_type=portfolio&'.htmlspecialchars_decode($custom_wp_query);
	}
}
$new_wp_query = new WP_Query(wp_parse_args($args));
$custom_query = $new_wp_query;

// navigation
$grid_navigation = '';
if ($new_wp_query->max_num_pages > 1) {
	if 	($navigation === '1') {
		// pagination
		if ( $query === 'global' ) {
			ob_start();
			include(locate_template( 'templates/section-pagination.php' ));
			$grid_navigation .= ob_get_clean();
		} else {
			$page_url = explode("?", get_pagenum_link(1, false));
			$base = $page_url[0] . '%_%';
			$prev_link = '';
			$next_link = '';
			$format = 'page/%#%';
			if ($paged - 1 > 0) {
				$prev_link = $page_url[0] . 'page/' . ($paged - 1);
				$prev_link =  '<div class="page-prev page-numbers"><a class="wtbx-nav-button page-links-prev" href="'.$prev_link.'"></a></div>';
			}
			if ($paged < $new_wp_query->max_num_pages) {
				$next_link = $page_url[0] . 'page/' . ($paged + 1);
				$next_link =  '<div class="page-next page-numbers"><a class="wtbx-nav-button page-links-next" href="'.$next_link.'"></a></div>';
			}

			$pagination_args = array(
				'base'            => $base,
				'format'          => $format,
				'total'           => $new_wp_query->max_num_pages,
				'current'         => $paged,
				'show_all'        => false,
				'prev_next'       => false,
				'type'            => 'array',
				'add_args'        => false,
				'add_fragment'    => ''
			);

			$paginate_links = paginate_links($pagination_args);

			if (is_array($paginate_links)) {
				$grid_navigation .= '<nav class="wtbx-pagination wtbx-skin-'. esc_attr($pagination_skin) .'">';
				$grid_navigation .= '<div class="row-inner clearfix">';
				$grid_navigation .= '<div class="wtbx-pagination-inner clearfix">';
				$grid_navigation .= $prev_link;
				$grid_navigation .= '<div class="wtbx-pagination-pages">';
				foreach ( $paginate_links as $page ) {
					$grid_navigation .= $page;
				}
				$grid_navigation .= '</div>';
				$grid_navigation .= $next_link;
				$grid_navigation .= '</div>';
				$grid_navigation .= '</div>';
				$grid_navigation .= '</nav>';
			}
		}

		if ( $query === 'settings' ) {
			$args['paged'] = $paged;
		}
	} elseif ($navigation === '2' && $style !== 'panels' && $style !== 'slider') {
		ob_start();
		if ( $loadmore !== '' ) {
			get_template_part('templates/components/loadmore');
		} else {
			get_template_part('templates/components/loading');
		}
		$grid_navigation .= ob_get_clean();

		$lazyload_settings = array(
			'ajaxurl'           => site_url() . '/wp-admin/admin-ajax.php',
			'wpnonce'           => wp_create_nonce('wtbx-grid-nonce'),
			'query'             => serialize($new_wp_query->query),
			'current_page'      => $paged,
			'max_pages'         => $new_wp_query->max_num_pages,
			'aspect_ratio'      => $aspect_ratio,
			'animation'         => $animation_style,
//			'portfolio_overlay' => $portfolio_overlay,
			'overlay_content'   => $overlay_content,
			'meta_primary'      => $meta_primary,
			'meta_secondary'    => $meta_secondary,
			'excerpt_length'    => $excerpt_length,
			'grid_layout'       => $grid_layout,
			'overlay_trigger'   => $overlay_trigger,
			'like'              => $like,
			'overlay_mobile'    => $overlay_mobile,
			'click_action'      => $click_action,
			'overlay_idle'                          => $overlay_idle,
			'overlay_hover'                         => $overlay_hover,
			'meta_primary_hover'                    => $meta_primary_hover,
			'meta_secondary_hover'                  => $meta_secondary_hover,
			'action_button_link'                    => $action_button_link,
			'action_button_gallery_all'             => $action_button_gallery_all,
			'action_button_gallery_item'            => $action_button_gallery_item,
			'caption_primary'                       => $caption_primary,
			'caption_secondary'                     => $caption_secondary,
			'share'                                 => $share,
			'loadmore'                              => $loadmore,
		);
		wtbx_vc_localize_main_js('wtbx_'.$object.'_' . $gridID, $lazyload_settings);
	}
}

$portfolio_contents = $portfolio_imgs = array();

if (!$new_wp_query->have_posts()) {
	include(locate_template('templates/nothing-found.php'));
} else {
	while ($new_wp_query->have_posts()) : $new_wp_query->the_post();
		$postID = get_the_ID();
		$current_post = $new_wp_query->current_post;
		ob_start();
		include(locate_template('templates/portfolio/'.$style.'/portfolio-entry-'.$style.'.php'));
		$output .= ob_get_clean();
		if ( $style === 'panels' ) {
			$portfolio_contents[] = wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary') . wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary') . '<div class="portfolio-'.esc_attr($style).'-excerpt wtbx-text">' . wtbx_excerpt($excerpt_length) . '</div><a href="'.esc_url(get_permalink()).'" class="portfolio-'.esc_attr($style).'-link">'.esc_html__('See Details', 'core-extension').'</a>';
		} elseif ( $style === 'slider' ) {
			$portfolio_contents[] = wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary') . wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary') . '<div class="portfolio-'.esc_attr($style).'-excerpt wtbx-text">' . wtbx_excerpt($excerpt_length) . '</div><a href="'.esc_url(get_permalink()).'" class="portfolio-'.esc_attr($style).'-link">'.esc_html__('See Details', 'core-extension').'</a>';
			$portfolio_imgs[] = get_post_thumbnail_id($postID);
		}
		if (!empty($custom_layout)) {
			if ( $current_post >= ($tiles-1) && ($current_post+1) % ($tiles) === 0 ) {
				$counter++;
			}
		}
	endwhile;
}

wp_reset_postdata();

$output .= '</div>';

if ( $style === 'panels' || $style === 'slider' ) {
	$output .= '<div class="portfolio-'.esc_attr($style).'-content">';
	foreach ( $portfolio_contents as $portfolio_content ) {
		$output .= '<div class="portfolio-'.esc_attr($style).'-meta">';
		$output .= $portfolio_content;
		$output .= '</div>';
	}
	$output .= '</div>';

	if ( $style === 'panels' ) {
		$output .= '<div class="portfolio-'.esc_attr($style).'-counter">';
		for ( $i=1; $i<=sizeof($portfolio_contents); $i++ ) {
			$output .= '<span>' . ($i < 10 ? '0' : '') . $i . '</span>';
		}
		$output .= '</div>';
	}

	$output .= '<div class="portfolio-'.esc_attr($style).'-nav">';
	$output .= '<div class="portfolio-'.esc_attr($style).'-buttons">';
	$output .= '<div class="portfolio-'.esc_attr($style).'-button prev wtbx-click"><i class="scape-ui-chevron-left"></i></div>';
	$output .= '<div class="portfolio-'.esc_attr($style).'-button next wtbx-click"><i class="scape-ui-chevron-right"></i></div>';
	$output .= '</div>';
	if ( $style === 'slider' ) {
		$output .= '<div class="portfolio-progress-wrapper">';
		$output .= '<div class="portfolio-from">01</div>';
	}
	$output .= '<div class="portfolio-'.esc_attr($style).'-progress"><div class="bar"></div></div>';
	if ( $style === 'slider' ) {
		$output .= '<div class="portfolio-to">'.esc_html(sizeof($portfolio_contents)).'</div>';
		$output .= '</div>';
	}
	$output .= '</div>';

	if ( $style === 'slider' ) {
		$output .= '<div class="portfolio-slider-bg">';
		for ( $i=0; $i<=sizeof($portfolio_imgs); $i++ ) {
			$output .= '<div class="portfolio-slider-bg-inner">' . wtbx_image_smart_crop($portfolio_imgs[$i], 'full', 'full', '1:1', $alt, '', true, '1') . '</div>';
		}
		$output .= '</div>';
	}
}

$output .= $grid_navigation;

$output .= '</div>';

if ( in_array($action_button_preview, array('gallery_all', 'gallery_item'))  || in_array($click_action, array('gallery_all', 'gallery_item'))  ) {
	ob_start();
	include(locate_template('templates/components/lightbox-nav.php'));
	$output .= ob_get_clean();
}

$output .= '</div>';



$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( $style === 'metro' ) {
	wp_enqueue_style('scape-portfolio-metro');
	wp_enqueue_script('scape-grid-metro');
} elseif ( $style === 'masonry' ) {
	wp_enqueue_style('scape-portfolio-masonry');
}  elseif ( $style === 'overlap' ) {
	wp_enqueue_style('scape-portfolio-overlap');
	wp_enqueue_script('scape-grid-general');
} elseif ( $style === 'boxed' ) {
	wp_enqueue_style('scape-portfolio-boxed');
	wp_enqueue_script('scape-grid-masonry');
}  elseif ( $style === 'square' ) {
	wp_enqueue_style('scape-portfolio-square');
	wp_enqueue_script('scape-grid-masonry');
}  elseif ( $style === 'tiles' ) {
	wp_enqueue_style('scape-portfolio-tiles');
	wp_enqueue_script('scape-grid-masonry');
} elseif ( $style === 'panels' ) {
	wp_enqueue_style('scape-portfolio-panels');
} elseif ( $style === 'slider' ) {
	wp_enqueue_style('scape-portfolio-slider');
}

if ( wtbx_vc_is_page_editable() ) {
	echo '<script>';
	echo "if ('undefined' !== typeof SCAPE) {";
	echo "if ('undefined' !== typeof SCAPE.isotopeMasonry) {SCAPE.isotopeMasonry.init(jQuery('.wtbx-grid-masonry, .wtbx-grid-boxed, .wtbx-grid-square, .wtbx-grid-tiles, .wtbx-grid-minimal'));}";
	echo "if ('undefined' !== typeof SCAPE.isotopeMetro) {SCAPE.isotopeMetro.init(jQuery('.wtbx-grid-metro'));}";
	echo "if ('undefined' !== typeof SCAPE.gridGeneral) {SCAPE.gridGeneral.init(jQuery('.wtbx-grid-overlap'), 'overlap', 'portfolio');}";
	echo "if ('undefined' !== typeof SCAPE.portfolioGridSlider) {SCAPE.portfolioGridSlider.init(jQuery('.wtbx-grid-panels, .wtbx-grid-slider'));}";
	echo "SCAPE.gridReveal(jQuery('.wtbx-grid').find('.wtbx-element-reveal:not(.wtbx-element-visible)'));";
	echo "SCAPE.waypoints(jQuery('.".$unique_class." .wtbx_appearance_animation'));";
	echo "SCAPE.atvHover();}";
	echo "SCAPE.revealNoLazy();";
	echo '</script>';
}