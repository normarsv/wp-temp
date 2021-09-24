<?php
$output = $link = $el_class = $unique_class = $style = $icon = $heading_typography = $accent_color =
$overlay_color = $button_color = $color_string_overlay = $color_string_button_text = $color_string_button_bg = '';
$ratio = '16:9';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-videoplayer' );
wtbx_vc_script_queue( 'plyr' );
wp_enqueue_style('scape-plyr');

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_video_player';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_style_' . $style;
$shortcode_class[]  = $hover !== '' ? 'wtbx_hover_' . $hover : null;


// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).' wtbx_preloader_cont">';
$output .= $poster !== '' ? wtbx_vc_preloader($lazy, $preloader) : '';


// color
$color_string_overlay       = wtbx_vc_color_styles_bg($overlay_color);
$color_string_button_text   = wtbx_vc_color_styles_text($button_color);
$color_string_button_bg     = wtbx_vc_color_styles_bg($button_color);


// poster
if ( $poster ) {
	$metadata = wp_get_attachment_metadata($poster);
	if ( is_array($metadata) ) {
		$ratio = $metadata['width'] . ':' . $metadata['height'];
	}
}


// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$color = json_decode($accent_color, true);
$new_color = '';

$js_styles .= $color_string_overlay !== '' ? $unique_class_css.' .wtbx_video_player_overlay {' . $color_string_overlay .'}' : '';
$js_styles .= $radius !== '' ? $unique_class_css.' .wtbx_video_player_wrapper {border-radius:' . $radius .'px}' : '';
$js_styles .= $color_string_button_text !== '' ? $unique_class_css.' .wtbx_video_player_front .wtbx_video_player_play.wtbx_skin_light_color i {'. $color_string_button_text .'}' : '';
$js_styles .= $color_string_button_bg !== '' ? $unique_class_css.' .wtbx_video_player_front .wtbx_video_player_play.wtbx_skin_dark_color {'. $color_string_button_bg .'}' : '';



$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_with_image' . $this->getExtraClass( $anim_class ).'">';
	$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';

		$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';

			$output .= '<div class="wtbx_video_player_wrapper wtbx_' . esc_attr($media) . ($poster !== '' ? wtbx_vc_reveal_class($lazy) : '') . '" data-media="'.esc_attr($media).'">';
				$output .= '<div class="wtbx_video_player_front wtbx-click'. (( $media === 'youtube' || $media === 'vimeo' ) && !wtbx_vc_has_consent($media) ? ' with_noconsent' : '') .'">';
					if ( ( $media === 'youtube' || $media === 'vimeo' ) && !wtbx_vc_has_consent($media) ) {
						$output .= '<div class="post-'.esc_attr($media).' video-embed video-embed-noconsent">';
						$output .= wtbx_noconsent_content($media, $poster);
						$output .= '</div>';
					} else {
						$output .= '<div class="wtbx_video_player_poster">';
						$output .= wtbx_image_smart_crop( $poster, 'medium', 'full', false, wtbx_get_alt_text($poster), '', true, $lazy );
						$output .= '</div>';
						$output .= '<div class="wtbx_video_player_overlay"></div>';
						$output .= '<div class="wtbx_video_player_play wtbx_skin_'.esc_attr($skin).'"><i class="scape-ui-play"></i></div>';
					}

					if ( $style === 'lightbox' ) {
						if ( $media === 'youtube' && $youtube !== '' ) {
							$url = '//www.youtube.com/watch?v=' . $youtube;
							$type = ' data-iframe="1"';
						} elseif ( $media === 'vimeo' && $vimeo !== '' ) {
							$url = 'https://vimeo.com/' . $vimeo;
							$type = ' data-iframe="1"';
						} elseif ( $media === 'selfhosted_video' && $selfhosted_video !== '' ) {
							$url = $selfhosted_video;
							$type = ' data-video="1"';
						}
						$output .= '<div class="wtbx_video_player_lightbox wtbx-lightbox-item" data-dynamic="1"'.$type.' data-dynamicel="' . esc_url(json_encode($url)) . '"' . wtbx_lightbox_attributes($poster) . ' data-id="' . hexdec(substr(uniqid(), 6, 7)) . '"></div>';
					}

				$output .= '</div>';

				$output .= '<div class="wtbx_video_player_back">';

					if ( $style === 'default' ) {
						if ( $media === 'youtube' && $youtube !== '' ) {
							if ( wtbx_vc_has_consent('youtube') ) {
								$output .= '<div class="plyr__video-embed wtbx_video_player_embed" data-plyr-provider="youtube" data-plyr-embed-id="'.$youtube.'"></div>';
							}
						} elseif ( $media === 'vimeo' && $vimeo !== '' ) {
							if ( wtbx_vc_has_consent('vimeo') ) {
								$output .= '<div class="plyr__video-embed wtbx_video_player_embed" data-plyr-provider="vimeo" data-plyr-embed-id="'.$vimeo.'"></div>';
							}
						} elseif ( $media === 'selfhosted_video' && $selfhosted_video !== '' ) {
							$output .= '<video class="wtbx_video_player_embed" playsinline controls><source src="'.esc_url($selfhosted_video).'" type="video/mp4"></video>';
						}
					} elseif ( $style === 'lightbox' ) {
						wtbx_vc_lightbox_nav();
					}

				$output .= '</div>';

			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
$output .= '</div>';

echo $output;

if ( wtbx_vc_is_page_editable() ) {
	echo "<script>if ('undefined' !== typeof SCAPE) {SCAPE.mediaplayer();}</script>";
}