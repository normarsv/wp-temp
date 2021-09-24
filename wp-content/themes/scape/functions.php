<?php

/*********************
LAUNCH SCAPE
Let's get everything up and running.
*********************/

// Define constants
$theme = wp_get_theme();
define('WTBX_PATH', get_template_directory());
define('WTBX_URI', get_template_directory_uri());
define('WTBX_PATH_STYLESHEET', get_stylesheet_directory());
define('WTBX_INCLUDE', get_template_directory() . '/inc');
define('WTBX_ADMIN', get_template_directory() . '/inc/theme-options');
define('WTBX_PLUGINS', get_template_directory() . '/inc/plugins');
define('WTBX_THEME_NAME', 'scape');
define('SCAPE_VERSION', $theme->get( 'Version' ));

// Add language support
load_theme_textdomain('scape', get_template_directory() . '/languages');


// Theme setup
require_once(WTBX_INCLUDE . '/fonts-enqueue.php');
require_once(WTBX_INCLUDE . '/theme-enqueue.php');
require_once(WTBX_INCLUDE . '/theme-support.php');
require_once(WTBX_INCLUDE . '/theme-filters-actions.php');
require_once(WTBX_INCLUDE . '/theme-prettify.php');
require_once(WTBX_INCLUDE . '/helper-functions.php');
require_once(WTBX_INCLUDE . '/custom-functions.php');
require_once(WTBX_INCLUDE . '/verification.php');
require_once(WTBX_INCLUDE . '/admin-pages.php');
require_once(WTBX_INCLUDE . '/ajax-load.php');
require_once(WTBX_INCLUDE . '/widgets.php');
require_once(WTBX_INCLUDE . '/tinymce/tinymce-ext.php');
require_once(WTBX_INCLUDE . '/plugins/class-tgm-plugin-activation.php');
require_once(WTBX_INCLUDE . '/plugins/tgm-register-plugins.php');

// demo
wtbx_demo(false);

// Breadcrumbs
require_once(WTBX_INCLUDE . '/breadcrumbs.php');

// WooCommerce
require_once(WTBX_INCLUDE . '/woocommerce/woofunctions.php');

// Menu additional features
require_once(WTBX_INCLUDE . '/menu.php');

// Comment walker
require_once(WTBX_INCLUDE . '/comment-walker.php');

// Custom fonts
require_once(WTBX_INCLUDE . '/custom-fonts.php');

// Custom icon fonts
require_once(WTBX_INCLUDE . '/custom-icon-fonts.php');

// Resize
require_once(WTBX_INCLUDE . '/libs/aq-resize.php');

// Icon generator + default icons
require_once(WTBX_INCLUDE . '/icons/icons.php');

// Installation wizard
if ( is_admin() ) {
	require_once(WTBX_INCLUDE . '/envato-setup/envato-setup-init.php');
	require_once(WTBX_INCLUDE . '/envato-setup/envato-setup.php');
}



add_filter('wtbx_theme_setup_wizard_username', 'wtbx_set_theme_setup_wizard_username', 10);
if( ! function_exists('wtbx_set_theme_setup_wizard_username') ){
	function wtbx_set_theme_setup_wizard_username($username){
		return 'Whitebox-Studio';
	}
}



add_filter('wtbx_theme_setup_wizard_oauth_script', 'wtbx_set_theme_setup_wizard_oauth_script', 10);
if( ! function_exists('wtbx_set_theme_setup_wizard_oauth_script') ){
	function wtbx_set_theme_setup_wizard_oauth_script($oauth_url){
		return '';
	}
}



if ( class_exists( 'ReduxFramework' ) && class_exists('SCAPE_Core_Extend') && !isset( $redux_demo ) ) {
	require_once( WTBX_INCLUDE . '/options.php' );
}



if ( ! function_exists( 'redux_disable_dev_mode_plugin' ) ) {
	function wtbx_redux_disable_dev_mode_plugin( $redux ) {
		if ( $redux->args['opt_name'] != 'redux_demo' ) {
			$redux->args['dev_mode'] = false;
			$redux->args['forced_dev_mode_off'] = false;
		}
	}
}
add_action( 'redux/construct', 'wtbx_redux_disable_dev_mode_plugin' );
add_filter( 'redux/wtbx_scape/aURL_filter', '__return_empty_string', 10 );



