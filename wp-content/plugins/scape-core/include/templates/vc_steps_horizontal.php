<?php
$output = $style = $active = $skin = $scheme = $el_class = $step_animation = $step_content_below = $accent_color = $steps = $b =
$accent_color_text = $accent_color_bg = $title_typography = $title_typography_string = $step_width = $equal_width = $mobile = '';
$title_wrapper = $subtitle_wrapper = 'div';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-stepshor' );
wtbx_vc_script_queue( 'scape-steps' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_steps_horizontal';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_width_' . $width;
$mobile !== '' ? $shortcode_class[] = 'wtbx_stack_' . $mobile : null;

// element style
$accent_color_text = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
$title_typography_string = wtbx_font_styling($title_typography);
$subtitle_typography_string = wtbx_font_styling($subtitle_typography);
$active = $active !== '' ? ' data-active-tab="'.intval($active).'"' : '';

$steps_html = '';
$steps_html .= '<ul class="wtbx_steps_nav clearfix">';

$steps = vc_param_group_parse_atts( $atts['steps'] );

if ( !empty($steps[0]) ) {
	for ( $i=0; $i<sizeof($steps); $i++) {
		$bullet_type = $steps[$i]['bullet_type'];
		$descr = $steps[$i]['description'];

		if ( $bullet_type === 'icon' ) {
			$icon = $steps[$i]['icon'];
			$icon_el = wtbx_vc_get_icon($icon);
			if ( $icon !== '' ) {
				$b = '<div class="wtbx_step_bullet wtbx_step_bullet_icon">'.wtbx_vc_get_icon($icon).'</div>';
			}
		} elseif ( $bullet_type === 'number' ) {
			$number = $steps[$i]['number'];
			if ( $number !== '' ) {
				$b = '<div class="wtbx_step_bullet wtbx_step_bullet_number">'.esc_html($number).'</div>';
			}
		} elseif ( $bullet_type === 'abbr' ) {
			$abbr = $steps[$i]['abbr'];
			if ( $abbr !== '' ) {
				$b = '<div class="wtbx_step_bullet wtbx_step_bullet_abbr">'.esc_html($abbr).'</div>';
			}
		}

		$step_title = ( isset($steps[$i]['title']) ) ? '<'.$title_wrapper.' class="wtbx_steps_nav_title">' . $steps[$i]['title'] . '</'.$title_wrapper.'>' : '';
		$step_subtitle = ( isset($steps[$i]['subtitle']) ) ? '<'.$subtitle_wrapper.' class="wtbx_steps_nav_subtitle">' . $steps[$i]['subtitle'] . '</'.$subtitle_wrapper.'>' : '';

		$step_header = '<div class="wtbx_steps_header">' . $step_title . $step_subtitle . '</div>';

		$svg = $style === 'style_2' ? '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="10" viewBox="0 0 52 200" preserveAspectRatio="none"><path d="M0,0 C0,0 0.732348743,27.8872506 10.999999,45 C26,70 46,75 46,100 C46,125 25.9999999,130 10.999999,155 C0.256994849,172.905006 0,200 0,200 L0,0 Z" fill="#ffffff"></path></svg>' : '';
		$step_content = '<div class="wtbx_step_content">'.$svg.'<div class="wtbx_step_inner">' . $descr . '</div></div>';

		if ( $style === 'style_3' ) { $step_content_below .= $step_content; }

		$steps_html .= '<li class="wtbx_steps_nav_item">';
		$steps_html .= '<div class="wtbx_steps_nav_link wtbx-click touchhover">';
		$steps_html .= ($style === 'style_2' || $style === 'style_3' || $style === 'style_4') ? $step_header : '';
		$steps_html .= $b;
		$steps_html .= ($style === 'style_1' || $style === 'style_2' || $style === 'style_4') ? '<div class="wtbx_step_wrapper">' : '';
		$steps_html .= $style === 'style_1' ? $step_header : '';
		$steps_html .= ($style === 'style_1' || $style === 'style_2' || $style === 'style_4') ? $step_content : '';
		$steps_html .= ($style === 'style_1' || $style === 'style_2' || $style === 'style_4') ? '</div>' : '';
		$steps_html .= '</div>';
		$steps_html .= '</li>';
	}
}

$steps_html .= '</ul>' . "\n";



// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// colors
$bullet_color_text = wtbx_vc_color_styles_text($bullet_color);
$bullet_color_cont = wtbx_vc_color_styles_bg($bullet_cont_color);
$connector_color_border = wtbx_vc_color_styles_border($connector_color);
$connector_color_bg = wtbx_vc_color_styles_bg($connector_color);
$title_color = wtbx_vc_color_styles_text($title_color);
$subtitle_color = wtbx_vc_color_styles_text($subtitle_color);
$descr_color = wtbx_vc_color_styles_text($descr_color);


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'"'.$active.'>';


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( $style === 'style_1' ) {
	$js_styles .= ($bullet_color_text !== '' || $bullet_color_cont !== '') ? $unique_class_css.'.wtbx_style_1 .wtbx_steps_nav_link .wtbx_step_bullet {' . $bullet_color_text . $bullet_color_cont .'}' : '';
	$js_styles .= $connector_color !== '' ? $unique_class_css.'.wtbx_style_1 .wtbx_steps_nav_link .wtbx_step_bullet:before, '.$unique_class_css.'.wtbx_style_1 .wtbx_steps_nav_link:after {' . $connector_color_border .'}' : '';
} elseif ( $style === 'style_2'  ) {
	$js_styles .= ($bullet_color_text !== '' || $bullet_color_cont !== '') ? $unique_class_css.'.wtbx_style_2 .wtbx_steps_nav_link .wtbx_step_bullet {' . $bullet_color_text . $bullet_color_cont .'}' : '';
	$js_styles .= $connector_color !== '' ? $unique_class_css.'.wtbx_style_2 .wtbx_steps_nav_link:after {' . $connector_color_bg .'}' : '';
} elseif ( $style === 'style_3'  ) {
	$js_styles .= ($bullet_color_text !== '' || $bullet_color_cont !== '') ? $unique_class_css.'.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_step_bullet, '.$unique_class_css.'.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_step_bullet, '.$unique_class_css.'.wtbx_style_3 .wtbx_step_bullet:hover, '.$unique_class_css.'.wtbx_style_3 .wtbx_steps_header:hover + .wtbx_step_bullet {' . $bullet_color_text . $bullet_color_cont . '}' : '';
	$js_styles .= ($connector_color_border !== '') ? $unique_class_css.'.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_steps_nav_link:before, '.$unique_class_css.'.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_step_bullet:before {' . $connector_color_border .'}' : '';
	$js_styles .= $connector_color !== '' ? $unique_class_css.'.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_steps_nav_link:before {' . $connector_color_bg .'}' : '';
} elseif ( $style === 'style_4'  ) {
	$js_styles .= ($bullet_color_text !== '' || $bullet_color_cont !== '') ? $unique_class_css.'.wtbx_style_4 .wtbx_steps_nav_link .wtbx_step_bullet {' . $bullet_color_text . $bullet_color_cont .'}' : '';
	$js_styles .= $connector_color !== '' ? $unique_class_css.'.wtbx_style_4 .wtbx_steps_nav_item .wtbx_step_bullet:after {' . $connector_color_bg .'}' : '';
}

$js_styles .= $title_typography_string !== '' ? $unique_class_css.'.wtbx_vc_steps_horizontal .wtbx_steps_nav_item .wtbx_steps_nav_link .wtbx_steps_nav_title {' . $title_typography_string .'}' : '';
$js_styles .= $subtitle_typography_string !== '' ? $unique_class_css.'.wtbx_vc_steps_horizontal .wtbx_steps_nav_item .wtbx_steps_nav_link .wtbx_steps_nav_subtitle {' . $subtitle_typography_string .'}' : '';
$js_styles .= $title_color !== '' ? $unique_class_css.' .wtbx_steps_nav_link .wtbx_steps_nav_title {' . $title_color .'}' : '';
$js_styles .= $subtitle_color !== '' ? $unique_class_css.' .wtbx_steps_nav_link .wtbx_steps_nav_subtitle {' . $subtitle_color .'}' : '';
$js_styles .= $descr_color !== '' ? $unique_class_css.' .wtbx_steps_nav_link .wtbx_step_content {' . $descr_color .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);


// shortcode

$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= $steps_html;

if ( $style === 'style_3' ) {
	$output .= '<div class="wtbx_step_wrapper">';
	$output .= $step_content_below;
	$output .= '</div>';
}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE.steps) {SCAPE.steps.init();}</script>";
}