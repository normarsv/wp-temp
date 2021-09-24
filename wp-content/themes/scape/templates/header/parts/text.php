<?php
$text = wtbx_option('h'.$header_style.'-text-info');

if ( class_exists( 'SitePress' ) && has_action('wpml_translate_single_string') ) {
	$text = apply_filters( 'wpml_translate_single_string', $text, 'scape', 'h'.$header_style.'-text-info' );
} else {
	$text = sprintf(esc_html__('%s', 'scape'), $text);
}

if ( $text !== '' ) { ?>
	<div class="wtbx_header_part wtbx_header_text_wrapper">
		<div class="wtbx_header_text"><?php echo esc_html($text); ?></div>
	</div>
<?php }

