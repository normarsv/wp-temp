
/*---------------------------------------------------------------*/
/* Header style 13
/*---------------------------------------------------------------*/
<?php
// general
$h13_header_width = wtbx_option('h13-width');
if ($h13_header_width !== '') { ?>
#site-header #header-wrapper.header-style-13 { width: <?php echo esc_html($h13_header_width); ?>px; }
.header-layout-13 + #main, .header-layout-13 + #main.wtbx-footer-under #footer {padding-left: <?php echo esc_html($h13_header_width); ?>px; }
<?php }
$h13_top_typo = wtbx_option_sub('h13-top-font', 'typography');
if ($h13_top_typo !== '') { ?>
.header-style-13 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h13_top_typo); ?> }
<?php }
$h13_main_typo = wtbx_option_sub('h13-main-font', 'typography');
if ($h13_main_typo !== '') { ?>
.header-style-13 .wtbx_hs_main { <?php echo wtbx_font_styling_static($h13_main_typo); ?> }
<?php }
$h13_footer_typo = wtbx_option_sub('h13-footer-font', 'typography');
if ($h13_footer_typo !== '') { ?>
.header-style-13 .wtbx_hs_footer { <?php echo wtbx_font_styling_static($h13_footer_typo); ?> }
<?php }
$h13_icon = wtbx_option_sub('h13-icon', 'typography');
if ($h13_icon !== '') { ?>
.header-style-13 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h13_icon); ?> }
<?php }

// logo
$h13_logo_width = intval(wtbx_option_sub('h13-logo-size', 'width'));
$h13_logo_height = intval(wtbx_option_sub('h13-logo-size', 'height'));
$h13_logo_margin_top = intval(wtbx_option('h13-logo-offset-top'));
$h13_logo_margin_left = intval(wtbx_option('h13-logo-offset-left'));

$h13_logo_width = $h13_logo_width !== '' ? ' width:'.$h13_logo_width.'px;' : '';
$h13_logo_height = $h13_logo_height !== '' ? ' height:'.$h13_logo_height.'px;' : '';
$h13_logo_margin_top = $h13_logo_margin_top !== '' ? ' margin-top:'.$h13_logo_margin_top.'px;' : '';
$h13_logo_margin_left = $h13_logo_margin_left !== '' ? ' margin-left:'.$h13_logo_margin_left.'px;' : '';

if ($h13_logo_width !== '' || $h13_logo_height !== '' || $h13_logo_margin_top !== '' || $h13_logo_margin_left !== '') { ?>
.header-style-13 .wtbx_header_logo {<?php echo esc_html($h13_logo_width ). $h13_logo_height . $h13_logo_margin_top . $h13_logo_margin_left; ?>}
<?php }

// light skin colors
// - header
$h13_light_header_bg = wtbx_option_sub('h13-light-header-bg','rgba');
if ($h13_light_header_bg !== '') { ?>
.header-style-13.header-skin-light { background-color: <?php echo esc_html($h13_light_header_bg); ?>; }
<?php }
$h13_light_border = wtbx_option_sub('h13-light-borders-color','rgba');
if ($h13_light_border !== '') { ?>
.header-style-13.header-skin-light .header_language_trigger:before, .header-style-13.header-skin-light .wtbx_header_login_alt a:before, .header-style-13.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h13_light_border); ?>; }
.header-style-13.header-skin-light .wtbx_header_border { background-color: <?php echo esc_html($h13_light_border); ?>; }
<?php }
$h13_light_header_text = wtbx_option_sub('h13-light-header-text-color','rgba');
if ($h13_light_header_text !== '') { ?>
.header-style-13.header-skin-light .wtbx_header_part, .header-style-13.header-skin-light .wtbx_h_text_color, .header-style-13.header-skin-light .header_widget a { color: <?php echo esc_html($h13_light_header_text); ?>; }
.header-style-13.header-skin-light .overlay_button .dot, .header-style-13.header-skin-light .overlay_button .dot:before, .header-style-13.header-skin-light .overlay_button .dot:after, .header-style-13.header-skin-light .sidearea_button .line { background-color: <?php echo esc_html($h13_light_header_text); ?>; }
<?php }
$h13_light_header_text_hover = wtbx_option_sub('h13-light-header-text-hover','rgba');
if ($h13_light_header_text_hover !== '') { ?>
.header-style-13.header-skin-light .wtbx_menu_nav > ul > li:hover, .header-style-13.header-skin-light .wtbx_h_text_color_hover:hover, .header-style-13.header-skin-light .header_widget a:hover { color: <?php echo esc_html($h13_light_header_text_hover); ?>; }
.header-style-13.header-skin-light .wtbx_menu_nav > ul > li.current-menu-item, .header-style-13.header-skin-light .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-13.header-skin-light .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h13_light_header_text_hover); ?>; }
.header-style-13.header-skin-light .overlay_button:hover .dot, .header-style-13.header-skin-light .overlay_button:hover .dot:before, .header-style-13.header-skin-light .overlay_button:hover .dot:after, .header-style-13.header-skin-light .sidearea_button:hover .line { background-color: <?php echo esc_html($h13_light_header_text_hover); ?>; }
<?php }
$h13_light_header_text_active = wtbx_option_sub('h13-light-header-text-active','rgba');
if ($h13_light_header_text_active !== '') { ?>
.header-style-13.header-skin-light .header_button_alt > a, .header-style-13.header-skin-light .header_cart_wrapper_prim .cart_product_count:before, .header-style-13.header-skin-light .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h13_light_header_text_active); ?>; }
.header-style-13.header-skin-light .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h13_light_header_text_active); ?>; }
<?php }

