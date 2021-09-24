<?php

function wtbx_custom_font_add_type() {
	$filename           = $_POST['filename'];
	$filenameNoSpaces   = str_replace(' ', '-', $filename);
	$filename_base      = pathinfo($filename)['filename'];
	$filenameBaseNoSpaces = str_replace(' ', '-', $filename_base);
	$file_id            = $_POST['id'];
	$old_dir            = get_attached_file($file_id);
	$upload_dir         = wp_upload_dir();
	$new_dir            = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_fonts/custom_font_temp' );

	if (!file_exists($new_dir) . $filename) {
		$custom_dir = wp_mkdir_p($new_dir);
	} else {
		$custom_dir = true;
		wp_delete_attachment( $file_id, true );
	}

	if ( $custom_dir ) {
		copy($old_dir, trailingslashit($new_dir) . '/' . $filename);
		wp_delete_attachment($file_id, true);
	}

	echo trailingslashit($new_dir);

	wp_die();
}

add_action('wp_ajax_custom_font_add_type', 'wtbx_custom_font_add_type');
add_action('wp_ajax_nopriv_custom_font_add_type', 'wtbx_custom_font_add_type');



function wtbx_custom_font_create() {
	$info           = $_POST['info'];
	$upload_dir     = wp_upload_dir();
	$temp_dir       = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_fonts/custom_font_temp/' );
	$return_array   = array();

	if ( is_dir($temp_dir) ) {
		$family = isset($info['name']) ? $info['name'] : '';

		if ( $family !== '' ) {
			$new_dir = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_fonts/' . $family );
			$temp_files = scandir($temp_dir);
			$font_files = array();

			if ( !is_dir($new_dir) ) {

				foreach ($temp_files as $temp_file) {
					if (substr($temp_file, 0, 1) !== '.') {
						wp_mkdir_p($new_dir);
						copy(trailingslashit($temp_dir) . $temp_file, trailingslashit($new_dir) . $temp_file);
						unlink(trailingslashit($temp_dir) . $temp_file);
						$temp_file_ext = pathinfo($temp_file);
						$temp_file_ext = $temp_file_ext['extension'];
						$font_files[$temp_file_ext] = $temp_file;
					}
				}
				reset($temp_files);
				rmdir($temp_dir);

				$font_row = '';
				$font_row .= '<div class="wtbx_font_row">';

				$font_row .= '<div class="wtbx_font_cell wtbx_font_family">';
				$font_row .= $family;
				$font_row .= '</div>';

				$font_row .= '<div class="wtbx_font_cell wtbx_font_source wtbx_font_custom"><span>Custom</span></div>';

				$font_row .= '<div class="wtbx_font_cell wtbx_font_variants"></div>';

				$font_row .= '<div class="wtbx_font_cell wtbx_font_subsets"></div>';

				$font_row .= '<div class="wtbx_font_cell wtbx_font_link"></div>';

				$font_row .= '<div class="wtbx_font_cell wtbx_font_select">';
				$uniqID = hexdec(substr(uniqid(), 6, 7));
				$details = array(
					'family'    => $uniqID,
					'vairants'  => '',
					'subsets'   => '',
					'type'      => 'custom',
					'name'      => $family,
					'id'        => $uniqID
				);
				$font_row .= "<span data-font='". json_encode($details) ."' class='wtbx_remove_from_pool'></span>";
				$font_row .= '</div>';

				$font_row .= '</div>';

				$fonts_return = array();
				$fonts_return['variants']  = '';
				$fonts_return['subsets']   = '';
				$fonts_return['type']      = 'custom';
				$fonts_return['name']      = $family;
				$fonts_return['family']    = $family;
				$fonts_return['id']        = $uniqID;

				$url = wp_nonce_url(admin_url('admin.php?page=Scape'));
				if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
					return false;
				}

				//check if credentials are correct or not.
				if(!WP_Filesystem($creds)) {
					request_filesystem_credentials($url, '', true, false, null);
					return false;
				}

				global $wp_filesystem;

				$css = '';
				$css .= "@font-face {" . "\n";
				$css .= "\tfont-family: '".$family."';\n";

				foreach ( $font_files as $extension => $file ) {
					if ( $extension === 'eot' ) {
						$css .="\tsrc: url('".$file."');\n";
					}
				}

				$css .="\tsrc: ";

				foreach ( $font_files as $extension => $file ) {
					if ( $extension === 'eot' ) {
						$css .="\n\t\turl('".$file."?#iefix') format('embedded-opentype'),";
					} elseif ( $extension === 'woff' ) {
						$css .="\n\t\turl('".$file."') format('woff'),";
					} elseif ( $extension === 'ttf' ) {
						$css .="\n\t\turl('".$file."') format('truetype'),";
					} elseif ( $extension === 'svg' ) {
						$css .="\n\t\turl('".$file."#".$family."') format('svg'),";
					}
				}

				$css = substr($css, 0, -1);

				$css .= ";\n";
				$css .= "\tfont-weight: normal;\n";
				$css .= "\tfont-style: normal;\n";

				$css .= "}\n";

				$wp_filesystem->put_contents(trailingslashit($new_dir) . 'stylesheet.css', $css, FS_CHMOD_FILE);

				$return_array = array(
					'object' => $fonts_return,
					'html'   => $font_row,
					'error'  => ''
				);

				$return_array['object'] = $fonts_return;
				$return_array['html']   = $font_row;

			} else {
				$return_array['error']  = esc_html__('Font already exists', 'scape');
				wtbx_recursive_delete_directory($temp_dir);
			}
		}
	}

	wp_die(json_encode($return_array));

}

