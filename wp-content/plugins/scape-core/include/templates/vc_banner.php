<?php
$output = $link = $el_class = $unique_class = $style = $color_overlay = $hover = $overlay_hover = $content_anim =
$title_typography = $subtitle_typography = $radius = $title_text = $subtitle_text = $lazy = $preloader = $alignment =
$button_type = $button_text = $overlay_h = $color_overlay_h = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-banner' );
wtbx_vc_script_queue( 'scape-banner' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_banner';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$alignment !== '' ? $shortcode_class[] = 'wtbx_' . $alignment : null;
$hover !== '' ? $shortcode_class[] = 'wtbx_hover_' . $hover : null;
//$overlay_hover !== '' ? $shortcode_class[] = 'wtbx_overlay_' . $overlay_hover : null;
$content_anim !== '' && ( $alignment === 'align_left' || $alignment === 'align_right' ) ? $shortcode_class[] = 'wtbx_content_anim' : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// image
$valid_image = false;
$ratio = '1:1';
if ( $image ) {
	$metadata = wp_get_attachment_metadata( $image );
	if ( isset($metadata['width']) && isset($metadata['height']) ) {
		$ratio = $metadata['width'] . ':' . $metadata['height'];
	}
	$valid_image = true;
}

// colors
$color_overlay      = wtbx_vc_color_styles_bg($overlay);
$color_title        = wtbx_vc_color_styles_text($title_color);
$color_subtitle     = wtbx_vc_color_styles_text($subtitle_color);
$color_shadow       = wtbx_vc_color_styles_shadow($overlay, '0 15px 50px -5px', '0.5');


// text typography
$typography_title       = wtbx_font_styling($title_typography);
$typography_subtitle    = wtbx_font_styling($subtitle_typography);

// button
$a_href = $a_title = $a_target = $a_rel = '';
if ( $link !== '' ) {
	$link       = ($link=='||') ? '' : $link;
	$link       = vc_build_link($link);
	$a_href     = $link['url'] !== '' ?' href="'.esc_url($link['url']).'"' : '';
	$a_title    = $link['title'] !== '' ? ' title="'.esc_attr($link['title']).'"' : '';
	$a_target   = ($link['target'] != '') ? ' target="'.trim(esc_attr($link['target'])).'"' : ' target="_self"';
	$a_rel      = $link['rel'] !== '' ? ' rel="'.esc_attr($link['rel']).'"' : '';
}

// output
$output  = '';
$output .= '<div class="wtbx_with_image' . $this->getExtraClass( $anim_class ) . ' ' . esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$min_height !== '' ? $js_styles .= $unique_class_css.' .wtbx_banner_content {min-height:' . intval($min_height) . 'px}' : null;
$radius !== '' ? $js_styles .= $unique_class_css.' .wtbx_banner_wrapper {border-radius:' . intval($radius) . 'px}' : null;
$padding !== '' ? $js_styles .= wtbx_vc_scape_design_responsive('', $padding, '', $unique_class_css.' .wtbx_banner_wrapper') : null;
$color_overlay !== '' ? $js_styles .= $unique_class_css.' .wtbx_banner_bg:after {' . $color_overlay . '}' : null;
$color_shadow !== '' && $hover === 'mousemove' && $style === 'style_2' ? $js_styles .= $unique_class_css.'.wtbx_hover_mousemove .wtbx_banner_wrapper:hover {' . $color_shadow . '}' : null;
$color_title !== '' || $typography_title !== '' ? $js_styles .= $unique_class_css.' .wtbx_banner_title {' . $color_title . $typography_title . '}' : null;
$color_subtitle !== '' || $typography_subtitle !== '' ? $js_styles .= $unique_class_css.' .wtbx_banner_subtitle {' . $color_subtitle . $typography_subtitle . '}' : null;

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
		$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner wtbx_preloader_cont">';
			$output .= '<div class="wtbx-rollhover-container">';
				$output .= $valid_image ? wtbx_vc_preloader($lazy, $preloader) : '';
				$output .= '<a '.$a_href.$a_title.$a_target.$a_rel.' class="wtbx_banner_wrapper touchhover'.wtbx_vc_reveal_class($lazy) . ($hover === 'mousemove' ? ' wtbx-rollhover' : '') . '">';
					$output .= '<div class="wtbx_banner_bg">';
					$output .= wtbx_image_smart_crop( $image, 'medium', 'full', false, wtbx_get_alt_text($image), '', true, $lazy );
					$output .= '</div>';

					$output .= '<div class="wtbx_banner_content" data-layer="1">';
						$output .= '<'.esc_html($title_wrapper).' class="wtbx-rollhover-layer wtbx_banner_title" data-layer="2"><span>' . esc_html($title_text) . '</span></'.esc_html($title_wrapper).'>';
						$output .= '<'.esc_html($subtitle_wrapper).' class="wtbx-rollhover-layer wtbx_banner_subtitle" data-layer="2"><span>' . esc_html($subtitle_text) . '</span></'.esc_html($subtitle_wrapper).'>';
					$output .= '</div>';
					if ( $button_text !== '' ) {
						$output .= '<div class="wtbx-rollhover-layer wtbx_banner_button" data-layer="2">'.esc_html($button_text).'<span></span></div>';
					}

				$output .= $button_type === '' ? '</a>' : '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE.bannerMousemove) {SCAPE.bannerMousemove.init();}</script>";
}