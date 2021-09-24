/*---------------------------------------------------------------*/
/* Preloaders
/*---------------------------------------------------------------*/
<?php
$color_accent = wtbx_option('color-main-accent');

// preloader color - elements
$el_preloader_color = wtbx_option('preloader-elements-color');
$el_preloader_color = $el_preloader_color !== '' ? $el_preloader_color : $color_accent;

if ($el_preloader_color !== '') { ?>
.wtbx-preloader-el .wtbx-preloader-1, .wtbx-preloader-el .wtbx-preloader-11 .circle {
	border-color: <?php echo esc_html($el_preloader_color); ?> !important;
}
.wtbx-preloader-el .wtbx-preloader-2 circle {
	stroke: <?php echo esc_html($el_preloader_color); ?> !important;
}
.wtbx-preloader-el .wtbx-preloader-1 {
	border-right-color:rgba(<?php echo wtbx_hex2rgb($el_preloader_color); ?>, 0.2) !important;
	border-bottom-color:rgba(<?php echo wtbx_hex2rgb($el_preloader_color); ?>, 0.2) !important;
	border-left-color:rgba(<?php echo wtbx_hex2rgb($el_preloader_color); ?>, 0.2) !important;
}
.wtbx-preloader-el .wtbx-preloader-3 .loader-inner,
.wtbx-preloader-el .wtbx-preloader-5 .ldr-blk,
.wtbx-preloader-el .wtbx-preloader-6 div,
.wtbx-preloader-el .wtbx-preloader-7 .sk-circle:before {
	background-color: <?php echo esc_html($el_preloader_color); ?>;
}
.wtbx-preloader-el .wtbx-preloader-4,
.wtbx-preloader-el .wtbx-preloader-4::before, .wtbx-preloader-el .wtbx-preloader-4::after {
	border-color:rgba(<?php echo wtbx_hex2rgb($el_preloader_color); ?>, 1) !important;
	border-left-color:rgba(<?php echo wtbx_hex2rgb($el_preloader_color); ?>, 0.1) !important;
}
.wtbx-preloader-el .wtbx-preloader-8 .pulsation {
	background-color: <?php echo esc_html($el_preloader_color); ?>;
	border-color: <?php echo esc_html($el_preloader_color); ?>;
}
<?php }

// preloader color - website
$global_preloader_color = wtbx_option('preloader-site-color');
$global_preloader_color = $global_preloader_color !== '' ? $global_preloader_color : $color_accent;

if ($global_preloader_color !== '') { ?>
.wtbx-preloader-global .wtbx-preloader-1, .wtbx-preloader-global .wtbx-preloader-11 .circle {
	border-color: <?php echo esc_html($global_preloader_color); ?> !important;
}
.wtbx-preloader-global .wtbx-preloader-2 circle {
	stroke: <?php echo esc_html($global_preloader_color); ?> !important;
}
.wtbx-preloader-global .wtbx-preloader-1 {
	border-right-color:rgba(<?php echo wtbx_hex2rgb($global_preloader_color); ?>, 0) !important;
	border-bottom-color:rgba(<?php echo wtbx_hex2rgb($global_preloader_color); ?>, 0) !important;
	border-left-color:rgba(<?php echo wtbx_hex2rgb($global_preloader_color); ?>, 0) !important;
}
.wtbx-preloader-global .wtbx-preloader-3 .loader-inner,
.wtbx-preloader-global .wtbx-preloader-5 .ldr-blk,
.wtbx-preloader-global .wtbx-preloader-6 div,
.wtbx-preloader-global .wtbx-preloader-7 .sk-circle:before,
.wtbx-preloader-global .wtbx-preloader-9 .ball,
.wtbx-preloader-global .wtbx-preloader-10 .line:before,
.wtbx-preloader-global .wtbx-preloader-11 .circle,
.wtbx-preloader-global .wtbx-preloader-12,
.wtbx-preloader-global .wtbx-preloader-13,
.wtbx-preloader-global .wtbx-preloader-14,
.wtbx-preloader-global .wtbx-preloader-15 div {
	background-color: <?php echo esc_html($global_preloader_color); ?>;
}
.wtbx-preloader-global .wtbx-preloader-4,
.wtbx-preloader-global .wtbx-preloader-4::before, .wtbx-preloader-global .wtbx-preloader-4::after {
	border-color:rgba(<?php echo wtbx_hex2rgb($global_preloader_color); ?>, 1) !important;
	border-left-color:rgba(<?php echo wtbx_hex2rgb($global_preloader_color); ?>, 0.1) !important;
}
.wtbx-preloader-global .wtbx-preloader-8 .pulsation {
	background-color: <?php echo esc_html($global_preloader_color); ?>;
	border-color: <?php echo esc_html($global_preloader_color); ?>;
}
.wtbx-preloader-global .wtbx-preloader-10 span,
.wtbx-preloader-global .wtbx-preloader-11 span {
	color: <?php echo esc_html($global_preloader_color); ?>;
}
.wtbx-preloader-global .wtbx-preloader-17 #wtbx-preloader-counter {
	color: <?php echo esc_html($global_preloader_color); ?>;
}
<?php }

$global_preloader_bg = wtbx_option_sub('preloader-site-bg', 'rgba');
if ($global_preloader_bg !== '') { ?>
#wtbx-site-preloader {
	background-color: <?php echo esc_html($global_preloader_bg); ?>;
}
<?php }

$global_transition_bg = wtbx_option_sub('transition-site-bg', 'rgba');
if ($global_transition_bg !== '') { ?>
#wtbx-site-transition {
	background-color: <?php echo esc_html($global_transition_bg); ?>;
}
<?php } ?>