<?php
$output = $link = $el_class = $unique_class = $style = $color_text = $zindex = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// shortcode class
$element_class      = 'wtbx_vc_section_divider';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

if ( $color !== '' ) {
	$color = json_decode($color, true);
	if (array_key_exists('id', $color) && array_key_exists('color', $color) && $color['id'] !== '' && $color['color'] !== '') {
		$color = wtbx_vc_color_from_palette($color['id'], $color['color']);
	} else {
		$color = '#ffffff';
	}
}


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

if ( $style !== 'notch-top' && $style !== 'notch-bottom' ) {
	$js_styles .= $unique_class_css.' .wtbx-section-decoration { height:' . intval($height) . 'px}';

	if ( $responsiveness !== '' ) {
		if ( $tablet_landscape !== '' ) {
			$js_styles .= '@media only screen and (max-width: 1024px) {' . $unique_class_css.' .wtbx-section-decoration' . ' {height:' . intval($tablet_landscape) . 'px} }';
		}
		if ( $tablet_portrait !== '' ) {
			$js_styles .= '@media only screen and (max-width: 979px) {' . $unique_class_css.' .wtbx-section-decoration' . ' {height:' . intval($tablet_portrait) . 'px} }';
		}
		if ( $mobile_landscape !== '' ) {
			$js_styles .= '@media only screen and (max-width: 767px) {' . $unique_class_css.' .wtbx-section-decoration' . ' {height:' . intval($mobile_landscape) . 'px} }';
		}
		if ( $mobile_portrait !== '' ) {
			$js_styles .= '@media only screen and (max-width: 479px) {' . $unique_class_css.' .wtbx-section-decoration' . ' {height:' . intval($mobile_portrait) . 'px} }';
		}
	}
}

$js_styles .=  !empty($zindex) ? $unique_class_css.' { z-index:' . intval($zindex) . '}' : '';


$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= wtbx_decoration($style, $color, true);
$output .= '</div>';

echo $output;