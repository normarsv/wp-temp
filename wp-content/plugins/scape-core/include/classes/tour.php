<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

require_once WTBX_PLUGIN_PATH . 'include/classes/tabs.php';

define( 'SCAPE_SLIDE_TITLE', __( 'Slide', 'js_composer' ) );

class WPBakeryShortCode_VC_Custom_Tour extends WPBakeryShortCode_VC_Custom_Tabs {
	protected $predefined_atts = array(
		'tab_id' => SCAPE_SLIDE_TITLE,
		'title' => '',
	);

	protected function getFileName() {
		return 'vc_custom_tour';
	}

	public function getTabTemplate() {
		return '<div class="wpb_template">' . do_shortcode( '[vc_custom_tab title="' . SLIDE_TITLE . '" tab_id=""][/vc_custom_tab]' ) . '</div>';
	}
}