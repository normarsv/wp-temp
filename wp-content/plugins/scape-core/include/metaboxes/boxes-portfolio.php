<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb2_admin_init', 'wtbx_portfolio' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function wtbx_portfolio() {
	$tabs = [esc_html__('Layout', 'core-extension'), esc_html__('Media', 'core-extension'), esc_html__('Details', 'core-extension'), esc_html__('List', 'core-extension')];
	$tabs = implode(',', $tabs);

	$portfolio_single = new_cmb2_box( array(
		'id'            => 'metabox-portfolio-item-content',
		'title'         => esc_html__( 'Portfolio content settings', 'core-extension' ),
		'object_types'  => array( 'portfolio' ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Show title', 'core-extension' ),
		'id'        => 'portfolio-item-title-enable',
		'type'      => 'select',
		'options'   => array(
			'2'     => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'Show', 'core-extension' ),
			'off'   => esc_html__( 'Hide', 'core-extension' ),
		),
		'default'       => '2',
		'before_row'    => '<div class="wtbx-tabnames" data-tabnames="'.esc_attr($tabs).'"></div>',
		'row_classes'   => 'tab_1'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Show description', 'core-extension' ),
		'id'        => 'portfolio-item-description-enable',
		'type'      => 'select',
		'options'   => array(
			'2'     => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'Show', 'core-extension' ),
			'off'   => esc_html__( 'Hide', 'core-extension' ),
		),
		'default' => '2',
		'row_classes'   => 'tab_1'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Show details', 'core-extension' ),
		'id'        => 'portfolio-item-details-enable',
		'type'      => 'select',
		'options'   => array(
			'2'     => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'Show', 'core-extension' ),
			'off'   => esc_html__( 'Hide', 'core-extension' ),
		),
		'default' => '2',
		'row_classes'   => 'tab_1'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Show like module', 'core-extension' ),
		'id'        => 'portfolio-item-like-enable',
		'type'      => 'select',
		'options'   => array(
			'2'     => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'Show', 'core-extension' ),
			'off'   => esc_html__( 'Hide', 'core-extension' ),
		),
		'default' => '2',
		'row_classes'   => 'tab_1'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Show share module', 'core-extension' ),
		'id'        => 'portfolio-item-share-enable',
		'type'      => 'select',
		'options'   => array(
			'2'     => esc_html__( 'Inherit', 'core-extension' ),
			'1'   => esc_html__( 'Show', 'core-extension' ),
			'off'   => esc_html__( 'Hide', 'core-extension' ),
		),
		'default' => '2',
		'row_classes'   => 'tab_1'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Content layout and position', 'core-extension' ),
		'desc'      => wp_kses_post( __( 'Left and right positioning is available with the following media layouts: <strong>image slider, vertical gallery, image gallery grid</strong>.', 'core-extension' )),
		'id'        => 'portfolio-item-content-position',
		'type'      => 'select',
		'options'   => array(
			'inherit'       => esc_html__( 'Inherit', 'core-extension' ),
			'top-onecol'    => esc_html__( 'Top - one column', 'core-extension' ),
			'top-twocol'    => esc_html__( 'Top - two columns', 'core-extension' ),
			'bottom-onecol' => esc_html__( 'Bottom - one column', 'core-extension' ),
			'bottom-twocol' => esc_html__( 'Bottom - two columns', 'core-extension' ),
			'left'          => esc_html__( 'Left', 'core-extension' ),
			'left-sticky'   => esc_html__( 'Left sticky', 'core-extension' ),
			'right'         => esc_html__( 'Right', 'core-extension' ),
			'right-sticky'  => esc_html__( 'Right sticky', 'core-extension' ),
		),
		'default' => 'inherit',
		'row_classes'   => 'tab_1'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Show media', 'core-extension' ),
		'id'        => 'portfolio-item-media-enable',
		'type'      => 'select',
		'options'   => array(
			'2'     => esc_html__( 'Inherit', 'core-extension' ),
			'1'     => esc_html__( 'Show', 'core-extension' ),
			'off'   => esc_html__( 'Hide', 'core-extension' ),
		),
		'default' => '2',
		'row_classes'   => 'tab_2'
	) );

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Portfolio item page layout', 'core-extension' ),
		'desc'      => wp_kses_post( __( 'Select one of predefined layouts or select <code>Custom Layout</code> to build your own using Page Builder.', 'core-extension' )),
		'id'        => 'portfolio-item-media',
		'type'      => 'select',
		'options'   => array(
			'slider'            => esc_html__( 'Image slider', 'core-extension' ),
			'carousel'          => esc_html__( 'Image carousel', 'core-extension' ),
			'gallery-vertical'  => esc_html__( 'Vertical gallery', 'core-extension' ),
			'gallery-grid'      => esc_html__( 'Grid gallery', 'core-extension' ),
//			'gallery-random'    => esc_html__( 'Random grid gallery', 'core-extension' ),
//			'gallery-masonry'   => esc_html__( 'Masonry image gallery', 'core-extension' ),
//			'zigzag'            => esc_html__( 'Zig-zag', 'core-extension' ),
//			'checkers'          => esc_html__( 'Checkers', 'core-extension' ),
			'video'             => esc_html__( 'Video player', 'core-extension' ),
			'audio'             => esc_html__( 'Audio player', 'core-extension' ),
			'custom'            => esc_html__( 'Custom layout', 'core-extension' ),
		),
		'default' => 'slider',
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' =>  esc_html__( 'Self-hosted video', 'core-extension' ),
		'id'   => 'portfolio-item-video-selfhosted',
		'type' => 'file',
		'options' => array(
			'add_upload_file_text' => esc_html__( 'Add video file', 'core-extension' )
		),
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'video',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'YouTube video ID', 'core-extension' ),
		'default' => '',
		'id'   => 'portfolio-item-video-youtube',
		'type' => 'text',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'video',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Vimeo video ID', 'core-extension' ),
		'default' => '',
		'id'   => 'portfolio-item-video-vimeo',
		'type' => 'text',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'video',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Video poster', 'core-extension' ),
		'desc'    => esc_html__( 'Will be displayed with self-hosted video, or with Youtube/Vimeo video when GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
		'id'   => 'portfolio-item-video-poster',
		'type' => 'file',
		'preview_size' => array( 100, 100 ),
		'options' => array(
			'url' => false,
			'add_upload_file_text' => esc_html__( 'Add image', 'core-extension' )
		),
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'video',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' =>  esc_html__( 'Self-hosted audio', 'core-extension' ),
		'id'   => 'portfolio-item-audio-selfhosted',
		'type' => 'file',
		'options' => array(
			'add_upload_file_text' => esc_html__( 'Add audio file', 'core-extension' )
		),
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'audio',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Audio thumbnail', 'core-extension' ),
		'desc'    => esc_html__( 'Will be displayed with self-hosted audio, or with SoundCloud/Spotify embed when GDPR plugin is active and no consent is received for this type of media.', 'core-extension' ),
		'id'   => 'portfolio-item-audio-thumbnail',
		'type' => 'file',
		'preview_size' => array( 100, 100 ),
		'options' => array(
			'url' => false,
			'add_upload_file_text' => esc_html__( 'Add image', 'core-extension' )
		),
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'audio',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' =>  esc_html__( 'Audio embed code', 'core-extension' ),
		'id'   => 'portfolio-item-audio-embed',
		'type' => 'textarea_code',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'audio',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' =>  esc_html__( 'SoundCloud audio ID / Spotify URI', 'core-extension' ),
		'id'   => 'portfolio-item-audio-url',
		'type' => 'text',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'audio',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Add images', 'core-extension' ),
		'id'   => 'portfolio-item-add-images',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ),
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => json_encode(array('carousel', 'slider', 'gallery-vertical', 'gallery-grid')),
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Image aspect ratio', 'core-extension' ),
		'desc' => wp_kses_post( __( '<strong>Width:height</strong> aspect ratio of the images. Example: <code>16:10</code>.', 'core-extension' )),
		'default' => '16:9',
		'id'   => 'portfolio-item-images-ratio',
		'type' => 'text_small',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => json_encode(array('carousel', 'slider', 'gallery-grid')),
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Navigation arrows skin', 'core-extension' ),
		'desc' => esc_html__( 'Choose the navigation arrows color skin based on the container background', 'core-extension' ),
		'id'        => 'portfolio-item-arrows',
		'type'      => 'select',
		'options'   => array(
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' )
		),
		'default' => 'light',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => json_encode(array('slider', 'carousel')),
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Navigation bullets', 'core-extension' ),
		'id'        => 'portfolio-item-bullets',
		'type'      => 'select',
		'options'   => array(
			'light' => esc_html__( 'Light', 'core-extension' ),
			'dark'  => esc_html__( 'Dark', 'core-extension' )
		),
		'default' => 'light',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => json_encode(array('slider', 'carousel')),
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name'          => esc_html__( 'Grid gutter', 'core-extension' ),
		'id'            => 'portfolio-item-vertical-gutter',
		'type'          => 'wtbx_slider',
		'min'           => '0',
		'max'           => '100',
		'default'       => '30',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => json_encode(array('gallery-vertical', 'gallery-grid')),
		),
		'row_classes'   => 'tab_2'
	) );
