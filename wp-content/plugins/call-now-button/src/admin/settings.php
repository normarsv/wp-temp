<?php

require_once dirname( __FILE__ ) . '/api/CnbAppRemote.php';
require_once dirname( __FILE__ ) . '/api/CnbAdminCloud.php';
require_once dirname( __FILE__ ) . '/domain-edit.php';
require_once dirname( __FILE__ ) . '/partials/admin-functions.php';
require_once dirname( __FILE__ ) . '/partials/admin-header.php';
require_once dirname( __FILE__ ) . '/partials/admin-footer.php';

function cnb_add_header_settings() {
    echo 'Settings';
}

function cnb_settings_create_tab_url($tab) {
    $url = admin_url('admin.php');
    $tab_link =
        add_query_arg(
            array(
                'page' => 'call-now-button-settings',
                'tab' => $tab),
            $url );
    return esc_url( $tab_link );
}

function cnb_settings_options_validate($input) {
    $messages = array();
    $messages[] = '<div class="notice-success notice is-dismissible"><p>Your settings have been updated!</p></div>';

    // When beta mode is disabled, disable the cloud as well
    if (array_key_exists('cloud_beta_enabled', $input) && $input['cloud_beta_enabled'] == 0) {
        $input['cloud_enabled'] = 0;
        $input['status'] = 'enabled';
    }

    // Since "active" and "cloud_enabled" have been merged into "status", we have to deal with that
    if (array_key_exists('status', $input)) {
        switch ($input['status']) {
            case 'disabled':
                $input['active'] = 0;
                $input['cloud_enabled'] = 0;
                break;
            case 'enabled':
                $input['active'] = 1;
                $input['cloud_enabled'] = 0;
                break;
            case 'cloud':
                $input['active'] = 1;
                $input['cloud_enabled'] = 1;
                break;
        }
    }

    // Cloud Domain settings can be set here as well
    if(array_key_exists('domain', $_POST) &&
        array_key_exists('cloud_enabled', $input) && $input['cloud_enabled'] === 1) {
        $domain = $_POST['domain'];
        $transient_id = null;
        cnb_admin_page_domain_edit_process_domain($domain, $transient_id);
        $messages = array_merge($messages, get_transient($transient_id));

        // Remove from settings
        unset($input['domain']);
    }

    $updated_options = array_merge(get_option('cnb'), $input);
    if (isset($updated_options['cloud_enabled']) && $updated_options['cloud_enabled'] === '1') {
        $cloud_id = CnbAdminCloud::cnb_set_default_option_for_cloud( $updated_options );
        if ($cloud_id != null) {
            $updated_options['cloud_use_id'] = $cloud_id;
        }
    }

    $transient_id = 'cnb-options';
    $_GET['tid'] = $transient_id;
    set_transient($transient_id, $messages, HOUR_IN_SECONDS);

    return $updated_options;
}

/**
 * Only true if beta is in the URL or beta mode is enabled via the options
 * @return bool
 */
function cnb_is_beta_user_via_url() {
    return filter_input( INPUT_GET, 'beta', FILTER_SANITIZE_STRING ) !== null;
}

/**
 * @param $cnb_options array Regular 'cnb' options
 *
 * @return bool
 */
function cnb_is_beta_user_via_options($cnb_options) {
    return is_array($cnb_options) && array_key_exists('cloud_beta_enabled', $cnb_options) && $cnb_options['cloud_beta_enabled'] == 1;
}

/**
 * @param $cnb_options array Regular 'cnb' options
 *
 * @return bool
 */
function cnb_is_beta_user_via_url_only($cnb_options) {
    $beta_url = cnb_is_beta_user_via_url();
    $beta_options = cnb_is_beta_user_via_options($cnb_options);
    return $beta_url && !$beta_options;
}
/**
 * Only true if beta is in the URL or beta mode is enabled via the options
 * @param $cnb_options array Regular 'cnb' options
 * @return bool
 */
function cnb_is_beta_user($cnb_options) {
//    $beta_url = cnb_is_beta_user_via_url();
//    $beta_options = cnb_is_beta_user_via_options($cnb_options);
//    return $beta_url || $beta_options;
    return cnb_is_beta_user_via_options($cnb_options);
}

function cnb_admin_settings_create_cloud_domain($cnb_user) {
    $nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    if( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $nonce, 'cnb_create_cloud_domain') ) {
        return CnbAdminCloud::cnb_wp_create_domain( $cnb_user );
    }
}

