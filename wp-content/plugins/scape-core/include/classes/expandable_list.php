<?php

class WPBakeryShortCode_VC_Expandable_List extends WPBakeryShortCode {
	protected $controls_css_settings = 'out-tc vc_controls-content-widget';
	protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );

	public function getColumnControls( $controls = 'full', $extended_css = '' ) {
		// we don't need containers bottom-controls for tabs
		if ( 'bottom-controls' === $extended_css ) {
			return '';
		}
		$column_controls = $this->getColumnControlsModular();

		return $output = $column_controls;
	}

	public function outputTitle($title) {
		return '';
	}
}

VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );

class WPBakeryShortCode_VC_Expandable_List_Item extends WPBakeryShortCode {
	protected $controls_css_settings = 'tc vc_control-container';
	protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
	protected $backened_editor_prepend_controls = false;
	public function outputTitle($title) {
		return '';
	}
}