<?php

// Register Portfolio Custom Post Type
function wtbx_portfolio_post_type() {

	$portfolio_cpt = (function_exists('wtbx_vc_option')) ? wtbx_vc_option('portfolio-custom-slug') : '';

	$base = (isset($portfolio_cpt) && $portfolio_cpt !== '') ? strtolower($portfolio_cpt) : 'portfolio';
	$label = ucfirst($base);

	$labels = array(
		'name'                => sprintf(esc_html__('%s', 'core-extension' ), $label),
		'singular_name'       => sprintf(esc_html__('Project', 'core-extension' ), $label),
		'menu_name'           => sprintf(esc_html__('%s', 'core-extension' ), $label),
		'parent_item_colon'   => __( 'Parent Item:', 'core-extension' ),
		'all_items'           => __( 'All Items', 'core-extension' ),
		'view_item'           => __( 'View Item', 'core-extension' ),
		'add_new_item'        => __( 'Add New', 'core-extension' ),
		'add_new'             => __( 'Add New Item', 'core-extension' ),
		'edit_item'           => __( 'Edit Item', 'core-extension' ),
		'update_item'         => __( 'Update Item', 'core-extension' ),
		'search_items'        => __( 'Search Item', 'core-extension' ),
		'not_found'           => __( 'Not found', 'core-extension' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'core-extension' ),
	);
	$args = array(
		'label'               => __( $base . '-item', 'core-extension' ),
		'description'         => __( $label . ' Post Type', 'core-extension' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments'),
		'taxonomies'          => array( $base . '_category' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-layout',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array(
									'slug' => $base,
									'with_front' => false
								),
		'capability_type'     => 'post',
	);
	register_post_type( 'portfolio', $args );

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => sprintf(esc_html__( '%s Categories', 'core-extension' ), $label),
		'singular_name'     => sprintf(esc_html__( '%s Category', 'core-extension' ), $label),
		'search_items'      => sprintf(esc_html__( 'Search %s Categories', 'core-extension' ), $label),
		'all_items'         => sprintf(esc_html__( 'All %s Categories', 'core-extension' ), $label),
		'parent_item'       => sprintf(esc_html__( 'Parent %s Category', 'core-extension' ), $label),
		'parent_item_colon' => sprintf(esc_html__( 'Parent %s Categor', 'core-extension' ), $label),
		'edit_item'         => sprintf(esc_html__( 'Edit %s Category', 'core-extension' ), $label),
		'update_item'       => sprintf(esc_html__( 'Update %s Category', 'core-extension' ), $label),
		'add_new_item'      => sprintf(esc_html__( 'Add New %s Category', 'core-extension' ), $label),
		'new_item_name'     => sprintf(esc_html__( 'New %s Category Name', 'core-extension' ), $label),
		'menu_name'         => sprintf(esc_html__( '%s Categories', 'core-extension' ), $label),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $base . '-category' ),
	);
	register_taxonomy( 'portfolio_category',  'portfolio', $args );

}

//function wtbx_register_custom_post_types() {
//	wtbx_content_block_post_type();
////	wtbx_portfolio_post_type();
//}

// Hook into the 'init' action portfolio post type
add_action( 'init', 'wtbx_portfolio_post_type' );




//runs only when the theme is set up
function wtbx_custom_flush_rules() {
	//defines the post type so the rules can be flushed.
	wtbx_portfolio_post_type();
	//and flush the rules.
	flush_rewrite_rules();
}
add_action('after_theme_switch', 'wtbx_custom_flush_rules');





function wtbx_portfolio_taxonomies() {

//	// Add new taxonomy, NOT hierarchical (like tags)
//	$labels = array(
//		'name'                       => _x( 'Tags', 'taxonomy general name', 'core-extension' ),
//		'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'core-extension' ),
//		'search_items'               => __( 'Search Tags', 'core-extension' ),
//		'popular_items'              => __( 'Popular Tags', 'core-extension' ),
//		'all_items'                  => __( 'All Tags', 'core-extension' ),
//		'parent_item'                => null,
//		'parent_item_colon'          => null,
//		'edit_item'                  => __( 'Edit Tag', 'core-extension' ),
//		'update_item'                => __( 'Update Tag', 'core-extension' ),
//		'add_new_item'               => __( 'Add New Tag', 'core-extension' ),
//		'new_item_name'              => __( 'New Tag Name', 'core-extension' ),
//		'separate_items_with_commas' => __( 'Separate tags with commas', 'core-extension' ),
//		'add_or_remove_items'        => __( 'Add or remove tags', 'core-extension' ),
//		'choose_from_most_used'      => __( 'Choose from the most used tags', 'core-extension' ),
//		'not_found'                  => __( 'No tags found.', 'core-extension' ),
//		'menu_name'                  => __( 'Tags', 'core-extension' ),
//	);
//
//	$args = array(
//		'hierarchical'          => false,
//		'labels'                => $labels,
//		'show_ui'               => true,
//		'show_admin_column'     => true,
//		'update_count_callback' => '_update_post_term_count',
//		'query_var'             => true,
//		'rewrite'               => array( 'slug' => 'portfolio-tag' ),
//	);
//
//	register_taxonomy( 'portfolio_tag', 'portfolio', $args );
}

// Hook into the 'init' action portfolio taxonomies
//add_action( 'init', 'wtbx_portfolio_taxonomies', 0 );



function wtbx_portfolio_columns( $gallery_columns ) {
	$gallery_columns['cb'] = '<input type="checkbox" />';
	$gallery_columns['title'] = __('Title', 'core-extension' );
	$gallery_columns['thumbnail'] = __('Image', 'core-extension' );
	$gallery_columns['portfolio_category'] = __('Categories', 'core-extension' );
//	$new_columns['portfolio_tag'] = __('Tags', 'core-extension' );
	$gallery_columns['date'] = __('Date', 'core-extension' );
	 
	return $gallery_columns;
}

// Add filter for portfolio custom columns
add_filter('manage_edit-portfolio_columns', 'wtbx_portfolio_columns');

 
function wtbx_manage_portfolio_columns( $column_name ) {
	global $post;
	
	switch ($column_name) {
	
		/* If displaying the 'Image' column. */
		case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, array( 100, 100) );
		break;
		
		/* If displaying the 'Categories' column. */
		case 'portfolio_category' :

			$terms = get_the_terms( $post->ID, 'portfolio_category' );

			if ( !empty( $terms ) ) {

				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'portfolio_category' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'portfolio_category', 'display' ) )
					);
				}
				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				echo '&macr;';
			}

			break;

		
//		/* If displaying the 'Tags' column. */
//		case 'portfolio_tag' :
//
//			$terms = get_the_terms( $post->ID, 'portfolio_tag' );
//
//			if ( !empty( $terms ) ) {
//
//				$out = array();
//				foreach ( $terms as $term ) {
//					$out[] = sprintf( '<a href="%s">%s</a>',
//						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'portfolio_tag' => $term->slug ), 'edit.php' ) ),
//						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'portfolio_tag', 'display' ) )
//					);
//				}
//				/* Join the terms, separating them with a comma. */
//				echo join( ', ', $out );
//			}
//
//			/* If no terms were found, output a default message. */
//			else {
//				echo '&macr;';
//			}
//
//			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
		break;
	
	} 
}	

// Add filter for portfolio custom column view
add_action('manage_portfolio_posts_custom_column', 'wtbx_manage_portfolio_columns', 10, 2);