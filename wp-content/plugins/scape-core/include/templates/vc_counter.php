<?php
$output = $link = $el_class = $unique_class = $style =
$accent_color_text = $accent_color_bg = $accent_color_border = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'waypoints' );


$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_counter';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $display;
if ( $display === 'display_block' && $align !== '' ) {
	$shortcode_class[]  = 'wtbx_' . $align;
}
$shortcode_class[]  = 'wtbx_align_prefix_' . $prefix_align;
$shortcode_class[]  = 'wtbx_align_suffix_' . $suffix_align;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// color & typography
$typography_string = wtbx_font_styling($typography);
$color = wtbx_vc_color_styles_text($color);

$typography_string_prefix = wtbx_font_styling($typography_prefix);
$color_prefix = wtbx_vc_color_styles_text($color_prefix);

$typography_string_suffix = wtbx_font_styling($typography_suffix);
$color_suffix = wtbx_vc_color_styles_text($color_suffix);

$margin = wtbx_vc_scape_design($margin);


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$js_styles .= $margin !== '' ? $js_styles .= $unique_class_css.' {' . $margin . '}' : '';

if ( $typography_string !== '' || $color !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_counter_wrapper {' . $typography_string . $color . '}';
}
if ( $typography_string_prefix !== '' || $color_prefix !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_counter_prefix {' . $typography_string_prefix . $color_prefix . '}';
}
if ( $typography_string_suffix !== '' || $color_suffix !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_counter_suffix {' . $typography_string_suffix . $color_suffix . '}';
}

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_counter_wrapper">';
if ( $prefix !== '' ) {
	$output .= '<span class="wtbx_counter_prefix wtbx-text">'.esc_html($prefix).'</span>';
}
$output .= '<span class="wtbx_counter_number wtbx-text" data-from="'.esc_attr($from).'" data-to="'.esc_attr($to).'" data-time="'.esc_attr($speed).'" data-delay="'.esc_attr($interval).'">'.esc_html($from).'</span>';
if ( $suffix !== '' ) {
	$output .= '<span class="wtbx_counter_suffix wtbx-text">'.esc_html($suffix).'</span>';
}
$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';


echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.counter.count(jQuery('.wtbx_counter_number:not(.init)'));}</script>";
}