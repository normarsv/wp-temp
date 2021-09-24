<?php

//Allow editor style.
add_editor_style('library/css/scape-tinymce.css');

// TinyMCE
function wtbx_enable_more_buttons($buttons) {
	$buttons[] = 'styleselect';

	return $buttons;
}
add_filter('mce_buttons_2', 'wtbx_enable_more_buttons');

// Enable font size & font family selects in the editor
if ( ! function_exists( 'wtbx_mce_buttons' ) ) {
	function wtbx_mce_buttons( $buttons ) {
//		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wtbx_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'wtbx_mce_text_sizes' ) ) {
	function wtbx_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 21px 22px 23px 24px 25px 28px 32px 36px 40px 44px 48px 54px 60px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wtbx_mce_text_sizes' );




// Hooks your functions into the correct filters
function wtbx_tinymce_extend() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'wtbx_tinymce_plugin' );
		add_filter( 'mce_buttons', 'wtbx_register_mce_button' );
	}
}
//add_action('admin_head', 'wtbx_tinymce_extend');

// Declare script for new button
function wtbx_tinymce_plugin( $plugin_array ) {
	$plugin_array['wtbx_mce_button'] = get_template_directory_uri() . '/inc/tinymce/scape-tinymce.js';
	return $plugin_array;
}

// Register new button in the editor
function wtbx_register_mce_button( $buttons ) {
	array_push( $buttons, 'wtbx_mce_button' );
	return $buttons;
}
