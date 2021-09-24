<?php
/*
 * ReduxFramework Config File
 */

if ( ! class_exists( 'Redux' ) ) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "wtbx_scape";


/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

if ( ! function_exists( 'wtbx_options_notice_content' ) ) {
	function wtbx_options_notice_content() {
		$output  = '';

		$code = '';
		if ( get_option('scape_theme_id') ) {
			$item_id = get_option('scape_theme_id');
			$code = get_option('envato_purchase_code_' . $item_id);
		}

		$validated = !empty($code);

		if ( !$validated ) {
			$output .= '<div class="wtbx-activation-notice no-style is-dismissible clearfix">';
			$output .= '<span>' . esc_html__('Please activate your theme Purchase Code to get access to demo content, templates and other premium features.', 'scape') . '</span>';
			$output .= sprintf( '<a class="wtbx-admin-button button-green align-right" href="%s">%s</a>', esc_url( admin_url('admin.php?page=scape-dashboard') ), esc_html__('Activate License', 'scape') );
			$output .= '</div>';
		}

		return $output;
	}
}

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'submenu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__( 'Theme Options', 'scape' ),
    'page_title'           => esc_html__( 'Theme Options', 'scape' ),
    'intro_text'           => wtbx_options_notice_content(),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-admin-gener',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => false,
    // Enable basic customizer support
//    'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
//    'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => '1',
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'scape-dashboard',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => false,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => false,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);

Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */



/*
 * ---> START SECTIONS
 */

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'General Settings', 'scape' ),
	'id'               => 'main-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-gear'
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'General', 'scape' ),
	'id'               => 'main-general-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'site-width',
			'type'     => 'text',
			'title'    => esc_html__( 'Layout width', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Specify the maximum width of the website content. Units - <strong>px</strong>.', 'scape' )),
			'default'  => '1200'
		),
		array(
			'id'       => 'site-smoothscroll',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable smooth scroll in Chrome browser', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'site-disable-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Disable appearance animation', 'scape' ),
			'subtitle' => esc_html__( 'Disable the appearance effect for shortcodes', 'scape' ),
			'options'  => array(
				'tablet_landscape'  => esc_html__('Tablet Landscape and below', 'scape'),
				'tablet_portrait'   => esc_html__('Tablet Portrait and below', 'scape'),
				'mobile_landscape'  => esc_html__('Mobile Landscape and below', 'scape'),
				'mobile_portrait'   => esc_html__('Mobile Portrait and below', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Don\'t disable', 'scape')
		),
		array(
			'id'       => 'site-google-api',
			'type'     => 'text',
			'title'    => esc_html__( 'Google API key', 'scape' ),
			'subtitle' => esc_html__( 'Google API key is needed to update the list of available Google Fonts, and to be able to use Google Maps shortcode.', 'scape' ),
			'desc'     => wp_kses_post( __('The API key can be obtained for free - please read <a href="//developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">this</a> for how to get an API key.', 'scape')),
			'default'  => ''
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Images', 'scape' ),
	'id'               => 'main-images-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'site-image-sizes',
			'type'     => 'text',
			'title'    => esc_html__( 'Responsive image sizes', 'scape' ),
			'subtitle' => esc_html__( 'Enter the image sizes you want to use with responsive image system.', 'scape' ),
			'desc'     => wp_kses_post( __( 'Values must be comma separated. For more info on responsive images please refer to <a href="http://docs.whiteboxstud.io/scape/#3-images" target="_blank"></a>.', 'scape' )),
			'default'  => '180,450,750,1170,1440,1920',
		),
		array(
			'id'       => 'site-smartimage',
			'type'     => 'switch',
			'title'    => esc_html__( 'Image lazy-loading', 'scape' ),
			'subtitle' => esc_html__( 'Improves page load speed as images are loaded asynchronously.', 'scape' ),
			'desc'     => esc_html__( 'Will affect images that support lazy loading and for which lazy loading cannot be switched individually.', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'site-preloaders',
			'type'     => 'switch',
			'title'    => esc_html__( 'Image preloader animation', 'scape' ),
			'subtitle' => esc_html__( 'Animated preloader visible while image is loading.', 'scape' ),
			'desc'      => esc_html__( 'Will affect images that support lazy loading and for which lazy loading cannot be switched individually.', 'scape' ),
			'default'  => '1',
			'required' => array( 'site-smartimage', '=', '1' ),
		),
		array(
			'id'       => 'site-image-cdn',
			'type'     => 'text',
			'title'    => esc_html__( 'CDN url for images', 'scape' ),
			'subtitle' => esc_html__( 'Enter your CDN url if you are using CDN to serve images on your site.', 'scape' ),
			'default'  => '',
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Social Media', 'scape' ),
	'id'               => 'social-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => esc_html__( 'Enter links to your social media profiles to be used in social icons shortcode and widgets.', 'scape' ),
	'fields'           => wtbx_vc_social_networks_options()
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Custom code &amp; analytics', 'scape' ),
	'id'               => 'custom-code-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => esc_html__( 'Custom code which will be executed on pages. Useful for tracking, analytics and other tools.', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'custom-code-head',
			'type'     => 'ace_editor',
			'mode'     => 'javascript',
			'options'  => array(
				'minLines' => 20,
				'maxLines' => 40
			),
			'title'    => wp_kses_post( __( 'Code in <code>&lt;head&gt;</code>', 'scape' )),
			'subtitle' => wp_kses_post( __( 'This code will be placed right before the closing of <code>&lt;/head&gt;</code> tag. Useful for analytics and tracking code.', 'scape' )),
		),
		array(
			'id'       => 'custom-code-body-start',
			'type'     => 'ace_editor',
			'mode'     => 'javascript',
			'options'  => array(
				'minLines' => 20,
				'maxLines' => 40
			),
			'title'    => wp_kses_post( __( 'Code after <code>&lt;body&gt;</code> tag', 'scape' )),
			'subtitle' => wp_kses_post( __( 'This code will be placed immediately after the opening of <code>&lt;body&gt;</code> tag.', 'scape' )),
		),
		array(
			'id'       => 'custom-code-body-end',
			'type'     => 'ace_editor',
			'mode'     => 'javascript',
			'options'  => array(
				'minLines' => 20,
				'maxLines' => 40
			),
			'title'    => wp_kses_post( __( 'Code before <code>&lt;/body&gt;</code> tag', 'scape' )),
			'subtitle' => wp_kses_post( __( 'This code will be placed right before the closing of <code>&lt;/body&gt;</code> tag.', 'scape' )),
		),
		array(
			'id'       => 'gdpr-tracking-consent',
			'type'     => 'checkbox',
			'title'    => wp_kses_post( __('Code excluded by the <strong>Tracking</strong> consent.', 'scape' )),
			'desc'     => wp_kses_post( __('Tracking code inclusion/exclusion is controlled by the <strong>Tracking</strong> consent.', 'scape' )),
			'subtitle' => esc_html__( 'Select which custom code areas should not be used on the site unless a visitor gives his consent to share tracking data.', 'scape' ),
			'options'  => array(
				'code_in_head'     => wp_kses_post( __( 'Code in <code>&lt;head&gt;</code>', 'scape' )),
				'code_body_open'   => wp_kses_post( __( 'Code after <code>&lt;body&gt;</code> tag', 'scape' )),
				'code_body_close'  => wp_kses_post( __( 'Code before <code>&lt;/body&gt;</code> tag', 'scape' )),
			),
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Custom CSS', 'scape' ),
	'id'               => 'custom-css-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'custom-css',
			'type'     => 'ace_editor',
			'mode'     => 'css',
			'options'  => array(
				'minLines' => 30,
				'maxLines' => 50
			),
			'title'    => wp_kses_post( __( 'Enter your custom CSS code here', 'scape' )),
		)
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Custom post types', 'scape' ),
	'id'               => 'custom-post-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => esc_html__( 'For advanced users. If you are adding custom post types, you can add the "$post_type" parameters which you pass to "register_post_type()" function here. Separate options tab will then be generated for each custom post type, allowing to set Header, Hero Section, Layout and Footer options. For more information please refer to theme documentation.', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'custom-post-types',
			'type'     => 'multi_text',
			'title'    => wp_kses_post( __( 'Enter <code>$post_type</code> parameter string', 'scape' )),
			'subtitle' => esc_html__( 'E.g. "events", "works", etc.', 'scape' ),
		)
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header Settings', 'scape' ),
	'id'               => 'header-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-header'
) );

// Header style 1
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 1', 'scape' ),
	'id'               => 'header-style-1-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h1-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '1',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h1-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h1-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h1-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h1-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h1-bottombar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header bottom bar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h1-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h1-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h1-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h1-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h1-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h1-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => 'shadow_default_sticky',
		    'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h1-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h1-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h1-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h1-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h1-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h1-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h1-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h1-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h1-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h1-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'        => 'h1-bottombar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Bottom bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the bottom bar elements.', 'scape' ),
			'line-height'   => false
		),
		array(
			'id'       => 'h1-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h1-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
			    'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
			    'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-light-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h1-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
			    'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-dark-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h1-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h1-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h1-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h1-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h1-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h1-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h1-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 1 alt
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 1 (alt)', 'scape' ),
	'id'               => 'header-style-2-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h2-builder',
			'type'     => 'wtbx_menu_builder',
		    'style'    => '1',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h2-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h2-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h2-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h2-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h2-bottombar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header bottom bar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h2-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h2-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h2-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h2-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h2-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h2-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h2-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h2-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h2-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h2-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h2-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h2-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h2-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h2-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h2-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h2-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'        => 'h2-bottombar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Bottom bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the bottom bar elements.', 'scape' ),
			'line-height'   => false
		),
		array(
			'id'       => 'h2-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h2-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-light-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h2-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			)
		),
		array(
			'id'       => 'h2-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-dark-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h2-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h2-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h2-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h2-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h2-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h2-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h2-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 2
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 2', 'scape' ),
	'id'               => 'header-style-3-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h3-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '3',
			'default'  => array(
				'value' => '{"header":{"bottombar":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h3-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h3-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h3-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header top bar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h3-bottombar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header bottom bar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 40,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h3-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h3-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h3-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h3-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h3-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h3-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h3-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h3-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h3-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h3-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h3-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h3-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h3-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h3-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h3-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h3-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h3-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h3-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'   => false
		),
		array(
			'id'        => 'h3-bottombar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Bottom bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the bottom bar elements.', 'scape' ),
			'line-height'   => false
		),
		array(
			'id'       => 'h3-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h3-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-light-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h3-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-dark-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h3-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h3-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h3-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h3-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h3-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h3-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h3-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 2 alt
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 2 (alt)', 'scape' ),
	'id'               => 'header-style-4-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h4-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '3',
			'default'  => array(
				'value' => '{"header":{"bottombar":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h4-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h4-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h4-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header top bar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h4-bottombar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header bottom bar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 40,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h4-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h4-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h4-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h4-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h4-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h4-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h4-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h4-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h4-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h4-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h4-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h4-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h4-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h4-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h4-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h4-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h4-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h4-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'   => false
		),
		array(
			'id'        => 'h4-bottombar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Bottom bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the bottom bar elements.', 'scape' ),
			'line-height'   => false
		),
		array(
			'id'       => 'h4-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h4-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-light-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h4-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-dark-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h4-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h4-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h4-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h4-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h4-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h4-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h4-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 3
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 3', 'scape' ),
	'id'               => 'header-style-5-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h5-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '5',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h5-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h5-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h5-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h5-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h5-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h5-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h5-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h5-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h5-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h5-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h5-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h5-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h5-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h5-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h5-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h5-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h5-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h5-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h5-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h5-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h5-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h5-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h5-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h5-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h5-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h5-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h5-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h5-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h5-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h5-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h5-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 3 alt
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 3 (alt)', 'scape' ),
	'id'               => 'header-style-6-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h6-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '5',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h6-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h6-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h6-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h6-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h6-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h6-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h6-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h6-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h6-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h6-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h6-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h6-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h6-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h6-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h6-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h6-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h6-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h6-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h6-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h6-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h6-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h6-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h6-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h6-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h6-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h6-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h6-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h6-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h6-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h6-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h6-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 4
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 4', 'scape' ),
	'id'               => 'header-style-7-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h7-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '7',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","label":"","parent":"","nav":""}],"right_idle":[]}}'
			)
		),
		array(
			'id'       => 'h7-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h7-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h7-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 120,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h7-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h7-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h7-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h7-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h7-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h7-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h7-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h7-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h7-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h7-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h7-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h7-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h7-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h7-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h7-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h7-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'       => 'h7-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h7-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-visible-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Color of elements in the visible area', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-visible-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Hover color of elements in the visible area', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-light-visible-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Active color of elements in the visible area', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h7-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-visible-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Color of elements in the visible area', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-visible-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Hover color of elements in the visible area', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-dark-visible-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Active color of elements in the visible area', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h7-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h7-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h7-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h7-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h7-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h7-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h7-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 5
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 5', 'scape' ),
	'id'               => 'header-style-8-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h8-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '8',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h8-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h8-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h8-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h8-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h8-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h8-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h8-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h8-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h8-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h8-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h8-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h8-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h8-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h8-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h8-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h8-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h8-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h8-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h8-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h8-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h8-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h8-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h8-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h8-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h8-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h8-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h8-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h8-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h8-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h8-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h8-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 5 alt
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 5 (alt)', 'scape' ),
	'id'               => 'header-style-9-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h9-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '8',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h9-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h9-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h9-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h9-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h9-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h9-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h9-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h9-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h9-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h9-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h9-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h9-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h9-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h9-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h9-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h9-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h9-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h9-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h9-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h9-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h9-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h9-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h9-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h9-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h9-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h9-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h9-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h9-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h9-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h9-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h9-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 6
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 6', 'scape' ),
	'id'               => 'header-style-15-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h15-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '6',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h15-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h15-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h15-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 200,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h15-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h15-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h15-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h15-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h15-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h15-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h15-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h15-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h15-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h15-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h15-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h15-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h15-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h15-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h15-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h15-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h15-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h15-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h15-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h15-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			)
		),
		array(
			'id'       => 'h15-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h15-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h15-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h15-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h15-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h15-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h15-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h15-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h15-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 6 alt
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 6 (alt)', 'scape' ),
	'id'               => 'header-style-16-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h16-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '6',
			'default'  => array(
				'value' => '{"header":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h16-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h16-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h16-topbar-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header topbar height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 40,
			'min'           => 40,
			'step'          => 1,
			'max'           => 200,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h16-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 140,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h16-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h16-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h16-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h16-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'anim_1' => esc_html__('Underline style 1', 'scape'),
				'anim_2' => esc_html__('Underline style 2', 'scape'),
				'anim_3' => esc_html__('Line below', 'scape'),
				'anim_4' => esc_html__('Line above', 'scape'),
				'anim_5' => esc_html__('Rectangle container', 'scape'),
				'anim_10' => esc_html__('Rounded container', 'scape'),
				'anim_8' => esc_html__('Skewed container', 'scape'),
				'anim_6' => esc_html__('Vertical line below', 'scape'),
				'anim_7' => esc_html__('Vertical line above', 'scape'),
				'anim_9' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h16-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h16-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h16-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h16-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h16-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h16-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h16-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h16-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h16-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h16-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h16-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h16-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'        => 'h16-topbar-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Top bar font style', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top bar elements.', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'       => 'h16-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h16-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h16-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h16-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h16-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h16-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h16-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h16-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h16-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h16-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 7
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 7', 'scape' ),
	'id'               => 'header-style-10-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h10-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '10',
			'default'  => array(
				'value' => '{"overlay":{"main":[{"id":"menu","nav":""}]},"header":{}}'
			)
		),
		array(
			'id'       => 'h10-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h10-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h10-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h10-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h10-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h10-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h10-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h10-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Idle header font style', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'        => 'h10-overlay-top-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Overlay top section font style', 'scape' ),
		),
		array(
			'id'        => 'h10-overlay-middle-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Overlay middle section font style', 'scape' ),
		),
		array(
			'id'        => 'h10-overlay-footer-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Overlay footer font style', 'scape' ),
		),
		array(
			'id'       => 'h10-visible-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Idle header settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h10-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h10-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 120,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h10-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h10-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h10-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h10-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h10-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h10-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Idle header - light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h10-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Idle header - dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h10-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-overlay-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Overlay layer settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h10-overlay-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-overlay-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.6'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-overlay-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text hover color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-overlay-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h10-components-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h10-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h10-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h10-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h10-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h10-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h10-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 8
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 8', 'scape' ),
	'id'               => 'header-style-11-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h11-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '11',
			'default'  => array(
				'value' => '{"overlay":{"main":[{"id":"menu","nav":""}]},"header":{}}'
			)
		),
		array(
			'id'       => 'h11-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h11-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h11-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h11-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h11-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h11-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h11-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h11-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Idle header font style', 'scape' ),
			'line-height'       => false
		),
		array(
			'id'        => 'h11-overlay-top-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Overlay top section font style', 'scape' ),
		),
		array(
			'id'        => 'h11-overlay-middle-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Overlay middle section font style', 'scape' ),
		),
		array(
			'id'        => 'h11-overlay-footer-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Overlay footer font style', 'scape' ),
		),
		array(
			'id'       => 'h11-visible-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Idle header settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h11-layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header layout', 'scape' ),
			'options'  => array(
				'header-boxed'      => array(
					'alt'   => esc_html__('Boxed', 'scape'),
					'title' => esc_html__('Boxed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-boxed.png'
				),
				'header-contained'      => array(
					'alt'   => esc_html__('Contained', 'scape'),
					'title' => esc_html__('Contained', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-contained.png'
				),
				'header-fullwidth'      => array(
					'alt'   => esc_html__('Full-width', 'scape'),
					'title' => esc_html__('Full-width', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-fullwidth.png'
				),
			),
			'default'  => 'header-contained',
		),
		array(
			'id'            => 'h11-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 50,
			'step'          => 1,
			'max'           => 120,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h11-spacing-top',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra top padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space above the header.', 'scape' ),
			'units'    => array('px', '%'),
			'bottom'   => false,
			'left'     => false,
			'right'    => false,
			'default'  => array(
				'padding-top'    => '0',
			)
		),
		array(
			'id'       => 'h11-spacing-side',
			'type'     => 'dimensions',
			'height'   => false,
			'title'    => esc_html__( 'Extra side padding', 'scape' ),
			'desc'     => esc_html__( 'Add extra space on the left and right side of the header.', 'scape' ),
			'units'    => array('px', '%'),
		),
		array(
			'id'       => 'h11-borders-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header bottom border', 'scape' ),
			'subtitle' => esc_html__( 'Add horizontal border at the bottom of the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h11-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h11-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'h11-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Idle header - light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h11-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Idle header - dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h11-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-overlay-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Overlay layer settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h11-overlay-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-overlay-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.6'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-overlay-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text hover color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-overlay-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h11-components-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h11-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h11-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h11-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h11-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h11-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h11-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Header style 9
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 9', 'scape' ),
	'id'               => 'header-style-12-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h12-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '12',
			'default'  => array(
				'value' => '{"main":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h12-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'            => 'h12-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header width', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 280,
			'min'           => 140,
			'step'          => 1,
			'max'           => 450,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h12-shadow',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'h12-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'side_anim_1' => esc_html__('Left border', 'scape'),
				'side_anim_2' => esc_html__('Left line', 'scape'),
				'side_anim_3' => esc_html__('Left dot', 'scape'),
				'side_anim_4' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h12-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h12-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h12-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h12-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h12-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h12-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h12-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h12-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h12-main-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header main section font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header main section elements.', 'scape' ),
		),
		array(
			'id'        => 'h12-footer-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header footer section font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header footer section elements.', 'scape' ),
		),
		array(
			'id'       => 'h12-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'       => 'h12-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h12-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h12-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h12-components-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h12-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h12-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h12-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h12-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h12-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h12-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		)
	)
) );

