<?php

require_once(dirname(__FILE__) . '/widget.php');

class WTBX_Login_Widget extends WTBX_WP_Widget {

	protected $widget_base_id = 'wtbx_login';
	protected $widget_name = 'Scape Login';

	protected $options;

	function __construct() {
		$this->widget_args = array(
			'description' => esc_html__('Displays login form.', 'core-extension')
		);

		$this->options = array(
//			array(
//				'description', 'text', '',
//				'label' => esc_html__('Description', 'core-extension'),
//				'input'=>'textarea',
//				'on_update'=>'esc_attr',
//			),
		);

		parent::__construct();
	}

	function widget($args, $instance) {
		extract( $args );
		$this->setInstances($instance, 'filter');

//		$title = $this->getInstance('title');
//		$description = $this->getInstance('description');

		$login_form_args = array(
			'label_log_in' => esc_html__('Login on site', 'core-extension'),
			'label_lost_password' => esc_html__('Lost password', 'core-extension'),
		);
		/*
		*/
		echo $before_widget;

//		if ( ! empty( $title ) ) {
//			echo $before_title . $title . $after_title;
//		}

		if ( ! empty( $description ) ) {
			echo '<p>' . $description . '</p>';
		}

		if (is_user_logged_in()) {
			echo '<div class="logout-wrapper">';
			$this->logout_form();
			echo '</div>';
		} else {
			echo '<div class="login-wrapper">';
			$this->wp_login_form($login_form_args);
			echo '</div>';
		}

		echo $after_widget;
	}

	function lost_password( $args ) {

		return '<p class="login-lost-password"><label>&nbsp;&nbsp;'
		. '<a href="' . wp_lostpassword_url() . '">'.esc_html__('I lost my password', 'core-extension').'</a>'
		. '</label></p>';
	}

	function wp_login_form( $args = array() ) {
		$defaults = array(
			'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
			'form_id' => uniqid('loginform_'),
			'label_username' => esc_html__( 'Username', 'core-extension' ),
			'placeholder_username' => esc_html__( 'Login', 'core-extension' ),
			'label_password' => esc_html__( 'Password', 'core-extension' ),
			'placeholder_password' => esc_html__( 'Password', 'core-extension' ),
			'label_remember' => esc_html__( 'Remember Me', 'core-extension' ),
			'label_lost_password' => esc_html__( 'Remind the password', 'core-extension' ),
			'label_log_in' => esc_html__( 'Log In', 'core-extension' ),
			'id_username' => uniqid('user_login_'),
			'id_password' => uniqid('user_pass_'),
			'id_remember' => uniqid('rememberme_'),
			'id_lost_password' => uniqid('rememberme_'),
			'id_submit' => uniqid('wp-submit_'),
			'remember' => true,
			'lost_password' => true,
			'value_username' => '',
			'value_remember' => false, // Set this to true to default the "Remember me" checkbox to checked
		);
		$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

		$registration_link = '';

		if (get_option('users_can_register')) {
			$registration_link = '
				<a href="'.wp_registration_url() .'" class="wtbx-button wtbx-button-secondary button-md button-fw">'. esc_html__('Register', 'core-extension') .'</a>
			';
		}

		$form = '
			<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" class="wtbx_login_form clearfix" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
				' . apply_filters( 'login_form_top', '', $args ) . '
				<p class="login-username">
					<label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>
					<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" value="' . esc_attr( $args['value_username'] ) . '" size="20" placeholder="' . esc_html( $args['placeholder_username'] ) . '" />
				</p>
				<p class="login-password">
					<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
					<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" value="" size="20" placeholder="' . esc_html( $args['placeholder_password'] ) . '" />
				</p>'
				. '<p class="login-registration">
					'. $registration_link .'
				</p>
				<p class="login-submit">
					<button type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="button wtbx-button wtbx-button-primary button-md button-fw">' .esc_attr( $args['label_log_in'] ). '</button>
					<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
				</p><div class="wtbx_login_opts clearfix">
				'. ( $args['remember'] ? '<p class="login-remember"><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /><label for="' . esc_attr( $args['id_remember'] ) . '"> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' )
			. '<p class="login-lost-password"><label>'
				. '<a href="' . wp_lostpassword_url() . '">' . $args['label_lost_password'] . '</a></label></p></div>'
			.apply_filters( 'login_form_bottom', '', $args ) . '
			</form>';

		echo $form;
	}

	function logout_form() {
		echo '<p class="login-logout"><a class="wtbx-button wtbx-button-primary button-lg button-fw" href="'.wp_logout_url().'"><i class="scape-ui-log-out"></i>'.esc_html__('Logout','core-extension').'</a></p>';
	}

}
