<?php
class WTBX_Nav_Menu_Walker extends Walker_Nav_Menu {
	private $_last_ul = '';
	
	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		$id_field = $this->db_fields['id'];

		if (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			$args[0]->wide_menu = ($depth==0 && !empty($element->_wtbx_mega_menu_enabled) && $element->_wtbx_mega_menu_enabled==1);
			$args[0]->full_width_menu = ($depth==0 && !empty($element->_wtbx_full_width_menu_enabled) && $element->_wtbx_full_width_menu_enabled==1);
			$args[0]->wtbx_mega_menu_image = ($depth==0 && !empty($element->_wtbx_mega_menu_image)) ? $element->_wtbx_mega_menu_image : '';
			$args[0]->wtbx_mega_menu_bg_position = ($depth==0 && !empty($element->_wtbx_mega_menu_bg_position)) ? $element->_wtbx_mega_menu_bg_position : '';
			$args[0]->wtbx_mega_menu_bg_repeat = ($depth==0 && !empty($element->_wtbx_mega_menu_bg_repeat)) ? $element->_wtbx_mega_menu_bg_repeat : '';
			$args[0]->wtbx_mega_menu_columns = ($depth==0 && !empty($element->_wtbx_mega_menu_columns) && $element->_wtbx_mega_menu_enabled==1) ? $element->_wtbx_mega_menu_columns : '';
			$args[0]->custom_class = !empty($element->_menu_item_classes) ? $element->_menu_item_classes : '';
			$args[0]->wtbx_mega_menu_opposite = !empty($element->_wtbx_mega_menu_opposite) ? $element->_wtbx_mega_menu_opposite : '';
			$args[0]->menu_item_object = (!empty($element->_menu_item_object) && $element->_menu_item_object == 'gs_sim');
		}

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}



	function start_lvl(&$output, $depth = 0, $args = array()) {
		$args = (object) $args;

		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0

		$classes = array(
			'menu-depth-' . $display_depth
		);

		if ($display_depth==1) {
			$classes[] = 'sub-menu';
			
			if ($args->wide_menu) {
				$classes[] = 'sub-menu-wide';
			}
			
			if ($args->full_width_menu) {
				$classes[] = 'sub-menu-full-width';
			}

			if ($args->wtbx_mega_menu_columns) {
				$classes[] = $args->wtbx_mega_menu_columns;
			}
			
		} else if ($display_depth >= 2) {
			$classes[] = 'sub-sub-menu';
		}
		$subnav_bg_image_url = !empty($args->wtbx_mega_menu_image) ? esc_attr($args->wtbx_mega_menu_image) : '';
		$subnav_bg_position = !empty($args->wtbx_mega_menu_bg_position) ? esc_attr($args->wtbx_mega_menu_bg_position) : 'center center';

		$subnav_bg_css = '';
		
		if ($args->wide_menu) {
			$subnav_bg_css .= ' style="';

			if(!empty($subnav_bg_image_url)) {
				$subnav_bg_css .= 'background-image: url('.$subnav_bg_image_url.');';

				if(!empty($subnav_bg_position)) {
					$subnav_bg_css .= 'background-position: '.$subnav_bg_position.';';
				}
			}

			$subnav_bg_css .= '"';
		}
		
		$prefix = '';
		if ($depth==0) {
			$prefix = '<div class="sub-menu' . ($args->wide_menu ? ' mega-menu-wrap' : '') . '"'.$subnav_bg_css.'>';
			$classes[] = 'sub-menu-group';

			if ($args->wide_menu && empty($subnav_bg_image_url)) {
				$classes[] = 'clearfix';
			}
		}
		
		$class_names = implode(' ', $classes);
		
		// build html output
		$output .= "\n" . $indent . $prefix . '<ul class="' . $class_names . '">' . "\n";
	}
	
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$args = (object) $args;

		$indent = str_repeat("\t", $depth);
		$postfix = '';
		if ($depth==0) {
			$postfix = '</div>';
		}
		
		$output .= "{$indent}</ul>{$postfix}\n";
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$args = (object) $args;

		// code indent
		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' );
		
		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'menu-item' : 'sub-menu-item' ),
			'menu-item-depth-' . $depth,
		);

		if (!empty($item->_wtbx_mega_menu_subtitle)  && ($depth>0)) {
			$depth_classes[] = 'mega-menu-item-has-subtitle';
		}
		
		if( isset($item->classes) && in_array("current-menu-ancestor", $item->classes)) {
			$depth_classes[] = 'current-menu-ancestor';
		}
		
		if( isset($item->classes) && in_array("current-menu-item", $item->classes)) {
			$depth_classes[] = 'current-menu-item';
		}
		
		if( isset($item->classes) && in_array("current-menu-parent", $item->classes) ) {
			$depth_classes[] = 'current-menu-parent';
		}

		// build html
		if ($args->has_children) {
			$depth_classes[] = 'has-submenu';
		}

		if (isset($args->wide_menu) && $args->wide_menu && $depth==0) {
			$depth_classes[] = 'mega-menu-item';
		}

		if ($depth==0) {
			if (isset($args->full_width_menu) && $args->full_width_menu) {
				$depth_classes[] = 'sub-menu-full-width';
			}
		}

		if ($depth==0) {
			if (isset($args->wtbx_mega_menu_opposite) && $args->wtbx_mega_menu_opposite) {
				$depth_classes[] = 'sub-menu-opposite';
			}
		}

		// add content_block class
		if ('content_block' === $item->object) {
			$depth_classes[] = 'menu-content-block';
		}

		$depth_class_names = esc_attr(implode(' ', $depth_classes));

		$custom_classes = isset($args->custom_class) ? $args->custom_class : array();
		(!empty($custom_classes)) ? $depth_class_names .= ' ' . implode( ' ', $custom_classes ) : null;

		$output .= $indent . '<li class="' . $depth_class_names . ' menu-item-' . $item->ID . '" data-id="menu-item-' . $item->ID . '">';

		// link attributes
		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .=!empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link item-title' ) . '"';

		$menu_icon = $item->_wtbx_mega_menu_icon;
		$icon = '';
		if ( $menu_icon !== '' ) {
			$menu_icon = json_decode($menu_icon, true);
			if ( json_last_error() === JSON_ERROR_NONE ) {
				$icon = !empty($menu_icon['icon']) ? '<i class="'.$menu_icon['icon'].'"></i>' : '';

				// if linea font
				if ( $menu_icon['font'] === 'linea' ) {
					$cat = '';
					require_once( WTBX_PLUGIN_PATH . 'include/icon-fonts/charmap.php' );
					$charmap = wtbx_vc_icon_font_linea();

					foreach( $charmap['icons'] as $category => $items ) {
						foreach ( $items as $id => $key ) {
							if ( array_key_exists($menu_icon['icon'], $key) ) {
								$cat = $category;
							}
						}
					}

					if ( $cat !== '' ) {
						$menu_icon['font'] = 'linea-' . strtolower(str_replace(' ', '-', $cat));
					}
				}

				wtbx_vc_enqueue_icon_font($menu_icon['font']);
			}
		}

		switch(true) {
			case ($depth == 0):

				if ( 'content_block' === $item->object ) {

				} else {
					$item_output = sprintf('%1$s<a%2$s>',
						$args->before, $attributes
					);

					$item_output .= sprintf('%s',
						apply_filters('the_title', $icon.$item->title, $item->ID)
					);

					$item_output .= sprintf('</a>%1$s',
						$args->after
					);
				}


				break;
			default:
				if ( 'content_block' === $item->object ) {
					$block = $item->object_id;
					$block = wtbx_get_translated_content_block($block);

					$s_ID = get_post($block);
					$content = $s_ID->post_content;
					$content = apply_filters('the_content', $content);
					$item_output = sprintf('%1$s%2$s%3$s',
						$args->before,
						$content,
						$args->after
					);
				} else {
					$item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
						$args->before,
						$attributes,
						$args->link_before,
						apply_filters('the_title', $icon.$item->title, $item->ID),
						$args->link_after,
						$args->after
					);
				}
		}

		// build html
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}