add_action('wp_ajax_custom_font_create', 'wtbx_custom_font_create');
add_action('wp_ajax_nopriv_custom_font_create', 'wtbx_custom_font_create');



function wtbx_remove_theme_font() {
	$folder             = $_POST['folder'];
	$upload_dir         = wp_upload_dir();
	$custom_font_dir   = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_fonts/' . $folder );
	wtbx_recursive_delete_directory($custom_font_dir);

	if ( !is_dir($custom_font_dir) ) {
		wp_die('removed');
	}
}

add_action('wp_ajax_remove_theme_font', 'wtbx_remove_theme_font');
add_action('wp_ajax_nopriv_remove_theme_font', 'wtbx_remove_theme_font');



function wtbx_add_fontsquirrel_font() {
	$urlname            = $_POST['urlname'];
	$font_name          = $_POST['name'];
	$upload_dir         = wp_upload_dir();
	$custom_fonts_dir   = trailingslashit( $upload_dir['basedir'] . '/wtbx_custom_fonts/' );
	$font_url           = 'https://www.fontsquirrel.com/fontfacekit/';

	if (!file_exists($custom_fonts_dir)) {
		$custom_dir = wp_mkdir_p($custom_fonts_dir);
	} else {
		$custom_dir = true;
	}

	if ( $custom_dir ) {

		$url = wp_nonce_url(admin_url('admin.php?page=Scape'));
		if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
			return false;
		}

		//check if credentials are correct or not.
		if(!WP_Filesystem($creds)) {
			request_filesystem_credentials($url, '', true, false, null);
			return false;
		}

		global $wp_filesystem;

		$file_response = wp_remote_request($font_url . $urlname, array('sslverify' => false, 'timeout' => 300));

		if ( is_wp_error($file_response) ) {
			var_dump($file_response->get_error_message());
		}

		if (!is_wp_error($file_response)) {
			$zip_file = wp_remote_retrieve_body($file_response);

			$zip_path   = trailingslashit($custom_fonts_dir) . $urlname . '.zip';
			$new_dir    = trailingslashit($custom_fonts_dir) . $font_name;

			$wp_filesystem->put_contents($zip_path, $zip_file, FS_CHMOD_FILE);
			$unzipfile = unzip_file(trailingslashit($custom_fonts_dir) . $urlname . '.zip', $new_dir);

			if ($unzipfile) {

				wp_delete_file($zip_path);

				$webfonts_dir = trailingslashit($new_dir) . 'web fonts/';

				if ( is_dir($webfonts_dir) ) {

					$font_files = array();

					$objects = scandir($webfonts_dir);

					foreach ($objects as $object) {
						if ( is_dir($webfonts_dir . $object) ) {

							if ( file_exists( $webfonts_dir . $object . '/specimen_files' ) ) {
								wtbx_recursive_delete_directory( $webfonts_dir . $object . '/specimen_files' );
							}

							$sub_objects = scandir(trailingslashit($webfonts_dir . $object));

							foreach ($sub_objects as $sub_object) {
								if ( is_dir($webfonts_dir . $object) ) {
									$path = pathinfo(trailingslashit($webfonts_dir . $object) . $sub_object);
									if( substr($sub_object, 0, 1) !== '.' && $path['extension'] !== 'html' && $path['extension'] !== 'css' ) {
										rename(trailingslashit($webfonts_dir . $object) . $sub_object, $webfonts_dir . $sub_object);
									}
								}
							}

							if ( $object != "." && $object != ".." ) {
								wtbx_recursive_delete_directory( trailingslashit($webfonts_dir . $object) );
							}

						}
					}

					$file_candidates = scandir(trailingslashit($webfonts_dir));
					foreach ($file_candidates as $file_candidate) {
						$final_path = pathinfo($webfonts_dir . $file_candidate);

						if( substr($file_candidate, 0, 1) !== '.' && $final_path['extension'] !== 'html' && $final_path['extension'] !== 'css' ) {
							$font_files[] = $file_candidate;
						}
					}

					$font_details_url = 'https://www.fontsquirrel.com/api/familyinfo/';
					$result = wp_remote_request($font_details_url . $urlname, array('sslverify' => false));

					if ( !is_wp_error( $result ) ) {
						$result = wp_remote_retrieve_body($result);
						$font_details = json_decode($result, true);

						if ( !empty($font_details) ) {

							$css = '';
							$families = array();
							$fonts_return = array();
							$row_return = '';

							foreach( $font_details as $font ) {
								$families[] = $font['family_name'];
							}
							$families = array_unique($families);

							foreach( $families as $family ) {

								$variants_return = array();

								foreach( $font_details as $font_face ) {

									if ( $font_face['family_name'] === $family ) {
										$filename = pathinfo($font_face['filename']);
										$filename = $filename['filename'];
										$family_name = $font_face['family_name'];
										$style_name = strtolower($font_face['style_name']);

										$css .= "@font-face {" . "\n";
										$css .= "\tfont-family: '".$family_name."';\n";

										if ( in_array($filename.'-webfont.eot', $font_files) ) {
											$css .="\tsrc: url('web fonts/".$filename."-webfont.eot');\n";
										}
										$css .="\tsrc: ";
										if ( in_array($filename.'-webfont.eot', $font_files) ) {
											$css .="\n\t\turl('web fonts/".$filename."-webfont.eot?#iefix') format('embedded-opentype'),";
										}
										if ( in_array($filename.'-webfont.woff', $font_files) ) {
											$css .="\n\t\turl('web fonts/".$filename."-webfont.woff') format('woff'),";
										}
										if ( in_array($filename.'-webfont.ttf', $font_files) ) {
											$css .="\n\t\turl('web fonts/".$filename."-webfont.ttf') format('truetype'),";
										}
										if ( in_array($filename.'-webfont.svg', $font_files) ) {
											$css .="\n\t\turl('web fonts/".$filename."-webfont.svg#".$filename."') format('svg'),";
										}

										$css = substr($css, 0, -1);

										$css .= ";\n";

										$variants = wtbx_get_font_weight_style($style_name);

										$css .= "\tfont-weight: ". $variants['weight'] . ";\n";
										$css .= "\tfont-style: ". $variants['style'] . ";\n";

										$css .= "}\n";

										$variants_return[] = $style_name;

									}
								}

								$variants_string = implode(',', $variants_return);
								$uniqID = hexdec(substr(uniqid(), 6, 7));
								$fonts_return[$uniqID]['variants']  = $variants_return;
								$fonts_return[$uniqID]['type']      = 'fontsquirrel';
								$fonts_return[$uniqID]['name']      = $font_name;
								$fonts_return[$uniqID]['family']    = $family;
								$fonts_return[$uniqID]['id']        = $uniqID;
								$fonts_return[$uniqID]['url']       = $urlname;

								$row_return .= '<div class="wtbx_font_row">';

								$row_return .= '<div class="wtbx_font_cell wtbx_font_family">';
								$row_return .= $family;
								$row_return .= '</div>';

								$row_return .= '<div class="wtbx_font_cell wtbx_font_source wtbx_font_fontsquirrel"><span>FontSquirrel</span></div>';

								$row_return .= '<div class="wtbx_font_cell wtbx_font_variants">';
								$row_return .= implode(', ', $variants_return);
								$row_return .= '</div>';

								$row_return .= '<div class="wtbx_font_cell wtbx_font_subsets"></div>';

								$row_return .= '<div class="wtbx_font_cell wtbx_font_link">';
								$row_return .= '<a href="//www.fontsquirrel.com/fonts/'.esc_attr($urlname).'" target="_blank" class="dashicons dashicons-search"></a>';
								$row_return .= '</div>';

								$row_return .= '<div class="wtbx_font_cell wtbx_font_select">';

								$details = array(
									'family'    => $family,
									'variants'  => $variants_string,
									'subsets'   => '',
									'type'      => 'fontsquirrel',
									'name'      => $font_name,
									'id'        => $uniqID
								);
								$row_return .= "<span data-font='". json_encode($details) ."' class='wtbx_remove_from_pool'></span>";
								$row_return .= '</div>';

								$row_return .= '</div>';

								$wp_filesystem->put_contents(trailingslashit($new_dir) . $family . '.css', $css, FS_CHMOD_FILE);

							}

							$return_array = array(
								'object' => $fonts_return,
								'html'   => $row_return
							);

							wp_die(json_encode($return_array));

						}
					}
				}
			}
		}
	}
}

