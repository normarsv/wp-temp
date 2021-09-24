<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb2_admin_init', 'wtbx_global_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function wtbx_global_metaboxes() {
	$base = 'single';
	$post_type = get_post_type(wtbx_vc_get_the_id());

	$tabs = [esc_html__('Header', 'core-extension'), esc_html__('Hero Section', 'core-extension'), esc_html__('Layout', 'core-extension'), esc_html__('Footer', 'core-extension'), esc_html__('Miscellaneous', 'core-extension'), esc_html__('Navigation', 'core-extension'), esc_html__('Post/Portfolio grid', 'core-extension')];
	$tabs = implode(',', $tabs);

	$object_array = array( 'page', 'post', 'portfolio', 'product' );

	$options = get_option('wtbx_scape');
	if ( isset($options['custom-post-types']) ) {
		$custom_post_types = $options['custom-post-types'];

		if ( !empty($custom_post_types) && is_array($custom_post_types) ) {
			foreach ( $custom_post_types as $key => $id ) {
				$object_array[] = $id;
			}
		}
	}

	$global = new_cmb2_box( array(
		'id'            => 'metabox-global-'.$base,
		'title'         => esc_html__( 'Page settings', 'core-extension' ),
		'object_types'  => $object_array,
		'context'       => 'normal',
		'priority'      => 'high',
	) );
	$global->add_field( array(
		'id'    => 'header-menu-'.$base,
		'type'  => 'select',
		'name'  => esc_html__( 'Header menu', 'core-extension' ),
		'desc'  => esc_html__( 'Choose a menu to display in page header.', 'core-extension' ),
		'options' => wtbx_get_menus(),
		'row_classes'   => 'tab_1'
	) );
	$global->add_field( array(
		'id'       => 'header-m-menu-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Mobile header menu', 'core-extension' ),
		'desc' => esc_html__( 'Choose a menu to display in mobile header.', 'core-extension' ),
		'options' => wtbx_get_menus(),
		'row_classes'   => 'tab_1'
	) );
	$global->add_field( array(
		'id'       => 'header-style-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Header style', 'core-extension' ),
		'options'  => array(
			'' => esc_html__('Inherit', 'core-extension'),
			'off' => esc_html__('No header', 'core-extension'),
			'1' => esc_html__('Style 1', 'core-extension'),
			'2' => esc_html__('Style 1 (alt)', 'core-extension'),
			'3' => esc_html__('Style 2', 'core-extension'),
			'4' => esc_html__('Style 2 (alt)', 'core-extension'),
			'5' => esc_html__('Style 3', 'core-extension'),
			'6' => esc_html__('Style 3 (alt)', 'core-extension'),
			'7' => esc_html__('Style 4', 'core-extension'),
			'8' => esc_html__('Style 5', 'core-extension'),
			'9' => esc_html__('Style 5 (alt)', 'core-extension'),
			'15' => esc_html__('Style 6', 'core-extension'),
			'16' => esc_html__('Style 6 (alt)', 'core-extension'),
			'10' => esc_html__('Style 7', 'core-extension'),
			'11' => esc_html__('Style 8', 'core-extension'),
			'12' => esc_html__('Style 9', 'core-extension'),
			'13' => esc_html__('Style 10', 'core-extension'),
			'14' => esc_html__('Style 11', 'core-extension')
		),
		'row_classes'   => 'tab_1'
	) );
	$global->add_field( array(
		'id'       => 'header-skin-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Header skin', 'core-extension' ),
		'options'  => array(
			''      => esc_html__('Inherit', 'core-extension'),
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' ),
		),
		'row_classes'   => 'tab_1'
	) );
	$global->add_field( array(
		'id'        => 'sticky-style-'.$base,
		'type'      => 'select',
		'name'      => esc_html__( 'Sticky header style', 'core-extension' ),
		'options'   => array(
			''          => esc_html__('Inherit', 'core-extension'),
			'disabled'  => esc_html__( 'Disabled', 'core-extension' ),
			'default'   => esc_html__( 'Default', 'core-extension' ),
			'scroll'    => esc_html__( 'On scroll up', 'core-extension' )
		),
		'row_classes'   => 'tab_1'
	) );
	$global->add_field( array(
		'id'       => 'sticky-skin-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Sticky header skin', 'core-extension' ),
		'options'  => array(
			''      => esc_html__('Inherit', 'core-extension'),
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' ),
		),
		'row_classes'   => 'tab_1'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Hero section type', 'core-extension' ),
		'id'   => 'header-section-'.$base,
		'type' => 'select',
		'options'  => array(
			''              => esc_html__( 'Inherit', 'core-extension' ),
			'off'           => esc_html__( 'Disable', 'core-extension' ),
			'default'       => esc_html__( 'Default', 'core-extension' ),
			'content_block' => esc_html__( 'Content block', 'core-extension' ),
			'custom_1'      => esc_html__( 'Layout for posts - style 1', 'core-extension' ),
			'custom_2'      => esc_html__( 'Layout for posts - style 2', 'core-extension' ),
		),
		'before_row'    => '<div class="wtbx-tabnames" data-tabnames="'.esc_attr($tabs).'"></div>',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'     => esc_html__( 'Content block', 'core-extension' ),
		'desc'     => esc_html__( 'Choose a content block to insert as a page header section. (Only for content block hero section type)', 'core-extension' ),
		'id'       => 'header-section-block-'.$base,
		'type'     => 'select',
		'options_cb' => 'wtbx_content_block_select',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Hero section layout', 'core-extension' ),
		'desc' => esc_html__( '(Only for default hero section type)', 'core-extension' ),
		'id'   => 'header-section-layout-'.$base,
		'type' => 'select',
		'options'  => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'one'   => esc_html__( 'Layout 1', 'core-extension' ),
			'two'   => esc_html__( 'Layout 2', 'core-extension' ),
			'three' => esc_html__( 'Layout 3', 'core-extension' ),
			'four'  => esc_html__( 'Layout 4', 'core-extension' ),
			'five'  => esc_html__( 'Layout 5', 'core-extension' ),
			'six'   => esc_html__( 'Layout 6', 'core-extension' ),
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'          => esc_html__( 'Relative height', 'core-extension' ),
		'desc'          => wp_kses_post( __( 'Set to <code>0</code> to inherit value from Theme Options. (Only for default hero section type)', 'core-extension' )),
		'id'            => 'header-section-height-slider-'.$base,
		'type'          => 'wtbx_slider',
		'min'           => '-1',
		'max'           => '100',
		'default'       => '-1',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Min. height', 'core-extension' ),
		'desc' => wp_kses_post( __( 'Enter value in pixels, e.g. <code>500px</code>. Leave empty to inherit value from Theme Options. (Only for default hero section type)', 'core-extension' )),
		'id'   => 'header-section-height-'.$base,
		'type' => 'text_small',
		'default' => '',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Additional top padding', 'core-extension' ),
		'desc' => wp_kses_post( __( 'Enter value in pixels, e.g. <code>500px</code>. Leave empty to inherit value from Theme Options. (Only for default hero section type)', 'core-extension' )),
		'id'   => 'header-section-padding-top-'.$base,
		'type' => 'text_small',
		'default' => '',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Additional bottom padding', 'core-extension' ),
		'desc' => wp_kses_post( __( 'Enter value in pixels, e.g. <code>500px</code>. Leave empty to inherit value from Theme Options. (Only for default hero section type)', 'core-extension' )),
		'id'   => 'header-section-padding-bottom-'.$base,
		'type' => 'text_small',
		'default' => '',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Background', 'core-extension' ),
		'desc'      => esc_html__( '(Only for default hero section type)', 'core-extension' ),
		'id'   => 'header-section-bg-image-'.$base,
		'type' => 'wtbx_background',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'      => esc_html__( 'Use featured image', 'core-extension' ),
		'desc'      => esc_html__( 'Use featured image for each post instead. (Only for default hero section type)', 'core-extension' ),
		'id'        => 'header-section-bg-featured-'.$base,
		'type'      => 'select',
		'options'   => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'on'    => esc_html__( 'Yes', 'core-extension' ),
			'off'   => esc_html__( 'No', 'core-extension' )
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Overlay color', 'core-extension' ),
		'id'   => 'header-section-overlay-color-'.$base,
		'desc' => esc_html__( '(Only for default hero section type).', 'core-extension' ),
		'type' => 'colorpicker',
		'options' => array(
			'alpha' => true,
		 ),
		'row_classes'   => 'tab_2'
	) );
