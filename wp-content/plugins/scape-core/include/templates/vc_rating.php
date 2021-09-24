<?php
$output = $link = $el_class = $unique_class = $style = $reason = $stars = $accent_color = $author_name =
$author_occupation = $author_company = $accent_color_bg = $accent_color_border = $rating_style = $skin = $scheme = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-rating' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_rating';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_skin_' . $skin;
$shortcode_class[]  = 'wtbx_scheme_' . $scheme;


// element style
$accent_color_text = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
$accent_color_border = wtbx_vc_color_styles_border($accent_color);


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// credentials
$credentials = '';
$credentials .= '<div class="wtbx_rating_credentials">';

if ( $rating > 0 ) {

	if ( $rating_style === 'default' ) {
		$rating = str_replace('.', '_', $rating);
		$stars .= '<div class="wtbx_rating_stars wtbx_stars_'.$rating.'">';
		$stars .= '<div class="wtbx_rating_stars_e">';
		for ($i = 0; $i < 5; $i++) {
			$stars .= '<i class="scape-ui-empty-star wtbx_rating_star" aria-hidden="true"></i>';
		}
		$stars .= '</div>';
		$stars .= '<div class="wtbx_rating_stars_fcont">';
		$stars .= '<div class="wtbx_rating_stars_f">';
		for ($i = 0; $i < 5; $i++) {
			$stars .= '<i class="scape-ui-filled-star wtbx_rating_star" aria-hidden="true"></i>';
		}
		$stars .= '</div>';
		$stars .= '</div>';
		$stars .= '</div>';
	} else {
		$stars .= '<div class="wtbx_rating_stars_compact">';
		$stars .= '<div class="wtbx_rating_number">'.$rating.'</div>';
		$stars .= '<i class="scape-ui-filled-star wtbx_rating_icon" aria-hidden="true"></i>';
		$stars .= '</div>';
	}


}

if ( $referee === 'person' ) {
	$style === 'style_1' ? $credentials .= $stars : null;
	if ( $author_name !=='' || $author_occupation !== '' || $author_company !== '' ) {
		$credentials .= '<div class="wtbx_rating_details">';
		$credentials .= $author_name !== '' ? '<div class="wtbx_rating_author_name wtbx-text">'.$author_name.'</div>' : '';
		$credentials .= $author_occupation !== '' ? '<div class="wtbx_rating_author_occupation wtbx-text">'.$author_occupation.'</div>' : '';
		$credentials .= $author_company !== '' ? '<div class="wtbx_rating_author_company wtbx-text">'.$author_company.'</div>' : '';
		$credentials .= '</div>';
	}
} elseif ( $referee === 'company' && $logo !== '' ) {
	$credentials .= $logo !== '' ? '<div class="wtbx_rating_logo">' . wtbx_image_smart_img($logo, 'full', 'full', wtbx_get_alt_text($logo), '', true) . '</div>' : '';
}

$credentials .= '</div>';

$reason = $reason !== '' ? '<div class="wtbx_rating_reason wtbx-text">' . esc_html($reason) . '</div>' : '';

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';
$accent_color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_rating_stars .wtbx_rating_star {' . $accent_color_text .  '}' : null;
$accent_color_bg !== '' ? $js_styles .= $unique_class_css.' .wtbx_rating_stars_compact {' . $accent_color_bg .  '}' : null;
$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

if ( $style === 'style_3' ) {
	$output .= $reason;
	$output .= $stars;
}
if ( $style === 'style_2' ) {
	$output .= $reason;
	$output .= $stars;
}

if ( $style === 'style_1' ) {
	$output .= $reason;
}

$output .= '<div class="wtbx_rating_content wtbx-text">' . wpb_js_remove_wpautop($content) . '</div>';
//if ( $style === 'style_1' || $style === 'style_2' ) {
	$output .= $credentials;
//}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;