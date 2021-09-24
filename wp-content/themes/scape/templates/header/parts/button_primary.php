<?php
$primary_button_link = wtbx_option('h'.$header_style.'-button-primary-link');
if ( class_exists( 'SitePress' ) && has_action('wpml_translate_single_string') ) {
	$primary_button_link = apply_filters( 'wpml_translate_single_string', $primary_button_link, 'scape', 'h'.$header_style.'-button-primary-link' );
} else {
	$primary_button_link = sprintf(esc_html__('%s', 'scape'), $primary_button_link);
}

$primary_button_text = wtbx_option('h'.$header_style.'-button-primary-text');
if ( class_exists( 'SitePress' ) && has_action('wpml_translate_single_string') ) {
	$primary_button_text = apply_filters( 'wpml_translate_single_string', $primary_button_text, 'scape', 'h'.$header_style.'-button-primary-text' );
} else {
	$primary_button_text = sprintf(esc_html__('%s', 'scape'), $primary_button_text);
}
?>

<div class="wtbx_header_part header_button header_custom_button header_button_height">
    <a href="<?php echo esc_html($primary_button_link); ?>" class="wtbx-button wtbx-button-primary"><?php echo esc_html($primary_button_text); ?></a>
</div>