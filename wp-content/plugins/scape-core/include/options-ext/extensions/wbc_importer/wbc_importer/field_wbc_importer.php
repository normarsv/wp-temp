<?php
/**
 * Extension-Boilerplate
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_wbc_importer' ) ) {

    /**
     * Main ReduxFramework_wbc_importer class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wbc_importer {

        /**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            $class = ReduxFramework_extension_wbc_importer::get_instance();

            if ( !empty( $class->demo_data_dir ) ) {
                $this->demo_data_dir = trailingslashit( str_replace( '\\', '/',  $class->demo_data_dir ) );
//                $this->demo_data_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->demo_data_dir ) );
	            $this->demo_data_url = plugin_dir_url( dirname(__FILE__) )  . 'demo-data/';
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
//                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
	            $this->extension_url = plugin_dir_url( __FILE__ );
            }
        }

        /**
         * Field Render Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

	        if ( SCAPE_Core_Extend::is_theme_activated() ) {

		        echo '</fieldset></td></tr><tr><td colspan="2"><fieldset class="redux-field wbc_importer">';

		        $nonce = wp_create_nonce("redux_{$this->parent->args['opt_name']}_wbc_importer");

		        // No errors please
		        $defaults = array(
			        'id' => '',
			        'url' => '',
			        'width' => '',
			        'height' => '',
			        'thumbnail' => '',
		        );

		        $this->value = wp_parse_args($this->value, $defaults);

		        $imported = false;

		        $this->field['wbc_demo_imports'] = apply_filters("redux/{$this->parent->args['opt_name']}/field/wbc_importer_files", array());

		        echo '<div class="theme-browser">';

		        echo '<div class="importer-popup">';
		        echo '<div class="importer-popup-backdrop"></div>';
//		        echo '<div class="importer-popup-container">';
		        echo '<div class="importer-popup-frame">';
		        echo '<img src="#" class="importer-popup-preview" />';
		        echo '<div class="importer-popup-content">';

		        echo '<div class="importer-popup-label">' . esc_html__('Plugins used in this demo:', 'core-extension') . '</div>';
		        echo '<div class="importer-popup-hint">' . esc_html__('To ensure that all associated data is imported, please enable all the plugins mentioned below before running demo import.', 'core-extension') . '</div>';
		        echo '<div class="importer-popup-plugins"></div>';

		        echo '<div class="importer-popup-label">' . esc_html__('Choose import options:', 'core-extension') . '</div>';
		        echo '<div class="importer-popup-options"></div>';

		        echo '<div class="importer-button importer-popup-import">' . esc_html__('Import Demo Data', 'core-extension') . '</div>';

//		        echo '</div>';
		        echo '</div>';
		        echo '</div>';
		        echo '</div>';


		        echo '<div class="themes">';

		        if (!empty($this->field['wbc_demo_imports'])) {

			        foreach ($this->field['wbc_demo_imports'] as $section => $imports) {

				        if (empty($imports)) {
					        continue;
				        }

				        if (!array_key_exists('imported', $imports)) {
					        $extra_class = 'not-imported';
					        $imported = false;
					        $import_message = esc_html__('Import Demo', 'core-extension');
				        } else {
					        $imported = true;
					        $extra_class = 'active imported';
					        $import_message = esc_html__('Demo Imported', 'core-extension');
				        }
				        echo '<div class="wrap-importer theme ' . $extra_class . '" data-demo-id="' . esc_attr($section) . '"  data-nonce="' . $nonce . '" id="' . $this->field['id'] . '-custom_imports" data-plugins="' . esc_attr($imports['plugins']) . '" data-options="' . esc_attr($imports['options']) . '">';

				        echo '<div class="theme-screenshot">';

				        if (isset($imports['image'])) {
					        echo '<img class="wbc_image" src="' . esc_url($this->demo_data_url . $imports['directory'] . '/' . $imports['image']) . '"/>';

				        }
				        echo '</div>';

//                    echo '<span class="more-details">'.$import_message.'</span>';
				        echo '<h3 class="theme-name">' . esc_html(apply_filters('wbc_importer_directory_title', $imports['directory'])) . '</h3>';

				        echo '<div class="theme-actions">';
				        if (false == $imported) {
					        echo '<div class="wbc-importer-buttons"><span class="importer-button import-demo-data">' . esc_html__('Import Demo', 'core-extension') . '</span></div>';
				        } else {
					        echo '<div class="wbc-importer-buttons importer-button imported">' . esc_html__('Imported', 'core-extension') . '</div>';
					        echo '<div id="wbc-importer-reimport" class="wbc-importer-buttons import-demo-data importer-button">' . esc_html__('Re-Import', 'core-extension') . '</div>';
				        }
				        echo '<a href="//themes.whiteboxstud.io/scape/'.esc_attr(basename($imports['directory'])).'" target="_blank" class="wbc-importer-preview">Demo Preview</a>';
				        echo '</div>';
				        echo '</div>';


			        }

		        } else {
			        echo "<h5>" . esc_html__('No Demo Data Provided', 'core-extension') . "</h5>";
		        }

		        echo '</div></div>';
		        echo '</fieldset></td></tr>';

	        }

        }

        /**
         * Enqueue Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            $min = Redux_Functions::isMin();

            wp_enqueue_script(
                'redux-field-wbc-importer-js',
                $this->extension_url . '/field_wbc_importer' . $min . '.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-wbc-importer-css',
                $this->extension_url . 'field_wbc_importer.css',
                time(),
                true
            );

        }
    }
}
