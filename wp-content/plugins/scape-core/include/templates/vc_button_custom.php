<?php
$output = $link = $el_class = $unique_class = $style = $button = $inner = $icon_pos = $icon = $padding = $margin =
$border_radius = $border_radius_h = $button_width = $button_align = $video_url = $action = $custom_action =
$text_color = $text_color_h = $bg_color = $bg_color_h = $border_color = $border_color_h = $title = $tooltip = '';

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
$shortcode_class[] = 'wtbx_style_custom';
$shortcode_class[] = 'wtbx_size_' . $size;
$display !== '' ? $shortcode_class[] = 'wtbx_' . $display : null;
$button_width !== '' ? $shortcode_class[] = 'wtbx_button_fullwidth' : null;
$shift !== '' ? $shortcode_class[] = $shift : null;
$no_border !== '' ? $shortcode_class[] = 'wtbx_noborder' : null;
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


// icon markup
$icon_el = wtbx_vc_get_icon($icon);


// text typography
$typography_string = wtbx_font_styling($text_typography);


// styles
$margin             = wtbx_vc_scape_design($margin);
$padding            = wtbx_vc_scape_design($padding);
$border_radius      = wtbx_vc_scape_design($border_radius);
$border_radius_h    = wtbx_vc_scape_design($border_radius_h);


// colors
$color_text             = wtbx_vc_color_styles_text($text_color);
$color_text_h           = wtbx_vc_color_styles_text($text_color_h);
$color_bg               = wtbx_vc_color_styles_bg($bg_color);
$color_bg_h             = wtbx_vc_color_styles_bg($bg_color_h);
$color_border           = wtbx_vc_color_styles_border($border_color, '');
$color_border_h         = wtbx_vc_color_styles_border($border_color_h, '');
if ( $border !== '' ) {
	$border_style = 'border: ' . intval($border) . 'px solid ' . $color_border;
	$border_style_h = 'border: ' . intval($border) . 'px solid ' . $color_border_h;
}


// markup
if ( $icon_pos === 'icon-right' ) {
	$inner = '<span class="wtbx_button_inner">' . esc_html($title) . '</span>' . $icon_el;
} else {
	$inner = $icon_el . '<span class="wtbx_button_inner">' . esc_html($title) . '</span>';
}


$button .= '<a '.$a_href.$a_title.$a_target.$a_rel.' class="wtbx-button wtbx-button-custom'.$lightbox_class.$this->getExtraClass( $el_class ).'"'.$lightbox.$custom_code.'>' . $inner . '</a>';

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$margin !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_button_container .wtbx_vc_button_inner {' . $margin . '}' : null;
$typography_string !== '' || $padding !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_button_container .wtbx_vc_button_inner .wtbx-button {' . $typography_string . $padding . '}' : null;
$color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_custom .wtbx-button-custom {' . $color_text .  '}' : null;
$color_text_h !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_custom .wtbx-button-custom:hover {' . $color_text_h . '}' : null;
$color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_custom .wtbx-button.wtbx-button-custom:before {' . $color_bg . '}' : null;
$color_bg_h !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_custom .wtbx-button.wtbx-button-custom:after {' . $color_bg_h . '}' : null;
$border_radius !== '' ? $js_styles .= $unique_class_css.' .wtbx-button-custom,'.$unique_class_css.' .wtbx-button-custom:before, '.$unique_class_css.' .wtbx-button-custom:after {' . $border_radius . '}' : null;
$border_radius_h !== '' ? $js_styles .= $unique_class_css.' .wtbx-button-custom:hover,'.$unique_class_css.' .wtbx-button-custom:hover:before, '.$unique_class_css.' .wtbx-button-custom:hover:after {' . $border_radius_h . '}' : null;
if ( $border !== '' ) {
	$color_border !== '' ? $js_styles .= $unique_class_css.' .wtbx-button-custom:before, '.$unique_class_css.' .wtbx-button-custom:after {' . $border_style . '}' : null;
	$color_border_h !== '' ? $js_styles .= $unique_class_css.' .wtbx-button-custom:hover:before, '.$unique_class_css.' .wtbx-button-custom:hover:after {' . $border_style_h . '}' : null;
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
