<?php
require_once dirname( __FILE__ ) . '/api/CnbAppRemotePayment.php';
require_once dirname( __FILE__ ) . '/api/CnbAppRemote.php';

// part of domain-upgrade
function cnb_admin_page_domain_upgrade_get_checkout($arg) {
    $planId  = filter_input( INPUT_POST, 'planId', FILTER_SANITIZE_STRING );
    $domainId  = filter_input( INPUT_POST, 'domainId', FILTER_SANITIZE_STRING );

    $url = admin_url('admin.php');
    $redirect_link =
        add_query_arg(
            array(
                'page' => 'call-now-button-domains',
                'action' => 'upgrade',
                'id' => $domainId,
                'upgrade' => 'success'),
            $url );
    $callbackUri = esc_url_raw( $redirect_link );
    $checkoutSession = CnbAppRemotePayment::cnb_remote_post_subscription( $planId, $domainId, $callbackUri );
    if ($checkoutSession instanceof WP_Error) {
        return -1;
    } else {
        // Get link based on Stripe checkoutSessionId
        esc_html_e($checkoutSession->checkoutSessionId);
    }
    wp_die();
}
add_action( 'wp_ajax_cnb_get_checkout', 'cnb_admin_page_domain_upgrade_get_checkout' );
