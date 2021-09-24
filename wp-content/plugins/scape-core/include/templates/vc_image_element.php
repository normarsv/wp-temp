<?php
$output = $link = $el_class = $unique_class = $img_width = $img_height = $ratio = $navigation =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = $image_el = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_image_element';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
//$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[]  = 'wtbx_img_align_' . $alignment;
$shadow !== '' ? $shortcode_class[] = 'wtbx_' . $shadow : null;
$h_overlay !== '' ? $shortcode_class[] = 'wtbx_image_' . $h_overlay : null;
$image_hover !== '' ? $shortcode_class[] = 'wtbx_image_' . $image_hover : null;
if ( $icon !== '' ) {
	$shortcode_class[] = 'wtbx_' . $icon;
	$shortcode_class[] = 'wtbx_' . $icon_position;
	$shortcode_class[] = 'wtbx_' . $icon_size;
	$shortcode_class[] = 'wtbx_icon_skin_' . $icon_color;
}


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// image markup
$valid_image = false;
$ratio = '';
if ( $image !== '' ) {
	if ( $size_type === 'relative' ) {
		if ( $size_relative !== '' && strpos($size_relative, ':') !== false ) {
			$aspects = explode(':', $size_relative);
			$aspects[0] = is_numeric($aspects[0]) ? intval($aspects[0]) : '';
			$aspects[1] = is_numeric($aspects[1]) ? intval($aspects[1]) : '';
			if (isset($aspects[0]) && isset($aspects[1]) ) {
				$ratio = $aspects[0] . ':' . $aspects[1];
				$valid_image = true;
			} else {
				$metadata = wp_get_attachment_metadata( $image );
				if ( isset($metadata['width']) && isset($metadata['height']) ) {
					$ratio = $metadata['width'] . ':' . $metadata['height'];
				}
				$valid_image = true;
			}
		} else  {
			$metadata = wp_get_attachment_metadata( $image );
			if ( isset($metadata['width']) && isset($metadata['height']) ) {
				$ratio = $metadata['width'] . ':' . $metadata['height'];
			}
			$valid_image = true;
		}

		$image_el = wtbx_image_smart_crop( $image, 'medium', 'full', $ratio, wtbx_get_alt_text($image), '', true, $lazy );

	} elseif ( $size_type === 'fixed' ) {
		if ( $size_fixed !== '' && strpos($size_fixed, 'x') !== false ) {
			$sizes = explode('x', $size_fixed);
			$sizes[0] = is_numeric($sizes[0]) ? intval($sizes[0]) : '';
			$sizes[1] = is_numeric($sizes[1]) ? intval($sizes[1]) : '';
			if ( $sizes[0] !== '' && $sizes[1] !== '' ) {
				$ratio = $sizes[0] . ':' . $sizes[1];
				$img_width = $sizes[0];
				$img_height = $sizes[1];
				$valid_image = true;
			} else {
				$metadata = wp_get_attachment_metadata( $image );
				if ( isset($metadata['width']) && isset($metadata['height']) ) {
					$ratio = $metadata['width'] . ':' . $metadata['height'];
				}
				$valid_image = true;
			}
		} else {
			$metadata = wp_get_attachment_metadata( $image );
			if ( isset($metadata['width']) && isset($metadata['height']) ) {
				$ratio = $metadata['width'] . ':' . $metadata['height'];
			}
			$valid_image = true;
		}

		$image_el = wtbx_image_smart_crop( $image, $size_fixed, 'full', $ratio, wtbx_get_alt_text($image), '', true, $lazy );
	}

}


// border radius
$pattern_radius = '/^(\d*(?:\.\d+)?)\s*(px|\%)?$/';
$radius_san = '';
if ( $radius !== '' ) {
	$regex = preg_match( $pattern_radius, $radius, $matches_radius );
	if ( isset( $matches_radius[1] ) ) {
		$value = (float) $matches_radius[1];
		$unit = isset( $matches_radius[2] ) ? $matches_radius[2] : 'px';
		$radius_san = ' border-radius:' . $value . $unit . ';';
	}
}


