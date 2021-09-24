<?php
$output = $style = $active = $skin = $scheme = $el_class = $tab_animation = $scroll_tab =
$accent_color_text = $accent_color_bg = $tab_width = $equal_width = $mobile = '';
$title_wrapper = 'div';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-accordion' );
wp_enqueue_script('scape-tabs');

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_accordion';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_skin_' . $skin;
$shortcode_class[]  = 'wtbx_scheme_' . $scheme;
$scroll_tab === '1' ? $shortcode_class[] = 'wtbx_scroll_tab' : null;
$el_class !== '' ? $shortcode_class[] = $el_class : null;

// element style
$accent_color_text = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
$accent_color_border = wtbx_vc_color_styles_border($accent_color);
$title_typography_string = wtbx_font_styling($title_typography);
$active = $active !== '' ? ' data-active-tab="'.intval($active).'"' : '';
$title_wrapper = ' data-wrapper="' . esc_attr($title_wrapper) . '"';


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'"'.$active.$title_wrapper.'>';


// styles
$unique_class_css = '.' . $unique_class . '.wtbx_vc_accordion';
$js_styles = '';

$title_typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_accordion_link {' . $title_typography_string .  '}' : null;

if ( $style === 'style_1' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_scheme_default .wtbx_vc_accordion_tab.active .wtbx_accordion_link {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_scheme_colorful .wtbx_vc_accordion_tab.active .wtbx_accordion_link {' . $accent_color_bg .  '}' : null;
} elseif ( $style === 'style_2' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_default .wtbx_vc_accordion_tab.active .wtbx_accordion_link {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_accordion_tab.active .wtbx_accordion_link, ' . $unique_class_css.'.wtbx_style_2.wtbx_scheme_default .wtbx_vc_accordion_tab.active .wtbx_accordion_link:before {' . $accent_color_bg .  '}' : null;
} elseif ( $style === 'style_3' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3 .wtbx_vc_accordion_tab.active .wtbx_accordion_link {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3 .wtbx_vc_accordion_tab.active:before {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3 .wtbx_vc_accordion_tab .wtbx_accordion_link:hover:before,'.$unique_class_css.'.wtbx_style_3 .wtbx_vc_accordion_tab .wtbx_accordion_link:before {' . $accent_color_border .  '}' : null;
}

$output .= wtbx_vc_js_styles($js_styles);



// shortcode

$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;