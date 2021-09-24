
/*---------------------------------------------------------------*/
/* Header style 7
/*---------------------------------------------------------------*/
<?php
// general
$h7_header_height = wtbx_option('h7-height');
if ($h7_header_height !== '') { ?>
.header-style-7 .wtbx_hs_header .wtbx_hs_inner, .header-style-7 .wtbx_hs_header .wtbx_ha, .header-style-7 .wtbx_hs_header .wtbx_ha .header_button_height, .header-style-7 .wtbx_hs_header .wtbx_ha .header_button_alt, .header-style-7 .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($h7_header_height); ?>px; line-height: <?php echo esc_html($h7_header_height); ?>px; }
<?php }
$h7_spacing_top = wtbx_option_sub('h7-spacing-top', 'padding-top');
if ($h7_spacing_top !== '') { ?>
.header-style-7 #header-container { padding-top: <?php echo esc_html($h7_spacing_top); ?> }
<?php }
$h7_spacing_side = wtbx_option_sub('h7-spacing-side', 'width');
if ($h7_spacing_side !== '') { ?>
.header-style-7 .wtbx_hs .wtbx_hs_inner { margin-left: <?php echo esc_html($h7_spacing_side); ?>; margin-right: <?php echo esc_html($h7_spacing_side); ?>; }
<?php }
$h7_typo = wtbx_option_sub('h7-font', 'typography');
if ($h7_typo !== '') { ?>
.header-style-7 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h7_typo); ?> }
<?php }
$h7_icon = wtbx_option_sub('h7-icon', 'typography');
if ($h7_icon !== '') { ?>
.header-style-7 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h7_icon); ?> }
<?php }

// logo
$h7_logo_width = intval(wtbx_option_sub('h7-logo-size', 'width'));
$h7_logo_height = intval(wtbx_option_sub('h7-logo-size', 'height'));
$h7_logo_margin_top = intval(wtbx_option('h7-logo-offset-top'));
$h7_logo_margin_left = intval(wtbx_option('h7-logo-offset-left'));

$h7_logo_width = $h7_logo_width !== '' ? ' width:'.$h7_logo_width.'px;' : '';
$h7_logo_height = $h7_logo_height !== '' ? ' height:'.$h7_logo_height.'px;' : '';
$h7_logo_margin_top = $h7_logo_margin_top !== '' ? ' margin-top:'.$h7_logo_margin_top.'px;' : '';
$h7_logo_margin_left = $h7_logo_margin_left !== '' ? ' margin-left:'.$h7_logo_margin_left.'px;' : '';

if ($h7_logo_width !== '' || $h7_logo_height !== '' || $h7_logo_margin_top !== '' || $h7_logo_margin_left !== '') { ?>
.header-style-7 .wtbx_header_logo {<?php echo esc_html($h7_logo_width ). $h7_logo_height . $h7_logo_margin_top . $h7_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$h7_light_border = wtbx_option_sub('h7-light-borders-color','rgba');
if ($h7_light_border !== '') { ?>
.header-style-7.header-skin-light .wtbx_hs, .header-style-7.header-skin-light .header_language_trigger:before, .header-style-7.header-skin-light .wtbx_header_login_alt a:before, .header-style-7.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h7_light_border); ?>; }
.header-style-7.header-skin-light .wtbx_header_border:before { background-color: <?php echo esc_html($h7_light_border); ?>; }
<?php }
// - header
$h7_light_header_bg = wtbx_option_sub('h7-light-header-bg','rgba');
if ($h7_light_header_bg !== '') { ?>
.header-style-7.header-skin-light .wtbx_hs_header:before { background-color: <?php echo esc_html($h7_light_header_bg); ?>; }
<?php }
$h7_light_header_text = wtbx_option_sub('h7-light-header-text-color','rgba');
if ($h7_light_header_text !== '') { ?>
.header-style-7.header-skin-light .wtbx_hs_header .wtbx_header_part, .header-style-7.header-skin-light .wtbx_hs_header .wtbx_h_text_color, .header-style-7.header-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h7_light_header_text); ?>; }
.header-style-7.header-skin-light .wtbx_hs_header .overlay_button .dot, .header-style-7.header-skin-light .wtbx_hs_header .overlay_button .dot:before, .header-style-7.header-skin-light .wtbx_hs_header .overlay_button .dot:after, .header-style-7.header-skin-light .wtbx_hs_header .sidearea_button .line, .header-style-7.header-skin-light .wtbx_hs_header .wtbx_header_trigger .line { background-color: <?php echo esc_html($h7_light_header_text); ?>; }
<?php }
$h7_light_header_text_hover = wtbx_option_sub('h7-light-header-text-hover','rgba');
if ($h7_light_header_text_hover !== '') { ?>
.header-style-7.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-7.header-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-7.header-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h7_light_header_text_hover); ?>; }
.header-style-7.header-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header-style-7.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-7.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-7.header-skin-light .wtbx_hs_header .sidearea_button:hover .line, .header-style-7.header-skin-light .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h7_light_header_text_hover); ?>; }
<?php }
$h7_light_header_text_active = wtbx_option_sub('h7-light-header-text-active','rgba');
if ($h7_light_header_text_active !== '') { ?>
.header-style-7.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-7.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-7.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h7_light_header_text_active); ?>; }
.header-style-7.header-skin-light .wtbx_hs_header .header_button_alt > a, .header-style-7.header-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-7.header-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h7_light_header_text_active); ?>; }
.header-style-7.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h7_light_header_text_active); ?>; }
<?php }
// - visible area
$h7_light_visible_text = wtbx_option_sub('h7-light-visible-text-color','rgba');
if ($h7_light_visible_text !== '') { ?>
.header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_part, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_widget a { color: <?php echo esc_html($h7_light_visible_text); ?>; }
.header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:before, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:after, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button .line, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger .line { background-color: <?php echo esc_html($h7_light_visible_text); ?>; }
<?php }
$h7_light_visible_text_hover = wtbx_option_sub('h7-light-visible-text-hover','rgba');
if ($h7_light_visible_text_hover !== '') { ?>
.header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li:hover, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color_hover:hover, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_widget a:hover { color: <?php echo esc_html($h7_light_visible_text_hover); ?>; }
.header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h7_light_visible_text_hover); ?>; }
.header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:before, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:after, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button:hover .line, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h7_light_visible_text_hover); ?>; }
<?php }
$h7_light_visible_text_active = wtbx_option_sub('h7-light-visible-text-active','rgba');
if ($h7_light_visible_text_active !== '') { ?>
.header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_button_alt > a, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_cart_wrapper_prim .cart_product_count:before, .header-style-7.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h7_light_visible_text_active); ?>; }
<?php }

