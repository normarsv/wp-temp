<?php
$output = $title = $tab_id = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


// shortcode class
$element_class      = 'wtbx_vc_tab';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// element style
$icon_el = wtbx_vc_get_icon($icon);
$tab_title = ( !empty($title) ) ? '<div class="wtbx_tabs_nav_title">' . $title . '</div>' : '';

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class;
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// output
$output  = '';
$output .= '<div class="' . esc_attr($css_class) . '" id="'.esc_attr($tab_id).'">';


// shortcode

$output .= '<div class="wtbx_tab_nav_mobile">';
$output .= '<a class="wtbx_tab_mobile_link wtbx_ui_accordion_item" href="#'.esc_attr($tab_id).'">' . $icon_el . $tab_title . '</a>';
$output .= '</div>';
$output .= '<div class="wtbx_tab_inner">';
$output .= '<div class="wtbx_tab_wrapper wtbx_ui_accordion_tab">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';

$output .= '</div>';

echo $output;