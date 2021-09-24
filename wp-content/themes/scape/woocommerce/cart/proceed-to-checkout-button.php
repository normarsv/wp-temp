<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<input type="submit" class="button wtbx-button wtbx-button-secondary button-md update-cart" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

<a href="<?php echo esc_url( wc_get_checkout_url() ) ;?>" class="checkout-button button alt wc-forward wtbx-button wtbx-button-primary button-md">
	<?php echo esc_html__( 'Proceed to checkout', 'woocommerce' ); ?>
</a>
