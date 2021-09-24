<?php
$output = $el_class = $unique_class = $style = $feature = $bullet_style =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// shortcode class
$element_class      = 'wtbx_vc_pricing_box_feature';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$bullet_style !== '' ? $shortcode_class[] = 'wtbx_bullet_align_' . $bullet_align : null;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner wtbx-text"'.($tooltip !== '' ? ' data-tooltip="' . esc_html($tooltip) . '"' : '').'>';

$output .= $bullet_align === 'right' ? esc_html($feature) : '';

if ( $bullet_style === 'bold' && $bullet_text !== '' ) {
	$output .= '<span class="wtbx_pricing_box_feature_bold">' . esc_html($bullet_text) . '</span>';
}
if ( $bullet_style === 'badge' && $bullet_badge !== '' ) {
	$output .= '<span class="wtbx_pricing_box_feature_badge">' . esc_html($bullet_badge) . '</span>';
}
if ( $bullet_style === 'icon' && $bullet_icon !== '' ) {
	$output .= '<span class="wtbx_pricing_box_feature_icon">' . wtbx_vc_get_icon($bullet_icon) . '</span>';
}

$output .= $bullet_align === 'left' ? esc_html($feature) : '';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