// overlay
$overlay = '';
if ( $h_overlay !== '' ) {
	$overlay = '<div class="wtbx_image_element_overlay"></div>';
}


// link

if ( $img_link === 'page_link' ) {
	$link = wtbx_vc_build_link($link, 'wtbx_image_overlap');
} else {
	$link = array();

	if ( $img_link === 'image_popup' ) {
       $attachments[] = array(
			'src'   => wp_get_attachment_image_url( $image, 'full' ),
			'thumb' => wp_get_attachment_image_url( $image, 'medium' )
       );
		$link['open'] = '<div class="wtbx_image_overlap wtbx-lightbox-item" data-dynamic="1" data-dynamicel="' . esc_attr(json_encode($attachments)) . '"' . wtbx_lightbox_attributes() . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} elseif ( $img_link === 'gallery_popup' && $images !== '' ) {
	         $attachments = array();
		$images = explode(",", $images);
		foreach ( $images as $image ) {
			if ( isset($image) ) {
				$attachments[] = array(
					'src'   => wp_get_attachment_image_url( $image, 'full' ),
					'thumb' => wp_get_attachment_image_url( $image, 'medium' )
				);
			}
		}
		$link['open'] = '<div class="wtbx_image_overlap wtbx-lightbox-item" data-dynamic="1" data-dynamicel="' . esc_attr(json_encode($attachments)) . '"' . wtbx_lightbox_attributes() . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} elseif ( $img_link === 'video_popup' ) {
	         $link['open'] = '<div class="wtbx_image_overlap wtbx-lightbox-item" data-dynamic="1" data-iframe="1" data-dynamicel="' . esc_url(json_encode($iframe_link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} else {
		$link['open'] = '<div class="wtbx_image_overlap wtbx_image_noaction">';
		$link['close'] = '</div>';
	}
}


// icon
$icon_class = '';
if ( $icon !== '' ) {
	if ( $img_link === 'page_link' ) {
		$icon_class = 'scape-ui-link';
	} elseif ( $img_link === 'image_popup' ) {
		$icon_class = 'scape-ui-maximize';
	} elseif ( $img_link === 'gallery_popup' ) {
		$icon_class = 'scape-ui-photo-library';
	} elseif ( $img_link === 'video_popup' ) {
		$icon_class = 'scape-ui-play';
	}

	$icon = '<div class="wtbx_image_icon"><i class="'.$icon_class.'"></i></div>';
}



$output  = '';
$output .= '<div class="'.esc_attr($css_class).' wtbx_preloader_cont">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$max_width_style = $img_width_style = $img_height_style = '';
if ( $size_type === 'relative' && $max_width !== '' ) {
	$max_width_style = ' max-width: ' . intval($max_width) .'px;';
}

if ( $size_type === 'fixed' && $img_height !== '' && $img_width !== '' ) {
	$img_width_style = ' width: '.$img_width.'px;';
	$img_height_style = ' height: '.$img_height.'px;';
}

$js_styles .= ( $max_width_style !== '' || $img_width_style !== '' || $img_height_style !== '' ) ? $unique_class_css.' .wtbx_image_wrapper {' .$max_width_style.$img_width_style.$img_height_style. '}' : '';
$js_styles .= ( $radius_san !== '' ) ? $unique_class_css.' .wtbx_image_inner {'.$radius_san.'}' : '';
$js_styles .= ( $h_overlay !== '' && $overlay_color !== '' ) ? $unique_class_css.' .wtbx_image_element_overlay {'.wtbx_vc_color_styles_bg($overlay_color).'}' : '';

$output .= wtbx_vc_js_styles($js_styles);

// shortcode

$output .= '<div class="wtbx_image_wrapper wtbx_with_image' . $this->getExtraClass( $anim_class ).'">';
$output .= $valid_image ? wtbx_vc_preloader($lazy, $preloader) : '';
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_image_inner'.wtbx_vc_reveal_class($lazy).'">';

$output .= $link['open'];
$output .= $link['close'];
$output .= $image_el;
$output .= ( !empty($link['open']) && !empty($link['close']) ) ? $icon : '';
$output .= $overlay;
$output .= '</div>';
$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
