<?php

add_action('after_setup_theme', 'wtbx_i_plugin_init');

if (!function_exists('wtbx_i_plugin_init')) {
	function wtbx_i_plugin_init() {
		// Enqueue admin scripts and styles
		add_action('admin_enqueue_scripts', 'wtbx_i_plugin_admin_scripts');
	}
}

if (!function_exists('wtbx_i_plugin_scripts')) {
	function wtbx_i_plugin_scripts() {
		wp_enqueue_style('scape-icon-font-style', get_template_directory_uri() . '/inc/icons/css/icon-font-style.css', false, '', 'all' );
	}
}

if (!function_exists('wtbx_i_plugin_admin_scripts')) {
	function wtbx_i_plugin_admin_scripts() {
		wp_enqueue_style( 'scape-icon-generator', get_template_directory_uri() . '/inc/icons/css/generator.css', false, '', 'all' );
		wp_enqueue_script( 'scape-icon-generator', get_template_directory_uri() . '/inc/icons/js/generator.js', array( 'jquery' ), '', false );
	}
}


/*
*	---------------------------------------------------------------------
*	Plugin URL
*	---------------------------------------------------------------------
*/

function wtbx_i_plugin_url() {
	return locate_template('/inc/icons/icons.php');
}

/*
*	---------------------------------------------------------------------
*	Icon generator box
*	---------------------------------------------------------------------
*/

