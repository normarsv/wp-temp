<?php
$output = $link = $el_class = $unique_class = $style = $color_text = $display = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_text_element';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = $display;
$center !== '' ? $shortcode_class[] = 'wtbx_center_' . $center: null;
$disable_margin !== '' ? $shortcode_class[] = 'wtbx_disable_margin' : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// colors
$color_text = wtbx_vc_color_styles_text($color);
$force_color = $force_color !== '' ? ' *' : '';

// text typography
$typography_string = wtbx_font_styling($typography);
$force_typography = $force_typography !== '' ? ' *' : '';

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_text_element_content' . $force_color . ' {' . $color_text .  '}' : null;
$typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_text_element_content' . $force_typography . ' {' . $typography_string . '}' : null;

if ( $display === 'wtbx_display_inline_block' ) {
	$margin  = wtbx_vc_scape_design($margin);
	$margin !== '' ? $js_styles .= $unique_class_css.' {' . $margin . '}' : null;
}

if ( $responsiveness !== '' ) {
	if ( $tablet_portrait !== '' && intval($tablet_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 979px) {' . $unique_class_css.' .wtbx_text_element_inner' . $force_typography . ' {font-size:' . intval($tablet_portrait) . '%} }';
	}
	if ( $mobile_landscape !== '' && intval($mobile_landscape) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 767px) {' . $unique_class_css.' .wtbx_text_element_inner' . $force_typography . ' {font-size:' . intval($mobile_landscape) . '%} }';
	}
	if ( $mobile_portrait !== '' && intval($mobile_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 479px) {' . $unique_class_css.' .wtbx_text_element_inner' . $force_typography . ' {font-size:' . intval($mobile_portrait) . '%} }';
	}
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
		$output .= '<div class="wtbx_text_element_content">';
			$output .= '<div class="wtbx_text_element_inner">';
				$output .= wpb_js_remove_wpautop($content, true);
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;