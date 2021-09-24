<?php
$output = $link = $el_class = $unique_class = $style = $icon = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

$pattern_w = '/^(\d*(?:\.\d+)?)\s*(px|\%)?$/';
if ( $width !== '' ) {
	$regex_width = preg_match( $pattern_w, $width, $matches_w );
	if ( isset( $matches_w[1] ) ) {
		$value = (float) $matches_w[1];
		$unit = isset( $matches_w[2] ) ? $matches_w[2] : 'px';
		$width_san = $value . $unit;
	}
}
$pattern_h = '/^(\d*(?:\.\d+)?)\s*(px)?$/';
if ( $height !== '' ) {
	$regex_height = preg_match( $pattern_h, $height, $matches_h );
	if ( isset( $matches_h[1] ) ) {
		$value = (float) $matches_h[1];
		$unit = isset( $matches_h[2] ) ? $matches_h[2] : 'px';
		$height_san = $value . $unit;
	}
}

// styles
if ( $style === 'horizontal' ) {
	$width = ( $width_san !== '' ) ? ' width:' . $width_san .';' : '';
	$height = ( $height_san !== '' ) ? ' border-top-width:' . $height_san .';' : '';
	$border_style = ( $border_style !== '' ) ? ' border-top-style:' . $border_style .';' : '';
} elseif ( $style === 'vertical' ) {
	$width = ( $width_san !== '' ) ? ' height:' . $width_san .';' : '';
	$height = ( $height_san !== '' ) ? ' border-right-width:' . $height_san .';' : '';
	$border_style = ( $border_style !== '' ) ? ' border-right-style:' . $border_style .';' : '';
} elseif ( $style === 'horizontal_icon' ) {
	$width = ( $width_san !== '' ) ? ' width:' . $width_san .';' : '';
	$height = ( $height_san !== '' ) ? ' border-top-width:' . $height_san .';' : '';
	$border_style = ( $border_style !== '' ) ? ' border-top-style:' . $border_style .';' : '';
	$icon = $icon !== '' ? wtbx_vc_get_icon($icon) : '';
} elseif ( $style === 'horizontal_text' ) {
	$width = '';
	$height = ( $height_san !== '' ) ? ' border-top-width:' . $height_san .';' : '';
	$border_style = ( $border_style !== '' ) ? ' border-top-style:' . $border_style .';' : '';
} elseif ( $style === 'vertical_icon' ) {
	$width = ( $width_san !== '' ) ? ' height:' . $width_san .';' : '';
	$height = ( $height_san !== '' ) ? ' border-right-width:' . $height_san .';' : '';
	$border_style = ( $border_style !== '' ) ? ' border-right-style:' . $border_style .';' : '';
	$icon = $icon !== '' ? wtbx_vc_get_icon($icon) : '';
} elseif ( $style === 'gradient' ) {
	$width = ( $width_san !== '' ) ? ' width:' . $width_san .';' : '';
	$b_radius = ( $height_san !== '' ) ? ' border-radius:' . $height_san .';' : '';
	$height = ( $height_san !== '' ) ? ' height:' . $height_san .';' : '';
} elseif ( $style === 'to_top' ) {
	$width = '';
	$height = ( $height_san !== '' ) ? ' border-top-width:' . $height_san .';' : '';
	$border_style = ( $border_style !== '' ) ? ' border-top-style:' . $border_style .';' : '';
	$icon = '<i class="scape-ui-chevron-up wtbx_vc_icon" aria-hidden="true"></i>';
}


// shortcode class
$element_class      = 'wtbx_vc_divider';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// element style
$shortcode_class[] = 'wtbx_style_' . $style;
( in_array($style, array('horizontal', 'gradient')) && $align !== '' ) ? $shortcode_class[] = 'wtbx_align_' . $align : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

if ( in_array($style, array('horizontal', 'vertical')) ) {
	$js_styles .= $unique_class_css.' .wtbx_vc_divider_inner {' . $width . $height . $border_style . wtbx_vc_color_styles_border($line_color) .'}';
} elseif ( in_array($style, array('horizontal_icon', 'vertical_icon', 'to_top')) ) {
	$js_styles .= $unique_class_css . ' .' . esc_attr($element_class).'_line:before {' .$width . $height . $border_style . wtbx_vc_color_styles_border($line_color) . wtbx_vc_color_styles_text($icon_color) . '}';
	$js_styles .= $unique_class_css . ' .' . esc_attr($element_class).'_icon {'.wtbx_vc_color_styles_text($icon_color).'}';
} elseif ( $style === 'gradient' ) {
	$js_styles .= $unique_class_css.' .wtbx_vc_divider_inner {' . $width . $height . $b_radius . wtbx_vc_color_styles_bg($line_color_gradient) .'}';
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

if ( in_array($style, array('horizontal_icon', 'vertical_icon')) ) {
	$output .= '<div class="'.esc_attr($element_class).'_line"></div>';
	$output .= '<div class="'.esc_attr($element_class).'_icon">'.$icon.'</div>';
	$output .= '<div class="'.esc_attr($element_class).'_line"></div>';
} elseif ( $style === 'to_top' ) {
	$output .= '<div class="'.esc_attr($element_class).'_line"></div>';
	$output .= '<a href="#top" class="'.esc_attr($element_class).'_icon">'.$icon.'</a>';
	$output .= '<div class="'.esc_attr($element_class).'_line"></div>';
} elseif ( $style === 'horizontal_text' ) {
	$output .= '<div class="'.esc_attr($element_class).'_line"></div>';
	$output .= '<div class="'.esc_attr($element_class).'_text">'.$icon.'</div>';
}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;