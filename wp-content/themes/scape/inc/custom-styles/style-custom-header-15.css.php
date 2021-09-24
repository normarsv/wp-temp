
/*---------------------------------------------------------------*/
/* Header style 15
/*---------------------------------------------------------------*/
<?php
// general
$h15_topbar_height = wtbx_option('h15-topbar-height');
if ($h15_topbar_height !== '') { ?>
.header-style-15 .wtbx_hs_topbar .wtbx_hs_inner, .header-style-15 .wtbx_hs_topbar .wtbx_ha, .header-style-15 .wtbx_hs_topbar .wtbx_ha .header_button_height { height: <?php echo esc_html($h15_topbar_height); ?>px; line-height: <?php echo esc_html($h15_topbar_height); ?>px; }
<?php }
$h15_header_height = wtbx_option('h15-height');
if ($h15_header_height !== '') { ?>
.header-style-15 .wtbx_hs_header .wtbx_hs_inner, .header-style-15 .wtbx_hs_header .wtbx_ha, .header-style-15 .wtbx_hs_header .wtbx_ha .header_button_height, .header-style-15 .wtbx_hs_header .wtbx_ha .header_button_alt, .header-style-15 .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($h15_header_height); ?>px; line-height: <?php echo esc_html($h15_header_height); ?>px; }
<?php }
$h15_spacing_top = wtbx_option_sub('h15-spacing-top', 'padding-top');
if ($h15_spacing_top !== '') { ?>
.header-style-15 #header-container { padding-top: <?php echo esc_html($h15_spacing_top); ?> }
<?php }
$h15_spacing_side = wtbx_option_sub('h15-spacing-side', 'width');
if ($h15_spacing_side !== '') { ?>
.header-style-15 .wtbx_hs .wtbx_hs_inner { margin-left: <?php echo esc_html($h15_spacing_side); ?>; margin-right: <?php echo esc_html($h15_spacing_side); ?>; }
<?php }
$h15_typo = wtbx_option_sub('h15-font', 'typography');
if ($h15_typo !== '') { ?>
.header-style-15 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h15_typo); ?> }
<?php }
$h15_topbar_typo = wtbx_option_sub('h15-topbar-font', 'typography');
if ($h15_topbar_typo !== '') { ?>
.header-style-15 .wtbx_hs_topbar { <?php echo wtbx_font_styling_static($h15_topbar_typo); ?> }
<?php }
$h15_icon = wtbx_option_sub('h15-icon', 'typography');
if ($h15_icon !== '') { ?>
.header-style-15 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h15_icon); ?> }
<?php }

// logo
$h15_logo_width = intval(wtbx_option_sub('h15-logo-size', 'width'));
$h15_logo_height = intval(wtbx_option_sub('h15-logo-size', 'height'));
$h15_logo_margin_top = intval(wtbx_option('h15-logo-offset-top'));
$h15_logo_margin_left = intval(wtbx_option('h15-logo-offset-left'));

?>
.header-style-15 .wtbx_ha_header_center_left { padding-right: <?php echo esc_html($h15_logo_width)/2 + 10; ?>px  }
.header-style-15 .wtbx_ha_header_center_right { padding-left: <?php echo esc_html($h15_logo_width)/2 + 10; ?>px  }
<?php

$h15_logo_width = $h15_logo_width !== '' ? ' width:'.$h15_logo_width.'px;' : '';
$h15_logo_height = $h15_logo_height !== '' ? ' height:'.$h15_logo_height.'px;' : '';
$h15_logo_margin_top = $h15_logo_margin_top !== '' ? ' margin-top:'.$h15_logo_margin_top.'px;' : '';
$h15_logo_margin_left = $h15_logo_margin_left !== '' ? ' margin-left:'.$h15_logo_margin_left.'px;' : '';

