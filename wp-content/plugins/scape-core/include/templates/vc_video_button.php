<?php
$output = $link = $el_class = $unique_class = $style = $icon = $heading_typography =
$color_string_text = $color_string_bg = $color_string_border = $accent_color_solid = $accent_color =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-videobutton' );

wtbx_script_queue('plyr');
wp_enqueue_style('scape-plyr');

wtbx_script_queue('magnific-popup');

wtbx_script_queue('scape-lightbox', false);
wp_enqueue_style('scape-lightbox-style');

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

//$h_typography_string = wtbx_font_styling($heading_typography);

// shortcode class
$element_class      = 'wtbx_vc_video_button';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[] = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_skin_' . $skin;
$alignment !== '' ? $shortcode_class[] = 'wtbx_align_' . $alignment : null;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// color
if ( !in_array($style, array('style_1', 'style_5', 'style_6')) ) {
	$accent_color = $accent_color_solid;
}
if ( $accent_color !== '' ) {
	$color_string_text = wtbx_vc_color_styles_text($accent_color);
	$color_string_bg = wtbx_vc_color_styles_bg($accent_color);
	$color_string_border = wtbx_vc_color_styles_border($accent_color);
}

// link
$type = $link = '';
if ( $video_type === 'youtube' && $youtube !== '' ) {
	$link = 'https://www.youtube.com/watch?v=' . $youtube;
	$type = ' data-iframe="1"';
} elseif ( $video_type === 'vimeo' && $vimeo !== '' ) {
	$link = 'https://vimeo.com/' . $vimeo;
	$type = ' data-iframe="1"';
} elseif ( $video_type === 'selfhosted_video' && $selfhosted_video !== '' ) {
	$link = $selfhosted_video;
	$type = ' data-video="1"';
}



// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$color = json_decode($accent_color, true);
$new_color = '';

if ( isset($color['color']) ) {
	$new_color = $color['color'];
} elseif ( isset($color['solid']['color']) ) {
	$new_color = $color['solid']['color'];
} elseif( isset($color['to']['color']) ) {
	$new_color = $color['to']['color'];
}

