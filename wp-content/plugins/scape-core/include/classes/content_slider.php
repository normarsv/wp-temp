<?php

/**
 */
class WPBakeryShortCode_VC_Content_Slider extends WPBakeryShortCode {
	static $filter_added = false;
	protected $controls_css_settings = 'out-tc vc_controls-content-widget';
	protected $controls_list = array( 'edit', 'clone', 'delete' );

	public function __construct( $settings ) {
		parent::__construct( $settings );
		// WPBakeryVisualComposer::getInstance()->addShortCode( array( 'base' => 'vc_tab' ) );
//		if ( ! self::$filter_added ) {
//			$this->addFilter( 'vc_inline_template_content', 'setCustomTabId' );
//			self::$filter_added = true;
//		}
	}

	public function contentAdmin( $atts, $content = null ) {
		$width = $custom_markup = '';
		$shortcode_attributes = array( 'width' => '1/1' );
		foreach ( $this->settings['params'] as $param ) {
			if ( $param['param_name'] != 'content' ) {
				//$shortcode_attributes[$param['param_name']] = $param['value'];
				if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
					$shortcode_attributes[ $param['param_name'] ] = __( $param['value'], "js_composer" );
				} elseif ( isset( $param['value'] ) ) {
					$shortcode_attributes[ $param['param_name'] ] = $param['value'];
				}
			} else if ( $param['param_name'] == 'content' && $content == null ) {
				//$content = $param['value'];
				$content = __( $param['value'], "js_composer" );
			}
		}
		extract( shortcode_atts(
			$shortcode_attributes
			, $atts ) );

		// Extract tab titles

		preg_match_all( '/vc_content_slide title="([^\"]+)"(\sslide_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
		/*
$tab_titles = array();
if ( isset($matches[1]) ) { $tab_titles = $matches[1]; }
*/
		$output = '';
		$tab_titles = array();

		if ( isset( $matches[0] ) ) {
			$tab_titles = $matches[0];
		}
		$tmp = '';
		if ( count( $tab_titles ) ) {
			$tmp .= '<ul class="clearfix tabs_controls">';
			foreach ( $tab_titles as $tab ) {
				preg_match( '/title="([^\"]+)"(\sslide_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
				if ( isset( $tab_matches[1][0] ) ) {
					$tmp .= '<li><a href="#tab-' . ( isset( $tab_matches[3][0] ) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) . '">' . $tab_matches[1][0] . '</a></li>';

				}
			}
			$tmp .= '</ul>' . "\n";
		} else {
			$output .= do_shortcode( $content );
		}


		/*
if ( count($tab_titles) ) {
	$tmp .= '<ul class="clearfix">';
	foreach ( $tab_titles as $tab ) {
		$tmp .= '<li><a href="#tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
	}
	$tmp .= '</ul>';
} else {
	$output .= do_shortcode( $content );
}
*/
		$elem = $this->getElementHolder( $width );

		$iner = '';
		foreach ( $this->settings['params'] as $param => $values ) {
			$custom_markup = '';
			$param_value = isset( ${$param['param_name']} ) ? ${$param['param_name']} : '';
			if ( is_array( $param_value ) ) {
				// Get first element from the array
				reset( $param_value );
				$first_key = key( $param_value );
				$param_value = $param_value[ $first_key ];
			}
			$iner .= $this->singleParamHtmlHolder( $param, $param_value );
		}
		//$elem = str_ireplace('%wpb_element_content%', $iner, $elem);

		if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
			if ( $content != '' ) {
				$custom_markup = str_ireplace( "%content%", $tmp . $content, $this->settings["custom_markup"] );
			} else if ( $content == '' && isset( $this->settings["default_content_in_template"] ) && $this->settings["default_content_in_template"] != '' ) {
				$custom_markup = str_ireplace( "%content%", $this->settings["default_content_in_template"], $this->settings["custom_markup"] );
			} else {
				$custom_markup = str_ireplace( "%content%", '', $this->settings["custom_markup"] );
			}
			//$output .= do_shortcode($this->settings["custom_markup"]);
			$iner .= do_shortcode( $custom_markup );
		}
		$elem = str_ireplace( '%wpb_element_content%', $iner, $elem );
		$output = $elem;

		return $output;
	}

	public function getTabTemplate() {
		return '<div class="wpb_template">' . do_shortcode( '[vc_content_slide title="Slide" slide_id=""][/vc_content_slide]' ) . '</div>';
	}

	public function setCustomTabId( $content ) {
		return preg_replace( '/slide_id\=\"([^\"]+)\"/', 'slide_id="$1-' . time() . '"', $content );
	}
}

define( 'CONT_SLIDE_TITLE', __( 'Slide', 'core-extension' ) );
require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-column.php' );

class WPBakeryShortCode_VC_Content_Slide extends WPBakeryShortCode_VC_Column {
	protected $controls_css_settings = 'tc vc_control-container';
	protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
	protected $predefined_atts = array(
		'slide_id' => '',
		'title' => ''
	);
	protected $controls_template_file = 'editors/partials/backend_controls_tab.tpl.php';

	public function __construct( $settings ) {
		parent::__construct( $settings );
	}

	public function customAdminBlockParams() {
		return ' id="tab-' . $this->atts['slide_id'] . '"';
	}

	public function mainHtmlBlockParams( $width, $i ) {
		return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] . ' wpb_sortable wpb_content_holder"' . $this->customAdminBlockParams();
	}

	public function containerHtmlBlockParams( $width, $i ) {
		return 'class="wpb_column_container vc_container_for_children"';
	}

	public function getColumnControls( $controls, $extended_css = '' ) {
		return $this->getColumnControlsModular( $extended_css );
		/*
		$controls_start = '<div class="vc_controls controls controls_column' . ( ! empty( $extended_css ) ? " {$extended_css}" : '' ) . '">';
		$controls_end = '</div>';

		if ( $extended_css == 'bottom-controls' ) $control_title = sprintf( __( 'Append to this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) );
		else $control_title = sprintf( __( 'Prepend to this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) );

		$controls_add = ' <a class="vc_control column_add" href="#" title="' . $control_title . '"><i class="vc_icon"></i></a>';
		$controls_edit = ' <a class="vc_control column_edit" href="#" title="' . sprintf( __( 'Edit this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc_icon"></i></a>';
		$controls_clone = '<a class="vc_control column_clone" href="#" title="' . sprintf( __( 'Clone this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc_icon"></i></a>';

		$controls_delete = '<a class="vc_control column_delete" href="#" title="' . sprintf( __( 'Delete this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc_icon"></i></a>';
		return $controls_start . $controls_add . $controls_edit . $controls_clone . $controls_delete . $controls_end;
		*/
	}
}

/**
 * @param $settings
 * @param $value
 *
 * @deprecated due to without prefix
 * @return string
 */
function slide_id_settings_field( $settings, $value ) {
	return vc_slide_id_settings_field( $settings, $value );
}

/**
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string
 */
function vc_slide_id_settings_field( $settings, $value ) {
	return '<div class="my_param_block">'
	. '<input name="' . $settings['param_name']
	. '" class="wpb_vc_param_value wpb-textinput '
	. $settings['param_name'] . ' ' . $settings['type'] . '_field" type="hidden" value="'
	. $value . '" />'
	. '<label>' . $value . '</label>'
	. '</div>';
	// TODO: Add data-js-function to documentation
}

vc_add_shortcode_param( 'tab_id', 'vc_slide_id_settings_field' );