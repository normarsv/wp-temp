<?php
/*---------------------------------------------------------------*/
/* Register shortcode within Visual Composer interface
/*---------------------------------------------------------------*/

add_action( 'init', 'wtbx_vc_map' );
function wtbx_vc_map() {

	$blocks = get_posts( array(
		'post_type'   => 'content_block',
		'posts_per_page'=> -1
	) );
	$content_blocks = array();
	if ( $blocks ) {
		foreach ( $blocks as $block ) {
			$content_blocks[ $block->post_title ] = $block->ID;
		}
	}

	$frontend_scripts = array(
		get_template_directory_uri() . '/library/js/libs/min/custom-scrollbar.min.js',
		get_template_directory_uri() . '/library/js/libs/min/smoothscroll.min.js',
		get_template_directory_uri() . '/library/js/libs/min/hammer.min.js',
		get_template_directory_uri() . '/library/js/libs/min/jquery.mousewheel.min.js',
		get_template_directory_uri() . '/library/js/libs/min/plyr.min.js',
		get_template_directory_uri() . '/library/js/libs/min/slick.min.js',
		get_template_directory_uri() . '/library/js/libs/min/flickity.min.js',
		get_template_directory_uri() . '/library/js/libs/min/packery.min.js',
		get_template_directory_uri() . '/library/js/libs/min/isotope.min.js',
		get_template_directory_uri() . '/library/js/libs/min/countdown.min.js',
		get_template_directory_uri() . '/library/js/libs/min/sticky-kit.min.js',
		get_template_directory_uri() . '/library/js/libs/min/magnific-popup.min.js',
		get_template_directory_uri() . '/library/js/libs/min/jquery.mega-menu.min.js',
		get_template_directory_uri() . '/library/js/libs/min/typed.min.js',
		get_template_directory_uri() . '/library/js/libs/min/before-after.min.js',
		get_template_directory_uri() . '/library/js/libs/min/vivus.min.js',
		get_template_directory_uri() . '/library/js/libs/min/lazyload.min.js',
		get_template_directory_uri() . '/library/js/libs/min/jquery.fullPage.min.js',
		get_template_directory_uri() . '/library/js/libs/min/jquery.waypoints.min.js',
		get_template_directory_uri() . '/library/js/app.js',
		
//		get_template_directory_uri() . '/library/js/module-lightbox.js',
//		get_template_directory_uri() . '/library/js/module-modal.js',
//		get_template_directory_uri() . '/library/js/module-gmaps.js',
//		get_template_directory_uri() . '/library/js/module-videobg.js',
//		get_template_directory_uri() . '/library/js/module-portfolio-slider.js',
//		get_template_directory_uri() . '/library/js/module-woocommerce.js',
//		get_template_directory_uri() . '/library/js/module-fullpage.js',
//		get_template_directory_uri() . '/library/js/module-testimonial-slider.js',
//		get_template_directory_uri() . '/library/js/module-content-slider.js',
//		get_template_directory_uri() . '/library/js/module-steps.js',
//		get_template_directory_uri() . '/library/js/module-sideheader.js',
//		get_template_directory_uri() . '/library/js/module-sidearea.js',
//		get_template_directory_uri() . '/library/js/module-language-switch.js',
//		get_template_directory_uri() . '/library/js/module-banner.js',

		WTBX_PLUGIN_URL . 'assets/js/spectrum.js',
		WTBX_PLUGIN_URL . 'assets/js/extend-frontend-tabs.js',
		WTBX_PLUGIN_URL . 'assets/js/extend-frontend-accordion.js',
		WTBX_PLUGIN_URL . 'assets/js/extend-frontend-exp-list.js',
		WTBX_PLUGIN_URL . 'assets/js/extend-frontend-button.js',
		WTBX_PLUGIN_URL . 'assets/js/extend-frontend-testimonial-slider.js',
		WTBX_PLUGIN_URL . 'assets/js/extend-frontend-content-slider.js'

	);


	$frontend_scripts_portfolio_grid = array(
		get_template_directory_uri() . '/library/js/module-grid-metro.js',
		get_template_directory_uri() . '/library/js/module-grid-general.js',
		get_template_directory_uri() . '/library/js/module-portfolio-slider.js'
	);

	$add_css_animation = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation', 'core-extension' ),
		'param_name' => 'css_animation',
		'value' => array(
			esc_html__( 'No', 'core-extension' ) => '',
			esc_html__( 'Fade in', 'core-extension' ) => 'wtbx-anim-fade-in',
			esc_html__( 'Top to bottom', 'core-extension' ) => 'wtbx-anim-top-to-bottom-small',
			esc_html__( 'Bottom to top', 'core-extension' ) => 'wtbx-anim-bottom-to-top-small',
			esc_html__( 'Left to right', 'core-extension' ) => 'wtbx-anim-left-to-right-small',
			esc_html__( 'Right to left', 'core-extension' ) => 'wtbx-anim-right-to-left-small',
			esc_html__( 'Top to bottom big', 'core-extension' ) => 'wtbx-anim-top-to-bottom',
			esc_html__( 'Bottom to top big', 'core-extension' ) => 'wtbx-anim-bottom-to-top',
			esc_html__( 'Left to right big', 'core-extension' ) => 'wtbx-anim-left-to-right',
			esc_html__( 'Right to left big', 'core-extension' ) => 'wtbx-anim-right-to-left',
			esc_html__( 'Scale up', 'core-extension' ) => 'wtbx-anim-scale-up',
			esc_html__( 'Scale down', 'core-extension' ) => 'wtbx-anim-scale-down',
			esc_html__( '3D Slide up', 'core-extension' ) => 'wtbx-anim-3d-slide-up',
			esc_html__( '3D Rotate top', 'core-extension' ) => 'wtbx-anim-3d-rotate-top',
			esc_html__( '3D Rotate bottom', 'core-extension' ) => 'wtbx-anim-3d-rotate-bottom',
			esc_html__( '3D Rotate left', 'core-extension' ) => 'wtbx-anim-3d-rotate-left',
			esc_html__( '3D Rotate right', 'core-extension' ) => 'wtbx-anim-3d-rotate-right',
		),
		'save_always' => true,
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'core-extension' ),
		"group" => esc_html__('Animation', 'core-extension')
	);

	$add_css_animation_easing = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation Easing', 'core-extension' ),
		'param_name' => 'css_animation_easing',
		'value' => array(
			esc_html__( 'Natural', 'core-extension' ) => 'wtbx_easing-natural',
			esc_html__( 'Linear', 'core-extension' ) => 'wtbx-easing-linear',
			esc_html__( 'Ease in', 'core-extension' ) => 'wtbx-easing-easein',
			esc_html__( 'Ease out', 'core-extension' ) => 'wtbx-easing-easeout',
			esc_html__( 'Ease in-out', 'core-extension' ) => 'wtbx-easing-easeinout',
			esc_html__( 'Sharp', 'core-extension' ) => 'wtbx-easing-sharp',
			esc_html__( 'Elastic light', 'core-extension' ) => 'wtbx-easing-elastic1',
			esc_html__( 'Elastic strong', 'core-extension' ) => 'wtbx-easing-elastic2',
		),
		'save_always' => true,
		"dependency" => Array('element' => "css_animation", 'not_empty' => true),
		"group" => esc_html__('Animation', 'core-extension')
	);

	$add_css_animation_duration = array(
		"type" => "dropdown",
		"heading" => esc_html__('CSS Animation Duration', 'core-extension'),
		"param_name" => "css_animation_duration",
		"value" => array(
			'0ms' => '',
			'100ms' => 'wtbx-duration-100',
			'200ms' => 'wtbx-duration-200',
			'300ms' => 'wtbx-duration-300',
			'400ms' => 'wtbx-duration-400',
			'500ms' => 'wtbx-duration-500',
			'600ms' => 'wtbx-duration-600',
			'700ms' => 'wtbx-duration-700',
			'800ms' => 'wtbx-duration-800',
			'900ms' => 'wtbx-duration-900',
			'1000ms' => 'wtbx-duration-1000',
			'1100ms' => 'wtbx-duration-1100',
			'1200ms' => 'wtbx-duration-1200',
			'1300ms' => 'wtbx-duration-1300',
			'1400ms' => 'wtbx-duration-1400',
			'1500ms' => 'wtbx-duration-1500',
			'1600ms' => 'wtbx-duration-1600',
			'1700ms' => 'wtbx-duration-1700',
			'1800ms' => 'wtbx-duration-1800',
			'1900ms' => 'wtbx-duration-1900',
			'2000ms' => 'wtbx-duration-2000',
			'2100ms' => 'wtbx-duration-2100',
			'2200ms' => 'wtbx-duration-2200',
			'2300ms' => 'wtbx-duration-2300',
			'2400ms' => 'wtbx-duration-2400',
			'2500ms' => 'wtbx-duration-2500',
			'2600ms' => 'wtbx-duration-2600',
			'2700ms' => 'wtbx-duration-2700',
			'2800ms' => 'wtbx-duration-2800',
			'2900ms' => 'wtbx-duration-2900',
			'3000ms' => 'wtbx-duration-3000',
		),
		"std" => "wtbx-duration-1000",
		'save_always' => true,
		"dependency" => Array('element' => "css_animation", 'not_empty' => true),
		"group" => esc_html__('Animation', 'core-extension')
	);

	$add_css_animation_delay = array(
		"type" => "dropdown",
		"heading" => esc_html__('CSS Animation Delay', 'core-extension'),
		"param_name" => "css_animation_delay",
		"value" => array(
			'0ms' => '',
			'100ms' => 'wtbx-delay-100',
			'200ms' => 'wtbx-delay-200',
			'300ms' => 'wtbx-delay-300',
			'400ms' => 'wtbx-delay-400',
			'500ms' => 'wtbx-delay-500',
			'600ms' => 'wtbx-delay-600',
			'700ms' => 'wtbx-delay-700',
			'800ms' => 'wtbx-delay-800',
			'900ms' => 'wtbx-delay-900',
			'1000ms' => 'wtbx-delay-1000',
			'1100ms' => 'wtbx-delay-1100',
			'1200ms' => 'wtbx-delay-1200',
			'1300ms' => 'wtbx-delay-1300',
			'1400ms' => 'wtbx-delay-1400',
			'1500ms' => 'wtbx-delay-1500',
			'1600ms' => 'wtbx-delay-1600',
			'1700ms' => 'wtbx-delay-1700',
			'1800ms' => 'wtbx-delay-1800',
			'1900ms' => 'wtbx-delay-1900',
			'2000ms' => 'wtbx-delay-2000'
		),
		'save_always' => true,
		"dependency" => Array('element' => "css_animation", 'not_empty' => true),
		"group" => esc_html__('Animation', 'core-extension')
	);

	$remove_css_animation = array(
		"type" => "dropdown",
		"heading" => esc_html__('Disable CSS animation on small screens', 'core-extension'),
		"param_name" => 'disable_css_animation',
		"value" => array(
			esc_html__('Do not disable', 'core-extension') => '',
			esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
			esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
			esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
			esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
		),
		'std' => '',
		"group" => esc_html__('Animation', 'core-extension')
	);

	$add_icon_animation = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon Animation', 'core-extension' ),
		'param_name' => 'icon_animation',
		'admin_label' => true,
		'value' => array(
			esc_html__( 'No animation', 'core-extension' ) => '',
			esc_html__( 'To full opacity', 'core-extension' ) => 'ha_full-opacity',
			esc_html__( 'Scale up', 'core-extension' ) => 'ha_scale',
			esc_html__( 'Bounce', 'core-extension' ) => 'ha_bounce',
			esc_html__( 'Shake', 'core-extension' ) => 'ha_shake',
			esc_html__( 'Swing', 'core-extension' ) => 'ha_swing',
			esc_html__( 'Tada', 'core-extension' ) => 'ha_tada',
			esc_html__( 'Wobble', 'core-extension' ) => 'ha_wobble',
			esc_html__( 'Pulse', 'core-extension' ) => 'ha_pulse'
		),
		'save_always' => true,
		'description' => esc_html__( 'Select type of animation for the icon when element is hovered. Note: Works only in modern browsers.', 'core-extension' ),
		"group" => esc_html__('Animation', 'core-extension')
	);

	function wtbx_disable_css($property, $description = '') {
		$output = array(
			"type" => "dropdown",
			"heading" => sprintf(esc_html__("Disable %s on smaller screens", 'core-extension'), $property),
			"description" => ($description !== '' ?  sprintf(esc_html__("%s", 'core-extension'), $description) : ''),
			"param_name" => "disable_" . str_replace(' ', '_', $property),
			"value" => array(
				esc_html__('Do not disable', 'core-extension') => '',
				esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
				esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
				esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
				esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
			),
			"group" => esc_html__('Responsiveness', 'core-extension')
		);

		return $output;
	}

