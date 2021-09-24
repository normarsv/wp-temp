<?php
$output = $link = $el_class = $unique_class = $style = $type = $message_icon = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_message';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_type_' . $type;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// icon
if ( $show_icon === 'yes' ) {
	$icon_array = array(
		'informational' => 'scape-ui-information-filled',
		'warning'       => 'scape-ui-warning-filled',
		'success'       => 'scape-ui-check',
		'error'         => 'scape-ui-x'
	);

	if ( $icon !== '' ) {
		$message_icon = wtbx_vc_get_icon($icon);
	} else {
		$message_icon = '<i class="' . esc_attr($icon_array[$type]) . '"></i>';
	}
}



// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

if ( $style === 'style_default' || $style === 'style_modern' ) {
	$radius !== '' ? $js_styles .= $unique_class_css.' .wtbx_message_wrapper {border-radius:' . intval($radius) .  'px}' : null;
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';
$output .= '<div class="wtbx_message_wrapper">';
$output .= '<div class="wtbx_table wtbx_message_inner">';
$output .= $message_icon !== '' ? '<div class="wtbx_table_cell wtbx_message_icon">' . $message_icon . '</div>' : '';
$output .= '<div class="wtbx_table_cell wtbx_message_content">' . wpb_js_remove_wpautop($content, true) . '</div>';
$output .= $show_dismiss === 'yes' ? '<div class="wtbx_table_cell wtbx_message_dismiss"><span class="wtbx_message_button wtbx-click"></span></div>' : '';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;