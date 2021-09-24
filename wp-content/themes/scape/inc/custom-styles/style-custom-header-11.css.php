
/*---------------------------------------------------------------*/
/* Header style 11
/*---------------------------------------------------------------*/
<?php
// general
$h11_header_height = wtbx_option('h11-height');
if ($h11_header_height !== '') { ?>
.header-style-11 .wtbx_hs_header .wtbx_hs_inner, .header-style-11 .wtbx_hs_header .wtbx_ha, .header-style-11 .wtbx_hs_header .wtbx_ha .header_button_height, .header-style-11 .wtbx_header_overlay_space, .header-style-11 .wtbx_hs_header .wtbx_ha .header_button_alt, .header-style-11 .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($h11_header_height); ?>px; line-height: <?php echo esc_html($h11_header_height); ?>px; }
<?php }
$h11_spacing_top = wtbx_option_sub('h11-spacing-top', 'padding-top');
if ($h11_spacing_top !== '') { ?>
.header-style-11 #header-container { padding-top: <?php echo esc_html($h11_spacing_top); ?> }
<?php }
$h11_spacing_side = wtbx_option_sub('h11-spacing-side', 'width');
if ($h11_spacing_side !== '') { ?>
.header-style-11 .wtbx_hs_header .wtbx_hs_inner { margin-left: <?php echo esc_html($h11_spacing_side); ?>; margin-right: <?php echo esc_html($h11_spacing_side); ?>; }
<?php }
$h11_typo = wtbx_option_sub('h11-font', 'typography');
if ($h11_typo !== '') { ?>
.header-style-11 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h11_typo); ?> }
<?php }
$h11_overlay_top_typo = wtbx_option_sub('h11-overlay-top-font', 'typography');
if ($h11_overlay_top_typo !== '') { ?>
.header-style-11 .wtbx_ha_overlay_header { <?php echo wtbx_font_styling_static($h11_overlay_top_typo); ?> }
<?php }
$h11_overlay_middle_typo = wtbx_option_sub('h11-overlay-middle-font', 'typography');
if ($h11_overlay_middle_typo !== '') { ?>
.header-style-11 .wtbx_ha_overlay_main { <?php echo wtbx_font_styling_static($h11_overlay_middle_typo); ?> }
<?php }
$h11_overlay_footer_typo = wtbx_option_sub('h11-overlay-footer-font', 'typography');
if ($h11_overlay_footer_typo !== '') { ?>
.header-style-11 .wtbx_ha_overlay_footer { <?php echo wtbx_font_styling_static($h11_overlay_footer_typo); ?> }
<?php }
$h11_icon = wtbx_option_sub('h11-icon', 'typography');
if ($h11_icon !== '') { ?>
.header-style-11 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h11_icon); ?> }
<?php }

// logo
$h11_logo_width = intval(wtbx_option_sub('h11-logo-size', 'width'));
$h11_logo_height = intval(wtbx_option_sub('h11-logo-size', 'height'));
$h11_logo_margin_top = intval(wtbx_option('h11-logo-offset-top'));
$h11_logo_margin_left = intval(wtbx_option('h11-logo-offset-left'));

$h11_logo_width = $h11_logo_width !== '' ? ' width:'.$h11_logo_width.'px;' : '';
$h11_logo_height = $h11_logo_height !== '' ? ' height:'.$h11_logo_height.'px;' : '';
$h11_logo_margin_top = $h11_logo_margin_top !== '' ? ' margin-top:'.$h11_logo_margin_top.'px;' : '';
$h11_logo_margin_left = $h11_logo_margin_left !== '' ? ' margin-left:'.$h11_logo_margin_left.'px;' : '';

