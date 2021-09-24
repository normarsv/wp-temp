<?php
$output = $el_class = $unique_class = $style = $responsiveness = $accent_color = $accent_color_text = $accent_color_bg =
$accent_color_border = $scheme = $skin = $hide_nav = $pagination = $navigation_skin = $pagination_skin = $stop_hover =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-testimonialslider' );
wtbx_vc_script_queue( 'scape-testimonial-slider' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay);

// styles and buttons
$buttons = '';
$slide_width = 1;
if ( $style === 'style_1' ) {
	$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
	$buttons .= '</div>';
	$slide_width = $slides_to_show = 1;
	$slides_to_scroll = 1;
} elseif ( $style === 'style_2' ) {
	$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_inside wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
	$buttons .= '</div>';
	$centered = true;
	$slides_to_scroll = 1;
	$slide_width = 'scale';
} elseif ( $style === 'style_3' ) {
	$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
	$buttons .= '</div>';
	$slide_width = $slides_to_show = 1;
	$slides_to_scroll = 1;
}

// shortcode class
$element_class      = 'wtbx_vc_testimonial_slider';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_skin_' . $skin;
$shortcode_class[] = 'wtbx_scheme_' . $scheme;
$style === 'style_2' ? $shortcode_class[] = 'wtbx_align_middle' : null;
$hide_nav === 'true' ? $shortcode_class[] = 'wtbx_hide_nav' : null;
$pagination !== '' ? $shortcode_class[] = 'wtbx_pagination_enabled' : null;


// element class
if ( $scheme === 'colorful' ) {
	$accent_color_text = wtbx_vc_color_styles_text($accent_color);
	$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
	$accent_color_border = wtbx_vc_color_styles_border($accent_color);
}

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// dots
$dots = true;
if ( $pagination === '' || $pagination === 'style_3' ) {
	$dots = '0';
}


// slider settings
$attraction = 0.04;
$friction   = 0.5;
$pagination_class = 'wtbx_dots wtbx_dots_'.$pagination.' wtbx_nav_skin_'.$pagination_skin;

$data  = '';
$data .= ' data-attraction="'.$attraction.'"';
$data .= ' data-friction="'.$friction.'"';
if ( intval($autoplay) > 0 ) {
	$data .= ' data-autoplay="'.($autoplay * 1000).'"';
}
$data .= ' data-pause="'.$stop_hover.'"';
$data .= ' data-dots="'.$dots.'"';
$data .= ' data-height="' . ( $style === 'style_1' ? true : false ) . '"';
$data .= ' data-pagination-class="'.$pagination_class.'"';
$data .= ' data-slides-desktop="' . $slide_width . '"';


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( $style === 'style_1' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_author_name {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_scheme_colorful .wtbx_dots.wtbx_dots_style_2 .dot.is-selected:before {' . $accent_color_bg .  '}' : null;

} elseif ( $style === 'style_2' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_content {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_photo {' . $accent_color_border .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_credentials:before, ' . $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_credentials:after {' . $accent_color_bg .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_dots.wtbx_dots_style_2 .dot.is-selected:before {' . $accent_color_bg .  '}' : null;

	if ( wtbx_vc_is_page_editable() ) {
		$accent_color_bg !== '' ? $js_styles .= '.vc_vc_testimonial_slider '  . $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_content {' . $accent_color_bg .  '}' : null;
		$accent_color_border !== '' ? $js_styles .= '.vc_vc_testimonial_slider ' . $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_photo {' . $accent_color_border .  '}' : null;
		$accent_color_bg !== '' ? $js_styles .= '.vc_vc_testimonial_slider ' . $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_credentials:before, .vc_vc_testimonial_slider ' . $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_credentials:after {' . $accent_color_bg .  '}' : null;
	}
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_testimonial_slider_wrapper">';
$output .= '<div class="wtbx_testimonial_slider_inner"'.$data.'>';

if ( wtbx_vc_is_page_editable() ) {
	$output .= '<div class="flickity-viewport"><div class="flickity-slider">';
}

$output .= wpb_js_remove_wpautop($content);

if ( wtbx_vc_is_page_editable() ) {
	$output .= '</div></div>';
	$output .= '<div class="'.$pagination_class.'"><ol class="flickity-page-dots"></ol></div>';
}

$output .= '</div>';

$output .= $buttons;

if ( $pagination !== '' && $pagination === 'style_3' ) {
	$output .= '<div class="wtbx_testimonial_slider_pagination wtbx_slider_pagination wtbx_dots wtbx_dots_'.$pagination.' wtbx_nav_skin_'.$pagination_skin.'">';
	$output .= '<div class="wtbx_pagination_numbers">';
	$output .= '<ul>';
	if ( wtbx_vc_is_page_editable() ) {
		$output .= '<li class="wtbx_dot_active">' . esc_html__('X', 'core-extension') . '</li>';
	}
	$output .= '</ul>';
	$output .= '<div class="wtbx_pagination_total">';
	if ( wtbx_vc_is_page_editable() ) {
		$output .= '<span class="wtbx_pagination_separator">/</span>' . esc_html__('X', 'core-extension');
	}
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
}

$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo '<ul class="wtbx_testimonials_nav"></ul>';
}