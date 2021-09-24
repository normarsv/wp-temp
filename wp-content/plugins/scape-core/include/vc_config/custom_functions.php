<?php

/*
 * Returns an option value
 */
function wtbx_vc_option($var = '', $def = '') {
	global $wtbx_scape;

	if (empty($wtbx_scape)) {
		if ( is_multisite() ) {
			$wtbx_scape = get_blog_option( get_current_blog_id(), 'wtbx_scape' );
		} else {
			$wtbx_scape = get_option('wtbx_scape');
		}
	}

	if ( (isset($wtbx_scape[$var]) && $wtbx_scape[$var] === '0') || !empty($wtbx_scape[$var]) ) {
		return $wtbx_scape[$var];
	} else {
        return $def;
	}
}




function wtbx_vc_option_sub($var = '', $sub = '', $def = '') {
	global $wtbx_scape;

	if (empty($wtbx_scape)) {
		$wtbx_scape = get_option('wtbx_scape');
		if ( is_multisite() ) {
			$wtbx_scape = get_blog_option( get_current_blog_id(), 'wtbx_scape' );
		} else {
			$wtbx_scape = get_option('wtbx_scape');
		}
	}

	if ($sub) {
		if ( (isset($wtbx_scape[$var][$sub]) && $wtbx_scape[$var][$sub] === '0') || !empty($wtbx_scape[$var][$sub]) ) {
			return $wtbx_scape[$var][$sub];
		} else {
			return $def;
		}
	} else {
		if ( (isset($wtbx_scape[$var][$sub]) && $wtbx_scape[$var][$sub] === '0') || !empty($wtbx_scape[$var]) ) {
			return $wtbx_scape[$var];
		} else {
			return $def;
		}
	}
}


/*
 * Returns array of default icon fonts
 */
function wtbx_vc_available_icon_fonts() {
	$icon_fonts = ['fontawesome', 'simplelineicons', 'linea-arrows', 'linea-basic', 'linea-basic-elaboration', 'linea-ecommerce', 'linea-music', 'linea-software', 'linea-weather', 'scape-basic', 'scape-controls', 'scape-devices', 'scape-media', 'scape-tech', 'scape-business', 'scape-entertainment', 'scape-objects', 'scape-brands', 'scape-people', 'scape-occasions'];
	return $icon_fonts;
}



/*
 * Returns an icon on the frontend and enqueues the font stylesheet
 */
function wtbx_vc_get_icon($icon_obj, $class = '') {

	if ( !empty($icon_obj) ) {
		$icon_obj = (array) json_decode($icon_obj);
	}

	if ( is_array($icon_obj) ) {

		$font = $icon_obj['font'];
		$icon = $icon_obj['icon'];
		$class !== '' ? $class = ' ' . $class : null;

		// if linea font
		if ( $font === 'linea' ) {
			$cat = '';
			require_once( WTBX_PLUGIN_PATH . 'include/icon-fonts/charmap.php' );
			$charmap = wtbx_vc_icon_font_linea();

			foreach( $charmap['icons'] as $category => $items ) {
				foreach ( $items as $id => $key ) {
					if ( array_key_exists($icon, $key) ) {
						$cat = $category;
					}
				}
			}

			if ( $cat !== '' ) {
				$font = 'linea-' . strtolower(str_replace(' ', '-', $cat));
			}
		}

		wtbx_vc_enqueue_icon_font($font);

		return '<i class="'.$icon.' wtbx_vc_icon'.$class.'"></i>';

	} else {
		return '';
	}

}



/*
 * Enqueues the icon font stylesheet
 */
function wtbx_vc_enqueue_icon_font($font) {
	if ( in_array($font, wtbx_vc_available_icon_fonts()) ) {
		// if it's on of default icon fonts - generate path to stylesheet
		if ( strpos($font, 'linea') !== false ) {
			$font_path = WTBX_PLUGIN_URL . 'include/icon-fonts/linea/font/' . str_replace('linea-', '', $font) . '/' . $font . '.css';
		} else {
			$font_path = WTBX_PLUGIN_URL . 'include/icon-fonts/' . $font . '/' . $font . '.min.css';
		}
		wp_enqueue_style('wtbx_' . $font , $font_path, array(), SCAPE_VERSION, 'all' );
	} else {
		// else check if such custom font exists and generate path to stylesheet
		$upload_dir = wp_upload_dir();
		$upload_dir = $upload_dir['baseurl'];
		$font_path = trailingslashit($upload_dir) . '/wtbx_icon_fonts/' . $font . '/style.css';
		wp_enqueue_style('wtbx_' . $font , $font_path, array(), SCAPE_VERSION, 'all' );
	}
}



/*
* Lists all fonts needed to be printed in admin area
*/
function wtbx_admin_fonts($key = '', $value = '') {
	global $wtbx_admin_fonts;
	if ( !empty($key) && !empty($value) ) {
		$wtbx_admin_fonts[$key] = $value;
	}
	return $wtbx_admin_fonts;
}



/*
 * Prints fonts in admin area
 */
function wtbx_print_admin_fonts() {
	$fonts = wtbx_admin_fonts();

	if ( $fonts ) {
		foreach ( $fonts as $id => $code ) {
			print_r($code);
		}
	}
}



/*
 * Prints fonts in gutenberg edit mode
 */
function wtbx_gutenberg_fonts() {
	global $current_screen;
	$current_screen = get_current_screen();
	if ( ( method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor() )
		|| ( function_exists('is_gutenberg_page') && is_gutenberg_page() ) ) {
		wtbx_vc_collect_custom_fonts(wtbx_vc_get_font_weight_style(), false);
		wtbx_print_admin_fonts();
	}
}



/*
 * Collects all the custom fonts for loading on the backend
 */
