<?php
$output = $el_class = $unique_class = $style = $responsiveness = $padding =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'scape-image-carousel' );

// styles and buttons
$buttons = '';
$slides_to_scroll = $slides_to_scroll === '1' ? 1 : 'auto';
$slide_width = $slides_to_show;
if ( $style === 'simple' ) {
	if ( $navigation === '1' ) {
		$buttons .= '<div class="wtbx_image_carousel_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_' . $navigation_skin . '">';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev wtbx-click"></div>';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_next wtbx-click"></div>';
		$buttons .= '</div>';
	}
} elseif ( $style === 'scale' ) {
	$buttons .= '<div class="wtbx_image_carousel_nav wtbx_arrows wtbx_arrows_inside wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev wtbx-click"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next wtbx-click"></div>';
	$buttons .= '</div>';
	$slides_to_scroll = 1;
	$slide_width = 'scale';
	$slides_to_show_tablet = $slides_to_show_mobile = 1;
} elseif ( $style === 'centered' ) {
	$buttons .= '<div class="wtbx_image_carousel_nav wtbx_arrows wtbx_arrows_inside_wide wtbx_nav_skin_'.$navigation_skin.'">';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev wtbx-click"></div>';
	$buttons .= '<div class="wtbx_arrow wtbx_arrow_next wtbx-click"></div>';
	$buttons .= '</div>';
	$slides_to_scroll = 1;
	$slide_width = 'centered';
	$slides_to_show_tablet = $slides_to_show_mobile = 1;
} elseif ( $style === 'overlap' ) {
	if ( $navigation === '1' ) {
		$buttons .= '<div class="wtbx_image_carousel_nav wtbx_arrows wtbx_arrows_default wtbx_nav_skin_' . $navigation_skin . '">';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_prev wtbx-click"></div>';
		$buttons .= '<div class="wtbx_arrow wtbx_arrow_next wtbx-click"></div>';
		$buttons .= '</div>';
		$slides_to_show = $slides_to_show_tablet = $slides_to_show_mobile = 1;
		$slides_to_scroll = 1;
	}
}


// shortcode class
$element_class      = 'wtbx_vc_image_carousel';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_style_' . $style;
$hide_nav === 'true' ? $shortcode_class[] = 'wtbx_hide_nav' : null;
$slider_pagination !== '' ? $shortcode_class[] = 'wtbx_pagination_enabled' : null;
if ( $responsiveness === 'true' ) {
	$shortcode_class[] = 'wtbx_responsive';
}
if ( $shadow !== '' ) {
	$shortcode_class[] = 'wtbx_' . $shadow;
}
if ( ($style === 'simple' || $style === 'overlap') && $navigation === '' ) {
	$shortcode_class[] = 'wtbx_no_arrows';
}



// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


$dots = true;
if ( $slider_pagination === '' || $slider_pagination === 'style_3' ) {
	$dots = '';
}

// slider settings
$max_attraction = 0.15;
$min_attraction = 0.005;
$max_friction   = 0.7;
$min_friction   = 0.2;
$attraction = intval($slider_speed) / 100 * $max_attraction + $min_attraction;
$friction   = intval($slider_speed) / 100 * $max_friction + $min_friction;

$data  = '';
$data .= ' data-align="' . ( $style === 'simple' ? 'left' : 'center' ) . '"';
$data .= ' data-slides="'.$slides_to_show.'"';
$data .= ' data-slides-to-scroll="'.$slides_to_scroll.'"';
$data .= ' data-attraction="'.$attraction.'"';
$data .= ' data-friction="'.$friction.'"';
if ( intval($autoplay) > 0 ) {
	$data .= ' data-autoplay="'.($autoplay * 1000).'"';
}
$data .= ' data-pause="'.$stop_hover.'"';
//$data .= ' data-drag="'.$mouse_drag.'"';
//$data .= ' data-infinite="'.$infinite.'"';
$data .= ' data-initial="' . ($initial_slide !== '' ? intval($initial_slide)-1 : '0') . '"';
$data .= ' data-dots="'.$dots.'"';
$data .= ' data-height="' . $autoheight . '"';
$data .= ' data-pagination-class="wtbx_dots wtbx_dots_'.$slider_pagination.' wtbx_nav_skin_'.$pagination_skin.'"';
$data .= ' data-slides-desktop="' . $slide_width . '"';
if ( $style === 'simple' ) {
	$data .= ' data-freescroll="' . $freescroll .'"';
}
if ( $responsiveness === 'true' ) {
	$data .= ' data-slides-tablet="' . $slides_to_show_tablet . '"';
	$data .= ' data-slides-mobile="' . $slides_to_show_mobile .'"';
}

// link
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
	$link['open'] = $link['close'] = '';
}

// padding
if ( $style === 'simple' ) {
	$padding = wtbx_vc_scape_design($padding);
}

