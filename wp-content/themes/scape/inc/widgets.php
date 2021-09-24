<?php
/*	
*	---------------------------------------------------------------------
*	WTBX Register sidebars
*	--------------------------------------------------------------------- 
*/

function wtbx_register_dynamic_sidebars() {

	$sidebars = wtbx_available_sidebars();

	if ( !empty($sidebars) ) {
		foreach ( $sidebars as $id => $name ) {
			if ( !empty($name) ) {
				register_sidebar(array(
					'name' => sprintf(esc_html__('%s', 'scape'), $name),
					'id' => 'wtbx_sidebar_' . $id,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => '</aside>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				));
			}
		}
	}
}

add_action( 'widgets_init', 'wtbx_register_dynamic_sidebars' );

?>