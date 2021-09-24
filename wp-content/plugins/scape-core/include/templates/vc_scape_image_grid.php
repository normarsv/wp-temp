<?php
$output = $el_class = $layout_cols = $lightbox_atts = $highlight = $hide = $limit = $style = $disable_sequential = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wtbx_vc_script_queue('isotope');
if ( $style === 'metro' ) { wtbx_vc_script_queue('packery'); }

// shortcode class
$element_class      = 'wtbx_vc_image_grid';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// unique grid ID
$gridID = hexdec(substr(uniqid(), 6, 7));


// define image size
$src_size       = 'small';
$srcset_size    = 'full';


// link
if ( $click_action === 'gallery_popup' ) {
	$lightbox_atts  = wtbx_lightbox_attributes();
	wtbx_vc_lightbox_nav();
}


// boxed layout classes
$rh_cont = $rh = $rh_layer = $hightlight = '';
if ( $style === 'boxed' ) {
	$rh_cont    = ' wtbx-rollhover-container';
	$rh         = ' wtbx-rollhover';
	$rh_layer   = ' wtbx-rollhover-layer';
	$highlight = '<div class="item-highlight"></div>';
}


// image markup
$image_el = '';
if ( $images !== '' ) {
	$images = explode(',', $images);
	$custom_layout = false;

	if ( strpos($metro_layout, 'layout') !== false ) {
		$custom_layout = true;
	}

	if ( $style === 'metro' ) {
		if ($custom_layout) {
			$layout_obj = wtbx_vc_grid_layouts($metro_layout);
			$layout_cols = ' data-layout-cols="'.$layout_obj['columns'].'"';
			$counter = 0;
			$limit = !empty($limit) ? intval($limit) : sizeof($images);
		}

		for ( $i = 0; $i < sizeof($images); $i++ ) {
			if (!$custom_layout) {
				$data_width = 1;
				$data_height = 1;
			} else {
				$tiles = $layout_obj['tiles'];
				$current = $i-$tiles*$counter;
				$data_width = $layout_obj['width'][$current];
				$data_height = $layout_obj['height'][$current];
				$hide = $i >= $limit ? ' wtbx_hide_responsive' : '';
			}

			$ratio = $data_width . ':' . $data_height;

			$image_el .= '<div class="wtbx_grid_entry wtbx_preloader_cont'.esc_attr($hide).'" data-width="'.$data_width.'" data-height="'.$data_height.'">';
			$image_el .= wtbx_vc_preloader($lazy, $preloader);
			$image_el .= '<div class="wtbx_grid_item_container wtbx_appearance_animation wtbx-grid-anim-'.$animation_style . wtbx_vc_reveal_class($lazy) . '" data-slide="'.($i+1).'">';
			if ( $click_action === 'gallery_popup' ) {
				$image_el .= '<a class="wtbx-lightbox-item" href="'. esc_url(wp_get_attachment_image_url( $images[$i], 'full' )) .'" data-thumbimage="'. esc_url(wp_get_attachment_image_url( $images[$i], 'medium' )) .'">';
			}
			$image_el .= '<div class="wtbx_grid_item_inner">';
			$image_el .= $overlay_trigger !== '' ? '<div class="wtbx_overlay wtbx_'.$overlay_trigger.'">'.($overlay_content === 'icon' ? '<span class="wtbx_image_grid_icon"></span>' : '' ).'</div>' : '';
			$image_el .= wtbx_image_smart_crop($images[$i], 'medium', 'full', false, wtbx_get_alt_text($images[$i]), '', true, $lazy);
			$image_el .= '</div>';
			if ( $click_action === 'gallery_popup' ) {
				$image_el .= '</a>';
			}
			$image_el .= '</div>';
			$image_el .= '</div>';

			if ($custom_layout) {
				if ( $i >= ($tiles-1) && ($i+1) % ($tiles) === 0 ) {
					$counter++;
				}
			}

		}
	} else {
		if ( $aspect_ratio !== '' && strpos($aspect_ratio, ':') !== false ) {
			$aspects = explode(':', $aspect_ratio);
			$aspects[0] = is_numeric($aspects[0]) ? intval($aspects[0]) : '';
			$aspects[1] = is_numeric($aspects[1]) ? intval($aspects[1]) : '';
		}

		for ( $i = 0; $i < sizeof($images); $i++ ) {

			$image_el .= '<div class="wtbx_grid_entry wtbx_preloader_cont">';
			$image_el .= wtbx_vc_preloader($lazy, $preloader);
			if ( $click_action === 'gallery_popup' ) {
				$image_el .= '<a class="wtbx_grid_item_container wtbx_appearance_animation wtbx-element-reveal wtbx-grid-anim-'.$animation_style . $rh_cont . wtbx_vc_reveal_class($lazy) . ' wtbx-lightbox-item" data-slide="'.($i+1).'" href="'. esc_url(wp_get_attachment_image_url( $images[$i], 'full' )) .'" data-thumbimage="'. esc_url(wp_get_attachment_image_url( $images[$i], 'medium' )) .'">';
			} else {
				$image_el .= '<div class="wtbx_grid_item_container wtbx_appearance_animation wtbx-element-reveal wtbx-grid-anim-'.$animation_style . $rh_cont . wtbx_vc_reveal_class($lazy) . '" data-slide="'.($i+1).'">';
			}
			$image_el .= '<div class="wtbx_grid_item_inner'.$rh.'">';
			$image_el .= $highlight;
			$image_el .= $overlay_trigger !== '' ? '<div class="wtbx_overlay wtbx_'.$overlay_trigger.'">'.($overlay_content === 'icon' ? '<span class="wtbx_image_grid_icon"></span>' : '' ).'</div>' : '';

			if (isset($aspects[0]) && isset($aspects[1]) ) {
				$ratio = $aspects[0] . ':' . $aspects[1];
			} else {
				$metadata = wp_get_attachment_metadata( $images[$i] );
				$ratio = $metadata['width'] . ':' . $metadata['height'];
			}

			$image_el .= wtbx_image_smart_crop($images[$i], 'medium', 'full', $ratio, wtbx_get_alt_text($images[$i]), '', true, $lazy);


			$image_el .= '</div>';
			if ( $click_action === 'gallery_popup' ) {
				$image_el .= '</a>';
			} else {
				$image_el .= '</div>';
			}
			$image_el .= '</div>';

		}
	}
}

