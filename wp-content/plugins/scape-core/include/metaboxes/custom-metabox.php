<?php

/*
 * Background field set
 */

function insert_bg_select_values($option, $value = false) {
	$options_array = array(
		'background-repeat'     => array(
			''          => esc_html__( 'Select item', 'core-extension' ),
			'no-repeat' => esc_html__( 'No Repeat', 'core-extension' ),
			'repeat'    => esc_html__( 'Repeat All', 'core-extension' ),
			'repeat-x'  => esc_html__( 'Repeat Horizontally', 'core-extension' ),
			'repeat-y'  => esc_html__( 'Repeat Vertically', 'core-extension' ),
			'inherit'   => esc_html__( 'Inherit', 'core-extension' )
		),
		'background-size'       => array(
			''          => esc_html__( 'Select item', 'core-extension' ),
			'inherit'   => esc_html__( 'Inherit', 'core-extension' ),
			'cover'     => esc_html__( 'Cover', 'core-extension' ),
			'contain'   => esc_html__( 'Contain', 'core-extension' )
		),
		'background-attachment' => array(
			''          => esc_html__( 'Select item', 'core-extension' ),
			'fixed'     => esc_html__( 'Fixed', 'core-extension' ),
			'scroll'    => esc_html__( 'Scroll', 'core-extension' ),
			'inherit'   => esc_html__( 'Inherit', 'core-extension' )
		),
		'background-position'   => array(
			''              => esc_html__( 'Select item', 'core-extension' ),
			'left top'      => esc_html__( 'Left Top', 'core-extension' ),
			'left center'   => esc_html__( 'Left Center', 'core-extension' ),
			'left bottom'   => esc_html__( 'Left Bottom', 'core-extension' ),
			'center top'    => esc_html__( 'Center Top', 'core-extension' ),
			'center center' => esc_html__( 'Center Center', 'core-extension' ),
			'center bottom' => esc_html__( 'Center Bottom', 'core-extension' ),
			'right top'     => esc_html__( 'Right Top', 'core-extension' ),
			'right center'  => esc_html__( 'Right Center', 'core-extension' ),
			'right bottom'  => esc_html__( 'Right Bottom', 'core-extension' )
		)
	);

	$options = '';
	foreach ( $options_array[$option] as $val => $label ) {
		$options .= '<option value="'. $val .'" '. selected( $value, $val, false ) .'>'. $label .'</option>';
	}

	return $options;

}

function wtbx_background_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args( $value, array(
		'background-color'      => '',
		'background-repeat'     => '',
		'background-size'       => '',
		'background-attachment' => '',
		'background-position'   => '',
		'background-image'      => '',
	) );

	?>
	<div><p><label for="<?php echo $field_type_object->_id( '_background_color' ); ?>">Background color</label></p>
		<?php echo $field_type_object->colorpicker( array(
			'name'  => $field_type_object->_name( '[background-color]' ),
			'id'    => $field_type_object->_id( '_background_color' ),
			'value' => $value['background-color'],
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type_object->_id( '_background_repeat' ); ?>'">Background repeat</label></p>
		<?php echo $field_type_object->select( array(
			'name'  => $field_type_object->_name( '[background-repeat]' ),
			'id'    => $field_type_object->_id( '_background_repeat' ),
			'options' => insert_bg_select_values( 'background-repeat', $value['background-repeat'] ),
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type_object->_id( '_background_size' ); ?>'">Background size</label></p>
		<?php echo $field_type_object->select( array(
			'name'  => $field_type_object->_name( '[background-size]' ),
			'id'    => $field_type_object->_id( '_background_size' ),
			'options' => insert_bg_select_values( 'background-size', $value['background-size'] ),
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type_object->_id( '_background_attachment' ); ?>'">Background attachment</label></p>
		<?php echo $field_type_object->select( array(
			'name'    => $field_type_object->_name( '[background-attachment]' ),
			'id'      => $field_type_object->_id( '_background_attachment' ),
			'options' => insert_bg_select_values( 'background-attachment', $value['background-attachment'] ),
			'desc'    => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type_object->_id( '_background_position' ); ?>'">Background position</label></p>
		<?php echo $field_type_object->select( array(
			'name'  => $field_type_object->_name( '[background-position]' ),
			'id'    => $field_type_object->_id( '_background_position' ),
			'options' => insert_bg_select_values( 'background-position', $value['background-position'] ),
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type_object->_id( '_background_image' ); ?>'">Background image</label></p>
		<?php
		echo '<input type="text" class="cmb2-upload-file regular-text" name="'. $field_type_object->_name( '[background-image]' ) .'" id="'. $field_type_object->_id( '_background_image' ) .'" value="'. $value['background-image'] .'" size="45" data-previewsize="[100,100]" data-queryargs="">';
		echo sprintf( '<input class="cmb2-upload-button button" type="button" value="%s" />',  __( 'Upload', 'core-extension' ) );
		?>
			<div id="<?php echo $field_type_object->_id( '-status' ); ?>" class="cmb2-media-status" style="">
				<div class="img-status">
					<?php if ( $value['background-image'] !== '' ) { ?>
						<img width="350px" style="max-width: 100px; width: 100%; height: auto;" src="<?php echo esc_attr($value['background-image']); ?>" alt="" title="">
						<p>
							<a href="#" class="cmb2-remove-file-button" rel="<?php echo esc_attr($field_type_object->_name( '[background-image]' )); ?>">Remove Image</a>
						</p>
					<?php } ?>
				</div>
			</div>

	</div>
	<br class="clear">
	<?php
	echo $field_type_object->_desc( true );

}

add_action( 'cmb2_render_wtbx_background', 'wtbx_background_field_callback', 10, 5 );



/*
 * Custom post type select
 */

function wtbx_get_content_block_list( $query_args ) {

	$args = wp_parse_args( $query_args, array(
		'post_type'   => 'content_block'
	) );

	$posts = get_posts( $args );

	$post_options = array();
	if ( $posts ) {
		$post_options[''] = esc_html__('Inherit', 'core-extension');
		foreach ( $posts as $post ) {
			$post_options[ $post->ID ] = $post->post_title;
		}
	}

	return $post_options;
}

function wtbx_content_block_select() {
	return wtbx_get_content_block_list( array( 'post_type' => 'content_block', 'posts_per_page'=> -1, ) );
}



/*
 * Slider
 */

//class OWN_Field_Slider {

//	const VERSION = '0.1.0';

//	public function hooks() {
//	}

function wtbx_slider_field_callback( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {

	echo '<div class="own-slider-field"></div>';

	echo $field_type_object->input( array(
		'type'       => 'hidden',
		'class'      => 'own-slider-field-value',
		'readonly'   => 'readonly',
		'data-start' => intval( $field_escaped_value ),
		'data-min'   => $field->min(),
		'data-max'   => $field->max(),
		'desc'       => '',
	) );

	echo '<span class="own-slider-field-value-display">'. $field->value_label() .' <span class="own-slider-field-value-text"></span></span>';

	$field_type_object->_desc( true, true );

	wp_enqueue_script( 'cmb2_field_slider_js',  WTBX_PLUGIN_URL . '/include/metaboxes/js/field_slider.js', array( 'jquery', 'jquery-ui-slider' ), '' );
	wp_enqueue_style( 'slider_ui', '//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css', array(), '1.0' );

}
add_filter( 'cmb2_render_wtbx_slider', 'wtbx_slider_field_callback', 10, 5 );


//}
//$own_field_slider = new OWN_Field_Slider();
//$own_field_slider->hooks();