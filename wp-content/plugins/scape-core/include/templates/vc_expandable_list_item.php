<?php

$title = $el_class =  $bullet = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// shortcode class
$element_class      = 'wtbx_vc_exp_list_item';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// bullet markup
if ( $bullet_style === 'default' ) {
	$bullet = '<div class="wtbx_exp_list_bullet_plus"></div>';
	$shortcode_class[]  = 'wtbx_with_bullet';
} elseif ( $bullet_style === 'icon' && $bullet_icon !== '' ) {
	$bullet = wtbx_vc_get_icon($bullet_icon);
	$shortcode_class[]  = 'wtbx_with_icon';
} elseif ( $bullet_style === 'text' && $bullet_style !== '' ) {
	$bullet = '<div class="wtbx_vc_list_item_bullet_text">'.$bullet_text.'</div>';
	$shortcode_class[]  = 'wtbx_with_text';
}

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// output
$output  = '';
$output .= '<div class="wtbx_vc_child_container">';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;

// shortcode
$output .= '<div class="wtbx_exp_list_item_inner">';

	$output .= '<div class="wtbx_exp_list_title_wrapper wtbx-click">';

		$output .= '<div class="wtbx_exp_list_bullet">';
			$output .= $bullet;
		$output .= '</div>';

		$output .= '<div class="wtbx_exp_list_title">';
			$output .= '<div class="wtbx_exp_list_title_wrap">';
				$output .= wpb_js_remove_wpautop($title);
			$output .= '</div>';
		$output .= '</div>';

	$output .= '</div>';

	$output .= '<div class="wtbx_exp_list_content_wrapper">';
		$output .= '<div class="wtbx_exp_list_content">';
			$output .= wpb_js_remove_wpautop($content, true);
		$output .= '</div>';
	$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;