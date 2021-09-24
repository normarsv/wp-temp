<?php

vc_add_shortcode_param( 'wtbx_vc_unique_class', 'wtbx_vc_unique_class_field' );
function wtbx_vc_unique_class_field( $settings, $value ) {
	return '<div class="wtbx_vc_unique_class_field">'
	. '<input name="' . $settings['param_name']
	. '" class="wpb_vc_param_value wpb-textinput '
	. $settings['param_name'] . ' ' . $settings['type'] . '_field" type="hidden" value="'
	. $value . '" />'
	. '<label class="unique_class_label">.' . $value . '</label>'
	. '</div>';
}



vc_add_shortcode_param( 'wtbx_vc_icon_font', 'wtbx_vc_icon_font_field', WTBX_PLUGIN_URL . 'assets/js/icon-font-field.js' );
function wtbx_vc_icon_font_field( $settings, $value ) {

	//TODO: add default font css load

	require_once( WTBX_PLUGIN_PATH . 'include/icon-fonts/charmap.php' );

	$output = '';
	$all_fonts = array();

	// get custom icon fonts
	$upload_dir = wp_upload_dir();
	$custom_fonts = wtbx_vc_option('custom_icon_font');

	// get default fonts
	$all_fonts['scape-basic']        = wtbx_vc_icon_font_scape_basic();
	$all_fonts['scape-controls']     = wtbx_vc_icon_font_scape_controls();
	$all_fonts['scape-devices']      = wtbx_vc_icon_font_scape_devices();
	$all_fonts['scape-media']        = wtbx_vc_icon_font_scape_media();
	$all_fonts['scape-tech']         = wtbx_vc_icon_font_scape_tech();
	$all_fonts['scape-business']     = wtbx_vc_icon_font_scape_business();
	$all_fonts['scape-entertainment']= wtbx_vc_icon_font_scape_entertainment();
	$all_fonts['scape-objects']      = wtbx_vc_icon_font_scape_objects();
	$all_fonts['scape-brands']       = wtbx_vc_icon_font_scape_brands();
	$all_fonts['scape-people']       = wtbx_vc_icon_font_scape_people();
	$all_fonts['scape-occasions']    = wtbx_vc_icon_font_scape_occasions();
	$all_fonts['fontawesome']       = wtbx_vc_icon_font_fontawesome();
	$all_fonts['simplelineicons']   = wtbx_vc_icon_font_simplelineicons();
	$all_fonts['linea']             = wtbx_vc_icon_font_linea();

	if ( !empty($custom_fonts) ) {

		$fonts = json_decode($custom_fonts['folder'], true);

		if ( $fonts !== null ) {
			foreach ( $fonts as $font) {

				$path = untrailingslashit( $upload_dir['basedir'] . '/wtbx_icon_fonts/' . $font );

				if ( file_exists( $path . '/charmap.json' ) ) {

					$charmap  = file_get_contents( $path.'/charmap.json' );
					$charmap  = json_decode($charmap, true);
					$all_fonts[$charmap['name']] = $charmap;

				}
			}
		}
	}


	// render option field
	$output .= '<div class="wtbx_vc_icon_font_wrapper">';
	$output .= '<div class="wtbx_vc_icon_font_field"><select class="wtbx_vc_icon_font_select">';
	if ( ! empty( $all_fonts ) ) {
		foreach ( $all_fonts as $font ) {
			$name = $font['name'];
			$label = $font['label'];
			$output .= '<option value="' . esc_attr( $name ) . '" ' . ( strcmp( $name, json_decode($value, true)['font'] ) === 0 ? 'selected' : '' ) . '>' . esc_html( $label ) . '</option>' . "\n";
		}
	}
	$output .= '</select>';
	$output .= '<div class="wtbx_vc_current_icon"><i></i><span class="scape-ui-x wtbx_vc_current_icon_remove"></span></div>';
	$output .= '</div>';

	$output .= '<div class="wtbx_vc_icon_font_container">';
	if ( ! empty( $all_fonts ) ) {
		foreach ( $all_fonts as $font ) {
			$output .= '<div class="wtbx_vc_icon_font" data-font="'.$font['name'].'">';

			if ( $font['name'] === 'fontawesome' || $font['name'] === 'linea' ) {
				foreach ( $font['icons'] as $category => $icons ) {

					$output .= '<div class="wtbx_vc_icon_font_category">'. $category .'</div>';
					$output .= '<ul class="wtbx_vc_icon_font_icons">';

					foreach ( $icons as $icon ) {
						foreach( $icon as $name => $label ) {
							$selected_icon = ( $name == json_decode($value, true)['icon'] ) ? ' class="checked"' : '';
							$output .= '<li><input type="radio" name="icons" value="' . $name . '" id="' . $name . '"'.$selected_icon.'><label title="' . $label . '" for="' . $name . '"><i class="' . $name . '"></i></label></li>';
						}
					}

					$output .= '</ul>';
				}
			} elseif ( is_array($custom_fonts) && json_decode($custom_fonts['folder'], true) !== null && in_array($font['name'], json_decode($custom_fonts['folder'], true)) ) {

				// load font css stylesheets
				$css_dir = $upload_dir['baseurl'] . '/wtbx_icon_fonts/' . $font['name'];

//				$output .= '<script>
//					jQuery(document).ready(function($) {

//						$.get("'.$css_dir.'/style.css", function( data ) {
//							$("head").append("<style>"+data+"</style>");
//						});

//						$("head").append("<link rel=\'stylesheet\' href=\''.$css_dir.'/style.css\' type=\'text/css\' media=\'all\'></link>");
//					});
//				</script>';

				$output .= '<ul class="wtbx_vc_icon_font_icons">';
				foreach( $font['icons'] as $name => $label ) {
					$selected_icon = ( $name == json_decode($value, true)['icon'] ) ? ' class="checked"' : '';
					$output .= '<li><input type="radio" name="icons" value="' . $name . '" id="' . $name . '"'.$selected_icon.'><label title="' . $label . '" for="' . $name . '"><i class="' . $name . '"></i></label></li>';

				}
				$output .= '</ul>';

			} else {

				$output .= '<ul class="wtbx_vc_icon_font_icons">';
				foreach ( $font['icons'] as $icon ) {
					foreach( $icon as $name => $label ) {
						$selected_icon = ( $name == json_decode($value, true)['icon'] ) ? ' class="checked"' : '';
						$output .= '<li><input type="radio" name="icons" value="' . $name . '" id="' . $name . '"'.$selected_icon.'><label title="' . $label . '" for="' . $name . '"><i class="' . $name . '"></i></label></li>';

					}
				}
				$output .= '</ul>';

			}

			$output .= '</div>';
		}
	}
	$output .= '</div>';

	$output .= '<input id="wtbx_vc_selected_icon" name="' .
		esc_attr( $settings['param_name'] ) .
		'" class="wpb_vc_param_value  ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" ' .
		( ( isset( $settings['settings'] ) && ! empty( $settings['settings'] ) ) ? ' data-settings="' . esc_attr( json_encode( $settings['settings'] ) ) . '" ' : '' ) .
		' />';

	$output .= '</div>';

	return $output;

}



