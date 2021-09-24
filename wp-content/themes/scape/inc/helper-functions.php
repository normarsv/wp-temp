<?php

// get image sizes
if ( !function_exists( 'wtbx_get_image_sizes' ) ){
	function wtbx_get_image_sizes() {
		$sizes = wtbx_option('site-image-sizes');
		if ($sizes === '') $sizes = '180,450,750,1170,1440,1920,2880';
		$sizes = preg_replace('/\s+/', '', $sizes);
		$sizes = explode(',', $sizes);
		return $sizes;
	}
}



// create image sizes attribute
if ( !function_exists( 'wtbx_create_sizes' ) ){
	function wtbx_create_sizes($sizes, $size, $image_src, $image_meta, $attachment_id) {
		if ( !wtbx_option('site-smartimage')) {
			$theme_sizes = wtbx_get_image_sizes();
			$max_width = '';
			$sizes = '';

			foreach( $theme_sizes as $theme_size ) {
				$sizes .= '(max-width: ' . $theme_size . 'px) '. $theme_size . 'px, ';
				$max_width = $theme_size;
			}

			$metadata = wp_get_attachment_metadata( $attachment_id );
			$width = isset($metadata['width']) ? $metadata['width'] : $max_width;
			$sizes .= $width . 'px';
		}
		return $sizes;
	}
}
add_filter( 'wp_calculate_image_sizes', 'wtbx_create_sizes', 10 , 5 );



// HEX to RGB
function wtbx_hex2rgb($hex) {
	$output = '';
	if ( strpos($hex, '#') !== false ) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		$output = implode(",", $rgb);
	}

	return $output; // returns the rgb values separated by commas
}


// HEX to RGBA (array)
function wtbx_hex2rgba_array($hex, $opacity = '1') {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgba = array($r, $g, $b, $opacity);
	return $rgba;
}



// RGBA to array
function wtbx_rgba2array($rgba) {
	if ( strpos($rgba, 'rgba') !== false ) {
		$rgba = str_replace(array('rgba(', ')', ' '), '', $rgba);
	} else {
		$rgba = str_replace(array('rgb(', ')', ' '), '', $rgba);
	}
	$array = explode(',', $rgba);
	return $array;
}



// RGBA to HEX
function wtbx_rgba2hex($rgb) {
	$rgb = wtbx_rgba2array($rgb);
	$color = sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
	return $color;
}



// Grid entry animations array
if ( ! function_exists( 'wtbx_grid_animations' ) ) {
	function wtbx_grid_animations() {
		$animations = wtbx_vc_grid_animations();
		$opts = array();

		foreach ( $animations as $key => $value ) {
			$opts[$value] = $key;
		}

		return $opts;
	}
}



if ( ! function_exists( 'wtbx_reading_time' ) ) {
	function wtbx_reading_time($postID, $full = true) {
		$post_content = get_the_content($postID);
		$words = str_word_count( strip_tags( $post_content ) );
		$minutes = floor( $words / 120 );
		$seconds = floor( $words % 120 / ( 120 / 60 ) );
		$short = esc_html__('Min','scape');

		if ( 1 < $minutes ) {
			$reading_time = $minutes . ' ' . ( $full === true ? esc_html__('Minutes','scape') : $short );
		} else {
			$reading_time = '1 '  . ( $full === true ? esc_html__('Minute','scape') : $short );
		}

		return $reading_time;
	}
}



if ( ! function_exists( 'wtbx_get_attachment_id_by_url' ) ) {
	function wtbx_get_attachment_id_by_url( $url ) {
		// Split the $url into two parts with the wp-content directory as the separator
		$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
		// Get the host of the current site and the host of the $url, ignoring www
		$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
		$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
		// Return nothing if there aren't any $url parts or if the current host and $url host do not match
		if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
			return;
		}
		// Now we're going to quickly search the DB for any attachment GUID with a partial path match
		// Example: /uploads/2013/05/test-image.jpg
		global $wpdb;
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );
		// Returns null if no attachment is found
		return $attachment[0];
	}
}



