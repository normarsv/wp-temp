<?php
$output = $el_class = $meta_primary = $meta_secondary = $lightbox_atts = $layout_cols = $tiles = $counter = $min_width =
$post_overlay = $style = $disable_sequential = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style('scape-blog');
wtbx_vc_script_queue('isotope');
if ( $style === 'metro' ) { wtbx_vc_script_queue('packery'); }

// shortcode class
$element_class      = 'wtbx_vc_blog_grid';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// unique grid ID
$gridID = hexdec(substr(uniqid(), 6, 7));

// prefix
if ( $limit === 'yes' ) $custom_categories = explode(',', $categories);
$category_term = 'category';
$defaults = explode(',', $defaults);
$rm_text = wtbx_vc_option('post-list-excerpt-text');
$gutter = $style === 'metro' ? intval($gutter) : '30';
$gutter = $style === 'masonry' ? '0' : $gutter;
$gutter = $style === 'minimal' ? '' : $gutter;
$border = intval($border);
$post_type = 'post';
$is_content_block = 'content_block' === get_post_type();

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
	$tax_query = array();
}

// filter
$filter_categories = $filter === '' ? false : $categories_array;
$filter_bg = $filter_bg_color;

$filter_display = ' filter-layout-' . $filter_align;
if ( $filter_align !== 'center' ) {
	$filter_display .= $filter_layout;
}

// loading limit
$post_limit = $post_limit !== '' ? ' data-limit="'.intval($post_limit).'"' : '';

// pagination skin
$pagination_skin = $nav_skin;

// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

// lightbox
if ( !empty($click_action) && in_array($click_action, array('gallery_all', 'gallery_item') )) {
	$lightbox_atts  = wtbx_lightbox_attributes();
}

// typography
$title_typography = wtbx_font_styling($title_typography);
$excerpt_typography = wtbx_font_styling($excerpt_typography);

//overlay
$overlay_color = wtbx_vc_color_styles_bg($overlay_color);

// folder
$folder = $style === 'sbs' ? 'sidebyside' : $style;

// side-by-side specific
$content_width = (12 - $media_width);

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
		$grid_layout = 'default';
		$columns = str_replace('columns_', '', $metro_layout);
	}
} else {
	$grid_layout = 'default';
	$layout_cols = $tiles = '';
}

// object
$object = $blog_type = $style;

// meta hide
$meta_class = '';
$meta_array = !empty($hide_meta) ? explode(',', $hide_meta) : array();
if (!empty($meta_array)) {
	foreach ( $meta_array as $item ) {
		$meta_class .= ' no-' . $item;
	}
}

$perpage = $perpage !== '' ? $perpage : wp_count_posts('post')->publish;


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $grid_bg_color !== '' ? $unique_class_css.' .wtbx_blog_grid_wrapper {' . wtbx_vc_color_styles_bg($grid_bg_color) .'}' : '';
$js_styles .= ( $title_typography !== '' ) ? $unique_class_css.' article.post-entry h1.entry-title a {'.$title_typography.'}' : '';
$js_styles .= ( $excerpt_typography !== '' ) ? $unique_class_css.' article.post-entry .entry-content {'.$excerpt_typography.'}' : '';
$js_styles .= $style === 'metro' && $overlay_color !== '' ? $unique_class_css.' .post-metro-overlay {' . $overlay_color .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';


$output .= '<div class="wtbx_blog_grid_wrapper blog-' . $style . ($filter !== '' ? ' filter-'.$filter : '') . '">';

if ( $filter !== '' && !wtbx_is_archive() ) {
	ob_start();
	include(locate_template('templates/components/filter.php'));
	$output .= ob_get_clean();
}

$output .= '<div class="wtbx-grid-wrapper">';
$output .= '<div class="blog-grid wtbx-grid wtbx-grid-'.$style.' wtbx-container-reveal wtbx-lightbox-container row-inner clearfix'.esc_attr($meta_class).'" data-columns="'.$columns.'" data-gutter="'.$gutter.'" data-border="'.$border.'" data-id="'.$gridID.'" data-grid="blog" data-seq="'.$disable_sequential.'" data-minwidth="'.esc_attr(intval($min_width)).'" '.$lightbox_atts.' data-filter-prefix="category"'.$layout_cols.$post_limit.'>';

$paged = (get_query_var('paged')) ? get_query_var('paged') : (isset($new_wp_query->query['paged']) ? $new_wp_query->query['paged'] : 1);

