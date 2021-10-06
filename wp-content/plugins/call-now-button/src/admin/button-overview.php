<?php

require_once dirname( __FILE__ ) . '/api/CnbAppRemote.php';
require_once dirname( __FILE__ ) . '/api/CnbAdminCloud.php';
require_once dirname( __FILE__ ) . '/partials/admin-functions.php';
require_once dirname( __FILE__ ) . '/partials/admin-header.php';
require_once dirname( __FILE__ ) . '/partials/admin-footer.php';
require_once dirname( __FILE__ ) . '/../utils/utils.php';
require_once dirname( __FILE__ ) . '/button-edit.php';

function cnb_add_header_button_overview() {
    echo 'Buttons ';
}

function cnb_add_new_modal_action() {
    $url = admin_url('admin.php');
    $new_link =
        add_query_arg(
            array(
                'TB_inline' => 'true',
                'inlineId' => 'cnb-add-new-modal',
                'height' => '440', // 405 is ideal -> To hide the scrollbar
                'page' => 'call-now-button',
                'action' => 'new',
                'type' => 'single',
                'id' => 'new' ),
            $url );
    printf(
        '<a href="%s" title="%s" class="thickbox open-plugin-details-modal page-title-action" data-title="%s">%s</a>',
        $new_link,
        __('Create new button', CNB_NAME),
        __('Choose a Button type', CNB_NAME),
        __('Add New', CNB_NAME)
    );
}

