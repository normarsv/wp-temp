
/*---------------------------------------------------------------*/
/* Header style 4
/*---------------------------------------------------------------*/
<?php
// general
$h4_header_height = wtbx_option('h4-height');
if ($h4_header_height !== '') { ?>
.header-style-4 .wtbx_hs_header .wtbx_hs_inner, .header-style-4 .wtbx_hs_header .wtbx_ha, .header-style-4 .wtbx_hs_header .wtbx_ha .header_button_height, .header-style-4 .wtbx_hs_header .wtbx_ha .header_button_alt, .header-style-4 .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($h4_header_height); ?>px; line-height: <?php echo esc_html($h4_header_height); ?>px; }
<?php }
$h4_topbar_height = wtbx_option('h4-topbar-height');
if ($h4_topbar_height !== '') { ?>
.header-style-4 .wtbx_hs_topbar .wtbx_hs_inner, .header-style-4 .wtbx_hs_topbar .wtbx_ha, .header-style-4 .wtbx_hs_topbar .wtbx_ha .header_button_height { height: <?php echo esc_html($h4_topbar_height); ?>px; line-height: <?php echo esc_html($h4_topbar_height); ?>px; }
<?php }
$h4_bottombar_height = wtbx_option('h4-bottombar-height');
if ($h4_bottombar_height !== '') { ?>
.header-style-4 .wtbx_hs_bottombar .wtbx_hs_inner, .header-style-4 .wtbx_hs_bottombar .wtbx_ha, .header-style-4 .wtbx_hs_bottombar .wtbx_ha .header_button_height { height: <?php echo esc_html($h4_bottombar_height); ?>px; line-height: <?php echo esc_html($h4_bottombar_height); ?>px; }
<?php }
$h4_spacing_top = wtbx_option_sub('h4-spacing-top', 'padding-top');
if ($h4_spacing_top !== '') { ?>
.header-style-4 #header-container { padding-top: <?php echo esc_html($h4_spacing_top); ?> }
<?php }
$h4_spacing_side = wtbx_option_sub('h4-spacing-side', 'width');
if ($h4_spacing_side !== '') { ?>
.header-style-4 .wtbx_hs .wtbx_hs_inner { margin-left: <?php echo esc_html($h4_spacing_side); ?>; margin-right: <?php echo esc_html($h4_spacing_side); ?>; }
<?php }
$h4_typo = wtbx_option_sub('h4-font', 'typography');
if ($h4_typo !== '') { ?>
.header-style-4 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h4_typo); ?> }
<?php }
$h4_topbar_typo = wtbx_option_sub('h4-topbar-font', 'typography');
if ($h4_topbar_typo !== '') { ?>
.header-style-4 .wtbx_hs_topbar { <?php echo wtbx_font_styling_static($h4_topbar_typo); ?> }
<?php }
$h4_bottombar_typo = wtbx_option_sub('h4-bottombar-font', 'typography');
if ($h4_bottombar_typo !== '') { ?>
.header-style-4 .wtbx_hs_bottombar { <?php echo wtbx_font_styling_static($h4_bottombar_typo); ?> }
<?php }
$h4_icon = wtbx_option_sub('h4-icon', 'typography');
if ($h4_icon !== '') { ?>
.header-style-4 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h4_icon); ?> }
<?php }

// logo
$h4_logo_width = intval(wtbx_option_sub('h4-logo-size', 'width'));
$h4_logo_height = intval(wtbx_option_sub('h4-logo-size', 'height'));
$h4_logo_margin_top = intval(wtbx_option('h4-logo-offset-top'));
$h4_logo_margin_left = intval(wtbx_option('h4-logo-offset-left'));

$h4_logo_width = $h4_logo_width !== '' ? ' width:'.$h4_logo_width.'px;' : '';
$h4_logo_height = $h4_logo_height !== '' ? ' height:'.$h4_logo_height.'px;' : '';
$h4_logo_margin_top = $h4_logo_margin_top !== '' ? ' margin-top:'.$h4_logo_margin_top.'px;' : '';
$h4_logo_margin_left = $h4_logo_margin_left !== '' ? ' margin-left:'.$h4_logo_margin_left.'px;' : '';

