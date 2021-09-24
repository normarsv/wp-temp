<?php
$output = $el_class = $unique_class = $style =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay);

// shortcode class
$element_class      = 'wtbx_vc_content_slide';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner wtbx_vc_row">';

$output .= '<div class="wtbx_content_slide_inner">';
$output .= wpb_js_remove_wpautop($content, true);
$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
