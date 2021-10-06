<?php

class CnbAdminCloud {

    /**
     * Called when Cloud Hosting is enabled via settings
     *
     * If no ID has been set yet, it sets a sane default
     *
     * @param $options array
     *
     * @return string The ID to use for the Cloud Button
     */
    public static function cnb_set_default_option_for_cloud( $options ) {
        global $cnb_options;
        if ( isset( $cnb_options['cloud_use_id'] ) && ! empty( $cnb_options['cloud_use_id'] ) ) {
            return $cnb_options['cloud_use_id'];
        }
        if ( ! isset( $cnb_options['api_key'] ) || empty( $cnb_options['api_key'] ) ) {
            $cnb_options['api_key'] = $options['api_key'];
        }
        $user_info = CnbAppRemote::cnb_remote_get_user_info();
        if ( $user_info instanceof WP_Error ) {
            return '';
        }

        return $user_info->id;
    }

    /**
     * @param $button
     * @param array $actions Should ONLY contain Ids, not full objects
     * @param array $conditions
     *
     * @return array
     */
    public static function cnb_update_button_and_conditions( $button, $actions = array(), $conditions = array() ) {
        $cnb_cloud_notifications = array();
        // No need to update the Condition, this is done via the Button for now

        // 2: Update the Condition(s)
        $new_conditions = array();
        foreach ( $conditions as $condition ) {
            if ( $condition['delete'] === 'true' ) {
                // 2.1 Delete now unused Conditions
                CnbAppRemote::cnb_remote_delete_condition( $condition );
            } else if ( $condition['id'] === '' ) {
                // 2.2 Create new Conditions
                $new_conditions[] = self::cnb_create_condition( $cnb_cloud_notifications, $condition );
            } else if ( $condition['id'] !== '' ) {
                // 2.3 Update existing Conditions
                $new_conditions[] = self::cnb_update_condition( $cnb_cloud_notifications, $condition );
            }
        }

        // 3: Update the Action(s)
        $new_actions = array();
        foreach ( $actions as $action ) {
            if ( isset( $action['delete'] ) && $action['delete'] === 'true' ) {
                // 2.1 Delete now unused Action
                CnbAppRemote::cnb_remote_delete_action( $action );
            } else if ( $action['id'] === '' ) {
                // 2.2 Create new Action
                $new_actions[] = self::cnb_create_action( $cnb_cloud_notifications, $action );
            } else if ( $action['id'] !== '' && isset( $action['actionType'] ) ) {
                // 2.3 Update existing Action (but only if it is provided fully, which is why "actionType" is tested for presence
                $new_actions[] = self::cnb_update_action( $cnb_cloud_notifications, $action );
            } else {
                // 2.4 No update needed, so pass on the action as received
                $new_actions[] = $action;
            }
        }

        // 4: Update the Button
        self::cnb_update_button_actions_conditions( $cnb_cloud_notifications, $button, $new_actions, $new_conditions );

        return $cnb_cloud_notifications;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $button array Single Button object
     * @param $actions array Action objects
     * @param $conditions array Condition objects
     *
     * @return mixed|WP_Error
     */
    public static function cnb_update_button_actions_conditions( &$cnb_cloud_notifications, $button, $actions, $conditions ) {
        $result = CnbAppRemote::cnb_remote_update_wp_button( $button, $actions, $conditions );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'update', 'button', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'updated', 'button', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_update_button( &$cnb_cloud_notifications, $button ) {
        $result = CnbAppRemote::cnb_remote_update_button( $button );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'update', 'button', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'updated', 'button', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_update_action( &$cnb_cloud_notifications, $action ) {
        $result = CnbAppRemote::cnb_remote_update_action( $action );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'update', 'action', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'updated', 'action', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_update_condition( &$cnb_cloud_notifications, $condition ) {
        $result = CnbAppRemote::cnb_remote_update_condition( $condition );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'update', 'condition', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'updated', 'condition', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_update_domain( &$cnb_cloud_notifications, $domain ) {
        $result = CnbAppRemote::cnb_remote_update_domain( $domain );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'update', 'domain', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'updated', 'domain', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $button array Single Button object
     *
     * @return object|WP_Error The created Button
     */
    public static function cnb_create_button( &$cnb_cloud_notifications, $button ) {
        $result = CnbAppRemote::cnb_remote_create_button( $button );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'create', 'button', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'created', 'button', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $button_id string ID of the button to delete
     *
     * @return mixed|WP_Error
     */
    public static function cnb_delete_button( &$cnb_cloud_notifications, $button_id ) {
        $result = CnbAppRemote::cnb_remote_delete_button( array( 'id' => $button_id ) );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'delete', 'button', $result, 'with ID <code>' . esc_html( $button_id ) . '</code>' );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'deleted', 'button', $button_id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $domain_id string ID of the domain to delete
     *
     * @return mixed|WP_Error
     */
    public static function cnb_delete_domain( &$cnb_cloud_notifications, $domain_id ) {
        $result = CnbAppRemote::cnb_remote_delete_domain( array( 'id' => $domain_id ) );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'delete', 'domain', $result, 'with ID <code>' . esc_html( $domain_id ) . '</code>' );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'deleted', 'domain', $domain_id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $action_id string ID of the action to delete
     *
     * @return mixed|WP_Error
     */
    public static function cnb_delete_action( &$cnb_cloud_notifications, $action_id ) {
        $result = CnbAppRemote::cnb_remote_delete_action( array( 'id' => $action_id ) );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'delete', 'action', $result, 'with ID <code>' . esc_html( $action_id ) . '</code>' );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'deleted', 'action', $action_id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $condition_id string ID of the condition to delete
     *
     * @return mixed|WP_Error
     */
    public static function cnb_delete_condition( &$cnb_cloud_notifications, $condition_id ) {
        $result = CnbAppRemote::cnb_remote_delete_condition( array( 'id' => $condition_id ) );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'delete', 'condition', $result, 'with ID <code>' . esc_html( $condition_id ) . '</code>' );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'deleted', 'condition', $condition_id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    /**
     * @param $cnb_cloud_notifications
     * @param $apikey_id string ID of the Api Key to delete
     *
     * @return mixed|WP_Error
     */
    public static function cnb_delete_apikey( &$cnb_cloud_notifications, $apikey_id ) {
        $result = CnbAppRemote::cnb_remote_delete_apikey( array( 'id' => $apikey_id ) );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'delete', 'apikey', $result, 'with ID <code>' . esc_html( $apikey_id ) . '</code>' );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'deleted', 'apikey', $apikey_id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_create_domain( &$cnb_cloud_notifications, $domain ) {
        $result = CnbAppRemote::cnb_remote_create_domain( $domain );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'create', 'domain', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'created', 'domain', $result->name );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_create_action( &$cnb_cloud_notifications, $action ) {
        $result = CnbAppRemote::cnb_remote_create_action( $action );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'create', 'action', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else {
            $message = self::cnb_admin_get_success_message( 'created', 'action', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_create_condition( &$cnb_cloud_notifications, $condition ) {
        $result = CnbAppRemote::cnb_remote_create_condition( $condition );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'create', 'condition', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else if ( $result !== null ) {
            $message = self::cnb_admin_get_success_message( 'created', 'condition', $result->id );
            array_push( $cnb_cloud_notifications, $message );
        }

        return $result;
    }

    public static function cnb_create_apikey( &$cnb_cloud_notifications, $apikey ) {
        $result = CnbAppRemote::cnb_remote_create_apikey( $apikey );
        if ( $result instanceof WP_Error ) {
            $message = self::cnb_admin_get_error_message( 'create', 'apikey', $result );
            array_push( $cnb_cloud_notifications, $message );
        } else if ( $result !== null ) {
            $message = self::cnb_admin_get_success_message( 'created', 'apikey', $result->id );
            array_push( $cnb_cloud_notifications, $message );

            $key_msg = '<div class="notice-success notice"><p>' .
                       'Your API key is <strong><code>' . esc_html( $result->key ) . '</code></strong>. This will not be shown again!' .
                       '</p></div>';
            array_push( $cnb_cloud_notifications, $key_msg );
        }

        return $result;
    }

    /**
     * @param $verb string one of created, updated, deleted
     * @param $type string one of button, action, condition
     * @param $id string The identifier of the $type (could be an actual ID, a name, etc)
     *
     * @return string A Wordpress success notice with all details filled out
     */
    public static function cnb_admin_get_success_message( $verb, $type, $id ) {
        return '<div class="notice-success notice is-dismissible"><p>
                Your ' . $type . ' <strong>' . esc_html( $id ) . '</strong> has been ' . $verb . ' at <strong>' . CnbAppRemote::cnb_get_api_base() . '</strong>!
            </p></div>';
    }

    /**
     * @param $result WP_Error The WP_Error that was thrown
     *
     * @return string HTML code with additional information (Content has been escaped already)
     */
    public static function cnb_admin_get_error_message_details( $result ) {
        if (!($result instanceof WP_Error)) { return ''; }

        $error_codes = $result->get_error_codes();
        $codes = 'Technical details: <br />';
        foreach ($error_codes as $error_code) {
            if ( $result->get_error_message( $error_code ) === '' ) {
                $codes .= '<p>Error code: <code>' . esc_html( $error_code ) . '.</code></p>';
            } else {
                $codes .= '<p>Error code: <code>' . esc_html( $error_code ) . '</code>, message: <code>' . esc_html( $result->get_error_message( $error_code ) ) . '</code></p>';
            }
        }

        $additional_details = '';
        // Get detail message if possible
        $details = $result->get_error_data( $result->get_error_code() );
        if ( $details ) {
            $details_obj = json_decode( $details );
            if ( json_last_error() == JSON_ERROR_NONE ) {
                if ( $details_obj->message ) {
                    $additional_details .= '<p>Additional details: <strong>' . esc_html( $details_obj->message ) . '</strong></p>';
                }
            } else {
                $additional_details .= '<p>Additional details: <strong>' . esc_html( $details ) . '</strong></p>';
            }
        }

        return '<p>' . $codes . $additional_details . '</p>';

    }

    /**
     * @param $verb string one of created, updated, deleted
     * @param $type string one of button, action, condition
     * @param $result WP_Error The WP_Error that was thrown
     * @param $extra_info string Allows for some extra details to be added to the error message.
     *                          This contains HTML and should be escaped already when passed through.
     *
     * @return string A Wordpress error notice with all details filled out  (Content has been escaped already)
     */
    public static function cnb_admin_get_error_message( $verb, $type, $result, $extra_info = '' ) {
        $error_details = self::cnb_admin_get_error_message_details( $result );

        return '<div class="notice-error notice"><p>We could not ' . $verb . ' the ' . $type . ' ' . $extra_info . ' :-(.</p>
            ' . $error_details . '</div>';
    }

    /**
     *
     * Update the CallNowButton Cloud with a domain matching the Wordpress Domain
     *
     * @param $cnb_user
     *
     * @return array Array of Notifications
     */
    public static function cnb_wp_create_domain( $cnb_user ) {
        $cnb_cloud_notifications = array();

        if ( $cnb_user instanceof WP_Error ) {
            array_push( $cnb_cloud_notifications,
                '<div class="notice-error notice"><p>Cloud hosting is enabled, but needs to be configured.</p></div>' );

            return $cnb_cloud_notifications;
        }

        array_push( $cnb_cloud_notifications,
            '<div class="notice-success notice is-dismissible"><p>Cloud hosting is successfully connected.</p></div>' );

        $cnb_cloud_create_domain_check = CnbAppRemote::cnb_remote_get_wp_domain();
        if ( $cnb_cloud_create_domain_check instanceof WP_Error ) {
            self::cnb_remote_create_wp_domain( $cnb_cloud_notifications );
        }

        return $cnb_cloud_notifications;
    }

    /**
     *
     * This can be used to create the domain matching this Wordpress instance's main domain
     *
     * @param $cnb_cloud_notifications
     *
     * @return mixed|WP_Error
     */
    public static function cnb_remote_create_wp_domain( &$cnb_cloud_notifications ) {
        global $cnb_options;
        $domain = array(
            'name'               => CnbAppRemote::cnb_clean_site_url(),
            'timezone'           => wp_timezone_string(),
            'trackGA'            => isset($cnb_options['tracking'] ) && $cnb_options['tracking'] != 0,
            'trackConversion'    => isset($cnb_options['conversions'] ) && $cnb_options['conversions'] != 0,
            'properties'         => array(),
            'renew'              => false
        );

        $domain['properties']['zindex'] = zindex($cnb_options['z-index']);
        $domain['properties']['scale'] = $cnb_options['zoom'];

        return self::cnb_create_domain( $cnb_cloud_notifications, $domain );
    }

    /**
     * Update the CallNowButton Cloud with the current settings
     *
     * @return array Array of Notifications
     */
    public static function cnb_wp_migrate_button() {
        global $cnb_options;

        $cnb_cloud_notifications = array();

        $cnb_user = CnbAppRemote::cnb_remote_get_user_info();
        if ( $cnb_user instanceof WP_Error ) {
            array_push( $cnb_cloud_notifications,
                '<div class="notice-error notice"><p>Cloud hosting is enabled, but needs to be configured.</p></div>' );

            return $cnb_cloud_notifications;
        }

        // Initialize the cloud
        $domain = CnbAppRemote::cnb_remote_get_wp_domain();
        if ( $domain instanceof WP_Error ) {
            array_push( $cnb_cloud_notifications,
                '<div class="notice-error notice"><p>Cloud hosting is enabled, but there is no domain matching ' . CnbAppRemote::cnb_clean_site_url() . '</p></div>' );
        }

        // 1: Create action
        $action = self::cnb_wp_create_action( $cnb_cloud_notifications, $cnb_options );

        // 2: Create condition
        $condition = self::cnb_wp_create_condition( $cnb_cloud_notifications, $cnb_options );

        // 3: Create button
        $button = self::cnb_wp_create_button( $cnb_cloud_notifications, $domain, $action, $condition, $cnb_options );

        if ( ! ( $button instanceof WP_Error ) ) {
            $url              = admin_url( 'admin.php' );
            $button_edit_link =
                add_query_arg(
                    array(
                        'page'   => 'call-now-button',
                        'action' => 'edit',
                        'id'     => $button->id,
                    ),
                    $url );
            $button_edit_url  = esc_url( $button_edit_link );

            array_push( $cnb_cloud_notifications,
                '<div class="notice notice-success"><p><span class="dashicons dashicons-cloud-saved"></span>
            Congratulations, you have successfully migrated your Button to the cloud version!
            Click <a href="' . $button_edit_url . '">here</a> to edit your button.</p></div>' );
        }

        return $cnb_cloud_notifications;
    }

    public static function cnb_wp_create_action( &$cnb_cloud_notifications, $options ) {
        $action = array(
            'actionType'      => 'PHONE',
            'actionValue'     => $options['number'],
            'labelText'       => $options['text'],
            'backgroundColor' => $options['color'],
            'iconcolor'       => $options['iconcolor'],
            'iconEnabled'     => isset( $options['hideIcon'] ) && $options['hideIcon'] == 1 ? false : true,
            'schedule'        => array(
                'showAlways' => true
            )
        );

        return self::cnb_create_action( $cnb_cloud_notifications, $action );
    }

    public static function cnb_wp_create_condition( &$cnb_cloud_notifications, $options ) {
        // frontpage (if == 1, condition: don't show on /)
        if ( ! isset( $options['frontpage'] ) || $options['frontpage'] != 1 ) {
            return null;
        }

        $condition = array(
            'conditionType' => 'url',
            'filterType'    => 'EXCLUDE',
            'matchType'     => 'EXACT',
            'matchValue'    => get_home_url(),
        );

        return self::cnb_create_condition( $cnb_cloud_notifications, $condition );
    }

    /**
     *
     * @param $cnb_cloud_notifications
     * @param $domain
     * @param $action
     * @param $condition
     * @param $options
     *
     * @return mixed|WP_Error
     */
    public static function cnb_wp_create_button( &$cnb_cloud_notifications, $domain, $action, $condition, $options ) {
        $appearance = 'default';
        $type       = 'single';

        switch ( $options['appearance'] ) {
            case 'right':
                $appearance = 'BOTTOM_RIGHT';
                break;
            case 'left':
                $appearance = 'BOTTOM_LEFT';
                break;
            case 'middle':
                $appearance = 'BOTTOM_CENTER';
                break;
            case 'mright':
                $appearance = 'MIDDLE_RIGHT';
                break;
            case 'mleft':
                $appearance = 'MIDDLE_LEFT';
                break;
            case 'tright':
                $appearance = 'TOP_RIGHT';
                break;
            case 'tleft':
                $appearance = 'TOP_LEFT';
                break;
            case 'tmiddle':
                $appearance = 'TOP_CENTER';
                break;

            // The 2 "full" options
            case 'full':
                $appearance = 'BOTTOM_CENTER';
                $type       = 'full';
                break;
            case 'tfull':
                $appearance = 'TOP_CENTER';
                $type       = 'full';
                break;
        }

        $iconBackgroundColor = null;
        $iconColor           = null;

        $conditions = array();
        if ( $condition != null && isset( $condition->id ) ) {
            $condition_array = json_decode( json_encode( $condition ), true );
            array_push( $conditions, $condition_array );
        }

        $actions = array();
        if ( $action != null && isset( $action->id ) ) {
            $action_array = json_decode( json_encode( $action ), true );
            array_push( $actions, $action_array );

            $iconBackgroundColor = $action->backgroundColor;
            $iconColor           = $action->iconColor;
        }

        $button = array(
            'name'       => 'Button created via Wordpress plugin',
            'domain'     => $domain->id,
            'active'     => true,
            'actions'    => $actions,
            'conditions' => $conditions,
            'type'       => $type,
            'options'    => array(
                'placement'           => $appearance,
                'iconBackgroundColor' => $iconBackgroundColor,
                'iconColor'           => $iconColor
            )
        );

        return self::cnb_create_button( $cnb_cloud_notifications, $button );
    }

    /**
     * NOTE: Currently only be called via button-overview, for a specific listing use case
     *
     * @param array $button The button array as created by the button-overview table class
     * @param int $max (optional) The maximum amount of Actions to retrieve
     *
     * @return array Array of Action objects, between 0 and $max items
     */
    public static function cnb_wp_get_actions_for_button( $button, $max = 3 ) {
        $count = 0;
        if ( $button['actions'] ) {
            $count = count( $button['actions'] );
        }
        $actionCount = min( $count, $max );
        $result      = array();
        if ( ! $button || $max <= 0 ) {
            return $result;
        }

        for ( $i = 0; $i < $actionCount; $i ++ ) {
            $result[] = $button['actions'][ $i ];
        }

        return $result;
}}