<?php


class ScapePanel {

	function init() {
		add_action( 'admin_menu', array($this, 'add_menu') );
	}


	function add_menu() {
		add_menu_page( esc_html__('Theme Dashboard', 'scape'), esc_html__('Scape Theme', 'scape'), 'manage_options', 'scape-dashboard', array($this, 'render'), 'none', 2 );
		add_submenu_page( 'scape-dashboard', esc_html__('Theme  Dashboard', 'scape'), esc_html__('Theme Dashboard', 'scape'), 'manage_options', 'scape-dashboard', array($this, 'render'));
	}


	function render() {
	    if ( current_user_can( 'manage_options' ) ) {
		    echo '<div class="wrap"><h2>' . esc_html__('Scape Dashboard', 'scape') . '</h2></div>';
		    echo '<div class="wrap"><div class="wtbx-dashboard clearfix">';

		    wp_localize_script( 'scape-dashboard', 'scape_dashboard_params', array(
			    'ajaxurl'   => admin_url('admin-ajax.php'),
			    'wpnonce'   => wp_create_nonce('scape_dashboard'),
		    ) );


		    $this->render_info();
		    $this->render_verification();

		    if ( current_user_can( 'switch_themes' ) ) {
			    $this->render_requirements();
		    }

		    echo '</div></div>';
        }
	}


