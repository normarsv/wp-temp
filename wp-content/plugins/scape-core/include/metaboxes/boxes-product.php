<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

if ( class_exists( 'WooCommerce' ) ) {
	add_filter( 'cmb2_admin_init', 'wtbx_product_metaboxes' );
	function wtbx_product_metaboxes() {
		$product = new_cmb2_box( array(
			'id'            => 'metabox-product',
			'title'         => esc_html__( 'Product details', 'core-extension' ),
			'object_types'  => array( 'product' ),
			'context'       => 'normal',
			'priority'      => 'high',
		) );
		$product->add_field( array(
			'name' => esc_html__( 'Product subtitle', 'core-extension' ),
			'desc' => esc_html__( 'Will be displayed under the product title', 'core-extension' ),
			'id'   => 'product-subtitle',
			'type' => 'text'
		) );
		$product->add_field( array(
			'name' => esc_html__( 'Product badge', 'core-extension' ),
			'desc' => wp_kses_post( __('Custom product badge. E.g. <strong>"New Release"</strong>, <strong>"Best Seller"</strong> etc.', 'core-extension' )),
			'id'   => 'product-badge',
			'type' => 'text'
		) );
	}
}
