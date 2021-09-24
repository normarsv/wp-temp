<?php
$output = $link = $el_class = $unique_class = $style = $button = $inner = $margin = $skin = $arrow =
$size = $margin = $padding = $border_radius = $border_radius_h ='';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_button';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$align_small !== '' ? $shortcode_class[] = 'wtbx_block_' . $align_small : null;

// element style
$shortcode_class[] = 'wtbx_style_arrow';
$shortcode_class[] = 'wtbx_type_' . $style;
$shortcode_class[] = 'wtbx_skin_' . $skin;
$shortcode_class[] = 'wtbx_size_' . $size;
$display !== '' ? $shortcode_class[] = 'wtbx_' . $display : null;
$button_width !== '' ? $shortcode_class[] = 'wtbx_button_fullwidth' : null;
if ( $display === 'display_block' && $button_align !== '' ) $shortcode_class[] = 'wtbx_' . $button_align;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// link
$a_href = $a_title = $a_target = $a_rel = $lightbox = $lightbox_class = $custom_code = '';
if ( $action === 'link' ) {
	$link                   = ($link=='||') ? '' : $link;
	$link                   = vc_build_link($link);
	$a_href                 = $link['url'] !== '' ?' href="'.esc_url($link['url']).'"' : '';
	$a_title                = $link['title'] !== '' ? ' title="'.esc_attr($link['title']).'"' : '';
	$a_target               = ($link['target'] != '') ? ' target="'.trim(esc_attr($link['target'])).'"' : ' target="_self"';
	$a_rel                  = $link['rel'] !== '' ? ' rel="'.esc_attr($link['rel']).'"' : '';
} elseif ( $action === 'video' && $video_url !== '' ) {
	$lightbox = ' data-dynamic="1" data-iframe="1" data-dynamicel="' . esc_url(json_encode($video_url)) . '"' . wtbx_lightbox_attributes($poster);
	$lightbox_class = ' wtbx-lightbox-item';
} elseif ( $action === 'custom' && $custom_action !== '' ) {
	$custom_code = rawurldecode( base64_decode( strip_tags( $custom_action ) ) );
	$custom_code = wpb_js_remove_wpautop( apply_filters( 'vc_raw_html_module_content', $custom_code ) );
	$custom_code = ' onclick="' . esc_attr($custom_code) . '"';
}


// text typography
$typography_string = wtbx_font_styling($text_typography);


// styles
$margin                 = wtbx_vc_scape_design($margin);
$padding                = wtbx_vc_scape_design($padding);
$border_radius          = wtbx_vc_scape_design($border_radius);
$border_radius_h        = wtbx_vc_scape_design($border_radius_h);

$color_bg               = wtbx_vc_color_styles_bg($accent_color);
$color_text             = wtbx_vc_color_styles_text($accent_color);
$link_color_accent      = wtbx_vc_get_color($accent_color);

// markup
$arrow = $style !== 'round' ? wtbx_vc_arrow('right') : '';
$inner = '<span class="wtbx_button_inner">' . esc_html($title) . '</span>' . $arrow;

$button .= '<a '.$a_href.$a_title.$a_target.$a_rel.' class="wtbx-button wtbx-button-arrow'.$lightbox_class.$this->getExtraClass( $el_class ).'"'.$lightbox.$custom_code.'>' . $inner . '</a>';

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_button_container .wtbx_vc_button_inner .wtbx-button {' . $typography_string . '}' : null;
$margin !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow .wtbx_vc_button_container .wtbx-button {' . $margin . '}' : null;

if ( $style === 'simple' ) {
	if ( $skin === 'light' ) {
		$color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_simple .wtbx_vc_button_inner .wtbx-button:hover .wtbx_button_inner {' . $color_text . '}' : null;
		$link_color_accent !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_simple .wtbx_vc_button_inner .wtbx-button:hover .bar,'.$unique_class_css.'.wtbx_style_arrow.wtbx_type_simple .wtbx_vc_button_inner .wtbx-button:hover .chevron {fill:' . $link_color_accent . '}' : null;
	} else {
		$color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_simple .wtbx_vc_button_inner .wtbx-button {' . $color_bg . '}' : null;
	}
} else if ( $style === 'square' ) {
	if ( $skin === 'light' ) {
		$color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_square .wtbx_vc_button_inner .wtbx-button:hover .wtbx_button_inner {' . $color_text . '}' : null;
		$link_color_accent !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_square .wtbx_vc_button_inner .wtbx-button:hover .bar,'.$unique_class_css.'.wtbx_style_arrow.wtbx_type_square .wtbx_vc_button_inner .wtbx-button:hover .chevron {fill:' . $link_color_accent . '}' : null;
	} else {
		$color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_square .wtbx_vc_button_inner .wtbx-button {' . $color_bg . '}' : null;
	}
} else if ( $style === 'round' ) {
	if ( $skin === 'light' ) {
		$color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_round .wtbx_vc_button_inner .wtbx-button:before {' . $color_bg . '}' : null;
	} else {
		$color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_arrow.wtbx_type_round .wtbx_vc_button_inner .wtbx-button {' . $color_bg . '}' : null;
	}
}


$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner"'.($tooltip !== '' ? ' data-tooltip="' . esc_html($tooltip) . '"' : '').'>';

$output .= $button;

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
