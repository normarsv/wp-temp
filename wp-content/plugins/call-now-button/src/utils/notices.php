<?php
function cnb_settings_get_account_missing_notice($user) {
    global $cnb_options;

    $notice = '<div class="notice notice-warning">
            <h2 class="title">You\'re almost there!</h2>
            <p>You have enabled Cloud Hosting, but you need an account and API key from
                <a href="https://app.callnowbutton.com?utm_source=wp-plugin&utm_medium=referral&utm_campaign=beta_tester&utm_term=sign-up-for-api">https://app.callnowbutton.com</a>.</p>
            <p><ul>
                <li>Create an account on <a href="https://app.callnowbutton.com?utm_source=wp-plugin&utm_medium=referral&utm_campaign=beta_tester&utm_term=sign-up-for-api">https://app.callnowbutton.com</a></li>
                <li>Go to your profile page and click <strong>Create new API key</strong>.</li>
                <li>Copy the API key into the "API key" field below</li>
                <li>Click "Save API key"</li>
            </ul></p>
                <form method="post" action="' . esc_url( admin_url('options.php') ) . '" class="cnb-container">';
    ob_start();
    settings_fields('cnb_options');
    $notice .= ob_get_clean();
    $notice .= '<input type="hidden" name="page" value="call-now-button-settings" />
            <table class="form-table">
                <tr class="when-cloud-enabled">
                <th scope="row">Enter API key:</th>
                <td>
                    <input type="text" class="regular-text" name="cnb[api_key]"
                           value="' . ((isset($cnb_options['api_key'])) ? esc_attr($cnb_options['api_key']) : '') . '"
                           placeholder="e.g. b52c3f83-38dc-4493-bc90-642da5be7e39"/>
                    <input type="submit" class="button-primary" value="' . __('Save API key') . '"/>
                </td>
                </table>
            </form>';
    $notice .= CnbAdminCloud::cnb_admin_get_error_message_details($user);
    $notice .= '</div>';
    return $notice;
}

function cnb_settings_get_domain_missing_notice($domain) {
    $notice = '<div class="notice notice-warning">
                <h2 class="title">Domain not found yet</h2>
                <p>You have enabled Cloud Hosting and are logged in,
                    but we need to create the domain remotely.</p>
                <p>
                <form action="' . esc_url( admin_url('admin-post.php') ) . '" method="post">
                    <input type="hidden" name="page" value="call-now-button-settings" />
                    <input type="hidden" name="action" value="cnb_create_cloud_domain" />
                    <input type="hidden" name="_wpnonce" value="' . wp_create_nonce('cnb_create_cloud_domain') .'" />
                    <input type="submit" value="Create domain" class="button button-secondary" />
                </form>
                </p>';
    $notice .= CnbAdminCloud::cnb_admin_get_error_message_details( $domain );
    $notice .= '</div>';
    return $notice;
}

function cnb_settings_get_button_missing_notice() {
    return '<div class="notice notice-warning">
            <h2 class="title">Creating your first button</h2>
            <p>You have enabled Cloud Hosting and have your domain setup,
            so now it\'s time to create your first button.</p>
            <p>To make it easy, we can migrate your existing button to the Cloud.</p>
            <p>
            <form action="'. esc_url( admin_url('admin-post.php') ) .'" method="post">
                <input type="hidden" name="page" value="call-now-button-settings" />
                <input type="hidden" name="action" value="cnb_migrate_legacy_button" />
                <input type="hidden" name="_wpnonce" value="'. wp_create_nonce('cnb_migrate_legacy_button') .'" />
                <input type="submit" value="Migrate button" class="button button-secondary" />
            </form>
            </p>
        </div>';
}

function cnb_settings_get_buttons_missing_notice($error) {
    $notice = '<div class="notice notice-warning">
            <h2 class="title">Could not retrieve Buttons</h2>
            <p>Something unexpected went wrong retrieving the Buttons for this API key</p>';
    $notice .= CnbAdminCloud::cnb_admin_get_error_message_details( $error );
    $notice .= '</div>';
    return $notice;
}

function cnb_api_key_invalid_notice($error) {
    $url = admin_url('admin.php');
    $redirect_link =
        add_query_arg(
            array(
                'page' => 'call-now-button-settings',
            ),
            $url );
    $redirect_url = esc_url( $redirect_link );

    $errorNotice = '<div class="notice notice-error">
            <h2 class="title">API Key invalid</h2>
            <p>You have enabled Cloud Hosting, but you need a valid API key from CallNowButtom</p>
            <p>Go to <a href="'.$redirect_url.'">Settings</a> for instructions.</p>';
    $errorNotice .= CnbAdminCloud::cnb_admin_get_error_message_details( $error );
    $errorNotice .= '</div>';
    return $errorNotice;

}

function cnb_button_disabled_notice() {
    $url = admin_url('admin.php');
    $redirect_link =
        add_query_arg(
            array(
                'page' => 'call-now-button-settings',
            ),
            $url );
    $redirect_url = esc_url( $redirect_link );

    return '<div class="notice-error notice">
        <p>The Call Now Button is currently <b>disabled</b>.
        Change the <i>Button status</i> under <a href="'.$redirect_url.'">Settings</a> to enable.</p></div>';
}

function cnb_button_classic_enabled_but_no_number_notice() {
    $url = admin_url('admin.php');
    $redirect_link =
        add_query_arg(
            array(
                'page' => 'call-now-button-settings',
            ),
            $url );
    $redirect_url = esc_url( $redirect_link );

    return '<div class="notice-warning notice">
        <p>The Call Now Button is currently <strong>active without a phone number</strong>.
        Change the <i>Button status</i> under <a href="'.$redirect_url.'">Settings</a> to disable or enter a phone number.</p></div>';
}

function cnb_caching_plugin_warning_notice($caching_plugin_name) {
    return '<div class="notice-error notice">
        <p><span class="dashicons dashicons-warning"></span> 
        Your website is using a <strong><i>Caching Plugin</i></strong> (' . $caching_plugin_name . ').
        If you\'re not seeing your button or your changes, make sure you empty your cache first.</p></div>';
}