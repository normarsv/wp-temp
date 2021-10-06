<?php
require_once dirname( __FILE__ ) . '/../../utils/notices.php';

function cnb_admin_header_get_cloud_error($error) {
    return cnb_api_key_invalid_notice($error);
}

function cnb_admin_header( $cnb_options, $cnb_settings, $cnb_cloud_notifications = array(), $cnb_changelog = array() ) {
    echo '<h1 class="wp-heading-inline">';
    do_action( 'cnb_header' );
    do_action( 'cnb_after_header' );
    echo '</h1>';

    echo '<!--## NOTIFICATION BARS ##  -->';

    // Display notification that the button is active or inactive
    if ( $cnb_options['active'] != 1 ) {
        echo cnb_button_disabled_notice();
    }

    if ( $cnb_options['active'] == 1 && $cnb_options['status'] == 'enabled' && empty($cnb_options['number'])) {
        echo cnb_button_classic_enabled_but_no_number_notice();
    }

    // Display notification that there's a caching plugin active
    if ( isset( $_GET['settings-updated'] ) ) {
        $cnb_caching_check = cnb_check_for_caching();
        if ( $cnb_caching_check[0] == true ) {
            echo cnb_caching_plugin_warning_notice($cnb_caching_check[1]);
        }
    }

    // Show the notifications after updating the cloud
    if ( is_array( $cnb_cloud_notifications ) ) {
        foreach ( $cnb_cloud_notifications as $cnb_cloud_notification ) {
            echo $cnb_cloud_notification;
        }
    }

    // inform existing users about updates to the button
    if ( $cnb_settings['updated'][0] ) {
        echo '<div class="notice-warning notice is-dismissible">';
        $cnb_old_version = $cnb_settings['updated'][1];
        echo '<h3>' . CNB_NAME . ' has been updated!</h3><h4>What\'s new?</h4>';
        // Only on first run after update show list of changes since last update
        foreach ( $cnb_changelog as $key => $value ) {
            if ( $key > $cnb_old_version ) {
                echo '<h3>' . esc_html($key) . '</h3>';
                if ( is_array( $value ) ) {
                    foreach ( $value as $item ) {
                        echo '<p><span class="dashicons dashicons-yes"></span> ' . esc_html($item) . '</p>';
                    }
                } else {
                    echo '<p><span class="dashicons dashicons-yes"></span> ' . esc_html($value) . '</p>';
                }
            }
        }
        echo '</div>';
    }
}
