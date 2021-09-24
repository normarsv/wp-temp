<?php

if (!class_exists('WTBX_Mega_menu')) {
	class WTBX_Mega_menu {
		var $_options;

		public function __construct() {
			$this->_options = self::options();
			$this->_add_filters();
		}
		
		public static function options() {
			return array(
				'_wtbx_mega_menu_icon'		=> array(
						'type' => 'hidden',
						'label' => esc_html__( 'Icon', 'scape' ),
						'default' => '',
						'size' => 'wide',
					),
				'_wtbx_mega_menu_enabled'	=> array(
						'type' => 'select',
						'label' => esc_html__( 'Enable mega menu', 'scape' ),
						'default' => 0,
						'options' => array(1=>esc_html__( 'Yes', 'scape' ), 0=>esc_html__( 'No', 'scape' )),
						'size' => 'thin',
						'class' => 'wtbx-sd-0',
					),
				'_wtbx_full_width_menu_enabled'	=> array(
						'type' => 'select',
						'label' => esc_html__( 'Enable full-width menu', 'scape' ),
						'default' => 0,
						'options' => array(1=>esc_html__( 'Yes', 'scape' ), 0=>esc_html__( 'No', 'scape' )),
						'size' => 'thin',
						'class' => 'wtbx-sd-0',
					),
				'_wtbx_mega_menu_opposite'	=> array(
					'type' => 'select',
					'label' => esc_html__('3rd level menu on the opposite side', 'scape'),
					'options' => array(1=>esc_html__( 'Yes', 'scape' ), 0=>esc_html__( 'No', 'scape' )),
					'default' => 0,
					'size' => 'wide',
					'class' => 'wtbx-sd-0',
					),
				'_wtbx_mega_menu_image'	=> array(
					'type' => 'upload',
					'label' => esc_html__('Image', 'scape'),
					'default' => '',
					'size' => 'wide',
					'class' => 'wtbx-sd-0',
					),
				'_wtbx_mega_menu_bg_position'	=> array(
					'type' => 'select',
					'label' => esc_html__( 'Background position', 'scape' ),
					'default' => 0,
					'options' => array(
						'left top' => esc_html__('Left top', 'scape'),
						'left center' => esc_html__('Left center', 'scape'),
						'left bottom' => esc_html__('Left bottom', 'scape'),
						'right top' => esc_html__('Right top', 'scape'),
						'right center' => esc_html__('Right center', 'scape'),
						'right bottom' => esc_html__('Right bottom', 'scape'),
						'center top' => esc_html__('Center top', 'scape'),
						'center center' => esc_html__('Center center', 'scape'),
						'center bottom' => esc_html__('Center bottom', 'scape')
					),
					'size' => 'thin',
					'class' => 'wtbx-sd-0',
				),
				'_wtbx_mega_menu_columns'	=> array(
					'type' => 'select',
					'label' => esc_html__( 'Number of equal columns', 'scape' ),
					'default' => 'no-repeat',
					'options' => array(
						'' =>esc_html__( 'Disable equal columns', 'scape' ),
						'mega-menu-col-1' =>esc_html__( '1', 'scape' ),
						'mega-menu-col-2' =>esc_html__( '2', 'scape' ),
						'mega-menu-col-3' =>esc_html__( '3', 'scape' ),
						'mega-menu-col-4' =>esc_html__( '4', 'scape' ),
						'mega-menu-col-5' =>esc_html__( '5', 'scape' ),
						'mega-menu-col-6' =>esc_html__( '6', 'scape' ),
					),
					'size' => 'thin',
					'class' => 'wtbx-sd-0',
				),
			);
		}

		private function _add_filters() {
			# Add custom options to menu
			add_filter('wp_setup_nav_menu_item', array($this, 'add_custom_options'));

			# Update custom menu options
			add_action('wp_update_nav_menu_item', array($this, 'update_custom_options'), 10, 3);

			# Set edit menu walker
			add_filter('wp_edit_nav_menu_walker', array($this, 'apply_edit_walker_class'), 10, 2);
			
			# Addition style
			add_action('admin_enqueue_scripts', array( $this, 'add_menu_css' ));
			
			# Addition js
			add_action('admin_head-nav-menus.php', array( $this, 'add_icon_js' ));

			# Mega menu javascript
			add_action('admin_enqueue_scripts', array( $this, 'wtbx_mega_menu_admin_scripts' ), 80);
		}
		
		
 
		function wtbx_mega_menu_admin_scripts() {
			wp_enqueue_media();
			wp_enqueue_script('scape-menu-image-js', get_template_directory_uri().'/inc/menu/js/image-upload.js', array('jquery'));
		}
		

		/**
		 * Register custom options and load options values
		 * 
		 * @param obj $item Menu Item
		 * @return obj Menu Item
		 */
		public function add_custom_options($item) {

			foreach($this->_options as $option => $params) {
				$item->$option = get_post_meta($item->ID, $option, true);
				if ($item->$option===false) {
					$item->$option = $params['default'];
				}
			}

			return $item;
		}

		public function update_custom_options($menu_id, $menu_item_id, $args) {
			foreach($this->_options as $option => $params) {
				$key = 'menu-item-'. $option;
				
				$option_value = '';
				
				if (isset($_REQUEST[$key], $_REQUEST[$key][$menu_item_id])) {
					$option_value = $_REQUEST[$key][$menu_item_id];
				}
				
				update_post_meta($menu_item_id, $option, $option_value );
			}
		}

		public function apply_edit_walker_class( $walker, $menu_id ) {
			return WTBX_EDIT_MENU_WALKER_CLASS;
		}
		
		public function add_menu_css() {
			$css = "
				.menu-item .wtbx-sd-0 { display: none; }
				.menu-item.menu-item-depth-0 .wtbx-sd-0 { display: block; }
				.menu-item .wtbx-show-only-depth-1 { display: none; }
				.menu-item.menu-item-depth-1 .wtbx-show-only-depth-1 { display: block; }
				.menu-item .wtbx-hd-0 { display: block; }
				.menu-item.menu-item-depth-0 .wtbx-hd-0 { display: none; }
			";
			wp_add_inline_style('wp-admin', $css);
		}
		
		public function add_icon_js() {
			echo '<script type="text/javascript">'
					. 'jQuery(document).ready(function($) {'
					. '"use strict";'
//					. '$("#menu-to-edit").unbind("DOMNodeInserted.wtbx").bind("DOMNodeInserted.wtbx", function(e) {
//					    console.log(e.target);
//					});'
					. 'setTimeout(function(){'
					. 'var menu_icon = $("input.edit-menu-item-_wtbx_mega_menu_icon");'
					. 'if (0 == menu_icon.siblings("a").length && false == menu_icon.hasClass("wtbx-iconname")) {'
					. 'menu_icon.addClass("wtbx-iconname").after("<div class=\"wtbx-menu-icon-wrapper\"><div class=\"wtbx-selected-icon\"></div><a href=\"#\" class=\"button wtbx-add-icon\">'.esc_html__('Select icon', 'scape').'</a><div class=\"button wtbx-delete-icon\">'.esc_html__('Remove icon', 'scape').'</div></div>");'
					. '}'
					. '},1000);'
					. '});'
					. '</script>';
		}
	}
}