vc_add_shortcode_param( 'wtbx_vc_colorpicker_solid', 'wtbx_vc_colorpicker_solid', WTBX_PLUGIN_URL . 'assets/js/colorpicker.js' );
function wtbx_vc_colorpicker_solid( $settings, $value ) {

	$palette_array_def = wtbx_vc_get_colors();
	$palette_array_add = wtbx_vc_option('color-palette-solid');
	if ( !empty($palette_array_add) ) {
		$palette_array = array_merge($palette_array_def, $palette_array_add);
	} else {
		$palette_array = $palette_array_def;
	}

	$default_id = $default_color = '';

	$output  = '';
	$output .= '<div class="wtbx_vc_colorpicker wtbx_vc_colorpicker_solid" data-param="'.esc_attr($settings['param_name']).'">';

	$output .= '<input id="wtbx_vc_selected_color" name="' .
		esc_attr( $settings['param_name'] ) .
		'" class="wpb_vc_param_value  ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" ' .
		( ( isset( $settings['settings'] ) && ! empty( $settings['settings'] ) ) ? ' data-default-color="'.$default_color.'" data-settings="' . esc_attr( json_encode( $settings['settings'] ) ) . '" ' : '' ) .
		' />';

	if ( $value !== '' ) {
		$value          = json_decode($value, true);
		$default_id     = $value['id'];
		$default_color  = $value['color'];

		!empty($value['id']) ? $default_id = $value['id'] : null;

		if ( !empty($value['id']) && array_key_exists($value['id'], $palette_array) ) {
			$default_color = $palette_array[$value['id']];
		} else {
			!empty($value['color']) ? $default_color = $value['color'] : null;
		}
	}

	// current color preview
	$output .= '<div class="wtbx_vc_colorpicker_preview">';
		$output .= '<div class="wtbx_vc_colorpicker_current_color" style="background-color: '.esc_attr($default_color).'"></div><span class="wtbx_vc_colorpicker_current_code">';
		$output .= ($default_color !== '') ? esc_html($default_color) : esc_html__('Select color', 'core-extension');
		$output .= '</span>';
		$output .= '<i class="dashicons dashicons-no-alt wtbx_vc_colorpicker_clear"></i>';
	$output	.= '</div>';


	$output .= '<div class="wtbx_vc_colorpicker_container">';

	$selected_palette   = $default_id === 'custom_color' ? '' : ' selected';
	$selected_custom    = $default_id === 'custom_color' ? ' selected' : '';

	// select
	$output .= '<div class="wtbx_vc_colorpicker_select">';
		$output .= '<select>';
			$output .= '<option value="palette"'. $selected_palette . '>'.esc_html__('Choose color from palette', 'core-extension').'</option>' . "\n";
			$output .= '<option value="custom"'. $selected_custom . '>'.esc_html__('Custom color', 'core-extension').'</option>' . "\n";
		$output .= '</select>';
	$output	.= '</div>';


	// options
	$output .= '<div class="wtbx_vc_colorpicker_options">';

	// palette
	$count = 1;
	$output .= '<div class="wtbx_vc_colorpicker_option wtbx_vc_colorpicker_palette clearfix" data-option="palette">';
	foreach ( $palette_array as $key => $color ) {
		if ( strpos($key, 'custom_') !== false ) {
			$name = 'Additional color ' . $count;
			$count++;
		} else {
			$name = $key;
		}

		$selected_opt = $default_id === $key ? ' current' : '';

		$output .= '<div class="wtbx_vc_color_opt_wrapper"><div class="wtbx_vc_color_opt'.$selected_opt.'" data-id="'.esc_attr($key).'" data-color="'.esc_attr($color).'"><div class="wtbx_vc_color_opt_inner">'
						. '<span class="wtbx_vc_color_cell wtbx_vc_color_opt_name">'.esc_attr($name).'</span>'
						. '<span class="wtbx_vc_color_cell wtbx_vc_color_opt_hex">'.esc_attr($color).'</span>'
						. '<div class="wtbx_vc_color_cell wtbx_vc_color_opt_preview" style="background-color:'.esc_attr($color).'"></div></div>'
				. '</div></div>';
	}
	$output	.= '</div>';

	// colorpicker
	if ( $default_id === 'custom_color' ) {
		$default_colorpicker = $default_color;
	} else {
		$default_colorpicker = '';
	}

	$output .= '<div class="wtbx_vc_colorpicker_option wtbx_vc_colorpicker_custom" data-option="custom" data-color="'.esc_attr($default_colorpicker).'">';
	$output .= '<input name="' . $settings['param_name'] . '[custom]" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field wtbx_vc_colorpicker_custom_color" type="text" value="'.esc_attr($default_colorpicker).'"/>';
	$output	.= '</div>';

	$output	.= '</div>';


	$output	.= '</div>';
	$output	.= '</div>';

	return $output;
}



