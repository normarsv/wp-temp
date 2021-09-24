
/*---------------------------------------------------------------*/
/* Header style 16
/*---------------------------------------------------------------*/
<?php
// general
$h16_topbar_height = wtbx_option('h16-topbar-height');
if ($h16_topbar_height !== '') { ?>
.header-style-16 .wtbx_hs_topbar .wtbx_hs_inner, .header-style-16 .wtbx_hs_topbar .wtbx_ha, .header-style-16 .wtbx_hs_topbar .wtbx_ha .header_button_height { height: <?php echo esc_html($h16_topbar_height); ?>px; line-height: <?php echo esc_html($h16_topbar_height); ?>px; }
<?php }
$h16_header_height = wtbx_option('h16-height');
if ($h16_header_height !== '') { ?>
.header-style-16 .wtbx_hs_header .wtbx_hs_inner, .header-style-16 .wtbx_hs_header .wtbx_ha, .header-style-16 .wtbx_hs_header .wtbx_ha .header_button_height, .header-style-16 .wtbx_hs_header .wtbx_ha .header_button_alt, .header-style-16 .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($h16_header_height); ?>px; line-height: <?php echo esc_html($h16_header_height); ?>px; }
<?php }
$h16_spacing_top = wtbx_option_sub('h16-spacing-top', 'padding-top');
if ($h16_spacing_top !== '') { ?>
.header-style-16 #header-container { padding-top: <?php echo esc_html($h16_spacing_top); ?> }
<?php }
$h16_spacing_side = wtbx_option_sub('h16-spacing-side', 'width');
if ($h16_spacing_side !== '') { ?>
.header-style-16 .wtbx_hs .wtbx_hs_inner { margin-left: <?php echo esc_html($h16_spacing_side); ?>; margin-right: <?php echo esc_html($h16_spacing_side); ?>; }
<?php }
$h16_typo = wtbx_option_sub('h16-font', 'typography');
if ($h16_typo !== '') { ?>
.header-style-16 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h16_typo); ?> }
<?php }
$h16_topbar_typo = wtbx_option_sub('h16-topbar-font', 'typography');
if ($h16_topbar_typo !== '') { ?>
.header-style-16 .wtbx_hs_topbar { <?php echo wtbx_font_styling_static($h16_topbar_typo); ?> }
<?php }
$h16_icon = wtbx_option_sub('h16-icon', 'typography');
if ($h16_icon !== '') { ?>
.header-style-16 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h16_icon); ?> }
<?php }

// logo
$h16_logo_width = intval(wtbx_option_sub('h16-logo-size', 'width'));
$h16_logo_height = intval(wtbx_option_sub('h16-logo-size', 'height'));
$h16_logo_margin_top = intval(wtbx_option('h16-logo-offset-top'));
$h16_logo_margin_left = intval(wtbx_option('h16-logo-offset-left'));

?>
.header-style-16 .wtbx_ha_header_center_left { padding-right: <?php echo esc_html($h16_logo_width)/2 + 10; ?>px  }
.header-style-16 .wtbx_ha_header_center_right { padding-left: <?php echo esc_html($h16_logo_width)/2 + 10; ?>px  }
<?php

$h16_logo_width = $h16_logo_width !== '' ? ' width:'.$h16_logo_width.'px;' : '';
$h16_logo_height = $h16_logo_height !== '' ? ' height:'.$h16_logo_height.'px;' : '';
$h16_logo_margin_top = $h16_logo_margin_top !== '' ? ' margin-top:'.$h16_logo_margin_top.'px;' : '';
$h16_logo_margin_left = $h16_logo_margin_left !== '' ? ' margin-left:'.$h16_logo_margin_left.'px;' : '';

