
/*---------------------------------------------------------------*/
/* Header style 9
/*---------------------------------------------------------------*/
<?php
// general
$h9_topbar_height = wtbx_option('h9-topbar-height');
if ($h9_topbar_height !== '') { ?>
.header-style-9 .wtbx_hs_topbar .wtbx_hs_inner, .header-style-9 .wtbx_hs_topbar .wtbx_ha, .header-style-9 .wtbx_hs_topbar .wtbx_ha .header_button_height { height: <?php echo esc_html($h9_topbar_height); ?>px; line-height: <?php echo esc_html($h9_topbar_height); ?>px; }
<?php }
$h9_header_height = wtbx_option('h9-height');
if ($h9_header_height !== '') { ?>
.header-style-9 .wtbx_hs_header .wtbx_hs_inner, .header-style-9 .wtbx_hs_header .wtbx_ha, .header-style-9 .wtbx_hs_header .wtbx_ha .header_button_height, .header-style-9 .wtbx_hs_header .wtbx_ha .header_button_alt, .header-style-9 .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($h9_header_height); ?>px; line-height: <?php echo esc_html($h9_header_height); ?>px; }
<?php }
$h9_spacing_top = wtbx_option_sub('h9-spacing-top', 'padding-top');
if ($h9_spacing_top !== '') { ?>
.header-style-9 #header-container { padding-top: <?php echo esc_html($h9_spacing_top); ?> }
<?php }
$h9_spacing_side = wtbx_option_sub('h9-spacing-side', 'width');
if ($h9_spacing_side !== '') { ?>
.header-style-9 .wtbx_hs .wtbx_hs_inner { margin-left: <?php echo esc_html($h9_spacing_side); ?>; margin-right: <?php echo esc_html($h9_spacing_side); ?>; }
<?php }
$h9_typo = wtbx_option_sub('h9-font', 'typography');
if ($h9_typo !== '') { ?>
.header-style-9 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h9_typo); ?> }
<?php }
$h9_topbar_typo = wtbx_option_sub('h9-topbar-font', 'typography');
if ($h9_topbar_typo !== '') { ?>
.header-style-9 .wtbx_hs_topbar { <?php echo wtbx_font_styling_static($h9_topbar_typo); ?> }
<?php }
$h9_icon = wtbx_option_sub('h9-icon', 'typography');
if ($h9_icon !== '') { ?>
.header-style-9 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h9_icon); ?> }
<?php }

// logo
$h9_logo_width = intval(wtbx_option_sub('h9-logo-size', 'width'));
$h9_logo_height = intval(wtbx_option_sub('h9-logo-size', 'height'));
$h9_logo_margin_top = intval(wtbx_option('h9-logo-offset-top'));
$h9_logo_margin_left = intval(wtbx_option('h9-logo-offset-left'));

?>
.header-style-9 .wtbx_ha_header_center_left { padding-right: <?php echo esc_html($h9_logo_width)/2 + 10; ?>px  }
.header-style-9 .wtbx_ha_header_center_right { padding-left: <?php echo esc_html($h9_logo_width)/2 + 10; ?>px  }
<?php

$h9_logo_width = $h9_logo_width !== '' ? ' width:'.$h9_logo_width.'px;' : '';
$h9_logo_height = $h9_logo_height !== '' ? ' height:'.$h9_logo_height.'px;' : '';
$h9_logo_margin_top = $h9_logo_margin_top !== '' ? ' margin-top:'.$h9_logo_margin_top.'px;' : '';
$h9_logo_margin_left = $h9_logo_margin_left !== '' ? ' margin-left:'.$h9_logo_margin_left.'px;' : '';

