<?php
$output = $link = $el_class = $unique_class = $style =
$accent_color_text = $accent_color_bg = $accent_color_border =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_team_table';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_layout_' . $layout;
$shortcode_class[] = 'wtbx_photo_columns_' . $photos_in_row;
$shortcode_class[] = 'wtbx_' . $photos_position;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// add lazy & preloader settings to child shortcodes
$content = str_replace('[vc_team_table_member', '[vc_team_table_member lazy="'.$lazy.'" preloader="'.$preloader.'"', $content);


// typography
$title_typography_string = wtbx_font_styling($title_typography);


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';
$js_styles .= $title_typography_string !== '' ? $unique_class_css.' .wtbx_team_table_title {' . $title_typography_string .'}' : '';
$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_team_table_title">' . esc_html($title) . '</div>';
$output .= '<div class="wtbx_team_table_wrapper">';
if ( $photos_position === 'photos_left' ) {
	$output .= '<div class="wtbx_team_table_photos clearfix"></div>';
}
$output .= '<div class="wtbx_team_table_content">' . wpb_js_remove_wpautop($content, true) . '</div>';
if ( $photos_position === 'photos_right' ) {
	$output .= '<div class="wtbx_team_table_photos clearfix"></div>';
}
$output .= '</div>';


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;