if ($h16_logo_width !== '' || $h16_logo_height !== '' || $h16_logo_margin_top !== '' || $h16_logo_margin_left !== '') { ?>
.header-style-16 .wtbx_header_logo {<?php echo esc_html($h16_logo_width ). $h16_logo_height . $h16_logo_margin_top . $h16_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$h16_light_border = wtbx_option_sub('h16-light-borders-color','rgba');
if ($h16_light_border !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs, .header-style-16.header-skin-light .header_language_trigger:before, .header-style-16.header-skin-light .wtbx_header_login_alt a:before, .header-style-16.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h16_light_border); ?>; }
.header-style-16.header-skin-light .wtbx_header_border:before { background-color: <?php echo esc_html($h16_light_border); ?>; }
<?php }
// - header
$h16_light_header_bg = wtbx_option_sub('h16-light-header-bg','rgba');
if ($h16_light_header_bg !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_header { background-color: <?php echo esc_html($h16_light_header_bg); ?>; }
<?php }
$h16_light_header_text = wtbx_option_sub('h16-light-header-text-color','rgba');
if ($h16_light_header_text !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_header .wtbx_header_part, .header-style-16.header-skin-light .wtbx_hs_header .wtbx_h_text_color, .header-style-16.header-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h16_light_header_text); ?>; }
.header-style-16.header-skin-light .wtbx_hs_header .overlay_button .dot, .header-style-16.header-skin-light .wtbx_hs_header .overlay_button .dot:before, .header-style-16.header-skin-light .wtbx_hs_header .overlay_button .dot:after, .header-style-16.header-skin-light .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h16_light_header_text); ?>; }
<?php }
$h16_light_header_text_hover = wtbx_option_sub('h16-light-header-text-hover','rgba');
if ($h16_light_header_text_hover !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-16.header-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-16.header-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h16_light_header_text_hover); ?>; }
.header-style-16.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-16.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-16.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h16_light_header_text_hover); ?>; }
.header-style-16.header-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header-style-16.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-16.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-16.header-skin-light .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h16_light_header_text_hover); ?>; }
<?php }
$h16_light_header_text_active = wtbx_option_sub('h16-light-header-text-active','rgba');
if ($h16_light_header_text_active !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_header .header_button_alt > a, .header-style-16.header-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-16.header-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h16_light_header_text_active); ?>; }
.header-style-16.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h16_light_header_text_active); ?>; }
<?php }
// - topbar
$h16_light_topbar_bg = wtbx_option_sub('h16-light-topbar-bg','rgba');
if ($h16_light_topbar_bg !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_topbar { background-color: <?php echo esc_html($h16_light_topbar_bg); ?>; }
<?php }
$h16_light_topbar_text = wtbx_option_sub('h16-light-topbar-text-color','rgba');
if ($h16_light_topbar_text !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_topbar .wtbx_header_part, .header-style-16.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color, .header-style-16.header-skin-light .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h16_light_topbar_text); ?>; }
.header-style-16.header-skin-light .wtbx_hs_topbar .overlay_button .dot, .header-style-16.header-skin-light .wtbx_hs_topbar .overlay_button .dot:before, .header-style-16.header-skin-light .wtbx_hs_topbar .overlay_button .dot:after, .header-style-16.header-skin-light .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h16_light_topbar_text); ?>; }
<?php }
$h16_light_topbar_text_hover = wtbx_option_sub('h16-light-topbar-text-hover','rgba');
if ($h16_light_topbar_text_hover !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-16.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-16.header-skin-light .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h16_light_topbar_text_hover); ?>; }
.header-style-16.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h16_light_topbar_text_hover); ?>; }
.header-style-16.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-16.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-16.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-16.header-skin-light .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h16_light_topbar_text_hover); ?>; }
<?php }
$h16_light_topbar_text_active = wtbx_option_sub('h16-light-topbar-text-active','rgba');
if ($h16_light_topbar_text_active !== '') { ?>
.header-style-16.header-skin-light .wtbx_hs_topbar .header_button_alt > a, .header-style-16.header-skin-light .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-16.header-skin-light .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h16_light_topbar_text_active); ?>; }
<?php }

// dark skin colors
// -general
$h16_dark_border = wtbx_option_sub('h16-dark-borders-color','rgba');
if ($h16_dark_border !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs, .header-style-16.header-skin-dark .header_language_trigger:before, .header-style-16.header-skin-dark .wtbx_header_login_alt a:before, .header-style-16.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h16_dark_border); ?>; }
.header-style-16.header-skin-dark .wtbx_header_border:before { background-color: <?php echo esc_html($h16_dark_border); ?>; }
<?php }
// - header
$h16_dark_header_bg = wtbx_option_sub('h16-dark-header-bg','rgba');
if ($h16_dark_header_bg !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_header { background-color: <?php echo esc_html($h16_dark_header_bg); ?>; }
<?php }
$h16_dark_header_text = wtbx_option_sub('h16-dark-header-text-color','rgba');
if ($h16_dark_header_text !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_header .wtbx_header_part, .header-style-16.header-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header-style-16.header-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h16_dark_header_text); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_header .overlay_button .dot, .header-style-16.header-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header-style-16.header-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header-style-16.header-skin-dark .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h16_dark_header_text); ?>; }
<?php }
$h16_dark_header_text_hover = wtbx_option_sub('h16-dark-header-text-hover','rgba');
if ($h16_dark_header_text_hover !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-16.header-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-16.header-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h16_dark_header_text_hover); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-16.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-16.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h16_dark_header_text_hover); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header-style-16.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-16.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-16.header-skin-dark .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h16_dark_header_text_hover); ?>; }
<?php }
$h16_dark_header_text_active = wtbx_option_sub('h16-dark-header-text-active','rgba');
if ($h16_dark_header_text_active !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_header .header_button_alt > a, .header-style-16.header-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-16.header-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h16_dark_header_text_active); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h16_dark_header_text_active); ?>; }
<?php }
// - topbar
$h16_dark_topbar_bg = wtbx_option_sub('h16-dark-topbar-bg','rgba');
if ($h16_dark_topbar_bg !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_topbar { background-color: <?php echo esc_html($h16_dark_topbar_bg); ?>; }
<?php }
$h16_dark_topbar_text = wtbx_option_sub('h16-dark-topbar-text-color','rgba');
if ($h16_dark_topbar_text !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_topbar .wtbx_header_part, .header-style-16.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color, .header-style-16.header-skin-dark .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h16_dark_topbar_text); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_topbar .overlay_button .dot, .header-style-16.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:before, .header-style-16.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:after, .header-style-16.header-skin-dark .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h16_dark_topbar_text); ?>; }
<?php }
$h16_dark_topbar_text_hover = wtbx_option_sub('h16-dark-topbar-text-hover','rgba');
if ($h16_dark_topbar_text_hover !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-16.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-16.header-skin-dark .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h16_dark_topbar_text_hover); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h16_dark_topbar_text_hover); ?>; }
.header-style-16.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-16.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-16.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-16.header-skin-dark .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h16_dark_topbar_text_hover); ?>; }
<?php }
$h16_dark_topbar_text_active = wtbx_option_sub('h16-dark-topbar-text-active','rgba');
if ($h16_dark_topbar_text_active !== '') { ?>
.header-style-16.header-skin-dark .wtbx_hs_topbar .header_button_alt > a, .header-style-16.header-skin-dark .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-16.header-skin-dark .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h16_dark_topbar_text_active); ?>; }
<?php } ?>