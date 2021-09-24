<?php
/*
*	---------------------------------------------------------------------
*	WTBX add/remove filters and actions
*	---------------------------------------------------------------------
*/

function wtbx_setup() {

	// launching operation cleanup
	add_action('init', 'wtbx_head_cleanup');
	// A better title
	add_filter('wp_title', 'rw_title', 10, 3);
	// remove WP version from RSS
	add_filter('the_generator', 'wtbx_rss_version');

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'wtbx_wp_scripts_and_styles' );
	add_action( 'admin_enqueue_scripts', 'wtbx_admin_scripts_and_styles' );

	// launching this stuff after theme setup
	wtbx_theme_support();

	// initiate custom cursor
	wtbx_custom_cursor_atts();

	// set custom excerpt length
	add_filter('excerpt_length', 'custom_excerpt_length', 999);

	// add fonts load in footer
	add_action( 'wp_footer', 'WtbxFontsEnqueue::themeFonts' );

	// items per page for post and portfolio grids
	add_action( 'pre_get_posts', 'wtbx_pre_get_posts' );

	// register and enqueue Gutenberg stylesheet
	add_action( 'enqueue_block_editor_assets', 'wtbx_gutenberg_styles' );

	add_action( 'redux/options/wtbx_scape/settings/change', 'wtbx_generate_css' );
	
	// register dynamic strings for translation
	add_action('redux/options/wtbx_scape/settings/change', 'wtbx_register_detail_key_strings');

	function wtbx_register_detail_key_strings($value) {
		if ( class_exists('SitePress') && has_action('wpml_register_single_string') ) {
			if (isset($value['portfolio-item-details'])) {
				foreach ((array) $value['portfolio-item-details'] as $id => $label) {
					do_action('wpml_register_single_string', 'Scape', 'Portfolio detail - ' . $label, $label);
				}
			}

			for ( $i = 0; $i <= 10; $i++ ) {
				if (isset($value['h'.$i.'-text-info'])) { do_action('wpml_register_single_string', 'Scape', 'h'.$i.'-text-info', $value['h'.$i.'-text-info']); }
				if (isset($value['h'.$i.'-button-primary-link'])) { do_action('wpml_register_single_string', 'Scape', 'h'.$i.'-button-primary-link', $value['h'.$i.'-button-primary-link']); }
				if (isset($value['h'.$i.'-button-primary-text'])) { do_action('wpml_register_single_string', 'Scape', 'h'.$i.'-button-primary-text', $value['h'.$i.'-button-primary-text']); }
				if (isset($value['h'.$i.'-button-secondary-link'])) { do_action('wpml_register_single_string', 'Scape', 'h'.$i.'-button-secondary-link', $value['h'.$i.'-button-secondary-link']); }
				if (isset($value['h'.$i.'-button-secondary-text'])) { do_action('wpml_register_single_string', 'Scape', 'h'.$i.'-button-secondary-text', $value['h'.$i.'-button-secondary-text']); }
			}

			if (isset($value['hm-text-info'])) { do_action('wpml_register_single_string', 'Scape', 'hm-text-info', $value['hm-text-info']); }
			if (isset($value['hm-button-primary-link'])) { do_action('wpml_register_single_string', 'Scape', 'hm-button-primary-link', $value['hm-button-primary-link']); }
			if (isset($value['hm-button-primary-text'])) { do_action('wpml_register_single_string', 'Scape', 'hm-button-primary-text', $value['hm-button-primary-text']); }
			if (isset($value['hm-button-secondary-link'])) { do_action('wpml_register_single_string', 'Scape', 'hm-button-secondary-link', $value['hm-button-secondary-link']); }
			if (isset($value['hm-button-secondary-text'])) { do_action('wpml_register_single_string', 'Scape', 'hm-button-secondary-text', $value['hm-button-secondary-text']); }

		}
	}

	function wtbx_custom_portfolio_slug() {
		global $wtbx_scape;

		if (empty($wtbx_scape)) {
			if (is_multisite()) {
				$wtbx_scape = get_blog_option(get_current_blog_id(), 'wtbx_scape');
			} else {
				$wtbx_scape = get_option('wtbx_scape');
			}
		}

		$portfolio_cpt = (!empty($wtbx_scape['portfolio-custom-slug'])) ? $wtbx_scape['portfolio-custom-slug'] : '';
		if ($portfolio_cpt === '') $portfolio_cpt = 'portfolio';

		$rules = get_option('rewrite_rules');
		$matched = array();

		if ( !empty($rules) ) {
			foreach ($rules as $key => $value) {
				if ( preg_match('/\b('.$portfolio_cpt.')\b/', $key, $matches) ) {
					array_push($matched, $key);
				}
			}
			if (empty($matched)) {
				global $wp_rewrite; $wp_rewrite->flush_rules();
			}
		}

	}
	add_action( 'init', 'wtbx_custom_portfolio_slug' );

}
add_action( 'after_setup_theme', 'wtbx_setup' );

add_action( 'after_switch_theme', 'wtbx_generate_css' );

function custom_excerpt_length( $length ) {
	return 75;
}

