<?php
$output = $unique_class = $el_class = $css = $heading_text =
$heading_wrapper = $style = $alignment = $divider_rounded =
$divider_length_san = $divider_thickness_san = $space_san = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


$element_class      = 'wtbx_vc_styled_heading';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_style_' . $style;
$alignment !== '' ? $shortcode_class[]  = 'wtbx_' . $alignment : null;
$style === 'with_dash' ? $shortcode_class[] = 'wtbx_dash_' . $dash_type : null;
$center !== '' ? $shortcode_class[] = 'wtbx_center_' . $center: null;


$shortcode_class    = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class ) . vc_shortcode_custom_css_class( $css, ' ' );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$heading_text = $page_title !== '' ? wtbx_get_the_title() : wpb_js_remove_wpautop($heading_text);

$heading = ($heading_text !== '') ? '<div class="wtbx_heading_el_title_wrapper '.$heading_wrapper.'"><'.$heading_wrapper.' class="wtbx_heading_el_title wtbx-text">' . $heading_text . '</'.$heading_wrapper.'></div>' : '';
$divider = in_array($style, array('with_line_top', 'with_line_bottom', 'with_line_side')) !== '' ? '<div class="wtbx_heading_el_divider"></div>' : '';
$empty_space = '<span class="wtbx_heading_el_space"></span>';

$h_typography_string    = wtbx_font_styling($heading_typography);
$div_color              = wtbx_vc_color_styles_bg($divider_color);

if ( $divider_rounded === 'rounded' && $divider_thickness !== '' ) {
	$divider_rounded = ' border-radius:' . intval($divider_thickness) . 'px;';
}
$clearfix = ( $style === 'with_line_top' || $style === 'with_line_bottom') ? ' clearfix' : '';

// css
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$output .= '<div class="'.esc_attr($css_class).'">';

$js_styles = '';

($heading_color !== '') ? $js_styles .= $unique_class_css.' .wtbx_heading_el_title {' . wtbx_vc_color_styles_text($heading_color) . '}' : null;
($h_typography_string !== '') ? $js_styles .= $unique_class_css.' .wtbx_heading_el_title_wrapper {' . $h_typography_string . '}' : null;


if ( $style === 'with_border' ) {
	$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner:before,'.$unique_class_css.' .wtbx_vc_styled_heading_inner:after {' . wtbx_vc_color_styles_bg($divider_color) . '}';
} elseif ( $style === 'with_line_top' ) {
	$divider_length_san     = ' height:' . intval($divider_length) . 'px;';
	$divider_thickness_san  = ' width:' .  intval($divider_thickness) . 'px;';
	$space_san              = ' margin-bottom:' . intval($space) . 'px;';
	$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner .wtbx_heading_el_divider {' . $divider_length_san . $divider_thickness_san . $space_san . wtbx_vc_color_styles_bg($divider_color) . $divider_rounded . '}';
} elseif ( $style === 'with_line_bottom' ) {
	$divider_length_san     = ' height:' . intval($divider_length) . 'px;';
	$divider_thickness_san  = ' width:' .  intval($divider_thickness) . 'px;';
	$space_san              = ' margin-top:' . intval($space) . 'px;';
	$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner .wtbx_heading_el_divider {' . $divider_length_san . $divider_thickness_san . $space_san . wtbx_vc_color_styles_bg($divider_color) . $divider_rounded . '}';
} elseif ( $style === 'with_line_side' ) {
	$divider_length_san     = ' width:' . intval($divider_length) . 'px;';
	$divider_thickness_san  = ' height:' .  intval($divider_thickness) . 'px;';

	if ( $alignment === 'align_left' || $alignment === '' ) {
		$space_san = ' margin-right:' . intval($space) . 'px;';
		$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner .wtbx_heading_el_divider:before {' . $divider_length_san . $divider_thickness_san . $space_san . wtbx_vc_color_styles_bg($divider_color) . $divider_rounded . '}';
	} elseif ( $alignment === 'align_right' ) {
		$space_san = ' margin-left:' . intval($space) . 'px;';
		$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner .wtbx_heading_el_divider:before {' . $divider_length_san . $divider_thickness_san . $space_san . wtbx_vc_color_styles_bg($divider_color) . $divider_rounded . '}';
	} elseif ( $alignment === 'align_center' ) {
		$space_san = ' margin-right:' . intval($space) . 'px;';
		$space_san_right = ' margin-left:' . intval($space) . 'px;';
		$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner .wtbx_heading_el_divider:first-of-type:before {' . $divider_length_san . $divider_thickness_san . $space_san . wtbx_vc_color_styles_bg($divider_color) . $divider_rounded . '}';
		$js_styles .= $unique_class_css.' .wtbx_vc_styled_heading_inner .wtbx_heading_el_divider:last-of-type:before {' . $divider_length_san . $divider_thickness_san . $space_san . wtbx_vc_color_styles_bg($divider_color) . $divider_rounded . '}';
	}
}

if ( $responsiveness !== '' ) {
	if ( $tablet_portrait !== '' && intval($tablet_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 979px) {' . $unique_class_css.' .wtbx_heading_el_title {font-size:' . intval($tablet_portrait) . '%} }';
	}
	if ( $mobile_landscape !== '' && intval($mobile_landscape) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 767px) {' . $unique_class_css.' .wtbx_heading_el_title {font-size:' . intval($mobile_landscape) . '%} }';
	}
	if ( $mobile_portrait !== '' && intval($mobile_portrait) < 100 ) {
		$js_styles .= '@media only screen and (max-width: 479px) {' . $unique_class_css.' .wtbx_heading_el_title {font-size:' . intval($mobile_portrait) . '%} }';
	}
}

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container clearfix">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner'.$clearfix.'">';

if ( $style === 'with_line_top' ) {
	$output .= $divider . $heading;
} elseif ( $style === 'with_line_bottom' ) {
	$output .= $heading . $divider;
} elseif ( $style === 'with_line_side' ) {
	if ( $alignment === 'align_left' || $alignment === '' ) {
		$output .= $divider . $heading;
	} elseif ( $alignment === 'align_right' ) {
		$output .= $heading . $divider;
	} elseif ( $alignment === 'align_center' ) {
		$output .= $divider . $heading . $divider;
	}
} else {
	$output .= $heading;
}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;