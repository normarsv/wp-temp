<?php
$link = $el_class = $style = $skin = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-listitem' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// construct link
$link = wtbx_vc_build_link($link);

// icon markup
$icon = ( $bullet_style === 'icon' && $bullet_icon !== '' ) ? wtbx_vc_get_icon($bullet_icon) : '';

// text/number markup
$bullet_text = ( $bullet_style === 'text' ) ? '<div class="wtbx_vc_list_item_bullet_text wtbx-text">'.$bullet_text.'</div>' : '';

// shortcode class
$element_class      = 'wtbx_vc_list_item';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// element style
$shortcode_class[] = 'wtbx_bullet_' . $bullet_style;
$shortcode_class[] = 'wtbx_' . $style;
( $link['open'] !== '' ) ? $shortcode_class[] = 'wtbx_has_link' : '';
$shortcode_class[] = 'wtbx_offset_' . $offset;
$shortcode_class[] = 'wtbx_' . $bullet_size;
$shortcode_class[] = 'wtbx_skin_' . $skin;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';
$js_styles .= ( $bullet_style === 'point' ) ? $unique_class_css.'.wtbx_bullet_point .wtbx_vc_list_item_bullet:before, '.$unique_class_css.'.wtbx_bullet_point .wtbx_vc_list_item_bullet:after {'. wtbx_vc_color_styles_bg($bullet_color) .'}' : '';
$js_styles .= ( $bullet_style === 'icon' ) ? $unique_class_css.' .wtbx_vc_icon {'. wtbx_vc_color_styles_text($bullet_color) .'}' : '';
$js_styles .= ( $bullet_style === 'text' ) ? $unique_class_css.'.wtbx_bullet_text .wtbx_vc_list_item_bullet_text {'. wtbx_vc_color_styles_text($bullet_color) .'}' : '';
$js_styles .= ( $bullet_style === 'text' ) ? $unique_class_css.'.wtbx_bullet_text .wtbx_vc_list_item_bullet_text {'. wtbx_vc_color_styles_bg($bullet_cont_color) .'}' : '';
$js_styles .= $unique_class_css.' .wtbx_vc_list_item_content {'. wtbx_vc_color_styles_text($text_color) .'}';
$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner"'.($tooltip !== '' ? ' data-tooltip="' . esc_html($tooltip) . '"' : '').'>';
$output .= $link['open'];
$output .= $link['close'];

$output .= '<div class="wtbx_vc_list_item_bullet">';
$output .= $icon;
$output .= $bullet_text;
$output .= '</div>';

$output .= '<div class="wtbx_vc_list_item_content">' . wpb_js_remove_wpautop($content, true) . '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;