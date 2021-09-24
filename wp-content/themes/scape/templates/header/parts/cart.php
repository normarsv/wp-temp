<?php if ( class_exists( 'WooCommerce' ) ) : ?>
    <div class="wtbx_header_part header_button header_cart_wrapper header_cart_wrapper_prim header_button_height">
        <?php global $woocommerce; ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Click to view your shopping cart', 'scape' ); ?>" class="header_cart wtbx_h_text_color wtbx_h_text_color_hover header_button_height">
            <?php echo wtbx_woocommerce_cart_button(); ?>
        </a>
        <?php woocommerce_cart_widget() ?>
    </div>
<?php endif; ?>