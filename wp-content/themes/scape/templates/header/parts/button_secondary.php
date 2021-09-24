<?php
$secondary_button_link = wtbx_option('h'.$header_style.'-button-secondary-link');
if ( class_exists( 'SitePress' ) && has_action('wpml_translate_single_string') ) {
	$secondary_button_link = apply_filters( 'wpml_translate_single_string', $secondary_button_link, 'scape', 'h'.$header_style.'-button-secondary-link' );
} else {
	$secondary_button_link = sprintf(esc_html__('%s', 'scape'), $secondary_button_link);
}

$secondary_button_text = wtbx_option('h'.$header_style.'-button-secondary-text');
if ( class_exists( 'SitePress' ) && has_action('wpml_translate_single_string') ) {
	$secondary_button_text = apply_filters( 'wpml_translate_single_string', $secondary_button_text, 'scape', 'h'.$header_style.'-button-secondary-text' );
} else {
	$secondary_button_text = sprintf(esc_html__('%s', 'scape'), $secondary_button_text);
}
?>

<div class="wtbx_header_part header_button header_custom_button header_button_height">
	<a href="<?php echo esc_html($secondary_button_link); ?>" class="wtbx-button wtbx-button-secondary"><?php echo esc_html($secondary_button_text); ?></a>
</div>