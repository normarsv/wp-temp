<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb2_admin_init', 'wtbx_post_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wtbx_post_metaboxes() {

	// Standard post
	$post_image = new_cmb2_box( array(
		'id'            => 'metabox-post-format-image',
		'title'         => esc_html__( 'Post settings - image', 'core-extension' ),
		'object_types'  => array( 'post' ),
		'context'       => 'normal',
		'priority'      => 'high',
	) );
	$post_image->add_field( array(
		'name' => esc_html__( 'Upload an image', 'core-extension' ),
		'id'   => 'post-add-image',
		'type' => 'file',
		'options' => array(
			'url' => false,
			'add_upload_file_text' => esc_html__( 'Add image', 'core-extension' )
		),
	) );

	// Gallery post
	$post_gallery = new_cmb2_box( array(
		'id'            => 'metabox-post-format-gallery',
		'title'         => esc_html__( 'Post settings - gallery', 'core-extension' ),
		'object_types'  => array( 'post' ),
		'context'       => 'normal',
		'priority'      => 'high',
	) );
	$post_gallery->add_field( array(
		'name' => esc_html__( 'Add gallery images', 'core-extension' ),
		'id'   => 'post-add-slides',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 )
	) );
	$post_gallery->add_field( array(
		'name' => esc_html__( 'Slider aspect ratio', 'core-extension' ),
		'desc' => wp_kses_post( __( '<strong>Width:height</strong> aspect ratio of the slides. Example: <code>16:10</code>', 'core-extension' )),
		'default' => '16:9',
		'id'   => 'post-slides-ratio',
		'type' => 'text_small',
	) );
	$post_gallery->add_field( array(
		'name'      => esc_html__( 'Slider navigation skin', 'core-extension' ),
		'id'        => 'post-slides-skin',
		'type'      => 'select',
		'options'   => array(
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' )
		),
		'default' => 'light'
	) );

	// Quote post
	$post_quote = new_cmb2_box( array(
		'id'            => 'metabox-post-format-quote',
		'title'         => esc_html__( 'Post settings - quote', 'core-extension' ),
		'object_types'  => array( 'post' ),
		'context'       => 'normal',
		'priority'      => 'high',
	) );
	$post_quote->add_field( array(
		'name' => esc_html__( 'Quote text', 'core-extension' ),
		'id'   => 'post-quote-text',
		'type' => 'textarea_small',
	) );
	$post_quote->add_field( array(
		'name' => esc_html__( 'Quote author', 'core-extension' ),
		'id'   => 'post-quote-author',
		'type' => 'text',
	) );
	$post_quote->add_field( array(
		'name' => esc_html__( 'Background image', 'core-extension' ),
		'id'   => 'post-quote-image',
		'type' => 'file',
		'options' => array(
			'url' => false,
			'add_upload_file_text' => esc_html__( 'Add image', 'core-extension' )
		),
	) );

	// Video post
	$post_video = new_cmb2_box( array(
		'id'            => 'metabox-post-format-video',
		'title'         => esc_html__( 'Post settings - video', 'core-extension' ),
		'object_types'  => array( 'post' ),
		'context'       => 'normal',
		'priority'      => 'high',
	) );
	$post_video->add_field( array(
		'name' => esc_html__( 'Youtube video ID', 'core-extension' ),
		'id'   => 'post-video-youtube',
		'type' => 'text',
	) );
	$post_video->add_field( array(
		'name' => esc_html__( 'Vimeo video ID', 'core-extension' ),
		'id'   => 'post-video-vimeo',
		'type' => 'text',
	) );
	$post_video->add_field( array(
		'name' => esc_html__( 'Self-hosted video file in .mp4 format', 'core-extension' ),
		'id'   => 'post-video-selfhosted',
		'type' => 'file',
		'options' => array(
			'add_upload_file_text' => esc_html__( 'Add video file', 'core-extension' )
		)
	) );
	$post_video->add_field( array(
		'name' => esc_html__( 'Video poster', 'core-extension' ),
		'desc'    => esc_html__( 'Will be displayed with self-hosted video, or with Youtube/Vimeo video when GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
		'id'   => 'post-video-poster',
		'type' => 'file',
		'preview_size' => array( 100, 100 ),
		'options' => array(
			'url' => false,
			'add_upload_file_text' => esc_html__( 'Add image', 'core-extension' )
		)
	) );

	// Audio post
	$post_audio = new_cmb2_box( array(
		'id'            => 'metabox-post-format-audio',
		'title'         => esc_html__( 'Post settings - audio', 'core-extension' ),
		'object_types'  => array( 'post' ),
		'context'       => 'normal',
		'priority'      => 'high',
	) );
	$post_audio->add_field( array(
		'name' => esc_html__( 'External audio', 'core-extension' ),
		'id'   => 'post-audio-external',
		'type' => 'text',
	) );
	$post_audio->add_field( array(
		'name' => esc_html__( 'Self-hosted audio', 'core-extension' ),
		'id'   => 'post-audio-selfhosted',
		'type' => 'file',
		'options' => array(
			'add_upload_file_text' => esc_html__( 'Add audio file', 'core-extension' )
		)
	) );
	$post_audio->add_field( array(
		'name' => esc_html__( 'Audio title', 'core-extension' ),
		'desc'    => esc_html__( 'Will be displayed with external or self-hosted audio.', 'core-extension' ),
		'id'   => 'post-audio-title',
		'type' => 'text',
	) );
	$post_audio->add_field( array(
		'name' => esc_html__( 'Audio thumbnail', 'core-extension' ),
		'desc'    => esc_html__( 'Will be displayed with external or self-hosted video, or with SoundCloud/Spotify embed when GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
		'id'   => 'post-audio-thumbnail',
		'type' => 'file',
		'preview_size' => array( 100, 100 ),
		'options' => array(
			'url' => false,
			'add_upload_file_text' => esc_html__( 'Add image', 'core-extension' )
		)
	) );
	$post_audio->add_field( array(
		'name' => esc_html__( 'Audio embed', 'core-extension' ),
		'id'   => 'post-audio-embed',
		'type' => 'textarea_code',
	) );
	$post_audio->add_field( array(
		'name' => esc_html__( 'SoundCloud audio ID / Spotify URI', 'core-extension' ),
		'id'   => 'post-audio-uri',
		'type' => 'text',
	) );
}