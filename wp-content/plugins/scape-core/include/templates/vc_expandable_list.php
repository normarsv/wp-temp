<?php

$title = $el_class = $style = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-explist' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_expandable_list';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// element style
$shortcode_class[] = 'wtbx_style_' . $style;
$shortcode_class[] = 'wtbx_skin_' . $skin;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$accent_color_text      = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg        = wtbx_vc_color_styles_bg($accent_color);
$accent_color_border    = wtbx_vc_color_styles_border($accent_color);
$accent_color_shadow    = wtbx_vc_color_styles_shadow($accent_color, '0 1px 5px 0', '0.5');
$title_typography_string    = wtbx_font_styling($title_typography);

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( $style === 'default' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_default .wtbx_vc_exp_list_item:hover .wtbx_exp_list_title_wrap,'.$unique_class_css.'.wtbx_style_default .wtbx_vc_exp_list_item.active .wtbx_exp_list_title_wrap {' . $accent_color_text .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_default .wtbx_exp_list_bullet:before {' . $accent_color_border .  '}' : null;
} elseif ( $style === 'minimal' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_minimal .wtbx_exp_list_bullet_plus:before,'.$unique_class_css.'.wtbx_style_minimal .wtbx_exp_list_bullet_plus:after,'.$unique_class_css.'.wtbx_style_minimal .wtbx_vc_exp_list_item:before,'.$unique_class_css.'.wtbx_style_minimal .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet_plus {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet_plus,'.$unique_class_css.'.wtbx_style_minimal .wtbx_exp_list_title_wrapper:hover .wtbx_exp_list_bullet_plus  {' . $accent_color_border .  '}' : null;
} elseif ( $style === 'boxed' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_boxed .wtbx_vc_exp_list_item .wtbx_exp_list_bullet_plus:after {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_boxed .wtbx_vc_exp_list_item.active .wtbx_exp_list_title_wrapper:before  {' . $accent_color_border .  '}' : null;
	$accent_color_shadow !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_boxed .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet_plus:after {' . $accent_color_shadow .  '}' : null;
} elseif ( $style === 'border' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_border .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet:before {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_border .wtbx_vc_exp_list_item.active .wtbx_exp_list_title_wrapper:before {' . $accent_color_border .  '}' : null;
}

$accent_color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_exp_list_item.active .wtbx_vc_icon,'.$unique_class_css.' .wtbx_vc_exp_list_item:hover .wtbx_vc_icon,'.$unique_class_css.' .wtbx_vc_exp_list_item .wtbx_vc_list_item_bullet_text  {' . $accent_color_text .  '}' : null;
$title_typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_vc_el_inner .wtbx_vc_exp_list_item .wtbx_exp_list_title_wrapper,'.$unique_class_css.' .wtbx_vc_el_inner .wtbx_vc_exp_list_item .wtbx_exp_list_title_wrapper .wtbx_exp_list_title {' . $title_typography_string .  '}' : null;

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner' . $this->getExtraClass( $anim_class ) . '">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;