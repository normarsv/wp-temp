<?php
$output = $el_class = $unique_class = $img_width = $img_height = $ratio = $navigation = '';
$link = array();

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_image_box';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$align !== '' ? $shortcode_class[] = 'wtbx_ib_align_' . $align : null;
$skin !== '' ? $shortcode_class[] = 'wtbx_skin_' . $skin : null;

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


// link
if ( $img_link === 'page_link' ) {
	$link = wtbx_vc_build_link($link, 'wtbx_image_overlay');
	$link['content'] = '<div class="wtbx_image_box_button"><i class="scape-ui-link"></i></div>';
} else {
	$link = array();

	if ( $img_link === 'image_popup' && $image !== '' ) {
		$attachments[] = array(
			'src'   => wp_get_attachment_image_url( $image, 'full' ),
			'thumb' => wp_get_attachment_image_url( $image, 'medium' )
		);
		$link['open'] = '<div class="wtbx_image_overlay wtbx-lightbox-item" data-dynamic="1" data-dynamicel="' . esc_attr(json_encode($attachments)) . '"' . wtbx_lightbox_attributes() . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['content'] = '<div class="wtbx_image_box_button"><i class="scape-ui-maximize"></i></div>';
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
		$link['open'] = '<div class="wtbx_image_overlay wtbx-lightbox-item" data-dynamic="1" data-dynamicel="' . esc_attr(json_encode($attachments)) . '"' . wtbx_lightbox_attributes() . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['content'] = '<div class="wtbx_image_box_button"><i class="scape-ui-grid"></i></div>';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} elseif ( $img_link === 'video_popup' ) {
		$attachments[] = array(
			'src'   => wp_get_attachment_image_url( $image, 'full' ),
			'thumb' => wp_get_attachment_image_url( $image, 'medium' )
		);
		$link['open'] = '<div class="wtbx_image_overlay wtbx-lightbox-item" data-dynamic="1" data-iframe="1" data-dynamicel="' . esc_url(json_encode($iframe_link)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
		$link['content'] = '<div class="wtbx_image_box_button"><i class="scape-ui-play"></i></div>';
		$link['close'] = '</div>';
		wtbx_vc_lightbox_nav();
	} else {
		$link['open'] = '';
		$link['content'] = '';
		$link['close'] = '';
	}
}




// content
$innner = '<div class="wtbx_image_box_content">';
//$content .= '<div class="wtbx_image_box_text">';
$innner .= '<div class="wtbx_image_box_title">'.esc_html($title).'</div>';
$innner .= '<div class="wtbx_image_box_descr">'.wpb_js_remove_wpautop($content, true).'</div>';
//$content .= '</div>';
if ( $style === 'style_2' ) {
	$innner .= $link['open'];
	$innner .= $link['close'];
	$innner .= $link['content'];
}
$innner .= '</div>';


// typography
$title_typography_string = wtbx_font_styling($title_typography);


// colors
$bg_color_string = wtbx_vc_color_styles_bg($bg_color);
$bg_overlay = wtbx_vc_color_styles_bg($overlay_color);



$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $radius !== '' ? $unique_class_css.'.wtbx_style_1 .wtbx_image_inner,'.$unique_class_css.'.wtbx_style_2 .wtbx_image,'.$unique_class_css.'.wtbx_style_2 .wtbx_image_box_content {border-radius:' .$radius. 'px;}' : '';
$js_styles .= $title_typography_string !== '' ? $unique_class_css.' .wtbx_image_wrapper .wtbx_image_box_content .wtbx_image_box_title {' .$title_typography_string. '}' : '';
$js_styles .= $bg_color_string !== '' ? $unique_class_css.'.wtbx_style_2  .wtbx_image_box_content {' .$bg_color_string. '}' : '';
$js_styles .= $bg_overlay !== '' ? $unique_class_css.'.wtbx_style_1 .wtbx_image_overlay:before {' .$bg_overlay. '}' : '';

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<figure class="wtbx_image_wrapper wtbx_preloader_cont wtbx_with_image' . $this->getExtraClass( $anim_class ).'">';
$output .= $valid_image ? wtbx_vc_preloader($lazy, $preloader) : '';
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_image_inner'.wtbx_vc_reveal_class($lazy).'">';

$output .= '<div class="wtbx_image">';
$output .= $image_el;
if ( $style === 'style_1' ) {
	$output .= $link['open'];
	$output .= $link['content'];
	$output .= $link['close'];
	$output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none">';
	$output .= '<path d="M0 100 L0 90 C40 -30 60 -30 100 90 L100 100 Z" fill="#ffffff"></path>';
	$output .= '</svg>';
}

$output .= '</div>';

$output .= $innner;

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

$output .= '</figure>';

$output .= '</div>';

echo $output;
