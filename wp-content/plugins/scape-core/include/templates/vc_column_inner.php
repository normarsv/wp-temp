<?php
$column_height = $output = $font_color = $bg_style = $bg_image_el = $textalign = $textalign_small = $lazy =
$custom_bg_image = $custom_bg_cover = $custom_bg_repeat = $custom_bg_position = $custom_bg_attachment = $el_class =
$column_shift = $column_scale = $column_opacity = $column_scroll_speed = $column_scroll_small = $column_sticky = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

$width = wpb_translateColumnWidthToSpan($width);
$width = vc_column_offset_class_merge($offset, $width);

if ( $column_sticky !== '' ) {
	wtbx_script_queue('sticky-kit');
}

// shortcode class
$element_class      = 'wtbx_vc_inner_column';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $width;
$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[]  = $unique_class;
$textalign !== '' ? $shortcode_class[] = 'wtbx_' . $textalign : null;
$textalign_small !== '' ? $shortcode_class[] = 'wtbx_center_align_' . $textalign_small : null;
$column_shift !== '' && $column_shift !== '0' ? $shortcode_class[] = 'wtbx_column_shift' : null;
$column_scale !== '' && $column_scale !== '0' ? $shortcode_class[] = 'wtbx_column_scale' : null;
$column_opacity !== '' && $column_opacity !== '0' ? $shortcode_class[] = 'wtbx_column_opacity' : null;
$column_scroll_speed !== '' ? $shortcode_class[] = 'wtbx_inner_column_scroll_smooth' : null;
$column_scroll_small !== '' ? $shortcode_class[] = 'wtbx_disable_scroll_' . $column_scroll_small : null;
$column_sticky !== '' ? $shortcode_class[] = $column_sticky : null;
!empty($link['url']) ? $shortcode_class[] = 'wtbx_column_link' : null;

// background image
if ( $custom_bg_image !== '' ) {
	$bg_styles = array();
	$bg_image_el = wtbx_image_smart_bg( $custom_bg_image, 'medium', 'full', false, wtbx_get_alt_text($custom_bg_image), 'wtbx_inner_column_bg_image', true, $lazy );

	$custom_bg_cover !== '' ? $bg_styles[] = 'background-size:'.$custom_bg_cover : null;
	$custom_bg_repeat !== '' ? $bg_styles[] = 'background-repeat:'.$custom_bg_repeat : null;
	$custom_bg_position !== '' ? $bg_styles[] = 'background-position:'.strtolower($custom_bg_position) : null;
	$custom_bg_attachment !== '' ? $bg_styles[] = 'background-attachment:'.$custom_bg_attachment : null;

	$bg_style = implode('; ', $bg_styles);
}

// disable CSS properties on smaller screens
$disable_css_class = array();
$disable_fixed_height !== '' ? $disable_css_class[] = 'wtbx_disable_height_' . $disable_fixed_height : null;
//$disable_margins !== '' ? $disable_css_class[] = 'wtbx_disable_margins_' . $disable_margins : null;
//$disable_borders !== '' ? $disable_css_class[] = 'wtbx_disable_borders_' . $disable_borders : null;
//$disable_padding !== '' ? $disable_css_class[] = 'wtbx_disable_padding_' . $disable_padding : null;
$disable_css_class = implode(' ', $disable_css_class);
$disable_css_class !== '' ? $disable_css_class = ' ' . $disable_css_class : null;

// column link
$inner_class    = 'wtbx_vc_el_inner ' . esc_attr($element_class) . '_inner';
$link           = wtbx_vc_build_link($link, $inner_class);
$inner_open     = $link['open'] !== '' ? $link['open'] : '<div class="'.$inner_class.'">';
$inner_close    = $link['close'] !== '' ? $link['close'] : '</div>';

// animation on scroll
$html_atts = '';
$html_atts .= $column_shift !== '' && $column_shift !== '0' ? ' data-shift="' . esc_html($column_shift) . '"' : '';
$html_atts .= $column_scale !== '' && $column_scale !== '0' ? ' data-scale="' . esc_html($column_scale) . '"' : '';
$html_atts .= $column_opacity !== '' && $column_opacity !== '0' ? ' data-opacity="' . esc_html($column_opacity) . '"' : '';
$html_atts !== '' ? $shortcode_class[] = 'wtbx_column_scroll' : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// height
if ( $min_height !== '' ) {
	$min_height = ' min-height:' . intval($min_height) . 'px;';
}

// colors
$bg_color_string = wtbx_vc_color_styles_bg($custom_bg_color);

// typography
$typography_string = wtbx_font_styling($typography);

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'"'.$html_atts.'>';
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$js_styles .= $font_color !== '' || $typography_string !== '' || $min_height !== '' ? $unique_class_css.' .wtbx_vc_inner_column_container .wtbx_inner_column_wrapper .wtbx_inner_column_content {' . wtbx_vc_color_styles_text($font_color) . $typography_string . $min_height . '}' : '';
$js_styles .= $min_height !== '' && wtbx_vc_is_page_editable() ? '.vc_editor.compose-mode .wtbx_vc_inner_column.vc_empty-element'.$unique_class_css.' .wtbx_vc_inner_column_container .wtbx_inner_column_wrapper .wtbx_inner_column_content {' . $min_height . '}' : '';
$js_styles .= $bg_color_string !== '' ? $unique_class_css.' .wtbx_inner_column_bg {' . $bg_color_string . '}' : '';

$margin_selector    = $unique_class_css . ' .' . $element_class . '_inner';
$border_selector    = $unique_class_css . ' .wtbx_inner_column_bg';
$padding_selector   = $unique_class_css . ' .wtbx_inner_column_content';
$offset_selector    = $unique_class_css . ' .wtbx_inner_column_content';
$zindex_selector    = $unique_class_css;
$js_styles .= wtbx_vc_scape_design_styles($el_design, $margin_selector, $border_selector, $padding_selector, $offset_selector, $zindex_selector);

$color_border = wtbx_vc_color_styles_border($border_color);
$js_styles .= $color_border !== '' ? $unique_class_css.' .wtbx_inner_column_bg {' . $color_border .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= $inner_open;
$output .= '<div class="wtbx_inner_column_bg">';
$output .= '<div class="wtbx_inner_column_bg_inner wtbx-element-reveal wtbx-reveal-cont">';
$output .= $bg_image_el;
$output .= '</div>';
$output .= '</div>';
$output .= '<div class="wtbx_inner_column_wrapper clearfix">';
$output .= '<div class="wtbx_inner_column_content">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= '</div>';
$output .= $inner_close;
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>jQuery('".$unique_class_css."').parent().css('z-index', jQuery('".$unique_class_css."').css('z-index'));</script>";
}