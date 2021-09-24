<?php
$output = $title = $tab_id = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


// shortcode class
$element_class      = 'wtbx_vc_step';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// element style
$icon_el = wtbx_vc_get_icon($icon);
$step_title = ( isset($title) ) ? '<div class="wtbx_steps_nav_title">' . $title . '</div>' : '';

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class;
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// output
$output  = '';
$output .= '<div class="' . esc_attr($css_class) . '"id="wtbx_step-'.$step_id.'">';


// shortcode

$output .= '<div class="wtbx_step_inner">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

$output .= '</div>';

echo $output;