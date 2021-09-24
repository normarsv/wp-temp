<?php
$output = $link = $el_class = $unique_class = $style = $icon = $heading_typography = $lazy =
$section_align = $bg_image_el = $bg_style = $custom_bg_effect = $textalign_small = $opposite_float =
$bg_parallax = $bg_scale = $bg_mousemove = $bg_video_el = $bg_video_poster = $video_poster = $video_sound =
$overlay_color = $bg_anim_el = $anim_bg_styles = $animated_layer = $anim_direction = $anim_bg_style =
$segments_style = $disable_margins = $disable_borders = $disable_padding = $disable_columns_gap =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = $full_height =
$section_show_on = $row_height = $row_min_height = $wrapper_height = $max_width = $disable_css_animation =
$bg_parallax_cont_class = $bg_scale_elem_class = $bg_parallax_elem_class = $bg_overlay = $row_alignment = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

$h_typography_string = wtbx_font_styling($heading_typography);

// privacy consent check
$allow_content = true;
if ( $consent_include === 'include' && !wtbx_vc_has_consent($consent_id) ) {
	$allow_content = false;
} elseif ( $consent_include === 'exclude' && wtbx_vc_has_consent($consent_id) ) {
	$allow_content = false;
}

// shortcode class
$element_class      = 'wtbx_vc_inner_row';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
wtbx_vc_is_page_editable() ? $shortcode_class[]  = 'vc_row' : null;
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = $row_width;
$row_alignment !== '' ? $shortcode_class[] = 'wtbx_force_align_' . $row_alignment : null;
$textalign !== '' ? $shortcode_class[] = 'wtbx_' . $textalign : null;
$textalign_small !== '' ? $shortcode_class[] = 'wtbx_center_align_' . $textalign_small : null;
$opposite_float !== '' ? $shortcode_class[] = 'wtbx_opposite_float' : null;
($row_show_on != '') ? $shortcode_class[] = str_replace(',', ' ', $row_show_on)  : null;

// disable row display
if ( 'yes' === $disable_element ) {
	if ( wtbx_vc_is_page_editable() ) {
		$shortcode_class[] = $this->getExtraClass('vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md');
	} else {
		return '';
	}
}

// row height
if ($row_height_type !== '' ) {
	$shortcode_class[] = 'wtbx_row_' . $row_height_type;
	if ( $row_height_type === 'fixed_height_screen' && $height !== '' ) {
		$row_height = ' height:' . intval($height) . 'vh' . ';';
	}
}
if ( $min_height !== '' ) {
	$row_min_height = ' min-height:' . intval($min_height) . 'px' . ';';
}

// equal height columns
if ( $gap !== '' ) {
	$shortcode_class[] = 'wtbx_column-gap-' . $gap;
}

if ( $equal_height !== '' ) {
	$flex_row = true;
//	$shortcode_class[] = 'wtbx_row-equal-height';

	if (  $columns_placement !== '' ) {
//		$flex_row = true;
		$shortcode_class[] = 'wtbx_row-flex-align-' . $columns_placement;
	}

	if (  $content_placement !== '' ) {
//		$flex_row = true;
		$shortcode_class[] = 'wtbx_row-content-align-' . $content_placement;
	}

//	if ( $flex_row !== '' ) {
	$shortcode_class[] = 'wtbx_row-flex';
//	}
}

// background image
if ( $custom_bg_type === 'image' && $custom_bg_image !== '' ) {
	$bg_styles = array();
	$bg_image_el = wtbx_image_smart_bg( $custom_bg_image, 'medium', 'full', false, wtbx_get_alt_text($custom_bg_image), 'wtbx_row_bg_image', true, $lazy );

	$custom_bg_cover !== '' ? $bg_styles[] = 'background-size:'.$custom_bg_cover : null;
	$custom_bg_repeat !== '' ? $bg_styles[] = 'background-repeat:'.$custom_bg_repeat : null;
	$custom_bg_position !== '' ? $bg_styles[] = 'background-position:'.strtolower($custom_bg_position) : null;
	$custom_bg_attachment !== '' ? $bg_styles[] = 'background-attachment:'.$custom_bg_attachment : null;

	$bg_style = implode('; ', $bg_styles);
}

// disable CSS properties on smaller screens
$disable_css_class = array();
$disable_fixed_height !== '' ? $disable_css_class[] = 'wtbx_disable_height_' . $disable_fixed_height : null;
//$disable_margins !== '' ? $disable_css_class[] = 'wtbx_disable_margins_' . $disable_margins : null;
//$disable_borders !== '' ? $disable_css_class[] = 'wtbx_disable_borders_' . $disable_borders : null;
//$disable_padding !== '' ? $disable_css_class[] = 'wtbx_disable_padding_' . $disable_padding : null;
$disable_columns_gap !== '' ? $disable_css_class[] = 'wtbx_disable_gap_' . $disable_columns_gap : null;
$disable_css_class = implode(' ', $disable_css_class);
$disable_css_class !== '' ? $disable_css_class = ' ' . $disable_css_class : null;