if ($h9_logo_width !== '' || $h9_logo_height !== '' || $h9_logo_margin_top !== '' || $h9_logo_margin_left !== '') { ?>
.header-style-9 .wtbx_header_logo {<?php echo esc_html($h9_logo_width ). $h9_logo_height . $h9_logo_margin_top . $h9_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$h9_light_border = wtbx_option_sub('h9-light-borders-color','rgba');
if ($h9_light_border !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs, .header-style-9.header-skin-light .header_language_trigger:before, .header-style-9.header-skin-light .wtbx_header_login_alt a:before, .header-style-9.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h9_light_border); ?>; }
.header-style-9.header-skin-light .wtbx_header_border:before { background-color: <?php echo esc_html($h9_light_border); ?>; }
<?php }
// - header
$h9_light_header_bg = wtbx_option_sub('h9-light-header-bg','rgba');
if ($h9_light_header_bg !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_header { background-color: <?php echo esc_html($h9_light_header_bg); ?>; }
<?php }
$h9_light_header_text = wtbx_option_sub('h9-light-header-text-color','rgba');
if ($h9_light_header_text !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_header .wtbx_header_part, .header-style-9.header-skin-light .wtbx_hs_header .wtbx_h_text_color, .header-style-9.header-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h9_light_header_text); ?>; }
.header-style-9.header-skin-light .wtbx_hs_header .overlay_button .dot, .header-style-9.header-skin-light .wtbx_hs_header .overlay_button .dot:before, .header-style-9.header-skin-light .wtbx_hs_header .overlay_button .dot:after, .header-style-9.header-skin-light .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h9_light_header_text); ?>; }
<?php }
$h9_light_header_text_hover = wtbx_option_sub('h9-light-header-text-hover','rgba');
if ($h9_light_header_text_hover !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-9.header-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-9.header-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h9_light_header_text_hover); ?>; }
.header-style-9.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-9.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-9.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h9_light_header_text_hover); ?>; }
.header-style-9.header-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header-style-9.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-9.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-9.header-skin-light .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h9_light_header_text_hover); ?>; }
<?php }
$h9_light_header_text_active = wtbx_option_sub('h9-light-header-text-active','rgba');
if ($h9_light_header_text_active !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_header .header_button_alt > a, .header-style-9.header-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-9.header-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h9_light_header_text_active); ?>; }
.header-style-9.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h9_light_header_text_active); ?>; }
<?php }
// - topbar
$h9_light_topbar_bg = wtbx_option_sub('h9-light-topbar-bg','rgba');
if ($h9_light_topbar_bg !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_topbar { background-color: <?php echo esc_html($h9_light_topbar_bg); ?>; }
<?php }
$h9_light_topbar_text = wtbx_option_sub('h9-light-topbar-text-color','rgba');
if ($h9_light_topbar_text !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_topbar .wtbx_header_part, .header-style-9.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color, .header-style-9.header-skin-light .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h9_light_topbar_text); ?>; }
.header-style-9.header-skin-light .wtbx_hs_topbar .overlay_button .dot, .header-style-9.header-skin-light .wtbx_hs_topbar .overlay_button .dot:before, .header-style-9.header-skin-light .wtbx_hs_topbar .overlay_button .dot:after, .header-style-9.header-skin-light .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h9_light_topbar_text); ?>; }
<?php }
$h9_light_topbar_text_hover = wtbx_option_sub('h9-light-topbar-text-hover','rgba');
if ($h9_light_topbar_text_hover !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-9.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-9.header-skin-light .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h9_light_topbar_text_hover); ?>; }
.header-style-9.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h9_light_topbar_text_hover); ?>; }
.header-style-9.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-9.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-9.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-9.header-skin-light .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h9_light_topbar_text_hover); ?>; }
<?php }
$h9_light_topbar_text_active = wtbx_option_sub('h9-light-topbar-text-active','rgba');
if ($h9_light_topbar_text_active !== '') { ?>
.header-style-9.header-skin-light .wtbx_hs_topbar .header_button_alt > a, .header-style-9.header-skin-light .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-9.header-skin-light .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h9_light_topbar_text_active); ?>; }
<?php }

// dark skin colors
// -general
$h9_dark_border = wtbx_option_sub('h9-dark-borders-color','rgba');
if ($h9_dark_border !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs, .header-style-9.header-skin-dark .header_language_trigger:before, .header-style-9.header-skin-dark .wtbx_header_login_alt a:before, .header-style-9.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h9_dark_border); ?>; }
.header-style-9.header-skin-dark .wtbx_header_border:before { background-color: <?php echo esc_html($h9_dark_border); ?>; }
<?php }
// - header
$h9_dark_header_bg = wtbx_option_sub('h9-dark-header-bg','rgba');
if ($h9_dark_header_bg !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_header { background-color: <?php echo esc_html($h9_dark_header_bg); ?>; }
<?php }
$h9_dark_header_text = wtbx_option_sub('h9-dark-header-text-color','rgba');
if ($h9_dark_header_text !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_header .wtbx_header_part, .header-style-9.header-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header-style-9.header-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h9_dark_header_text); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_header .overlay_button .dot, .header-style-9.header-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header-style-9.header-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header-style-9.header-skin-dark .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h9_dark_header_text); ?>; }
<?php }
$h9_dark_header_text_hover = wtbx_option_sub('h9-dark-header-text-hover','rgba');
if ($h9_dark_header_text_hover !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-9.header-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-9.header-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h9_dark_header_text_hover); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-9.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-9.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h9_dark_header_text_hover); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header-style-9.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-9.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-9.header-skin-dark .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h9_dark_header_text_hover); ?>; }
<?php }
$h9_dark_header_text_active = wtbx_option_sub('h9-dark-header-text-active','rgba');
if ($h9_dark_header_text_active !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_header .header_button_alt > a, .header-style-9.header-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-9.header-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h9_dark_header_text_active); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h9_dark_header_text_active); ?>; }
<?php }
// - topbar
$h9_dark_topbar_bg = wtbx_option_sub('h9-dark-topbar-bg','rgba');
if ($h9_dark_topbar_bg !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_topbar { background-color: <?php echo esc_html($h9_dark_topbar_bg); ?>; }
<?php }
$h9_dark_topbar_text = wtbx_option_sub('h9-dark-topbar-text-color','rgba');
if ($h9_dark_topbar_text !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_topbar .wtbx_header_part, .header-style-9.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color, .header-style-9.header-skin-dark .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h9_dark_topbar_text); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_topbar .overlay_button .dot, .header-style-9.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:before, .header-style-9.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:after, .header-style-9.header-skin-dark .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h9_dark_topbar_text); ?>; }
<?php }
$h9_dark_topbar_text_hover = wtbx_option_sub('h9-dark-topbar-text-hover','rgba');
if ($h9_dark_topbar_text_hover !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-9.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-9.header-skin-dark .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h9_dark_topbar_text_hover); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h9_dark_topbar_text_hover); ?>; }
.header-style-9.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-9.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-9.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-9.header-skin-dark .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h9_dark_topbar_text_hover); ?>; }
<?php }
$h9_dark_topbar_text_active = wtbx_option_sub('h9-dark-topbar-text-active','rgba');
if ($h9_dark_topbar_text_active !== '') { ?>
.header-style-9.header-skin-dark .wtbx_hs_topbar .header_button_alt > a, .header-style-9.header-skin-dark .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-9.header-skin-dark .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h9_dark_topbar_text_active); ?>; }
<?php } ?>