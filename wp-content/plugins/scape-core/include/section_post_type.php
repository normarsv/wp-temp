<?php

// Register Content Block Custom Post Type
function wtbx_content_block_post_type() {

	$base = 'content_block';
	$label = esc_html__( 'Content Block', 'core-extension' );

	$labels = array(
		'name'                => sprintf(esc_html__('%s', 'core-extension' ), $label),
		'singular_name'       => sprintf(esc_html__('%s', 'core-extension' ), $label),
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
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions'),
		'taxonomies'          => array( $base . '_category' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-index-card',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => wtbx_vc_is_page_editable() ? true : false,
		'rewrite'             => array(
			'slug' => $base,
			'with_front' => false
		),
		'capability_type'     => 'post',
//		'capabilities' => array(
//			'edit_post'          => 'edit_content_block',
//			'read_post'          => 'read_content_block',
//			'delete_post'        => 'delete_content_block',
//			'edit_posts'         => 'edit_content_blocks',
//			'edit_others_posts'  => 'edit_others_content_blocks',
//			'publish_posts'      => 'publish_content_blocks',
//			'read_private_posts' => 'read_private_content_blocks',
//			'create_posts'       => 'edit_content_blocks',
//		),
//		'capability_type'     => 'content_block',
		'map_meta_cap' => true,
	);
	register_post_type( $base, $args );

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => sprintf(esc_html__( '%s Categories', 'core-extension' ), $label),
		'singular_name'     => sprintf(esc_html__( '%s Category', 'core-extension' ), $label),
		'search_items'      => sprintf(esc_html__( 'Search %s Categories', 'core-extension' ), $label),
		'all_items'         => sprintf(esc_html__( 'All %s Categories', 'core-extension' ), $label),
		'parent_item'       => sprintf(esc_html__( 'Parent %s Category', 'core-extension' ), $label),
		'parent_item_colon' => sprintf(esc_html__( 'Parent %s Category', 'core-extension' ), $label),
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
		'query_var'         => false,
		'rewrite'           => array( 'slug' => $base . '_category' ),
	);
	register_taxonomy( $base . '_category',  $base, $args );

}

// Hook into the 'init' action portfolio post type
add_action( 'init', 'wtbx_content_block_post_type', 11 );