// typography
$typography_string = wtbx_font_styling($typography);


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
($section_show_on != '') ? $css_class .= $this->getExtraClass( str_replace(',', ' ', $section_show_on) ) : '';


$output  = '';
$output .= '<div class="wtbx_vc_row '.esc_attr($css_class).'"'.($row_id !== '' ? ' id="'.esc_attr($row_id).'"' : '').'>';


// styles
$unique_class_css = '.' . $unique_class;
$js_styles = '';

$custom_bg_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_inner_row_bg {' . wtbx_vc_color_styles_bg($custom_bg_color) . '}' : null;
$bg_style !== '' ? $js_styles .= $unique_class_css.' .wtbx-bg-image .wtbx-bg-image-inner .wtbx_inner_row_bg_image, '.$unique_class_css.'.wtbx_anim_bg_segments .wtbx_anim_segments .wtbx_anim_image {' . $bg_style . '}' : null;

if ( $row_height_type === 'fixed_height_screen' ) {
	$js_styles .= $unique_class_css.' .wtbx_inner_row_content_inner {' . $row_height . '}';
}
if ( $row_min_height !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_inner_row_content_inner {' . $row_min_height . '}';
}
if ( $max_width !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_vc_inner_row .wtbx_inner_row_content {max-width:' . intval($max_width) . 'px; margin: 0 auto;}';
}

$typography_string !== '' || $font_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_inner_row_content_inner {' . wtbx_vc_color_styles_text($font_color) . $typography_string . '}' : null;

$margin_selector    = $unique_class_css . ' .' . $element_class . '_inner';
$border_selector    = $unique_class_css . ' .wtbx_inner_row_bg';
$padding_selector   = $unique_class_css . ' .wtbx_inner_row_content_inner';
$offset_selector    = $unique_class_css . ' .wtbx_inner_row_content_wrapper';
$zindex_selector    = $unique_class_css;
$js_styles .= wtbx_vc_scape_design_styles($el_design, $margin_selector, $border_selector, $padding_selector, $offset_selector, $zindex_selector);

$color_border = wtbx_vc_color_styles_border($border_color);
$js_styles .= $color_border !== '' ? $unique_class_css.' .wtbx_inner_row_bg {' . $color_border .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner ' . esc_attr($element_class) . '_inner">';
$output .= '<div class="wtbx_inner_row_wrapper">';

if ( $allow_content ) {
	$output .= '<div class="wtbx_inner_row_bg">';
	$output .= '<div class="wtbx_inner_row_bg_inner wtbx-element-reveal wtbx-reveal-cont' . $bg_parallax_cont_class . '">';
	$output .= '<div class="wtbx_inner_row_bg_media_wrapper wtbx-entry-media' . $bg_scale_elem_class . '"' . $bg_scale . '>';
	$output .= '<div class="wtbx_inner_row_bg_media' . $bg_parallax_elem_class . '"' . $bg_parallax . $bg_mousemove . '>';
	$output .= $bg_image_el;
	$output .= '</div>'; // end of media
	$output .= '</div>'; // end of media wrapper

	$output .= $bg_overlay;
	$output .= '</div>'; // end of bg inner
	$output .= '</div>'; // end of bg
} elseif ( !wtbx_vc_is_page_editable() ) {
	if ( $consent_poster !== '' ) {
		$output .= wtbx_noconsent_content($consent_id, $consent_poster);
	}
}

$output .= '<div class="wtbx_inner_row_content clearfix">';
$output .= '<div class="wtbx_inner_row_content_wrapper">';
$output .= '<div class="wtbx_inner_row_content_inner' . (wtbx_vc_is_page_editable() ? ' wpb_row' : '') . ' clearfix">';

if ( wtbx_vc_is_page_editable() || $allow_content ) {
	$output .= wpb_js_remove_wpautop($content);
}

$output .= '</div>';  // end of content
$output .= '</div>';
$output .= '</div>';


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>";
	echo "jQuery('".$unique_class_css."').parent().css('z-index', jQuery('".$unique_class_css."').css('z-index'));";
	echo "if ( jQuery('".$unique_class_css."').hasClass('wtbx_force_align_top') ) {jQuery('".$unique_class_css."').parent().addClass('wtbx_force_align_top')};";
	echo "if ( jQuery('".$unique_class_css."').hasClass('wtbx_force_align_middle') ) {jQuery('".$unique_class_css."').parent().addClass('wtbx_force_align_middle')};";
	echo "if ( jQuery('".$unique_class_css."').hasClass('wtbx_force_align_bottom') ) {jQuery('".$unique_class_css."').parent().addClass('wtbx_force_align_bottom')};";
	echo "</script>";
}