add_action('wp_ajax_add_fontsquirrel_font', 'wtbx_add_fontsquirrel_font');
add_action('wp_ajax_nopriv_add_fontsquirrel_font', 'wtbx_add_fontsquirrel_font');


function wtbx_typekit_sync() {
	$apikey     = $_POST['apikey'];
	$kitid      = $_POST['kitid'];
	$response   = array(
		'status' => 'error',
	);

	if ( !empty($apikey) && !empty($kitid) ) {
		$curl_args = array( 'sslverify' => false );
		$url = 'https://typekit.com/api/v1/json/kits/' . $kitid . '?token=' . $apikey;
		$kit_response = wp_remote_request($url, $curl_args);

		if (!is_wp_error($kit_response)) {
			$kit_response = wp_remote_retrieve_body($kit_response);
			$kit_response = json_decode($kit_response);

			if (isset($kit_response->kit->name)) {
				$fonts = $kit_response->kit->families;

				if (count($fonts) > 0) {
					$row_return     = '';
					$fonts_return   = array();
					$variants_std   = wtbx_typekit_variants();

					foreach ( $fonts as $font ) {
						$font_id        = $font->id;
						$variants       = array();

						foreach ( $font->variations as $variation ) {
							$variants[] = $variants_std[$variation];
						}

						$row_return .= '<div class="wtbx_font_row" data-type="typekit">';

						$row_return .= '<div class="wtbx_font_cell wtbx_font_family">';
						$row_return .= $font->name;
						$row_return .= '</div>';

						$row_return .= '<div class="wtbx_font_cell wtbx_font_source wtbx_font_typekit"><span>Typekit</span></div>';

						$row_return .= '<div class="wtbx_font_cell wtbx_font_variants">';
						$row_return .= implode(', ', $variants);
						$row_return .= '</div>';

						$row_return .= '<div class="wtbx_font_cell wtbx_font_subsets"></div>';

						$row_return .= '<div class="wtbx_font_cell wtbx_font_link">';
						$row_return .= '<a href="//typekit.com/fonts/'.esc_attr($font->slug).'" target="_blank" class="dashicons dashicons-search"></a>';
						$row_return .= '</div>';

						$row_return .= '<div class="wtbx_font_cell wtbx_font_select">';

						$details = array(
							'family'    => $font_id,
							'variants'  => implode(', ', $variants),
							'subsets'   => implode(', ', $font->subset),
							'type'      => 'typekit',
							'name'      => $font->name,
							'id'        => $font_id
						);
						$row_return .= "<span data-font='". json_encode($details) ."' class='wtbx_remove_from_pool'></span>";
						$row_return .= '</div>';

						$row_return .= '</div>';

						$fonts_return[$font_id]['variants']  = $variants;
						$fonts_return[$font_id]['type']      = 'typekit';
						$fonts_return[$font_id]['name']      = $font->name;
						$fonts_return[$font_id]['family']    = $font->name;
						$fonts_return[$font_id]['id']        = $font_id;
					}

					$response = array(
						'status' => 'success',
						'object' => $fonts_return,
						'html'   => $row_return
					);
					$response['status'] = 'success';
					wp_die(json_encode($response));
				}
			}
			$response['message'] = esc_html__('No Kits found with this name.', 'scape');
			wp_die(json_encode($response));
		} else {
			$response['message'] = esc_html__('Sorry, an error occurred while trying to connect to Typekit.', 'scape');
			wp_die(json_encode($response));
		}
	} else {
		$response['message'] = esc_html__('Missing API Key or Kit ID.', 'scape');
		wp_die(json_encode($response));
	}
}

add_action('wp_ajax_typekit_sync', 'wtbx_typekit_sync');
add_action('wp_ajax_nopriv_typekit_sync', 'wtbx_typekit_sync');



function wtbx_unique_font_id() {
	echo hexdec(substr(uniqid(), 6, 7));
	wp_die();
}

add_action('wp_ajax_unique_font_id', 'wtbx_unique_font_id');
add_action('wp_ajax_nopriv_unique_font_id', 'wtbx_unique_font_id');