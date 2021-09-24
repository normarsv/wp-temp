<?php
/*
*	---------------------------------------------------------------------
*	WTBX Custom functions
*	---------------------------------------------------------------------
*/

// generate css styles
if ( ! function_exists( 'wtbx_generate_css' ) ) {
	function wtbx_generate_css() {
		global $wp_filesystem;

		$css_dir = wtbx_custom_styles_dir();

		// Initialise the Wordpress filesystem, no more using file_put_contents function
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}

		$styles = scandir(WTBX_PATH . '/inc/custom-styles/');
		foreach ( $styles as $style ) {
		    if ( !empty($style) && $style !== '.' && $style !== '..' && $style !== '/' ) {
			    wtbx_generate_stylesheet($style);
            }
        }

		$chmod_file = ( 0755 & ~ umask() );
		if ( defined( 'FS_CHMOD_FILE' ) ) {
			$chmod_file = FS_CHMOD_FILE;
		}

		// TinyMCE styles
		ob_start();
		require(WTBX_PATH . '/inc/scape-tinymce.css.php');
		$css = ob_get_clean();

		$wp_filesystem->put_contents(
			$css_dir . 'library/css/scape-tinymce.css',
			$css,
			$chmod_file
		);

		// Gutenberg styles
		ob_start();
		require(WTBX_PATH . '/inc/gutenscape.css.php');
		$css = ob_get_clean();

		$wp_filesystem->put_contents(
			$css_dir . 'library/css/scape-gutenberg.css',
			$css,
			$chmod_file
		);
	}
}


if ( ! function_exists( 'wtbx_custom_styles_dir' ) ) {
	function wtbx_custom_styles_dir($url = false) {
		$upload_dir         = wp_upload_dir();
		$new_dir            = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_styles' );

		if (!file_exists($new_dir)) {
			wp_mkdir_p($new_dir);
		}

		if ( $url ) {
		    $new_dir = trailingslashit( $upload_dir['baseurl'] . '/wtbx_custom_styles' );
		    $new_dir = str_replace(array('http:', 'https:'), '', $new_dir);
        }

		return $new_dir;
	}
}


