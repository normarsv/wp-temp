<?php

if ( ! function_exists( 'wtbx_contactmethods' ) ) {
	function wtbx_contactmethods() {
		$array = wtbx_vc_social_networks();
		$contactmethods = array();
		foreach ($array as $key => $value) {
			$contactmethods[$key] = $value[0];
		}
		return $contactmethods;
	}
}

// Filter Contact Methods
if ( ! function_exists( 'wtbx_filter_contactmethods' ) ) {
	function wtbx_filter_contactmethods( $contactmethods ) {
		$contacts = wtbx_contactmethods();

		$contactmethods['author_info'] = esc_html__('Job/position', 'core-extension');

		foreach($contacts as $k=>$v) {
			$contactmethods[$k] = $v;
		}

		// Remove Contact Methods
		unset($contactmethods['aim']);
		unset($contactmethods['yim']);
		unset($contactmethods['jabber']);

		return $contactmethods;
	}
}
add_filter('user_contactmethods','wtbx_filter_contactmethods', 10, 1);