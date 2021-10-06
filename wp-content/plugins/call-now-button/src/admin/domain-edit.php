<?php

require_once dirname( __FILE__ ) . '/api/CnbAppRemote.php';
require_once dirname( __FILE__ ) . '/api/CnbAdminCloud.php';
require_once dirname( __FILE__ ) . '/partials/admin-functions.php';
require_once dirname( __FILE__ ) . '/partials/admin-header.php';
require_once dirname( __FILE__ ) . '/partials/admin-footer.php';

/***
 * To ensure arrays are properly sanitized to WordPress Codex standards,
 * they encourage usage of sanitize_text_field(). That only works with a single
 * variable (string). This function allows for a full blown array to get sanitized
 * properly, while sanitizing each individual value in a key -> value pair.
 *
 * Source: https://wordpress.stackexchange.com/questions/24736/wordpress-sanitize-array
 * Author: Broshi, answered Feb 5 '17 at 9:14
 * Via:    https://developer.wordpress.org/reference/functions/sanitize_text_field/
 */
function cnb_wporg_recursive_sanitize_text_field( $array ) {
    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = cnb_wporg_recursive_sanitize_text_field( $value );
        } else {
            $value = sanitize_text_field( $value );
        }
    }
    return $array;
}

function cnb_add_header_domain_edit($domain=null) {
    $domain_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
    $name = 'New Domain';

    if ($domain && !empty($domain->id) && $domain->id !== 'new') {
        $name = $domain->name;
    }
    if (strlen($domain_id) > 0 && $domain_id === 'new') {
        echo 'Add domain';
    } else {
        echo 'Edit domain: "' . esc_html($name) . '"';
    }
}

/**
 * This is called to create the Domain
 */
function cnb_admin_page_domain_create_process() {
    global $cnb_slug_base;
    $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    if( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $nonce, 'cnb_create_domain') ) {

        // sanitize the input
        $domain_data = filter_input(
            INPUT_POST,
            'domain',
            FILTER_SANITIZE_STRING,
            FILTER_REQUIRE_ARRAY | FILTER_FLAG_NO_ENCODE_QUOTES);

        $domain = array();
        $domain['name'] = sanitize_text_field( $domain_data['name'] );
        $domain['timezone'] = sanitize_text_field( $domain_data['timezone'] );
        $domain['trackGA'] = sanitize_text_field( $domain_data['trackGA'] );
        $domain['trackConversion'] = sanitize_text_field( $domain_data['trackConversion'] );
        $domain['properties'] = cnb_wporg_recursive_sanitize_text_field( $domain_data['properties']);

        // Convert into booleans
        $domain['trackGA'] = !empty($domain['trackGA']) ? $domain['trackGA'] : "false";
        $domain['trackConversion'] = !empty($domain['trackConversion']) ? $domain['trackConversion'] : "false";
        $domain['renew'] = !empty($domain['renew']) ? $domain['renew'] : "false";

        // Convert the zindex order back to an actual zindex
        $domain['properties']['zindex'] = zindex($domain['properties']['zindex']);

        // do the processing
        $cnb_cloud_notifications = array();
        $new_domain = CnbAdminCloud::cnb_create_domain( $cnb_cloud_notifications, $domain );

        // redirect the user to the appropriate page
        $transient_id = 'cnb-' . wp_generate_uuid4();
        set_transient( $transient_id, $cnb_cloud_notifications, HOUR_IN_SECONDS );

        // Get ID in case of error
        $id = 'new';
        if ((!$new_domain instanceof WP_Error)) {
            $id = $new_domain->id;
        }

        // Create link
        $url           = admin_url( 'admin.php' );
        $redirect_link =
            add_query_arg(
                array(
                    'page'   => 'call-now-button-domains',
                    'action' => 'edit',
                    'id'     => $id,
                    'tid'    => $transient_id
                ),
                $url );
        $redirect_url  = esc_url_raw( $redirect_link );
        wp_safe_redirect( $redirect_url );
        exit;
    }
    else {
        wp_die( __( 'Invalid nonce specified', CNB_NAME), __( 'Error', CNB_NAME), array(
            'response' 	=> 403,
            'back_link' => 'admin.php?page=' . $cnb_slug_base,
        ) );
    }
}