function wtbx_vc_collect_custom_fonts($object, $append) {
	$has_typekit = false;

	if ( !empty($object) ) {
		foreach ( (array) $object as $font_id => $font_details ) {
			if ( $font_details['type'] && isset($font_details['family']) && isset($font_details['name']) ) {
				$font_type = $font_details['type'];
				$upload_dir = wp_upload_dir();

				if ( $font_type === 'custom' ) {
					$font_link = $upload_dir['baseurl'] . '/wtbx_custom_fonts/' . $font_details['name'] . '/stylesheet.css';
				} elseif ( $font_type === 'fontsquirrel' ) {
					$font_link = $upload_dir['baseurl'] . '/wtbx_custom_fonts/' . $font_details['name'] . '/' . $font_details['family'] . '.css';
				} elseif ( $font_type === 'google' ) {
					$font_link ='//fonts.googleapis.com/css?family=' . str_replace(' ', '+', $font_details['name']) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
				} elseif ( $font_type === 'typekit' ) {
					$has_typekit = 'typekit';
				}

				if ( $font_type !== 'typekit' && !empty($font_link) ) {
					if ( $append ){
						$print_fonts  = '';
						$print_fonts .= '<script>jQuery(document).ready(function($) {';
						$print_fonts .= '$(\'<link href="'.esc_url($font_link).'" rel="stylesheet">\').appendTo("head");';
						$print_fonts .= '});</script>';
					} else {
						$print_fonts = '<link href="'.esc_url($font_link).'" rel="stylesheet">';
					}

					wtbx_admin_fonts($font_id, $print_fonts);
				}
			}
		}

		if ( $has_typekit ) {
			if ( isset(wtbx_vc_get_theme_fonts()['typekit_kitid']) ) {
				$typekit_kitid = wtbx_vc_get_theme_fonts()['typekit_kitid'];
				wtbx_admin_fonts($has_typekit, '<script src="https://use.typekit.net/'.esc_attr($typekit_kitid).'.js"></script><script>try{Typekit.load({ async: true });}catch(e){}</script>');
			}
		}
	}

}



/*
 * Returns a link
 */
function wtbx_vc_build_link($link, $class = '') {
	$link = vc_build_link( $link );
	if ( !empty($link['url']) && strlen( $link['url'] ) > 0 ) {
		$url    = array();
		$href   = !empty($link['url']) ? $link['url'] : '';
		$title  = !empty($link['title']) ? ' title="' . $link['title'] . '"' : '';
		$target = !empty($link['target']) ? $link['target'] : '_self';
		$rel    = !empty($link['rel']) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '';
		$class  = $class !== '' ? ' class="' . $class . '"' : '';

		$url['open'] = '<a'.$class.' href="'.$href.'"'.$title.' target="'.$target.'"' . $rel . '>';
		$url['close'] = '</a>';

	} else {
		$url['open'] = '';
		$url['close'] = '';
	}

	return $url;
}



/*
 * Returns string with animation classes
 */
function wtbx_vc_el_animation($animation, $duration, $delay) {
	$classes = array();

	if ( $animation !== '' ) {
		$classes[] = $animation;
		$classes[] = $duration !== '' ? $duration : '';
		$classes[] = $delay !== '' ? $delay : '';
	}

	$classes = implode(' ', $classes);
	return $classes;
}



/*
 * Returns array with default palette colors
 */
function wtbx_vc_get_colors() {
	$palette = [];
	$palette['Main accent color']       = wtbx_vc_option('color-main-accent');
//	$palette['Dark background']         = wtbx_vc_option('color-main-bg-dark');
	$palette['Dark color']              = wtbx_vc_option('color-main-text-dark');
	$palette['Light background']        = wtbx_vc_option('color-main-bg-light');
	$palette['Default text color']      = wtbx_vc_option('color-main-text-color');
//	$palette['Medium-dark text color']  = wtbx_vc_option('color-main-text-medium');
	$palette['Light text color']        = wtbx_vc_option('color-main-text-light');
	$palette['Border color']            = wtbx_vc_option('color-main-border-color');
	$palette['Overlay color']           = wtbx_vc_option_sub('color-main-overlay-color', 'rgba') !== '' ? wtbx_vc_option_sub('color-main-overlay-color', 'rgba') : wtbx_vc_option('color-main-overlay-color');
//	$palette['Preloader color']         = wtbx_vc_option('color-preloader-elements');

	return $palette;
}



/*
 * Returns an array of gradient directions
 */
function wtbx_vc_gradient_directions($associative = false) {
	if ( $associative ) {
		return array(
			'to top'    => '&uarr;',
			'45deg'     => '&#8599;',
			'to right'  => '&rarr;',
			'135deg'    => '&#8600;',
			'to bottom' => '&darr;',
			'225deg'    => '&#8601;',
			'to left'   => '&larr;',
			'315deg'    => '&#8598;',
			'ellipse at center' => '&#10752'
		);
	} else {
		return array('to top','45deg','to right','135deg','to bottom','225deg','to left','315deg','ellipse at center');
	}
}



/*
 * Returns new gradient direction
 */
function wtbx_vc_get_new_gradient_dir($direction) {

	if ( $direction === '' || $direction === 'ellipse at center' ) {
		return $direction;
	}

	$directions_array = wtbx_vc_gradient_directions();
	$dir_pos = array_search($direction, $directions_array);

	if ( $dir_pos === 0 ) {
		$new_direction = $directions_array[7];
	} else {
		$new_direction = $directions_array[$dir_pos-1];
	}

	return $new_direction;

}



/*
 * Returns a color or a palette color if found in the palette
 */
function wtbx_vc_color_from_palette($id, $color) {
	$palette_array_def = wtbx_vc_get_colors();
	$palette_array_add = wtbx_vc_option('color-palette-solid');
	if ( !empty($palette_array_add) ) {
		$palette_array = array_merge($palette_array_def, $palette_array_add);
	} else {
		$palette_array = $palette_array_def;
	}

	if ( array_key_exists($id, $palette_array) ) {
		return $palette_array[$id];
	} else {
		return $color;
	}
}



/*
 * Returns only color string from solid colorpicker
 */
function wtbx_vc_get_color($object) {
	$color = '';
	if ( $object !== '' ) {
		$object = json_decode($object, true);
		if ( !empty($object) ) {
			if ( array_key_exists('id', $object) && array_key_exists('color', $object) && $object['id'] !== '' && $object['color'] !== '' ) {
				$color = wtbx_vc_color_from_palette($object['id'], $object['color']);
			}
		}
	}
	return $color;
};



/*
 * Returns a string with text color styles
 */
function wtbx_vc_color_styles_text($object) {
	$color_string = '';
	if ( $object !== '' ) {
		$object = json_decode($object, true);
		if ( !empty($object) ) {
			if ( array_key_exists('id', $object) && array_key_exists('color', $object) && $object['id'] !== '' && $object['color'] !== '' ) {
				// if it's a solid color from solid colorpicker
				$color_string = 'color:' . wtbx_vc_color_from_palette($object['id'], $object['color']) .';';
			} elseif ( array_key_exists('solid', $object) && $object['solid']['color'] !== '' ) {
				// if it's a solid color
				$color_string = 'color:' . wtbx_vc_color_from_palette($object['solid']['id'], $object['solid']['color']) .';';
			} elseif ( ( array_key_exists('from', $object) && $object['from']['color'] !== '' ) || ( array_key_exists('to', $object) && $object['to']['color'] !== '' ) ) {
				// if it's a gradient
				$color_from = wtbx_vc_color_from_palette($object['from']['id'], $object['from']['color']);
				$color_to   = wtbx_vc_color_from_palette($object['to']['id'], $object['to']['color']);

				$dir    = $object['dir'];
				$from   = $color_from !== '' ? $color_from : 'transparent';
				$to     = $color_to !== '' ? $color_to : 'transparent';
				$type   = $dir === 'ellipse at center' ? 'radial-gradient' : 'linear-gradient';
				$color_string = 'color: '.$from.'; background: '.$type.'('.$dir.', '.$from.', '.$to.'); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-fill-color: transparent;';
			}
		}
	}
	return $color_string;
};