if ( ! function_exists( 'wtbx_args_to_html_attr' ) ) {
	function wtbx_args_to_html_attr($args) {
		$html = '';
		if ( !empty($args) ) {
			foreach ( $args as $key => $value ) {
				$html .= ' ' . $key . '="' . $value . '"';
			}
		}
		return $html;
	}
}



if ( ! function_exists( 'wtbx_get_the_title' ) ) {
	function wtbx_get_the_title($postID = false) {
		if ( !$postID ) {
			$postID = get_the_ID();
		}

		if ( class_exists('Woocommerce' ) && is_woocommerce() && !is_product() ) {
			$title = woocommerce_page_title(false);
		} elseif ( is_search() ) { // Search title
			$title = esc_html__('Search Results for: ', 'scape') . '<span class="wtbx-search-query">' . get_search_query() . '</span>';
		} elseif ( is_category() || is_tax() ) { // Category & taxonomy title
			$title = single_cat_title('', false);
		} elseif ( is_tag() ) { // Tag title
			$title = single_tag_title('', false);
		} elseif ( is_archive() ) { // Archive title
			if ( get_post_type() === 'portfolio' && is_post_type_archive() ) {
				$title = get_post_type_object('portfolio')->labels->name;
			} elseif (is_day()) {
				$title = get_the_date();
			} elseif (is_month()) {
				$title = get_the_date();
			} elseif (is_year()) {
				$title = get_the_date();
			} elseif (is_author()) {
				$title = get_the_author();
			} else {
				$title = esc_html__('Archives', 'scape');
			}
		} else {
			if ( is_front_page() && is_home() ) {
				$title = esc_html__('Blog', 'scape');
			} elseif ( is_home() ) {
				$title = single_post_title('', false);
			} else {
				$title = get_the_title($postID);
			}
		}

		return $title;
	}
}



if ( ! function_exists( 'wtbx_page_defaults' ) ) {
	function wtbx_page_defaults($read = true) {
		global $wtbx_page_defaults;

		if (!$read) {

			$defaults = array();

			$defaults['global_site_preloader'] = wtbx_option_levelled('preloader-site-style');
			$defaults['global_site_transition'] = wtbx_option('transition-site-style');
			$defaults['global_site_reveal'] = wtbx_option('preloader-site-reveal');
			$defaults['smoothscroll'] = wtbx_option('site-smoothscroll');

			if (wtbx_demo() && 13 === get_the_ID()) {
				$defaults['global_site_preloader'] = '17';
				$defaults['global_site_reveal'] = 'fade';
				$defaults['smoothscroll'] = false;

				wp_add_inline_style( 'scape-style-preloaders', '.wtbx-preloader-global .wtbx-preloader-17 #wtbx-preloader-counter {color: #eaeef6;' );
			}

			if ($defaults['smoothscroll'] == true) {
				wtbx_script_queue('smoothscroll');
			}

			if (wtbx_demo() && isset($_GET['transition']) && sanitize_text_field($_GET['transition']) === 'random') {
				$site_preloader = rand(1, 17);
				$site_reveal = rand(1, 6);
				$site_transition = rand(1, 9);

				while (in_array($site_preloader, array(10, 11))) {
					$site_preloader = rand(1, 17);
				}

				$site_reveal_styles = array(
					'fade', 'scale', 'slide_top', 'slide_bottom', 'slide_left', 'slide_right'
				);

				$site_transition_styles = array(
					'fade', 'fade_top', 'fade_bottom', 'fade_left', 'fade_right', 'slide_top', 'slide_bottom', 'slide_left', 'slide_right'
				);

				$defaults['global_site_preloader'] = strval($site_preloader);
				$defaults['global_site_reveal'] = strval($site_reveal_styles[$site_reveal - 1]);
				$defaults['global_site_transition'] = strval($site_transition_styles[$site_transition - 1]);

				if (wtbx_demo() && 17 === $site_preloader ) {
					wp_add_inline_style( 'scape-style-preloaders', '.wtbx-preloader-global .wtbx-preloader-17 #wtbx-preloader-counter {color: #eaeef6;' );
				}
			}

			$wtbx_page_defaults = $defaults;

		}

		return $wtbx_page_defaults;
	}
}



