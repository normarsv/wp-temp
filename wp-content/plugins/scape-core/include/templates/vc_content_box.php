<?php
$output = $link = $el_class = $unique_class = $style = $width_san = $height_san = $equal_height =
$contrast_color = $scale_hover = $hover_anim = $vertical_align = $overflow = $horizontal_align = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// box size
$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%)?$/';
if ( $width !== '' ) {
	$regex_width = preg_match( $pattern, $width, $matches_w );
	if ( isset( $matches_w[1] ) ) {
		$value = (float) $matches_w[1];
		$unit = isset( $matches_w[2] ) ? $matches_w[2] : 'px';
		$width_san = ' max-width:' . $value . $unit . ';';
	}
}
if ( $height !== '' ) {
	$height = intval($height);
}

// shortcode class
$element_class      = 'wtbx_vc_content_box';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$textalign_small !== '' ? $shortcode_class[] = 'wtbx_center_align_' . $textalign_small : null;

// element style
$shortcode_class[] = 'wtbx_' . $style;
( in_array($style, array('style_1', 'style_2', 'style_3')) ) ? $shortcode_class[] = 'wtbx_' . $hover_anim : null;
$contrast_color !== '' ? $shortcode_class[] = 'wtbx_contrast_color' : null;
$alignment !== '' ? $shortcode_class[] = 'wtbx_' . $alignment : null;
$vertical_align !== '' ? $shortcode_class[] = 'wtbx_vertical_' . $vertical_align : null;
$horizontal_align !== '' ? $shortcode_class[] = 'wtbx_content_' . $horizontal_align : null;
$style === 'style_custom' ? $shortcode_class[] = 'wtbx_' . $shadow : null;
$style === 'style_custom' ? $shortcode_class[] = 'wtbx_hover_' . $shadow_hover : null;
$style === 'style_custom' ? $shortcode_class[] = 'wtbx_border_' . $border_hover : null;
$style === 'style_custom' ? $shortcode_class[] = 'wtbx_scale_' . $scale_hover : null;
$equal_height !== '' ? $shortcode_class[] = 'wtbx_equal_height' : null;
$overflow !== '' ? $shortcode_class[] = 'wtbx_overflow' : null;
$equal_start = $equal_height !== '' ? ' data-equal="'.$equal_height.'"' : '';

// construct link
$link = wtbx_vc_build_link($link, 'wtbx_content_box_link');

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'"'.$equal_start.'>';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $bg_color !== '' ? $unique_class_css.' .wtbx_content_box_bg_idle {' . wtbx_vc_color_styles_bg($bg_color) .'}' : '';
$js_styles .= $bg_color_hover !== '' ? $unique_class_css.' .wtbx_vc_content_box_inner .wtbx_content_box_bg_hover {' . wtbx_vc_color_styles_bg($bg_color_hover) .'}' : '';

$js_styles .= $width_san !== '' ? $unique_class_css.' .wtbx_vc_content_box_inner {'.$width_san.'}' : '';
$js_styles .= $height !== '' ? $unique_class_css.' .wtbx_vc_content_box_inner, '.$unique_class_css.' .wtbx_content_box_container {min-height:'.$height.'px}' : '';

//if ( $style === 'style_custom' ) {
	$margin_selector    = $unique_class_css . ' .' . $element_class . '_inner';
	$border_selector    = $unique_class_css . ' .wtbx_content_box_bg,'. $unique_class_css . ' .wtbx_content_box_container';
	$padding_selector   = $unique_class_css . ' .wtbx_content_box_container';
	$zindex_selector    = $unique_class_css;
	$js_styles .= wtbx_vc_scape_design_styles($el_design, $margin_selector, $border_selector, $padding_selector, '', $zindex_selector);

	$color_border = wtbx_vc_color_styles_border($border_color);
	$js_styles .= $color_border !== '' ? $unique_class_css.'.wtbx_vc_content_box .wtbx_content_box_bg {' . $color_border .'}' : '';
//}
$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container wtbx_equal_height_cont clearfix">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner wtbx_equal_height_cont clearfix">';

$output .= '<div class="wtbx_content_box_bg wtbx_content_box_bg_idle"></div>';
( $bg_color_hover !== '' ) ? $output .= '<div class="wtbx_content_box_bg wtbx_content_box_bg_hover"></div>' : '';
$output .= '<div class="wtbx_content_box_container">';
	$output .= '<div class="wtbx_content_box_wrapper">';
		$output .= '<div class="wtbx_content_box_content">';
			$output .= wpb_js_remove_wpautop( $content );
		$output .= '</div>';
	$output .= '</div>';
	$output .= $link['open'];
	$output .= $link['close'];
$output .= '</div>';


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
