<?php
$output = $link = $el_class = $unique_class = $style = $icon = $heading_typography = $lazy =
$section_align = $bg_image_el = $bg_style = $custom_bg_effect = $disable_css_animation =
$bg_parallax = $bg_scale = $bg_mousemove = $bg_video_el = $bg_video_poster = $video_poster = $video_sound =
$overlay_color = $bg_anim_el = $anim_bg_styles = $animated_layer = $anim_direction = $anim_bg_style =
$segments_style = $disable_margins = $disable_borders = $disable_padding = $disable_fixed_height = $section_height =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = $full_height =
$bg_parallax_cont_class = $bg_scale_elem_class = $bg_parallax_elem_class = $bg_overlay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( $custom_bg_type === 'video' ) { wtbx_vc_script_queue('scape-videobg'); }

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

$h_typography_string = wtbx_font_styling($heading_typography);

// shortcode class
$element_class      = 'wtbx_vc_section';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$custom_bg_effect !== '' ? $shortcode_class[]  = 'wtbx_parallax_wrapper' : null;
if ( $animated_layer === 'anim_bg_image' && $anim_direction !== '' ) {
	$shortcode_class[] = 'wtbx_anim_layer_' . $anim_direction;
}
$animated_layer === 'anim_bg_segments' ? $shortcode_class[]  = 'wtbx_' . $animated_layer : null;
$segments_style !== '' ? $shortcode_class[]  = 'wtbx_' . $segments_style : null;
($section_show_on != '') ? $shortcode_class[] = str_replace(',', ' ', $section_show_on)  : null;

// element style
if ( 'yes' === $disable_element ) {
	if ( wtbx_vc_is_page_editable() ) {
		$shortcode_class[] = $this->getExtraClass('vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md');
	} else {
		return '';
	}
}

//if ($full_height === 'full_height_fixed' || $full_height === 'full_height_ext' ) {
//	$shortcode_class[] = 'wtbx_section_' . $full_height;
//
//	if ( $section_align !== '' ) {
//		$shortcode_class[] = 'wtbx_section_' . $section_align;
//	}
//}

// section height
if ($height_type !== '' && $height !== '' ) {
	$shortcode_class[] = 'wtbx_section_full_height_fixed';
	$section_height = ' height:' . intval($height) . 'vh' . ';';

	if ( $section_align !== '' ) {
		$shortcode_class[] = 'wtbx_section_' . $section_align;
	}
}
if ( $min_height !== '' ) {
	$section_min_height = ' min-height:' . intval($min_height) . 'px' . ';';
}


