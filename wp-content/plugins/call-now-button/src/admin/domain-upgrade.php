<?php

require_once dirname( __FILE__ ) . '/api/CnbAppRemote.php';
require_once dirname( __FILE__ ) . '/api/CnbAppRemotePayment.php';
require_once dirname( __FILE__ ) . '/api/CnbAdminCloud.php';
require_once dirname( __FILE__ ) . '/partials/admin-functions.php';
require_once dirname( __FILE__ ) . '/partials/admin-header.php';
require_once dirname( __FILE__ ) . '/partials/admin-footer.php';

function cnb_add_header_domain_upgrade() {
    echo 'Upgrade domain';
}

/**
 * Sort currency first, then type (so EUR->Pro, EUR->Pro+, USD->Pro, USD->Pro+)
 */
function cnb_plan_sort($a, $b) {
    $currency = strcmp($a->currency, $b->currency);
    if ($currency === 0) {
        return strcmp($a->domainType, $b->domainType);
    }
    return $currency;
}

function cnb_get_domain() {
    $domain_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
    $domain = new stdClass();
    if (strlen($domain_id) > 0 && $domain_id != 'new') {
        $domain = CnbAppRemote::cnb_remote_get_domain( $domain_id );
    }
    return $domain;
}

function cnb_domain_type_is_current_or_better($plan, $domain) {
    if ($domain->type === 'FREE') {
        return false;
    }
    switch ($domain->type) {
        case 'PRO':
            return $plan->domainType === 'PRO';
        case 'PROPLUS':
            return $plan->domainType === 'PRO' || $plan->domainType === 'PROPLUS';
        default: // Same as 'FREE'
            return false;
    }
}

function cnb_print_domain_upgrade_notice_cache_flush() {
    $upgradeStatus = filter_input( INPUT_GET, 'upgrade', FILTER_SANITIZE_STRING );
    $checkoutSesionId = filter_input( INPUT_GET, 'checkout_session_id', FILTER_SANITIZE_STRING );
    if ($upgradeStatus || $checkoutSesionId) {
        // Increase the cache ID
        CnbAppRemote::cnb_incr_transient_base();
    }
}


function cnb_print_domain_upgrade_notice($domain, &$cnb_notices) {
    $upgradeStatus = filter_input( INPUT_GET, 'upgrade', FILTER_SANITIZE_STRING );
    $checkoutSesionId = filter_input( INPUT_GET, 'checkout_session_id', FILTER_SANITIZE_STRING );
    if ($upgradeStatus === 'success?payment=success') {
        // Get checkout Session Details
        $session = CnbAppRemotePayment::cnb_remote_get_subscription_session( $checkoutSesionId );
        // This results in a subscription (via ->subscriptionId), get that for ->type
        $subscription = CnbAppRemotePayment::cnb_remote_get_subscription( $session->subscriptionId );
        //
        $message = '<div class="notice-success notice"><p>Your domain <strong>'.esc_html($domain->name).'</strong> has been upgraded to <strong>'.esc_html($subscription->type).'</strong>!</p></div>';
        $cnb_notices[] = $message;
        return true;
    }
    return false;
}

