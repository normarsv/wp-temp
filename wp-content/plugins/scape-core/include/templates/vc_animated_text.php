<?php
$el_class = $unique_class = $prefix_text = $postfix_text = $center = $text_color = $anim_text_color =
$text_typography = $anim_text_typography = '';

$start_delay    = 500;
$type_speed     = 50;
$back_delay     = 500;
$back_speed     = 10;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( wtbx_vc_is_page_editable() ) {
	wp_enqueue_script('typed');
} else {
	wtbx_vc_script_queue('typed');
}

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_animated_text';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$alignment !== '' ? $shortcode_class[] = 'wtbx_' . $alignment : null;
$center !== '' ? $shortcode_class[] = 'wtbx_center_' . $center: null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// colors
$color_text = wtbx_vc_color_styles_text($text_color);
$color_anim = wtbx_vc_color_styles_text($anim_text_color);

// text typography
$text_typography_string = wtbx_font_styling($text_typography);
$anim_typography_string = wtbx_font_styling($anim_text_typography);

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'" data-id="'.esc_attr($unique_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_anim_text_cont {' . $color_text .  '}' : null;
$color_anim !== '' ? $js_styles .= $unique_class_css.' .wtbx_anim_text {' . $color_anim .  '}' : null;
$text_typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_anim_text_cont {' . $text_typography_string . '}' : null;
$anim_typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_anim_text {' . $anim_typography_string . '}' : null;

if ( $responsiveness !== '' ) {
	if ( $tablet_portrait !== '' && intval($tablet_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 979px) {' . $unique_class_css.' .wtbx_anim_prefix span, ' . $unique_class_css.' .wtbx_anim_postfix span, ' . $unique_class_css.' .wtbx_anim_text span {font-size:' . intval($tablet_portrait) . '%} }';
	}
	if ( $mobile_landscape !== '' && intval($mobile_landscape) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 767px) {' . $unique_class_css.' .wtbx_anim_prefix span, ' . $unique_class_css.' .wtbx_anim_postfix span, ' . $unique_class_css.' .wtbx_anim_text span {font-size:' . intval($mobile_landscape) . '%} }';
	}
	if ( $mobile_portrait !== '' && intval($mobile_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 479px) {' . $unique_class_css.' .wtbx_anim_prefix span, ' . $unique_class_css.' .wtbx_anim_postfix span, ' . $unique_class_css.' .wtbx_anim_text span {font-size:' . intval($mobile_portrait) . '%} }';
	}
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
		$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

			$output .= '<'.esc_html($wrapper).' class="wtbx_anim_text_cont">';
				$output .= $prefix_text !== '' ? '<span class="wtbx_anim_prefix"><span>' . esc_html($prefix_text) . '</span></span>': '';

				if ( !empty($animated_text) ) {
					$text = explode(',', $animated_text);
					if ( sizeof($text) > 0 ) {
						$text = json_encode($text);
						$output .= '<span class="wtbx_anim_text" data-text-strings="'.esc_attr($text).'" data-startdelay="'.esc_attr($start_delay).'" data-typespeed="'.esc_attr($type_speed).'" data-backdelay="'.esc_attr($back_delay).'" data-backspeed="'.esc_attr($back_speed).'"><span></span></span>';
					}
				}

				$output .= $postfix_text !== '' ? '<span class="wtbx_anim_postfix"><span>' . esc_html($postfix_text) . '</span></span>' : '';
			$output .= '</'.esc_html($wrapper).'>';

		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE.animatedText) {SCAPE.animatedText();}</script>";
}