if(!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Cnb_Button_List_Table extends WP_List_Table {

    private $data;
    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
     */
    function __construct() {
        parent::__construct(array(
            'singular' => 'cnb_list_button', //Singular label
            'plural' => 'cnb_list_buttons', //plural label, also this well be one of the table css class
            'ajax' => false //We won't support Ajax for this table
        ));
    }

    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    function get_columns() {
        return array(
            'cb' => '<input type="checkbox">',
            'id' => __('ID'),
            'name' => __('Name'),
            'type' => __('Type'),
            'actions' => __('Actions'),
            'status' => __('Status')
        );
    }

    function get_sortable_columns() {
        return array(
            'name' => array('name', false),
            'type' => array('type', false),
            'title' => array('title', false),
            'status' => array('status', false),
            );
    }

    function get_hidden_columns() {
        return array('id');
    }

    function get_views() {
        // Let's count
        $data = $this->get_data();

        // In case of error (CNB not setup yet), return an empty view
        if ($data instanceof WP_Error) return array();
        $all_count = count($data);
        $all_count_str = '<span class="count">('.$all_count.')</span>';
        $active_count = count(array_filter($data, function($el) { return $el['status'] === true; }));
        $active_count_str = '<span class="count">('.$active_count.')</span>';

        // Let's build a link
        $url = admin_url('admin.php');

        // Which one is current?
        $current_view_is_active = isset( $_REQUEST['view'] ) && $_REQUEST['view'] === 'active';
        $all_link =
            add_query_arg(
                array( 'page' => 'call-now-button'),
                $url );
        $all_url = esc_url( $all_link );

        $active_link =
            add_query_arg(
                array( 'page' => 'call-now-button', 'view' => 'active'),
                $url );
        $active_url = esc_url( $active_link );

        return array(
            'all'       => __("<a href='" . $all_url    . "' " . (!$current_view_is_active ? "class='current'" : '') . ">All ".$all_count_str."</a>", CNB_NAME),
            'active'    => __("<a href='" . $active_url . "' " . ($current_view_is_active ? "class='current'" : '')  . "'>Active ".$active_count_str."</a>", CNB_NAME)
        );
    }
    function prepare_items() {
        // Process any Bulk actions before gathering data
        $this->process_bulk_action();

        /* -- Preparing your query -- */
        $data = $this->get_data();

        if ($data instanceof WP_Error) {
            return $data;
        }

        /* -- Filtering parameters -- */
        $current_view_is_active = isset( $_REQUEST['view'] ) && $_REQUEST['view'] === 'active';
        if ($current_view_is_active) {
            $data = array_filter($data, function($el) { return $el['status'] === true; });
        }

        /* -- Ordering parameters -- */
        //Parameters that are going to be used to order the result
        usort( $data, array( &$this, 'sort_data' ) );

        /* -- Pagination parameters -- */
        //Number of elements in your table?
        $totalitems = count($data); //return the total number of affected rows
        $per_page = 20; //How many to display per page?
        //Which page is this?
        $current_page = !empty($_GET['paged']) ? (int)sanitize_text_field($_GET['paged']) : 1;

        //Page Number
        if (empty($current_page) || !is_numeric($current_page) || $current_page <= 0) {
            $current_page = 1;
        }

        //How many pages do we have in total?
        $totalpages = ceil($totalitems / $per_page); //adjust the query to take pagination into account
        if (!empty($current_page) && !empty($per_page)) {
            $offset = ($current_page - 1) * $per_page;

            /* -- Register the pagination -- */
            $this->set_pagination_args(array(
                'total_items' => $totalitems,
                'total_pages' => $totalpages,
                'per_page' => $per_page,
            ));
            //The pagination links are automatically built according to those parameters

            /* -- Register the Columns -- */
            $columns = $this->get_columns();
            $hidden_columns = $this->get_hidden_columns();
            $sortable_columns = $this->get_sortable_columns();
            $this->_column_headers = array($columns, $hidden_columns, $sortable_columns, 'name');

            /* -- Register the items -- */
            $data = array_slice($data,$offset,$per_page);
            $this->items = $data;
        }
        return null;
    }

    function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
                return '<code>' . esc_html($item[ $column_name ]) . '</code>';
            case 'name':
            case 'type':
                switch ($item[ $column_name ]) {
                    case 'SINGLE':
                    case 'FULL':
                    case 'MULTI':
                        $button_types = cnb_get_button_types();
                        return $button_types[$item[ $column_name ]];
                    default:
                        return esc_html($item[$column_name]);
                }
            case 'actions':
                // Moved to column_actions
            case 'status':
                return $item[ $column_name ] ? 'Active' : 'Inactive';

            default:
                return '<em>Unknown column ' .esc_html($column_name) . '</em>';
        }
    }

    function column_actions( $item ) {
        global $cnb_options;

        $items = '';
        $domain = '';
        $actionMsg = '';
        $count = 0;

        // Action info
        if ($item['actions']) {
            $count = count( $item['actions'] );
        }

        if ($count === 0) {
            $items .= '<em>No action yet</em>';
        }

        // Action detail
        $actions = CnbAdminCloud::cnb_wp_get_actions_for_button( $item );
        foreach ($actions as $action) {
            $actionValue = !empty($action->actionValue) ? esc_html($action->actionValue) : '<em>No value</em>';
            $actionTypes = cnb_get_action_types();
            $actionType = $actionTypes[$action->actionType];
            $actionMsg .= "$actionType ($actionValue)<br />";
        }
        $diff = $count - count($actions);
        if ($diff > 0) {
            $actionMsg .= "<em>Plus $diff more...</em><br />";
        }

        // Domain info
        if ($cnb_options['advanced_view'] === 1) {
            $domain = '<br />Domain: <code>' . esc_html($item['domain']->name) . '</code>';
        }

        return "$items$actionMsg$domain";
    }

    private function get_data() {
        if ($this->data != null) return $this->data;
        $buttons = CnbAppRemote::cnb_remote_get_buttons_full();

        if ($buttons instanceof WP_Error) {
            return $buttons;
        }

        $data = array();
        foreach ($buttons as $button) {
            $data[] = array(
                'id' => $button->id,
                'name' => $button->name,
                'type' => $button->type,
                'actions' => $button->actions,
                'status' => $button->active,
                'domain' => $button->domain
            );
        }
        $this->data = $data;
        return $data;
    }
    

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b ) {
        // If orderby is set, use this as the sort column
        $orderby = !empty($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'name';
        // If order is set use this as the order
        $order = !empty($_GET['order']) ? sanitize_text_field($_GET['order']) : 'asc';

        $result = strcmp( $a[$orderby], $b[$orderby] );

        // Flip Enabled/Disabled, since we actually consider "Enabled" to be before "Disabled"
        if ($orderby === 'status') {
            $result = -$result;
        }

        if($order === 'asc') {
            return $result;
        }
        return -$result;
    }

    /**
     * Custom action for `cb` columns (checkboxes)
     *
     * @param array|object $item
     * @return string|void
     */
    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['id']
        );
    }

    function column_name($item) {
        // Let's build a link
        $url = admin_url('admin.php');
        $edit_link =
            add_query_arg(
                array( 'page' => 'call-now-button', 'action' => 'edit', 'type' => strtolower($item['type']), 'id' => $item['id'] ),
                $url );
        $edit_url = esc_url( $edit_link );

        $actions = array(
            'edit' => '<a href="'.$edit_url.'">Edit</a>',
        );
        $enable_disable_link = wp_nonce_url(
            add_query_arg(
                array(
                    'page' => 'call-now-button',
                    'action' => $item['status'] == true ? 'cnb_disable_button' : 'cnb_enable_button',
                    'id' => $item['id'] ),
                $url ),
            'cnb_enable_disable_button' );
        $enable_disable_url = esc_url( $enable_disable_link );

        if ($item['status'] == true) {
            $actions['disable'] = '<a href="'.$enable_disable_url.'">Disable</a>';
        } else {
            $actions['enable'] = '<a href="'.$enable_disable_url.'">Enable</a>';
        }
        $delete_link = wp_nonce_url(
            add_query_arg( array(
                'page' => 'call-now-button',
                'action' => 'cnb_delete_button',
                'id' => $item['id'] ),
                $url ),
            'cnb_delete_button' );
        $delete_url = esc_url( $delete_link );
        $actions['delete'] = '<a href="'.$delete_url.'">Delete</a>';

        return sprintf(
            '%1$s %2$s',
            '<a href="'.$edit_url.'">'.esc_html($item['name']) . '</a>',
            $this->row_actions($actions)
        );
    }

    function get_bulk_actions() {
        return array(
            'enable'    => 'Enable',
            'disable'    => 'Disable',
            'delete'    => 'Delete',
        );
    }

    function process_bulk_action() {
        if ( isset( $_REQUEST['_wpnonce'] ) && ! empty( $_REQUEST['_wpnonce'] ) ) {
            $nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
            $action = 'bulk-' . $this->_args['plural'];

            if (wp_verify_nonce($nonce, $action)) {
                $buttonIds = filter_input(INPUT_POST, 'cnb_list_button', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
                switch ($this->current_action()) {
                    case 'enable':
                    case 'disable':
                        foreach ($buttonIds as $buttonId) {
                            $button = array('id' => $buttonId, 'active' => $this->current_action() === 'enable');
                            CnbAppRemote::cnb_remote_update_button( $button );
                        }
                        echo '<div class="notice-success notice"><p>' . count($buttonIds) . ' Buttons updated</p></div>';
                        break;
                    case 'delete':
                        foreach ($buttonIds as $buttonId) {
                            $button = array('id' => $buttonId);
                            CnbAppRemote::cnb_remote_delete_button( $button );
                        }
                        echo '<div class="notice-success notice"><p>' . count($buttonIds) . ' Button(s) deleted</p></div>';
                        break;
                }
            }
        }
    }
}

