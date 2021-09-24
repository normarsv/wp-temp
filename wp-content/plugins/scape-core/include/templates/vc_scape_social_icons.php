<?php
$output = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-socialicons' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_social_icons';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$alignment !== '' ? $shortcode_class[] = 'wtbx_align_' . $alignment : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// colors
$color_text_default = wtbx_vc_color_styles_text($color_default);
$color_bg_default = wtbx_vc_color_styles_bg($bg_default);
$color_text_hover = wtbx_vc_color_styles_text($color_hover);
$color_bg_hover = wtbx_vc_color_styles_bg($bg_hover);
$color_border = wtbx_vc_color_styles_border($bg_default);


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( in_array( $style, array('style_1', 'style_2') ) ) {
	$js_styles .= $color_text_default !== '' ? $unique_class_css.' a:not(:hover) i {' . $color_text_default .'}' : '';
	$js_styles .= $color_text_hover !== '' ? $unique_class_css.' a:hover i {' . $color_text_hover .'}' : '';
} elseif ( in_array( $style, array('style_3', 'style_4') ) ) {
	$js_styles .= $color_text_default !== '' ? $unique_class_css.' a:not(:hover) i {' . $color_text_default .'}' : '';
	$js_styles .= $color_text_hover !== '' ? $unique_class_css.' a:hover i {' . $color_text_hover .'}' : '';
	$js_styles .= $color_bg_default !== '' ? $unique_class_css.' a:not(:hover) {' . $color_bg_default .'}' : '';
	$js_styles .= $color_bg_hover !== '' ? $unique_class_css.' a:hover {' . $color_bg_hover .'}' : '';
} elseif ( $style === 'style_5' ) {
	$js_styles .= $color_text_default !== '' ? $unique_class_css.'.wtbx_style_5 .wtbx_social_icon .wtbx_social_icon_front {' . $color_text_default .'}' : '';
	$js_styles .= $color_text_hover !== '' ? $unique_class_css.'.wtbx_style_5 .wtbx_social_icon .wtbx_social_icon_back {' . $color_text_hover .'}' : '';
	$js_styles .= $color_bg_default !== '' ? $unique_class_css.'.wtbx_style_5 .wtbx_social_icon .wtbx_social_icon_front {' . $color_bg_default .'}' : '';
	$js_styles .= $color_bg_hover !== '' ? $unique_class_css.'.wtbx_style_5 .wtbx_social_icon .wtbx_social_icon_back {' . $color_bg_hover .'}' : '';
} elseif (  $style === 'style_6' ) {
	$js_styles .= $color_text_default !== '' ? $unique_class_css.'.wtbx_style_6 .wtbx_social_icon i {' . $color_text_default .'}' : '';
	$js_styles .= $color_text_hover !== '' ? $unique_class_css.'.wtbx_style_6 .wtbx_social_icon a:hover i {' . $color_text_hover .'}' : '';
	$js_styles .= $color_bg_hover !== '' ? $unique_class_css.'.wtbx_style_6 .wtbx_social_icon a:before {' . $color_bg_hover .'}' : '';
} elseif ( $style === 'style_7' ) {
	$js_styles .= $color_text_default !== '' ? $unique_class_css.'.wtbx_style_7 .wtbx_social_icon .wtbx_social_icon_front {' . $color_text_default .'}' : '';
	$js_styles .= $color_text_hover !== '' ? $unique_class_css.'.wtbx_style_7 .wtbx_social_icon .wtbx_social_icon_back {' . $color_text_hover .'}' : '';
	$js_styles .= $color_bg_default !== '' ? $unique_class_css.'.wtbx_style_7 .wtbx_social_icon a {' . $color_border .'}' : '';
	$js_styles .= $color_bg_hover !== '' ? $unique_class_css.'.wtbx_style_7 .wtbx_social_icon .wtbx_social_icon_back {' . $color_bg_hover .'}' : '';
}


$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<ul class="wtbx_social_icons_wrapper' . $this->getExtraClass( $anim_class ) . '">';

$keys = $networks !== '' ? explode(',', $networks) : '';
$variants = wtbx_vc_social_networks();

if ( $keys ) {
	foreach ( $keys as $key ) {
		$url = wtbx_vc_option('social_'.$key);
		if ( $url !== '' && isset($variants[$key][1]) ) {

			if ( in_array( $style, array('style_1', 'style_2', 'style_3', 'style_4', 'style_6') ) ) {
				$output .= '<li class="wtbx_social_icon wtbx_vc_child_container '.$key.' wtbx_size_'.$size.'">';
				$output .= '<a class="wtbx_'.$style.' wtbx_default_'.$color_type_default.' wtbx_hover_'.$color_type_hover.' wtbx_default_bg_'.$bg_type_default.' wtbx_hover_bg_'.$bg_type_hover.'" href="'.$url.'"' . ( wtbx_option('social_open_blank') === '1' ? ' target="_blank"' : '' ) . '>';
				$output .= '<i class="'.$variants[$key][1].'"></i>';
				$output .= '</a>';
				$output .= '</li>';
			} else {
				$output .= '<li class="wtbx_social_icon wtbx_vc_child_container '.$key.' wtbx_size_'.$size.'">';
				$output .= '<a class="wtbx_'.$style.' wtbx_default_'.$color_type_default.' wtbx_hover_'.$color_type_hover.' wtbx_default_bg_'.$bg_type_default.' wtbx_hover_bg_'.$bg_type_hover.'" href="'.$url.'"' . ( wtbx_option('social_open_blank') === '1' ? ' target="_blank"' : '' ) . '>';
				$output .= '<i class="'.$variants[$key][1].' wtbx_social_icon_front"></i>';
				$output .= '<i class="'.$variants[$key][1].' wtbx_social_icon_back"></i>';
				$output .= '</a>';
				$output .= '</li>';
			}
		}
	}
}

$output .= '</ul>';


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
