<?php

function wtbx_unzip_icon_font() {

	$filename           = $_POST['filename'];
	$filenameNoSpaces   = str_replace(' ', '-', $filename);
	$filename_base      = pathinfo($filename)['filename'];
	$filenameBaseNoSpaces = str_replace(' ', '-', $filename_base);
	$file_id            = $_POST['id'];
	$old_dir            = get_attached_file($file_id);
	$upload_dir         = wp_upload_dir();
	$new_dir            = trailingslashit( $upload_dir['basedir'] . '/wtbx_icon_fonts/' . $filenameBaseNoSpaces );

	$url = wp_nonce_url(admin_url('admin.php?page=Scape'));
	if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
		return false;
	}

	//check if credentials are correct or not.
	if(!WP_Filesystem($creds)) {
		request_filesystem_credentials($url, '', true, false, null);
		return false;
	}

	if (!file_exists($new_dir)) {
		$custom_dir = wp_mkdir_p($new_dir);
	}
	else {
		$custom_dir = true;
		wp_delete_attachment( $file_id, true );
		wp_die( '<div class="error notice is-dismissible"><p>This font already exists.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'scape') .'</span></button></div>' );
	}

	if ( $custom_dir ) {

		copy($old_dir, trailingslashit($new_dir) . '/' . $filename);
		wp_delete_attachment( $file_id, true );

		// unzip the archive contents
		global $wp_filesystem;
		$unzipfile = unzip_file($new_dir . '/' . $filename, $new_dir);

		if ( $unzipfile ) {

			// check for the json file to be sure it's an icomoon .zip
			if( !file_exists( $new_dir.'/'.'selection.json' ) ) {
				?>
				<div class="error notice is-dismissible">
					<p><?php esc_html_e( 'There was a problem with the file you uploaded. Make sure that you\'re uploading a .zip file from', 'scape'); echo " <a href='//icomoon.io/app/#/select' target='_blank'>icomoon</a>. "; ?></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.', 'scape') ?></span></button>
				</div>
				<?php
				// delete the files from the directory
				wtbx_recursive_delete_directory( $new_dir );
				exit();
			}

			$selection  = $wp_filesystem->get_contents( $new_dir.'/'.'selection.json' );
			$selection  = json_decode($selection, true);
			$prefix     = '';
			$icons_arr  = array();

			if ( isset($selection['preferences']['fontPref']['prefix']) ) {
				$prefix = $selection['preferences']['fontPref']['prefix'];
			}

			$charmap = $new_dir.'/'.'charmap.json';

			$charmap_contents  = '';
			$charmap_contents .= '{' . "\n\t" . '"name": "' . $filenameBaseNoSpaces . '",' . "\n\t" . '"label": "' . $filename_base . '",' . "\n\t" . '"icons": {';

			$comma = '';

			foreach( $selection['icons'] as $icon ) {
				if(!empty($icon) && isset($icon['properties']['name'])) {
					$charmap_contents .= $comma . "\n\t\t" . '"'.$prefix.$icon['properties']['name'].'": "'.$icon['properties']['name'] .'"';
					$comma = ',';
					$icons_arr[] = $prefix.$icon['properties']['name'];
				}
			}

			$charmap_contents .= "\n\t" . '}' . "\n" . '}';

			$wp_filesystem->put_contents( $charmap, $charmap_contents, FS_CHMOD_FILE );

			// change path of linked font files in style.css
			$styleCSS = $new_dir.'/style.css';
			$currentStyles = $wp_filesystem->get_contents($styleCSS);

			// delete unecessary files
			wp_delete_file( $new_dir . '/' . $filename );
			if ( file_exists( $new_dir . '/Read Me.txt' ) ) {
				unlink($new_dir.'/Read Me.txt');
			}
			if ( file_exists( $new_dir . '/demo.html' ) ) {
				unlink($new_dir.'/demo.html');
			}
			if ( file_exists( $new_dir . '/demo-files' ) ) {
				wtbx_recursive_delete_directory($new_dir.'/demo-files');
			}

			$css_dir = $upload_dir['baseurl'] . '/wtbx_icon_fonts/' . $filenameBaseNoSpaces;

			// ajax get style.css file and append to head to show icons
			echo '<script>
					jQuery(document).ready(function($) {
						$("head").append("<link type=\"text/css\" rel=\"stylesheet\" href=\"'.$css_dir.'/style.css\"/>");
						var $field          = $("#wtbx_scape-custom_icon_font"),
							fonts           = $field.find(".custom_icon_font_folder").val();

							if ( fonts !== "" ) {
								fonts = JSON.parse(fonts);
							} else {
								fonts = [];
							}

							fonts.push("'.$filenameBaseNoSpaces.'");
							fonts = JSON.stringify(fonts);
							$field.find(".custom_icon_font_folder").val(fonts);
							$("#redux_save").trigger("click");
					});
				</script>';

			echo '<div class="wtbx-font-preview" data-font="'.$filenameBaseNoSpaces.'">';
			echo '<div class="wtbx-font-preview-remove" data-remove="'.$filenameBaseNoSpaces.'" data-confirmation="'.esc_html__('Are you sure you want to remove this font?', 'scape').'">'.esc_html__('Remove', 'scape').'</div>';
			echo '<div class="wtbx-font-preview-title">'.$filename_base.'<span class="wtbx-font-preview-count">'.sizeof($icons_arr).'</span></div>';
			echo '<div class="wtbx-font-preview-inner">';
			foreach ( $icons_arr as $key => $value ) { ?>
				<span class="wtbx-font-preview-icon <?php echo esc_attr($value); ?>"></span>
			<?php }
			echo '</div>';
			echo '</div>';
		}

	} else {
		wp_die( '<div class="error notice is-dismissible"><p>Could not create a folder for the custom font.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'scape') .'</span></button></div>' );
	}


	wp_die();

}

add_action('wp_ajax_unzip_icon_font', 'wtbx_unzip_icon_font');
add_action('wp_ajax_nopriv_unzip_icon_font', 'wtbx_unzip_icon_font');




if ( ! function_exists( 'wtbx_remove_icon_font' ) ) {
	function wtbx_remove_icon_font() {
		$font       = $_POST['font'];
		$upload_dir = wp_upload_dir();
		$dir        = untrailingslashit( $upload_dir['basedir'] . '/wtbx_icon_fonts/' . $font );

		wtbx_recursive_delete_directory($dir);

		if ( !wtbx_recursive_delete_directory($dir) ) {
			wp_die( '<div id="message" class="success"><p>Font deleted successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'scape') .'</span></button></div>' );
		} else {
			wp_die( '<div id="message" class="error"><p>Could not delete the font.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'. esc_html__('Dismiss this notice.', 'scape') .'</span></button></div>' );
		}
	}
}

add_action('wp_ajax_remove_icon_font', 'wtbx_remove_icon_font');
add_action('wp_ajax_nopriv_remove_icon_font', 'wtbx_remove_icon_font');