/**
 * Main entrypoint, used by `call-now-button.php`.
 */
function cnb_admin_button_overview_render() {
    $id = !empty($_GET['id']) ? sanitize_text_field($_GET['id']) : null;
    $action = !empty($_GET['action']) ? sanitize_text_field($_GET['action']) : null;

    if ($id === null) {
        cnb_admin_page_overview_render_list();
    } else {
        switch ($action) {
            case 'new':
            case 'edit':
                require_once dirname( __FILE__ ) . "/button-edit.php";
                cnb_admin_page_edit_render();
                break;
            case 'cnb_enable_button':
            case 'cnb_disable_button':
            if ( isset( $_REQUEST['_wpnonce'] ) && ! empty( $_REQUEST['_wpnonce'] ) ) {
                $nonce  = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );

                if ( wp_verify_nonce( $nonce, 'cnb_enable_disable_button' ) ) {
                    $buttonId = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
                    $button = array( 'id' => $buttonId, 'active' => $action === 'cnb_enable_button' );
                    CnbAppRemote::cnb_remote_update_button( $button );
                    echo '<div class="notice-success notice is-dismissible"><p>Button <code>' . esc_html($buttonId) . '</code> updated</p></div>';
                } else {
                    echo '<div class="notice-error notice"><p>Something went wrong</p></div>';
                }
            }
            cnb_admin_page_overview_render_list();
            break;
            case 'cnb_delete_button':
                if ( isset( $_REQUEST['_wpnonce'] ) && ! empty( $_REQUEST['_wpnonce'] ) ) {
                    $nonce  = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );

                    if ( wp_verify_nonce( $nonce, $action ) ) {
                        $cnb_cloud_notifications = array();
                        CnbAdminCloud::cnb_delete_button( $cnb_cloud_notifications, $id );
                        foreach ($cnb_cloud_notifications as $cnb_cloud_notification) {
                            echo $cnb_cloud_notification;
                        }
                    }
                }
                cnb_admin_page_overview_render_list();
                break;
        }
    }
}

