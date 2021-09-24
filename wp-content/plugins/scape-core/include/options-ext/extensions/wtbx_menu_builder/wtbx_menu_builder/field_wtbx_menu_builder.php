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
if( !class_exists( 'ReduxFramework_wtbx_menu_builder' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wtbx_menu_builder extends ReduxFramework {
    
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
	            $this->extension_url = trailingslashit( plugin_dir_url( __FILE__ ) );
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
	        $style  = $this->field['style'];
	        $menu   = wtbx_menu_builder_zones('style_' . $style);
	        $els    = wtbx_menu_builder_elements();
	        $value  = isset($this->value['value']) ? $this->value['value'] : '';
	        $items  = json_decode($value, true);

			$output  = '';
	        $output .= '<div class="wtbx_mb_wrapper wtbx_mb_style_'.$style.'">';

	        $output .= '<input type="hidden" class="wtbx_mb_value" name="' . $this->field['name'] . $this->field['name_suffix'] . '[value]" id="' . $this->parent->args['opt_name'] . '[' . $this->field['id'] . '][value]" value=\'' . $value . '\' />';

				$output .= '<div class="wtbx_mb_dropzone">';

					foreach ( $menu as $section => $options ) {
						$output .= '<div class="wtbx_mb_section wtbx_mb_section_'.$section.'" data-section="'.$section.'">';
						$output .= '<div class="wtbx_mb_section_label">'.$options['label'].'</div>';
						$output .= '<div class="wtbx_mb_section_inner clearfix">';

						if ( in_array($style, array('7', '10', '11')) && $section === 'header' ) {
							$output .= '<div class="wtbx_mb_area wtbx_mb_area_trigger"></div>';
						}

						if ( in_array($style, array('mobile')) && $section === 'top_header' ) {
							$output .= '<div class="wtbx_mb_area wtbx_mb_area_trigger"></div>';
						}

						foreach ( $options['areas'] as $area => $opts ) {
							$output .= '<div class="wtbx_mb_area wtbx_mb_area_'.$area.'" data-area="'.$area.'" data-restrict="' . ( isset($opts['restrict']) ? $opts['restrict'] : '' ) .'">';
							$output .= '<div class="wtbx_mb_area_label">'.$opts['label'].'</div>';
							$output .= '<div class="wtbx_mb_area_inner wtbx_mb_drop clearfix">';

							if ( isset($items[$section][$area]) ) {
								foreach ( (array) $items[$section][$area] as $item ) {
									$output .= '<div class="wtbx_mb_item wtbx_mb_el'.(isset($item['parent']) ? ' wtbx_mb_parent_' . $item['parent'] : '').' wtbx_mb_item_'.$item['id'].'" data-item="'.$item['id'].'" data-parent="'.(isset($item['parent']) ? $item['parent'] : '').'"' . (isset($item['nav']) ? ' data-nav="'.$item['nav'] . '"' : '') .' data-label="'.(isset($item['label']) ? $item['label'] : '').'">';
									$output .= '<div class="wtbx_mb_item_label">'.(isset($item['label']) ? $item['label'] : '').'</div><div class="wtbx_mb_item_remove"></div>';
									$output .= '</div>';
								}
							}

							$output .= '</div>';
							$output .= '</div>';
						}

						$output .= '</div>';
						$output .= '</div>';
					}

				$output .= '</div>';

	            $output .= '<div class="wtbx_mb_clear_wrapper"><div class="wtbx_mb_clear" data-confirm="'.esc_html__('Are you sure you want to remove all elements from this header.', 'core-extension').'">'.esc_html__('Remove all elements', 'core-extension').'</div></div>';

	            $output .= '<div class="wtbx_mb_items clearfix">';

	                foreach ( $els as $section => $options ) {
		                $output .= '<div class="wtbx_mb_item_cont">';
		                $output .= '<div class="wtbx_mb_item_cont_inner"><div class="wtbx_mb_item_cont_label">'.$options['label'].'</div>';

		                if ( sizeof($options['items']) > 0 ) {
			                foreach ( $options['items'] as $item => $props ) {
				                $output .= '<div class="wtbx_mb_item wtbx_mb_el wtbx_mb_parent_'.$section.' wtbx_mb_item_'.$props['id'].'" data-item="'.$props['id'].'" data-parent="'.$section.'"' . (isset($props['nav']) ? ' data-nav="'.$props['nav'] . '"' : '') .' data-label="'.$props['label'].'">';
				                $output .= '<div class="wtbx_mb_item_label">'.$props['label'].'</div><div class="wtbx_mb_item_remove"></div>';
				                $output .= '</div>';
			                }
		                } else {
			                $output .= '<div class="wtbx_mb_no_items">' . esc_html__('No items found', 'core-extension') . '</div>';
		                }

		                $output .= '</div>';
		                $output .= '</div>';
	                }

	            $output .= '</div>';


	        $output .= '</div>';


	        echo $output;
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

            $extension = ReduxFramework_extension_wtbx_menu_builder::getInstance();

            wp_enqueue_script(
                'redux-field-wtbx-menubuilder-js',
                $this->extension_url . 'field_wtbx_menu_builder.js',
                array( 'jquery' ),
                time(),
                true
            );

	        wp_enqueue_script('jquery-ui-core');
	        wp_enqueue_script( 'jquery-ui-droppable' );

            wp_enqueue_style(
                'redux-field-wtbx-menubuilder-css',
                $this->extension_url . 'field_wtbx_menu_builder.css',
                time(),
                true
            );
        
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
