<?php
$output = $el_class = $unique_class = $style =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay);

// shortcode class
$element_class      = 'wtbx_vc_testimonial_slide';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;


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
	$credentials .= $author_name !== '' ? '<div class="wtbx_testimonial_author_name">'.$author_name.'</div>' : '';
	$credentials .= $author_occupation !== '' ? '<div class="wtbx_testimonial_author_occupation">'.$author_occupation.'</div>' : '';
	$credentials .= $author_company !== '' ? '<div class="wtbx_testimonial_author_company">'.$author_company.'</div>' : '';
	$credentials .= '</div>';
} elseif ( $referee === 'company' ) {
	$credentials .= $logo !== '' ? '<div class="wtbx_testimonial_logo">' . wtbx_image_smart_img($logo, 'thumb§', 'full', wtbx_get_alt_text($logo), '', true) . '</div>' : '';
}
$credentials .= '</div>';


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner wtbx_vc_row">';

$output .= '<div class="wtbx_testimonial_content">' . wpb_js_remove_wpautop($content, true) . '</div>';
$output .= $credentials;

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;