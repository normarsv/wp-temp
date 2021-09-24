<?php
$output = $link = $el_class = $unique_class = $style = $icon = $heading_typography =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wtbx_vc_script_queue('countdown');

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_countdown';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$separate !== '' ? $shortcode_class[] = 'wtbx_' . $separate : null;
$alignment !== '' ? $shortcode_class[] = 'wtbx_align_' . $alignment : null;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// event
$event = '';
$event .= $year !== '' ? $year : '2030';
$event .= $month !== '' ? '/' . $month : '/1';
$event .= $date !== '' ? '/' . $date : '/1';
$event .= $hour !== '' ? ' ' . $hour : ' ';
$event .= $minute !== '' ? ':' . $minute : ':0';
$event .= $second !== '' ? ':' . $second : ':0';

// format
$days = '<div class="wtbx_countdown_days">';
if ( $days_display === 'months_days' ) {
	$days .= '<div class="wtbx_countdown_block wtbx_cd_block_day"><span>' . '%m' . '</span><div class="wtbx_countdown_label">' . $months_label . '</div></div>';
	$days .= '<div class="wtbx_countdown_block wtbx_cd_block_day"><span>' . '%n' . '</span><div class="wtbx_countdown_label">' . $days_label . '</div></div>';
} elseif ( $days_display === 'weeks_days' ) {
	$days .= '<div class="wtbx_countdown_block wtbx_cd_block_day"><span>' . '%w' . '</span><div class="wtbx_countdown_label">' . $weeks_label . '</div></div>';
	$days .= '<div class="wtbx_countdown_block wtbx_cd_block_day"><span>' . '%d' . '</span><div class="wtbx_countdown_label">' . $days_label . '</div></div>';
} elseif ( $days_display === 'days' ) {
	$days .= '<div class="wtbx_countdown_block wtbx_cd_block_day"><span>' . '%D' . '</span><div class="wtbx_countdown_label">' . $days_label . '</div></div>';
}
$days .= '</div>';

$time = '<div class="wtbx_countdown_time">';
if ( strpos($time_display, 'hours')  !== false ) {
	$time .= '<div class="wtbx_countdown_block wtbx_cd_block_time"><span class="wtbx_countdown_time">' . '%H' . '</span><div class="wtbx_countdown_label">' . $hours_label . '</div></div>';
}
if ( strpos($time_display, 'minutes')  !== false ) {
	$time .= '<div class="wtbx_countdown_block wtbx_cd_block_time"><span class="wtbx_countdown_time">' . '%M' . '</span><div class="wtbx_countdown_label">' . $minutes_label . '</div></div>';
}
if ( strpos($time_display, 'seconds')  !== false ) {
	$time .= '<div class="wtbx_countdown_block wtbx_cd_block_time"><span class="wtbx_countdown_time">' . '%S' . '</span><div class="wtbx_countdown_label">' . $seconds_label . '</div></div>';
}
$time .= '</div>';

$format = $days . $time;

// typography
$numbers_typography_string = wtbx_font_styling($numbers_typography);
$labels_typography_string = wtbx_font_styling($labels_typography);

// colors
$n_color  = wtbx_vc_color_styles_text($numbers_color);
$l_color  = wtbx_vc_color_styles_text($labels_color);
$n_color_bg  = wtbx_vc_color_styles_bg($numbers_color);

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $numbers_typography_string !== '' ? $unique_class_css.' .wtbx_countdown_wrapper .wtbx_countdown_block span {' . $numbers_typography_string .'}' : '';
$js_styles .= $labels_typography_string !== '' ? $unique_class_css.' .wtbx_countdown_wrapper .wtbx_countdown_block .wtbx_countdown_label {' . $labels_typography_string .'}' : '';
$js_styles .= $n_color !== '' ? $unique_class_css.' .wtbx_countdown_wrapper .wtbx_countdown_block span {' . $n_color .'}' : '';
$js_styles .= $n_color_bg !== '' ? $unique_class_css.'.wtbx_separate .wtbx_countdown_wrapper .wtbx_countdown_days:after,'.$unique_class_css.' .wtbx_cd_block_time .wtbx_countdown_time:before,'.$unique_class_css.' .wtbx_cd_block_time .wtbx_countdown_time:after  {' . $n_color_bg .'}' : '';
$js_styles .= $l_color !== '' ? $unique_class_css.' .wtbx_countdown_wrapper .wtbx_countdown_block .wtbx_countdown_label {' . $l_color .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_countdown_wrapper" data-event="'.esc_attr($event).'" data-format="'.esc_attr($format).'">';


$output .= '</div>';


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';


echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.countdown();}</script>";
}