	function render_info() {
	    if ( WtbxVerification::is_theme_activated() ) { ?>
		<div class="wtbx-dash-widget wtbx-dash-widget-wide">
			<div class="wtbx-dash-header">
				<div class="wtbx-dash-title"><?php esc_html_e('Useful links and information', 'scape') ?></div>
			</div>
            <div class="wtbx-dash-tiles">
                <div class="wtbx-dash-tile">
                    <a href="http://docs.whiteboxstud.io/scape/#home" target="_blank" class="wtbx-dash-tile-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
                        <path d="M23.293,2.844c-0.132-0.094-0.3-0.12-0.451-0.068l-9,3c-0.006,0.002-0.01,0.007-0.016,0.009    C13.79,5.799,13.761,5.82,13.73,5.84c-0.024,0.016-0.05,0.028-0.07,0.047c-0.024,0.023-0.041,0.051-0.06,0.078    c-0.018,0.025-0.038,0.047-0.051,0.075c-0.013,0.028-0.017,0.06-0.025,0.09c-0.008,0.033-0.018,0.064-0.02,0.098    c0,0.007-0.004,0.013-0.004,0.02c0,0.276-0.224,0.5-0.5,0.5h-0.386c0.774-1.924,5.757-3.755,9-4.513    c0.269-0.063,0.436-0.332,0.373-0.601s-0.334-0.436-0.601-0.373C20.518,1.467,13.868,3.102,12,5.822    c-1.868-2.72-8.517-4.356-9.386-4.558C2.346,1.198,2.076,1.367,2.013,1.636s0.104,0.538,0.373,0.601    c3.244,0.758,8.226,2.589,9,4.513H11c-0.276,0-0.5-0.224-0.5-0.5c0-0.006-0.003-0.011-0.004-0.017    c-0.001-0.04-0.013-0.077-0.023-0.115c-0.007-0.025-0.01-0.051-0.021-0.075c-0.015-0.033-0.038-0.06-0.06-0.089    c-0.017-0.022-0.03-0.047-0.051-0.066c-0.023-0.022-0.051-0.036-0.078-0.053c-0.029-0.018-0.056-0.038-0.088-0.051    c-0.006-0.002-0.01-0.007-0.017-0.009l-9-3C1.005,2.723,0.839,2.75,0.708,2.844S0.5,3.089,0.5,3.25v15    c0,0.215,0.138,0.406,0.342,0.474l8.712,2.904c0.169,0.643,0.75,1.122,1.446,1.122h2c0.695,0,1.277-0.478,1.446-1.122l8.713-2.904    c0.204-0.068,0.342-0.259,0.342-0.474v-15C23.5,3.089,23.423,2.938,23.293,2.844z M9.5,20.557L1.5,17.891V3.944L9.5,6.61V20.557z     M13.5,21.25c0,0.276-0.224,0.5-0.5,0.5h-2c-0.276,0-0.5-0.224-0.5-0.5V7.665C10.656,7.72,10.825,7.75,11,7.75h2    c0.175,0,0.344-0.03,0.5-0.085V21.25z M22.5,17.891l-8,2.667V6.611l8-2.666V17.891z"></path>
                    </svg>
                        <div class="wtbx-dash-tile-title"><?php esc_html_e('Theme Documentation', 'scape'); ?></div>
                    </a>
                </div>
                <div class="wtbx-dash-tile">
                    <a href="http://docs.whiteboxstud.io/scape/#home" target="_blank" class="wtbx-dash-tile-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
                        <path d="M21.5,0.5h-19C1.121,0.5,0,1.622,0,3v18c0,1.378,1.121,2.5,2.5,2.5h19c1.379,0,2.5-1.122,2.5-2.5V3   C24,1.622,22.879,0.5,21.5,0.5z M2.5,1.5h19C22.327,1.5,23,2.173,23,3v1.5H1V3C1,2.173,1.673,1.5,2.5,1.5z M21.5,22.5h-19   C1.673,22.5,1,21.827,1,21V5.5h22V21C23,21.827,22.327,22.5,21.5,22.5z"></path>
                            <circle cx="2.5" cy="3" r="0.5"></circle>
                            <circle cx="4.5" cy="3" r="0.5"></circle>
                            <circle cx="6.5" cy="3" r="0.5"></circle>
                            <path d="M16.748,13.566l-7-4C9.594,9.477,9.403,9.478,9.249,9.567C9.095,9.657,9,9.822,9,10v8c0,0.179,0.095,0.343,0.249,0.433   C9.326,18.478,9.413,18.5,9.5,18.5c0.086,0,0.171-0.022,0.248-0.066l7-4C16.904,14.345,17,14.179,17,14   S16.904,13.655,16.748,13.566z M10,17.138v-6.276L15.492,14L10,17.138z"></path>
                    </svg>
                        <div class="wtbx-dash-tile-title"><?php esc_html_e('Video Academy', 'scape'); ?></div>
                    </a>
                </div>
                <div class="wtbx-dash-tile">
                    <a href="//wordpress.org/support/" target="_blank" class="wtbx-dash-tile-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 30 30" style="enable-background:new 0 0 30 30;" xml:space="preserve">
                        <path d="M14.5,9c-0.8,0-3-0.1-4.2-0.5C10.1,8.4,9.9,8.1,10,7.8c0.1-0.3,0.4-0.4,0.6-0.3C11.6,7.8,13.5,8,14.5,8    c0.9,0,2.4-0.1,3.3-0.5c0.3-0.1,0.5,0.1,0.6,0.3c0.1,0.3-0.1,0.5-0.3,0.6C17.1,8.8,15.5,9,14.5,9z"></path>
                            <path d="M19.5,28.5c-0.2,0-0.4-0.1-0.5-0.3L12,8.7c-0.1-0.3,0-0.5,0.3-0.6c0.3-0.1,0.5,0,0.6,0.3l7,19.5c0.1,0.3,0,0.5-0.3,0.6    C19.6,28.5,19.6,28.5,19.5,28.5z"></path>
                            <path d="M21.5,24c-0.2,0-0.4-0.1-0.5-0.3l-5-15c-0.1-0.3,0.1-0.5,0.3-0.6c0.3-0.1,0.5,0.1,0.6,0.3l5,15c0.1,0.3-0.1,0.5-0.3,0.6    C21.6,24,21.6,24,21.5,24z"></path>
                            <path d="M4.5,9C3.1,9,2.2,8.5,2.1,8.4C1.9,8.3,1.8,8,1.9,7.7c0.1-0.2,0.4-0.3,0.7-0.2c0,0,0.8,0.4,1.9,0.4c0.9,0,2.4-0.1,3.3-0.5    c0.3-0.1,0.5,0.1,0.6,0.3c0.1,0.3-0.1,0.5-0.3,0.6C7.1,8.8,5.5,9,4.5,9z"></path>
                            <path d="M9.5,28.5c-0.2,0-0.4-0.1-0.5-0.3L2,8.7C1.9,8.4,2.1,8.1,2.3,8c0.3-0.1,0.5,0,0.6,0.3l7,19.5c0.1,0.3,0,0.5-0.3,0.6    C9.6,28.5,9.6,28.5,9.5,28.5z"></path>
                            <path d="M11.5,25c-0.2,0-0.4-0.1-0.5-0.4l-5-16C5.9,8.4,6.1,8.1,6.4,8C6.6,7.9,6.9,8.1,7,8.4l5,16c0.1,0.3-0.1,0.5-0.3,0.6    C11.6,25,11.5,25,11.5,25z"></path>
                            <path d="M20,29c-0.1,0-0.1,0-0.2,0c-0.3-0.1-0.4-0.4-0.3-0.6c1.9-5.9,3.2-8.6,4.3-10.8c0.5-1,0.9-1.9,1.3-2.9    c0.3-1.5-1.1-3.1-2.3-4.6C21.8,8.9,21,7.9,21,7c0-2.7,1.7-3,2.5-3c1.4,0,2.4,0.7,3.1,1.9c1,1.9,0.9,4.5-0.1,7.8    c-0.1,0.5-0.3,0.9-0.4,1.3c0,0.1,0,0.1-0.1,0.2c0,0.1-0.1,0.1-0.1,0.2c-0.4,0.9-0.7,1.7-1.2,2.6c-1,2.2-2.3,4.9-4.2,10.7    C20.4,28.9,20.2,29,20,29z M23.5,5C22.9,5,22,5.2,22,7c0,0.6,0.8,1.5,1.6,2.4c0.8,1,1.7,2,2.2,3.2c0.7-2.6,0.7-4.8-0.1-6.3    C25.2,5.4,24.5,5,23.5,5z"></path>
                            <path d="M10.5,28.5c-0.1,0-0.1,0-0.2,0c-0.3-0.1-0.4-0.4-0.3-0.6l4.5-12.5c0.1-0.3,0.4-0.4,0.6-0.3c0.3,0.1,0.4,0.4,0.3,0.6    L11,28.2C10.9,28.4,10.7,28.5,10.5,28.5z"></path>
                            <path d="M15,30C6.7,30,0,23.3,0,15S6.7,0,15,0s15,6.7,15,15S23.3,30,15,30z M15,1C7.3,1,1,7.3,1,15s6.3,14,14,14s14-6.3,14-14    S22.7,1,15,1z"></path>
                    </svg>
                        <div class="wtbx-dash-tile-title"><?php esc_html_e('How To Use WordPress', 'scape'); ?></div>
                    </a>
                </div>
                <div class="wtbx-dash-tile">
                    <a href="//whitebox.ticksy.com/" target="_blank" class="wtbx-dash-tile-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
                        <path d="M12.604,23H9.158c-0.525,0-0.971-0.387-1.035-0.899l-0.377-2.629c-0.511-0.231-1.006-0.519-1.478-0.858l-2.479,0.996    c-0.504,0.183-1.053-0.021-1.297-0.466l-2.194-3.795C0.043,14.879,0.153,14.317,0.554,14l2.103-1.644    c-0.033-0.317-0.048-0.594-0.048-0.857s0.016-0.54,0.048-0.857L0.556,9.001c-0.41-0.324-0.519-0.905-0.254-1.353l2.197-3.801    C2.743,3.4,3.298,3.2,3.785,3.389L6.27,4.387c0.493-0.35,0.979-0.633,1.475-0.859l0.378-2.638C8.187,0.386,8.632,0,9.158,0h4.4    c0.526,0,0.972,0.387,1.035,0.9l0.377,2.628c0.511,0.231,1.006,0.519,1.478,0.858l2.479-0.996    c0.504-0.181,1.054,0.021,1.296,0.467l2.194,3.794c0.255,0.469,0.145,1.031-0.256,1.347l-2.102,1.644    c0.026,0.252,0.048,0.546,0.048,0.857c0,0.018-0.005,0.099-0.007,0.117c-0.015,0.138-0.088,0.292-0.2,0.375    c-0.112,0.083-0.257,0.143-0.391,0.119c-1.087-0.198-2.046-0.128-3.018,0.162c-0.156,0.044-0.324,0.014-0.452-0.087    c-0.127-0.101-0.198-0.257-0.19-0.419c0.003-0.054,0.01-0.107,0.017-0.16c0.009-2.57-2.014-4.593-4.501-4.593    s-4.51,2.023-4.51,4.511c0,2.487,2.023,4.51,4.51,4.51c0.136-0.017,0.189-0.024,0.243-0.027c0.162-0.005,0.319,0.063,0.419,0.19    s0.133,0.296,0.087,0.452c-0.18,0.607-0.271,1.23-0.271,1.852c0,1.333,0.404,2.618,1.17,3.714    c0.106,0.153,0.119,0.352,0.033,0.517C12.961,22.896,12.79,23,12.604,23z M6.342,17.545c0.108,0,0.216,0.035,0.305,0.104    c0.549,0.422,1.135,0.763,1.744,1.012c0.164,0.067,0.28,0.216,0.306,0.392l0.418,2.915l2.595,0.024    c-0.567-1.073-0.864-2.265-0.864-3.492c0-0.495,0.05-0.99,0.149-1.479c-2.865-0.192-5.137-2.584-5.137-5.498    c0-3.039,2.472-5.511,5.51-5.511c2.913,0,5.305,2.272,5.498,5.137c0.732-0.148,1.464-0.19,2.228-0.109    c-0.014-0.2-0.036-0.388-0.057-0.556c-0.022-0.174,0.05-0.348,0.188-0.456l2.321-1.815l-2.192-3.865L16.56,5.419    c-0.164,0.066-0.352,0.041-0.491-0.067c-0.549-0.423-1.136-0.763-1.744-1.012c-0.164-0.067-0.28-0.216-0.306-0.392l-0.418-2.915    L9.158,1L8.696,3.948C8.67,4.123,8.554,4.272,8.39,4.34C7.804,4.58,7.232,4.912,6.642,5.355C6.502,5.46,6.318,5.484,6.155,5.419    l-2.739-1.1L1.165,8.153l2.328,1.875c0.138,0.108,0.21,0.282,0.188,0.456c-0.05,0.398-0.073,0.721-0.073,1.016    s0.023,0.618,0.073,1.016c0.022,0.174-0.05,0.348-0.188,0.456l-2.321,1.815l2.193,3.866l2.791-1.072    C6.216,17.556,6.279,17.545,6.342,17.545z"></path>
                            <path d="M18.343,24c-3.033,0-5.5-2.467-5.5-5.5s2.467-5.5,5.5-5.5s5.5,2.467,5.5,5.5S21.375,24,18.343,24z M18.343,14        c-2.481,0-4.5,2.019-4.5,4.5s2.019,4.5,4.5,4.5s4.5-2.019,4.5-4.5S20.824,14,18.343,14z"></path>
                            <path d="M18.344,22c-0.13,0-0.26-0.05-0.35-0.15c-0.1-0.09-0.15-0.22-0.15-0.35c0-0.13,0.05-0.26,0.15-0.35       c0.18-0.19,0.51-0.19,0.7,0c0.09,0.09,0.15,0.22,0.15,0.35c0,0.13-0.06,0.26-0.15,0.35C18.604,21.949,18.474,22,18.344,22z"></path>
                            <path d="M18.343,20L18.343,20c-0.277,0-0.5-0.225-0.5-0.5l0.001-1c0-0.237,0.167-0.441,0.399-0.489l0.109-0.021       c1.017-0.188,1.491-0.502,1.491-0.99c0-0.542-0.688-1-1.501-1c-0.783,0-1.457,0.424-1.5,0.946       c-0.023,0.275-0.266,0.487-0.54,0.456c-0.275-0.023-0.479-0.265-0.456-0.54C15.933,15.801,17.007,15,18.341,15       c1.379,0,2.501,0.897,2.501,2c0,0.955-0.672,1.596-1.999,1.908l-0.001,0.593C18.842,19.777,18.619,20,18.343,20z"></path>
                    </svg>
                        <div class="wtbx-dash-tile-title"><?php esc_html_e('Help And Support', 'scape'); ?></div>
                    </a>
                </div>
                <div class="wtbx-dash-tile">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=' . (is_child_theme() ? 'ScapeChild' : 'Scape') . '&tab=75')) ?>" class="wtbx-dash-tile-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 30 30" viewBox="0 0 30 30">
                            <path d="m10 22.5h10c.276 0 .5-.224.5-.5v-2c0-.276-.224-.5-.5-.5s-.5.224-.5.5v1.5h-9v-1.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5v2c0 .276.224.5.5.5zm4.646-2.146c.047.047.102.082.16.106.001 0 .002.002.003.002h.001c.061.025.126.038.19.038s.129-.013.189-.037c.06-.025.116-.061.164-.109l2-2c.195-.195.195-.512 0-.707s-.512-.195-.707 0l-1.146 1.146v-5.793c0-.276-.224-.5-.5-.5s-.5.224-.5.5v5.794l-1.147-1.147c-.195-.195-.512-.195-.707 0s-.195.512 0 .707zm-10.646-16.854c-.276 0-.5.224-.5.5s.224.5.5.5.5-.224.5-.5-.223-.5-.5-.5zm6 0c-.276 0-.5.224-.5.5s.224.5.5.5.5-.224.5-.5-.223-.5-.5-.5zm16.565-2h-23.13c-1.62 0-2.935 1.335-2.935 2.976v21.048c0 1.641 1.317 2.976 2.935 2.976h23.131c1.619 0 2.935-1.335 2.935-2.976v-21.048c-.001-1.641-1.318-2.976-2.936-2.976zm1.936 24.024c0 1.09-.869 1.976-1.935 1.976h-23.131c-1.067 0-1.935-.886-1.935-1.976v-19.024h27.001zm0-20.024h-27.001v-1.024c0-1.09.87-1.976 1.935-1.976h23.131c1.067 0 1.935.886 1.935 1.976zm-21.501-2c-.276 0-.5.224-.5.5s.224.5.5.5.5-.224.5-.5-.223-.5-.5-.5z"/>
                        </svg>
                        <div class="wtbx-dash-tile-title"><?php esc_html_e('Demo Import', 'scape'); ?></div>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
		</div>
        <?php }
	}