function wtbx_i_generator() {
	?>
	<div id="wtbx-generator-overlay" class="wtbx-overlay-bg"></div>
	<div id="wtbx-generator-wrap">
		<div id="wtbx-generator">
			<a href="#" id="wtbx-generator-close"><span class="wtbx-close-icon"></span></a>
			<div id="wtbx-generator-shell">
				<div class="wtbx-generator-icon-select">
					<?php
					if ( class_exists('SCAPE_Core_Extend') ) {
						require_once( WTBX_PLUGIN_PATH . 'include/icon-fonts/charmap.php' );
						$custom_fonts = wtbx_option('custom_icon_font');
						$upload_dir = wp_upload_dir();
						$output = '';

						$all_fonts['scape-basic']        = wtbx_vc_icon_font_scape_basic();
						$all_fonts['scape-controls']     = wtbx_vc_icon_font_scape_controls();
						$all_fonts['scape-devices']      = wtbx_vc_icon_font_scape_devices();
						$all_fonts['scape-media']        = wtbx_vc_icon_font_scape_media();
						$all_fonts['scape-tech']         = wtbx_vc_icon_font_scape_tech();
						$all_fonts['scape-business']     = wtbx_vc_icon_font_scape_business();
						$all_fonts['scape-entertainment']= wtbx_vc_icon_font_scape_entertainment();
						$all_fonts['scape-objects']      = wtbx_vc_icon_font_scape_objects();
						$all_fonts['scape-brands']       = wtbx_vc_icon_font_scape_brands();
						$all_fonts['scape-people']       = wtbx_vc_icon_font_scape_people();
						$all_fonts['scape-occasions']    = wtbx_vc_icon_font_scape_occasions();
						$all_fonts['fontawesome']       = wtbx_vc_icon_font_fontawesome();
						$all_fonts['simplelineicons']   = wtbx_vc_icon_font_simplelineicons();
						$all_fonts['linea']             = wtbx_vc_icon_font_linea();

						if ( !empty($custom_fonts) ) {

							$fonts = json_decode($custom_fonts['folder'], true);

							if ( !empty($fonts) ) {
								foreach ($fonts as $font) {
									global $wp_filesystem;

									if ( empty( $wp_filesystem ) ) {
										require_once ABSPATH . '/wp-admin/includes/file.php';
										WP_Filesystem();
									}

									$path = untrailingslashit($upload_dir['basedir'] . '/wtbx_icon_fonts/' . $font);

									if ($wp_filesystem->exists($path . '/charmap.json')) {
										$charmap = $wp_filesystem->get_contents($path . '/charmap.json');
										$charmap = json_decode($charmap, true);
										$all_fonts[$charmap['name']] = $charmap;
									}
								}
							}

						}

						// render option field
						$output .= '<div class="wtbx-library-select-wrapper"><select id="wtbx-library-select">';
						if (!empty($all_fonts)) {
							foreach ($all_fonts as $font) {
								$name = $font['name'];
								$label = $font['label'];
								$output .= '<option value="' . esc_attr($name) . '">' . esc_html($label) . '</option>' . "\n";
							}
						}
						$output .= '</select>';
						$output .= '</div>';

						if (!empty($all_fonts)) {
							foreach ($all_fonts as $font) {
								$output .= '<div class="wtbx-icon-list ' . esc_attr($font['name']) . '">';

								$css_dir = array();

								if ($font['name'] === 'linea' ) {
									foreach ($font['icons'] as $category => $icons) {
										$css_dir[] = WTBX_PLUGIN_URL . 'include/icon-fonts/' . $font['name'] . '/font/' . strtolower(str_replace(' ', '-', $category)) . '/linea-'.strtolower(str_replace(' ', '-', $category)).'.css';

										$output .= '<div class="wtbx_vc_icon_font_category">' . esc_html($category) . '</div>';
										$output .= '<ul class="wtbx_vc_icon_font_icons">';

										foreach ($icons as $icon) {
											foreach ($icon as $name => $label) {
												$output .= '<li class="wtbx-font-preview-icon"><input type="radio" name="icons" value="' . esc_attr($name) . '" id="' . esc_attr($name) . '"><label title="' . esc_attr($label) . '" for="' . esc_attr($name) . '"><i class="' . esc_attr($name) . '"></i></label></li>';
											}
										}

										$output .= '</ul>';
									}
								} elseif ($font['name'] === 'fontawesome' || strpos('scape-', $font['name']) !== false ) {
									$css_dir[] = WTBX_PLUGIN_URL . '/include/icon-fonts/' . $font['name'] . '/' . $font['name'] . '.min.css';

									foreach ($font['icons'] as $category => $icons) {

										$output .= '<div class="wtbx_vc_icon_font_category">' . esc_attr($category) . '</div>';
										$output .= '<ul class="wtbx_vc_icon_font_icons">';

										foreach ($icons as $icon) {
											foreach ($icon as $name => $label) {
												$output .= '<li class="wtbx-font-preview-icon"><input type="radio" name="icons" value="' . esc_attr($name) . '" id="' . esc_attr($name) . '"><label title="' . esc_attr($label). '" for="' . esc_attr($name) . '"><i class="' . esc_attr($name) . '"></i></label></li>';
											}
										}

										$output .= '</ul>';
									}
								} elseif ( is_array($custom_fonts) && in_array($font['name'], (array) json_decode($custom_fonts['folder'], true)) ) {

									// load font css stylesheets
									$css_dir[] = $upload_dir['baseurl'] . '/wtbx_icon_fonts/' . esc_html($font['name']) . '/style.css';

									$output .= '<div class="wtbx-font-preview-title">' . esc_html($font['label']) . '</div>';
									$output .= '<ul class="wtbx_vc_icon_font_icons">';
									foreach ($font['icons'] as $name => $label) {
										$output .= '<li class="wtbx-font-preview-icon"><input type="radio" name="icons" value="' . esc_attr($name) . '" id="' . esc_attr($name) . '"><label title="' . esc_attr($label) . '" for="' . esc_attr($name) . '"><i class="' . esc_attr($name) . '"></i></label></li>';

									}
									$output .= '</ul>';

								} else {
									$css_dir[] = WTBX_PLUGIN_URL . 'include/icon-fonts/' . esc_html($font['name']) . '/' . esc_html($font['name']) . '.min.css';

									$output .= '<div class="wtbx-font-preview-title">' . esc_html($font['label']) . '</div>';
									$output .= '<ul class="wtbx_vc_icon_font_icons">';

									if ( isset($font['icons']) ) {
										foreach ($font['icons'] as $icon) {
											foreach ($icon as $name => $label) {
												$output .= '<li class="wtbx-font-preview-icon"><input type="radio" name="icons" value="' . esc_attr($name) . '" id="' . esc_attr($name) . '"><label title="' . esc_attr($label) . '" for="' . esc_attr($name) . '"><i class="' . esc_attr($name) . '"></i></label></li>';
											}
										}
									}

									$output .= '</ul>';

								}

								$output .= '<script>jQuery(document).ready(function($) {';
								foreach ( $css_dir as $dir ) {
									$output .= '$("head").append("<link type=\"text/css\" rel=\"stylesheet\" href=\"' . esc_url($dir) . '\"/>");';
								}
								$output .= '});</script>';

								$output .= '</div>';
							}
						}

						$output_escaped = $output;

						// This variable contains dynamic values that have been safely escaped above
						echo $output_escaped;?>
					</div>
				<?php } ?>
			</div>

			<input name="wtbx-generator-insert" type="submit" class="button button-primary button-large" id="wtbx-generator-insert" value="Insert Icon">
		</div>
	</div>

<?php
}

add_action( 'admin_footer', 'wtbx_i_generator' );

?>