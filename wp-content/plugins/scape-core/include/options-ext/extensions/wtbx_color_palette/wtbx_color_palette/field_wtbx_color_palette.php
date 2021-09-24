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
if( !class_exists( 'ReduxFramework_wtbx_color_palette' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wtbx_color_palette extends ReduxFramework {
    
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
//		        'id'        => '',
//		        'url'       => '',
//		        'width'     => '',
//		        'height'    => '',
//		        'thumbnail' => '',
//		        'palette' => '',
	        );

	        $this->value = wp_parse_args( $this->value, $defaults );
	        $palette_array = $this->value;
	        echo '<div class="wtbx-color-palette-wrapper wtbx-color-palette-copy"><div class="el el-lines wtbx-handle"></div><span class="wtbx-color-name">' .esc_html__('Custom color ', 'core-extension' ). '</span><input data-id="color-palette-solid" name="' . $this->field['name'] . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-color" class="wtbx-colorpicker" type="text" value="" data-oldcolor="" data-default-color=""><div class="wtbx-color-remove" data-confirmation="'.esc_html__('Are you sure you want to remove this color from palette?', 'core-extension').'">'.esc_html__('Remove', 'core-extension').'</div></div>';
	        echo '<div class="wtbx-color-palette-container">';

	        $count = 1;

	        foreach ( $palette_array as $color_id => $color ) {
		        if ( $color !== '' ) {
			        echo '<div class="wtbx-color-palette-wrapper"><div class="el el-lines wtbx-handle"></div><span class="wtbx-color-name">' .esc_html__('Custom color ', 'core-extension' ) . $count . '</span><input data-id="' . $this->field['id'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '['.$color_id.']" id="' . $this->field['id'] . '-color" class="wtbx-colorpicker wtbx-colorpicker-init ' . $this->field['class'] . '"  type="text" value="'.$color.'" data-color="'.$color.'"  " /><div class="wtbx-color-remove" data-confirmation="'.esc_html__('Are you sure you want to remove this color from palette?', 'core-extension').'">'.esc_html__('Remove', 'core-extension').'</div></div>';
			        $count++;
		        }
	        }

	        echo '</div>';
	        
	        echo '<div class="wtbx-color-palette-footer">';
	        echo '<div class="button media_upload_button wtbx_color_palette_add" data-add_number="" data-el-id="">Add Color</div>';
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

            $extension = ReduxFramework_extension_wtbx_color_palette::getInstance();
        
            wp_enqueue_script(
                'redux-field-wtbx-color-palette-js',
                $this->extension_url . 'field_wtbx_color_palette.js',
                array( 'redux-field-color-js', 'wtbx-spectrum' ),
                time(),
                true
            );

//            wp_enqueue_style(
//                'redux-field-wtbx-color-palette-css',
//                $this->extension_url . 'field_wtbx_color_palette.css',
//                time(),
//                true
//            );

	        if ($this->parent->args['dev_mode']) {
		        wp_enqueue_style( 'redux-color-picker-css' );
	        }

//	        wp_enqueue_style( 'wp-color-picker' );

	        wp_enqueue_script(
		        'redux-field-color-rgba-js',
		        ReduxFramework::$_url . 'inc/fields/color_rgba/field_color_rgba' . Redux_Functions::isMin() . '.js',
		        array('jquery', 'wtbx-spectrum'),
		        time(),
		        true
	        );

	        wp_enqueue_script(
		        'redux-field-color-js',
		        ReduxFramework::$_url . 'inc/fields/color/field_color' . Redux_Functions::isMin() . '.js',
		        array( 'jquery', 'wtbx-spectrum', 'redux-js' ),
		        time(),
		        true
	        );

	        // Spectrum CSS
//	        if (!wp_style_is ( 'redux-spectrum-css' )) {
//		        wp_enqueue_style('redux-spectrum-css');
//	        }

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