//	$global->add_field( array(
//		'name'     => esc_html__( 'Scroll effect', 'core-extension' ),
//		'desc'     => esc_html__( '(Only for default hero section type)', 'core-extension' ),
//		'id'       => 'header-section-scroll-effect-'.$base,
//		'type'     => 'select',
//		'options'  => array(
//			''              => esc_html__( 'Inherit', 'core-extension' ),
//			'none'          => esc_html__( 'None', 'core-extension' ),
//			'cont_zoom_in'  => esc_html__( 'Content zoom in', 'core-extension' ),
//			'hs_3d_slide'   => esc_html__( 'Hero section 3D slide out', 'core-extension' )
//		),
//		'default'  => '',
//		'row_classes'   => 'tab_2'
//	) );
	$global->add_field( array(
		'name'     => esc_html__( 'Full hero section scroll', 'core-extension' ),
		'desc'     => esc_html__( 'If enabled, hero section will be fully scrolled down on first user scroll event. (Only for default hero section type)', 'core-extension' ),
		'id'       => 'header-section-scroll-full-'.$base,
		'type'     => 'select',
		'options'  => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'On', 'core-extension' ),
			'none'  => esc_html__( 'Off', 'core-extension' )
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'      => esc_html__( 'Image parallax effect', 'scape' ),
		'desc'      => esc_html__( 'Only for default hero section type.', 'scape' ),
		'id'       => 'header-section-parallax-'.$base,
		'type'     => 'select',
		'options'  => array(
			''                          => esc_html__( 'Inherit', 'scape' ),
			'none'                      => esc_html__( 'None', 'scape' ),
			'wtbx_parallax_scroll'      => esc_html__( 'Scroll parallax', 'scape' ),
			'wtbx_parallax_mousemove'   => esc_html__( 'Mouse move parallax', 'scape' )
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'     => esc_html__( 'Content fadeout effect', 'core-extension' ),
		'desc'     => esc_html__( 'If enabled, hero section content will shift and fade out as the user scrolls down. Only for default and custom hero section type', 'core-extension' ),
		'id'       => 'header-section-fadeout-'.$base,
		'type'     => 'select',
		'options'  => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'On', 'core-extension' ),
			'none'  => esc_html__( 'Off', 'core-extension' )
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Decoration style', 'core-extension' ),
		'id'   => 'header-section-decoration-layout-'.$base,
		'type' => 'select',
		'options'  => array(
			''              => esc_html__( 'Inherit', 'core-extension' ),
			'none'          => esc_html__( 'None', 'core-extension' ),
			'curve-top'     => esc_html__( 'Curve top', 'core-extension' ),
			'curve-bottom'  => esc_html__( 'Curve bottom', 'core-extension' ),
			'notch-bottom'  => esc_html__( 'Notch', 'core-extension' ),
			'notch-top'     => esc_html__( 'Notch reversed', 'core-extension' ),
			'waves-1'       => esc_html__( 'Waves 1', 'core-extension' ),
			'waves-2'       => esc_html__( 'Waves 2', 'core-extension' ),
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Decoration color', 'core-extension' ),
		'id'   => 'header-section-decoration-color-'.$base,
		'desc' => esc_html__( 'You may want to match it with the background of your page of the first row on it.', 'core-extension' ),
		'type' => 'colorpicker',
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'      => esc_html__( 'Hero section content skin', 'scape' ),
		'id'        => 'header-section-skin-'.$base,
		'type'      => 'select',
		'options'   => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'light' => esc_html__( 'Light', 'scape' ),
			'dark'  => esc_html__( 'Dark', 'scape' ),
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name'      => esc_html__( '"Scroll-down" button style', 'core-extension' ),
		'id'        => 'header-section-scrolldown-style-'.$base,
		'type'      => 'select',
		'options'   => array(
			''                  => esc_html__( 'Inherit', 'core-extension' ),
			'none'              => esc_html__( 'None', 'core-extension' ),
			'arrow-single'      => esc_html__( 'Arrow down', 'core-extension' ),
			'angle-down'        => esc_html__( 'Angle down in circle', 'core-extension' ),
			'angle-down-cont'   => esc_html__( 'Angle down in round container', 'core-extension' ),
			'mouse-simple'      => esc_html__( 'Mouse icon', 'core-extension' ),
		),
		'row_classes'   => 'tab_2'
	) );
	$global->add_field( array(
		'name' => esc_html__( '"Scroll-down" button skin', 'core-extension' ),
		'id'   => 'header-section-scrolldown-skin-'.$base,
		'type' => 'select',
		'options'  => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' ),
		),
		'row_classes'   => 'tab_2'
	) );

	$global->add_field( array(
		'id'       => 'preloader-site-style-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Page preloader', 'scape' ),
		'desc'     => esc_html__( 'Important: adding a page preloader switches off image lazy loading for elements, which it is not specifically switched on for.', 'scape' ),
		'options'  => array(
			''       => esc_html__( 'Inherit', 'core-extension' ),
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
		),
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'id'       => 'page-layout-fullwidth-'.$base,
		'type'     => 'select',
		'name'     => esc_html__( 'Layout width', 'core-extension' ),
		'options'  => array(
			''              => esc_html__( 'Inherit', 'core-extension' ),
			'width-default' => esc_html__( 'Default site width', 'core-extension' ),
			'width-full'    => esc_html__( 'Full page width', 'core-extension' ),
		),
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'name'          => esc_html__( 'Content width limit', 'core-extension' ),
		'desc'          => wp_kses_post( __( 'Units - <code>px</code>. (Only for default site width)', 'core-extension' )),
		'id'            => 'page-layout-width-limit-'.$base,
		'type'          => 'text_small',
		'default'       => '',
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'id'       => 'page-layout-content-bg-'.$base,
		'type' => 'colorpicker',
		'name'    => esc_html__( 'Page background color', 'core-extension' ),
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'name'          => esc_html__( 'Content top padding', 'core-extension' ),
		'desc'          => wp_kses_post( __( 'Units - <code>px</code>.', 'core-extension' )),
		'id'            => 'page-layout-content-padding-top-'.$base,
		'type'          => 'text_small',
		'default'       => '',
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'name'          => esc_html__( 'Content bottom padding', 'core-extension' ),
		'subtitle'      => wp_kses_post( __( 'Units - <code>px</code>.', 'core-extension' )),
		'id'            => 'page-layout-content-padding-bottom-'.$base,
		'type'          => 'text_small',
		'default'       => '',
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'id'       => 'page-layout-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Page layout', 'core-extension' ),
		'options'  => array(
			''                      => esc_html__( 'Inherit', 'core-extension' ),
			'no_sidebar'            => esc_html__( 'Full width content', 'core-extension' ),
			'sidebar_left'          => esc_html__( 'Left sidebar - Content', 'core-extension' ),
			'sidebar_left_sticky'   => esc_html__( ' Sticky left sidebar - Content', 'core-extension' ),
			'sidebar_right'         => esc_html__( 'Content - Right Sidebar', 'core-extension' ),
			'sidebar_right_sticky'  => esc_html__( 'Content - Sticky right Sidebar', 'core-extension' ),

		),
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'id'            => 'page-layout-sidebar-width-slider-'.$base,
		'name'          => esc_html__( 'Sidebar width', 'core-extension' ),
		'desc'          => wp_kses_post( __( 'Set to <code>-1</code> to inherit value from Theme Options. (Only for page layouts with sidebar)', 'core-extension' )),
		'type'          => 'wtbx_slider',
		'min'           => '-1',
		'max'           => '500',
		'default'       => '-1',
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'name'          => esc_html__( 'Sidebar top padding', 'core-extension' ),
		'desc'          => wp_kses_post( __( 'Use this to make sidebar content start at the same level as the main page content. Units - <code>px</code>. (Only for page layouts with sidebar)', 'core-extension' )),
		'id'            => 'page-layout-sidebar-padding-'.$base,
		'type'          => 'text_small',
		'default'       => '',
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'id'        => 'page-layout-sidebar-skin-'.$base,
		'type'      => 'select',
		'name'      => esc_html__( 'Sidebar content skin', 'core-extension' ),
		'desc'      => esc_html__('(Only for page layouts with sidebar)', 'core-extension'),
		'options'   => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' ),
		),
		'row_classes'   => 'tab_3'
	) );
	$global->add_field( array(
		'id'            => 'page-layout-sidebar-widgetarea-'.$base,
		'type'          => 'select',
		'name'          => esc_html__( 'Sidebar to use', 'core-extension' ),
		'desc'          => esc_html__('(Only for page layouts with sidebar)', 'core-extension'),
		'options'       => wtbx_sidebars_array(),
		'row_classes'   => 'tab_3'
	) );

	$global->add_field( array(
		'name'    => esc_html__( 'Enable footer', 'core-extension' ),
		'id'       => 'footer-enable-'.$base,
		'type'     => 'select',
		'options'  => array(
			''          => esc_html__( 'Inherit', 'core-extension' ),
			'1'   => esc_html__('On', 'core-extension'),
			'off'     => esc_html__('Off', 'core-extension')
		),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'name'     => esc_html__( 'Content block', 'core-extension' ),
		'desc'     => esc_html__( 'Choose a content block to insert as a footer.', 'core-extension' ),
		'id'       => 'footer-block-'.$base,
		'type'     => 'select',
		'options_cb' => 'wtbx_content_block_select',
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'name'    => esc_html__( 'Footer style', 'core-extension' ),
		'id'       => 'footer-style-'.$base,
		'type'     => 'select',
		'options'  => array(
			''          => esc_html__( 'Inherit', 'core-extension' ),
			'default'   => esc_html__('Default', 'core-extension'),
			'under'     => esc_html__('Underlying', 'core-extension')
		),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Underlying footer breakpoint', 'core-extension' ),
		'desc' => wp_kses_post( __( 'Switch to default header style under this width. Units - <strong>px</strong>.', 'core-extension' )),
		'id'   => 'footer-breakpoint-'.$base,
		'type' => 'text_small',
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'id'       => 'footer-skin-'.$base,
		'type'     => 'select',
		'name'    => esc_html__( 'Widgets skin', 'core-extension' ),
		'options'  => array(
			''      => esc_html__( 'Inherit', 'core-extension' ),
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' ),
		),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'id'       => 'footer-color-text-'.$base,
		'type'     => 'colorpicker',
		'name'    => esc_html__( 'Default text color', 'core-extension' ),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'id'       => 'footer-color-text-dark-'.$base,
		'type'     => 'colorpicker',
		'name'    => esc_html__( 'Dark text color', 'core-extension' ),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'id'       => 'footer-color-text-light-'.$base,
		'type'     => 'colorpicker',
		'name'    => esc_html__( 'Light text color', 'core-extension' ),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'id'       => 'footer-color-link-'.$base,
		'type'     => 'colorpicker',
		'name'    => esc_html__( 'Link color', 'core-extension' ),
		'row_classes'   => 'tab_4'
	) );
	$global->add_field( array(
		'id'       => 'footer-color-link-hover-'.$base,
		'type'     => 'colorpicker',
		'name'    => esc_html__( 'Link hover color', 'core-extension' ),
		'row_classes'   => 'tab_4'
	) );

	$global->add_field( array(
		'name' => esc_html__( 'Page template', 'core-extension' ),
		'id'   => 'page-template-type-'.$base,
		'type' => 'select',
		'options'  => array(
			'default'   => esc_html__( 'Default', 'core-extension' ),
			'slider'    => esc_html__( 'Full-screen slider', 'core-extension' )
		),
		'row_classes'   => 'tab_5'
	) );
	$global->add_field( array(
		'name' => esc_html__( 'Slider animation', 'core-extension' ),
		'id'   => 'page-template-slider-anim-'.$base,
		'type' => 'select',
		'options'  => array(
			'animDefault'     => esc_html__( 'Default slide', 'core-extension' ),
			'animEasing'      => esc_html__( 'Slide with slight overlap', 'core-extension' ),
			'animOverlap'     => esc_html__( 'Slide with overlap', 'core-extension' ),
			'animScaledown'   => esc_html__( 'Slide with scaling down', 'core-extension' ),
			'animScaleup'     => esc_html__( 'Slide with scaling up', 'core-extension' )
		),
		'attributes' => array(
			'data-conditional-id' => 'page-template-type-'.$base,
			'data-conditional-value' => 'slider',
		),
		'row_classes'   => 'tab_5'
	) );
	$global->add_field( array(
		'id'        => 'page-template-slider-nav-'.$base,
		'type'      => 'select',
		'name'      => esc_html__( 'Slider navigation', 'core-extension' ),
		'options'   => array(
			''                  => esc_html__( 'Disable', 'core-extension' ),
			'circles'           => esc_html__( 'Circles', 'core-extension' ),
			'circles_labels'    => esc_html__( 'Circles with labels', 'core-extension' ),
			'lines'             => esc_html__( 'Lines', 'core-extension' ),
			'lines_labels'      => esc_html__( 'Lines with labels', 'core-extension' ),
			'vertical_labels'   => esc_html__( 'Vertical with labels', 'core-extension' ),
		),
		'attributes' => array(
			'data-conditional-id' => 'page-template-type-'.$base,
			'data-conditional-value' => 'slider',
		),
		'row_classes'   => 'tab_5'
	) );
	$global->add_field( array(
		'id'        => 'page-navigation-'.$base,
		'type'      => 'select',
		'name'      => esc_html__( 'Page navigation', 'core-extension' ),
		'options'   => array(
			''                  => esc_html__( 'Disable', 'core-extension' ),
			'circles'           => esc_html__( 'Circles', 'core-extension' ),
			'circles_labels'    => esc_html__( 'Circles with labels', 'core-extension' ),
			'lines'             => esc_html__( 'Lines', 'core-extension' ),
			'lines_labels'      => esc_html__( 'Lines with labels', 'core-extension' ),
			'vertical'          => esc_html__( 'Vertical', 'core-extension' ),
			'vertical_labels'   => esc_html__( 'Vertical with labels', 'core-extension' ),
		),
		'attributes' => array(
			'data-conditional-id' => 'page-template-type-'.$base,
			'data-conditional-value' => 'default',
		),
		'row_classes'   => 'tab_5'
	) );

	$global->add_field( array(
		'name' => esc_html__( 'Navigation parent', 'core-extension' ),
		'desc' => wp_kses_post( __( 'Set the parent page to group items and create navigation logic. For more info please refer to <a href="http://docs.whiteboxstud.io/scape" target="_blank">theme documentation</a>.', 'core-extension' )),
		'id'   => 'navigation-parent',
		'type' => 'select',
		'options'  => wtbx_get_pages(),
		'row_classes'   => 'tab_6'
	) );

	$global->add_field( array(
		'name' => esc_html__( 'Grid items per page', 'core-extension' ),
//		'desc' => wp_kses_post( __( '', 'core-extension' )),
		'id'   => 'items-perpage',
		'type' => 'text_small',
		'default' => '',
		'row_classes'   => 'tab_7'
	) );

}