function cnb_admin_page_domain_edit_process_domain($domain_data, &$transient_id=null) {
    $domain = array();

    // sanitize the input
    $domain['id'] = sanitize_text_field( $domain_data['id'] );
    if (isset($domain_data['name'])) {
        $domain['name'] = sanitize_text_field($domain_data['name']);
    }
    $domain['renew'] = sanitize_text_field( isset($domain_data['renew']) ? $domain_data['renew'] : 'false' );
    $domain['timezone'] = sanitize_text_field( $domain_data['timezone'] );
    $domain['trackGA'] = sanitize_text_field( isset($domain_data['trackGA']) ? $domain_data['trackGA'] : 'false' );
    $domain['trackConversion'] = sanitize_text_field( isset($domain_data['trackConversion']) ? $domain_data['trackConversion'] : 'false' );
    $domain['properties'] = cnb_wporg_recursive_sanitize_text_field( $domain_data['properties']);

    // Convert into booleans
    $domain['trackGA'] = !empty($domain['trackGA']) ? $domain['trackGA'] : 'false';
    $domain['trackConversion'] = !empty($domain['trackConversion']) ? $domain['trackConversion'] : 'false';
    $domain['renew'] = !empty($domain['renew']) ? $domain['renew'] : 'false';

    // Convert the zindex order back to an actual zindex
    $domain['properties']['zindex'] = zindex($domain['properties']['zindex']);

    // do the processing
    $cnb_cloud_notifications = array();
    CnbAdminCloud::cnb_update_domain( $cnb_cloud_notifications, $domain );

    $transient_id = 'cnb-' . wp_generate_uuid4();
    set_transient($transient_id, $cnb_cloud_notifications, HOUR_IN_SECONDS);

    return $domain;
}
/**
 * This is called to update the Domain
 */
function cnb_admin_page_domain_edit_process() {
    global $cnb_slug_base;
    $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    if( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $nonce, 'cnb_update_domain') ) {

        $domain_data = $_POST['domain'];
        $transient_id = null;
        $domain = cnb_admin_page_domain_edit_process_domain($domain_data, $transient_id);

        // redirect the user to the appropriate page
        $url = admin_url('admin.php');
        $redirect_link =
            add_query_arg(
                array(
                    'page' => 'call-now-button-domains',
                    'action' => 'edit',
                    'id' => $domain['id'],
                    'tid' => $transient_id),
                $url );
        $redirect_url = esc_url_raw( $redirect_link );
        wp_safe_redirect($redirect_url);
        exit;
    }
    else {
        wp_die( __( 'Invalid nonce specified', CNB_NAME), __( 'Error', CNB_NAME), array(
            'response' 	=> 403,
            'back_link' => 'admin.php?page=' . $cnb_slug_base,
        ) );
    }
}