/*
 * Returns a string with background color styles
 */
function wtbx_vc_color_styles_bg($object) {
	$color_string = '';
	if ( $object !== '' ) {
		$object = json_decode($object, true);
		if ( !empty($object) ) {
			if ( array_key_exists('id', $object) && array_key_exists('color', $object) && $object['id'] !== '' && $object['color'] !== '' ) {
				// if it's a solid color from solid colorpicker
				$color_string = 'background-color:' . wtbx_vc_color_from_palette($object['id'], $object['color']) .';';
			} elseif ( array_key_exists('solid', $object) && $object['solid']['color'] !== '' ) {
				// if it's a solid color
				$color_string = 'background-color:' . wtbx_vc_color_from_palette($object['solid']['id'], $object['solid']['color']) .';';
			} elseif ( ( array_key_exists('from', $object) && $object['from']['color'] !== '' ) || ( array_key_exists('to', $object) && $object['to']['color'] !== '' ) ) {
				// if it's a gradient
				$color_from = wtbx_vc_color_from_palette($object['from']['id'], $object['from']['color']);
				$color_to   = wtbx_vc_color_from_palette($object['to']['id'], $object['to']['color']);

				$dir    = $object['dir'];
				$from   = $color_from !== '' ? $color_from : 'transparent';
				$to     = $color_to !== '' ? $color_to : 'transparent';
				$type   = $dir === 'ellipse at center' ? 'radial-gradient' : 'linear-gradient';
				$color_string = 'background-color: '.$from.'; background: '.$type.'('.$dir.', '.$from.', '.$to.');';
			}
		}
	}
	return $color_string;
};



/*
 * Returns a string with background color styles
 */
function wtbx_vc_color_styles_border($object, $property = 'border-color:') {
	$color_string = '';
	if ( $object !== '' ) {
		$object = json_decode($object, true);
		if ( !empty($object) ) {
			if ( array_key_exists('id', $object) && array_key_exists('color', $object) && $object['id'] !== '' && $object['color'] !== '' ) {
				// if it's a solid color from solid colorpicker
				$color_string = $property . wtbx_vc_color_from_palette($object['id'], $object['color']) .';';
			} elseif ( array_key_exists('solid', $object) && $object['solid']['color'] !== '' ) {
				// if it's a solid color
				$color_string = $property . wtbx_vc_color_from_palette($object['solid']['id'], $object['solid']['color']) .';';
			} elseif ( ( array_key_exists('from', $object) && $object['from']['color'] !== '' ) || ( array_key_exists('to', $object) && $object['to']['color'] !== '' ) ) {
				// if it's a gradient
				$color_from = wtbx_vc_color_from_palette($object['from']['id'], $object['from']['color']);
				$color_to   = wtbx_vc_color_from_palette($object['to']['id'], $object['to']['color']);

				$dir    = $object['dir'];
				$from   = $color_from !== '' ? $color_from : 'transparent';
				$to     = $color_to !== '' ? $color_to : 'transparent';
				$type   = $dir === 'ellipse at center' ? 'radial-gradient' : 'linear-gradient';
				$color_string =
				  ' border-color: '.$from.';'
				. ' -webkit-border-image: -webkit-'.$type.'('.$dir.', '.$from.' 0%, '.$to.' 100%);'
				. ' -moz-border-image: -moz-'.$type.'('.$dir.', '.$from.' 0%, '.$to.' 100%);'
				. ' -o-border-image: -o-'.$type.'('.$dir.', '.$from.' 0%, '.$to.' 100%);'
				. ' border-image: '.$type.'('.$dir.', '.$from.' 0%, '.$to.' 100%);'
				. ' border-image-slice: 1;';
			} elseif ( array_key_exists('id', $object) && array_key_exists('color', $object) && array_key_exists('dir', $object) && $object['dir'] !== '' && $object['from']['color'] !== '' && $object['to']['color'] !== '' )  {
				// if it's a color from solid colorpicker
				$color_string = $property . wtbx_vc_color_from_palette($object['id'], $object['color']) .';';
			}
		}
	}
	return $color_string;
};



/*
 * Returns a string with shadow color styles
 */
function wtbx_vc_color_styles_shadow($object, $shadow = '0 8px 25px -5px', $opacity = '0.6') {
	$color = '';
	if ( $object !== '' ) {
		$object = json_decode($object, true);
		if ( !empty($object) ) {
			if ( array_key_exists('id', $object) && array_key_exists('color', $object) && $object['id'] !== '' && $object['color'] !== '' ) {
				// if it's a solid color from solid colorpicker
				$color = $object['color'];
			} elseif ( array_key_exists('solid', $object) && $object['solid']['color'] !== '' ) {
				// if it's a solid color
				$color = $object['solid']['color'];
			} elseif ( ( array_key_exists('from', $object) && $object['from']['color'] !== '' ) || ( array_key_exists('to', $object) && $object['to']['color'] !== '' ) ) {
				// if it's a gradient
				$color = $object['to']['color'] !== '' ? $object['to']['color'] : $object['from']['color'];
			}

			if ( $color !== '' ) {
				if ( strpos($color, '#') === 0 ) {
					$array = wtbx_hex2rgba_array($color, $opacity);
				} else {
					$array = wtbx_rgba2array($color);
					$array[3] = $opacity;
				}
				$color = 'box-shadow:' . $shadow .' rgba(' . implode(',', $array) . ')';
			}
		}
	}
	return $color;
};



/*
 * Returns a string with element margin/padding/border
 */
function wtbx_vc_scape_design( $object ) {
	$output = '';
	$object = !empty($object) ? json_decode($object, true) : '';
	if ( $object !== '' ) {
		$prop = $object['property'];
		$suffix = isset($object['suffix']) ? '-' . $object['suffix'] : '';
		foreach ( $object as $variant => $value ) {
			if ( $variant !== 'property' && $variant !== 'suffix' && $value !== '' ) {
				$output .= ' ' . $prop . '-' . $variant . $suffix . ': ' . $value . 'px;';
			}
		}
	}
	return $output;
}



