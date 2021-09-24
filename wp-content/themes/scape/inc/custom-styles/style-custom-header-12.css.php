
/*---------------------------------------------------------------*/
/* Header style 12
/*---------------------------------------------------------------*/
<?php
// general
$h12_header_width = wtbx_option('h12-width');
if ($h12_header_width !== '') { ?>
#site-header #header-wrapper.header-style-12 { width: <?php echo esc_html($h12_header_width); ?>px; }
.header-layout-12 + #main, .header-layout-12 + #main.wtbx-footer-under #footer { padding-left: <?php echo esc_html($h12_header_width); ?>px; }
<?php }
$h12_top_typo = wtbx_option_sub('h12-top-font', 'typography');
if ($h12_top_typo !== '') { ?>
.header-style-12 .wtbx_hs_header { <?php echo wtbx_font_styling_static($h12_top_typo); ?> }
<?php }
$h12_main_typo = wtbx_option_sub('h12-main-font', 'typography');
if ($h12_main_typo !== '') { ?>
.header-style-12 .wtbx_hs_main { <?php echo wtbx_font_styling_static($h12_main_typo); ?> }
<?php }
$h12_footer_typo = wtbx_option_sub('h12-footer-font', 'typography');
if ($h12_footer_typo !== '') { ?>
.header-style-12 .wtbx_hs_footer { <?php echo wtbx_font_styling_static($h12_footer_typo); ?> }
<?php }
$h12_icon = wtbx_option_sub('h12-icon', 'typography');
if ($h12_icon !== '') { ?>
.header-style-12 .wtbx_hs_header .menu-item i { <?php echo wtbx_font_styling_static($h12_icon); ?> }
<?php }

// logo
$h12_logo_width = intval(wtbx_option_sub('h12-logo-size', 'width'));
$h12_logo_height = intval(wtbx_option_sub('h12-logo-size', 'height'));
$h12_logo_margin_top = intval(wtbx_option('h12-logo-offset-top'));
$h12_logo_margin_left = intval(wtbx_option('h12-logo-offset-left'));

$h12_logo_width = $h12_logo_width !== '' ? ' width:'.$h12_logo_width.'px;' : '';
$h12_logo_height = $h12_logo_height !== '' ? ' height:'.$h12_logo_height.'px;' : '';
$h12_logo_margin_top = $h12_logo_margin_top !== '' ? ' margin-top:'.$h12_logo_margin_top.'px;' : '';
$h12_logo_margin_left = $h12_logo_margin_left !== '' ? ' margin-left:'.$h12_logo_margin_left.'px;' : '';

if ($h12_logo_width !== '' || $h12_logo_height !== '' || $h12_logo_margin_top !== '' || $h12_logo_margin_left !== '') { ?>
.header-style-12 .wtbx_header_logo {<?php echo esc_html($h12_logo_width ). $h12_logo_height . $h12_logo_margin_top . $h12_logo_margin_left; ?>}
<?php }

// light skin colors
// - header
$h12_light_header_bg = wtbx_option_sub('h12-light-header-bg','rgba');
if ($h12_light_header_bg !== '') { ?>
.header-style-12.header-skin-light { background-color: <?php echo esc_html($h12_light_header_bg); ?>; }
<?php }
$h12_light_border = wtbx_option_sub('h12-light-borders-color','rgba');
if ($h12_light_border !== '') { ?>
.header-style-12.header-skin-light .header_language_trigger:before, .header-style-12.header-skin-light .wtbx_header_login_alt a:before, .header-style-12.header-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h12_light_border); ?>; }
.header-style-12.header-skin-light .wtbx_header_border { background-color: <?php echo esc_html($h12_light_border); ?>; }
<?php }
$h12_light_header_text = wtbx_option_sub('h12-light-header-text-color','rgba');
if ($h12_light_header_text !== '') { ?>
.header-style-12.header-skin-light .wtbx_header_part, .header-style-12.header-skin-light .wtbx_h_text_color, .header-style-12.header-skin-light .header_widget a { color: <?php echo esc_html($h12_light_header_text); ?>; }
.header-style-12.header-skin-light .overlay_button .dot, .header-style-12.header-skin-light .overlay_button .dot:before, .header-style-12.header-skin-light .overlay_button .dot:after, .header-style-12.header-skin-light .sidearea_button .line { background-color: <?php echo esc_html($h12_light_header_text); ?>; }
<?php }
$h12_light_header_text_hover = wtbx_option_sub('h12-light-header-text-hover','rgba');
if ($h12_light_header_text_hover !== '') { ?>
.header-style-12.header-skin-light .wtbx_menu_nav > ul > li:hover, .header-style-12.header-skin-light .wtbx_h_text_color_hover:hover, .header-style-12.header-skin-light .header_widget a:hover { color: <?php echo esc_html($h12_light_header_text_hover); ?>; }
.header-style-12.header-skin-light .wtbx_menu_nav > ul > li.current-menu-item, .header-style-12.header-skin-light .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-12.header-skin-light .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h12_light_header_text_hover); ?>; }
.header-style-12.header-skin-light .overlay_button:hover .dot, .header-style-12.header-skin-light .overlay_button:hover .dot:before, .header-style-12.header-skin-light .overlay_button:hover .dot:after, .header-style-12.header-skin-light .sidearea_button:hover .line { background-color: <?php echo esc_html($h12_light_header_text_hover); ?>; }
<?php }
$h12_light_header_text_active = wtbx_option_sub('h12-light-header-text-active','rgba');
if ($h12_light_header_text_active !== '') { ?>
.header-style-12.header-skin-light .header_button_alt > a, .header-style-12.header-skin-light .header_cart_wrapper_prim .cart_product_count:before, .header-style-12.header-skin-light .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h12_light_header_text_active); ?>; }
.header-style-12.header-skin-light .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h12_light_header_text_active); ?>; }
<?php }