function cnb_admin_page_domain_edit_render() {
    global $cnb_options, $cnb_settings;

    $cnb_notices = cnb_get_notices();
    $cnb_changelog = cnb_get_changelog();

    $domain_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
    $domain = new stdClass();
    if (strlen($domain_id) > 0 && $domain_id != 'new') {
        $domain = CnbAppRemote::cnb_remote_get_domain( $domain_id );
    }
    // Domain specific conversions

    // Set default values in case they are missing
    if (strlen($domain_id) > 0 && $domain_id == 'new' && empty($domain->id)) {
        $domain->id = null;
    }
    if (empty($domain->timezone)) {
        $domain->timezone = wp_timezone_string();
    }
    if (empty($domain->type)) {
        $domain->type = 'FREE';
    }
    if (empty($domain->properties)) {
        $domain->properties = new stdClass();
        $domain->properties->scale = '1';
        $domain->properties->debug = false;
    }
    if (empty($domain->name)) {
        $domain->name = null;
    }
    if (!isset($domain->trackGA)) {
        $domain->trackGA = true;
    }
    if (!isset($domain->trackConversion)) {
        $domain->trackConversion = true;
    }

    add_action('cnb_header', function() use($domain) {
        cnb_add_header_domain_edit($domain);
    });

    ?>

    <div class="wrap">
        <?php cnb_admin_header($cnb_options, $cnb_settings, $cnb_notices, $cnb_changelog) ?>
        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
            <input type="hidden" name="page" value="call-now-button" />
            <input type="hidden" name="action" value="<?php echo $domain_id === 'new' ? 'cnb_create_domain' :'cnb_update_domain' ?>" />
            <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce($domain_id === 'new' ? 'cnb_create_domain' : 'cnb_update_domain')?>" />

            <table class="form-table nav-tab-active" role="presentation">
            <?php cnb_admin_page_domain_edit_render_form($domain) ?>
            </table>

            <?php submit_button(); ?>
        </form>

        <?php cnb_admin_footer() ?>
    </div>
<?php }

