<?php
$output = $el_class = $unique_class = $style = $responsiveness = $cont_margin =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-contentslider' );
wtbx_vc_script_queue( 'scape-content-slider' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay);

// count slides
$slides = array();
preg_match_all( '/vc_content_slide([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
if ( isset( $matches[1] ) ) {
	$slides = $matches[1];
}

// styles and buttons
$buttons = '';
$slides_to_scroll = $slides_to_scroll === '1' ? 1 : 'auto';
$slide_width = $slides_to_show;
if ( $style === 'default' ) {
	if ( $navigation === '1' ) {
		$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_'.$navigation_skin.'">';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
		$buttons .= '</div>';
	}
} elseif ( $style === 'fixed' ) {
	if ( $navigation === '1' ) {
		$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_default wtbx_arrows_fixed wtbx_nav_skin_'.$navigation_skin.'">';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
		$buttons .= '</div>';
	}
} elseif ( $style === 'boxed_simple' ) {
	$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
	$buttons .= '</div>';
} elseif ( $style === 'boxed_scale' ) {
	$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_inside wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
	$buttons .= '</div>';
	$centered = true;
	$slides_to_scroll = 1;
	$slide_width = 'scale';
} elseif ( $style === 'boxed_overlap' ) {
	$buttons .= '<div class="wtbx_content_slider_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next"></div>';
	$buttons .= '</div>';
	$slide_width = $slides_to_show = 1;
	$slides_to_scroll = 1;
}

// shortcode class
$element_class      = 'wtbx_vc_content_slider';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_style_' . $style;
$shortcode_class[] = 'wtbx_align_' . $slide_align;
$responsiveness === 'true' ? $shortcode_class[] = 'wtbx_responsive' : null;
$hide_nav === 'true' ? $shortcode_class[] = 'wtbx_hide_nav' : null;
$pagination !== '' ? $shortcode_class[] = 'wtbx_pagination_enabled' : null;
if ( $responsiveness === 'true' ) {
	$shortcode_class[] = 'wtbx_responsive';
}
if ( ( $style === 'default' || $style === 'fixed' || $style === 'fixed_content' ) && $navigation === '' ) {
	$shortcode_class[] = 'wtbx_no_arrows';
}

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


$dots = true;
if ( $pagination === '' || $pagination === 'style_3' ) {
	$dots = '';
}

// slider settings
$max_attraction = 0.15;
$min_attraction = 0.005;
$max_friction   = 0.7;
$min_friction   = 0.2;
$attraction = intval($slider_speed) / 100 * $max_attraction + $min_attraction;
$friction   = intval($slider_speed) / 100 * $max_friction + $min_friction;
$pagination_class = 'wtbx_dots wtbx_dots_'.$pagination.' wtbx_nav_skin_'.$pagination_skin;


$data  = '';
$data .= ' data-align="' . ( in_array($style, array('default', 'boxed_simple', 'fixed', 'fixed_content')) ? 'left' : 'center' ) . '"';
$data .= ' data-slides="'.$slides_to_show.'"';
$data .= ' data-slides-to-scroll="'.$slides_to_scroll.'"';
$data .= ' data-attraction="'.$attraction.'"';
$data .= ' data-friction="'.$friction.'"';
if ( intval($autoplay) > 0 ) {
	$data .= ' data-autoplay="'.($autoplay * 1000).'"';
}
$data .= ' data-pause="'.$stop_hover.'"';
//$data .= ' data-drag="'.$mouse_drag.'"';
$data .= ' data-drag="1"';
//$data .= ' data-infinite="'.$infinite.'"';
$data .= ' data-initial="' . ($initial_slide !== '' ? intval($initial_slide)-1 : '0') . '"';
$data .= ' data-dots="'.$dots.'"';
$data .= ' data-height="' . $autoheight . '"';
$data .= ' data-pagination-class="wtbx_dots wtbx_dots_'.$pagination.' wtbx_nav_skin_'.$pagination_skin.'"';
$data .= ' data-slides-desktop="' . $slide_width . '"';
//if ( $style === 'default' ) {
//	$data .= ' data-freescroll="' . $freescroll .'"';
//}
if ( $responsiveness === 'true' ) {
	$data .= ' data-slides-tablet="' . $slides_to_show_tablet . '"';
	$data .= ' data-slides-mobile="' . $slides_to_show_mobile .'"';
}

// padding
if ( $style === 'default' || $style === 'fixed' || $style === 'fixed_content' ) {
	$margin = !empty($padding) ? json_decode($padding, true) : '';
	if ( $margin !== '' ) {
		$prop = $margin['property'];
		$cont_margin .= !empty($margin['left']) ? ' margin-left: -' . $margin['left'] . 'px;' : '';
		$cont_margin .= !empty($margin['right']) ? ' margin-right: -' . $margin['right'] . 'px;' : '';
	}
}
$padding = wtbx_vc_scape_design($padding);


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$easing = 'cubic-bezier(0.6, 0, 0.2, 1)';
$scale_speed = 2000 / $slider_speed;
if ( $style === 'default' || $style === 'fixed' || $style === 'fixed_content' ) {
	$js_styles .= $unique_class_css . '.wtbx_vc_content_slider .wtbx_content_slider_wrapper .wtbx_vc_content_slide .wtbx_vc_content_slide_container .wtbx_vc_content_slide_inner, '.$unique_class_css . ' .wtbx_dots {' . $padding . '}';
} elseif ( $style === 'boxed_scale' ) {
	$js_styles .= $unique_class_css . " .wtbx_vc_content_slide_container { -webkit-transition: all ".$scale_speed."ms ".$easing."; -moz-transition: all ".$scale_speed."ms ".$easing."; -ms-transition: all ".$scale_speed."ms ".$easing."; -o-transition: all ".$scale_speed."ms ".$easing."; transition: all ".$scale_speed."ms ".$easing."; }";
}
if ( $style === 'fixed' || $style === 'fixed_content' ) {
	$js_styles .= $unique_class_css . '.wtbx_vc_content_slider .wtbx_content_slider_inner {' . $cont_margin . '}';
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_content_slider_wrapper">';
$output .= '<div class="wtbx_content_slider_inner"'.$data.'>';

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
	$output .= '<div class="wtbx_content_slider_pagination wtbx_slider_pagination wtbx_dots wtbx_dots_'.$pagination.' wtbx_nav_skin_'.$pagination_skin.'">';
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
	echo '<ul class="wtbx_slider_nav"></ul>';
}