function cnb_admin_page_domain_upgrade_render() {
    global $cnb_options, $cnb_settings;

    add_action('cnb_header', 'cnb_add_header_domain_upgrade');

    $cnb_notices = cnb_get_notices();
    $cnb_changelog = cnb_get_changelog();

    $domain = cnb_get_domain();
    $updated = cnb_print_domain_upgrade_notice($domain, $cnb_notices);

    if ($updated) {
        cnb_print_domain_upgrade_notice_cache_flush();
        $domain = cnb_get_domain();
    }


    echo '<div class="wrap">';
    cnb_admin_header($cnb_options, $cnb_settings, $cnb_notices, $cnb_changelog);

    $plans = CnbAppRemotePayment::cnb_remote_get_plans();
    usort($plans, 'cnb_plan_sort');

    $planCount = count($plans);

    // If the type is missing, we assume FREE
    if (empty($domain->type)) {
        $domain->type = 'FREE';
    }

    // Stripe integration
    ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function cnb_get_checkout(planId) {
            jQuery('.spinner');
            const data = {
                'action': 'cnb_get_checkout',
                'planId': planId,
                'domainId': jQuery('#cnb_domain_id').val()
            };

            jQuery.post(ajaxurl, data, function(response) {
                cnb_goto_checkout(response)
            });
        }

        function cnb_goto_checkout(checkoutSessionId) {
            stripe.redirectToCheckout({ sessionId: checkoutSessionId });
        }

        const stripe = Stripe("<?php echo esc_js( CnbAppRemotePayment::cnb_remote_get_stripe_key()->key) ?>");
    </script>

    <h2><?php esc_html_e($domain->name) ?></h2>
    <form id="wp_domain_upgrade" method="post">
    <input type="hidden" name="cnb_domain_id" id="cnb_domain_id" value="<?php esc_attr_e($domain->id) ?>">
    <p>Your current plan: <code><?php esc_html_e($domain->type) ?></code></p>
    <h2>Select Plan</h2>
        <table class="cnb-pricing">
            <tr>
                <?php foreach ($plans as $plan) { ?>
                <td>
                    <h1><?php echo $plan->domainType === 'PROPLUS' ? 'PRO+' : 'PRO'; ?></h1>
                    <div class="cnb_font_120 cnb_font_bold"><?php echo $plan->currency === 'EUR' ? '€' : '$' ?><?php echo round($plan->price / 12.0, 2) ?>/month</div>
                    billed annually<br />
                    <?php if ($plan->domainType === $domain->type) { ?>
                        <strong>CURRENT PLAN</strong>
                    <?php } ?>
                </td>
                <?php } ?>
            </tr>
            <tr><?php echo str_repeat('<td>Unlimited buttons</td>', $planCount); ?></tr>
            <tr><?php echo str_repeat('<td>Scheduling</td>', $planCount); ?></tr>
            <tr><?php echo str_repeat('<td>Multi button</td>', $planCount); ?></tr>
            <tr><?php echo str_repeat('<td>Button bar</td>', $planCount); ?></tr>
            <tr>
            <?php foreach ($plans as $plan) {
                if ($plan->domainType === 'PRO') { ?>
                <td>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6.54 5c.06.89.21 1.76.45 2.59l-1.2 1.2c-.41-1.2-.67-2.47-.76-3.79h1.51m9.86 12.02c.85.24 1.72.39 2.6.45v1.49c-1.32-.09-2.59-.35-3.8-.75l1.2-1.19M7.5 3H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.49c0-.55-.45-1-1-1-1.24 0-2.45-.2-3.57-.57-.1-.04-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.45-5.15-3.76-6.59-6.59l2.2-2.2c.28-.28.36-.67.25-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1z"></path>
                    </svg>
                </td>
                <?php } else { ?>
                <td>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6.54 5c.06.89.21 1.76.45 2.59l-1.2 1.2c-.41-1.2-.67-2.47-.76-3.79h1.51m9.86 12.02c.85.24 1.72.39 2.6.45v1.49c-1.32-.09-2.59-.35-3.8-.75l1.2-1.19M7.5 3H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.49c0-.55-.45-1-1-1-1.24 0-2.45-.2-3.57-.57-.1-.04-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.45-5.15-3.76-6.59-6.59l2.2-2.2c.28-.28.36-.67.25-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1z"></path>
                    </svg>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"></path>
                    </svg>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M16.75,13.96C17,14.09 17.16,14.16 17.21,14.26C17.27,14.37 17.25,14.87 17,15.44C16.8,16 15.76,16.54 15.3,16.56C14.84,16.58 14.83,16.92 12.34,15.83C9.85,14.74 8.35,12.08 8.23,11.91C8.11,11.74 7.27,10.53 7.31,9.3C7.36,8.08 8,7.5 8.26,7.26C8.5,7 8.77,6.97 8.94,7H9.41C9.56,7 9.77,6.94 9.96,7.45L10.65,9.32C10.71,9.45 10.75,9.6 10.66,9.76L10.39,10.17L10,10.59C9.88,10.71 9.74,10.84 9.88,11.09C10,11.35 10.5,12.18 11.2,12.87C12.11,13.75 12.91,14.04 13.15,14.17C13.39,14.31 13.54,14.29 13.69,14.13L14.5,13.19C14.69,12.94 14.85,13 15.08,13.08L16.75,13.96M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C10.03,22 8.2,21.43 6.65,20.45L2,22L3.55,17.35C2.57,15.8 2,13.97 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12C4,13.72 4.54,15.31 5.46,16.61L4.5,19.5L7.39,18.54C8.69,19.46 10.28,20 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4Z"></path>
                    </svg>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                    </svg>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17 7h-4v2h4c1.65 0 3 1.35 3 3s-1.35 3-3 3h-4v2h4c2.76 0 5-2.24 5-5s-2.24-5-5-5zm-6 8H7c-1.65 0-3-1.35-3-3s1.35-3 3-3h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-2zm-3-4h8v2H8z"></path>
                    </svg>
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12,2A3,3 0 0,0 9,5C9,6.27 9.8,7.4 11,7.83V10H8V12H11V18.92C9.16,18.63 7.53,17.57 6.53,16H8V14H3V19H5V17.3C6.58,19.61 9.2,21 12,21C14.8,21 17.42,19.61 19,17.31V19H21V14H16V16H17.46C16.46,17.56 14.83,18.63 13,18.92V12H16V10H13V7.82C14.2,7.4 15,6.27 15,5A3,3 0 0,0 12,2M12,4A1,1 0 0,1 13,5A1,1 0 0,1 12,6A1,1 0 0,1 11,5A1,1 0 0,1 12,4Z"></path>
                    </svg>
                </td>
            <?php } } ?>
            </tr>
            <tr><?php
                // Get link based on Stripe checkoutSessionId
                foreach ( $plans as $plan ) {
                    echo '<td><button class="button button-secondary" type="button" ';
                    if ( cnb_domain_type_is_current_or_better($plan, $domain) ) {
                        echo 'disabled="disabled"';
                    } else {
                        echo 'onclick="cnb_get_checkout(\'' . esc_js($plan->id) . '\')"';
                    }
                    echo '>Upgrade</button></td>';
                }
                ?></tr>
        </table>
    </form>
    <?php
    cnb_admin_footer();
    echo '</div>';
}