if ($h4_logo_width !== '' || $h4_logo_height !== '' || $h4_logo_margin_top !== '' || $h4_logo_margin_left !== '') { ?>
.header-style-4 .wtbx_header_logo {<?php echo esc_html($h4_logo_width ). $h4_logo_height . $h4_logo_margin_top . $h4_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$h4_light_border = wtbx_option_sub('h4-light-borders-color','rgba');
if ($h4_light_border !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs, .header-style-4.header-skin-light .header_language_trigger:before, .header-style-4.header-skin-light .wtbx_header_login_alt a:before, .header-style-4.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h4_light_border); ?>; }
.header-style-4.header-skin-light .wtbx_header_border:before { background-color: <?php echo esc_html($h4_light_border); ?>; }
<?php }
// - header
$h4_light_header_bg = wtbx_option_sub('h4-light-header-bg','rgba');
if ($h4_light_header_bg !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_header { background-color: <?php echo esc_html($h4_light_header_bg); ?>; }
<?php }
$h4_light_header_text = wtbx_option_sub('h4-light-header-text-color','rgba');
if ($h4_light_header_text !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_header .wtbx_header_part, .header-style-4.header-skin-light .wtbx_hs_header .wtbx_h_text_color, .header-style-4.header-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h4_light_header_text); ?>; }
.header-style-4.header-skin-light .wtbx_hs_header .overlay_button .dot, .header-style-4.header-skin-light .wtbx_hs_header .overlay_button .dot:before, .header-style-4.header-skin-light .wtbx_hs_header .overlay_button .dot:after, .header-style-4.header-skin-light .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h4_light_header_text); ?>; }
<?php }
$h4_light_header_text_hover = wtbx_option_sub('h4-light-header-text-hover','rgba');
if ($h4_light_header_text_hover !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-4.header-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-4.header-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h4_light_header_text_hover); ?>; }
.header-style-4.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-4.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-4.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h4_light_header_text_hover); ?>; }
.header-style-4.header-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header-style-4.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-4.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-4.header-skin-light .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h4_light_header_text_hover); ?>; }
<?php }
$h4_light_header_text_active = wtbx_option_sub('h4-light-header-text-active','rgba');
if ($h4_light_header_text_active !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_header .header_button_alt > a, .header-style-4.header-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-4.header-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h4_light_header_text_active); ?>; }
.header-style-4.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h4_light_header_text_active); ?>; }
<?php }
// - topbar
$h4_light_topbar_bg = wtbx_option_sub('h4-light-topbar-bg','rgba');
if ($h4_light_topbar_bg !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_topbar { background-color: <?php echo esc_html($h4_light_topbar_bg); ?>; }
<?php }
$h4_light_topbar_text = wtbx_option_sub('h4-light-topbar-text-color','rgba');
if ($h4_light_topbar_text !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_topbar .wtbx_header_part, .header-style-4.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color, .header-style-4.header-skin-light .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h4_light_topbar_text); ?>; }
.header-style-4.header-skin-light .wtbx_hs_topbar .overlay_button .dot, .header-style-4.header-skin-light .wtbx_hs_topbar .overlay_button .dot:before, .header-style-4.header-skin-light .wtbx_hs_topbar .overlay_button .dot:after, .header-style-4.header-skin-light .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h4_light_topbar_text); ?>; }
<?php }
$h4_light_topbar_text_hover = wtbx_option_sub('h4-light-topbar-text-hover','rgba');
if ($h4_light_topbar_text_hover !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-4.header-skin-light .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-4.header-skin-light .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h4_light_topbar_text_hover); ?>; }
.header-style-4.header-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h4_light_topbar_text_hover); ?>; }
.header-style-4.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-4.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-4.header-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-4.header-skin-light .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h4_light_topbar_text_hover); ?>; }
<?php }
$h4_light_topbar_text_active = wtbx_option_sub('h4-light-topbar-text-active','rgba');
if ($h4_light_topbar_text_active !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_topbar .header_button_alt > a, .header-style-4.header-skin-light .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-4.header-skin-light .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h4_light_topbar_text_active); ?>; }
<?php }
// - bottombar
$h4_light_bottombar_bg = wtbx_option_sub('h4-light-bottombar-bg','rgba');
if ($h4_light_bottombar_bg !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_bottombar { background-color: <?php echo esc_html($h4_light_bottombar_bg); ?>; }
<?php }
$h4_light_bottombar_text = wtbx_option_sub('h4-light-bottombar-text-color','rgba');
if ($h4_light_bottombar_text !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_bottombar .wtbx_header_part, .header-style-4.header-skin-light .wtbx_hs_bottombar .wtbx_h_text_color, .header-style-4.header-skin-light .wtbx_hs_bottombar .header_widget a { color: <?php echo esc_html($h4_light_bottombar_text); ?>; }
.header-style-4.header-skin-light .wtbx_hs_bottombar .overlay_button .dot, .header-style-4.header-skin-light .wtbx_hs_bottombar .overlay_button .dot:before, .header-style-4.header-skin-light .wtbx_hs_bottombar .overlay_button .dot:after, .header-style-4.header-skin-light .wtbx_hs_bottombar .sidearea_button .line { background-color: <?php echo esc_html($h4_light_bottombar_text); ?>; }
<?php }
$h4_light_bottombar_text_hover = wtbx_option_sub('h4-light-bottombar-text-hover','rgba');
if ($h4_light_bottombar_text_hover !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_bottombar .wtbx_menu_nav > ul > li:hover, .header-style-4.header-skin-light .wtbx_hs_bottombar .wtbx_h_text_color_hover:hover, .header-style-4.header-skin-light .wtbx_hs_bottombar .header_widget a:hover { color: <?php echo esc_html($h4_light_bottombar_text_hover); ?>; }
.header-style-4.header-skin-light .wtbx_hs_bottombar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h4_light_bottombar_text_hover); ?>; }
.header-style-4.header-skin-light .wtbx_hs_bottombar .overlay_button:hover .dot, .header-style-4.header-skin-light .wtbx_hs_bottombar .overlay_button:hover .dot:before, .header-style-4.header-skin-light .wtbx_hs_bottombar .overlay_button:hover .dot:after, .header-style-4.header-skin-light .wtbx_hs_bottombar .sidearea_button:hover .line { background-color: <?php echo esc_html($h4_light_bottombar_text_hover); ?>; }
<?php }
$h4_light_bottombar_text_active = wtbx_option_sub('h4-light-bottombar-text-active','rgba');
if ($h4_light_bottombar_text_active !== '') { ?>
.header-style-4.header-skin-light .wtbx_hs_bottombar .header_button_alt > a, .header-style-4.header-skin-light .wtbx_hs_bottombar .header_cart_wrapper_prim .cart_product_count:before, .header-style-4.header-skin-light .wtbx_hs_bottombar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h4_light_bottombar_text_active); ?>; }
<?php }

