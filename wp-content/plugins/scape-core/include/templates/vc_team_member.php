<?php
$output = $link = $el_class = $unique_class = $style = $scheme = $skin = $accent_color =
$email = $linkedin = $facebook = $twitter = $google = $dribbble = $instagram = $equal_start = $equal_height =
$lazy = $preloader = $photo = $name = $accent_color_text = $accent_color_bg = $accent_color_border = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-teammember' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);


// shortcode class
$element_class      = 'wtbx_vc_team_member';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_with_image';
$shortcode_class[] = 'wtbx_' . $style;
$shortcode_class[] = 'wtbx_skin_' . $skin;
$shortcode_class[] = 'wtbx_scheme_' . $scheme;
if ( $style === 'style_1' || $style === 'style_2' || $style === 'style_3' ) {
	$equal_height !== '' ? $shortcode_class[] = 'wtbx_equal_height' : '';
	$equal_start = $equal_height !== '' ? ' data-equal="'.$equal_height.'"' : '';
}
if ( $style === 'style_3' ) {
	$alignment !== '' ? $shortcode_class[] = 'wtbx_' . $alignment : null;
}


// element style
$accent_color_text = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg = wtbx_vc_color_styles_bg($accent_color);
$accent_color_border = wtbx_vc_color_styles_border($accent_color);

// social buttons
$social  = '';
$social_count = 7;
$social_items = '';
$email !== '' ? $social_items .= '<li><a href="'.esc_url('mailto:'.$email).'"><i class="scape-ui-mail" aria-hidden="true"></i></a></li>' : $social_count--;
$linkedin !== '' ? $social_items .= '<li><a href="'.esc_url($linkedin).'" target="_blank"><i class="scape-ui-linkedin" aria-hidden="true"></i></a></li>' : $social_count--;
$facebook !== '' ? $social_items .= '<li><a href="'.esc_url($facebook).'" target="_blank"><i class="scape-ui-facebook" aria-hidden="true"></i></a></li>' : $social_count--;
$twitter !== '' ? $social_items .= '<li><a href="'.esc_url($twitter).'" target="_blank"><i class="scape-ui-twitter" aria-hidden="true"></i></a></li>' : $social_count--;
$google !== '' ? $social_items .= '<li><a href="'.esc_url($google).'" target="_blank"><i class="scape-ui-google-plus" aria-hidden="true"></i></a></li>' : $social_count--;
$dribbble !== '' ? $social_items .= '<li><a href="'.esc_url($dribbble).'" target="_blank"><i class="scape-ui-dribbble" aria-hidden="true"></i></a></li>' : $social_count--;
$instagram !== '' ? $social_items .= '<li><a href="'.esc_url($instagram).'" target="_blank"><i class="scape-ui-instagram" aria-hidden="true"></i></a></li>' : $social_count--;

if ( $social_count > 0 ) {
	$social .= '<div class="wtbx_team_member_social">';
	$social .= '<ul>';
	$social .= $social_items;
	$social .= '</ul>';
	$social .= '</div>';
	$shortcode_class[]  = 'with_social_icons';
}


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );


// svg divider
$svg = '';
if ( $style === 'style_1' ) {
	$svg  = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">';
	$svg .= '<path d="M0 100 0 0 C30 80 70 80 100 0 L 100 100 Z"></path>';
	$svg .= '</svg>';
}


// photo
$image  = '';
$image .= '<div class="wtbx_team_member_photo wtbx_preloader_cont">';
$image .= wtbx_vc_preloader($lazy, $preloader);
$image .= '<div class="wtbx_team_member_photo_inner'.wtbx_vc_reveal_class($lazy).'">';
if ( $style === 'style_1' || $style === 'style_4' ) {
	$image .= wtbx_image_smart_img( $photo, 'medium', 'full', $name, '', true, $lazy );
} elseif ( $style === 'style_2' || 'style_3' ) {
	$image .= wtbx_image_smart_crop( $photo, 'medium', 'full', '1:1', $name, '', true, $lazy );
}
$image .= $svg;
$image .= '</div>';
$image .= '</div>';


// credentials
$credentials  = '';
$credentials .= '<div class="wtbx_team_member_details">';
$credentials .= $name !== '' ? '<div class="wtbx_team_member_name">'.$name.'</div>' : '';
$credentials .= $position !== '' ? '<div class="wtbx_team_member_position">'.$position.'</div>' : '';
$credentials .= '</div>';


// description
$description = $content !== '' ? '<div class="wtbx_team_member_description">' . wpb_js_remove_wpautop($content, true) . '</div>' : '';


// output
$output  = '';
$output .= '<div class="'.esc_attr($css_class).'"'.$equal_start.'>';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

if ( $style === 'style_4' ) {
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_4 .wtbx_team_member_photo:before {' . $accent_color_bg .  '}' : null;
} else {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_team_member_social a:hover i {' . $accent_color_text .  '}' : null;
}
if ( $style === 'style_1' ) {
	$social_count > 0 ? $js_styles .= $unique_class_css.'.wtbx_style_1 .wtbx_team_member_social li {width:' . $social_width = 100 / $social_count . '%' .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1 .wtbx_team_member_content:before {' . $accent_color_bg .  '}' : null;
}

$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner wtbx_equal_height_cont">';

$output .= '<figure' . ($style === 'style_4' ? ' class="touchhover"' : '') . '>';
$output .= $image;
if ( $style === 'style_4' ) {
	$output .= $social;
}
$output .= '<div class="wtbx_team_member_content">';
$output .= $credentials;
if ( $style !== 'style_4' ) {
	$output .= $description;
}
$output .= '</div>';
if ( $style !== 'style_4' ) {
	$output .= $social;
}
$output .= '</figure>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;