/*
 * Returns a string with element margin/padding/border (responsive)
 */
function wtbx_vc_scape_design_responsive( $margin = '', $padding = '', $border = '', $selector = '' ) {
	$output = $screens = '';

	if ( $margin !== '' || $padding !== '' || $border !== '' ) {
		$array = [$margin, $padding, $border];
		$screens = array();

		$sizes = array(
			'tablet_landscape'  => '1024',
			'tablet_portrait'   => '979',
			'mobile_landscape'  => '767',
			'mobile_portrait'   => '479'
		);

		foreach ( $array as $object ) {
			$object = !empty($object) ? json_decode($object, true) : '';

			if ( $object !== '' ) {
				$prop   = $object['property'];
				$suffix = isset($object['suffix']) ? '-' . $object['suffix'] : '';

				foreach( $object as $key => $variants ) {
					if ( $key !== 'property' && $key !== 'suffix' ) {
						foreach( $variants as $variant => $value ) {
							if ( $value !== '' ) {
								$screens[$key][$prop]['values'][$variant] = $value;
							}
						}
						if ( !empty($screens[$key][$prop]['values'] ) ) {
							$screens[$key][$prop]['suffix'] = $suffix;
							$screens[$key][$prop]['property'] = $prop;
						}
					}
				}
			}
		}

		$o = '';

		foreach ( $screens as $screen => $properties ) {
			if ( $screen !== 'desktop' ) {
				$output .= ' @media only screen and (max-width:'.$sizes[$screen].'px) {';
			}

			$output .= ' ' . $selector . ' {';

			foreach ( $properties as $prop_key => $prop_value ) {
				if ( $prop_key !== 'suffix' && $prop_key !== 'property' ) {

					foreach ( $prop_value['values'] as $variant => $variant_value ) {
						$output .= ' ' . $prop_value['property'] . '-' . $variant . $prop_value['suffix'] . ': ' . $variant_value . 'px;';
					}
				}
			}

			$output .= '}';

			if ( $screen !== 'desktop' ) {
				$output .= '}';
			}
		}

	}

	return $output;

};



/*
 * Returns a string with element design
 */
function wtbx_vc_scape_design_styles($object, $margin_selector, $border_selector, $padding_selector, $offset_selector, $zindex_selector) {
	$output = '';

	if ( !empty($object) ) {
		$object     = json_decode($object, true);
		$sizes      = wtbx_vc_scape_screen_sizes();
		$selectors  = array_unique([$margin_selector, $border_selector, $padding_selector, $offset_selector, $zindex_selector]);

		$pattern    = '/^(\d*(?:\.\d+)?)\s*(px|\%)?$/';

		if ( $object !== null ){
			foreach ( array_reverse($object) as $screen => $properties ) {
				if ( $screen !== 'desktop' ) {
					$output .= ' @media only screen and (max-width:'.$sizes[$screen].'px) {';
				}

				foreach ( $selectors as $selector ) {
					foreach ( $properties as $prop_key => $prop_value ) {
						$property = '';

						if ( $selector === $margin_selector && strpos($prop_key, 'margin') !== false ) {
							$regexr = preg_match( $pattern, $prop_value, $matches );
							$value = isset( $matches[1] ) ? (float) $matches[1] : 0;
							$unit = isset( $matches[2] ) ? $matches[2] : 'px';
							$prop_value = $value . $unit;
							$property .= ' ' . $prop_key . ': ' . $prop_value . ' !important;';
						} elseif ( $selector === $border_selector && strpos($prop_key, 'border') !== false ) {
							$property .= ' ' . ( $prop_key === 'border-style' || strpos($prop_key, 'radius') !== false ? $prop_key : $prop_key . '-width' ) . ': ' . $prop_value . ( $prop_key === 'border-style' ? '' : 'px' ) . ' !important;';
						} elseif ( $selector === $padding_selector && strpos($prop_key, 'padding') !== false ) {
							$regexr = preg_match( $pattern, $prop_value, $matches );
							$value = isset( $matches[1] ) ? (float) $matches[1] : 0;
							$unit = isset( $matches[2] ) ? $matches[2] : 'px';
							$prop_value = $value . $unit;
							$property .= ' ' . $prop_key . ': ' . $prop_value . ' !important;';
						} elseif ( $selector === $zindex_selector && strpos($prop_key, 'z-index') !== false ) {
							$property .= ' ' . $prop_key . ': ' . $prop_value . ' !important;';
						} elseif ( $selector === $offset_selector && strpos($prop_key, 'shift') !== false ) {
							if ( $prop_key === 'shift-vertical' ) {
								if ( intval($prop_value) < 0 ) {
									$property .= ' top: auto;';
									$property .= ' margin-top: ' . $prop_value . 'px;';
								} else {
									$property .= ' margin-top: 0;';
									$property .= ' top: ' . $prop_value . 'px;';
									$property .= ' position: relative;';
								}
							} elseif ( $prop_key === 'shift-horizontal' ) {
								if ( intval($prop_value) < 0 ) {
									$property .= ' left: auto;';
									$property .= ' margin-left: ' . $prop_value . 'px;';
								} else {
									$property .= ' margin-left: 0;';
									$property .= ' left: ' . $prop_value . 'px;';
									$property .= ' position: relative;';
								}
							}
						}

						if ( $property ) {
							$output .= ' ' . $selector . ' {' . $property . '}';
						}
					}
				}

				if ( $screen !== 'desktop' ) {
					$output .= '}';
				}
			}
		}

	}

	return $output;
}



/*
 * Returns array with screen size labels and breakpoints
 */
function wtbx_vc_scape_screen_sizes() {
	return array(
		'screen'            => '',
		'tablet_landscape'  => '1024',
		'tablet_portrait'   => '991',
		'mobile_landscape'  => '767',
		'mobile_portrait'   => '479'
	);
}



///*
// * Returns an array of design param properties
// */
//function wtbx_vc_design_param_properties() {
//	array(
//		'desktop'           => 'device-screen',
//		'tablet_landscape'  => 'device-tablet2',
//		'tablet_portrait'   => 'device-tablet',
//		'mobile_landscape'  => 'device-mobile2',
//		'mobile_portrait'   => 'device-mobile'
//	);
//}



/*
 * Returns shortcode element animation class
 */
