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
if( !class_exists( 'ReduxFramework_wtbx_icon_font' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wtbx_icon_font extends ReduxFramework {
    
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
//                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
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
		        'id'        => '',
		        'url'       => '',
		        'width'     => '',
		        'height'    => '',
		        'thumbnail' => '',
	        );

	        $this->value = wp_parse_args( $this->value, $defaults );

	        if (isset($this->field['mode']) && $this->field['mode'] == false) {
		        $this->field['mode'] = 0;
	        }

	        if ( ! isset( $this->field['mode'] ) ) {
		        $this->field['mode'] = "image";
	        }

	        if (!isset($this->field['library_filter'])) {
		        $libFilter = '';
	        } else {
		        if (!is_array($this->field['library_filter'])) {
			        $this->field['library_filter'] = array($this->field['library_filter']);
		        }

		        $mimeTypes = get_allowed_mime_types();

		        $libArray = $this->field['library_filter'];

		        $jsonArr = array();

		        // Enum mime types
		        foreach ($mimeTypes as $ext => $type) {
			        if (strpos($ext,'|')) {
				        $expArr = explode('|', $ext);

				        foreach($expArr as $ext){
					        if (in_array($ext, $libArray )) {
						        $jsonArr[$ext] = $type;
					        }
				        }
			        } elseif (in_array($ext, $libArray )) {
				        $jsonArr[$ext] = $type;
			        }

		        }

		        $libFilter = urlencode(json_encode($jsonArr));
	        }

	        if ( empty( $this->value ) && ! empty( $this->field['default'] ) ) { // If there are standard values and value is empty
		        if ( is_array( $this->field['default'] ) ) {
			        if ( ! empty( $this->field['default']['id'] ) ) {
				        $this->value['id'] = $this->field['default']['id'];
			        }

			        if ( ! empty( $this->field['default']['url'] ) ) {
				        $this->value['url'] = $this->field['default']['url'];
			        }
		        } else {
			        if ( is_numeric( $this->field['default'] ) ) { // Check if it's an attachment ID
				        $this->value['id'] = $this->field['default'];
			        } else { // Must be a URL
				        $this->value['url'] = $this->field['default'];
			        }
		        }
	        }

	        $fonts = !empty( $this->value['folder'] ) ? $this->value['folder'] : array();
	        $upload_dir = wp_upload_dir();

	        // delete icon font folders if there were left any
	        // due to not saving Theme Options after the font was added

	        $fonts_to_check = !empty($fonts) ? json_decode($fonts) : array();

	        if( file_exists( $upload_dir['basedir'] . '/wtbx_icon_fonts/' ) ) {
		        $objects = scandir($upload_dir['basedir'] . '/wtbx_icon_fonts/' );

		        // check for odd font folders and delete if there are any
		        foreach ($objects as $object) {
			        if ($object != "." && $object != "..") {
				        if (filetype($upload_dir['basedir'] . '/wtbx_icon_fonts/' . $object) == "dir" && !in_array($object, $fonts_to_check)) {
					        wtbx_recursive_delete_directory($upload_dir['basedir'] . '/wtbx_icon_fonts/' . $object);
				        }
			        }
		        }

		        // check odd fonts saved and delete if there are any
		        if ( !empty($fonts_to_check) ) {
			        foreach ($fonts_to_check as $font_to_check) {
				        if (!in_array($font_to_check, $objects)) {
					        unset($fonts_to_check[array_search($font_to_check,$fonts_to_check)]);
					        $this->value['folder'] = json_encode($fonts_to_check);
				        }
			        }
		        }
            }

	        echo '<input type="hidden" class="custom_icon_font_folder" name="' . $this->field['name'] . $this->field['name_suffix'] . '[folder]" id="' . $this->parent->args['opt_name'] . '[' . $this->field['id'] . '][folder]" value=\'' . ( !empty($this->value['folder']) ? $this->value['folder'] : '') . '\' />';

	        //Upload controls DIV
	        echo '<div class="upload_button_div">';

	        //If the user has WP3.5+ show upload/remove button
	        echo '<span class="button button-primary media_upload_button" id="' . $this->field['id'] . '-media" data-select="'.esc_html__('Insert Icon Font .Zip File', 'core-extension').'">' . esc_html__( 'Upload new icon font', 'core-extension' ) . '</span>';

	        echo '</div>';

			// icon font preview
	        echo    '<div class="wtbx-font-preview-container">';

	        // load icon fonts preview
	        if ( !empty($fonts) ) {
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

		        $fonts = json_decode($fonts);

		        if ( !empty($fonts) ) {

			        foreach ( $fonts as $font ) {

				        $path = untrailingslashit( $upload_dir['basedir'] . '/wtbx_icon_fonts/' . $font );

				        if ( $wp_filesystem->exists( $path . '/charmap.json' ) ) {

					        $charmap  = $wp_filesystem->get_contents( $path.'/charmap.json' );
					        $charmap  = json_decode($charmap, true);

					        $css_dir = $upload_dir['baseurl'] . '/wtbx_icon_fonts/' . $font . '/style.css';

					        echo '<script>
									jQuery(document).ready(function($) {
										$("head").append("<link type=\"text/css\" rel=\"stylesheet\" href=\"'.$css_dir.'\"/>");
									});
								</script>';

					        if ( !empty($charmap) ) {

						        echo '<div class="wtbx-font-preview" data-font="'.$font.'">';
						        echo '<div class="wtbx-font-preview-remove" data-remove="'.$font.'" data-confirmation="'.esc_html__('Are you sure you want to remove this font?', 'core-extension').'">'.esc_html__('Remove', 'core-extension').'</div>';
						        echo '<div class="wtbx-font-preview-title">'.$font.'<span class="wtbx-font-preview-count">'.sizeof($charmap['icons']).'</span></div>';
						        echo '<div class="wtbx-font-preview-inner">';
						        foreach ( $charmap['icons'] as $key => $value ) { ?>
							        <span class="wtbx-font-preview-icon <?php echo esc_attr($key); ?>"></span>
						        <?php }
						        echo '</div>';
						        echo '</div>';
					        }

				        }
			        }
		        }
	        }

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

            $extension = ReduxFramework_extension_wtbx_icon_font::getInstance();
        
            wp_enqueue_script(
                'redux-field-wtbx-icon-font-js',
                $this->extension_url . 'field_wtbx_icon_font.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-wtbx-icon-font-css',
                $this->extension_url . 'field_wtbx_icon_font.css',
                time(),
                true
            );

			$ajax_url = array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			);
			wp_localize_script( 'redux-field-wtbx-icon-font-js', 'wtbx_icon_font_ajax', $ajax_url );
        
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
