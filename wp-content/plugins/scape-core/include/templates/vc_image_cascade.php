<?php
$output = $el_class = $unique_class = $img_width = $img_height = $ratio = $navigation = $lightbox_atts =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-imagecascade' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay);


// shortcode class
$element_class      = 'wtbx_vc_image_cascade';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[]  = 'wtbx_layout_' . $layout;
$shadow !== '' ? $shortcode_class[] = 'wtbx_' . $shadow : null;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// link
$link = array();
if ( $img_link === 'gallery_popup' && $images !== '' ) {
	$lightbox_atts = wtbx_lightbox_attributes();
	$attachments = array();
	$gallery_images = explode(",", $images);
	foreach ( $gallery_images as $gallery_image ) {
		$attachments[] = array(
			'src'   => wp_get_attachment_image_url( $gallery_image, 'full' ),
			'thumb' => wp_get_attachment_image_url( $gallery_image, 'medium' )
		);
	}
	$link['open'] = '<div class="wtbx_image_overlap wtbx-lightbox-item" data-dynamic="1" data-dynamicel="' . esc_attr(json_encode($attachments)) . '"' . wtbx_lightbox_attributes() . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '">';
	$link['close'] = '</div>';
	wtbx_vc_lightbox_nav();
} else {
	$link['open'] = '';
	$link['close'] = '';
}


// image limit
$image_limits = array(
	'1' => 2,
	'2' => 2,
	'3' => 2,
	'4' => 2,
	'5' => 3,
	'6' => 3,
	'7' => 3,
	'8' => 3,
	'9' => 4,
	'10' => 4,
	'11' => 4,
	'12' => 4
);


// image markup
$image_el = '';

if ( $images !== '' ) {
	$images = explode(',', $images);

	if ( $aspect_ratio !== '' && strpos($aspect_ratio, ':') !== false ) {
		$aspects = explode(':', $aspect_ratio);
		$aspects[0] = is_numeric($aspects[0]) ? intval($aspects[0]) : '';
		$aspects[1] = is_numeric($aspects[1]) ? intval($aspects[1]) : '';
		if (isset($aspects[0]) && isset($aspects[1]) ) {
			$ratio = $aspects[0] . ':' . $aspects[1];

			for ( $i=0; $i < sizeof($images); $i++ ) {
				if ( $i < $image_limits[$layout] ) {
					$image_el .= '<div class="wtbx_image_wrapper wtbx_cascade_image_'.($i+1).wtbx_vc_reveal_class($lazy) . ($img_link === 'gallery_popup' ? ' wtbx_with_lightbox' : '' ) . '" data-slide="'.($i+1).'">';
					$image_el .= '<div class="wtbx_image_inner">';
					if ($img_link === 'gallery_popup') $image_el .= '<a class="wtbx_image_overlap wtbx-lightbox-item" href="'.esc_attr(wp_get_attachment_image_url( $images[$i], 'full' )).'" data-thumbimage="'.esc_url(wp_get_attachment_image_url( $images[$i], 'medium' )).'"></a>';
					$image_el .= wtbx_image_smart_crop( $images[$i], 'medium', 'full', $ratio, wtbx_get_alt_text($images[$i]), '', true, $lazy );
					$image_el .= '</div>';
					$image_el .= '</div>';
				}
			}

		} else {
			for ( $i=0; $i < sizeof($images); $i++ ) {
				if ( $i < $image_limits[$layout] ) {
					$image_el .= '<div class="wtbx_image_wrapper wtbx_cascade_image_'.($i+1).wtbx_vc_reveal_class($lazy) . ($img_link === 'gallery_popup' ? ' wtbx_with_lightbox' : '' ) . '" data-slide="'.($i+1).'">';
					$image_el .= '<div class="wtbx_image_inner">';
					if ($img_link === 'gallery_popup') $image_el .= '<a class="wtbx_image_overlap wtbx-lightbox-item" href="'.esc_attr(wp_get_attachment_image_url( $images[$i], 'full' )).'" data-thumbimage="'.esc_url(wp_get_attachment_image_url( $images[$i], 'medium' )).'"></a>';
					$image_el .= wtbx_image_smart_img($images[$i], 'medium', 'full', wtbx_get_alt_text($images[$i]), '', true, $lazy);
					$image_el .= '</div>';
					$image_el .= '</div>';
				}
			}
		}
	} else  {
		for ( $i=0; $i < sizeof($images); $i++ ) {
			if ( $i < $image_limits[$layout] ) {
				$image_el .= '<div class="wtbx_image_wrapper wtbx_cascade_image_'.($i+1).wtbx_vc_reveal_class($lazy) . ($img_link === 'gallery_popup' ? ' wtbx_with_lightbox' : '' ) . '" data-slide="'.($i+1).'">';
				$image_el .= '<div class="wtbx_image_inner">';
				if ($img_link === 'gallery_popup') $image_el .= '<a class="wtbx_image_overlap wtbx-lightbox-item" href="'.esc_attr(wp_get_attachment_image_url( $images[$i], 'full' )).'" data-thumbimage="'.esc_url(wp_get_attachment_image_url( $images[$i], 'medium' )).'"></a>';
				$image_el .= wtbx_image_smart_img($images[$i], 'medium', 'full', wtbx_get_alt_text($images[$i]), '', true, $lazy);
				$image_el .= '</div>';
				$image_el .= '</div>';
			}
		}
	}
}


// border radius
$border = $border !== '' ? ' border-radius:' . intval($border) . 'px' : '';


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';
$js_styles .= $border !== '' ? $unique_class_css.' .wtbx_image_wrapper {' .$border. '}' : '';
$output .= wtbx_vc_js_styles($js_styles);


$output .= '<div class="'.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_image_cascade_wrapper wtbx_vc_el_container">';
$output .= '<div class="wtbx_image_cascade_inner wtbx_preloader_cont wtbx-lightbox-container" '.$lightbox_atts.'>';
$image_el .= wtbx_vc_preloader($lazy, $preloader);
$output .= $image_el;
$output .= '</div>';
$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
