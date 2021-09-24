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
if( !class_exists( 'ReduxFramework_wtbx_toggle' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wtbx_toggle extends ReduxFramework {
    
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
	        $defaults    = array(
		        'indent'   => '',
		        'style'    => '',
		        'class'    => '',
		        'title'    => '',
		        'subtitle' => '',
	        );
	        $this->field = wp_parse_args( $this->field, $defaults );

	        $guid = substr(uniqid(), 6, 7);

	        $add_class = '';
	        if ( isset( $this->field['indent'] ) &&  true === $this->field['indent'] ) {
		        $add_class = ' form-table-toggle-indented';
	        } elseif( !isset( $this->field['indent'] ) || ( isset( $this->field['indent'] ) && false !== $this->field['indent'] ) ) {
		        $add_class = " hide";
	        }

	        echo '<input type="hidden" id="' . esc_attr($this->field['id']) . '-marker"></td></tr></table>';

	        echo '<div id="toggle-' . esc_attr($this->field['id']) . '" class="redux-toggle-field redux-field ' . esc_attr($this->field['style']) . ' ' . esc_attr($this->field['class']) . ' ">';

	        if ( ! empty( $this->field['title'] ) ) {
		        echo '<h3>' . esc_html($this->field['title']) . '</h3>';
	        }

	        if ( ! empty( $this->field['subtitle'] ) ) {
		        echo '<div class="redux-toggle-desc">' . esc_html($this->field['subtitle']) . '</div>';
	        }

	        echo '</div><table id="toggle-table-' . esc_attr($this->field['id']) . '" data-id="' . esc_attr($this->field['id']) . '" class="form-table form-table-toggle no-border' . esc_attr($add_class) . '"><tbody><tr><th></th><td id="' . esc_attr($guid) . '">';

	        // delete the tr afterwards
	        ?>
	        <script type="text/javascript">
		        jQuery( document ).ready(
			        function() {
				        var $ = jQuery;
				        $( '#<?php echo esc_js($this->field['id']); ?>-marker' ).parents( 'tr:first' ).css( {display: 'none'} ).prev('tr' ).css('border-bottom','none');
				        var group = $( '#<?php echo esc_js($this->field['id']); ?>-marker' ).parents( '.redux-group-tab:first' );
				        if ( !group.hasClass( 'togglesChecked' ) ) {
					        group.addClass( 'togglesChecked' );
					        var test = group.find( '.redux-toggle-indent-start h3' );
					        $.each(
						        test, function( key, value ) {
							        $( value ).css( 'margin-top', '20px' )
						        }
					        );
					        if ( group.find( 'h3:first' ).css( 'margin-top' ) == "20px" ) {
						        group.find( 'h3:first' ).css( 'margin-top', '0' );
					        }
				        }

				        var $trigger = $( '#toggle-<?php echo esc_js($this->field['id']); ?>' );

				        $trigger.addClass('toggle-hidden');
				        $trigger.next('.form-table-toggle').toggleClass('toggle-hidden');

				        $trigger.on('click', function() {
					        $(this).toggleClass('toggle-hidden');
					        $(this).next('.form-table-toggle').toggleClass('toggle-hidden');
				        });
			        }
		        );
	        </script>
        <?php

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

            $extension = ReduxFramework_extension_wtbx_toggle::getInstance();

//            wp_enqueue_script(
//                'redux-field-wtbx-toggle-js',
//                $this->extension_url . 'field_wtbx_toggle.js',
//                array( 'jquery' ),
//                time(),
//                true
//            );

//            wp_enqueue_style(
//                'redux-field-wtbx-toggle-css',
//                $this->extension_url . 'field_wtbx_toggle.css',
//                time(),
//                true
//            );
        
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