// dark skin colors
// - header
$h13_dark_header_bg = wtbx_option_sub('h13-dark-header-bg','rgba');
if ($h13_dark_header_bg !== '') { ?>
.header-style-13.header-skin-dark { background-color: <?php echo esc_html($h13_dark_header_bg); ?>; }
<?php }
$h13_dark_border = wtbx_option_sub('h13-dark-borders-color','rgba');
if ($h13_dark_border !== '') { ?>
.header-style-13.header-skin-dark .header_language_trigger:before, .header-style-13.header-skin-dark .wtbx_header_login_alt a:before, .header-style-13.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h13_dark_border); ?>; }
.header-style-13.header-skin-dark .wtbx_header_border { background-color: <?php echo esc_html($h13_dark_border); ?>; }
<?php }
$h13_dark_header_text = wtbx_option_sub('h13-dark-header-text-color','rgba');
if ($h13_dark_header_text !== '') { ?>
.header-style-13.header-skin-dark .wtbx_header_part, .header-style-13.header-skin-dark .wtbx_h_text_color, .header-style-13.header-skin-dark .header_widget a { color: <?php echo esc_html($h13_dark_header_text); ?>; }
.header-style-13.header-skin-dark .overlay_button .dot, .header-style-13.header-skin-dark .overlay_button .dot:before, .header-style-13.header-skin-dark .overlay_button .dot:after, .header-style-13.header-skin-dark .sidearea_button .line { background-color: <?php echo esc_html($h13_dark_header_text); ?>; }
<?php }
$h13_dark_header_text_hover = wtbx_option_sub('h13-dark-header-text-hover','rgba');
if ($h13_dark_header_text_hover !== '') { ?>
.header-style-13.header-skin-dark .wtbx_menu_nav > ul > li:hover, .header-style-13.header-skin-dark .wtbx_h_text_color_hover:hover, .header-style-13.header-skin-dark .header_widget a:hover { color: <?php echo esc_html($h13_dark_header_text_hover); ?>; }
.header-style-13.header-skin-dark .wtbx_menu_nav > ul > li.current-menu-item, .header-style-13.header-skin-dark .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-13.header-skin-dark .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h13_dark_header_text_hover); ?>; }
.header-style-13.header-skin-dark .overlay_button:hover .dot, .header-style-13.header-skin-dark .overlay_button:hover .dot:before, .header-style-13.header-skin-dark .overlay_button:hover .dot:after, .header-style-13.header-skin-dark .sidearea_button:hover .line { background-color: <?php echo esc_html($h13_dark_header_text_hover); ?>; }
<?php }
$h13_dark_header_text_active = wtbx_option_sub('h13-dark-header-text-active','rgba');
if ($h13_dark_header_text_active !== '') { ?>
.header-style-13.header-skin-dark .header_button_alt > a, .header-style-13.header-skin-dark .header_cart_wrapper_prim .cart_product_count:before, .header-style-13.header-skin-dark .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h13_dark_header_text_active); ?>; }
.header-style-13.header-skin-dark .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h13_dark_header_text_active); ?>; }
<?php } ?>