function cnb_admin_settings_migrate_legacy_to_cloud() {
    $nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    if( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $nonce, 'cnb_migrate_legacy_button') ) {
        return CnbAdminCloud::cnb_wp_migrate_button();
    }
}

function cnb_admin_setting_migrate() {
    // Update the cloud if requested
    $cnb_cloud_notifications = array();

    $action = !empty($_POST['action']) ? sanitize_text_field($_POST['action']) : null;
    switch ($action) {
        case 'cnb_create_cloud_domain':
            $cnb_user = CnbAppRemote::cnb_remote_get_user_info();
            $cnb_cloud_notifications = cnb_admin_settings_create_cloud_domain($cnb_user);
            break;
        case 'cnb_migrate_legacy_button':
            $cnb_cloud_notifications = cnb_admin_settings_migrate_legacy_to_cloud();
            break;
    }

    // redirect the user to the appropriate page
    $transient_id = 'cnb-' . wp_generate_uuid4();
    set_transient($transient_id, $cnb_cloud_notifications, HOUR_IN_SECONDS);

    // Create link
    $url = admin_url('admin.php');
    $redirect_link =
        add_query_arg(
            array(
                'page' => 'call-now-button-settings',
                'tid' => $transient_id,
            ),
            $url );
    $redirect_url = esc_url_raw( $redirect_link );
    wp_safe_redirect($redirect_url);
    exit;
}

