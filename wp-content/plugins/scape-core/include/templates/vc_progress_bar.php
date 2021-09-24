<?php
$output = $anim_class = $el_class = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_progress_bar';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// colors
$color_text = wtbx_vc_color_styles_text($text_color);
$color_bar = wtbx_vc_color_styles_bg($bar_color);
$color_track = wtbx_vc_color_styles_bg($track_color);


// bars
$bars = vc_param_group_parse_atts( $atts['values'] );


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $color_text !== '' ? $unique_class_css.' .wtbx_pb_track .wtbx_pb_label, ' . $unique_class_css.' .wtbx_pb_track .wtbx_pb_value {' . $color_text . '}' : '';
$js_styles .= $color_track !== '' ? $unique_class_css.' .wtbx_pb_track {' . $color_track . '}' : '';

$output .= wtbx_vc_js_styles($js_styles);

	// shortcode
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
		$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

			$output .='<div class="wtbx_progress_bar_cont">';

			if ( !empty($bars) ) {
				foreach ( $bars as $bar ) {
					if ( !empty($bar['label']) && !empty($bar['value']) ) {
						$custom_bar_color = isset($bar['custom_bar_color']) && !empty(wtbx_vc_color_styles_bg($bar['custom_bar_color'])) ? wtbx_vc_color_styles_bg($bar['custom_bar_color']) : $color_bar;

						$output .= '<div class="wtbx_pb_track wtbx_appearance_animation">';
						$output .= '<span class="wtbx_pb_label wtbx-text">' . esc_html($bar['label']) . '</span>';
						$output .= '<div class="wtbx_pb_bar" style="width:'. (floatval($bar['value']) / floatval($max)) * 100 . '%; ' . $custom_bar_color . '">';
						if ( $style !== 'style_3' ) {
							$output .= '<span class="wtbx_pb_value wtbx-text">' . esc_html($bar['value'])  . $units . '</span>';
						}
						$output .= '</div>';
						if ( $style === 'style_3' ) {
							$output .= '<span class="wtbx_pb_value wtbx-text">' . esc_html($bar['value']) . '<span> / ' . floatval($max) . ' ' . $units . '</span></span>';
						}
						$output .= '</div>';
					}
				}
			}

			$output .= '</div>';

		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {jQuery('".$unique_class_css." .wtbx_appearance_animation').addClass('wtbx_to_be_animated wtbx_animated');}</script>";
}