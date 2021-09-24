<?php

class WtbxFontsEnqueue {

	public static $fonts = array();
	public static $googlefonts = array();
	public static $font_variants = array();
	public static $font_subsets = array();
	protected static $enqueue_styles = array();



	public static function addFont( $font_object, $all_variants = false ) {
		$font_id        = '';
		$details        = array();
		$theme_fonts    = self::getThemeFonts();

		if ( !empty($theme_fonts) ) {
			$theme_fonts = $theme_fonts['fonts'];
			if ( $font_object !== '' && isset($font_object['font_family']) ) {

				$font_id = $font_object['font_family'];

				if ( isset($theme_fonts[$font_id]['type']) && $theme_fonts[$font_id]['type'] === 'google' ) {
					if ( !in_array( $font_id, self::$googlefonts ) ) {
						self::$googlefonts[$font_id] = $theme_fonts[$font_id]['name'];
					}
				} else {
					if ( !in_array( $font_id, self::$fonts ) ) {
						self::$fonts[$font_id] = '';
					}
				}

				if ( !isset(self::$font_variants[$font_id]) ) {
					self::$font_variants[$font_id] = [];
				}
				if ( $all_variants ) {
					if ( isset($theme_fonts[$font_id]['variants']) ) {
						foreach( $theme_fonts[$font_id]['variants'] as $variant ) {
							self::$font_variants[$font_id][] = $variant;
						}
					}
				} else {
					if ( isset($font_object['variants']) ) {
						if ( isset(self::$font_variants[$font_id]) && !in_array( $font_object['variants'], self::$font_variants[$font_id] ) ) {
							self::$font_variants[$font_id][] = $font_object['variants'];
						}
					}
				}

				if ( isset($theme_fonts[$font_id]['type']) && $theme_fonts[$font_id]['type'] === 'google' ) {
					if ( isset($font_object['subsets']) ) {
						if ( !isset(self::$font_subsets[$font_id]) ) {
							self::$font_subsets[$font_id] = [];
						}
						if ( isset(self::$font_subsets[$font_id]) && !in_array( $font_object['subsets'], self::$font_subsets[$font_id] ) ) {
							self::$font_subsets[$font_id][] = $font_object['subsets'];
						}
					}
				}
			}
		}

		return self::$fonts;
	}



	public static function themeFonts() {
		self::enqueueFonts();
	}



	protected static function glueFonts($fonts, $type) {
		$saved_fonts = get_option('scape_theme_footer_fonts');
		if ( !empty($saved_fonts[$type]) ) {
			$fonts = $saved_fonts[$type] + $fonts;
		}

		return $fonts;
	}



	protected static function enqueueFonts() {
		$fonts          = self::glueFonts(self::$fonts, 'fonts');
		$theme_fonts    = self::getThemeFonts();

		if ( !empty($theme_fonts) ) {
			$theme_fonts = $theme_fonts['fonts'];
			foreach ( $fonts as $font => $details ) {
				if ( isset($theme_fonts[$font]['type']) ) {
					call_user_func( 'WtbxFontsEnqueue::enqueueFont'.ucfirst($theme_fonts[$font]['type']), $theme_fonts[$font] );
				}
			}
			self::enqueueFontGoogle();
		}
	}



	protected static function getThemeFonts() {
		$fonts = wtbx_option('custom_fonts');
		$fonts = !empty($fonts['fonts']) ? json_decode($fonts['fonts'], true) : '';
		return $fonts;
	}



	protected static function enqueueFontCustom($font) {
		if ( isset($font['family']) && isset($font['name']) ) {
			$upload_dir = wp_upload_dir();
			$dir        = $upload_dir['baseurl'] . '/wtbx_custom_fonts/' . $font['name'] . '/stylesheet.css';
			wp_enqueue_style( 'wtbx-custom-font-' . str_replace(' ', '-', strtolower($font['family'])), $dir, array(), '', 'all' );
		}
	}



	protected static function enqueueFontFontsquirrel($font) {

		if ( isset($font['family']) && isset($font['name']) ) {
			$upload_dir = wp_upload_dir();
			$dir        = $upload_dir['baseurl'] . '/wtbx_custom_fonts/' . $font['name'] . '/' . $font['family'] . '.css';

			wp_enqueue_style( 'wtbx-fs-font-' . str_replace(' ', '-', strtolower($font['family'])), $dir, array(), '', 'all' );
		}

	}



	protected static function enqueueFontGoogle() {
		$google_fonts = self::glueFonts(self::$googlefonts, 'googlefonts');
		$font_variants = self::glueFonts(self::$font_variants, 'variants');
		$font_subsets = self::glueFonts(self::$font_subsets, 'subsets');

		$subsets_array = array();
		foreach ( $font_variants as $id => $subsets ) {
			foreach ( $subsets as $subset ) {
				if ( $subset !== '' )  {
					$subsets_array[] = $subset;
				}
			}
		}
		$subsets_array = array_unique($subsets_array);
		$subsets_str = !empty($subsets_array) ? '&subset=' . implode(',', $subsets_array) : '';

		if ( sizeof($subsets_array) <= 1 ) {
			$google_font_link = array();
			foreach ( $google_fonts as $font => $name ) {
				$variants = array();
				foreach ( $font_variants[$font] as $key => $value ) {
					$variants[] = str_replace('_', '', $value);
				}
				$variants = implode(',', $variants);
				$google_font_link[] = str_replace(' ', '+', $name) . ':' . $variants;
			}
			if ( !empty( $google_font_link ) ) {
				$google_font_link = implode( '|', $google_font_link ) . $subsets_str;
				wp_enqueue_style( 'wtbx-google-fonts', '//fonts.googleapis.com/css?family='. $google_font_link, array(), '', 'all' );
			}
		} else {
			foreach ( $google_fonts as $font => $name ) {
				$variants = array();
				if ( isset($font_variants[$font]) ) {
					foreach ( (array) $font_variants[$font] as $key => $value ) {
						$variants[] = str_replace('_', '', $value);
					}
				}

				$subsets_array = array();
				if ( isset($font_subsets[$font]) ) {
					foreach ( (array) $font_subsets[$font] as $key => $value ) {
						$subsets_array[] = $value;
					}
				}

				$subsets_str = !empty($subsets_array) ? '&subset=' . implode(',', $subsets_array) : '';

				$variants = implode(',', $variants);
				$google_font_link = str_replace(' ', '+', $name) . ':' . $variants . $subsets_str;

				wp_enqueue_style( 'wtbx-google-fonts-' . str_replace(' ', '-', strtolower($name)) , '//fonts.googleapis.com/css?family='. $google_font_link, array(), '', 'all' );
			}
		}

	}



	protected static function enqueueFontTypekit($font) {
		$theme_fonts = wtbx_option('custom_fonts');
		$theme_fonts = !empty($theme_fonts['fonts']) ? json_decode($theme_fonts['fonts'], true) : '';
		if ( isset($theme_fonts['typekit_kitid']) ) {
			wp_enqueue_style( 'typekit', '//use.typekit.net/'.esc_attr($theme_fonts['typekit_kitid']).'.css', 'scape-style', time(), 'all' );
		}
	}



	public static function hideNonExistentFonts() {
		$theme_fonts = self::getThemeFonts();
		if ( !empty($theme_fonts['fonts']) ) {
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


}