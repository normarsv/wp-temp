<?php
$output = $link = $el_class = $unique_class = $style =
$accent_color_text = $accent_color_bg = $accent_color_border = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-testimonial' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// construct link
//$link = wtbx_vc_build_link($link);


// shortcode class
$element_class      = 'wtbx_vc_testimonial';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[] = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_skin_' . $skin;
$shortcode_class[] = 'wtbx_scheme_' . $scheme;

// element style
if ( $scheme === 'colorful' ) {
	$accent_color_text = wtbx_vc_color_styles_text($accent_color);
	$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
	$accent_color_border = wtbx_vc_color_styles_border($accent_color);
}

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// credentials
$credentials = '';
$credentials .= '<div class="wtbx_testimonial_credentials">';

if ( $referee === 'person' ) {
	$credentials .= $photo !== '' ? '<div class="wtbx_testimonial_photo wtbx-element-reveal wtbx-reveal-cont">' . wtbx_image_smart_img($photo, 'thumb', 'full', wtbx_get_alt_text($photo), '', true) . '</div>' : '';
	$credentials .= '<div class="wtbx_testimonial_details">';
	$credentials .= $author_name !== '' ? '<div class="wtbx_testimonial_author_name wtbx-text">'.$author_name.'</div>' : '';
	$credentials .= $author_occupation !== '' ? '<div class="wtbx_testimonial_author_occupation wtbx-text">'.$author_occupation.'</div>' : '';
	$credentials .= $author_company !== '' ? '<div class="wtbx_testimonial_author_company wtbx-text">'.$author_company.'</div>' : '';
	$credentials .= '</div>';
} elseif ( $referee === 'company' ) {
	$credentials .= $logo !== '' ? '<div class="wtbx_testimonial_logo">' . wtbx_image_smart_img($logo, 'thumb', 'full', wtbx_get_alt_text($logo), '', true) . '</div>' : '';
}

$credentials .= '</div>';

// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( $style === 'style_1' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_scheme_colorful .wtbx_testimonial_author_name {' . $accent_color_text .  '}' : null;
} elseif ( $style === 'style_2' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_testimonial_content {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2.wtbx_scheme_colorful .wtbx_testimonial_content:before {' . $accent_color_border .  '}' : null;
} elseif ( $style === 'style_3' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_content {' . $accent_color_bg .  '}' : null;
	$accent_color_border !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_photo {' . $accent_color_border .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_credentials:before, ' . $unique_class_css.'.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_credentials:after {' . $accent_color_bg .  '}' : null;
} elseif ( $style === 'style_4' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_4.wtbx_scheme_colorful .wtbx_testimonial_quote {' . $accent_color_text .  '}' : null;
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$style === 'style_1' ? $output .= $credentials : null;
$style === 'style_4' ? $output .= '<i class="scape-ui-quote wtbx_testimonial_quote" aria-hidden="true"></i>' : null;

$output .= '<div class="wtbx_testimonial_content">' . wpb_js_remove_wpautop($content, true) . '</div>';

if ( $style === 'style_2' || $style === 'style_3' || $style === 'style_4' ) {
	$output .= $credentials;
}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;