if ( ! function_exists( 'wtbx_generate_stylesheet' ) ) {
    function wtbx_generate_stylesheet( $filename ) {
	    global $wp_filesystem;

	    // Initialise the Wordpress filesystem, no more using file_put_contents function
	    if (empty($wp_filesystem)) {
		    require_once(ABSPATH .'/wp-admin/includes/file.php');
		    WP_Filesystem();
	    }

        $path = WTBX_PATH . '/inc/custom-styles/' . $filename;
	    $css_dir = WTBX_PATH. '/library/css/';
        $css_dir = wtbx_custom_styles_dir();

	    ob_start();
	    require($path);
	    $css = ob_get_clean();

	    // remove comments
	    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
	    // backup values within single or double quotes
	    preg_match_all('/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER);
	    for ($i=0; $i < count($hit[1]); $i++) {
		    $css = str_replace($hit[1][$i], '##########' . $i . '##########', $css);
	    }
	    // remove traling semicolon of selector's last property
	    $css = preg_replace('/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css);
	    // remove any whitespace between semicolon and property-name
	    $css = preg_replace('/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css);
	    // remove any whitespace surrounding property-colon
	    $css = preg_replace('/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css);
	    // remove any whitespace surrounding selector-comma
	    $css = preg_replace('/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css);
	    // remove any whitespace surrounding opening parenthesis
	    $css = preg_replace('/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css);
	    // remove any whitespace between numbers and units
	    $css = preg_replace('/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css);
	    // shorten zero-values
	    $css = preg_replace('/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css);
	    // constrain multiple whitespaces
	    $css = preg_replace('/\p{Zs}+/ims',' ', $css);
	    // remove newlines
	    $css = str_replace(array("\r\n", "\r", "\n"), '', $css);
	    // Restore backupped values within single or double quotes
	    for ($i=0; $i < count($hit[1]); $i++) {
		    $css = str_replace('##########' . $i . '##########', $hit[1][$i], $css);
	    }

	    $chmod_file = ( 0755 & ~ umask() );
	    if ( defined( 'FS_CHMOD_FILE' ) ) {
		    $chmod_file = FS_CHMOD_FILE;
	    }

	    $wp_filesystem->put_contents(
		    $css_dir . str_replace('.php', '', $filename),
		    $css,
		    $chmod_file
	    );
    }
}


// outputs image (img)
if ( ! function_exists( 'wtbx_image_smart_img' ) ) {
	function wtbx_image_smart_img( $img_id, $src_size, $srcset_size, $alt = '', $classes = '', $return = false, $lazy = '' ) {
		$image = '<div class="wtbx-image-placeholder"></div>';
		$is_external =  strpos($img_id, 'whiteboxstud.io') !== false || strpos($img_id, 'localhost') !== false;

		$classes .= ( $classes !== '' ) ? ' ' : '';

		if ( $is_external ) {
			$image = '<img class="wtbx-lazyloaded wtbx-external" src="' . $img_id . '"/>';
		} elseif ( $img_id ) {
			$data_srcset = wp_get_attachment_image_srcset( $img_id, $srcset_size );

            $lazy = $lazy !== '' ? $lazy : wtbx_option('site-smartimage');

            if ( $alt === '' ) {
                $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
            }

            $metadata = wp_get_attachment_metadata( $img_id );
            if ( isset($metadata['height']) && isset($metadata['width']) ) {
                $ratio = $metadata['height'] / $metadata['width'];
            }

            if ( $lazy === '1' ) {
                $loaded = '';
            } else {
                $loaded = ' wtbx-lazyloaded';
            }

			$data_srcset === false && isset($metadata['width']) ? $data_srcset = wp_get_attachment_image_url( $img_id, 'full' ) . ' ' . esc_attr($metadata['width']) . 'w'  : null;

			$dims = array();
			$data_path = '';
			$src = pathinfo(wp_get_attachment_image_url( $img_id, 'full' ));

			if ( $src && !empty($src) ) {
				$data_path =  trailingslashit($src['dirname']) . $src['filename'];
				$strip_chars = '-scaled.';
				if ( strpos($data_path  . '.' . $src['extension'], $strip_chars) !== false ) {
					$data_path = explode($strip_chars, $data_path  . '.' . $src['extension'])[0];
				}

				$candidates = explode(', ', $data_srcset);
				foreach ( $candidates as $candidate ) {

					$cdn = wtbx_option('site-image-cdn');
					if ( !empty($cdn) ) {
						$candidate = str_replace(trailingslashit(site_url()), trailingslashit($cdn), $candidate);
						$data_path = str_replace(trailingslashit(site_url()), trailingslashit($cdn), $data_path);
					}

					$size_string = str_replace('scaled', '', str_replace('-', '', explode(str_replace(array('http://www.', 'https://www.', 'https://', 'http://'), '', $data_path), $candidate)[1]));
					$dims[] = $size_string;
				}
			}

			// output
            if ( $lazy === '1' ) {
                if ( wp_get_attachment_image_url( $img_id, $src_size ) !== false && $data_srcset !== false ) {
                    $attr = array(
                        'class' => $classes.'wtbx-image wtbx-lazy lazyload'.$loaded,
                        'data-bg' => 'false',
                        'data-imgratio' => esc_attr($ratio),
                        'src' => wtbx_get_empty_image(),
                        'srcset' => '',
                        'data-src' => esc_attr(wp_get_attachment_image_url( $img_id, $src_size )),
                        'data-path' => esc_attr($data_path),
                        'data-dims' => esc_attr(json_encode($dims)),
                        'data-sizes' => 'auto',
                        'alt' => esc_attr($alt)
                    );
	                $image = '<img' . wtbx_args_to_html_attr($attr) . ' />';
                }
            } else {
                if ( wp_get_attachment_image_url( $img_id, $src_size ) !== false && $data_srcset !== false ) {
                    $attr = array(
                        'class' => $classes.'wtbx-lazyloaded',
                        'alt' => esc_attr($alt)
                    );
                    $image = wp_get_attachment_image( $img_id, $src_size, false, $attr );
                }
            }
		}

		$image_escaped = $image;

		if ( $return === false ) {
			// This variable contains dynamic values that have been safely escaped above
			echo $image_escaped;
			return false;
		} else {
			return $image_escaped;
		}
	}
}



// outputs image (cropped)
if ( ! function_exists( 'wtbx_image_smart_crop' ) ) {
	function wtbx_image_smart_crop( $img_id, $src_size, $srcset_size, $ratio = '', $alt = '', $classes = '', $return = false, $lazy = '' ) {
		$image = '<div class="wtbx-image-placeholder"></div>';
		$is_external =  strpos($img_id, 'whiteboxstud.io') !== false || strpos($img_id, 'localhost') !== false;
		$aspect = 100;
		$spacing = '';

		$classes .= ( $classes !== '' ) ? ' ' : '';

		if ( $is_external ) {
			$image = '<img class="wtbx-lazyloaded wtbx-external" src="' . $img_id . '"/>';
		} elseif ( $img_id ) {
			$data_srcset = wp_get_attachment_image_srcset( $img_id, $srcset_size );

			$lazy = $lazy !== '' ? $lazy : wtbx_option('site-smartimage');

			if ( $alt === '' ) {
				$alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
			}

			if ( $lazy === '1' ) {
				$loaded = '';
			} else {
				$loaded = ' wtbx-lazyloaded';
			}

			$aspectratio = 1;
			$metadata = wp_get_attachment_metadata( $img_id );
			if ( isset($metadata['height']) && isset($metadata['width']) ) {
				$aspectratio = round($metadata['width'] / $metadata['height'], 4);
			}

			$data_srcset === false && isset($metadata['width']) ? $data_srcset = wp_get_attachment_image_url( $img_id, 'full' ) . ' ' . esc_attr($metadata['width']) . 'w'  : null;

			// bottom padding
			if ( $ratio === false ) {
				$spacing    = '';
				$external   = '';
			} elseif ($ratio && $ratio !== '' && strpos($ratio, ':') !== false) {
				$dimensions = explode(':', $ratio);
				$aspect     = round(1 / ($dimensions[0] / $dimensions[1]), 4) * 100;
				$spacing    = ' style="padding-bottom: ' . esc_attr($aspect) . '%"';
				$external   = ' wtbx-external';
			} else {
				$external   = ' wtbx-external';
				if ( $is_external ) {
					$spacing = '';
				} else {
					$spacing = ' style="padding-bottom: 66.67%"';
				}
			}

			$dims = array();
			$data_path = '';
			$src = pathinfo(wp_get_attachment_image_url( $img_id, 'full' ));

			if ( $src && !empty($src) ) {
				$data_path =  trailingslashit($src['dirname']) . $src['filename'];
				$strip_chars = '-scaled.';
				if ( strpos($data_path  . '.' . $src['extension'], $strip_chars) !== false ) {
				    $data_path = explode($strip_chars, $data_path  . '.' . $src['extension'])[0];
                }

				$candidates = explode(', ', $data_srcset);
				foreach ( $candidates as $candidate ) {

					$cdn = wtbx_option('site-image-cdn');
					if ( !empty($cdn) ) {
						$candidate = str_replace(trailingslashit(site_url()), trailingslashit($cdn), $candidate);
						$data_path = str_replace(trailingslashit(site_url()), trailingslashit($cdn), $data_path);
					}

					$size_string = str_replace('scaled', '', str_replace('-', '', explode(str_replace(array('http://www.', 'https://www.', 'https://', 'http://'), '', $data_path), $candidate)[1]));
					$dims[] = $size_string;
				}
            }

			// output
			if ( $lazy === '1' ) {
				if ( wp_get_attachment_image_url( $img_id, $src_size ) !== false && $data_srcset !== false ) {
					$attr = array(
						'class' => $classes.'wtbx-image wtbx-lazy lazyload'.$loaded,
						'data-bg' => 'false',
						'data-imgratio' => esc_attr($ratio),
						'data-aspectratio' => esc_attr($aspectratio),
						'src' => wtbx_get_empty_image(),
						'srcset' => '',
						'data-src' => esc_attr(wp_get_attachment_image_url( $img_id, $src_size )),
						'data-path' => esc_attr($data_path),
						'data-dims' => esc_attr(json_encode($dims)),
						'data-sizes' => 'auto',
						'data-parent-fit' => 'cover',
						'alt' => esc_attr($alt)
					);
					$image = '<img' . wtbx_args_to_html_attr($attr) . ' />';
				}
			} else {
				if ( wp_get_attachment_image_url( $img_id, $src_size ) !== false && $data_srcset !== false ) {
					$attr = array(
						'class' => $classes.'wtbx-lazyloaded',
						'alt' => esc_attr($alt)
					);
					$image = wp_get_attachment_image( $img_id, $src_size, false, $attr );
				}
			}
		}

		$image_escaped  = '<div class="wtbx-image-crop' . ($ratio === false ? ' wtbx-cover' : '') . '"' . $spacing . '>';
		$image_escaped .= $image;
		$image_escaped .= '</div>';

		if ( $return === false ) {
			// This variable contains dynamic values that have been safely escaped above
			echo $image_escaped;
			return false;
		} else {
			return $image_escaped;
		}
	}
}



// outputs image (bg)
if ( ! function_exists( 'wtbx_image_smart_bg' ) ) {
	function wtbx_image_smart_bg( $img_id, $src_size, $srcset_size, $ratio = '', $alt = '', $classes = '', $return = false, $lazy = '' ) {
		$image = '';
		$is_external =  strpos($img_id, 'whiteboxstud.io') !== false || strpos($img_id, 'localhost') !== false;

		$lazy = $lazy !== '' ? $lazy : wtbx_option('site-smartimage');

		if ( $lazy === '1' ) {
			$bg         = '';
			$loaded     = ' wtbx-lazy';
		} else {
			$bg         = ' style="background-image: url(\'' . esc_url( wp_get_attachment_image_url( $img_id, $src_size ) ) . '\')"';
			$loaded     = ' wtbx-lazy wtbx-lazyloaded';
		}

		$classes .= ( $classes !== '' ) ? ' ' : '';
		$classes  = ' class="'.$classes.'wtbx-image lazyload'.$loaded.'"';

		// bottom padding
		if ( $ratio === false ) {
			$spacing    = '';
			$external   = '';
		} elseif ($ratio && $ratio !== '' && strpos($ratio, ':') !== false) {
			$dimensions = explode(':', $ratio);
			$aspect     = round(1 / ($dimensions[0] / $dimensions[1]), 4) * 100;
			$spacing    = ' style="padding-bottom: ' . esc_attr($aspect) . '%"';
			$external   = ' wtbx-external';
		} else {
			$external   = ' wtbx-external';
			if ( $is_external ) {
                $spacing = '';
            } else {
			    $spacing = ' style="padding-bottom: 66.67%"';
		    }
		}

		// ratio for "h" attribute calculation
		$metadata = wp_get_attachment_metadata( $img_id );
		if ( isset($metadata['height']) && isset($metadata['width']) ) {
			$ratio = round($metadata['height'] / $metadata['width'] * 100, 2);
		}

		if ( $is_external ) {
			// output
			$image .=   '<div class="wtbx-bg-image">';
			$image .=      '<div class="wtbx-bg-image-inner'.esc_attr($external).'"'.$spacing.'>';
			$image .=          '<div'.$classes.' data-bg="true" style="background-image: url(\'' . $img_id . '\')"';
			$image .=              ' data-sizes="auto"';
			$image .=              ' data-bgset="'.esc_attr($img_id).' 1920w"';
			$image .=              ' data-ratio="66.67"';
			$image .=              ' aria-label="'.esc_attr($alt).'"';
			$image .=   '></div></div></div>';
        } elseif ( $img_id ) {
			$data_srcset = wp_get_attachment_image_srcset( $img_id, $srcset_size );

			if ( !wp_get_attachment_image_url( $img_id, $src_size ) ) {
			    return false;
			}

            if ( $alt === '' ) {
                $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
            }

			$metadata = wp_get_attachment_metadata( $img_id );

			( $data_srcset === false && isset($metadata['width']) ) ? $data_srcset = wp_get_attachment_image_url( $img_id, 'full' ) . ' ' . esc_attr($metadata['width']) . 'w'  : null;

			if ( $data_srcset !== false ) {
				$dims = array();
				$data_path = '';

				$src = pathinfo(wp_get_attachment_image_url( $img_id, 'full' ));

				if ( $src && !empty($src) ) {
					$data_path =  trailingslashit($src['dirname']) . $src['filename'];

					$candidates = explode(', ', $data_srcset);
					foreach ($candidates as $candidate) {
						$strip_chars = '-scaled.';
						if ( strpos($data_path  . '.' . $src['extension'], $strip_chars) !== false ) {
							$data_path = explode($strip_chars, $data_path  . '.' . $src['extension'])[0];
						}

						$cdn = wtbx_option('site-image-cdn');
						if ( !empty($cdn) ) {
							$candidate = str_replace(trailingslashit(site_url()), trailingslashit($cdn), $candidate);
							$data_path = str_replace(trailingslashit(site_url()), trailingslashit($cdn), $data_path);
						}

						$size_string = str_replace('scaled', '', str_replace('-', '', explode(str_replace(array('http://www.', 'https://www.', 'https://', 'http://'), '', $data_path), $candidate)[1]));
						$width_string = explode(' ', $size_string)[1];
						$width_val = intval($width_string);
						$height_string = round($width_val * $ratio / 100) . 'h';
						$size_string .= ' ' . $height_string;
						$dims[] = $size_string;
					}
				}

				// output
                $image .=   '<div class="wtbx-bg-image">';
                $image .=      '<div class="wtbx-bg-image-inner"'.$spacing.'>';
                $image .=          '<div '.$classes.' data-bg="true"' . $bg;
                $image .=              ' data-sizes="auto"';
                $image .=              ' data-path="'.esc_attr($data_path).'"';
				$image .=              ' data-dims="'.esc_attr(json_encode($dims)).'"';
//				$image .=              ' data-bgset="'.esc_attr($data_srcset).'"';
                $image .=              ' data-ratio="'.esc_attr($ratio).'"';
                $image .=              ' aria-label="'.esc_attr($alt).'"';
                $image .=   '></div></div></div>';
            }
		}

		$image_escaped = $image;

		if ( $return === false ) {
			// This variable contains dynamic values that have been safely escaped above
			echo $image_escaped;
			return false;
		} else {
			return $image_escaped;
		}
	}
}



// Get empty image
if ( ! function_exists( 'wtbx_get_empty_image' ) ) {
    function wtbx_get_empty_image() {
        $image = '';
        if ( class_exists( 'SCAPE_Core_Extend' ) && function_exists( 'wtbx_vc_empty_image' ) ) {
            $image = wtbx_vc_empty_image();
        }

        return $image;
    }
}



// Lightbox data attributes
if ( ! function_exists( 'wtbx_lightbox_attributes' ) ) {
	function wtbx_lightbox_attributes($poster = '') {

		$data_poster = '';

	    if  (class_exists('GDPR') ) {
		    wtbx_localize_main_js('wtbxNoConsentLightbox', array(
			    'icons' => wtbx_noconsent_icons(),
			    'text' => wtbx_noconsent_text()
		    ) );

		    $data_poster = ' data-poster="'.wp_get_attachment_url($poster).'"';
        }

		// get options
		$counter        = wtbx_option('lightbox-counter');
		$thumbnail      = wtbx_option('lightbox-thumbnail');
		$scroll         = wtbx_option('lightbox-scroll');

		// share buttons
		$share_array = ['facebook', 'googleplus', 'linkedin', 'pinterest', 'twitter', 'vkontakte'];
		$share_buttons = array();
		foreach ( $share_array as $network ) {
			if ( wtbx_option('lightbox-share-'.$network) === '1' ) {
				$share_buttons[] = $network;
			}
		}
		$share_buttons = implode(',', $share_buttons);

		// output
		$output  = '';
		$output .= ' data-counter="'.esc_attr($counter).'"';
		$output .= ' data-thumbnail="'.esc_attr($thumbnail).'"';
		$output .= ' data-share-buttons="'.esc_attr($share_buttons).'"';
		$output .= ' data-scroll="'.esc_attr($scroll).'"';
		$output .= $data_poster;
		return $output;
	}
}



if ( !function_exists( 'wtbx_social_networks' ) ) {
    function wtbx_social_networks() {
        if ( function_exists( 'wtbx_vc_social_networks' ) ) {
            return wtbx_vc_social_networks();
        }
        return false;
    }
}



if ( !function_exists( 'wtbx_get_alt_text' ) ) {
	function wtbx_get_alt_text($id) {
		$alt = '';
		if ( $id !== '' ) {
			$alt = get_post_meta($id, '_wp_attachment_image_alt', true);
			if ( empty($alt) ) {
				$alt = get_the_title($id);
			}
		}
		return $alt;
	}
}



if ( ! function_exists( 'wtbx_decoration' ) ) {
	function wtbx_decoration( $style = '', $color = '#ffffff', $return = false ) {
		$output = '';

		if ( $style !== '' ) {
			$width  = 100;
			$height = 100;
			$paths   = array();

			switch ($style) {
				case 'slope-left':
					$paths[] = 'M0 100 0 95 100 0 100 100 Z';
					break;
				case 'slope-right':
					$paths[] = 'M0 0 L100 95 100 100 0 100 Z';
					break;
				case 'corner-left':
					$paths[] = 'M0,0 15,90 C16,95 16,97 23,91 L100,36 100,100 0,100 Z';
					break;
				case 'corner-right':
					$paths[] = 'M0,36 L77,91 C84,97 84,95 85,90 L100,0 L100,100 0,100 Z';
					break;
				case 'curve-top':
					$paths[] = 'M0 100 L0 90 C40 -30 60 -30 100 90 L100 100 Z';
					break;
				case 'curve-bottom':
					$paths[] = 'M0 100 0 0 C40 120 60 120 100 0 L 100 100 Z';
					break;
				case 'curve-left':
					$paths[] = 'M0 100 0 0 C15 120 35 120 100 0 L 100 100 Z';
					break;
				case 'curve-right':
					$paths[] = 'M0 100 0 0 C65 120 85 120 100 0 L 100 100 Z';
					break;
				case 'triangle-top':
					$paths[] = 'M0 100 0 90 50 0 100 90 100 100 Z';
					break;
				case 'triangle-bottom':
					$paths[] = 'M0 100 L0 0 50 90 100 0 100 100 Z';
					break;
				case 'notch-bottom':
					$paths[] = 'M0,0 C0,0 0.732348743,27.8872506 10.999999,45 C26,70 46,75 46,100 C46,125 25.9999999,130 10.999999,155 C0.256994849,172.905006 0,200 0,200 L52,200 52,0 0,0 Z';
					$width  = 52;
					$height = 200;
					break;
				case 'notch-top':
					$paths[]   = 'M-1,0 L0,0 C0,0 0.732348743,27.8872506 10.999999,45 C26,70 46,75 46,100 C46,125 25.9999999,130 10.999999,155 C0.256994849,172.905006 0,200 0,200 L0,200 L-1,200 Z';
					$width  = 52;
					$height = 200;
					break;
				case 'waves-1':
					$paths[] = 'M0 100 C15,60 35,60 100,100 Z';
					$paths[] = 'M0 100 L0,90 C20,20 70,60 100,100 Z';
					$paths[] = 'M0 100 L0,60 C10,20 60,100 100,100 Z';
					$paths[] = 'M0 100 L40,100 C80,50 95,50 100,50 L100,100 Z';
					break;
				case 'waves-2':
					$paths[] = 'M0 100 C25,90 70,40 100,90 L100,100 Z';
					$paths[] = 'M0 100 L0,80 C20,25 60,60 100,100 Z';
					$paths[] = 'M0 100 L0,60 C10,70 60,100 100,100 Z';
					$paths[] = 'M0 100 C60,30 80,40 100,100 Z';
					$paths[] = 'M0 100 L40,100 C80,50 95,50 100,50 L100,100 Z';
					break;
				case 'waves-3':
					$paths[] = 'M0,100 L0,45 C15,100 35,100 100,80 L100,100 Z';
					$paths[] = 'M0 100 L0,0 C10,60 20,100 100,100 Z';
					$paths[] = 'M0 100 L0,50 C30,20 50,100 100,100 Z';
					$paths[] = 'M0 100 L0,30 C10,-20 30,100 50,100 L100,100 Z';
					$paths[] = 'M0 100 L30,100 C60,60 80,70 100,90 L100,100 Z';
					$paths[] = 'M0 100 L50,100 C65,95 85,75 100,60 L100,100 Z';
					break;
				case 'waves-4':
					$paths[] = 'M0,100 L0,80 C65,100 85,100 100,45 L100,100 Z';
					$paths[] = 'M0 100 C80,100 90,60 100,0 L100,100 Z';
					$paths[] = 'M0 100 C50,100 70,20 100,50 L100,100 Z';
					$paths[] = 'M0 100 L40,100 C80,20 90,0 100,40 L100,100 Z';
					$paths[] = 'M0 100 C20,70 40,60 70,100 L100,100 Z';
					$paths[] = 'M0 100 L0,50 C15,75 35,100 50,100 L100,100 Z';
					break;
				case 'waves-5':
					$paths[] = 'M0,100 L0,50 C5,40 20,40 30,70 C40,100 50,100 60,80 C70,60 80,60 90,70 C100,80 100,80 100,80 L100,100 Z';
					$paths[] = 'M0 100 L0,20 C20,20 30,100 50,100 Z';
					$paths[] = 'M0 100 L0,40 C30,100 50,100 100,50 L100,100 Z';
					$paths[] = 'M0 100 L0,30 C40,0 40,160 55,100 L100,100 Z';
					$paths[] = 'M0 100 L50,100 C60,90 70,40 100,65 L100,100 Z';
					$paths[] = 'M0 100 L50,100 C65,95 85,75 100,70 L100,100 Z';
					break;
				case 'waves-6':
					$paths[] = 'M0,100 L0,80 C0,80 0,80 10,70 C20,60 30,60 40,80 C50,100 60,100 70,70 C80,40 95,40 100,50 L100,100 Z';
					$paths[] = 'M0 100 L50,100 C70,100 80,20 100,20 L100,100 Z';
					$paths[] = 'M0 100 L0,50 C50,100 70,100 100,40 L100,100 Z';
					$paths[] = 'M0 100 L45,100 C60,160 60,0 100,30 L100,100 Z';
					$paths[] = 'M0 100 L0,65 C30,40 40,90 50,100 L100,100 Z';
					$paths[] = 'M0 100 L0,70 C15,75 35,95 100,50 L100,100 Z';
					break;
				case 'layered-1':
					$paths[] = 'M4.4408921e-15,8.16369858 C2.13175456,3.16793204 4.70743815,0.670048765 7.72705078,0.670048765 C18.4671021,0.670048765 22.2784424,43.4806415 34.4662476,43.4806415 C47.1838379,43.4806415 47.9907032,25.7087262 58.7713972,25.7087262 C72.0083967,25.7087262 77.9150391,94.4423992 100,94.4423992 L100,100.670049 L0,100.670049 L4.4408921e-15,8.16369858 Z';
					$paths[] = 'M4.4408921e-15,8.16369858 C2.13175456,3.16793204 4.70743815,0.670048765 7.72705078,0.670048765 C18.4671021,0.670048765 22.2784424,43.4806415 34.4662476,43.4806415 C47.1838379,43.4806415 47.9907032,22.2514492 58.7713972,22.2514492 C72.0083967,22.2514492 77.9150391,87.7804472 100,87.7804472 L100,100.670049 L0,100.670049 L4.4408921e-15,8.16369858 Z';
					$paths[] = 'M4.4408921e-15,8.16369858 C2.13175456,3.16793204 4.70743815,0.670048765 7.72705078,0.670048765 C18.4671021,0.670048765 22.2784424,40.9095743 34.4662476,40.9095743 C47.1838379,40.9095743 47.9907032,18.4662671 58.7713972,18.4662671 C72.0083967,18.4662671 77.9150391,79.1277087 100,79.1277087 L100,100.670049 L0,100.670049 L4.4408921e-15,8.16369858 Z';
					break;
				case 'layered-2':
					$paths[] = 'M4.4408921e-15,8.16369858 C2.13175456,3.16793204 4.70743815,0.670048765 7.72705078,0.670048765 C18.4671021,0.670048765 22.2784424,43.4806415 34.4662476,43.4806415 C47.1838379,43.4806415 47.9907032,25.7087262 58.7713972,25.7087262 C72.0083967,25.7087262 77.9150391,94.4423992 100,94.4423992 L100,100.670049 L0,100.670049 L4.4408921e-15,8.16369858 Z';
					$paths[] = 'M4.4408921e-15,8.16369858 C2.13175456,3.16793204 4.70743815,0.670048765 7.72705078,0.670048765 C18.4671021,0.670048765 22.2784424,43.4806415 34.4662476,43.4806415 C47.1838379,43.4806415 47.9907032,22.2514492 58.7713972,22.2514492 C72.0083967,22.2514492 77.9150391,87.7804472 100,87.7804472 L100,100.670049 L0,100.670049 L4.4408921e-15,8.16369858 Z';
					$paths[] = 'M4.4408921e-15,8.16369858 C2.13175456,3.16793204 4.70743815,0.670048765 7.72705078,0.670048765 C18.4671021,0.670048765 22.2784424,40.9095743 34.4662476,40.9095743 C47.1838379,40.9095743 47.9907032,18.4662671 58.7713972,18.4662671 C72.0083967,18.4662671 77.9150391,79.1277087 100,79.1277087 L100,100.670049 L0,100.670049 L4.4408921e-15,8.16369858 Z';
					break;
                case 'layered-3':
	                $paths[] = 'M0 100 L0 90 C40 30 60 30 100 90 L100 100 Z';
	                $paths[] = 'M0 100 L0 70 C40 10 60 10 100 70 L100 100 Z';
	                $paths[] = 'M0 100 L0 50 C40 -10 60 -10 100 50 L100 100 Z';
	                break;
				case 'layered-4':
					$paths[] = 'M0 100 0 40 C40 100 60 100 100 40 L 100 100 Z';
					$paths[] = 'M0 100 0 20 C40 80 60 80 100 20 L 100 100 Z';
					$paths[] = 'M0 100 0 0 C40 60 60 60 100 0 L 100 100 Z';
					break;
				case 'layered-5':
					$paths[] = 'M4.4408921e-15,10.7270202 C2.71905444,27.5789203 6.45699,32.4843089 9.47660263,32.4843089 C18.4347945,32.4843089 20.3684444,4.47381794 29.2026738,4.47381794 C38.0369031,4.47381794 43.0978392,50.1919525 51.7764117,50.1919525 C60.4549841,50.1919525 61.5184294,18.9856821 72.4256626,18.9856821 C83.3328957,18.9856821 84.1887902,68.1108873 100,58.1393831 C100,58.1393831 100,71.952538 100,99.5788479 L0,99.5788479 L4.4408921e-15,10.7270202 Z';
					$paths[] = 'M0,4.47381794 C2.71905444,21.325718 6.45699,30.5034538 9.47660263,30.5034538 C18.4347945,30.5034538 22.7051399,4.47381794 31.5393692,4.47381794 C40.3735986,4.47381794 43.0978392,45.9109046 51.7764117,45.9109046 C60.4549841,45.9109046 61.5184294,18.9856821 72.4256626,18.9856821 C83.3328957,18.9856821 84.1887902,68.1108873 100,58.1393831 C100,58.1393831 100,71.952538 100,99.5788479 L0,99.5788479 L0,4.47381794 Z';
					$paths[] = 'M0,0.525544757 C2.71905444,17.3774449 6.45699,30.5034538 9.47660263,30.5034538 C18.4347945,30.5034538 20.3684444,4.47381794 29.2026738,4.47381794 C38.0369031,4.47381794 43.0978392,40.7584783 51.7764117,40.7584783 C60.4549841,40.7584783 62.5501441,20.3422677 73.4573773,20.3422677 C84.3646105,20.3422677 84.1887902,59.1439085 100,49.1724043 C100,49.1724043 100,65.9745522 100,99.5788479 L0,99.5788479 L0,0.525544757 Z';
					break;
				case 'layered-6':
					$paths[] = 'M4.4408921e-15,10.7270202 C2.71905444,27.5789203 6.45699,32.4843089 9.47660263,32.4843089 C18.4347945,32.4843089 20.3684444,4.47381794 29.2026738,4.47381794 C38.0369031,4.47381794 43.0978392,50.1919525 51.7764117,50.1919525 C60.4549841,50.1919525 61.5184294,18.9856821 72.4256626,18.9856821 C83.3328957,18.9856821 84.1887902,68.1108873 100,58.1393831 C100,58.1393831 100,71.952538 100,99.5788479 L0,99.5788479 L4.4408921e-15,10.7270202 Z';
					$paths[] = 'M0,4.47381794 C2.71905444,21.325718 6.45699,30.5034538 9.47660263,30.5034538 C18.4347945,30.5034538 22.7051399,4.47381794 31.5393692,4.47381794 C40.3735986,4.47381794 43.0978392,45.9109046 51.7764117,45.9109046 C60.4549841,45.9109046 61.5184294,18.9856821 72.4256626,18.9856821 C83.3328957,18.9856821 84.1887902,68.1108873 100,58.1393831 C100,58.1393831 100,71.952538 100,99.5788479 L0,99.5788479 L0,4.47381794 Z';
					$paths[] = 'M0,0.525544757 C2.71905444,17.3774449 6.45699,30.5034538 9.47660263,30.5034538 C18.4347945,30.5034538 20.3684444,4.47381794 29.2026738,4.47381794 C38.0369031,4.47381794 43.0978392,40.7584783 51.7764117,40.7584783 C60.4549841,40.7584783 62.5501441,20.3422677 73.4573773,20.3422677 C84.3646105,20.3422677 84.1887902,59.1439085 100,49.1724043 C100,49.1724043 100,65.9745522 100,99.5788479 L0,99.5788479 L0,0.525544757 Z';
					break;
				default:
					$paths[] = '';
			}

			$svg  = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 '.$width.' '.$height.'" preserveAspectRatio="none">';
			foreach( $paths as $path ) {
				$svg .= '<path d="'.$path.'" fill="'.$color.'"></path>';
			}
			$svg .= '</svg>';

			$left = $style === 'notch-bottom' ? '<div class="left" style="background-color:'.esc_attr($color).'"></div>' : '';
			$right = $style === 'notch-bottom' ? '<div class="right" style="background-color:'.esc_attr($color).'"></div>' : '';

			$output = '<div class="wtbx-section-decoration wtbx-decoration-'.$style.'">'.$left.$svg.$right.'</div>';

			if ( !$return ) {
				echo '<div class="wtbx-section-decoration wtbx-decoration-'.$style.'">'.$left.$svg.$right.'</div>';
			}
		}

		return $output;
	}
}



if ( ! function_exists( 'wtbx_scroll_down_button' ) ) {
	function wtbx_scroll_down_button( $style = '', $skin = 'light' ) {
		if ( $style !== '' ) {
		    $icon = '';
			if ( strpos($style, 'arrow-single') !== false ) {
				$icon = '<span></span>';
			} else if ( strpos($style, 'arrow-label') !== false ) {
				$icon = '<span></span>' . esc_html__('scroll', 'scape');
			} else if ( strpos($style, 'angle-down') !== false ) {
				$icon = '<span></span>';
			} else if ( strpos($style, 'angle-down-cont') !== false ) {
				$icon = '<span></span>';
			} else if ( strpos($style, 'angles-down') !== false ) {
				$icon = '<span></span>';
			} else if ( strpos($style, 'mouse-simple') !== false ) {
				$icon = '<span></span>';
			} else if ( strpos($style, 'mouse-label') !== false ) {
				$icon = '<i class="scape-ui-Wireless-Mouse" aria-hidden="true"></i>' . esc_html__('scroll down', 'scape');
			}

			echo '<div class="wtbx-scrolldown-button scrolldown-'.$style.' wtbx-skin-'.$skin.'">'.$icon.'</div>';
		}
	}
}



if ( ! function_exists( 'wtbx_navigation' ) ) {
	function wtbx_navigation($custom_query = false) {
		global $paged, $wp_query;

		if ( $custom_query && $custom_query !== '' ) {
			$wp_query = $custom_query;
		}

		// Don't print empty markup if there's only one page.
		if ($wp_query->max_num_pages < 2) {
			return;
		}

		$pagination_args = array(
			'prev_next' => false,
			'total' => $wp_query->max_num_pages,
			'current' => max( 1, get_query_var('paged') ),
			'type' => 'array',
		);
		$paginate_links = wtbx_paginate_links($pagination_args);

		if ( !$paged ) {
			$paged = 1;
        }
		$nextpage = intval($paged) + 1;
		$prevpage = intval($paged) - 1;


		if (is_array($paginate_links)) {
			$output = "<ul class='wtbx-pagination-inner clearfix'>";
			$prev = get_previous_posts_link('');
			if ($prev !== NULL) $output .= '<li class="page-prev page-numbers" data-page="'.esc_attr($prevpage).'">' . $prev . '</li>';

			$output .= '<div class="wtbx-nav-pages wtbx-pagination-pages">';
			foreach ($paginate_links as $pages => $page) {
				$output .= $page;
			}
			$output .= '</div>';

			$next = get_next_posts_link('');
			if ($next !== NULL) $output .= '<li class="page-next page-numbers" data-page="'.esc_attr($nextpage).'">' . $next . '</li>';
			$output .= "</ul>";
		}

		return $output;
	}
}



function wtbx_paginate_links($args = '') {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );

	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$defaults = array(
		'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format'             => $format, // ?page=%#% : %#% is replaced by the page number
		'total'              => $total,
		'current'            => $current,
		'aria_current'       => 'page',
		'show_all'           => false,
		'prev_next'          => true,
		'prev_text'          => esc_html__( '&laquo; Previous', 'scape' ),
		'next_text'          => esc_html__( 'Next &raquo;', 'scape' ),
		'end_size'           => 1,
		'mid_size'           => 2,
		'type'               => 'plain',
		'add_args'           => array(), // array of query args to add
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => '',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! is_array( $args['add_args'] ) ) {
		$args['add_args'] = array();
	}

	// Merge additional query vars found in the original URL into 'add_args' array.
	if ( isset( $url_parts[1] ) ) {
		// Find the format argument.
		$format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
		$format_query = isset( $format[1] ) ? $format[1] : '';
		wp_parse_str( $format_query, $format_args );

		// Find the query args of the requested URL.
		wp_parse_str( $url_parts[1], $url_query_args );

		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		foreach ( $format_args as $format_arg => $format_arg_value ) {
			unset( $url_query_args[ $format_arg ] );
		}

		$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
	}

	// Who knows what else people pass in $args
	$total = (int) $args['total'];
	if ( $total < 2 ) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}
	$add_args = $args['add_args'];
	$r = '';
	$page_links = array();
	$dots = false;

	if ( $args['prev_next'] && $current && 1 < $current ) :
		$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current - 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $args['add_fragment'];

		/**
		 * Filters the paginated links for the given archive pages.
		 *
		 * @since 3.0.0
		 *
		 * @param string $link The paginated link URL.
		 */
		$page_links[] = '<a class="prev page-numbers" data-page="'.esc_attr($current-1).'" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['prev_text'] . '</a>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = "<span aria-current='" . esc_attr( $args['aria_current'] ) . "' class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );
				$link .= $args['add_fragment'];

				/** This filter is documented in wp-includes/general-template.php */
				$page_links[] = "<a class='page-numbers' data-page='".esc_attr($n)."' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
				$dots = true;
            elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<span class="page-numbers dots">' . esc_html__( '&hellip;', 'scape' ) . '</span>';
				$dots = false;
			endif;
		endif;
	endfor;
	if ( $args['prev_next'] && $current && $current < $total ) :
		$link = str_replace( '%_%', $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current + 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $args['add_fragment'];

		/** This filter is documented in wp-includes/general-template.php */
		$page_links[] = '<a class="next page-numbers" data-page="'.esc_attr($current+1).'" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['next_text'] . '</a>';
	endif;
	switch ( $args['type'] ) {
		case 'array' :
			return $page_links;

		case 'list' :
			$r .= "<ul class='page-numbers'>\n\t<li>";
			$r .= join("</li>\n\t<li>", $page_links);
			$r .= "</li>\n</ul>\n";
			break;

		default :
			$r = join("\n", $page_links);
			break;
	}
	return $r;
}



function wtbx_portfolio_meta_content($meta, $postID, $class, $link = false) {
	$output = $link_class = '';

	if ( $meta === 'title'|| $meta === 'title_link' ) {
		if ( $link ) {
			$output .= '<a href="'. esc_url( get_the_permalink() ).'" rel="bookmark">';
			$link_class = ' meta-link';
		}
		$output .= '<h3 class="entry-title'.$link_class.' '.esc_attr($class).'">'.get_the_title().'</h3>';
		if ( $link ) {
			$output .= '</a>';
		}
	} elseif ( $meta === 'categories' || $meta === 'categories_link' ) {
		if ( $link ) {
			$terms = wp_get_post_terms( $postID, 'portfolio_category');
			$categories = array();

			$output .= '<div class="entry-meta meta-category '.esc_attr($class).'">';
				$output .= '<div class="category-list">';
					foreach ($terms as $term) {
						$categories[] = '<a class="meta-link" href="'.esc_url(get_term_link($term->slug, 'portfolio_category')).'">'.esc_html($term->name).'</a>';
					}
					if ( !empty($categories) ) {
						$categories = implode(', ', $categories);
						$output .= $categories;
					}
				$output .= '</div>';
			$output .= '</div>';
		} else {
			$output .= '<p class="entry-meta '.$class.'">';
			$terms = get_the_terms($postID, 'portfolio_category');
			if ( !empty($terms) ) {
				$categories = array();
				foreach ($terms as $term) {
					$categories[] = $term->name;
				}
				$output .= implode(', ', $categories);
				$output .= '</p>';
			}
		}
	} elseif ( get_post_meta($postID, 'portfolio-detail-' . $meta, true) ) {
		$output .= '<p class="entry-meta '.esc_attr($class).'">' . str_replace("<br />", ", ", nl2br(esc_html(get_post_meta($postID, 'portfolio-detail-' . $meta, true)))) . '</p>';
	} else {
		$output .= '<p class="entry-meta '.esc_attr($class).'"></p>';
	}

	return $output;
}



function wtbx_portfolio_meta_caption($meta, $postID) {
	$output = '';

	if ( $meta === 'title' ) {
		$output .= get_the_title();
	} elseif ( $meta === 'categories' ) {
		$terms = get_the_terms($postID, 'portfolio_category');
		if ( !empty($terms) ) {
			$categories = array();
			foreach ( $terms as $term ) {
				$categories[] = $term->name;
			}
			$output .= implode(', ', $categories);
		}
	} elseif ( get_post_meta($postID, 'portfolio-detail-' . $meta, true) ) {
		$output .= get_post_meta($postID, 'portfolio-detail-' . $meta, true);
	}

	return $output;
}



function wtbx_portfolio_link($postID, $click_action, $caption_primary = '', $caption_secondary = '', $share = '') {
	$type_escaped = $poster = $title = $share_url = '';
	$imgID          = get_post_thumbnail_id($postID);
	$alt            = get_the_title($postID);
	$item_layout    = get_post_meta($postID, 'portfolio-item-media', true);

	if ($imgID) {
		$metadata = wp_get_attachment_metadata( $imgID );
		$ratio = $metadata['width'] . ':' . $metadata['height'];
	}

	// unique gallery ID
	$lightbox_item_id = '';
	if ( in_array($click_action, array('gallery_item', 'preview') )) {
		$lightbox_item_id = hexdec(substr(uniqid(), 6, 7));
	}

	// caption meta
	$caption_primary_escaped = $caption_secondary_escaped = '';
	if ( $click_action === 'gallery_all' || $click_action === 'gallery_item' ) {
		if ( $caption_primary !== '' ) {
			$caption_primary = wtbx_portfolio_meta_caption($caption_primary, $postID);

			if ( $caption_primary !== '' ) {
				$caption_primary_escaped = ' data-caption-primary="'.esc_attr($caption_primary).'"';
			}
		}
		if ( $caption_secondary !== '' ) {
			$caption_secondary = wtbx_portfolio_meta_caption($caption_secondary, $postID);

			if ( $caption_secondary !== '' ) {
				$caption_secondary_escaped = ' data-caption-secondary="'.esc_attr($caption_secondary).'"';
			}
		}
	}

	if ( $click_action === 'link' ) : ?>
		<a class="portfolio-overlay-trigger" href="<?php the_permalink(); ?>" rel="bookmark"><i class="scape-ui-link"></i></a>
	<?php elseif ( $click_action === 'gallery_all' ) :
		$type_escaped = '';
		$share_url = '';
		if ( $item_layout === 'video' ) {
			$video_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-video-selfhosted', true));
			$url = '';
			if ( $video_selfhosted !== '' ) {
				$url = $video_selfhosted;
				$type_escaped = ' data-video="1"';
			} elseif ( get_post_meta($postID, 'portfolio-item-video-youtube', true) ) {
				$url = '//www.youtube.com/watch?v=' . esc_attr(get_post_meta($postID, 'portfolio-item-video-youtube', true));
				$type_escaped = ' data-iframe="1"';
			} elseif ( get_post_meta($postID, 'portfolio-item-video-vimeo', true) ) {
				$url = '//vimeo.com/' . esc_attr(get_post_meta($postID, 'portfolio-item-video-vimeo', true));
				$type_escaped = ' data-iframe="1"';
			}
			$share_url = $url;
		} elseif ( $item_layout === 'audio' ) {
			$audio_embed = get_post_meta($postID, 'portfolio-item-audio-embed', true);
			$audio_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted', true));
			$url = '';

			if ( $audio_selfhosted !== '' ) {
				$url    = $audio_selfhosted;
				$title  = $audio_selfhosted !== '' ? get_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ))->post_title : '';
				$type_escaped   = ' data-audio="1"';
				$share_url = $url;
			} else if ( strpos($audio_embed, 'spotify') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
				$url    = '//embed.spotify.com/?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
				$type_escaped   = ' data-iframe="1"';
				$share_url = '//open.spotify.com/embed?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
			} elseif ( strpos($audio_embed, 'soundcloud') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
				$url    = '//w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true)) . '&auto_play=false&show_artwork=true&visual=true';
				$type_escaped   = ' data-iframe="1"';
				$share_url = '//w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
			} else {
				$url    = '';
			}
		} else {
			$url = wp_get_attachment_image_url( $imgID, 'full' );
			$share_url = $url;
		}

		if ( $share === 'link' ) {
			$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
		} elseif ( $share === 'media' ) {
			$data_share_escaped = ' data-share="'.esc_url($share_url).'"';
		} else {
			$data_share_escaped = '';
		}

		?>
		<a class="portfolio-overlay-trigger wtbx-lightbox-item"
			<?php // This variable does not contain unescaped dynamic data - see lines: 736, 743, 746, 749, 760, 764, 768 ?>
            <?php echo $type_escaped; ?>
           href="<?php echo esc_url($url); ?>"
            <?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
           data-title="<?php echo esc_attr($title); ?>"
           data-poster="<?php echo esc_attr( wp_get_attachment_image_url( get_post_meta($postID, 'portfolio-item-audio-thumbnail_id', 1 ), 'full' )); ?>"
           data-thumbimage="<?php echo esc_url(wp_get_attachment_image_url( $imgID, 'medium' )); ?>"
			<?php // These variables have been safely escaped on lines: 721, 728, 779, 781, 783 ?>
            <?php echo $caption_primary_escaped, $caption_secondary_escaped, $data_share_escaped; ?>>
			<i class="scape-ui-maximize"></i>
		</a>
	<?php elseif ( $click_action === 'gallery_item' ) :
		$type_escaped = '';
		// get portfolio item layout
		$attachments = $images = array();
		// get attached images
		if ( in_array($item_layout, array('slider', 'carousel', 'gallery-vertical', 'gallery-grid', 'gallery-masonry')) ) {
			$images = get_post_meta( $postID, 'portfolio-item-add-images', 1 );
			foreach ( (array) $images as $imgID => $imgURL ) {
				$attachments[] = array(
					'src'   => wp_get_attachment_image_url( $imgID, 'full' ),
					'thumb' => wp_get_attachment_image_url( $imgID, 'medium' ),
				);
			}
		} else {
			$sections = get_post_meta( $postID, 'portfolio-item-section', true );
			if ( !empty($sections) ) {
				foreach ( (array) $sections as $key => $entry ) {
					if ( isset( $entry['portfolio-item-section-image_id'] ) ) {
						$imgID = $entry['portfolio-item-section-image_id'];
						$images[] = $imgID;
						$attachments[] = array(
							'src'   => wp_get_attachment_image_url( $imgID, 'full' ),
							'thumb' => wp_get_attachment_image_url( $imgID, 'medium' ),
						);
					}
				}
			}
		}
		if (!empty($attachments)) :
			if ( $share === 'link' ) {
				$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
			} else {
				$data_share_escaped = '';
			}
			?>
			<a class="portfolio-overlay-trigger wtbx-lightbox-item"
                <?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
               data-dynamic="1"
               data-dynamicel="<?php echo esc_attr(json_encode($attachments)); ?>"
                <?php echo wtbx_lightbox_attributes(); ?>
               data-id="<?php echo esc_attr($lightbox_item_id); ?>"
				<?php // These variables have been safely escaped on lines: 721, 728, 829, 831 ?>
                <?php echo $caption_primary_escaped, $caption_secondary_escaped, $data_share_escaped; ?>>
                <i class="scape-ui-grid"></i>
			</a>
		<?php elseif ( $item_layout === 'video' ) :
			$iframe_url = '';
			$video_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-video-selfhosted', true));
			if ( $video_selfhosted !== '' ) {
				$iframe_url = $video_selfhosted;
				$type_escaped = ' data-video="1"';
			} elseif ( get_post_meta($postID, 'portfolio-item-video-youtube', true) ) {
				$iframe_url = '//www.youtube.com/watch?v=' . esc_attr(get_post_meta($postID, 'portfolio-item-video-youtube', true));
				$type_escaped = ' data-iframe="1"';
			} elseif ( get_post_meta($postID, 'portfolio-item-video-vimeo', true) ) {
				$iframe_url = '//vimeo.com/' . esc_attr(get_post_meta($postID, 'portfolio-item-video-vimeo', true));
				$type_escaped = ' data-iframe="1"';
			}

			if ( $share === 'link' ) {
				$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
			} elseif ( $share === 'media' ) {
				$data_share_escaped = ' data-share="'.esc_url($iframe_url).'"';
			} else {
				$data_share_escaped = '';
			}
			?>

			<a class="portfolio-overlay-trigger wtbx-lightbox-item"
				<?php // This variable does not contain unescaped dynamic data - see lines: 800, 849, 852, 855 ?>
                <?php echo $type_escaped; ?>
               data-dynamic="1"
                <?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
               data-dynamicel="<?php echo esc_attr($iframe_url); ?>"
				<?php // These variables have been safely escaped on lines: 721, 728, 859,861, 863 ?>
                <?php echo $caption_primary_escaped, $caption_secondary_escaped, $data_share_escaped; ?>>
				<i class="scape-ui-grid"></i>
			</a>

		<?php elseif ( $item_layout === 'audio' ) :
			$audio_embed = get_post_meta($postID, 'portfolio-item-audio-embed', true);
			$audio_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted', true));

			if ( $audio_selfhosted !== '' ) {
				$iframe_url = $audio_selfhosted;
				$title      = $audio_selfhosted !== '' ? get_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ))->post_title : '';
				$type_escaped = ' data-audio="1"';
				$share_url  = $iframe_url;
			} else if ( strpos($audio_embed, 'spotify') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
				$iframe_url = '//embed.spotify.com/?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
				$type_escaped = ' data-iframe="1"';
				$share_url  = '//open.spotify.com/embed?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
			} elseif ( strpos($audio_embed, 'soundcloud') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
				$iframe_url = '//w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true)) . '&auto_play=false&show_artwork=true&visual=true';
				$type_escaped = ' data-iframe="1"';
				$share_url  = '//w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
			} else {
				$iframe_url = '';
			}

			if ( $share === 'link' ) {
				$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
			} elseif ( $share === 'media' ) {
				$data_share_escaped = ' data-share="'.esc_url($share_url).'"';
			} else {
				$data_share_escaped = '';
			}
			?>

			<a class="portfolio-overlay-trigger wtbx-lightbox-item"
				<?php // This variable does not contain unescaped dynamic data - see lines: 885, 889, 893 ?>
                <?php echo $type_escaped; ?>
               data-dynamic="1"
                <?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
               data-title="<?php echo esc_attr($title); ?>"
               data-poster="<?php echo esc_attr( wp_get_attachment_image_url( get_post_meta($postID, 'portfolio-item-audio-thumbnail_id', 1 ), 'full' )); ?>"
               data-dynamicel="<?php echo esc_attr($iframe_url); ?>"
				<?php // These variables have been safely escaped on lines: 721, 728, 900, 902, 904 ?>
                <?php echo $caption_primary_escaped, $caption_secondary_escaped, $data_share_escaped; ?>>
				<i class="scape-ui-grid"></i>
			</a>

		<?php else : ?>
			<a class="portfolio-overlay-trigger" href="<?php the_permalink(); ?>" rel="bookmark"></a>
		<?php endif; ?>

	<?php elseif ( $click_action === 'preview' ) : ?>
		<div class="portfolio-overlay-trigger wtbx-preview-trigger" data-postid="<?php echo esc_attr($postID); ?>"></div>
	<?php endif;
}



// Slider Revolution Theme Mode
if ( function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'wtbx_revslider_theme_mode' );
	function wtbx_revslider_theme_mode() {
		set_revslider_as_theme();
	}
}



// trim and filter excerpt
if ( ! function_exists( 'wtbx_excerpt' ) ) {
	function wtbx_excerpt($length = '', $rm_text = '') {
		global $post;

		if ($rm_text !== '') {
			if (wtbx_option('post-list-readmore') === 'default') {
				$rm_text = esc_html__('Read more', 'scape');
			} else if (wtbx_option('post-list-readmore') === 'custom') {
				$rm_text = wtbx_option('post-list-readmore-custom');
			}
			$rm_text = '<div class="read-more-wrap"><div class="read-more"><a class="more-link" href="' . esc_url( get_permalink($post->ID) ) . '" title="' . esc_html__('Continue reading: ', 'scape') . esc_attr(get_the_title($post->ID)) . '">' . esc_html($rm_text) . '</a></div></div>';
		}

		$more = '...';

		if ( has_excerpt($post->ID) ) {
			$excerpt = get_the_excerpt($post->ID) . $rm_text;
		} else {
//			$text = do_shortcode($post->post_content);
			$text = get_the_content();
			$text = apply_filters( 'the_content', $text );
			$text = str_replace( ']]>', ']]&gt;', $text );

			if ( $length !== '' ) {
				$excerpt = wp_trim_words($text, $length, $more) . $rm_text;
			} else {
			    $excerpt = $text . $rm_text;
            }
		}
		return $excerpt;
	}
}



if ( ! function_exists( 'wtbx_font_styling_static' ) ) {
    function wtbx_font_styling_static( $value, $is_object = true ) {
	    return wtbx_font_styling( $value, $is_object );
    }
}



// Font typography style
if ( ! function_exists( 'wtbx_font_styling' )) {
	function wtbx_font_styling( $value, $is_object = true ) {
		$css    = '';
		$styles = array();

		if ( $is_object ) {
			$font = $value;
		} else {
			$font = wtbx_option_sub($value, 'typography');
		}
		$font = !empty($font) ? json_decode($font, true) : '';

		$theme_fonts    = wtbx_option_sub('custom_fonts', 'fonts');
		$theme_fonts    = !empty($theme_fonts) ? json_decode($theme_fonts, true) : '';
		$theme_fonts    = isset($theme_fonts['fonts']) ? $theme_fonts['fonts'] : '';

		if ( $font !== '' ) {
			$id             = isset($font['font_family']) ? $font['font_family'] : '';
			$backup         = isset($font['backup_family']) ? $font['backup_family'] : '';
			$variants       = isset($font['variants']) ? $font['variants'] : '';
			$transform      = isset($font['transform']) ? $font['transform'] : '';
			$font_size      = isset($font['font_size']) ? $font['font_size'] : '';
			$line_height    = isset($font['line_height']) ? $font['line_height'] : '';
			$letter_spacing = isset($font['letter_spacing']) ? $font['letter_spacing'] : '';


			if ( $variants !== '' ) {
				if ( strpos($variants, '_italic') !== false ) {
					$styles = explode('_', $variants);
				} else {
					$styles[] = $variants;
				}
			}

			if ( $theme_fonts !== '' ) {
				$family  = isset($theme_fonts[$id]['family']) ? "'".esc_html($theme_fonts[$id]['family'])."'" : '';
				$family .= !empty($family) && !empty($backup) ? ', ' : '';
				$family .= $backup !== '' ? $backup : '';
				$css    .= $family !== '' ? ' font-family: ' .  $family . ';' : '';
			}

			$css .= $font_size !== '' ? ' font-size: ' .  esc_html($font_size) . ';' : '';
			$css .= isset($styles[0]) ? ' font-weight: ' .  esc_html($styles[0]) . ';' : '';
			$css .= isset($styles[1]) ? ' font-style: ' .  esc_html($styles[1]) . ';' : '';
			$css .= $line_height !== '' ? ' line-height: ' .  esc_html(str_replace('em', '', $line_height)) . ';' : '';
			$css .= $transform !== '' ? ' text-transform: ' .  esc_html($transform) . ';' : '';
			$css .= $letter_spacing !== '' ? ' letter-spacing: ' .  esc_html($letter_spacing) . ';' : '';

		}

		$all_variants = false;
		if ( in_array($value, wtbx_get_full_variants_typo()) ) {
			$all_variants = true;
		}

		wtbx_fonts_enqueue($font, $all_variants);

		return $css;

	}
}



/*
 * Returns only fonts size from the typography array
 */

function wtbx_font_size( $value ) {
    $size = '';
    $font = wtbx_option_sub($value, 'typography');
	$font = !empty($font) ? json_decode($font, true) : '';

	if ( $font !== '' && isset($font['font_size']) ) {
		$size = intval($font['font_size']);
	}

	return $size;
}



/*
 * Returns array of header layouts
 */
if ( ! function_exists( 'wtbx_header_layouts' ) ) {
	function wtbx_header_layouts() {
		$headers = array(
			'1' => esc_html__('Header style 1', 'scape')
		);

		return $headers;
	}
}



/*
 * Prints dynamic styles to the footer
 */
function wtbx_add_footer_styles() {

	//adding scripts file in the footer
	wp_register_script( 'scape-main-js', apply_filters('scape_main_js_path', WTBX_URI . '/library/js/app.js') , wtbx_script_queue(), SCAPE_VERSION, true );

	// Media player sprite
	if ( class_exists('SCAPE_Core_Extend') ) {
		wtbx_localize_main_js('wtbxMediaPlayer', array(
			'iconUrl' => trailingslashit(WTBX_PLUGIN_URL) . 'assets/images/plyr.svg'
		));
	}

	wp_enqueue_style( 'scape-style-custom' );

	wp_enqueue_script( 'scape-main-js' );

	if ( wtbx_footer_js_styles(false, true) !== '' ) {
	    $css = wtbx_footer_js_styles(false, true);
		wtbx_localize_main_js('wtbx_dynamic_styles', array(
			'css' => $css
		) );
    }

	wtbx_localize_main_js('', '', true);

}



/*
 * Returns array of header menu zones for menu builder
 */
if ( ! function_exists( 'wtbx_menu_builder_zones' ) ) {
	function wtbx_menu_builder_zones($style) {

		$output = array(
			'style_1' => array(
				'topbar' => array(
					'slug'  => 'topbar',
					'label' => esc_html__('Top bar', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Header', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'main'  => array(
							'label' => esc_html__('Main menu area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'bottombar' => array(
					'slug'  => 'bottombar',
					'label' => esc_html__('Bottom bar', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
			),
			'style_3' => array(
				'topbar' => array(
					'slug'  => 'topbar',
					'label' => esc_html__('Top bar', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'bottombar' => array(
					'slug'  => 'bottombar',
					'label' => esc_html__('Bottom bar', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Header', 'scape'),
					'areas' => array(
						'main'  => array(
							'label' => esc_html__('Main menu area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				)
			),
			'style_5' => array(
				'topbar' => array(
					'slug'  => 'topbar',
					'label' => esc_html__('Top bar', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Header', 'scape'),
					'areas' => array(
						'main'   => array(
							'label' => esc_html__('Main menu area', 'scape'),
						),
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'right'         => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
			),
			'style_6' => array(
				'topbar' => array(
					'slug'  => 'topbar',
					'label' => esc_html__('Top bar', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Header', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'main'   => array(
							'label' => esc_html__('Main menu area', 'scape'),
						),
						'right'         => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
			),
			'style_7' => array(
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Header', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'main'  => array(
							'label' => esc_html__('Main menu (hidden) area', 'scape'),
						),
						'right_idle' => array(
							'label' => esc_html__('Right (visible) area', 'scape'),
						),
						'right_hidden'  => array(
							'label' => esc_html__('Right (hidden) area', 'scape'),
						)
					)
				),
			),
			'style_8' => array(
				'topbar' => array(
					'slug'  => 'topbar',
					'label' => esc_html__('Top bar', 'scape'),
					'areas' => array(
						'left'  => array(
							'label' => esc_html__('Left area', 'scape'),
						),
						'right' => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Header', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'main'   => array(
							'label' => esc_html__('Main menu area', 'scape'),
						),
						'right'         => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
			),
			'style_10' => array(
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Idle section', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'right'     => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'overlay' => array(
					'slug'  => 'overlay',
					'label' => esc_html__('Overlay section', 'scape'),
					'areas' => array(
						'header'  => array(
							'label' => esc_html__('Overlay header area', 'scape'),
							'restrict' => 'sidearea,overlay,language,login,login_alt,border'
						),
						'main'      => array(
							'label' => esc_html__('Overlay main menu area', 'scape'),
							'restrict' => 'sidearea,overlay,language,login,login_alt,border'
						),
						'footer'   => array(
							'label' => esc_html__('Overlay footer area', 'scape'),
							'restrict' => 'sidearea,overlay,language,login,login_alt,border'
						)
					)
				),
			),
			'style_11' => array(
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Idle section', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'right'     => array(
							'label' => esc_html__('Right area', 'scape'),
						)
					)
				),
				'overlay' => array(
					'slug'  => 'overlay',
					'label' => esc_html__('Overlay section', 'scape'),
					'areas' => array(
						'header'  => array(
							'label' => esc_html__('Overlay header area', 'scape'),
							'restrict' => 'sidearea,overlay,language,login,login_alt,border'
						),
						'main'      => array(
							'label' => esc_html__('Overlay main menu area', 'scape'),
							'restrict' => 'sidearea,overlay,language,login,login_alt,border'
						),
						'footer'   => array(
							'label' => esc_html__('Overlay footer area', 'scape'),
							'restrict' => 'sidearea,overlay,language,login,login_alt,border'
						)
					)
				),
			),
			'style_12' => array(
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Top', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
					)
				),
				'main' => array(
					'slug'  => 'main',
					'label' => esc_html__('Main', 'scape'),
					'areas' => array(
						'main'  => array(
							'label' => esc_html__('Main menu area', 'scape'),
							'restrict' => 'sidearea,overlay'
						)
					)
				),
				'footer' => array(
					'slug'  => 'footer',
					'label' => esc_html__('Footer', 'scape'),
					'areas' => array(
                        'middle_inline'  => array(
                            'label' => esc_html__('Footer area (inline)', 'scape'),
                            'restrict' => 'sidearea,overlay'
                        ),
						'middle'  => array(
							'label' => esc_html__('Footer area (stacked)', 'scape'),
							'restrict' => 'sidearea,overlay'
						),
					)
				),
			),
			'style_13' => array(
				'header' => array(
					'slug'  => 'header',
					'label' => esc_html__('Top', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
					)
				),
				'main' => array(
					'slug'  => 'main',
					'label' => esc_html__('Main', 'scape'),
					'areas' => array(
						'main'  => array(
							'label' => esc_html__('Main menu area', 'scape'),
							'restrict' => 'sidearea,overlay'
						)
					)
				),
				'footer' => array(
					'slug'  => 'footer',
					'label' => esc_html__('Footer', 'scape'),
					'areas' => array(
						'bottom'  => array(
							'label' => esc_html__('Footer area', 'scape'),
							'restrict' => 'sidearea,overlay'
						)
					)
				),
			),
			'style_mobile' => array(
				'top_header' => array(
					'slug'  => 'top_header',
					'label' => esc_html__('Top header', 'scape'),
					'areas' => array(
						'logo'  => array(
							'label'     => esc_html__('Logo', 'scape'),
						),
						'right'     => array(
							'label'     => esc_html__('Idle area', 'scape'),
							'restrict'  => 'sidearea,overlay'
						)
					)
				),
				'header' => array(
					'slug'  => 'header',
					'label' => '',
					'areas' => array(
						'top'  => array(
							'label' => esc_html__('Top header area', 'scape'),
							'restrict' => 'sidearea,overlay'
						)
					)
				),
				'main' => array(
					'slug'  => 'main',
					'label' => esc_html__('Side navigation', 'scape'),
					'areas' => array(
						'main'  => array(
							'label' => esc_html__('Main menu area', 'scape'),
							'restrict' => 'sidearea,overlay'
						)
					)
				),
				'footer' => array(
					'slug'  => 'footer',
					'label' => '',
					'areas' => array(
						'bottom_inline'  => array(
							'label' => esc_html__('Footer area (inline)', 'scape'),
							'restrict' => 'sidearea,overlay'
						),
						'bottom_stack'  => array(
							'label' => esc_html__('Footer area (stacked)', 'scape'),
							'restrict' => 'sidearea,overlay'
						)
					)
				),
			),
		);

		return $output[$style];

	}
}



/*
 * Returns array of header elements for menu builder
 */
if ( ! function_exists( 'wtbx_menu_builder_elements' ) ) {
	function wtbx_menu_builder_elements() {

		$menus = wp_get_nav_menus();
		$menu_array = array(
			'menu' => array(
				'label' => esc_html__('Menus', 'scape'),
				'items' => array()
			)
		);

		foreach ( $menus as $menu ) {
			$menu_array['menu']['items'][$menu->slug]['id'] = 'menu';
			$menu_array['menu']['items'][$menu->slug]['nav'] = $menu->slug;
			$menu_array['menu']['items'][$menu->slug]['label'] = $menu->name;
		}

		$output =  $menu_array
		+ array(
			'button' => array(
				'label' => esc_html__('Buttons', 'scape'),
				'items' => array(
					'search'  => array(
						'id' => 'search',
						'label' => esc_html__('Search button', 'scape')
					),
					'search_alt'  => array(
						'id' => 'search_alt',
						'label' => esc_html__('Search button alt', 'scape')
					),
					'sidearea'  => array(
						'id' => 'sidearea',
						'label' => esc_html__('Sidearea button', 'scape')
					),
					'overlay'  => array(
						'id' => 'overlay',
						'label' => esc_html__('Overlay button', 'scape')
					),
					'button_primary'  => array(
						'id' => 'button_primary',
						'label' => esc_html__('Primary button', 'scape')
					),
					'button_secondary'  => array(
						'id' => 'button_secondary',
						'label' => esc_html__('Secondary button', 'scape')
					),
				)
			),
			'widget' => array(
				'label' => esc_html__('Widgets', 'scape'),
				'items' => array(
					'search_field'  => array(
						'id' => 'search_field',
						'label' => esc_html__('Search field', 'scape')
					),
					'social'  => array(
						'id' => 'social',
						'label' => esc_html__('Social icons', 'scape')
					),
					'login'  => array(
						'id' => 'login',
						'label' => esc_html__('Login', 'scape')
					),
					'login_alt'  => array(
						'id' => 'login_alt',
						'label' => esc_html__('Login alt', 'scape')
					),
					'language'  => array(
						'id' => 'language',
						'label' => esc_html__('Language switch', 'scape')
					),
					'language_alt'  => array(
						'id' => 'language_alt',
						'label' => esc_html__('Language switch alt', 'scape')
					),
				)
			),
			'woocommerce' => array(
				'label' => esc_html__('WooCommerce', 'scape'),
				'items' => array(
					'cart'  => array(
						'id' => 'cart',
						'label' => esc_html__('Cart', 'scape')
					),
					'cart_alt'  => array(
						'id' => 'cart_alt',
						'label' => esc_html__('Cart alt', 'scape')
					),
					'wishlist'  => array(
						'id' => 'wishlist',
						'label' => esc_html__('Wishlist', 'scape')
					),
					'wishlist_alt'  => array(
						'id' => 'wishlist_alt',
						'label' => esc_html__('Wishlist alt', 'scape')
					),
				)
			),
			'misc' => array(
				'label' => esc_html__('Miscellaneous', 'scape'),
				'items' => array(
                    'text'  => array(
                        'id' => 'text',
                        'label' => esc_html__('Text info', 'scape')
                    ),
					'content_block'  => array(
						'id' => 'content_block',
						'label' => esc_html__('Content block', 'scape')
					),
					'space'  => array(
						'id' => 'space',
						'label' => esc_html__('Space', 'scape')
					),
					'border'  => array(
						'id' => 'border',
						'label' => esc_html__('Border', 'scape')
					),
				),
			)
		);

		return $output;

	}
}



/*
 * Displays login form
 */
if ( ! function_exists( 'wtbx_login_form' ) ) {
	function wtbx_login_form() {
		$args = array(
			'form_id' => 'wtbx_loginform',
			'label_username' => '',
			'label_password' => '',
		);

		add_filter('login_form_top', 'wtbx_login_form_top');

		if (class_exists('WTBX_Login_Widget') && class_exists('SCAPE_Core_Extend')) {
			$args = array(
				'label_log_in' => esc_html__('Sign in', 'scape'),
				'label_username' => esc_html__( 'Username / Email', 'scape' ),
				'label_lost_password' => esc_html__('Forgot password?', 'scape'),
			);
			$wtbx_login_widget = new WTBX_Login_Widget();
			$wtbx_login_widget->wp_login_form($args);
		} else {
			wp_login_form($args);
		}
	}
}

if ( ! function_exists( 'wtbx_login_form_top' ) ) {
	function wtbx_login_form_top() {
		echo '<h3 class="wtbx_login_form_title">' . esc_html__('Sign in', 'scape') . '</h3>';
		$content_block = wtbx_option('login-form-content-before');
		if ( !empty($content_block) ) {
			$content_block = wtbx_get_translated_content_block($content_block);
			$s_ID = get_post($content_block);
			if ( isset($s_ID->post_content) ) {
				$content = $s_ID->post_content;
			} else {
				$content = '';
			}
			echo apply_filters('the_content', $content);
		}
	}
}

if ( ! function_exists( 'wtbx_layout_settings' ) ) {
	function wtbx_layout_settings() {
		$wtbx_layout = array();
		$wtbx_layout['fullwidth']                = wtbx_option_levelled('page-layout-fullwidth');
        $wtbx_layout['content_limit']            = wtbx_option_levelled('page-layout-width-limit');
		$wtbx_layout['fullwidth']                = $wtbx_layout['fullwidth'] !== '' ? ' ' . $wtbx_layout['fullwidth'] : '';
		$wtbx_layout['sidebar']                  = wtbx_option_levelled('page-layout');
		$wtbx_layout['sidebar_css']              = '';
		$wtbx_layout['sidebar_sticky']           = '';
		$wtbx_layout['sidebar_skin']             = '';
		$wtbx_layout['side_padding']             = wtbx_option_levelled('page-layout-content-padding-side') === '1' ? '' : 'no-side-padding';
		$wtbx_layout['sidebar_widgetarea']       = '';

		if ( in_array( $wtbx_layout['sidebar'], array('sidebar_left', 'sidebar_left_sticky', 'sidebar_right', 'sidebar_right_sticky') ) ) {
			$wtbx_layout['sidebar_width']        = wtbx_option_levelled('page-layout-sidebar-width-slider');
			$wtbx_layout['sidebar_padding']      = wtbx_option_levelled('page-layout-sidebar-padding');
			$wtbx_layout['sidebar_sticky']       = (strpos($wtbx_layout['sidebar'], 'sticky') !== false) ? ' wtbx-sticky' : '';
			$wtbx_layout['sidebar_widgetarea']   = wtbx_option_levelled('page-layout-sidebar-widgetarea');
			$wtbx_layout['sidebar_skin']         = wtbx_option_levelled('page-layout-sidebar-skin');
			$wtbx_layout['sidebar_font']         = wtbx_option_levelled('page-layout-sidebar-font-size', 'typography');

			if ( $wtbx_layout['sidebar_skin'] !== '' ) {
				$wtbx_layout['sidebar_skin']     = ' wtbx_skin_'.$wtbx_layout['sidebar_skin'];
			}

		} else {
			$wtbx_layout['sidebar_width']        = '';
		}

		if ( wtbx_demo() ) {
			if ( isset($_GET['layout']) && $_GET['layout'] === 'shop-sidebar-left' ) {
				$wtbx_layout['sidebar'] = 'sidebar_left_sticky';
				$wtbx_layout['sidebar_width'] = wtbx_option_levelled('page-layout-sidebar-width-slider');
				$wtbx_layout['sidebar_sticky'] = ' wtbx-sticky';
				$wtbx_layout['sidebar_widgetarea'] = 'wtbx_sidebar_1481353117873378';
			} elseif ( isset($_GET['layout']) && $_GET['layout'] === 'shop-sidebar-right' ) {
				$wtbx_layout['sidebar'] = 'sidebar_right_sticky';
				$wtbx_layout['sidebar_width'] = wtbx_option_levelled('page-layout-sidebar-width-slider');
				$wtbx_layout['sidebar_sticky'] = ' wtbx-sticky';
				$wtbx_layout['sidebar_widgetarea'] = 'wtbx_sidebar_1481353117873378';
			} elseif ( isset($_GET['layout']) && $_GET['layout'] === 'shop-no-sidebar' ) {
				$wtbx_layout['sidebar'] = 'no_sidebar';
				$wtbx_layout['sidebar_width'] = '';
				$wtbx_layout['sidebar_sticky'] = '';
				$wtbx_layout['sidebar_widgetarea'] = '';
			}

			if ( isset($_GET['col']) && ( $_GET['col'] === '2' || $_GET['col'] === '3' ) ) {
				$wtbx_layout['sidebar'] = 'sidebar_left';
				$wtbx_layout['sidebar_width'] = '360';
				$wtbx_layout['sidebar_sticky'] = '';
				$wtbx_layout['sidebar_widgetarea'] = 'wtbx_sidebar_1481353117873378';
			}
		}

		if ( $wtbx_layout['sidebar_sticky'] ===' wtbx-sticky' ) {
			wtbx_script_queue('sticky-kit');
        }

		return $wtbx_layout;
	}
}



if ( ! function_exists( 'wtbx_add_widget_styles' ) ) {
	function wtbx_add_widget_styles($text) {
	    wp_enqueue_style('scape-widgets');
		return $text;
	}
}



if ( ! function_exists( 'wtbx_add_comment_styles' ) ) {
	function wtbx_add_comment_styles() {
		wp_enqueue_style('scape-comments');
	}
}



// search page filter
if ( ! function_exists( 'wtbx_search_filter' ) ) {
	function wtbx_search_filter($query) {
		if ( !is_admin() && is_search() && isset($_GET['post_type']) ) {
			$post_type = $_GET['post_type'];
			if (!$post_type) {
				$post_type = 'any';
			}
			if ($query->is_search) {
				$query->set('post_type', $post_type);
			};
		}
		return $query;
	}
}



// maintenance page redirect
if ( ! function_exists( 'wtbx_maintenance_redirect' ) ) {
	function wtbx_maintenance_redirect($original_template) {
		$is_redirect_active = wtbx_option('maintenance-mode');
		if ( $is_redirect_active === '1' && !is_user_logged_in() && function_exists( 'wtbx_set_503_header' ) ) {
			wtbx_set_503_header();
			return get_template_directory() . '/maintenance-page.php';
		}
		return $original_template;
	}
}



// get the list of available sidebars
if ( ! function_exists( 'wtbx_available_sidebars' ) ) {
	function wtbx_available_sidebars() {
		return wtbx_option('page-layout-sidebar-widgetareas');
	}
}



// output breadcrumbs
if ( ! function_exists( 'wtbx_breadcrumbs' ) ) {
	function wtbx_breadcrumbs() {

		$breadcrumbs = '';
		if (wtbx_option('header-section-bc-enable-global') === '1') {
			$bc_separator = wtbx_option('header-section-bc-separator');
			switch ($bc_separator) {
				case 'slash':
					$bc_separator = '/';
					break;
				case 'angle':
					$bc_separator = '<span class="wtbx-separator-angle"></span>';
					break;
				case 'circle':
					$bc_separator = '<span class="wtbx-separator-circle"></span>';
					break;
				default:
					$bc_separator = '/';
			}

			$breadcrumbs .= '<div class="wtbx-page-breadcrumbs">';
			$breadcrumbs .= '<div class="row-inner clearfix">';
			$breadcrumbs .= '<div class="wtbx-col-sm-12">';
			$breadcrumbs .= wtbx_bc_plus(array(
				'echo' => false,
				'separator' => $bc_separator
			));
			$breadcrumbs .= '</div>';
			$breadcrumbs .= '</div>';
			$breadcrumbs .= '</div>';
		}

		return $breadcrumbs;
	}
}



// output overlay content for portfolio square and tiles layouts
if ( ! function_exists( 'wtbx_portfolio_overlay_content' ) ) {
	function wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout) {
		if ( $overlay_content !== '' ) {
			if ( $click_action === 'link' ) {
				$overlay_content = '<i class="scape-ui-link"></i>';
			} else {
				if ( $item_layout === 'audio' ) {
					$overlay_content = '<i class="scape-ui-play"></i>';
				} elseif ( $item_layout === 'video' ) {
					$overlay_content = '<i class="scape-ui-play"></i>';
				} else {
					$overlay_content = '<i class="scape-ui-maximize"></i>';
				}
			}
		}

		return $overlay_content;
	}
}



// output the like button
if ( ! function_exists( 'wtbx_get_simple_likes_button' ) ) {
	function wtbx_get_simple_likes_button($post_id, $filled = false) {
	    if ( class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) {
		    return get_simple_likes_button( $post_id, $filled );
        }
	}
}



/*
 * Returns array of available sidebars
 */
function wtbx_sidebars_array_ext() {
	$data = array();
	$data['none'] = esc_html__('Disable', 'scape');
	global $wp_registered_sidebars;
	foreach ( $wp_registered_sidebars as $key => $value ) {
		$data[ $key ] = $value['name'];
	}
	return $data;
}



// Post query filters for navigation
function wtbx_get_adjacent_post_where_filter( $where ) {
	$where .= " AND pj.meta_key = 'navigation-parent' AND pj.meta_value = '" . wtbx_nav_parent() . "'";
	return $where;
}

function wtbx_get_adjacent_post_join_filter( $join ) {
	global $wpdb;
	$join .= " INNER JOIN {$wpdb->postmeta} AS pj ON p.ID = pj.post_id";
	return $join;
}



// Global fonts enqueue
if ( ! function_exists( 'wtbx_fonts_enqueue' ) ) {
	function wtbx_fonts_enqueue($font_object, $all_variants = false) {
		WtbxFontsEnqueue::addFont($font_object, $all_variants);
	}
}


// Pass attributes for custom cursor to frontend
if ( ! function_exists( 'wtbx_custom_cursor_atts' ) ) {
	function wtbx_custom_cursor_atts() {
		if ( class_exists('WTBX_Mobile_Detect') ) {
			$detect = new WTBX_Mobile_Detect;
			if ( !$detect->isMobile() && wtbx_option('cursor-enable') === '1' ) {

				$primary_color = wtbx_option_sub('cursor-color-primary', 'rgba');
				$secondary_color = wtbx_option_sub('cursor-color-secondary', 'rgba');

				if ( empty($primary_color) ) { $primary_color = wtbx_option('color-main-accent'); }
				if ( empty($secondary_color) ) { $secondary_color = wtbx_option('color-main-accent'); }

				wtbx_localize_main_js('wtbxCustomCursor', array(
					'cursorStyle' => wtbx_option('cursor-style'),
					'cursorColorPrimary' => esc_html($primary_color),
					'cursorColorSecondary' => esc_html($secondary_color),
				));
			}
        }
	}
}



// Dynamic styles
if ( ! function_exists( 'wtbx_js_styles' ) ) {
    function wtbx_js_styles($styles) {
        $output = false;

	    if ( function_exists('wtbx_footer_js_styles') ) {
		    wtbx_footer_js_styles($styles);
	    }

	    return $output;
    }
}



// Returns GDPR noconsent placeholder for media
if ( ! function_exists( 'wtbx_noconsent_content' ) ) {
	function wtbx_noconsent_content($type, $poster = '', $bg = false) {
	    $output = '';
	    $icon = wtbx_noconsent_icons();

        $output .= '<div class="wtbx-gdpr-noconsent-wrapper'. ($bg ? ' wtbx-gdpr-noconsent-bg' : '') .'" data-type="'.esc_attr($type).'">';
		$output .= '<div class="wtbx-gdpr-noconsent-poster">';
		if ( $poster !== '' ) {
			if ( $bg ) {
				$output .= 	wtbx_image_smart_crop($poster, 'large', 'full', false, wtbx_get_alt_text($poster), '', true, '');
			} else {
				$output .= 	wtbx_image_smart_img($poster, 'large', 'full', wtbx_get_alt_text($poster), '', true, '');
			}
        }
        $output .= '</div>';
		if ( !$bg ) {
			$output .= '<div class="wtbx-gdpr-noconsent-content">';
			$output .= '<div class="wtbx-gdpr-noconsent-inner">';

			$output .= '<div class="wtbx-gdpr-noconsent-icon">';
			$output .= $icon[$type];
			$output .= '</div>';

			$output .= '<div class="wtbx-gdpr-noconsent-text">';
			$output .= wtbx_noconsent_text();
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</div>';
        }

		$output .= '</div>';

		return $output;
	}
}



// Returns placeholder text when no consent is received for this type of media
if ( ! function_exists( 'wtbx_noconsent_text' ) ) {
	function wtbx_noconsent_text() {
		return wp_kses_post('This content is blocked, please review your <a href="#" class="gdpr-preferences">Privacy Preferences</a>');
	}
}



// Returns placeholder text when no consent is received for this type of media
if ( ! function_exists( 'wtbx_noconsent_icons' ) ) {
	function wtbx_noconsent_icons() {
		return array(
			'soundcloud' => '<svg enable-background="new 0 0 300 300" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg"><path d="m14.492 208.896c.619 0 1.143-.509 1.232-1.226l3.365-26.671-3.355-27.278c-.1-.717-.623-1.23-1.242-1.23-.635 0-1.176.524-1.26 1.23l-2.941 27.278 2.941 26.662c.084.716.625 1.235 1.26 1.235z"/><path d="m3.397 198.752c.608 0 1.101-.473 1.19-1.18l2.608-16.574-2.608-16.884c-.09-.685-.582-1.18-1.19-1.18-.635 0-1.127.495-1.217 1.19l-2.18 16.875 2.18 16.569c.09.701.582 1.184 1.217 1.184z"/><path d="m27.762 148.644c-.08-.867-.715-1.5-1.503-1.5-.782 0-1.418.633-1.491 1.5l-2.811 32.355 2.811 31.174c.073.862.709 1.487 1.491 1.487.788 0 1.423-.625 1.503-1.487l3.18-31.174z"/><path d="m38.152 214.916c.922 0 1.668-.759 1.758-1.751l3.005-32.156-3.005-33.258c-.09-.999-.836-1.749-1.758-1.749-.935 0-1.692.751-1.756 1.754l-2.656 33.253 2.656 32.156c.064.993.821 1.751 1.756 1.751z"/><path d="m50.127 215.438c1.074 0 1.936-.86 2.025-2.011l-.01.008 2.83-32.426-2.83-30.857c-.08-1.132-.941-2.005-2.016-2.005-1.09 0-1.947.873-2.012 2.014l-2.502 30.849 2.502 32.418c.066 1.15.923 2.01 2.013 2.01z"/><path d="m67.132 181.017-2.655-50.172c-.074-1.272-1.065-2.286-2.281-2.286-1.207 0-2.195 1.013-2.269 2.286l-2.35 50.172 2.35 32.418c.074 1.278 1.063 2.278 2.269 2.278 1.217 0 2.207-1 2.281-2.278v.009z"/><path d="m74.386 215.766c1.339 0 2.45-1.111 2.513-2.529v.021l2.482-32.233-2.482-61.656c-.063-1.418-1.174-2.529-2.513-2.529-1.37 0-2.471 1.111-2.545 2.529l-2.185 61.656 2.195 32.222c.064 1.408 1.165 2.519 2.535 2.519z"/><path d="m86.645 111.435c-1.508 0-2.725 1.238-2.787 2.799l-2.033 66.801 2.033 31.884c.063 1.553 1.279 2.783 2.787 2.783 1.504 0 2.73-1.22 2.783-2.788v.016l2.307-31.895-2.307-66.801c-.053-1.571-1.28-2.799-2.783-2.799z"/><path d="m99.01 215.766c1.656 0 2.975-1.336 3.037-3.056v.019l2.133-31.693-2.133-69.045c-.063-1.714-1.381-3.056-3.037-3.056-1.666 0-3.005 1.342-3.031 3.056l-1.916 69.045 1.916 31.693c.026 1.701 1.365 3.037 3.031 3.037z"/><path d="m111.477 215.734c1.787 0 3.237-1.463 3.291-3.318v.029l1.963-31.404-1.963-67.289c-.054-1.854-1.504-3.311-3.291-3.311-1.8 0-3.25 1.456-3.303 3.311l-1.725 67.289 1.736 31.389c.042 1.841 1.492 3.304 3.292 3.304z"/><path d="m129.359 181.041-1.777-64.836c-.043-2-1.609-3.571-3.551-3.571-1.947 0-3.514 1.571-3.555 3.584l-1.594 64.823 1.594 31.198c.041 1.984 1.607 3.556 3.555 3.556 1.941 0 3.508-1.572 3.551-3.585v.029z"/><path d="m136.682 215.853c2.064 0 3.773-1.717 3.805-3.828v.017l1.613-30.984-1.613-77.153c-.031-2.119-1.74-3.833-3.805-3.833-2.063 0-3.767 1.722-3.809 3.844l-1.434 77.111 1.434 31.016c.042 2.093 1.746 3.81 3.809 3.81z"/><path d="m149.291 92.814c-2.229 0-4.037 1.849-4.074 4.103l-1.667 84.151 1.677 30.526c.027 2.225 1.836 4.068 4.064 4.068 2.195 0 4.037-1.844 4.047-4.105v.037l1.82-30.526-1.82-84.151c-.01-2.262-1.852-4.103-4.047-4.103z"/><path d="m160.82 215.882c.09.008 101.623.056 102.275.056 20.385 0 36.904-16.722 36.904-37.357 0-20.624-16.52-37.349-36.904-37.349-5.059 0-9.879 1.034-14.275 2.907-2.922-33.671-30.815-60.077-64.842-60.077-8.318 0-16.429 1.662-23.593 4.469-2.788 1.09-3.534 2.214-3.556 4.392v118.539c.032 2.29 1.778 4.193 3.991 4.42z"/></svg>',
			'spotify' => '<svg height="168" viewBox="0 0 168 168" width="168" xmlns="http://www.w3.org/2000/svg"><path d="m83.996.277c-46.249 0-83.743 37.493-83.743 83.742 0 46.251 37.494 83.741 83.743 83.741 46.254 0 83.744-37.49 83.744-83.741 0-46.246-37.49-83.738-83.745-83.738l.001-.004zm38.404 120.78c-1.5 2.46-4.72 3.24-7.18 1.73-19.662-12.01-44.414-14.73-73.564-8.07-2.809.64-5.609-1.12-6.249-3.93-.643-2.81 1.11-5.61 3.926-6.25 31.9-7.291 59.263-4.15 81.337 9.34 2.46 1.51 3.24 4.72 1.73 7.18zm10.25-22.805c-1.89 3.075-5.91 4.045-8.98 2.155-22.51-13.839-56.823-17.846-83.448-9.764-3.453 1.043-7.1-.903-8.148-4.35-1.04-3.453.907-7.093 4.354-8.143 30.413-9.228 68.222-4.758 94.072 11.127 3.07 1.89 4.04 5.91 2.15 8.976zm.88-23.744c-26.99-16.031-71.52-17.505-97.289-9.684-4.138 1.255-8.514-1.081-9.768-5.219-1.254-4.14 1.08-8.513 5.221-9.771 29.581-8.98 78.756-7.245 109.83 11.202 3.73 2.209 4.95 7.016 2.74 10.733-2.2 3.722-7.02 4.949-10.73 2.739z"/></svg>',
			'youtube' => '<svg enable-background="new 0 0 96.875 96.875" viewBox="0 0 96.875 96.875" width="96.875" xmlns="http://www.w3.org/2000/svg"><path d="m95.201 25.538c-1.186-5.152-5.4-8.953-10.473-9.52-12.013-1.341-24.172-1.348-36.275-1.341-12.105-.007-24.266 0-36.279 1.341-5.07.567-9.281 4.368-10.467 9.52-1.688 7.337-1.707 15.346-1.707 22.9s0 15.562 1.688 22.898c1.184 5.151 5.396 8.952 10.469 9.52 12.012 1.342 24.172 1.349 36.277 1.342 12.107.007 24.264 0 36.275-1.342 5.07-.567 9.285-4.368 10.471-9.52 1.689-7.337 1.695-15.345 1.695-22.898 0-7.554.014-15.563-1.674-22.9zm-59.265 37.936c0-10.716 0-21.32 0-32.037 10.267 5.357 20.466 10.678 30.798 16.068-10.3 5.342-20.504 10.631-30.798 15.969z"/></svg>',
			'vimeo' => '<svg enable-background="new 0 0 430.118 430.118" viewBox="0 0 430.118 430.118" width="430.118" xmlns="http://www.w3.org/2000/svg"><path d="m367.243 28.754c-59.795-1.951-100.259 31.591-121.447 100.664 10.912-4.494 21.516-6.762 31.858-6.762 21.804 0 31.455 12.237 28.879 36.776-1.278 14.86-10.911 36.482-28.879 64.858-18.039 28.423-31.513 42.61-40.464 42.61-11.621 0-22.199-21.958-31.857-65.82-3.239-12.918-9.031-45.812-17.324-98.765-7.775-49.046-28.32-71.962-61.727-68.741-14.132 1.299-35.302 14.241-63.556 38.734-20.613 18.724-41.498 37.453-62.726 56.163l20.225 26.112c19.303-13.562 30.595-20.311 33.731-20.311 14.802 0 28.625 23.219 41.488 69.651 11.53 42.644 23.158 85.23 34.744 127.812 17.256 46.466 38.529 69.708 63.552 69.708 40.473 0 90.028-38.065 148.469-114.223 56.537-72.909 85.725-130.352 87.694-172.341 2.595-56.115-18.29-84.851-62.66-86.125z"/></svg>'
		);
	}
}