//	function wtbx_unique_class($prefix) {
//		$unique_class = array(
//			'type' => 'wtbx_vc_unique_class',
//			'heading' => esc_html__( 'Unique class', 'core-extension' ),
//			'param_name' => 'unique_class',
//			'value' => wtbx_vc_unique_value($prefix),
//			'description' => esc_html__( 'This class will be added to the element. You can use it to apply custom CSS styling or add an extra class in the field below.', 'core-extension' ),
//			'group' => esc_html__( 'Misc', 'core-extension' ),
//		);
//		return $unique_class;
//	}

	$lazy_images = array(
		"type" => "dropdown",
		"heading" => esc_html__('Enable lazy image loading for this element', 'core-extension'),
		"param_name" => "lazy",
		"value" => array(
			esc_html__('Default theme setting', 'core-extension') => "",
			esc_html__('Enable', 'core-extension') => "1",
			esc_html__('Disable', 'core-extension') => "0"
		),
		"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
		"group" => esc_html__('Misc', 'core-extension')
	);

	$preloader = array(
		"type" => "dropdown",
		"heading" => esc_html__('Enable prealoading animation', 'core-extension'),
		"param_name" => "preloader",
		"value" => array(
			esc_html__('Default theme setting', 'core-extension') => "",
			esc_html__('Enable', 'core-extension') => "1",
			esc_html__('Disable', 'core-extension') => "0"
		),
		'save_always' => true,
		'std' => '',
		"description" => esc_html__('Preloader will be displayed while image is being loaded (only applicable if lazy image loading is switched on).', 'core-extension'),
		"group" => esc_html__('Misc', 'core-extension')
	);

	$extra_class = array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Extra class name', 'core-extension' ),
		'param_name' => 'el_class',
		'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'core-extension' ),
		'group' => esc_html__( 'Misc', 'core-extension' ),
	);

	$tooltip = array (
		'type' => 'textfield',
		'heading' => esc_html__( 'Tooltip', 'core-extension' ),
		'param_name' => 'tooltip',
		'value' => '',
		'description' => esc_html__( 'Enter tooltip text which should be displayed on element hover.', 'core-extension' ),
		"group" => esc_html__('Misc', 'core-extension'),
	);

	// Section
	vc_map( array(
		'name' => esc_html__( 'Section', 'core-extension' ),
		'is_container' => true,
		'icon' => 'icon-wpb-vc_section',
		'show_settings_on_create' => false,
		'base' => 'vc_section',
		"weight" => 3,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		'as_parent' => array(
			'only' => 'vc_row',
		),
		'as_child' => array(
			'only' => '', // Only root
		),
		'class' => 'vc_main-sortable-element',
		'description' => esc_html__( 'Group multiple rows in section', 'core-extension' ),
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Section height', 'core-extension'),
				"param_name" => "height_type",
				"value" => array(
					'Auto' => '',
					'Relative height (as percentage of screen height)' => 'fixed_height_screen',
				),
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Height', 'core-extension'),
				"param_name" => "height",
				"std" => '100',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Set the section height in percentage.', 'core-extension'),
				"dependency" => array(
					'element' => "height_type",
					'value' => array('fixed_height_screen')
				),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Min height', 'core-extension'),
				"param_name" => "min_height",
				"value" => '',
				"description" => esc_html__('Set the minimum height of the section in pixels.', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Vertical align', 'core-extension'),
				"param_name" => "section_align",
				"value" => array(
					'Top'    => 'align_top',
					'Middle' => 'align_middle',
					'Bottom' => 'align_bottom'
				),
				'std' => 'align-top',
				'save_always' => true,
				"description" => esc_html__('Choose how the section content should be vertically aligned.', 'core-extension'),
				"dependency" => array(
					'element' => "height_type",
					'value' => array('fixed_height_screen'))
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Border color', 'core-extension' ),
				'param_name' => 'border_color',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "custom_bg_color",
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				"description" => esc_html__('Select color of the background overlay. Use semi-transparent colors to control the overlay opacity.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background type', 'core-extension'),
				"param_name" => "custom_bg_type",
				"value" => array(
					esc_html__('Without attachment', 'core-extension')   => '',
					esc_html__('Image background', 'core-extension')     => 'image',
					esc_html__('Video background', 'core-extension')     => 'video'
				),
				"description" => esc_html__('Choose the type of background attachment for this section.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "custom_bg_image",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background-cover', 'core-extension'),
				"param_name" => "custom_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "auto",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				'std' => 'cover',
				'save_always' => true,
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "custom_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => 'repeat',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'std' => 'no-repeat',
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "custom_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'std' => 'Center center',
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "custom_bg_attachment",
				"value" => array(
					'Scroll' => '',
					'Fixed' => 'fixed'
				),
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background effect', 'core-extension'),
				"param_name" => "custom_bg_effect",
				"description" => esc_html__('Background image shift effect', 'core-extension'),
				"value" => array(
					esc_html__('None', 'core-extension') => "",
					esc_html__('Scroll parallax', 'core-extension') => "wtbx_parallax_bg",
					esc_html__('Scroll scale effect', 'core-extension') => "wtbx_scale_bg",
					esc_html__('Scroll parallax + scale effect', 'core-extension') => "wtbx_parallax_scale_bg",
					esc_html__('Mouse move parallax', 'core-extension') => "wtbx_mousemove_bg",
				),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background image parallax intensity', 'core-extension'),
				"param_name" => "parallax_intensity",
				"std" => '2',
				'range_from' => '0',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of parallax effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'custom_bg_effect',
					'value'     => array('wtbx_parallax_bg', 'wtbx_parallax_scale_bg')
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background image scaling intensity', 'core-extension'),
				"param_name" => "scale_intensity",
				"std" => '2',
				'range_from' => '-10',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of scaling effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'custom_bg_effect',
					'value'     => array('wtbx_scale_bg', 'wtbx_parallax_scale_bg')
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background image mouse move parallax intensity', 'core-extension'),
				"param_name" => "mousemove_intensity",
				"std" => '2',
				'range_from' => '0',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of mouse move parallax effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'custom_bg_effect',
					'value'     => array('wtbx_mousemove_bg')
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Enable lazy background image loading', 'core-extension'),
				"param_name" => "lazy",
				"value" => array(
					esc_html__('Default theme setting', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "1",
					esc_html__('Disable', 'core-extension') => "0"
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Video source', 'core-extension'),
				"param_name" => "bg_v_source",
				"value" => array(
					esc_html__('Self-hosted video', 'core-extension')    => 'self_hosted',
					esc_html__('Vimeo video', 'core-extension')          => 'vimeo',
					esc_html__('Youtube video' , 'core-extension')       => 'youtube'),
				"description" => esc_html__('Choose the source for the background video.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Link to video (mp4)', 'core-extension'),
				"param_name" => "bg_video_mp4",
				"dependency" => array(
					'element' => "bg_v_source",
					'value' => 'self_hosted'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Vimeo video ID', 'core-extension'),
				"param_name" => "vimeo_id",
				"dependency" => array(
					'element' => "bg_v_source",
					'value' => 'vimeo'
				),
				"description" => wp_kses_post( __('Enter just the video ID, <strong>not</strong> the full link.', 'core-extension' )),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Youtube video ID', 'core-extension'),
				"param_name" => "youtube_id",
				"dependency" => array(
					'element' => "bg_v_source",
					'value' => 'youtube'
				),
				"description" => wp_kses_post( __('Enter just the video ID, <strong>not</strong> the full link.', 'core-extension' )),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Video sound', 'core-extension'),
				"param_name" => "video_sound",
				"value" => array(
					esc_html__('Mute sound', 'core-extension') => "",
					esc_html__('Play sound', 'core-extension') => "play_sound",
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Video background parallax effect', 'core-extension'),
				"param_name" => "parallax_video",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "wtbx_parallax_video",
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"description" => esc_html__('Parallax effect for video during the scroll', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background video parallax effect intensity', 'core-extension'),
				"param_name" => "video_parallax_intensity",
				"std" => '2',
				'range_from' => '0',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of parallax effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'parallax_video',
					'value'     => 'wtbx_parallax_video'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster image', 'core-extension'),
				"param_name" => "video_poster",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"description" => esc_html__('If added, this image will be displayed on desktop before the video is loaded and replace the video on mobile devices.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Animated layer', 'core-extension'),
				"param_name" => "animated_layer",
				"value" => array(
					esc_html__('Disable', 'core-extension') => '',
					esc_html__('Background image', 'core-extension') => 'anim_bg_image',
					esc_html__('Background segments', 'core-extension') => 'anim_bg_segments'
				),
				"description" => esc_html__('Animated background layer over the background attachment.', 'core-extension'),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Segments style', 'core-extension'),
				"param_name" => "segments_style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => 'anim_style_1',
					esc_html__('Style 2', 'core-extension') => 'anim_style_2',
					esc_html__('Style 3', 'core-extension') => 'anim_style_3',
					esc_html__('Style 4', 'core-extension') => 'anim_style_4',
					esc_html__('Style 5', 'core-extension') => 'anim_style_5',
					esc_html__('Style 6', 'core-extension') => 'anim_style_6',
					esc_html__('Style 7', 'core-extension') => 'anim_style_7',
				),
				"dependency" => array(
					'element' => "animated_layer",
					'value' => 'anim_bg_segments'
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "anim_bg_image",
				"dependency" => array(
					'element' => "animated_layer",
					'value' => 'anim_bg_image'
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background-cover', 'core-extension'),
				"param_name" => "anim_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "auto",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "anim_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => 'repeat',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "anim_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "anim_bg_attachment",
				"value" => array(
					esc_html__('Scroll', 'core-extension') => 'scroll',
					esc_html__('Fixed', 'core-extension') => 'fixed'
				),
				'save_always' => true,
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Animation', 'core-extension'),
				"param_name" => "anim_direction",
				"value" => array(
					esc_html__('No animation', 'core-extension') => '',
					esc_html__('Left to right', 'core-extension') => 'to_right',
					esc_html__('Right to left', 'core-extension') => 'to_left',
					esc_html__('Top to bottom', 'core-extension') => 'to_bottom',
					esc_html__('Bottom to top', 'core-extension') => 'to_top',
				),
				'std' => 'to_left',
				'save_always' => true,
				"dependency" => array(
					'element' => "animated_layer",
					'value' => array('anim_bg_image', 'anim_bg_text')
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Animation cycle time', 'core-extension'),
				"param_name" => "anim_time",
				"std" => '40',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Animation time in seconds.', 'core-extension'),
				"dependency" => array(
					'element' => "animated_layer",
					'value' => array('anim_bg_image', 'anim_bg_text')
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Disable animated layer on small screens', 'core-extension'),
				"param_name" => 'anim_disable',
				"value" => array(
					esc_html__('Do not disable', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => '',
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Add ID to section', 'core-extension'),
				"param_name" => "section_id",
				"description" => esc_html__('This ID is used to make one page menu or scroll to anchor. Please give unique ID to each row, if using menu for one page style.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Anchor label', 'core-extension'),
				"param_name" => "anchor",
				"description" => esc_html__('Anchor label is needed if fullscreen page slider mode is activated. Will be displayed next to navigation dots.', 'core-extension'),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Slide skin', 'core-extension'),
				"param_name" => "nav_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')           => "light",
					esc_html__('Light colorful', 'core-extension')  => "light_color",
					esc_html__('Dark', 'core-extension')            => "dark",
					esc_html__('Dark colorful', 'core-extension')   => "dark_color",
				),
				'save_always' => true,
				'description' => esc_html__( 'Used when fullscreen page slider mode is activated. Skin is applied to slider navigation and site header (header styles 1 - 6 only) . Choose the skin based on the background color (e.g. dark skin for the section with dark background).', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Disable section', 'core-extension' ),
				'param_name' => 'disable_element',
				'description' => esc_html__( 'If checked the section won\'t be visible on the public side of your website. You can switch it back any time.', 'core-extension' ),
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Hide this row on screen sizes:', 'core-extension'),
				"param_name" => "section_show_on",
				"value" => Array(
					wp_kses_post( __("<strong>Desktop</strong> (on screen sizes larger than 1025px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_on_normal_screen',
					wp_kses_post( __("<strong>Tablet Landscape</strong> (on screen sizes from 980px - 1024px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_tablet_landscape',
					wp_kses_post( __("<strong>Tablet Portrait</strong> (on screen sizes from 768px - 979px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_tablet_portrait',
					wp_kses_post( __("<strong>Mobile Landscape</strong> (on screen sizes from 480px - 767px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_mobile_landscape',
					wp_kses_post( __("<strong>Mobile Portrait</strong> (on screen sizes smaller than 479px)", 'core-extension' )) => 'wtbx_hide_mobile_portrait'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			wtbx_disable_css('fixed height', 'Disable min height and relative height on smaller screens, and enforce automatic height.'),
//			wtbx_disable_css('margins'),
//			wtbx_disable_css('borders'),
//			wtbx_disable_css('padding')
		),
		'js_view' => 'VcSectionView',
	) );



	// Row
	vc_map( array(
		"name" => esc_html__('Row', 'core-extension'),
		"base" => "vc_row",
		"is_container" => true,
		"icon" => "icon-wpb-vc_row",
		"weight" => 2,
		"show_settings_on_create" => false,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		"admin_enqueue_js" =>  array( WTBX_PLUGIN_URL . 'assets/js/spectrum.js', WTBX_PLUGIN_URL . 'assets/js/extend-composer-custom-views.js' ),
		"admin_enqueue_css" => array( WTBX_PLUGIN_URL . 'assets/css/core-extension-backend.css', WTBX_PLUGIN_URL . 'assets/css/font-devices.css' ),
		"front_enqueue_js" =>  $frontend_scripts,
		"front_enqueue_css" => array( WTBX_PLUGIN_URL . 'assets/css/core-extension-backend.css', WTBX_PLUGIN_URL . 'assets/css/font-devices.css' ),
		"description" => esc_html__('Place content elements inside the row', 'core-extension'),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Row stretch', 'core-extension' ),
				'param_name' => 'row_width',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Stretch row', 'core-extension' ) => 'wtbx_stretch_row',
					esc_html__( 'Stretch row and content', 'core-extension' ) => 'wtbx_stretch_row_content',
				),
			    'std' => 'wtbx_stretch_row',
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Max width', 'core-extension'),
				"param_name" => "max_width",
				"value" => '',
				"description" => esc_html__('Set the maximum width of the row in pixels.', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Row height', 'core-extension'),
				"param_name" => "row_height_type",
				"value" => array(
					'Auto' => '',
                    'Relative height (as percentage of screen height)' => 'fixed_height_screen',
				),
				"description" => esc_html__('Choose automatic row height based on height of its content (default behaviour) and fixed height (great for landing pages with image or video background).', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Height', 'core-extension'),
				"param_name" => "height",
				"std" => '100',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Set the height that the row in percentage.', 'core-extension'),
				"dependency" => array(
					'element' => "row_height_type",
					'value' => array('fixed_height_cont', 'fixed_height_screen')
				),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Min height', 'core-extension'),
				"param_name" => "min_height",
				"value" => '',
				"description" => esc_html__('Set the minimum height of the row in pixels.', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Force align row within container', 'core-extension' ),
				'param_name' => 'row_alignment',
				'value' => array(
					esc_html__( 'Disable', 'core-extension' ) => '',
					esc_html__( 'Top', 'core-extension' ) => 'top',
					esc_html__( 'Middle', 'core-extension' ) => 'middle',
					esc_html__( 'Bottom', 'core-extension' ) => 'bottom',
				),
				'std' => '',
				'description' => esc_html__( 'Select content position within columns.', 'core-extension' ),
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
//				'padding' => '15',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Border color', 'core-extension' ),
				'param_name' => 'border_color',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Opposite column float', 'core-extension'),
				"param_name" => "opposite_float",
				"description" => esc_html__('Enable to make your columns float to the opposite side. Allows better control of the column stacking order on smaller screens.', 'core-extension'),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Equal height columns', 'core-extension'),
				"param_name" => "equal_height",
				"description" => esc_html__('Enable equal height columns in this row', 'core-extension'),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns gap', 'core-extension' ),
				'param_name' => 'gap',
				'value' => array(
					'default' => '',
					'0px' => '0',
					'1px' => '1',
					'2px' => '2',
					'3px' => '3',
					'4px' => '4',
					'5px' => '5',
					'10px' => '10',
					'15px' => '15',
					'20px' => '20',
					'25px' => '25',
					'30px' => '30',
					'35px' => '35',
				),
				'std' => '',
				'description' => esc_html__( 'Select gap between columns in row.', 'core-extension' ),
				"dependency" => array(
					'element' => "equal_height",
					'not_empty' => true
				),
				"group" => esc_html__('Columns', 'core-extension')
			),
//			array(
//				'type' => 'dropdown',
//				'heading' => esc_html__( 'Column side space', 'core-extension' ),
//				'param_name' => 'row_side_space',
//				'value' => array(
//					esc_html__( 'Enable', 'core-extension' ) => '',
//					esc_html__( 'Disable', 'core-extension' ) => 'wtbx_no_column_space',
//				),
//				"dependency" => array(
//					'element' => "gap",
//					'not_empty' => true
//				),
//				'description' => esc_html__( 'Disabling side space will result in no empty space before the first and after the last column. Columns will be stretched to the sides of the row.', 'core-extension' ),
//				"group" => esc_html__('Columns', 'core-extension')
//			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns position', 'core-extension' ),
				'param_name' => 'columns_placement',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Middle', 'core-extension' ) => 'middle',
					esc_html__( 'Top', 'core-extension' ) => 'top',
					esc_html__( 'Bottom', 'core-extension' ) => 'bottom',
					esc_html__( 'Stretch', 'core-extension' ) => 'stretch',
				),
				'std' => 'stretch',
				'description' => esc_html__( 'Select columns position within row.', 'core-extension' ),
				"dependency" => array(
					'element' => "equal_height",
					'not_empty' => true
				),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content position', 'core-extension' ),
				'param_name' => 'content_placement',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Top', 'core-extension' ) => 'top',
					esc_html__( 'Middle', 'core-extension' ) => 'middle',
					esc_html__( 'Bottom', 'core-extension' ) => 'bottom',
				),
				'std' => '',
				'description' => esc_html__( 'Select content position within columns.', 'core-extension' ),
				"dependency" => array(
					'element' => "equal_height",
					'not_empty' => true
				),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "custom_bg_color",
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				"description" => esc_html__('Select color of the background overlay. Use semi-transparent colors to control the overlay opacity.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background type', 'core-extension'),
				"param_name" => "custom_bg_type",
				"value" => array(
					esc_html__('Without attachment', 'core-extension')   => '',
					esc_html__('Image background', 'core-extension')     => 'image',
					esc_html__('Video background', 'core-extension')     => 'video'
				),
				"description" => esc_html__('Choose the type of background attachment for this row.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "custom_bg_image",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background-cover', 'core-extension'),
				"param_name" => "custom_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				'std' => 'cover',
				'save_always' => true,
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "custom_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => '',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'std' => 'no-repeat',
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "custom_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'std' => 'Center center',
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "custom_bg_attachment",
				"value" => array(
					'Scroll' => '',
					'Fixed' => 'fixed'
				),
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background effect', 'core-extension'),
				"param_name" => "custom_bg_effect",
				"description" => esc_html__('Background image shift effect', 'core-extension'),
				"value" => array(
					esc_html__('None', 'core-extension') => "",
					esc_html__('Scroll parallax', 'core-extension') => "wtbx_parallax_bg",
					esc_html__('Scroll scale effect', 'core-extension') => "wtbx_scale_bg",
					esc_html__('Scroll parallax + scale effect', 'core-extension') => "wtbx_parallax_scale_bg",
					esc_html__('Mouse move parallax', 'core-extension') => "wtbx_mousemove_bg",
				),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background image parallax intensity', 'core-extension'),
				"param_name" => "parallax_intensity",
				"std" => '2',
				'range_from' => '0',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of parallax effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'custom_bg_effect',
					'value'     => array('wtbx_parallax_bg', 'wtbx_parallax_scale_bg')
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background image scaling intensity', 'core-extension'),
				"param_name" => "scale_intensity",
				"std" => '2',
				'range_from' => '-10',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of scaling effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'custom_bg_effect',
					'value'     => array('wtbx_scale_bg', 'wtbx_parallax_scale_bg')
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background image mouse move parallax intensity', 'core-extension'),
				"param_name" => "mousemove_intensity",
				"std" => '2',
				'range_from' => '0',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of mouse move parallax effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'custom_bg_effect',
					'value'     => array('wtbx_mousemove_bg')
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Enable lazy background image loading', 'core-extension'),
				"param_name" => "lazy",
				"value" => array(
					esc_html__('Default theme setting', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "1",
					esc_html__('Disable', 'core-extension') => "0"
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Video source', 'core-extension'),
				"param_name" => "bg_v_source",
				"value" => array(
					esc_html__('Self-hosted video', 'core-extension')    => 'self_hosted',
					esc_html__('Vimeo video', 'core-extension')          => 'vimeo',
					esc_html__('Youtube video' , 'core-extension')       => 'youtube'),
				"description" => esc_html__('Choose the source for the background video.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Link to video (mp4)', 'core-extension'),
				"param_name" => "bg_video_mp4",
				"dependency" => array(
					'element' => "bg_v_source",
					'value' => 'self_hosted'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Vimeo video ID', 'core-extension'),
				"param_name" => "vimeo_id",
				"dependency" => array(
					'element' => "bg_v_source",
					'value' => 'vimeo'
				),
				"description" => wp_kses_post( __('Enter just the video ID, <strong>not</strong> the full link.', 'core-extension' )),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Youtube video ID', 'core-extension'),
				"param_name" => "youtube_id",
				"dependency" => array(
					'element' => "bg_v_source",
					'value' => 'youtube'
				),
				"description" => wp_kses_post( __('Enter just the video ID, <strong>not</strong> the full link.', 'core-extension' )),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Video sound', 'core-extension'),
				"param_name" => "video_sound",
				"value" => array(
					esc_html__('Mute sound', 'core-extension') => "",
					esc_html__('Play sound', 'core-extension') => "play_sound",
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Video background parallax effect', 'core-extension'),
				"param_name" => "parallax_video",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "wtbx_parallax_video",
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"description" => esc_html__('Parallax effect for video during the scroll', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Background video parallax effect intensity', 'core-extension'),
				"param_name" => "video_parallax_intensity",
				"std" => '2',
				'range_from' => '0',
				'range_to' => '10',
				'step' => 0.5,
				'save_always' => true,
				"description" => esc_html__('You can change the intensity of parallax effect by altering the decimal number.', 'core-extension'),
				"dependency" => array(
					'element'   => 'parallax_video',
					'value'     => 'wtbx_parallax_video'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster image', 'core-extension'),
				"param_name" => "video_poster",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'video'
				),
				"description" => esc_html__('If added, this image will be displayed on desktop before the video is loaded and replace the video on mobile devices.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Animated layer', 'core-extension'),
				"param_name" => "animated_layer",
				"value" => array(
					esc_html__('Disable', 'core-extension') => '',
					esc_html__('Background image', 'core-extension') => 'anim_bg_image',
					esc_html__('Background segments', 'core-extension') => 'anim_bg_segments'
				),
				"description" => wp_kses_post( __('Animated background layer over the background attachment. <strong>Note:</strong> Background segments only work with image background.', 'core-extension' )),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Segments style', 'core-extension'),
				"param_name" => "segments_style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => 'anim_style_1',
					esc_html__('Style 2', 'core-extension') => 'anim_style_2',
					esc_html__('Style 3', 'core-extension') => 'anim_style_3',
					esc_html__('Style 4', 'core-extension') => 'anim_style_4',
					esc_html__('Style 5', 'core-extension') => 'anim_style_5',
					esc_html__('Style 6', 'core-extension') => 'anim_style_6',
					esc_html__('Style 7', 'core-extension') => 'anim_style_7',
				),
				"dependency" => array(
					'element' => "animated_layer",
					'value' => 'anim_bg_segments'
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "anim_bg_image",
				"dependency" => array(
					'element' => "animated_layer",
					'value' => 'anim_bg_image'
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background size', 'core-extension'),
				"param_name" => "anim_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "auto",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "anim_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => 'repeat',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "anim_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "anim_bg_attachment",
				"value" => array(
					esc_html__('Scroll', 'core-extension') => 'scroll',
					esc_html__('Fixed', 'core-extension') => 'fixed'
				),
				'save_always' => true,
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "anim_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Animation', 'core-extension'),
				"param_name" => "anim_direction",
				"value" => array(
					esc_html__('No animation', 'core-extension') => '',
					esc_html__('Left to right', 'core-extension') => 'to_right',
					esc_html__('Right to left', 'core-extension') => 'to_left',
					esc_html__('Top to bottom', 'core-extension') => 'to_bottom',
					esc_html__('Bottom to top', 'core-extension') => 'to_top',
				),
				'std' => 'to_left',
				'save_always' => true,
				"dependency" => array(
					'element' => "animated_layer",
					'value' => array('anim_bg_image', 'anim_bg_text')
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Animation cycle time', 'core-extension'),
				"param_name" => "anim_time",
				"std" => '40',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Animation time in seconds.', 'core-extension'),
				"dependency" => array(
					'element' => "animated_layer",
					'value' => array('anim_bg_image', 'anim_bg_text')
				),
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Disable animated layer on small screens', 'core-extension'),
				"param_name" => 'anim_disable',
				"value" => array(
					esc_html__('Do not disable', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => '',
				"group" => esc_html__('Animated layer', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Row font Color', 'core-extension' ),
				'param_name' => 'font_color',
				'description' => esc_html__( 'Select font color', 'core-extension' ),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Row text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Right', 'core-extension') => "align_right"
				),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Force center alignment on smaller screens', 'core-extension'),
				"param_name" => 'textalign_small',
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Row font style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content fadeout effect', 'core-extension' ),
				'param_name' => 'fadeout',
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "wtbx-fadeout",
				),
				'description' => esc_html__( 'If enabled, hero section content will shift and fade out as the user scrolls down.', 'core-extension' ),
				'group' => esc_html__( 'Misc', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Add ID to row', 'core-extension'),
				"param_name" => "row_id",
				"description" => esc_html__('This ID is used to make one page menu or scroll to anchor. Please give unique ID to each row, if using menu for one page style.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Anchor label', 'core-extension'),
				"param_name" => "anchor",
				"description" => esc_html__('Anchor label is needed if fullscreen page slider mode is activated. Will be displayed next to navigation dots.', 'core-extension'),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Slide skin', 'core-extension'),
				"param_name" => "nav_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')           => "light",
					esc_html__('Light colorful', 'core-extension')  => "light skin_colorful",
					esc_html__('Dark', 'core-extension')            => "dark",
					esc_html__('Dark colorful', 'core-extension')   => "dark skin_colorful",
				),
				'save_always' => true,
				'description' => esc_html__( 'Used when fullscreen page slider mode is activated. Skin is applied to slider navigation and site header (header styles 1 - 6 only) .', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Disable row', 'core-extension' ),
				'param_name' => 'disable_element',
				'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'core-extension' ),
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Hide this row on screen sizes:', 'core-extension'),
				"param_name" => "row_show_on",
				"value" => Array(
					wp_kses_post( __("<strong>Desktop</strong> (on screen sizes larger than 1025px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_on_normal_screen',
					wp_kses_post( __("<strong>Tablet Landscape</strong> (on screen sizes from 980px - 1024px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_tablet_landscape',
					wp_kses_post( __("<strong>Tablet Portrait</strong> (on screen sizes from 768px - 979px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_tablet_portrait',
					wp_kses_post( __("<strong>Mobile Landscape</strong> (on screen sizes from 480px - 767px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_mobile_landscape',
					wp_kses_post( __("<strong>Mobile Portrait</strong> (on screen sizes smaller than 479px)", 'core-extension' )) => 'wtbx_hide_mobile_portrait'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			wtbx_disable_css('fixed height', 'Disable min height and relative height on smaller screens, and enforce automatic height.'),
			wtbx_disable_css('columns gap'),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Consent ID', 'core-extension' ),
				'param_name' => 'consent_id',
				"value" => wtbx_vc_get_all_consents(),
				'description' => esc_html__( 'Choose which consent this row\'s content should be dependent on.', 'core-extension' ),
				'group' => esc_html__( 'Consent', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Include or exclude', 'core-extension' ),
				'param_name' => 'consent_include',
				"value" => array(
					esc_html__('Include', 'core-extension') => "include",
					esc_html__('Exclude', 'core-extension') => "exclude",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose whether include or exclude the content based on whether the consent has been received.', 'core-extension' ),
				'group' => esc_html__( 'Consent', 'core-extension' )
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Poster', 'core-extension'),
				"param_name" => "consent_poster",
				"value" => "",
				'dependency' => array(
					'element' => 'consent_id',
					'not_empty' => true,
				),
				'description' => esc_html__( 'If poster image is added, in cases when the content is hidden, users will see the poster together with invitation to review the Privacy Preferences.', 'core-extension' ),
				"group" => esc_html__('Consent', 'core-extension')
			),
		),
		'js_view' => 'VcRowView',
	) );

	// Row inner
	vc_map( array(
		'name' => esc_html__( 'Row', 'core-extension' ),
		'base' => 'vc_row_inner',
		'content_element' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-vc_row',
		'weight' => 1000,
		'show_settings_on_create' => false,
		'description' => esc_html__( 'Place content elements inside the row', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Row stretch', 'core-extension' ),
				'param_name' => 'row_width',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Stretch row', 'core-extension' ) => 'wtbx_stretch_row',
					esc_html__( 'Stretch row and content', 'core-extension' ) => 'wtbx_stretch_row_content',
				),
				'std' => 'wtbx_stretch_row',
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Max width', 'core-extension'),
				"param_name" => "max_width",
				"value" => '',
				"description" => esc_html__('Set the maximum width of the row in pixels.', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Row height', 'core-extension'),
				"param_name" => "row_height_type",
				"value" => array(
					'Auto' => '',
					'Relative height (as percentage of screen height)' => 'fixed_height_screen',
				),
				"description" => esc_html__('Choose automatic row height based on height of its content (default behaviour) and fixed height (great for landing pages with image or video background).', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Height', 'core-extension'),
				"param_name" => "height",
				"std" => '100',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Set the height that the row in percentage.', 'core-extension'),
				"dependency" => array(
					'element' => "row_height_type",
					'value' => array('fixed_height_cont', 'fixed_height_screen')
				),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Min height', 'core-extension'),
				"param_name" => "min_height",
				"value" => '',
				"description" => esc_html__('Set the minimum height of the row in pixels.', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Force align row within container', 'core-extension' ),
				'param_name' => 'row_alignment',
				'value' => array(
					esc_html__( 'Disable', 'core-extension' ) => '',
					esc_html__( 'Top', 'core-extension' ) => 'top',
					esc_html__( 'Middle', 'core-extension' ) => 'middle',
					esc_html__( 'Bottom', 'core-extension' ) => 'bottom',
				),
				'std' => '',
				'description' => esc_html__( 'Select content position within columns.', 'core-extension' ),
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Border color', 'core-extension' ),
				'param_name' => 'border_color',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Opposite column float', 'core-extension'),
				"param_name" => "opposite_float",
				"description" => esc_html__('Enable to make your columns float to the opposite side. Allows better control of the column stacking order on smaller screens.', 'core-extension'),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Equal height columns', 'core-extension'),
				"param_name" => "equal_height",
				"description" => esc_html__('Enable equal height columns in this row', 'core-extension'),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns gap', 'core-extension' ),
				'param_name' => 'gap',
				'value' => array(
					'default' => '',
					'0px' => '0',
					'1px' => '1',
					'2px' => '2',
					'3px' => '3',
					'4px' => '4',
					'5px' => '5',
					'10px' => '10',
					'15px' => '15',
					'20px' => '20',
					'25px' => '25',
					'30px' => '30',
					'35px' => '35',
				),
				'std' => '',
				'description' => esc_html__( 'Select gap between columns in row.', 'core-extension' ),
				"dependency" => array(
					'element' => "equal_height",
					'not_empty' => true
				),
				"group" => esc_html__('Columns', 'core-extension')
			),
//			array(
//				'type' => 'dropdown',
//				'heading' => esc_html__( 'Column side space', 'core-extension' ),
//				'param_name' => 'row_side_space',
//				'value' => array(
//					esc_html__( 'Enable', 'core-extension' ) => '',
//					esc_html__( 'Disable', 'core-extension' ) => 'wtbx_no_column_space',
//				),
//				"dependency" => array(
//					'element' => "gap",
//					'not_empty' => true
//				),
//				'description' => esc_html__( 'Disabling side space will result in no empty space before the first and after the last column. Columns will be stretched to the sides of the row.', 'core-extension' ),
//				"group" => esc_html__('Columns', 'core-extension')
//			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns position', 'core-extension' ),
				'param_name' => 'columns_placement',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Middle', 'core-extension' ) => 'middle',
					esc_html__( 'Top', 'core-extension' ) => 'top',
					esc_html__( 'Bottom', 'core-extension' ) => 'bottom',
					esc_html__( 'Stretch', 'core-extension' ) => 'stretch',
				),
				'std' => 'stretch',
				'description' => esc_html__( 'Select columns position within row.', 'core-extension' ),
				"dependency" => array(
					'element' => "equal_height",
					'not_empty' => true
				),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content position', 'core-extension' ),
				'param_name' => 'content_placement',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Top', 'core-extension' ) => 'top',
					esc_html__( 'Middle', 'core-extension' ) => 'middle',
					esc_html__( 'Bottom', 'core-extension' ) => 'bottom',
				),
				'std' => '',
				'description' => esc_html__( 'Select content position within columns.', 'core-extension' ),
				"dependency" => array(
					'element' => "equal_height",
					'not_empty' => true
				),
				"group" => esc_html__('Columns', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "custom_bg_color",
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background type', 'core-extension'),
				"param_name" => "custom_bg_type",
				"value" => array(
					esc_html__('Without attachment', 'core-extension')   => '',
					esc_html__('Image background', 'core-extension')     => 'image',
				),
				"description" => esc_html__('Choose the type of background attachment for this row.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "custom_bg_image",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background-cover', 'core-extension'),
				"param_name" => "custom_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				'std' => 'cover',
				'save_always' => true,
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "custom_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => '',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'std' => 'no-repeat',
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "custom_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'std' => 'Center center',
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "custom_bg_attachment",
				"value" => array(
					esc_html__('Scroll', 'core-extension') => 'scroll',
					esc_html__('Fixed', 'core-extension') => 'fixed'
				),
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Enable lazy background image loading', 'core-extension'),
				"param_name" => "lazy",
				"value" => array(
					esc_html__('Default theme setting', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "1",
					esc_html__('Disable', 'core-extension') => "0"
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Row font Color', 'core-extension' ),
				'param_name' => 'font_color',
				'description' => esc_html__( 'Select font color', 'core-extension' ),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Row text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Right', 'core-extension') => "align_right"),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Force center alignment on smaller screens', 'core-extension'),
				"param_name" => 'textalign_small',
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Row font style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Hide this row on screen sizes:', 'core-extension'),
				"param_name" => "row_show_on",
				"value" => Array(
					wp_kses_post( __("<strong>Desktop</strong> (on screen sizes larger than 1025px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_on_normal_screen',
					wp_kses_post( __("<strong>Tablet Landscape</strong> (on screen sizes from 980px - 1024px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_tablet_landscape',
					wp_kses_post( __("<strong>Tablet Portrait</strong> (on screen sizes from 768px - 979px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_tablet_portrait',
					wp_kses_post( __("<strong>Mobile Landscape</strong> (on screen sizes from 480px - 767px)<br/><br/>", 'core-extension' )) => 'wtbx_hide_mobile_landscape',
					wp_kses_post( __("<strong>Mobile Portrait</strong> (on screen sizes smaller than 479px)", 'core-extension' )) => 'wtbx_hide_mobile_portrait'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			wtbx_disable_css('fixed height'),
//			wtbx_disable_css('margins'),
//			wtbx_disable_css('borders'),
//			wtbx_disable_css('padding'),
			wtbx_disable_css('columns gap'),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Add ID to row', 'core-extension'),
				"param_name" => "row_id",
				"description" => esc_html__('This ID is used to make one page menu or scroll to anchor. Please give unique ID to each row, if using menu for one page style.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Disable row', 'core-extension' ),
				'param_name' => 'disable_element',
				'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'core-extension' ),
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Consent ID', 'core-extension' ),
				'param_name' => 'consent_id',
				"value" => wtbx_vc_get_all_consents(),
				'description' => esc_html__( 'Choose which consent this row\'s content should be dependent on.', 'core-extension' ),
				'group' => esc_html__( 'Consent', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Include or exclude', 'core-extension' ),
				'param_name' => 'consent_include',
				"value" => array(
					esc_html__('Include', 'core-extension') => "include",
					esc_html__('Exclude', 'core-extension') => "exclude",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose whether include or exclude the content based on whether the consent has been received.', 'core-extension' ),
				'group' => esc_html__( 'Consent', 'core-extension' )
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Poster', 'core-extension'),
				"param_name" => "consent_poster",
				"value" => "",
				'dependency' => array(
					'element' => 'consent_id',
					'not_empty' => true,
				),
				'description' => esc_html__( 'If poster image is added, in cases when the content is hidden, users will see the poster together with invitation to review the Privacy Preferences.', 'core-extension' ),
				"group" => esc_html__('Consent', 'core-extension')
			),
		),
		'js_view' => 'VcRowView'
	) );

	// Column
	$column_width_list = array(
		esc_html__('1 column - 1/12', 'core-extension') => '1/12',
		esc_html__('2 columns - 1/6', 'core-extension') => '1/6',
		esc_html__('3 columns - 1/4', 'core-extension') => '1/4',
		esc_html__('4 columns - 1/3', 'core-extension') => '1/3',
		esc_html__('5 columns - 5/12', 'core-extension') => '5/12',
		esc_html__('6 columns - 1/2', 'core-extension') => '1/2',
		esc_html__('7 columns - 7/12', 'core-extension') => '7/12',
		esc_html__('8 columns - 2/3', 'core-extension') => '2/3',
		esc_html__('9 columns - 3/4', 'core-extension') => '3/4',
		esc_html__('10 columns - 5/6', 'core-extension') => '5/6',
		esc_html__('11 columns - 11/12', 'core-extension') => '11/12',
		esc_html__('12 columns - 1/1', 'core-extension') => '1/1',
		esc_html__('20% - 1/5', 'core-extension') => '1/5',
		esc_html__('40% - 2/5', 'core-extension') => '2/5',
		esc_html__('60% - 3/5', 'core-extension') => '3/5',
		esc_html__('80% - 4/5', 'core-extension') => '4/5',
	);
	vc_map( array(
		'name' => esc_html__( 'Column', 'core-extension' ),
		'base' => 'vc_column',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Min height', 'core-extension'),
				"param_name" => "min_height",
				"value" => '',
				"description" => esc_html__('Set the minimum height of the row in pixels.', 'core-extension'),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Make whole column a link', 'core-extension' ),
				'param_name' => 'column_link',
				'value' => array( esc_html__( 'Yes, please', 'core-extension' ) => 'yes' )
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element' => 'column_link',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
				'padding-h' => '15',
				'padding-v' => '15',
				'value' => '{"desktop":{"padding-top":15,"padding-right":15,"padding-bottom":15,"padding-left":15}}',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Border color', 'core-extension' ),
				'param_name' => 'border_color',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "custom_bg_color",
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background type', 'core-extension'),
				"param_name" => "custom_bg_type",
				"value" => array(
					esc_html__('Without attachment', 'core-extension')   => '',
					esc_html__('Image background', 'core-extension')     => 'image',
				),
				"description" => esc_html__('Choose the type of background attachment for this section.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "custom_bg_image",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background-cover', 'core-extension'),
				"param_name" => "custom_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				'std' => 'cover',
				'save_always' => true,
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "custom_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => '',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'std' => 'no-repeat',
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "custom_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'std' => 'Center center',
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "custom_bg_attachment",
				"value" => array(
					esc_html__('Scroll', 'core-extension') => 'scroll',
					esc_html__('Fixed', 'core-extension') => 'fixed'
				),
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Enable lazy background image loading', 'core-extension'),
				"param_name" => "lazy",
				"value" => array(
					esc_html__('Default theme setting', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "1",
					esc_html__('Disable', 'core-extension') => "0"
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Column font Color', 'core-extension' ),
				'param_name' => 'font_color',
				'description' => esc_html__( 'Select font color', 'core-extension' ),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Column text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Right', 'core-extension') => "align_right"),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Force center alignment on smaller screens', 'core-extension'),
				"param_name" => 'textalign_small',
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Column font style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
//			array(
//				"type" => "wtbx_vc_slider",
//				'heading' => esc_html__( 'Vertical shift', 'core-extension' ),
//				'param_name' => 'column_shift',
//				"std" => '0',
//				'range_from' => '-10',
//				'range_to' => '10',
//				'step' => '1',
//				'description' => esc_html__( 'Shift column vertically on scroll to achieve parallax effect.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "wtbx_vc_slider",
//				'heading' => esc_html__( 'Scale', 'core-extension' ),
//				'param_name' => 'column_scale',
//				"std" => '0',
//				'range_from' => '0',
//				'range_to' => '10',
//				'step' => '1',
//				'description' => esc_html__( 'Scale column on scroll.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "wtbx_vc_slider",
//				'heading' => esc_html__( 'Opacity', 'core-extension' ),
//				'param_name' => 'column_opacity',
//				"std" => '0',
//				'range_from' => '0',
//				'range_to' => '10',
//				'step' => '1',
//				'description' => esc_html__( 'Change column opacity on scroll.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Animation speed', 'core-extension'),
//				"param_name" => 'column_scroll_speed',
//				"value" => array(
//					esc_html__('Instant (no animation)', 'core-extension') => '',
//					esc_html__('Smooth', 'core-extension') => 'column_scroll_smooth',
//				),
//				'std' => '',
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Sticky column', 'core-extension'),
//				"param_name" => 'column_sticky',
//				"value" => array(
//					esc_html__('Disable', 'core-extension') => '',
//					esc_html__('Enable', 'core-extension') => 'wtbx-sticky',
//				),
//				'std' => '',
//				'description' => esc_html__( 'Make this column sticky. Will override and disable scroll animation settings above.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Disable scroll animation and stickyness on smaller screens', 'core-extension'),
//				"param_name" => 'column_scroll_small',
//				"value" => array(
//					esc_html__('Do not force', 'core-extension') => '',
//					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
//					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
//					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
//					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
//				),
//				'std' => '',
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Width', 'core-extension' ),
				'param_name' => 'width',
				'value' => $column_width_list,
				'group' => esc_html__( 'Responsiveness', 'core-extension' ),
				'description' => esc_html__( 'Select column width.', 'core-extension' ),
				'std' => '1/1'
			),
			array(
				'type' => 'column_offset',
				'heading' => esc_html__('Responsiveness', 'core-extension'),
				'param_name' => 'offset',
				'group' => esc_html__( 'Responsiveness', 'core-extension' ),
				'description' => esc_html__('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'core-extension')
			),
			wtbx_disable_css('fixed height'),
//			wtbx_disable_css('margins'),
//			wtbx_disable_css('borders'),
//			wtbx_disable_css('padding'),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		'js_view' => 'VcColumnView'
	) );

	// Column inner
	vc_map( array(
		'name' => esc_html__( 'Column', 'core-extension' ),
		'base' => 'vc_column_inner',
		'is_container' => true,
		'content_element' => false,
		'allowed_container_element' => array('vc_pricing_box', 'vc_content_box'),
		'controls' => 'full',
		'params' => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Min height', 'core-extension'),
				"param_name" => "min_height",
				"value" => '',
				"description" => esc_html__('Set the minimum height of the row in pixels.', 'core-extension'),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Make whole column a link', 'core-extension' ),
				'param_name' => 'column_link',
				'value' => array( esc_html__( 'Yes, please', 'core-extension' ) => 'yes' )
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element' => 'column_link',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
				'padding-h' => '15',
				'padding-v' => '15',
				'value' => '{"desktop":{"padding-top":15,"padding-right":15,"padding-bottom":15,"padding-left":15}}',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Border color', 'core-extension' ),
				'param_name' => 'border_color',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "custom_bg_color",
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background type', 'core-extension'),
				"param_name" => "custom_bg_type",
				"value" => array(
					esc_html__('Without attachment', 'core-extension')   => '',
					esc_html__('Image background', 'core-extension')     => 'image',
				),
				"description" => esc_html__('Choose the type of background attachment for this section.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Background image', 'core-extension'),
				"param_name" => "custom_bg_image",
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Background-cover', 'core-extension'),
				"param_name" => "custom_bg_cover",
				"description" => esc_html__('Set to "Cover" if you want the image to cover all the background area.', 'core-extension'),
				"value" => array(
					esc_html__('Auto', 'core-extension') => "",
					esc_html__('Cover', 'core-extension') => "cover",
					esc_html__('Contain', 'core-extension') => "contain"
				),
				'std' => 'cover',
				'save_always' => true,
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background repeat', 'core-extension'),
				"param_name" => "custom_bg_repeat",
				"value" => array(
					esc_html__('Repeat all', 'core-extension') => '',
					esc_html__('Repeat horizontally', 'core-extension') => 'repeat-x',
					esc_html__('Repeat vertically', 'core-extension') => 'repeat-y',
					esc_html__('No repeat', 'core-extension') => 'no-repeat'),
				'std' => 'no-repeat',
				'save_always' => true,
				"description" => esc_html__('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background position', 'core-extension'),
				"param_name" => "custom_bg_position",
				"value" => array(
					'Left top',
					'Left center',
					'Left bottom',
					'Right top',
					'Right center',
					'Right bottom',
					'Center top',
					'Center center',
					'Center bottom'
				),
				'std' => 'Center center',
				'save_always' => true,
				"description" => esc_html__('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background attachment', 'core-extension'),
				"param_name" => "custom_bg_attachment",
				"value" => array(
					esc_html__('Scroll', 'core-extension') => 'scroll',
					esc_html__('Fixed', 'core-extension') => 'fixed'
				),
				"description" => esc_html__('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => array(
					'element' => "custom_bg_image",
					'not_empty' => true
				),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Enable lazy background image loading', 'core-extension'),
				"param_name" => "lazy",
				"value" => array(
					esc_html__('Default theme setting', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "1",
					esc_html__('Disable', 'core-extension') => "0"
				),
				"dependency" => array(
					'element' => "custom_bg_type",
					'value' => 'image'
				),
				"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
				"group" => esc_html__('Background', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Column font Color', 'core-extension' ),
				'param_name' => 'font_color',
				'description' => esc_html__( 'Select font color', 'core-extension' ),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Column text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Right', 'core-extension') => "align_right"),
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Force center alignment on smaller screens', 'core-extension'),
				"param_name" => 'textalign_small',
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Column font style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				'group' => esc_html__( 'Typography', 'core-extension' )
			),
//			array(
//				"type" => "wtbx_vc_slider",
//				'heading' => esc_html__( 'Vertical shift', 'core-extension' ),
//				'param_name' => 'column_shift',
//				"std" => '0',
//				'range_from' => '-10',
//				'range_to' => '10',
//				'step' => '1',
//				'description' => esc_html__( 'Shift column vertically on scroll to achieve parallax effect.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "wtbx_vc_slider",
//				'heading' => esc_html__( 'Scale', 'core-extension' ),
//				'param_name' => 'column_scale',
//				"std" => '0',
//				'range_from' => '0',
//				'range_to' => '10',
//				'step' => '1',
//				'description' => esc_html__( 'Scale column on scroll.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "wtbx_vc_slider",
//				'heading' => esc_html__( 'Opacity', 'core-extension' ),
//				'param_name' => 'column_opacity',
//				"std" => '0',
//				'range_from' => '0',
//				'range_to' => '10',
//				'step' => '1',
//				'description' => esc_html__( 'Change column opacity on scroll.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Animation speed', 'core-extension'),
//				"param_name" => 'column_scroll_speed',
//				"value" => array(
//					esc_html__('Instant (no animation)', 'core-extension') => '',
//					esc_html__('Smooth', 'core-extension') => 'column_scroll_smooth',
//				),
//				'std' => '',
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Sticky column', 'core-extension'),
//				"param_name" => 'column_sticky',
//				"value" => array(
//					esc_html__('Disable', 'core-extension') => '',
//					esc_html__('Enable', 'core-extension') => 'wtbx-sticky',
//				),
//				'std' => '',
//				'description' => esc_html__( 'Make this column sticky. Will override and disable scroll animation settings above.', 'core-extension' ),
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Disable scroll animation and stickyness on smaller screens', 'core-extension'),
//				"param_name" => 'column_scroll_small',
//				"value" => array(
//					esc_html__('Do not force', 'core-extension') => '',
//					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
//					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
//					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
//					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
//				),
//				'std' => '',
//				'group' => esc_html__( 'Scroll animation', 'core-extension' )
//			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Width', 'core-extension' ),
				'param_name' => 'width',
				'value' => $column_width_list,
				'group' => esc_html__( 'Responsiveness', 'core-extension' ),
				'description' => esc_html__( 'Select column width.', 'core-extension' ),
				'std' => '1/1'
			),
			array(
				'type' => 'column_offset',
				'heading' => esc_html__('Responsiveness', 'core-extension'),
				'param_name' => 'offset',
				'group' => esc_html__( 'Responsiveness', 'core-extension' ),
				'description' => esc_html__('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'core-extension')
			),
			wtbx_disable_css('fixed height'),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		'js_view' => 'VcColumnView'
	) );

	// Section divider
	vc_map( array(
		'name' => esc_html__( 'Section divider', 'core-extension' ),
		'base' => 'vc_section_divider',
		'icon' => 'icon-wpb-vc_section_divider',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Structure', 'core-extension') ),
		'description' => esc_html__( 'Horizontal SVG section divider', 'core-extension' ),
		'weight' => 2,
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Divider style', 'core-extension'),
				"param_name" => "style",
				'admin_label' => true,
				"value" => array(
					esc_html__('Slope left', 'core-extension')  => "slope-left",
					esc_html__('Slope right', 'core-extension')  => "slope-right",
					esc_html__('Corner left', 'core-extension')  => "corner-left",
					esc_html__('Corner right', 'core-extension')  => "corner-right",
					esc_html__('Curve top', 'core-extension')  => "curve-top",
					esc_html__('Curve bottom', 'core-extension')  => "curve-bottom",
					esc_html__('Curve left', 'core-extension')  => "curve-left",
					esc_html__('Curve right', 'core-extension')  => "curve-right",
					esc_html__('Notch top', 'core-extension')  => "notch-top",
					esc_html__('Notch bottom', 'core-extension')  => "notch-bottom",
					esc_html__('Waves 1', 'core-extension')  => "waves-1",
					esc_html__('Waves 2', 'core-extension')  => "waves-2",
					esc_html__('Waves 3', 'core-extension')  => "waves-3",
					esc_html__('Waves 4', 'core-extension')  => "waves-4",
					esc_html__('Waves 5', 'core-extension')  => "waves-5",
					esc_html__('Waves 6', 'core-extension')  => "waves-6",
					esc_html__('Layered 1', 'core-extension')  => "layered-1",
					esc_html__('Layered 2', 'core-extension')  => "layered-2",
					esc_html__('Layered 3', 'core-extension')  => "layered-3",
					esc_html__('Layered 4', 'core-extension')  => "layered-4",
					esc_html__('Layered 5', 'core-extension')  => "layered-5",
					esc_html__('Layered 6', 'core-extension')  => "layered-6",
				),
				'save_always' => true,
				'group' => esc_html__( 'Style', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Divider color', 'core-extension' ),
				'param_name' => 'color',
				'group' => esc_html__( 'Style', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Z-index', 'core-extension' ),
				'param_name' => 'zindex',
				'group' => esc_html__( 'Style', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Height', 'core-extension' ),
				"param_name" => "height",
				"std" => '200',
				'range_from' => '0',
				'range_to' => '500',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( 'Divider height in <code>px</code>.', 'core-extension' )),
				"dependency" => array(
					'element' => "style",
					'value' => array(
						'slope-left',
						'slope-right',
						'corner-left',
						'corner-right',
						'curve-top',
						'curve-bottom',
						'curve-left',
						'curve-right',
						'waves-1',
						'waves-2',
						'waves-3',
						'waves-4',
						'waves-5',
						'waves-6',
						'layered-1',
						'layered-2',
						'layered-3',
						'layered-4',
						'layered-5',
						'layered-6'
					)
				),
				'group' => esc_html__( 'Height', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"description" => esc_html__('Enable custom height settings for smaller screens', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"dependency" => array(
					'element' => "style",
					'value' => array(
						'slope-left',
						'slope-right',
						'corner-left',
						'corner-right',
						'curve-top',
						'curve-bottom',
						'curve-left',
						'curve-right',
						'waves-1',
						'waves-2',
						'waves-3',
						'waves-4',
						'waves-5',
						'waves-6',
						'layered-1',
						'layered-2',
						'layered-3',
						'layered-4',
						'layered-5',
						'layered-6'
					)
				),
				"group" => esc_html__('Height', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Custom height for tablet landscape', 'core-extension' ),
				'param_name' => 'tablet_landscape',
				"std" => '200',
				'range_from' => '0',
				'range_to' => '500',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( '1024px and below. Set to <code>0</code> to hide completely.', 'core-extension' )),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				'group' => esc_html__( 'Height', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Custom height for tablet portrait', 'core-extension' ),
				'param_name' => 'tablet_portrait',
				"std" => '100',
				'range_from' => '0',
				'range_to' => '500',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( '979px and below. Set to <code>0</code> to hide completely.', 'core-extension' )),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				'group' => esc_html__( 'Height', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Custom height for mobile landscape', 'core-extension' ),
				'param_name' => 'mobile_landscape',
				"std" => '0',
				'range_from' => '0',
				'range_to' => '500',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( '767px and below. Set to <code>0</code> to hide completely.', 'core-extension' )),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				'group' => esc_html__( 'Height', 'core-extension' )
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Custom height for mobile portrait', 'core-extension' ),
				'param_name' => 'mobile_portrait',
				"std" => '0',
				'range_from' => '0',
				'range_to' => '500',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( '479px and below. Set to <code>0</code> to hide completely.', 'core-extension' )),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				'group' => esc_html__( 'Height', 'core-extension' )
			),
			$extra_class
		)
	) );

	// Empty space
	vc_map( array(
		'name' => esc_html__( 'Empty Space', 'core-extension' ),
		'base' => 'vc_empty_space',
		'icon' => 'icon-wpb-vc_empty_space',
		'show_settings_on_create' => true,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Structure', 'core-extension') ),
		'description' => esc_html__( 'Blank space with custom height', 'core-extension' ),
		'weight' => 2,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Height', 'core-extension' ),
				'param_name' => 'height',
				'value' => '30px',
				'admin_label' => true,
				'description' => wp_kses_post( __( 'Enter empty space height (Note: CSS measurement units allowed). E.g. <code>30px</code>, <code>2em</code>, <code>50%</code>.', 'core-extension' )),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Custom height for tablet landscape', 'core-extension' ),
				'param_name' => 'tablet_landscape',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( '1024px and below.', 'core-extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Custom height for tablet portrait', 'core-extension' ),
				'param_name' => 'tablet_portrait',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( '992px and below.', 'core-extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Custom height for mobile landscape', 'core-extension' ),
				'param_name' => 'mobile_landscape',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( '767px and below.', 'core-extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Custom height for mobile portrait', 'core-extension' ),
				'param_name' => 'mobile_portrait',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( '479px and below.', 'core-extension' ),
			),
			$extra_class
		)
	) );

	// Content block
	vc_map( array(
		'name' => esc_html__( 'Content block', 'core-extension' ),
		'base' => 'vc_content_block',
				'icon' => 'icon-wpb-vc_content_block',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		'description' => esc_html__( 'Reusable content block', 'core-extension' ),
		'weight' => 2,
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Content block to use', 'core-extension'),
				"param_name" => "block",
				"value" => $content_blocks,
				'admin_label' => true,
				'save_always' => true,
			),
			$extra_class
		)
	) );

	// Horizontal divider
	vc_map( array(
		"name"		=> esc_html__('Divider', 'core-extension'),
		"base"		=> "vc_separator",
		"icon"		=> "icon-wpb-vc_divider",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Structure', 'core-extension') ),
		"weight"    => 2,
		"description" => esc_html__('Styled horizontal divider', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Type', 'core-extension'),
				"param_name" => "style",
				"value" => array(esc_html__('Horizontal line', 'core-extension') => "horizontal",
				                 esc_html__('Horizontal line with icon', 'core-extension') => "horizontal_icon",
				                 esc_html__('Vertical line', 'core-extension') => "vertical",
				                 esc_html__('Vertical line with icon', 'core-extension') => "vertical_icon",
				                 esc_html__('Gradient line', 'core-extension') => "gradient",
				                 esc_html__('To top button', 'core-extension') => "to_top",
				)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => "align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right",
					esc_html__('Center', 'core-extension') => "none"),
				"dependency" => array(
					'element' => "style",
					'value' => array('horizontal', 'gradient')
				)
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Line color', 'core-extension'),
				"param_name" => "line_color",
				"value" => '',
				"dependency" => array(
					'element' => "style",
					'value' => array('horizontal', 'horizontal_icon', 'horizontal_text', 'vertical', 'vertical_icon', 'to_top')
				)
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				"value" => '',
				"dependency" => array(
					'element' => "style",
					'value' => array('horizontal_icon', 'vertical_icon')
				)
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Line color', 'core-extension'),
				"param_name" => "line_color_gradient",
				"value" => '',
				"dependency" => array(
					'element' => "style",
					'value' => array('gradient')
				)
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Divider line length', 'core-extension'),
				"param_name" => "width",
				"value" => '100%',
				"description" => wp_kses_post( __('Width of divider line. Enter <code>px</code> or <code>%</code> in the end for the value to be in pixels or percentages, respectively. <br />
										<strong>Example:</strong> <code>200px</code> or <code>50%</code>', 'core-extension')),
				"dependency" => array(
					'element' => "style",
					'value' => array('horizontal', 'horizontal_icon', 'horizontal_text', 'vertical', 'vertical_icon', 'gradient')
				)
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Divider line thickness', 'core-extension'),
				"param_name" => "height",
				"value" => '1px',
				"description" => wp_kses( __('Thickness of divider line. Enter <code>px</code> in the end for a fixed thickness in pixels. <br />
										<strong>Example:</strong> <code>3px</code>', 'core-extension'), 'default'),
				"dependency" => array(
					'element' => "style",
					'value' => array('horizontal', 'horizontal_icon', 'horizontal_text', 'vertical', 'vertical_icon', 'gradient', 'to_top')
				)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Line style', 'core-extension'),
				"param_name" => "border_style",
				"value" => array(esc_html__('Solid', 'core-extension') => "solid",
				                 esc_html__('Dashed', 'core-extension') => "dashed",
				                 esc_html__('Dotted', 'core-extension') => "dotted",
				                 esc_html__('Double', 'core-extension') => "double"
				),
				"dependency" => array(
					'element' => "style",
					'value' => array('horizontal', 'horizontal_icon', 'horizontal_text', 'vertical', 'vertical_icon', 'to_top')
				)
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element' => 'style',
					'value' => array('horizontal_icon', 'vertical_icon')
				),
				"group" => esc_html__('Icon', 'core-extension'),
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)

	) );

	// Tabs
	$tab_id_1 = 'tab-' . time() . '-1-' . rand( 0, 100 );
	$tab_id_2 = 'tab-' . time() . '-2-' . rand( 0, 100 );
	vc_map( array(
		"name" => esc_html__( 'Tabs', 'core-extension' ),
		'base' => 'vc_custom_tabs',
		'show_settings_on_create' => false,
		'is_container' => true,
		'as_parent' => array(
			'only' => 'vc_custom_tab',
		),
		'icon' => 'icon-wpb-vc_tabs',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		"weight" => 2,
		'description' => esc_html__( 'Tabbed content', 'core-extension' ),
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Tab navigation alignment', 'core-extension'),
				"param_name" => "tabs_align",
				"value" => array(
					esc_html__('Left', 'core-extension')   => "",
					esc_html__('Right', 'core-extension')  => "align_right",
					esc_html__('Center', 'core-extension') => "align_center"
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tabs style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3',
					esc_html__( 'Style 4', 'core-extension' ) => 'style_4'
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of tabs section.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Equal width tab navigation', 'core-extension'),
				"param_name" => "equal_width",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension')  => "equal",
				),
				'dependency' => array(
					'element'   => 'style',
					'value'     => 'style_4',
				),
				'description' => esc_html__( 'If enabled, tab navigation items will have equal width and will take full width of the container.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the tabs color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color scheme', 'core-extension'),
				"param_name" => "scheme",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Colorful', 'core-extension')  => "colorful",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the tabs color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
//				'dependency' => array(
//					'element'   => 'scheme',
//					'value'     => array('colorful'),
//				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Tabs title wrapper', 'core-extension'),
				"param_name" => 'title_wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Headings &amp; Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Tabs title font', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Headings &amp; Typography', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Tab number which is active on page load', 'core-extension'),
				"param_name" => "active",
				"value" => '1',
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Turn into accordion on smaller screens', 'core-extension'),
				"param_name" => 'mobile',
				"value" => array(
					esc_html__('Do not turn into accordion', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => 'mobile_landscape',
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Tab animation', 'core-extension'),
				"param_name" => "tab_animation",
				"value" => array(
					esc_html__('No animation', 'core-extension')        => "default",
					esc_html__('Fade', 'core-extension')                => "fade",
					esc_html__('Horizontal slide', 'core-extension')    => "slide_hor",
					esc_html__('Vertical slide', 'core-extension')      => "slide_vert",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the tabs color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		'custom_markup' => '
							<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
							<ul class="tabs_controls">
							</ul>
							%content%
							</div>'
		,
		'default_content' => '
								[vc_custom_tab title="' . esc_html__( 'Tab 1', 'core-extension' ) . '" tab_id="' . $tab_id_1 . '"][/vc_custom_tab]
								[vc_custom_tab title="' . esc_html__( 'Tab 2', 'core-extension' ) . '" tab_id="' . $tab_id_2 . '"][/vc_custom_tab]
								',
		'js_view' => 'VcCustomTabsView'
	) );

	// Tab
	vc_map( array(
		'name' => esc_html__( 'Tab', 'core-extension' ),
		'base' => 'vc_custom_tab',
		'allowed_container_element' => array('vc_row'),
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'core-extension' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Tab title.', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Tab ID', 'core-extension' ),
				'param_name' => "tab_id",
//				'settings' => array(
//					'auto_generate' => true,
//				),
//				'description' => wp_kses_post( __( 'Enter section ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'core-extension' )),
			)
		),
		'js_view' => 'VcCustomTabView',
	) );

	// Tour
	$tab_id_1 = 'tab-' . time() . '-1-' . rand( 0, 100 );
	$tab_id_2 = 'tab-' . time() . '-2-' . rand( 0, 100 );
	vc_map( array(
		"name" => esc_html__( 'Tour', 'core-extension' ),
		'base' => 'vc_custom_tour',
		'show_settings_on_create' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-vc_tour',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		"weight" => 2,
		'description' => esc_html__( 'Tabbed content', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tour style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3',
					esc_html__( 'Style 4', 'core-extension' ) => 'style_4'
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of tabs section.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Fixed navigation width (%)', 'core-extension'),
				"param_name" => "fixed_width",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Set to <code>0</code> for auto width.', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the tour color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color scheme', 'core-extension'),
				"param_name" => "scheme",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Colorful', 'core-extension')  => "colorful",
				),
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('style_1', 'style_3', 'style_4'),
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the tour color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
//				'dependency' => array(
//					'element'   => 'style',
//					'value'     => array('style_1', 'style_4'),
//				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Tabs title wrapper', 'core-extension'),
				"param_name" => 'title_wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Headings &amp; Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Tabs title font', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Headings &amp; Typography', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Tab number which is active on page load', 'core-extension'),
				"param_name" => "active",
				"value" => '1',
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Turn into accordion on smaller screens', 'core-extension'),
				"param_name" => 'mobile',
				"value" => array(
					esc_html__('Do not turn into accordion', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => 'mobile_landscape',
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Tab animation', 'core-extension'),
				"param_name" => "tab_animation",
				"value" => array(
					esc_html__('No animation', 'core-extension')        => "default",
					esc_html__('Fade', 'core-extension')                => "fade",
					esc_html__('Horizontal slide', 'core-extension')    => "slide_hor",
					esc_html__('Vertical slide', 'core-extension')      => "slide_vert",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the tabs color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		'custom_markup' => '
			<div class="wpb_tabs_holder wpb_holder vc_clearfix vc_container_for_children">
				<ul class="tabs_controls"></ul>
				%content%
			</div>',
		'default_content' => '
			[vc_custom_tab title="' . esc_html__( 'Tab 1', 'core-extension' ) . '" tab_id="' . $tab_id_1 . '"][/vc_custom_tab]
			[vc_custom_tab title="' . esc_html__( 'Tab 2', 'core-extension' ) . '" tab_id="' . $tab_id_2 . '"][/vc_custom_tab]
	    ',
		'js_view' => 'VcCustomTabsView'
	) );

	$tab_id_1 = 'tab-' . time() . '-1-' . rand( 0, 100 );
	$tab_id_2 = 'tab-' . time() . '-2-' . rand( 0, 100 );
	// Accordion
	vc_map( array(
		'name' => esc_html__( 'Accordion', 'core-extension' ),
		'base' => 'vc_custom_accordion',
		'show_settings_on_create' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-vc_accordion',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		"weight" => 2,
		'description' => esc_html__( 'Collapsible content panels', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Accordion style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3'
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of accordion section.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the accordion color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color scheme', 'core-extension'),
				"param_name" => "scheme",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Colorful', 'core-extension')  => "colorful",
				),
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('style_1', 'style_2'),
				),
				'description' => esc_html__( 'Choose the accordion color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
//				'dependency' => array(
//					'element'   => 'scheme',
//					'value'     => 'colorful',
//				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Accordion title wrapper', 'core-extension'),
				"param_name" => 'title_wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Headings &amp; Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Accordion section title font', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Headings &amp; Typography', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Accordion number which is active on page load', 'core-extension'),
				"param_name" => "active",
				"value" => '1',
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Scroll to active accordion tab', 'core-extension'),
				"param_name" => "scroll_tab",
				"value" => array(
					esc_html__('No', 'core-extension')  => "",
					esc_html__('Yes', 'core-extension')   => "1",
				),
				'save_always' => true,
				'description' => esc_html__( 'If activated, the page will scroll to the newly opened accordion tab.', 'core-extension' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		'custom_markup' => '
<div class="vc_tta-container" data-vc-action="collapseAll">
	<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
	   <div class="vc_tta-panels vc_clearfix {{container-class}}">
	      {{ content }}
	      <div class="vc_tta-panel vc_tta-section-append">
	         <div class="vc_tta-panel-heading">
	            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
	               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
	                   <span class="vc_tta-title-text">' . esc_html__( 'Add Tab', 'core-extension' ) . '</span>
	                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
					</a>
	            </h4>
	         </div>
	      </div>
	   </div>
	</div>
</div>',
		'default_content' => '
		[vc_custom_accordion_tab title="' . sprintf( '%s %d', esc_html__( 'Accordion Tab', 'core-extension' ), 1 ) . '" el_id="' . $tab_id_1 . '"][/vc_custom_accordion_tab]
		[vc_custom_accordion_tab title="' . sprintf( '%s %d', esc_html__( 'Accordion Tab', 'core-extension' ), 2 ) . '" el_id="' . $tab_id_2 . '"][/vc_custom_accordion_tab]',
		'js_view' => 'VcCustomAccordionView'
	) );

	// Accordion Tab
	vc_map( array(
		'name' => esc_html__( 'Accordion Tab', 'core-extension' ),
		'base' => 'vc_custom_accordion_tab',
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'core-extension' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Tab title.', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Tab ID', 'core-extension' ),
				'param_name' => 'el_id',
				'description' => sprintf( wp_kses_post( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>). The element ID should not start with a number.', 'core-extension' )), 'http://www.w3schools.com/tags/att_global_id.asp' ),
			),
		),
		'custom_markup' => '
		<div class="vc_tta-panel-heading">
		    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
		</div>
		<div class="vc_tta-panel-body">
			<div class="vc_controls">
				<div class="vc_controls-tc vc_control-container">
					<a class="vc_control-btn vc_element-name vc_element-move">
						<span class="vc_btn-content" title="Drag to move Accordion Tab">Accordion tab</span>
					</a>
					<a class="vc_control-btn vc_control-btn-edit" href="#" title="Edit Accordion tab"><span class="vc_btn-content"><span class="icon"></span></span></a>
					<a class="vc_control-btn vc_control-btn-clone" href="#" title="Clone Accordion tab"><span class="vc_btn-content"><span class="icon"></span></span></a>
					<a class="vc_control-btn vc_control-btn-delete" href="#" title="Delete Accordion tab"><span class="vc_btn-content"><span class="icon"></span></span></a>
				</div>
			</div>
			<div class="wpb_column_container vc_container_for_children vc_clearfix vc_empty-container ui-sortable ui-droppable"></div>
				{{ content }}
			</div>
		</div>',
		'default_content' => '',
		'js_view' => 'VcCustomAccordionTabView',
	) );

	// Content box
	vc_map( array(
		'name' => esc_html__( 'Content box', 'core-extension' ),
		'base' => 'vc_content_box',
		'icon' => 'icon-wpb-vc_content_box',
		'show_settings_on_create' => true,
		'is_container' => true,
		"weight" => 2,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		'description' => esc_html__( 'Styled container with elements inside', 'core-extension' ),
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
					esc_html__('Custom style', 'core-extension') => "style_custom",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Hover shadow animation', 'core-extension'),
				"param_name" => "hover_anim",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "hover_disable",
					esc_html__('Enable', 'core-extension') => "hover_enable",
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_1', 'style_2', 'style_4')
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Shadow on idle state', 'core-extension'),
				"param_name" => "shadow",
				"value" => array(esc_html__('No shadow', 'core-extension') => "no_shadow",
				                 esc_html__('Small shadow', 'core-extension') => "small_shadow",
				                 esc_html__('Big shadow', 'core-extension') => "big_shadow",
				),
				'save_always' => true,
				'description' => esc_html__( 'Add shadow to the content box', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_custom')
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Shadow on hover state', 'core-extension'),
				"param_name" => "shadow_hover",
				"value" => array(esc_html__('Inherit from idle state', 'core-extension') => "no_shadow",
				                 esc_html__('Small shadow', 'core-extension') => "small_shadow",
				                 esc_html__('Big shadow', 'core-extension') => "big_shadow",
				),
				'save_always' => true,
				'description' => esc_html__( 'Add shadow to the content box on hover', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_custom')
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Overflow', 'core-extension'),
				"param_name" => "overflow",
				"value" => array(esc_html__('Visible', 'core-extension') => "",
				                 esc_html__('Hidden', 'core-extension') => "hidden",
				),
				'save_always' => true,
				'description' => esc_html__( 'Set to "hidden" to hide the overflowing content (may be useful if the content box has rounded borders).', 'core-extension' ),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"description" => esc_html__('Leave empty for transparent background', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color on hover', 'core-extension'),
				"param_name" => "bg_color_hover",
				"description" => esc_html__('Leave empty for default background', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Top border color', 'core-extension'),
				"param_name" => "top_border_color",
				"description" => esc_html__('Leave empty for accent color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
				"dependency" => array(
					'element' => 'style',
					'value' => array('style_4')
				)
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Top border color on hover', 'core-extension'),
				"param_name" => "top_border_color_hover",
				"description" => esc_html__('Leave empty for default state color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
				"dependency" => array(
					'element' => 'style',
					'value' => array('style_4')
				)
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
				'padding-h' => '45',
				'padding-v' => '45',
				'offset' => false,
				'value' => '{"desktop":{"padding-top":45,"padding-right":45,"padding-bottom":45,"padding-left":45}}',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Border color', 'core-extension' ),
				'param_name' => 'border_color',
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Border', 'core-extension'),
				"param_name" => "border_hover",
				"value" => array(esc_html__('Show always', 'core-extension') => "default",
				                 esc_html__('Show only for default state', 'core-extension') => "def_state",
				                 esc_html__('Show only for hover state', 'core-extension') => "hover_state",
				),
				'save_always' => true,
				'description' => esc_html__( 'Add shadow to the content box on hover', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_custom')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Fixed maximum width', 'core-extension'),
				"param_name" => "width",
				"value" => '',
				"description" => wp_kses( __('Maximum allowed width for the box. Enter <code>px</code> or <code>%</code> in the end for the value to be in pixels or percentages, respectively. <br />
										<strong>Example:</strong> <code>200px</code> or <code>50%</code>', 'core-extension'), 'default'),
				"group" => esc_html__('Layout', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Fixed minimum height', 'core-extension'),
				"param_name" => "height",
				"value" => '',
				"description" => wp_kses_post( __('Minimum allowed height for the box in <code>px</code>.', 'core-extension' )),
				"group" => esc_html__('Layout', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Same height boxes across adjacent columns', 'core-extension'),
				"param_name" => "equal_height",
				"value" => array(
					esc_html__('Disable', 'core-extension') => '',
					esc_html__('Desktop only', 'core-extension') => '1024',
					esc_html__('Tablet Landscape and above', 'core-extension') => '979',
					esc_html__('Tablet Portrait and above', 'core-extension') => '767',
					esc_html__('Mobile Landscape and above', 'core-extension') => '479',
					esc_html__('All screen sizes', 'core-extension') => '0'
				),
				'save_always' => true,
				"description" => esc_html__('All content boxes in adjacent columns with "Same height" setting enabled will be the same height.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Horizontal box alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__('Default', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right",
				),
				'save_always' => true,
				"description" => esc_html__('Useful if the box is narrower than its container', 'core-extension'),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Vertical content alignment', 'core-extension'),
				"param_name" => "vertical_align",
				"value" => array(
					esc_html__('Disabled', 'core-extension') => "",
					esc_html__('Middle', 'core-extension') => "align_middle",
					esc_html__('Top', 'core-extension') => "align_top",
					esc_html__('Bottom', 'core-extension') => "align_bottom",
				),
				'save_always' => true,
				"description" => esc_html__('Useful if the height of the box is bigger than its content', 'core-extension'),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Horizontal content alignment', 'core-extension'),
				"param_name" => "horizontal_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right",
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force centered alignment on small screens", 'core-extension'),
				"param_name" => "textalign_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				"description" => esc_html__('Adds link to the whole content box.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcContentBoxView'
	) );

	// Content Slider
	$slide_id_1 = time() . '-1-' . rand( 0, 100 );
	$slide_id_2 = time() . '-2-' . rand( 0, 100 );
	vc_map( array(
		"name"		=> esc_html__('Content Slider', 'core-extension'),
		"base"		=> "vc_content_slider",
		"icon"		=> "icon-wpb-vc_content_slider",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('Slider with shortcode elements inside', 'core-extension'),
//		"allowed_container_element" => true,
		"is_container" => true,
		"as_parent" => array('only' => 'vc_content_slide'),
		"show_settings_on_create" => false,
		"params" => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Slider style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => 'default',
					esc_html__( 'Fixed', 'core-extension' ) => 'fixed',
//					esc_html__( 'Fixed with content', 'core-extension' ) => 'fixed_content',
					esc_html__( 'Boxed simple', 'core-extension' ) => 'boxed_simple',
					esc_html__( 'Boxed scaling', 'core-extension' ) => 'boxed_scale',
					esc_html__( 'Boxed overlapping', 'core-extension' ) => 'boxed_overlap'
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of the slider.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
//			array(
//				"type" => 'dropdown',
//				"heading" => esc_html__('Free scroll', 'core-extension'),
//				"param_name" => "freescroll",
//				"value" => array(
//					esc_html__( 'Disable', 'core-extension' )   => '',
//					esc_html__( 'Enable', 'core-extension' )    => '1'
//				),
//				'dependency' => array(
//					'element' => 'style',
//					'value' => 'default'
//				),
//				"group" => esc_html__('Design', 'core-extension')
//			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Slide padding', 'core-extension' ),
				'param_name' => 'padding',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'padding',
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('default', 'fixed', 'fixed_content'),
				),
				'description' => esc_html__( 'Use to set slide padding different from the default one (30px).', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Navigation arrows', 'core-extension'),
				"param_name" => "navigation",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Enable', 'core-extension' )    => '1',
				),
				'std' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('default', 'fixed', 'fixed_content'),
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Navigation arrows skin', 'core-extension'),
				"param_name" => "navigation_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the navigation buttons color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Pagination', 'core-extension'),
				"param_name" => "pagination",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Style 1', 'core-extension' )   => 'style_1',
					esc_html__( 'Style 2', 'core-extension' )   => 'style_2',
					esc_html__( 'Style 3', 'core-extension' )   => 'style_3'
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Pagination buttons skin', 'core-extension'),
				"param_name" => "pagination_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the pagination buttons color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Hide navigation elements', 'core-extension'),
				"param_name" => "hide_nav",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension')  => "true",
				),
				'description' => esc_html__( 'Show navigation elements only when the slider is hovered.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Number of slides per view', 'core-extension' ),
				"param_name" => "slides_to_show",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '8',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('default', 'boxed_simple', 'fixed', 'fixed_content'),
				),
				"description" => esc_html__( 'Number of slides visible at the same time.', 'core-extension' ),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Number of slides scrolled', 'core-extension'),
				"param_name" => "slides_to_scroll",
				"value" => array(
					esc_html__( 'One', 'core-extension' )           => '1',
					esc_html__( 'Whole view', 'core-extension' )    => 'all'
				),
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('default', 'boxed_simple', 'fixed', 'fixed_content'),
				),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Enable', 'core-extension' )    => 'true'
				),
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('default', 'boxed_simple', 'fixed', 'fixed_content'),
				),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Number of slides per view on tablet', 'core-extension' ),
				"param_name" => "slides_to_show_tablet",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '8',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'responsiveness',
					'not_empty'     => true,
				),
				"description" => esc_html__( 'Below 1024px', 'core-extension' ),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Number of slides per view on mobile', 'core-extension' ),
				"param_name" => "slides_to_show_mobile",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '8',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'responsiveness',
					'not_empty'     => true,
				),
				"description" => esc_html__( 'Below 768px', 'core-extension' ),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => 'textfield',
				"heading" => esc_html__('Initial slide', 'core-extension'),
				"param_name" => "initial_slide",
				"value" => '1',
				"group" => esc_html__('Settings', 'core-extension')
			),
//			array(
//				"type" => 'dropdown',
//				"heading" => esc_html__('Hide pagination and navigation when not hovered?', 'core-extension'),
//				"param_name" => "navigation_hide",
//				"value" => array(
//					esc_html__( 'No', 'core-extension' )    => 'false',
//					esc_html__( 'Yes', 'core-extension' )   => 'true'
//				),
//				'std' => 'true',
//				"group" => esc_html__('Settings', 'core-extension')
//			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Slide vertical alignment', 'core-extension'),
				"param_name" => "slide_align",
				"value" => array(
					esc_html__( 'Default', 'core-extension' )       => 'default',
					esc_html__( 'Middle', 'core-extension' )        => 'middle',
					esc_html__( 'Equal height', 'core-extension' )  => 'fullheight'
				),
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Auto height', 'core-extension'),
				"param_name" => "autoheight",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )    => 'false',
					esc_html__( 'Enable', 'core-extension' )   => 'true'
				),
				'std' => 'false',
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Slider speed', 'core-extension' ),
				"param_name" => "slider_speed",
				"std" => '20',
				'range_from' => '1',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('default', 'boxed_simple', 'boxed_scale', 'fixed', 'fixed_content'),
				),
				"group" => esc_html__('Slider animation', 'core-extension')
			),
			array(
				"type" => 'wtbx_vc_slider',
				"heading" => esc_html__('Slider autoplay speed', 'core-extension'),
				"param_name" => "autoplay",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '20',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __( 'Set time of slider autoplay in seconds. Higher number means longer interval. Set to <code>0</code> to disable autoplay.', 'core-extension' )),
				"group" => esc_html__('Slider animation', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Pause slider on hover', 'core-extension'),
				"param_name" => "stop_hover",
				"value" => array(
					esc_html__( 'No', 'core-extension' )    => 'false',
					esc_html__( 'Yes', 'core-extension' )   => 'true'
				),
				'std' => 'true',
				'save_always' => true,
				"group" => esc_html__('Slider animation', 'core-extension')
			),
		),
		'custom_markup' => '
							<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
							<ul class="tabs_controls">
							</ul>
							%content%
							</div>'
		,
		'default_content' => '
								[vc_content_slide title="' . esc_html__( 'Slide-1', 'core-extension' ) . '" slide_id="' . $slide_id_1 . '"][/vc_content_slide]
								[vc_content_slide title="' . esc_html__( 'Slide-2', 'core-extension' ) . '" slide_id="' . $slide_id_2 . '"][/vc_content_slide]
								',
		"js_view" => 'VcContentSliderView'
	) );

	// Content Slide
	vc_map( array(
		'name' => esc_html__( 'Content Slide', 'core-extension' ),
		'base' => 'vc_content_slide',
		'allowed_container_element' => array('vc_row_inner', 'vc_content_box'),
		"as_child" => array('only' => 'vc_content_slider'),
		'is_container' => true,
		'content_element' => false,
		"show_settings_on_create" => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'core-extension' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Slide title.', 'core-extension' )
			),
			array(
				'type' => 'tab_id',
				'heading' => esc_html__( 'Slide ID', 'core-extension' ),
				'param_name' => "slide_id"
			),
		),
		'js_view' => 'VcContentSlideView'
	) );

	// Default button
	vc_map( array(
		"name" => esc_html__('Default Button', 'core-extension'),
		"base" => "vc_button_default",
		"icon" => "icon-wpb-vc_button_default",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content',  'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('Predefined default style', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wtbx_button",
				"param_name" => "title",
				"value" => esc_html__('Text on the button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Button text style', 'core-extension'),
				"param_name" => "text_typography",
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action', 'core-extension' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'Link', 'core-extension' ) => 'link',
					esc_html__( 'YouTube/Vimeo video popup', 'core-extension' ) => 'video',
					esc_html__( 'Custom action', 'core-extension' ) => 'custom'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'link',
				),
				'description' => esc_html__( 'Only YouTube and Vimeo videos are supported.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Video URL', 'core-extension'),
				"param_name" => "video_url",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'video',
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'action',
					'value' => 'video',
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Custom code', 'core-extension'),
				"param_name" => "custom_action",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'custom',
				),
				'description' => esc_html__( 'Enter custom code to be executed on button click.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Primary button', 'core-extension' ) => 'primary',
					esc_html__( 'Secondary button', 'core-extension' ) => 'secondary',
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose which of the button designs to use (Primary and Secondary button design should be set in Theme Options).', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Button size', 'core-extension'),
				"param_name" => "size",
				"std" => '5',
				'range_from' => '1',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Choose button size on a scale from 1 to 10.', 'core-extension'),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button display', 'core-extension'),
				"param_name" => "display",
				"value" => array(esc_html__('Inline', 'core-extension') => "",
				                 esc_html__('Block', 'core-extension') => "display_block",
				),
				'std' => 'display_block',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "btn_align_center",
					esc_html__('Left', 'core-extension') => "btn_align_left",
					esc_html__('Right', 'core-extension') => "btn_align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(esc_html__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => esc_html__('Button takes full width of its container. If activated, button alignment is not relevant.', 'core-extension'),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force equal left and right margins on small screens", 'core-extension'),
				"description" => esc_html__('Useful in case of more than one inline button in a row.', 'core-extension'),
				"param_name" => "align_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon position', 'core-extension'),
				"param_name" => "icon_pos",
				"value" => array(
					esc_html__('Left', 'core-extension') => "icon-left",
					esc_html__('Right', 'core-extension') => "icon-right"
				),
				"description" => esc_html__('Choose position of the icon relative to button text.', 'core-extension'),
				'std' => 'icon-right',
				"group" => esc_html__('Icon', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				//				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcButtonView'
	) );

	// Buttons - with arrow
	vc_map( array(
		"name" => esc_html__('Button - with arrow', 'core-extension'),
		"base" => "vc_button_arrow",
		"icon" => "icon-wpb-vc_button_arrow",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content',  'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('Button with styled arrow', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wtbx_button",
				"param_name" => "title",
				"value" => esc_html__('Text on the button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Button text style', 'core-extension'),
				"param_name" => "text_typography",
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action', 'core-extension' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'Link', 'core-extension' ) => 'link',
					esc_html__( 'YouTube/Vimeo video popup', 'core-extension' ) => 'video',
					esc_html__( 'Custom action', 'core-extension' ) => 'custom'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'link',
				),
				'description' => esc_html__( 'Only YouTube and Vimeo videos are supported.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Video URL', 'core-extension'),
				"param_name" => "video_url",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'video',
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'action',
					'value' => 'video',
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Custom code', 'core-extension'),
				"param_name" => "custom_action",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'custom',
				),
				'description' => esc_html__( 'Enter custom code to be executed on button click.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Simple', 'core-extension' ) => 'simple',
					esc_html__( 'Square', 'core-extension' ) => 'square',
					esc_html__( 'Round', 'core-extension' ) => 'round',
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
//			array(
//				"type" => "wtbx_vc_slider",
//				"heading" => esc_html__('Button size', 'core-extension'),
//				"param_name" => "size",
//				"std" => '5',
//				'range_from' => '1',
//				'range_to' => '10',
//				'step' => '1',
//				'save_always' => true,
//				"description" => esc_html__('Choose button size on a scale from 1 to 10.', 'core-extension'),
//				"group" => esc_html__('Design', 'core-extension')
//			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button display', 'core-extension'),
				"param_name" => "display",
				"value" => array(esc_html__('Inline', 'core-extension') => "",
				                 esc_html__('Block', 'core-extension') => "display_block",
				),
				'std' => 'display_block',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "btn_align_center",
					esc_html__('Left', 'core-extension') => "btn_align_left",
					esc_html__('Right', 'core-extension') => "btn_align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(esc_html__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => esc_html__('Button takes full width of its container. If activated, button alignment is not relevant.', 'core-extension'),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force equal left and right margins on small screens", 'core-extension'),
				"description" => esc_html__('Useful in case of more than one inline button in a row.', 'core-extension'),
				"param_name" => "align_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				"group" => esc_html__('Design', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcButtonView'
	) );

	// Buttons - link
	vc_map( array(
		"name" => esc_html__('Button - Link', 'core-extension'),
		"base" => "vc_button_link",
		"icon" => "icon-wpb-vc_button_link",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content',  'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('Styled as a link', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wtbx_button",
				"param_name" => "title",
				"value" => esc_html__('Text on the button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Button text style', 'core-extension'),
				"param_name" => "text_typography",
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action', 'core-extension' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'Link', 'core-extension' ) => 'link',
					esc_html__( 'YouTube/Vimeo video popup', 'core-extension' ) => 'video',
					esc_html__( 'Custom action', 'core-extension' ) => 'custom'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'link',
				),
				'description' => esc_html__( 'Only YouTube and Vimeo videos are supported.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Video URL', 'core-extension'),
				"param_name" => "video_url",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'video',
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'action',
					'value' => 'video',
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Custom code', 'core-extension'),
				"param_name" => "custom_action",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'custom',
				),
				'description' => esc_html__( 'Enter custom code to be executed on button click.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Decoration', 'core-extension' ),
				'param_name' => 'link_decoration',
				'value' => array(
					esc_html__( 'No decoration', 'core-extension' ) => '',
					esc_html__( 'Underline', 'core-extension' ) => 'underline',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Arrow', 'core-extension' ),
				'param_name' => 'link_arrow',
				'value' => array(
					esc_html__( 'No arrow', 'core-extension' ) => '',
					esc_html__( 'Arrow on the left', 'core-extension' ) => 'arrow_left',
					esc_html__( 'Arrow on the right', 'core-extension' ) => 'arrow_right',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Button size', 'core-extension'),
				"param_name" => "size",
				"std" => '5',
				'range_from' => '1',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Choose button size on a scale from 1 to 10.', 'core-extension'),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button display', 'core-extension'),
				"param_name" => "display",
				"value" => array(esc_html__('Inline', 'core-extension') => "",
				                 esc_html__('Block', 'core-extension') => "display_block",
				),
				'std' => 'display_block',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "btn_align_center",
					esc_html__('Left', 'core-extension') => "btn_align_left",
					esc_html__('Right', 'core-extension') => "btn_align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(esc_html__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => esc_html__('Button takes full width of its container. If activated, button alignment is not relevant.', 'core-extension'),
				"group" => esc_html__('Layout', 'core-extension'),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force equal left and right margins on small screens", 'core-extension'),
				"description" => esc_html__('Useful in case of more than one inline button in a row.', 'core-extension'),
				"param_name" => "align_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon position', 'core-extension'),
				"param_name" => "icon_pos",
				"value" => array(esc_html__('Left', 'core-extension') => "icon-left",
				                 esc_html__('Right', 'core-extension') => "icon-right"),
				"description" => esc_html__('Choose position of the icon relative to button text.', 'core-extension'),
				'std' => 'icon-right',
				"group" => esc_html__('Icon', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
//				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Color (default state)', 'core-extension'),
				"param_name" => "link_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Color (hover state)', 'core-extension'),
				"param_name" => "link_color_h",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcButtonView'
	) );

	// Buttons - glowing
	vc_map( array(
		"name" => esc_html__('Button - Glowing', 'core-extension'),
		"base" => "vc_button_glowing",
		"icon" => "icon-wpb-vc_button_glowing",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content',  'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('With glowing effect', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wtbx_button",
				"param_name" => "title",
				"value" => esc_html__('Text on the button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Button text style', 'core-extension'),
				"param_name" => "text_typography",
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action', 'core-extension' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'Link', 'core-extension' ) => 'link',
					esc_html__( 'YouTube/Vimeo video popup', 'core-extension' ) => 'video',
					esc_html__( 'Custom action', 'core-extension' ) => 'custom'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'link',
				),
				'description' => esc_html__( 'Only YouTube and Vimeo videos are supported.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Video URL', 'core-extension'),
				"param_name" => "video_url",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'video',
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'action',
					'value' => 'video',
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Custom code', 'core-extension'),
				"param_name" => "custom_action",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'custom',
				),
				'description' => esc_html__( 'Enter custom code to be executed on button click.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Button size', 'core-extension'),
				"param_name" => "size",
				"std" => '5',
				'range_from' => '1',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Choose button size on a scale from 1 to 10.', 'core-extension'),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button display', 'core-extension'),
				"param_name" => "display",
				"value" => array(esc_html__('Inline', 'core-extension') => "",
				                 esc_html__('Block', 'core-extension') => "display_block",
				),
				'std' => 'display_block',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "btn_align_center",
					esc_html__('Left', 'core-extension') => "btn_align_left",
					esc_html__('Right', 'core-extension') => "btn_align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(esc_html__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => esc_html__('Button takes full width of its container. If activated, button alignment is not relevant.', 'core-extension'),
				"group" => esc_html__('Layout', 'core-extension'),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force equal left and right margins on small screens", 'core-extension'),
				"description" => esc_html__('Useful in case of more than one inline button in a row.', 'core-extension'),
				"param_name" => "align_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Padding', 'core-extension' ),
				'param_name' => 'padding',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'padding',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color",
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Border-radius', 'core-extension' ),
				'param_name' => 'border_radius',
				'variants' => array(
					'top-left'      => esc_html__('Top left', 'core-extension'),
					'top-right'     => esc_html__('Top right', 'core-extension'),
					'bottom-right'  => esc_html__('Bottom right', 'core-extension'),
					'bottom-left'   => esc_html__('Bottom left', 'core-extension'),
				),
				'property' => 'border',
				'suffix' => 'radius',
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color_h",
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color_h",
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Border-radius', 'core-extension' ),
				'param_name' => 'border_radius_h',
				'variants' => array(
					'top-left'      => esc_html__('Top left', 'core-extension'),
					'top-right'     => esc_html__('Top right', 'core-extension'),
					'bottom-right'  => esc_html__('Bottom right', 'core-extension'),
					'bottom-left'   => esc_html__('Bottom left', 'core-extension'),
				),
				'property' => 'border',
				'suffix' => 'radius',
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon position', 'core-extension'),
				"param_name" => "icon_pos",
				"value" => array(esc_html__('Left', 'core-extension') => "icon-left",
				                 esc_html__('Right', 'core-extension') => "icon-right"),
				"description" => esc_html__('Choose position of the icon relative to button text.', 'core-extension'),
				'std' => 'icon-right',
				"group" => esc_html__('Icon', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
//				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcButtonView'
	) );

	// Buttons - filling
	vc_map( array(
		"name" => esc_html__('Button - Filling', 'core-extension'),
		"base" => "vc_button_filling",
		"icon" => "icon-wpb-vc_button_filling",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content',  'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('With filling animation', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wtbx_button",
				"param_name" => "title",
				"value" => esc_html__('Text on the button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Button text style', 'core-extension'),
				"param_name" => "text_typography",
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action', 'core-extension' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'Link', 'core-extension' ) => 'link',
					esc_html__( 'YouTube/Vimeo video popup', 'core-extension' ) => 'video',
					esc_html__( 'Custom action', 'core-extension' ) => 'custom'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'link',
				),
				"value" => '',
				'description' => esc_html__( 'Only YouTube and Vimeo videos are supported.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Video URL', 'core-extension'),
				"param_name" => "video_url",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'video',
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'action',
					'value' => 'video',
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Custom code', 'core-extension'),
				"param_name" => "custom_action",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'custom',
				),
				'description' => esc_html__( 'Enter custom code to be executed on button click.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Fill animation direction', 'core-extension'),
				"param_name" => "direction",
				"value" => array(
					esc_html__('From left', 'core-extension')   => "left",
					esc_html__('From right', 'core-extension')  => "right",
					esc_html__('From top', 'core-extension')    => "top",
					esc_html__('From bottom', 'core-extension') => "bottom",
					esc_html__('From center horizontal', 'core-extension') => "center_h",
					esc_html__('From center vertical', 'core-extension') => "center_v",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Button size', 'core-extension'),
				"param_name" => "size",
				"std" => '5',
				'range_from' => '1',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Choose button size on a scale from 1 to 10.', 'core-extension'),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Shift top animation on hover', 'core-extension'),
				"param_name" => "shift",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension')  => "wtbx_shift",
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button display', 'core-extension'),
				"param_name" => "display",
				"value" => array(
					esc_html__('Inline', 'core-extension') => "",
					esc_html__('Block', 'core-extension') => "display_block",
				),
				'std' => 'display_block',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "btn_align_center",
					esc_html__('Left', 'core-extension') => "btn_align_left",
					esc_html__('Right', 'core-extension') => "btn_align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(esc_html__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => esc_html__('Button takes full width of its container. If activated, button alignment is not relevant.', 'core-extension'),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border width', 'core-extension'),
				"param_name" => "border",
				"std" => '4',
				'range_from' => '0',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force equal left and right margins on small screens", 'core-extension'),
				"description" => esc_html__('Useful in case of more than one inline button in a row.', 'core-extension'),
				"param_name" => "align_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Padding', 'core-extension' ),
				'param_name' => 'padding',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'padding',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color on hover', 'core-extension'),
				"param_name" => "text_color_h",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon position', 'core-extension'),
				"param_name" => "icon_pos",
				"value" => array(esc_html__('Left', 'core-extension') => "icon-left",
				                 esc_html__('Right', 'core-extension') => "icon-right"),
				"description" => esc_html__('Choose position of the icon relative to button text.', 'core-extension'),
				'std' => 'icon-right',
				"group" => esc_html__('Icon', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
//				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcButtonView'
	) );

	// Buttons - custom
	vc_map( array(
		"name" => esc_html__('Button - Customizable', 'core-extension'),
		"base" => "vc_button_custom",
		"icon" => "icon-wpb-vc_button_customizable",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content',  'core-extension') ),
		"weight" => 2,
		"description" => esc_html__('Fully customizable', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wtbx_button",
				"param_name" => "title",
				"value" => esc_html__('Text on the button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Button text style', 'core-extension'),
				"param_name" => "text_typography",
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action', 'core-extension' ),
				'param_name' => 'action',
				'value' => array(
					esc_html__( 'Link', 'core-extension' ) => 'link',
					esc_html__( 'YouTube/Vimeo video popup', 'core-extension' ) => 'video',
					esc_html__( 'Custom action', 'core-extension' ) => 'custom'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'link',
				),
				'description' => esc_html__( 'Only YouTube and Vimeo videos are supported.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Video URL', 'core-extension'),
				"param_name" => "video_url",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'video',
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'action',
					'value' => 'video',
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Custom code', 'core-extension'),
				"param_name" => "custom_action",
				"value" => '',
				'dependency' => array(
					'element'   => 'action',
					'value'     => 'custom',
				),
				'description' => esc_html__( 'Enter custom code to be executed on button click.', 'core-extension' ),
				"group" => esc_html__('Action', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Button size', 'core-extension'),
				"param_name" => "size",
				"std" => '5',
				'range_from' => '1',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('Choose button size on a scale from 1 to 10.', 'core-extension'),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Shift top animation on hover', 'core-extension'),
				"param_name" => "shift",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension')  => "wtbx_shift",
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button display', 'core-extension'),
				"param_name" => "display",
				"value" => array(esc_html__('Inline', 'core-extension') => "",
				                 esc_html__('Block', 'core-extension') => "display_block",
				),
				'std' => 'display_block',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "btn_align_center",
					esc_html__('Left', 'core-extension') => "btn_align_left",
					esc_html__('Right', 'core-extension') => "btn_align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(esc_html__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => esc_html__('Button takes full width of its container. If activated, button alignment is not relevant.', 'core-extension'),
				"group" => esc_html__('Layout', 'core-extension'),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force equal left and right margins on small screens", 'core-extension'),
				"description" => esc_html__('Useful in case of more than one inline button in a row.', 'core-extension'),
				"param_name" => "align_small",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Padding', 'core-extension' ),
				'param_name' => 'padding',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'padding',
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Border width', 'core-extension'),
				"param_name" => "border",
				"description" => wp_kses_post( __('Enter button border width in <code>px</code> or leave empty. <strong>Example:</strong> <code>1</code> or <code>5px</code>', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color",
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Border color', 'core-extension'),
				"param_name" => "border_color",
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Border-radius', 'core-extension' ),
				'param_name' => 'border_radius',
				'variants' => array(
					'top-left'      => esc_html__('Top left', 'core-extension'),
					'top-right'     => esc_html__('Top right', 'core-extension'),
					'bottom-right'  => esc_html__('Bottom right', 'core-extension'),
					'bottom-left'   => esc_html__('Bottom left', 'core-extension'),
				),
				'property' => 'border',
				'suffix' => 'radius',
				"group" => esc_html__('Default state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color_h",
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color_h",
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Border color', 'core-extension'),
				"param_name" => "border_color_h",
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('No border', 'core-extension'),
				"param_name" => "no_border",
				"description" => esc_html__('Check if you have a border on idle state and do not want it on hover state', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Border-radius', 'core-extension' ),
				'param_name' => 'border_radius_h',
				'variants' => array(
					'top-left'      => esc_html__('Top left', 'core-extension'),
					'top-right'     => esc_html__('Top right', 'core-extension'),
					'bottom-right'  => esc_html__('Bottom right', 'core-extension'),
					'bottom-left'   => esc_html__('Bottom left', 'core-extension'),
				),
				'property' => 'border',
				'suffix' => 'radius',
				"group" => esc_html__('Hover state', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon position', 'core-extension'),
				"param_name" => "icon_pos",
				"value" => array(esc_html__('Left', 'core-extension') => "icon-left",
				                 esc_html__('Right', 'core-extension') => "icon-right"),
				"description" => esc_html__('Choose position of the icon relative to button text.', 'core-extension'),
				'std' => 'icon-right',
				"group" => esc_html__('Icon', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
//				'admin_label' => true,
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcButtonView'
	) );

	// Icons
	vc_map( array(
		'name' => esc_html__( 'Icon', 'core-extension' ),
		'base' => 'vc_icon',
		'icon' => 'icon-wpb-vc_icon',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Icon from icon library', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'icon',
				"group" => esc_html__('Icon', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Without container', 'core-extension' ) => '',
					esc_html__( 'Simple container shape', 'core-extension' ) => 'simple',
					esc_html__( 'Style 1', 'core-extension' ) => 'predefined_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'predefined_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'predefined_3',
					esc_html__( 'Style 4', 'core-extension' ) => 'predefined_4',
					esc_html__( 'Style 5', 'core-extension' ) => 'predefined_5',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				'dependency' => array(
					'element' => 'style',
					'value' => array('predefined_1', 'predefined_2', 'predefined_3', 'predefined_4', 'predefined_5'),
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon draw animation', 'core-extension' ),
				'description' => esc_html__( 'Only works with "Linea" icon library', 'core-extension' ),
				'param_name' => 'icon_anim',
				'value' => array(
					esc_html__( 'Disable', 'core-extension' ) => '',
					esc_html__( 'When enters viewport', 'core-extension' ) => 'icon_anim_viewport',
					esc_html__( 'When enters viewport and on hover', 'core-extension' ) => 'icon_anim_viewport_hover',
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('', 'simple'),
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'core-extension' ),
				'param_name' => 'simple_style',
				'value' => array(
					esc_html__( 'Square', 'core-extension' ) => 'square',
					esc_html__( 'Slightly rounded square', 'core-extension' ) => 'square_sl_rounded',
					esc_html__( 'Rounded square', 'core-extension' ) => 'square_rounded',
					esc_html__( 'Circle', 'core-extension' ) => 'circle',
					esc_html__( 'Rhombus', 'core-extension' ) => 'rhombus',
					esc_html__( 'Slightly rounded rhombus', 'core-extension' ) => 'rhombus_sl_rounded',
					esc_html__( 'Rounded rhombus', 'core-extension' ) => 'rhombus_rounded',
				),
				'dependency' => array(
					'element' => 'style',
					'value' => 'simple',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				'description' => wp_kses_post( __( 'Please note that the gradient fill for text works only in webkit-based browsers. In other browsers the <code>From</code> value will be used as a text color.', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension'),
				'dependency' => array(
					'element' => 'style',
					'value' => array('', 'simple'),
				),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color",
				'dependency' => array(
					'element' => 'style',
					'value' => 'simple',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Border color', 'core-extension'),
				"param_name" => "border_color",
				'dependency' => array(
					'element' => 'style',
					'value' => 'simple',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Icon size', 'core-extension' ),
				'param_name' => 'size',
				'value' => '1em',
				'save_always' => true,
				'description' => wp_kses_post( __( 'Enter icon size in <code>px</code> or <code>em</code> units. E.g. <code>30px</code>, <code>2em</code>.', 'core-extension' )),
				"group" => esc_html__('Size &amp; Position', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Container size', 'core-extension' ),
				'param_name' => 'cont_size',
				'value' => '3em',
				'save_always' => true,
				'description' => wp_kses_post( __( 'Enter container size in <code>px</code> or <code>em</code> units. E.g. <code>30px</code>, <code>2em</code>.', 'core-extension' )),
				"group" => esc_html__('Size &amp; Position', 'core-extension'),
				'dependency' => array(
					'element' => 'display',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display', 'core-extension' ),
				'param_name' => 'display',
				'value' => array(
					esc_html__( 'Block', 'core-extension' ) => 'wtbx_display_block',
					esc_html__( 'Inline-block', 'core-extension' ) => 'wtbx_display_inline_block',
				),
				"group" => esc_html__('Size &amp; Position', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon alignment', 'core-extension' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => '',
					esc_html__( 'Align left', 'core-extension' ) => 'wtbx_align_left',
					esc_html__( 'Align right', 'core-extension' ) => 'wtbx_align_right',
					esc_html__( 'Align center', 'core-extension' ) => 'wtbx_align_center',
				),
				"group" => esc_html__('Size &amp; Position', 'core-extension'),
				'dependency' => array(
					'element' => 'display',
					'value' => 'wtbx_display_block',
				),
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				'dependency' => array(
					'element' => 'display',
					'value' => 'wtbx_display_inline_block',
				),
				"group" => esc_html__('Size &amp; Position', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation,
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'core-extension' ),
				'param_name' => 'link',
				"group" => esc_html__('Misc', 'core-extension'),
				'description' => esc_html__( 'Add link to icon.', 'core-extension' )
			),
		),
		'js_view' => 'VcIconElementView_Backend',
	) );

	// Heading
	vc_map( array(
		"name" => esc_html__('Styled Heading', 'core-extension'),
		"base" => "vc_heading",
		"icon" => "icon-wpb-vc_heading",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Styled customizable heading', 'core-extension'),
		"params" => array(
			array(
				"type" => "textarea",
				"heading" => esc_html__('Heading text', 'core-extension'),
				"param_name" => "heading_text",
				"value" => esc_html__('Heading text', 'core-extension'),
				"admin_label" => true,
				"group" => esc_html__('Heading', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Display page title', 'core-extension'),
				"param_name" => "page_title",
				"description" => esc_html__('Display the page current title instead of text. Useful, when the heading is a part of a content block used across multiple pages.', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Heading', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Heading wrapper', 'core-extension'),
				"param_name" => 'heading_wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'h1',
				'save_always' => true,
				"group" => esc_html__('Heading', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => 'alignment',
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right"
				),
				"group" => esc_html__('Heading', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__( 'Heading style', 'core-extension' ),
				"param_name" => "style",
				"value" => array(
					esc_html__('Default', 'core-extension')                   => 'default',
					esc_html__('With side border' , 'core-extension')         => 'with_border',
					esc_html__('With vertical line top', 'core-extension')    => 'with_line_top',
					esc_html__('With vertical line bottom', 'core-extension') => 'with_line_bottom',
					esc_html__('With side line', 'core-extension')            => 'with_line_side',
				),
				"description" => esc_html__( 'Choose heading element style.', 'core-extension' ),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Heading color', 'core-extension'),
				"param_name" => "heading_color",
				"value" => '',
				"description" => '',
				"group" => esc_html__('Heading', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Heading font style', 'core-extension'),
				"param_name" => "heading_typography",
				"value" => '',
				"group" => esc_html__('Heading', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Line size', 'core-extension'),
				'description' => wp_kses_post( __( 'Line length divider in <code>px</code>.', 'core-extension' )),
				"param_name" => "divider_length",
				"std" => '100',
				'range_from' => '1',
				'range_to' => '300',
				'step' => '1',
				'save_always' => true,
				"dependency" => array(
					'element' => 'style',
					'value' => array('with_line_top', 'with_line_bottom', 'with_line_side')
				),
				"group" => esc_html__('Line', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Line thickness', 'core-extension'),
				'description' => wp_kses_post( __( 'Line thickness divider in <code>px</code>.', 'core-extension' )),
				"param_name" => "divider_thickness",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '20',
				'step' => '1',
				'save_always' => true,
				"dependency" => array(
					'element' => 'style',
					'value' => array('with_line_top', 'with_line_bottom', 'with_line_side')
				),
				"group" => esc_html__('Line', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Space between text and divider', 'core-extension'),
				'description' => wp_kses_post( __( 'Additional empty space between text and divider in <code>px</code>.', 'core-extension' )),
				"param_name" => "space",
				"std" => '15',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"dependency" => array(
					'element' => 'style',
					'value' => array('with_line_top', 'with_line_bottom', 'with_line_side')
				),
				"group" => esc_html__('Line', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Divider color', 'core-extension'),
				"param_name" => "divider_color",
				"value" => '',
				"description" => '',
				"dependency" => array(
					'element' => 'style',
					'value' => array('with_line_top', 'with_line_bottom', 'with_line_side')
				),
				"group" => esc_html__('Line', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Rounded line', 'core-extension'),
				"param_name" => 'divider_rounded',
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "rounded",
				),
				'save_always' => true,
				"description" => esc_html__( 'Can be used with thick divider.', 'core-extension' ),
				"dependency" => array(
					'element' => 'style',
					'value' => array('with_line_top', 'with_line_bottom', 'with_line_side')
				),
				"group" => esc_html__('Line', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Number', 'core-extension'),
				"param_name" => "number_text",
				"value" => '',
				'dependency' => array(
					'element' => 'style',
					'value' => 'with_number'
				),
				"group" => esc_html__('Number', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Number color', 'core-extension'),
				"param_name" => "number_color",
				"value" => '',
				'dependency' => array(
					'element' => 'style',
					'value' => 'with_number'
				),
				"group" => esc_html__('Number', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Number font style', 'core-extension'),
				"param_name" => "number_typography",
				"value" => '',
				'dependency' => array(
					'element' => 'style',
					'value' => 'with_number'
				),
				"group" => esc_html__('Number', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force centered text on small screens", 'core-extension'),
				"param_name" => "center",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"description" => esc_html__('Make font size smaller of small devices', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (979px) and below', 'core-extension'),
				"param_name" => "tablet_portrait",
				"std" => '90',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Mobile landscape (767px) and below', 'core-extension'),
				"param_name" => "mobile_landscape",
				"std" => '80',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (below 480)', 'core-extension'),
				"param_name" => "mobile_portrait",
				"std" => '70',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );

	// Split text
	vc_map( array(
		"name" => esc_html__('Split text', 'core-extension'),
		"base" => "vc_split_text",
		"icon" => "icon-wpb-vc_split_text",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Text with appearance animation', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text (single line)', 'core-extension'),
				"param_name" => "text_single",
				"value" => "",
				"admin_label" => true,
				"description" => esc_html__('Does support commas. For multi-line text use the textarea below.', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "exploded_textarea",
				"heading" => esc_html__('Text (multiple lines)', 'core-extension'),
				"param_name" => "text",
				"value" => "",
				"admin_label" => true,
				"description" => esc_html__('Each text line in the field will represent a real text line. Separate the lines with linebreaks (Enter). Does not support commas (use single line above for that).', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Heading wrapper', 'core-extension'),
				"param_name" => 'wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "color",
				"value" => '',
				"group" => esc_html__('Color', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Fill container color', 'core-extension'),
				"param_name" => "fill_color",
				"value" => '',
				"group" => esc_html__('Color', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => 'alignment',
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right",
					esc_html__('Center', 'core-extension') => "align_center"
				),
				'save_always' => true,
				"group" => esc_html__('Typography', 'core-extension')

			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Text font style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force centered text on small screens", 'core-extension'),
				"param_name" => "center",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"description" => esc_html__('Make font size smaller of small devices', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (979px) and below', 'core-extension'),
				"param_name" => "tablet_portrait",
				"std" => '90',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Mobile landscape (767px) and below', 'core-extension'),
				"param_name" => "mobile_landscape",
				"std" => '80',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (below 480)', 'core-extension'),
				"param_name" => "mobile_portrait",
				"std" => '70',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			$extra_class,
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'CSS Animation', 'core-extension' ),
				'param_name' => 'css_animation',
				'value' => array(
					esc_html__( 'Clip from bottom', 'core-extension' ) => 'wtbx-anim-clip-bottom',
					esc_html__( 'Clip from top', 'core-extension' ) => 'wtbx-anim-clip-top',
					esc_html__( 'Clip from left', 'core-extension' ) => 'wtbx-anim-clip-left',
					esc_html__( 'Clip from right', 'core-extension' ) => 'wtbx-anim-clip-right',
					esc_html__( 'Fill from bottom', 'core-extension' ) => 'wtbx-anim-fill-bottom',
					esc_html__( 'Fill from top', 'core-extension' ) => 'wtbx-anim-fill-top',
					esc_html__( 'Fill from left', 'core-extension' ) => 'wtbx-anim-fill-left',
					esc_html__( 'Fill from right', 'core-extension' ) => 'wtbx-anim-fill-right',
				),
				'save_always' => true,
				'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'core-extension' ),
				"group" => esc_html__('Animation', 'core-extension')
			),
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );

	// Animated text
	vc_map( array(
		"name" => esc_html__('Typed text', 'core-extension'),
		"base" => "vc_animated_text",
		"icon" => "icon-wpb-vc_animated_text",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Text with type animation', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Prefix text', 'core-extension'),
				"param_name" => "prefix_text",
				"value" => esc_html__('Explore the', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "exploded_textarea",
				"heading" => esc_html__('Animated text', 'core-extension'),
				"param_name" => "animated_text",
				"value" => esc_html__('awesome,fantastic,great,advanced', 'core-extension'),
				"description" => esc_html__('Each text line in the field will represent an animated piece of text. Separate the lines with linebreaks (Enter).', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Postfix text', 'core-extension'),
				"param_name" => "postfix_text",
				"value" => esc_html__('product features', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Text wrapper', 'core-extension'),
				"param_name" => 'wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_slider',
				'heading' => esc_html__( 'Start delay', 'core-extension' ),
				'param_name' => 'start_delay',
				"std" => '0',
				'range_from' => '0',
				'range_to' => '2000',
				'step' => '100',
				'save_always' => true,
				'group' => esc_html__('Settings', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_slider',
				'heading' => esc_html__( 'Type time', 'core-extension' ),
				'param_name' => 'type_speed',
				"std" => '50',
				'range_from' => '0',
				'range_to' => '200',
				'step' => '10',
				'save_always' => true,
				'group' => esc_html__('Settings', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_slider',
				'heading' => esc_html__( 'Erase delay', 'core-extension' ),
				'param_name' => 'back_delay',
				"std" => '500',
				'range_from' => '0',
				'range_to' => '5000',
				'step' => '100',
				'save_always' => true,
				'group' => esc_html__('Settings', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_slider',
				'heading' => esc_html__( 'Erase time', 'core-extension' ),
				'param_name' => 'back_speed',
				"std" => '10',
				'range_from' => '0',
				'range_to' => '200',
				'step' => '10',
				'save_always' => true,
				'group' => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Prefix and postfix text color', 'core-extension'),
				"param_name" => "text_color",
//				"value" => '',
//				'save_always' => true,
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Animated text color', 'core-extension'),
				"param_name" => "anim_text_color",
//				"value" => '',
//				'save_always' => true,
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => 'alignment',
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right",
					esc_html__('Center', 'core-extension') => "align_center"
				),
				'save_always' => true,
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Prefix and postfix text font style', 'core-extension'),
				"param_name" => "text_typography",
//				"value" => '',
//				'save_always' => true,
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Animated text font style', 'core-extension'),
				"param_name" => "anim_text_typography",
//				"value" => '',
//				'save_always' => true,
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force centered text on small screens", 'core-extension'),
				"param_name" => "center",
				"value" => array(
					esc_html__('Do not force', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"description" => esc_html__('Make font size smaller of small devices', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (979px) and below', 'core-extension'),
				"param_name" => "tablet_portrait",
				"std" => '90',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Mobile landscape (767px) and below', 'core-extension'),
				"param_name" => "mobile_landscape",
				"std" => '80',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (below 480)', 'core-extension'),
				"param_name" => "mobile_portrait",
				"std" => '70',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );

	// Testimonial
	vc_map( array(
		'name' => esc_html__( 'Testimonial', 'core-extension' ),
		'base' => 'vc_testimonial',
		'icon' => 'icon-wpb-vc_testimonial',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Reference/Testimonial element', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Testimonial style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3',
					esc_html__( 'Style 4', 'core-extension' ) => 'style_4',
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of the testimonial.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the testimonial color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color scheme', 'core-extension'),
				"param_name" => "scheme",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Colorful', 'core-extension')  => "colorful",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the testimonial color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				'dependency' => array(
					'element' => 'scheme',
					'value' => 'colorful',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('Testimonial text', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				'value' => wp_kses_post( __('Holisticly recaptiualize user-centric manufactured products before empowered scenarios. Enthusiastically impact sustainable human capital through premier strategic theme areas.', 'core-extension')),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Referee', 'core-extension'),
				"param_name" => "referee",
				"value" => array(
					esc_html__('Person', 'core-extension')   => "person",
					esc_html__('Company', 'core-extension')  => "company",
				),
				'save_always' => true,
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author name', 'core-extension'),
				"holder" => "i",
				"param_name" => "author_name",
				'value' => 'John Smith',
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author position/occupation', 'core-extension'),
				"param_name" => "author_occupation",
				'value' => 'Marketing Director',
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author company', 'core-extension'),
				"param_name" => "author_company",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Author photo', 'core-extension'),
				"param_name" => "photo",
				"value" => "",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Company logo', 'core-extension'),
				"param_name" => "logo",
				"value" => "",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'company',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		//		'js_view' => 'VcTestimonialView'
	) );

	// Testimonial slider
	vc_map( array(
		"name" => esc_html__('Testimonial slider', 'core-extension'),
		"base" => "vc_testimonial_slider",
		"icon" => "icon-wpb-vc_testimonial_slider",
		"as_parent" => array('only' => 'vc_testimonial_slide'),
		"is_container" => true,
		"show_settings_on_create" => false,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Slider with testimonials/quotes', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(esc_html__('Style 1', 'core-extension') => "style_1",
				                 esc_html__('Style 2', 'core-extension') => "style_2",
				                 esc_html__('Style 3', 'core-extension') => "style_3"
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_1', 'style_2'),
				),
				'description' => esc_html__( 'Choose the testimonial color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color scheme', 'core-extension'),
				"param_name" => "scheme",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Colorful', 'core-extension')  => "colorful",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_1', 'style_2'),
				),
				'description' => esc_html__( 'Choose the testimonial color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				'dependency' => array(
					'element' => 'scheme',
					'value' => 'colorful',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Navigation buttons skin', 'core-extension'),
				"param_name" => "navigation_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the navigation buttons color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Pagination', 'core-extension'),
				"param_name" => "pagination",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Style 1', 'core-extension' )   => 'style_1',
					esc_html__( 'Style 2', 'core-extension' )   => 'style_2',
					esc_html__( 'Style 3', 'core-extension' )   => 'style_3'
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Pagination buttons skin', 'core-extension'),
				"param_name" => "pagination_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the pagination buttons color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Hide navigation elements', 'core-extension'),
				"param_name" => "hide_nav",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension')  => "true",
				),
				'description' => esc_html__( 'Show navigation elements only when the slider is hovered.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => 'wtbx_vc_slider',
				"heading" => esc_html__('Slider autoplay speed', 'core-extension'),
				"param_name" => "autoplay",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '20',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __( 'Set time of slider autoplay in seconds. Higher number means longer interval. Set to <code>0</code> to disable autoplay.', 'core-extension' )),
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Pause slider on hover', 'core-extension'),
				"param_name" => "stop_hover",
				"value" => array(
					esc_html__( 'No', 'core-extension' )    => 'false',
					esc_html__( 'Yes', 'core-extension' )   => 'true'
				),
				'std' => 'true',
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension')
			),
			$extra_class
		),
		"custom_markup" => '
			<div class="wpb_testimonial_holder wpb_holder clearfix vc_container_for_children">
			%content%
			</div>
			<div class="tab_controls">
			    <a class="add_tab" title="' . esc_html__( 'Add testimonial slide', 'core-extension' ) . '"><span class="vc-composer-icon vc-c-icon-add"></span> <span class="tab-label">' . esc_html__( 'Add testimonial slide', 'core-extension' ) . '</span></a>
			</div>
		',
		'default_content' => '
	  [vc_testimonial_slide name="John Martin" position="Developer"]I am dummy testimonial text.[/vc_testimonial_slide]
	  [vc_testimonial_slide name="Richard Smith" position="Designer"]I am dummy testimonial text.[/vc_testimonial_slide]
	  ',
		"js_view" => 'VcTestimonialSliderView'
	) );


	// Testimonial slide
	vc_map( array(
		"name" => esc_html__('Testimonial', 'core-extension'),
		"base" => "vc_testimonial_slide",
		"icon" => "icon-wpb-vc_testimonial",
//		"is_container" => true,
//		"content_element" => false,
		"as_child" => array('only' => 'vc_testimonial_slider'),
//		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Referee', 'core-extension'),
				"param_name" => "referee",
				"value" => array(
					esc_html__('Person', 'core-extension')   => "person",
					esc_html__('Company', 'core-extension')  => "company",
				),
				'save_always' => true,
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author name', 'core-extension'),
				"holder" => "h3",
				"param_name" => "author_name",
				'value' => 'John Smith',
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author position/occupation', 'core-extension'),
				"param_name" => "author_occupation",
				'value' => 'Marketing Director',
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author company', 'core-extension'),
				"param_name" => "author_company",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Author photo', 'core-extension'),
				"param_name" => "photo",
				"value" => "",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Company logo', 'core-extension'),
				"param_name" => "logo",
				"value" => "",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'company',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('Testimonial text', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				'value' => wp_kses_post( __('I am dummy testimonial text.', 'core-extension')),
				"group" => esc_html__('Content', 'core-extension')
			),
			$extra_class
		),
		"js_view" => 'VcTestimonialSlideView'
	) );

	// Review / Rating
	vc_map( array(
		'name' => esc_html__( 'Rating', 'core-extension' ),
		'base' => 'vc_rating',
		'icon' => 'icon-wpb-vc_rating',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Review / Star Rating element', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3',
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of the rating.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the rating color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Reason / Verdict', 'core-extension'),
				"param_name" => "reason",
				'value' => 'Fantastic experience',
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('Review text', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				'value' => wp_kses_post( __('Holisticly recaptiualize user-centric manufactured products before empowered scenarios. Enthusiastically impact sustainable human capital through premier strategic theme areas.', 'core-extension')),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Rating', 'core-extension'),
				"param_name" => "rating",
				"std" => '5',
				'range_from' => '0',
				'range_to' => '5',
				'step' => 0.5,
				'save_always' => true,
				"description" => wp_kses_post( __('Set to <code>0</code> if you Do not want to add rating.', 'core-extension' )),
				"group" => esc_html__('Rating', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Rating star style', 'core-extension'),
				"param_name" => "rating_style",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Compact', 'core-extension')  => "compact",
				),
				'save_always' => true,
				"group" => esc_html__('Rating', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Rating star color', 'core-extension'),
				"param_name" => "accent_color",
				"group" => esc_html__('Rating', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Referee', 'core-extension'),
				"param_name" => "referee",
				"value" => array(
					esc_html__('Person', 'core-extension')   => "person",
					esc_html__('Company', 'core-extension')  => "company",
				),
				'save_always' => true,
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author name', 'core-extension'),
				"param_name" => "author_name",
				'value' => 'John Smith',
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author position/occupation', 'core-extension'),
				"param_name" => "author_occupation",
				'value' => 'Marketing Director',
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Author company', 'core-extension'),
				"param_name" => "author_company",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'person',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Company logo', 'core-extension'),
				"param_name" => "logo",
				"value" => "",
				'dependency' => array(
					'element' => 'referee',
					'value' => 'company',
				),
				"group" => esc_html__('Author', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );

	// Team
	vc_map( array(
		"name" => esc_html__('Team Member', 'core-extension'),
		"base" => "vc_team_member",
		"icon" => "icon-wpb-vc_team_member",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Staff member', 'core-extension'),
		"params" => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Element style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3',
					esc_html__( 'Style 4', 'core-extension' ) => 'style_4',
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of the team member element.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_3', 'style_4'),
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the team member element color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Content alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_3'),
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_1', 'style_2', 'style_4'),
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Employee photo', 'core-extension'),
				"param_name" => "photo",
				"value" => "",
				"group" => esc_html__('Employee', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Name', 'core-extension'),
				"param_name" => "name",
				"value" => "Michael Smith",
				"holder" => "i",
				"description" => '',
				"group" => esc_html__('Employee', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Position', 'core-extension'),
				"param_name" => "position",
				"value" => "Sales Manager",
				"group" => esc_html__('Employee', 'core-extension')
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('Additional information about employee', 'core-extension'),
				"param_name" => "content",
				"description" => esc_html__('Short description of this person.', 'core-extension'),
				"value" => wp_kses_post( __('Dedicated expert with rich professional background.', 'core-extension')),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_1', 'style_2', 'style_3'),
				),
				"group" => esc_html__('Employee', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Email', 'core-extension'),
				"param_name" => "email",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('LinkedIn', 'core-extension'),
				"param_name" => "linkedin",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Facebook', 'core-extension'),
				"param_name" => "facebook",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Twitter', 'core-extension'),
				"param_name" => "twitter",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Google+', 'core-extension'),
				"param_name" => "google",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Dribbble', 'core-extension'),
				"param_name" => "dribbble",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Instagram', 'core-extension'),
				"param_name" => "instagram",
				"group" => esc_html__('Social', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Same height boxes across adjacent columns', 'core-extension'),
				"param_name" => "equal_height",
				"value" => array(
					esc_html__('Disable', 'core-extension') => '',
					esc_html__('Desktop only', 'core-extension') => '1024',
					esc_html__('Tablet Landscape and above', 'core-extension') => '979',
					esc_html__('Tablet Portrait and above', 'core-extension') => '767',
					esc_html__('Mobile Landscape and above', 'core-extension') => '479',
					esc_html__('All screen sizes', 'core-extension') => '0'
				),
				'save_always' => true,
				"description" => esc_html__('All team member elements in adjacent columns with "Same height" setting enabled will be the same height.', 'core-extension'),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_1', 'style_2', 'style_3'),
				),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
//		"js_view" => 'VcTeamMemberView'
	) );

	// Team table
//	$tab_id_1 = time() . '-1-' . rand( 0, 100 );
//	$tab_id_2 = time() . '-2-' . rand( 0, 100 );
//	vc_map( array(
//		"name" => esc_html__( 'Team table', 'core-extension' ),
//		'base' => 'vc_team_table',
//		'show_settings_on_create' => true,
//		'is_container' => true,
//		"as_parent" => array('only' => 'vc_team_table_member'),
//		'icon' => 'icon-wpb-vc_team_table',
//		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
//		"weight" => 1,
//		'description' => esc_html__( 'Table with team members info', 'core-extension' ),
//		'params' => array(
//			array(
//				'type' => 'textfield',
//				'heading' => esc_html__( 'Title (optional)', 'core-extension' ),
//				'param_name' => 'title',
//				'value' => esc_html__( 'Our Team', 'core-extension' ),
//			),
//			array(
//				"type" => "wtbx_vc_typography",
//				"heading" => esc_html__('Title text style', 'core-extension'),
//				"param_name" => "title_typography",
//				"value" => '',
//				'description' => esc_html__( 'Will override default styling', 'core-extension' ),
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Position of photos section', 'core-extension'),
//				"param_name" => "photos_position",
//				"value" => array(
//					esc_html__('Left', 'core-extension')   => "photos_left",
//					esc_html__('Right', 'core-extension')  => "photos_right"
//				),
//				'save_always' => true,
//				"group" => esc_html__('Design', 'core-extension')
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Photo section width', 'core-extension'),
//				"param_name" => "layout",
//				"value" => array(
//					esc_html__('Narrow', 'core-extension')  => "narrow",
//					esc_html__('Half', 'core-extension')    => "half",
//					esc_html__('Wide', 'core-extension')    => "wide",
//				),
//				'save_always' => true,
//				'std' => 'half',
//				"group" => esc_html__('Design', 'core-extension')
//			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Number of photos in one row', 'core-extension'),
//				"param_name" => "photos_in_row",
//				"value" => array(
//					esc_html__('1', 'core-extension')   => "1",
//					esc_html__('2', 'core-extension')   => "2",
//					esc_html__('3', 'core-extension')   => "3",
//					esc_html__('4', 'core-extension')   => "4",
//					esc_html__('5', 'core-extension')   => "5",
//					esc_html__('6', 'core-extension')   => "6",
//				),
//				'save_always' => true,
//				'std' => '3',
//				"group" => esc_html__('Design', 'core-extension')
//			),
//			$lazy_images,
//			$preloader,
//			$extra_class,
//			$add_css_animation,
//			$add_css_animation_easing,
//			$add_css_animation_duration,
//			$add_css_animation_delay,
//		),
//		'custom_markup' => '
//							<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
//							<ul class="tabs_controls">
//							</ul>
//							%content%
//							</div>'
//		,
//		'default_content' => '
//								[vc_team_table_member title="' . esc_html__( 'James Baker', 'core-extension' ) . '" slide_id="' . $tab_id_1 . '"][/vc_team_table_member]
//								[vc_team_table_member title="' . esc_html__( 'James Baker', 'core-extension' ) . '" slide_id="' . $tab_id_2 . '"][/vc_team_table_member]
//								',
//		'js_view' => 'VcTeamTableView'
//	) );
//
//	// Team table member
//	vc_map( array(
//		'name' => esc_html__( 'Team member', 'core-extension' ),
//		'base' => 'vc_team_table_member',
//		'icon' => 'icon-wpb-vc_team_table',
//		'allowed_container_element' => 'vc_row',
//		'is_container' => true,
//		"as_child" => array('only' => 'vc_team_table'),
//		'content_element' => false,
//		'show_settings_on_create' => false,
//		'params' => array(
//			array(
//				"type" => "attach_image",
//				"heading" => esc_html__('Photo', 'core-extension'),
//				"param_name" => "photo",
//				"value" => "",
////				"group" => esc_html__('Team member', 'core-extension')
//			),
//			array(
//				'type' => 'textfield',
//				'heading' => esc_html__( 'Name', 'core-extension' ),
//				'param_name' => 'title',
//				'value' => esc_html__( 'James Baker', 'core-extension' ),
//				'description' => esc_html__( 'Team member name', 'core-extension' ),
////				"group" => esc_html__('Team member', 'core-extension')
//			),
//			array(
//				"type" => "textfield",
//				"heading" => esc_html__('Position', 'core-extension'),
//				"param_name" => "position",
//				"value" => "Sales Manager",
////				"holder" => "i",
////				"group" => esc_html__('Team member', 'core-extension')
//			),
//			array(
//				'type' => 'hidden',
//				'heading' => esc_html__( 'Team member ID', 'core-extension' ),
//				'param_name' => "slide_id"
//			),
//			array(
//				"type" => "hidden",
//				"param_name" => "lazy",
//			),
//			array(
//				"type" => "hidden",
//				"param_name" => "preloader",
//			),
//		),
//		'js_view' => 'VcTeamTableMemberView',
//	) );

	// Pricing box
	vc_map( array(
		"name"	=> esc_html__('Pricing box', 'core-extension'),
		"base"	=> "vc_pricing_box",
		"icon"	=> "icon-wpb-vc_pricing_box",
		'show_settings_on_create' => true,
		'as_parent' => array( 'only' => 'vc_pricing_box_feature' ),
		"is_container" => true,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Customizable pricing boxes', 'core-extension'),
		"params" => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Element style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Style 1', 'core-extension' ) => 'style_1',
					esc_html__( 'Style 2', 'core-extension' ) => 'style_2',
					esc_html__( 'Style 3', 'core-extension' ) => 'style_3',
				),
				'save_always' => true,
				'description' => esc_html__( 'Set the style of the pricing box.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the pricing box content color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Emphasize', 'core-extension'),
				"param_name" => "emphasize",
				"value" => array(
					esc_html__('No', 'core-extension')   => "",
					esc_html__('Yes', 'core-extension')  => "yes",
				),
				'description' => esc_html__( 'Make this pricing box stand out from others and apply special styling to it.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border radius', 'core-extension'),
				"param_name" => "radius",
				"std" => '8',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Border radius in <code>px</code>.', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Border color', 'core-extension'),
				"param_name" => "border_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Title', 'core-extension' ),
				"param_name" => "title",
				"holder" => "h4",
				"description" => esc_html__( 'State the name of this pricing plan.', 'core-extension' ),
				"value" => esc_html__( 'Standard Pack', 'core-extension' ),
				"group" => esc_html__('Content', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Subtitle', 'core-extension' ),
				"param_name" => "meta",
				"holder" => "span",
				"description" => esc_html__( 'A short precising subtitle or slogan for the plan.', 'core-extension' ),
				"value" => esc_html__( 'Most popular choice', 'core-extension' ),
				"group" => esc_html__('Content', 'core-extension'),
			),
			array(
				"type" => "textarea_raw_html",
				"heading" => esc_html__('Pricing plan description (optional)', 'core-extension'),
				"param_name" => "description",
				"description" => esc_html__('Short abstract about the pricing plan.', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Price', 'core-extension' ),
				"param_name" => "price",
				"holder" => "span",
				"description" => esc_html__( 'Set the price of this plan. Use dot or comma as a delimiter.', 'core-extension' ),
				"value" => esc_html__( '25.99', 'core-extension' ),
				"group" => esc_html__('Price', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Currency', 'core-extension' ),
				"param_name" => "currency",
				"holder" => "span",
				"description" => esc_html__( 'Enter currency symbol or text, e.g., $ or USD.', 'core-extension' ),
				"value" => esc_html__( '$', 'core-extension' ),
				"group" => esc_html__('Price', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Time period', 'core-extension' ),
				"param_name" => "time",
				"holder" => "span",
				"description" => esc_html__( 'Choose time span for you plan, e.g., \'monthly\', \'per week\' or \'/yr\'.', 'core-extension' ),
				"value" => esc_html__( 'monthly', 'core-extension' ),
				"group" => esc_html__('Price', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button style', 'core-extension' ),
				'param_name' => 'btn_style',
				'value' => array(
					esc_html__( 'Button', 'core-extension' ) => 'btn',
					esc_html__( 'Ghost button', 'core-extension' ) => 'ghost',
					esc_html__( 'Link', 'core-extension' ) => 'link',
				),
				'save_always' => true,
				"group" => esc_html__('Button', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('Button URL', 'core-extension'),
				"param_name" => "btn_link",
				"group" => esc_html__('Button', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Button text', 'core-extension' ),
				"param_name" => "btn_text",
				"value" => esc_html__( 'Buy now', 'core-extension' ),
				"group" => esc_html__('Button', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Button border radius', 'core-extension'),
				"param_name" => "btn_radius",
				"std" => '4',
				'range_from' => '0',
				'range_to' => '30',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Button border radius in <code>px</code>.', 'core-extension' )),
				"group" => esc_html__('Button', 'core-extension'),
				"dependency" => array(
					'element' => 'btn_style',
					'value' => array('btn', 'ghost')
				),
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Button text color (idle)', 'core-extension' ),
				'param_name' => 'btn_text_color',
				'group' => esc_html__( 'Button', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Button background color (idle)', 'core-extension' ),
				'param_name' => 'btn_bg_color',
				'dependency' => array(
					'element' => 'btn_style',
					'value' => array('btn', 'ghost')
				),
				'group' => esc_html__( 'Button', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Button text color (hover)', 'core-extension' ),
				'param_name' => 'btn_text_color_hover',
				'group' => esc_html__( 'Button', 'core-extension' )
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Button background color (hover)', 'core-extension' ),
				'param_name' => 'btn_bg_color_hover',
				'dependency' => array(
					'element' => 'btn_style',
					'value' => array('btn', 'ghost')
				),
				'group' => esc_html__( 'Button', 'core-extension' )
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcPricingView'
	) );

	// Pricing box feature
	vc_map( array(
		"name"	=> esc_html__('Pricing plan feature', 'core-extension'),
		"base"	=> "vc_pricing_box_feature",
		"icon"	=> "icon-wpb-vc_pricing",
		'as_child' => array( 'only' => 'vc_pricing_box' ),
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Customizable pricing boxes', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				'admin_label' => true,
				"heading" => esc_html__('Title', 'core-extension'),
				"param_name" => "feature",
				"value" => esc_html__( 'Unlimited usage.', 'core-extension' ),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Bullet', 'core-extension'),
				"param_name" => "bullet_style",
				"value" => array(
					esc_html__('Disable', 'core-extension')     => "",
					esc_html__('Bold text', 'core-extension')   => "bold",
					esc_html__('Text badge', 'core-extension')  => "badge",
					esc_html__('Icon', 'core-extension')        => "icon"
				),
				'description' => esc_html__( 'Add icon or badge, or leave plain text.', 'core-extension' ),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Bullet alignment', 'core-extension'),
				"param_name" => "bullet_align",
				"value" => array(
					esc_html__('Left', 'core-extension')    => "left",
					esc_html__('Right', 'core-extension')   => "right"
				),
				'dependency' => array(
					'element' => 'bullet_style',
					'not_empty' => true,
				),
				'save_always' => true,
				'description' => esc_html__( 'Add icon or badge, or leave plain text.', 'core-extension' ),
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'bullet_icon',
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'icon',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Badge with text', 'core-extension'),
				"param_name" => "bullet_badge",
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'badge',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Bold text', 'core-extension'),
				"param_name" => "bullet_text",
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'bold',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			$tooltip,
			$extra_class,
		),
//		"js_view" => 'VcPricingFeatureView'
	) );

	// Text block
	vc_map( array(
		'name' => esc_html__( 'Text element', 'core-extension' ),
		'base' => 'vc_text_element',
		'icon' => 'icon-wpb-vc_text_element',
		'wrapper_class' => 'clearfix',
		'weight' => 2,
		'category'  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		'description' => esc_html__( 'A block of text with WYSIWYG editor', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Text', 'core-extension' ),
				'param_name' => 'content',
				'save_always' => true,
				'value' => wp_kses_post( __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'core-extension' )),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Text font style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Disable paragraph margins', 'core-extension'),
				"param_name" => "disable_margin",
				"description" => esc_html__('Disable top margin of the first paragraph and bottom margin of the last paragraph.', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Force font style', 'core-extension'),
				"param_name" => "force_typography",
				"description" => esc_html__('Will override default tag (e.g. headings) styling', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Display', 'core-extension' ),
				'param_name' => 'display',
				'value' => array(
					esc_html__( 'Block', 'core-extension' ) => 'wtbx_display_block',
					esc_html__( 'Inline-block', 'core-extension' ) => 'wtbx_display_inline_block',
				),
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				'dependency' => array(
					'element' => 'display',
					'value' => 'wtbx_display_inline_block',
				),
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_colorpicker_solid',
				'heading' => esc_html__( 'Text color', 'core-extension' ),
				'param_name' => 'color',
				'group' => esc_html__( 'Color', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Force text color', 'core-extension'),
				"param_name" => "force_color",
				"description" => esc_html__('Will override default tag (e.g. headings) color', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Color', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Force centered text on small screens", 'core-extension'),
				"param_name" => "center",
				"value" => array(
					esc_html__("Do not force", 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"description" => esc_html__('Make font size smaller of small devices', 'core-extension'),
				"value" => array(
					esc_html__('Yes, please', 'core-extension') => 'yes'
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (979px) and below', 'core-extension'),
				"param_name" => "tablet_portrait",
				"std" => '90',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Mobile landscape (767px) and below', 'core-extension'),
				"param_name" => "mobile_landscape",
				"std" => '80',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Tablet portrait (below 480)', 'core-extension'),
				"param_name" => "mobile_portrait",
				"std" => '70',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__('As percentage of initial font size.', 'core-extension'),
				"dependency" => array(
					'element' => "responsiveness",
					'not_empty' => true
				),
				"group" => esc_html__('Responsiveness', 'core-extension')
			),
			//			array(
			//				'type' => 'el_id',
			//				'heading' => esc_html__( 'Element ID', 'core-extension' ),
			//				'param_name' => 'el_id',
			//				'description' => sprintf( wp_kses_post( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'core-extension' )), 'http://www.w3schools.com/tags/att_global_id.asp' ),
			//				"group" => esc_html__('Misc', 'core-extension')
			//			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );


	// Before / After image slider
	vc_map( array(
		"name" => esc_html__('Before/After slider', 'core-extension'),
		"base" => "vc_image_before_after",
		"icon" => "icon-wpb-vc_before_after",
		"weight" => 1,
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"description" => esc_html__('Image comparison slider', 'core-extension'),
		"params" => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( '"Before image"', 'core-extension' ),
				'param_name' => 'before_image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( '"After image"', 'core-extension' ),
				'param_name' => 'after_image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Divider skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Maximum image width', 'core-extension' ),
				'param_name' => 'max_width',
				'description' => wp_kses_post( __( 'Enter maximum width in <code>px</code> that the image can take on the screen. Leave empty for the image to fill the whole width of its container element.', 'core-extension' )),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Element alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'max_width',
					'not_empty' => true
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Border radius', 'core-extension' ),
				'param_name' => 'radius',
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Border radius in <code>px</code>.', 'core-extension' )),
				'group' => esc_html__('Design', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );


	// List item
	vc_map( array(
		"name" => esc_html__('List Item', 'core-extension'),
		"base" => "vc_list_item",
		"icon" => "icon-wpb-vc_list_item",
		"is_container" => false,
		"description" => esc_html__('List with icon, number or text', 'core-extension'),
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		"weight" => 2,
		"params" => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => 'style_1',
					esc_html__( 'Rectangle', 'core-extension' ) => 'style_2',
					esc_html__( 'Container', 'core-extension' ) => 'style_3',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('style_2', 'style_3'),
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Bullet type', 'core-extension' ),
				'param_name' => 'bullet_style',
				'value' => array(
					esc_html__( 'Point', 'core-extension' ) => 'point',
					esc_html__( 'Icon', 'core-extension' ) => 'icon',
					esc_html__( 'Number / Text', 'core-extension' ) => 'text',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text offset', 'core-extension' ),
				'param_name' => 'offset',
				'value' => array(
					esc_html__( 'Very small', 'core-extension' ) => 'xs',
					esc_html__( 'Small', 'core-extension' ) => 'sm',
					esc_html__( 'Medium', 'core-extension' ) => 'md',
					esc_html__( 'Large', 'core-extension' ) => 'lg',
				),
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'text',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Enter the bullet number or text', 'core-extension' ),
				'description' => esc_html__( 'Try not to exceed two characters for better result.', 'core-extension' ),
				'param_name' => 'bullet_text',
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'text',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Bullet size', 'core-extension' ),
				'param_name' => 'bullet_size',
				'value' => array(
					esc_html__( 'Small', 'core-extension' ) => 'bullet_small',
					esc_html__( 'Big', 'core-extension' ) => 'bullet_big',
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Bullet color', 'core-extension'),
				"param_name" => "bullet_color",
				'description' => wp_kses_post( __( 'Please note that the gradient fill for text works only in webkit-based browsers. In other browsers the <code>From</code> value will be used as a text color.', 'core-extension' )),
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Bullet container color', 'core-extension'),
				"param_name" => "bullet_cont_color",
				'description' => wp_kses_post( __( 'Please note that the gradient fill for text works only in webkit-based browsers. In other browsers the <code>From</code> value will be used as a text color.', 'core-extension' )),
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'text',
				),
				"group" => esc_html__('Colors', 'core-extension'),

			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'bullet_icon',
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'icon',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('List item text', 'core-extension'),
				"param_name" => "content",
				'holder' => 'i',
				"value" => wp_kses_post( __('I am a list item', 'core-extension')),
				"group" => esc_html__('Content', 'core-extension'),
			),
			$tooltip,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation,
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				"group" => esc_html__('Link', 'core-extension'),
			),
		),
//		"js_view" => 'VcListItemView'
	) );

	// Expandable list
	vc_map( array(
		'name' => esc_html__( 'Expandable list', 'core-extension' ),
		'base' => 'vc_expandable_list',
		'show_settings_on_create' => false,
		'is_container' => true,
		'as_parent' => array(
			'only' => 'vc_expandable_list_item',
		),
		'icon' => 'icon-wpb-vc_expandable_list',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		'description' => esc_html__( 'Toggle list for QA or F.A.Q.', 'core-extension' ),
		"weight" => 2,
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => 'default',
					esc_html__( 'Minimalistic', 'core-extension' ) => 'minimal',
					esc_html__( 'Boxed', 'core-extension' ) => 'boxed',
					esc_html__( 'Border', 'core-extension' ) => 'border',
				),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Title font style', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		'custom_markup' => '
<div class="vc_tta-container" data-vc-action="collapseAll">
	<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
	   <div class="vc_tta-panels vc_clearfix {{container-class}}">
	      {{ content }}
	      <div class="vc_tta-panel vc_tta-section-append">
	         <div class="vc_tta-panel-heading">
	            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
	               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
	                   <span class="vc_tta-title-text">' . esc_html__( 'Add list item', 'core-extension' ) . '</span>
	                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
					</a>
	            </h4>
	         </div>
	      </div>
	   </div>
	</div>
</div>',
		'default_content' => '[vc_expandable_list_item title="' . sprintf( '%s %d', esc_html__( 'Section', 'core-extension' ), 1 ) . '"][/vc_expandable_list_item][vc_expandable_list_item title="' . sprintf( '%s %d', esc_html__( 'Section', 'core-extension' ), 2 ) . '"][/vc_expandable_list_item]',
		'js_view' => 'VcExpandableListView'
	) );


	// Expandable list item
	vc_map( array(
		'name' => esc_html__( 'Expandable list item', 'core-extension' ),
		'base' => 'vc_expandable_list_item',
		'icon' => 'icon-wpb-ui-tta-section',
		'show_settings_on_create' => false,
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'as_child' => array(
			'only' => 'vc_expandable_list',
		),
		'category' => esc_html__( 'Content', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'param_name' => 'title',
				'heading' => esc_html__( 'List item title', 'core-extension' ),
				'description' => esc_html__( 'Enter list item title or question.', 'core-extension' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Bullet style', 'core-extension' ),
				'param_name' => 'bullet_style',
				'value' => array(
					esc_html__( 'Default', 'core-extension' ) => 'default',
					esc_html__( 'Icon', 'core-extension' ) => 'icon',
					esc_html__( 'Number / Text', 'core-extension' ) => 'text'
				),
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'bullet_icon',
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'icon',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Enter the bullet number or text', 'core-extension' ),
				'description' => esc_html__( 'Try not to exceed two characters for better result.', 'core-extension' ),
				'param_name' => 'bullet_text',
				'dependency' => array(
					'element' => 'bullet_style',
					'value' => 'text',
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			$extra_class,
		),
		'js_view' => 'VcExpandableListItemView',
		'custom_markup' => '
		<div class="vc_tta-panel-heading">
		    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
		</div>
		<div class="vc_tta-panel-body">
			<div class="vc_controls">
				<div class="vc_controls-tc vc_control-container">
					<a class="vc_control-btn vc_element-name vc_element-move">
						<span class="vc_btn-content" title="Drag to move Expandable list item">List item</span>
					</a>
					<a class="vc_control-btn vc_control-btn-edit" href="#" title="Edit list item"><span class="vc_btn-content"><span class="icon"></span></span></a>
					<a class="vc_control-btn vc_control-btn-clone" href="#" title="Clone list item"><span class="vc_btn-content"><span class="icon"></span></span></a>
					<a class="vc_control-btn vc_control-btn-delete" href="#" title="Delete list item"><span class="vc_btn-content"><span class="icon"></span></span></a>
				</div>
			</div>
			<div class="wpb_column_container vc_container_for_children vc_clearfix vc_empty-container ui-sortable ui-droppable"></div>
				{{ content }}
			</div>
		</div>',
		'default_content' => '',
	) );

	// Service
	vc_map( array(
		"name" => esc_html__('Service', 'core-extension'),
		"base" => "vc_service",
		"icon" => "icon-wpb-vc_service",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Text', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Service info with custom icon', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Bullet on the left', 'core-extension') => "left",
					esc_html__('Bullet on the right', 'core-extension') => "right",
					esc_html__('Bullet on top centered', 'core-extension') => "center",
					esc_html__('Bullet on top left aligned', 'core-extension') => "center_left",
					esc_html__('Bullet on top right aligned', 'core-extension') => "center_right",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Bullet type', 'core-extension'),
				"param_name" => "bullet_type",
				"value" => array(esc_html__('Icon', 'core-extension') => "icon",
				                 esc_html__('Number', 'core-extension') => "number",
				                 esc_html__('Abbreviation', 'core-extension') => "abbr",
//				                 esc_html__('Image', 'core-extension') => "image"
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('left', 'right', 'center', 'center_left', 'center_right')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon draw animation', 'core-extension' ),
				'description' => esc_html__( 'Only works with "Linea" icon library', 'core-extension' ),
				'param_name' => 'icon_anim',
				'value' => array(
					esc_html__( 'Disable', 'core-extension' ) => '',
					esc_html__( 'When enters viewport', 'core-extension' ) => 'icon_anim_viewport',
					esc_html__( 'When enters viewport and on hover', 'core-extension' ) => 'icon_anim_viewport_hover',
				),
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => array('icon')
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Bullet container shape', 'core-extension'),
				"param_name" => "bullet_cont",
				"value" => array( esc_html__('Without container', 'core-extension') => "empty",
				                  esc_html__('Circle', 'core-extension') => "circle",
				                  esc_html__('Rounded square', 'core-extension') => "rounded",
				                  esc_html__('Square', 'core-extension') => "square",
				),
				"description" => esc_html__('Choose the shape of bullet container.', 'core-extension'),
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => array('icon')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
//			array(
//				"type" => "dropdown",
//				"heading" => esc_html__('Bullet size', 'core-extension'),
//				"param_name" => "bullet_size",
//				"value" => array(esc_html__('Small', 'core-extension') => "sm",
//				                 esc_html__('Medium', 'core-extension') => "md",
//				                 esc_html__('Large', 'core-extension') => "lg",
//				),
//				'dependency' => array(
//					'element' => 'style',
//					'value' => array('left', 'right', 'center', 'center_left', 'center_right')
//				),
//				"group" => esc_html__('Design', 'core-extension')
//			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Shadow', 'core-extension'),
				"param_name" => "shadow",
				"value" => array(esc_html__('No shadow', 'core-extension') => "no_shadow",
				                 esc_html__('Light shadow', 'core-extension') => "light_shadow",
				                 esc_html__('Dark shadow', 'core-extension') => "dark_shadow",
				),
				'save_always' => true,
				'description' => esc_html__( 'Add shadow to the bullet container', 'core-extension' ),
				'dependency' => array(
					'element' => 'bullet_cont',
					'value' => array('circle', 'rounded', 'square')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Outer border', 'core-extension'),
				"param_name" => "border",
				"value" => array(esc_html__('No border', 'core-extension') => "no_border",
				                 esc_html__('Dashed border', 'core-extension') => "border_dashed",
				),
				'save_always' => true,
				'description' => esc_html__( 'Add outer border to the bullet container', 'core-extension' ),
				'dependency' => array(
					'element' => 'bullet_cont',
					'value' => array('circle', 'rounded', 'square')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => array('icon')
				),
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Number', 'core-extension'),
				"param_name" => "number",
				"value" => '01',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => 'number'
				),
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Abbreviation', 'core-extension'),
				'description' => esc_html__( 'Only two characters will be displayed.', 'core-extension' ),
				"param_name" => "abbr",
				"value" => 'Ab',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => 'abbr'
				),
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Image', 'core-extension'),
				"param_name" => "image",
				"value" => "",
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => 'image'
				),
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Bullet font style', 'core-extension'),
				"param_name" => "bullet_typography",
				"value" => '',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => array('number', 'abbr')
				),
//				'font_size' => false,
//				'line_height' => false,
//				'transform' => false,
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Heading', 'core-extension'),
				"param_name" => "heading",
				"holder" => "h4",
				"value" => esc_html__('Service box title', 'core-extension'),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Heading font style', 'core-extension'),
				"param_name" => "heading_typography",
				"value" => '',
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('Service description', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				"value" => wp_kses_post( __('This is random service box text, change it to your own in shortcode settings. Dramatically productivate go forward infrastructures vis-a-vis bricks-and-clicks initiatives.', 'core-extension')),
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Bullet color', 'core-extension'),
				"param_name" => "bullet_color",
				"description" => esc_html__('Leave empty to use default text color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
				"dependency" => array(
					'element' => "bullet_type",
					'value' => array('icon', 'number', 'abbr')
				)
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Bullet container color', 'core-extension'),
				"param_name" => "bullet_cont_color",
				"description" => esc_html__('Leave empty to use accent color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
				"dependency" => array(
					'element' => "bullet_cont",
					'value' => array('circle', 'rounded', 'square')
				)
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Border color', 'core-extension'),
				"param_name" => "border_color",
				"description" => esc_html__('Leave empty to use accent color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
				'dependency' => array(
					'element' => 'style',
					'value' => array('border_left', 'border_right')
				),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Heading text color', 'core-extension'),
				"param_name" => "title_color",
				"description" => esc_html__('Leave empty to use default heading color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Description text color', 'core-extension'),
				"param_name" => "descr_color",
				"description" => esc_html__('Leave empty to use default text color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Enable lazy image loading for this element', 'core-extension'),
				"param_name" => "lazy",
				"value" => array(
					esc_html__('Default theme setting', 'core-extension') => "",
					esc_html__('Enable', 'core-extension') => "1",
					esc_html__('Disable', 'core-extension') => "0"
				),
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => 'image'
				),
				"description" => esc_html__('You can override theme\'s default lazy image loading settings for this element.', 'core-extension'),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
//		"js_view" => 'VcCustomServiceView'

	) );

	// Image Element
	vc_map( array(
		'name' => esc_html__( 'Image element', 'core-extension' ),
		'base' => 'vc_image_element',
		'icon' => 'icon-wpb-vc_image_element',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Customizable image', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'core-extension' ),
				'param_name' => 'image',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image size definition', 'core-extension' ),
				'param_name' => 'size_type',
				'value' => array(
					esc_html__( 'Relative size', 'core-extension' ) => 'relative',
					esc_html__( 'Fixed size', 'core-extension' ) => 'fixed'
				),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image aspect ratio', 'core-extension' ),
				'param_name' => 'size_relative',
				'value' => '',
				'dependency' => array(
					'element'   => 'size_type',
					'value'     => 'relative',
				),
				'description' => wp_kses_post( __( 'Enter aspect ratio of your image. If the original image has a different aspect ratio, it will be resized to fit this ratio. Leave empty to leave the original image aspect ratio.</br>Example: <code>1:1</code>,<code>4:3</code>,<code>16:9</code>', 'core-extension' )),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Maximum image width', 'core-extension' ),
				'param_name' => 'max_width',
				'dependency' => array(
					'element'   => 'size_type',
					'value'     => 'relative',
				),
				'description' => esc_html__( 'Enter maximum width that the image can take on the screen. Leave empty for the image to fill the whole width of its container element.', 'core-extension' ),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'core-extension' ),
				'param_name' => 'size_fixed',
				'dependency' => array(
					'element'   => 'size_type',
					'value'     => 'fixed',
				),
				'description' => esc_html__( 'Enter image size in pixels (Example: 200x100 (Width x Height)). Leave parameter empty to use "thumbnail" by default.', 'core-extension' ),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image alignment', 'core-extension' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Inherit', 'core-extension' ) => '',
					esc_html__( 'Center', 'core-extension' ) => 'center',
					esc_html__( 'Left', 'core-extension' ) => 'left',
					esc_html__( 'Right', 'core-extension' ) => 'right'
				),
				'save_always' => true,
				'std' => 'center',
				'description' => esc_html__( 'Select image alignment (applied if the image is narrower than its container element).', 'core-extension' ),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(   esc_html__( 'No shadow', 'core-extension' )        => '',
				                    esc_html__( 'Small shadow', 'core-extension' )     => 'shadow_small',
				                    esc_html__( 'Medium shadow', 'core-extension' )    => 'shadow_medium',
				                    esc_html__( 'Large shadow', 'core-extension' )      => 'shadow_large'
				),
				'description' => esc_html__( 'Add shadow to image.', 'core-extension' ),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Border radius', 'core-extension' ),
				'param_name' => 'radius',
				'value' => '0px',
				'description' => wp_kses_post( __( 'Enter border radius. Do not forget to add <code>px</code> or <code>%</code>.', 'core-extension' )),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Add color overlay?', 'core-extension'),
				"param_name" => "h_overlay",
				'value' => array(
					esc_html__('No overlay', 'core-extension' )                   => '',
					esc_html__('Overlay appears on hover', 'core-extension' )     => 'overlay',
					esc_html__('Overlay disappears on hover', 'core-extension' )  => 'overlay_h'),
				"group" => esc_html__('Hover', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => '',
				'dependency' => array(
					'element' => 'h_overlay',
					'not_empty' => true
				),
				"group" => esc_html__('Hover', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add effect on image hover', 'core-extension' ),
				'param_name' => 'image_hover',
				'value' => array(
					esc_html__('No effect', 'core-extension' )                    => '',
					esc_html__('Opaque on hover', 'core-extension' )              => 'h_transparent',
					esc_html__('Scale up on hover', 'core-extension' )            => 'h_scale_up',
					esc_html__('Scale down on hover', 'core-extension' )          => 'h_scale_down',
					esc_html__('Shift up on hover', 'core-extension' )            => 'h_shift_up',
				),
				"group" => esc_html__('Hover', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add link to image', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => esc_html__( 'Choose where the link will lead', 'core-extension' ),
				'value' => array(esc_html__('Do not add link', 'core-extension' ) => '',
				                 esc_html__('Link to another page' , 'core-extension' )           => 'page_link',
				                 esc_html__('Open image in popup window', 'core-extension' )      => 'image_popup',
				                 esc_html__('Open gallery in popup window', 'core-extension' )    => 'gallery_popup',
				                 esc_html__('Open video in popup window', 'core-extension' )      => 'video_popup'
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Image link', 'core-extension' ),
				'param_name' => 'link',
				'dependency' => array(
					'element' => 'img_link',
					'value' => 'page_link'
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Insert link to the content', 'core-extension' ),
				'param_name' => 'iframe_link',
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('video_popup')
				),
				'description' => wp_kses_post( __( 'You can add link to <strong>Youtube</strong> video or <strong>Vimeo</strong> video.', 'core-extension' )),
				'group' => esc_html__('Link', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('video_popup')
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Gallery images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'dependency' => array(
					'element' => 'img_link',
					'value' => 'gallery_popup'
				),
				'description' => esc_html__( 'Select images from media library.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Add icon based on link destination?', 'core-extension'),
				"param_name" => "icon",
				'value' => array(esc_html__('Do not add icon', 'core-extension' )                      => '',
				                 esc_html__('Add icon', 'core-extension' )                             => 'img_icon',
				                 esc_html__('Add icon shown only on image hover', 'core-extension' )   => 'img_icon_h'
				),
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('page_link', 'image_popup', 'gallery_popup', 'video_popup')
				),
				'description' => esc_html__( 'Icon will be added on top of the picture.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Position of the icon', 'core-extension' ),
				'param_name' => 'icon_position',
				'description' => esc_html__( 'Choose the position where the icon should appear.', 'core-extension' ),
				'dependency' => array(
					'element' => 'icon',
					'not_empty' => true
				),
				'value' => array(
					esc_html__('Center', 'core-extension' )               => 'icon_center',
					esc_html__('Top right corner', 'core-extension' )     => 'icon_top_right',
					esc_html__('Bottom right corner', 'core-extension' )  => 'icon_bot_right',
					esc_html__('Bottom left corner', 'core-extension' )   => 'icon_bot_left',
					esc_html__('Top left corner', 'core-extension' )      => 'icon_top_left'
				),
				'save_always' => true,
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size of the icon', 'core-extension' ),
				'param_name' => 'icon_size',
				'description' => esc_html__( 'Choose how big the icon should be', 'core-extension' ),
				'dependency' => array(
					'element' => 'icon',
					'not_empty' => true
				),
				'value' => array(
					esc_html__('Small', 'core-extension' )        => 'icon_small',
					esc_html__('Medium', 'core-extension' )       => 'icon_medium',
					esc_html__('Large', 'core-extension' )        => 'icon_large'
				),
				'save_always' => true,
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')    => "dark",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'icon',
					'not_empty' => true
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcCustomImageView'
	) );

	// Image Cascade
	vc_map( array(
		'name' => esc_html__( 'Image cascade', 'core-extension' ),
		'base' => 'vc_image_cascade',
		'icon' => 'icon-wpb-vc_image_cascade',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Customizable image', 'core-extension' ),
		'params' => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Layout', 'core-extension'),
				"param_name" => "layout",
				"value" => array(
					esc_html__('Layout 1 (for 2 images)', 'core-extension') => "1",
					esc_html__('Layout 2 (for 2 images)', 'core-extension') => "2",
					esc_html__('Layout 3 (for 2 images)', 'core-extension') => "3",
					esc_html__('Layout 4 (for 2 images)', 'core-extension') => "4",
					esc_html__('Layout 5 (for 3 images)', 'core-extension') => "5",
					esc_html__('Layout 6 (for 3 images)', 'core-extension') => "6",
					esc_html__('Layout 7 (for 3 images)', 'core-extension') => "7",
					esc_html__('Layout 8 (for 3 images)', 'core-extension') => "8",
					esc_html__('Layout 9 (for 4 images)', 'core-extension') => "9",
					esc_html__('Layout 10 (for 4 images)', 'core-extension') => "10",
					esc_html__('Layout 11 (for 4 images)', 'core-extension') => "11",
					esc_html__('Layout 12 (for 4 images)', 'core-extension') => "12",
				),
				'save_always' => true,
				"group" => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__( 'Select images from media library.', 'core-extension' ),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image aspect ratio', 'core-extension' ),
				'param_name' => 'aspect_ratio',
				'value' => '',
				'description' => wp_kses_post( __( 'Set aspect ratio of displayed images. If original images have different aspect ratio, they will be resized to fit this ratio. If left empty, the original image aspect ratio will be used.</br>Example: <code>1:1</code>,<code>4:3</code>,<code>16:9</code>', 'core-extension' )),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Enable', 'core-extension' )    => 'shadow'
				),
				'description' => esc_html__( 'Add shadow to images.', 'core-extension' ),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Image border radius', 'core-extension' ),
				"param_name" => "border",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Action on image click', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => esc_html__( 'What happens when a user clicks an image.', 'core-extension' ),
				'value' => array(
					esc_html__('No action', 'core-extension')               => '',
					esc_html__('Open gallery in lightbox', 'core-extension') => 'gallery_popup'
				),
				"group" => esc_html__('Action', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
		),
	) );

	// Image With Caption
	vc_map( array(
		'name' => esc_html__( 'Image with caption', 'core-extension' ),
		'base' => 'vc_image_caption',
		'icon' => 'icon-wpb-vc_image_caption',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Customizable image', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'core-extension' ),
				'param_name' => 'image',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image aspect ratio', 'core-extension' ),
				'param_name' => 'aspect_ratio',
				'value' => '',
				'description' => wp_kses_post( __( 'Set aspect ratio of displayed images. If original images have different aspect ratio, they will be resized to fit this ratio. If left empty, the original image aspect ratio will be used.</br>Example: <code>1:1</code>,<code>4:3</code>,<code>16:9</code>', 'core-extension' )),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Force overlay to always be visible on mobile', 'core-extension' ),
				'param_name' => 'overlay_mobile',
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				"group" => esc_html__('Image', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Caption behaviour', 'core-extension'),
				"param_name" => "caption_appear",
				'value' => array(
					esc_html__('Appears on hover', 'core-extension')      => 'caption_appear',
					esc_html__('Disappears on hover', 'core-extension')   => 'caption_disappear',
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Caption color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Caption color scheme', 'core-extension'),
				"param_name" => "scheme",
				"value" => array(
					esc_html__('Default', 'core-extension')   => "default",
					esc_html__('Colorful', 'core-extension')  => "colorful",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the color scheme based on the container background.', 'core-extension' ),
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('style_2'),
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Caption background color', 'core-extension'),
				"param_name" => "bg_color",
				'dependency' => array(
					'element'   => 'scheme',
					'value'     => array('colorful'),
				),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(   esc_html__( 'No shadow', 'core-extension' )        => '',
				                    esc_html__( 'Small shadow', 'core-extension' )     => 'shadow_small',
				                    esc_html__( 'Medium shadow', 'core-extension' )    => 'shadow_medium',
				                    esc_html__( 'Large shadow', 'core-extension' )      => 'shadow_large'
				),
				'description' => esc_html__( 'Add shadow to image.', 'core-extension' ),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Image border radius', 'core-extension' ),
				"param_name" => "radius",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Caption title', 'core-extension' ),
				'param_name' => 'title',
				"value" => esc_html__('Caption title', 'core-extension'),
				'group' => esc_html__('Title', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Title font style', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Title', 'core-extension')
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Caption description', 'core-extension' ),
				'param_name' => 'description',
				"value" => esc_html__('Caption description', 'core-extension'),
				'group' => esc_html__('Description', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Description font style', 'core-extension'),
				"param_name" => "description_typography",
				"value" => '',
				"group" => esc_html__('Description', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add link to image', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => esc_html__( 'Choose where the link will lead', 'core-extension' ),
				'value' => array(esc_html__('Do not add link', 'core-extension') => '',
				                 esc_html__('Link to another page', 'core-extension')            => 'page_link',
				                 esc_html__('Open image in popup window', 'core-extension')      => 'image_popup',
				                 esc_html__('Open gallery in popup window', 'core-extension')    => 'gallery_popup',
				                 esc_html__('Open video in popup window', 'core-extension')      => 'video_popup'
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Image link', 'core-extension' ),
				'param_name' => 'link',
				'dependency' => array(
					'element' => 'img_link',
					'value' => 'page_link'
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Insert link to the content', 'core-extension' ),
				'param_name' => 'iframe_link',
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('video_popup')
				),
				'description' => wp_kses_post( __( 'You can add link to <strong>Youtube</strong> video or <strong>Vimeo</strong> video.', 'core-extension' )),
				'group' => esc_html__('Link', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('video_popup')
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Gallery images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'dependency' => array(
					'element' => 'img_link',
					'value' => 'gallery_popup'
				),
				'description' => esc_html__( 'Select images from media library.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcCustomImageView'
	) );

	// Image Box
	vc_map( array(
		'name' => esc_html__( 'Image box', 'core-extension' ),
		'base' => 'vc_image_box',
		'icon' => 'icon-wpb-vc_image_box',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		'description' => esc_html__( 'Image box with text', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'core-extension' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image aspect ratio', 'core-extension' ),
				'param_name' => 'aspect_ratio',
				'value' => '',
				'description' => wp_kses_post( __( 'Set aspect ratio of displayed images. If original images have different aspect ratio, they will be resized to fit this ratio. If left empty, the original image aspect ratio will be used.</br>Example: <code>1:1</code>,<code>4:3</code>,<code>16:9</code>', 'core-extension' )),
				'group' => esc_html__('Image', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2"
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Content box alignment', 'core-extension'),
				"param_name" => "align",
				"value" => array(
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => 'style_2'
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Content box color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => 'style_2'
				),
				'description' => esc_html__( 'Choose the tabs color sking based on the container background.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Image box background color', 'core-extension'),
				"param_name" => "bg_color",
				'dependency' => array(
					'element' => 'style',
					'value' => 'style_2'
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => '',
				'dependency' => array(
					'element' => 'style',
					'value' => 'style_1'
				),
				'description' => esc_html__( 'Only visible when the link is attached to the box.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border radius', 'core-extension'),
				"param_name" => "radius",
				"std" => '4',
				'range_from' => '0',
				'range_to' => '30',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( 'Enter border radius in <code>px</code>.', 'core-extension' )),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Box title', 'core-extension' ),
				'param_name' => 'title',
				"value" => esc_html__('Image box title', 'core-extension'),
				'admin_label' => true,
				'group' => esc_html__('Content', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Title font style', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Content', 'core-extension')
			),
			array(
				'type' => 'textarea_html',
				'heading' => esc_html__( 'Box description', 'core-extension' ),
				'param_name' => 'content',
				'group' => esc_html__('Content', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Add link to box', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => esc_html__( 'Choose where the link will lead', 'core-extension' ),
				'value' => array(esc_html__('Do not add link', 'core-extension') => '',
				                 esc_html__('Link to another page', 'core-extension')            => 'page_link',
				                 esc_html__('Open image in popup window', 'core-extension')      => 'image_popup',
				                 esc_html__('Open gallery in popup window', 'core-extension')    => 'gallery_popup',
				                 esc_html__('Open video in popup window', 'core-extension')      => 'video_popup'
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Image link', 'core-extension' ),
				'param_name' => 'link',
				'dependency' => array(
					'element' => 'img_link',
					'value' => 'page_link'
				),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Insert link to the content', 'core-extension' ),
				'param_name' => 'iframe_link',
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('video_popup')
				),
				'description' => wp_kses_post( __( 'You can add link to <strong>Youtube</strong> video or <strong>Vimeo</strong> video.', 'core-extension' )),
				'group' => esc_html__('Link', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'img_link',
					'value' => array('video_popup')
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Gallery images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'dependency' => array(
					'element' => 'img_link',
					'value' => 'gallery_popup'
				),
				'description' => esc_html__( 'Select images from media library.', 'core-extension' ),
				"group" => esc_html__('Link', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
		"js_view" => 'VcCustomImageView'
	) );

	// Image Carousel
	vc_map( array(
		"name"		=> esc_html__('Image Carousel', 'core-extension'),
		"base"		=> "vc_image_carousel",
		"icon"		=> "icon-wpb-vc_image_carousel",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Carousel with images', 'core-extension'),
		"params" => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__( 'Select images from media library.', 'core-extension' ),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image aspect ratio', 'core-extension' ),
				'param_name' => 'aspect_ratio',
				'value' => '',
				'description' => wp_kses_post( __( 'Set aspect ratio of displayed images. If original images have different aspect ratio, they will be resized to fit this ratio. If left empty, the original image aspect ratio will be used.</br>Example: <code>1:1</code>,<code>4:3</code>,<code>16:9</code>', 'core-extension' )),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open images in lightbox', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => esc_html__( 'What happens when a user clicks an image.', 'core-extension' ),
				'value' => array(
					esc_html__('No', 'core-extension') => '',
					esc_html__('Yes', 'core-extension') => 'gallery_popup'
				),
				'group' => esc_html__('Images', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Carousel style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Simple', 'core-extension' ) => 'simple',
					esc_html__( 'Scaling', 'core-extension' ) => 'scale',
					esc_html__( 'Centered', 'core-extension' ) => 'centered',
					esc_html__( 'Overlapping', 'core-extension' ) => 'overlap'
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the carousel style.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Free scroll', 'core-extension'),
				"param_name" => "freescroll",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Enable', 'core-extension' )    => '1'
				),
				'dependency' => array(
					'element' => 'style',
					'value' => 'simple'
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border radius', 'core-extension'),
				"param_name" => "radius",
				"std" => '4',
				'range_from' => '0',
				'range_to' => '30',
				'step' => '1',
				'save_always' => true,
				'description' => wp_kses_post( __( 'Set border radius in <code>px</code>.', 'core-extension' )),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image shadow', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(
					esc_html__( 'Enable', 'core-extension' )    => '',
					esc_html__( 'Disable', 'core-extension' )   => 'no_shadow',
				),
//				'std' => 'no_shadow',
				'save_always' => true,
				'description' => esc_html__( 'Add shadow to images.', 'core-extension' ),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Slide padding', 'core-extension' ),
				'param_name' => 'padding',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'padding',
				'dependency' => array(
					'element'   => 'style',
					'value'     => 'simple',
				),
				'description' => esc_html__( 'Use to set slide padding different from the default one.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Navigation arrows', 'core-extension'),
				"param_name" => "navigation",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Enable', 'core-extension' )    => '1',
				),
				'std' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('simple', 'overlap'),
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Navigation arrows skin', 'core-extension'),
				"param_name" => "navigation_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the navigation buttons color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Pagination', 'core-extension'),
				"param_name" => "slider_pagination",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Style 1', 'core-extension' )   => 'style_1',
					esc_html__( 'Style 2', 'core-extension' )   => 'style_2',
					esc_html__( 'Style 3', 'core-extension' )   => 'style_3'
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Pagination buttons skin', 'core-extension'),
				"param_name" => "pagination_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the pagination buttons color skin based on the container background.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Hide navigation elements', 'core-extension'),
				"param_name" => "hide_nav",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Enable', 'core-extension')  => "true",
				),
				'description' => esc_html__( 'Show navigation elements only when the slider is hovered.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Number of slides per view', 'core-extension' ),
				"param_name" => "slides_to_show",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '8',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('simple'),
				),
				"description" => esc_html__( 'Number of slides visible at the same time.', 'core-extension' ),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Number of slides scrolled', 'core-extension'),
				"param_name" => "slides_to_scroll",
				"value" => array(
					esc_html__( 'One', 'core-extension' )           => '1',
					esc_html__( 'Whole view', 'core-extension' )    => 'all'
				),
				'save_always' => true,
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('simple'),
				),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Enable responsiveness', 'core-extension'),
				"param_name" => "responsiveness",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )   => '',
					esc_html__( 'Enable', 'core-extension' )    => 'true'
				),
				'dependency' => array(
					'element'   => 'style',
					'value'     => array('simple'),
				),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Number of slides per view on tablet', 'core-extension' ),
				"param_name" => "slides_to_show_tablet",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '8',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'responsiveness',
					'not_empty'     => true,
				),
				"description" => esc_html__( 'Smaller than 1024px', 'core-extension' ),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Number of slides per view on mobile', 'core-extension' ),
				"param_name" => "slides_to_show_mobile",
				"std" => '1',
				'range_from' => '1',
				'range_to' => '8',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element'   => 'responsiveness',
					'not_empty'     => true,
				),
				"description" => esc_html__( 'Smaller than 768px', 'core-extension' ),
				"group" => esc_html__('Slides', 'core-extension')
			),
			array(
				"type" => 'textfield',
				"heading" => esc_html__('Initial slide', 'core-extension'),
				"param_name" => "initial_slide",
				"value" => '1',
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Auto height', 'core-extension'),
				"param_name" => "autoheight",
				"value" => array(
					esc_html__( 'Disable', 'core-extension' )    => 'false',
					esc_html__( 'Enable', 'core-extension' )   => 'true'
				),
				'std' => 'false',
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Carousel speed', 'core-extension' ),
				"param_name" => "slider_speed",
				"std" => '20',
				'range_from' => '1',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('simple', 'scale', 'centered')
				),
				"group" => esc_html__('Carousel animation', 'core-extension')
			),
			array(
				"type" => 'wtbx_vc_slider',
				"heading" => esc_html__('Slider autoplay speed', 'core-extension'),
				"param_name" => "autoplay",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '20',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __( 'Set time of slider autoplay in seconds. Higher number means longer interval. Set to <code>0</code> to disable autoplay.', 'core-extension' )),
				"group" => esc_html__('Carousel animation', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => esc_html__('Pause slider on hover', 'core-extension'),
				"param_name" => "stop_hover",
				"value" => array(
					esc_html__( 'No', 'core-extension' )    => 'false',
					esc_html__( 'Yes', 'core-extension' )   => 'true'
				),
				'std' => 'true',
				'save_always' => true,
				"group" => esc_html__('Carousel animation', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class
		),
		"js_view" => 'VcImageCarouselView'
	) );

	// Modal Window
	vc_map( array(
		"name"		=> esc_html__('Modal Window', 'core-extension'),
		"base"		=> "vc_modal",
		"icon"		=> "icon-wpb-vc_modal_window",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Container', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Modal window with overlay', 'core-extension'),
		'allowed_container_element' => 'vc_row',
		"is_container" => true,
		"show_settings_on_create" => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Modal window ID', 'core-extension' ),
				"param_name" => "id",
				"value" => "",
				"description" => wp_kses( __('Add <strong>ID</strong> to this modal window. The element triggering this modal shoud have <code>#modal-</code> in front of this ID in the URL.</br>
									 E.g. if your modal window ID is <code>description</code>, your trigger element URL should be <code>#modal-description</code>.', 'core-extension' ), 'default')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Maximum width', 'core-extension' ),
				"param_name" => "width",
				"value" => "800",
				"description" => esc_html__( 'Enter maximum width in pixels you want this modal window to take.', 'core-extension' ),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => '',
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Close button skin', 'core-extension'),
				"param_name" => "close_button_skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the close button color skin based on its container background.', 'core-extension' ),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Animation effect', 'core-extension' ),
				'param_name' => 'effect',
				'value' => array( esc_html__('Fade in', 'core-extension')     => 'fade',
				                  esc_html__('Slide down', 'core-extension')  => 'slide-down',
				                  esc_html__('Slide up', 'core-extension')    => 'slide-up',
				                  esc_html__('Scale down', 'core-extension')  => 'scale-down',
				                  esc_html__('Scale up', 'core-extension')    => 'scale-up',
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_design',
				'heading' => esc_html__( 'Design', 'core-extension' ),
				'param_name' => 'el_design',
				'padding-h' => '45',
				'padding-v' => '45',
				'value' => '{"desktop":{"padding-top":45,"padding-right":45,"padding-bottom":45,"padding-left":45}}',
				'additional' => false,
				'margin' => false,
				'border' => false,
				'group' => esc_html__( 'Design', 'core-extension' )
			),
			$extra_class,
		),
		"js_view" => 'VcModalView'
	) );

	// Post Grid
	vc_map( array(
		"name"		=> esc_html__('Post Grid', 'core-extension'),
		"base"		=> "vc_scape_post_grid",
		"icon"		=> "icon-wpb-vc_post_grid",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Grid with posts entries.', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Blog grid type', 'core-extension'),
				"param_name" => "style",
				'admin_label' => true,
				"value" => array(
					esc_html__('Default', 'core-extension') => "default",
					esc_html__('Column', 'core-extension') => "column",
					esc_html__('Minimal', 'core-extension') => "minimal",
					esc_html__('Side-by-side', 'core-extension') => "sbs",
					esc_html__('Masonry', 'core-extension') => "masonry",
					esc_html__('Metro', 'core-extension') => "metro",
					esc_html__('Boxed', 'core-extension') => "boxed",
					esc_html__('Magazine', 'core-extension') => "magazine",
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Post media preview', 'core-extension'),
				"param_name" => "preview",
				"value" => array(
					esc_html__('Featured image', 'core-extension')  => "featured_image",
					esc_html__('Post media', 'core-extension')      => "post_media",
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('default', 'masonry', 'column')
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Number of columns', 'core-extension'),
				"param_name" => "columns",
				"value" => array(
					esc_html__('1', 'core-extension') => "1",
					esc_html__('2', 'core-extension') => "2",
					esc_html__('3', 'core-extension') => "3",
					esc_html__('4', 'core-extension') => "4",
					esc_html__('5', 'core-extension') => "5",
					esc_html__('6', 'core-extension') => "6"
				),
				'std' => '3',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'boxed')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Number of columns', 'core-extension'),
				"param_name" => "columns_minimal",
				"value" => array(
					esc_html__('1', 'core-extension') => "1",
					esc_html__('2', 'core-extension') => "2"
				),
				'std' => '1',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('minimal')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__( 'Metro grid layout', 'core-extension' ),
				"param_name" => "metro_layout",
				"value" => array(
					esc_html__('1 Column', 'core-extension') => "columns_1",
					esc_html__('2 Columns', 'core-extension') => "columns_2",
					esc_html__('3 Columns', 'core-extension') => "columns_3",
					esc_html__('4 Columns', 'core-extension') => "columns_4",
					esc_html__('5 Columns', 'core-extension') => "columns_5",
					esc_html__('6 Columns', 'core-extension') => "columns_6",
					esc_html__('Layout 1 (repeated each 4 or 8 items)', 'core-extension') => "layout_7",
					esc_html__('Layout 2 (repeated each 7 or 14 items)', 'core-extension') => "layout_8",
				),
				'std' => 'columns_4',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => 'metro'
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Min column width', 'core-extension' ),
				"param_name" => "min_width",
				"value" => "",
				"description" => esc_html__( 'Minimum grid column width in px, which serves as a responsiveness breakpoint. Leave empty to use default responsiveness options.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Grid gutter size', 'core-extension' ),
				"param_name" => "gutter",
				"value" => "5",
				'dependency' => array(
					'element' => 'style',
					'value' => array('metro')
				),
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Grid item border radius', 'core-extension' ),
				"param_name" => "border",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('metro')
				),
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Post thumbnail width', 'core-extension'),
				"param_name" => "media_width",
				"value" => array(
					esc_html__('4', 'core-extension')   => '4',
					esc_html__('5', 'core-extension')   => '5',
					esc_html__('6', 'core-extension')   => '6',
					esc_html__('7', 'core-extension')   => '7',
					esc_html__('8', 'core-extension')   => '8'
				),
				'std' => '6',
				"description" => esc_html__( 'Choose how many columns wide should the thumbnail be.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('sbs')
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Hide meta elements', 'core-extension'),
				"param_name" => "hide_meta",
				"value" => array(
					__('Author image</br>', 'core-extension')    => "author-image",
					__('Author name</br>', 'core-extension')     => "author-name",
					__('Date</br>', 'core-extension')            => "date",
					__('Comments</br>', 'core-extension')        => "comments",
					__('Categories</br>', 'core-extension')      => "categories",
					__('Like button</br>', 'core-extension')     => "like",
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Estimated reading time', 'core-extension'),
				"param_name" => "reading_time",
				"value" => array(
					esc_html__('Display', 'core-extension') => "1",
					esc_html__('Do not display', 'core-extension') => "",
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('sbs', 'minimal')
				),
//				'std' => '',
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
//			array(
//				'type' => 'checkbox',
//				'heading' => esc_html__( 'Force overlay to always be visible on mobile', 'core-extension' ),
//				'param_name' => 'overlay_mobile',
//				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
//				"group" => esc_html__('Layout', 'core-extension'),
//				'dependency' => array(
//					'element' => 'style',
//					'value' => array('metro')
//				),
//			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Thumbnail aspect ratio', 'core-extension' ),
				"param_name" => "aspect_ratio",
				"value" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => array('default', 'masonry', 'sbs', 'column')
				),
				"description" => wp_kses_post( __( '<strong>Width:height</strong> aspect ratio of images in the grid. Leave blank for not forcing aspect ratio.</br>Example: <code>16:10</code>', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Post excerpt length', 'core-extension' ),
				"param_name" => "excerpt_length",
				"value" => "20",
				'dependency' => array(
					'element' => 'style',
					'value' => array('default', 'minimal', 'masonry', 'sbs', 'boxed', 'magazine', 'column')
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Item appearance animation', 'core-extension' ),
				'param_name' => 'animation_style',
				'value' => wtbx_vc_grid_animations(),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('minimal', 'masonry', 'sbs', 'boxed', 'magazine')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Disable sequential appearance animation', 'core-extension'),
				"param_name" => "disable_sequential",
				"value" => array(
					esc_html__('No', 'core-extension') => "",
					esc_html__('Yes', 'core-extension') => "1"
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('minimal', 'masonry', 'metro', 'boxed', 'magazine')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Grid container background color', 'core-extension'),
				"param_name" => "grid_bg_color",
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Item overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'description' => esc_html__( 'Overlay color that the grid items have on default state. Leave empty to use default overlay color.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('metro')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Query', 'core-extension'),
				"param_name" => "query",
				"value" => array(
					esc_html__('Use settings', 'core-extension') => "settings",
					esc_html__('Global query', 'core-extension') => "global",
					esc_html__('Custom query', 'core-extension') => "custom",
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Limit items to specific categories', 'core-extension' ),
				'param_name' => 'limit',
				'description' => esc_html__( 'Check if you only want to display posts of specific categories.', 'core-extension' ),
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				'dependency' => array(
					'element' => 'query',
					'value' => 'settings'
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Categories to display', 'core-extension'),
				"param_name" => "categories",
				'value' => wtbx_vc_get_terms('category'),
				'dependency' => array(
					'element' => 'limit',
					'not_empty' => true
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Custom query', 'core-extension' ),
				"param_name" => "custom_wp_query",
				"value" => "",
				"description" => esc_html__( 'Write custom query', 'core-extension' ),
				'dependency' => array(
					'element' => 'query',
					'value' => 'custom'
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter', 'core-extension'),
				"param_name" => "filter",
				"value" => array(
					esc_html__('No filter', 'core-extension') => "",
					esc_html__('Filter - minimalistic', 'core-extension') => "minimal",
					esc_html__('Filter - slider', 'core-extension') => "slider",
					esc_html__('Filter - multichoice', 'core-extension') => "multi",
					esc_html__('Filter - sidebar', 'core-extension') => "sidebar"
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed')
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter alignment', 'core-extension'),
				"param_name" => "filter_align",
				"value" => array(
					esc_html__('Center', 'core-extension') => "center",
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right",
				),
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter buttons layout', 'core-extension'),
				"description" => esc_html__('Only works with left or right aligned filter', 'core-extension'),
				"param_name" => "filter_layout",
				"value" => array(
					esc_html__('Together', 'core-extension') => "",
					esc_html__('Separated', 'core-extension') => "-separated",
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => 'minimal'
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Multichoice filter operator', 'core-extension'),
				"param_name" => "filter_operator",
				"value" => array(
					esc_html__('OR', 'core-extension') => "or",
					esc_html__('AND', 'core-extension') => "and"
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('multi')
				),
				'save_always' => true,
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter updates hash', 'core-extension'),
				"description" => esc_html__( 'URL hash will be updated when the filter is used. Allows to create links to filtered grids.', 'core-extension' ),
				"param_name" => "filter_hash",
				"value" => array(
					esc_html__('No', 'core-extension') => "",
					esc_html__('Yes', 'core-extension') => "1",
				),
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Default category to display', 'core-extension'),
				"param_name" => "defaults",
				'value' => wtbx_vc_get_terms('category'),
//				"description" => esc_html__( 'Applicable if filter is enabled.', 'core-extension' ),
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Filter background color', 'core-extension'),
				"param_name" => "filter_bg_color",
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter skin', 'core-extension'),
				"param_name" => "filter_skin",
				"value" => array(
					esc_html__('Light', 'core-extension') => "light",
					esc_html__('Dark', 'core-extension') => "dark"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'filter',
					'value' => array('minimal', 'slider', 'multi')
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter color scheme', 'core-extension'),
				"param_name" => "filter_scheme",
				"value" => array(
					esc_html__('Default', 'core-extension') => "default",
					esc_html__('Colorful', 'core-extension') => "colorful"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'filter',
					'value' => array('minimal', 'slider', 'multi')
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Number of items per page', 'core-extension' ),
				"param_name" => "perpage",
				"value" => "",
				"description" => esc_html__( 'Leave empty to display all items', 'core-extension' ),
				'dependency' => array(
					'element' => 'query',
					'value' => array('settings')
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Navigation', 'core-extension'),
				"param_name" => "navigation",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Pagination', 'core-extension') => "1",
					esc_html__('Lazy loading', 'core-extension') => "2"
				),
				"description" => esc_html__( 'Pagination only works if "Global query" is chosen.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Pagination skin', 'core-extension'),
				"param_name" => "nav_skin",
				"value" => array(
					esc_html__('Light', 'core-extension') => "light",
					esc_html__('Dark', 'core-extension') => "dark"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'navigation',
					'value' => array('1')
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('"Load more" button', 'core-extension'),
				"param_name" => "loadmore",
				"value" => array(
					esc_html__('Never', 'core-extension') => "",
					esc_html__('1', 'core-extension') => 1,
					esc_html__('2', 'core-extension') => 2,
					esc_html__('3', 'core-extension') => 3,
					esc_html__('4', 'core-extension') => 4,
					esc_html__('5', 'core-extension') => 5,
					esc_html__('6', 'core-extension') => 6,
					esc_html__('7', 'core-extension') => 7,
					esc_html__('8', 'core-extension') => 8,
					esc_html__('9', 'core-extension') => 9,
					esc_html__('10', 'core-extension') => 10
				),
				'dependency' => array(
					'element' => 'navigation',
					'value' => array('2')
				),
				"description" => wp_kses_post( __( 'Show <strong>"Load More"</strong> button after this number of item batches loaded or choose to never show it.', 'core-extension' )),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Number of batches to load', 'core-extension' ),
				"param_name" => "post_limit",
				"value" => "",
				"description" => esc_html__( 'How many times to load older items. Leave empty to load all items available.', 'core-extension' ),
				'dependency' => array(
					'element' => 'navigation',
					'value' => array('2')
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Post title font style', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Excerpt font style', 'core-extension'),
				"param_name" => "excerpt_typography",
				"value" => '',
				'dependency' => array(
					'element' => 'style',
					'value' => array('default', 'sbs', 'minimal', 'masonry', 'boxed', 'column')
				),
				"group" => esc_html__('Typography', 'core-extension')
			),
			$extra_class,
		)
	) );

	// Portfolio Item Grid
	vc_map( array(
		"name"		=> esc_html__('Portfolio Grid', 'core-extension'),
		"base"		=> "vc_scape_portfolio_grid",
		"icon"		=> "icon-wpb-vc_portfolio_grid",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"front_enqueue_js" =>  $frontend_scripts_portfolio_grid,
		"description" => esc_html__('Grid with portfolio items.', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Grid type', 'core-extension'),
				"param_name" => "style",
				'admin_label' => true,
				"value" => array(
					esc_html__('Masonry', 'core-extension') => "masonry",
					esc_html__('Metro', 'core-extension') => "metro",
					esc_html__('Boxed', 'core-extension') => "boxed",
					esc_html__('Square', 'core-extension') => "square",
					esc_html__('Tiles', 'core-extension') => "tiles",
					esc_html__('Overlap', 'core-extension') => "overlap",
					esc_html__('Panels', 'core-extension') => "panels",
					esc_html__('Slider', 'core-extension') => "slider"
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Max number of columns', 'core-extension'),
				"param_name" => "columns",
				"value" => array(
					esc_html__('1', 'core-extension') => "1",
					esc_html__('2', 'core-extension') => "2",
					esc_html__('3', 'core-extension') => "3",
					esc_html__('4', 'core-extension') => "4",
					esc_html__('5', 'core-extension') => "5",
					esc_html__('6', 'core-extension') => "6",
				),
				'std' => '3',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'boxed', 'square', 'tiles')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__( 'Metro grid layout', 'core-extension' ),
				"param_name" => "metro_layout",
				"value" => array(
					esc_html__( 'Default', 'core-extension' ) => 'default',
					esc_html__( 'Individual', 'core-extension' ) => 'individual',
					esc_html__( 'Predefined 1 (repeated each 12 items)', 'core-extension' ) => 'layout_1',
					esc_html__( 'Predefined 2 (repeated each 12 items)', 'core-extension' ) => 'layout_2',
					esc_html__( 'Predefined 3 (repeated each 12 items)', 'core-extension' ) => 'layout_3',
					esc_html__( 'Predefined 4 (repeated each 10 items)', 'core-extension' ) => 'layout_4',
					esc_html__( 'Predefined 5 (repeated each 10 items)', 'core-extension' ) => 'layout_5',
					esc_html__( 'Predefined 6 (repeated each 10 items)', 'core-extension' ) => 'layout_6',
					esc_html__( 'Predefined 7 (repeated each 4 or 8 items)', 'core-extension' ) => 'layout_7',
					esc_html__( 'Predefined 8 (repeated each 7 or 14 items)', 'core-extension' ) => 'layout_8',
				),
				'std' => 'default',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => 'metro'
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Number of columns', 'core-extension'),
				"param_name" => "columns_portfolio_metro",
				"value" => array(
					esc_html__('1', 'core-extension') => "1",
					esc_html__('2', 'core-extension') => "2",
					esc_html__('3', 'core-extension') => "3",
					esc_html__('4', 'core-extension') => "4",
					esc_html__('5', 'core-extension') => "5",
					esc_html__('6', 'core-extension') => "6",
				),
				'std' => '3',
				'save_always' => true,
				'dependency' => array(
					'element' => 'metro_layout',
					'value' => array('default', 'individual')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Min column width', 'core-extension' ),
				"param_name" => "min_width",
				"value" => "",
				"description" => esc_html__( 'Minimum grid column width in px, which serves as a responsiveness breakpoint. Leave empty to use default responsiveness options.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'boxed', 'tiles', 'square')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Min column width', 'core-extension' ),
				"param_name" => "min_width_metro",
				"value" => "",
				"description" => esc_html__( 'Minimum grid column width in px, which serves as a responsiveness breakpoint. Leave empty to use default responsiveness options.', 'core-extension' ),
				'dependency' => array(
					'element' => 'metro_layout',
					'value' => array('default', 'individual')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Grid gutter size', 'core-extension' ),
				"param_name" => "gutter",
				"value" => "5",
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'tiles', 'square')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Grid item border radius', 'core-extension' ),
				"param_name" => "border",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'tiles', 'square', 'overlap')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Thumbnail aspect ratio', 'core-extension' ),
				"param_name" => "aspect_ratio",
				"value" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'boxed', 'square', 'tiles', 'overlap')
				),
				"description" => wp_kses_post( __( '<strong>Width:height</strong> aspect ratio of images in the grid. Leave blank for not forcing aspect ratio.</br>Example: <code>16:10</code>', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Item appearance animation', 'core-extension' ),
				'param_name' => 'animation_style',
				'value' => wtbx_vc_grid_animations(),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'square', 'tiles', 'overlap')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Disable sequential appearance animation', 'core-extension'),
				"param_name" => "disable_sequential",
				"value" => array(
					esc_html__('No', 'core-extension') => "",
					esc_html__('Yes', 'core-extension') => "1"
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'square', 'tiles')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Force overlay to always be visible on mobile', 'core-extension' ),
				'param_name' => 'overlay_mobile',
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'square', 'tiles')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Grid container background color', 'core-extension'),
				"param_name" => "grid_bg_color",
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "color_skin",
				"value" => array(
					esc_html__('Light', 'core-extension') => "light",
					esc_html__('Dark', 'core-extension') => "dark"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles', 'overlap', 'panels', 'slider')
				),
				"description" => wp_kses_post( __( 'Set to <strong>Dark</strong> when using dark container background.', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Mousemove animation', 'core-extension'),
				"param_name" => "mousemove",
				"value" => array(
					esc_html__('Enable', 'core-extension') => "true",
					esc_html__('Disable', 'core-extension') => "false",
				),
				'std' => 'false',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro')
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Item idle overlay', 'core-extension'),
				"param_name" => "overlay_idle",
				"value" => array(
					esc_html__('Empty', 'core-extension') => "empty",
					esc_html__('Color overlay', 'core-extension') => "color",
					esc_html__('Meta centered', 'core-extension') => "meta_centered",
					esc_html__('Meta middle', 'core-extension') => "meta_middle",
					esc_html__('Meta aligned', 'core-extension') => "meta_aligned",
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed')
				),
				"group" => esc_html__('Overlay idle', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Item overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'description' => esc_html__( 'Leave empty to use default overlay color.', 'core-extension' ),
				'dependency' => array(
					'element' => 'overlay_idle',
					'value' => array('color', 'meta_middle')
				),
				"group" => esc_html__('Overlay idle', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Primary meta info', 'core-extension'),
				"param_name" => "portfolio_content_primary",
				"value" => wtbx_vc_scape_grid_meta(),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'overlay_idle',
					'value' => array('meta_centered', 'meta_aligned', 'meta_middle')
				),
				"group" => esc_html__('Overlay idle', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Secondary meta info', 'core-extension'),
				"param_name" => "portfolio_content_secondary",
				"value" => wtbx_vc_scape_grid_meta(),
				'save_always' => true,
				'std' => 'categories',
				'dependency' => array(
					'element' => 'overlay_idle',
					'value' => array('meta_centered', 'meta_aligned', 'meta_middle')
				),
				"group" => esc_html__('Overlay idle', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Item hover overlay', 'core-extension'),
				"param_name" => "overlay_hover",
				"value" => array(
					esc_html__('Empty', 'core-extension') => "empty",
					esc_html__('Color overlay', 'core-extension') => "color",
					esc_html__('Color overlay with icon', 'core-extension') => "icon",
					esc_html__('Meta centered', 'core-extension') => "meta_centered",
					esc_html__('Meta middle', 'core-extension') => "meta_middle",
					esc_html__('Meta middle inside', 'core-extension') => "meta_middle_inside",
					esc_html__('Meta with border', 'core-extension') => "meta_border",
					esc_html__('Meta boxed', 'core-extension') => "meta_boxed",
					esc_html__('Meta aligned', 'core-extension') => "meta_aligned",
					esc_html__('Action buttons', 'core-extension') => "buttons",
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed')
				),
				"group" => esc_html__('Overlay hover', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Item hover overlay color', 'core-extension'),
				"param_name" => "overlay_color_hover",
				'description' => esc_html__( 'Leave empty to use default overlay color.', 'core-extension' ),
				'dependency' => array(
					'element' => 'overlay_hover',
					'value' => array('color', 'icon', 'meta_middle', 'meta_middle_inside', 'meta_boxed', 'meta_border', 'buttons')
				),
				"group" => esc_html__('Overlay hover', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Action on click', 'core-extension'),
				"param_name" => "click_action",
				"value" => array(
					esc_html__('Nothing', 'core-extension') => "",
					esc_html__('Link to item page', 'core-extension') => "link",
					esc_html__('Open whole grid gallery in lightbox', 'core-extension') => "gallery_all",
					esc_html__('Open item gallery in lightbox', 'core-extension') => "gallery_item",
					//					esc_html__('Quick item preview in lightbox', 'core-extension') => "preview",
				),
				'save_always' => true,
				'std' => 'link',
				'dependency' => array(
					'element' => 'overlay_hover',
					'value' => array('empty', 'color', 'icon', 'meta_centered', 'meta_middle', 'meta_aligned', 'meta_middle_inside', 'meta_boxed', 'meta_border')
				),
				"group" => esc_html__('Overlay hover', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Primary meta info', 'core-extension'),
				"param_name" => "portfolio_content_primary_hover",
				"value" => wtbx_vc_scape_grid_meta(),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'overlay_hover',
					'value' => array('meta_centered', 'meta_aligned', 'meta_middle', 'meta_middle_inside', 'meta_boxed', 'meta_border')
				),
				"group" => esc_html__('Overlay hover', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Secondary meta info', 'core-extension'),
				"param_name" => "portfolio_content_secondary_hover",
				"value" => wtbx_vc_scape_grid_meta(),
				'save_always' => true,
				'std' => 'categories',
				'dependency' => array(
					'element' => 'overlay_hover',
					'value' => array('meta_centered', 'meta_aligned', 'meta_middle', 'meta_middle_inside', 'meta_boxed', 'meta_border')
				),
				"group" => esc_html__('Overlay hover', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Action buttons', 'core-extension'),
				"param_name" => "action_buttons",
				"value" => array(
					esc_html__('Link to item page', 'core-extension') => "link",
					esc_html__('Preview', 'core-extension') => "preview",
					esc_html__('Link to item page and Preview', 'core-extension') => "link,preview",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'overlay_hover',
					'value' => array('buttons')
				),
				"group" => esc_html__('Overlay hover', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Item overlay content', 'core-extension'),
				"param_name" => "overlay_content_separate",
				"value" => array(
					esc_html__('Empty', 'core-extension') => "",
					esc_html__('Icon', 'core-extension') => "icon"
				),
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles')
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Action on click', 'core-extension'),
				"param_name" => "click_action_separate",
				"value" => array(
					esc_html__('Link to item page', 'core-extension') => "link",
					esc_html__('Open whole grid gallery in lightbox', 'core-extension') => "gallery_all",
					esc_html__('Open item gallery in lightbox', 'core-extension') => "gallery_item",
					//					esc_html__('Quick item preview in lightbox', 'core-extension') => "preview",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles')
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Item overlay behaviour', 'core-extension'),
				"param_name" => "overlay_trigger",
				"value" => array(
					esc_html__('Appear on hover', 'core-extension') => "overlay_appear",
					esc_html__('Disappear on hover', 'core-extension') => "overlay_disappear"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles')
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Item overlay color', 'core-extension'),
				"param_name" => "overlay_color_separate",
				'description' => esc_html__( 'Leave empty to use default overlay color.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles')
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Primary meta info', 'core-extension'),
				"param_name" => "portfolio_content_primary_separate",
				"value" => wtbx_vc_scape_grid_meta(),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles', 'overlap', 'panels', 'slider')
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Secondary meta info', 'core-extension'),
				"param_name" => "portfolio_content_secondary_separate",
				"value" => wtbx_vc_scape_grid_meta(),
				'save_always' => true,
				'std' => 'categories',
				'dependency' => array(
					'element' => 'style',
					'value' => array('square', 'tiles', 'overlap', 'panels', 'slider')
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Excerpt length', 'core-extension' ),
				"param_name" => "excerpt_length",
				"value" => "10",
				'dependency' => array(
					'element' => 'style',
					'value' => array('overlap', 'panels', 'slider')
				),
				'save_always' => true,
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Meta alignment', 'core-extension'),
				"param_name" => "meta_alignment",
				"value" => array(
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Center', 'core-extension') => "center",
					esc_html__('Right', 'core-extension') => "right"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => 'square'
				),
				"group" => esc_html__('Overlay &amp; Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Primary meta info in lightbox', 'core-extension'),
				"param_name" => "portfolio_content_primary_lightbox",
				"value" => wtbx_vc_scape_grid_meta(false),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'click_action',
					'value' => array('gallery_all', 'gallery_item')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Secondary meta info in lightbox', 'core-extension'),
				"param_name" => "portfolio_content_secondary_lightbox",
				"value" => wtbx_vc_scape_grid_meta(false),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'click_action',
					'value' => array('gallery_all', 'gallery_item')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Preview action', 'core-extension'),
				"param_name" => "action_button_preview",
				"value" => array(
					esc_html__('Display whole grid gallery in lightbox', 'core-extension') => "gallery_all",
					esc_html__('Display item gallery in lightbox', 'core-extension') => "gallery_item",
				),
				'dependency' => array(
					'element' => 'action_buttons',
					'value' => array('preview', 'link,preview')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Primary meta info in lightbox', 'core-extension'),
				"param_name" => "portfolio_content_primary_lightbox_preview",
				"value" => wtbx_vc_scape_grid_meta(false),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'action_buttons',
					'value' => array('preview', 'link,preview')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Secondary meta info in lightbox', 'core-extension'),
				"param_name" => "portfolio_content_secondary_lightbox_preview",
				"value" => wtbx_vc_scape_grid_meta(false),
				'save_always' => true,
				'std' => 'categories',
				'dependency' => array(
					'element' => 'action_buttons',
					'value' => array('preview', 'link,preview')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Primary meta info in lightbox', 'core-extension'),
				"param_name" => "portfolio_content_primary_lightbox_separate",
				"value" => wtbx_vc_scape_grid_meta(false),
				'save_always' => true,
				'std' => 'title',
				'dependency' => array(
					'element' => 'click_action_separate',
					'value' => array('gallery_all', 'gallery_item')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Secondary meta info in lightbox', 'core-extension'),
				"param_name" => "portfolio_content_secondary_lightbox_separate",
				"value" => wtbx_vc_scape_grid_meta(false),
				'save_always' => true,
				'std' => 'categories',
				'dependency' => array(
					'element' => 'click_action_separate',
					'value' => array('gallery_all', 'gallery_item')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Share buttons in lightbox', 'core-extension'),
				"param_name" => "lightbox_share",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Share portfolio item page', 'core-extension') => "link",
//					esc_html__('Share media', 'core-extension') => "media",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'click_action',
					'value' => array('gallery_all', 'gallery_item')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Share buttons in lightbox', 'core-extension'),
				"param_name" => "lightbox_share_separate",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Share portfolio item page', 'core-extension') => "link",
//					esc_html__('Share media', 'core-extension') => "media",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'click_action_separate',
					'value' => array('gallery_all', 'gallery_item')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Share buttons in lightbox', 'core-extension'),
				"param_name" => "lightbox_share_preview",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Share portfolio item page', 'core-extension') => "link",
					esc_html__('Share media', 'core-extension') => "media",
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'action_buttons',
					'value' => array('preview', 'link,preview')
				),
				"group" => esc_html__('Lightbox', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Query', 'core-extension'),
				"param_name" => "query",
				"value" => array(
					esc_html__('Use settings', 'core-extension') => "settings",
					esc_html__('Global query', 'core-extension') => "global",
					esc_html__('Custom query', 'core-extension') => "custom",
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Limit items to specific categories', 'core-extension' ),
				'param_name' => 'limit',
				'description' => esc_html__( 'Check if you only want to display posts of specific categories.', 'core-extension' ),
				'value' => array( esc_html__( 'Yes', 'core-extension' ) => 'yes' ),
				'dependency' => array(
					'element' => 'query',
					'value' => 'settings'
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Categories to display', 'core-extension'),
				"param_name" => "categories",
				'value' => wtbx_vc_get_terms('portfolio_category'),
				'dependency' => array(
					'element' => 'limit',
					'not_empty' => true
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Custom query', 'core-extension' ),
				"param_name" => "custom_wp_query",
				"value" => "",
				"description" => esc_html__( 'Write custom query', 'core-extension' ),
				'dependency' => array(
					'element' => 'query',
					'value' => 'custom'
				),
				"group" => esc_html__('Query', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter', 'core-extension'),
				"param_name" => "filter",
				"value" => array(
					esc_html__('No filter', 'core-extension') => "",
					esc_html__('Filter - minimalistic', 'core-extension') => "minimal",
					esc_html__('Filter - slider', 'core-extension') => "slider",
					esc_html__('Filter - multichoice', 'core-extension') => "multi",
					esc_html__('Filter - sidebar', 'core-extension') => "sidebar"
				),
				"group" => esc_html__('Filter', 'core-extension'),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'square', 'tiles')
				),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter alignment', 'core-extension'),
				"param_name" => "filter_align",
				"value" => array(
					esc_html__('Center', 'core-extension') => "center",
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right",
				),
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter buttons layout', 'core-extension'),
				"description" => esc_html__('Only works with left or right aligned filter', 'core-extension'),
				"param_name" => "filter_layout",
				"value" => array(
					esc_html__('Together', 'core-extension') => "",
					esc_html__('Separated', 'core-extension') => "-separated",
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => 'minimal'
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Multichoice filter operator', 'core-extension'),
				"param_name" => "filter_operator",
				"value" => array(
					esc_html__('OR', 'core-extension') => "or",
					esc_html__('AND', 'core-extension') => "and"
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('multi')
				),
				'save_always' => true,
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter updates hash', 'core-extension'),
				"description" => esc_html__( 'URL hash will be updated when the filter is used. Allows to create links to filtered grids.', 'core-extension' ),
				"param_name" => "filter_hash",
				"value" => array(
					esc_html__('No', 'core-extension') => "",
					esc_html__('Yes', 'core-extension') => "1",
				),
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__('Default category to display', 'core-extension'),
				"param_name" => "defaults",
				'value' => wtbx_vc_get_terms('portfolio_category'),
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Filter background color', 'core-extension'),
				"param_name" => "filter_bg_color",
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter skin', 'core-extension'),
				"param_name" => "filter_skin",
				"value" => array(
					esc_html__('Light', 'core-extension') => "light",
					esc_html__('Dark', 'core-extension') => "dark"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Filter color scheme', 'core-extension'),
				"param_name" => "filter_scheme",
				"value" => array(
					esc_html__('Default', 'core-extension') => "default",
					esc_html__('Colorful', 'core-extension') => "colorful"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'filter',
					'not_empty' => true
				),
				"group" => esc_html__('Filter', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Number of items per page', 'core-extension' ),
				"param_name" => "perpage",
				"value" => "",
				"description" => esc_html__( 'Leave empty to display all items', 'core-extension' ),
				'dependency' => array(
					'element' => 'query',
					'value' => array('settings')
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Navigation', 'core-extension'),
				"param_name" => "navigation",
				"value" => array(
					esc_html__('Disable', 'core-extension') => "",
					esc_html__('Pagination', 'core-extension') => "1",
					esc_html__('Lazy loading', 'core-extension') => "2"
				),
				"description" => esc_html__( 'Pagination only works if "Global query" is chosen.', 'core-extension' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed', 'square', 'tiles', 'overlap')
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Pagination skin', 'core-extension'),
				"param_name" => "nav_skin",
				"value" => array(
					esc_html__('Light', 'core-extension') => "light",
					esc_html__('Dark', 'core-extension') => "dark"
				),
				'save_always' => true,
				'dependency' => array(
					'element' => 'navigation',
					'value' => array('1')
				),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('"Load more" button', 'core-extension'),
				"param_name" => "loadmore",
				"value" => array(
					esc_html__('Never', 'core-extension') => "",
					esc_html__('1', 'core-extension') => 1,
					esc_html__('2', 'core-extension') => 2,
					esc_html__('3', 'core-extension') => 3,
					esc_html__('4', 'core-extension') => 4,
					esc_html__('5', 'core-extension') => 5,
					esc_html__('6', 'core-extension') => 6,
					esc_html__('7', 'core-extension') => 7,
					esc_html__('8', 'core-extension') => 8,
					esc_html__('9', 'core-extension') => 9,
					esc_html__('10', 'core-extension') => 10
				),
				'dependency' => array(
					'element' => 'navigation',
					'value' => array('2')
				),
				"description" => wp_kses_post( __( 'Show <strong>"Load More"</strong> button after this number of item batches loaded or choose to never show it.', 'core-extension' )),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Number of batches to load', 'core-extension' ),
				"param_name" => "post_limit",
				"value" => "",
				'dependency' => array(
					'element' => 'navigation',
					'value' => array('2')
				),
				"description" => esc_html__( 'How many times to load older items. Leave empty to load all items available.', 'core-extension' ),
				"group" => esc_html__('Navigation', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Primary meta font style', 'core-extension'),
				"param_name" => "primary_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Secondary meta font style', 'core-extension'),
				"param_name" => "secondary_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Meta text color', 'core-extension'),
				"param_name" => "meta_color",
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro', 'boxed')
				),
				"group" => esc_html__('Typography', 'core-extension')
			),
			$extra_class,
		)
	) );

	// Image grid
	vc_map( array(
		"name"		=> esc_html__('Image Grid', 'core-extension'),
		"base"		=> "vc_scape_image_grid",
		"icon"		=> "icon-wpb-vc_image_grid",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Responsive image gallery grid.', 'core-extension'),
		"params" => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__( 'Select images from media library.', 'core-extension' ),
				"group" => esc_html__('Images', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Image aspect ratio', 'core-extension' ),
				"param_name" => "aspect_ratio",
				"value" => "",
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'boxed')
				),
				"description" => wp_kses_post( __( '<strong>Width:height</strong> aspect ratio of images in the grid. Leave blank for not forcing aspect ratio.</br>Example: <code>16:10</code>', 'core-extension' )),
				"group" => esc_html__('Images', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Grid type', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Masonry', 'core-extension') => "masonry",
					esc_html__('Metro', 'core-extension') => "metro",
					esc_html__('Boxed', 'core-extension') => "boxed"
				),
				'save_always' => true,
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__( 'Metro grid layout', 'core-extension' ),
				"param_name" => "metro_layout",
				"value" => array(
					esc_html__('1 Column', 'core-extension') => "columns_1",
					esc_html__('2 Columns', 'core-extension') => "columns_2",
					esc_html__('3 Columns', 'core-extension') => "columns_3",
					esc_html__('4 Columns', 'core-extension') => "columns_4",
					esc_html__('5 Columns', 'core-extension') => "columns_5",
					esc_html__('6 Columns', 'core-extension') => "columns_6",
					esc_html__('7 Columns', 'core-extension') => "columns_7",
					esc_html__('8 Columns', 'core-extension') => "columns_8",
					esc_html__('Layout 1 (repeated each 12 items)', 'core-extension') => "layout_1",
					esc_html__('Layout 2 (repeated each 12 items)', 'core-extension') => "layout_2",
					esc_html__('Layout 3 (repeated each 12 items)', 'core-extension') => "layout_3",
					esc_html__('Layout 4 (repeated each 10 items)', 'core-extension') => "layout_4",
					esc_html__('Layout 5 (repeated each 10 items)', 'core-extension') => "layout_5",
					esc_html__('Layout 6 (repeated each 10 items)', 'core-extension') => "layout_6",
					esc_html__('Layout 7 (repeated each 4 or 8 items)', 'core-extension') => "layout_7",
					esc_html__('Layout 8 (repeated each 7 or 14 items)', 'core-extension') => "layout_8",
				),
				'std' => 'columns_4',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => 'metro'
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Show this number of items on small screens', 'core-extension' ),
				"description" => esc_html__( 'Leave empty to disable responsiveness', 'core-extension' ),
				"param_name" => "limit",
				"value" => "",
				'dependency' => array(
					'element' => 'metro_layout',
					'value' => array('layout_1', 'layout_2', 'layout_3', 'layout_4', 'layout_5', 'layout_6', 'layout_7', 'layout_8')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Number of columns', 'core-extension'),
				"param_name" => "columns",
				"value" => array(
					esc_html__('1', 'core-extension') => "1",
					esc_html__('2', 'core-extension') => "2",
					esc_html__('3', 'core-extension') => "3",
					esc_html__('4', 'core-extension') => "4",
					esc_html__('5', 'core-extension') => "5",
					esc_html__('6', 'core-extension') => "6",
					esc_html__('7', 'core-extension') => "7",
					esc_html__('8', 'core-extension') => "8"
				),
				'std' => '4',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'boxed')
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Action on click', 'core-extension'),
				"param_name" => "click_action",
				"value" => array(
					esc_html__('No action', 'core-extension') => "",
					esc_html__('Open grid gallery in lightbox', 'core-extension') => "gallery_popup"
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( 'Grid gutter size', 'core-extension' ),
				"param_name" => "gutter",
				"value" => "5",
				'dependency' => array(
					'element' => 'style',
					'value' => array('masonry', 'metro')
				),
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Item overlay behaviour', 'core-extension'),
				"param_name" => "overlay_trigger",
				"value" => array(
					esc_html__('No overlay', 'core-extension') => "",
					esc_html__('Appear on hover', 'core-extension') => "overlay_appear",
					esc_html__('Disappear on hover', 'core-extension') => "overlay_disappear"
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Item overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'description' => esc_html__( 'Will only be used if the grid style allows colored overlay. Leave empty to use default overlay color.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Item overlay content', 'core-extension'),
				"param_name" => "overlay_content",
				"value" => array(
					esc_html__('Empty', 'core-extension') => "",
					esc_html__('Icon', 'core-extension') => "icon",
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__( 'Image border radius', 'core-extension' ),
				"param_name" => "border",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				"description" => esc_html__( 'Value in pixels.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Item appearance animation', 'core-extension' ),
				'param_name' => 'animation_style',
				'value' => wtbx_vc_grid_animations(),
				'save_always' => true,
				'description' => esc_html__( 'Will only be used with lazy image loading.', 'core-extension' ),
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Disable sequential appearance animation', 'core-extension'),
				"param_name" => "disable_sequential",
				"value" => array(
					esc_html__('No', 'core-extension') => "",
					esc_html__('Yes', 'core-extension') => "1"
				),
				"group" => esc_html__('Design', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
		),
		"js_view" => 'VcImageCarouselView'
	) );

	// Video button
	vc_map( array(
		"name"		=> esc_html__('Video button', 'core-extension'),
		"base"		=> "vc_video_button",
		"icon"		=> "icon-wpb-vc_video_button",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Button with video popup', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
					esc_html__('Style 4', 'core-extension') => "style_4",
					esc_html__('Style 5', 'core-extension') => "style_5",
					esc_html__('Style 6', 'core-extension') => "style_6",

				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Thumbnail image', 'core-extension'),
				"param_name" => "thumbnail",
				"dependency" => array(
					'element' => "style",
					'value' => 'style_4'
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'description' => esc_html__( 'Choose the element color skin', 'core-extension' ),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				"dependency" => array(
					'element' => "style",
					'value' => array('style_1', 'style_5', 'style_6')
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Accent color', 'core-extension'),
				"param_name" => "accent_color_solid",
				"dependency" => array(
					'element' => "style",
					'value' => array('style_2', 'style_3', 'style_4')
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "center",
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right"
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Title', 'core-extension'),
				"param_name" => "heading",
				"value" => esc_html__('Watch', 'core-extension'),
				'save_always' => true,
				"admin_label" => true,
				"group" => esc_html__('Text', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Subtitle', 'core-extension'),
				"param_name" => "subheading",
				"value" => esc_html__('Story video', 'core-extension'),
				'save_always' => true,
				"admin_label" => true,
				"dependency" => array(
					'element' => "style",
					'value' => array('style_2', 'style_3', 'style_4')
				),
				"group" => esc_html__('Text', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Video type', 'core-extension'),
				"param_name" => "video_type",
				"value" => array(
					esc_html__('YouTube', 'core-extension') => "youtube",
					esc_html__('Vimeo', 'core-extension') => "vimeo",
					esc_html__('Selfhosted video', 'core-extension') => "selfhosted_video"
				),
				'save_always' => true,
				"group" => esc_html__('Video', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('YouTube video ID', 'core-extension'),
				"param_name" => "youtube",
				"dependency" => array(
					'element' => "video_type",
					'value' => 'youtube'
				),
				"group" => esc_html__('Video', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Vimeo video ID', 'core-extension'),
				"param_name" => "vimeo",
				"dependency" => array(
					'element' => "video_type",
					'value' => 'vimeo'
				),
				"group" => esc_html__('Video', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Video poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'dependency' => array(
					'element' => 'video_type',
					'value' => array('youtube', 'vimeo'),
				),
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Video', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Selfhosted video url', 'core-extension'),
				"param_name" => "selfhosted_video",
				"value" => '',
				'description' => esc_html__( 'Copy audio file url from Media and paste here.', 'core-extension' ),
				"group" => esc_html__('Video', 'core-extension'),
				'dependency' => array(
					'element' => 'video_type',
					'value' => 'selfhosted_video'
				),
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );

	// Countdown
	vc_map( array(
		"name"		=> esc_html__('Countdown', 'core-extension'),
		"base"		=> "vc_countdown",
		"icon"		=> "icon-wpb-vc_countdown",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Animated time left until an event', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
					esc_html__('Style 4', 'core-extension') => "style_4"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Days display', 'core-extension'),
				"param_name" => "days_display",
				"value" => array(
					esc_html__('Months and days', 'core-extension') => "months_days",
					esc_html__('Weeks and days', 'core-extension') => "weeks_days",
					esc_html__('Days', 'core-extension') => "days",
					//					esc_html__('None', 'core-extension') => "none"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Time display', 'core-extension'),
				"param_name" => "time_display",
				"value" => array(
					esc_html__('Hours, minutes, seconds', 'core-extension') => "hours_minutes_seconds",
					esc_html__('Hours, minutes', 'core-extension') => "hours_minutes",
					esc_html__('Hours only', 'core-extension') => "hours",
					esc_html__('None', 'core-extension') => "none"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Separate days and time', 'core-extension'),
				"param_name" => "separate",
				"value" => array(
					esc_html__('Do not Separate', 'core-extension') => "",
					esc_html__('Separate', 'core-extension') => "separate"
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "center",
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right"
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Year (required)', 'core-extension'),
				"param_name" => "year",
				"value" => esc_html__('2030', 'core-extension'),
				"group" => esc_html__('Event time', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Month number (required)', 'core-extension'),
				"param_name" => "month",
				"value" => esc_html__('11', 'core-extension'),
				"group" => esc_html__('Event time', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Date (required)', 'core-extension'),
				"param_name" => "date",
				"value" => esc_html__('16', 'core-extension'),
				"group" => esc_html__('Event time', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Hours (optional)', 'core-extension'),
				"param_name" => "hour",
				"value" => esc_html__('12', 'core-extension'),
				"group" => esc_html__('Event time', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Minutes (optional)', 'core-extension'),
				"param_name" => "minute",
				"group" => esc_html__('Event time', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Seconds (optional)', 'core-extension'),
				"param_name" => "second",
				"group" => esc_html__('Event time', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Months label', 'core-extension'),
				"param_name" => "months_label",
				"value" => 'months',
				"group" => esc_html__('Labels', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Weeks label', 'core-extension'),
				"param_name" => "weeks_label",
				"value" => 'weeks',
				"group" => esc_html__('Labels', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Days label', 'core-extension'),
				"param_name" => "days_label",
				"value" => 'days',
				"group" => esc_html__('Labels', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Hours label', 'core-extension'),
				"param_name" => "hours_label",
				"value" => 'hours',
				"group" => esc_html__('Labels', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Minutes label', 'core-extension'),
				"param_name" => "minutes_label",
				"value" => 'minutes',
				"group" => esc_html__('Labels', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Seconds label', 'core-extension'),
				"param_name" => "seconds_label",
				"value" => 'seconds',
				"group" => esc_html__('Labels', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Numbers font styles', 'core-extension'),
				"param_name" => "numbers_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Labels font styles', 'core-extension'),
				"param_name" => "labels_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Numbers color', 'core-extension'),
				"param_name" => "numbers_color",
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Labels color', 'core-extension'),
				"param_name" => "labels_color",
				"group" => esc_html__('Colors', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );

	// Counter
	vc_map( array(
		"name"		=> esc_html__('Counter', 'core-extension'),
		"base"		=> "vc_counter",
		"icon"		=> "icon-wpb-vc_counter",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Animated numerical data', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Value you want to begin at', 'core-extension'),
				"param_name" => "from",
				"value" => "0",
				"description" => '',
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Value you want to stop at', 'core-extension'),
				"param_name" => "to",
				"value" => "2000",
				"admin_label" => true,
				"description" => '',
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Duration (in milliseconds)', 'core-extension'),
				"param_name" => "speed",
				"value" => "1000",
				"description" => '',
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Interval (in milliseconds)', 'core-extension'),
				"param_name" => "interval",
				"value" => "10",
				"description" => esc_html__('How often the number should be updated', 'core-extension'),
				"group" => esc_html__('Settings', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Display', 'core-extension'),
				"param_name" => "display",
				"value" => array(esc_html__('Inline', 'core-extension') => "display_inline",
				                 esc_html__('Block', 'core-extension') => "display_block",
				),
				'save_always' => true,
				'std' => 'display_block',
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Alignment', 'core-extension'),
				"param_name" => "align",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "align_center",
					esc_html__('Left', 'core-extension') => "align_left",
					esc_html__('Right', 'core-extension') => "align_right"
				),
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_block',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_styles',
				'heading' => esc_html__( 'Margin', 'core-extension' ),
				'param_name' => 'margin',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'margin',
				'dependency' => array(
					'element'   => 'display',
					'value'     => 'display_inline',
				),
				"group" => esc_html__('Layout', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "color",
				'value' => '',
				"group" => esc_html__('Counter', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Text style', 'core-extension'),
				"param_name" => "typography",
				"value" => '',
				"group" => esc_html__('Counter', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Prefix (optional)', 'core-extension'),
				"param_name" => "prefix",
				"value" => "",
				"description" => wp_kses_post( __('A sign or a word to be put before the counter, e.g. <code>$</code>.', 'core-extension' )),
				"group" => esc_html__('Prefix', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Prefix text color', 'core-extension'),
				"param_name" => "color_prefix",
				'value' => '',
				"group" => esc_html__('Prefix', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Vertical alignment', 'core-extension'),
				"param_name" => "prefix_align",
				"value" => array(
					esc_html__('None', 'core-extension') => "none",
					esc_html__('Top', 'core-extension') => "top",
					esc_html__('Middle', 'core-extension') => "middle",
					esc_html__('Bottom', 'core-extension') => "bottom",
				),
				'save_always' => true,
				'std' => 'none',
				"group" => esc_html__('Prefix', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Prefix text style', 'core-extension'),
				"param_name" => "typography_prefix",
				"value" => '',
				"group" => esc_html__('Prefix', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Suffix (optional)', 'core-extension'),
				"param_name" => "suffix",
				"value" => "",
				"description" => wp_kses_post( __('A sign or a word to be put after the counter, e.g. <code>$</code>.', 'core-extension' )),
				"group" => esc_html__('Suffix', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Suffix text color', 'core-extension'),
				"param_name" => "color_suffix",
				'value' => '',
				"group" => esc_html__('Suffix', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Vertical alignment', 'core-extension'),
				"param_name" => "suffix_align",
				"value" => array(
					esc_html__('None', 'core-extension') => "none",
					esc_html__('Top', 'core-extension') => "top",
					esc_html__('Middle', 'core-extension') => "middle",
					esc_html__('Bottom', 'core-extension') => "bottom",
				),
				'save_always' => true,
				'std' => 'none',
				"group" => esc_html__('Suffix', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Suffix text style', 'core-extension'),
				"param_name" => "typography_suffix",
				"value" => '',
				"group" => esc_html__('Suffix', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)

	) );

	// Social Icons
	vc_map( array(
		"name"		=> esc_html__('Social icons', 'core-extension'),
		"base"		=> "vc_scape_social_icons",
		"icon"		=> "icon-wpb-vc_social_icons",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Social', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Icon links to social profiles', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
					esc_html__('Style 4', 'core-extension') => "style_4",
					esc_html__('Style 5', 'core-extension') => "style_5",
					esc_html__('Style 6', 'core-extension') => "style_6",
					esc_html__('Style 7', 'core-extension') => "style_7"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(
					esc_html__('Inherit', 'core-extension') => "",
					esc_html__('Center', 'core-extension') => "center",
					esc_html__('Left', 'core-extension') => "left",
					esc_html__('Right', 'core-extension') => "right"
				),
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Icon size', 'core-extension'),
				"param_name" => "size",
				"std" => '3',
				'range_from' => '1',
				'range_to' => '10',
				'step' => '1',
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon color type (default state)', 'core-extension'),
				"param_name" => "color_type_default",
				"value" => array(
					esc_html__('Branded', 'core-extension') => "branded",
					esc_html__('Custom', 'core-extension') => "custom"
				),
				'save_always' => true,
				"group" => esc_html__('Colors (idle)', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Icon color (default state)', 'core-extension'),
				"param_name" => "color_default",
				'value' => '',
				"dependency" => array(
					'element' => "color_type_default",
					'value' => 'custom'
				),
				"group" => esc_html__('Colors (idle)', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background color type (default state)', 'core-extension'),
				"param_name" => "bg_type_default",
				"value" => array(
					esc_html__('Branded', 'core-extension') => "branded",
					esc_html__('Custom', 'core-extension') => "custom"
				),
				'save_always' => true,
				"dependency" => array(
					'element' => "style",
					'value' => array('style_3', 'style_4', 'style_5', 'style_7')
				),
				"group" => esc_html__('Colors (idle)', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Background color (default state)', 'core-extension'),
				"param_name" => "bg_default",
				'value' => '',
				"dependency" => array(
					'element' => "bg_type_default",
					'value' => 'custom'
				),
				"group" => esc_html__('Colors (idle)', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon color type (hover state)', 'core-extension'),
				"param_name" => "color_type_hover",
				"value" => array(
					esc_html__('Branded', 'core-extension') => "branded",
					esc_html__('Custom', 'core-extension') => "custom"
				),
				'save_always' => true,
				"group" => esc_html__('Colors (hover)', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Icon color (hover state)', 'core-extension'),
				"param_name" => "color_hover",
				'value' => '',
				"dependency" => array(
					'element' => "color_type_hover",
					'value' => 'custom'
				),
				"group" => esc_html__('Colors (hover)', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Background color type (hover state)', 'core-extension'),
				"param_name" => "bg_type_hover",
				"value" => array(
					esc_html__('Branded', 'core-extension') => "branded",
					esc_html__('Custom', 'core-extension') => "custom"
				),
				'save_always' => true,
				"dependency" => array(
					'element' => "style",
					'value' => array('style_3', 'style_4', 'style_5', 'style_6', 'style_7')
				),
				"group" => esc_html__('Colors (hover)', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Background color (hover state)', 'core-extension'),
				"param_name" => "bg_hover",
				'value' => '',
				"dependency" => array(
					'element' => "bg_type_hover",
					'value' => 'custom'
				),
				"group" => esc_html__('Colors (hover)', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => esc_html__('Social icons to show', 'core-extension'),
				'description' => esc_html__( 'Do not forget to add links to social profiles in Theme Options.', 'core-extension' ),
				"param_name" => "networks",
				"value" => wtbx_vc_social_networks_param(),
				'save_always' => true,
				"group" => esc_html__('Icons', 'core-extension')
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );

	// Message box
	vc_map( array(
		"name"		=> esc_html__('Message box', 'core-extension'),
		"base"		=> "vc_message_box",
		"icon"		=> "icon-wpb-vc_message_box",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Notification box', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Default', 'core-extension')     => "style_default",
					esc_html__('Modern', 'core-extension')      => "style_modern",
					esc_html__('With border', 'core-extension') => "style_border"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Message type', 'core-extension'),
				"param_name" => "type",
				"value" => array(
					esc_html__('Informational', 'core-extension')   => "informational",
					esc_html__('Warning', 'core-extension')         => "warning",
					esc_html__('Success', 'core-extension')         => "success",
					esc_html__('Error', 'core-extension')           => "error"
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border radius', 'core-extension'),
				"param_name" => "radius",
				"std" => '6',
				'range_from' => '0',
				'range_to' => '30',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Message box border radius in <code>px</code>.', 'core-extension' )),
				"group" => esc_html__('Style', 'core-extension'),
				"dependency" => array(
					'element' => "style",
					'value' => array('style_default', 'style_modern')
				),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Icon', 'core-extension'),
				"param_name" => "show_icon",
				"value" => array(
					esc_html__('Display', 'core-extension') => 'yes',
					esc_html__('Hide', 'core-extension') => 'no',
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Dismiss button', 'core-extension'),
				"param_name" => "show_dismiss",
				"value" => array(
					esc_html__('Display', 'core-extension') => 'yes',
					esc_html__('Hide', 'core-extension') => 'no',
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				'type' => 'textarea_html',
				'value' => esc_html__('Heads up! This alert needs your attention, but it\'s not super important.', 'core-extension'),
				"heading" => esc_html__('Message text', 'core-extension'),
				'param_name' => 'content',
				'holder' => 'div',
				"group" => esc_html__('Content', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'icon',
				'save_always' => true,
				"dependency" => array(
					'element' => "show_icon",
					'value' => 'yes'
				),
				"description" => esc_html__('If not chosen, a default icon will be displayed corresponding to the message box type chosen.', 'core-extension'),
				"group" => esc_html__('Icon', 'core-extension'),
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );

	// Banner
	vc_map( array(
		"name"		=> esc_html__('Banner', 'core-extension'),
		"base"		=> "vc_banner",
		"icon"		=> "icon-wpb-vc_banner",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension'), esc_html__('Images', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Advertisement block', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Image hover effect', 'core-extension'),
				"param_name" => "hover",
				"value" => array(
					esc_html__('None', 'core-extension') => "",
					esc_html__('Shift up', 'core-extension') => "shift",
					esc_html__('3D animation', 'core-extension') => "mousemove",
				),
				'save_always' => true,
				"group" => esc_html__('Design', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border radius', 'core-extension'),
				"param_name" => "radius",
				"std" => '8',
				'range_from' => '0',
				'range_to' => '30',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Banner border radius in <code>px</code>.', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'value' => '200',
				"heading" => esc_html__('Min. height', 'core-extension'),
				'param_name' => 'min_height',
				"description" => esc_html__('Minimum height of the content (used to make banners in a row equal height).', 'core-extension'),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_styles_responsive',
				'heading' => esc_html__( 'Padding', 'core-extension' ),
				'param_name' => 'padding',
				'variants' => array(
					'top'       => esc_html__('Top', 'core-extension'),
					'right'     => esc_html__('Right', 'core-extension'),
					'bottom'    => esc_html__('Bottom', 'core-extension'),
					'left'      => esc_html__('Left', 'core-extension'),
				),
				'property' => 'padding',
				"description" => wp_kses_post( __('You can set custom banner inner padding or theme default will be used (<code>30px</code>).', 'core-extension' )),
				"group" => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background image', 'core-extension' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Background', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay",
				"group" => esc_html__('Background', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'value' => esc_html__('Banner title text', 'core-extension'),
				"heading" => esc_html__('Title text', 'core-extension'),
				'param_name' => 'title_text',
				'holder' => 'div',
				"group" => esc_html__('Title', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Title wrapper', 'core-extension'),
				"param_name" => 'title_wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Title', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Title text color', 'core-extension'),
				"param_name" => "title_color",
				"description" => esc_html__('Leave empty to use white color', 'core-extension'),
				"group" => esc_html__('Title', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Title font style', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Title', 'core-extension')
			),
			array(
				'type' => 'textarea',
				'value' => esc_html__('Banner subtitle text', 'core-extension'),
				"heading" => esc_html__('Subtitle text', 'core-extension'),
				'param_name' => 'subtitle_text',
				"group" => esc_html__('Subtitle', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Subtitle wrapper', 'core-extension'),
				"param_name" => 'subtitle_wrapper',
				"value" => array(
					esc_html__('h1', 'core-extension') => "h1",
					esc_html__('h2', 'core-extension') => "h2",
					esc_html__('h3', 'core-extension') => "h3",
					esc_html__('h4', 'core-extension') => "h4",
					esc_html__('h5', 'core-extension') => "h5",
					esc_html__('h6', 'core-extension') => "h6",
					esc_html__('p', 'core-extension') => "p",
					esc_html__('div', 'core-extension') => "div",
					esc_html__('span', 'core-extension') => "span",
				),
				'std' => 'div',
				'save_always' => true,
				"group" => esc_html__('Subtitle', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Subtitle text color', 'core-extension'),
				"param_name" => "subtitle_color",
				"description" => esc_html__('Leave empty to use white color', 'core-extension'),
				"group" => esc_html__('Subtitle', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Subtitle font style', 'core-extension'),
				"param_name" => "subtitle_typography",
				"value" => '',
				"group" => esc_html__('Subtitle', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Text on the button', 'core-extension'),
				"param_name" => "button_text",
				"value" => esc_html__('Text on the button', 'core-extension'),
				"group" => esc_html__('Button', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => esc_html__('URL (Link)', 'core-extension'),
				"param_name" => "link",
				"group" => esc_html__('Button', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );

	// Google Maps
	vc_map( array(
		"name"		=> esc_html__('Styled Google Map', 'core-extension'),
		"base"		=> "vc_scape_google_map",
		"icon"		=> "icon-wpb-vc_google_map",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Google with predefined colors and settings', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Map layout', 'core-extension'),
				"param_name" => "layout",
				"value" => array(
					esc_html__('Default', 'core-extension') => 'default',
					esc_html__('Content block on the left', 'core-extension') => 'content_left',
					esc_html__('Content block on the right', 'core-extension') => 'content_right',
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Relative height', 'core-extension'),
				"param_name" => "height",
				"std" => '0',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Set the height of the the map in percentage of the screen size. Set to <code>0</code> to disable relative height.', 'core-extension' )),
				'dependency' => array(
					'element'   => 'layout',
					'value'     => 'default'
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Min height', 'core-extension'),
				"param_name" => "min_height",
				"value" => '400',
				"description" => esc_html__('Set the minimum height of the map in pixels.', 'core-extension'),
				'dependency' => array(
					'element'   => 'layout',
					'value'     => 'default'
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__('Content block', 'core-extension'),
				"param_name" => "content",
				'dependency' => array(
					'element'   => 'layout',
					'value'     => array('content_left', 'content_right'),
				),
				"group" => esc_html__('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color scheme', 'core-extension'),
				"param_name" => "color_scheme",
				"value" => array(
					esc_html__('Color scheme 1', 'core-extension') => "scheme_1",
					esc_html__('Color scheme 2', 'core-extension') => "scheme_2",
					esc_html__('Color scheme 3', 'core-extension') => "scheme_3",
					esc_html__('Color scheme 4', 'core-extension') => "scheme_4",
					esc_html__('Color scheme 5', 'core-extension') => "scheme_5",
					esc_html__('Color scheme 6', 'core-extension') => "scheme_6",
					esc_html__('Color scheme 7', 'core-extension') => "scheme_7",
					esc_html__('Color scheme 8', 'core-extension') => "scheme_8",
					esc_html__('Color scheme 9', 'core-extension') => "scheme_9",
					esc_html__('Color scheme 10', 'core-extension') => "scheme_10",
					esc_html__('Color scheme 11', 'core-extension') => "scheme_11",
					esc_html__('Color scheme 12', 'core-extension') => "scheme_12",
					esc_html__('Color scheme 13', 'core-extension') => "scheme_13",
					esc_html__('Color scheme 14', 'core-extension') => "scheme_14",
					esc_html__('Color scheme 15', 'core-extension') => "scheme_15",
					esc_html__('Color scheme 16', 'core-extension') => "scheme_16",
					esc_html__('Color scheme 17', 'core-extension') => "scheme_17",
					esc_html__('Color scheme 18', 'core-extension') => "scheme_18",
					esc_html__('Color scheme 19', 'core-extension') => "scheme_19",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Map border radius', 'core-extension' ),
				'param_name' => 'radius',
				"std" => '0',
				'range_from' => '0',
				'range_to' => '50',
				'step' => '1',
				'save_always' => true,
				'description' => esc_html__( 'Enter border radius in pixels.', 'core-extension' ),
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Google API key', 'core-extension' ),
				'param_name' => 'key',
				'value' => '',
				'description' => wp_kses( __( 'This element uses Google Maps JavaScript API which requires the use of an individual API key.
				If this field is left blank, the map will use the key from <strong>Scape Options -> General Settings -> Google API key</strong>.
				It can be obtained for free - please read <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">this</a> for how to get an API key.', 'core-extension' ), 'default'),
				"group" => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Draggable map', 'core-extension'),
				"param_name" => "draggable",
				"value" => array(
					esc_html__('Enable', 'core-extension') => 'true',
					esc_html__('Disable', 'core-extension') => 'false',
				),
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Zoom on scroll', 'core-extension'),
				"param_name" => "scroll_zoom",
				"value" => array(
					esc_html__('Enable', 'core-extension') => 'true',
					esc_html__('Disable', 'core-extension') => 'false',
				),
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Zoom control buttons', 'core-extension'),
				"param_name" => "zoom_control",
				"value" => array(
					esc_html__('Enable', 'core-extension') => 'true',
					esc_html__('Disable', 'core-extension') => 'false',
				),
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Street view control', 'core-extension'),
				"param_name" => "streetview_control",
				"value" => array(
					esc_html__('Enable', 'core-extension') => 'true',
					esc_html__('Disable', 'core-extension') => 'false',
				),
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Map type control', 'core-extension'),
				"param_name" => "map_type_control",
				"value" => array(
					esc_html__('Enable', 'core-extension') => 'true',
					esc_html__('Disable', 'core-extension') => 'false',
				),
				'save_always' => true,
				"group" => esc_html__('Settings', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Map center', 'core-extension'),
				"param_name" => "centering",
				"value" => array(
					esc_html__('Automatic', 'core-extension') => 'auto',
					esc_html__('Manual', 'core-extension') => 'manual',
				),
				'save_always' => true,
				'description' => esc_html__( 'Automatic mode will pan and zoom the map automatically to include all the location markers.', 'core-extension' ),
				"group" => esc_html__('Positioning', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Zoom', 'core-extension'),
				"param_name" => "zoom",
				"std" => '14',
				'range_from' => '1',
				'range_to' => '20',
				'step' => '1',
				'save_always' => true,
				"dependency" => array(
					'element' => "centering",
					'value' => 'manual'
				),
				"group" => esc_html__('Positioning', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'value' => '',
				"heading" => esc_html__('Latitude', 'core-extension'),
				'param_name' => 'lat',
				"dependency" => array(
					'element' => "centering",
					'value' => 'manual'
				),
				"group" => esc_html__('Positioning', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'value' => '',
				"heading" => esc_html__('Longitude', 'core-extension'),
				'param_name' => 'lng',
				"dependency" => array(
					'element' => "centering",
					'value' => 'manual'
				),
				"group" => esc_html__('Positioning', 'core-extension'),
			),
			array(
				"heading" => esc_html__('Locations', 'core-extension'),
				'type' => 'param_group',
                'value' => '',
                'param_name' => 'locations',
				"group" => esc_html__('Locations', 'core-extension'),
                'params' => array(
					array(
						'type' => 'textfield',
						'value' => esc_html__('Times Square, New York', 'core-extension'),
						"heading" => esc_html__('Address', 'core-extension'),
						'param_name' => 'address',
						'admin_label' => true,
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__('Info window', 'core-extension'),
						"param_name" => "infowindow",
						"value" => array(
							esc_html__('Disable', 'core-extension') => '',
							esc_html__('Default', 'core-extension') => 'default',
							esc_html__('Minimal', 'core-extension') => 'minimal',
							esc_html__('Colorful', 'core-extension') => 'colorful',
						),
						'description' => esc_html__( 'Controls whether this marker will have its own info window info window is shown by default.', 'core-extension' ),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__('Info window state', 'core-extension'),
						"param_name" => "state",
						"value" => array(
							esc_html__('Opens on click', 'core-extension') => 'on_click',
							esc_html__('Open by default and opens on click', 'core-extension') => 'active_on_click',
							esc_html__('Always open', 'core-extension') => 'active',
						),
						"dependency" => array(
							'element' => 'infowindow',
							'not_empty' => true
						),
						'description' => esc_html__( 'Only one info window can be open at a time.', 'core-extension' ),
					),
					array(
						'type' => 'textfield',
						'value' => '',
						"heading" => esc_html__('Title', 'core-extension'),
						'param_name' => 'title',
						'admin_label' => true,
						"dependency" => array(
							'element' => 'infowindow',
							'value' => array('default', 'minimal', 'colorful')
						),
					),
					array(
						'type' => 'textarea',
						'value' => '',
						"heading" => esc_html__('Description', 'core-extension'),
						'param_name' => 'description',
						"dependency" => array(
							'element' => 'infowindow',
							'value' => array('default')
						),
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__('Location photo', 'core-extension'),
						"param_name" => "photo",
						'description' => esc_html__( 'Image identifying the location.', 'core-extension' ),
						"dependency" => array(
							'element' => 'infowindow',
							'value' => array('default')
						),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__('Marker', 'core-extension'),
						"param_name" => "marker_style",
						"value" => array(
							esc_html__('Default', 'core-extension') => 'default',
							esc_html__('Simple circle', 'core-extension') => 'circle',
							esc_html__('Circle with border', 'core-extension') => 'circle_border',
							esc_html__('Circle with halo', 'core-extension') => 'circle_halo',
							esc_html__('Pulsating circle', 'core-extension') => 'circle_pulse',
							esc_html__('Pin', 'core-extension') => 'pin',
							esc_html__('Custom image', 'core-extension') => 'image',
						),
						'description' => esc_html__( 'Only one info window can be open at a time.', 'core-extension' ),
					),
					array(
						"type" => "wtbx_vc_colorpicker_solid",
						"heading" => esc_html__('Marker color', 'core-extension'),
						"param_name" => "marker_color",
						"dependency" => array(
							'element' => 'marker_style',
							'value' => array('circle', 'circle_border', 'circle_halo', 'circle_pulse', 'pin')
						),
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__('Marker image', 'core-extension'),
						"param_name" => "marker",
						"dependency" => array(
							'element' => 'marker_style',
							'value' => 'image'
						),
						'description' => esc_html__( 'Select custom marker image. Otherwise a default marker will be used.', 'core-extension' ),
					),
				)
            ),
			$extra_class,
			array(
				"type" => "attach_image",
				"heading" => esc_html__('Poster', 'core-extension'),
				"param_name" => "poster",
				"value" => "",
				'description' => esc_html__( 'Poster will be shown if GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
				"group" => esc_html__('Misc', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );

	// Steps Horizontal
	vc_map( array(
		"name"		=> esc_html__('Horizontal Steps', 'core-extension'),
		"base"		=> "vc_steps_horizontal",
		"icon"		=> "icon-wpb-vc_steps_horizontal",
//		'show_settings_on_create' => true,
//		'is_container' => true,
//		'as_parent' => array(
//			'only' => 'vc_steps_item',
//		),
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Horizontally aligned steps', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
					esc_html__('Style 4', 'core-extension') => "style_4",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Step width', 'core-extension'),
				"param_name" => "width",
				"value" => array(
					esc_html__('1/2', 'core-extension') => "2",
					esc_html__('1/3', 'core-extension') => "3",
					esc_html__('1/4', 'core-extension') => "4",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Stack into one column for the following screen size:', 'core-extension'),
				"param_name" => 'mobile',
				"value" => array(
					esc_html__('None', 'core-extension') => '',
					esc_html__('Tablet Landscape and below', 'core-extension') => 'tablet_landscape',
					esc_html__('Tablet Portrait and below', 'core-extension') => 'tablet_portrait',
					esc_html__('Mobile Landscape and below', 'core-extension') => 'mobile_landscape',
					esc_html__('Mobile Portrait and below', 'core-extension') => 'mobile_portrait',
				),
				'std' => 'mobile_landscape',
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Bullet color', 'core-extension'),
				"param_name" => "bullet_color",
				"description" => esc_html__('Leave empty to use default text color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Bullet container color', 'core-extension'),
				"param_name" => "bullet_cont_color",
				"description" => esc_html__('Leave empty to use accent color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Connector color', 'core-extension'),
				"param_name" => "connector_color",
				"description" => esc_html__('Leave empty to use default border color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Title text color', 'core-extension'),
				"param_name" => "title_color",
				"description" => esc_html__('Leave empty to use default heading color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Subtitle text color', 'core-extension'),
				"param_name" => "subtitle_color",
				"description" => esc_html__('Leave empty to use default heading color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Description text color', 'core-extension'),
				"param_name" => "descr_color",
				"description" => esc_html__('Leave empty to use default text color', 'core-extension'),
				"group" => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Title font style', 'core-extension'),
				"param_name" => "title_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Subtitle font style', 'core-extension'),
				"param_name" => "subtitle_typography",
				"value" => '',
				"group" => esc_html__('Typography', 'core-extension')
			),
			array(
				"heading" => esc_html__('Steps', 'core-extension'),
				'type' => 'param_group',
				'value' => '',
				'param_name' => 'steps',
				"group" => esc_html__('Steps', 'core-extension'),
				'params' => array(
					array(
						"type" => "textfield",
						"heading" => esc_html__('Title', 'core-extension'),
						"param_name" => "title",
						"value" => esc_html__('Step title', 'core-extension'),
						'admin_label' => true,
						'save_always' => true,
						"group" => esc_html__('Title', 'core-extension')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__('Subtitle', 'core-extension'),
						"param_name" => "subtitle",
						"value" => esc_html__('Step subtitle', 'core-extension'),
						'save_always' => true,
						"group" => esc_html__('Subtitle', 'core-extension')
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__('Step description', 'core-extension'),
						"param_name" => "description",
						'save_always' => true,
						"value" => esc_html__('This is random text, change it to your own in shortcode settings.', 'core-extension'),
						"group" => esc_html__('Description', 'core-extension')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__('Bullet type', 'core-extension'),
						"param_name" => "bullet_type",
						"value" => array(esc_html__('Icon', 'core-extension') => "icon",
						                 esc_html__('Number', 'core-extension') => "number",
						                 esc_html__('Abbreviation', 'core-extension') => "abbr"
						),
						'save_always' => true,
						"group" => esc_html__('Bullet', 'core-extension')
					),
					array(
						'type' => 'wtbx_vc_icon_font',
						'heading' => esc_html__( 'Select an icon', 'core-extension' ),
						'param_name' => 'icon',
						'dependency' => array(
							'element' => 'bullet_type',
							'value' => array('icon')
						),
						'save_always' => true,
						"group" => esc_html__('Bullet', 'core-extension'),
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__('Number', 'core-extension'),
						"param_name" => "number",
						"value" => '01',
						'dependency' => array(
							'element' => 'bullet_type',
							'value' => 'number'
						),
						'save_always' => true,
						"group" => esc_html__('Bullet', 'core-extension')
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__('Abbreviation', 'core-extension'),
						'description' => esc_html__( 'Only two characters will be displayed.', 'core-extension' ),
						"param_name" => "abbr",
						"value" => 'Ab',
						'dependency' => array(
							'element' => 'bullet_type',
							'value' => 'abbr'
						),
						'save_always' => true,
						"group" => esc_html__('Bullet', 'core-extension')
					),
					$extra_class,
				)
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
//		'custom_markup' => '
//<div class="vc_tta-container" data-vc-action="collapseAll">
//	<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
//	   <div class="vc_tta-panels vc_clearfix {{container-class}}">
//	      {{ content }}
//	      <div class="vc_tta-panel vc_tta-section-append">
//	         <div class="vc_tta-panel-heading">
//	            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
//	               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
//	                   <span class="vc_tta-title-text">' . esc_html__( 'Add Step', 'core-extension' ) . '</span>
//	                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
//					</a>
//	            </h4>
//	         </div>
//	      </div>
//	   </div>
//	</div>
//</div>',
//		'default_content' => '[vc_steps_item title="' . sprintf( '%s %d', esc_html__( 'Step', 'core-extension' ), 1 ) . '"][/vc_steps_item][vc_steps_item title="' . sprintf( '%s %d', esc_html__( 'Step', 'core-extension' ), 2 ) . '"][/vc_steps_item]',
//		'js_view' => 'VcStepsView'
	) );

	// Step
	vc_map( array(
		"name"		=> esc_html__('Step', 'core-extension'),
		"base"		=> "vc_steps_item",
		"icon"		=> "icon-wpb-vc_modal_window",
		'show_settings_on_create' => true,
		'as_child' => array(
			'only' => 'vc_steps_horizontal',
		),
//		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Horizontally aligned steps', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Bullet type', 'core-extension'),
				"param_name" => "bullet_type",
				"value" => array(esc_html__('Icon', 'core-extension') => "icon",
				                 esc_html__('Number', 'core-extension') => "number",
				                 esc_html__('Abbreviation', 'core-extension') => "abbr"
				),
				'save_always' => true,
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => array('icon')
				),
				'save_always' => true,
				"group" => esc_html__('Bullet', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Number', 'core-extension'),
				"param_name" => "number",
				"value" => '01',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => 'number'
				),
				'save_always' => true,
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Abbreviation', 'core-extension'),
				'description' => esc_html__( 'Only two characters will be displayed.', 'core-extension' ),
				"param_name" => "abbr",
				"value" => 'Ab',
				'dependency' => array(
					'element' => 'bullet_type',
					'value' => 'abbr'
				),
				'save_always' => true,
				"group" => esc_html__('Bullet', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Title', 'core-extension'),
				"param_name" => "title",
				"value" => esc_html__('Step title', 'core-extension'),
				'save_always' => true,
				"group" => esc_html__('Title', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Heading font style', 'core-extension'),
				"param_name" => "heading_typography",
				"value" => '',
				"group" => esc_html__('Title', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Subtitle', 'core-extension'),
				"param_name" => "subtitle",
				"value" => esc_html__('Step subtitle', 'core-extension'),
				'save_always' => true,
				"group" => esc_html__('Subtitle', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_typography",
				"heading" => esc_html__('Heading font style', 'core-extension'),
				"param_name" => "heading_typography",
				"value" => '',
				"group" => esc_html__('Subtitle', 'core-extension')
			),
			array(
				"type" => "textarea",
				"heading" => esc_html__('Step description', 'core-extension'),
				"param_name" => "description",
				'save_always' => true,
				"value" => esc_html__('This is random text, change it for your own in shortcode settings.', 'core-extension'),
				"group" => esc_html__('Description', 'core-extension')
			),
			$extra_class,
		),
		'js_view' => 'VcStepsItemView',
		'custom_markup' => '
		<div class="vc_tta-panel-heading">
		    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
		    <div class="vc_controls">
				<div class="vc_controls-tc vc_control-container">
					<a class="vc_control-btn vc_element-name vc_element-move">
						<span class="vc_btn-content" title="Drag to move Step">Step</span>
					</a>
					<a class="vc_control-btn vc_control-btn-edit" href="#" title="Edit Step"><span class="vc_btn-content"><span class="icon"></span></span></a>
					<a class="vc_control-btn vc_control-btn-clone" href="#" title="Clone Step"><span class="vc_btn-content"><span class="icon"></span></span></a>
					<a class="vc_control-btn vc_control-btn-delete" href="#" title="Delete Step"><span class="vc_btn-content"><span class="icon"></span></span></a>
				</div>
			</div>
		</div>',
		'default_content' => '',
	) );

	// Video Player
	vc_map( array(
		"name"		=> esc_html__('Video player', 'core-extension'),
		"base"		=> "vc_scape_video_player",
		"icon"		=> "icon-wpb-vc_video_player",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"weight" => 1,
		"description" => esc_html__('Video player', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Media frame with poster', 'core-extension') => "default",
					esc_html__('Poster with media in lightbox', 'core-extension') => "lightbox",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Play button skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')           => "light",
					esc_html__('Light colorful', 'core-extension')  => "light_color",
					esc_html__('Dark', 'core-extension')            => "dark",
					esc_html__('Dark colorful', 'core-extension')   => "dark_color",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Play button color', 'core-extension'),
				"param_name" => "button_color",
				"group" => esc_html__('Style', 'core-extension'),
				"dependency" => array(
					'element' => "skin",
					'value' => array('light_color', 'dark_color')
				),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Hover animation', 'core-extension'),
				"param_name" => "hover",
				"value" => array(
					esc_html__('None', 'core-extension')            => "",
					esc_html__('Shift up', 'core-extension')        => "up",
					esc_html__('Scale down', 'core-extension')      => "scale",
					esc_html__('Rotate left', 'core-extension')     => "left",
					esc_html__('Rotate right', 'core-extension')    => "right",
				),
				'save_always' => true,
				"group" => esc_html__('Style', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_slider",
				"heading" => esc_html__('Border radius', 'core-extension'),
				"param_name" => "radius",
				"std" => '8',
				'range_from' => '0',
				'range_to' => '30',
				'step' => '1',
				'save_always' => true,
				"description" => wp_kses_post( __('Video border radius in <code>px</code>.', 'core-extension' )),
				"group" => esc_html__('Style', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Media', 'core-extension'),
				"param_name" => "media",
				"value" => array(
					esc_html__('Youtube video', 'core-extension') => "youtube",
					esc_html__('Vimeo video', 'core-extension') => "vimeo",
					esc_html__('Selfhosted video', 'core-extension') => "selfhosted_video"
				),
				'save_always' => true,
				"group" => esc_html__('Media', 'core-extension'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Youtube video id', 'core-extension'),
				"param_name" => "youtube",
				"value" => '',
				"group" => esc_html__('Media', 'core-extension'),
				'dependency' => array(
					'element' => 'media',
					'value' => 'youtube'
				),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Vimeo video id', 'core-extension'),
				"param_name" => "vimeo",
				"value" => '',
				"group" => esc_html__('Media', 'core-extension'),
				'dependency' => array(
					'element' => 'media',
					'value' => 'vimeo'
				),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Selfhosted video url', 'core-extension'),
				"param_name" => "selfhosted_video",
				"value" => '',
				'description' => esc_html__( 'Copy audio file url from Media and paste here.', 'core-extension' ),
				"group" => esc_html__('Media', 'core-extension'),
				'dependency' => array(
					'element' => 'media',
					'value' => 'selfhosted_video'
				),
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Poster', 'core-extension' ),
				'param_name' => 'poster',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'core-extension' ),
				'group' => esc_html__('Poster', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				"group" => esc_html__('Poster', 'core-extension')
			),
			$lazy_images,
			$preloader,
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		),
	) );

	// Widgetised Sidebar
	vc_map( array(
		'name' => __( 'Widgetised Sidebar', 'core-extension' ),
		'base' => 'vc_widget_sidebar',
		'class' => 'wpb_widget_sidebar_widget',
		'icon' => 'icon-wpb-layout_sidebar',
		'category' => __( 'Structure', 'core-extension' ),
		'description' => __( 'WordPress widgetised sidebar', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Enter text used as widget title (Note: located above content element).', 'core-extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'widgetised_sidebars',
				'heading' => __( 'Sidebar', 'core-extension' ),
				'param_name' => 'sidebar_id',
				'description' => __( 'Select widget area to display.', 'core-extension' ),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
			),
			array(
				'type' => 'el_id',
				'heading' => __( 'Element ID', 'core-extension' ),
				'param_name' => 'el_id',
				'description' => sprintf( wp_kses_post( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>). The element ID should not start with a number.', 'core-extension' )), 'http://www.w3schools.com/tags/att_global_id.asp' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'core-extension' ),
			),
		),
	) );

	// Progress Bar
	vc_map( array(
		"name" => esc_html__('Progress Bar', 'core-extension'),
		"base" => "vc_progress_bar",
		"icon" => "icon-wpb-vc_progress_bar",
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		"description" => esc_html__('Animated progress bar', 'core-extension'),
		'weight' => 1,
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
				),
				'save_always' => true
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Maximum value', 'core-extension'),
				"param_name" => "max",
				'value' => '100',
				'save_always' => true,
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Units', 'core-extension'),
				"param_name" => "units",
				"description" => esc_html__('Enter measurement units (if needed) Eg. %, px, points, etc.', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Bar color', 'core-extension'),
				"param_name" => "bar_color",
				"description" => esc_html__('Select bar background color for bars or leave empty to use main accent color.', 'core-extension'),
				'group' => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Track color', 'core-extension'),
				"param_name" => "track_color",
				"description" => esc_html__('Select track background color for bars or leave empty for transparent track background.', 'core-extension'),
				'group' => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_multi",
				"heading" => esc_html__('Text color', 'core-extension'),
				"param_name" => "text_color",
				'group' => esc_html__('Colors', 'core-extension')
			),
			array(
				"heading" => esc_html__('Values', 'core-extension'),
				'type' => 'param_group',
				'param_name' => 'values',
				"group" => esc_html__('Values', 'core-extension'),
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Development', 'core-extension' ),
						'value' => '90',
					),
					array(
						'label' => esc_html__( 'Design', 'core-extension' ),
						'value' => '80',
					),
					array(
						'label' => esc_html__( 'Marketing', 'core-extension' ),
						'value' => '70',
					),
				) ) ),
				'save_always' => true,
				'params' => array(
					array(
						'type' => 'textfield',
						'value' => '',
						"heading" => esc_html__('Label', 'core-extension'),
						'param_name' => 'label',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'value' => '',
						"heading" => esc_html__('Value', 'core-extension'),
						'param_name' => 'value',
						'admin_label' => true,
					),
					array(
						"type" => "wtbx_vc_colorpicker_multi",
						"heading" => esc_html__('Bar color', 'core-extension'),
						"param_name" => "custom_bar_color",
						"description" => esc_html__('You can choose a different bar color for this specific bar.', 'core-extension'),
					),
				)
			),
		    $extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );


	// Pie chart
	vc_map( array(
		'name' => esc_html__( 'Progress circle', 'vc_extend' ),
		'base' => 'vc_custom_pie',
		'class' => '',
		'icon' => 'icon-wpb-vc_pie_chart',
		"category"  => array(esc_html__('Scape theme', 'core-extension'), esc_html__('Content', 'core-extension') ),
		'description' => esc_html__( 'Animated progress circle', 'core-extension' ),
		'weight' => 1,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'core-extension' ),
				'param_name' => 'title',
				'value' => esc_html__( 'Title', 'core-extension' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Subtitle', 'core-extension' ),
				'param_name' => 'subtitle',
				'value' => esc_html__( 'Subtitle', 'core-extension' ),
				'admin_label' => true
			),
			array(
				"type" => "wtbx_vc_slider",
				'heading' => esc_html__( 'Pie value', 'core-extension' ),
				'param_name' => 'value',
				"std" => '50',
				'range_from' => '0',
				'range_to' => '100',
				'step' => '1',
				'save_always' => true,
				'description' => esc_html__( 'Set pie value between 0 and 100.', 'core-extension' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Pie value label (optional)', 'core-extension' ),
				'param_name' => 'label_value',
				'description' => esc_html__( 'Input integer value for label in case you want to display a different value from the one assigned to the graph. If empty, "Pie value" will be used.', 'core-extension' ),
				'value' => ''
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__('Units', 'core-extension'),
				"param_name" => "units",
				"description" => esc_html__('Enter measurement units (if needed) Eg. %, px, points, etc.', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(
					esc_html__('Style 1', 'core-extension') => "style_1",
					esc_html__('Style 2', 'core-extension') => "style_2",
					esc_html__('Style 3', 'core-extension') => "style_3",
				),
				'save_always' => true,
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_slider',
				'heading' => esc_html__( 'Chart size', 'core-extension' ),
				'param_name' => 'size',
				"std" => '200',
				'range_from' => '150',
				'range_to' => '300',
				'step' => '1',
				'save_always' => true,
				'group' => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Line width', 'core-extension' ),
				'param_name' => 'width',
				'value' => '10',
				'description' => wp_kses_post( __( 'Set the width of the line in <code>px</code>.', 'core-extension' )),
				'group' => esc_html__('Design', 'core-extension')
			),
			array(
				'type' => 'wtbx_vc_slider',
				'heading' => esc_html__( 'Animation duration', 'core-extension' ),
				'param_name' => 'duration',
				"std" => '2000',
				'range_from' => '0',
				'range_to' => '5000',
				'step' => '100',
				'save_always' => true,
				'group' => esc_html__('Design', 'core-extension'),
			),
			array(
				'type' => 'wtbx_vc_icon_font',
				'heading' => esc_html__( 'Select an icon', 'core-extension' ),
				'param_name' => 'icon',
				'save_always' => true,
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_2', 'style_3'),
				),
				"group" => esc_html__('Icon', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__('Color skin', 'core-extension'),
				"param_name" => "skin",
				"value" => array(
					esc_html__('Light', 'core-extension')   => "light",
					esc_html__('Dark', 'core-extension')  => "dark",
				),
				'save_always' => true,
				'group' => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Chart line color', 'core-extension'),
				"param_name" => "chart_color",
				"group" => esc_html__('Colors', 'core-extension'),
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Track color', 'core-extension'),
				"param_name" => "track_color",
				"value" => '',
				'description' => esc_html__( 'Set the color of the track underneath the pie.', 'core-extension' ),
				'group' => esc_html__('Colors', 'core-extension')
			),
			array(
				"type" => "wtbx_vc_colorpicker_solid",
				"heading" => esc_html__('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				"value" => '',
				'description' => esc_html__( 'Set the color of the icon.', 'core-extension' ),
				'group' => esc_html__('Colors', 'core-extension'),
				'dependency' => array(
					'element' => 'style',
					'value' => array('style_2', 'style_3'),
				),
			),
			$extra_class,
			$add_css_animation,
			$add_css_animation_easing,
			$add_css_animation_duration,
			$add_css_animation_delay,
			$remove_css_animation
		)
	) );

}