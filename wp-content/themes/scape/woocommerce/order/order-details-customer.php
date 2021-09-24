<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">

	<div class="wtbx-section-header">
		<div class="wtbx-section-title with-border no-padding">
			<h2><?php esc_html_e( 'Customer Details', 'scape' ); ?></h2>
		</div>
	</div>

	<table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
		<?php if ( $order->get_customer_note() ) : ?>
			<tr>
				<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
				<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<tr>
				<th><?php esc_html_e( 'Email:', 'woocommerce' ); ?></th>
				<td><?php echo esc_html( $order->get_billing_email() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<tr>
				<th><?php esc_html_e( 'Phone:', 'woocommerce' ); ?></th>
				<td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
	</table>

	<?php if ( $show_shipping ) : ?>

        <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses clearfix">
            <div class="wtbx-col-sm-6 zero-left-padding">
                <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address address">

        <?php else: ?>

        <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses clearfix">
            <div class="wtbx-col-sm-12 zero-left-padding">
                <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address address">

        <?php endif; ?>

                    <div class="title">
                        <h3 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h3>
                    </div>
                    <address>
	                    <?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>
                    </address>

        <?php if ( $show_shipping ) : ?>

                </div><!-- /.col-1 -->
            </div>

            <div class="wtbx-col-sm-6 zero-right-padding">
                <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2 address">
                    <div class="title">
                        <h3 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h3>
                    </div>
                    <address>
                        <?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>
                    </address>
        <?php endif; ?>

                </div><!-- /.col-2 -->
            </div>

        </section><!-- /.col2-set -->

        <?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

    </section>
