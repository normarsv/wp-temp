<?php

function wtbx_privacy_consent_shortcode($atts, $content = null) {
	$output = $id = $notice = $include = '';

	extract( shortcode_atts( array(
		'id'        => '',
		'include'   => 'no',
	    'notice'    => ''
	), $atts) );

	if ( $include === 'no' ) {
		if ( $id !== '' && !wtbx_vc_has_consent($id) ) {
			if ( $notice === 'yes' ) {
				$output .= '<span class="wtbx-noconsent-inline">';
				$output .= '[' . wtbx_noconsent_text() . ']';
				$output .= '</span>';
			}
		} else {
			$output = $content;
		}
	} elseif ( $include === 'yes' ) {
		if ( $id !== '' && !wtbx_vc_has_consent($id) ) {
			$output = $content;
		} else {
			if ( $notice === 'yes' ) {
				$output .= '<span class="wtbx-noconsent-inline">';
				$output .= '[' . wtbx_noconsent_text() . ']';
				$output .= '</span>';
			}
		}
	}

	return $output;
}

add_shortcode( 'scape_privacy_consent', 'wtbx_privacy_consent_shortcode' );