if (!function_exists('wtbx_option')) {
	function wtbx_option($var = '', $def = '') {
		global $wtbx_scape;

		if (empty($wtbx_scape)) {
			if ( is_multisite() ) {
				$wtbx_scape = get_blog_option( get_current_blog_id(), 'wtbx_scape' );
			} else {
				$wtbx_scape = get_option('wtbx_scape');
			}
		}

		if ( (isset($wtbx_scape[$var]) && $wtbx_scape[$var] === '0') || !empty($wtbx_scape[$var]) ) {
			return $wtbx_scape[$var];
		} else {
			return $def;
		}
	}
}



if (!function_exists('wtbx_option_sub')) {
	function wtbx_option_sub($var = '', $sub = '', $def = '') {
		global $wtbx_scape;

		if (empty($wtbx_scape)) {
			$wtbx_scape = get_option('wtbx_scape');
			if ( is_multisite() ) {
				$wtbx_scape = get_blog_option( get_current_blog_id(), 'wtbx_scape' );
			} else {
				$wtbx_scape = get_option('wtbx_scape');
			}
		}

		if ($sub) {
			if ( (isset($wtbx_scape[$var][$sub]) && $wtbx_scape[$var][$sub] === '0') || !empty($wtbx_scape[$var][$sub]) ) {
				return $wtbx_scape[$var][$sub];
			} else {
				return $def;
			}
		} else {
			if ( (isset($wtbx_scape[$var][$sub]) && $wtbx_scape[$var][$sub] === '0') || !empty($wtbx_scape[$var]) ) {
				return $wtbx_scape[$var];
			} else {
				return $def;
			}
		}

	}
}



add_action( 'vc_before_init', 'wtbx_set_vc_as_theme' );
function wtbx_set_vc_as_theme() {
	vc_set_as_theme();
}



if ( ! isset( $content_width ) ) {
	$content_width = wtbx_option('site-width', 1200);
}



if ( get_option('scape_generated_css') !== '1' ) {
	wtbx_add_default_options();
	update_option('scape_generated_css', '1');
}



function wtbx_add_default_options () {
	if ( !get_option('wtbx_scape') ) {
		require_once(WTBX_INCLUDE . '/envato-setup/default-options.php');
	}
	wtbx_generate_css();
}



// Add body classes
function wtbx_body_class($classes, $post_id) {

	$anim_disable = wtbx_option('site-disable-anim');
	$smartimages = wtbx_option('site-smartimage');
	$global_site_preloader = wtbx_option_levelled('preloader-site-style');

	if ( wtbx_demo() && 13 === get_the_ID() ) {
		$global_site_preloader = '1';
	}

	if ( $global_site_preloader !== '' ) { $smartimages = false; }

	// Add mobile class
	if ( class_exists('WTBX_Mobile_Detect') ) {
		$detect = new WTBX_Mobile_Detect;
		if ($detect->isMobile()) {
			$classes[] = 'device-mobile';
		} else {
			$classes[] = 'device-desktop';
		}
	} else {
		$classes[] = 'device-desktop';
	}

	// Add initialization class
	$classes[] = 'wtbx-page-init';

	// Add frontend editor mode class
	if ( wtbx_is_page_editable() ) { $classes[] = 'wtbx-frontend-editor'; }

	// Add maintenance page class
	if ( wtbx_maintenance() ) { $classes[] = 'maintenance-page'; }

	// Add animation disabling class
	if ( $anim_disable !== '' ) { $classes[] = 'anim_disable_' . $anim_disable; }

	// Add smart images class
	if ( !$smartimages ) { $classes[] = 'wtbx-smartimages-off'; }

	// Add theme version
	$classes[] = 'scape-ver-' . SCAPE_VERSION;

	// Add plugin version
	if ( class_exists('SCAPE_Core_Extend') ) {
		$classes[] = 'scape-core-ver-' . WTBX_PLUGIN_VERSION;
	}

	return $classes;
}

?>