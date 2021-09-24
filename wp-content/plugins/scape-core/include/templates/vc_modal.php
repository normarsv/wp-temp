<?php
$output = $link = $el_class = $unique_class = $style = $overlay_color = $close_button_skin =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wtbx_vc_script_queue('scape-modal');

// shortcode class
$element_class      = 'wtbx_vc_modal';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_anim_' . $effect;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// width
$width = intval($width);
if ( $width !== '' ) {
	$width = ' max-width: ' . $width . 'px;';
}


// overlay color
$overlay = wtbx_vc_color_styles_bg($overlay_color);


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $overlay !== '' ? $unique_class_css.' .wtbx_modal_content:before {' . $overlay .  '}' : '';
$js_styles .= $unique_class_css.' .wtbx_modal_body {' . $width .  '}';

$padding_selector = $unique_class_css . ' .wtbx_modal_wrapper .wtbx_modal_content .wtbx_modal_inner';
$js_styles .= wtbx_vc_scape_design_styles($el_design, '', '', $padding_selector, '', '');

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
//$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
//$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_modal_wrapper modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'">';
	$output .= '<div class="wtbx_modal_dialog modal-dialog" role="document">';
		$output .= '<div class="wtbx_modal_content modal-content">';
			$output .= '<div class="wtbx_modal_body modal-body">';
				$output .= '<div class="wtbx_modal_close wtbx-click wtbx_skin_'.$close_button_skin.'"></div>';
				$output .= '<div class="wtbx_modal_inner">';
					$output .= wpb_js_remove_wpautop($content);
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

//$output .= '</div>';
//$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE.modal) {SCAPE.modal.init();}</script>";
}