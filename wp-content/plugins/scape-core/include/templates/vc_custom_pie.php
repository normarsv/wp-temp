<?php
$output = $anim_class = '';
$value      = 50;
$size       = 160;
$width      = 10;
$duration   = 2000;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_pie';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_skin_' . $skin;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).' wtbx_appearance_animation">';

// colors
$color_icon = wtbx_vc_color_styles_text($icon_color);

// chart color
if ( $chart_color !== '' ) {
	$chart_color = json_decode($chart_color, true);
}
$color_chart = isset($chart_color['color']) && $chart_color['color'] !== '' ? $chart_color['color'] : wtbx_vc_option('color-main-accent');

// track color
if ( $track_color !== '' ) {
	$track_color = json_decode($track_color, true);
}
$color_track = isset($track_color['color']) && $track_color['color'] !== '' ? $track_color['color'] : '';

// icon markup
$icon_el = wtbx_vc_get_icon($icon);

// size
$svg_size = ' width="'.esc_attr(intval($size)).'" height="'.esc_attr(intval($size)).'"';
$r = $size/2 - intval($width);

// value
$label_value = $label_value !== '' ? intval($label_value) : intval($value);

// ratio
$ratio = $style === 'style_3' ? 0.75 : 1;

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$js_styles .= $color_icon !== '' ? $unique_class_css.' .wtbx_pie_wrapper .wtbx_vc_icon {' . $color_icon . '}' : '';
$js_styles .= $duration !== '' ? $unique_class_css.' svg .bar {-webkit-transition-duration:' . $duration . 'ms;-moz-transition-duration:' . $duration . 'ms;-ms-transition-duration:' . $duration . 'ms;-o-transition-duration:' . $duration . 'ms;transition-duration:' . $duration . 'ms;}' : '';

if ( $style === 'style_1' || $style === 'style_3' ) {
	$js_styles .= $unique_class_css.' .wtbx_pie_value {font-size:' . ($r/3) . 'px}';
}
if ( $style === 'style_2' || $style === 'style_3' ) {
	$js_styles .= $unique_class_css.' .wtbx_vc_icon {font-size:' . ($r/2.9) . 'px}';
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
		$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';
			$output .='<div class="wtbx_pie_cont" data-label="' . esc_attr(intval($label_value) * $ratio) . '"data-value="' . esc_attr(intval($value) * $ratio) . '" data-ratio="'.(1-$ratio).'" data-duration="'.$duration.'">';
				$output .= '<div class="wtbx_pie_wrapper">';
					$output .= '<svg'.$svg_size.' viewPort="0 0 '.esc_attr((intval($size)/2)).' '.esc_attr((intval($size)/2)).'" version="1.1" xmlns="http://www.w3.org/2000/svg">';
						if ( $track_color !== '' ) {
							$output .= '<circle stroke-linecap="round" stroke-width="'.esc_attr(intval($width)).'" r="'.$r.'" cx="'.esc_attr(intval($size)/2).'" cy="'.esc_attr(intval($size)/2).'" fill="transparent" stroke="'.esc_attr($color_track).'" stroke-dasharray="'.esc_attr(pi()*($r*2)*$ratio).'"></circle>';
						}
						$output .= '<circle class="bar" stroke-linecap="round" stroke-width="'.esc_attr(intval($width)).'" r="'.esc_attr($r).'" cx="'.esc_attr(intval($size)/2).'" cy="'.esc_attr(intval($size)/2).'" fill="transparent" stroke-dasharray="'.esc_attr(pi()*($r*2)).'" stroke-dashoffset="'.esc_attr((-pi()*($r*2))).'" stroke="'.esc_attr($color_chart).'"></circle>';
					$output .= '</svg>';

					if ( $style === 'style_1' || $style === 'style_3' ) {
						$output .= '<div class="wtbx_pie_value wtbx-text"><div>0</div><span>' . esc_html($units) . '</span>' . '</div>';
					}
					if ( $style === 'style_2' || $style === 'style_3' ) {
						$output .= $icon_el;
					}
				$output .= '</div>';

				$output .= '<div class="wtbx_pie_content">';
					if ( $style === 'style_2' ) {
						$output .= '<div class="wtbx_pie_value wtbx-text"><div>0</div><span>' . esc_html($units) . '</span>' . '</div>';
					}
					$output .= '<div class="wtbx_pie_text">';
					$output .= $title !== '' ? '<span class="wtbx_pie_title wtbx-text">' . esc_html($title) . '</span>' : '';
					$output .= $subtitle !== '' ? '<span class="wtbx_pie_subtitle wtbx-text">' . esc_html($subtitle) . '</span>' : '';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.pie.trigger(jQuery('".$unique_class_css."'));}</script>";
}