vc_add_shortcode_param( 'wtbx_vc_colorpicker_multi', 'wtbx_vc_colorpicker_multi', WTBX_PLUGIN_URL . 'assets/js/colorpicker-multi.js' );
function wtbx_vc_colorpicker_multi( $settings, $value ) {

	$palette_array_def = wtbx_vc_get_colors();
	$palette_array_add = wtbx_vc_option('color-palette-solid');
	if ( !empty($palette_array_add) ) {
		$palette_array = array_merge($palette_array_def, $palette_array_add);
	} else {
		$palette_array = $palette_array_def;
	}

	$default_id_solid = $default_color_solid = $default_id_from = $default_color_from = $default_id_to = $default_color_to = $default_dir = '';

	$output  = '';
	$output .= '<div class="wtbx_vc_colorpicker wtbx_vc_colorpicker_multi" data-param="'.esc_attr($settings['param_name']).'">';

	$output .= '<input id="wtbx_vc_selected_color" name="' .
		esc_attr( $settings['param_name'] ) .
		'" class="wpb_vc_param_value  ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" ' .
		( ( isset( $settings['settings'] ) && ! empty( $settings['settings'] ) ) ? ' data-settings="' . esc_attr( json_encode( $settings['settings'] ) ) . '" ' : '' ) .
		' />';

	if ( $value !== '' ) {
		$value = json_decode($value, true);
	}

	if ( $value !== '' && $value['solid'] ) {
		!empty($value['solid']['id']) ? $default_id_solid = $value['solid']['id'] : null;

		if ( !empty($value['solid']['id']) && array_key_exists($value['solid']['id'], $palette_array) ) {
			$default_color_solid = $palette_array[$value['solid']['id']];
		} else {
			!empty($value['solid']['color']) ? $default_color_solid = $value['solid']['color'] : null;
		}
	}

	if ( empty($value) || !empty($value['solid']) ) {
		$switch_solid_active = ' active';
	} else {
		$switch_solid_active = '';
	}

	if ( !empty($value['from']) || !empty($value['to']) ) {
		$switch_palette_active = ' active';
	} else {
		$switch_palette_active = '';
	}

	// switch
	$output .= '<div class="wtbx_vc_colorpicker_switch">';
	$output .= '<span class="wtbx_vc_colorpicker_switch_label'.$switch_solid_active.'" data-type="solid">'.esc_html__('Solid', 'core-extension').'</span>';
	$output .= '<span class="wtbx_vc_colorpicker_switch_label'.$switch_palette_active.'" data-type="gradient">'.esc_html__('Gradient', 'core-extension').'</span>';
	$output	.= '</div>';

	$output .= '<div class="wtbx_vc_colorpicker_types">';

	$output .= '<div class="wtbx_vc_colorpicker_type'.$switch_solid_active.'" data-type="solid">';

	// current color preview
	$output .= '<div class="wtbx_vc_colorpicker_preview" data-section="solid">';
	$output .= '<div class="wtbx_vc_colorpicker_current_color" style="background-color: '.esc_attr($default_color_solid).'"></div><span class="wtbx_vc_colorpicker_current_code">';
	$output .= ($default_color_solid !== '') ? esc_html($default_color_solid) : esc_html__('Select color', 'core-extension');
	$output .= '</span>';
	$output .= '<i class="dashicons dashicons-no-alt wtbx_vc_colorpicker_clear"></i>';
	$output	.= '</div>';


	$output .= '<div class="wtbx_vc_colorpicker_container" data-section="solid">';

	$selected_palette   = $default_id_solid === 'custom_color' ? '' : ' selected';
	$selected_custom    = $default_id_solid === 'custom_color' ? ' selected' : '';

	// select
	$output .= '<div class="wtbx_vc_colorpicker_select">';
	$output .= '<select>';
	$output .= '<option value="palette"'. $selected_palette . '>'.esc_html__('Choose color from palette', 'core-extension').'</option>' . "\n";
	$output .= '<option value="custom"'. $selected_custom . '>'.esc_html__('Custom color', 'core-extension').'</option>' . "\n";
	$output .= '</select>';
	$output	.= '</div>';


	// options
	$output .= '<div class="wtbx_vc_colorpicker_options">';

	// palette
	$count = 1;
	$output .= '<div class="wtbx_vc_colorpicker_option wtbx_vc_colorpicker_palette clearfix" data-option="solid-palette">';
	foreach ( $palette_array as $key => $color ) {
		if ( strpos($key, 'custom_') !== false ) {
			$name = 'Additional color ' . $count;
			$count++;
		} else {
			$name = $key;
		}

		$selected_opt = $default_id_solid === $key ? ' current' : '';

		$output .= '<div class="wtbx_vc_color_opt_wrapper"><div class="wtbx_vc_color_opt'.$selected_opt.'" data-id="'.esc_attr($key).'" data-color="'.esc_attr($color).'"><div class="wtbx_vc_color_opt_inner">'
			. '<span class="wtbx_vc_color_cell wtbx_vc_color_opt_name">'.esc_attr($name).'</span>'
			. '<span class="wtbx_vc_color_cell wtbx_vc_color_opt_hex">'.esc_attr($color).'</span>'
			. '<div class="wtbx_vc_color_cell wtbx_vc_color_opt_preview" style="background-color:'.esc_attr($color).'"></div></div>'
			. '</div></div>';
	}
	$output	.= '</div>';

	// colorpicker
	if ( $default_id_solid === 'custom_color' ) {
		$default_colorpicker = $default_color_solid;
	} else {
		$default_colorpicker = '';
	}

	$output .= '<div class="wtbx_vc_colorpicker_option wtbx_vc_colorpicker_custom" data-option="solid-custom" data-color="'.esc_attr($default_colorpicker).'">';
	$output .= '<input name="' . $settings['param_name'] . '[custom]" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field wtbx_vc_colorpicker_custom_color" type="text" value="'.esc_attr($default_colorpicker).'"/>';
	$output	.= '</div>';
	$output	.= '</div>';
	$output	.= '</div>';
	$output .= '</div>';

	/////////////
	/////////////
	/////////////

	$output .= '<div class="wtbx_vc_colorpicker_type'.$switch_palette_active.'" data-type="gradient">';

	$directions = wtbx_vc_gradient_directions(true);

	$output .= '<div class="wtbx_vc_colorpicker_gradient_dir">';
	$output .= '<select>';
		foreach ($directions as $dir => $label ) {
			if ( $value !== '' && !empty($value['dir']) ) {
				$default_dir = $dir === $value['dir'] ? ' selected' : '';
			}
			$output .= '<option value="'.$dir.'"'. $default_dir .'>'.$label.'</option>' . "\n";
		}
	$output .= '</select>';
	$output .= '</div>';

	$sections = ['from', 'to'];

	$output .= '<div class="wtbx_vc_colorpicker_preview_wrapper clearfix">';

	foreach ( $sections as $section ) {
		${'$default_id_'.$section} = ${'$default_color_'.$section} = '';

		if ( $value !== '' && !empty($value[$section]) ) {
			${'$default_id_'.$section} = !empty($value[$section]['id']) ? $value[$section]['id'] : '';

			if ( !empty($value[$section]['id']) && array_key_exists($value[$section]['id'], $palette_array) ) {
				${'$default_color_'.$section} = $palette_array[$value[$section]['id']];
			} else {
				${'$default_color_'.$section} = !empty($value[$section]['color']) ? $value[$section]['color'] : '';
			}
		}

		// current color preview
		$output .= '<div class="wtbx_vc_colorpicker_preview" data-section="'.$section.'">';
			$output .= '<span class="wtbx_vc_colorpicker_current_label">'.ucfirst($section).':</span>';
			$output .= '<div class="wtbx_vc_colorpicker_current_color" style="background-color: ' . esc_attr(${'$default_color_'.$section}) . '"></div>';
			$output .= '<span class="wtbx_vc_colorpicker_current_code">';
				$output .= (${'$default_color_'.$section} !== '') ? esc_html(${'$default_color_'.$section}) : esc_html__('Select color', 'core-extension');
			$output .= '</span>';
			$output .= '<i class="dashicons dashicons-no-alt wtbx_vc_colorpicker_clear"></i>';
		$output .= '</div>';
	}
	$output	.= '</div>';

	$output .= '<div class="wtbx_vc_colorpicker_container_wrapper">';
	foreach ( $sections as $section ) {

		if ( $value !== '' && !empty($value[$section]) ) {
			!empty($value[$section]['id']) ? $default_id = $value[$section]['id'] : null;
			!empty($value[$section]['color']) ? $default_color = $value[$section]['color'] : null;
		}

		$output .= '<div class="wtbx_vc_colorpicker_container" data-section="'.$section.'">';

		$selected_palette   = ${'$default_id_'.$section} === 'custom_color' ? '' : ' selected';
		$selected_custom    = ${'$default_id_'.$section} === 'custom_color' ? ' selected' : '';

		// select
		$output .= '<div class="wtbx_vc_colorpicker_select">';
		$output .= '<select>';
		$output .= '<option value="palette"'. $selected_palette . '>'.esc_html__('Choose color from palette', 'core-extension').'</option>' . "\n";
		$output .= '<option value="custom"'. $selected_custom . '>'.esc_html__('Custom color', 'core-extension').'</option>' . "\n";
		$output .= '</select>';
		$output	.= '</div>';


		// options
		$output .= '<div class="wtbx_vc_colorpicker_options">';

		// palette
		$count = 1;
		$output .= '<div class="wtbx_vc_colorpicker_option wtbx_vc_colorpicker_palette clearfix" data-option="'.$section.'-palette">';
		foreach ( $palette_array as $key => $color ) {
			if ( strpos($key, 'custom_') !== false ) {
				$name = 'Additional color ' . $count;
				$count++;
			} else {
				$name = $key;
			}

			$selected_opt = ${'$default_id_'.$section} === $key ? ' current' : '';

			$output .= '<div class="wtbx_vc_color_opt_wrapper"><div class="wtbx_vc_color_opt'.$selected_opt.'" data-id="'.esc_attr($key).'" data-color="'.esc_attr($color).'"><div class="wtbx_vc_color_opt_inner">'
				. '<span class="wtbx_vc_color_cell wtbx_vc_color_opt_name">'.esc_attr($name).'</span>'
				. '<span class="wtbx_vc_color_cell wtbx_vc_color_opt_hex">'.esc_attr($color).'</span>'
				. '<div class="wtbx_vc_color_cell wtbx_vc_color_opt_preview" style="background-color:'.esc_attr($color).'"></div></div>'
				. '</div></div>';
		}
		$output	.= '</div>';

		// colorpicker
		if ( ${'$default_id_'.$section} === 'custom_color' ) {
			$default_colorpicker = ${'$default_color_'.$section};
		} else {
			$default_colorpicker = '';
		}

		$output .= '<div class="wtbx_vc_colorpicker_option wtbx_vc_colorpicker_custom" data-option="'.$section.'-custom">';
		$output .= '<input name="' . $settings['param_name'] . '[custom]" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field wtbx_vc_colorpicker_custom_color" type="text" value="'.esc_attr($default_colorpicker).'"/>';
		$output	.= '</div>';

		$output	.= '</div>';


		$output	.= '</div>';
	}
	$output	.= '</div>';

	$output	.= '</div>';

	$output	.= '</div>';

	$output	.= '</div>';

	return $output;
}