if ( $style === 'metro' && strpos($metro_layout, 'columns') !== false ) {
	$columns = explode('columns_', $metro_layout)[1];
}


// border radius
$border = $border !== '' ? ' border-radius:' . intval($border) . 'px' : '';


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$js_styles .= $border !== '' ? $unique_class_css.' .wtbx_grid_entry {' .$border. '}' : '';
$js_styles .= ( $overlay_trigger !== '' && $overlay_color !== '' ) ? $unique_class_css.' .wtbx_overlay {'.wtbx_vc_color_styles_bg($overlay_color).'}' : '';

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';


$output .= '<div class="wtbx_isotope_grid wtbx_image_grid_container wtbx-grid wtbx-grid-'.$style.' wtbx-grid-anim-container wtbx-container-reveal wtbx-lightbox-container" data-columns="'.$columns.'" data-gutter="'.$gutter.'" data-border="'.$border.'" data-id="'.$gridID.'" data-grid="'.$style.'" data-seq="'.$disable_sequential.'"'.$layout_cols.' '.$lightbox_atts.'>';

$output .= $image_el;

$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {";
	echo "SCAPE.isotopeGrid.init(jQuery('.wtbx_isotope_grid'));";
	echo "SCAPE.gridReveal(jQuery('.wtbx-grid').find('.wtbx-element-reveal:not(.wtbx-element-visible)'));";
	echo '}</script>';

}