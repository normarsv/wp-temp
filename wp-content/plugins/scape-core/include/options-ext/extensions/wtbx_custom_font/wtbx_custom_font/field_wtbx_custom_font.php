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
if( !class_exists( 'ReduxFramework_wtbx_custom_font' ) ) {

	/**
	 * Main ReduxFramework_custom_field class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework_wtbx_custom_font extends ReduxFramework {

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

			// Remove unsaved custom fonts
			$this->removeUnsavedCustomFonts();

			// Get Google Fonts array
			$this->getGoogleArray();

			// Get Font Squirrel array
			$this->getFontSquirrelArray();

		}

		function removeUnsavedCustomFonts() {
			// No errors please
			$defaults = array(
				'fonts'     => ''
			);

			$this->value = wp_parse_args( $this->value, $defaults );
			$fonts = !empty($this->value['fonts']) ? json_decode($this->value['fonts'], true) : '';
			$saved_custom_fonts = array();

			if ( $fonts !== '' && isset($fonts['fonts']) ) {
				foreach( $fonts['fonts'] as $font => $details ) {

					if ( isset($details['type']) && isset($details['name']) && ( $details['type'] === 'custom' || $details['type'] === 'fontsquirrel' ) ) {
						$saved_custom_fonts[] = $details['name'];
					}
				}
			}

			$saved_custom_fonts = array_unique($saved_custom_fonts);

			$upload_dir = wp_upload_dir();
			$custom_fonts_dir = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_fonts/' );
			if ( file_exists($custom_fonts_dir) ) {
				$custom_fonts = scandir($custom_fonts_dir);

				foreach( $custom_fonts as $custom_font ) {
					if (substr($custom_font, 0, 1) !== '.') {
						if ( !in_array($custom_font, $saved_custom_fonts) ) {
							wtbx_recursive_delete_directory($custom_fonts_dir . $custom_font);
						}
					}
				}
			}
		}

		function getGoogleArray() {

			$googleapikey = $this->getGoogleApiKey();

			if ( $googleapikey === '' ) {
				return;
			}

			$gFile = dirname( __FILE__ ) . '/googlefonts_default.php';

			// Weekly update
			if ( isset( $googleapikey ) ) {

				if ( file_exists( $gFile ) ) {
					// Keep the fonts updated weekly
					$weekback     = strtotime( date( 'jS F Y', time() + ( 60 * 60 * 24 * - 7 ) ) );
					$last_updated = filemtime( $gFile );
					if ( $last_updated < $weekback ) {
						unlink( $gFile );
					}
				}
			}

			if ( ! file_exists( $gFile ) ) {
				$result = @wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $googleapikey );
				if ( ! is_wp_error( $result ) && $result['response']['code'] == 200 ) {
					$result = json_decode( $result['body'] );
					if ( !empty($result) ) {
						$this->parent->filesystem->execute( 'put_contents', $gFile, array( 'content' => "<?php return json_decode( '" . json_encode($result->items) . "', true );" ) );
					}
				}
			}
		}

		function getGoogleApiKey() {
			// No errors please
			$defaults = array(
				'fonts'     => ''
			);

//			$this->value = wp_parse_args( $this->value, $defaults );
//			$googleapikey = '';
//
//			$array = !empty($this->value['fonts']) ? json_decode($this->value['fonts'], true) : '';
//			if ( $array !== '' && isset($array['googleapikey']) ) {
//				$googleapikey = $array['googleapikey'];
//			}

			$googleapikey = wtbx_vc_option('site-google-api');

			return $googleapikey;
		}

		function getTypekitCreds() {
			// No errors please
			$defaults = array(
				'fonts'     => ''
			);

			$this->value = wp_parse_args( $this->value, $defaults );
			$array = array(
				'apikey' => '',
				'kitid'  => ''
			);

			$array = !empty($this->value['fonts']) ? json_decode($this->value['fonts'], true) : '';
			if ( $array !== '' && isset($array['typekit_apikey']) ) {
				$array['apikey'] = $array['typekit_apikey'];
			}
			if ( $array !== '' && isset($array['typekit_kitid']) ) {
				$array['kitid'] = $array['typekit_kitid'];
			}

			return $array;
		}

		function getFontSquirrelArray() {

			$fsFile = dirname( __FILE__ ) . '/fontsquirrelfonts.php';

			// Weekly update
			if ( file_exists( $fsFile ) ) {
				// Keep the fonts updated weekly
				$weekback     = strtotime( date( 'jS F Y', time() + ( 60 * 60 * 24 * - 7 ) ) );
				$last_updated = filemtime( $fsFile );
				if ( $last_updated < $weekback ) {
					unlink( $fsFile );
				}
			}

			if ( ! file_exists( $fsFile ) ) {
				$font_squirrel_all = 'http://www.fontsquirrel.com/api/fontlist/all';
				$result = wp_remote_request( $font_squirrel_all );

				if ( !is_wp_error( $result ) && $result['response']['code'] == 200 ) {
					$result = wp_remote_retrieve_body($result);
					$result = json_decode($result);
					if ( !empty($result) ) {
						$this->parent->filesystem->execute( 'put_contents', $fsFile, array( 'content' => "<?php return json_decode( '" . json_encode($result, JSON_HEX_APOS) . "', true );" ) );
					}
				}
			}
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
				'fonts'     => ''
			);

			$this->value = wp_parse_args( $this->value, $defaults );

			$font_value = WtbxFontsEnqueue::hideNonExistentFonts();

			echo '<input type="hidden" class="wtbx_custom_fonts" name="' . $this->field['name'] . $this->field['name_suffix'] . '[fonts]" id="' . $this->parent->args['opt_name'] . '[' . $this->field['id'] . '][fonts]" value="' . ($font_value !== '' ? esc_attr(json_encode($font_value)) : '' ) . '" />';

			echo '<div class="wtbx_font_pool_wrapper">';
			echo '<div class="wtbx_font_pool_container">';

			echo '<div class="wtbx_font_pool_loading"></div>';

			$this->renderFontsPool();

			$this->renderGoogleGontsBlock();

			$this->renderTypekitFontsBlock();

			$this->renderFontSquirrelFontsBlock();

			$this->renderCustomFonts();

			echo '</div>';
			echo '</div>';

		}

		function renderFontsPool() {

			$fonts_pool = WtbxFontsEnqueue::hideNonExistentFonts();
//			$creds      = $this->getTypekitCreds();

			echo '<div class="wtbx_font_container wtbx_font_wrapper wtbx_fontpool">';
			echo '<div class="wtbx_font_container_header">';
			echo '<div class="wtbx_fontpool_title">'. esc_html__('Fonts Pool', 'core-extension') .'</div>';
			echo '<div class="wtbx_fontpool_descr">'.esc_html__('A collection of fonts used in the theme', 'core-extension').'</div>';
			echo '</div>';

			echo '<div id="wtbx_fontpool" class="wtbx_fonts_tab active" data-confirmation="'. esc_html__('Are you sure you want to remove this font from the pool?', 'core-extension') .'">';

			if ( empty($fonts_pool['fonts']) ) {
				echo '<div class="wtbx_font_row wtbx_font_row_empty"><div class="wtbx_font_cell">' . esc_html__('No fonts added yet', 'core-extension') . '</div></div>';
			} else {
				echo '<div class="wtbx_font_row wtbx_font_row_empty wtbx_font_row_hidden"><div class="wtbx_font_cell">' . esc_html__('No fonts added yet', 'core-extension') . '</div></div>';


				foreach ( $fonts_pool['fonts'] as $font => $details ) {

//					if ( $details['type'] === 'typekit' && ( empty($creds['apikey']) || empty($creds['kitid']) ) ) {
//						continue;
//					}

					$font_row = '';
					$font_row .= '<div class="wtbx_font_row" data-type="'.esc_attr($details['type']).'">';

					$font_row .= '<div class="wtbx_font_cell wtbx_font_family">';
					$font_row .= $details['name'];
					$font_row .= '</div>';

					$font_row .= '<div class="wtbx_font_cell wtbx_font_source wtbx_font_'. esc_attr($details['type']) .'"><span>'. esc_attr($details['type']) .'</span></div>';

					$font_row .= '<div class="wtbx_font_cell wtbx_font_variants">';
					$font_row .= isset($details['variants']) ? ucwords(implode(', ', (array) $details['variants'])) : '';
					$font_row .= '</div>';

					$font_row .= '<div class="wtbx_font_cell wtbx_font_subsets">';
					$font_row .= isset($details['subsets']) ? ucwords(implode(', ', (array) $details['subsets'])) : '';
					$font_row .= '</div>';

					$font_row .= '<div class="wtbx_font_cell wtbx_font_link">';
					if ( $details['type'] === 'google' ) {
						$font_row .= '<a href="https://fonts.google.com/specimen/'.esc_attr($details['name']).'" target="_blank" class="dashicons dashicons-search"></a>';
					} elseif ( $details['type'] === 'fontsquirrel' ) {
						$font_row .= '<a href="https://www.fontsquirrel.com/fonts/'.esc_attr($details['url']).'" target="_blank" class="dashicons dashicons-search"></a>';
					}
					$font_row .= '</div>';

					$font_row .= '<div class="wtbx_font_cell wtbx_font_select">';
					$details['family'] = $font;
//				    $details['name'] = $font;
					$font_row .= "<span data-font='". json_encode($details) ."' class='wtbx_remove_from_pool'></span>";
					$font_row .= '</div>';

					$font_row .= '</div>';

					echo $font_row;
				}
			}

			echo '</div>';
			echo '</div>';
		}

		function renderCustomFonts() {

			$fonts_pool = !empty($this->value['fonts']) ? json_decode($this->value['fonts'], true) : '';

			echo '<div class="wtbx_font_container wtbx_customfonts" data-type="custom">';

			echo '<div class="wtbx_font_container_header">';
			echo '<div class="wtbx_font_container_title">'. esc_html__('Custom Fonts', 'core-extension') .'</div>';
			echo '<div class="wtbx_font_toggle_container">';
			echo '<span class="dashicons dashicons-arrow-down wtbx_font_toggle"></span>';
			echo '</div>';
			echo '</div>';

			echo '<div id="wtbx_customfonts" class="wtbx_font_block">';


			// Upload font block
			echo '<div class="wtbx_upload_fonts_wrapper">';
			echo '<div class="wtbx_upload_fonts_title">'.esc_html__('Upload custom font', 'core-extension').'</div>';
			echo '<div class="wtbx_upload_fonts_descr">'.esc_html__('Enter the font name, upload font files and press "Add Font" button below', 'core-extension').'</div>';
			echo '<div class="wtbx_upload_fonts_container">';

			echo '<div class="wtbx_custom_font_detail" data-detail="family">';
			echo '<div class="wtbx_custom_font_th wtbx_custom_font_title">'.esc_html__('Font family', 'core-extension').'</div>';
			echo '<div class="wtbx_upload_font_td">';
			echo '<input type="text" class="wtbx_custom_font_family"/>';
			echo '</div>';
			echo '</div>';

			echo '<div class="wtbx_custom_font_detail" data-detail="files">';
			echo '<div class="wtbx_custom_font_th wtbx_custom_font_title">'.esc_html__('Font files', 'core-extension').'</div>';
			echo '<div class="wtbx_upload_font_td">';
			echo '<div class="wtbx_upload_buttons">';
			echo '<div class="wtbx_font_file_uploaded"><span class="dashicons dashicons-yes"></span></div><span class="button media_upload_button" id="' . $this->field['id'] . '-eot" data-type="eot" data-select="'.esc_html__('Insert .eot format file', 'core-extension').'" data-mime="application/vnd.ms-fontobject">' . esc_html__( '.eot', 'core-extension' ) . '</span>';
			echo '<div class="wtbx_font_file_uploaded"><span class="dashicons dashicons-yes"></span></div><span class="button media_upload_button" id="' . $this->field['id'] . '-ttf" data-type="ttf" data-select="'.esc_html__('Insert .ttf format file', 'core-extension').'" data-mime="application/x-font-ttf">' . esc_html__( '.ttf', 'core-extension' ) . '</span>';
			echo '<div class="wtbx_font_file_uploaded"><span class="dashicons dashicons-yes"></span></div><span class="button media_upload_button" id="' . $this->field['id'] . '-woff" data-type="woff" data-select="'.esc_html__('Insert .woff format file', 'core-extension').'" data-mime="application/font-woff">' . esc_html__( '.woff', 'core-extension' ) . '</span>';
//			echo '<div class="wtbx_font_file_uploaded"><span class="dashicons dashicons-yes"></span></div><span class="button media_upload_button" id="' . $this->field['id'] . '-svg" data-type="svg" data-select="'.esc_html__('Insert .svg format file', 'core-extension').'" data-mime="image/svg+xml">' . esc_html__( '.svg', 'core-extension' ) . '</span>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';

			echo '</div>';

			echo '<div class="wtbx_custom_font_footer">';
			echo '<span class="button button-primary" disabled="disabled" id="wtbx_make_custom_font">' . esc_html__( 'Add Font', 'core-extension' ) . '</span>';
			echo '</div>';

			echo '</div>';
			echo '</div>';
		}

		function renderGoogleGontsBlock() {

//			$googleapikey = '';
//			$array = !empty($this->value['fonts']) ? json_decode($this->value['fonts'], true) : '';
//			if ( $array !== '' && isset($array['googleapikey']) ) {
//				$googleapikey = $array['googleapikey'];
//			}

			$googleapikey = wtbx_vc_option('site-google-api');

			echo '<div class="wtbx_font_container wtbx_googlefonts" data-type="google">';

			echo '<div class="wtbx_font_container_header">';
			echo '<div class="wtbx_font_container_title">'. esc_html__('Google Fonts', 'core-extension') .'</div>';
			echo '<div class="wtbx_font_toggle_container">';
			echo '<span class="dashicons dashicons-arrow-down wtbx_font_toggle"></span>';
			echo '</div>';
			echo '</div>';

			echo '<div class="wtbx_font_block">';
//			echo '<div class="wtbx_googlefonts_key_wrapper">';
//			echo '<div class="wtbx_googlefonts_key_header">';
//			echo '<label><strong>'.esc_html('Google API Key', 'core-extension').'</strong></label>';
//			echo '<div class="wtbx_googlefonts_hint">'.esc_html('Entering the API Key will allow you to update a list of available Google Fonts once a week', 'core-extension').'</div>';
//			echo '</div>';
//			echo '<div class="wtbx_googlefonts_key_container">';
//			echo '<input type="text" name="wtbx_googlefonts_key" id="wtbx_googlefonts_key" value="' . $googleapikey . '"/>';
//			echo '</div>';
//			echo '</div>';

			$gFile = dirname( __FILE__ ) . '/googlefonts.php';
			if ( !file_exists( $gFile ) ) {
				$gFile = dirname( __FILE__ ) . '/googlefonts_default.php';
			}
			if ( file_exists( $gFile ) ) {
				$fonts = include $gFile;

				$lastChar = '';
				$fonts_array = array();
				foreach($fonts as $font) {
					$family     = $font['family'];
					$variants   = $font['variants'];
					$subsets    = $font['subsets'];

					$char = $family[0];
					$fonts_array[strtoupper($char)][] = array(
						'family'    => $family,
						'variants'  => $variants,
						'subsets'   => $subsets
					);

					if ($char !== $lastChar) $lastChar = $char;
				}

				echo '<div class="wtbx_font_wrapper wtbx_googlefonts_wrapper">';

				$navigation = '';
				$tabs = '';
				$first = true;
				foreach($fonts_array as $group => $families) {
					$navigation .= '<div data-tab="'.strtolower($group).'" class="wtbx_fonts_nav_item ' . ($first === true ? 'active' : '') . '">';
					$navigation .= $group;
					$navigation .= '</div>';

					$tabs .= '<div data-group="'.strtolower($group).'" class="wtbx_fonts_tab ' . ($first === true ? 'active' : '') . '">';
					foreach($families as $key => $value) {
						$tabs .= '<div class="wtbx_font_row" data-family="'.$value['family'].'">';

						$tabs .= '<div class="wtbx_font_cell wtbx_font_family">';
						$tabs .= $value['family'];
						$tabs .= '</div>';

						$tabs .= '<div class="wtbx_font_cell wtbx_font_variants">';
						$tabs .= ucwords(implode(', ', $value['variants']));
						$tabs .= '</div>';

						$tabs .= '<div class="wtbx_font_cell wtbx_font_subsets">';
						$tabs .= ucwords(implode(', ', $value['subsets']));
						$tabs .= '</div>';

						$tabs .= '<div class="wtbx_font_cell wtbx_font_link">';
						$tabs .= '<a href="https://fonts.google.com/specimen/'.esc_attr($value['family']).'" target="_blank" class="dashicons dashicons-search"></a>';
						$tabs .= '</div>';

						$tabs .= '<div class="wtbx_font_cell wtbx_font_select">';
						$font_details = $value;
						$font_details['type'] = 'google';
						$font_details['name'] = $value['family'];
						$tabs .= "<span data-font='". json_encode($font_details) ."' class='wtbx_add_to_pool'></span>";
						$tabs .= '</div>';

						$tabs .= '</div>';
					}
					$tabs .= '</div>';

					$first = false;
				}

				echo '<div class="wtbx_fonts_nav">';
				echo '<div class="wtbx_fonts_nav_inner">';
				echo $navigation;
				echo '</div>';
				echo '</div>';

				echo '<div class="wtbx_fonts_tabs">';
				echo $tabs;
				echo '</div>';
				echo '</div>';
			}


			echo '</div>';
			echo '</div>';

		}

		function renderFontSquirrelFontsBlock() {

			echo '<div class="wtbx_font_container wtbx_fontsquirrel" data-type="fontsquirrel">';

			echo '<div class="wtbx_font_container_header">';
			echo '<div class="wtbx_font_container_title">'. esc_html__('Font Squirrel Fonts', 'core-extension') .'</div>';
			echo '<div class="wtbx_font_toggle_container">';
			echo '<span class="dashicons dashicons-arrow-down wtbx_font_toggle"></span>';
			echo '</div>';
			echo '</div>';

			echo '<div class="wtbx_font_block">';

			$fsFile = dirname( __FILE__ ) . '/fontsquirrelfonts.php';
			if ( !file_exists( $fsFile ) ) {
				return;
			}
			$fonts = include $fsFile;

			$lastChar = '';
			$fonts_array = array();

			foreach($fonts as $font) {
				$family     = $font['family_name'];
				$url        = $font['family_urlname'];
				$filename   = $font['font_filename'];

				$char = $family[0];
				$fonts_array[strtoupper($char)][] = array(
					'family'    => $family,
					'url'       => $url,
					'filename'  => $filename
				);

				if ($char !== $lastChar) $lastChar = $char;
			}

			echo '<div class="wtbx_font_wrapper wtbx_fontsquirrelfonts_wrapper">';

			$navigation = '';
			$tabs = '';
			$first = true;
			foreach($fonts_array as $group => $families) {
				$navigation .= '<div data-tab="'.strtolower($group).'" class="wtbx_fonts_nav_item ' . ($first === true ? 'active' : '') . '" style="max-width: '.(100/sizeof($fonts_array) - 0.5).'%">';
				$navigation .= $group;
				$navigation .= '</div>';

				$tabs .= '<div data-group="'.strtolower($group).'" class="wtbx_fonts_tab ' . ($first === true ? 'active' : '') . '">';
				foreach($families as $key => $value) {
					$tabs .= '<div class="wtbx_font_row" data-family="'.$value['family'].'">';

					$tabs .= '<div class="wtbx_font_cell wtbx_font_family">';
					$tabs .= isset($value['family']) ? $value['family'] : '';
					$tabs .= '</div>';

					$tabs .= '<div class="wtbx_font_cell wtbx_font_variants">';
//				    $tabs .= ucwords(implode(', ', $value['variants']));
					$tabs .= '</div>';

					$tabs .= '<div class="wtbx_font_cell wtbx_font_subsets">';
//				    $tabs .= ucwords(implode(', ', $value['subsets']));
					$tabs .= '</div>';

					$tabs .= '<div class="wtbx_font_cell wtbx_font_link">';
					$tabs .= '<a href="https://www.fontsquirrel.com/fonts//' . (isset($value['url']) ? esc_attr($value['url']) : '') . '" target="_blank" class="dashicons dashicons-search"></a>';
					$tabs .= '</div>';

					$tabs .= '<div class="wtbx_font_cell wtbx_font_select">';
					$font_details = $value;
					$font_details['type'] = 'fontsquirrel';
					$font_details['name'] = $value['family'];
					$tabs .= "<span data-font='". json_encode($font_details) ."' class='wtbx_add_to_pool'></span>";
					$tabs .= '</div>';

					$tabs .= '</div>';
				}
				$tabs .= '</div>';

				$first = false;
			}

			echo '<div class="wtbx_fonts_nav">';
			echo '<div class="wtbx_fonts_nav_inner">';
			echo $navigation;
			echo '</div>';
			echo '</div>';

			echo '<div class="wtbx_fonts_tabs">';
			echo $tabs;
			echo '</div>';

			echo '</div>';

			echo '</div>';
			echo '</div>';

		}

		function renderTypekitFontsBlock() {

			$fonts = !empty($this->value['fonts']) ? json_decode($this->value['fonts'], true) : '';
			$creds = $this->getTypekitCreds();

			echo '<div class="wtbx_font_container wtbx_typekitfonts" data-type="custom">';

			echo '<div class="wtbx_font_container_header">';
			echo '<div class="wtbx_font_container_title">'. esc_html__('Adobe Typekit Fonts', 'core-extension') .'</div>';
			echo '<div class="wtbx_font_toggle_container">';
			echo '<span class="dashicons dashicons-arrow-down wtbx_font_toggle"></span>';
			echo '</div>';
			echo '</div>';

			echo '<div id="wtbx_typekitfonts" class="wtbx_font_block">';

			echo '<div class="wtbx_typekit_header clearfix">';
			echo '<div class="wtbx_typekit_row">';
			echo '<div class="wtbx_typekit_col">';
			echo '<span>'. esc_html__('Typekit API Key:', 'core-extension') .'</span>';
			echo '<span><input type="text" name="wtbx_typekit_apikey" id="wtbx_typekit_apikey" value="'.(isset($creds['apikey']) ? $creds['apikey'] : '').'" /></span>';
			echo '</div>';
			echo '<div class="wtbx_typekit_col">';
			echo '<span>'. esc_html__('Typekit Kit ID:', 'core-extension') .'</span>';
			echo '<span><input type="text" name="wtbx_typekit_kitid" id="wtbx_typekit_kitid" value="'.(isset($creds['kitid']) ? $creds['kitid'] : '').'" /></span>';
			echo '</div>';
			echo '<div class="wtbx_typekit_save"><span class="button button-primary" id="wtbx_typekit_save">' . esc_html__( 'Sync', 'core-extension' ) . '</span><span class="button" id="wtbx_typekit_reset" data-confirmation="'. esc_html__('Are you sure you want to desynchronize Typekit fonts? This will remove them from the font pool.', 'core-extension') .'">' . esc_html__( 'De-Sync', 'core-extension' ) . '</span></div>';
			echo '</div>';
			echo '<div class="wtbx_typekit_hint">'. sprintf( esc_html__('You need a %s to access your Typekit fonts.', 'core-extension'), '<a href="https://typekit.com/account/tokens" target="_blank">Typekit API key</a>') .'</div>';

			echo '</div>';


			echo '</div>';
			echo '</div>';
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

			$extension = ReduxFramework_extension_wtbx_custom_font::getInstance();

			wp_enqueue_script(
				'redux-field-wtbx-custom-font-js',
				$this->extension_url . 'field_wtbx_custom_font.js',
				array( 'jquery' ),
				time(),
				true
			);

			wp_enqueue_style(
				'redux-field-wtbx-custom-font-css',
				$this->extension_url . 'field_wtbx_custom_font.css',
				time(),
				true
			);

			$ajax_url = array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			);
			wp_localize_script( 'redux-field-wtbx-custom-font-js', 'wtbx_custom_font_ajax', $ajax_url );

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
