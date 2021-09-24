<?php
/*
*	---------------------------------------------------------------------
*	WTBX Theme Support
*	---------------------------------------------------------------------
*/

function wtbx_theme_support() {

	// rss thingy
	add_theme_support('automatic-feed-links');

	/* Thumbnails */
	add_theme_support( 'post-thumbnails' );

	/* Feeds */
	add_theme_support( 'automatic-feed-links' );

	/* HTML5 */
	add_theme_support( 'html5', array( 'gallery', 'caption' ) );

	add_theme_support( 'woocommerce' );

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'image',             // single image
			'gallery',           // gallery of images
			'video',             // video
			'audio',             // audio
			'quote',             // a quick quote
		)
	);

	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-header' );

	add_theme_support( 'editor-styles' );

	// Register menu
	register_nav_menus( array(
		'header'   => esc_html__( 'Header Menu', 'scape' ),
		'mobile'   => esc_html__( 'Mobile Header Menu', 'scape' ),
	) );

	// Remove block widgets editor
	remove_theme_support( 'widgets-block-editor' );

}