// dark skin colors
// - header
$h12_dark_header_bg = wtbx_option_sub('h12-dark-header-bg','rgba');
if ($h12_dark_header_bg !== '') { ?>
.header-style-12.header-skin-dark { background-color: <?php echo esc_html($h12_dark_header_bg); ?>; }
<?php }
$h12_dark_border = wtbx_option_sub('h12-dark-borders-color','rgba');
if ($h12_dark_border !== '') { ?>
.header-style-12.header-skin-dark .header_language_trigger:before, .header-style-12.header-skin-dark .wtbx_header_login_alt a:before, .header-style-12.header-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($h12_dark_border); ?>; }
.header-style-12.header-skin-dark .wtbx_header_border { background-color: <?php echo esc_html($h12_dark_border); ?>; }
<?php }
$h12_dark_header_text = wtbx_option_sub('h12-dark-header-text-color','rgba');
if ($h12_dark_header_text !== '') { ?>
.header-style-12.header-skin-dark .wtbx_header_part, .header-style-12.header-skin-dark .wtbx_h_text_color, .header-style-12.header-skin-dark .header_widget a { color: <?php echo esc_html($h12_dark_header_text); ?>; }
.header-style-12.header-skin-dark .overlay_button .dot, .header-style-12.header-skin-dark .overlay_button .dot:before, .header-style-12.header-skin-dark .overlay_button .dot:after, .header-style-12.header-skin-dark .sidearea_button .line { background-color: <?php echo esc_html($h12_dark_header_text); ?>; }
<?php }
$h12_dark_header_text_hover = wtbx_option_sub('h12-dark-header-text-hover','rgba');
if ($h12_dark_header_text_hover !== '') { ?>
.header-style-12.header-skin-dark .wtbx_menu_nav > ul > li:hover, .header-style-12.header-skin-dark .wtbx_h_text_color_hover:hover, .header-style-12.header-skin-dark .header_widget a:hover { color: <?php echo esc_html($h12_dark_header_text_hover); ?>; }
.header-style-12.header-skin-dark .wtbx_menu_nav > ul > li.current-menu-item, .header-style-12.header-skin-dark .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-style-12.header-skin-dark .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($h12_dark_header_text_hover); ?>; }
.header-style-12.header-skin-dark .overlay_button:hover .dot, .header-style-12.header-skin-dark .overlay_button:hover .dot:before, .header-style-12.header-skin-dark .overlay_button:hover .dot:after, .header-style-12.header-skin-dark .sidearea_button:hover .line { background-color: <?php echo esc_html($h12_dark_header_text_hover); ?>; }
<?php }
$h12_dark_header_text_active = wtbx_option_sub('h12-dark-header-text-active','rgba');
if ($h12_dark_header_text_active !== '') { ?>
.header-style-12.header-skin-dark .header_button_alt > a, .header-style-12.header-skin-dark .header_cart_wrapper_prim .cart_product_count:before, .header-style-12.header-skin-dark .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h12_dark_header_text_active); ?>; }
.header-style-12.header-skin-dark .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($h12_dark_header_text_active); ?>; }
<?php } ?>