function wtbx_vc_appearance_animation( $animation = '', $easing = '', $duration = '', $delay = '', $disable = '' ) {
	$output     = '';
	$classes    = array();
	if ( !empty($animation) ) {
		$classes[] = 'wtbx_appearance_animation';
		$classes[] = $animation;
		!empty($duration) ? $classes[] = $duration : null;
		!empty($delay) ? $classes[] = $delay : null;
		!empty($easing) ? $classes[] = $easing : null;
		!empty($disable) ? $classes[] = 'disable_anim_' . $disable : null;
		$output = implode(' ', $classes);
	}
	return $output;
}



/*
 * Returns shortcode lazy image reveal class
 */
function wtbx_vc_reveal_class($lazy) {
	$reveal_class = '';
	if ( $lazy === '1' ) {
		$reveal_class = ' wtbx-element-reveal wtbx-reveal-cont';
	} elseif ( $lazy === '' ) {
		if ( wtbx_vc_option('site-smartimage') === '1' ) {
			$reveal_class = ' wtbx-element-reveal wtbx-reveal-cont';
		}
	}
	return $reveal_class;
}



/*
 * Returns image preloader
 */
function wtbx_vc_preloader( $lazy = '', $preloader = '' ) {
	$output     = '';
	$display    = false;
	$loader     = false;

	if ( $lazy === '1' ) {
		$display = true;
	} elseif ( $lazy === '' && wtbx_vc_option('site-smartimage') === '1' ) {
		$display = true;
	}

	if ( $preloader === '1' ) {
		$loader = true;
	} elseif ( $preloader === '' && wtbx_vc_option('site-preloaders') === '1' ) {
		$loader = true;
	}

	if ($display === true && $loader === true) {
		ob_start();
		include(locate_template('templates/components/preloader.php'));
		$output = ob_get_clean();
	}
	return $output;
}



/*
 * Returns lighbox navigation
 */
function wtbx_vc_lightbox_nav() {
	ob_start();
	include(locate_template('templates/components/lightbox-nav.php'));
	$output = ob_get_clean();
	return $output;
}



/*
 * Returns array of categories
 */
function wtbx_vc_get_terms( $taxonomy = 'category', $args = array() ) {
	$args['taxonomy'] = $taxonomy;
	$args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );
	$taxonomy = $args['taxonomy'];
	$terms = (array) get_terms( $taxonomy, $args );

	$term_options = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$term_options[ $term->name.'</br>' ] = $term->term_id;
		}
	}

	return $term_options;
}



/*
 * Returns array of available menus
 */
function wtbx_get_menus() {
	$menus = get_terms( 'nav_menu' );
	$menus = array_combine( wp_list_pluck( $menus, 'term_id' ), wp_list_pluck( $menus, 'name' ) );

	$array      = array();
	$array['']  = esc_html__('Inherit', 'core-extension');
	$array      = $array + $menus;

	return $array;
}



/*
 * Check if current page is post edit page
 */
if ( ! function_exists( 'is_edit_page' ) ) {
	function is_edit_page($new_edit = null){
		global $pagenow;

		if ( !is_admin() ) return false;

		if($new_edit == "edit")
			return in_array( $pagenow, array( 'post.php',  ) );
		elseif($new_edit == "new") //check for new post page
			return in_array( $pagenow, array( 'post-new.php' ) );
		else //check for either new or edit
			return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
	}
}



/*
 * Returns array of available grid animations
 */
function wtbx_vc_grid_animations() {
	$opts = array(
//		esc_html__( 'No animation', 'core-extension' )      => 'none',
		esc_html__( 'Fade in', 'core-extension' )           => 'fadein',
	    esc_html__( 'Scale up', 'core-extension' )          => 'scaleup',
		esc_html__( 'Slide up', 'core-extension' )          => 'slideup',
		esc_html__( '3D Slide up', 'core-extension' )       => 'slideup3d',
		esc_html__( '3D Rotate top', 'core-extension' )     => 'rotatetop',
		esc_html__( '3D Rotate bottom', 'core-extension' )  => 'rotatebottom',
		esc_html__( '3D Rotate left', 'core-extension' )    => 'rotateleft',
		esc_html__( '3D Rotate right', 'core-extension' )   => 'rotateright'
	);
	return $opts;
}



/*
 * Returns array of portfolio details fields
 */
function wtbx_grid_meta($links) {
	$output = array();

	if ($links) {
		$output = array(
			'' => esc_html__('Empty', 'core-extension'),
			'title' => esc_html__('Title', 'core-extension'),
			'title_link' => esc_html__('Title with link', 'core-extension'),
			'categories' => esc_html__('Categories', 'core-extension'),
			'categories_link' => esc_html__('Categories with links', 'core-extension')
		);
	} else {
		$output = array(
			'' => esc_html__('Empty', 'core-extension'),
			'title' => esc_html__('Title', 'core-extension'),
			'categories' => esc_html__('Categories', 'core-extension'),
		);
	}

	$details = get_option('wtbx_scape');
	if ( !empty($details) && isset($details['portfolio-item-details']) ) {
		$details = $details['portfolio-item-details'];
		if ( is_array($details) && !empty($details) ) {
			foreach ( $details as $id => $label ) {
				if ( isset($label) ) {
					$output[$id] = $label;
				}
			}
		}
	}

	return $output;
}



/*
 * Returns array of social networks for Theme Options
 */
function wtbx_vc_social_networks_options() {
	$networks = wtbx_vc_social_networks();
	$output = array();

	$output[] = array(
		'id'       => 'social_open_blank',
		'type'     => 'switch',
		'title'    => esc_html__( 'Open social links in a new tab', 'core-extension' ),
		'default'  => false,
	);

	foreach ( $networks as $key => $value ) {
		if ( isset($value[0]) ) {
			$output[] = array(
				'id'       => 'social_'.$key,
				'type'     => 'text',
				'title'    => $value[0],
				'subtitle' => sprintf( esc_html__( 'Enter your %s URL.', 'core-extension' ), $value[0] )
			);
		}
	}

	return $output;
}



/*
 * Returns array of social networks for VC parameter
 */
function wtbx_vc_social_networks_param() {
	$networks = wtbx_vc_social_networks();
	$output = array();

	foreach ( $networks as $key => $value ) {
		$output[$value[0].'</br>'] = $key;
	}

	return $output;
}



/*
 * Returns array of social networks with labels and icons
 */