if ($h11_logo_width !== '' || $h11_logo_height !== '' || $h11_logo_margin_top !== '' || $h11_logo_margin_left !== '') { ?>
.header-style-11 .wtbx_header_logo {<?php echo esc_html($h11_logo_width ). $h11_logo_height . $h11_logo_margin_top . $h11_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$h11_light_border = wtbx_option_sub('h11-light-borders-color','rgba');
if ($h11_light_border !== '') { ?>
.header-style-11.header-skin-light .wtbx_hs, .header-style-11.header-skin-light .header_language_trigger:before, .header-style-11.header-skin-light .wtbx_header_login_alt a:before, .header-style-11.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h11_light_border); ?>; }
.header-style-11.header-skin-light .wtbx_hs_header .wtbx_header_border:before { background-color: <?php echo esc_html($h11_light_border); ?>; }
<?php }
// - header
$h11_light_header_bg = wtbx_option_sub('h11-light-header-bg','rgba');
if ($h11_light_header_bg !== '') { ?>
.header-style-11.header-skin-light .wtbx_hs_header:before, .header-style-11.header-skin-light .wtbx_header_overlay_layer { background-color: <?php echo esc_html($h11_light_header_bg); ?>; }
<?php }
$h11_light_header_text = wtbx_option_sub('h11-light-header-text-color','rgba');
if ($h11_light_header_text !== '') { ?>
.header-style-11.header-skin-light .wtbx_hs_header .wtbx_header_part, .header-style-11.header-skin-light .wtbx_hs_header .wtbx_h_text_color, .header-style-11.header-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h11_light_header_text); ?>; }
.header-style-11.header-skin-light .wtbx_hs_header .overlay_button .dot, .header-style-11.header-skin-light .wtbx_hs_header .overlay_button .dot:before, .header-style-11.header-skin-light .wtbx_hs_header .overlay_button .dot:after, .header-style-11.header-skin-light .wtbx_hs_header .sidearea_button .line, .header-style-11.header-skin-light .wtbx_hs_header .wtbx_header_trigger .line { background-color: <?php echo esc_html($h11_light_header_text); ?>; }
<?php }
$h11_light_header_text_hover = wtbx_option_sub('h11-light-header-text-hover','rgba');
if ($h11_light_header_text_hover !== '') { ?>
.header-style-11.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-11.header-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-11.header-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h11_light_header_text_hover); ?>; }
.header-style-11.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-11.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-11.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h11_light_header_text_hover); ?>; }
.header-style-11.header-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header-style-11.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-11.header-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-11.header-skin-light .wtbx_hs_header .sidearea_button:hover .line, .header-style-11.header-skin-light .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h11_light_header_text_hover); ?>; }
<?php }
$h11_light_header_text_active = wtbx_option_sub('h11-light-header-text-active','rgba');
if ($h11_light_header_text_active !== '') { ?>
.header-style-11.header-skin-light .wtbx_hs_header .header_button_alt > a, .header-style-11.header-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before , .header-style-11.header-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h11_light_header_text_active); ?>; }
.header-style-11.header-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h11_light_header_text_active); ?>; }
<?php }

// dark skin colors
// -general
$h11_dark_border = wtbx_option_sub('h11-dark-borders-color','rgba');
if ($h11_dark_border !== '') { ?>
.header-style-11.header-skin-dark .wtbx_hs, .header-style-11.header-skin-dark .header_language_trigger:before, .header-style-11.header-skin-dark .wtbx_header_login_alt a:before, .header-style-11.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h11_dark_border); ?>; }
.header-style-11.header-skin-dark .wtbx_hs_header .wtbx_header_border:before { background-color: <?php echo esc_html($h11_dark_border); ?>; }
<?php }
// - header
$h11_dark_header_bg = wtbx_option_sub('h11-dark-header-bg','rgba');
if ($h11_dark_header_bg !== '') { ?>
.header-style-11.header-skin-dark .wtbx_hs_header:before, .header-style-11.header-skin-dark .wtbx_header_overlay_layer { background-color: <?php echo esc_html($h11_dark_header_bg); ?>; }
<?php }
$h11_dark_header_text = wtbx_option_sub('h11-dark-header-text-color','rgba');
if ($h11_dark_header_text !== '') { ?>
.header-style-11.header-skin-dark .wtbx_hs_header .wtbx_header_part, .header-style-11.header-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header-style-11.header-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($h11_dark_header_text); ?>; }
.header-style-11.header-skin-dark .wtbx_hs_header .overlay_button .dot, .header-style-11.header-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header-style-11.header-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header-style-11.header-skin-dark .wtbx_hs_header .sidearea_button .line, .header-style-11.header-skin-dark .wtbx_hs_header .wtbx_header_trigger .line { background-color: <?php echo esc_html($h11_dark_header_text); ?>; }
<?php }
$h11_dark_header_text_hover = wtbx_option_sub('h11-dark-header-text-hover','rgba');
if ($h11_dark_header_text_hover !== '') { ?>
.header-style-11.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header-style-11.header-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header-style-11.header-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($h11_dark_header_text_hover); ?>; }
.header-style-11.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header-style-11.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-11.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h11_dark_header_text_hover); ?>; }
.header-style-11.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header-style-11.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header-style-11.header-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header-style-11.header-skin-dark .wtbx_hs_header .sidearea_button:hover .line, .header-style-11.header-skin-dark .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h11_dark_header_text_hover); ?>; }
<?php }
$h11_dark_header_text_active = wtbx_option_sub('h11-dark-header-text-active','rgba');
if ($h11_dark_header_text_active !== '') { ?>
.header-style-11.header-skin-dark .wtbx_hs_header .header_button_alt > a, .header-style-11.header-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header-style-11.header-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h11_dark_header_text_active); ?>; }
.header-style-11.header-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h11_dark_header_text_active); ?>; }
<?php }