	function render_requirements() {
		$dir = wp_upload_dir();
		$dir_writable = wp_is_writable($dir['basedir'].'/');

		$memory_limit_min = '512M';
		$memory_limit = ini_get('memory_limit');
		$memory_limit_byte = wp_convert_hr_to_bytes($memory_limit);
		$memory_limit_byte_enough = $memory_limit_byte >= 536870912;

		$upload_max_filesize_min = '128M';
		$upload_max_filesize = ini_get('upload_max_filesize');
		$upload_max_filesize_byte = wp_convert_hr_to_bytes($upload_max_filesize);
		$upload_max_filesize_byte_enough = $upload_max_filesize_byte >= 134217728;

		$post_max_size_min = '128M';
		$post_max_size = ini_get('post_max_size');
		$post_max_size_byte = wp_convert_hr_to_bytes($post_max_size);
		$post_max_size_byte_enough = ($post_max_size_byte >= 134217728);

		$max_input_vars_min = 2000;
		$max_input_vars = ini_get('max_input_vars');
		$max_input_vars_enough = $max_input_vars >= $max_input_vars_min;

		$max_execution_time_min = 120;
		$max_execution_time = ini_get('max_execution_time');
		$max_execution_time_enough = $max_execution_time >= $max_execution_time_min;

		$requirements = array(
			array(
				'id' => 'writable',
			    'label' => esc_html__('Uploads folder writable', 'scape'),
			    'status' => $dir_writable,
			    'current' => ''
			),
			array(
				'id' => 'memory_limit',
				'label' => esc_html__('Memory limit', 'scape'),
				'status' => $memory_limit_byte_enough,
				'current' => esc_html__('Currently: ', 'scape') . $memory_limit . ' / '. $memory_limit_min
			),
			array(
				'id' => 'upload_max_filesize',
				'label' => esc_html__('Upload max. filesize', 'scape'),
				'status' => $upload_max_filesize_byte_enough,
				'current' => esc_html__('Currently: ', 'scape') . $upload_max_filesize . ' / '. $upload_max_filesize_min
			),
			array(
				'id' => 'post_max_size',
				'label' => esc_html__('Max. post size', 'scape'),
				'status' => $post_max_size_byte_enough,
				'current' => esc_html__('Currently: ', 'scape') . $post_max_size . ' / '. $post_max_size_min
			),
			array(
				'id' => 'max_input_vars',
				'label' => esc_html__('Max. input vars', 'scape'),
				'status' => $max_input_vars_enough,
				'current' => esc_html__('Currently: ', 'scape') . $max_input_vars . ' / '. $max_input_vars_min
			),
			array(
				'id' => 'max_execution_time',
				'label' => esc_html__('Max. execution time', 'scape'),
				'status' => $max_execution_time_enough,
				'current' => esc_html__('Currently: ', 'scape') . $max_execution_time . ' / '. $max_execution_time_min
			)
		);

		?>
		<div class="wtbx-dash-widget last">
			<div class="wtbx-dash-header">
				<div class="wtbx-dash-title"><?php esc_html_e('System Requirements', 'scape') ?></div>
			</div>
			<div class="wtbx-dash-content">
                <div class="wtbx-dash-column">
                    <div class="wtbx-dash-space"></div>
                    <?php foreach ( $requirements as $requirement => $opts ) { ?>
                        <div class="wtbx-dash-row">
                            <div class="wtbx-dash-cell wtbx-label">
                                <?php echo esc_html($opts['label']); ?>
                            </div>
                            <div class="wtbx-dash-cell wtbx-status">
                                <i class="dashicons <?php if ( $opts['status']) {echo 'dashicons-yes';} else {echo 'dashicons-no-alt';} ?>"></i>
                            </div>
                            <div class="wtbx-dash-cell wtbx-current">
                                <?php echo esc_html($opts['current']); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="wtbx-dash-space"></div>
                    <div class="wtbx-dash-space"></div>
                </div>
            </div>
		</div>
		<?php
	}


	function render_verification() {
		?>
		<div class="wtbx-dash-widget">
			<div class="wtbx-dash-header">
				<div class="wtbx-dash-title"><?php esc_html_e('Theme Activation', 'scape') ?></div>
			</div>
			<div class="wtbx-dash-content">
				<?php

				$code = $token = '';
				if ( get_option('scape_theme_id') ) {
					$item_id = get_option('scape_theme_id');
					$token = get_option('envato_purchase_token_' . $item_id);
					$code = get_option('envato_purchase_code_' . $item_id);

					if ( empty($token) && get_option('envato_market') ) {
						$envato_market = get_option('envato_market');
						if ( isset($envato_market['token']) && !empty($envato_market['token']) ) {
							$token = $envato_market['token'];
						}
					}
				}

				$validated = !empty($code);

				$nonce = wp_create_nonce('scape_validation');

				if ( $validated ) { ?>

                    <div class="wtbx-dash-activated">
                        <div class="wtbx-validation-wrapper">
                            <div class="wtbx-dash-column">
                                <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Token', 'scape') ?></div>
                                <div><?php echo sprintf(esc_html__('Please insert your Envato Token. %sMore info%s.', 'scape'), '<a target="_blank" href="http://docs.whiteboxstud.io/scape/#2-activation">', '</a>') ?></div>
                                <input type="text" name="wtbx-validation-token" class="wtbx-validation-input" value="<?php echo esc_attr($token); ?>" readonly="readonly" />
                            </div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-column">
                                <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Purchase Code', 'scape') ?></div>
                                <div><?php echo sprintf(esc_html__('Please insert your Envato Purchase Code. %sMore info%s.', 'scape'), '<a target="_blank" href="http://docs.whiteboxstud.io/scape/#2-activation">', '</a>') ?></div>
                                <input type="text" name="wtbx-validation-code" class="wtbx-validation-input" value="<?php echo esc_attr($code); ?>" readonly="readonly" />
                            </div>
                            <div class="wtbx-dash-message" style=>
                                <i class="dashicons dashicons-yes"></i>
                                <span><?php esc_html_e('Your theme license copy is activated', 'scape') ?></span>
                            </div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-column">
                                <div id="wtbx-activate-purchase-code" class="wtbx-activation-button"><?php esc_html_e('Activate Code', 'scape') ?></div>
                                <div id="wtbx-deactivate-purchase-code" class="wtbx-activation-button"><?php esc_html_e('Deactivate Code', 'scape') ?></div>
                            </div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-column">
                                <p class="wtbx-dash-activation-adv"><?php esc_html_e('Theme Purchase Code activation will give you access to theme demo content, templates and other premium features.', 'scape') ?></p>
                                <p class="wtbx-dash-hint wtbx-dash-activation-inact"><?php esc_html_e('You can only register one license per website.', 'scape') ?></p>
                                <p class="wtbx-dash-hint wtbx-dash-activation-hint"><?php esc_html_e('You can only register one license per website. If the Purchase Code is registered elsewhere, please deactivate it on that website first.', 'scape') ?></p>
                            </div>
                        </div>
                        <div class="wtbx-dash-space"></div>
                    </div>

				<?php } else { ?>

					<div class="wtbx-dash-not-activated">
						<div class="wtbx-validation-wrapper">
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-column">
                                <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Token', 'scape') ?></div>
                                <div class="wtbx-dash-hint"><?php echo sprintf(esc_html__('Please insert your Envato Token. %sMore info%s.', 'scape'), '<a target="_blank" href="http://docs.whiteboxstud.io/scape/#2-activation">', '</a>') ?></div>
                                <input type="text" name="wtbx-validation-token" class="wtbx-validation-input" value="<?php echo esc_attr($token); ?>" />
                            </div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-column">
                                <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Purchase Code', 'scape') ?></div>
                                <div class="wtbx-dash-hint"><?php echo sprintf(esc_html__('Please insert your Envato Purchase Code. %sMore info%s.', 'scape'), '<a target="_blank" href="http://docs.whiteboxstud.io/scape/#2-activation">', '</a>') ?></div>
                                <input type="text" name="wtbx-validation-code" class="wtbx-validation-input" value="" />
                            </div>
                            <div class="wtbx-dash-message">
                                <i class="dashicons"></i>
                                <span></span>
                            </div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-space"></div>
                            <div class="wtbx-dash-column">
                                <div id="wtbx-activate-purchase-code" class="wtbx-activation-button"><?php esc_html_e('Activate Code', 'scape') ?></div>
                                <div id="wtbx-deactivate-purchase-code" class="wtbx-activation-button"><?php esc_html_e('Deactivate Code', 'scape') ?></div>
                            </div>
                        </div>
						<div class="wtbx-dash-space"></div>
                        <div class="wtbx-dash-space"></div>
                        <div class="wtbx-dash-column">
                            <p class="wtbx-dash-activation-adv"><?php esc_html_e('Theme Purchase Code activation will give you access to theme demo content, templates and other premium features.', 'scape') ?></p>
                            <p class="wtbx-dash-hint wtbx-dash-activation-inact"><?php esc_html_e('You can only register one license per website.', 'scape') ?></p>
                            <p class="wtbx-dash-hint wtbx-dash-activation-hint"><?php esc_html_e('You can only register one license per website. If the purchase code is registered elsewhere, please deactivate it on that website first.', 'scape') ?></p>
                        </div>
                        <div class="wtbx-dash-space"></div>
                    </div>

				<?php } ?>
			</div>
		</div>
		<?php
	}


}

$scape_panel = new ScapePanel();
$scape_panel->init();