function wtbx_vc_social_networks() {
	return array(
		'behance'       => ['Behance', 'scape-ui-behance'],
		'codepen'       => ['Codepen', 'scape-ui-codepen'],
		'dribbble'      => ['Dribbble', 'scape-ui-dribbble'],
		'facebook'      => ['Facebook', 'scape-ui-facebook'],
		'flickr'        => ['Flickr', 'scape-ui-flickr'],
		'foursquare'    => ['Foursquare', 'scape-ui-foursquare'],
		'github'        => ['GitHub', 'scape-ui-github'],
		'google-plus'   => ['Google+', 'scape-ui-google-plus'],
		'instagram'     => ['Instagram', 'scape-ui-instagram'],
		'linkedin'      => ['LinkedIn', 'scape-ui-linkedin'],
		'medium'        => ['Medium', 'scape-ui-medium'],
		'pinterest'     => ['Pinterest', 'scape-ui-pinterest'],
		'rss'           => ['RSS', 'scape-ui-rss'],
		'skype'         => ['Skype', 'scape-ui-skype'],
		'snapchat'      => ['Snapchat', 'scape-ui-snapchat'],
		'soundcloud'    => ['Soundcloud', 'scape-ui-soundcloud'],
		'telegram'      => ['Telegram', 'scape-ui-telegram'],
		'tiktok'        => ['TikTok', 'scape-ui-tiktok'],
		'tumblr'        => ['Tumblr', 'scape-ui-tumblr'],
		'twitter'       => ['Twitter', 'scape-ui-twitter'],
		'vimeo'         => ['Vimeo', 'scape-ui-vimeo'],
		'vk'            => ['VK', 'scape-ui-vk'],
		'yelp'          => ['Yelp', 'scape-ui-yelp'],
		'youtube'       => ['YouTube', 'scape-ui-youtube'],
	);
}



/*
 * Returns array of portfolio details fields for VC
 */
function wtbx_vc_scape_grid_meta($links = true) {
	$array = wtbx_grid_meta($links);
	$output = array();

	foreach ( $array as $key => $value ) {
		$output[$value] = $key;
	}

	return $output;
}



/*
 * Returns array of custom metro grid layouts
 */
function wtbx_vc_grid_layouts($layout) {
	$layouts = array(
		'layout_1'  => array(
			'width'     => array(2, 1, 2, 2, 3, 1, 1, 1, 1, 1, 1, 1),
			'height'    => array(2, 1, 1, 2, 3, 1, 1, 2, 1, 1, 1, 1),
			'columns'   => 7,
			'tiles'     => 12
		),
		'layout_2'  => array(
			'width'     => array(3, 1, 1, 2, 2, 1, 1, 1, 1, 2, 1, 1),
			'height'    => array(3, 1, 1, 2, 2, 2, 1, 1, 1, 1, 1, 1),
			'columns'   => 7,
			'tiles'     => 12
		),
		'layout_3'  => array(
			'width'     => array(2, 1, 2, 1, 1, 3, 1, 1, 2, 1, 1, 1),
			'height'    => array(2, 1, 1, 2, 2, 3, 2, 1, 1, 1, 1, 1),
			'columns'   => 7,
			'tiles'     => 12
		),
		'layout_4'  => array(
			'width'     => array(2, 1, 1, 1, 1, 1, 2, 2, 1, 1),
			'height'    => array(1, 2, 1, 1, 2, 1, 1, 1, 1, 1),
			'columns'   => 5,
			'tiles'     => 10
		),
		'layout_5'  => array(
			'width'     => array(3, 1, 1, 1, 1, 1, 2, 2, 1, 1),
			'height'    => array(3, 1, 1, 2, 2, 1, 2, 1, 1, 1),
			'columns'   => 6,
			'tiles'     => 10
		),
		'layout_6'  => array(
			'width'     => array(2, 2, 1, 2, 1, 1, 3, 1, 1, 1),
			'height'    => array(2, 1, 1, 1, 1, 2, 2, 1, 1, 1),
			'columns'   => 7,
			'tiles'     => 10
		),
		'layout_7'  => array(
			'width'     => array(2, 1, 1, 2, 1, 1, 2, 2),
			'height'    => array(2, 1, 1, 1, 1, 1, 2, 1),
			'columns'   => 4,
			'tiles'     => 8
		),
		'layout_8'  => array(
			'width'     => array(2, 2, 1, 1, 1, 1, 1, 2, 2, 1, 1, 1, 1, 1),
			'height'    => array(2, 1, 2, 1, 1, 1, 1, 1, 2, 1, 2, 1, 1, 1),
			'columns'   => 4,
			'tiles'     => 14
		)
	);

	return $layouts[$layout];
}


/*
 * Returns JS string with filtered CSS styles to append
 */
function wtbx_vc_js_styles($styles) {
	$return = '';
	if ( $styles !== '' ) {
		if ( wtbx_vc_is_page_editable() ) {
			$return = '<style type="text/css">'. wp_kses_post($styles) . '</style>';
		} elseif ( function_exists('wtbx_footer_js_styles') ) {
			wtbx_footer_js_styles($styles);
		}
	}
	return $return;
}



/*
* Returns a filtered page ID
*/
function wtbx_vc_get_the_id() {
	global $post;
	$postID = null;

	if ( class_exists('Woocommerce' ) && is_shop() ) {
		$postID = wc_get_page_id('shop');
	} elseif ( class_exists('Woocommerce' ) && is_product_category() ) {
		$cat = get_queried_object();
		$postID = $cat->term_id;
	} elseif ( is_single() ) {
		$postID = $post->ID;
	}

	return $postID;
}



/*
 * Returns array of available sidebars
 */
function wtbx_sidebars_array() {
	$sidebars = array();
	$sidebars[''] = esc_html__('Inherit', 'core-extension');
	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
		$sidebars[$sidebar['id']] = $sidebar['name'];
	}
	return $sidebars;
}



/*
 * Adds scripts to queue
 */
function wtbx_vc_script_queue($data, $add = true) {
    if ( function_exists( 'wtbx_script_queue' ) ) {
	    wtbx_script_queue($data, $add);
    }
}



/*
 * Adds localization data to queue
 */
function wtbx_vc_localize_main_js( $object, $data, $add = false ) {
	if ( function_exists( 'wtbx_localize_main_js' ) ) {
		wtbx_localize_main_js( $object, $data, $add );
	}
}



/*
 * Returns the list of pages
 */
function wtbx_get_pages() {
	$data = array();

	$pages = get_pages();
	$data[] = esc_html__('Default', 'core-extension');

	if ( !empty($pages) ) {
		foreach( $pages as $page ) {
			$data[$page->ID] = $page->post_title;
		}
	}

	return $data;
}



/*
 * Returns true if on the Frontend Editor page
 */
