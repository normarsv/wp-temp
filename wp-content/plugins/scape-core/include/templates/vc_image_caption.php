<?php
$output = $link = $el_class = $unique_class = $img_width = $img_height = $ratio = $navigation =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-imagecaption' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_image_caption';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_' . $caption_appear;
$shortcode_class[]  = 'wtbx_skin_' . $skin;
$shortcode_class[]  = 'wtbx_scheme_' . $scheme;
$shadow !== '' ? $shortcode_class[] = 'wtbx_' . $shadow : null;
$overlay_mobile === 'yes' ? $shortcode_class[] = 'force_mobile_hover' : null;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// image markup
$image_el = '';
$valid_image = false;
if ( $image !== '' ) {

	if ( $aspect_ratio !== '' && strpos($aspect_ratio, ':') !== false ) {
		$aspects = explode(':', $aspect_ratio);
		$aspects[0] = is_numeric($aspects[0]) ? intval($aspects[0]) : '';
		$aspects[1] = is_numeric($aspects[1]) ? intval($aspects[1]) : '';
		if ( $aspects[0] !== '' && $aspects[1] !== '' ) {
			$ratio = $aspects[0] . ':' . $aspects[1];

			$image_el .= '<div class="wtbx_image_bg' . ($img_link === 'gallery_popup' ? ' wtbx_with_lightbox' : '' ) . '">';
			$image_el .= wtbx_image_smart_crop( $image, 'medium', 'full', $ratio, wtbx_get_alt_text($image), '', true, $lazy );
			$image_el .= '</div>';
			$valid_image = true;

		} else {
			$image_el .= '<div class="wtbx_image_bg' . ($img_link === 'gallery_popup' ? ' wtbx_with_lightbox' : '' ) . '">';
			$image_el .= wtbx_image_smart_img($image, 'medium', 'full', wtbx_get_alt_text($image), '', true, $lazy);
			$image_el .= '</div>';
			$valid_image = true;
		}
	} else  {
		$image_el .= '<div class="wtbx_image_bg' . ($img_link === 'gallery_popup' ? ' wtbx_with_lightbox' : '' ) . '">';
		$image_el .= wtbx_image_smart_img($image, 'medium', 'full', wtbx_get_alt_text($image), '', true, $lazy);
		$image_el .= '</div>';
		$valid_image = true;
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
$caption  = '';
$caption .= '<div class="wtbx_image_caption_content">';
$caption .= '<div class="wtbx_image_caption_title">'.esc_html($title).'</div>';
$caption .= '<div class="wtbx_image_caption_descr">'.esc_html($description).'</div>';
$caption .= '</div>';

// link
if ( $img_link === 'page_link' ) {
	$link = wtbx_vc_build_link($link, 'wtbx_image_overlap');
} else {
	$link = array();

	if ( $img_link === 'image_popup' && $image !== '' ) {
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
		foreach ( $images as $gallery_image ) {
			if ( isset($gallery_image) ) {
				$attachments[] = array(
					'src'   => wp_get_attachment_image_url( $gallery_image, 'full' ),
					'thumb' => wp_get_attachment_image_url( $gallery_image, 'medium' )
				);
			}
		}
		$link['open'] = '<div class="wtbx_image_overlap wtbx-lightbox-item" data-dynamic="1" data-dynamicel="' . esc_attr(json_encode($attachments)) . '"' . wtbx_lightbox_attributes() . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} elseif ( $img_link === 'video_popup' ) {
		$attachments[] = array(
			'src'   => wp_get_attachment_image_url( $image, 'full' ),
			'thumb' => wp_get_attachment_image_url( $image, 'medium' )
		);
		$link['open'] = '<div class="wtbx_image_overlap wtbx-lightbox-item" data-dynamic="1" data-iframe="1" data-dynamicel="' . esc_url(json_encode($iframe_link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} else {
		$link['open'] = '<div class="wtbx_image_overlap">';
		$link['close'] = '</div>';
	}
}



// typography
$title_typography_string = wtbx_font_styling($title_typography);
$description_typography_string = wtbx_font_styling($description_typography);


$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( $style === 'style_2' && $scheme === 'colorful' && $bg_color !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_image_inner:before {'.wtbx_vc_color_styles_bg($bg_color).'}';
}
$js_styles .= $radius_san !== '' ? $unique_class_css.' .wtbx_image_inner {' .$radius_san. '}' : '';
$js_styles .= $title_typography_string !== '' ? $unique_class_css.' .wtbx_image_caption_title {' .$title_typography_string. '}' : '';
$js_styles .= $description_typography_string !== '' ? $unique_class_css.' .wtbx_image_caption_descr {' .$description_typography_string. '}' : '';

$output .= wtbx_vc_js_styles($js_styles);

// shortcode

$output .= '<figure class="wtbx_image_wrapper wtbx_preloader_cont wtbx_with_image' . $this->getExtraClass( $anim_class ).'">';
$output .= $valid_image ? wtbx_vc_preloader($lazy, $preloader) : '';
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_image_inner touchhover'.wtbx_vc_reveal_class($lazy).'">';

$output .= $link['open'];
$output .= $link['close'];
$output .= $image_el;

if ( $style !== 'style_3' ) {
	$output .= $caption;
}
$output .= '</div>';
if ( $style === 'style_3' ) {
	$output .= $caption;
}
$output .= '</div>';
$output .= '</div>';
$output .= '</figure>';

$output .= '</div>';


echo $output;