$disable_css_class = array();
$disable_fixed_height !== '' ? $disable_css_class[] = 'wtbx_disable_height_' . $disable_fixed_height : null;
$disable_margins !== '' ? $disable_css_class[] = 'wtbx_disable_margins_' . $disable_margins : null;
$disable_borders !== '' ? $disable_css_class[] = 'wtbx_disable_borders_' . $disable_borders : null;
$disable_padding !== '' ? $disable_css_class[] = 'wtbx_disable_padding_' . $disable_padding : null;
$disable_css_class = implode(' ', $disable_css_class);

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class ) . $this->getExtraClass($disable_css_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
($section_show_on != '') ? $css_class .= $this->getExtraClass( str_replace(',', ' ', $section_show_on) ) : '';


// background image
if ( $custom_bg_type === 'image' && $custom_bg_image !== '' ) {
	$bg_styles = array();
	$bg_image_el = wtbx_image_smart_bg( $custom_bg_image, 'medium', 'full', false, wtbx_get_alt_text($custom_bg_image), 'wtbx_section_bg_image', true, $lazy );

	$custom_bg_cover !== '' ? $bg_styles[] = 'background-size:'.$custom_bg_cover : null;
	$custom_bg_repeat !== '' ? $bg_styles[] = 'background-repeat:'.$custom_bg_repeat : null;
	$custom_bg_position !== '' ? $bg_styles[] = 'background-position:'.strtolower($custom_bg_position) : null;
	$custom_bg_attachment !== '' ? $bg_styles[] = 'background-attachment:'.$custom_bg_attachment : null;

	$bg_style = implode('; ', $bg_styles);
}
$detect = new WTBX_Mobile_Detect;
if ( !$detect->isMobile() ) {
	if ( $custom_bg_effect === 'wtbx_parallax_bg' || $custom_bg_effect === 'wtbx_parallax_scale_bg' || $parallax_video === 'wtbx_parallax_video' ) {
		if ( ($parallax_intensity !== '' && $parallax_intensity !== 0) || ($video_parallax_intensity !== '' && $video_parallax_intensity !== 0) ) {
			$bg_parallax = ' data-parallax-strength="' . $parallax_intensity .'"';
			$bg_parallax_elem_class = ' wtbx_parallax_scroll';
			$bg_parallax_cont_class = ' wtbx_parallax_container';
		}
		wp_enqueue_script('scape-parallax');
	}
	if ( $custom_bg_effect === 'wtbx_scale_bg' || $custom_bg_effect === 'wtbx_parallax_scale_bg' ) {
		if ( $scale_intensity !== '' && $scale_intensity !== 0 ) {
			$bg_scale = ' data-scale-strength="' . $scale_intensity .'"';
			$bg_scale_elem_class = ' wtbx_parallax_scale';
			$bg_parallax_cont_class = ' wtbx_parallax_container';
		}
		wp_enqueue_script('scape-parallax');
	}
	if ( $custom_bg_effect === 'wtbx_mousemove_bg' ) {
		if ( $mousemove_intensity !== '' && $mousemove_intensity !== 0 ) {
			$bg_mousemove = ' data-parallax-strength="' . $mousemove_intensity .'"';
			$bg_parallax_elem_class = ' wtbx_parallax_mousemove';
			$bg_parallax_cont_class = ' wtbx_parallax_container';
		}
		wp_enqueue_script('scape-parallax');
	}
}


// background video
if ( $custom_bg_type === 'video' ) {
	$data_poster = 0;
	if ( $video_poster !== '' ) {
		$data_poster = 1;
		$bg_video_poster = wtbx_image_smart_bg( $video_poster, 'medium', 'full', false, wtbx_get_alt_text($video_poster), '', true );
	}
	$mute = $video_sound === '' ? 1 : 0;

	if ( $bg_v_source === 'self_hosted' && $bg_video_mp4 !== '' ) {

		wp_enqueue_script( 'wp-mediaelement' );

		$video_details  = wp_get_attachment_metadata(wtbx_get_attachment_id_by_url($bg_video_mp4));

		$video_width = isset($video_details['width']) ? $video_details['width'] : 16;
		$video_height = isset($video_details['height']) ? $video_details['height'] : 9;

		$bg_video_el .= '<div class="wtbx_bg_video_wrapper">';
		$bg_video_el .= '<div class="wtbx_bg_video_poster" data-poster="'.$data_poster.'">'.$bg_video_poster.'</div>';
		$bg_video_el .= '<div class="wtbx_bg_video wtbx_bg_selfhosted" data-width="'.$video_width.'" data-height="'.$video_height.'" data-mute="'.$mute.'">';
		$bg_video_el .= '<video class="wtbx_bg_player" src="'. esc_attr($bg_video_mp4).'"'. ($mute ? ' muted playsinline' : '') .' autoplay>';
		$bg_video_el .= '</video>';
		$bg_video_el .=	'</div>';
		$bg_video_el .=	'</div>';

	} elseif ( $bg_v_source == 'vimeo' && $vimeo_id !== '' ) {
		$consent_media = 'vimeo';
		if ( !wtbx_vc_has_consent($consent_media) ) {
			$bg_video_el .= '<div class="wtbx_bg_video_wrapper">';
			$bg_video_el .= wtbx_noconsent_content($consent_media, $video_poster, true);
			$bg_video_el .= '</div>';
		} else {
			$bg_video_el .= '<div class="wtbx_bg_video_wrapper">';
			$bg_video_el .= '<div class="wtbx_bg_video_poster" data-poster="'.$data_poster.'">'.$bg_video_poster.'</div>';
			$bg_video_el .= '<div class="wtbx_bg_video wtbx_bg_vimeo" data-id="'.$vimeo_id.'" data-mute="'.$mute.'">';
			$bg_video_el .= '</div>';
			$bg_video_el .= '</div>';
		}
	} elseif ( $bg_v_source === 'youtube' && $youtube_id !== '' ) {
		$consent_media = 'youtube';
		if ( !wtbx_vc_has_consent($consent_media) ) {
			$bg_video_el .= '<div class="wtbx_bg_video_wrapper">';
			$bg_video_el .= wtbx_noconsent_content($consent_media, $video_poster, true);
			$bg_video_el .= '</div>';
		} else {
			wp_enqueue_script( 'vc_youtube_iframe_api_js', 'https://www.youtube.com/iframe_api', array(), WPB_VC_VERSION, true );
			$bg_video_el .= '<div class="wtbx_bg_video_wrapper">';
			$bg_video_el .= '<div class="wtbx_bg_video_poster" data-poster="'.$data_poster.'">'.$bg_video_poster.'</div>';
			$bg_video_el .= '<div class="wtbx_bg_video wtbx_bg_youtube" data-id="'.$youtube_id.'" data-mute="'.$mute.'">';
			$bg_video_el .= '<div class="wtbx_bg_player"></div>';
			$bg_video_el .= '</div>';
			$bg_video_el .= '</div>';
		}
	}
}


// animated layer image
if ( class_exists('WTBX_Mobile_Detect') ) {
	$detect = new WTBX_Mobile_Detect;
	if ( $animated_layer === 'anim_bg_image' && $anim_bg_image !== '' ) {
		$anim_bg_styles = array();
		$bg_anim_el = wtbx_image_smart_bg( $anim_bg_image, 'medium', 'full', false, wtbx_get_alt_text($anim_bg_image), 'wtbx_anim_image', true );

		$anim_bg_styles[] = 'background-size:'.$anim_bg_cover;
		$anim_bg_styles[] = 'background-repeat:'.$anim_bg_repeat;
		$anim_bg_styles[] = 'background-position:'.strtolower($anim_bg_position);
		$anim_bg_styles[] = 'background-attachment:'.$anim_bg_attachment;
		$anim_bg_style = implode('; ', $anim_bg_styles);

		$keyframes_prefix = ['@-webkit-', '@-moz-', '@-o-', '@'];

		$anim_details  = wp_get_attachment_metadata($anim_bg_image);
		$anim_width = isset($anim_details['width']) ? '-' . $anim_details['width'] . 'px' : '100%';
		$anim_height = isset($anim_details['height']) ? $anim_details['height'] . 'px' : '100%';

		$keyframes_anim_bg_pos = array(
			'to_right' => 'from { background-position-x: '.$anim_width.'; } to { background-position-x: 0; }',
			'to_left' => 'from { background-position-x: 0; } to { background-position-x: '.$anim_width.'; }',
			'to_bottom' => 'from { background-position-y: 0; } to { background-position-y: '.$anim_height.'; }',
			'to_top' => 'from { background-position-y: '.$anim_height.'; } to { background-position-x: 0; }',

		);
		$anim_bg_keyframes = '';

		foreach( $keyframes_prefix as $prefix ) {
			$anim_bg_keyframes .= ' ' . $prefix . 'keyframes ' . $unique_class . '{' . $keyframes_anim_bg_pos[$anim_direction] . '}';
		}

	} elseif ( $animated_layer === 'anim_bg_segments' && !$detect->isMobile() && $custom_bg_type === 'image' && $custom_bg_image !== '' ) {
		$bg_anim_segments = '';
		wp_enqueue_script('scape-parallax');

		switch ($segments_style) {
			case 'anim_style_1':
				$segments = 3;
				break;
			case 'anim_style_2':
				$segments = 4;
				break;
			case 'anim_style_3':
				$segments = 5;
				break;
			case 'anim_style_4':
				$segments = 4;
				break;
			case 'anim_style_5':
				$segments = 4;
				break;
			case 'anim_style_6':
				$segments = 4;
				break;
			case 'anim_style_7':
				$segments = 4;
				break;
			default:
				$segments = 3;
		}

		$bg_anim_el = '<div class="wtbx_anim_segments wtbx-element-reveal wtbx-reveal-cont">';

		for ($i = 1; $i <= $segments; $i++) {
			$anim_parallax = $bg_parallax !== '' ? ' data-parallax-strength="' .$parallax_intensity / (($i*$i+1) / 10 + 1) .'"' : '';
			$anim_mousemove = $bg_mousemove !== '' ? ' data-parallax-strength="' .$mousemove_intensity / (($i*$i+1) / 10 + 1) .'"' : '';
			$anim_scale = $bg_scale !== '' ? ' data-scale-strength="' .$scale_intensity / (($i*$i+1) / 10 + 1) .'"' : '';
			$bg_anim_el .= '<div class="wtbx_anim_segment_wrapper wtbx_anim_segment_'.$i.'"><div class="wtbx_anim_segment_outer'.$bg_scale_elem_class.'"'.$anim_scale.'><div class="wtbx_anim_segment_container'.$bg_parallax_elem_class.'"'.$anim_parallax.$anim_mousemove.'"><div class="wtbx_anim_segment_inner"><div class="wtbx_anim_segment"><div class="wtbx_anim_segment_shadow"></div><div class="wtbx_anim_segment_piece wtbx-entry-media">'.wtbx_image_smart_bg( $custom_bg_image, 'medium', 'full', false, wtbx_get_alt_text($custom_bg_image), 'wtbx_anim_image', true ).'</div></div></div></div></div></div>';
		}

		$bg_anim_el .= '</div>';
	}
}


// background overlay
if ( $overlay_color !== '' ) {
	$bg_overlay = '<div class="wtbx_section_bg_overlay"></div>';
}


$output  = '';
$output .= '<section class="'.esc_attr($css_class).'"'.($section_id !== '' ? ' id="'.esc_attr($section_id).'"' : '').($anchor !== '' ? ' data-anchor="'.esc_attr($anchor).'"' : '').($nav_skin !== '' ? ' data-skin="'.esc_attr($nav_skin).'"' : '').'>';


// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

!empty($custom_bg_color) ? $js_styles .= $unique_class_css.' .wtbx_section_bg {' . wtbx_vc_color_styles_bg($custom_bg_color) . '}' : null;
!empty($bg_style) ? $js_styles .= $unique_class_css.' .wtbx-bg-image .wtbx-bg-image-inner .wtbx_section_bg_image, '.$unique_class_css.'.wtbx_anim_bg_segments .wtbx_anim_segments .wtbx_anim_image {' . $bg_style . '}' : null;
!empty($overlay_color) ? $js_styles .= $unique_class_css.' .wtbx_section_bg_overlay {' . wtbx_vc_color_styles_bg($overlay_color) . '}' : null;
!empty($anim_bg_style) ? $js_styles .= $unique_class_css.' .wtbx_section_bg_anim_inner .wtbx-bg-image .wtbx_anim_image {' . $anim_bg_style . '}' : null;
!empty($anim_bg_keyframes) ? $js_styles .= $unique_class_css.' .wtbx_section_bg_anim_inner .wtbx_anim_image { -webkit-animation: '.$unique_class.' '.$anim_time.'s linear infinite; -moz-animation: '.$unique_class.' '.$anim_time.'s linear infinite; -o-animation: '.$unique_class.' '.$anim_time.'s linear infinite; animation: '.$unique_class.' '.$anim_time.'s linear infinite; }' : null;
!empty($anim_bg_keyframes) ? $js_styles .= $anim_bg_keyframes : null;

if ( !empty($section_height) ) {
	$js_styles .= $unique_class_css.' .wtbx_section_content {' . $section_height . '}';
}
if ( !empty($section_min_height) ) {
	$js_styles .= $unique_class_css.' .wtbx_section_content {' . $section_min_height . '}';
}

$margin_selector    = $unique_class_css . ' .' . $element_class . '_inner';
$border_selector    = $unique_class_css.' .wtbx_section_bg';
$padding_selector   = $unique_class_css . ' .wtbx_section_content_inner';
$offset_selector    = $unique_class_css . ' .wtbx_section_content_inner';
$js_styles .= $border_color !== '' ? $unique_class_css.' .wtbx_section_bg {' . wtbx_vc_color_styles_border($border_color) . '}' : '';
$zindex_selector    = $unique_class_css;
$js_styles .= wtbx_vc_scape_design_styles($el_design, $margin_selector, $border_selector, $padding_selector, $offset_selector, $zindex_selector);

$color_border = wtbx_vc_color_styles_border($border_color);
$js_styles .= $color_border !== '' ? $unique_class_css.' .wtbx_section_bg {' . $color_border .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner ' . esc_attr($element_class) . '_inner">';
$output .= '<div class="wtbx_section_wrapper">';

$output .= '<div class="wtbx_section_bg">';
$output .= '<div class="wtbx_section_bg_inner ' . ($custom_bg_image !== '' ? ' wtbx-element-reveal' : '') . ' wtbx-reveal-cont'.$bg_parallax_cont_class.'">';
$output .= '<div class="wtbx_section_bg_media_wrapper wtbx-entry-media'.$bg_scale_elem_class.'"'.$bg_scale.'>';
$output .= '<div class="wtbx_section_bg_media'.$bg_parallax_elem_class.'"'.$bg_parallax.$bg_mousemove.'>';
$output .= $bg_image_el;
$output .= $bg_video_el;
$output .= '</div>'; // end of media
$output .= '</div>'; // end of media wrapper

if ( !empty($bg_anim_el) ) {
	$output .= '<div class="wtbx_section_bg_anim" data-disable="'. esc_attr(!empty($anim_disable) ? wtbx_vc_scape_screen_sizes()[$anim_disable] : '0') . '">';
	$output .= '<div class="wtbx_section_bg_anim_inner">';
	$output .= $bg_anim_el;
	$output .= '</div>'; // end of animated layer
	$output .= '</div>'; // end of animated layer wrapper
}

$output .= $bg_overlay;
$output .= '</div>'; // end of bg inner
$output .= '</div>'; // end of bg


$output .= '<div class="wtbx_section_content">';
$output .= '<div class="wtbx_section_content_inner">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= '</div>';  // end of content


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '</section>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE && 'undefined' !== typeof SCAPE.parallaxBackground && SCAPE.videoBg) {SCAPE.parallaxBackground.mousemove();SCAPE.videoBg.init();}</script>";
}