function wtbx_vc_is_page_editable() {
	$is_editable = false;
	if ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) {
		$is_editable = true;
	}
	return $is_editable;
}



/*
 * Returns a base64-encoded empty image
 */
function wtbx_vc_empty_image() {
	return 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
}



/*
 * Returns an SVG arrow
 */
function wtbx_vc_arrow($dir) {
	$output = '';
	if ( $dir === 'left' ) {
		$output = '<svg class="wtbx_link_arrow" viewBox="0 0 800 461" xmlns="http://www.w3.org/2000/svg"><rect class="bar" height="60" rx="30" width="800" y="200"/><path class="chevron" d="m253.675752 211.75923c9.62699 11.783527 8.945751 29.177708-2.043718 40.167177l-200.13961 200.13961c-11.7157287 11.715729-30.7106781 11.715729-42.42640682 0-11.71572875-11.715729-11.71572875-30.710678 0-42.426407l179.07359282-179.073593-179.35281344-179.3528136c-11.71572875-11.7157287-11.71572875-30.7106781 0-42.42640684 11.71572874-11.71572875 30.71067814-11.71572875 42.42640684 0l199.4188306 199.41883044c1.122031 1.122031 2.136604 2.310828 3.043718 3.553603z" transform="matrix(-1 0 0 -1 260.41883 460.852814)"/></svg>';
	} else {
		$output = '<svg class="wtbx_link_arrow" viewBox="0 0 813 486" xmlns="http://www.w3.org/2000/svg"><rect class="bar" height="60" rx="30" width="800" y="213"/><path class="chevron" d="m793.388955 224.472433c9.626991 11.783528 8.945751 29.177709-2.043717 40.167177l-200.139611 200.139611c-11.715728 11.715728-30.710678 11.715728-42.426406 0-11.715729-11.715729-11.715729-30.710679 0-42.426407l179.073593-179.073593-179.352814-179.3528141c-11.715729-11.7157288-11.715729-30.7106781 0-42.4264069 11.715729-11.71572875 30.710678-11.71572875 42.426407 0l199.418831 199.418831c1.122031 1.122031 2.136603 2.310828 3.043717 3.553602z"/></svg>';
	}
	return $output;
}



/*
 * Returns array with typography options fields
 */
function wtbx_vc_get_typography_fields() {
	$fonts = wtbx_vc_get_theme_fonts();

	$params_array = array(
		'font_family'   => array(
			'title'     => 'Font family',
			'values'    => wtbx_vc_get_theme_font_names($fonts)
		),
		'backup_family' => array(
			'title'     => 'Backup font family',
			'values'    => wtbx_vc_get_standard_font_names()
		),
		'variants'  => array(
			'title'     => 'Font weight &amp; style',
			'values'    => ''
		),
		'subsets'       => array(
			'title'     => 'Font subsets',
			'values'    => ''
		),
		'transform'     => array(
			'title'     => 'Text transform',
			'values'    => array(
				''              => esc_html__('Inherit', 'core-extension'),
				'capitalize'    => esc_html__('Capitalize', 'core-extension'),
				'uppercase'     => esc_html__('Uppercase', 'core-extension'),
				'lowercase'     => esc_html__('Lowercase', 'core-extension'),
				'none'          => esc_html__('None', 'core-extension'),
			)
		),
	);

	return $params_array;
}



/*
 * Returns array of available theme fonts
 */
function wtbx_vc_get_theme_fonts() {
	$fonts = wtbx_vc_hide_nonexistent_fonts();
	return $fonts;
}



/*
 * Returns array of filtered and validated theme fonts
 */
function wtbx_vc_hide_nonexistent_fonts() {
	$theme_fonts = wtbx_vc_option('custom_fonts');
	$theme_fonts = !empty($theme_fonts['fonts']) ? json_decode($theme_fonts['fonts'], true) : '';
	if ( $theme_fonts !== '' ) {
		foreach ( (array) $theme_fonts['fonts'] as $id => $details ) {
			$type       = $details['type'];
			$upload_dir = wp_upload_dir();
			$dir        = '';

			if ( $type === 'custom' ) {
				$dir = trailingslashit($upload_dir['basedir']) . 'wtbx_custom_fonts/' . $details['name'] . '/stylesheet.css';
			} elseif ( $type === 'fontsquirrel' ) {
				$dir  = trailingslashit($upload_dir['basedir']) . 'wtbx_custom_fonts/' . $details['name'] . '/' . $details['family'] . '.css';
			} elseif ( $type === 'typekit' ) {
				if ( empty($theme_fonts['typekit_apikey']) || empty($theme_fonts['typekit_kitid']) ) {
					unset($theme_fonts['fonts'][$id]);
				}
			}

			if ( $dir !== '' && !file_exists($dir) ) {
				unset($theme_fonts['fonts'][$id]);
			}
		}
	}

	return $theme_fonts;
}



/*
 * Returns array with font_id => font_family
 */
function wtbx_vc_get_theme_font_names($fonts) {
	$array = array();
	$array[''] = esc_html__('Inherit', 'core-extension');
	if ( !empty($fonts) && isset($fonts['fonts']) ) {
		foreach ( $fonts['fonts'] as $font => $details ) {
			$array[$details['id']] = $details['family'];
		}
	}
	return $array;
}



/*
 * Returns array of standard font names
 */
function wtbx_vc_get_standard_font_names() {
	$array = array(
		""                                                     => "",
		"Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
		"'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
		"'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
		"'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
		"Courier, monospace"                                   => "Courier, monospace",
		"Garamond, serif"                                      => "Garamond, serif",
		"Georgia, serif"                                       => "Georgia, serif",
		"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
		"'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
		"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
		"'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
		"'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
		"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
		"Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
		"'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
		"'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
		"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
	);

	return $array;
}



/*
* Returns array of theme fonts for JS object
*/
function wtbx_vc_get_font_weight_style() {
	$fonts = wtbx_vc_get_theme_fonts();
	$new_fonts = array();
	if ( !empty($fonts) ) {
		$new_fonts = $fonts['fonts'];
		foreach ( $new_fonts as $id => $details ) {
			if ( isset($details['variants']) ) {
				$variants = $details['variants'];
				$variants = wtbx_vc_get_standardized_variants($variants);
				$new_fonts[$id]['variants'] = $variants;
			}
		}
	}
	return $new_fonts;
}