function cnb_admin_page_overview_render_list() {
    global $cnb_options, $cnb_settings;

    $cnb_notices = cnb_get_notices();
    $cnb_changelog = cnb_get_changelog();

    //Prepare Table of elements
    $wp_list_table = new Cnb_Button_List_Table();
    $data = $wp_list_table->prepare_items();

    if ($data instanceof WP_Error) {
        $cnb_notices[] = cnb_admin_header_get_cloud_error($data);
    } else {
        add_action('cnb_header', 'cnb_add_header_button_overview');
        add_action('cnb_after_header', 'cnb_add_new_modal_action');
    }

    $cnb_cloud_domain = CnbAppRemote::cnb_remote_get_wp_domain();
    if (!($cnb_cloud_domain instanceof WP_Error)) {
        $url = admin_url('admin.php');
        $upgrade_link =
            add_query_arg(array(
                'page' => 'call-now-button-domains',
                'action' => 'upgrade',
                'id' => $cnb_cloud_domain->id
            ),
                $url);
        $upgrade_url = esc_url($upgrade_link);
    }
    echo '<div class="wrap">';
    cnb_admin_header($cnb_options, $cnb_settings, $cnb_notices, $cnb_changelog);

    echo '<div id="poststuff">

    <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content" style="position: relative;">';

    // Check if we should warn about inactive buttons
    $views = $wp_list_table->get_views();
    $active_views = isset($views['active']) ? $views['active'] : '';
    if (false !== strpos($active_views, '(0)')) {
        echo '<div class="notice-warning notice"><p><strong>You have no active buttons.</strong> Create or enable one (or more) buttons to use the Call Now Button.</p></div>';
    }
    $wp_list_table->views();

    echo '<form id="wp_list_event" method="post">';

    //Table of elements
    $wp_list_table->display();
    echo '</form></div>' ?>

    <?php if (isset($upgrade_url)) { ?>
    <div id="postbox-container-1" class="postbox-container"> <!-- Sidebar promo boxes -->
        <?php if (!($cnb_cloud_domain instanceof WP_Error) && $cnb_cloud_domain->type === 'FREE') { ?>
        <!-- Sidebar messages -->
        <div id="cnb_upgrade_box" class="postbox ">  <!-- Upgrade promobox -->
            <div class="postbox-header">
                <h2 class="hndle">Need more power?</h2>
            </div>
            <div class="inside">
                <div class="submitbox" id="submitpost">
                    <div id="minor-publishing">
                        <div id="misc-publishing-actions">
                            <div class="cnb_promobox_item">Upgrade to add the following functionality:</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">Unlimited buttons</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">Email, Maps, URL, WhatsApp</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">Button bar with multiple actions</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">Expandable multi button</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">Advanced page selection per button</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">Button scheduling</div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox">And much more!</div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div id="major-publishing-actions">
                        <div id="publishing-action">
                            <a class="button button-primary button-large" href="<?php echo $upgrade_url ?>">Upgrade</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
        <div id="cnb_support_box" class="postbox "> <!-- support promobox -->
            <div class="postbox-header">
                <h2 class="hndle">Need help?</h2>
            </div>
            <div class="inside">
                <div class="submitbox" id="submitpost">
                    <div id="minor-publishing">
                        <div id="misc-publishing-actions">
                            <div class="cnb_promobox_item">
                                Please head over to our <a href="https://help.callnowbutton.com/" target="_blank">Help Center</a> for all your questions.
                            </div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox"><a href="https://help.callnowbutton.com/" target="_blank">Help Center</a></div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox"><a href="https://help.callnowbutton.com/" target="_blank">Support forum</a></div>
                            <div class="cnb_promobox_item cnb-side-icon cnb-side-checkbox"><a href="https://help.callnowbutton.com/" target="_blank">FAQ</a></div>
                        </div>
                        <div class="clear"></div>
                    </div>                    
                </div>
            </div>
        </div>
    </div><!-- end #postbox-container-1 -->
    <?php } ?>
    
    
        
    
    <br class="clear">
<?php
    echo '</div><!--End #poststuff -->';
    cnb_admin_footer();
    echo '</div>';
    cnb_admin_page_render_thickbox($cnb_cloud_domain);
}

function cnb_admin_page_render_thickbox($default_domain = null) {
    add_thickbox();
    echo '<div id="cnb-add-new-modal" style="display:none;"><div>';

    if (!$default_domain) {
        // Get the various supported domains
        $default_domain = CnbAppRemote::cnb_remote_get_wp_domain();
    }

    $button_id = 'new';

    // Create a dummy button
    $button = new stdClass();
    $button->id = '';
    $button->active = false;
    $button->name = '';
    $button->type = 'SINGLE';
    $button->domain = $default_domain;
    $button->actions = array();

    // Set some sane defaults
    if (!isset($button->options)) $button->options = new stdClass();
    $button->options->iconBackgroundColor = !empty($button->options->iconBackgroundColor)
        ? $button->options->iconBackgroundColor
        : '#009900';
    $button->options->iconColor = !empty($button->options->iconColor)
        ? $button->options->iconColor
        : '#FFFFFF';
    $button->options->placement = !empty($button->options->placement)
        ? $button->options->placement
        : ($button->type === 'FULL' ? 'BOTTOM_CENTER' : 'BOTTOM_RIGHT');
    $button->options->scale = !empty($button->options->scale)
        ? $button->options->scale
        : '1';

    $options = array('modal_view' => true, 'submit_button_text' => 'Next');
    cnb_button_edit_form($button_id, $button, $default_domain, $options);
    echo '</div></div>';
}