function cnb_admin_settings_page() {
    global $cnb_options, $cnb_settings;

    add_action('cnb_header', 'cnb_add_header_settings');

    $cnb_notices = cnb_get_notices();
    $cnb_changelog = cnb_get_changelog();

    $beta = cnb_is_beta_user($cnb_options);
    $beta_tmp = cnb_is_beta_user_via_url_only($cnb_options);
    if ($beta_tmp) {
        $notice = '<form method="post" action="' . esc_url( admin_url('options.php') ) . '" class="cnb-container">';
        ob_start();
        settings_fields('cnb_options');
        $notice .= ob_get_clean();
        $notice .= '<input type="hidden" name="page" value="call-now-button-settings" />
            <table>
                <tr>
                <th scope="row"</th>
                <td>
                    <input type="hidden" name="cnb[cloud_beta_enabled]" value="1" />
                    <input type="submit" class="button-primary" value="' . __('Activate beta mode') . '"/> For testing new unreleased functionality. 
                </td>
                </table>
            </form>';
        $cnb_notices[] = '<div class="notice-warning notice"><p>'.$notice.'</p></div>';
    }
    $cnb_user = CnbAppRemote::cnb_remote_get_user_info();

    if (!($cnb_user instanceof WP_Error)) {
        // Let's check if the domain already exists
        $cnb_cloud_domain = CnbAppRemote::cnb_remote_get_wp_domain();
        $cnb_cloud_domains = CnbAppRemote::cnb_remote_get_domains();
        $cnb_clean_site_url = CnbAppRemote::cnb_clean_site_url();

        if (empty($cnb_cloud_domain->properties)) {
            $cnb_cloud_domain->properties = array();
        }
    }
    ?>

    <div class="wrap">
        <?php
        $show_advanced_view_only = array_key_exists('advanced_view', $cnb_options) && $cnb_options['advanced_view'] === 1;
        if ($show_advanced_view_only) {
            echo '<script type="text/javascript">show_advanced_view_only_set=1</script>';
        }

        cnb_admin_header($cnb_options, $cnb_settings, $cnb_notices, $cnb_changelog) ?>

        <h2 class="nav-tab-wrapper">
            <a href="<?php echo cnb_settings_create_tab_url('basic_options') ?>"
               class="nav-tab <?php echo cnb_is_active_tab('basic_options') ?>">General</a>
            <?php if ($cnb_options['status'] === 'cloud') { ?>
                <a href="<?php echo cnb_settings_create_tab_url('account_options') ?>"
                   class="nav-tab <?php echo cnb_is_active_tab('account_options') ?>">Account</a>
                <?php if ($show_advanced_view_only) { ?>
                <a href="<?php echo cnb_settings_create_tab_url('advanced_options') ?>"
                   class="nav-tab <?php echo cnb_is_active_tab('advanced_options') ?>">Advanced</a>
               <?php } ?>
            <?php } ?>
        </h2>
        <form method="post" action="<?php echo esc_url( admin_url('options.php') ); ?>" class="cnb-container">
            <?php settings_fields('cnb_options'); ?>
            <table class="form-table <?php echo cnb_is_active_tab('basic_options'); ?>">
                <tr>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th scope="row">Button status:</th>
                    <td>
                        <div class="cnb-radio-item">
                            <input type="radio" name="cnb[status]" id="cnb_status_disabled" value="disabled" <?php checked('disabled', $cnb_options['status']); ?> />
                            <label for="cnb_status_disabled">Disabled</label>
                        </div>
                        <div class="cnb-radio-item">
                            <input type="radio" name="cnb[status]" id="cnb_status_enabled" value="enabled" <?php checked('enabled', $cnb_options['status']); ?> />
                            <label for="cnb_status_enabled">Enabled <?php if (isset($cnb_options['cloud_beta_enabled']) && $cnb_options['cloud_beta_enabled']) { ?>(local)<?php } ?></label>
                        </div>
                        <?php if ($beta) { ?>
                        <div class="cnb-radio-item">
                            <input type="radio" id="cloud_enabled" name="cnb[status]" value="cloud" <?php checked('cloud', $cnb_options['status']) ?> />
                            <label for="cloud_enabled">Enabled (cloud)
                                <a href="<?php echo CNB_SUPPORT; ?>click-tracking/<?php cnb_utm_params("question-mark", "click-tracking"); ?>" target="_blank" class="cnb-nounderscore">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </a>
                            </label>
                        </div>
                        <?php } ?>
                    </td>
                </tr>
                <?php if ($cnb_options['status'] === 'enabled') { ?>
                <tr>
                    <th colspan="2"><h2>Tracking</h2></th>
                </tr>
                <tr>
                    <th scope="row">Click tracking: <a href="<?php echo CNB_SUPPORT; ?>click-tracking/<?php cnb_utm_params("question-mark", "click-tracking"); ?>" target="_blank" class="cnb-nounderscore">
                            <span class="dashicons dashicons-editor-help"></span>
                        </a></th>
                    <td>
                        <div class="cnb-radio-item">
                            <input id="tracking3" type="radio" name="cnb[tracking]" value="0" <?php checked('0', $cnb_options['tracking']); ?> />
                            <label for="tracking3">Disabled</label>
                        </div>
                        <div class="cnb-radio-item">
                            <input id="tracking4" type="radio" name="cnb[tracking]" value="3" <?php checked('3', $cnb_options['tracking']); ?> />
                            <label for="tracking4">Latest Google Analytics (gtag.js)</label>
                        </div>
                        <div class="cnb-radio-item">
                            <input id="tracking1" type="radio" name="cnb[tracking]" value="2" <?php checked('2', $cnb_options['tracking']); ?> />
                            <label for="tracking1">Google Universal Analytics (analytics.js)</label>
                        </div>
                        <div class="cnb-radio-item">
                            <input id="tracking2" type="radio" name="cnb[tracking]" value="1" <?php checked('1', $cnb_options['tracking']); ?> />
                            <label for="tracking2">Classic Google Analytics (ga.js)</label>
                        </div>
                        <p class="description">Using Google Tag Manager? Set up click tracking in GTM. <a href="<?php echo CNB_SUPPORT; ?>click-tracking/google-tag-manager-event-tracking/<?php cnb_utm_params("description_link", "google-tag-manager-event-tracking"); ?>" target="_blank">Learn how to do this...</a></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Google Ads: <a href="<?php echo CNB_SUPPORT; ?>google-ads/<?php cnb_utm_params("question-mark", "google-ads"); ?>" target="_blank" class="cnb-nounderscore">
                            <span class="dashicons dashicons-editor-help"></span>
                        </a></th>
                    <td class="conversions">
                        <div class="cnb-radio-item">
                            <input name="cnb[conversions]" id="conversions_0" type="radio" value="0" <?php checked('0', $cnb_options['conversions']); ?> /> <label for="conversions_0">Off </label>
                        </div>
                        <div class="cnb-radio-item">
                            <input name="cnb[conversions]" id="conversions_1" type="radio" value="1" <?php checked('1', $cnb_options['conversions']); ?> /> <label for="conversions_1">Conversion Tracking using Google's global site tag </label>
                        </div>
                        <div class="cnb-radio-item">
                            <input name="cnb[conversions]" id="conversions_2" type="radio" value="2" <?php checked('2', $cnb_options['conversions']); ?> /> <label for="conversions_2">Conversion Tracking using JavaScript</label>
                        </div>
                        <p class="description">Select this option if you want to track clicks on the button as Google Ads conversions. This option requires the Event snippet to be present on the page. <a href="https">Learn more...</a></p>
                    </td>
                </tr>
                <tr>
                    <th colspan="2"><h2>Button display</h2></th>
                </tr>
                <tr class="zoom">
                    <th scope="row">Button size <span id="cnb_slider_value"></span>:</th>
                    <td>
                        <label class="cnb_slider_value">Smaller&nbsp;&laquo;&nbsp;</label>
                        <input type="range" min="0.7" max="1.3" name="cnb[zoom]" value="<?php esc_attr_e($cnb_options['zoom']) ?>" class="slider" id="cnb_slider" step="0.1">
                        <label class="cnb_slider_value">&nbsp;&raquo;&nbsp;Bigger</label>
                    </td>
                </tr>
                <tr class="z-index">
                    <th scope="row">Order (<span id="cnb_order_value"></span>): <a href="https://callnowbutton.com/set-order/" target="_blank" class="cnb-nounderscore">
                            <span class="dashicons dashicons-editor-help"></span>
                        </a></th>
                    <td>
                        <label class="cnb_slider_value">Backwards&nbsp;&laquo;&nbsp;</label>
                        <input type="range" min="1" max="10" name="cnb[z-index]" value="<?php esc_attr_e($cnb_options['z-index']) ?>" class="slider2" id="cnb_order_slider" step="1">
                        <label class="cnb_slider_value">&nbsp;&raquo;&nbsp;Front</label>
                        <p class="description">The default (and recommended) value is all the way to the front so the button sits on top of everything else. In case you have a specific usecase where you want something else to sit in front of the Call Now Button (e.g. a chat window or a cookie notice) you can move this backwards one step at a time to adapt it to your situation.</p>
                    </td>
                </tr>
                <?php if($cnb_options['classic'] == 1) { ?>
                    <tr class="classic">
                        <th scope="row">Classic button: <a href="https://callnowbutton.com/new-button-design/<?php cnb_utm_params("question-mark", "new-button-design"); ?>" target="_blank" class="cnb-nounderscore">
                                <span class="dashicons dashicons-editor-help"></span>
                            </a></th>
                        <td>
                            <input type="hidden" name="cnb[classic]" value="0" />
                            <input id="classic" name="cnb[classic]" type="checkbox" value="1" <?php checked('1', $cnb_options['classic']); ?> /> <label title="Enable" for="classic">Active</label>
                        </td>
                    </tr>
                <?php
                }
            }
            if($cnb_options['status'] === 'cloud' && isset($cnb_cloud_domain) && !($cnb_cloud_domain instanceof WP_Error)) {
                cnb_admin_page_domain_edit_render_form($cnb_cloud_domain);
            } ?>
            <?php if ($beta) { ?>
                <?php if ($cnb_options['status'] !== 'cloud') { ?>
                    <tr>
                        <th colspan="2"><h2>Advanced</h2></th>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Beta mode:</th>
                    <td><label>
                            <input type="hidden" name="cnb[cloud_beta_enabled]" value="0" />
                            <input id="beta" type="checkbox" name="cnb[cloud_beta_enabled]" value="1" <?php checked('1', $beta); ?> />
                            <label title="Enabled" for="beta">Enabled</label>
                        </label>
                        <p class="description">You can stop being a beta user and return to the original button at any time</p>
                    </td>
                </tr>
            <?php } ?>
            </table>
            <?php if ($cnb_options['status'] === 'cloud') { ?>
            <table class="form-table <?php echo cnb_is_active_tab('account_options'); ?>">
                    <tr>
                        <th scope="row">API key</th>
                        <td>
                            <input type="text" class="regular-text" name="cnb[api_key]"
                                   value="<?php if (isset($cnb_options['api_key'])) { esc_attr_e($cnb_options['api_key']); } ?>"
                                   placeholder="e.g. b52c3f83-38dc-4493-bc90-642da5be7e39"/>
                            <?php if ($cnb_user instanceof WP_Error) { ?>
                                <p class="description">Get you key at <a href="<?php echo CNB_WEBSITE?>"><?php echo CNB_WEBSITE?></a></p>
                            <?php } ?>                                
                        </td>
                    </tr>
                     <?php if (!$cnb_user instanceof WP_Error) { ?>
                         <tr>
                            <th scope="row">Account owner</th>
                            <td>
                                <?php esc_html_e($cnb_user->name) ?>
                                <?php
                                    if ($cnb_user->email !== $cnb_user->name) { esc_html_e(' (' . $cnb_user->email . ')'); 
                                } ?>
                            </td>
                        </tr>
                         <tr>
                            <th scope="row">Account ID</th>
                            <td><code><?php esc_html_e($cnb_user->id) ?></code></td>
                        </tr>
                    <?php } ?>
            </table>
            <table class="form-table <?php echo cnb_is_active_tab('advanced_options'); ?>">
                <tr>
                    <th>Advanced view</th>
                    <td><label>
                            <input type="hidden" name="cnb[advanced_view]" value="0" />
                            <input type="checkbox" name="cnb[advanced_view]" value="1" <?php checked('1', $cnb_options['advanced_view']); ?> />
                            <p class="description">Show all the bells and whistles (for power users)</p>
                        </label>
                    </td>
                </tr>
                <?php if ($beta) { ?>
                    <tr class="cnb_advanced_view">
                        <th>Show traces</th>
                        <td><label>
                                <input type="hidden" name="cnb[footer_show_traces]" value="0" />
                                <input type="checkbox" name="cnb[footer_show_traces]" value="1" <?php checked('1', $cnb_options['footer_show_traces']); ?> />
                                <p class="description">Show the API calls and their timing in the footer.</p>
                            </label>
                        </td>
                    </tr>
                    <?php if (!($cnb_user instanceof WP_Error) && isset($cnb_cloud_domain)) { ?>
                        <tr class="when-cloud-enabled cnb_advanced_view">
                            <th scope="row">Domain</th>
                            <td>
                                <div>
                                    <p>Your domain: <strong><?php esc_html_e($cnb_clean_site_url) ?></strong></p>
                                    <?php if ($cnb_cloud_domain instanceof WP_Error) { ?>
                                        <p class="description notice notice-warning">Almost there! Create your domain using the button at the top of this page.</p>
                                    <?php } else { ?>
                                        <p class="description">Your domain <strong><?php esc_html_e($cnb_cloud_domain->name) ?></strong> is connected with ID <strong><?php esc_html_e($cnb_cloud_domain->id) ?></strong></p>
                                    <?php }?>
                                    <select name="cnb[cloud_use_id]">

                                        <optgroup label="Account-wide">
                                            <option
                                                    value="<?php esc_attr_e($cnb_user->id) ?>"
                                                <?php selected($cnb_user->id, $cnb_options['cloud_use_id']) ?>
                                            >
                                                Let the button decide
                                            </option>
                                        </optgroup>
                                        <optgroup label="Specific domain">
                                            <?php foreach ($cnb_cloud_domains as $domain) { ?>
                                                <option
                                                        value="<?php esc_attr_e($domain->id) ?>"
                                                    <?php selected($domain->id, $cnb_options['cloud_use_id']) ?>
                                                >
                                                    <?php esc_html_e($domain->name) ?>
                                                </option>
                                            <?php } ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } // end of beta check ?>
                <tr class="when-cloud-enabled cnb_advanced_view">
                    <th>API endpoint</th>
                    <td><label>
                            <input type="text" name="cnb[api_base]" class="regular-text"
                                   value="<?php echo CnbAppRemote::cnb_get_api_base() ?>" />
                            <p class="description">The API endpoint to use to communicate with the CallNowButton Cloud service. <br />
                                <strong>Do not change this unless you know what you're doing!</strong>
                            </p>
                        </label>
                    </td>
                </tr>
                <tr class="cnb_advanced_view">
                    <th>API caching</th>
                    <td><label>
                            <input type="hidden" name="cnb[api_caching]" value="0" />
                            <input type="checkbox" name="cnb[api_caching]" value="1" <?php checked('1', $cnb_options['api_caching']); ?> />
                            <p class="description">Cache API requests (using Wordpress transients)</p>
                    </label></td>
                </tr>
            </table>
            <?php } ?>
            <input type="hidden" name="cnb[version]" value="<?php echo CNB_VERSION; ?>"/>
            <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/></p>
        </form>

        <?php cnb_admin_footer() ?>
    </div>
<?php }