// dark skin colors
// -general
$h4_dark_border = wtbx_option_sub('h4-dark-borders-color','rgba');
if ($h4_dark_border !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs, .header-style-4.header-skin-dark .header_language_trigger:before, .header-style-4.header-skin-dark .wtbx_header_login_alt a:before, .header-style-4.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h4_dark_border); ?>; }
.header-style-4.header-skin-dark .wtbx_header_border:before { background-color: <?php echo esc_html($h4_dark_border); ?>; }
<?php }
// - header
$h4_dark_header_bg = wtbx_option_sub('h4-dark-header-bg','rgba');
if ($h4_dark_header_bg !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_header { background-color: <?php echo esc_html($h4_dark_header_bg); ?>; }
<?php }
$h4_dark_header_text = wtbx_option_sub('h4-dark-header-text-color','rgba');
if ($h4_dark_header_text !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_header .wtbx_header_part, .header-style-4.header-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header-style-4.header-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h4_dark_header_text); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_header .overlay_button .dot, .header-style-4.header-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header-style-4.header-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header-style-4.header-skin-dark .wtbx_hs_header .sidearea_button .line { background-color: <?php echo esc_html($h4_dark_header_text); ?>; }
<?php }
$h4_dark_header_text_hover = wtbx_option_sub('h4-dark-header-text-hover','rgba');
if ($h4_dark_header_text_hover !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-4.header-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-4.header-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h4_dark_header_text_hover); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-4.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-4.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h4_dark_header_text_hover); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header-style-4.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-4.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-4.header-skin-dark .wtbx_hs_header .sidearea_button:hover .line { background-color: <?php echo esc_html($h4_dark_header_text_hover); ?>; }
<?php }
$h4_dark_header_text_active = wtbx_option_sub('h4-dark-header-text-active','rgba');
if ($h4_dark_header_text_active !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_header .header_button_alt > a, .header-style-4.header-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-4.header-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h4_dark_header_text_active); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h4_dark_header_text_active); ?>; }
<?php }
// - topbar
$h4_dark_topbar_bg = wtbx_option_sub('h4-dark-topbar-bg','rgba');
if ($h4_dark_topbar_bg !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_topbar { background-color: <?php echo esc_html($h4_dark_topbar_bg); ?>; }
<?php }
$h4_dark_topbar_text = wtbx_option_sub('h4-dark-topbar-text-color','rgba');
if ($h4_dark_topbar_text !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_topbar .wtbx_header_part, .header-style-4.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color, .header-style-4.header-skin-dark .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($h4_dark_topbar_text); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_topbar .overlay_button .dot, .header-style-4.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:before, .header-style-4.header-skin-dark .wtbx_hs_topbar .overlay_button .dot:after, .header-style-4.header-skin-dark .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($h4_dark_topbar_text); ?>; }
<?php }
$h4_dark_topbar_text_hover = wtbx_option_sub('h4-dark-topbar-text-hover','rgba');
if ($h4_dark_topbar_text_hover !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header-style-4.header-skin-dark .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header-style-4.header-skin-dark .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($h4_dark_topbar_text_hover); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h4_dark_topbar_text_hover); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot, .header-style-4.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:before, .header-style-4.header-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:after, .header-style-4.header-skin-dark .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($h4_dark_topbar_text_hover); ?>; }
<?php }
$h4_dark_topbar_text_active = wtbx_option_sub('h4-dark-topbar-text-active','rgba');
if ($h4_dark_topbar_text_active !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_topbar .header_button_alt > a, .header-style-4.header-skin-dark .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header-style-4.header-skin-dark .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h4_dark_topbar_text_active); ?>; }
<?php }
// - bottombar
$h4_dark_bottombar_bg = wtbx_option_sub('h4-dark-bottombar-bg','rgba');
if ($h4_dark_bottombar_bg !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_bottombar { background-color: <?php echo esc_html($h4_dark_bottombar_bg); ?>; }
<?php }
$h4_dark_bottombar_text = wtbx_option_sub('h4-dark-bottombar-text-color','rgba');
if ($h4_dark_bottombar_text !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_bottombar .wtbx_header_part, .header-style-4.header-skin-dark .wtbx_hs_bottombar .wtbx_h_text_color, .header-style-4.header-skin-dark .wtbx_hs_bottombar .header_widget a { color: <?php echo esc_html($h4_dark_bottombar_text); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_bottombar .overlay_button .dot, .header-style-4.header-skin-dark .wtbx_hs_bottombar .overlay_button .dot:before, .header-style-4.header-skin-dark .wtbx_hs_bottombar .overlay_button .dot:after, .header-style-4.header-skin-dark .wtbx_hs_bottombar .sidearea_button .line { background-color: <?php echo esc_html($h4_dark_bottombar_text); ?>; }
<?php }
$h4_dark_bottombar_text_hover = wtbx_option_sub('h4-dark-bottombar-text-hover','rgba');
if ($h4_dark_bottombar_text_hover !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_bottombar .wtbx_menu_nav > ul > li:hover, .header-style-4.header-skin-dark .wtbx_hs_bottombar .wtbx_h_text_color_hover:hover, .header-style-4.header-skin-dark .wtbx_hs_bottombar .header_widget a:hover { color: <?php echo esc_html($h4_dark_bottombar_text_hover); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_bottombar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h4_dark_bottombar_text_hover); ?>; }
.header-style-4.header-skin-dark .wtbx_hs_bottombar .overlay_button:hover .dot, .header-style-4.header-skin-dark .wtbx_hs_bottombar .overlay_button:hover .dot:before, .header-style-4.header-skin-dark .wtbx_hs_bottombar .overlay_button:hover .dot:after, .header-style-4.header-skin-dark .wtbx_hs_bottombar .sidearea_button:hover .line { background-color: <?php echo esc_html($h4_dark_bottombar_text_hover); ?>; }
<?php }
$h4_dark_bottombar_text_active = wtbx_option_sub('h4-dark-bottombar-text-active','rgba');
if ($h4_dark_bottombar_text_active !== '') { ?>
.header-style-4.header-skin-dark .wtbx_hs_bottombar .header_button_alt > a, .header-style-4.header-skin-dark .wtbx_hs_bottombar .header_cart_wrapper_prim .cart_product_count:before, .header-style-4.header-skin-dark .wtbx_hs_bottombar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h4_dark_bottombar_text_active); ?>; }
<?php } ?>