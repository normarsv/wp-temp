<?php
$icon = $color = $size = $align = $el_class = $custom_color = $link = $background_style = $background_color = $i_font =
$type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons = $cont_size =
$icon_simplelineicons = $custom_bg_color = $display = $margin_left = $margin_right = $css_class = $icon_anim = $svg =
$icon_animation = $css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = $a_href = $a_title = $icon_el = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-icons' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_icon_el';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;

// construct link
$link = wtbx_vc_build_link($link);

// icon markup
if ( !empty($icon) ) {

	if ( $style === '' || $style === 'simple' ) {
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
						$icon_el = '<div id="'.$unique_class.'" class="wtbx_vc_icon '.$icon_anim.'" data-file="'.WTBX_PLUGIN_URL . 'include/icon-fonts/linea/svg/' . $folder . '/' . $category . '.svg'.'"></div>';
						wtbx_vc_script_queue('vivus');
					}
				}

			} else {
				$icon_el = wtbx_vc_get_icon($icon);
			}
		}
	} else {
		$icon_el = wtbx_vc_get_icon($icon);
	}
}


$margin  = wtbx_vc_scape_design($margin);

// icon size
$pattern = '/^(\d*(?:\.\d+)?)\s*(px|em)?$/';
$size_san = ' font-size:1em;';
if ( $size !== '' ) {
	$regex_width = preg_match( $pattern, $size, $matches_w );
	if ( isset( $matches_w[1] ) ) {
		$value = (float) $matches_w[1];
		$unit = isset( $matches_w[2] ) ? $matches_w[2] : 'px';
		$size_san = ' font-size:' . $value . $unit . ';';
	}
}

// container size
$border = 0;
if ( $cont_size !== '' ) {
	$regex_width = preg_match( $pattern, $cont_size, $cont_matches_w );
	if ( isset( $cont_matches_w[1] ) ) {
		$cont_value = (float) $cont_matches_w[1];
		$cont_unit = isset( $cont_matches_w[2] ) ? $cont_matches_w[2] : 'px';
	}
	$cont_size = ' line-height: ' . $cont_value . $cont_unit . ';';
	if ( $style !== '' ) {
		$cont_size .= ' width: ' . $cont_value . $cont_unit . '; height: ' . $cont_value . $cont_unit . ';';
	}
} else {
	$cont_size = '';
}

// position styles
$css_class .= $shortcode_class[] = $display;
if ( $display === 'wtbx_display_block' && $align !== '' ) $shortcode_class[] = $align;

// adjust background gradient direction
if ( $style === 'simple' && ( $simple_style === 'rhombus' || $simple_style === 'rhombus_sl_rounded' || $simple_style === 'rhombus_rounded' ) ) {
	if ( isset(json_decode($bg_color, true)['dir']) ) {
		$bg_grad_dir = json_decode($bg_color, true)['dir'];
		$bg_grad_new_dir = wtbx_vc_get_new_gradient_dir($bg_grad_dir);

		$bg_color = json_decode($bg_color, true);
		$bg_color['dir'] = $bg_grad_new_dir;
		$bg_color = json_encode($bg_color);
	}
}

// adjust border gradient direction
if ( $style === 'simple' && ( $simple_style === 'rhombus' || $simple_style === 'rhombus_sl_rounded' || $simple_style === 'rhombus_rounded' ) ) {
	if ( isset(json_decode($border_color, true)['dir']) ) {
		$border_grad_dir = json_decode($border_color, true)['dir'];
		$border_grad_new_dir = wtbx_vc_get_new_gradient_dir($border_grad_dir);

		$border_color = json_decode($border_color, true);
		$border_color['dir'] = $border_grad_new_dir;
		$border_color = json_encode($border_color);
	}
}

// icon container style
$shortcode_class[] = 'wtbx_icon_' . $style;
$style_class = '';
if ( $style === 'simple' ) $style_class = 'wtbx_style_' . $simple_style;
$shortcode_class[] = $style_class;

// STYLES
$additional_icon = '';
$custom_icon_color = '';
$inner_style = '';
$icon_style = '';
if ( $style === 'simple' ) {
	$inner_style = wtbx_vc_color_styles_bg($bg_color) . wtbx_vc_color_styles_shadow($border_color, '0 0 0 1px', '1');
	$icon_style = wtbx_vc_color_styles_text($icon_color);
} elseif ( $style === 'predefined_1' ) {
	$additional_icon = wtbx_vc_get_icon($icon, 'double_icon');
	$inner_style = wtbx_vc_color_styles_bg($accent_color);
	$icon_style = ' color: #ffffff';
} elseif ( $style === 'predefined_2' ) {
	$inner_style = wtbx_vc_color_styles_border($accent_color);
	$icon_style = wtbx_vc_color_styles_text($accent_color);
} elseif ( $style === 'predefined_3' ) {
	$icon_style = wtbx_vc_color_styles_bg($accent_color);
} elseif ( $style === 'predefined_5' ) {
	$icon_style = wtbx_vc_color_styles_text($accent_color);
} else {
	$icon_style = wtbx_vc_color_styles_text($icon_color);
}

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$margin !== '' ? $js_styles .= $unique_class_css.' {' . $margin . '}' : null;
$js_styles .= $unique_class_css.' .wtbx_vc_icon_wrapper {' . $size_san . $cont_size . $inner_style .'}';
$js_styles .= $style === 'predefined_2' ? $unique_class_css.' .wtbx_vc_icon_wrapper:before {' . wtbx_vc_color_styles_bg($accent_color) . '}' : '';
$js_styles .= $style === 'predefined_3' ? $unique_class_css.' .wtbx_vc_icon_wrapper:before {' . wtbx_vc_color_styles_border($accent_color) . '}' : '';
$js_styles .= $style === 'predefined_4' ? $unique_class_css.' .wtbx_vc_icon_wrapper:before, '.$unique_class_css.' .wtbx_vc_icon_wrapper:after {' . wtbx_vc_color_styles_bg($accent_color) . '}' : '';
$js_styles .= $unique_class_css.' .wtbx_vc_icon {'. $icon_style .'}';

if ( $svg !== '' ) {
	$stroke = str_replace('color', 'stroke', explode('; ', wtbx_vc_color_styles_text($icon_color))[0]);
	$js_styles .= $unique_class_css.' svg path { '.$stroke.' }';
	$js_styles .= $unique_class_css.' .wtbx_vc_icon_wrapper .wtbx_vc_icon,'.$unique_class_css.' svg { width: '.$value . $unit.'; height: '.$value . $unit.'; }';
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner"'.($tooltip !== '' ? ' data-tooltip="' . esc_html($tooltip) . '"' : '').'>';
$output .= '<div class="wtbx_vc_icon_wrapper' . ($i_font === 'linea' && $icon_anim !== '' ? ' icon_anim_container' : '') . '">';
$output .= $link['open'];

$output .= $icon_el;
$output .= $additional_icon;

$output .= $link['close'];
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.animIcons();}</script>";
}