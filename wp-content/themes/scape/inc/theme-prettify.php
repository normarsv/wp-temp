<?php
/*
*	---------------------------------------------------------------------
*	WTBX Prettify the theme
*	---------------------------------------------------------------------
*/

// A better title
function rw_title( $title, $sep, $seplocation ) {
	global $page, $paged;

	// Don't affect in feeds.
	if ( is_feed() ) return $title;

	// Add the blog's name
	if ( 'right' == $seplocation ) {
		$title .= get_bloginfo( 'name' );
	} else {
		$title = get_bloginfo( 'name' ) . $title;
	}

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " {$sep} {$site_description}";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " {$sep} " . sprintf( esc_html__( 'Page %s', 'scape' ), max( $paged, $page ) );
	}

	return $title;
} // end better title

// remove WP version from RSS
function wtbx_rss_version() { return ''; }

// add excerpt field for pages
add_action( 'init', 'wtbx_add_excerpts_to_pages' );
function wtbx_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

function collars_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}



// change default image sizing on theme activation
// TODO: hide option fields on Settings > Media panel
add_action( 'switch_theme', 'wtbx_enforce_image_size_options' );
function wtbx_enforce_image_size_options() {
	$sizes = wtbx_get_image_sizes();
	update_option( 'thumbnail_size_w', $sizes['0'] );
	update_option( 'thumbnail_size_h', $sizes['0'] );
	update_option('medium_size_w', $sizes['1']);
	update_option('medium_size_h', $sizes['1']);
	update_option('medium_large_size_w', $sizes['2']);
	update_option('medium_large_size_h', $sizes['2']);
	update_option('large_size_w', $sizes['3']);
	update_option('large_size_h', $sizes['3']);
}

// add new image size
add_action( 'after_setup_theme', 'wtbx_add_image_sizes' );
if ( !function_exists( 'wtbx_add_image_sizes' ) ) {
	function wtbx_add_image_sizes() {
		if ( function_exists( 'add_image_size' ) ) {
			$sizes = wtbx_get_image_sizes();
			for ($key = 4, $size = count($sizes); $key < $size; $key++) {
				add_image_size( 'wtbx_' . $sizes[$key], $sizes[$key], $sizes[$key] );
			}
		}
	}
}

// add new size to dropdown list when adding media to post
function wtbx_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'x-large' => esc_html__( 'Extra large', 'scape' ),
		'xx-large' => esc_html__( 'Super large', 'scape' ),
		'xxx-large' => esc_html__( 'Ultra large', 'scape' ),
	) );
}
add_filter( 'image_size_names_choose', 'wtbx_custom_sizes' );

// ensure our image sizes are not overridden by website administrator
add_filter( 'pre_update_option_thumbnail_size_w', 'wtbx_filter_thumbnail_size_w' );
function wtbx_filter_thumbnail_size_w( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['0'];
}
add_filter( 'pre_update_option_thumbnail_size_h', 'wtbx_filter_thumbnail_size_h' );
function wtbx_filter_thumbnail_size_h( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['0'];
}
add_filter( 'pre_update_option_medium_size_w', 'wtbx_filter_medium_size_w' );
function wtbx_filter_medium_size_w( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['1'];
}
add_filter( 'pre_update_option_medium_size_h', 'wtbx_filter_medium_size_h' );
function wtbx_filter_medium_size_h( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['1'];
}
add_filter( 'pre_update_option_medium_large_size_w', 'wtbx_filter_medium_large_size_w' );
function wtbx_filter_medium_large_size_w( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['2'];
}
add_filter( 'pre_update_option_medium_large_size_h', 'wtbx_filter_medium_large_size_h' );
function wtbx_filter_medium_large_size_h( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['2'];
}
add_filter( 'pre_update_option_large_size_w', 'wtbx_filter_large_size_w' );
function wtbx_filter_large_size_w( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['3'];
}
add_filter( 'pre_update_option_large_size_h', 'wtbx_filter_large_size_h' );
function wtbx_filter_large_size_h( $newvalue ) {
	$sizes = wtbx_get_image_sizes();
	return $sizes['3'];
}