vc_add_shortcode_param( 'wtbx_vc_typography', 'wtbx_vc_typography', WTBX_PLUGIN_URL . 'assets/js/typography.js' );
function wtbx_vc_typography( $settings, $value ) {

	$output = '';
	$font_settings = !empty($value) ? json_decode($value, true) : '';

	$output .= '<div class="wtbx_typography_wrapper">';

	$output .= '<input name="' . $settings['param_name']. '" class="wpb_vc_param_value wpb-textinput wtbx_typography_value '. $settings['param_name'] . ' ' . $settings['type'] . '_field" type="hidden"' . "value='". esc_attr($value) . "' />";

	$object = wtbx_vc_get_font_weight_style();
	$hidden_object = json_encode($object);

	wtbx_vc_collect_custom_fonts($object, true);

	wtbx_print_admin_fonts();

	$output .= '<div class="wtbx_typography_container">';
	$output .= "<div class='wtbx_typography_hidden' data-fonts='".esc_attr($hidden_object)."'></div>";


	$params = wtbx_vc_get_typography_fields();

	foreach ( $params as $param => $props ) {
		if ( !isset($settings[$param]) || ( isset($settings[$param]) && $settings[$param] ) ) {
			$output .= '<div class="wtbx_typography_param">';
			$output .= '<div class="wtbx_typography_label">' . esc_html($props['title']) . '</div>';
			$output .= '<select class="wtbx_typography_select" data-param="' . esc_attr($param) . '">';
			if ( !empty($props['values']) ) {
				foreach ($props['values'] as $key => $value) {
					$output .= '<option value="' . esc_attr($key) . '"' . ( isset($font_settings[$param]) && (string) $key === $font_settings[$param] ? 'selected="selected"' : '') . '>' . esc_html($value) . '</option>';
				}
			}
			$output .= '</select>';
			$output .= '</div>';
		}
	}

	if ( !isset($settings['font_size']) || ( isset($settings['font_size']) && $settings['font_size'] ) ) {
		$font_size = isset($font_settings['font_size']) ? $font_settings['font_size'] : '';
		if ( strpos($font_size, 'em') !== false ) {
			$font_size_em = ' active';
			$font_size_px = '';
			$font_size_units = 'em';
		} else {
			$font_size_em = '';
			$font_size_px = ' active';
			$font_size_units = 'px';
		}

		$output .= '<div class="wtbx_typography_param">';
		$output .= '<div class="wtbx_typography_label">' . esc_html__('Font size', 'core-extension') . '</div>';
		$output .= '<div class="wtbx_typography_param_wrap">';
		$output .= '<input type="text" class="wtbx_typography_input" data-param="font_size" data-units="'.$font_size_units.'" value="'.($font_size !== '' ? floatval($font_size) : '').'" />';
		$output .= '<div class="wtbx_typography_units">';
		$output .= '<div class="wtbx_typography_unit' . $font_size_px . '" data-units="px">px</div>';
		$output .= '<div class="wtbx_typography_unit' . $font_size_em . '" data-units="em">em</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}

	if ( !isset($settings['line_height']) || ( isset($settings['line_height']) && $settings['line_height'] ) ) {
		$line_height = isset($font_settings['line_height']) ? $font_settings['line_height'] : '';
		if (strpos($line_height, 'em') !== false) {
			$line_height_em = ' active';
			$line_height_px = '';
			$line_height_units = 'em';
		} else {
			$line_height_em = '';
			$line_height_px = ' active';
			$line_height_units = 'px';
		}

		$output .= '<div class="wtbx_typography_param">';
		$output .= '<div class="wtbx_typography_label">' . esc_html__('Line height', 'core-extension') . '</div>';
		$output .= '<div class="wtbx_typography_param_wrap">';
		$output .= '<input type="text" class="wtbx_typography_input" data-param="line_height" data-units="' . $line_height_units . '" value="' . ($line_height !== '' ? floatval($line_height) : '') . '" />';
		$output .= '<div class="wtbx_typography_units">';
		$output .= '<div class="wtbx_typography_unit' . $line_height_px . '" data-units="px">px</div>';
		$output .= '<div class="wtbx_typography_unit' . $line_height_em . '" data-units="em">em</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}

	$letter_spacing = isset($font_settings['letter_spacing']) ? $font_settings['letter_spacing'] : '';
	if ( strpos($letter_spacing, 'em') !== false ) {
		$letter_spacing_em = ' active';
		$letter_spacing_px = '';
		$letter_spacing_units = 'em';
	} else {
		$letter_spacing_em = '';
		$letter_spacing_px = ' active';
		$letter_spacing_units = 'px';
	}

	$output .= '<div class="wtbx_typography_param">';
	$output .= '<div class="wtbx_typography_label">' . esc_html__('Letter spacing', 'core-extension') . '</div>';
	$output .= '<div class="wtbx_typography_param_wrap">';
	$output .= '<input type="text" class="wtbx_typography_input" data-param="letter_spacing" data-units="'.$letter_spacing_units.'" value="'.($letter_spacing !== '' ? floatval($letter_spacing) : '').'" />';
	$output .= '<div class="wtbx_typography_units">';
	$output .= '<div class="wtbx_typography_unit' . $letter_spacing_px . '" data-units="px">px</div>';
	$output .= '<div class="wtbx_typography_unit' . $letter_spacing_em . '" data-units="em">em</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	$output .= '</div>';

	$output .= '<div class="wtbx_typography_preview">';
	$preview_text = 'The sky was cloudless and of a deep dark blue.';
	$output .= '<div class="wtbx_typography_preview_inner">'.$preview_text.'</div>';
	$output .= '</div>';

	$output .= '<div class="wtbx_typography_clear_wrapper"><div class="wtbx_typography_clear">' . esc_html__('Clear all font settings', 'core-extension') . '</div></div>';

	$output .= '</div>';

	return $output;
}



vc_add_shortcode_param( 'wtbx_vc_slider', 'wtbx_vc_slider', WTBX_PLUGIN_URL . 'assets/js/slider.js' );
function wtbx_vc_slider( $settings, $value ) {

	$output = '';
	$output .= '<div class="wtbx_vc_slider_wrapper clearfix">';
	$output .= '<input name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value wtbx_vc_slider_value '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="hidden" value="'.($value !== '' ? esc_attr($value) : $settings['std']).'" data-min="'. (isset($settings['range_from']) ? esc_attr($settings['range_from']) : '') .'" data-max="'. (isset($settings['range_to']) ? esc_attr($settings['range_to']) : '') .'" data-step="'.(isset($settings['step']) ? esc_attr($settings['step']) : '').'" />';
	$output .= '<div class="wtbx_vc_slider_from">'.esc_attr($settings['range_from']).'</div><div class="wtbx_vc_slider_to">'.esc_attr($settings['range_to']).'</div>';
	$output .= '<div class="wtbx_vc_slider"><div class="wtbx_vc_slider_handle ui-slider-handle"></div></div>';
	$output .= '</div>';

	return $output;
}



vc_add_shortcode_param( 'wtbx_vc_styles', 'wtbx_vc_styles', WTBX_PLUGIN_URL . 'assets/js/styles.js' );
function wtbx_vc_styles( $settings, $value ) {

	$properties = !empty($value) ? json_decode($value, true) : '';

	$output = '';
	$output .= '<div class="wtbx_vc_styles_wrapper clearfix" data-property="'.(isset($settings['property']) ? esc_attr($settings['property']) : '').'" data-suffix="'.(isset($settings['suffix']) ? esc_attr($settings['suffix']) : '').'">';
	$output .= '<input name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value wtbx_vc_styles_value '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="hidden" value="'.($value !== '' ? esc_attr($value) : $settings['std']).'" />';

	$output .= '<table class="wtbx_vc_styles_table">';

	// headings
	$output .= '<tr>';
	if ( isset($settings['variants']) ) {
		$output .= '<th></th>';
		foreach ( $settings['variants'] as $property => $label ) {
			$output .= '<th>' . esc_html($label) . '</th>';
		}
	}
	$output .= '</tr>';

	$output .= '<tr>';
	if ( isset($settings['variants']) ) {
		$output .= '<td>'.$settings['heading'].'</td>';
		foreach ( $settings['variants'] as $property => $label ) {
			$output .= '<td><input class="wtbx_vc_styles_input" type="text" name="'.esc_html($property).'" value="'.(isset($properties[$property]) ? $properties[$property] : '').'" /></td>';
		}
	}
	$output .= '</tr>';

	$output .= '</table>';
	$output .= '</div>';

	return $output;
}



vc_add_shortcode_param( 'wtbx_vc_styles_responsive', 'wtbx_vc_styles_responsive', WTBX_PLUGIN_URL . 'assets/js/styles.js' );
function wtbx_vc_styles_responsive( $settings, $value ) {

	$properties = !empty($value) ? json_decode($value, true) : '';

	$screens = array(
		'desktop'           => 'device-screen',
		'tablet_landscape'  => 'device-tablet2',
		'tablet_portrait'   => 'device-tablet',
		'mobile_landscape'  => 'device-mobile2',
		'mobile_portrait'   => 'device-mobile'
	);

	$screen_names = array(
		'desktop'           => esc_html__('Desktop (1025px and wider)', 'core-extension'),
		'tablet_landscape'  => esc_html__('Tablet landscape (up to 1024px)', 'core-extension'),
		'tablet_portrait'   => esc_html__('Tablet portrait (up to 969px)', 'core-extension'),
		'mobile_landscape'  => esc_html__('Mobile landscape (up to 767px)', 'core-extension'),
		'mobile_portrait'   => esc_html__('Mobile portrait (479px and narrower)', 'core-extension'),
	);

	$output = '';
	$output .= '<div class="wtbx_vc_styles_responsive_wrapper" data-property="'.esc_attr($settings['property']).'" data-suffix="'.esc_attr($settings['suffix']).'">';
	$output .= '<input name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value wtbx_vc_styles_value '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="hidden" value="'.($value !== '' ? esc_attr($value) : $settings['std']).'" />';
	$output .= '<div class="wtbx_vc_styles_responsive_inner clearfix">';

	$output .= '<table class="wtbx_vc_styles_table">';

	// headings
	$output .= '<tr>';
	if ( isset($settings['variants']) ) {
		$output .= '<th></th>';
		foreach ( $settings['variants'] as $property => $label ) {
			$output .= '<th>' . esc_html($label) . '</th>';
		}
	}
	$output .= '</tr>';

	foreach ( $screens as $screen => $icon ) {
		$output .= '<tr class="wtbx_screen_size" data-screen="'.$screen.'">';
		if ( isset($settings['variants']) ) {
			$output .= '<td title="'.$screen_names[$screen].'"><i class="device-icon '.$icon.'"></i></td>';
			foreach ( $settings['variants'] as $property => $label ) {
				$output .= '<td><input class="wtbx_vc_styles_input" type="text" name="'.esc_html($property).'" value="'. (!empty($properties) ? $properties[$screen][$property] : "") .'" /></td>';
			}
		}
		$output .= '</tr>';
	}

	$output .= '</table>';
	$output .= '</div>';

	$output .= '<div class="wtbx_toggle"><div class="wtbx_toggle_label" data-show="'.esc_html__('Show responsive options').'" data-hide="'.esc_html__('Hide responsive options').'">'.esc_html__('Show responsiveness options').'</div></div>';

	$output .= '</div>';

	return $output;
}



vc_add_shortcode_param( 'wtbx_vc_design', 'wtbx_vc_design', WTBX_PLUGIN_URL . 'assets/js/design.js' );
function wtbx_vc_design( $settings, $value ) {

	$saved = !empty($value) ? json_decode($value, true) : '';

	$screens = array(
		'mobile_portrait'   => 'device-mobile',
		'mobile_landscape'  => 'device-mobile2',
		'tablet_portrait'   => 'device-tablet',
		'tablet_landscape'  => 'device-tablet2',
		'desktop'           => 'device-screen',
	);

	$properties = array(
		'margin'        => ['margin-top', 'margin-right', 'margin-bottom', 'margin-left'],
		'border'        => ['border-top', 'border-right', 'border-bottom', 'border-left', 'border-top-left-radius', 'border-top-right-radius', 'border-bottom-right-radius', 'border-bottom-left-radius'],
		'padding'       => ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
	);

	$border_styles = array(
		''          => 'inherit',
		'none'      => 'none',
		'hidden'    => 'hidden',
		'dotted'    => 'dotted',
		'dashed'    => 'dashed',
		'solid'     => 'solid',
		'double'    => 'double',
		'groove'    => 'groove',
		'ridge'     => 'ridge',
		'inset'     => 'inset',
		'outset'    => 'outset'
	);

	$screen_names = array(
		'desktop'           => esc_html__('Desktop (1025px and wider)', 'core-extension'),
		'tablet_landscape'  => esc_html__('Tablet landscape (up to 1024px)', 'core-extension'),
		'tablet_portrait'   => esc_html__('Tablet portrait (up to 969px)', 'core-extension'),
		'mobile_landscape'  => esc_html__('Mobile landscape (up to 767px)', 'core-extension'),
		'mobile_portrait'   => esc_html__('Mobile portrait (479px and narrower)', 'core-extension'),
	);

	$classes = array();
	( isset($settings['additional']) && !$settings['additional'] ) ? $classes[] = 'no_additional' : null;
	( isset($settings['margin']) && !$settings['margin'] ) ? $classes[] = 'no_margin' : null;
	( isset($settings['border']) && !$settings['border'] ) ? $classes[] = 'no_border' : null;
	( isset($settings['offset']) && !$settings['offset'] ) ? $classes[] = 'no_offset' : null;
	$classes = implode(' ', $classes);

	$output = '';
	$output .= '<div class="wtbx_vc_design_wrapper '.$classes.'">';
		$output .= '<input name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value wtbx_vc_design_value '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="hidden" value="'.($value !== '' ? esc_attr($value) : $settings['std']).'" />';
		$output .= '<div class="wtbx_vc_design_inner clearfix">';

			$output .= '<div class="wtbx_vc_design_column">';

				// tabs
				$output .= '<ul class="wtbx_vc_design_tabs clearfix">';
				foreach ( $screens as $id => $icon ) {
					$output .= '<li class="wtbx_vc_design_tabs_label'. ($id === 'desktop' ? ' active' : '') .'" data-screen="'.esc_attr($id).'">';
						$output .= '<i class="device-icon '.$icon.'"></i>';
					$output .= '</li>';
				}
				$output .= '</ul>';

				// properties
				$output .= '<div class="wtbx_vc_design_content">';

					foreach ( $screens as $id => $icon ) {
						$output .= '<div class="wtbx_vc_design_tab clearfix'. ($id === 'desktop' ? ' active' : '') .'" data-screen="'.esc_attr($id).'">';
							$output .= '<div class="wtbx_vc_design_table">';
								foreach ( $properties as $property => $variants ) {
									if ( !isset($settings[$property]) || ( isset($settings[$property]) && $settings[$property] ) ) {
										$output .= '<div class="wtbx_property" data-property="' . $property . '">';
										$output .= '<span class="wtbx_property_label">' . esc_html($property) . '</span>';
										foreach ($variants as $variant) {
											$default = '';
											if ($variant === 'padding-left' || $variant === 'padding-right') {
												$default = $id === 'desktop' && isset($settings['padding-h']) ? $settings['padding-h'] : '';
											} elseif ($variant === 'padding-top' || $variant === 'padding-bottom') {
												$default = $id === 'desktop' && isset($settings['padding-v']) ? $settings['padding-v'] : '';
											}
											$padding_h = $id === 'desktop' && isset($settings['padding-h']) && ($variant === 'padding-left' || $variant === 'padding-right') ? ' data-paddingh="' . $settings['padding-h'] . '"' : '';
											$padding_v = $id === 'desktop' && isset($settings['padding-v']) && ($variant === 'padding-top' || $variant === 'padding-bottom') ? ' data-paddingv="' . $settings['padding-v'] . '"' : '';

											$output .= '<div class="wtbx_variant" data-variant="' . esc_html($variant) . '">';
											$output .= '<input class="wtbx_vc_design_input" type="text" name="' . esc_html($variant) . '" placeholder="-" value="' . (isset($saved[$id][$variant]) ? esc_attr($saved[$id][$variant]) : esc_attr($default)) . '"' . $padding_h . $padding_v . ' />';
											$output .= '</div>';
										}
										$output .= '</div>';
									}
								}
							$output .= '</div>';

						if ( !isset($settings['additional']) || ( isset($settings['additional']) && $settings['additional'] ) ) {

							if ( !isset($settings['offset']) || ( isset($settings['offset']) && $settings['offset'] ) ) {
								$output .= '<div class="wtbx_offset_cont">';
								$output .= '<div class="wtbx_offset">';
								$output .= '<div class="wtbx_offset_label">' . esc_html__('Y-axis content shift', 'core-extension') . '</div>';
								$output .= '<div class="wtbx_offset_inner wtbx_offset_demo">';
								$output .= '<div class="wtbx_offset_arrow up"></div>';
								$output .= '<div class="wtbx_offset_square"></div>';
								$output .= '<div class="wtbx_offset_arrow down"></div>';
								$output .= '</div>';
								$output .= '<div class="wtbx_offset_inner wtbx_offset_input">';
								$output .= '<input class="wtbx_vc_offset_input wtbx_vc_design_input" type="text" name="shift-vertical" placeholder="-" value="' . (isset($saved[$id]['shift-vertical']) ? esc_attr($saved[$id]['shift-vertical']) : '') . '" />';
								$output .= '</div>';
								$output .= '<span class="wtbx_offset_hint">' . esc_html__('Negative value shifts content up', 'core-extension') . '</span>';
								$output .= '</div>';
								$output .= '<div class="wtbx_offset">';
								$output .= '<div class="wtbx_offset_label">' . esc_html__('X-axis content shift', 'core-extension') . '</div>';
								$output .= '<div class="wtbx_offset_inner wtbx_offset_demo">';
								$output .= '<div class="wtbx_offset_arrow left"></div>';
								$output .= '<div class="wtbx_offset_square"></div>';
								$output .= '<div class="wtbx_offset_arrow right"></div>';
								$output .= '</div>';
								$output .= '<div class="wtbx_offset_inner wtbx_offset_input">';
								$output .= '<input class="wtbx_vc_offset_input wtbx_vc_design_input" type="text" name="shift-horizontal" placeholder="-" value="' . (isset($saved[$id]['shift-horizontal']) ? esc_attr($saved[$id]['shift-horizontal']) : '') . '" />';
								$output .= '</div>';
								$output .= '<span class="wtbx_offset_hint">' . esc_html__('Negative value shifts content to the left', 'core-extension') . '</span>';
								$output .= '</div>';
								$output .= '</div>';
							}

							$output .= '<div class="wtbx_zindex">';
								$output .= '<div class="wtbx_zindex_label">'.esc_html__('Custom z-index ', 'core-extension').'</div>';
								$output .= '<input class="wtbx_vc_zindex_input wtbx_vc_design_input" type="text" name="z-index" placeholder="-" value="'. ( isset($saved[$id]['z-index']) ? esc_attr($saved[$id]['z-index']) : '' ) .'" />';
							$output .= '</div>';

							$output .= '<div class="wtbx_border_styles">';
								$output .= '<div class="wtbx_border_label">'.esc_html__('Border style', 'core-extension').'</div>';
								$output .= '<select class="wtbx_vc_border_style wtbx_vc_design_input" name="border-style">';
									foreach ( $border_styles as $style => $label ) {
										$output .= '<option value="' . esc_attr( $style ) . '"' . ( isset($saved[$id]['border-style']) && $style === $saved[$id]['border-style'] ? ' selected="selected"' : '' )  . '>' . esc_html( $label ) . '</option>' . "\n";
									}
								$output .= '</select>';
							$output .= '</div>';

						}

						$output .= '</div>';
					}
				$output .= '</div>';

			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';

	return $output;
}