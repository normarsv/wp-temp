<?php
$output = $link = $el_class = $unique_class = $style = $icon = $heading_typography =
$icon_anim = $svg = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-service' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

$h_typography_string = wtbx_font_styling($heading_typography);
$b_typography_string = wtbx_font_styling($bullet_typography);

// shortcode class
$element_class      = 'wtbx_vc_service';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// element style
$shortcode_class[] = 'wtbx_style_' . $style;
//$shortcode_class[] = 'wtbx_bullet_' . $bullet_size;
$shortcode_class[] = 'wtbx_bullet_cont_' . $bullet_cont;
$shortcode_class[] = 'wtbx_bullet_' . $shadow;
$shortcode_class[] = 'wtbx_bullet_' . $border;

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// icon markup
if ( $bullet_type === 'icon' ) {
	if ( !empty($icon) ) {
		$i_icon = (array) json_decode($icon, true);
		if ( is_array($i_icon) ) {
			$i_font = $i_icon['font'];
			$i_icon = $i_icon['icon'];

			if ( $i_font === 'linea' && $icon_anim !== '' ) {
				$linea_cats = ['arrows', 'basic', 'basic-elaboration', 'ecommerce', 'music', 'software', 'weather'];
				$category = str_replace('-', '_', str_replace('scape-linea-', '', $i_icon));
				$folder = '';
				foreach( $linea_cats as $cat ) {
					if ( strpos($category, $cat) !== false ) {
						$folder = $cat;
					}
				}

				$svg = str_replace('-', '_', $i_icon) . '.svg';

				if ( $category !== '' ) {
					if ( $icon_anim === 'icon_anim_viewport' || $icon_anim === 'icon_anim_viewport_hover' ) {
						$icon_el = '<div id="'.$unique_class.'" class="'.$icon_anim.'" data-file="'.WTBX_PLUGIN_URL . 'include/icon-fonts/linea/svg/' . $folder . '/' . $category . '.svg'.'"></div>';
						wtbx_vc_script_queue('vivus');
					}
				}

			} else {
				$icon_el = wtbx_vc_get_icon($icon);
			}
		}
	}
}



// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( in_array($bullet_type, array('icon', 'number', 'abbr')) && $bullet_color !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_vc_service .wtbx_vc_service_inner .wtbx_service_bullet_inner,'.$unique_class_css.'.wtbx_vc_service .wtbx_vc_service_inner .wtbx_service_bullet_inner i {' . wtbx_vc_color_styles_text($bullet_color) .'}';
}
if ( in_array($bullet_type, array('number', 'abbr')) && $b_typography_string !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_vc_service .wtbx_vc_service_inner .wtbx_service_bullet .wtbx_service_bullet_number,'.$unique_class_css.' .wtbx_service_bullet .wtbx_service_bullet_abbr {' . $b_typography_string .'}';
}
if ( in_array($bullet_cont, array('circle', 'rounded', 'square', 'octagon')) && $bullet_cont_color !== '' ) {
	$js_styles .= $unique_class_css.'.wtbx_vc_service .wtbx_service_bullet_inner {' . wtbx_vc_color_styles_bg($bullet_cont_color) .'}';
}
if ( in_array($style, array('border_left', 'border_right')) && $border_color !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_service_bullet {' . wtbx_vc_color_styles_bg($border_color) .'}';
}
if ( $title_color !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_service_title {' . wtbx_vc_color_styles_text($title_color) .'}';
}
if ( $descr_color !== '' ) {
	$js_styles .= $unique_class_css.' .wtbx_service_descr {' . wtbx_vc_color_styles_text($descr_color) .'}';
}

if ( $svg !== '' ) {
	$stroke = str_replace('color', 'stroke', explode('; ', wtbx_vc_color_styles_text($bullet_color))[0]);
	$js_styles .= $unique_class_css.' svg path { '.$stroke.' }';
}


$js_styles .= $h_typography_string !== '' ? $unique_class_css.' .wtbx_service_content .wtbx_service_title {' . $h_typography_string .'}' : '';

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner icon_anim_container">';

if ( $bullet_type === 'icon' && $icon !== '' ) {
	$output .= '<div class="wtbx_service_bullet"><div class="wtbx_service_bullet_inner wtbx_service_bullet_icon">'.$icon_el.'</div></div>';
} elseif ( $bullet_type === 'number' && $number !== '' ) {
	$output .= '<div class="wtbx_service_bullet"><div class="wtbx_service_bullet_inner wtbx_service_bullet_number">'.esc_html($number).'</div></div>';
} elseif ( $bullet_type === 'abbr' && $abbr !== '' ) {
	$output .= '<div class="wtbx_service_bullet"><div class="wtbx_service_bullet_inner wtbx_service_bullet_abbr">'.esc_html($abbr).'</div></div>';
} elseif ( $bullet_type === 'image' && $image !== '' ) {
	$output .= '<div class="wtbx_service_bullet"><div class="wtbx_service_bullet_inner wtbx_service_bullet_image wtbx_preloader_cont'.wtbx_vc_reveal_class($lazy).'">'.wtbx_image_smart_img($image, 'full', 'full', wtbx_get_alt_text($image), '', true, $lazy).'</div></div>';
}


$output .= '<div class="wtbx_service_content">';
$output .= $heading !== '' ? '<div class="wtbx_service_title wtbx_textholder wtbx-text">' . esc_html($heading) . '</div>' : '';
$output .= $content !== '' ? '<div class="wtbx_service_descr wtbx_textholder wtbx-text">' . wpb_js_remove_wpautop($content, true) . '</div>' : '';
$output .= '</div>';


$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.animIcons();}</script>";
}