//	$portfolio_single->add_field( array(
//		'name'          => esc_html__( 'Grid columns', 'core-extension' ),
//		'id'            => 'portfolio-item-columns',
//		'type'          => 'wtbx_slider',
//		'min'           => '1',
//		'max'           => '4',
//		'default'       => '2',
//		'attributes' => array(
//			'data-conditional-id' => 'portfolio-item-media',
//			'data-conditional-value' => json_encode(array('gallery-random')),
//		),
//		'row_classes'   => 'tab_2'
//	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Breakpoint width', 'core-extension' ),
		'desc' => esc_html__( 'Width under which the slider will be disabled.', 'core-extension' ),
		'default' => '979',
		'id'   => 'portfolio-item-fullscreen-width',
		'type' => 'text_small',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'slider-fullscreen',
		),
		'row_classes'   => 'tab_2'
	) );
	$portfolio_single->add_field( array(
		'name' => esc_html__( 'Breakpoint height', 'core-extension' ),
		'desc' => esc_html__( 'Height under which the slider will be disabled.', 'core-extension' ),
		'default' => '500',
		'id'   => 'portfolio-item-fullscreen-height',
		'type' => 'text_small',
		'attributes' => array(
			'data-conditional-id' => 'portfolio-item-media',
			'data-conditional-value' => 'slider-fullscreen',
		),
		'row_classes'   => 'tab_2'
	) );
