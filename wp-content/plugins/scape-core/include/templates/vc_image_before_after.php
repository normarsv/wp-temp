<?php
$output = $link = $el_class = $unique_class = $style = $radius_san = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wtbx_vc_script_queue('before-after');

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_image_before_after';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$alignment !== '' ? $shortcode_class[] = 'wtbx_' . $alignment : null;
$skin !== '' ? $shortcode_class[] = 'wtbx_skin_' . $skin : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// ratio
$ratio = 1;
$valid_image = false;
if ( $before_image && $after_image ) {
	$metadata_before = wp_get_attachment_metadata( $before_image );
	$metadata_after = wp_get_attachment_metadata( $after_image );
	if ( isset($metadata_before['width']) && isset($metadata_before['height']) ) {
		$ratio_before = $metadata_before['height'] / $metadata_before['width'];
	} else {
		$ratio_before = '1:1';
	}
	if ( isset($metadata_after['width']) && isset($metadata_after['height']) ) {
		$ratio_after = $metadata_after['height'] / $metadata_after['width'];
	} else {
		$ratio_after = '1:1';
	}
	$ratio = max($ratio_before,$ratio_after);
	$valid_image = true;
}

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$radius !== '' ? $js_styles .= $unique_class_css.' .wtbx_before_after_inner {border-radius:' . intval($radius) .  'px}' : null;
$max_width !== '' ? $js_styles .= $unique_class_css.' .wtbx_before_after {width:' . intval($max_width) .  'px}' : null;

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_before_after wtbx_preloader_cont wtbx_with_image' . $this->getExtraClass( $anim_class ).'">';
	$output .= $valid_image ? wtbx_vc_preloader($lazy, $preloader) : '';
		$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
			$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';
				$output .= '<div class="ba-slider wtbx_before_after_inner'.wtbx_vc_reveal_class($lazy).'">';
					$output .= wtbx_image_smart_img($after_image, 'medium', 'full', wtbx_get_alt_text($after_image), 'wtbx_before_after_image wtbx_after_image', true, $lazy);
					$output .= '<div class="resize">';
						$output .= wtbx_image_smart_img($before_image, 'medium', 'full', wtbx_get_alt_text($before_image), 'wtbx_before_after_image wtbx_before_image', true, $lazy);
					$output .= '</div>';
					$output .= '<div class="handle"><span class="drag-inner wtbx-click"></span></div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;
if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.beforeAfter(jQuery('.wtbx_before_after_inner:not(.initialized)'));}</script>";
}
