<?php

class WtbxVerification {

	public $verify_url;

	public function __construct() {
		$this->verify_url = 'http://whiteboxstud.io/envato/api';

		add_action('wp_ajax_scape_activate_purchase_code', array($this, 'activate_code'));
		add_action('wp_ajax_scape_deactivate_purchase_code', array($this, 'deactivate_code'));
	}


	public static function is_theme_activated() {
		$code = '';
		if ( get_option('scape_theme_id') ) {
			$item_id = get_option('scape_theme_id');
			$code = get_option('envato_purchase_code_' . $item_id);
		}
		return !empty($code);
	}


	public function activate_code() {
		check_ajax_referer( 'scape_dashboard', 'nonce' );

		global $wp_version;
		$data = $_POST['data'];

		$time = ceil(time()/60)*60;
		$hash = hash('sha256', 'wtbx'. $time);

		if ( !empty($data['token']) && !empty($data['code']) ) {
			$response = wp_remote_post($this->verify_url.'/activate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.home_url('/'),
				'body' => array(
					'action' => 'activate',
					'theme' => 'scape',
					'token' => urlencode($data['token']),
					'code' => urlencode($data['code']),
					'url' => home_url('/'),
				    'hash' => $hash
				)
			));

			$response_code = wp_remote_retrieve_response_code( $response );
			$response_body = wp_remote_retrieve_body( $response );
			$response_body = json_decode($response_body, true);

			$status = $response_body['status'];

			if ( $response_code != 200 || $status !== 'success' ) {
				if ( $response_body['status'] === 'exist' ) {
					$item_id = $response_body['item_id'];

					update_option('scape_theme_id', '');
					update_option('envato_purchase_token_' . $item_id, '');
					update_option('envato_purchase_code_' . $item_id, '');
				}
				$this->response($response_body);
			}

			if ( isset($response_body['item_id']) ) {
				$item_id = $response_body['item_id'];

				update_option('scape_theme_id', $item_id);
				update_option('envato_purchase_token_' . $item_id, $data['token']);
				update_option('envato_purchase_code_' . $item_id, $data['code']);

				$this->response($response_body);
			} else {
				$response_body['message'] = esc_html__('The Purchase Code is invalid', 'scape');
				$this->response($response_body);
			}

		} else {
			$response = array(
				'status' => 'fail',
			    'message' => esc_html__('Token or Purchase Code missing...', 'scape')
			);

			$this->response($response);
		}
	}


	public function deactivate_code() {
		check_ajax_referer( 'scape_dashboard', 'nonce' );

		global $wp_version;
		$data = $_POST['data'];

		$time = ceil(time()/60)*60;
		$hash = hash('sha256', 'wtbx'. $time);

		if ( !empty($data['token']) && !empty($data['code']) ) {
			$response = wp_remote_post($this->verify_url.'/activate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.home_url('/'),
				'body' => array(
					'action' => 'deactivate',
					'theme' => 'scape',
					'token' => urlencode($data['token']),
					'code' => urlencode($data['code']),
					'hash' => $hash
				)
			));

			$response_code = wp_remote_retrieve_response_code( $response );
			$response_body = wp_remote_retrieve_body( $response );
			$response_body = json_decode($response_body, true);

			$status = $response_body['status'];

			if ( $response_code != 200 || $status !== 'success' ) {
				if ( isset($response_body['message']) ) {
					$this->response($response_body);
				}
				wp_die();
			}

			if ( $status === 'success' ) {
				$item_id = get_option('scape_theme_id');

				update_option('scape_theme_id', '');
				update_option('envato_purchase_token_' . $item_id, '');
				update_option('envato_purchase_code_' . $item_id, '');

				$this->response($response_body);

			} else {
				$response_body['message'] = esc_html__('The Purchase Code could not be deactivated', 'scape');
				$this->response($response_body);
			}


		} else {
			$response = array(
				'status' => 'fail',
				'message' => esc_html__('Token or Purchase Code missing...', 'scape')
			);

			$this->response($response);
		}
	}


	public function response($response) {
		echo json_encode($response);
		wp_die();
	}

}


$wtbx_verification = new WtbxVerification();