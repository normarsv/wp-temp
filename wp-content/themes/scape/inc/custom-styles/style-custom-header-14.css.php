
/*---------------------------------------------------------------*/
/* Header style 14
/*---------------------------------------------------------------*/
<?php
// general
$h14_header_width = wtbx_option('h14-width');
if ($h14_header_width !== '') { ?>
#site-header #header-wrapper.header-style-14 { width: <?php echo esc_html($h14_header_width); ?>px; }
<?php }
$h14_trigger_width = wtbx_option('h14-trigger-width');
if ($h14_trigger_width !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper { width: <?php echo esc_html($h14_trigger_width); ?>px; }
.header-layout-14 + #main, .header-layout-14 + #main.wtbx-footer-under #footer {padding-left: <?php echo esc_html($h14_trigger_width); ?>px; }
<?php }
$h14_top_typo = wtbx_option_sub('h14-top-font', 'typography');
if ($h14_top_typo !== '') { ?>
.header-style-14 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h14_top_typo); ?> }
<?php }
$h14_main_typo = wtbx_option_sub('h14-main-font', 'typography');
if ($h14_main_typo !== '') { ?>
.header-style-14 .wtbx_hs_main { <?php echo wtbx_font_styling_static($h14_main_typo); ?> }
<?php }
$h14_footer_typo = wtbx_option_sub('h14-footer-font', 'typography');
if ($h14_footer_typo !== '') { ?>
.header-style-14 .wtbx_hs_footer { <?php echo wtbx_font_styling_static($h14_footer_typo); ?> }
<?php }
$h14_icon = wtbx_option_sub('h14-icon', 'typography');
if ($h14_icon !== '') { ?>
.header-style-14 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h14_icon); ?> }
<?php }

// logo
// - header
$h14_logo_width = intval(wtbx_option_sub('h14-logo-size', 'width'));
$h14_logo_height = intval(wtbx_option_sub('h14-logo-size', 'height'));
$h14_logo_margin_top = intval(wtbx_option('h14-logo-offset-top'));
$h14_logo_margin_left = intval(wtbx_option('h14-logo-offset-left'));

$h14_logo_width = $h14_logo_width !== '' ? ' width:'.$h14_logo_width.'px;' : '';
$h14_logo_height = $h14_logo_height !== '' ? ' height:'.$h14_logo_height.'px;' : '';
$h14_logo_margin_top = $h14_logo_margin_top !== '' ? ' margin-top:'.$h14_logo_margin_top.'px;' : '';
$h14_logo_margin_left = $h14_logo_margin_left !== '' ? ' margin-left:'.$h14_logo_margin_left.'px;' : '';

if ($h14_logo_width !== '' || $h14_logo_height !== '' || $h14_logo_margin_top !== '' || $h14_logo_margin_left !== '') { ?>
.header-layout-14 #header-container .wtbx_header_logo {<?php echo esc_html($h14_logo_width ). $h14_logo_height . $h14_logo_margin_top . $h14_logo_margin_left; ?>}
<?php }

// logo
// - trigger
$h14_trigger_logo_width = intval(wtbx_option_sub('h14-trigger-logo-size', 'width'));
$h14_trigger_logo_height = intval(wtbx_option_sub('h14-trigger-logo-size', 'height'));
$h14_trigger_logo_margin_top = intval(wtbx_option('h14-trigger-logo-offset-top'));
$h14_trigger_logo_margin_left = intval(wtbx_option('h14-trigger-logo-offset-left'));

$h14_trigger_logo_width = $h14_trigger_logo_width !== '' ? ' width:'.$h14_trigger_logo_width.'px;' : '';
$h14_trigger_logo_height = $h14_trigger_logo_height !== '' ? ' height:'.$h14_trigger_logo_height.'px;' : '';
$h14_trigger_logo_margin_top = $h14_trigger_logo_margin_top !== '' ? ' margin-top:'.$h14_trigger_logo_margin_top.'px;' : '';
$h14_trigger_logo_margin_left = $h14_trigger_logo_margin_left !== '' ? ' margin-left:'.$h14_trigger_logo_margin_left.'px;' : '';

if ($h14_trigger_logo_width !== '' || $h14_trigger_logo_height !== '' || $h14_trigger_logo_margin_top !== '' || $h14_trigger_logo_margin_left !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper .wtbx_header_logo {<?php echo esc_html($h14_trigger_logo_width ). $h14_trigger_logo_height . $h14_trigger_logo_margin_top . $h14_trigger_logo_margin_left; ?>}
<?php }

