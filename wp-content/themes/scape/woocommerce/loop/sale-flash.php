<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$badge = get_post_meta($post->ID, 'product-badge', true);

?>

<?php if ( $badge || $product->is_on_sale() ) : ?>
	<div class="wtbx-badges">

		<?php if ($badge) : ?>
			<span class="wtbx-product-badge"><?php echo esc_html($badge); ?></span>
		<?php endif; ?>

		<?php if ( $product->is_on_sale() && $product->get_regular_price() > 0 ) : ?>

			<?php
				if ( !$product->is_type( 'variable' ) ) {
					$percentage = '-' . round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 ) . '% ';
				} else {
					$percentage = '';
				}
			?>

			<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html($percentage) . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
		<?php endif; ?>

	</div>
<?php endif; ?>