//	$portfolio_single->add_field( array(
//		'id'          => 'portfolio-item-section',
//		'type'        => 'group',
//		'description' => esc_html__( 'Add and sort separate sections of portfolio item.', 'core-extension' ),
//		// 'repeatable'  => false, // use false if you want non-repeatable group
//		'options'     => array(
//			'group_title'   => esc_html__( 'Section {#}', 'core-extension' ), // since version 1.1.4, {#} gets replaced by row number
//			'add_button'    => esc_html__( 'Add New Section', 'core-extension' ),
//			'remove_button' => esc_html__( 'Remove Section', 'core-extension' ),
//			'sortable'      => true, // beta
//			'closed'     => true, // true to have the groups closed by default
//		),
//		'attributes' => array(
//			'data-conditional-id' => 'portfolio-item-media',
//			'data-conditional-value' => json_encode(array('zigzag', 'checkers', 'slider-fullscreen')),
//		),
//		'row_classes'   => 'tab_2'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name' => esc_html__( 'Heading', 'core-extension' ),
//		'id'   => 'portfolio-item-section-heading',
//		'type' => 'text'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name'      => esc_html__( 'Heading color', 'core-extension' ),
//		'id'        => 'portfolio-item-section-heading-color',
//		'type'      => 'colorpicker'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name' =>  esc_html__( 'Description', 'core-extension' ),
//		'id'   => 'portfolio-item-section-description',
//		'type' => 'textarea'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name'      => esc_html__( 'Description color', 'core-extension' ),
//		'id'        => 'portfolio-item-section-description-color',
//		'type'      => 'colorpicker'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name' => esc_html__( 'Image', 'core-extension' ),
//		'id'   => 'portfolio-item-section-image',
//		'type' => 'file'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name'      => esc_html__( 'Image position', 'core-extension' ),
//		'id'        => 'portfolio-item-section-layout',
//		'type'      => 'select',
//		'options'   => array(
//			'left'  => esc_html__( 'Left', 'core-extension' ),
//			'right' => esc_html__( 'Right', 'core-extension' )
//		),
//		'default' => 'left'
//	) );
//	$portfolio_single->add_group_field( 'portfolio-item-section', array(
//		'name'      => esc_html__( 'Section background-color', 'core-extension' ),
//		'id'        => 'portfolio-item-section-bg',
//		'type'      => 'colorpicker',
//		'default' => '#ffffff'
//	) );


	$details_array = get_option('wtbx_scape');
	if ( !empty($details_array) && !empty($details_array['portfolio-item-details']) ) {
		$details_array = $details_array['portfolio-item-details'];

		foreach ( $details_array as $id => $label ) {
			if ( isset($label) ) {
				if ( class_exists('SitePress') && function_exists('wpml_object_id') ) {
					$label = apply_filters( 'wpml_translate_single_string', $label, 'core-extension', 'portfolio_detail_'.esc_html(strtolower(str_replace(' ', '_', $label))));
				}
				$portfolio_single->add_field( array(
					'name'    => $label,
					'id'      => 'portfolio-detail-' . $id,
					'type'    => 'textarea_small',
					'row_classes'   => 'tab_3'
				) );
			}
		}
	} else {
		$portfolio_single->add_field( array(
			'name' => esc_html__('No details can be added at the moment', 'core-extension'),
			'desc' => wp_kses_post( __('Please first add the details fields in <a href="admin.php?page=Scape&tab=42">Theme Options</a> -> Content -> Portfolio item details.')),
			'type' => 'title',
			'id'   => 'portfolio-detail-empty',
            'row_classes' => 'tab_3'
		) );
	}

	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Item tile width', 'core-extension' ),
		'desc'      => esc_html__( 'Specify how many columns wide this item should be. To be used with metro style portfolio page.', 'core-extension' ),
		'id'        => 'portfolio-list-width',
		'type'      => 'select',

		'options'   => array(
			'1'     => esc_html__( '1', 'core-extension' ),
			'2'     => esc_html__( '2', 'core-extension' ),
			'3'     => esc_html__( '3', 'core-extension' ),
			'4'     => esc_html__( '4', 'core-extension' ),
		),
		'default' => '1',
		'row_classes'   => 'tab_4'
	) );
	$portfolio_single->add_field( array(
		'name'      => esc_html__( 'Item tile height', 'core-extension' ),
		'desc'      => esc_html__( 'Specify how many columns high this item should be. To be used with metro style portfolio page.', 'core-extension' ),
		'id'        => 'portfolio-list-height',
		'type'      => 'select',
		'options'   => array(
			'1'     => esc_html__( '1', 'core-extension' ),
			'2'     => esc_html__( '2', 'core-extension' ),
			'3'     => esc_html__( '3', 'core-extension' ),
			'4'     => esc_html__( '4', 'core-extension' ),
		),
		'default' => '1',
		'row_classes'   => 'tab_4'
	) );
}