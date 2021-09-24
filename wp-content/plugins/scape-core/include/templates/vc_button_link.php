<?php
$output = $link = $el_class = $unique_class = $style = $button = $inner = $icon_pos = $icon =
$padding = $margin = $border_radius = $border_radius_h = '';

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
$shortcode_class[] = 'wtbx_style_link';
$shortcode_class[] = 'wtbx_size_' . $size;
$display !== '' ? $shortcode_class[] = 'wtbx_' . $display : null;
$button_width !== '' ? $shortcode_class[] = 'wtbx_button_fullwidth' : null;
if ( $display === 'display_block' && $button_align !== '' ) $shortcode_class[] = 'wtbx_' . $button_align;
if ( $link_decoration === 'underline' ) $shortcode_class[] = 'wtbx_link_decoration';
if ( $link_arrow !== '' ) $shortcode_class[] = 'wtbx_' . $link_arrow;


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
$link_color_text        = wtbx_vc_color_styles_text($link_color);
$link_color_bg          = wtbx_vc_color_styles_bg($link_color);
$link_color_border      = wtbx_vc_color_styles_border($link_color);
$link_color_text_h      = wtbx_vc_color_styles_text($link_color_h);
$link_color_bg_h        = wtbx_vc_color_styles_bg($link_color_h);
$link_color_border_h    = wtbx_vc_color_styles_border($link_color_h);
$link_color_general     = wtbx_vc_get_color($link_color);
$link_color_general_h   = wtbx_vc_get_color($link_color_h);


// markup
if ( $icon_pos === 'icon-right' ) {
	$inner = '<span class="wtbx_button_inner">' . esc_html($title) . '</span>' . $icon_el;
} else {
	$inner = $icon_el . '<span class="wtbx_button_inner">' . esc_html($title) . '</span>';
}


$arrow_left = $link_arrow === 'arrow_left' ? wtbx_vc_arrow('left') : '';
$arrow_right = $link_arrow === 'arrow_right' ? wtbx_vc_arrow('right') : '';
$button .= '<a '.$a_href.$a_title.$a_target.$a_rel.' class="wtbx-button wtbx-button-link'.$lightbox_class.$this->getExtraClass( $el_class ).'"'.$lightbox.$custom_code.'>' . $arrow_left . $inner . $arrow_right . '</a>';

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$margin !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_button_container .wtbx_vc_button_inner {' . $margin . '}' : null;
$typography_string !== '' || $padding !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_button_container .wtbx_vc_button_inner .wtbx-button {' . $typography_string . $padding . '}' : null;

if ( $link_color !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx-button {' . $link_color_text . '}';
	$js_styles .= $unique_class_css.'.wtbx_vc_button.wtbx_style_link.wtbx_link_decoration .wtbx_button_inner:before,'.$unique_class_css.'.wtbx_vc_button.wtbx_style_link.wtbx_link_decoration .wtbx-button .wtbx_button_inner:after {' . $link_color_bg . '}';
}
if ( $link_color_h !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx-button:hover {' . $link_color_text_h . '}';
	$js_styles .= $unique_class_css.'.wtbx_vc_button.wtbx_style_link.wtbx_link_decoration .wtbx-button .wtbx_button_inner:after {' . $link_color_bg_h . '}';
}
if ( $link_color_general !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_vc_button.wtbx_style_link .wtbx-button .bar,'.$unique_class_css.'.wtbx_style_link .wtbx-button .chevron {fill:' . $link_color_general . '}';
}
if ( $link_color_general_h !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_vc_button.wtbx_style_link .wtbx-button:hover .bar,'.$unique_class_css.'.wtbx_style_link .wtbx-button:hover .chevron {fill:' . $link_color_general_h . '}';
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