// overlay layer
$h11_overlay_bg = wtbx_option_sub('h11-overlay-bg','rgba');
if ($h11_overlay_bg !== '') { ?>
.header-style-11.header_active .wtbx_header_overlay_layer { background-color: <?php echo esc_html($h11_overlay_bg); ?>; }
<?php }
$h11_overlay_text = wtbx_option_sub('h11-overlay-text-color','rgba');
if ($h11_overlay_text !== '') { ?>
.header-style-11 .wtbx_header_overlay_layer .wtbx_header_part, .header-style-11 .wtbx_header_overlay_layer .wtbx_h_text_color, .header-style-11 .wtbx_header_overlay_layer .header_widget a { color: <?php echo esc_html($h11_overlay_text); ?>; }
.header-style-11 .wtbx_header_overlay_layer .overlay_button .dot, .header-style-11 .wtbx_header_overlay_layer .overlay_button .dot:before, .header-style-11 .wtbx_header_overlay_layer .overlay_button .dot:after, .header-style-11 .wtbx_header_overlay_layer .sidearea_button .line, .header-style-11.header_active .wtbx_hs_header .wtbx_header_trigger .line, .header-style-11 .wtbx_header_overlay_layer .wtbx_header_border:before { background-color: <?php echo esc_html($h11_overlay_text); ?>; }
<?php }
$h11_overlay_text_hover = wtbx_option_sub('h11-overlay-text-hover','rgba');
if ($h11_overlay_text_hover !== '') { ?>
.header-style-11 .wtbx_header_overlay_layer .wtbx_menu_nav > ul > li:hover, .header-style-11 .wtbx_header_overlay_layer .wtbx_h_text_color_hover:hover, .header-style-11 .wtbx_header_overlay_layer .header_widget a:hover { color: <?php echo esc_html($h11_overlay_text_hover); ?>; }
.header-style-11 .wtbx_header_overlay_layer .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($h11_overlay_text_hover); ?>; }
.header-style-11 .wtbx_header_overlay_layer .overlay_button:hover .dot, .header-style-11 .wtbx_header_overlay_layer .overlay_button:hover .dot:before, .header-style-11 .wtbx_header_overlay_layer .overlay_button:hover .dot:after, .header-style-11 .wtbx_header_overlay_layer .sidearea_button:hover .line, .header-style-11.header_active .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h11_overlay_text_hover); ?>; }
<?php }
$h11_overlay_text_active = wtbx_option_sub('h11-overlay-text-active','rgba');
if ($h11_overlay_text_active !== '') { ?>
.header-style-11 .wtbx_header_overlay_layer .header_button_alt > a, .header-style-11 .wtbx_header_overlay_layer .header_cart_wrapper_prim .cart_product_count:before, .header-style-11 .wtbx_header_overlay_layer .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h11_overlay_text_active); ?>; }
<?php } ?>