// Header style 10
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 10', 'scape' ),
	'id'               => 'header-style-13-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h13-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '13',
			'default'  => array(
				'value' => '{"main":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h13-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'            => 'h13-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header width', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 280,
			'min'           => 140,
			'step'          => 1,
			'max'           => 450,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h13-shadow',
			'type'     => 'switch',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'h13-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'side_anim_1' => esc_html__('Left border', 'scape'),
				'side_anim_2' => esc_html__('Left line', 'scape'),
				'side_anim_3' => esc_html__('Left dot', 'scape'),
				'side_anim_4' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h13-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h13-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h13-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h13-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h13-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h13-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h13-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h13-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h13-main-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header main section font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header main section elements.', 'scape' ),
		),
		array(
			'id'        => 'h13-footer-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header footer section font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header footer section elements.', 'scape' ),
		),
		array(
			'id'       => 'h13-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'       => 'h13-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h13-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h13-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h13-components-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h13-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h13-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h13-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h13-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h13-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h13-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		)
	)
) );

// Header style 11
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header style 11', 'scape' ),
	'id'               => 'header-style-14-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look and contents of the header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h14-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => '13',
			'default'  => array(
				'value' => '{"main":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'h14-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'            => 'h14-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header width', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 280,
			'min'           => 140,
			'step'          => 1,
			'max'           => 450,
			'display_value' => 'text'
		),
		array(
			'id'            => 'h14-trigger-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header trigger bar width', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'min'           => 30,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h14-menu-anim',
			'type'     => 'select',
			'title'    => esc_html__( 'Menu animation style', 'scape' ),
			'options'  => array(
				'side_anim_1' => esc_html__('Left border', 'scape'),
				'side_anim_2' => esc_html__('Left line', 'scape'),
				'side_anim_3' => esc_html__('Left dot', 'scape'),
				'side_anim_4' => esc_html__('Filled background', 'scape'),
			),
			'default'  => ''
		),
		array(
			'id'       => 'h14-mobile-breakpoint',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Mobile header breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to mobile header if the window is under this width/height. Units - <strong>px</strong>.', 'scape' )),
			'default'  => array(
				'width'   => '768',
				'height'  => ''
			),
		),
		array(
			'id'       => 'h14-typography-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'h14-main-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header main section font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header main section elements.', 'scape' ),
		),
		array(
			'id'        => 'h14-footer-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header footer section font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the header footer section elements.', 'scape' ),
		),
		array(
			'id'       => 'h14-icon',
			'type'      => 'wtbx_typography',
			'title'    => esc_html__( 'Header menu icon size', 'scape' ),
			'subtitle' => esc_html__( 'Specify size of the icons which are displayed next to menu items in header.', 'scape' ),
			'font-family'       => false,
			'backup-family'     => false,
			'weight-style'      => false,
			'transform'         => false,
			'letter-spacing'    => false,
			'subsets'           => false,
			'line-height'       => false,
			'preview'           => false
		),
		array(
			'id'       => 'h14-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h14-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for header.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h14-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h14-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h14-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h14-trigger-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Trigger logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h14-trigger-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light trigger skin.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h14-trigger-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark trigger skin.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h14-trigger-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h14-trigger-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h14-trigger-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h14-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Trigger - light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h14-light-trigger-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger bar background color', 'scape' ),
			'default'  => array(
				'color' => '#f9f9f9',
				'alpha' => '1'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-light-trigger-hover-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger bar background hover color', 'scape' ),
			'default'  => array(
				'color' => '#f1f1f1',
				'alpha' => '1'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-light-trigger-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger button color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-light-trigger-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger button hover color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Trigger - dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h14-dark-trigger-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger bar background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-dark-trigger-hover-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger bar background hover color', 'scape' ),
			'default'  => array(
				'color' => '#111111',
				'alpha' => '1'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-dark-trigger-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger button color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-dark-trigger-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Trigger button hover color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-colors-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Header colors', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h14-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-header-backdrop',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Backdrop color', 'scape' ),
			'default'  => array(
				'color' => '#000000',
				'alpha' => '1',
				'rgba'  => 'rgba(0,0,0,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h14-components-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h14-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'h14-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h14-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'h14-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'h14-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'h14-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		)
	)
) );


// Sticky header
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Sticky header', 'scape' ),
	'id'               => 'header-sticky-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look of sticky header', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'h-sticky-general-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'General settings', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'            => 'h-sticky-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Sticky header main section height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'default'       => 70,
			'step'          => 1,
			'min'           => 50,
			'max'           => 120,
			'display_value' => 'text'
		),
		array(
			'id'       => 'h-sticky-topbar',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show top bar in sticky header', 'scape' ),
			'subtitle' => esc_html__( 'Will only be shown if top bar is enabled for the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h-sticky-bottombar',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show bottom bar in sticky header', 'scape' ),
			'subtitle' => esc_html__( 'Will only be shown if bottom bar is enabled for the header.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'h-sticky-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h-sticky-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for light sticky header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h-sticky-logo-image-dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark style logo', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for dark sticky header style.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'h-sticky-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'h-sticky-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h-sticky-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'h-sticky-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h-sticky-light-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ebebf5',
				'alpha' => '1',
				'rgba'  => 'rgba(236, 240, 243,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-light-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'h-sticky-dark-header-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'default'  => array(
				'color' => '#212121',
				'alpha' => '1',
				'rgba'  => 'rgba(33,33,33,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '0.1',
				'rgba'  => 'rgba(255,255,255,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-header-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-header-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-header-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-topbar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-topbar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-topbar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-topbar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Top bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-bottombar-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar background color', 'scape' ),
			'default'  => array(
				'color' => '#1d1d1d',
				'alpha' => '1',
				'rgba'  => 'rgba(29,29,29,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-bottombar-text-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text color', 'scape' ),
			'default'  => array(
				'color' => '#636363',
				'alpha' => '1',
				'rgba'  => 'rgba(99,99,99,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-bottombar-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar text hover/active color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'h-sticky-dark-bottombar-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Bottom bar elements accent color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Submenu', 'scape' ),
	'id'               => 'menu-general-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'sm-colors-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Colors', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'sm-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Submenu background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'sm-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Submenu link color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'sm-color-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Submenu link hover color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'sm-color-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Submenu link active color', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'sm-color-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Submenu link hover background color', 'scape' ),
			'default'  => array(
				'color' => '#f7f8fd',
				'alpha' => '1',
				'rgba'  => 'rgba(249,250,251,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'sm-color-megaheading',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Megamenu column heading color', 'scape' ),
			'default'  => array(
				'color' => '#151221',
				'alpha' => '1',
				'rgba'  => 'rgba(45,53,67,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'sm-typography-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'sm-link-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Submenu link font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the submenu link.', 'scape' ),
		),
		array(
			'id'        => 'sm-megamenu-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Megamenu column heading font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the megamenu heading.', 'scape' ),
		),
	)
) );

// Header overlay
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header overlay panel', 'scape' ),
	'id'               => 'header-overlay-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look of header overlay', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'ho-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background color', 'scape' ),
			'default'  => array(
				'color' => '#000000',
				'alpha' => '.95',
				'rgba'  => 'rgba(0,0,0,.95)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'ho-skin',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Color skin', 'scape' ),
			'subtitle' => esc_html__( 'Based on the background color.', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'dark',
		),
		array(
			'id'       => 'ho-content',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the header overlay panel.', 'scape' ),
		),
	)
) );