if ( ! function_exists( 'wtbx_get_the_id' ) ) {
	function wtbx_get_the_id() {
		global $post;
		$postID = null;

		if ( class_exists( 'Woocommerce' ) && is_shop() ) {
			$postID = wc_get_page_id('shop');
		} elseif ( class_exists( 'Woocommerce' ) && is_product_category() ) {
			$cat = get_queried_object();
			$postID = $cat->term_id;
		} elseif ( is_single() ) {
			$postID = $post->ID;
		}

		return $postID;
	}
}



function wtbx_option_base() {

	$base = get_post_type(wtbx_get_the_id());

	if ( is_404() ) {
		$base = '404';
	} elseif ( is_search() ) {
		$base = 'search';
	} elseif ( class_exists('Woocommerce') && (is_product_category() || is_product_tag() || is_shop()) ) {
		$base = 'shop';
	} elseif ( class_exists('Woocommerce') && is_product() ) {
	       $base = 'product';
	} elseif ( $base === 'post' ) {
		if ( is_archive() ) {
			$base  = 'blog';
		} elseif ( is_front_page() && is_home() ) {
			// Default homepage
			$base  = 'blog';
		} elseif ( is_front_page() ) {
			// static homepage
		} elseif ( is_home() ) {
			// blog page
			$base  = 'blog';
		}
	} elseif ( is_single() ) {
		$base .= '-item';
	}

	$post_type_array        = wtbx_post_type_array();
	$can_have_unique_type   = in_array($base, $post_type_array);

	if ( $can_have_unique_type ) {
			return $base;
	} else {
		return false;
	}
}



function wtbx_post_type_array() {
	$array  = array('404', 'search', 'blog', 'post', 'portfolio-item', 'portfolio', 'shop', 'product', 'page');
	$custom_array   = wtbx_option('custom-post-types');
	$new_custom_array = array();
	if ( !empty($custom_array) && is_array($custom_array) ) {

		foreach ( (array) $custom_array as $key => $id ) {
			$new_custom_array[] = $id;
			$new_custom_array[] = $id . '-item';
		}

		$array = array_merge($array, $new_custom_array);
	}

	return $array;
}



function wtbx_option_levelled($var = '', $sub = '', $def = '') {
	global $post;
	$postID  = is_singular() ? $post->ID : '';
	$var    .= '-';
	$base    = wtbx_option_base();
	$global  = 'global';
	$return  = '';


	if ( $sub === '' ) {
		$function = 'wtbx_option';
	} else {
		$function = 'wtbx_option_sub';
	}

	$single = get_post_meta($postID, $var.'single', 1);
	if ( $sub !== '' && isset($single[$sub]) ) {
		$single = $single[$sub];
	}

	if ( is_author() ) {
		$single = call_user_func_array( $function, array($var.'author',$sub) );
	}

	// if it's a slider field
	if ( strpos($var, 'slider') !== false ) {
		if ( get_post_meta($postID, $var.'single', 1) === '-1' ) {
			$single = '';
		}

		if ( call_user_func_array( $function, array($var.$base,$sub) ) === '-1' ) {
			$base = '';
		}
	}

	if ( !empty($single) || ( empty($single) && $single === '0' ) ) {
		// take option for this exact page
		$return = $single;
	} elseif ( $base !== false && call_user_func_array( $function, array($var.$base,$sub) ) !== '' ) {
		// take option for this post type
		$return = call_user_func_array( $function, array($var.$base,$sub) );
	} else {
		// take global option
		$return = call_user_func_array( $function, array($var.$global,$sub) );
	}

	$return = empty($return) ? $def : $return;

	return $return;
}