function cnb_admin_page_domain_edit_render_form($domain) {
    $domain_properties_zindex = !empty($domain->properties->zindex) ? $domain->properties->zindex : 2147483647;
    $domain_properties_zindex_order = zindexToOrder($domain_properties_zindex);

    $url          = admin_url( 'admin.php' );
    $upgrade_link =
        add_query_arg( array(
            'page'   => 'call-now-button-domains',
            'action' => 'upgrade',
            'id'     => $domain->id
        ),
            $url );
    $upgrade_url  = esc_url( $upgrade_link );
?>
        <tr>
            <th>Plan</th>
            <td>
                <code><?php esc_html_e($domain->type) ?></code>
                <?php
                if ($domain->type !== 'PROPLUS') {
                    echo '<a href="' . $upgrade_url . '">Upgrade!</a>';
                }
                ?>               
            </td>
        </tr>        <?php if ($domain->type != 'FREE') { ?>
            <tr>
                <th scope="row">Renew</th>
                <td><fieldset><legend class="screen-reader-text"><span>Renew</span></legend><label for="renew">
                            <input name="domain[renew]" type="checkbox" id="renew" value="true" <?php checked('1', $domain->renew); ?>  />
                            Renew domain automatically</label>
                    </fieldset>
                    <?php if (!empty($domain->expires)) { ?>
                        <p class="description" id="domain_expires-description">
                            Domain expires <code><?php esc_html_e($domain->expires) ?></code>.
                        </p>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th colspan="2"><h2>Tracking</h2></th>
        </tr>
        <tr>
            <th scope="row">Google Analytics</th>
            <td>
                        <input type="hidden" name="domain[trackGA]" value="0" />
                        <input name="domain[trackGA]" type="checkbox" id="google_analytics" value="true" <?php checked('1', $domain->trackGA); ?>  />
                        <label for="google_analytics">Enable </label>
                    <p class="description">
                        Supports Classic, Universal Analytics and Global site tag (v3 and v4).<br>
                        Using Google Tag Manager? Set up click tracking in GTM. <a href="https://callnowbutton.com/support/click-tracking/google-tag-manager-event-tracking/?utm_source=wp-plugin&amp;utm_medium=referral&amp;utm_campaign=description_link&amp;utm_term=google-tag-manager-event-tracking" target="_blank">Learn how to do this...</a>
                    </p>
                </td>
        </tr>
        <tr>
            <th scope="row">Google Ads conversions</th>
            <td>
               <input type="hidden" name="domain[trackConversion]" value="0" />
                <input name="domain[trackConversion]" type="checkbox" id="conversion_tracking" value="true" <?php checked('1', $domain->trackConversion); ?>  />
                <label for="conversion_tracking">Enable</label>
                <p class="description">Select this option if you want to count clicks on the button as Google Ads conversions. This option requires the Event snippet to be present on the page. <a href="https://support.google.com/google-ads/answer/6331304" target="_blank">Learn more...</a></p>
            </td>
        </tr>
        <tr>
            <th colspan="2"><h2>Button display</h2></th>
        </tr>
        <tr class="zoom">
            <th scope="row">Button size <span id="cnb_slider_value"></span></th>
            <td><fieldset>
                    <label class="cnb_slider_value" for="cnb_slider" onclick="jQuery('#cnb_slider:enabled')[0].stepDown();cnb_update_sliders()">Smaller&nbsp;&laquo;&nbsp;</label>
                    <input type="range" min="0.7" max="1.3" step="0.1" name="domain[properties][scale]"
                           value="<?php esc_attr_e($domain->properties->scale) ?>" class="slider" id="cnb_slider">
                    <label class="cnb_slider_value" for="cnb_slider" onclick="jQuery('#cnb_slider:enabled')[0].stepUp();cnb_update_sliders()">&nbsp;&raquo;&nbsp;Bigger</label>
                </fieldset></td>
        </tr>
        <tr class="z-index">
            <th scope="row">Order (<span id="cnb_order_value"></span>) <a
                        href="https://callnowbutton.com/set-order/" target="_blank" class="cnb-nounderscore">
                    <span class="dashicons dashicons-editor-help"></span>
                </a></th>
            <td>
                <label class="cnb_slider_value" for="cnb_order_slider" onclick="jQuery('#cnb_order_slider:enabled')[0].stepDown();cnb_update_sliders()">Backwards&nbsp;&laquo;&nbsp;</label>
                <input type="range" min="1" max="10" name="domain[properties][zindex]"
                       value="<?php esc_attr_e($domain_properties_zindex_order) ?>" class="slider2" id="cnb_order_slider"
                       step="1">
                <label class="cnb_slider_value" for="cnb_order_slider" onclick="jQuery('#cnb_order_slider:enabled')[0].stepUp();cnb_update_sliders()">&nbsp;&raquo;&nbsp;Front</label>
                <p class="description">The default (and recommended) value is all the way to the front so the
                    button sits on top of everything else. In case you have a specific usecase where you want
                    something else to sit in front of the Call Now Button (e.g. a chat window or a cookie
                    notice) you can move this backwards one step at a time to adapt it to your situation.</p>
            </td>
        </tr>
        <tr>
            <th colspan="2"><h2>Advanced</h2></th>
        </tr>
    <tr>
        <th scope="row"><label for="domain_name">Domain name</label></th>
        <td>
            <input type="hidden" name="domain[id]" value="<?php esc_attr_e($domain->id) ?>" />
            <input type="text" id="domain_name" name="domain[name]" value="<?php esc_attr_e($domain->name) ?>" class="regular-text" disabled="disabled"/>
            <p class="description">
                <strong>Warning</strong>: Changing your domain name means remapping all existing Buttons for that domain. Please use with caution. <a class="cnb_cursor_pointer" onclick="return jQuery('#domain_name').prop('disabled', false);">Click here to change your domain.</a>
            </p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="domain_timezone">Timezone</label></th>
        <td>
            <select name="domain[timezone]" id="domain_timezone">
                <?php echo wp_timezone_choice($domain->timezone) ?>
            </select>
            <p class="description" id="domain_timezone-description">
                <?php if (empty($domain->timezone)) { ?>
                    Please select your timezone.
                <?php } else { ?>
                    Currently set to <code><?php esc_html_e($domain->timezone) ?></code>.
                <?php } ?>
            </p>
        </td>
    </tr>
    <tr>
            <th scope="row">Debug mode</th>
            <td>
                        <input type="hidden" name="domain[properties][debug]" value="false" />
                        <input name="domain[properties][debug]" type="checkbox" id="domain_properties_debug" value="true" <?php checked('true', $domain->properties->debug); ?>  />
                        <label for="domain_properties_debug">Enabled</label>
                    <p class="description">
                        This enables some additional information in your browser's console, which can help during troubleshooting.
                    </p>
                </fieldset></td>
        </tr>
    <?php
}