// dark skin colors
// -general
$h7_dark_border = wtbx_option_sub('h7-dark-borders-color','rgba');
if ($h7_dark_border !== '') { ?>
.header-style-7.header-skin-dark .wtbx_hs, .header-style-7.header-skin-dark .header_language_trigger:before, .header-style-7.header-skin-dark .wtbx_header_login_alt a:before, .header-style-7.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h7_dark_border); ?>; }
.header-style-7.header-skin-dark .wtbx_header_border:before { background-color: <?php echo esc_html($h7_dark_border); ?>; }
<?php }
// - header
$h7_dark_header_bg = wtbx_option_sub('h7-dark-header-bg','rgba');
if ($h7_dark_header_bg !== '') { ?>
.header-style-7.header-skin-dark .wtbx_hs_header:before { background-color: <?php echo esc_html($h7_dark_header_bg); ?>; }
<?php }
$h7_dark_header_text = wtbx_option_sub('h7-dark-header-text-color','rgba');
if ($h7_dark_header_text !== '') { ?>
.header-style-7.header-skin-dark .wtbx_hs_header .wtbx_header_part, .header-style-7.header-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header-style-7.header-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h7_dark_header_text); ?>; }
.header-style-7.header-skin-dark .wtbx_hs_header .overlay_button .dot, .header-style-7.header-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header-style-7.header-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header-style-7.header-skin-dark .wtbx_hs_header .sidearea_button .line, .header-style-7.header-skin-dark .wtbx_hs_header .wtbx_header_trigger .line { background-color: <?php echo esc_html($h7_dark_header_text); ?>; }
<?php }
$h7_dark_header_text_hover = wtbx_option_sub('h7-dark-header-text-hover','rgba');
if ($h7_dark_header_text_hover !== '') { ?>
.header-style-7.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-7.header-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-7.header-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h7_dark_header_text_hover); ?>; }
.header-style-7.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-7.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-7.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h7_dark_header_text_hover); ?>; }
.header-style-7.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header-style-7.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-7.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-7.header-skin-dark .wtbx_hs_header .sidearea_button:hover .line, .header-style-7.header-skin-dark .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h7_dark_header_text_hover); ?>; }
<?php }
$h7_dark_header_text_active = wtbx_option_sub('h7-dark-header-text-active','rgba');
if ($h7_dark_header_text_active !== '') { ?>
.header-style-7.header-skin-dark .wtbx_hs_header .header_button_alt > a, .header-style-7.header-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-7.header-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h7_dark_header_text_active); ?>; }
.header-style-7.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h7_dark_header_text_active); ?>; }
<?php }
// - visible area
$h7_dark_visible_text = wtbx_option_sub('h7-dark-visible-text-color','rgba');
if ($h7_dark_visible_text !== '') { ?>
.header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_part, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_widget a { color: <?php echo esc_html($h7_dark_visible_text); ?>; }
.header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:before, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:after, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button .line, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger .line { background-color: <?php echo esc_html($h7_dark_visible_text); ?>; }
<?php }
$h7_dark_visible_text_hover = wtbx_option_sub('h7-dark-visible-text-hover','rgba');
if ($h7_dark_visible_text_hover !== '') { ?>
.header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li:hover, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color_hover:hover, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_widget a:hover { color: <?php echo esc_html($h7_dark_visible_text_hover); ?>; }
.header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h7_dark_visible_text_hover); ?>; }
.header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:before, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:after, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button:hover .line, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h7_dark_visible_text_hover); ?>; }
<?php }
$h7_dark_visible_text_active = wtbx_option_sub('h7-dark-visible-text-active','rgba');
if ($h7_dark_visible_text_active !== '') { ?>
.header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_button_alt > a, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_cart_wrapper_prim .cart_product_count:before, .header-style-7.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h7_dark_visible_text_active); ?>; }
<?php } ?>