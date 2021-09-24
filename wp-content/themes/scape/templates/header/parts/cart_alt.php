<?php if ( class_exists( 'WooCommerce' ) ) : ?>
    <div class="wtbx_header_part header_button header_cart_wrapper header_button_alt header_cart_wrapper_alt">
        <?php global $woocommerce; ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Click to view your shopping cart', 'scape' ); ?>" class="header_cart header_alt_button">
            <?php echo wtbx_woocommerce_cart_button(true); ?>
        </a>
        <?php woocommerce_cart_widget() ?>
    </div>
<?php endif; ?>