/*
* Returns array of standardized font weights and styles
*/
function wtbx_vc_get_standardized_variants($variants) {

	$weights    = wtbx_vc_get_font_weights();
	$return_arr = array();
//	$return_arr[] = 'inherit';

	foreach ( (array) $variants as $key => $value ) {
		$curr_variant = '';

		if ( (string) strtolower($value) === 'italic' ) {
			$curr_variant .= '400_italic';
		} else {
			foreach( $weights as $weight => $weight_opts ) {
				foreach( $weight_opts as $weight_opt ) {

					if ( preg_match('/'.$weight_opt.'/i', $value) ) {

						$curr_variant .= $weight;

						if ( preg_match('/italic/i', $value) ) {
							$curr_variant .= '_italic';
						}
						break 2;
					}
				}
			}
		}
		$return_arr[] = $curr_variant;
	}
	if ( !empty($return_arr) ) array_unshift($return_arr, 'inherit');

	return $return_arr;
}



/*
* Returns array of recognized font weights
*/
function wtbx_vc_get_font_weights() {
	return array(
		'100' => ['100', 'ultra thin', 'ultrathin', 'extra thin', 'extrathin', 'thin', 'hairline'],
		'200' => ['200', 'extra light', 'ultra light', 'extralight', 'ultralight'],
		'300' => ['300', 'light'],
		'400' => ['400', 'regular', 'normal', 'book', 'roman'],
		'500' => ['500', 'medium'],
		'600' => ['600', 'semi bold', 'demi bold', 'semibold', 'demibold'],
		'700' => ['700', 'bold'],
		'800' => ['800', 'extra bold', 'extrabold', 'ultra bold', 'ultra bold'],
		'900' => ['900', 'black', 'heavy']
	);
}



/*
* Returns an array of all registered consents of VC map
*/
function wtbx_vc_get_all_consents() {
	$consents = get_option( 'gdpr_consent_types', array() );
	$array = array(
		'-' => ''
	);

	if ( !empty($consents) ) {
		foreach ( $consents as $key => $consent ) {
			$array[$consent['name']] = $key;
		}
	}

	return $array;
}



function wtbx_vc_has_consent($type) {
	if ( class_exists('GDPR') && $type !== '' && !has_consent($type) ) {
		return false;
	} else {
		return true;
	}
}



function wtbx_set_503_header() {
	$protocol = 'HTTP/1.0 ';
	if ( isset($_SERVER['SERVER_PROTOCOL']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1' ) {
		$protocol = 'HTTP/1.1 ';
	}
	status_header( 503, $protocol . get_status_header_desc( 503 ) );
	header( 'Retry-After: 3600' );
}




// custom login styles
function wtbx_login_stylesheet() {
	if ( wtbx_vc_option('login-page-enable') ) {
		wp_enqueue_style( 'scape-custom-login', get_template_directory_uri() . '/library/css/login.css', '', SCAPE_VERSION, 'all' );
		wp_enqueue_style( 'scape-ui-font', get_template_directory_uri() . '/library/fonts/scape-ui.min.css', 'scape-style', SCAPE_VERSION, 'all' );

		$color_text_dark    = wtbx_vc_option('color-main-text-dark');
		$color_text_light    = wtbx_vc_option('color-main-text-light');
		$color_accent       = wtbx_vc_option('color-main-accent');
		$color_bg_light     = wtbx_vc_option('color-main-bg-light');
		$color_border       = wtbx_vc_option('color-main-border-color');

		?>
		<style type="text/css">
			<?php if ( wtbx_vc_option('login-page-logo') !== '' ) { ?>
			#login h1 a, .login h1 a {
				background-image: url(<?php echo wtbx_vc_option_sub('login-page-logo', 'url') ?>);
				width: <?php echo intval(wtbx_vc_option_sub('login-page-logo', 'width'))/2; ?>px;
				height: <?php echo intval(wtbx_vc_option_sub('login-page-logo', 'height'))/2; ?>px;
				background-size: cover;
				background-position: center center;
			}
			<?php } ?>
			body.login #login_error a {
				color: <?php echo esc_html($color_accent); ?>;
			}
			body.login div#login label,
			body.login div#login p.message {
				color: <?php echo esc_html($color_text_dark); ?>;
			}
			body.login div#login form#loginform p.forgetmenot input#rememberme:checked:before {
				background-color: <?php echo esc_html($color_accent); ?>;
				border-color: <?php echo esc_html($color_accent); ?>;
			}
			body.login div#login input {
				box-shadow: 0 0 0 1px rgba(<?php echo wtbx_hex2rgb($color_border); ?>, 1);
			}
			body.login div#login input:focus, body.login div#login input:active {
				box-shadow: 0 0 0 2px rgba(<?php echo wtbx_hex2rgb($color_accent); ?>, 1);
			}
			body.login div#login p.message:before {
				background-color: <?php echo esc_html($color_accent); ?>;
			}
			body.login div#login form#loginform p.forgetmenot input#rememberme:before {
				border-color: <?php echo esc_html($color_border); ?>;
			}
			body.login div#login form#loginform p.forgetmenot input#rememberme:hover:before {
				border-color: <?php echo esc_html($color_accent); ?>;
			}
			body.login div#login p.submit input#wp-submit {
				color: <?php echo wtbx_vc_option_sub('btn-primary-text-def','rgba'); ?>;
				background-color: <?php echo wtbx_vc_option_sub('btn-primary-bg-def','rgba'); ?>;
			}
			body.login div#login p.submit input#wp-submit:hover {
				color: <?php echo wtbx_vc_option_sub('btn-primary-text-hover','rgba'); ?>;
				background-color: <?php echo wtbx_vc_option_sub('btn-primary-bg-hover','rgba'); ?>;
			}
			body.login {
				background-color: <?php echo wtbx_vc_option_sub('login-page-bg', 'background-color'); ?>;
				background-image: url(<?php echo wtbx_vc_option_sub('login-page-bg', 'background-image'); ?>);
				background-repeat: <?php echo wtbx_vc_option_sub('login-page-bg', 'background-repeat'); ?>;
				background-position: <?php echo wtbx_vc_option_sub('login-page-bg', 'background-position'); ?>;
				background-size: <?php echo wtbx_vc_option_sub('login-page-bg', 'background-size'); ?>;
				background-attachment: <?php echo wtbx_vc_option_sub('login-page-bg', 'background-attachment'); ?>;
			}
			body.login:after {
				background-color: <?php echo wtbx_vc_option_sub('login-page-overlay', 'rgba'); ?>;
			}
            body.login .wp-pwd .button.wp-hide-pw .dashicons {
                color: <?php echo esc_html($color_text_light); ?>;
            }
            body.login .wp-pwd .button.wp-hide-pw:hover .dashicons {
                color: <?php echo esc_html($color_text_dark); ?>;
            }
		</style>
		<?php
	}
}