$args = array();
if ( $query === 'global' || wtbx_is_archive() ) {
	global $wp_query;
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$args = $wp_query->query_vars;
	if ( wtbx_vc_is_page_editable() ) {
		$args = array('post_type' => 'post',
		              'posts_per_page' => get_option( 'posts_per_page' ),
		              'paged' => $paged,
		);
	}
} elseif ( $query === 'settings' ) {
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $perpage,
		'paged' => $paged,
		'tax_query' => $tax_query
	);
} elseif ( $query === 'custom' ) {
	if ( !empty($custom_wp_query) ) {
		$args = 'post_type=post&'.htmlspecialchars_decode($custom_wp_query);
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
	} elseif ($navigation === '2') {
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
			'preview'           => $preview,
			'excerpt'           => $excerpt_length,
			'aspect_ratio'      => $aspect_ratio,
			'animation'         => $animation_style,
			'post_overlay'      => $post_overlay,
			'meta_array'        => $meta_array,
			'meta_class'        => $meta_class,
			'loadmore'          => $loadmore,
			'media_width'       => $media_width,
			'grid_layout'       => $grid_layout,
			'columns_minimal'   => $columns_minimal,
			'reading_time'      => $reading_time
		);
		wtbx_vc_localize_main_js('wtbx_'.$object.'_' . $gridID, $lazyload_settings);
	}
}


if (!$new_wp_query->have_posts()) :
	include(locate_template('templates/nothing-found.php'));
endif;

while ($new_wp_query->have_posts()) : $new_wp_query->the_post();
	$postID = get_the_ID();
	ob_start();
	$current_post = $new_wp_query->current_post;
	include(locate_template('templates/blog-post/'.$folder.'/blog-entry-'.$style.'.php'));
	if (!empty($custom_layout)) {
		if ( $current_post >= ($tiles-1) && ($current_post+1) % ($tiles) === 0 ) {
			$counter++;
		}
	}
	$output .= ob_get_clean();

endwhile;

wp_reset_postdata();


$output .= '</div>';

$output .= $grid_navigation;

$output .= '</div>';

if ( $style === 'masonry' ) {
	ob_start();
	include(locate_template('templates/components/lightbox-nav.php'));
	$output .= ob_get_clean();
}

$output .= '</div>';



$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( $style === 'sbs' ) {
	wp_enqueue_style('scape-blog-sbs-style');
	wp_enqueue_script('scape-blog-sbs');
} elseif ( $style === 'minimal' ) {
	wp_enqueue_style('scape-blog-minimal-style');
	wp_enqueue_script('scape-blog-minimal');
} elseif ( $style === 'default' ) {
	wp_enqueue_style('scape-blog-default-style');
	wp_enqueue_script('scape-blog-default');
} elseif ( $style === 'metro' ) {
	if ( wtbx_vc_is_page_editable() ) {
		wp_enqueue_script('isotope');
		wp_enqueue_script('packery');
	}
	wp_enqueue_style('scape-blog-metro-style');
	wp_enqueue_script('scape-grid-metro');
} elseif ( $style === 'column' ) {
	wp_enqueue_style('scape-blog-column-style');
	wp_enqueue_script('scape-grid-general');
} elseif ( $style === 'boxed' ) {
	wp_enqueue_style('scape-blog-boxed-style');
	wp_enqueue_script('scape-grid-general');
} elseif ( $style === 'magazine' ) {
	wp_enqueue_style('scape-blog-magazine-style');
	wp_enqueue_script('scape-grid-general');
} elseif ( $style === 'masonry' ) {
	wp_enqueue_style('scape-blog-masonry-style');
	wp_enqueue_script('scape-grid-masonry');
}

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>";
	echo "if ('undefined' !== typeof SCAPE.isotopeMasonry) { SCAPE.isotopeMasonry.init(jQuery('.wtbx-grid-masonry, .wtbx-grid-boxed, .wtbx-grid-square, .wtbx-grid-tiles, .wtbx-grid-minimal')); }";
	echo "if ('undefined' !== typeof SCAPE.isotopeMetro) { SCAPE.isotopeMetro.init(jQuery('.wtbx-grid-metro')); }";
	echo "if ('undefined' !== typeof SCAPE.blogDefault) { SCAPE.blogDefault.init(jQuery('.wtbx-grid-default')); }";
	echo "if ('undefined' !== typeof SCAPE.blogMinimal) { SCAPE.blogMinimal.init(jQuery('.wtbx-grid-minimal')); }";
	echo "if ('undefined' !== typeof SCAPE.blogSBS) { SCAPE.blogSBS.init(jQuery('.wtbx-grid-sbs')); }";
	echo "if ('undefined' !== typeof SCAPE.gridGeneral) { SCAPE.gridGeneral.init(jQuery('.wtbx-grid-column'), 'column', 'blog'); }";
	echo "if ('undefined' !== typeof SCAPE.gridGeneral) { SCAPE.gridGeneral.init(jQuery('.wtbx-grid-magazine'), 'magazine', 'blog'); }";
	echo "if ('undefined' !== typeof SCAPE.gridGeneral) { SCAPE.gridGeneral.init(jQuery('.wtbx-grid-boxed'), 'boxed', 'blog'); }";
	echo "if ('undefined' !== typeof SCAPE.gridGeneral) { SCAPE.gridGeneral.init(jQuery('.wtbx-grid-overlap'), 'overlap', 'portfolio'); }";
	echo "if ('undefined' !== typeof SCAPE) {";
	echo "SCAPE.waypoints(jQuery('.".$unique_class." .wtbx_appearance_animation'));";
	echo "SCAPE.prettyLike();";
	echo "SCAPE.revealNoLazy();";
	echo "}";
	echo "</script>";
}