<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$height = $unique_class = $el_class = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$element_class      = 'wtbx_vc_content_block';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

if ( $block ) {
	$block = wtbx_get_translated_content_block($block);
	$s_ID = get_post($block);
	$content = $s_ID->post_content;
	$content = apply_filters('the_content', $content);
	$output .= $content;
}

$output .= '</div>';

echo $output;
