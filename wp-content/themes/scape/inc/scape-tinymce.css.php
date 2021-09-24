<?php
$typo_general = wtbx_font_styling('typo-general', false);
if ( $typo_general !== '' ) { ?>
body {<?php print_r($typo_general);?> }
<?php }

$typo_h = wtbx_font_styling('typo-h', false);
if ( $typo_h !== '' ) { ?>
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {<?php print_r($typo_h);?> }
<?php }

$typo_h1 = wtbx_font_styling('typo-h1', false);
if ( $typo_h1 !== '' ) { ?>
h1, .h1 {<?php echo esc_html($typo_h1);?> }
<?php }

$typo_h2 = wtbx_font_styling('typo-h2', false);
if ( $typo_h2 !== '' ) { ?>
h2, .h2 {<?php echo esc_html($typo_h2);?> }
<?php }

$typo_h3 = wtbx_font_styling('typo-h3', false);
if ( $typo_h3 !== '' ) { ?>
h3, .h3 {<?php echo esc_html($typo_h3);?> }
<?php }

$typo_h4 = wtbx_font_styling('typo-h4', false);
if ( $typo_h4 !== '' ) { ?>
h4, .h4 {<?php echo esc_html($typo_h4);?> }
<?php }

$typo_h5 = wtbx_font_styling('typo-h5', false);
if ( $typo_h5 !== '' ) { ?>
h5, .h5 {<?php echo esc_html($typo_h5);?> }
<?php }

$typo_h6 = wtbx_font_styling('typo-h6', false);
if ( $typo_h6 !== '' ) { ?>
h6, .h6 {<?php echo esc_html($typo_h6);?> }
<?php }
?>

blockquote {
	margin: 3em 3em;
	position: relative;
	text-align: center;
}

blockquote p {
	font-style: italic;
	font-size: 1.142857em;
	font-weight: 500;
}