if ($h15_logo_width !== '' || $h15_logo_height !== '' || $h15_logo_margin_top !== '' || $h15_logo_margin_left !== '') { ?>
.header-style-15 .wtbx_header_logo {<?php echo esc_html($h15_logo_width ). $h15_logo_height . $h15_logo_margin_top . $h15_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$h15_light_border = wtbx_option_sub('h15-light-borders-color','rgba');
if ($h15_light_border !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs, .header-style-15.header-skin-light .header_language_trigger:before, .header-style-15.header-skin-light .wtbx_header_login_alt a:before, .header-style-15.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h15_light_border); ?>; }
.header-style-15.header-skin-light .wtbx_header_border:before { background-color: <?php echo esc_html($h15_light_border); ?>; }
<?php }
// - header
$h15_light_header_bg = wtbx_option_sub('h15-light-header-bg','rgba');
if ($h15_light_header_bg !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_header { background-color: <?php echo esc_html($h15_light_header_bg); ?>; }
<?php }
$h15_light_header_text = wtbx_option_sub('h15-light-header-text-color','rgba');
if ($h15_light_header_text !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_header .wtbx_header_part, .header-style-15.header-skin-light .wtbx_hs_header .wtbx_h_text_color, .header-style-15.header-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h15_light_header_text); ?>; }
.header-style-15.header-skin-light .wtbx_hs_header .overlay_button .dot, .header-style-15.header-skin-light .wtbx_hs_header .overlay_button .dot:before, .header-style-15.header-skin-light .wtbx_hs_header .overlay_button .dot:after, .header-style-15.header-skin-light .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h15_light_header_text); ?>; }
<?php }
$h15_light_header_text_hover = wtbx_option_sub('h15-light-header-text-hover','rgba');
if ($h15_light_header_text_hover !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-15.header-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-15.header-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h15_light_header_text_hover); ?>; }
.header-style-15.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-15.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-15.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h15_light_header_text_hover); ?>; }
.header-style-15.header-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header-style-15.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-15.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-15.header-skin-light .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h15_light_header_text_hover); ?>; }
<?php }
$h15_light_header_text_active = wtbx_option_sub('h15-light-header-text-active','rgba');
if ($h15_light_header_text_active !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_header .header_button_alt > a, .header-style-15.header-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-15.header-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h15_light_header_text_active); ?>; }
.header-style-15.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h15_light_header_text_active); ?>; }
<?php }
// - topbar
$h15_light_topbar_bg = wtbx_option_sub('h15-light-topbar-bg','rgba');
if ($h15_light_topbar_bg !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_topbar { background-color: <?php echo esc_html($h15_light_topbar_bg); ?>; }
<?php }
$h15_light_topbar_text = wtbx_option_sub('h15-light-topbar-text-color','rgba');
if ($h15_light_topbar_text !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_topbar .wtbx_header_part, .header-style-15.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color, .header-style-15.header-skin-light .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h15_light_topbar_text); ?>; }
.header-style-15.header-skin-light .wtbx_hs_topbar .overlay_button .dot, .header-style-15.header-skin-light .wtbx_hs_topbar .overlay_button .dot:before, .header-style-15.header-skin-light .wtbx_hs_topbar .overlay_button .dot:after, .header-style-15.header-skin-light .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h15_light_topbar_text); ?>; }
<?php }
$h15_light_topbar_text_hover = wtbx_option_sub('h15-light-topbar-text-hover','rgba');
if ($h15_light_topbar_text_hover !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-15.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-15.header-skin-light .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h15_light_topbar_text_hover); ?>; }
.header-style-15.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h15_light_topbar_text_hover); ?>; }
.header-style-15.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-15.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-15.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-15.header-skin-light .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h15_light_topbar_text_hover); ?>; }
<?php }
$h15_light_topbar_text_active = wtbx_option_sub('h15-light-topbar-text-active','rgba');
if ($h15_light_topbar_text_active !== '') { ?>
.header-style-15.header-skin-light .wtbx_hs_topbar .header_button_alt > a, .header-style-15.header-skin-light .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-15.header-skin-light .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h15_light_topbar_text_active); ?>; }
<?php }

// dark skin colors
// -general
$h15_dark_border = wtbx_option_sub('h15-dark-borders-color','rgba');
if ($h15_dark_border !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs, .header-style-15.header-skin-dark .header_language_trigger:before, .header-style-15.header-skin-dark .wtbx_header_login_alt a:before, .header-style-15.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h15_dark_border); ?>; }
.header-style-15.header-skin-dark .wtbx_header_border:before { background-color: <?php echo esc_html($h15_dark_border); ?>; }
<?php }
// - header
$h15_dark_header_bg = wtbx_option_sub('h15-dark-header-bg','rgba');
if ($h15_dark_header_bg !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_header { background-color: <?php echo esc_html($h15_dark_header_bg); ?>; }
<?php }
$h15_dark_header_text = wtbx_option_sub('h15-dark-header-text-color','rgba');
if ($h15_dark_header_text !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_header .wtbx_header_part, .header-style-15.header-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header-style-15.header-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h15_dark_header_text); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_header .overlay_button .dot, .header-style-15.header-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header-style-15.header-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header-style-15.header-skin-dark .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h15_dark_header_text); ?>; }
<?php }
$h15_dark_header_text_hover = wtbx_option_sub('h15-dark-header-text-hover','rgba');
if ($h15_dark_header_text_hover !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-15.header-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-15.header-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h15_dark_header_text_hover); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-15.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-15.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h15_dark_header_text_hover); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header-style-15.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-15.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-15.header-skin-dark .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h15_dark_header_text_hover); ?>; }
<?php }
$h15_dark_header_text_active = wtbx_option_sub('h15-dark-header-text-active','rgba');
if ($h15_dark_header_text_active !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_header .header_button_alt > a, .header-style-15.header-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-15.header-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h15_dark_header_text_active); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h15_dark_header_text_active); ?>; }
<?php }
// - topbar
$h15_dark_topbar_bg = wtbx_option_sub('h15-dark-topbar-bg','rgba');
if ($h15_dark_topbar_bg !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_topbar { background-color: <?php echo esc_html($h15_dark_topbar_bg); ?>; }
<?php }
$h15_dark_topbar_text = wtbx_option_sub('h15-dark-topbar-text-color','rgba');
if ($h15_dark_topbar_text !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_topbar .wtbx_header_part, .header-style-15.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color, .header-style-15.header-skin-dark .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h15_dark_topbar_text); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_topbar .overlay_button .dot, .header-style-15.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:before, .header-style-15.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:after, .header-style-15.header-skin-dark .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h15_dark_topbar_text); ?>; }
<?php }
$h15_dark_topbar_text_hover = wtbx_option_sub('h15-dark-topbar-text-hover','rgba');
if ($h15_dark_topbar_text_hover !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-15.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-15.header-skin-dark .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h15_dark_topbar_text_hover); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h15_dark_topbar_text_hover); ?>; }
.header-style-15.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-15.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-15.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-15.header-skin-dark .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h15_dark_topbar_text_hover); ?>; }
<?php }
$h15_dark_topbar_text_active = wtbx_option_sub('h15-dark-topbar-text-active','rgba');
if ($h15_dark_topbar_text_active !== '') { ?>
.header-style-15.header-skin-dark .wtbx_hs_topbar .header_button_alt > a, .header-style-15.header-skin-dark .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-15.header-skin-dark .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h15_dark_topbar_text_active); ?>; }
<?php } ?>