// Sidearea
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Side area panel', 'scape' ),
	'id'               => 'header-sidearea-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look of header sidearea panel', 'scape' ),
	'fields'           => array(
		array(
			'id'            => 'hs-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Side area width', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Set the width of the side area. Units - <strong>px</strong>.', 'scape' )),
			'default'       => 340,
			'min'           => 200,
			'step'          => 1,
			'max'           => 600,
			'display_value' => 'text'
		),
		array(
			'id'       => 'hs-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background color', 'scape' ),
			'default'  => array(
				'color' => '#1b1c1f',
				'alpha' => '1',
				'rgba'  => 'rgba(27,28,31,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'hs-skin',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Color skin', 'scape' ),
			'subtitle' => esc_html__( 'Based on the background color.', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'dark',
		),
		array(
			'id'       => 'hs-content',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the header overlay panel.', 'scape' ),
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Search panel', 'scape' ),
	'desc'         => esc_html__( 'Offscreen search overlay panel.', 'scape' ),
	'id'               => 'search-panel-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'search-form-post-types',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Post types displayed in search form dropdown', 'scape' ),
			'subtitle' => esc_html__( 'Uncheck all to disable dropdown.', 'scape' ),
			'data'     => 'post_types',
		),
		array(
			'id'       => 'search-panel-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Panel background color', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'search-panel-skin',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Panel color skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light',
		),
		array(
			'id'       => 'search-panel-content',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert below the search field.', 'scape' ),
		),
		array(
			'id'        => 'search-panel-content-hide',
			'type'      => 'dimensions',
			'units'     => false,    // You can specify a unit value. Possible: px, em, %
			'title'     => esc_html__( 'Content block display breakpoint', 'scape' ),
			'subtitle'  => esc_html__( 'Hide content block under this screen width or height.', 'scape' ),
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Mobile navigation', 'scape' ),
	'id'               => 'mobile-menu-tab',
	'subsection'       => true,
	'customizer_width' => '600px',
	'desc'             => esc_html__( 'Set the look of main mobile navigation', 'scape' ),
	'fields'           => array(
		array(
			'id'       => 'hm-builder',
			'type'     => 'wtbx_menu_builder',
			'style'    => 'mobile',
			'default'  => array(
				'value' => '{"top_header":{"right":[]},"main":{"main":[{"id":"menu","nav":""}]}}'
			)
		),
		array(
			'id'       => 'hm-logo-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Logo', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'hm-logo-image-light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Logo file', 'scape' ),
			'subtitle' => esc_html__( 'Upload logo image file for the mobile top header.', 'scape' ),
			'desc'     => esc_html__( 'Upload at least a @2x logo size image for proper display on high pixel density displays. Image will be resized on the frontend automatically.', 'scape' ),
		),
		array(
			'id'       => 'hm-logo-size',
			'type'     => 'dimensions',
			'units'    => false,
			'title'    => esc_html__( 'Logo size', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
			'desc'     => esc_html__( 'This field is mandatory. Logo will not be displayed if it\'s left empty.', 'scape' ),
		),
		array(
			'id'       => 'hm-logo-offset-top',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo top offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'hm-logo-offset-left',
			'type'     => 'text',
			'title'    => esc_html__( 'Logo left offset', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Units - <strong>px</strong>.', 'scape' )),
		),
		array(
			'id'       => 'hm-top-start',
			'type'     => 'wtbx_toggle',
			'title'         => esc_html__( 'Top header', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'hm-sticky',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sticky mobile header style', 'scape' ),
			'options'  => array(
				'disabled'  => esc_html__( 'Disabled', 'scape' ),
				'default'   => esc_html__( 'Default', 'scape' ),
				'scroll'    => esc_html__( 'On scroll up', 'scape' )
			),
			'default'  => 'disabled',
		),
//		array(
//			'id'       => 'hm-design',
//			'type'     => 'button_set',
//			'title'    => esc_html__( 'Mobile header style', 'scape' ),
//			'options'  => array(
//				''  => esc_html__( 'Default', 'scape' ),
//				'slide'   => esc_html__( 'Sliding from top', 'scape' ),
//				'bubble'    => esc_html__( 'Bubble fullscreen', 'scape' )
//			),
//			'default'  => '',
//		),
		array(
			'id'            => 'hm-height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Header height', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Set the height of the header. Units - <strong>px</strong>.', 'scape' )),
			'default'       => 60,
			'min'           => 50,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		),
		array(
			'id'       => 'hm-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header background color', 'scape' ),
			'subtitle' => esc_html__( 'Specify background color of the top header.', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'hm-text',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons color', 'scape' ),
			'subtitle' => esc_html__( 'Specify color of the header text and icons.', 'scape' ),
			'default'  => array(
				'color' => '#223350',
				'alpha' => '1',
				'rgba'  => 'rgba(34,51,80,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'hm-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header elements accent color', 'scape' ),
			'subtitle' => esc_html__( 'Specify  active color of the header text and icons.', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'hm-borders-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'default'  => array(
				'color' => '#000000',
				'alpha' => '0.1',
				'rgba'  => 'rgba(0,0,0,.1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'        => 'hm-header-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Header font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the top mobile header font.', 'scape' ),
		),
		array(
			'id'       => 'hm-shadow',
			'type'     => 'select',
			'title'    => esc_html__( 'Header shadow', 'scape' ),
			'options'  => array(
				'shadow_default' => esc_html__('On default state', 'scape'),
				'shadow_sticky' => esc_html__('On sticky state', 'scape'),
				'shadow_default_sticky' => esc_html__('On default and sticky state', 'scape'),
			),
			'default'  => '',
			'placeholder' => esc_html__('Disable', 'scape')
		),
		array(
			'id'       => 'hm-side-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Side navigation', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'            => 'hm-s-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Width of side navigation', 'scape' ),
			'subtitle'      => wp_kses_post( __( 'Set width of the side navigation. Units - <strong>px</strong>.', 'scape' )),
			'default'       => 290,
			'min'           => 200,
			'step'          => 1,
			'max'           => 375,
			'display_value' => 'text'
		),
		array(
			'id'       => 'hm-side-skin',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Color skin', 'scape' ),
			'subtitle' => esc_html__( 'Based on the background color.', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light',
		),
		array(
			'id'       => 'hm-s-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background color', 'scape' ),
			'subtitle' => esc_html__( 'Specify background color of the top header.', 'scape' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => '1',
			    'rgba'  => 'rgba(255,255,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'hm-s-text',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Header text & icons color', 'scape' ),
			'subtitle' => esc_html__( 'Specify color of the header text and icons.', 'scape' ),
			'default'  => array(
				'color' => '#223350',
				'alpha' => '1',
				'rgba'  => 'rgba(34,51,80,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'hm-s-text-active',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Active menu items highlight color', 'scape' ),
			'subtitle' => esc_html__( 'Specify active color of the header text and icons.', 'scape' ),
			'default'  => array(
				'color' => '#8571ea',
				'alpha' => '1',
				'rgba'  => 'rgba(108,99,255,1)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'        => 'hm-s-font',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Side navigation font', 'scape' ),
			'subtitle'  => esc_html__( 'Specify font properties for the side navigation font.', 'scape' ),
		),
		array(
			'id'       => 'hm-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'hm-text-info',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Text info element content', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Content of the <strong>Text info</strong> element.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'hm-button-primary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'hm-button-primary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Primary button link', 'scape' ),
		),
		array(
			'id'       => 'hm-button-secondary-text',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button text', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'hm-button-secondary-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Secondary button link', 'scape' ),
		),
		array(
			'id'       => 'hm-content-block',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert into the "Content Block" component.', 'scape' ),
		),
	)
) );

// Page Settings
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Page settings', 'scape' ),
	'id'               => 'page-layout-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-layout'
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Header navigation', 'scape' ),
	'desc'             => esc_html__( 'Global header options.', 'scape' ),
	'id'               => 'header-general-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'header-style-global',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header style', 'scape' ),
			'options'  => array(
				'off'      => array(
					'alt'   => esc_html__('No header', 'scape'),
					'title' => esc_html__('No header', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/disable.png'
				),
				'1'      => array(
					'alt'   => esc_html__('Default', 'scape'),
					'title' => esc_html__('Style 1', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-1.png'
				),
				'2'      => array(
					'alt'   => esc_html__('Default - transparent', 'scape'),
					'title' => esc_html__('Style 1 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-2.png'
				),
				'3'      => array(
					'alt'   => esc_html__('Menu bottom', 'scape'),
					'title' => esc_html__('Style 2', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-3.png'
				),
				'4'      => array(
					'alt'   => esc_html__('Menu bottom - transparent', 'scape'),
					'title' => esc_html__('Style 2 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-4.png'
				),
				'5'      => array(
					'alt'   => esc_html__('Logo in center', 'scape'),
					'title' => esc_html__('Style 3', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-5.png'
				),
				'6'      => array(
					'alt'   => esc_html__('Logo in center - transparent', 'scape'),
					'title' => esc_html__('Style 3 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-6.png'
				),
				'7'      => array(
					'alt'   => esc_html__('Slide in from top', 'scape'),
					'title' => esc_html__('Style 4', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-7.png'
				),
				'8'      => array(
					'alt'   => esc_html__('Menu centered', 'scape'),
					'title' => esc_html__('Style 5', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-8.png'
				),
				'9'      => array(
					'alt'   => esc_html__('Menu centered - transparent', 'scape'),
					'title' => esc_html__('Style 5 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-9.png'
				),
				'15'      => array(
					'alt'   => esc_html__('Logo and menu centered', 'scape'),
					'title' => esc_html__('Style 6', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-15.png'
				),
				'16'      => array(
					'alt'   => esc_html__('Logo and menu centered - transparent', 'scape'),
					'title' => esc_html__('Style 6 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-16.png'
				),
				'10'      => array(
					'alt'   => esc_html__('Overlay - centered button', 'scape'),
					'title' => esc_html__('Style 7', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-10.png'
				),
				'11'      => array(
					'alt'   => esc_html__('Overlay - right-aligned button', 'scape'),
					'title' => esc_html__('Style 8', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-11.png'
				),
				'12'      => array(
					'alt'   => esc_html__('Left centered', 'scape'),
					'title' => esc_html__('Style 9', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-12.png'
				),
				'13'      => array(
					'alt'   => esc_html__('Left', 'scape'),
					'title' => esc_html__('Style 10', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-13.png'
				),
				'14'      => array(
					'alt'   => esc_html__('Left hidden', 'scape'),
					'title' => esc_html__('Style 11', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-14.png'
				),
			),
			'default'  => '1'
		),
		array(
			'id'       => 'header-skin-global',
			'type'     => 'select',
			'title'    => esc_html__( 'Header skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark' => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light'
		),
		array(
			'id'       => 'sticky-style-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sticky header style', 'scape' ),
			'options'  => array(
				'disabled'  => esc_html__( 'Disabled', 'scape' ),
				'default'   => esc_html__( 'Default', 'scape' ),
				'scroll'    => esc_html__( 'On scroll up', 'scape' )
			),
			'default'  => 'disabled',
		),
		array(
			'id'       => 'sticky-skin-global',
			'type'     => 'select',
			'title'    => esc_html__( 'Sticky header skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark' => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light'
		),
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Hero section', 'scape' ),
	'desc'             => esc_html__( 'Global hero section options.', 'scape' ),
	'id'               => 'header-section-general',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'header-section-general-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'General', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'header-section-global',
			'type'     => 'select',
			'title'    => esc_html__( 'Hero section', 'scape' ),
			'options'  => array(
				'default'       => esc_html__( 'Default', 'scape' ),
				'content_block' => esc_html__( 'Content block', 'scape' ),
			),
			'default'       => 'default',
			'placeholder'   => esc_html__( 'Disable', 'scape' ),
		),
		array(
			'id'       => 'header-section-block-global',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Only for content block hero section type.', 'scape' ),
			'desc' => esc_html__( 'Choose a content block to insert as a page hero section.', 'scape' ),
		),
		array(
			'id'       => 'header-section-layout-global',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Hero section layout', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			'options'  => array(
				'one'      => array(
					'alt'   => esc_html__('Centered', 'scape'),
					'title' => esc_html__('Layout 1', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-1.png'
				),
				'two'      => array(
					'alt'   => esc_html__('Centered, bottom-aligned breadcrumbs', 'scape'),
					'title' => esc_html__('Layout 2', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-2.png'
				),
				'three'      => array(
					'alt'   => esc_html__('Left-aligned', 'scape'),
					'title' => esc_html__('Layout 3', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-3.png'
				),
				'four'      => array(
					'alt'   => esc_html__('Right-aligned', 'scape'),
					'title' => esc_html__('Layout 4', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-4.png'
				),
				'five'      => array(
					'alt'   => esc_html__('Left-aligned separated', 'scape'),
					'title' => esc_html__('Layout 5', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-5.png'
				),
				'six'      => array(
					'alt'   => esc_html__('Right-aligned separated', 'scape'),
					'title' => esc_html__('Layout 6', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-6.png'
				),
			),
			'default'  => 'five',
		),
		array(
			'id'            => 'header-section-height-slider-global',
			'type'          => 'slider',
			'title'         => esc_html__( 'Relative height', 'scape' ),
			'desc'          => wp_kses_post( __( 'Height as percentage of screen size. Set to <code>0</code> to disable.', 'scape' )),
			'default'       => 0,
			'min'           => 0,
			'step'          => 1,
			'max'           => 100,
			'resolution'    => 1,
			'display_value' => 'label',
			'subtitle'      => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-height-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Min. height', 'scape' ),
			'desc'     => esc_html__( 'Minimum height in pixels. Leave empty to disable.', 'scape' ),
			'default'  => '200',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-padding-top-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Additional top padding', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-padding-bottom-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Additional bottom padding', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-background-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Background', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'header-section-bg-image-global',
			'type'     => 'background',
			'url'      => true,
			'title'    => esc_html__( 'Background', 'scape' ),
			'default'  => array(
				'background-color' => '#f7f8fd'
			),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-bg-featured-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Use featured image', 'scape' ),
			'subtitle' => esc_html__( 'Use featured image for each single post/page/product etc. Only for default hero section type.', 'scape' ),
			'desc'     => esc_html__( 'If switched on, will override the background image.', 'scape' ),
			'options'  => array(
				'on'   => esc_html__( 'Yes', 'scape' ),
				'off'  => esc_html__( 'No', 'scape' ),
			),
			'default'  => 'off',
		),
		array(
			'id'       => 'header-section-bg-lazy',
			'type'     => 'select',
			'title'    => esc_html__( 'Enable lazy background image loading', 'scape' ),
			'options'  => array(
				'1'     => esc_html__( 'Enable', 'scape' ),
				'0'     => esc_html__( 'Disable', 'scape' )
			),
			'placeholder'  => esc_html__( 'Default theme setting', 'scape' ),
			'desc'      => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'scape'),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-overlay-color-global',
			'type'      => 'color_rgba',
			'title'    => esc_html__( 'Overlay color', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
		),
		array(
			'id'       => 'header-section-decoration-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Effects &amp; decoration', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'header-section-scroll-full-global',
			'type'     => 'switch',
			'title'    => esc_html__( 'Full hero section scroll', 'scape' ),
			'desc'     => esc_html__( 'If enabled, hero section will be fully scrolled down on first user scroll event.', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-parallax-global',
			'type'     => 'select',
			'title'    => esc_html__( 'Image parallax effect', 'scape' ),
			'options'  => array(
				'wtbx_parallax_scroll'       => esc_html__( 'Scroll parallax', 'scape' ),
				'wtbx_parallax_mousemove'    => esc_html__( 'Mouse move parallax', 'scape' )
			),
			'default'  => '',
			'placeholder' => esc_html__('None', 'scape'),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'            => 'header-section-parallax-strength-global',
			'type'          => 'slider',
			'title'         => esc_html__( 'Parallax effect strength', 'scape' ),
			'default'       => 2,
			'min'           => 0,
			'step'          => 1,
			'max'           => 10,
			'resolution'    => 1,
			'display_value' => 'label',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-fadeout-global',
			'type'     => 'switch',
			'title'    => esc_html__( 'Content fadeout effect', 'scape' ),
			'desc'     => esc_html__( 'If enabled, hero section content will shift and fade out as the user scrolls down.', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-decoration-layout-global',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Bottom decoration', 'scape' ),
			'options'  => array(
				''      => array(
					'alt'   => esc_html__('None', 'scape'),
					'title' => esc_html__('None', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-none.png'
				),
				'curve-top'      => array(
					'alt'   => esc_html__('Curve top', 'scape'),
					'title' => esc_html__('Curve top', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-curve-top.png'
				),
				'curve-bottom'      => array(
					'alt'   => esc_html__('Curve bottom', 'scape'),
					'title' => esc_html__('Curve bottom', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-curve-bottom.png'
				),
				'notch-bottom'      => array(
					'alt'   => esc_html__('Notch', 'scape'),
					'title' => esc_html__('Notch', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-notch.png'
				),
				'notch-top'      => array(
					'alt'   => esc_html__('Notch reversed', 'scape'),
					'title' => esc_html__('Notch reversed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-notch-reversed.png'
				),
				'waves-1'      => array(
					'alt'   => esc_html__('Waves 1', 'scape'),
					'title' => esc_html__('Waves 1', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-waves-1.png'
				),
				'waves-2'      => array(
					'alt'   => esc_html__('Waves 2', 'scape'),
					'title' => esc_html__('Waves 2', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-waves-2.png'
				),
			),
			'default'  => '',
		),
		array(
			'id'       => 'header-section-decoration-color-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Decoration color', 'scape' ),
			'desc' => esc_html__( 'You may want to match it with the background of your page of the first row on it.', 'scape' ),
			'default'  => '#ffffff',
		),
		array(
			'id'       => 'header-section-scrolldown-style-global',
			'type'     => 'select',
			'title'    => esc_html__( '"Scroll-down" button', 'scape' ),
			'options'  => array(
				'arrow-single'      => esc_html__( 'Arrow down', 'scape' ),
				'angle-down'        => esc_html__( 'Angle down in circle', 'scape' ),
				'angle-down-cont'   => esc_html__( 'Angle down in round container', 'scape' ),
				'mouse-simple'      => esc_html__( 'Mouse icon', 'scape' ),
			),
			'default'       => '',
			'placeholder'   => esc_html__( 'Disable', 'scape' ),
		),
		array(
			'id'       => 'header-section-scrolldown-skin-global',
			'type'     => 'button_set',
			'title'    => esc_html__( '"Scroll-down" button skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light'
		),
		array(
			'id'       => 'header-section-typography-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Typography', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'header-section-bc-enable-global',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable breadcrumbs', 'scape' ),
			'default'  => '1',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'        => 'header-section-title-global',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Title font style', 'scape' ),
			'default'  => array(
				'typography' => '{"font_family":"","backup_family":"","variants":"500","subsets":"","transform":"","font_size":"24px","line_height":"","letter_spacing":""}',
			),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'        => 'header-section-bc-global',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Breadcrumbs font', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-skin-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Hero section content skin', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'dark',
		),
		array(
			'id'       => 'header-section-title-color-light-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Title and content color (light skin)', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			'default'  => '#ffffff',
		),
		array(
			'id'       => 'header-section-bc-link-color-light-global',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Breadcrumb link color (light skin)', 'scape' ),
			'active'   => false,
			'visited'  => false,
			'default'  => array(
				'regular'  => '#c1c1c1',
				'hover'    => '#ffffff',
			),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-bc-separator-color-light-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Breadcrumb separator color (light skin)', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-title-color-dark-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Title and content color (dark skin)', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			'default'  => '#151221',
		),
		array(
			'id'       => 'header-section-bc-link-color-dark-global',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Breadcrumb link color (dark skin)', 'scape' ),
			'active'   => false,
			'visited'  => false,
			'default'  => array(
				'regular'  => '',
				'hover'    => '#151221',
			),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-bc-separator-color-dark-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Breadcrumb separator color (dark skin)', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-bc-separator',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Breadcrumbs separator', 'scape' ),
			'options'  => array(
				'slash'     => esc_html__( 'Slash', 'scape' ),
				'angle'     => esc_html__( 'Angle', 'scape' ),
				'circle'    => esc_html__( 'Circle', 'scape' ),
			),
			'default'  => 'slash',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
	)
) );

// Page Layout
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Layout', 'scape' ),
	'desc'             => esc_html__( 'Global page layout options.', 'scape' ),
	'id'               => 'page-layout-general-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'page-layout-fullwidth-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Layout width', 'scape' ),
			'options'  => array(
				'width-default' => esc_html__( 'Default site width', 'scape' ),
				'width-full'    => esc_html__( 'Full page width', 'scape' ),
			),
			'default'  => 'width-default'
		),
		array(
			'id'       => 'page-layout-width-limit-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Content width limit', 'scape' ),
			'subtitle' => esc_html__( 'Only for default site width.', 'scape' ),
			'desc'     => wp_kses_post( __( 'Units - <code>px</code>.', 'scape' )),
		),
		array(
			'id'       => 'page-layout-space-global',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra page padding', 'scape' ),
			'desc'     => wp_kses_post( __( 'Add extra space around the page content. Units - <code>px</code>.', 'scape' )),
			'units'    => 'px',
			'default'  => array(
				'padding-top'    => '0',
				'padding-right'  => '0',
				'padding-bottom' => '0',
				'padding-left'   => '0'
			)
		),
		array(
			'id'       => 'page-layout-content-bg-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Page background color', 'scape' ),
		),
		array(
			'id'       => 'page-layout-content-padding-top-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Content top padding', 'scape' ),
			'desc'     => wp_kses_post( __( 'Units - <code>px</code>.', 'scape' )),
			'default'  => '60',
		),
		array(
			'id'       => 'page-layout-content-padding-bottom-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Content bottom padding', 'scape' ),
			'desc'     => wp_kses_post( __( 'Units - <code>px</code>.', 'scape' )),
			'default'  => '60',
		),
		array(
			'id'       => 'page-layout-global',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Page layout', 'scape' ),
			'options'  => array(
				'no_sidebar'      => array(
					'alt'   => esc_html__( 'No sidebar', 'scape' ),
					'title' => esc_html__('Full width content', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-no-sidebar.png'
				),
				'sidebar_left'      => array(
					'alt'   => esc_html__( 'Left sidebar', 'scape' ),
					'title' => esc_html__('Left sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-left-sidebar.png'
				),
				'sidebar_left_sticky'      => array(
					'alt'   => esc_html__( 'Left sticky sidebar', 'scape' ),
					'title' => esc_html__('Left sticky sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-left-sticky-sidebar.png'
				),
				'sidebar_right'      => array(
					'alt'   => esc_html__('Right sidebar', 'scape'),
					'title' => esc_html__('Right sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-right-sidebar.png'
				),
				'sidebar_right_sticky'      => array(
					'alt'   => esc_html__('Right sticky sidebar', 'scape'),
					'title' => esc_html__('Right sticky sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-right-sticky-sidebar.png'
				),
			),
			'default'  => 'no_sidebar',
		),
		array(
			'id'            => 'page-layout-sidebar-width-slider-global',
			'type'          => 'slider',
			'title'         => esc_html__( 'Sidebar width', 'scape' ),
			'subtitle'      => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'default'       => 340,
			'min'           => 1,
			'step'          => 1,
			'max'           => 500,
			'resolution'    => 1,
			'display_value' => 'text',
		),
		array(
			'id'       => 'page-layout-sidebar-padding-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Sidebar top padding', 'scape' ),
			'subtitle' => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'desc'     => wp_kses_post( __( 'Use this to make sidebar content start at the same level as the main page content. Units - <code>px</code>.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'page-layout-sidebar-skin-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sidebar content skin', 'scape' ),
			'subtitle' => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light',
		),
		array(
			'id'       => 'page-layout-sidebar-widgetarea-global',
			'type'     => 'select',
			'title'    => esc_html__( 'Sidebar to use', 'scape' ),
			'subtitle' => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'data'     => 'callback',
			'args'     => 'wtbx_sidebars_array_ext',
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'        => 'page-layout-sidebar-font-size-global',
			'type'      => 'wtbx_typography',
			'font-family'       => false,
			'backup-family'     => false,
			'subsets'           => false,
			'weight-style'      => false,
			'line-height'       => false,
			'letter-spacing'    => false,
			'transform'         => false,
			'preview'           => false,
			'title'     => esc_html__( 'Sidebar base font size', 'scape' ),
			'subtitle'  => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
		),
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Footer', 'scape' ),
	'desc'             => esc_html__( 'Global footer options.', 'scape' ),
	'id'               => 'footer-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'footer-general-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'General', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'footer-enable-global',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable footer', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'footer-block-global',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert as a footer.', 'scape' ),
		),
		array(
			'id'       => 'footer-style-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Footer style', 'scape' ),
			'options'  => array(
				'default'   => esc_html__('Default', 'scape'),
				'under'     => esc_html__('Underlying', 'scape')
			),
			'default'  => 'default'
		),
		array(
			'id'       => 'footer-breakpoint-global',
			'type'     => 'text',
			'title'    => esc_html__( 'Underlying footer breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to default header style under this width. Units - <strong>px</strong>.', 'scape' )),
			'required' => array( 'footer-style-global', '=', 'under' ),
		),
		array(
			'id'       => 'footer-widgets-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Widgets', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'footer-skin-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Widgets skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light',
		),
		array(
			'id'       => 'footer-color-text-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Default text color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-text-dark-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Dark text color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-text-light-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Light text color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-link-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Link color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-link-hover-global',
			'type'     => 'color',
			'title'    => esc_html__( 'Link hover color', 'scape' ),
			'default'  => '',
		),
	)
) );

// Page section
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Pages', 'scape' ),
	'id'               => 'page-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-page'
) );
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Pages', 'scape' ),
	'desc'              => esc_html__( 'Settings affect single pages.', 'scape' ),
	'id'                => 'page-single-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array_merge(
		wtbx_header_options('page'),
		wtbx_header_section_options('page'),
		wtbx_layout_options('page'),
		array(
			array(
				'id'       => 'page-content-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Content', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'page-comments',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display page comments', 'scape' ),
				'default'  => '1',
			),
		),
		wtbx_footer_options('page')
	)
) );

// Blog & Posts section
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Blog &amp; Posts', 'scape' ),
	'id'               => 'blog-posts-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-tiles-view'
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Post entry', 'scape' ),
	'id'               => 'post-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           =>
		array_merge(
			wtbx_header_options('post'),
			array(
				array(
					'id'       => 'post-header-section-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Hero section', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'header-section-post',
					'type'     => 'select',
					'title'    => esc_html__( 'Hero section', 'scape' ),
					'options'  => array(
						'off'           => esc_html__( 'Disable', 'scape' ),
						'default'       => esc_html__( 'Default', 'scape' ),
						'content_block' => esc_html__( 'Content block', 'scape' ),
						'custom_1'      => esc_html__( 'Layout for posts - style 1', 'scape' ),
					),
					'default'  => wtbx_option_defaults('header-section', 'post-type'),
					'placeholder' => esc_html__( 'Inherit', 'scape' ),
				),
				array(
					'id'       => 'header-section-layout-post',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Hero section layout', 'scape' ),
					'options'  => array(
						''         => array(
							'alt'   => esc_html__('Inherit', 'scape'),
							'title' => esc_html__('Inherit', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/inherit.png'
						),
						'one'      => array(
							'alt'   => esc_html__('Centered', 'scape'),
							'title' => esc_html__('Layout 1', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/hero-layout-1.png'
						),
						'two'      => array(
							'alt'   => esc_html__('Centered, bottom-aligned breadcrumbs', 'scape'),
							'title' => esc_html__('Layout 2', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/hero-layout-2.png'
						),
						'three'      => array(
							'alt'   => esc_html__('Left-aligned', 'scape'),
							'title' => esc_html__('Layout 3', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/hero-layout-3.png'
						),
						'four'      => array(
							'alt'   => esc_html__('Right-aligned', 'scape'),
							'title' => esc_html__('Layout 4', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/hero-layout-4.png'
						),
						'five'      => array(
							'alt'   => esc_html__('Left-aligned separated', 'scape'),
							'title' => esc_html__('Layout 5', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/hero-layout-5.png'
						),
						'six'      => array(
							'alt'   => esc_html__('Right-aligned separated', 'scape'),
							'title' => esc_html__('Layout 6', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/hero-layout-6.png'
						),
					),
					'default'  => wtbx_option_defaults('header-section-layout'),
					'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
				),
				array(
					'id'       => 'post-header-author-name-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show author name', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-header-categories-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show post category', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-header-date-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show post date', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'header-section-block-post',
					'type'     => 'select',
					'data'     => 'posts',
					'args'     => array(
						'post_type' => 'content_block',
						'posts_per_page'=> -1,
					),
					'title'    => esc_html__( 'Content block', 'scape' ),
					'desc' => esc_html__( 'Choose a content block to insert as a page hero section.', 'scape' ),
					'subtitle' => esc_html__( 'Only for content block hero section type.', 'scape' ),
					'placeholder' => esc_html__( 'Inherit', 'scape' )
				),
				array(
					'id'            => 'header-section-height-slider-post',
					'type'          => 'slider',
					'title'         => esc_html__( 'Relative height', 'scape' ),
					'desc'          => wp_kses_post( __( 'Height as percentage of screen size. Set to <code>0</code> to disable or <code>-1</code> to inherit.', 'scape' )),
					'default'       => -1,
					'min'           => -1,
					'step'          => 1,
					'max'           => 100,
					'resolution'    => 1,
					'display_value' => 'label',
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-height-post',
					'type'     => 'text',
					'title'    => esc_html__( 'Min. height', 'scape' ),
					'desc'     => wp_kses_post( __( 'Minimum height in pixels. Set to <code>0</code> disable or leave empty to inherit.', 'scape' )),
					'default'  => '',
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-padding-top-post',
					'type'     => 'text',
					'title'    => esc_html__( 'Additional top padding', 'scape' ),
					'default'  => '',
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-padding-bottom-post',
					'type'     => 'text',
					'title'    => esc_html__( 'Additional bottom padding', 'scape' ),
					'default'  => '',
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-bg-image-post',
					'type'     => 'background',
					'url'      => true,
					'title'    => esc_html__( 'Background', 'scape' ),
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-bg-featured-post',
					'type'     => 'select',
					'title'    => esc_html__( 'Use featured image', 'scape' ),
					'desc'     => esc_html__( 'Use featured image for each post instead', 'scape' ),
					'options'  => array(
						'on'   => esc_html__( 'Yes', 'scape' ),
						'off'  => esc_html__( 'No', 'scape' ),
					),
					'default'  => '',
					'placeholder' => esc_html__( 'Inherit', 'scape' ),
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-overlay-color-post',
					'type'      => 'color_rgba',
					'title'    => esc_html__( 'Overlay color', 'scape' ),
					'default'  => '',
					'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
					'options'       => array(
						'show_input'                => true,
						'show_initial'              => true,
						'show_alpha'                => true,
						'show_palette'              => false,
						'show_palette_only'         => false,
						'show_selection_palette'    => false,
						'allow_empty'               => true,
						'clickout_fires_change'     => true,
						'show_buttons'              => true,
						'input_text'                => 'Select Color'
					),
				),
				array(
					'id'       => 'header-section-scroll-full-post',
					'type'     => 'select',
					'title'    => esc_html__( 'Full hero section scroll', 'scape' ),
					'desc'     => esc_html__( 'If enabled, hero section will be fully scrolled down on first user scroll event.', 'scape' ),
					'options'  => array(
						'1'     => esc_html__( 'On', 'scape' ),
						'none'  => esc_html__( 'Off', 'scape' )
					),
					'placeholder' => esc_html__( 'Inherit', 'scape' ),
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-parallax-post',
					'type'     => 'select',
					'title'    => esc_html__( 'Image parallax effect', 'scape' ),
					'options'  => array(
						'none'                      => esc_html__( 'None', 'scape' ),
						'wtbx_parallax_scroll'      => esc_html__( 'Scroll parallax', 'scape' ),
						'wtbx_parallax_mousemove'   => esc_html__( 'Mouse move parallax', 'scape' )
					),
					'default'  => '',
					'placeholder' => esc_html__('Inherit', 'scape'),
					'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-fadeout-post',
					'type'     => 'switch',
					'title'    => esc_html__( 'Content fadeout effect', 'scape' ),
					'desc'     => esc_html__( 'If enabled, hero section content will shift and fade out as the user scrolls down.', 'scape' ),
					'default'  => '',
					'subtitle' => esc_html__( 'Only for default and custom hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-decoration-layout-post',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Bottom decoration', 'scape' ),
					'options'  => array(
						''         => array(
							'alt'   => esc_html__('Inherit', 'scape'),
							'title' => esc_html__('Inherit', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/inherit.png'
						),
						'off'      => array(
							'alt'   => esc_html__('None', 'scape'),
							'title' => esc_html__('None', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-none.png'
						),
						'curve-top'      => array(
							'alt'   => esc_html__('Curve top', 'scape'),
							'title' => esc_html__('Curve top', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-curve-top.png'
						),
						'curve-bottom'      => array(
							'alt'   => esc_html__('Curve bottom', 'scape'),
							'title' => esc_html__('Curve bottom', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-curve-bottom.png'
						),
						'notch-bottom'      => array(
							'alt'   => esc_html__('Notch', 'scape'),
							'title' => esc_html__('Notch', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-notch.png'
						),
						'notch-top'      => array(
							'alt'   => esc_html__('Notch reversed', 'scape'),
							'title' => esc_html__('Notch reversed', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-notch-reversed.png'
						),
						'waves-1'      => array(
							'alt'   => esc_html__('Waves 1', 'scape'),
							'title' => esc_html__('Waves 1', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-waves-1.png'
						),
						'waves-2'      => array(
							'alt'   => esc_html__('Waves 2', 'scape'),
							'title' => esc_html__('Waves 2', 'scape'),
							'img'   => WTBX_URI . '/library/images/admin/divider-waves-2.png'
						),
					),
					'default'  => '',
				),
				array(
					'id'       => 'header-section-skin-post',
					'type'     => 'select',
					'title'    => esc_html__( 'Hero section content skin', 'scape' ),
					'options'  => array(
						'light' => esc_html__( 'Light', 'scape' ),
						'dark'  => esc_html__( 'Dark', 'scape' ),
					),
					'placeholder' => esc_html__( 'Inherit', 'scape' ),
					'default'  => '',
				),
				array(
					'id'        => 'header-section-title-post',
					'type'      => 'wtbx_typography',
					'title'     => esc_html__( 'Title font style', 'scape' ),
					'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
				),
				array(
					'id'        => 'header-section-bc-post',
					'type'      => 'wtbx_typography',
					'title'     => esc_html__( 'Breadcrumbs font', 'scape' ),
					'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
				),
				array(
					'id'       => 'header-section-decoration-color-post',
					'type'     => 'color',
					'title'    => esc_html__( 'Decoration color', 'scape' ),
					'desc'     => esc_html__( 'You may want to match it with the background of your page of the first row on it.', 'scape' ),
					'default'  => '',
				),
				array(
					'id'       => 'header-section-scrolldown-style-post',
					'type'     => 'select',
					'title'    => esc_html__( '"Scroll-down" button', 'scape' ),
					'options'  => array(
						'none'              => esc_html__( 'None', 'scape' ),
						'arrow-single'      => esc_html__( 'Arrow down', 'scape' ),
						'angle-down'        => esc_html__( 'Angle down in circle', 'scape' ),
						'angle-down-cont'   => esc_html__( 'Angle down in round container', 'scape' ),
						'mouse-simple'      => esc_html__( 'Mouse icon', 'scape' ),
					),
					'default'  => '',
					'placeholder' => esc_html__( 'Inherit', 'scape' ),
				),
				array(
					'id'       => 'header-section-scrolldown-skin-post',
					'type'     => 'select',
					'title'    => esc_html__( '"Scroll-down" button skin', 'scape' ),
					'options'  => array(
						'light' => esc_html__( 'Light', 'scape' ),
						'dark'  => esc_html__( 'Dark', 'scape' ),
					),
					'default'  => '',
					'placeholder' => esc_html__( 'Inherit', 'scape' ),
				),
			),
			wtbx_layout_options('post'),
			array(
				array(
					'id'       => 'post-content-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Content', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'        => 'post-heading-font',
					'type'      => 'wtbx_typography',
					'title'     => esc_html__( 'Post heading font', 'scape' ),
				),
				array(
					'id'        => 'post-content-font',
					'type'      => 'wtbx_typography',
					'title'     => esc_html__( 'Post content font', 'scape' ),
				),
				array(
					'id'       => 'post-hide-media',
					'type'     => 'checkbox',
					'title'    => esc_html__( 'Hide media in post body for these post formats', 'scape' ),
					'subtitle' => esc_html__( 'Useful if media is shown in the hero section or embedded in post content.', 'scape' ),
					'options'  => array(
						'image'     => esc_html__('Image', 'scape'),
						'gallery'   => esc_html__('Gallery', 'scape'),
						'video'     => esc_html__('Video', 'scape'),
						'audio'     => esc_html__('Audio', 'scape'),
						'quote'     => esc_html__('Quote', 'scape'),
					),
				),
				array(
					'id'       => 'post-author-descr',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author description block on post page', 'scape' ),
					'default'  => '0',
				),
				array(
					'id'       => 'post-comments',
					'type'     => 'switch',
					'title'    => esc_html__( 'Comments on post page', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-meta-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Meta elements', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'post-title',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post title on post page', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-author',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author name in post meta', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-category',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post category in post meta', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-tags',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post tags', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-social-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Social buttons', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'post-like-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post like button', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Post share buttons', 'scape' ),
					'options'  => array(
						'1' => esc_html__('Disable', 'scape'),
						'2' => esc_html__('Predefined buttons', 'scape'),
						'3' => esc_html__('Custom code', 'scape'),
					),
					'default'  => '2'
				),
				array(
					'id'       => 'post-share-facebook',
					'type'     => 'switch',
					'required' => array( 'post-share', '=', '2' ),
					'title'    => esc_html__( 'Facebook', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share-googleplus',
					'type'     => 'switch',
					'required' => array( 'post-share', '=', '2' ),
					'title'    => esc_html__( 'Google+', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share-linkedin',
					'type'     => 'switch',
					'required' => array( 'post-share', '=', '2' ),
					'title'    => esc_html__( 'LinkedIn', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share-pinterest',
					'type'     => 'switch',
					'required' => array( 'post-share', '=', '2' ),
					'title'    => esc_html__( 'Pinterest', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share-twitter',
					'type'     => 'switch',
					'required' => array( 'post-share', '=', '2' ),
					'title'    => esc_html__( 'Twitter', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share-vkontakte',
					'type'     => 'switch',
					'required' => array( 'post-share', '=', '2' ),
					'title'    => esc_html__( 'VK.com', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-copy',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post link copy', 'scape' ),
					'required' => array( 'post-share', '=', '2' ),
					'default'  => '1',
				),
				array(
					'id'       => 'post-share-custom',
					'type'     => 'textarea',
					'required' => array( 'post-share', '=', '3' ),
					'title'    => esc_html__( 'Custom share code', 'scape' ),
					'desc' => esc_html__( 'Add social share buttons code using this field.', 'scape' ),
					'default'  => '',
				),
				array(
					'id'       => 'post-navigation-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Navigation bar', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'post-navigation-layout',
					'type'     => 'select',
					'title'    => esc_html__( 'Layout', 'scape' ),
					'options'  => array(
						'top'       => esc_html__( 'Top', 'scape' ),
						'bottom'    => esc_html__( 'Bottom', 'scape' ),
						'sticky'    => esc_html__( 'Sticky', 'scape' ),
					),
					'default'  => 'bottom',
					'placeholder'   => esc_html__( 'Disable', 'scape' ),
				),
				array(
					'id'       => 'post-navigation-skin',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Navigation skin', 'scape' ),
					'options'  => array(
						'light' => esc_html__( 'Light', 'scape' ),
						'dark'  => esc_html__( 'Dark', 'scape' )
					),
					'required' => array( 'post-navigation-layout', '=', array('top', 'bottom') ),
					'default'  => 'light'
				),
				array(
					'id'       => 'post-navigation-parent',
					'type'     => 'switch',
					'title'    => esc_html__( '"Back to list" button', 'scape' ),
					'default'  => '1',
					'required' => array( 'post-navigation-layout', '=', array('top', 'bottom') ),
				),
				array(
					'id'       => 'post-navigation-buttons',
					'type'     => 'switch',
					'title'    => esc_html__( 'Navigation buttons', 'scape' ),
					'required' => array( 'post-navigation-layout', '=', array('top', 'bottom') ),
					'default'  => 1
				),
				array(
					'id'       => 'post-related-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Related posts', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'post-related-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Related posts display', 'scape' ),
					'default'  => 0
				),
				array(
					'id'       => 'post-related-criteria',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Relation by', 'scape' ),
					'options'  => array(
						'category'  => esc_html__( 'Category', 'scape' ),
						'tag'       => esc_html__( 'Tag', 'scape' )
					),
					'default'  => 'category',
					'required' => array( 'post-related-enable', '=', true ),
				),
				array(
					'id'            => 'post-related-total',
					'type'          => 'slider',
					'title'         => esc_html__( 'Total number of related posts shown', 'scape' ),
					'default'       => 4,
					'min'           => 1,
					'step'          => 1,
					'max'           => 16,
					'display_value' => 'text',
					'required' => array( 'post-related-enable', '=', true ),
				),
				array(
					'id'            => 'post-related-autoplay',
					'type'          => 'slider',
					'title'         => esc_html__( 'Slider autoplay speed (in seconds)', 'scape' ),
					'desc'         => wp_kses_post( __( 'Set to <code>0</code> to disable autoplay.', 'scape' )),
					'default'       => 4,
					'min'           => 0,
					'step'          => 1,
					'max'           => 10,
					'display_value' => 'text',
					'required' => array( 'post-related-enable', '=', true ),
				),
				array(
					'id'       => 'post-related-categories-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Display post category', 'scape' ),
					'default'  => 1,
					'required' => array( 'post-related-enable', '=', true ),
				),
				array(
					'id'       => 'post-related-date-enable',
					'type'     => 'switch',
					'title'    => esc_html__( 'Display post date', 'scape' ),
					'default'  => 1,
					'required' => array( 'post-related-enable', '=', true ),
				),
			),
			wtbx_footer_options('post')
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Archives', 'scape' ),
	'desc'             => esc_html__( 'Settings affect blog archive pages such as category and date pages.', 'scape' ),
	'id'               => 'post-archive-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           =>
		array_merge(
			wtbx_header_options('blog'),
			wtbx_header_section_options('blog'),
			wtbx_layout_options('blog'),
			array(
				array(
					'id'       => 'post-archive-content-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Content', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'post-archive-custom',
					'type'     => 'select',
					'title'    => esc_html__( 'Content block', 'scape' ),
					'subtitle' => esc_html__( 'Content block to be used to display blog archives.', 'scape' ),
					'desc'     => esc_html__( 'Content block should contain a "Post Grid" shortcode. "Query" option in shortcode settings must be set to "Global query".', 'scape' ),
		            'data'     => 'posts',
					'args'     => array(
						'post_type' => 'content_block',
						'posts_per_page'=> -1,
					),
					'placeholder' => esc_html__( 'Inherit', 'scape' )
				)
			),
			wtbx_footer_options('blog')
		)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Author page', 'scape' ),
	'desc'             => esc_html__( 'Settings affect author page.', 'scape' ),
	'id'               => 'post-author-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array_merge(
		wtbx_header_options('author'),
		array(
			array(
				'id'       => 'post-author-header-section-start',
				'type'     => 'wtbx_toggle',
				'title'         => esc_html__( 'Hero section', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'post-author-image-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show author image', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'post-author-name-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show author name', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'post-author-position-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show author position', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'post-author-description-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show author description', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'post-author-social-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show author social icons', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'            => 'header-section-height-slider-author',
				'type'          => 'slider',
				'title'         => esc_html__( 'Relative height', 'scape' ),
				'desc'          => wp_kses_post( __( 'Height as percentage of screen size. Set to <code>0</code> to disable.', 'scape' )),
				'default'       => -1,
				'min'           => -1,
				'step'          => 1,
				'max'           => 100,
				'resolution'    => 1,
				'display_value' => 'label',
			),
			array(
				'id'       => 'header-section-height-author',
				'type'     => 'text',
				'title'    => esc_html__( 'Min. height', 'scape' ),
				'desc'     => wp_kses_post( __( 'Minimum height in pixels. Set to <code>0</code> disable or leave empty to inherit.', 'scape' )),
				'default'  => '',
			),
			array(
				'id'       => 'header-section-padding-top-author',
				'type'     => 'text',
				'title'    => esc_html__( 'Additional top padding', 'scape' ),
				'default'  => '',
			),
			array(
				'id'       => 'header-section-padding-bottom-author',
				'type'     => 'text',
				'title'    => esc_html__( 'Additional bottom padding', 'scape' ),
				'default'  => '',
			),
			array(
				'id'       => 'header-section-bg-image-author',
				'type'     => 'background',
				'url'      => true,
				'title'    => esc_html__( 'Background', 'scape' ),
			),
			array(
				'id'       => 'header-section-bg-featured-author',
				'type'     => 'select',
				'title'    => esc_html__( 'Use featured image', 'scape' ),
				'desc'     => esc_html__( 'Use featured image for each post instead', 'scape' ),
				'options'  => array(
					'on'   => esc_html__( 'Yes', 'scape' ),
					'off'  => esc_html__( 'No', 'scape' ),
				),
				'default'  => '',
				'placeholder' => esc_html__( 'Inherit', 'scape' ),
			),
			array(
				'id'       => 'header-section-overlay-color-author',
				'type'      => 'color_rgba',
				'title'    => esc_html__( 'Overlay color', 'scape' ),
				'default'  => '',
				'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
				'options'       => array(
					'show_input'                => true,
					'show_initial'              => true,
					'show_alpha'                => true,
					'show_palette'              => false,
					'show_palette_only'         => false,
					'show_selection_palette'    => false,
					'allow_empty'               => true,
					'clickout_fires_change'     => true,
					'show_buttons'              => true,
					'input_text'                => 'Select Color'
				),
			),
			array(
				'id'       => 'header-section-scroll-full-author',
				'type'     => 'select',
				'title'    => esc_html__( 'Full hero section scroll', 'scape' ),
				'desc'     => esc_html__( 'If enabled, hero section will be fully scrolled down on first user scroll event.', 'scape' ),
				'options'  => array(
					'1'     => esc_html__( 'On', 'scape' ),
					'none'  => esc_html__( 'Off', 'scape' )
				),
				'placeholder' => esc_html__( 'Inherit', 'scape' ),
			),
			array(
				'id'       => 'header-section-parallax-author',
				'type'     => 'select',
				'title'    => esc_html__( 'Image parallax effect', 'scape' ),
				'options'  => array(
					'none'                      => esc_html__( 'None', 'scape' ),
					'wtbx_parallax_scroll'      => esc_html__( 'Scroll parallax', 'scape' ),
					'wtbx_parallax_mousemove'   => esc_html__( 'Mouse move parallax', 'scape' )
				),
				'default'  => '',
				'placeholder' => esc_html__('Inherit', 'scape'),
				'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			),
			array(
				'id'       => 'header-section-fadeout-author',
				'type'     => 'switch',
				'title'    => esc_html__( 'Content fadeout effect', 'scape' ),
				'desc'     => esc_html__( 'If enabled, hero section content will shift and fade out as the user scrolls down.', 'scape' ),
				'default'  => '',
			),
			array(
				'id'       => 'header-section-decoration-layout-author',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Decoration style', 'scape' ),
				'options'  => array(
					''         => array(
						'alt'   => esc_html__('Inherit', 'scape'),
						'title' => esc_html__('Inherit', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/inherit.png'
					),
					'off'      => array(
						'alt'   => esc_html__('None', 'scape'),
						'title' => esc_html__('None', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-none.png'
					),
					'curve-top'      => array(
						'alt'   => esc_html__('Curve top', 'scape'),
						'title' => esc_html__('Curve top', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-curve-top.png'
					),
					'curve-bottom'      => array(
						'alt'   => esc_html__('Curve bottom', 'scape'),
						'title' => esc_html__('Curve bottom', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-curve-bottom.png'
					),
					'notch-bottom'      => array(
						'alt'   => esc_html__('Notch', 'scape'),
						'title' => esc_html__('Notch', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-notch.png'
					),
					'notch-top'      => array(
						'alt'   => esc_html__('Notch reversed', 'scape'),
						'title' => esc_html__('Notch reversed', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-notch-reversed.png'
					),
					'waves-1'      => array(
						'alt'   => esc_html__('Waves 1', 'scape'),
						'title' => esc_html__('Waves 1', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-waves-1.png'
					),
					'waves-2'      => array(
						'alt'   => esc_html__('Waves 2', 'scape'),
						'title' => esc_html__('Waves 2', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/divider-waves-2.png'
					)
				),
				'default'  => '',
			),
			array(
				'id'       => 'header-section-skin-author',
				'type'     => 'select',
				'title'    => esc_html__( 'Hero section content skin', 'scape' ),
				'options'  => array(
					'light' => esc_html__( 'Light', 'scape' ),
					'dark'  => esc_html__( 'Dark', 'scape' ),
				),
				'placeholder' => esc_html__( 'Inherit', 'scape' ),
				'default'  => '',
			),
			array(
				'id'        => 'header-section-title-author',
				'type'      => 'wtbx_typography',
				'title'     => esc_html__( 'Title font style', 'scape' ),
				'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			),
			array(
				'id'        => 'header-section-bc-author',
				'type'      => 'wtbx_typography',
				'title'     => esc_html__( 'Breadcrumbs font', 'scape' ),
				'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			),
			array(
				'id'       => 'header-section-decoration-color-author',
				'type'     => 'color',
				'title'    => esc_html__( 'Decoration color', 'scape' ),
				'desc' => esc_html__( 'You may want to match it with the background of your page of the first row on it.', 'scape' ),
				'default'  => '',
			),
			array(
				'id'       => 'header-section-scrolldown-style-author',
				'type'     => 'select',
				'title'    => esc_html__( '"Scroll-down" button', 'scape' ),
				'options'  => array(
					'none'              => esc_html__( 'None', 'scape' ),
					'arrow-single'      => esc_html__( 'Arrow down', 'scape' ),
					'angle-down'        => esc_html__( 'Angle down in circle', 'scape' ),
					'angle-down-cont'   => esc_html__( 'Angle down in round container', 'scape' ),
					'mouse-simple'      => esc_html__( 'Mouse icon', 'scape' ),
				),
				'default'  => '',
				'placeholder' => esc_html__( 'Inherit', 'scape' ),
			),
			array(
				'id'       => 'header-section-scrolldown-skin-author',
				'type'     => 'select',
				'title'    => esc_html__( '"Scroll-down" button skin', 'scape' ),
				'options'  => array(
					'light' => esc_html__( 'Light', 'scape' ),
					'dark'  => esc_html__( 'Dark', 'scape' ),
				),
				'default'  => '',
				'placeholder' => esc_html__( 'Inherit', 'scape' ),
			),
		),
		wtbx_layout_options('author'),
		array(
			array(
				'id'       => 'post-author-content-start',
				'type'     => 'wtbx_toggle',
				'title'         => esc_html__( 'Content', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'post-author-custom',
				'type'     => 'select',
				'title'    => esc_html__( 'Content block', 'scape' ),
				'subtitle' => esc_html__( 'Content block to be used to display blog archives.', 'scape' ),
				'desc'     => esc_html__( 'Content block should contain a "Post Grid" shortcode. "Query" option in shortcode settings must be set to "Global query".', 'scape' ),
				'data'     => 'posts',
				'args'     => array(
					'post_type' => 'content_block',
					'posts_per_page'=> -1,
				),
				'placeholder' => esc_html__( 'Select item', 'scape' )
			)
		),
		wtbx_footer_options('author')
	)
) );

// Portfolio section
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Portfolio', 'scape' ),
	'id'               => 'portfolio-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-photo-library'
) );

Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Portfolio item', 'scape' ),
	'desc'              => esc_html__( 'Settings affect single portfolio item pages.', 'scape' ),
	'id'                => 'post-single-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array_merge(
		wtbx_header_options('portfolio-item'),
		wtbx_header_section_options('portfolio-item'),
		wtbx_layout_options('portfolio-item'),
		array(
			array(
				'id'       => 'portfolio-elements-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Content', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'portfolio-item-content-position',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Content layout', 'scape' ),
				'desc'     => wp_kses_post( __( 'Left and right positioning is <strong>NOT</strong> available with the following media layouts: <strong>image carousel, zig-zag, checkers</strong>.', 'scape' )),
				'options'  => array(
					'top-onecol'      => array(
						'alt'   => esc_html__('Top - one column', 'scape'),
						'title' => esc_html__('Top - one column', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-top-onecol.png'
					),
					'top-twocol'      => array(
						'alt'   => esc_html__('Top - two columns', 'scape'),
						'title' => esc_html__('Top - two columns', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-top-twocol.png'
					),
					'bottom-onecol'      => array(
						'alt'   => esc_html__('Bottom - one column', 'scape'),
						'title' => esc_html__('Bottom - one column', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-bottom-onecol.png'
					),
					'bottom-twocol'      => array(
						'alt'   => esc_html__('Bottom - two columns', 'scape'),
						'title' => esc_html__('Bottom - two columns', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-bottom-twocol.png'
					),
					'left'      => array(
						'alt'   => esc_html__('Left', 'scape'),
						'title' => esc_html__('Left', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-left.png'
					),
					'left-sticky'      => array(
						'alt'   => esc_html__('Left sticky', 'scape'),
						'title' => esc_html__('Left sticky', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-left-sticky.png'
					),
					'right'      => array(
						'alt'   => esc_html__('Right', 'scape'),
						'title' => esc_html__('Right', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-right.png'
					),
					'right-sticky'      => array(
						'alt'   => esc_html__('Right sticky', 'scape'),
						'title' => esc_html__('Right sticky', 'scape'),
						'img'   => WTBX_URI . '/library/images/admin/portfolio-right-sticky.png'
					),
				),
				'default'  => 'bottom-twocol'
			),
			array(
				'id'       => 'portfolio-item-title-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show title', 'scape' ),
				'default'  => 1,
			),
			array(
				'id'       => 'portfolio-item-description-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show description', 'scape' ),
				'default'  => 1
			),
			array(
				'id'       => 'portfolio-item-media-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show media', 'scape' ),
				'default'  => 1
			),
			array(
				'id'       => 'portfolio-item-details-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show details', 'scape' ),
				'default'  => 1
			),
			array(
				'id'        => 'portfolio-item-title-typography',
				'type'      => 'wtbx_typography',
				'title'     => esc_html__( 'Portfolio item title font style', 'scape' ),
			),
			array(
				'id'        => 'portfolio-item-description-typography',
				'type'      => 'wtbx_typography',
				'title'     => esc_html__( 'Portfolio item description font style', 'scape' ),
			),
			array(
				'id'        => 'portfolio-item-details',
				'type'      => 'wtbx_details',
				'title'     => esc_html__( 'Portfolio item details', 'scape' ),
				'subtitle'  => esc_html__( 'Add, name and sort portfolio details labels', 'scape' ),
				'label'     => false,
				'options'   => array(
					'1'     => ''
				),
				'required' => array( 'portfolio-item-details-enable', '=', true ),
			),
			array(
				'id'       => 'portfolio-social-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Social buttons', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'portfolio-item-like-enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Portfolio like button', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Portfolio item share buttons', 'scape' ),
				'options'  => array(
					'1' => esc_html__('Disable', 'scape'),
					'2' => esc_html__('Predefined buttons', 'scape'),
					'3' => esc_html__('Custom code', 'scape'),
				),
				'default'  => '2'
			),
			array(
				'id'       => 'portfolio-share-facebook',
				'type'     => 'switch',
				'required' => array( 'portfolio-share', '=', '2' ),
				'title'    => esc_html__( 'Facebook', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share-googleplus',
				'type'     => 'switch',
				'required' => array( 'portfolio-share', '=', '2' ),
				'title'    => esc_html__( 'Google+', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share-linkedin',
				'type'     => 'switch',
				'required' => array( 'portfolio-share', '=', '2' ),
				'title'    => esc_html__( 'LinkedIn', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share-pinterest',
				'type'     => 'switch',
				'required' => array( 'portfolio-share', '=', '2' ),
				'title'    => esc_html__( 'Pinterest', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share-twitter',
				'type'     => 'switch',
				'required' => array( 'portfolio-share', '=', '2' ),
				'title'    => esc_html__( 'Twitter', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share-vkontakte',
				'type'     => 'switch',
				'required' => array( 'portfolio-share', '=', '2' ),
				'title'    => esc_html__( 'VK.com', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-copy',
				'type'     => 'switch',
				'title'    => esc_html__( 'Portfolio link copy', 'scape' ),
				'required' => array( 'portoflio-share', '=', '2' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-share-custom',
				'type'     => 'textarea',
				'required' => array( 'portfolio-share', '=', '3' ),
				'title'    => esc_html__( 'Custom share code', 'scape' ),
				'desc' => esc_html__( 'Add social share buttons code using this field.', 'scape' ),
				'default'  => '',
			),
			array(
				'id'       => 'portfolio-navigation-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Navigation bar', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'portfolio-navigation-layout',
				'type'     => 'select',
				'title'    => esc_html__( 'Layout', 'scape' ),
				'options'  => array(
					'top'       => esc_html__( 'Top', 'scape' ),
					'bottom'    => esc_html__( 'Bottom', 'scape' ),
					'sticky'    => esc_html__( 'Sticky', 'scape' ),
					'images'    => esc_html__( 'Image preview', 'scape' ),
				),
				'default'  => 'bottom',
				'placeholder'   => esc_html__( 'Disable', 'scape' ),
			),
			array(
				'id'       => 'portfolio-navigation-skin',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Navigation skin', 'scape' ),
				'options'  => array(
					'light' => esc_html__( 'Light', 'scape' ),
					'dark'  => esc_html__( 'Dark', 'scape' )
				),
				'required' => array( 'portfolio-navigation-layout', '=', array('top', 'bottom') ),
				'default'  => 'light'
			),
			array(
				'id'       => 'portfolio-navigation-parent',
				'type'     => 'switch',
				'title'    => esc_html__( '"Back to list" button', 'scape' ),
				'default'  => '1',
				'required' => array( 'portfolio-navigation-layout', '=', array('top', 'bottom') ),
			),
			array(
				'id'       => 'portfolio-navigation-buttons',
				'type'     => 'switch',
				'title'    => esc_html__( 'Navigation buttons', 'scape' ),
				'required' => array( 'portfolio-navigation-layout', '=', array('top', 'bottom') ),
				'default'  => 1
			)
		),
		wtbx_footer_options('portfolio-item')
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Archives', 'scape' ),
	'desc'             => esc_html__( 'Settings affect portfolio archive pages.', 'scape' ),
	'id'               => 'portfolio-archive-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array_merge(
		wtbx_header_options('portfolio'),
		wtbx_header_section_options('portfolio'),
		wtbx_layout_options('portfolio'),
		array(
			array(
				'id'       => 'portfolio-archive-content-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Content', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'portfolio-archive-custom',
				'type'     => 'select',
				'title'    => esc_html__( 'Content block', 'scape' ),
				'subtitle' => esc_html__( 'Content block to be used to display blog archives.', 'scape' ),
				'desc'     => esc_html__( 'Content block should contain a "Post Grid" shortcode. "Query" option in shortcode settings must be set to "Global query".', 'scape' ),
				'data'     => 'posts',
				'args'     => array(
					'post_type' => 'content_block',
					'posts_per_page'=> -1,
				),
				'placeholder' => esc_html__( 'Inherit', 'scape' )
			),
			array(
				'id'       => 'portfolio-archive-perpage',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Number of portfolio items per page', 'scape' ),
				'default'  => '12',
				'min'      => '1',
				'step'     => '1',
				'max'      => '',
			),
			array(
				'id'       => 'portfolio-archive-link',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display link to portfolio item page in lightbox', 'scape' ),
				'default'  => '1',
			),
			array(
				'id'       => 'portfolio-custom-slug',
				'type'     => 'text',
				'title'    => esc_html__( 'Custom portfolio post type slug', 'scape' ),
				'subtitle' => esc_html__( 'E.g. "Projects", "Works", etc.', 'scape' ),
				'desc'     => wp_kses_post( __( 'Enter a different post type name, if you are not satisfied with the default one - <strong>Portfolio</strong>.', 'scape' )),
				'default'  => 'Portfolio',
			),
		),
		wtbx_footer_options('portfolio')
	)
) );


Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'WooCommerce', 'scape' ),
	'id'               => 'woocommerce-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-dollar-bag'
) );

Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Product page', 'scape' ),
	'desc'              => esc_html__( 'Settings affect single product pages.', 'scape' ),
	'id'                => 'product-single-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            =>
		array_merge(
			wtbx_header_options('product'),
			wtbx_header_section_options('product'),
			wtbx_layout_options('product'),
			array(
				array(
					'id'       => 'product-content-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Content', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'             => 'product-image-ratio',
					'type'           => 'dimensions',
					'units'          => false,    // You can specify a unit value. Possible: px, em, %
					'title'          => esc_html__( 'Product image ratio', 'scape' ),
					'subtitle'       => wp_kses_post( __('E.g. <strong>3:4</strong>.', 'scape' )),
					'desc'           => esc_html__( 'Leave blank to use initial image ratio.', 'scape' ),
					'default'  => array(
						'width'   => '1',
						'height'  => '1'
					),
				),
				array(
					'id'       => 'product-image-size',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Product image gallery width', 'scape' ),
					'options'  => array(
						'3'    => esc_html__( '3/12', 'scape' ),
						'4'    => esc_html__( '4/12', 'scape' ),
						'5'    => esc_html__( '5/12', 'scape' ),
						'6'    => esc_html__( '6/12', 'scape' ),
						'7'    => esc_html__( '7/12', 'scape' ),
					),
					'default'  => '5'
				),
				array(
					'id'       => 'product-thumbnails-position',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Thumbnails position', 'scape' ),
					'options'  => array(
						'bottom'    => esc_html__( 'Bottom', 'scape' ),
						'left'      => esc_html__( 'Left', 'scape' )
					),
					'default'  => 'bottom'
				),
				array(
					'id'       => 'product-single-breadcrumbs',
					'type'     => 'switch',
					'title'    => esc_html__( 'Display breadcrumbs', 'scape' ),
					'default'  => 1,
				),
				array(
					'id'       => 'product-single-subtitle',
					'type'     => 'switch',
					'title'    => esc_html__( 'Display subtitle', 'scape' ),
					'default'  => 1,
				),
				array(
					'id'        => 'product-single-title-typography',
					'type'      => 'wtbx_typography',
					'title'     => esc_html__( 'Product title font style', 'scape' ),
				),
				array(
					'id'        => 'product-single-subtitle-typography',
					'type'      => 'wtbx_typography',
					'title'     => esc_html__( 'Product subtitle font style', 'scape' ),
				),
				array(
					'id'       => 'product-social-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Social buttons', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'product-share',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post share buttons', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Product like &amp; share buttons', 'scape' ),
					'options'  => array(
						'1' => esc_html__('Disable', 'scape'),
						'2' => esc_html__('Predefined buttons', 'scape'),
						'3' => esc_html__('Custom code', 'scape'),
					),
					'default'  => '2'
				),
				array(
					'id'       => 'product-share-facebook',
					'type'     => 'switch',
					'required' => array( 'product-share', '=', '2' ),
					'title'    => esc_html__( 'Facebook', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share-googleplus',
					'type'     => 'switch',
					'required' => array( 'product-share', '=', '2' ),
					'title'    => esc_html__( 'Google+', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share-linkedin',
					'type'     => 'switch',
					'required' => array( 'product-share', '=', '2' ),
					'title'    => esc_html__( 'LinkedIn', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share-pinterest',
					'type'     => 'switch',
					'required' => array( 'product-share', '=', '2' ),
					'title'    => esc_html__( 'Pinterest', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share-twitter',
					'type'     => 'switch',
					'required' => array( 'product-share', '=', '2' ),
					'title'    => esc_html__( 'Twitter', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share-vkontakte',
					'type'     => 'switch',
					'required' => array( 'product-share', '=', '2' ),
					'title'    => esc_html__( 'VK.com', 'scape' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-like',
					'type'     => 'switch',
					'title'    => esc_html__( 'Post like button', 'scape' ),
					'required' => array( 'product-share', '=', '2' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-copy',
					'type'     => 'switch',
					'title'    => esc_html__( 'Product link copy', 'scape' ),
					'required' => array( 'product-share', '=', '2' ),
					'default'  => '1',
				),
				array(
					'id'       => 'product-share-custom',
					'type'     => 'textarea',
					'required' => array( 'product-share', '=', '3' ),
					'title'    => esc_html__( 'Custom share code', 'scape' ),
					'desc' => esc_html__( 'Add social share buttons code using this field.', 'scape' ),
					'default'  => '',
				),
				array(
					'id'       => 'product-navigation-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Navigation bar', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'product-navigation-layout',
					'type'     => 'select',
					'title'    => esc_html__( 'Layout', 'scape' ),
					'options'  => array(
						'top'       => esc_html__( 'Top', 'scape' ),
						'bottom'    => esc_html__( 'Bottom', 'scape' ),
						'sticky'    => esc_html__( 'Sticky', 'scape' ),
					),
					'default'  => 'bottom',
					'placeholder'   => esc_html__( 'Disable', 'scape' ),
				),
				array(
					'id'       => 'product-navigation-skin',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Navigation skin', 'scape' ),
					'options'  => array(
						'light' => esc_html__( 'Light', 'scape' ),
						'dark'  => esc_html__( 'Dark', 'scape' )
					),
					'default'  => 'light'
				),
				array(
					'id'       => 'product-navigation-parent',
					'type'     => 'switch',
					'title'    => esc_html__( '"Back to list" button', 'scape' ),
					'default'  => '1',
					'required' => array( 'product-navigation-layout', '=', array('top', 'bottom') ),
				),
				array(
					'id'       => 'product-navigation-buttons',
					'type'     => 'switch',
					'title'    => esc_html__( 'Navigation buttons', 'scape' ),
					'default'  => 1
				),
			),
			wtbx_footer_options('product')
		)
) );

Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Shop page', 'scape' ),
	'desc'              => esc_html__( 'Settings affect main shop and archive pages.', 'scape' ),
	'id'                => 'product-shop-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            =>
		array_merge(
			wtbx_header_options('shop'),
			wtbx_header_section_options('shop'),
			wtbx_layout_options('shop'),
			array(
				array(
					'id'       => 'shop-content-start',
					'type'     => 'wtbx_toggle',
					'title'    => esc_html__( 'Content', 'scape' ),
					'indent'   => true, // Indent all options below until the next 'section' option is set.
				),
				array(
					'id'       => 'shop-perpage',
					'type'     => 'spinner',
					'title'    => esc_html__( 'Number of products shown per page', 'scape' ),
					'default'  => '12',
					'min'      => '1',
					'step'     => '1',
					'max'      => '100',
				),
				array(
					'id'       => 'shop-columns',
					'type'     => 'spinner',
					'title'    => esc_html__( 'Product columns', 'scape' ),
					'desc'     => esc_html__( 'Maximum number of columns in product grid.', 'scape' ),
					'default'  => '4',
					'min'      => '2',
					'step'     => '1',
					'max'      => '6',
				),
				array(
					'id'       => 'shop-cat-columns',
					'type'     => 'spinner',
					'title'    => esc_html__( 'Product category columns', 'scape' ),
					'desc'     => esc_html__( 'Maximum number of columns in product category grid.', 'scape' ),
					'default'  => '2',
					'min'      => '2',
					'step'     => '1',
					'max'      => '4',
				),
			),
			wtbx_footer_options('shop')
		)
) );

// Various components
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Components', 'scape' ),
	'desc'              => esc_html__( 'Settings affect various WooCommerce sections and components.', 'scape' ),
	'id'                => 'product-components-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array(
		array(
			'id'       => 'product-cat-tile-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Category tile', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'product-cat-tile-title-position',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Layout', 'scape' ),
			'options'  => array(
				'left'      => array(
					'alt'   => esc_html__('Text on the left', 'scape'),
					'title' => esc_html__('Left', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/category-tile-left.png'
				),
				'right'      => array(
					'alt'   => esc_html__('Text on the right', 'scape'),
					'title' => esc_html__('Right', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/category-tile-right.png'
				),
			),
			'default'  => 'left',
		),
		array(
			'id'       => 'product-cat-tile-count',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display product count in category', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'        => 'product-cat-tile-title-typography',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Category title font style', 'scape' ),
		),
		array(
			'id'        => 'product-cat-tile-description-typography',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Category description font style', 'scape' ),
		),
		array(
			'id'       => 'product-tile-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Product tile', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'product-tile-padding',
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Image padding', 'scape' ),
			'desc'     => esc_html__( 'Set bigger padding for more space around the image.', 'scape' ),
			'units'    => 'px',
			'default'  => array(
				'padding-top'    => '0',
				'padding-right'  => '0',
				'padding-bottom' => '110',
				'padding-left'   => '0'
			)
		),
		array(
			'id'       => 'product-tile-bg',
			'type'     => 'color',
			'title'    => esc_html__( 'Image background color', 'scape' ),
			'desc'     => esc_html__( 'You may want to match the color with the product image background if using image padding.', 'scape' ),
			'default'  => '#ffffff',
		),
		array(
			'id'             => 'product-tile-ratio',
			'type'           => 'dimensions',
			'units'          => false,    // You can specify a unit value. Possible: px, em, %
			'placeholder'    => array(),
			'title'          => esc_html__( 'Product image ratio', 'scape' ),
			'subtitle'       => esc_html__( 'Leave blank to use initial image ratio.', 'scape' ),
		),
		array(
			'id'       => 'product-tile-hover',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show second product image on tile hover', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-tile-subtitle',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display product subtitle', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-tile-rating',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display product rating', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-tile-zoom',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display image zoom button', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-tile-preview',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display product preview button', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-tile-share',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display share buttons in lightbox', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-tile-link',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display link to product page in lightbox', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'product-wishlist',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display add to wishlist button', 'scape' ),
			'desc'     => wp_kses_post( __( 'Button will be shown if <a href="//wordpress.org/plugins/yith-woocommerce-wishlist/">YITH WooCommerce Wishlist</a> plugin is installed.', 'scape' )),
			'default'  => '1',
		),
		array(
			'id'        => 'product-tile-title-typography',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Product title font style', 'scape' ),
		),
		array(
			'id'        => 'product-tile-subtitle-typography',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Product subtitle font style', 'scape' ),
		),
		array(
			'id'       => 'product-upsells-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Upsells', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'product-upsells-total',
			'type'     => 'spinner',
			'title'    => esc_html__( 'Number of products', 'scape' ),
			'desc'     => esc_html__( 'Maximum number of items in up-sell products section.', 'scape' ),
			'default'  => '12',
			'min'      => '0',
			'step'     => '1',
			'max'      => '100',
		),
		array(
			'id'       => 'product-upsells-columns',
			'type'     => 'spinner',
			'title'    => esc_html__( 'Columns', 'scape' ),
			'desc'     => esc_html__( 'Number of columns in up-sells section.', 'scape' ),
			'default'  => '4',
			'min'      => '1',
			'step'     => '1',
			'max'      => '6',
		),
		array(
			'id'       => 'product-related-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Related products', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'product-related-total',
			'type'     => 'spinner',
			'title'    => esc_html__( 'Number of products', 'scape' ),
			'desc'     => esc_html__( 'Maximum number of items in related products section.', 'scape' ),
			'default'  => '12',
			'min'      => '0',
			'step'     => '1',
			'max'      => '100',
		),
		array(
			'id'       => 'product-related-columns',
			'type'     => 'spinner',
			'title'    => esc_html__( 'Columns', 'scape' ),
			'desc'     => esc_html__( 'Number of columns in related products section.', 'scape' ),
			'default'  => '4',
			'min'      => '1',
			'step'     => '1',
			'max'      => '6',
		),
		array(
			'id'       => 'product-badges-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Product badges', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'product-sale-discount',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Discount amount', 'scape' ),
			'desc'     => esc_html__( 'Show amount of discount on a sale badge (where applicable).', 'scape' ),
			'options'  => array(
				'1' => esc_html__('Show', 'scape'),
				''  => esc_html__('Hide', 'scape')
			),
			'default'  => '1'
		),
		array(
			'id'       => 'product-sale-bg',
			'type'     => 'color',
			'title'    => esc_html__( 'Sale badge color', 'scape' ),
			'default'  => '#5ed48b',
		),
		array(
			'id'       => 'product-badge-bg',
			'type'     => 'color',
			'title'    => esc_html__( 'Custom product badge color', 'scape' ),
			'desc'     => esc_html__( 'If left empty, will match the site accent color.', 'scape' ),
			'default'  => '',
		),
	)
) );

wtbx_custom_post_type_options($opt_name);

// Utility pages section
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Utility pages', 'scape' ),
	'id'               => 'utility-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-tools'
) );

// Search page
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Search page', 'scape' ),
	'id'                => 'search-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array_merge(
		wtbx_header_options('search'),
		wtbx_header_section_options('search'),
		wtbx_layout_options('search'),
		array (
			array(
				'id'       => 'search-content-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Content', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => 'search-page-post-types',
				'type'     => 'checkbox',
				'title'    => esc_html__( 'Post types displayed in search form dropdown', 'scape' ),
				'subtitle' => esc_html__( 'Uncheck all to disable dropdown.', 'scape' ),
				'data'     => 'post_types',
			)
		),
		wtbx_footer_options('search')
	)
) );

// 404 page
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( '404 page', 'scape' ),
	'id'                => '404-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array_merge(
		wtbx_header_options('404'),
		wtbx_header_section_options('404'),
		wtbx_layout_options('404'),
		array (
			array(
				'id'       => '404-content-start',
				'type'     => 'wtbx_toggle',
				'title'    => esc_html__( 'Content', 'scape' ),
				'indent'   => true, // Indent all options below until the next 'section' option is set.
			),
			array(
				'id'       => '404-style',
				'type'     => 'button_set',
				'title'    => esc_html__( '404 page style', 'scape' ),
				'subtitle' => esc_html__( 'Choose default style or custom style to use a content block instead.', 'scape' ),
				'options'  => array(
					'default'   => esc_html__( 'Default', 'scape' ),
					'custom'    => esc_html__( 'Custom', 'scape' )
				),
				'default'  => 'default'
			),
			array(
				'id'       => '404-style-custom',
				'type'     => 'select',
				'data'     => 'posts',
				'args'     => array(
					'post_type' => 'content_block',
					'posts_per_page'=> -1,
				),
				'title'    => esc_html__( 'Content block', 'scape' ),
				'subtitle' => esc_html__( 'Choose a content block to insert below the search field.', 'scape' ),
				'required' => array( '404-style', '=', array('custom') ),
			)
		),
		wtbx_footer_options('404')
	)
) );

// Maintenance page
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Maintenance page', 'scape' ),
	'id'                => 'maintenance-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array (
		array(
			'id'       => 'maintenance-mode',
			'type'     => 'switch',
			'title'    => esc_html__( 'Activate maintenance mode', 'scape' ),
			'subtitle' => esc_html__( 'Maintenance mode will be activated for not logged in users after saving the changes.', 'scape' ),
			'default'  => false
		),
		array(
			'id'       => 'maintenance-page',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Maintenance page', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to display on a maintenance page.', 'scape' ),
			'desc'     => esc_html__( 'If not set, the default maintenance page will be shown.', 'scape' ),
		)
	)

) );

// Login page
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Login page', 'scape' ),
	'id'                => 'login-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array (
		array(
			'id'       => 'login-page-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Custom login page', 'scape' ),
			'subtitle' => esc_html__( 'Override default WordPress login page style to make the page nicer.', 'scape' ),
			'default'  => false,
		),
		array(
			'id'       => 'login-page-logo',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Logo', 'scape' ),
			'subtitle' => esc_html__( 'If not set, default WordPress logo will be used.', 'scape' ),
			'desc'     => esc_html__( 'Logo will be shown twice as small to appear sharp on retina displays.', 'scape' ),
			'required' => array( 'login-page-enable', '=', array(true) ),
		),
		array(
			'id'       => 'login-page-bg',
			'type'     => 'background',
			'url'      => true,
			'title'    => esc_html__( 'Background', 'scape' ),
			'required' => array( 'login-page-enable', '=', array(true) ),
		),
		array(
			'id'        => 'login-page-overlay',
			'type'      => 'color_rgba',
			'title'     => esc_html__( 'Image overlay color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'rgba'  => 'rgba(0,0,0,.5)'
			),
			'required' => array( 'login-page-enable', '=', array(true) ),
		),
		array(
			'id'       => 'login-html-before',
			'type'     => 'ace_editor',
			'mode'     => 'html',
			'options'  => array(
				'minLines' => 10,
				'maxLines' => 30
			),
			'title'    => esc_html__( 'Content before the login form', 'scape' ),
			'subtitle' => esc_html__( 'Raw code for the content to display', 'scape' ),
		),
		array(
			'id'       => 'login-html-after',
			'type'     => 'ace_editor',
			'mode'     => 'html',
			'options'  => array(
				'minLines' => 10,
				'maxLines' => 30
			),
			'title'    => esc_html__( 'Content after the login form', 'scape' ),
			'subtitle' => esc_html__( 'Raw code for the content to display', 'scape' ),
		),
		array(
			'id'       => 'login-form-content-before',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content above the form in Sign In popup', 'scape' ),
			'desc' => esc_html__( 'Choose a content block to insert before the form in login popup.', 'scape' ),
			'placeholder' => esc_html__( 'None', 'scape' )
		),
		array(
			'id'       => 'login-form-content-after',
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content below the form in Sign In popup', 'scape' ),
			'desc' => esc_html__( 'Choose a content block to insert after the form in login popup.', 'scape' ),
			'placeholder' => esc_html__( 'None', 'scape' )
		),
	)

) );


// Button section
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Button', 'scape' ),
	'id'               => 'button-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-play-button'
) );

// primary button
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Primary button', 'scape' ),
	'desc'              => esc_html__( 'Default design of primary button.', 'scape' ),
	'id'                => 'btn-primary-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array(
		array(
			'id'        => 'btn-primary-selectors',
			'type'      => 'text',
			'title'     => esc_html__( 'Additional selectors', 'scape' ),
			'desc'      => esc_html__( 'List additional element selectors (separated with comma) that you want to look like a default button.', 'scape' ),
			'default'   => ''
		),
		array(
			'id'       => 'btn-primary-def-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Default state', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'btn-primary-text-def',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#ffffff',
				'alpha'     => 1,
				'rgba'  => 'rgba(255,255,255,1)'
			)
		),
		array(
			'id'        => 'btn-primary-bg-def',
			'type'      => 'color_rgba',
			'title'     => esc_html__( 'Background color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#8571ea',
				'alpha'     => 1,
				'rgba'  => 'rgba(133,113,234,1)'
			)
		),
		array(
			'id'        => 'btn-primary-border-def',
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'scape' ),
			'all'       => true,
			'default'   => array(
				'border-width'  => '0px',
				'border-style'  => 'solid',
				'border-color'  => '#8571ea'
			)
		),
		array(
			'id'        => 'btn-primary-border-radius-def',
			'type'      => 'spinner',
			'title'     => esc_html__( 'Border radius', 'scape' ),
			'default'  => '6',
			'min'      => '0',
			'step'     => '1',
			'max'      => '100',
		),
		array(
			'id'        => 'btn-primary-shadow-def',
			'type'     => 'button_set',
			'title'     => esc_html__( 'Shadow/glow effect', 'scape' ),
			'options'  => array(
				'none'      => esc_html__('None', 'scape'),
				'shadow'    => esc_html__('Shadow', 'scape'),
				'glow'      => esc_html__('Glow', 'scape')
			),
			'default'  => 'none'
		),
		array(
			'id'       => 'btn-primary-hover-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Hover state', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'btn-primary-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#ffffff',
				'alpha'     => 1,
				'rgba'  => 'rgba(255,255,255,1)'
			)
		),
		array(
			'id'        => 'btn-primary-bg-hover',
			'type'      => 'color_rgba',
			'title'     => esc_html__( 'Background color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color' => '#8257e2',
				'alpha' => 1,
				'rgba'  => 'rgba(130,87,226,1)'
			)
		),
		array(
			'id'        => 'btn-primary-border-hover',
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'scape' ),
			'all'       => true,
			'default'   => array(
				'border-width'  => '0px',
				'border-style'  => 'solid',
				'border-color'  => '#8257e2'
			)
		),
		array(
			'id'        => 'btn-primary-border-radius-hover',
			'type'      => 'spinner',
			'title'     => esc_html__( 'Border radius', 'scape' ),
			'default'  => '6',
			'min'      => '0',
			'step'     => '1',
			'max'      => '100',
		),
		array(
			'id'        => 'btn-primary-shadow-hover',
			'type'     => 'button_set',
			'title'     => esc_html__( 'Shadow/glow effect', 'scape' ),
			'options'  => array(
				'none'      => esc_html__('None', 'scape'),
				'shadow'    => esc_html__('Shadow', 'scape'),
				'glow'      => esc_html__('Glow', 'scape')
			),
			'default'  => 'none'
		),
	)
) );

// secondary button
Redux::set_section( $opt_name, array(
	'title'             => esc_html__( 'Secondary button', 'scape' ),
	'desc'              => esc_html__( 'Default design of secondary button.', 'scape' ),
	'id'                => 'btn-secondary-tab',
	'subsection'        => true,
	'customizer_width'  => '450px',
	'fields'            => array(
		array(
			'id'        => 'btn-secondary-selectors',
			'type'      => 'text',
			'title'     => esc_html__( 'Additional selectors', 'scape' ),
			'desc'      => esc_html__( 'List additional element selectors (separated with comma) that you want to look like a default button.', 'scape' ),
			'default'   => ''
		),
		array(
			'id'       => 'btn-secondary-def-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Default state', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'btn-secondary-text-def',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#151221',
				'alpha'     => 1,
				'rgba'  => 'rgba(45,53,67,1)'
			)
		),
		array(
			'id'        => 'btn-secondary-bg-def',
			'type'      => 'color_rgba',
			'title'     => esc_html__( 'Background color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#ffffff',
				'alpha'     => 1,
				'rgba'  => 'rgba(255,255,255,1)'
			)
		),
		array(
			'id'        => 'btn-secondary-border-def',
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'scape' ),
			'all'       => true,
			'default'   => array(
				'border-top'    => '1px',
				'border-right'  => '1px',
				'border-bottom' => '1px',
				'border-left'   => '1px',
				'border-style'  => 'solid',
				'border-color'  => '#ebebf5'
			)
		),
		array(
			'id'        => 'btn-secondary-border-radius-def',
			'type'      => 'spinner',
			'title'     => esc_html__( 'Border radius', 'scape' ),
			'default'  => '6',
			'min'      => '0',
			'step'     => '1',
			'max'      => '100',
		),
		array(
			'id'        => 'btn-secondary-shadow-def',
			'type'     => 'button_set',
			'title'     => esc_html__( 'Shadow/glow effect', 'scape' ),
			'options'  => array(
				'none'      => esc_html__('None', 'scape'),
				'shadow'    => esc_html__('Shadow', 'scape'),
				'glow'      => esc_html__('Glow', 'scape')
			),
			'default'  => 'none'
		),
		array(
			'id'       => 'btn-secondary-hover-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Hover state', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'btn-secondary-text-hover',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Text color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#151221',
				'alpha'     => 1,
				'rgba'      => 'rgba(45,53,67,1)'
			)
		),
		array(
			'id'        => 'btn-secondary-bg-hover',
			'type'      => 'color_rgba',
			'title'     => esc_html__( 'Background color', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color' => '#ffffff',
				'alpha' => 1,
				'rgba'  => 'rgba(255,255,255,1)'
			)
		),
		array(
			'id'        => 'btn-secondary-border-hover',
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'scape' ),
			'all'       => true,
			'default'   => array(
				'border-top'    => '1px',
				'border-right'  => '1px',
				'border-bottom' => '1px',
				'border-left'   => '1px',
				'border-style'  => 'solid',
				'border-color'  => 'rgba(255,255,255,0)'
			)
		),
		array(
			'id'        => 'btn-secondary-border-radius-hover',
			'type'      => 'spinner',
			'title'     => esc_html__( 'Border radius', 'scape' ),
			'default'  => '6',
			'min'      => '0',
			'step'     => '1',
			'max'      => '100',
		),
		array(
			'id'        => 'btn-secondary-shadow-hover',
			'type'     => 'button_set',
			'title'     => esc_html__( 'Shadow/glow effect', 'scape' ),
			'options'  => array(
				'none'      => esc_html__('None', 'scape'),
				'shadow'    => esc_html__('Shadow', 'scape'),
				'glow'      => esc_html__('Glow', 'scape')
			),
			'default'  => 'shadow'
		),
	)
) );

// Typography
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Typography', 'scape' ),
	'id'               => 'typography-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-text-color'
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'General', 'scape' ),
	'id'               => 'typography-general-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'typo-general',
			'type'     => 'wtbx_typography',
			'title'    => esc_html__( 'Website font settings', 'scape' ),
			'subtitle' => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
		    'default'  => array(
		    	'typography' => '{"font_family":"","backup_family":"","variants":"","subsets":"","transform":"","font_size":"15px","line_height":"1.9em","letter_spacing":""}'
		    )
		),
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Headings', 'scape' ),
	'id'               => 'typography-headings-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'        => 'typo-h',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Headings typography settings', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'font-size'     => false,
			'line-height'   => false,
			'default'  => array(
				'typography' => '{"font_family":"","backup_family":"","variants":"600","subsets":"","transform":"","letter_spacing":""}'
			)
		),
		array(
			'id'        => 'typo-h1',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'H1', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'backup-family'     => false,
			'subsets'           => false,
			'preview'           => false,
			'default'  => array(
				'typography' => '{"font_family":"","variants":"","transform":"","font_size":"40px","line_height":"1.5em","letter_spacing":""}'
			)
		),
		array(
			'id'        => 'typo-h2',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'H2', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'backup-family'     => false,
			'subsets'           => false,
			'preview'           => false,
			'default'  => array(
				'typography' => '{"font_family":"","variants":"","transform":"","font_size":"32px","line_height":"1.5em","letter_spacing":""}'
			)
		),
		array(
			'id'        => 'typo-h3',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'H3', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'backup-family'     => false,
			'subsets'           => false,
			'preview'           => false,
			'default'  => array(
				'typography' => '{"font_family":"","variants":"","transform":"","font_size":"26px","line_height":"1.5em","letter_spacing":""}'
			)
		),
		array(
			'id'        => 'typo-h4',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'H4', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'backup-family'     => false,
			'subsets'           => false,
			'preview'           => false,
			'default'  => array(
				'typography' => '{"font_family":"","variants":"","transform":"","font_size":"22px","line_height":"1.5em","letter_spacing":""}'
			)
		),
		array(
			'id'        => 'typo-h5',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'H5', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'backup-family'     => false,
			'subsets'           => false,
			'preview'           => false,
			'default'  => array(
				'typography' => '{"font_family":"","variants":"","transform":"","font_size":"18px","line_height":"1.5em","letter_spacing":""}'
			)
		),
		array(
			'id'        => 'typo-h6',
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'H6', 'scape' ),
			'subtitle'  => esc_html__( 'Will be used unless specific styles are applied to an element.', 'scape' ),
			'backup-family'     => false,
			'subsets'           => false,
			'preview'           => false,
			'default'  => array(
				'typography' => '{"font_family":"","variants":"","transform":"","font_size":"15px","line_height":"1.5em","letter_spacing":""}'
			)
		),
	)
) );

// Customization section
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Colors', 'scape' ),
	'id'               => 'customization-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-palette'
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Main theme colors', 'scape' ),
	'id'               => 'colors-main-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'color-main-accent',
			'type'     => 'color',
			'title'    => esc_html__( 'Main theme accent color', 'scape' ),
			'desc'     => esc_html__( 'Used in key interface elements.', 'scape' ),
			'default'  => '#8571ea',
		),
		array(
			'id'       => 'color-main-text-dark',
			'type'     => 'color',
			'title'    => esc_html__( 'Dark color', 'scape' ),
			'desc'     => esc_html__( 'Used in headings, as well as other bold and ui elements.', 'scape' ),
			'default'  => '#151221',
		),
		array(
			'id'       => 'color-main-bg-light',
			'type'     => 'color',
			'title'    => esc_html__( 'Light background', 'scape' ),
			'desc'     => esc_html__( 'Used as light background in theme interface elements.', 'scape' ),
			'default'  => '#f7f8fd',
		),
		array(
			'id'       => 'color-main-text-color',
			'type'     => 'color',
			'title'    => esc_html__( 'Default text color', 'scape' ),
			'desc'     => esc_html__( 'Used as default website text color.', 'scape' ),
			'default'  => '#687188',
		),
		array(
			'id'       => 'color-main-text-light',
			'type'     => 'color',
			'title'    => esc_html__( 'Light text color', 'scape' ),
			'desc'     => esc_html__( 'Used in secondary elements.', 'scape' ),
			'default'  => '#bbc2ce',
		),
		array(
			'id'       => 'color-main-border-color',
			'type'     => 'color',
			'title'    => esc_html__( 'Border color', 'scape' ),
			'desc'     => esc_html__( 'Used as default border color.', 'scape' ),
			'default'  => '#ebebf5',
		),
		array(
			'id'       => 'color-main-overlay-color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Overlay color', 'scape' ),
			'desc'     => esc_html__( 'Used as default overlay color.', 'scape' ),
			'default'  => array(
				'color' => '#151424',
				'alpha' => '0.5',
				'rgba'  => 'rgba(21, 20, 36, 0.5)'
			),
		    'options'   => array(
			    'show_initial' => true
		    )
		),
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Color palette', 'scape' ),
	'id'               => 'colors-palettes-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'color-palette-solid',
			'type'     => 'wtbx_color_palette',
			'title'    => esc_html__( 'Additional color palette', 'scape' ),
			'subtitle' => esc_html__( 'Choose additional colors to be used for content elements.', 'scape' ),
			'default'  => '',
		),
	)
) );

Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Components', 'scape' ),
	'id'               => 'components-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-layers'
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Sidebars', 'scape' ),
	'desc'             => wp_kses_post( __( 'Add and reorganize sidebars to be used on this site. Sidebars will be available for use <strong>after saving changes and reloading the page</strong>.', 'scape' )),
	'id'               => 'sidebars-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'page-layout-sidebar-widgetareas',
			'type'     => 'wtbx_sidebars',
			'title'    => esc_html__( 'Available sidebars', 'scape' ),
			'options'   => array(
				'222222'    => ''
			),
			'default'   => array(
				'111111'    => 'Page Sidebar',
			),
		)
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Lightbox', 'scape' ),
	'desc'             => esc_html__( 'Displayed while website elements such as images, posts, modals etc. are being loaded.', 'scape' ),
	'id'               => 'lightbox-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'lightbox-design-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Design &amp; performance', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'lightbox-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Lightbox overlay background color', 'scape' ),
			'default'  => array(
				'color' => '#141618',
				'alpha' => '0.95',
			    'rgba'  => 'rgba(20,22,24,0.95)'
			),
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'lightbox-scroll',
			'type'     => 'switch',
			'title'    => esc_html__( 'Navigation with mouse scroll', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-components-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Components', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'lightbox-thumbnail',
			'type'     => 'switch',
			'title'    => esc_html__( 'Gallery thumbnails', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-counter',
			'type'     => 'switch',
			'title'    => esc_html__( 'Image counter', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-share-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Share buttons', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'lightbox-share-facebook',
			'type'     => 'switch',
			'title'    => esc_html__( 'Facebook', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-share-googleplus',
			'type'     => 'switch',
			'title'    => esc_html__( 'Google+', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-share-linkedin',
			'type'     => 'switch',
			'title'    => esc_html__( 'LinkedIn', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-share-pinterest',
			'type'     => 'switch',
			'title'    => esc_html__( 'Pinterest', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-share-twitter',
			'type'     => 'switch',
			'title'    => esc_html__( 'Twitter', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'lightbox-share-vkontakte',
			'type'     => 'switch',
			'title'    => esc_html__( 'VK.com', 'scape' ),
			'default'  => '1',
		),
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Preloader', 'scape' ),
	'id'               => 'preloader-element-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'transition-global-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Website page transitions', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'transition-site-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Page transition effect', 'scape' ),
			'options'  => array(
				'fade'          => esc_html__('Fade', 'scape'),
				'fade_top'      => esc_html__('Fade top', 'scape'),
				'fade_bottom'   => esc_html__('Fade bottom', 'scape'),
				'fade_left'     => esc_html__('Fade left', 'scape'),
				'fade_right'    => esc_html__('Fade right', 'scape'),
				'slide_top'     => esc_html__('Slide top', 'scape'),
				'slide_bottom'  => esc_html__('Slide bottom', 'scape'),
				'slide_left'    => esc_html__('Slide left', 'scape'),
				'slide_right'   => esc_html__('Slide right', 'scape'),
			),
			'default'  => '',
			'placeholder'   => esc_html__( 'None', 'scape' ),
		),
		array(
			'id'       => 'transition-site-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Page transition layer background color', 'scape' ),
			'desc'     => esc_html__( 'If left empty, white color will be used.', 'scape' ),
			'default'  => '',
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'preloader-global-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Website preloader', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'preloader-site-style-global',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Preloader style', 'scape' ),
			'desc'     => esc_html__( 'Important: adding a page preloader switches off image lazy loading for elements, which it is not specifically switched on for.', 'scape' ),
			'options'  => array(
				''      => array(
					'alt'   => esc_html__('No preloader', 'scape'),
					'title' => esc_html__('No preloader', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/disable-square.png'
				),
				'1'      => array(
					'alt'   => esc_html__('Rotating arc', 'scape'),
					'title' => esc_html__('Rotating arc', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-1.png'
				),
				'2'      => array(
					'alt'   => esc_html__('Dynamic rotating arc', 'scape'),
					'title' => esc_html__('Dynamic arc', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-2.png'
				),
				'3'      => array(
					'alt'   => esc_html__('Dynamic rotating arc with gradient', 'scape'),
					'title' => esc_html__('Gradient arc', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-3.png'
				),
				'5'      => array(
					'alt'   => esc_html__('Blinking squares', 'scape'),
					'title' => esc_html__('Blinking squares', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-5.png'
				),
				'6'      => array(
					'alt'   => esc_html__('Equalizer', 'scape'),
					'title' => esc_html__('Equalizer', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-6.png'
				),
				'7'      => array(
					'alt'   => esc_html__('Rotating circles', 'scape'),
					'title' =>esc_html__('Rotating circles', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-7.png'
				),
				'8'      => array(
					'alt'   => esc_html__('Pulsating circle', 'scape'),
					'title' => esc_html__('Pulsating circle', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-8.png'
				),
				'9'      => array(
					'alt'   => esc_html__('Pulsating circles', 'scape'),
					'title' => esc_html__('Pulsating circles', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-9.png'
				),
				'10'      => array(
					'alt'   => esc_html__('Dynamic line', 'scape'),
					'title' => esc_html__('Dynamic line', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-10.png'
				),
				'11'      => array(
					'alt'   => esc_html__('Dynamic circle', 'scape'),
					'title' => esc_html__('Dynamic circle', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-11.png'
				),
				'12'      => array(
					'alt'   => esc_html__('Progress aligned', 'scape'),
					'title' => esc_html__('Progress aligned', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-12.png'
				),
				'13'      => array(
					'alt'   => esc_html__('Progress centered', 'scape'),
					'title' => esc_html__('Progress centered', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-13.png'
				),
				'14'      => array(
					'alt'   => esc_html__('Progress fullscreen', 'scape'),
					'title' => esc_html__('Progress fullscreen', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-14.png'
				),
				'15'      => array(
					'alt'   => esc_html__('Progress glowing', 'scape'),
					'title' => esc_html__('Progress glowing', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-15.png'
				),
				'16'      => array(
					'alt'   => esc_html__('Simple logo', 'scape'),
					'title' => esc_html__('Simple logo', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-16.png'
				),
				'17'      => array(
					'alt'   => esc_html__('Logo with progress', 'scape'),
					'title' => esc_html__('Logo with progress', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-17.png'
				),
			),
			'default'  => '',
		),
		array(
			'id'       => 'preloader-site-reveal',
			'type'     => 'select',
			'title'    => esc_html__( 'Website reveal animation', 'scape' ),
			'options'  => array(
				'fade'          => esc_html__('Fade', 'scape'),
				'scale'         => esc_html__('Scale', 'scape'),
				'slide_top'     => esc_html__('Slide top', 'scape'),
				'slide_bottom'  => esc_html__('Slide bottom', 'scape'),
				'slide_left'    => esc_html__('Slide left', 'scape'),
				'slide_right'   => esc_html__('Slide right', 'scape'),
			),
			'default'  => 'fade',
		),
		array(
			'id'       => 'preloader-site-color',
			'type'     => 'color',
			'title'    => esc_html__( 'Preloader color', 'scape' ),
			'desc'     => esc_html__( 'If left empty, theme accent color will be used.', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'preloader-site-bg',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Preload screen background color', 'scape' ),
			'desc'     => esc_html__( 'If left empty, white color will be used.', 'scape' ),
			'default'  => '',
			'options'   => array(
				'show_initial' => true
			)
		),
		array(
			'id'       => 'preloader-site-label',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Preloader label', 'scape' ),
			'options'  => array(
				''      => esc_html__('None', 'scape'),
				'text'  => esc_html__('Text', 'scape'),
				'image' => esc_html__('Image', 'scape'),
			),
			'default'  => 'text',
		),
		array(
			'id'       => 'preloader-site-image',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Upload your image file.', 'scape' ),
			'desc'     => esc_html__( 'Please choose an image that is at least 80x80 px.', 'scape' ),
		),
		array(
			'id'       => 'preloader-elements-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Elements preloader', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'preloader-elements-style',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Preloader style', 'scape' ),
			'options'  => array(
				''      => array(
					'alt'   => esc_html__('No preloader', 'scape'),
					'title' => esc_html__('No preloader', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/disable-square.png'
				),
				'1'      => array(
					'alt'   => esc_html__('Rotating arc', 'scape'),
					'title' => esc_html__('Rotating arc', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-1.png'
				),
				'2'      => array(
					'alt'   => esc_html__('Dynamic rotating arc', 'scape'),
					'title' => esc_html__('Dynamic arc', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-2.png'
				),
				'3'      => array(
					'alt'   => esc_html__('Dynamic rotating arc with gradient', 'scape'),
					'title' => esc_html__('Gradient arc', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-3.png'
				),
				'5'      => array(
					'alt'   => esc_html__('Blinking squares', 'scape'),
					'title' => esc_html__('Blinking squares', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-5.png'
				),
				'6'      => array(
					'alt'   => esc_html__('Equalizer', 'scape'),
					'title' => esc_html__('Equalizer', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-6.png'
				),
				'7'      => array(
					'alt'   => esc_html__('Rotating circles', 'scape'),
					'title' =>esc_html__('Rotating circles', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-7.png'
				),
				'8'      => array(
					'alt'   => esc_html__('Pulsating circle', 'scape'),
					'title' => esc_html__('Pulsating circle', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-8.png'
				),
				'9'      => array(
					'alt'   => esc_html__('Pulsating circles', 'scape'),
					'title' => esc_html__('Pulsating circles', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/preloader-9.png'
				),
			),
			'default'  => '1',
		),
		array(
			'id'       => 'preloader-elements-color',
			'type'     => 'color',
			'title'    => esc_html__( 'Preloader color', 'scape' ),
			'desc'     => esc_html__( 'If left empty, theme accent color will be used.', 'scape' ),
			'default'  => '',
		),
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Filter', 'scape' ),
	'desc'             => esc_html__( 'Filter used with post and portfolio grids.', 'scape' ),
	'id'               => 'grid-filter-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'gf-light-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Light skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'gf-light-accent',
			'type'     => 'color',
			'title'    => esc_html__( 'Accent color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'gf-light-shadow',
			'type'     => 'switch',
			'title'    => esc_html__( 'Slider knob shadow/glow', 'scape' ),
			'default'  => '',
		),

		array(
			'id'       => 'gf-dark-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Dark skin', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'gf-dark-accent',
			'type'     => 'color',
			'title'    => esc_html__( 'Accent color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'gf-dark-shadow',
			'type'     => 'switch',
			'title'    => esc_html__( 'Slider knob shadow/glow', 'scape' ),
			'default'  => '',
		)
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'To-Top button', 'scape' ),
	'desc'             => esc_html__( 'Clickable Scroll to-top button', 'scape' ),
	'id'               => 'totop-button-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'totop-enable',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable To-Top button', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'totop-style',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Button style', 'scape' ),
			'options'  => array(
				'circle-shadow' => esc_html__('Circle', 'scape'),
				'square-shadow' => esc_html__('Square', 'scape')
			),
			'default'  => 'circle-shadow',
			'required' => array( 'totop-enable', '=', true )
		),
	)
) );
//Redux::set_section( $opt_name, array(
//	'title'            => esc_html__( 'Custom cursor', 'scape' ),
//	'desc'             => esc_html__( 'Custom animated interactive cursor', 'scape' ),
//	'id'               => 'custom-cursor-tab',
//	'subsection'       => true,
//	'customizer_width' => '450px',
//	'fields'           => array(
//		array(
//			'id'       => 'cursor-enable',
//			'type'     => 'switch',
//			'title'    => esc_html__( 'Enable custom cursor', 'scape' ),
//			'default'  => '0',
//		),
//		array(
//			'id'       => 'cursor-style',
//			'type'     => 'button_set',
//			'title'    => esc_html__( 'Cursor style', 'scape' ),
//			'options'  => array(
//				'tidy' => esc_html__('Tidy', 'scape'),
//				'bold' => esc_html__('Bold', 'scape')
//			),
//			'default'  => 'tidy',
//		),
//		array(
//			'id'       => 'cursor-color-primary',
//			'type'     => 'color_rgba',
//			'title'    => esc_html__( 'Primary color', 'scape' ),
//			'default'  => array(
//				'color' => '#ea4c59',
//				'alpha' => '1',
//				'rgba'  => 'rgba(234,76,89,1)'
//			),
//			'options'   => array(
//				'show_initial' => true
//			),
//		),
//		array(
//			'id'       => 'cursor-color-secondary',
//			'type'     => 'color_rgba',
//			'title'    => esc_html__( 'Secondary color', 'scape' ),
//			'default'  => array(
//				'color' => '#ea4c59',
//				'alpha' => '1',
//				'rgba'  => 'rgba(234,76,89,1)'
//			),
//			'options'   => array(
//				'show_initial' => true
//			),
//		),
//	)
//) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Theme fonts', 'scape' ),
	'id'               => 'theme-fonts-section',
	'customizer_width' => '400px',
	'icon'             => 'scape-ui-text-box'
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Font pool', 'scape' ),
	'desc'             => esc_html__( 'Add fonts to the global fonts pool. They will become available to use in the theme after saving the changes and reloading the page.', 'scape' ),
	'id'               => 'custom-custom-font-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'custom_fonts',
			'type'     => 'wtbx_custom_font',
		)
	)
) );
Redux::set_section( $opt_name, array(
	'title'            => esc_html__( 'Icon fonts', 'scape' ),
	'desc'             => wp_kses_post( __( 'Add custom icon fonts which will become available for use in the theme. They will become available to use in the theme after saving the changes and reloading the page. Please note that you need create an icon font on <strong>Icomoon</strong>, export it and then upload using this form.', 'scape' )),
	'id'               => 'custom-icon-font-tab',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'custom_icon_font',
			'type'     => 'wtbx_icon_font',
			'url'      => true,
			'title'    => wp_kses_post( __( 'Upload the font <code>.Zip</code> archive', 'scape' )),
		),
	)
) );

function wtbx_header_options($base = '') {
	$output = array(
		array(
			'id'       => 'header-section-start-'.$base,
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Header navigation', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'header-menu-'.$base,
			'type'     => 'select',
			'data'     => 'menu',
			'title'    => esc_html__( 'Header menu', 'scape' ),
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
			'subtitle' => esc_html__( 'Choose a menu to display in page header.', 'scape' ),
		),
		array(
			'id'       => 'header-m-menu-'.$base,
			'type'     => 'select',
			'data'     => 'menu',
			'title'    => esc_html__( 'Mobile header menu', 'scape' ),
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
			'subtitle' => esc_html__( 'Choose a menu to display in mobile header.', 'scape' ),
		),
		array(
			'id'       => 'header-style-'.$base,
			'type'     => 'image_select',
			'title'    => esc_html__( 'Header style', 'scape' ),
			'options'  => array(
				''      => array(
					'alt'   => esc_html__('Inherit', 'scape'),
					'title' => esc_html__('Inherit', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/inherit.png'
				),
				'off'      => array(
					'alt'   => esc_html__('No header', 'scape'),
					'title' => esc_html__('No header', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/disable.png'
				),
				'1'      => array(
					'alt'   => esc_html__('Default', 'scape'),
					'title' => esc_html__('Style 1', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-1.png'
				),
				'2'      => array(
					'alt'   => esc_html__('Default - transparent', 'scape'),
					'title' => esc_html__('Style 1 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-2.png'
				),
				'3'      => array(
					'alt'   => esc_html__('Menu bottom', 'scape'),
					'title' => esc_html__('Style 2', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-3.png'
				),
				'4'      => array(
					'alt'   => esc_html__('Menu bottom - transparent', 'scape'),
					'title' => esc_html__('Style 2 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-4.png'
				),
				'5'      => array(
					'alt'   => esc_html__('Logo in center', 'scape'),
					'title' => esc_html__('Style 3', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-5.png'
				),
				'6'      => array(
					'alt'   => esc_html__('Logo in center - transparent', 'scape'),
					'title' => esc_html__('Style 3 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-6.png'
				),
				'7'      => array(
					'alt'   => esc_html__('Slide in from top', 'scape'),
					'title' => esc_html__('Style 4', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-7.png'
				),
				'8'      => array(
					'alt'   => esc_html__('Menu centered', 'scape'),
					'title' => esc_html__('Style 5', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-8.png'
				),
				'9'      => array(
					'alt'   => esc_html__('Menu centered - transparent', 'scape'),
					'title' => esc_html__('Style 5 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-9.png'
				),
				'15'      => array(
					'alt'   => esc_html__('Logo and menu centered', 'scape'),
					'title' => esc_html__('Style 6', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-15.png'
				),
				'16'      => array(
					'alt'   => esc_html__('Logo and menu centered - transparent', 'scape'),
					'title' => esc_html__('Style 6 (alt)', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-16.png'
				),
				'10'      => array(
					'alt'   => esc_html__('Overlay - centered button', 'scape'),
					'title' => esc_html__('Style 7', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-10.png'
				),
				'11'      => array(
					'alt'   => esc_html__('Overlay - right-aligned button', 'scape'),
					'title' => esc_html__('Style 8', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-11.png'
				),
				'12'      => array(
					'alt'   => esc_html__('Left centered', 'scape'),
					'title' => esc_html__('Style 9', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-12.png'
				),
				'13'      => array(
					'alt'   => esc_html__('Left', 'scape'),
					'title' => esc_html__('Style 10', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-13.png'
				),
				'14'      => array(
					'alt'   => esc_html__('Left hidden', 'scape'),
					'title' => esc_html__('Style 11', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/header-style-14.png'
				),
			),
			'default'  => wtbx_option_defaults('header-style', $base)
		),
		array(
			'id'       => 'header-skin-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Header skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark' => esc_html__( 'Dark', 'scape' ),
			),
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'sticky-style-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Sticky header style', 'scape' ),
			'options'  => array(
				'disabled'  => esc_html__( 'Disabled', 'scape' ),
				'default'   => esc_html__( 'Default', 'scape' ),
				'scroll'    => esc_html__( 'On scroll up', 'scape' )
			),
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'sticky-skin-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Sticky header skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark' => esc_html__( 'Dark', 'scape' ),
			),
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
	);

	return $output;
}

function wtbx_header_section_options($base = '') {
	$output = array(
		array(
			'id'       => $base.'-header-section-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Hero section', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'header-section-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Hero section', 'scape' ),
			'options'  => array(
				'off'           => esc_html__( 'Disable', 'scape' ),
				'default'       => esc_html__( 'Default', 'scape' ),
				'content_block' => esc_html__( 'Content block', 'scape' ),
			),
			'default'  => wtbx_option_defaults('header-section', $base),
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'header-section-block-'.$base,
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'desc' => esc_html__( 'Choose a content block to insert as a page hero section.', 'scape' ),
			'subtitle' => esc_html__( 'Only for content block section type.', 'scape' ),
			'placeholder' => esc_html__( 'Inherit', 'scape' )
		),
		array(
			'id'       => 'header-section-layout-'.$base,
			'type'     => 'image_select',
			'title'    => esc_html__( 'Hero section layout', 'scape' ),
			'options'  => array(
				''         => array(
					'alt'   => esc_html__('Inherit', 'scape'),
					'title' => esc_html__('Inherit', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/inherit.png'
				),
				'one'      => array(
					'alt'   => esc_html__('Centered', 'scape'),
					'title' => esc_html__('Layout 1', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-1.png'
				),
				'two'      => array(
					'alt'   => esc_html__('Centered, bottom-aligned breadcrumbs', 'scape'),
					'title' => esc_html__('Layout 2', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-2.png'
				),
				'three'      => array(
					'alt'   => esc_html__('Left-aligned', 'scape'),
					'title' => esc_html__('Layout 3', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-3.png'
				),
				'four'      => array(
					'alt'   => esc_html__('Right-aligned', 'scape'),
					'title' => esc_html__('Layout 4', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-4.png'
				),
				'five'      => array(
					'alt'   => esc_html__('Left-aligned separated', 'scape'),
					'title' => esc_html__('Layout 5', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-5.png'
				),
				'six'      => array(
					'alt'   => esc_html__('Right-aligned separated', 'scape'),
					'title' => esc_html__('Layout 6', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/hero-layout-6.png'
				),
			),
			'default'  => wtbx_option_defaults('header-section-layout'),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'            => 'header-section-height-slider-'.$base,
			'type'          => 'slider',
			'title'         => esc_html__( 'Relative height', 'scape' ),
			'desc'          => esc_html__( 'Height as percentage of screen size. Set to <code>0</code> to disable or <code>-1</code> to inherit.', 'scape' ),
			'default'       => -1,
			'min'           => -1,
			'step'          => 1,
			'max'           => 100,
			'resolution'    => 1,
			'display_value' => 'label',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-height-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Min. height', 'scape' ),
			'desc'     => esc_html__( 'Minimum height in pixels. Set to <code>0</code> disable or leave empty to inherit.', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-padding-top-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Additional top padding', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-padding-bottom-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Additional bottom padding', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-bg-image-'.$base,
			'type'     => 'background',
			'url'      => true,
			'title'    => esc_html__( 'Background', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-bg-featured-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Use featured image', 'scape' ),
			'desc'     => esc_html__( 'Use featured image for each post instead', 'scape' ),
			'options'  => array(
				'on'   => esc_html__( 'Yes', 'scape' ),
				'off'  => esc_html__( 'No', 'scape' ),
			),
			'default'  => '',
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-overlay-color-'.$base,
			'type'      => 'color_rgba',
			'title'    => esc_html__( 'Overlay color', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => false,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'show_buttons'              => true,
				'input_text'                => 'Select Color'
			),
		),
		array(
			'id'       => 'header-section-scroll-full-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Full hero section scroll', 'scape' ),
			'desc'     => esc_html__( 'If enabled, hero section will be fully scrolled down on first user scroll event.', 'scape' ),
			'options'  => array(
				'1'     => esc_html__( 'On', 'scape' ),
				'none'  => esc_html__( 'Off', 'scape' )
			),
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-parallax-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Image parallax effect', 'scape' ),
			'options'  => array(
				'none'                      => esc_html__( 'None', 'scape' ),
				'wtbx_parallax_scroll'      => esc_html__( 'Scroll parallax', 'scape' ),
				'wtbx_parallax_mousemove'   => esc_html__( 'Mouse move parallax', 'scape' )
			),
			'default'  => '',
			'placeholder' => esc_html__('Inherit', 'scape'),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-fadeout-'.$base,
			'type'     => 'switch',
			'title'    => esc_html__( 'Content fadeout effect', 'scape' ),
			'desc'     => esc_html__( 'If enabled, hero section content will shift and fade out as the user scrolls down.', 'scape' ),
			'default'  => '',
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-decoration-layout-'.$base,
			'type'     => 'image_select',
			'title'    => esc_html__( 'Decoration style', 'scape' ),
			'options'  => array(
				''         => array(
					'alt'   => esc_html__('Inherit', 'scape'),
					'title' => esc_html__('Inherit', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/inherit.png'
				),
				'off'      => array(
					'alt'   => esc_html__('None', 'scape'),
					'title' => esc_html__('None', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-none.png'
				),
				'curve-top'      => array(
					'alt'   => esc_html__('Curve top', 'scape'),
					'title' => esc_html__('Curve top', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-curve-top.png'
				),
				'curve-bottom'      => array(
					'alt'   => esc_html__('Curve bottom', 'scape'),
					'title' => esc_html__('Curve bottom', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-curve-bottom.png'
				),
				'notch-bottom'      => array(
					'alt'   => esc_html__('Notch', 'scape'),
					'title' => esc_html__('Notch', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-notch.png'
				),
				'notch-top'      => array(
					'alt'   => esc_html__('Notch reversed', 'scape'),
					'title' => esc_html__('Notch reversed', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-notch-reversed.png'
				),
				'waves-1'      => array(
					'alt'   => esc_html__('Waves 1', 'scape'),
					'title' => esc_html__('Waves 1', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-waves-1.png'
				),
				'waves-2'      => array(
					'alt'   => esc_html__('Waves 2', 'scape'),
					'title' => esc_html__('Waves 2', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/divider-waves-2.png'
				)
			),
			'default'  => '',
		),
		array(
			'id'       => 'header-section-skin-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Hero section content skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
			'default'  => '',
		),
		array(
			'id'        => 'header-section-title-'.$base,
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Title font style', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'        => 'header-section-bc-'.$base,
			'type'      => 'wtbx_typography',
			'title'     => esc_html__( 'Breadcrumbs font', 'scape' ),
			'subtitle' => esc_html__( 'Only for default hero section type.', 'scape' ),
		),
		array(
			'id'       => 'header-section-decoration-color-'.$base,
			'type'     => 'color',
			'title'    => esc_html__( 'Decoration color', 'scape' ),
			'desc' => esc_html__( 'You may want to match it with the background of your page of the first row on it.', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'header-section-scrolldown-style-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( '"Scroll-down" button', 'scape' ),
			'options'  => array(
				'none'              => esc_html__( 'None', 'scape' ),
				'arrow-single'      => esc_html__( 'Arrow down', 'scape' ),
				'angle-down'        => esc_html__( 'Angle down in circle', 'scape' ),
				'angle-down-cont'   => esc_html__( 'Angle down in round container', 'scape' ),
				'mouse-simple'      => esc_html__( 'Mouse icon', 'scape' ),
			),
			'default'  => '',
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'header-section-scrolldown-skin-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( '"Scroll-down" button skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => '',
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
		),
	);

	return $output;
}

function wtbx_layout_options($base = '') {
	$output = array(
		array(
			'id'       => 'post-layout-start-'.$base,
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Layout', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'preloader-site-style-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Page preloader', 'scape' ),
			'desc'     => esc_html__( 'Important: adding a page preloader switches off image lazy loading for elements, which it is not specifically switched on for.', 'scape' ),
			'options'  => array(
				'off'    => esc_html__('No preloader', 'scape'),
				'1'      => esc_html__('Rotating arc', 'scape'),
				'2'      => esc_html__('Dynamic rotating arc', 'scape'),
				'3'      => esc_html__('Dynamic rotating arc with gradient', 'scape'),
				'5'      => esc_html__('Blinking squares', 'scape'),
				'6'      => esc_html__('Equalizer', 'scape'),
				'7'      => esc_html__('Rotating circles', 'scape'),
				'8'      => esc_html__('Pulsating circle', 'scape'),
				'9'      => esc_html__('Pulsating circles', 'scape'),
				'10'     => esc_html__('Dynamic line', 'scape'),
				'12'     => esc_html__('Progress aligned', 'scape'),
				'13'     => esc_html__('Progress centered', 'scape'),
				'14'     => esc_html__('Progress fullscreen', 'scape'),
				'15'     => esc_html__('Progress glowing', 'scape'),
			),
			'default'  => '',
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'page-layout-fullwidth-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Layout width', 'scape' ),
			'options'  => array(
				'width-default' => esc_html__( 'Default site width', 'scape' ),
				'width-full'    => esc_html__( 'Full page width', 'scape' ),
			),
			'default'       => 'width-default',
			'placeholder'   => esc_html__( 'Inherit', 'scape' )
		),
		array(
			'id'       => 'page-layout-width-limit-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Content width limit', 'scape' ),
			'subtitle' => esc_html__( 'Only for default site width.', 'scape' ),
			'desc'     => wp_kses_post( __( 'Units - <code>px</code>.', 'scape' ))
		),
		array(
			'id'       => 'page-layout-space-'.$base,
			'type'     => 'spacing',
			'mode'     => 'padding',
			'title'    => esc_html__( 'Extra page padding', 'scape' ),
			'desc'     => wp_kses_post( __( 'Add extra space around the page content. Units - <code>px</code>.', 'scape' )),
			'units'    => 'px',
			'default'  => array(
				'padding-top'    => '0',
				'padding-right'  => '0',
				'padding-bottom' => '0',
				'padding-left'   => '0'
			)
		),
		array(
			'id'       => 'page-layout-content-bg-'.$base,
			'type'     => 'color',
			'title'    => esc_html__( 'Page background color', 'scape' ),
		),
		array(
			'id'       => 'page-layout-content-padding-top-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Content top padding', 'scape' ),
			'desc'     => wp_kses_post( __( 'Units - <code>px</code>.', 'scape' )),
		    'default'  => wtbx_option_defaults('content-padding-top', $base)
		),
		array(
			'id'       => 'page-layout-content-padding-bottom-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Content bottom padding', 'scape' ),
			'desc'     => wp_kses_post( __( 'Units - <code>px</code>.', 'scape' )),
			'default'  => wtbx_option_defaults('content-padding-bottom', $base)
		),
		($base === 'blog' || $base === 'portfolio' || $base === 'author' ? array(
			'id'       => 'page-layout-content-padding-side-'.$base,
			'type'     => 'switch',
			'title'    => esc_html__( 'Side padding', 'scape' ),
			'subtitle' => esc_html__( 'Switch off to disable content padding on the left and on the right.', 'scape' ),
			'desc'     => esc_html__( 'Useful when full-width grid is used to display archive items.', 'scape' ),
			'default'  => '1'
		) : null),
		array(
			'id'       => 'page-layout-'.$base,
			'type'     => 'image_select',
			'title'    => esc_html__( 'Page layout', 'scape' ),
			'options'  => array(
				''      => array(
					'alt'   => esc_html__( 'Inherit', 'scape' ),
					'title' => esc_html__('Inherit', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/inherit.png'
				),
				'no_sidebar'      => array(
					'alt'   => esc_html__( 'No sidebar', 'scape' ),
					'title' => esc_html__('Full width content', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-no-sidebar.png'
				),
				'sidebar_left'      => array(
					'alt'   => esc_html__( 'Left sidebar', 'scape' ),
					'title' => esc_html__('Left sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-left-sidebar.png'
				),
				'sidebar_left_sticky'      => array(
					'alt'   => esc_html__( 'Left sticky sidebar', 'scape' ),
					'title' => esc_html__('Left sticky sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-left-sticky-sidebar.png'
				),
				'sidebar_right'      => array(
					'alt'   => esc_html__('Right sidebar', 'scape'),
					'title' => esc_html__('Right sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-right-sidebar.png'
				),
				'sidebar_right_sticky'      => array(
					'alt'   => esc_html__('Right sticky sidebar', 'scape'),
					'title' => esc_html__('Right sticky sidebar', 'scape'),
					'img'   => WTBX_URI . '/library/images/admin/page-layout-right-sticky-sidebar.png'
				),
			),
			'default'  => '',
		),
		array(
			'id'       => 'page-layout-sidebar-width-slider-'.$base,
			'type'          => 'slider',
			'title'         => esc_html__( 'Sidebar width', 'scape' ),
			'subtitle'      => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'desc'          => wp_kses_post( __( 'Set to <code>-1</code> to inherit value.', 'scape' )),
			'default'       => -1,
			'min'           => -1,
			'step'          => 1,
			'max'           => 500,
			'resolution'    => 1,
			'display_value' => 'text',
		),
		array(
			'id'       => 'page-layout-sidebar-padding-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Sidebar top padding', 'scape' ),
			'subtitle' => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'desc'     => wp_kses_post( __( 'Use this to make sidebar content start at the same level as the main page content. Units - <code>px</code>.', 'scape' )),
			'default'  => '',
		),
		array(
			'id'       => 'page-layout-sidebar-skin-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Sidebar content skin', 'scape' ),
			'subtitle' => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'page-layout-sidebar-widgetarea-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Sidebar to use', 'scape' ),
			'subtitle' => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
			'data'     => 'callback',
			'args'     => 'wtbx_sidebars_array_ext',
			'placeholder'   => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'        => 'page-layout-sidebar-font-size-'.$base,
			'type'      => 'wtbx_typography',
			'font-family'       => false,
			'backup-family'     => false,
			'subsets'           => false,
			'weight-style'      => false,
			'line-height'       => false,
			'letter-spacing'    => false,
			'transform'         => false,
			'preview'           => false,
			'title'     => esc_html__( 'Sidebar base font size', 'scape' ),
			'subtitle'  => esc_html__( 'Only for page layouts with sidebar.', 'scape' ),
		),
	);

	return $output;
}



function wtbx_footer_options($base = '') {
	$output = array(
		array(
			'id'       => 'footer-start-'.$base,
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Footer', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => 'footer-enable-'.$base,
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable footer', 'scape' ),
			'default'  => '1',
		),
		array(
			'id'       => 'footer-block-'.$base,
			'type'     => 'select',
			'data'     => 'posts',
			'args'     => array(
				'post_type' => 'content_block',
				'posts_per_page'=> -1,
			),
			'placeholder' => esc_html__('Inherit', 'scape'),
			'title'    => esc_html__( 'Content block', 'scape' ),
			'subtitle' => esc_html__( 'Choose a content block to insert as a footer.', 'scape' ),
		),
		array(
			'id'       => 'footer-style-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Footer style', 'scape' ),
			'options'  => array(
				'default' => esc_html__('Default', 'scape'),
				'under' => esc_html__('Underlying', 'scape'),
			),
			'placeholder' => esc_html__('Inherit', 'scape'),
		),
		array(
			'id'       => 'footer-breakpoint-'.$base,
			'type'     => 'text',
			'title'    => esc_html__( 'Underlying footer breakpoint', 'scape' ),
			'subtitle' => wp_kses_post( __( 'Switch to default header style under this width. Units - <strong>px</strong>.', 'scape' )),
			'required' => array( 'footer-style-global', '=', 'under' ),
		),
		array(
			'id'       => 'footer-skin-'.$base,
			'type'     => 'select',
			'title'    => esc_html__( 'Widgets skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' ),
			),
			'default'  => 'light',
			'placeholder' => esc_html__( 'Inherit', 'scape' ),
		),
		array(
			'id'       => 'footer-color-text-'.$base,
			'type'     => 'color',
			'title'    => esc_html__( 'Default text color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-text-dark'.$base,
			'type'     => 'color',
			'title'    => esc_html__( 'Dark text color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-text-light'.$base,
			'type'     => 'color',
			'title'    => esc_html__( 'Light text color', 'scape' ),
			'default'  => '',
		),
		array(
			'id'       => 'footer-color-link'.$base,
			'type'     => 'color',
			'title'    => esc_html__( 'Link hover color', 'scape' ),
			'default'  => '',
		)
	);

	return $output;
}

function wtbx_navbar_options($base = '') {
	$output = array(
		array(
			'id'       => $base.'-navigation-start',
			'type'     => 'wtbx_toggle',
			'title'    => esc_html__( 'Navigation bar', 'scape' ),
			'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'       => $base.'-navigation-layout',
			'type'     => 'select',
			'title'    => esc_html__( 'Layout', 'scape' ),
			'options'  => array(
				'top'       => esc_html__( 'Top', 'scape' ),
				'bottom'    => esc_html__( 'Bottom', 'scape' ),
				'sticky'    => esc_html__( 'Sticky', 'scape' ),
				'images'    => esc_html__( 'Image preview', 'scape' ),
			),
			'default'  => 'bottom',
			'placeholder'   => esc_html__( 'Disable', 'scape' ),
		),
		array(
			'id'       => $base.'-navigation-skin',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Navigation skin', 'scape' ),
			'options'  => array(
				'light' => esc_html__( 'Light', 'scape' ),
				'dark'  => esc_html__( 'Dark', 'scape' )
			),
			'required' => array( $base.'-navigation-layout', '=', array('top', 'bottom') ),
			'default'  => 'light'
		),
		array(
			'id'       => $base.'-navigation-parent',
			'type'     => 'switch',
			'title'    => esc_html__( '"Back to list" button', 'scape' ),
			'default'  => '1',
			'required' => array( $base.'-navigation-layout', '=', array('top', 'bottom') ),
		),
		array(
			'id'       => $base.'-navigation-buttons',
			'type'     => 'switch',
			'title'    => esc_html__( 'Navigation buttons', 'scape' ),
			'required' => array( $base.'-navigation-layout', '=', array('top', 'bottom') ),
			'default'  => '1'
		)
	);

	return $output;
}

function wtbx_custom_post_type_options($opt_name) {
	$options = get_option('wtbx_scape');
	if ( !empty($options['custom-post-types']) ) {
		$custom_post_types = $options['custom-post-types'];

		if ( !empty($custom_post_types) && is_array($custom_post_types) ) {
			foreach ( $custom_post_types as $key => $id ) {
				if ( !empty($id) ) {
					$singular_id = $id . '-item';
					$name = ucfirst(str_replace('_', ' ', str_replace('-', ' ', $id)));

					Redux::set_section( $opt_name, array(
						'title'            => sprintf(esc_html__('%s', 'scape' ), $name),
						'id'               => $id.'-custom-section',
						'customizer_width' => '400px',
						'icon'             => 'scape-ui-box'
					) );

					Redux::set_section( $opt_name, array(
						'title'            => sprintf(esc_html__('%s archives', 'scape' ), $name),
						'id'               => $id.'-custom-tab',
						'subsection'       => true,
						'customizer_width' => '450px',
						'fields'           => array_merge(
							wtbx_header_options($id),
							wtbx_header_section_options($id),
							wtbx_layout_options($id),
							wtbx_footer_options($id)
						)
					) );

					Redux::set_section( $opt_name, array(
						'title'            => sprintf(esc_html__('Single %s', 'scape' ), $name),
						'id'               => $singular_id.'-custom-tab',
						'subsection'       => true,
						'customizer_width' => '450px',
						'fields'           => array_merge(
							wtbx_header_options($singular_id),
							wtbx_header_section_options($singular_id),
							wtbx_layout_options($singular_id),
							wtbx_navbar_options($id),
							wtbx_footer_options($singular_id)
						)
					) );
				}
			}
		}
	}
};

function wtbx_option_defaults($option, $base = '') {
	if ( $base = 'search' ) {
		$base = 'utility';
	} elseif ( $base === 'page' ) {
		$base = 'page';
	} else {
		$base = 'post-type';
	}

	$array = array(
		'post-type' => array(
			'header-style' => '',
			'header-section' => 'off',
			'header-section-layout' => 'five',
			'content-padding-top' => '120',
		),
		'page' => array(
			'header-style' => '',
			'header-section' => '',
			'header-section-layout' => 'five',
		),
		'utility' => array(
			'header-style' => '',
			'header-section' => 'default',
			'header-section-layout' => 'five',
			'content-padding-top' => '',
			'content-padding-bottom' => '',
		),
	    '404' => array(
		    'header-style' => 'off',
		    'header-section' => 'off',
		    'header-section-layout' => '',
		    'content-padding-top' => '0',
		    'content-padding-bottom' => '0'
	    )
	);
	
	return $array[$base][$option];
}