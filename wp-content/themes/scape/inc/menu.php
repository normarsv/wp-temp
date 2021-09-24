<?php

/*
* Custom Walker to remove all the wp_nav_menu junk
*/
class wtbx_clean_walker extends Walker_Nav_Menu
{
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $current_indicators = array('current-menu-parent', 'current_page_item', 'current_page_parent');

        $newClasses = array();

        foreach($classes as $el){
            //check if it's indicating the current page, otherwise we don't need the class
            if (in_array($el, $current_indicators)){
                array_push($newClasses, $el);
            }
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $newClasses), $item ) );
        if($class_names!='') $class_names = ' class="'. esc_attr( $class_names ) . '"';


        $output .= $indent . '<li' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';

        if($depth != 0)
        {
            //children stuff
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 *	Mega Menu 
 */
add_action('after_setup_theme', 'wtbx_mega_menu_init');
add_filter('wp_nav_menu_args', 'wtbx_mega_menu_walker' );

if (!defined('WTBX_MEGA_MENU_CLASS')) define('WTBX_MEGA_MENU_CLASS', 'WTBX_Mega_menu');
if (!defined('WTBX_EDIT_MENU_WALKER_CLASS')) define('WTBX_EDIT_MENU_WALKER_CLASS', 'WTBX_Edit_Menu_Walker');
if (!defined('WTBX_NAV_MENU_WALKER_CLASS')) define('WTBX_NAV_MENU_WALKER_CLASS', 'WTBX_Nav_Menu_Walker');

if (!function_exists('wtbx_mega_menu_init')) {
	function wtbx_mega_menu_init() {
		require_once locate_template('inc/menu/edit-mega-menu-walker.php');
		require_once locate_template('inc/menu/front-mega-menu-walker.php');
		require_once locate_template('inc/menu/mega-menu.php');
		
		$class = WTBX_MEGA_MENU_CLASS;
		$mega_menu = new $class();
	}
}

if (!function_exists('wtbx_mega_menu_walker')) {
	function wtbx_mega_menu_walker($args = '') {
		$metro_menu_walker['container'] = false;

		if (!$args['walker']) {
			$class = WTBX_NAV_MENU_WALKER_CLASS;
			$metro_menu_walker['walker'] = new $class();
		}

		return array_merge($args, $metro_menu_walker);
	}
}