if ( $style === 'style_1' ) {
	if ( $skin === 'dark' && $color_string_text !== '' ) {
		$js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_skin_dark .wtbx_video_icon i {' . $color_string_text .'}';
	}
	if ( $skin === 'light' && $color_string_bg !== '' ) {
		$js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_skin_light .wtbx_video_icon {' . $color_string_bg .'}';

		if ( $new_color !== '' ) {
			$js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_skin_light .wtbx_video_icon:before { border-color:' . $new_color .'}';
		}
	}
} elseif ( $style === 'style_2' ) {
	$js_styles .= $color_string_text !== '' ? $unique_class_css.'.wtbx_style_2 .wtbx_video_icon i {' . $color_string_text .'}' : '';
	if ( $skin === 'light' ) {
		$js_styles .= $color_string_border !== '' ? $unique_class_css.'.wtbx_style_2.wtbx_skin_light .wtbx_video_icon, '.$unique_class_css.'.wtbx_style_2.wtbx_skin_light .wtbx_video_icon:before, '.$unique_class_css.'.wtbx_style_2.wtbx_skin_light .wtbx_video_icon:after {' . $color_string_border .'}' : '';
	} elseif ( $skin === 'dark' ) {
		$js_styles .= $color_string_border !== '' ? $unique_class_css.'.wtbx_style_2.wtbx_skin_dark .wtbx_video_icon, '.$unique_class_css.'.wtbx_style_2.wtbx_skin_dark .wtbx_video_icon:before, '.$unique_class_css.'.wtbx_style_2.wtbx_skin_dark .wtbx_video_icon:after {' . $color_string_border .'}' : '';
	}
} elseif ( $style === 'style_3' ) {
	if ( $skin === 'dark' ) {
		if ( $new_color !== '' ) {
			if ( strpos($new_color, '#') !== false ) {
				$new_color = wtbx_hex2rgba_array($new_color);
			} else {
				$new_color = wtbx_rgba2array($new_color);
			}
			if ( isset($new_color[0]) && isset($new_color[1]) && isset($new_color[2]) ) {
				$js_styles .= $unique_class_css.'.wtbx_style_3.wtbx_skin_dark .wtbx_video_button_wrapper:hover {box-shadow: 0 10px 45px -5px rgba('.$new_color[0].','.$new_color[1].','.$new_color[2].',0.6)}';
			}
		}

		$js_styles .= $color_string_bg !== '' ? $unique_class_css.'.wtbx_style_3.wtbx_skin_dark .wtbx_video_button_wrapper {' . $color_string_bg .'}' : '';
		$js_styles .= empty($new_color) ? $unique_class_css.'.wtbx_style_3.wtbx_skin_dark .wtbx_video_button_wrapper {' . $new_color .'}' : '';
	} elseif ( $skin === 'light' ) {
		$js_styles .= $color_string_text !== '' ? $unique_class_css.'.wtbx_style_3.wtbx_skin_light .wtbx_video_icon i {' . $color_string_text .'}' : '';
		$js_styles .= $color_string_border !== '' ? $unique_class_css.'.wtbx_style_3.wtbx_skin_light .wtbx_video_icon, '.$unique_class_css.'.wtbx_style_3.wtbx_skin_light .wtbx_video_icon:before, '.$unique_class_css.'.wtbx_style_3.wtbx_skin_light .wtbx_video_icon:after {' . $color_string_border .'}' : '';
	}
} elseif ( $style === 'style_4' ) {
	$js_styles .= $color_string_bg !== '' ? $unique_class_css.'.wtbx_style_4 .wtbx_video_icon:before {' . $color_string_bg .'}' : '';
} elseif ( $style === 'style_5' ) {
	if ( $skin === 'dark' && $color_string_text !== '' ) {
		$js_styles .= $unique_class_css.'.wtbx_style_5.wtbx_skin_dark .wtbx_video_icon i {' . $color_string_text .'}';
	}
	if ( $skin === 'light' && $color_string_bg !== '' ) {
		$js_styles .= $unique_class_css.'.wtbx_style_5.wtbx_skin_light .wtbx_video_icon,'.$unique_class_css.'.wtbx_style_5.wtbx_skin_light .wtbx_video_icon:before,'.$unique_class_css.'.wtbx_style_5.wtbx_skin_light .wtbx_video_icon:after {' . $color_string_bg .'}';
	}
} elseif ( $style === 'style_6' ) {
	if ( $skin === 'dark' && $color_string_text !== '' ) {
		$js_styles .= $unique_class_css.'.wtbx_style_6.wtbx_skin_dark .wtbx_video_icon i {' . $color_string_text .'}';
	}
	if ( $skin === 'light' && $color_string_bg !== '' ) {
		$js_styles .= $unique_class_css.'.wtbx_style_6.wtbx_skin_light .wtbx_video_icon {' . $color_string_bg .'}';
	}
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="'.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($anim_class). ' ' .esc_attr($element_class).'_inner">';


if ( $style === 'style_1' ) {
	$output .= '<div class="wtbx_video_button_wrapper wtbx_vc_el_container">';
	$output .= '<div class="wtbx_video_icon wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$output .= '<i class="scape-ui-play"></i>';
	$output .= '</div>';

	if ( $heading !== '' ) {
		$output .= '<div class="wtbx_video_button_h">' . esc_html($heading) . '</div>';
	}
	$output .= '</div>';

} elseif ( $style === 'style_2' ) {
	$output .= '<div class="wtbx_video_button_wrapper wtbx_vc_el_container wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$output .= '<div class="wtbx_video_button_cell">';
	$output .= '<div class="wtbx_video_icon">';
	$output .= '<i class="scape-ui-play"></i>';
	$output .= '</div>';
	$output .= '</div>';

	if ( $heading !== '' || $subheading !== '' ) {
		$output .= '<div class="wtbx_video_button_cell">';
		if ( $subheading !== '' ) {
			$output .= '<div class="wtbx_video_button_sh">' . esc_html($subheading) . '</div>';
		}
		if ( $heading !== '' ) {
			$output .= '<div class="wtbx_video_button_h">' . esc_html($heading) . '</div>';
		}
		$output .= '</div>';
	}

	$output .= '</div>';
} elseif ( $style === 'style_3' ) {
	$output .= '<div class="wtbx_vc_el_container">';
	$output .= '<div class="wtbx_video_button_wrapper wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$output .= '<div class="wtbx_video_button_cell">';
	$output .= '<div class="wtbx_video_icon">';
	$output .= '<i class="scape-ui-play"></i>';
	$output .= '</div>';
	$output .= '</div>';

	if ( $heading !== '' || $subheading !== '' ) {
		$output .= '<div class="wtbx_video_button_cell">';
		if ( $subheading !== '' ) {
			$output .= '<div class="wtbx_video_button_sh">' . esc_html($subheading) . '</div>';
		}
		if ( $heading !== '' ) {
			$output .= '<div class="wtbx_video_button_h">' . esc_html($heading) . '</div>';
		}
		$output .= '</div>';
	}
	$output .= '</div>';
	$output .= '</div>';
} elseif ( $style === 'style_4' ) {
	$output .= '<div class="wtbx_video_button_wrapper wtbx_vc_el_container wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$output .= '<div class="wtbx_video_button_cell">';
	$output .= '<div class="wtbx_video_icon">';
	if ( $thumbnail !== '' ) {
		$output .= wtbx_image_smart_crop( $thumbnail, 'thumbnail', 'medium', '4:3', wtbx_get_alt_text($thumbnail), '', true );
	}
	$output .= '<i class="scape-ui-play"></i>';
	$output .= '</div>';
	$output .= '</div>';

	if ( $heading !== '' || $subheading !== '' ) {
		$output .= '<div class="wtbx_video_button_cell">';
		if ( $subheading !== '' ) {
			$output .= '<div class="wtbx_video_button_sh">' . esc_html($subheading) . '</div>';
		}
		if ( $heading !== '' ) {
			$output .= '<div class="wtbx_video_button_h">' . esc_html($heading) . '</div>';
		}
		$output .= '</div>';
	}

	$output .= '</div>';
} elseif ( $style === 'style_5' ) {
	$output .= '<div class="wtbx_video_button_wrapper wtbx_vc_el_container">';
	$output .= '<div class="wtbx_video_icon wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$output .= '<i class="scape-ui-play"></i>';
	$output .= '</div>';

	if ( $heading !== '' ) {
		$output .= '<div class="wtbx_video_button_h">' . esc_html($heading) . '</div>';
	}
	$output .= '</div>';
} elseif ( $style === 'style_6' ) {
	$output .= '<div class="wtbx_video_button_wrapper wtbx_vc_el_container wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$output .= '<div class="wtbx_video_button_cell">';
	$output .= '<div class="wtbx_video_icon">';
	if ( $thumbnail !== '' ) {
		$output .= wtbx_image_smart_crop( $thumbnail, 'thumbnail', 'medium', '4:3', wtbx_get_alt_text($thumbnail), '', true );
	}
	$output .= '<i class="scape-ui-play"></i>';
	$output .= '</div>';
	$output .= '</div>';

	if ( $heading !== '' || $subheading !== '' ) {
		$output .= '<div class="wtbx_video_button_cell">';
		if ( $heading !== '' ) {
			$output .= '<div class="wtbx_video_button_h">' . esc_html($heading) . '</div>';
		}
		$output .= '</div>';
	}

	$output .= '</div>';
}


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
