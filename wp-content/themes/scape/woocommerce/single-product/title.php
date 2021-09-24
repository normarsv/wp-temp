<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post, $product;
$subtitle = get_post_meta($post->ID, 'product-subtitle', true);

?>
<h1 class="product_title entry-title">
	<?php echo esc_html( get_the_title() ); ?>
</h1>

<?php if ($subtitle && wtbx_option('product-single-subtitle')) {
	echo '<h5 class="product_subtitle">' . esc_html($subtitle) . '</h5>';
} ?>

<?php echo wc_get_product_tag_list( $product->get_id(), '', '<div class="tagged_as item-field">', '</div>' ); ?>
