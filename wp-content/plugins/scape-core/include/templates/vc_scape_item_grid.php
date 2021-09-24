<?php
$output = $el_class = $meta_primary = $meta_secondary = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


// shortcode class
$element_class      = 'wtbx_vc_item_grid';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// unique grid ID
$gridID = hexdec(substr(uniqid(), 6, 7));

// prefix
if ( $source === 'blog' ) {
	$style = $style_blog;
	$source_folder = 'blog-post';
	$prefix = 'category';
	if ( $limit_blog === 'yes' ) $custom_categories = explode(',', $categories_blog);
	$category_term = 'category';
	$post_type = 'post';
	$defaults = explode(',', $defaults_blog);
	$rm_text = wtbx_vc_option('post-list-excerpt-text');
	$gutter = $style_blog === 'metro' ? intval($gutter_blog) : '';
	$border = intval($border_blog);
	$post_overlay = $overlay_color;
	$columns = $columns_blog;
} elseif ( $source === 'portfolio' ) {
	$style = $style_portfolio;
	$source_folder = 'portfolio';
	$prefix = 'portfolio_category';
	if ( $limit_portfolio === 'yes' ) $custom_categories = explode(',', $categories_portfolio);
	$category_term = 'portfolio_category';
	$post_type = 'portfolio';
	$defaults =  explode(',', $defaults_portfolio);
	$gutter = $style_portfolio !== 'boxed' ? intval($gutter_portfolio) : '';
	if ( $style === 'square' ) $gutter = 60;
	if ( $style === 'tiles' ) $gutter = 45;
	$border = intval($border_portfolio);
	$portfolio_overlay = wtbx_vc_color_styles_bg($overlay_color);

	// columns
	if ( $style_portfolio === 'metro' ) {
		$grid_layout = $metro_layout_portfolio;
		if ( strpos($grid_layout, 'layout') !== false ) {
			$custom_layout = true;
			$layout_obj = wtbx_vc_grid_layouts($grid_layout);
			$counter = 0;
			$layout_cols = ' data-layout-cols="'.$layout_obj['columns'].'"';
			$tiles = $layout_obj['tiles'];
		} else {
			$columns = $columns_portfolio_metro;
		}
	} else {
		$columns = $columns_portfolio;
		$layout_cols = $grid_layout = '';
	}

	// content
	if ( in_array($style, array('masonry', 'metro', 'boxed')) ) {
		$content = $overlay_content;
		$meta_primary = $portfolio_content_primary;
		$meta_secondary = $portfolio_content_secondary;
	} else {
		$overlay_content = $overlay_content_separate;
		$meta_primary = $portfolio_content_primary_separate;
		$meta_secondary = $portfolio_content_secondary_separate;
	}

}

// categories
$categories_array = [];
if (!empty($custom_categories)) {
	$categories_array = $custom_categories;
} else {
	$categories = get_terms($category_term);
	if (!empty($categories) && !is_wp_error($categories)) {
		foreach ($categories as $term) {
			$categories_array[] = $term->term_id;
		}
	}
}

// filter
if ( $filter === 'multi' ) $operator = ' data-operator="'.$filter_operator.'"';
$filter_categories = $filter === '' ? false : $categories_array;
$filter_bg = $filter_bg_color;

// fullwidth
$fullwidth = $fullwidth === 'yes' ? ' full-width' : '';

// overlay animation
$overlay_trigger = !empty($overlay_trigger) ? ' overlay-' . str_replace('overlay_', '', $overlay_trigger) : '';

// loading limit
$post_limit = $post_limit !== '' ? ' data-limit="'.intval($post_limit).'"' : '';

// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

// lightbox
if ( in_array($click_action, array('gallery_all', 'gallery_item') )) {
	$lightbox_atts  = wtbx_lightbox_attributes();
}

// object
if ( $style === 'metro' ) {
	$object = 'metro';
} else {
	$object = 'masonry';
}

$blog_type = $object;

// meta hide
$meta_class = '';
$meta_array = $hide_meta !== '' ? explode(',', $hide_meta) : array();
if ($meta_array) {
	foreach ( $meta_array as $item ) {
		$meta_class .= ' no-' . $item;
	}
}


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';
$js_styles .= $grid_bg_color !== '' ? $unique_class_css.' .wtbx-grid-wrapper {' . wtbx_vc_color_styles_bg($grid_bg_color) .'}' : '';
$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';


