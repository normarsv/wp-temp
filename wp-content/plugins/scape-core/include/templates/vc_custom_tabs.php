<?php
$output = $style = $active = $skin = $scheme = $el_class = $tab_animation =
$accent_color_text = $accent_color_bg = $tab_width = $equal_width = $mobile = '';
$title_wrapper = 'div';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-tabs' );
wp_enqueue_script('scape-tabs');

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_tabs';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = 'wtbx_ui_tabs';
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_skin_' . $skin;
$shortcode_class[]  = 'wtbx_scheme_' . $scheme;
$shortcode_class[]  = 'wtbx_tab_anim_' . $tab_animation;
$mobile !== '' ? $shortcode_class[] = 'wtbx_mobile_acc_' . $mobile : null;

$el_class !== '' ? $shortcode_class[] = $el_class : null;
$tabs_align !== '' ? $shortcode_class[]  = 'wtbx_nav_' . $tabs_align : null;
$equal_width !== '' ? $shortcode_class[]  = 'wtbx_tabs_equal' : null;

// element style
$accent_color_text = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
$title_typography_string = wtbx_font_styling($title_typography);
$active = $active !== '' ? ' data-active-tab="'.intval($active).'"' : '';
$title_wrapper = ' data-wrapper="' . esc_attr($title_wrapper) . '"';


// Extract tab titles
$tabs_nav = '';
$tabs_nav .= '<ul class="wtbx_tabs_nav clearfix">';
$style === 'style_3' ? $tabs_nav .= '<li class="wtbx_tabs_knob"></li>' : null;
$tabs_nav .= '</ul>' . "\n";


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'"'.$active.$title_wrapper.'>';


// styles
$unique_class_css = '.' . $unique_class . '.wtbx_vc_tabs';
$js_styles = '';

$title_typography_string !== '' ? $js_styles .= $unique_class_css.' .wtbx_tabs_nav .wtbx_tabs_nav_item .wtbx_tabs_nav_link {' . $title_typography_string .  '}' : null;

if ( $style === 'style_1' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1 .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link:before {' . $accent_color_bg .  '}' : null;
} elseif ( $style === 'style_2' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2 .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link:before {' . $accent_color_bg .  '}' : null;
} elseif ( $style === 'style_3' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_vc_tabs.wtbx_style_3.wtbx_scheme_colorful .wtbx_tabs_knob {' . $accent_color_bg .  '}' : null;
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_vc_tabs.wtbx_style_3.wtbx_scheme_default .wtbx_tabs_nav .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link {' . $accent_color_text .  '}' : null;
} elseif ( $style === 'style_4' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_4.wtbx_scheme_colorful .wtbx_tabs_nav_item .wtbx_tabs_nav_link:after {' . $accent_color_bg .  '}' : null;
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_4.wtbx_scheme_default .wtbx_tabs_nav .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link {' . $accent_color_text .  '}' : null;
}

if ( $scheme === 'colorful' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_scheme_colorful .wtbx_vc_tab.active .wtbx_tab_mobile_link {' . $accent_color_bg .  '}' : null;
} else if (  $scheme === 'default' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_scheme_default .wtbx_tabs_content .wtbx_vc_tab.active .wtbx_tab_mobile_link {' . $accent_color_text .  '}' : null;
}

$output .= wtbx_vc_js_styles($js_styles);


// shortcode

$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= $tabs_nav;

$output .= '<div class="wtbx_tabs_content">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;