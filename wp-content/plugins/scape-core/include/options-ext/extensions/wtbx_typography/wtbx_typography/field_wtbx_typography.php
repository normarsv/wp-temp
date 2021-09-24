<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_wtbx_typography' ) ) {

	/**
	 * Main ReduxFramework_custom_field class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework_wtbx_typography extends ReduxFramework {

		/**
		 * Field Constructor.
		 *
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		function __construct( $field = array(), $value ='', $parent ) {

			$this->parent = $parent;
			$this->field = $field;
			$this->value = $value;

			if ( empty( $this->extension_dir ) ) {
				$this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
//				$this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
				$this->extension_url = plugin_dir_url( __FILE__ );
			}

			// Set default args for this field to avoid bad indexes. Change this to anything you use.
			$defaults = array(
				'options'           => array(),
				'stylesheet'        => '',
				'output'            => true,
				'enqueue'           => true,
				'enqueue_frontend'  => true
			);
			$this->field = wp_parse_args( $this->field, $defaults );

		}



		/**
		 * Field Render Function.
		 *
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function render() {

			// No errors please
			$defaults = array(
				'typography'    => '',
			);
			$this->value = wp_parse_args( $this->value, $defaults );

			$defaults = array(
				'font-family'       => true,
				'backup-family'     => true,
				'font-size'         => true,
				'line-height'       => true,
				'letter-spacing'    => true,
				'weight-style'      => true,
				'subsets'           => true,
				'transform'         => true,
				'preview'           => true

			);
			$this->field = wp_parse_args( $this->field, $defaults );

			$default_value = isset($this->field['default']['typography']) ? $this->field['default']['typography'] : '';
			$font_settings = !empty($this->value['typography']) ? $this->value['typography'] : $default_value;
			$font_settings = !empty($font_settings) ? json_decode($font_settings, true) : '';

			echo '<div class="wtbx_typography_wrapper">';
			echo '<input type="hidden" class="wtbx_typography_value" name="' . $this->field['name'] . $this->field['name_suffix'] . '[typography]" id="' . $this->parent->args['opt_name'] . '[' . $this->field['id'] . '][typography]" value="' . esc_attr($this->value['typography']) . '" />';
			echo '<div class="wtbx_typography_container clearfix">';

			$object         = $this->get_font_weight_style($this->get_theme_fonts());
			$has_typekit    = false;

			if ( !empty($object) ) {

				foreach ( (array) $object as $font_id => $font_details ) {
					if ( $font_details['type'] && isset($font_details['family']) && isset($font_details['name']) ) {
						$font_type  = $font_details['type'];
						$upload_dir = wp_upload_dir();
						$font_link  = '';

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
							$print_fonts  = '';
							$print_fonts .= '<script>jQuery(document).ready(function($) {';
							$print_fonts .= '$(\'<link href="'.esc_url($font_link).'" rel="stylesheet">\').appendTo("head");';
							$print_fonts .= '});</script>';
							wtbx_admin_fonts($font_id, $print_fonts);
						}
					}
				}
			}

			if ( $has_typekit ) {
				if ( isset($this->get_theme_fonts()['typekit_kitid']) ) {
					$typekit_kitid = $this->get_theme_fonts()['typekit_kitid'];
					wtbx_admin_fonts($has_typekit, '<script src="https://use.typekit.net/'.esc_attr($typekit_kitid).'.js"></script><script>try{Typekit.load({ async: true });}catch(e){}</script>');
				}
			}

			$params = $this->get_typography_fields();

			foreach ( $params as $param => $props ) {
				if ( $props['display'] === true ) {
					echo '<div class="wtbx_typography_param">';
					echo '<div class="wtbx_typography_label">' . esc_html($props['title']) . '</div>';
					echo '<select class="wtbx_typography_select" data-param="'.esc_attr($param).'">';
					foreach ( (array) $props['values'] as $key => $value ) {
						echo '<option value="'.esc_attr($key).'"' . (isset($font_settings[$param]) && (string) $key === $font_settings[$param] ? 'selected="selected"' : '' )  . '>'.esc_html($value).'</option>';
					}
					echo '</select>';
					echo '</div>';
				}
			}

			if ( $this->field['font-size'] === true ) {

				$font_size = isset($font_settings['font_size']) ? $font_settings['font_size'] : '';
				if ( strpos($font_size, 'em') !== false ) {
					$font_size_em = ' active';
					$font_size_px = '';
					$font_size_units = 'em';
				} else {
					$font_size_em = '';
					$font_size_px = ' active';
					$font_size_units = 'px';
				}

				// Font-size
				echo '<div class="wtbx_typography_param">';
				echo '<div class="wtbx_typography_label">' . esc_html__('Font size', 'core-extension') . '</div>';
				echo '<div class="wtbx_typography_param_wrap">';
				echo '<input type="text" class="wtbx_typography_input" data-param="font_size" data-units="'.$font_size_units.'" value="'.($font_size !== '' ? floatval($font_size) : '').'" />';
				echo '<div class="wtbx_typography_units">';
				echo '<div class="wtbx_typography_unit' . $font_size_px . '" data-units="px">px</div>';
				echo '<div class="wtbx_typography_unit' . $font_size_em . '" data-units="em">em</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}

			if ( $this->field['line-height'] === true ) {
				$line_height = isset($font_settings['line_height']) ? $font_settings['line_height'] : '';
				if ( strpos($line_height, 'em') !== false ) {
					$line_height_em = ' active';
					$line_height_px = '';
					$line_height_units = 'em';
				} else {
					$line_height_em = '';
					$line_height_px = ' active';
					$line_height_units = 'px';
				}

				echo '<div class="wtbx_typography_param">';
				echo '<div class="wtbx_typography_label">' . esc_html__('Line height', 'core-extension') . '</div>';
				echo '<div class="wtbx_typography_param_wrap">';
				echo '<input type="text" class="wtbx_typography_input" data-param="line_height" data-units="'.$line_height_units.'" value="'.($line_height !== '' ? floatval($line_height) : '').'" />';
				echo '<div class="wtbx_typography_units">';
				echo '<div class="wtbx_typography_unit' . $line_height_px . '" data-units="px">px</div>';
				echo '<div class="wtbx_typography_unit' . $line_height_em . '" data-units="em">em</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}

			if ( $this->field['letter-spacing'] === true ) {
				$letter_spacing = isset($font_settings['letter_spacing']) ? $font_settings['letter_spacing'] : '';
				if ( strpos($letter_spacing, 'em') !== false ) {
					$letter_spacing_em = ' active';
					$letter_spacing_px = '';
					$letter_spacing_units = 'em';
				} else {
					$letter_spacing_em = '';
					$letter_spacing_px = ' active';
					$letter_spacing_units = 'px';
				}

				echo '<div class="wtbx_typography_param">';
				echo '<div class="wtbx_typography_label">' . esc_html__('Letter spacing', 'core-extension') . '</div>';
				echo '<div class="wtbx_typography_param_wrap">';
				echo '<input type="text" class="wtbx_typography_input" data-param="letter_spacing" data-units="'.$letter_spacing_units.'" value="'.($letter_spacing !== '' ? floatval($letter_spacing) : '').'" />';
				echo '<div class="wtbx_typography_units">';
				echo '<div class="wtbx_typography_unit' . $letter_spacing_px . '" data-units="px">px</div>';
				echo '<div class="wtbx_typography_unit' . $letter_spacing_em . '" data-units="em">em</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';

				echo '</div>';
			}

			if ( $this->field['preview'] === true ) {
				echo '<div class="wtbx_typography_preview">';
				$preview_text = 'The sky was cloudless and of a deep dark blue.';
				echo '<div class="wtbx_typography_preview_inner">'.$preview_text.'</div>';
				echo '</div>';

			}

			echo '<div class="wtbx_typography_clear_wrapper"><div class="wtbx_typography_clear">' . esc_html__('Clear font settings', 'core-extension') . '</div></div>';

			echo '</div>';
			echo '</div>';

		}


		function get_theme_fonts() {
//			$fonts = wtbx_vc_option('custom_fonts');
//			$fonts = !empty($fonts['fonts']) ? json_decode($fonts['fonts'], true) : '';
			$fonts = $this->hideNonExistentFonts();
			return $fonts;
		}



		function hideNonExistentFonts() {
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



		function get_typography_fields() {
			$fonts = $this->get_theme_fonts();

			$params_array = array(
				'font_family'   => array(
					'title'     => 'Font family',
					'values'    => $this->get_theme_font_names($fonts),
					'display'   => $this->field['font-family']
				),
				'backup_family' => array(
					'title'     => 'Backup font family',
					'values'    => $this->get_standard_font_names(),
					'display'   => $this->field['backup-family']
				),
				'variants'  => array(
					'title'     => 'Font weight &amp; style',
					'values'    => '',
					'display'   => $this->field['weight-style']
				),
				'subsets'       => array(
					'title'     => 'Font subsets',
					'values'    => '',
					'display'   => $this->field['subsets']
				),
				'transform'     => array(
					'title'     => 'Text transform',
					'values'    => array(
						''              => esc_html__('Inherit', 'core-extension'),
						'capitalize'    => esc_html__('Capitalize', 'core-extension'),
						'uppercase'     => esc_html__('Uppercase', 'core-extension'),
						'lowercase'     => esc_html__('Lowercase', 'core-extension'),
						'none'          => esc_html__('None', 'core-extension'),
					),
					'display'   => $this->field['transform']
				),
			);

			return $params_array;
		}

		function get_theme_font_names($fonts) {
			$array = array();
			$array[''] = esc_html__('Inherit', 'core-extension');
			if ( !empty($fonts) && isset($fonts['fonts']) ) {
				foreach ( $fonts['fonts'] as $font => $details ) {
					$array[$details['id']] = $details['family'];
				}
			}
			return $array;
		}

		function get_standard_font_names() {
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

		function get_font_weight_style() {
			$fonts = $this->get_theme_fonts();
			$new_fonts = array();
			if ( !empty($fonts) ) {
				$new_fonts = $fonts['fonts'];
				foreach ( $new_fonts as $id => $details ) {
					if ( isset($details['variants']) ) {
						$variants = $details['variants'];
						$variants = $this->get_standardized_variants($variants);
						$new_fonts[$id]['variants'] = $variants;
					}
				}
			}
			return $new_fonts;
		}

		function get_standardized_variants($variants) {

			$weights    = $this->get_font_weights();
			$return_arr = array();
//			$return_arr[] = 'inherit';

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

		function get_font_weights() {
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



		/**
		 * Enqueue Function.
		 *
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function enqueue() {

			$extension = ReduxFramework_extension_wtbx_typography::getInstance();

			wp_enqueue_script(
				'redux-field-wtbx-typography-js',
				$this->extension_url . 'field_wtbx_typography.js',
				array( 'jquery' ),
				time(),
				true
			);

//			wp_enqueue_style(
//				'redux-field-wtbx-typography-css',
//				$this->extension_url . 'field_wtbx_typography.css',
//				time(),
//				true
//			);

			$localize_data = array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
				'object'  => json_encode($this->get_font_weight_style($this->get_theme_fonts()))
			);
			wp_localize_script( 'redux-field-wtbx-typography-js', 'wtbx_typography_field', $localize_data );

		}

		/**
		 * Output Function.
		 *
		 * Used to enqueue to the front-end
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function output() {

			if ( $this->field['enqueue_frontend'] ) {

			}

		}

	}
}