$output .= '<div class="wtbx_item_grid_wrapper '.$source.'-'.$style.'">';

if ( $filter !== '' && !$scape_archive ) {
	ob_start();
	include(locate_template('templates/components/filter.php'));
	$output .= ob_get_clean();
}

$output .= '<div class="wtbx-grid-wrapper'.$fullwidth.'">';
$output .= '<div class="'.$source.'-grid wtbx-grid wtbx-grid-'.$style.' wtbx-container-reveal wtbx-lightbox-container row-inner" data-columns="'.$columns.'" data-gutter="'.$gutter.'" data-border="'.$border.'" data-id="'.$gridID.'" data-grid="'.$source.'" '.$lightbox_atts.' data-filter-prefix="'.$prefix.'"'.$layout_cols.$post_limit.'>';

if ( !wtbx_is_archive() ) {
	$args = array('post_type' => $post_type,
	              'posts_per_page' => $perpage,
	              'paged' => 1,
	              'tax_query' => array(
		              array(
			              'taxonomy' => $category_term,
			              'field' => 'term_id',
			              'terms' => $categories_array,
		              ),
	              ),
	);
} else {
	global $wp_query;
	$wp_query->query_vars['posts_per_page'] = $perpage;
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$args = $wp_query->query_vars;
}
$new_wp_query = new WP_Query($args);
$custom_query = $new_wp_query;


if (!$new_wp_query->have_posts()) :
	get_template_part('templates/post-nothins', 'found');
endif;

while ($new_wp_query->have_posts()) : $new_wp_query->the_post();
	$postID = get_the_ID();
	ob_start();
	$current_post = $new_wp_query->current_post;
	include(locate_template('templates/'.$source_folder.'/'.$style.'/'.$source.'-entry-'.$style.'.php'));
	if ($custom_layout) {
		if ( $current_post >= ($tiles-1) && ($current_post+1) % ($tiles) === 0 ) {
			$counter++;
		}
	}
	$output .= ob_get_clean();

endwhile;

wp_reset_postdata();


$output .= '</div>';

if ($wp_query->max_num_pages > 1) {
	if 	($navigation === '1') {
		// pagination
		ob_start();
		include(locate_template( 'templates/section-pagination.php' ));
		$output .= ob_get_clean();
	} elseif ($navigation === '2') {
		if ( $source === 'portfolio' ) {
			$lazyload_settings = array(
				'ajaxurl'           => site_url() . '/wp-admin/admin-ajax.php',
				'query'             => serialize($wp_query->query),
				'current_page'      => 1,
				'max_pages'         => $wp_query->max_num_pages,
				'aspect_ratio'      => $aspect_ratio,
				'animation'         => $animation_style,
				'portfolio_overlay' => $portfolio_overlay,
				'overlay_content'   => $overlay_content,
				'meta_primary'      => $meta_primary,
				'meta_secondary'    => $meta_secondary,
				'grid_layout'       => $grid_layout,
				'overlay_trigger'   => $overlay_trigger,
				'like'              => $like,
				'overlay_mobile'    => $overlay_mobile,
				'click_action'      => $click_action,
				'loadmore'          => $loadmore
			);
		} elseif ( $source === 'blog' ) {
			$lazyload_settings = array(
				'ajaxurl'           => site_url() . '/wp-admin/admin-ajax.php',
				'query'             => serialize($wp_query->query),
				'current_page'      => $paged,
				'max_pages'         => $wp_query->max_num_pages,
				'preview'           => $preview,
				'excerpt'           => $excerpt_length,
				'aspect_ratio'      => $aspect_ratio,
				'animation'         => $animation_style,
				'post_overlay'      => $post_overlay,
				'meta_array'        => $meta_array,
				'meta_class'        => $meta_class,
				'loadmore'          => $loadmore
			);
		}

		wtbx_vc_localize_main_js('wtbx_'.$object.'_' . $gridID, $lazyload_settings );

		ob_start();
		get_template_part('templates/components/loadmore');
		$output .= ob_get_clean();
	}

}
$output .= '</div>';

if ( $click_action === 'gallery_all' || $click_action === 'gallery_item' ) {
	ob_start();
	include(locate_template('templates/components/lightbox-nav.php'));
	$output .= ob_get_clean();
}

$output .= '</div>';



$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;