<?php
$output = $link = $el_class = $unique_class = $style = $color_text = $color_fill = $text = $text_single = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_split_text';
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
$color_text = wtbx_vc_color_styles_text($color);
if ( strpos($css_animation, 'fill') !== false ) {
	$color_fill = wtbx_vc_color_styles_bg($fill_color);
}

// text typography
$typography_string = wtbx_font_styling($typography);

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_split_text_inner {' . $color_text .  '}' : null;
$color_fill !== '' ? $js_styles .= $unique_class_css.' .wtbx_split_fill {' . $color_fill .  '}' : null;
$typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_split_text_cont {' . $typography_string . '}' : null;

if ( $responsiveness !== '' ) {
	if ( $tablet_portrait !== '' && intval($tablet_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 979px) {' . $unique_class_css.' .wtbx_split_text_inner {font-size:' . intval($tablet_portrait) . '%} }';
	}
	if ( $mobile_landscape !== '' && intval($mobile_landscape) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 767px) {' . $unique_class_css.' .wtbx_split_text_inner {font-size:' . intval($mobile_landscape) . '%} }';
	}
	if ( $mobile_portrait !== '' && intval($mobile_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 479px) {' . $unique_class_css.' .wtbx_split_text_inner {font-size:' . intval($mobile_portrait) . '%} }';
	}
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="'.esc_attr($element_class).'_container">';
$output .= '<div class="'.esc_attr($element_class).'_inner">';

if ( !empty($text_single) ) {

	$output .= '<div class="wtbx_split_text_wrapper" data-delay="' . ( !empty($css_animation_delay) ? esc_attr(explode('wtbx-delay-', $css_animation_delay)[1]) : '' ) .'">';
	$output .= '<div class="wtbx_split_text_cont">';
	$output .= '<'.$wrapper.' class="wtbx_vc_el_container wtbx_vc_animation_el_half wtbx_split_text_inner wtbx-text">' . esc_html($text_single) .'</'.$wrapper.'>';
	if ( strpos($css_animation, 'fill') !== false ) {
		$output .= '<span class="wtbx_vc_animation_el wtbx_split_fill"></span>';
	}
	$output .= '</div>';
	$output .= '</div>';

} elseif ( !empty($text) ) {
	$lines = explode(',', $text);

	if ( sizeof($lines) > 0 ) {

		foreach ( $lines as $line ) {

			$output .= '<div class="wtbx_split_text_wrapper" data-delay="' . ( !empty($css_animation_delay) ? esc_attr(explode('wtbx-delay-', $css_animation_delay)[1]) : '' ) .'">';
				$output .= '<div class="wtbx_split_text_cont">';
					$output .= '<'.$wrapper.' class="wtbx_vc_el_container wtbx_vc_animation_el_half wtbx_split_text_inner wtbx-text">' . esc_html($line) .'</'.$wrapper.'>';
					if ( strpos($css_animation, 'fill') !== false ) {
						$output .= '<span class="wtbx_vc_animation_el wtbx_split_fill"></span>';
					}
				$output .= '</div>';
			$output .= '</div>';

		}

	}
}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.splitText.trigger();}</script>";
}