// image markup
$image_el = '';
if ( $images !== '' ) {
	$images = explode(',', $images);
	$slides = $images;

	if ( $aspect_ratio !== '' && strpos($aspect_ratio, ':') !== false ) {
		$aspects = explode(':', $aspect_ratio);
		$aspects[0] = is_numeric($aspects[0]) ? intval($aspects[0]) : '';
		$aspects[1] = is_numeric($aspects[1]) ? intval($aspects[1]) : '';
		if (isset($aspects[0]) && isset($aspects[1]) ) {
			$ratio = $aspects[0] . ':' . $aspects[1];

			foreach ( $images as $image ) {
				$image_el .= '<div class="wtbx_carousel_item wtbx_preloader_cont">';
				$image_el .= wtbx_vc_preloader($lazy, $preloader);
				$image_el .= '<div class="wtbx_carousel_item_container' . wtbx_vc_reveal_class($lazy) . '">';
				$image_el .= '<div class="wtbx_carousel_item_inner">';
				$image_el .= $link['open'];
				$image_el .= $link['close'];
				$image_el .= wtbx_image_smart_crop( $image, 'medium', 'full', $ratio, wtbx_get_alt_text($image), '', true, $lazy );
				$image_el .= '</div>';
				$image_el .= '</div>';
				$image_el .= '</div>';
			}

		} else {
			foreach ( $images as $image ) {
				$image_el .= '<div class="wtbx_carousel_item wtbx_preloader_cont">';
				$image_el .= wtbx_vc_preloader($lazy, $preloader);
				$image_el .= '<div class="wtbx_carousel_item_container' . wtbx_vc_reveal_class($lazy) . '">';
				$image_el .= '<div class="wtbx_carousel_item_inner">';
				$image_el .= $link['open'];
				$image_el .= $link['close'];
				$image_el .= wtbx_image_smart_img($image, 'medium', 'full', wtbx_get_alt_text($image), '', true, $lazy);
				$image_el .= '</div>';
				$image_el .= '</div>';
				$image_el .= '</div>';
			}
		}
	} else  {
		foreach ( $images as $image ) {
			$image_el .= '<div class="wtbx_carousel_item wtbx_preloader_cont">';
				$image_el .= wtbx_vc_preloader($lazy, $preloader);
				$image_el .= '<div class="wtbx_carousel_item_container' . wtbx_vc_reveal_class($lazy) . '">';
					$image_el .= '<div class="wtbx_carousel_item_inner">';
						$image_el .= $link['open'];
						$image_el .= $link['close'];
						$image_el .= wtbx_image_smart_img($image, 'medium', 'full', wtbx_get_alt_text($image), '', true, $lazy);
					$image_el .= '</div>';
				$image_el .= '</div>';
			$image_el .= '</div>';
		}
	}
}


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$easing = 'cubic-bezier(0.6, 0, 0.2, 1)';
if ( $style === 'simple' ) {
	$js_styles .= $unique_class_css . '.wtbx_style_simple .wtbx_image_carousel_wrapper .wtbx_carousel_item .wtbx_carousel_item_container {' . $padding . '}';
} elseif ( $style === 'scale' || $style === 'centered' ) {
	$js_styles .= $unique_class_css . " .wtbx_carousel_item_container, ".$unique_class_css . " .wtbx_carousel_item_inner { -webkit-transition: all ".$slider_speed."ms ".$easing."; -moz-transition: all ".$slider_speed."ms ".$easing."; -ms-transition: all ".$slider_speed."ms ".$easing."; -o-transition: all ".$slider_speed."ms ".$easing."; transition: all ".$slider_speed."ms ".$easing."; }";
} elseif ( $style === 'overlap' ) {
	$js_styles .= $unique_class_css . " .wtbx_carousel_item, " . $unique_class_css . " .wtbx_carousel_item_container { -webkit-transition: all ".$slider_speed."ms ".$easing." !important; -moz-transition: all ".$slider_speed."ms ".$easing." !important; -ms-transition: all ".$slider_speed."ms ".$easing." !important; -o-transition: all ".$slider_speed."ms ".$easing." !important; transition: all ".$slider_speed."ms ".$easing." !important; }";
}
$js_styles .= $radius !== '' ? $unique_class_css.' .wtbx_carousel_item_inner {border-radius:' .intval($radius). 'px;}' : '';

$output .= wtbx_vc_js_styles($js_styles);

	// shortcode
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
		$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

			$output .= '<div class="wtbx_image_carousel_wrapper">';
				$output .= '<div class="wtbx_image_carousel_inner"'.$data.'>';
					$output .= $image_el;
				$output .= '</div>';

				$output .= $buttons;

				if ( $slider_pagination !== '' ) {
					$output .= '<div class="wtbx_image_carousel_pagination wtbx_slider_pagination wtbx_dots wtbx_dots_'.$slider_pagination.' wtbx_nav_skin_'.$pagination_skin.'">';

						if ( $slider_pagination === 'style_3' ) {
							$output .= '<div class="wtbx_pagination_numbers">';
								$output .= '<ul></ul>';
								$output .= '<div class="wtbx_pagination_total"></div>';
							$output .= '</div>';
						}

					$output .= '</div>';
				}

			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE.imageCarousel) {SCAPE.imageCarousel.init(jQuery('" . $unique_class_css . " .wtbx_image_carousel_inner'));} setTimeout(function(){jQuery(window).trigger('resize'); jQuery('" . $unique_class_css . " .wtbx_image_carousel_inner').flickity('resize'); jQuery('" . $unique_class_css . "').next('[data-type=\"files\"]').remove();},1000);</script>";
}