// trigger
// - light skin
$h14_light_trigger_bg = wtbx_option_sub('h14-light-trigger-bg','rgba');
if ($h14_light_trigger_bg !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-light { background-color: <?php echo esc_html($h14_light_trigger_bg); ?>; }
<?php }
$h14_light_trigger_hover_bg = wtbx_option_sub('h14-light-trigger-hover-bg','rgba');
if ($h14_light_trigger_hover_bg !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-light:hover { background-color: <?php echo esc_html($h14_light_trigger_hover_bg); ?>; }
<?php }
$h14_light_trigger_color = wtbx_option_sub('h14-light-trigger-color','rgba');
if ($h14_light_trigger_color !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-light .line { background-color: <?php echo esc_html($h14_light_trigger_color); ?>; }
<?php }
$h14_light_trigger_hover = wtbx_option_sub('h14-light-trigger-hover','rgba');
if ($h14_light_trigger_hover !== '') { ?>
.header-layout-14:not(.header_active) .wtbx_header_trigger_wrapper.header-skin-light:hover .line { background-color: <?php echo esc_html($h14_light_trigger_hover); ?>; }
<?php }

// -dark skin
$h14_dark_trigger_bg = wtbx_option_sub('h14-dark-trigger-bg','rgba');
if ($h14_dark_trigger_bg !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-dark { background-color: <?php echo esc_html($h14_dark_trigger_bg); ?>; }
<?php }
$h14_dark_trigger_hover_bg = wtbx_option_sub('h14-dark-trigger-hover-bg','rgba');
if ($h14_dark_trigger_hover_bg !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-dark:hover { background-color: <?php echo esc_html($h14_dark_trigger_hover_bg); ?>; }
<?php }
$h14_dark_trigger_color = wtbx_option_sub('h14-dark-trigger-color','rgba');
if ($h14_dark_trigger_color !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-dark .line { background-color: <?php echo esc_html($h14_dark_trigger_color); ?>; }
<?php }
$h14_dark_trigger_hover = wtbx_option_sub('h14-dark-trigger-hover','rgba');
if ($h14_dark_trigger_hover !== '') { ?>
.header-layout-14 .wtbx_header_trigger_wrapper.header-skin-dark:hover .line { background-color: <?php echo esc_html($h14_dark_trigger_hover); ?>; }
<?php }

// header colors
$h14_backdrop = wtbx_option_sub('h14-header-backdrop','rgba');
if ($h14_backdrop !== '') { ?>
.header-layout-14 .header_backdrop { background-color: <?php echo esc_html($h14_backdrop); ?>; }
<?php }

// - header
$h14_header_bg = wtbx_option_sub('h14-header-bg','rgba');
if ($h14_header_bg !== '') { ?>
.header-style-14 { background-color: <?php echo esc_html($h14_header_bg); ?>; }
<?php }
$h14_border = wtbx_option_sub('h14-borders-color','rgba');
if ($h14_border !== '') { ?>
.header-style-14 .header_language_trigger:before, .header-style-14 .wtbx_header_login_alt a:before, .header-style-14.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h14_border); ?>; }
.header-style-14 .wtbx_header_border { background-color: <?php echo esc_html($h14_border); ?>; }
<?php }
$h14_header_text = wtbx_option_sub('h14-header-text-color','rgba');
if ($h14_header_text !== '') { ?>
.header-style-14 .wtbx_header_part, .header-style-14 .wtbx_h_text_color, .header-style-14 .header_widget a { color: <?php echo esc_html($h14_header_text); ?>; }
.header-style-14 .overlay_button .dot, .header-style-14 .overlay_button .dot:before, .header-style-14 .overlay_button .dot:after, .header-style-14 .sidearea_button .line { background-color: <?php echo esc_html($h14_header_text); ?>; }
<?php }
$h14_header_text_hover = wtbx_option_sub('h14-header-text-hover','rgba');
if ($h14_header_text_hover !== '') { ?>
.header-style-14 .wtbx_menu_nav > ul > li:hover, .header-style-14 .wtbx_h_text_color_hover:hover, .header-style-14 .header_widget a:hover { color: <?php echo esc_html($h14_header_text_hover); ?>; }
.header-style-14 .wtbx_menu_nav > ul > li.current-menu-item, .header-style-14 .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-14 .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h14_header_text_hover); ?>; }
.header-style-14 .overlay_button:hover .dot, .header-style-14 .overlay_button:hover .dot:before, .header-style-14 .overlay_button:hover .dot:after, .header-style-14 .sidearea_button:hover .line { background-color: <?php echo esc_html($h14_header_text_hover); ?>; }
<?php }
$h14_header_text_active = wtbx_option_sub('h14-header-text-active','rgba');
if ($h14_header_text_active !== '') { ?>
.header-style-14 .header_button_alt > a, .header-style-14 .header_cart_wrapper_prim .cart_product_count:before, .header-style-14 .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h14_header_text_active); ?>; }
.header-style-14 .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h14_header_text_active); ?>; }
<?php } ?>