// add mime types
function wtbx_add_mime_types( $existing_mimes ) {
	// add webm to the list of mime types
	$existing_mimes['ttf']      = 'application/x-font-ttf';
	$existing_mimes['eot']      = 'application/vnd.ms-fontobject';
	$existing_mimes['woff']     = 'application/font-woff woff';
	$existing_mimes['woff2']    = 'application/font-woff2 woff2';
	$existing_mimes['mp4']      = 'video/mp4, video/quicktime';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'wtbx_add_mime_types' );

// Pre-get-posts for search page
add_filter('pre_get_posts','wtbx_search_filter');

// Redirect for maintenance page
add_filter('template_include', 'wtbx_maintenance_redirect');

// Add body classes
add_filter( 'body_class', 'wtbx_body_class', 10, 2 );

// Add typekit preload
//add_action( 'wp_head', 'wtbx_preload_typekit_font' );

// Add comment styles
add_action( 'comment_form_before', 'wtbx_add_comment_styles' );

// Add widget styles
add_action( 'widget_title', 'wtbx_add_widget_styles' );

function wtbx_head_cleanup() {
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
}

function wtbx_pre_get_posts($query) {
	if ( !is_admin() ) {
		$id = get_the_ID();
		$has_grid = is_page() && !empty(get_post_meta($id, 'items-perpage', true));

		if ( (!is_single() && ( get_post_type() === 'post' || get_post_type() === 'portfolio' ) ) || $has_grid ) {
			if ( is_archive() ) {
				$id = get_post_meta($id, 'navigation-parent', true);
			}

			if ( !empty(get_post_meta($id, 'items-perpage', true)) ) {
				$query->set( 'posts_per_page', get_post_meta($id, 'items-perpage', true) );
			} elseif ( get_post_type() === 'portfolio' ) {
				$query->set( 'posts_per_page', wtbx_option('portfolio-archive-perpage') );
			}
		}
	}
	return $query;
}

// Register default theme-specific cookies for GDPR plugin
add_action( 'after_switch_theme', 'wtbx_default_gdpr_consent' );

function wtbx_default_gdpr_consent() {
	add_option(
		'gdpr_consent_types', array(
			'privacy-policy' => array(
				'name'          => 'Privacy Policy',
				'description'   => 'You read and agreed to our <a href="#">Privacy Policy</a>.',
				'registration'   => 'You read and agreed to our <a href="#">Privacy Policy</a>.',
			),
			'youtube'   => array(
				'name'          => 'YouTube',
				'description'   => 'We use the YouTube service to enable video content streaming on this site.',
				'registration'  => 'We use the YouTube service to enable video content streaming on this site.',
			),
			'vimeo' => array(
				'name'          => 'Vimeo',
				'description'   => 'We use the Vimeo service to enable video content streaming on this site.',
				'registration'  => 'We use the Vimeo service to enable video content streaming on this site.',
			),
			'soundcloud'   => array(
				'name'          => 'SoundCloud',
				'description'   => 'We use the SoundCloud service to enable audio content streaming on this site.',
				'registration'  => 'We use the SoundCloud service to enable audio content streaming on this site.',
			),
			'spotify'       => array(
				'name'          => 'Spotify',
				'description'   => 'We use the Spotify service to enable audio content streaming on this site.',
				'registration'  => 'We use the Spotify service to enable audio content streaming on this site.',
			),
			'google-maps'       => array(
				'name'          => 'Google Maps',
				'description'   => 'We use the Google Maps service to display interactive maps on this site.',
				'registration'  => 'We use the Google Maps service to display interactive maps on this site.',
			),
			'tracking'       => array(
				'name'          => 'Tracking',
				'description'   => 'We use the Google Analytics to get valuable interaction data and improve user experience on this site.',
				'registration'  => 'We use the Google Analytics to get valuable interaction data and improve user experience on this site.',
			),
			'like-system'       => array(
				'name'          => 'Like System',
				'description'   => 'We use the Like System for blog posts and portfolio items to improve user experience on this site.',
				'registration'  => 'We use the Like System for blog posts and portfolio items to improve user experience on this site.',
			)
		)
	);
}

function wtbx_default_menu_setup() {
	$menus = get_terms( 'nav_menu' );
	$locations = get_nav_menu_locations();

	if ( empty($menus) ) {
		$menu_id = wp_create_nav_menu('Main Navigation');
		$locations['header'] = $menu_id;
		$locations['mobile'] = $menu_id;
		set_theme_mod('nav_menu_locations', $locations);
	}
}

// Use shortcodes in text widgets
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

// Add specific CSS class by filter
add_filter( 'body_class', 'wtbx_body_class_names' );
function wtbx_body_class_names( $classes ) {
	if ( is_singular() && function_exists( 'has_blocks' ) && has_blocks() ) {
		$classes[] = 'has-blocks';
	}

	return $classes;
}

// Remove JS and CSS types
add_action( 'template_redirect', function(){
	ob_start( function( $buffer ){
		$buffer = str_replace( array( ' type="text/javascript"', " type='text/javascript'", ' type="text/css"', " type='text/css'" ), '', $buffer );
		return $buffer;
	});
});