if ( ! function_exists( 'wtbx_recursive_delete_directory' ) ) {
	function wtbx_recursive_delete_directory($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir") wtbx_recursive_delete_directory($dir . "/" . $object); else unlink($dir . "/" . $object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
}



function wtbx_search_panel($data = false) {
	global $wtbx_search_panel;
	if ($data) { $wtbx_search_panel = true; }
	return $wtbx_search_panel;
}



function wtbx_overlay_panel($data = false) {
	global $wtbx_overlay_panel;
	if ($data) { $wtbx_overlay_panel = true; }
	return $wtbx_overlay_panel;
}



function wtbx_sidearea_panel($data = false) {
	global $wtbx_sidearea_panel;
	if ($data) { $wtbx_sidearea_panel = true; }
	return $wtbx_sidearea_panel;
}



function wtbx_is_archive($data = false) {
	global $wtbx_is_archive;
	if ($data) { $wtbx_is_archive = true; }
	return $wtbx_is_archive;
}



function wtbx_sticky_navbar($data = false) {
	global $wtbx_sticky_navbar;
	if ($data) { $wtbx_sticky_navbar = true; }
	return $wtbx_sticky_navbar;
}



function wtbx_social_button($data = false) {
	global $wtbx_social_button;
	if ($data) { $wtbx_social_button = true; }
	return $wtbx_social_button;
}



function wtbx_maintenance($data = false) {
	global $wtbx_maintenance;
	if ($data) { $wtbx_maintenance = true; }
	return $wtbx_maintenance;
}



function wtbx_footer_js_styles($styles = false, $print = false) {
	global $wtbx_footer_js_styles;
	if ($styles) { $wtbx_footer_js_styles .= $styles; }
	return $print ? $wtbx_footer_js_styles : '';
}



function wtbx_script_queue($script = false, $add = true) {
	global $wtbx_plugin_scripts;
	if ( empty($wtbx_plugin_scripts) ) {
		$wtbx_plugin_scripts = array();
	}
	if ($script) {
		$wtbx_plugin_scripts[] = $script;
	} else {
		if ($add) {
			$plugin_scripts = array(
				'jquery',
				'scape-waypoints',
				'lazyload',
				'hammer',
				'mousewheel',
				'slick',
				'flickity',
				'mega-menu',
				'imagesloaded',
			    'plyr'
			);

			$wtbx_plugin_scripts = array_merge($plugin_scripts, $wtbx_plugin_scripts);
		} else {
			wp_enqueue_script($script);
		}
	}

	return $wtbx_plugin_scripts;
}



function wtbx_localize_main_js( $object, $data, $add = false ) {
	global $wtbx_localize_main_js;

	if ( !$add ) {
		$wtbx_localize_main_js[$object] = $data;
	} else {
		foreach ( $wtbx_localize_main_js as $object => $data ) {
			wp_localize_script( 'scape-main-js', $object, $data );
		}
	}
}



function wtbx_demo($data = false) {
	global $wtbx_demo;
	if ($data) { $wtbx_demo = true; };
	return $wtbx_demo;
}



function wtbx_nav_parent($parent = false) {
	global $wtbx_nav_parent;
	if ($parent) $wtbx_nav_parent = $parent;
	add_filter( 'get_next_post_join', 'wtbx_get_adjacent_post_join_filter' );
	add_filter( 'get_previous_post_join', 'wtbx_get_adjacent_post_join_filter' );
	add_filter( 'get_next_post_where', 'wtbx_get_adjacent_post_where_filter' );
	add_filter( 'get_previous_post_where', 'wtbx_get_adjacent_post_where_filter' );
	return $wtbx_nav_parent;
}



function wtbx_is_page_editable() {
	$is_editable = false;
	if ( class_exists('SCAPE_Core_Extend') && wtbx_vc_is_page_editable() ) {
		$is_editable = wtbx_vc_is_page_editable();
	}
	return $is_editable;
}



function wtbx_get_font_weight_style($variant) {

	$weights    = wtbx_font_weights();
	$styles     = wtbx_font_styles();
	$return_arr = array(
		'weight' => '400',
		'style'  => 'normal'
	);

	if ( isset($variant) ) {
		foreach( $weights as $weight => $weight_opts ) {
			foreach( $weight_opts as $weight_opt ) {
				if ( preg_match('/'.$weight_opt.'/i', $variant) ) {
					$return_arr['weight'] = $weight;
					break 2;
				}
			}
		}

		foreach( $styles as $style => $style_opts ) {
			foreach( $style_opts as $style_opt ) {
				if ( preg_match('/'.$style_opt.'/i', $variant) ) {
					$return_arr['style'] = $style;
					break 2;
				}
			}
		}
	}

	return $return_arr;
}



function wtbx_typekit_variants() {
	return array(
		'n1' => '100',
		'n2' => '200',
		'n3' => '300',
		'n4' => '400',
		'n5' => '500',
		'n6' => '600',
		'n7' => '700',
		'n8' => '800',
		'n9' => '900',
		'i1' => '100 italic',
		'i2' => '200 italic',
		'i3' => '300 italic',
		'i4' => '400 italic',
		'i5' => '500 italic',
		'i6' => '600 italic',
		'i7' => '700 italic',
		'i8' => '800 italic',
		'i9' => '900 italic',
	);
}



function wtbx_font_weights() {
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



function wtbx_font_styles() {
	return array(
		'normal' => ['normal, regular'],
		'italic' => ['italic']
	);
}




if ( ! function_exists( 'wtbx_get_full_variants_typo' ) ) {
	function wtbx_get_full_variants_typo() {
		return array('typo-general', 'typo-h');
	}
}



function wtbx_preload_typekit_font() {
	$theme_fonts = wtbx_option('custom_fonts');
	$theme_fonts = !empty($theme_fonts['fonts']) ? json_decode($theme_fonts['fonts'], true) : '';
	$kitid = $theme_fonts['typekit_kitid'];

	if ( !empty($kitid) ) {?>
		<link rel="preload" href="//use.typekit.net/<?php echo esc_attr($kitid); ?>.css?ver=1" as="style" crossorigin>
	<?php }
}



if ( ! function_exists( 'wtbx_get_translated_content_block' ) ) {
	function wtbx_get_translated_content_block($post) {
		if ( class_exists('SitePress') ) {
			$post = apply_filters( 'wpml_object_id', $post, 'content_block', true );
		} elseif ( function_exists('pll__') ) {
		    if ( pll_get_post($post) !== false ) {
			    $post = pll_get_post($post);
            }
        }
		return $post;
	}
}



if ( ! function_exists( 'wtbx_allowed_iframe_html' ) ) {
	function wtbx_allowed_iframe_html() {
		global $wp_embed;
		$allowed = wp_kses_allowed_html( 'post' );
		$allowed['iframe'] = array(
			'align' => true,
			'width' => true,
			'height' => true,
			'frameborder' => true,
			'name' => true,
			'src' => true,
			'id' => true,
			'class' => true,
			'style' => true,
			'scrolling' => true,
			'marginwidth' => true,
			'marginheight' => true,
			'allowtransparency' => true,
			'autoplay' => true,
			'auto_play' => true,
			'show_teaser' => true
		);
		return $allowed;
	}
}



// Checks if GDPR plugin is active and consent is given
if ( ! function_exists( 'wtbx_has_consent' ) ) {
	function wtbx_has_consent($type) {
		if ( wtbx_demo() && defined('DOING_AJAX') && DOING_AJAX ) {
			return true;
		}

		if ( class_exists('GDPR') && $type !== '' && !has_consent($type) ) {
			return false;
		} else {
			return true;
		}
	}
}



if ( ! function_exists( 'wtbx_add_space_before' ) ) {
	function wtbx_add_space_before($text) {
		if ( $text !== '' && substr($text, 0, 1) !== ' ' ) {
			$text = ' ' . $text;
		}
		return $text;
	}
}