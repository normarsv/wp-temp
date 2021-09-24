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
if( !class_exists( 'ReduxFramework_wtbx_sidebars' ) ) {

	/**
	 * Main ReduxFramework_custom_field class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework_wtbx_sidebars extends ReduxFramework {

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

			$this->add_text   = ( isset( $this->field['add_text'] ) ) ? $this->field['add_text'] : esc_html__( 'Add More', 'core-extension' );
			$this->show_empty = ( isset( $this->field['show_empty'] ) ) ? $this->field['show_empty'] : true;

			///////////////////////

			if ( empty( $this->field['mode'] ) ) {
				$this->field['mode'] = "text";
			}

			if ( $this->field['mode'] != "checkbox" && $this->field['mode'] != "text" ) {
				$this->field['mode'] = "text";
			}

			$class   = ( isset( $this->field['class'] ) ) ? $this->field['class'] : '';

			echo '<ul id="' . $this->field['id'] . '-list" class="redux-wtbx_sidebars wtbx-text-sortable ' . $class . '">';

			$name  = 'name="' . $this->field['name'] . $this->field['name_suffix'] . '" ';
			echo '<li class="wtbx-text-sortable-item wtbx-text-sortable-copy">';
			echo '<span class="compact drag wtbx-handle"><i class="el el-lines"></i></span>';
			echo '<input class="' . $class . '" type="' . $this->field['mode'] . '" ' . $name . 'id="' . $this->field['id'].'" value="" />';
			echo '<a href="javascript:void(0);" class="deletion wtbx-text-sortable-item-remove" data-confirmation="'.esc_html__('Are you sure you want to remove this sidebar? This will remove this sidebar from all pages it is displayed on with all the widgets it contains.', 'core-extension').'">' . esc_html__( 'Remove', 'core-extension' ) . '</a>';
			echo '</li>';

			$add_number = 1;

			if ( !empty($this->value) ) {
				foreach ( $this->value as $k => $nicename ) {
					$name = 'name="' . $this->field['name'] . $this->field['name_suffix'] . '[' . $k . ']' . '" ';
					$value_display = isset( $this->value[ $k ] ) ? $this->value[ $k ] : '';
					if ( isset($this->field['options'][$k]) ) {
						$nicename = $this->field['options'][$k];
					}

					if ( $k > $add_number ) {
						$add_number = $k;
					}

					if ( !empty($value_display) ) {
						echo '<li class="wtbx-text-sortable-item">';
						echo '<span class="compact drag wtbx-handle"><i class="el el-lines"></i></span>';
						echo '<input rel="' . $this->field['id'] . '-' . $k . '-hidden" class="' . $class . '" type="' . $this->field['mode'] . '" ' . $name . 'id="' . $this->field['id'] . '[' . $k . ']" value="' . esc_attr( $value_display ) . '" placeholder="' . esc_attr__('Field name', 'core-extension') . '" />';
						echo '<a href="javascript:void(0);" class="deletion wtbx-text-sortable-item-remove" data-confirmation="'.esc_html__('Are you sure you want to remove this sidebar? This will remove this sidebar from all pages it is displayed on with all the widgets it contains.', 'core-extension').'">' . esc_html__( 'Remove', 'core-extension' ) . '</a>';
						echo '</li>';
					}
				}
			}

			echo '</ul>';

			echo '<div class="wtbx-text-sortable-footer"><a href="javascript:void(0);" class="button button-primary wtbx_sidebars-add wtbx-text-sortable-add" data-add_number="' . ($add_number + 1) . '" data-id="' . $this->field['id'] . '-list" data-name="' . $this->field['name'] . $this->field['name_suffix'] . '" data-el-id="' . $this->field['id'] . '">' . $this->add_text . '</a></div>';

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

			$extension = ReduxFramework_extension_wtbx_sidebars::getInstance();

			wp_enqueue_script(
				'redux-field-wtbx-sidebars-js',
				$this->extension_url . 'field_wtbx_sidebars.js',
				array( 'jquery' ),
				time(),
				true
			);

//			wp_enqueue_style(
//				'redux-field-wtbx-sidebars-css',
//				$this->extension_url . 'field_wtbx_sidebars.css',
//				time(),
//				true
//			);

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
