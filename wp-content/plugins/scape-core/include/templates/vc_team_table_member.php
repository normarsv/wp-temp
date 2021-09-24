<?php
$output = $link = $el_class = $unique_class = $style = $name = $photo = $position = $title =
$accent_color_text = $accent_color_bg = $accent_color_border =
$css_animation = $css_animation_easing = $css_animation_duration = $css_animation_delay = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_team_table_member';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[] = 'wtbx_' . $style;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// photo
$image  = '';
$image .= '<a href="#wtbx_team-'.$slide_id.'" class="wtbx_team_member_photo wtbx_preloader_cont">';
if ( $photo ) {
	$image .= wtbx_vc_preloader($lazy, $preloader);
	$image .= '<div class="wtbx_team_member_photo_inner'.wtbx_vc_reveal_class($lazy).'">';
	$image .= wtbx_image_smart_crop( $photo, 'medium', 'full', '1:1', $name, '', true );
	$image .= '</div>';
} else {
	$image .= '<div class="wtbx_team_member_no_image"></div>';
}
$image .= '</a>';



// credentials
$credentials = '';
if ( $title !== '' || $position !== '' ) {
	$credentials .= '<div class="wtbx_team_member_details">';
	$credentials .= $title !== '' ? '<div class="wtbx_team_member_name">'.$title.'</div>' : '';
	$credentials .= $position !== '' ? '<div class="wtbx_team_member_position">'.$position.'</div>' : '';
	$credentials .= '</div>';
}


// description
$description = '<div class="wtbx_team_member_description">' . wpb_js_remove_wpautop($content, true) . '</div>';


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'" data-team="#wtbx_team-'.$slide_id.'">';


// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

$output .= '<div class="wtbx_team_member_wrapper">';

$output .= $image;
$output .= '<div class="wtbx_team_member_content">';
$output .= $credentials;
$output .= $description;
$output .= '</div>';

$output .= '</div>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;