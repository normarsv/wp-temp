/*---------------------------------------------------------------*/
/* Typography
/*---------------------------------------------------------------*/
<?php
$typo_general = wtbx_font_styling_static('typo-general', false);
if ( $typo_general !== '' ) { ?>
body, [data-tooltip]:after, .wtbx_gm_container .gm-style .gm-style-iw, .wtbx-pagination.paged-post-nav,
input[type="text"], input[type="password"],	input[type="datetime"],	input[type="datetime-local"],
input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"],
input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"],
input[type="url"], input[type="range"], input[type="date"], select, textarea, .field,
.select2-container .select2-choice, .select2-container .select2-selection,
.header_cart_widget, .widget_shopping_cart_content .empty, .wtbx_header_widget_area, #wtbx_login_modal, .actions-coupon, .wtbx-gdpr-noconsent-inner, .header_language_dropdown {<?php echo wp_kses_post($typo_general);?>}
<?php }

$base_font_size = wtbx_font_size('typo-general');
if ( $base_font_size !== '' ) { ?>
	form p, form button, form input[type="submit"].wtbx-button.wtbx-button-primary, form input[type="submit"].wtbx-button.wtbx-button-secondary, form button[type="submit"].wtbx-button.wtbx-button-primary, form button[type="submit"].wtbx-button.wtbx-button-secondary, form input[type="submit"], form button[type="submit"], .more-link, .wtbx_dropdown_option {font-size:<?php echo esc_html($base_font_size * 0.928571); ?>px}
<?php }

$typo_h = wtbx_font_styling_static('typo-h', false);
if ( $typo_h !== '' ) { ?>
	h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {<?php echo wp_kses_post($typo_h);?> }
<?php }

$typo_h1 = wtbx_font_styling_static('typo-h1', false);
if ( $typo_h1 !== '' ) { ?>
	h1, .h1 {<?php echo wp_kses_post($typo_h1);?> }
<?php }

$typo_h2 = wtbx_font_styling_static('typo-h2', false);
if ( $typo_h2 !== '' ) { ?>
	h2, .h2 {<?php echo wp_kses_post($typo_h2);?> }
<?php }

$typo_h3 = wtbx_font_styling_static('typo-h3', false);
if ( $typo_h3 !== '' ) { ?>
	h3, .h3 {<?php echo wp_kses_post($typo_h3);?> }
<?php }

$typo_h4 = wtbx_font_styling_static('typo-h4', false);
if ( $typo_h4 !== '' ) { ?>
	h4, .h4 {<?php echo wp_kses_post($typo_h4);?> }
<?php }

$typo_h5 = wtbx_font_styling_static('typo-h5', false);
if ( $typo_h5 !== '' ) { ?>
	h5, .h5 {<?php echo wp_kses_post($typo_h5);?> }
<?php }

$typo_h6 = wtbx_font_styling_static('typo-h6', false);
if ( $typo_h6 !== '' ) { ?>
	h6, .h6 {<?php echo wp_kses_post($typo_h6);?> }
<?php }
?>

/*---------------------------------------------------------------*/
/* Layout
/*---------------------------------------------------------------*/
<?php
// website width
?>
.wtbx_vc_row:not(.wtbx_stretch_row):not(.wtbx_stretch_row_content),
.wtbx_vc_inner_row:not(.wtbx_stretch_row):not(.wtbx_stretch_row_content),
.wtbx_row_content, .wtbx_inner_row_content, .row-inner,
.header-contained .wtbx_hs_inner, .header-boxed,
.header-contained .wtbx_header_overlay_inner, .header-boxed .wtbx_header_overlay_inner,
.header-style-10.header-boxed .wtbx_hs_header, .header-style-11.header-boxed .wtbx_hs_header, ul.sub-menu-full-width,
#container .woocommerce:not(.widget), body.has-blocks #page-wrap #container,
body.wtbx-def-page:not(.compose-mode) #container.row-inner {
	max-width: <?php echo esc_html(intval(wtbx_option('site-width', 1200))); ?>px;
}

/*---------------------------------------------------------------*/
/* Colors
/*---------------------------------------------------------------*/
<?php

// light bg color
$color_bg_light = wtbx_option('color-main-bg-light');
if ($color_bg_light !== '') { ?>
.cf-flat input[type="text"],
.cf-flat input[type="password"],
.cf-flat input[type="datetime"],
.cf-flat input[type="datetime-local"],
.cf-flat input[type="date"],
.cf-flat input[type="month"],
.cf-flat input[type="time"],
.cf-flat input[type="week"],
.cf-flat input[type="number"],
.cf-flat input[type="email"],
.cf-flat input[type="url"],
.cf-flat input[type="search"],
.cf-flat input[type="tel"],
.cf-flat input[type="color"],
.cf-flat input[type="url"],
.cf-flat input[type="range"],
.cf-flat input[type="date"],
.cf-flat select,
.cf-flat textarea,
.cf-flat .field,
.cf-flat .select2-container .select2-choice,
.field,
.select2-container .select2-choice,
.cf-subscribe-modern input, .cf-subscribe-modern input:focus, .cf-subscribe-modern input:active,
select[multiple] option:hover,
table thead th,
.wtbx-image-placeholder,
.wtbx-social-inner form input, .wtbx-social-inner form input:focus, .wtbx-social-inner form input:active,
.audioplayer .audioplayer-bar:before,
.audioplayer-volume-adjust > div:before,
.container-single-product .tagged_as a,
#payment .wc_payment_method .payment_box,
.select2-drop .select2-result.select2-highlighted,
.woocommerce-info, .woocommerce-message, .order-info,
.woocommerce .addresses .address .title,
.wtbx-related-posts,
.wtbx_social_widget.wtbx_style_3 a,
.wtbx-nav-back:before,
.tag-links span a:hover, .container-single-product .tagged_as a:hover,
.tagcloud a:hover,
.portfolio-slider-button:before,
#comments .bypostauthor .comment-body,
.wtbx_vc_list_item.wtbx_bullet_text .wtbx_vc_list_item_bullet_text,
.wtbx_vc_list_item.wtbx_style_3 .wtbx_vc_list_item_inner,
.wtbx_vc_accordion.wtbx_style_2.wtbx_skin_light .wtbx_accordion_link,
.wtbx_vc_accordion.wtbx_style_3 .wtbx_vc_accordion_tab.active .wtbx_accordion_link,
.wtbx_vc_testimonial.wtbx_style_2.wtbx_skin_light .wtbx_testimonial_content,
.wtbx_vc_testimonial.wtbx_style_3.wtbx_skin_light .wtbx_testimonial_content,
.wtbx_vc_testimonial.wtbx_style_3.wtbx_skin_light .wtbx_testimonial_credentials:before, .wtbx_vc_testimonial.wtbx_style_3.wtbx_skin_light .wtbx_testimonial_credentials:after,
.wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_skin_light .wtbx_testimonial_content,
.wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_skin_light .wtbx_testimonial_credentials:before, .wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_skin_light .wtbx_testimonial_credentials:after,
.wtbx_vc_tour.wtbx_style_2.wtbx_skin_light .wtbx_tabs_nav_link:hover,
.wtbx-filter.filter-multi.wtbx-scheme-default .wtbx-filter-button:before,
.wtbx-filter.filter-slider.wtbx-scheme-default .knob,
.header_language_dropdown a:hover,
.wtbx_dropdown_option:hover,
#wp-calendar th,
.wtbx-orderby, .wtbx_with_custom_dropdown,
.wtbx-quantity,
.woocommerce-password-hint,
.shop_table.my_account_orders th, .shop_table.woocommerce-table--order-downloads th,
.wtbx-cart .actions, .checkout_coupon,
.woocommerce-MyAccount-navigation li,
.woocommerce-error li,
.container-single-product .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
.header_cart_widget .total, .header_cart_widget .buttons,
.widget_layered_nav .wc-layered-nav-term span, .widget_product_categories .cat-item span,
.category-product-count,
.wtbx_vc_message.wtbx_style_border .wtbx_message_wrapper,
.wtbx-search-page-count,
.wtbx-pagination.wtbx-skin-light .page-numbers:after,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-mobile-menu button,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-mobile-menu button,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-mobile-menu button,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-content .gdpr-tabs,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-content .gdpr-tabs,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-content .gdpr-tabs,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-mobile-menu,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-mobile-menu,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-mobile-menu,
.wp-block-table.is-style-stripes tr:nth-child(odd) {
	background-color: <?php echo esc_html($color_bg_light); ?>;
}
.wtbx_vc_testimonial.wtbx_style_2.wtbx_skin_light .wtbx_testimonial_content:before,
.wtbx_vc_testimonial.wtbx_style_3.wtbx_skin_light .wtbx_testimonial_photo,
.wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_skin_light .wtbx_testimonial_photo {
	border-color: <?php echo esc_html($color_bg_light); ?>;
}
<?php }

// default text color
$color_text_def = wtbx_option('color-main-text-color');
if ($color_text_def !== '') { ?>
body,
input[type="radio"] ~ label,
.cf-minimal .wpcf7-form p,
.cf-minimal .wpcf7-form label,
.wtbx-page-breadcrumbs .breadcrumbs-path, .wtbx-page-breadcrumbs .breadcrumbs-path a,
.wtbx-tooltip,
.wtbx-social-container form input,
.wtbx_social_widget.wtbx_style_3 a,
.wtbx-pagination.wtbx-skin-light a,
.wtbx-pagination.wtbx-skin-light .page-prev a:before, .wtbx-pagination.wtbx-skin-light .page-next a:before,
.header_cart_widget,
.container-single-product .item-value, .container-single-product .item-field a,
.wtbx-product-entry .price del, .wtbx-product-entry .price del span,
.wtbx-product-preview .entry-summary .price del,
.container-single-product .price del,
.wtbx-cart .product-name dl,
.wtbx-cart .product-name .item-value, .wtbx-cart .product-name .item-label,
.cart_totals .shipping td,
.wtbx-checkout #order_review .shop_table tbody,
.shop_table.customer_details td,
.shop_table tbody,
.shop_table .variation,
.wtbx-carousel-arrows a:not(:hover),
.wtbx_vc_list_item_content,
.wtbx_vc_tabs.wtbx_skin_light .wtbx_tabs_nav_link,
.wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_link,
.wtbx_vc_tab .wtbx_tab_mobile_link,
.wtbx_vc_accordion.wtbx_skin_light .wtbx_accordion_link,
.wtbx_vc_pricing_box.wtbx_style_2 .wtbx_pricing_box_period,
.wtbx_step_content,
.header_language_dropdown a,
.header_cart_widget .quantity, .header_cart_widget .total, .header_cart_widget .total .amount,
.widget_shopping_cart .quantity, .widget_shopping_cart .total, .widget_shopping_cart .total .amount,
.wtbx-product-inner .wtbx-product-description,
.search-results article .meta-date,
.wtbx-search-page-label,
.woocommerce-MyAccount-navigation a,
.gdpr.gdpr-privacy-bar .gdpr-wrapper .gdpr-right .gdpr-buttons button.gdpr-preferences, .gdpr.gdpr-reconsent-bar .gdpr-wrapper .gdpr-right .gdpr-buttons button.gdpr-preferences,
.gdpr .gdpr-cookie-categories-item {
	color: <?php echo esc_html($color_text_def); ?>;
}
.wtbx_vc_message .wtbx_message_button:before, .wtbx_vc_message .wtbx_message_button:after,
.wtbx-product-inner .product-actions-trigger span,
.wtbx-page-breadcrumbs .wtbx-separator-circle:before {
	background-color: <?php echo esc_html($color_text_def); ?>;
}
.wtbx_vc_message .wtbx_message_button,
.wtbx-page-breadcrumbs .wtbx-separator-angle:before {
	border-color: <?php echo esc_html($color_text_def); ?>;
}
.gdpr .gdpr-tabs li button,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-content .gdpr-policies li a,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-content .gdpr-policies li a,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-content .gdpr-policies li a,
.gdpr .gdpr-wrapper .gdpr-mobile-menu button,
.gdpr .gdpr-wrapper .gdpr-mobile-menu button,
.gdpr .gdpr-wrapper .gdpr-mobile-menu button,
.gdpr .gdpr-wrapper footer span a {
	color: <?php echo esc_html($color_text_def); ?> !important;
}

<?php }

// dark text color
$color_text_dark = wtbx_option('color-main-text-dark');
if ($color_text_dark !== '') { ?>
form label,
h1,h2,h3,h4,h5,h6,
blockquote p,
.wp-caption figcaption,
.entry-title a,
input, select, textarea, .field,
select[multiple] option:hover,
.wpcf7-form p,
.mc-minimal .mc4wp-form input[type="submit"]:hover, .mc-minimal .mc4wp-form button[type="submit"]:hover,
.header_cart_widget li.empty,
.wp-block-latest-comments__comment-meta, .wp-block-latest-comments__comment-meta a:not(:hover),
.wp-block-latest-posts a:not(:hover),
.wp-block-categories a:not(:hover),
.post-masonry-comments:hover,
.wtbx-masonry-entry .post-like span,
.wtbx-masonry-entry .post-like i,
.post-sbs-inner .meta-author-link a,
.post-social-link:hover span,
.post-boxed-button i,
.wtbx_recent_comments .comment-meta,
.wtbx-grid-column .more-link:hover,
.post-minimal-inner .wtbx-like-button i,
.portfolio-tiles-button i,
.portfolio-overlap .portfolio-entry-meta *,
.wtbx_overlap.wtbx_meta_skin_dark article.portfolio-entry .portfolio-overlap-button,
.wtbx-default-entry .side-meta,
.portfolio-panels-meta .portfolio-meta-primary,
.portfolio-panels-meta .portfolio-meta-secondary,
.portfolio-panels .portfolio-panels-excerpt,
.portfolio-panels-counter,
.portfolio-panels-button,
.portfolio-slider-meta .portfolio-meta-primary,
.portfolio-slider-meta .portfolio-meta-secondary,
.portfolio-slider .portfolio-slider-excerpt,
.portfolio-slider-link,
.portfolio-slider-button,
.portfolio-overlap-excerpt,
.portfolio-entry .portfolio-overlay-buttons .portfolio-overlay-buttons-inner a:hover,
.portfolio-entry .portfolio-overlay-meta_boxed .portfolio-meta-primary,
.portfolio-entry .portfolio-overlay-meta_boxed .portfolio-meta-secondary,
.wtbx-like-label,
.wtbx-like-wrapper .wtbx-like-button:hover i,
.wtbx-like-wrapper .wtbx-like-button:hover span,
.meta-categories .category-list a:hover,
.wtbx-grid-magazine article.post-entry .post-magazine-inner .meta-categories .category-list a:hover,
.post-boxed-inner .post-entry-footer a:hover,
.author-contact-link:hover i,
.widget_media_video .mejs-overlay-button:before,
.entry-title, .meta-author-link:not(:hover), .category-list, .category-list a, .meta-date:not(:hover),
.post-social-title,
.wtbx-loadmore,
.tag-links span a:hover, .container-single-product .tagged_as a:hover,
.widget .tagcloud a:hover,
.wtbx_social_widget.wtbx_style_1 a:hover i,
.author-name,
#comments label, #comments .author-name a,
.author-posts,
.post-like-button span,
.wtbx-like a:hover,
.more-link,
.wtbx-related-posts .meta-categories a:hover,
.post-sbs-meta .post-like a:hover i, .post-sbs-meta .post-like a:hover span, .post-sbs-meta .post-sbs-comments:hover,
#page-header .page-header-inner.page-header-post.page-header-post-custom_1 .hero-meta-categories a:hover,
.audioplayer:not(.audioplayer-muted) .audioplayer-volume-button > a:before,
.portfolio-item-details,
.portfolio-content-wrapper .close,
.portfolio-content-trigger .expand,
.portfolio-boxed-content .portfolio-title, .portfolio-boxed-content .portfolio-categories,
.item-fields .item-label,
.container-single-product .price,
.container-single-product .variations .label,
.container-single-product .stock,
.wtbx-product-entry .price ins,
.wtbx-quantity,
.product-tabs li a,
.shop_attributes th,
.shop_table .shipping td .shipping-calculator-button,
#reviews #comments [itemprop="author"],
.woocommerce-breadcrumb a,
.wtbx-option:hover,
.wtbx-product-actions .wtbx-option-single i,
.wishlist-label, .cart-label, .added-to-cart:after,
.wtbx-product-entry .not-added-to-cart, .wtbx-product-entry .added_to_cart:after,
.add_to_wishlist,
.yith-wcwl-add-to-wishlist,
.wtbx-cart thead,
.wtbx-cart .product-name a, .wtbx-cart .product-subtotal, .wtbx-cart .cart_item,
.shop_table,
.product_subtitle,
.wishlist_table tr td.product-stock-status span.wishlist-in-stock,
.comment-navigation a,
#payment .wc_payment_methods label,
.select2-drop .select2-results .select2-highlighted,
.shop_table .order-total,
.shop_table.my_account_orders .order-number a,
.shop_table.customer_details th,
.shop_table.woocommerce-table--order-downloads .download-file a,
.woocommerce-error a, .woocommerce-info a,
.comment.note,
.woocommerce-grouped-product-list-item__price, .woocommerce-grouped-product-list-item__label a,
legend,
.product-content-wrapper .wtbx-share:hover,
.woocommerce-MyAccount-navigation a:hover, .woocommerce-MyAccount-navigation li.is-active a,
.wtbx_vc_list_item.wtbx_bullet_text .wtbx_vc_list_item_bullet_text,
.wtbx_vc_list_item .wtbx_vc_icon,
.wtbx_exp_list_title,
.wtbx_service_title,
.wtbx_heading_el_title,
.wtbx_vc_styled_heading.wtbx_style_overlapping .wtbx_heading_el_title,
.wtbx_vc_tabs.wtbx_skin_light .wtbx_tabs_nav_item:hover .wtbx_tabs_nav_link, .wtbx_vc_tabs.wtbx_skin_light .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tabs.wtbx_style_3.wtbx_scheme_default .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tabs.wtbx_style_4.wtbx_skin_dark.wtbx_scheme_default .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_item:hover .wtbx_tabs_nav_link, .wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tour.wtbx_style_3.wtbx_scheme_default .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link, .wtbx_vc_tour.wtbx_style_3 .wtbx_tabs_nav .wtbx_tabs_nav_item:hover .wtbx_tabs_nav_link,
.wtbx_vc_tab .wtbx_tab_mobile_link:hover,
.wtbx_vc_accordion.wtbx_skin_light .wtbx_accordion_link:hover,
.wtbx_vc_testimonial .wtbx_testimonial_author_name,
.wtbx_vc_rating .wtbx_rating_author_name,
.wtbx_vc_rating .wtbx_rating_reason,
.wtbx_vc_team_member .wtbx_team_member_name, .wtbx_vc_team_member.wtbx_style_1 .wtbx_team_member_social a,
.wtbx_vc_team_member.wtbx_style_4 .wtbx_team_member_social a:hover,
.wtbx_vc_pricing_box .wtbx_pricing_box_title,
.wtbx_vc_pricing_box .wtbx_pricing_box_period,
.wtbx_vc_pricing_box .wtbx_pricing_box_price, .wtbx_vc_pricing_box .wtbx_pricing_box_currency,
.wtbx_dots_style_3.wtbx_nav_skin_light .wtbx_pagination_numbers,
.wtbx_vc_testimonial_slide .wtbx_testimonial_author_name,
.wtbx_vc_team_table .wtbx_team_table_title, .wtbx_vc_team_table .wtbx_team_member_name,
.wtbx_vc_image_element.wtbx_icon_skin_dark .wtbx_image_icon,
.wtbx_vc_image_caption.wtbx_style_1.wtbx_skin_dark .wtbx_image_caption_content, .wtbx_vc_image_caption.wtbx_style_2.wtbx_skin_dark .wtbx_image_caption_content,
.wtbx-filter.wtbx-scheme-default .wtbx-filter-button.active, .wtbx-filter.wtbx-scheme-default .wtbx-filter-button:hover,
.wtbx-filter.filter-multi.wtbx-scheme-default .wtbx-filter-button:hover:after,
.wtbx-filter.filter-sidebar.wtbx-scheme-colorful .wtbx-filter-button,
.portfolio-entry-meta,
.wtbx_login_modal_close,
.wtbx-demo-button:hover {
	color: <?php echo esc_html($color_text_dark); ?>;
}
.wtbx_vc_button.wtbx_style_arrow .wtbx_button_inner,
.wtbx_vc_video_button.wtbx_skin_light .wtbx_video_button_h,
.wtbx_vc_video_button.wtbx_style_2.wtbx_skin_light i,
.wtbx_vc_countdown .wtbx_countdown_block span, .wtbx_vc_countdown.wtbx_style_3 .wtbx_countdown_label,
.wtbx_vc_image_box .wtbx_image_box_title, .wtbx_vc_image_box.wtbx_style_2 .wtbx_image_box_content:hover .wtbx_image_box_button,
.wtbx_vc_social_icons.wtbx_style_6 a i,
.wtbx_iw_title,
.wtbx_step_bullet, .wtbx_steps_nav_title,
.wtbx_login_modal .login-lost-password a,
.header_language_dropdown a:hover,
.wtbx_search_input_wrapper i:hover,
.wtbx_dropdown_option:hover, .wtbx_dropdown_option.option_active,
.wtbx_search_field,
.post-media-button,
.plyr--audio .plyr__controls, .plyr--audio .plyr__controls button:hover,
.wtbx-audio-selfhosted.audio-noposter .audio-title,
.wtbx-pagination.wtbx-skin-light a.current, .wtbx-pagination.wtbx-skin-light a:hover, .wtbx-pagination.wtbx-skin-light .page-numbers a, .wtbx-pagination.wtbx-skin-light .wtbx-nav-button,
.wtbx-pagination.wtbx-skin-light .page-link, .wtbx-pagination.wtbx-skin-light .page-numbers .page-link,
.wtbx-pagination.wtbx-skin-light .page-prev a:hover:before, .wtbx-pagination.wtbx-skin-light .page-next a:hover:before,
.wtbx-pagination.wtbx-skin-light .page-prev .page-link:before, .wtbx-pagination.wtbx-skin-light .page-next .page-link:before,
.wtbx-navigation.wtbx-skin-light .wtbx-nav-title,
.wtbx-pagination .page-numbers.current,
.wtbx-pagination.paged-post-nav a:hover,
.wtbx-pagination.paged-post-nav .current,
.paged-post-nav a .page-numbers, .paged-post-nav a .page-numbers:before,
.wtbx-grid-minimal .meta-author span, .wtbx-grid-minimal .post-entry-footer-section,
.wtbx-grid-minimal .post-entry-footer-section a, .wtbx-grid-minimal .meta-date,
.widget a, #wp-calendar th, #wp-calendar td, #wp-calendar caption,
.widget_rss cite, .wtbx_recent_posts_cont .meta-comments:hover, .wtbx_recent_posts_cont .meta-comments:hover *,
.wtbx_search_field_wrapper .search_field i:hover,
.wtbx-orderby, .wtbx_with_custom_dropdown,
.product-gallery .thumbnails-wrapper .wtbx-carousel-arrow,
.cart-subtotal .woocommerce-Price-amount,
.select2-container .select2-dropdown .select2-results__option.select2-results__option--highlighted,
.cart-empty,
.wtbx-woocommerce-thankyou, .woocommerce-bacs-bank-details,
.wtbx-order-details .product-name a:not(:hover),
.woocommerce-Pagination .woocommerce-Button,
.download-product a:not(:hover),
.shop_table.my_account_orders .order-total .woocommerce-Price-amount,
.container-woocommerce .term-description,
.wc-item-download-label,
.header_cart_widget .amount,
.widget_shopping_cart .amount, .widget_price_filter .price_label,
.widget_layered_nav .wc-layered-nav-term span, .widget_product_categories .cat-item span,
.widget_layered_nav_filters li a:after,
.wtbx-product-inner .yith-wcwl-add-button i,
.wtbx-product-preview .price,
.category-product-count,
.woocommerce.add_to_cart_inline,
.wtbx-search-page-count,
.wtbx_vc_progress_bar.wtbx_style_2 .wtbx_pb_label, .wtbx_vc_progress_bar.wtbx_style_2 .wtbx_pb_value,
.wtbx_vc_progress_bar.wtbx_style_3 .wtbx_pb_label, .wtbx_vc_progress_bar.wtbx_style_3 .wtbx_pb_value,
.wtbx_pie_value, .wtbx_pie_title, .wtbx_vc_pie .wtbx_vc_icon,
.wtbx_vc_image_before_after.wtbx_style_2 .handle:before,
.wtbx_vc_message.wtbx_type_informational .wtbx_message_wrapper,
.wtbx_vc_message.wtbx_style_border .wtbx_message_wrapper,
#fp-nav.style_circles_labels.wtbx_skin_dark .fp-tooltip,
#fp-nav.style_lines_labels.wtbx_skin_light .fp-tooltip,
#fp-nav.style_vertical_labels.wtbx_skin_light .fp-tooltip,
#wtbx-page-nav.style_circles_labels.wtbx_skin_dark .nav-tooltip,
#wtbx-page-nav.style_lines_labels.wtbx_skin_light .nav-tooltip,
#wtbx-page-nav.style_vertical.wtbx_skin_light .nav-tooltip, #wtbx-page-nav.style_vertical_labels.wtbx_skin_light .nav-tooltip,
.wtbx-scrolldown-button.scrolldown-mouse-simple.wtbx-skin-dark,
.wtbx_vc_video_player .wtbx_video_player_front .wtbx_video_player_play.wtbx_skin_light,
.wtbx_iw_container.style_minimal .wtbx_iw_address,
.widget_shopping_cart .total,
.widget_shopping_cart .total .woocommerce-Price-amount,
.gdpr.gdpr.gdpr-privacy-bar .gdpr-wrapper .gdpr-content p, .gdpr.gdpr-reconsent-bar .gdpr-wrapper .gdpr-content p,
.gdpr.gdpr-privacy-bar .gdpr-wrapper .gdpr-right .gdpr-buttons button.gdpr-preferences:hover, .gdpr.gdpr-reconsent-bar .gdpr-wrapper .gdpr-right .gdpr-buttons button.gdpr-preferences:hover,
.gdpr .gdpr-box-title, .gdpr .gdpr-tabs li,
.gdpr .gdpr-tab-content header h4,
.gdpr .gdpr-cookie-categories-item:hover {
	color: <?php echo esc_html($color_text_dark); ?>;
}
.gdpr .gdpr-tabs li button:hover,
.gdpr .gdpr-tabs li button.gdpr-active,
.gdpr .gdpr-cookie-title p,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-content .gdpr-policies li a:hover,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-content .gdpr-policies li a:hover,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-content .gdpr-policies li a:hover,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-mobile-menu button:hover,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-mobile-menu button:hover,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-mobile-menu button:hover,
.gdpr .gdpr-close,
.gdpr .gdpr-cookie-categories-item input:checked + label,
.gdpr .gdpr-wrapper footer span a:hover {
	color: <?php echo esc_html($color_text_dark); ?> !important;
}
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-mobile-menu button:hover:after,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-mobile-menu button:hover:after,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-mobile-menu button:hover:after {
	border-top-color: <?php echo esc_html($color_text_dark); ?>;
}
.wtbx-quantity-change:hover,
.widget_product_categories .cat-item a:before,
#wtbx_header_search_wrapper .wtbx_search_input_wrapper:after,
.wtbx_overlay_close, .wtbx_mobile_close,
.wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_item.active .wtbx_tour_arrow, .wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_item:hover .wtbx_tour_arrow,
.form-minimal .select2-drop:before,
.portfolio-overlap-button:before,
.portfolio-panels-progress .bar,
.portfolio-slider-button:hover:before,
.wtbx-product-inner:hover .product-actions-trigger span,
.wtbx_arrows.wtbx_nav_skin_light .wtbx_arrow:hover:before,
.wtbx_dots_style_1.wtbx_nav_skin_light ul li:before,
.wtbx_dots_style_2.wtbx_nav_skin_light ul li:before,
.wtbx_dots_style_1.wtbx_nav_skin_light ol li:before,
.wtbx_dots_style_2.wtbx_nav_skin_light ol li:before,
.wtbx_vc_modal.wtbx_style_1 .wtbx_modal_close.wtbx_skin_light:before, .wtbx_vc_modal.wtbx_style_1 .wtbx_modal_close.wtbx_skin_light:after,
.wtbx_vc_modal.wtbx_style_3 .wtbx_modal_close.wtbx_skin_light:before, .wtbx_vc_modal.wtbx_style_3 .wtbx_modal_close.wtbx_skin_light:after,
.wtbx_vc_countdown .wtbx_countdown_time:before, .wtbx_vc_countdown .wtbx_countdown_time:after,
.wtbx_vc_social_icons.wtbx_style_3 a, .wtbx_vc_social_icons.wtbx_style_4 a, .wtbx_vc_social_icons.wtbx_style_5 .wtbx_default_custom .wtbx_social_icon_front, .wtbx_vc_social_icons.wtbx_style_5 .wtbx_hover_custom .wtbx_social_icon_back,
.wtbx_vc_social_icons.wtbx_style_6 a:before, .wtbx_vc_social_icons.wtbx_style_7 .wtbx_hover_custom .wtbx_social_icon_back,
.wtbx_iw_close:before, .wtbx_iw_close:after,
.wtbx_vc_image_before_after.wtbx_skin_dark .handle,
#wtbx_header_overlay.wtbx_skin_dark .wtbx_overlay_close:before, #wtbx_header_overlay.wtbx_skin_dark .wtbx_overlay_close:after,
#mobile-header.wtbx_skin_dark .wtbx_mobile_close:before, #mobile-header.wtbx_skin_dark .wtbx_mobile_close:after,
.wtbx-slider-gallery.gallery-skin-dark .slick-dots li:before,
.wtbx-slider-gallery.gallery-skin-dark .flickity-page-dots li:before,
.wtbx-navigation .dot, .wtbx-navigation .dot:before, .wtbx-navigation .dot:after,
.widget_product_categories .cat-item a:before,
.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar,
article.error404,
.wtbx-filter.filter-sidebar.wtbx-scheme-default .wtbx-filter-button:before,
#fp-nav.style_circles.wtbx_skin_light span, #fp-nav.style_circles_labels.wtbx_skin_light span,
#fp-nav.style_lines.wtbx_skin_light span, #fp-nav.style_lines_labels.wtbx_skin_light span,
#fp-nav.style_vertical_labels.wtbx_skin_light span,
#wtbx-page-nav.style_circles.wtbx_skin_light .nav-bullet, #wtbx-page-nav.style_circles_labels.wtbx_skin_light .nav-bullet,
#wtbx-page-nav.style_lines.wtbx_skin_light .nav-bullet, #wtbx-page-nav.style_lines.wtbx_skin_light .nav-bullet-inner, #wtbx-page-nav.style_lines.wtbx_skin_light .nav-bullet:before,
#wtbx-page-nav.style_lines_labels.wtbx_skin_light .nav-bullet,
#wtbx-page-nav.style_vertical.wtbx_skin_light .nav-bullet, #wtbx-page-nav.style_vertical.wtbx_skin_light .nav-bullet-inner, #wtbx-page-nav.style_vertical.wtbx_skin_light .nav-bullet:before,
#wtbx-page-nav.style_vertical_labels.wtbx_skin_light .nav-bullet, #wtbx-page-nav.style_vertical_labels.wtbx_skin_light .nav-bullet-inner, #wtbx-page-nav.style_vertical_labels.wtbx_skin_light .nav-bullet:before,
.wtbx_vc_countdown.wtbx_style_1.wtbx_separate .wtbx_countdown_days:after,
.wtbx_search_close:before, .wtbx_search_close:after,
.wtbx_vc_message .wtbx_message_button:hover:before, .wtbx_vc_message .wtbx_message_button:hover:after,
.wtbx-skin-dark.slider-bullets ul li button,
.wtbx-slider-nav.wtbx-skin-dark .page-links-arrow,
.wtbx-scrolldown-button.scrolldown-arrow-single span,
.wtbx-scrolldown-button.scrolldown-arrow-label span,
.wtbx-scrolldown-button.scrolldown-mouse-simple.wtbx-skin-dark span,
.wtbx-scrolldown-button.scrolldown-angle-down-cont.wtbx-skin-dark,
.wtbx-social-close,
.mc4wp-form button[type="submit"]:hover .mc-arrow,
.mc4wp-form button[type="submit"]:hover .scape-ui-chevron-right {
	background-color: <?php echo esc_html($color_text_dark); ?>;
}
.portfolio-panels-button:hover:before,
.wtbx_search_form_wrapper .wtbx_search_field:hover, .wtbx_search_form_wrapper .wtbx_search_field:focus, .wtbx_search_form_wrapper .wtbx_search_field:active,
.wtbx_vc_expandable_list.wtbx_style_default .wtbx_exp_list_title_wrapper:hover:before,
.wtbx_vc_expandable_list.wtbx_style_boxed .wtbx_exp_list_title_wrapper:hover:before,
.wtbx-slider-nav.wtbx-skin-dark .page-links-arrow:before,
.cf-minimal .select2-container.select2-container--open .select2-choice,
.wtbx_field_cont input:focus, .wtbx_field_cont input:active, .wtbx_field_cont select:not([multiple]):focus, .wtbx_field_cont select:not([multiple]):active,
.wtbx_field_cont textarea:focus, .wtbx_field_cont textarea:active,
.mc-minimal .mc4wp-form input[type="email"]:focus,
.mc-minimal .mc4wp-form input[type="email"]:active,
.wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_item.active .wtbx_tour_arrow:before, .wtbx_vc_tour.wtbx_skin_light .wtbx_tabs_nav_item:hover .wtbx_tour_arrow:before,
.wtbx_vc_accordion.wtbx_style_3 .wtbx_vc_accordion_tab .wtbx_accordion_link:hover:before,
.wtbx_arrows.wtbx_nav_skin_light .wtbx_arrow:hover:after,
.wtbx_dots_style_1.wtbx_nav_skin_light ul li.slick-active:before,
.wtbx_dots_style_1.wtbx_nav_skin_light ol li.is-selected:before,
.wtbx-filter.filter-multi.wtbx-scheme-default .wtbx-filter-button:hover:after,
.wtbx_vc_video_button.wtbx_style_2.wtbx_skin_light .wtbx_video_icon, .wtbx_vc_video_button.wtbx_style_2.wtbx_skin_light .wtbx_video_icon:before, .wtbx_vc_video_button.wtbx_style_2.wtbx_skin_light .wtbx_video_icon:after,
.wtbx-slider-gallery.gallery-skin-dark .wtbx-arrow:before,
.wtbx-navigation.wtbx-page-nav a:before,
.wtbx_search_select_wrapper:hover:before,
.wtbx_vc_image_before_after.wtbx_style_1.wtbx_skin_dark .handle:before, .wtbx_vc_image_before_after.wtbx_style_1.wtbx_skin_dark .handle:after,
.wtbx_vc_message .wtbx_message_button:hover,
.wtbx-scrolldown-button.scrolldown-arrow-single span:before,
.wtbx-scrolldown-button.scrolldown-angle-down, .wtbx-scrolldown-button.scrolldown-angle-down span,
.wtbx-scrolldown-button.scrolldown-angle-down-cont span,
.wtbx-totop span,
.mc4wp-form button[type="submit"]:hover .mc-arrow:before,
.wp-block-pullquote {
	border-color: <?php echo esc_html($color_text_dark);?>;
}
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_square.wtbx_skin_light .wtbx-button .bar,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_square.wtbx_skin_light .wtbx-button .chevron,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_simple.wtbx_skin_light .wtbx-button .bar,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_simple.wtbx_skin_light .wtbx-button .chevron {
	fill: <?php echo esc_html($color_text_dark); ?>;
}
<?php }

// light text color
$color_text_light = wtbx_option('color-main-text-light');
if ($color_text_light !== '') { ?>
.wp-block-latest-comments__comment-date,
.wp-block-latest-posts__post-date,
.author-position,
.author-contact-link,
.product-content-wrapper .wtbx-share,
#page-header[data-skin="dark"] .page-header-inner.page-header-post.page-header-post-custom_1 .hero-meta-categories a:not(:hover),
.comment-metadata,
.widget .tagcloud a,
.tag-links span a, .container-single-product .tagged_as a,
p.logged-in-as a, .comment-metadata a, .comment-reply-link,
.post-masonry-comments, .post-carousel-comments, .post-sbs-comments,
.post-sbs-meta span, .post-sbs-meta a, .post-sbs-meta .meta-date, .post-sbs-meta .post-like i, .post-sbs-meta .meta-wrapper > *:after,
.wtbx-grid-boxed .post-entry-footer a,
.wtbx-grid-boxed .meta-date,
.wtbx-like a,
.wtbx-like-wrapper .wtbx-like-button i,
.wtbx-like-wrapper .wtbx-like-button span,
.wtbx-grid-default .entry-meta .category-list, .wtbx-grid-default .entry-meta a:not(:hover), .wtbx-grid-default .entry-meta .meta:after,
.post-default-inner .post-like a:not(:hover) i,
.post-default-inner .entry-meta .meta-date,
.wtbx_social_widget.wtbx_style_1 a, .wtbx_social_widget.wtbx_style_1 a:hover,
.portfolio-square .portfolio-entry-meta .portfolio-meta-secondary,
.portfolio-tiles .portfolio-entry-meta .portfolio-meta-secondary,
.portfolio-panels .portfolio-meta-secondary,
.star-rating:before,
.woocommerce-review-link,
.comment-form-rating .stars:before,
.blog-masonry article.post-entry .meta-date,
.wtbx_exp_list_bullet .wtbx_vc_icon,
.wtbx_icon_predefined_5 .wtbx_vc_icon_wrapper:not(:hover) .wtbx_vc_icon,
.wtbx_vc_styled_heading.wtbx_style_overlapping .wtbx_heading_el_subtitle,
.wtbx_vc_styled_heading.wtbx_style_with_number .wtbx_heading_el_number,
.wtbx_vc_testimonial .wtbx_testimonial_author_occupation, .wtbx_vc_testimonial .wtbx_testimonial_author_company,
.wtbx_vc_testimonial.wtbx_style_4 .wtbx_testimonial_quote,
.wtbx_vc_rating .wtbx_rating_author_occupation, .wtbx_vc_rating .wtbx_rating_author_company,
.wtbx_vc_team_member .wtbx_team_member_position,
.wtbx_vc_team_member.wtbx_style_2 .wtbx_team_member_social a,
.wtbx_vc_team_member.wtbx_style_3 .wtbx_team_member_social a,
.wtbx_vc_team_member.wtbx_style_4 .wtbx_team_member_social a,
.wtbx_vc_testimonial_slide .wtbx_testimonial_author_occupation, .wtbx_vc_testimonial_slide .wtbx_testimonial_author_company,
.wtbx_vc_team_table .wtbx_team_member_position,
.wtbx_vc_image_box.wtbx_style_2 .wtbx_image_box_content .wtbx_image_box_button,
.wtbx-filter.wtbx-skin-light .wtbx-filter-button,
.wtbx-filter.filter-multi.wtbx-scheme-default .wtbx-filter-button:after,
.wtbx_vc_video_button.wtbx_skin_light .wtbx_video_button_sh,
.wtbx_vc_countdown .wtbx_countdown_label,
.wtbx_social_icon a,
.wtbx_iw_address,
.wtbx_steps_nav_subtitle,
.header_language_dropdown a,
.wtbx_search_in,
.wtbx_search_select_wrapper:before,
.wtbx_dropdown_option,
.wtbx-pagination.wtbx-skin-light,
.wtbx-navigation.wtbx-skin-light .wtbx-nav-meta,
.wtbx-grid-minimal .category-list,
.wtbx-related-posts .meta-date,
.widget_rss .rss-date, .wtbx_recent_posts_cont .entry-meta *, .wtbx_recent_comments .entry-meta,
.wtbx_author_widget .author-contact-link:not(:hover) i,
.wtbx_search_field_wrapper .search_field i,
.wtbx-option,
.wtbx-product-entry .product-subtitle,
.wtbx-cart .product-remove a i,
.woocommerce-breadcrumb,
.woocommerce-review__verified,
.select2-container .select2-dropdown .select2-results__option,
.select2-drop .select2-search:before,
.select2-dropdown .select2-search:before,
.header_cart_widget .remove,
.widget_shopping_cart .remove,
.wtbx_search_input_wrapper i,
.wtbx_pie_subtitle,
.wtbx_vc_message.wtbx_style_border .wtbx_message_wrapper .wtbx_message_icon,
.wtbx_heading_el_subtitle,
.wtbx-no-image,
.search-results .wtbx-search-result-inner .meta-date,
.mc4wp-form button[type="submit"] .scape-ui-chevron-right,
.wtbx-demo-button {
	color: <?php echo esc_html($color_text_light); ?>;
}
.wtbx-grid-minimal .meta-categories:before,
.mc4wp-form button[type="submit"] .mc-arrow,
.wtbx_arrows.wtbx_nav_skin_light .wtbx_arrow:before {
	background-color: <?php echo esc_html($color_text_light); ?>;
}
.wtbx-filter.filter-multi.wtbx-scheme-default .wtbx-filter-button:after,
.wtbx_vc_service.wtbx_bullet_border_dashed .wtbx_service_bullet,
.mc4wp-form button[type="submit"] .mc-arrow:before,
.wtbx_arrows.wtbx_nav_skin_light .wtbx_arrow:after {
	border-color: <?php echo esc_html($color_text_light); ?>;
}
::-webkit-input-placeholder {
color: <?php echo esc_html($color_text_light); ?>;
}
:-moz-placeholder {
color: <?php echo esc_html($color_text_light); ?>;
}
::-moz-placeholder {
color: <?php echo esc_html($color_text_light); ?>;
}
:-ms-input-placeholder {
color: <?php echo esc_html($color_text_light); ?>;
}
<?php }

// border color
$color_border = wtbx_option('color-main-border-color');
if ($color_border !== '') { ?>
#sidebar .widget_nav_menu > ul > li > .sub-menu > ul > li:before,
#sidebar .widget_nav_menu > ul > li > .sub-menu > ul > li li a:before,
.portfolio-panels-progress,
.wtbx-tooltip:before,
.product-tabs li:before, .product-tabs li:after,
.tab-decor,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_square.wtbx_skin_light .wtbx-button:before,
.wtbx_vc_list_item.wtbx_style_3 .wtbx_vc_list_item_inner:before,
.wtbx_vc_expandable_list.wtbx_style_default .wtbx_exp_list_bullet:before, .wtbx_vc_expandable_list.wtbx_style_default .wtbx_exp_list_bullet:after,
.wtbx_vc_expandable_list.wtbx_style_boxed .wtbx_exp_list_bullet:before,
.wtbx_vc_expandable_list.wtbx_style_border .wtbx_exp_list_bullet:before,
.wtbx_vc_styled_heading:not(.wtbx_style_with_line_side) .wtbx_heading_el_divider,
.wtbx_vc_styled_heading.wtbx_style_with_line_side .wtbx_heading_el_divider:before,
.wtbx_vc_styled_heading.wtbx_style_pill .wtbx_vc_styled_heading_inner:before,
.wtbx_vc_tabs.wtbx_style_4.wtbx_skin_light .wtbx_tabs_nav_link:before,
.wtbx_vc_tour.wtbx_skin_light .wtbx_tour_arrow,
.wtbx_vc_accordion.wtbx_style_2.wtbx_skin_light .wtbx_accordion_link:before,
.portfolio-square-inner .post-like a, .portfolio-tiles-inner .post-like a,
.wtbx_vc_steps_horizontal.wtbx_style_2 .wtbx_step_bullet, .wtbx_vc_steps_horizontal.wtbx_style_2 .wtbx_steps_nav_link:after,
.wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_steps_nav_link:before, .wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_step_bullet,
.wtbx_vc_steps_horizontal.wtbx_style_4 .wtbx_step_bullet:after,
.shop_table.my_account_orders tbody .order-actions a:after, .shop_table.woocommerce-table--order-downloads tbody .order-actions a:after,
.widget_price_filter .ui-widget-content,
.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
.gdpr .gdpr-switch .gdpr-slider {
	background-color: <?php echo esc_html($color_border); ?>;
}
input,
select,
textarea,
.cf-minimal select[multiple],
.cf-flat input:hover, .cf-flat select:not([multiple]):hover, .cf-flat textarea:hover,
.cf-flat input:focus, .cf-flat select:not([multiple]):focus, .cf-flat textarea:focus,
.cf-flat input:active, .cf-flat select:not([multiple]):active, .cf-flat textarea:active,
.field,
.select2-container .select2-choice,
table th, table td,
#comments, .comments-title-inner, .comment-reply-link,
.wtbx-navigation-wrapper.wtbx-layout-top .wtbx-nav-inner,
.portfolio-item-details,
.portfolio-panels-button:before,
.wtbx-grid-column .post-entry,
.product-tabs li a,
.wtbx-product-inner,
.related-products-title, .upsells-products-title,
.container-single-product .tags-n-share,
.wtbx-option,
.wtbx-product-footer,
.wtbx_author_widget,
.related.products .wtbx-section-title:after, .upsells.products .wtbx-section-title:after,
.wtbx-cart .spacer,
.wtbx-cart thead,
.cart-collaterals,
.cart_totals .cart-collaterals h2,
.shop_table .order-total, .order-total,
.shop_attributes th, .shop_attributes td,
#order_review, .shop_table thead tr, .shop_table tbody tr, .shop_table tfoot tr:first-child,
#payment h4, #payment .payment_box,
.woocommerce .addresses .address,
.woocommerce .addresses .address .title,
.yith-wcwl-add-to-wishlist .add_to_wishlist,
.wtbx-cart .cart_item .product-thumbnail img,
.wtbx_vc_list_item.wtbx_bullet_icon.wtbx_style_2 .wtbx_vc_list_item_content,
.wtbx_vc_expandable_list.wtbx_style_border .wtbx_vc_exp_list_item,
.select2-container .select2-selection,
.select2-drop, .select2-drop .select2-search input:focus, .select2-drop .select2-search input:active, .select2-drop .select2-results {
	border-color: <?php echo esc_html($color_border); ?>;
}
.wtbx_vc_list_item.wtbx_style_2 .wtbx_vc_list_item_inner,
.wtbx_vc_expandable_list.wtbx_style_default .wtbx_vc_exp_list_item,
.wtbx_vc_expandable_list.wtbx_style_default .wtbx_exp_list_title_wrapper:before,
.wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_vc_exp_list_item, .wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_exp_list_bullet_plus,
.wtbx_vc_expandable_list.wtbx_style_boxed .wtbx_exp_list_title_wrapper:before,
.wtbx_vc_expandable_list.wtbx_style_border .wtbx_exp_list_title_wrapper:before,
.wtbx_vc_expandable_list.wtbx_style_border .wtbx_vc_exp_list_item.active .wtbx_exp_list_title_wrapper,
.wtbx_vc_divider_line:before,
.wtbx_vc_content_box.wtbx_style_1 .wtbx_content_box_bg, .wtbx_vc_content_box.wtbx_style_3 .wtbx_content_box_bg, .wtbx_vc_content_box.wtbx_style_4 .wtbx_content_box_bg, .wtbx_vc_content_box.wtbx_style_4 .wtbx_content_box_bg:before,
.wtbx_vc_styled_heading.wtbx_style_pill .wtbx_heading_el_title,
.wtbx_vc_tabs.wtbx_style_1.wtbx_skin_light .wtbx_tabs_nav,
.wtbx_vc_tour.wtbx_style_1.wtbx_skin_light .wtbx_tabs_nav,
.wtbx_vc_tour.wtbx_style_2 .wtbx_tabs_nav,
.wtbx_vc_tour.wtbx_skin_light .wtbx_tour_arrow:before,
.wtbx_ui_tabs.wtbx_skin_light .wtbx_vc_tab .wtbx_tab_mobile_link,
.wtbx_vc_accordion.wtbx_style_1.wtbx_skin_light .wtbx_accordion_link,
.wtbx_vc_accordion.wtbx_style_3 .wtbx_vc_accordion_tab .wtbx_accordion_link:before,
.wtbx_vc_accordion.wtbx_style_3 .wtbx_vc_accordion_tab,
.wtbx_vc_testimonial.wtbx_style_1 .wtbx_vc_testimonial_inner:before,
.wtbx_vc_team_member.wtbx_style_1 .wtbx_team_member_social, .wtbx_vc_team_member.wtbx_style_1 .wtbx_team_member_social a,
.wtbx_vc_pricing_box .wtbx_pricing_box_content,
.wtbx_vc_video_button.wtbx_style_3.wtbx_skin_light .wtbx_video_button_wrapper,
.cf-subscribe-modern .wpcf7-form p,
.wtbx_vc_social_icons.wtbx_style_2 a, .wtbx_vc_social_icons.wtbx_style_7 a,
.wtbx_vc_steps_horizontal.wtbx_style_1 .wtbx_step_bullet:before, .wtbx_vc_steps_horizontal.wtbx_style_1 .wtbx_steps_nav_link:after,
.wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_step_bullet:before,
.wtbx_search_field,
.wtbx_dropdown_option,
.author-area,
.wtbx-pagination.wtbx-skin-light .page-prev a, .wtbx-pagination.wtbx-skin-light .page-next a,
.wtbx-pagination.wtbx-skin-light .page-prev .page-link, .wtbx-pagination.wtbx-skin-light .page-next .page-link,
.wtbx-grid-minimal .meta-categories a,
.wtbx-grid-minimal .post-minimal-inner,
.wtbx-orderby, .wtbx_with_custom_dropdown,
#reviews #review_form_wrapper:before,
.product-gallery .thumbnails-wrapper .wtbx-carousel-arrow,
.product-main-image, .thumbnails-wrapper .thumb-inner,
.cart_item, .shop_table thead, .shop_table tfoot, .shop_table tbody tr,
.login, .register, .create-account,
.wtbx-woocommerce-thankyou, .woocommerce-bacs-bank-details,
.wtbx-order-details,
.woocommerce-MyAccount-navigation ul, .woocommerce-MyAccount-navigation a,
.woocommerce-password-hint,
.woocommerce-account .wtbx-address-wrapper, .woocommerce-account .edit-account,
.woocommerce-account .edit-account fieldset,
.shop_table.woocommerce-MyAccount-orders td, .shop_table.woocommerce-table--order-downloads td,
.woocommerce .commentlist.notes,
.woocommerce .comment.note,
.shop_table thead th, .shop_table tfoot tr:first-child th, .shop_table tfoot tr:first-child td, .shop_table tfoot tr:last-child th, .shop_table tfoot tr:last-child td,
.track_order, .header_cart_widget img, .widget_shopping_cart img,
.widget_products img, .widget_recently_viewed_products img, .widget_top_rated_products img,
.category-product-count,
.wtbx_search_select,
.wtbx-search-result-inner,
.wtbx_vc_message.wtbx_style_default.wtbx_type_informational .wtbx_message_wrapper,
.wtbx-search-page-count,
.mc-minimal input[type="email"],
.wtbx_vc_pie.wtbx_style_2 .wtbx_pie_value,
.gdpr.gdpr-privacy-bar .gdpr-wrapper .gdpr-right .gdpr-cookie-categories,
.gdpr.gdpr-privacy-bar .gdpr-wrapper .gdpr-right .gdpr-policy-list,
.gdpr.gdpr-reconsent-bar .gdpr-wrapper .gdpr-right .gdpr-cookie-categories,
.gdpr.gdpr-reconsent-bar .gdpr-wrapper .gdpr-right .gdpr-policy-list,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-content .gdpr-tab-content > div .gdpr-info .gdpr-cookies-used,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-content .gdpr-tab-content > div .gdpr-info .gdpr-cookies-used,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-content .gdpr-tab-content > div .gdpr-info .gdpr-cookies-used,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-mobile-menu,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-mobile-menu,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-mobile-menu,
.gdpr .gdpr-wrapper header .gdpr-box-title,
.gdpr .gdpr-wrapper footer {
	border-color: <?php echo esc_html($color_border); ?>;
}
#sidebar .widget_nav_menu > ul > li.has-submenu > a:hover:before {
	color: <?php echo esc_html($color_border); ?>;
}
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-content .gdpr-tabs,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-content .gdpr-tabs,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-content .gdpr-tabs {
	border-color: <?php echo esc_html($color_border); ?> !important;
}
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
input[type="url"],
input[type="range"],
input[type="date"],
select,
textarea,
.mc-bubble .mc4wp-form input[type="email"],
.select2-container .select2-selection,
.wtbx-nav-back:before,
.author-contacts .author-contact-link:before,
.wtbx_social_widget.wtbx_style_1 a:before,
.wtbx-social-container form input, .wtbx-social-container form input:focus, .wtbx-social-container form input:active,
.wtbx-like-wrapper .wtbx-like-button:before,
.wtbx_with_custom_dropdown,
.product-content-wrapper .wtbx-share,
.wtbx-pagination.wtbx-skin-light .page-numbers:after,
.wtbx-grid-column .more-link {
	box-shadow: 0 0 0 1px rgba(<?php echo wtbx_hex2rgb($color_border); ?>, 1);
}
.wtbx-quantity:hover {
	box-shadow: inset 0 0 0 2px rgba(<?php echo wtbx_hex2rgb($color_text_dark); ?>, 1);
}
@media only screen and (max-width: 767px) {
	.wtbx-cart .woocommerce-cart-form__cart-item, .wishlist_table.cart .cart_item {
		box-shadow: 0 0 0 1px rgba(<?php echo wtbx_hex2rgb($color_border); ?>, 1);
	}
}
<?php }

// overlay color
$color_overlay = wtbx_option_sub('color-main-overlay-color', 'rgba');
if ($color_overlay !== '') { ?>
.post-media-overlay:before,
.post-metro-overlay,
.slide-overlay,
.popup-overlay,
.portfolio-overlay,
.wtbx_vc_team_table .wtbx_team_member_photo:after,
.wtbx_modal_content:before,
.wtbx_image_element_overlay,
.wtbx_vc_image_caption.wtbx_style_2.wtbx_skin_light .wtbx_image_inner:before,
.wtbx_vc_image_grid .wtbx_overlay,
.wtbx_vc_image_box .wtbx_image_overlay:before,
.wtbx_login_modal_backdrop,
.wtbx_search_backdrop,
.wtbx_sidearea_backdrop:before,
.wtbx_mobile_backdrop,
.post-quote-inner .wtbx-bg-image:after,
.post-quote-inner .wtbx-image-crop:after,
.portfolio-overlay-meta_middle,
.portfolio-entry .portfolio-overlay-color,
.portfolio-overlay-icon,
.portfolio-overlay-buttons,
.portfolio-entry .portfolio-entry-bg,
.portfolio-entry-bg,
.wtbx_random_post_widget .random-post-bg:before,
.wtbx-related-post-thumbnail .wtbx-image-crop:before,
.gdpr-overlay,
.wtbx-gdpr-noconsent-poster:before,
.wtbx-product-category-entry .wtbx-product-image:before {
	background-color: <?php echo esc_html($color_overlay); ?>;
}
<?php }

// main accent color
$color_accent = wtbx_option('color-main-accent');
if ($color_accent !== '') { ?>
a,
#sidebar .widget_nav_menu > ul > li.current-menu-ancestor > a,
#sidebar .widget_nav_menu > ul > li.current-menu-parent > a,
#sidebar .widget_nav_menu > ul > li.current-menu-ancestor.has-submenu > a:before,
#sidebar .widget_nav_menu > ul > li.has-submenu > a:hover,
#sidebar .widget_nav_menu > ul > li.has-submenu > a:hover:before,
article.post-entry h1.entry-title a:hover,
.post-sbs-inner .meta-author-link a:hover,
.post-masonry-inner .meta-author-link:hover,
a.author-name:hover,
.category-list a:hover,
p.logged-in-as a:hover, #comments .author-name a:hover,
.post-like i,
.post-like-button i, .post-like-button:hover i,
.comment-metadata .comment-edit-link:hover,
#container.blog-metro article.post-entry .post-metro-inner .post-metro-footer .entry-title a:hover,
#container.blog-metro article.post-entry .post-metro-inner .post-metro-footer .post-metro-comments:hover,
#container.blog-metro article.post-entry .post-metro-inner .post-metro-header .entry-meta .meta-wrapper .meta-author-link:hover,
#container.blog-metro article.post-entry .post-metro-inner .post-metro-header .entry-meta .meta-wrapper .meta-category .category-list a:hover,
.portfolio-content-trigger:hover .expand,
#container.portfolio-panels article.portfolio-entry.slick-current,
.portfolio-panels-inner.content-title_cat .portfolio-panels-overlay .portfolio-panels-content .portfolio-title:hover,
.star-rating span, .wtbx-product-inner .star-rating:before,
.wtbx-product-footer .price span,
.woocommerce-review-link:hover,
.posted_in a:hover,
.woocommerce-breadcrumb a:hover,
.widget_product_categories .cat-item.current-cat a,
.wtbx-wishlist-loop,
.yith-wcwl-wishlistexistsbrowse .wishlist-browse,
.wtbx-cart .product-name a:hover,
.wtbx-cart .product-remove a:hover i,
.update-cart,
.stock.out-of-stock,
.comment-navigation a:hover,
.plyr input[type="range"], .plyr__control--overlaid,
.shop_table.my_account_orders .order-number a:hover,
.shop_table.woocommerce-table--order-downloads .download-file a:hover,
.order-info .order-status,
.wtbx_icon_predefined_2 .wtbx_vc_icon,
.wtbx_icon_predefined_5 .wtbx_vc_icon,
.wtbx_vc_list_item.wtbx_has_link.wtbx_style_1 .wtbx_vc_list_item_inner:hover .wtbx_vc_list_item_content,
.wtbx_vc_expandable_list .wtbx_vc_exp_list_item.active .wtbx_vc_icon, .wtbx_vc_expandable_list .wtbx_vc_exp_list_item:hover .wtbx_vc_icon,
.wtbx_vc_expandable_list .wtbx_vc_exp_list_item .wtbx_vc_list_item_bullet_text,
.wtbx_style_to_top .wtbx_vc_divider_icon {
	color: <?php echo esc_html($color_accent); ?>;
}
.wtbx_vc_tabs.wtbx_style_1.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tabs.wtbx_style_2.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tabs.wtbx_style_4.wtbx_scheme_default.wtbx_skin_light .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link, .wtbx_vc_tabs.wtbx_style_4.wtbx_scheme_default.wtbx_skin_dark .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tour.wtbx_style_1.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tour.wtbx_style_4.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_ui_tabs.wtbx_scheme_default .wtbx_vc_tab.active .wtbx_tab_mobile_link,
.wtbx_vc_accordion.wtbx_scheme_default .wtbx_vc_accordion_tab.active .wtbx_accordion_link,
.wtbx_vc_testimonial.wtbx_style_1.wtbx_scheme_colorful .wtbx_testimonial_author_name,
.wtbx_vc_testimonial.wtbx_style_4.wtbx_scheme_colorful .wtbx_testimonial_quote,
.wtbx_vc_rating .wtbx_rating_star,
.wtbx_vc_team_member .wtbx_team_member_social a:hover i,
.wtbx_vc_pricing_box .wtbx_pricing_box_subtitle,
.wtbx_vc_pricing_box_feature .wtbx_pricing_box_feature_icon,
.wtbx_vc_button.wtbx_style_link,
.wtbx_vc_testimonial_slider.wtbx_style_1.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_author_name,
.wtbx-filter.wtbx-scheme-colorful .wtbx-filter-button.active, .wtbx-filter.wtbx-scheme-colorful .wtbx-filter-button:hover,
.wtbx-filter.filter-minimal.wtbx-scheme-colorful .wtbx-filter-button.active, .wtbx-filter.filter-minimal.wtbx-scheme-colorful .wtbx-filter-button:hover,
.wtbx_vc_video_button.wtbx_style_1.wtbx_skin_dark i,
.wtbx_vc_video_button.wtbx_style_5.wtbx_skin_dark i,
.wtbx_vc_video_button.wtbx_style_6.wtbx_skin_dark i,
.wtbx_vc_video_button.wtbx_style_3.wtbx_skin_light i,
.wtbx-grid-minimal  .meta-author-link:hover span,
.wtbx_vc_portfolio_grid .portfolio-square-inner .meta-link:hover,
#wp-calendar #today, .widget a:hover,
.wtbx_random_post_widget .meta-categories a:hover,
mark,
.comment-reply-link:hover,
.widget_layered_nav .wc-layered-nav-term.chosen span,
.wtbx-product-entry .add_to_cart_button .added-to-cart,
.wtbx-product-inner .yith-wcwl-wishlistaddedbrowse, .wtbx-product-inner .yith-wcwl-wishlistexistsbrowse,
.wtbx-maintenance-wrapper i,
.wtbx-button-filling .wtbx-button,
.wtbx_vc_message.wtbx_type_informational .wtbx_message_icon,
.single-post-meta .meta-author-link:hover,
.author-area .author-posts:hover,
.wtbx_vc_video_player .wtbx_video_player_front .wtbx_video_player_play.wtbx_skin_light_color {
	color: <?php echo esc_html($color_accent); ?>;
}

::selection {
	background-color: <?php echo esc_html($color_accent); ?>;
}
blockquote:before,
.wtbx-loadmore-container .wtbx-loadmore:hover,
#sidebar .widget_nav_menu ul li a:hover,
#sidebar .widget_nav_menu ul li.current-menu-item > a,
#sidebar .widget_nav_menu ul li li.current-menu-ancestor > a,
.post-like-button:hover,
.wtbx-like-anim span:before,
.wtbx-like-wrapper .wtbx-like-inner .wtbx-like-button.liked:before,
.wtbx-grid-default article.post-entry.sticky .side-meta,
.post-sbs-inner .meta-category a,
.post-default-inner .more-link,
.wpcf7-submit,
.widget_media_audio .mejs-container .mejs-controls,
.post-masonry-divider,
.wtbx-grid-boxed article.post-entry .post-boxed-media .post-boxed-button:hover,
.portfolio-tiles article.portfolio-entry .portfolio-tiles-inner .portfolio-tiles-button:hover,
.portfolio-panels-link:before,
.portfolio-slider-link:before,
.wtbx_slider.wtbx_meta_skin_dark .portfolio-slider-link,
.wtbx_slider.wtbx_meta_skin_dark .portfolio-slider-button:hover:before,
.lg-progress-bar .lg-progress,
#container.container-single-product .product .woocommerce-tabs .wtbx-product-tabs .product-tabs li.active a,
.wtbx-product-footer .add_to_cart_button:hover,
.wtbx-product-badge,
.widget_price_filter .ui-slider-handle,
.widget_product_categories .cat-item a:hover:before, .widget_product_categories .cat-item.current-cat a:before,
.plyr__control--overlaid:hover,
.woocommerce-info:before, .woocommerce-message:before, .order-info:before,
.digital-downloads li a:hover,
.scrolldown-arrow-single-circle.wtbx-skin-dark i, .scrolldown-arrow-double-circle.wtbx-skin-dark i, .scrolldown-mouse-circle.wtbx-skin-dark i,
.scrolldown-arrow-single-circle.wtbx-skin-light i:hover, .scrolldown-arrow-double-circle.wtbx-skin-light i:hover, .scrolldown-mouse-circle.wtbx-skin-light i:hover,
.wtbx_icon_predefined_2 .wtbx_vc_icon_wrapper:before,
.wtbx_vc_list_item.wtbx_bullet_point .wtbx_vc_list_item_bullet:before, .wtbx_vc_list_item.wtbx_bullet_point .wtbx_vc_list_item_bullet:after,
.wtbx_icon_predefined_1 .wtbx_vc_icon_wrapper,
.wtbx_icon_predefined_3 .wtbx_vc_icon,
.wtbx_icon_predefined_4 .wtbx_vc_icon_wrapper:before,
.wtbx_icon_predefined_4 .wtbx_vc_icon_wrapper:after,
.wtbx_vc_service.wtbx_bullet_cont_circle .wtbx_service_bullet_inner,
.wtbx_vc_service.wtbx_bullet_cont_rounded .wtbx_service_bullet_inner,
.wtbx_vc_service.wtbx_bullet_cont_square .wtbx_service_bullet_inner,
.wtbx_vc_expandable_list.wtbx_style_default .wtbx_exp_list_bullet:after,
.wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_exp_list_bullet_plus:before, .wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_exp_list_bullet_plus:after, .wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_vc_exp_list_item:before,
.wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet_plus,
.wtbx_vc_expandable_list.wtbx_style_boxed .wtbx_vc_exp_list_item .wtbx_exp_list_bullet_plus:after,
.wtbx_vc_expandable_list.wtbx_style_border .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet:before,
.wtbx_vc_divider.wtbx_style_to_top .wtbx_vc_divider_inner .wtbx_vc_divider_icon:hover,
.wtbx_style_border_left .wtbx_service_bullet, .wtbx_style_border_right .wtbx_service_bullet,
.wtbx_vc_styled_heading.wtbx_style_with_border .wtbx_vc_styled_heading_inner:before, .wtbx_vc_styled_heading.wtbx_style_with_border .wtbx_vc_styled_heading_inner:after,
.wtbx_vc_tabs.wtbx_style_1 .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link:before,
.wtbx_vc_tabs.wtbx_style_2 .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link:before,
.wtbx_vc_tabs.wtbx_style_3.wtbx_scheme_colorful .wtbx_tabs_knob,
.wtbx_vc_tabs.wtbx_style_4.wtbx_scheme_colorful .wtbx_tabs_nav_item .wtbx_tabs_nav_link:after,
.wtbx_vc_tour.wtbx_style_1 .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link:before,
.wtbx_vc_tour.wtbx_style_2 .wtbx_tabs_nav_item.active .wtbx_tabs_nav_link,
.wtbx_vc_tour.wtbx_style_3.wtbx_scheme_colorful .wtbx_tabs_nav_item .wtbx_tabs_nav_link:before,
.wtbx_vc_tour.wtbx_style_4 .wtbx_tabs_nav .wtbx_tabs_nav_item .wtbx_tabs_nav_link:before,
.wtbx_ui_tabs.wtbx_scheme_colorful .wtbx_vc_tab.active .wtbx_tab_mobile_link,
.wtbx_vc_accordion.wtbx_scheme_colorful .wtbx_vc_accordion_tab.active .wtbx_accordion_link,
.wtbx_vc_accordion.wtbx_style_3 .wtbx_vc_accordion_tab:before,
.wtbx_vc_accordion.wtbx_style_2.wtbx_scheme_default .wtbx_vc_accordion_tab.active .wtbx_accordion_link:before,
.wtbx_vc_testimonial.wtbx_style_2.wtbx_scheme_colorful .wtbx_testimonial_content,
.wtbx_vc_testimonial.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_content,
.wtbx_vc_testimonial.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_credentials:before, .wtbx_vc_testimonial.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_credentials:after,
.wtbx_vc_rating .wtbx_rating_stars_compact,
.wtbx_vc_team_member.wtbx_style_1 .wtbx_team_member_content:before,
.wtbx_vc_team_member.wtbx_style_4 .wtbx_team_member_photo:before,
.wtbx_vc_team_table .wtbx_team_member_details:after,
.wtbx_vc_image_before_after.wtbx_style_2.wtbx_skin_dark .handle,
.wtbx_vc_pricing_box.wtbx_style_1 .wtbx_pricing_box_wrapper:after,
.wtbx_vc_pricing_box.wtbx_style_2 .wtbx_pricing_box_title_wrapper:before,
.wtbx_vc_pricing_box_feature .wtbx_pricing_box_feature_badge,
.wtbx-social-trigger:after {
	background-color: <?php echo esc_html($color_accent); ?>;
}
.wtbx-link-underlined #content a:before, .wtbx-link-underlined-anim #content a:before, .wtbx-link-underlined-fill #content a:before, .wtbx-link-fill-left #content a:before, .wtbx-link-fill-bottom #content a:before, .wtbx-link-shift-up #content a:before,
.wtbx_vc_button .wtbx_link_arrow:after, .wtbx_vc_button.wtbx_link_decoration .wtbx_button_inner:before,
.wtbx_vc_button.wtbx_style_glowing .wtbx-button:before,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_round.wtbx_skin_light .wtbx-button:before,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_round.wtbx_skin_dark .wtbx-button,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_square.wtbx_skin_dark .wtbx-button,
.wtbx_vc_button.wtbx_style_arrow.wtbx_type_simple.wtbx_skin_dark .wtbx-button,
.wtbx_vc_button.wtbx_style_link .wtbx_button_inner:before,
.wtbx_vc_button.wtbx_style_link .wtbx_button_inner:after,
.wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_content,
.wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_credentials:before, .wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_credentials:after,
.vc_vc_testimonial_slider .wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_content,
.vc_vc_testimonial_slider .wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_credentials:before, .vc_vc_testimonial_slider .wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_credentials:after,
.wtbx_vc_modal.wtbx_style_2 .wtbx_modal_close.wtbx_skin_dark:before, .wtbx_vc_modal.wtbx_style_2 .wtbx_modal_close.wtbx_skin_dark:after,
.wtbx_vc_modal.wtbx_style_2 .wtbx_modal_close.wtbx_skin_light,
.wtbx_vc_image_caption.wtbx_style_2.wtbx_scheme_colorful .wtbx_image_inner:before,
.wtbx-filter.filter-multi.wtbx-scheme-colorful .wtbx-filter-button:before,
.wtbx-filter.filter-slider.wtbx-scheme-colorful .knob,
.wtbx-filter.filter-sidebar.wtbx-scheme-colorful .wtbx-filter-button:before,
.wtbx_vc_video_button.wtbx_style_1.wtbx_skin_light .wtbx_video_icon,
.wtbx_vc_video_button.wtbx_style_5.wtbx_skin_light .wtbx_video_icon,
.wtbx_vc_video_button.wtbx_style_5.wtbx_skin_light .wtbx_video_icon:before,
.wtbx_vc_video_button.wtbx_style_5.wtbx_skin_light .wtbx_video_icon:after,
.wtbx_vc_video_button.wtbx_style_6.wtbx_skin_light .wtbx_video_icon,
.wtbx_vc_video_button.wtbx_style_3.wtbx_skin_dark .wtbx_video_button_wrapper,
.wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_step_bullet:hover, .wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_steps_header:hover + .wtbx_step_bullet,
.wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_step_bullet,
.wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_steps_nav_link:before,
.wtbx-navigation.wtbx-skin-dark .wtbx-nav-back:hover:before,
.wtbx-grid-minimal .meta-categories a:hover, .wtbx-grid-minimal .post-entry-header:before,
.post-metro-inner .meta-categories a,
.page-header-post-custom_2 .meta-categories a,
.wtbx-related-posts .meta-categories a,
.wtbx_dots_style_2.wtbx_nav_skin_light ul li.slick-active:before,
.wtbx_dots_style_2.wtbx_nav_skin_light ol li.is-selected:before,
.portfolio-entry .portfolio-meta-categories a,
#wp-calendar tbody a:before, #wp-calendar tfoot a:hover,
.product-gallery .thumbnails-wrapper .wtbx-carousel-arrow:hover,
.wtbx-woocommerce-thankyou:before,
.wc-bacs-bank-details-heading:before, .wtbx-section-title.with-border:before,
.woocommerce-Pagination .woocommerce-Button,
.woocommerce-account legend:before, .woocommerce-MyAccount-navigation li.is-active a,
.widget_price_filter .ui-slider-range,
.widget_layered_nav .wc-layered-nav-term.chosen a:before,
.widget_product_categories .cat-item a:hover + span, .widget_product_categories .cat-item.current-cat a + span,
.wtbx-product-inner:hover .category-product-count,
.search-results .wtbx-search-result-inner .entry-post-type,
.wtbx_split_fill,
.wtbx-button-filling:before,
.wtbx_pb_bar,
.wtbx_vc_image_before_after.wtbx_style_2.wtbx_skin_dark .handle:before,
.wtbx_vc_image_before_after.wtbx_style_3.wtbx_skin_dark .handle:before,
.wtbx_vc_image_before_after.wtbx_style_3.wtbx_skin_dark .handle,
.wtbx_vc_message.wtbx_style_border .wtbx_message_wrapper:before,
.wtbx_vc_button.wtbx_style_custom .wtbx-button:before, .wtbx_vc_button.wtbx_style_custom .wtbx-button:after,
#fp-nav.style_circles.skin_colorful ul li a span, #fp-nav.style_circles_labels.skin_colorful ul li a span,
#fp-nav.style_lines.skin_colorful ul li a.active span, #fp-nav.style_lines_labels.skin_colorful ul li a span,
#fp-nav.style_vertical_labels.skin_colorful ul li a span,
#wtbx-page-nav.style_circles.skin_colorful ul li a .nav-bullet, #wtbx-page-nav.style_circles_labels.skin_colorful ul li a .nav-bullet,
#wtbx-page-nav.style_lines.skin_colorful ul li a.active .nav-bullet, #wtbx-page-nav.style_lines.skin_colorful ul li a.active .nav-bullet-inner, #wtbx-page-nav.style_lines.skin_colorful ul li a.active .nav-bullet:before,
#wtbx-page-nav.style_lines_labels.skin_colorful .nav-bullet,
#wtbx-page-nav.style_vertical.skin_colorful a.active .nav-bullet-inner, #wtbx-page-nav.style_vertical_labels.skin_colorful a.active .nav-bullet-inner,
#page-header.layout-three .page-header-wrapper:before, #page-header.layout-four .page-header-wrapper:before,
.wtbx-scrolldown-button.scrolldown-angle-down-cont:hover,
.wtbx_vc_video_player .wtbx_video_player_front .wtbx_video_player_play.wtbx_skin_dark_color,
.wtbx_vc_pricing_box .wtbx_pricing_box_button.style_btn,
.wtbx_vc_pricing_box .wtbx_pricing_box_button.style_ghost:hover,
.wtbx_gm_container .gm-style-iw.style_colorful,
.wtbx_gm_marker.circle,
.wtbx_gm_marker.circle_halo,
.wtbx_gm_marker.circle_pulse, .wtbx_gm_marker.circle_pulse:before,
.wtbx_gm_marker.pin,
.wtbx-sticky-badge,
.gdpr .gdpr-switch input:checked + .gdpr-slider,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper .gdpr-content .gdpr-tabs li .gdpr-subtabs li button.gdpr-active,
.gdpr.gdpr-reconsent .gdpr-wrapper .gdpr-content .gdpr-tabs li .gdpr-subtabs li button.gdpr-active,
.gdpr.gdpr-general-confirmation .gdpr-wrapper .gdpr-content .gdpr-tabs li .gdpr-subtabs li button.gdpr-active {
	background-color: <?php echo esc_html($color_accent); ?>;
}
.gdpr .gdpr-cookie-title a {
	color: <?php echo esc_html($color_accent); ?> !important;
}
.gdpr .gdpr-always-active {
	background-color: <?php echo esc_html($color_accent); ?> !important;
}
.wishlist-browse,
.wtbx-loadmore,
#sidebar .widget_nav_menu a:hover:before,
.wtbx_vc_expandable_list.wtbx_style_default .wtbx_exp_list_bullet:before,
.wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet_plus, .wtbx_vc_expandable_list.wtbx_style_minimal .wtbx_exp_list_title_wrapper:hover .wtbx_exp_list_bullet_plus,
.wtbx_vc_expandable_list.wtbx_style_boxed .wtbx_vc_exp_list_item.active .wtbx_exp_list_title_wrapper:before,
.wtbx_vc_expandable_list.wtbx_style_border .wtbx_vc_exp_list_item.active .wtbx_exp_list_title_wrapper:before,
.wtbx_icon_predefined_2 .wtbx_vc_icon_wrapper,
.wtbx_icon_predefined_3 .wtbx_vc_icon_wrapper:before,
.wtbx_vc_tour.wtbx_scheme_colorful .wtbx_tabs_nav_item.active .wtbx_tour_arrow:before,
.wtbx_vc_accordion.wtbx_style_3 .wtbx_vc_accordion_tab.active .wtbx_accordion_link:before,
.wtbx_vc_testimonial.wtbx_style_2.wtbx_scheme_colorful .wtbx_testimonial_content:before,
.wtbx_vc_testimonial.wtbx_style_3.wtbx_scheme_colorful .wtbx_testimonial_photo,
.wtbx_vc_tour.wtbx_style_2.wtbx_scheme_colorful .wtbx_tabs_nav .wtbx_tabs_nav_item.active .wtbx_tour_arrow:before,
.wtbx_vc_button .wtbx_link_arrow:before,
.wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide.is-selected .wtbx_testimonial_photo,
.vc_vc_testimonial_slider .wtbx_vc_testimonial_slider.wtbx_style_2.wtbx_scheme_colorful .wtbx_vc_testimonial_slide .wtbx_testimonial_photo,
.wtbx_vc_video_button.wtbx_style_1.wtbx_skin_light .wtbx_video_icon:before,
.wtbx_vc_video_button.wtbx_style_3.wtbx_skin_light .wtbx_video_icon, .wtbx_vc_video_button.wtbx_style_3.wtbx_skin_light .wtbx_video_icon:before, .wtbx_vc_video_button.wtbx_style_3.wtbx_skin_light .wtbx_video_icon:after,
.wtbx_vc_steps_horizontal.wtbx_style_3 .wtbx_steps_nav_item.active .wtbx_step_bullet:before,
.widget_layered_nav .wc-layered-nav-term.chosen a:before,
.widget_layered_nav .wc-layered-nav-term a:hover:before,
.wtbx-button-filling,
.wtbx_vc_pricing_box .wtbx_pricing_box_button.style_ghost,
.wtbx_gm_container .style_colorful:before,
.wtbx_gm_marker.circle_border,
.wtbx_gm_marker.circle_halo:before,
.wtbx-masonry-entry.post-entry.sticky .post-masonry-inner,
.wtbx-grid-minimal .sticky .post-minimal-inner,
.wp-block-quote.is-style-default {
	border-color: <?php echo esc_html($color_accent); ?>;
}
.wtbx_vc_button.wtbx_style_link .wtbx-button .bar,
.wtbx_vc_button.wtbx_style_link .wtbx-button .chevron {
	fill: <?php echo esc_html($color_accent); ?>;
}
.more-link:hover,
.audioplayer-playpause:hover,
.plyr__control--overlaid:hover,
.product-tabs li.active a,
.wtbx_vc_button.wtbx_style_glowing .wtbx-button:hover:before,
.wtbx_vc_divider.wtbx_style_to_top .wtbx_vc_divider_inner .wtbx_vc_divider_icon:hover,
.wtbx_vc_video_button.wtbx_style_3.wtbx_skin_dark .wtbx_video_button_wrapper:hover,
.wtbx-navigation.wtbx-skin-dark .wtbx-nav-back:hover:before,
.wtbx-social-trigger:hover:after,
.wtbx-grid-boxed article.post-entry .post-boxed-media .post-boxed-button:hover,
.portfolio-tiles article.portfolio-entry .portfolio-tiles-inner .portfolio-tiles-button:hover,
.wtbx-loadmore:hover,
.wtbx_slider.wtbx_meta_skin_dark .portfolio-slider-link:hover {
	box-shadow: 0 10px 45px -5px rgba(<?php echo wtbx_hex2rgb($color_accent); ?>, 0.5);
}
.wtbx_vc_expandable_list.wtbx_style_boxed .wtbx_vc_exp_list_item.active .wtbx_exp_list_bullet_plus:after {
	box-shadow: 0 1px 5px 0 rgba(<?php echo wtbx_hex2rgb($color_accent); ?>, 0.5);
}
.post-social .post-like:hover,
#container.container-single-product .product .woocommerce-tabs .wtbx-product-tabs .product-tabs li.active a:hover,
.digital-downloads li a:hover,
.scrolldown-arrow-single-circle .wtbx-scrolldown-button-inner i:hover, .scrolldown-arrow-double-circle .wtbx-scrolldown-button-inner i:hover, .scrolldown-mouse-circle .wtbx-scrolldown-button-inner i:hover,
#wp-calendar tbody a:hover,
.wtbx_vc_modal.wtbx_style_2 .wtbx_modal_close.wtbx_skin_light:hover,
.wtbx-grid-minimal .meta-categories a:hover,
.page-header-post-custom_2 .meta-categories a:hover,
.portfolio-entry .portfolio-meta-categories a:hover,
.product-gallery .thumbnails-wrapper .wtbx-carousel-arrow:hover,
.woocommerce-Pagination .woocommerce-Button:hover,
.wtbx-scrolldown-button.scrolldown-angle-down-cont:hover,
.wtbx_vc_pricing_box .wtbx_pricing_box_button.style_btn:hover,
.container-single-product .product-content-wrapper .cart .wtbx-button:hover {
	box-shadow: 0 8px 25px -5px rgba(<?php echo wtbx_hex2rgb($color_accent); ?>, 0.5);
}

input[type="text"]:focus,
input[type="password"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
input[type="url"]:focus,
input[type="range"]:focus,
input[type="date"]:focus,
select:focus,
textarea:focus,
input[type="text"]:active,
input[type="password"]:active,
input[type="datetime"]:active,
input[type="datetime-local"]:active,
input[type="date"]:active,
input[type="month"]:active,
input[type="time"]:active,
input[type="week"]:active,
input[type="number"]:active,
input[type="email"]:active,
input[type="url"]:active,
input[type="search"]:active,
input[type="tel"]:active,
input[type="color"]:active,
input[type="url"]:active,
input[type="range"]:active,
input[type="date"]:active,
select:active,
textarea:active,
.select2-container.select2-container--open .select2-selection,
.comment-reply-link:hover,
.wtbx-nav-back:hover:before,
.author-contacts .author-contact-link:hover:before,
.post-masonry-header .author-image,
.wtbx_social_widget.wtbx_style_1 a:hover:before,
.wtbx_with_custom_dropdown:hover,
.product-content-wrapper .wtbx-share:hover,
.wtbx-grid-column .more-link:hover,
.paged-post-nav a:hover {
	box-shadow: 0 0 0 2px rgba(<?php echo wtbx_hex2rgb($color_accent); ?>, 1);
}

.wtbx-carousel-arrow:hover {
	text-shadow: 0 0 3px rgba(<?php echo wtbx_hex2rgb($color_accent); ?>, 0.3);
}
input[type="checkbox"]:checked ~ label:before, input[type="checkbox"]:checked + .wpcf7-list-item-label:before,
input[type="radio"]:checked ~ label:before, input[type="radio"]:checked + .wpcf7-list-item-label:before {
	background-color: <?php echo esc_html($color_accent); ?>;
}
input[type="checkbox"]:checked ~ label:before, input[type="checkbox"]:checked + .wpcf7-list-item-label:before,
input[type="radio"]:checked ~ label:before, input[type="radio"]:checked + .wpcf7-list-item-label:before,
input[type="checkbox"]:hover ~ label:before, input[type="checkbox"] + .wpcf7-list-item-label:hover:before,
input[type="radio"]:hover ~ label:before, input[type="radio"] + .wpcf7-list-item-label:hover:before {
	border-color: <?php echo esc_html($color_accent); ?>;
}
.cf-light input[type="checkbox"]:checked ~ label:before, .cf-light input[type="checkbox"]:checked + .wpcf7-list-item-label:before,
.cf-light input[type="radio"]:checked ~ label:before, .cf-light input[type="radio"]:checked + .wpcf7-list-item-label:before {
	color: <?php echo esc_html($color_accent); ?>;
}
@media only screen and (max-width: 767px) {
	.wtbx-cart .product-remove {
		background-color: <?php echo esc_html($color_accent); ?>;
	}
}
<?php } ?>

/*---------------------------------------------------------------*/
/* Sticky header
/*---------------------------------------------------------------*/
<?php
$h7_light_visible_text_hover = wtbx_option_sub('h7-light-visible-text-hover','rgba');
$h7_light_visible_text_active = wtbx_option_sub('h7-light-visible-text-active','rgba');
$h7_dark_visible_text_hover = wtbx_option_sub('h7-dark-visible-text-hover','rgba');
$h7_dark_visible_text_active = wtbx_option_sub('h7-dark-visible-text-active','rgba');

// general
$sticky_header_height = wtbx_option('h-sticky-height');
if ($sticky_header_height !== '') { ?>
	.header_sticky.header_sticky_active .wtbx_hs_header .wtbx_hs_inner, .header_sticky.header_sticky_active .wtbx_hs_header .wtbx_ha, .header_sticky.header_sticky_active .wtbx_hs_header .wtbx_ha .header_button_height, .header_sticky.header_sticky_active .wtbx_hs_header .wtbx_ha .header_button_alt, .header_sticky.header_sticky_active .wtbx_hs_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($sticky_header_height); ?>px; line-height: <?php echo esc_html($sticky_header_height); ?>px; }
<?php }

// logo
$sticky_logo_width = intval(wtbx_option_sub('h-sticky-logo-size', 'width'));
$sticky_logo_height = intval(wtbx_option_sub('h-sticky-logo-size', 'height'));
$sticky_logo_margin_top = intval(wtbx_option('h-sticky-logo-offset-top'));
$sticky_logo_margin_left = intval(wtbx_option('h-sticky-logo-offset-left'));

$sticky_logo_width = $sticky_logo_width !== '' ? ' width:'.$sticky_logo_width.'px;' : '';
$sticky_logo_height = $sticky_logo_height !== '' ? ' height:'.$sticky_logo_height.'px;' : '';
$sticky_logo_margin_top = $sticky_logo_margin_top !== '' ? ' margin-top:'.$sticky_logo_margin_top.'px;' : '';
$sticky_logo_margin_left = $sticky_logo_margin_left !== '' ? ' margin-left:'.$sticky_logo_margin_left.'px;' : '';

if ($sticky_logo_width !== '' || $sticky_logo_height !== '' || $sticky_logo_margin_top !== '' || $sticky_logo_margin_left !== '') { ?>
.header_sticky.header_sticky_active .wtbx_header_logo {<?php echo esc_html($sticky_logo_width ). $sticky_logo_height . $sticky_logo_margin_top . $sticky_logo_margin_left; ?>}
<?php }

// light skin colors
// -general
$sticky_light_border = wtbx_option_sub('h-sticky-light-borders-color','rgba');
if ($sticky_light_border !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs, .header_sticky.header_sticky_active.sticky-skin-light .header_language_trigger:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_header_login_alt a:before, .header_sticky.header_sticky_active.sticky-skin-light .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($sticky_light_border); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_header_border:before { background-color: <?php echo esc_html($sticky_light_border); ?>; }
<?php }
// - header
$sticky_light_header_bg = wtbx_option_sub('h-sticky-light-header-bg','rgba');
if ($sticky_light_header_bg !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header { background-color: <?php echo esc_html($sticky_light_header_bg); ?>; }
<?php }
$sticky_light_header_text = wtbx_option_sub('h-sticky-light-header-text-color','rgba');
if ($sticky_light_header_text !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_header_part, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_h_text_color, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .header_widget a { color: <?php echo esc_html($sticky_light_header_text); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .overlay_button .dot, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .overlay_button .dot:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .overlay_button .dot:after, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .sidearea_button .line, .header_sticky.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_hs_header .wtbx_header_trigger .line { background-color: <?php echo esc_html($sticky_light_header_text); ?>; }
.header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_part, .header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color, .header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_widget a { color: <?php echo esc_html($sticky_light_header_text); ?>; }
.header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot, .header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:before, .header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:after, .header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button .line, .header-style-7.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger .line { background-color: <?php echo esc_html($sticky_light_header_text); ?>; }
<?php }
$sticky_light_header_text_hover = wtbx_option_sub('h-sticky-light-header-text-hover','rgba');
if ($sticky_light_header_text_hover !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($sticky_light_header_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($sticky_light_header_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .overlay_button:hover .dot, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .overlay_button:hover .dot:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .overlay_button:hover .dot:after, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .sidearea_button:hover .line, .header_sticky.header_sticky_active.sticky-skin-light:not(.header_active) .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($sticky_light_header_text_hover); ?>; }
.header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($sticky_light_header_text_hover); ?>; }
.header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li:hover, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color_hover:hover, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_widget a:hover { color: <?php echo esc_html($h7_light_visible_text_hover); ?>; }
.header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:before, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:after, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button:hover .line, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h7_light_visible_text_hover); ?>; }
<?php }
$sticky_light_header_text_active = wtbx_option_sub('h-sticky-light-header-text-active','rgba');
if ($sticky_light_header_text_active !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .header_button_alt > a, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($sticky_light_header_text_active); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($sticky_light_header_text_active); ?>; }
	.header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_button_alt > a, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_cart_wrapper_prim .cart_product_count:before, .header-style-7.header_sticky_active.header-skin-light:not(.header_active) .wtbx_ha_header_right_idle .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h7_light_visible_text_active); ?>; }
<?php }
// - topbar
$sticky_light_topbar_bg = wtbx_option_sub('h-sticky-light-topbar-bg','rgba');
if ($sticky_light_topbar_bg !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar { background-color: <?php echo esc_html($sticky_light_topbar_bg); ?>; }
<?php }
$sticky_light_topbar_text = wtbx_option_sub('h-sticky-light-topbar-text-color','rgba');
if ($sticky_light_topbar_text !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .wtbx_header_part, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .wtbx_h_text_color, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($sticky_light_topbar_text); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .overlay_button .dot, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .overlay_button .dot:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .overlay_button .dot:after, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($sticky_light_topbar_text); ?>; }
<?php }
$sticky_light_topbar_text_hover = wtbx_option_sub('h-sticky-light-topbar-text-hover','rgba');
if ($sticky_light_topbar_text_hover !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($sticky_light_topbar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($sticky_light_topbar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .overlay_button:hover .dot, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .overlay_button:hover .dot:after, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($sticky_light_topbar_text_hover); ?>; }
<?php }
$sticky_light_topbar_text_active = wtbx_option_sub('h-sticky-light-topbar-text-active','rgba');
if ($sticky_light_topbar_text_active !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .header_button_alt > a, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($sticky_light_topbar_text_active); ?>; }
<?php }
// - bottombar
$sticky_light_bottombar_bg = wtbx_option_sub('h-sticky-light-bottombar-bg','rgba');
if ($sticky_light_bottombar_bg !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar { background-color: <?php echo esc_html($sticky_light_bottombar_bg); ?>; }
<?php }
$sticky_light_bottombar_text = wtbx_option_sub('h-sticky-light-bottombar-text-color','rgba');
if ($sticky_light_bottombar_text !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .wtbx_header_part, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .wtbx_h_text_color, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .header_widget a { color: <?php echo esc_html($sticky_light_bottombar_text); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .overlay_button .dot, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .overlay_button .dot:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .overlay_button .dot:after, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .sidearea_button .line { background-color: <?php echo esc_html($sticky_light_bottombar_text); ?>; }
<?php }
$sticky_light_bottombar_text_hover = wtbx_option_sub('h-sticky-light-bottombar-text-hover','rgba');
if ($sticky_light_bottombar_text_hover !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .wtbx_menu_nav > ul > li:hover, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .wtbx_h_text_color_hover:hover, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .header_widget a:hover { color: <?php echo esc_html($sticky_light_bottombar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($sticky_light_bottombar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .overlay_button:hover .dot, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .overlay_button:hover .dot:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .overlay_button:hover .dot:after, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .sidearea_button:hover .line { background-color: <?php echo esc_html($sticky_light_bottombar_text_hover); ?>; }
<?php }
$sticky_light_bottombar_text_active = wtbx_option_sub('h-sticky-light-bottombar-text-active','rgba');
if ($sticky_light_bottombar_text_active !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .header_button_alt > a, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .header_cart_wrapper_prim .cart_product_count:before, .header_sticky.header_sticky_active.sticky-skin-light .wtbx_hs_bottombar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($sticky_light_bottombar_text_active); ?>; }
<?php }

// dark skin colors
// -general
$sticky_dark_border = wtbx_option_sub('h-sticky-dark-borders-color','rgba');
if ($sticky_dark_border !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs, .header_sticky.header_sticky_active.sticky-skin-dark .header_language_trigger:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_header_login_alt a:before, .header_sticky.header_sticky_active.sticky-skin-dark .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($sticky_dark_border); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_header_border:before { background-color: <?php echo esc_html($sticky_dark_border); ?>; }
<?php }
// - header
$sticky_dark_header_bg = wtbx_option_sub('h-sticky-dark-header-bg','rgba');
if ($sticky_dark_header_bg !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header { background-color: <?php echo esc_html($sticky_dark_header_bg); ?>; }
<?php }
$sticky_dark_header_text = wtbx_option_sub('h-sticky-dark-header-text-color','rgba');
if ($sticky_dark_header_text !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_header_part, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_h_text_color, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .header_widget a { color: <?php echo esc_html($sticky_dark_header_text); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .overlay_button .dot, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .overlay_button .dot:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .overlay_button .dot:after, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .sidearea_button .line, .header_sticky.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_hs_header .wtbx_header_trigger .line { background-color: <?php echo esc_html($sticky_dark_header_text); ?>; }
.header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_part, .header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color, .header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_widget a { color: <?php echo esc_html($sticky_dark_header_text); ?>; }
.header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot, .header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:before, .header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button .dot:after, .header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button .line, .header-style-7.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger .line { background-color: <?php echo esc_html($sticky_dark_header_text); ?>; }
<?php }
$sticky_dark_header_text_hover = wtbx_option_sub('h-sticky-dark-header-text-hover','rgba');
if ($sticky_dark_header_text_hover !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:hover, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_h_text_color_hover:hover, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .header_widget a:hover { color: <?php echo esc_html($sticky_dark_header_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-item, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($sticky_dark_header_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .overlay_button:hover .dot, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .overlay_button:hover .dot:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .overlay_button:hover .dot:after, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .sidearea_button:hover .line, .header_sticky.header_sticky_active.sticky-skin-dark:not(.header_active) .wtbx_hs_header .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($sticky_dark_header_text_hover); ?>; }
.header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($sticky_dark_header_text_hover); ?>; }
.header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_menu_nav > ul > li:hover, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_h_text_color_hover:hover, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_widget a:hover { color: <?php echo esc_html($h7_dark_visible_text_hover); ?>; }
.header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:before, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .overlay_button:hover .dot:after, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .sidearea_button:hover .line, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .wtbx_header_trigger:hover .line { background-color: <?php echo esc_html($h7_dark_visible_text_hover); ?>; }
<?php }
$sticky_dark_header_text_active = wtbx_option_sub('h-sticky-dark-header-text-active','rgba');
if ($sticky_dark_header_text_active !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .header_button_alt > a, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .header_cart_wrapper_prim .cart_product_count:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($sticky_dark_header_text_active); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($sticky_dark_header_text_active); ?>; }
.header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_button_alt > a, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_cart_wrapper_prim .cart_product_count:before, .header-style-7.header_sticky_active.header-skin-dark:not(.header_active) .wtbx_ha_header_right_idle .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($h7_dark_visible_text_active); ?>; }
<?php }
// - topbar
$sticky_dark_topbar_bg = wtbx_option_sub('h-sticky-dark-topbar-bg','rgba');
if ($sticky_dark_topbar_bg !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar { background-color: <?php echo esc_html($sticky_dark_topbar_bg); ?>; }
<?php }
$sticky_dark_topbar_text = wtbx_option_sub('h-sticky-dark-topbar-text-color','rgba');
if ($sticky_dark_topbar_text !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .wtbx_header_part, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .wtbx_h_text_color, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .header_widget a { color: <?php echo esc_html($sticky_dark_topbar_text); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .overlay_button .dot, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .overlay_button .dot:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .overlay_button .dot:after, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .sidearea_button .line { background-color: <?php echo esc_html($sticky_dark_topbar_text); ?>; }
<?php }
$sticky_dark_topbar_text_hover = wtbx_option_sub('h-sticky-dark-topbar-text-hover','rgba');
if ($sticky_dark_topbar_text_hover !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li:hover, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .wtbx_h_text_color_hover:hover, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .header_widget a:hover { color: <?php echo esc_html($sticky_dark_topbar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($sticky_dark_topbar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .overlay_button:hover .dot:after, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .sidearea_button:hover .line { background-color: <?php echo esc_html($sticky_dark_topbar_text_hover); ?>; }
<?php }
$sticky_dark_topbar_text_active = wtbx_option_sub('h-sticky-dark-topbar-text-active','rgba');
if ($sticky_dark_topbar_text_active !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .header_button_alt > a, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .header_cart_wrapper_prim .cart_product_count:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_topbar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($sticky_dark_topbar_text_active); ?>; }
<?php }
// - bottombar
$sticky_dark_bottombar_bg = wtbx_option_sub('h-sticky-dark-bottombar-bg','rgba');
if ($sticky_dark_bottombar_bg !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar { background-color: <?php echo esc_html($sticky_dark_bottombar_bg); ?>; }
<?php }
$sticky_dark_bottombar_text = wtbx_option_sub('h-sticky-dark-bottombar-text-color','rgba');
if ($sticky_dark_bottombar_text !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .wtbx_header_part, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .wtbx_h_text_color, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .header_widget a { color: <?php echo esc_html($sticky_dark_bottombar_text); ?>; }
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .overlay_button .dot, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .overlay_button .dot:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .overlay_button .dot:after, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .sidearea_button .line { background-color: <?php echo esc_html($sticky_dark_bottombar_text); ?>; }
<?php }
$sticky_dark_bottombar_text_hover = wtbx_option_sub('h-sticky-dark-bottombar-text-hover','rgba');
if ($sticky_dark_bottombar_text_hover !== '') { ?>
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .wtbx_menu_nav > ul > li:hover, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .wtbx_h_text_color_hover:hover, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .header_widget a:hover { color: <?php echo esc_html($sticky_dark_bottombar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .wtbx_menu_nav > ul > li.current-menu-item { color: <?php echo esc_html($sticky_dark_bottombar_text_hover); ?>; }
.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .overlay_button:hover .dot, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .overlay_button:hover .dot:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .overlay_button:hover .dot:after, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .sidearea_button:hover .line { background-color: <?php echo esc_html($sticky_dark_bottombar_text_hover); ?>; }
<?php }
$sticky_dark_bottombar_text_active = wtbx_option_sub('h-sticky-dark-bottombar-text-active','rgba');
if ($sticky_dark_bottombar_text_active !== '') { ?>
	.header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .header_button_alt > a, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .header_cart_wrapper_prim .cart_product_count:before, .header_sticky.header_sticky_active.sticky-skin-dark .wtbx_hs_bottombar .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($sticky_dark_bottombar_text_active); ?>; }
<?php } ?>

/*---------------------------------------------------------------*/
/* Mobile Header
/*---------------------------------------------------------------*/
<?php
// general
$hm_header_height = wtbx_option('hm-height');
if ($hm_header_height !== '') { ?>
	.header-mobile-top .wtbx_hs_top_header .wtbx_hs_inner, .header-mobile-top .wtbx_hs_top_header .wtbx_ha, .header-mobile-top .wtbx_hs_top_header .wtbx_ha .header_button_height, .header-mobile-top .wtbx_hs_top_header .wtbx_ha .header_button_alt, .header-mobile-top .wtbx_hs_top_header .wtbx_menu_nav > ul > li > a { height: <?php echo esc_html($hm_header_height); ?>px; line-height: <?php echo esc_html($hm_header_height); ?>px; }
<?php }
$hms_header_width = wtbx_option('hm-s-width');
if ($hms_header_width !== '') { ?>
	#mobile-header { width: <?php echo esc_html($hms_header_width); ?>px }
	.device-desktop #mobile-header .mobile-nav-wrapper { width: <?php echo intval($hms_header_width) + 17; ?>px }
<?php }

// typography
$hm_top_typo = wtbx_option_sub('hm-header-font', 'typography');
if ($hm_top_typo !== '') { ?>
	.header-mobile-top .wtbx_hs_top_header { <?php echo wtbx_font_styling_static($hm_top_typo); ?> }
<?php }
$hm_side_typo = wtbx_option_sub('hm-s-font', 'typography');
if ($hm_side_typo !== '') { ?>
	#mobile-header.header-mobile-side { <?php echo wtbx_font_styling_static($hm_side_typo); ?> }
<?php }

// logo
$hm_logo_width = intval(wtbx_option_sub('hm-logo-size', 'width'));
$hm_logo_height = intval(wtbx_option_sub('hm-logo-size', 'height'));
$hm_logo_margin_top = intval(wtbx_option('hm-logo-offset-top'));
$hm_logo_margin_left = intval(wtbx_option('hm-logo-offset-left'));

$hm_logo_width = $hm_logo_width !== '' ? ' width:'.$hm_logo_width.'px;' : '';
$hm_logo_height = $hm_logo_height !== '' ? ' height:'.$hm_logo_height.'px;' : '';
$hm_logo_margin_top = $hm_logo_margin_top !== '' ? ' margin-top:'.$hm_logo_margin_top.'px;' : '';
$hm_logo_margin_left = $hm_logo_margin_left !== '' ? ' margin-left:'.$hm_logo_margin_left.'px;' : '';

if ($hm_logo_width !== '' || $hm_logo_height !== '' || $hm_logo_margin_top !== '' || $hm_logo_margin_left !== '') { ?>
	.header-mobile-top .wtbx_header_logo {<?php echo esc_html($hm_logo_width ). $hm_logo_height . $hm_logo_margin_top . $hm_logo_margin_left; ?>}
<?php }

// colors
// - top header
$hm_header_bg = wtbx_option_sub('hm-bg','rgba');
if ($hm_header_bg !== '') { ?>
	.header-mobile-top #header-container-mobile { background-color: <?php echo esc_html($hm_header_bg); ?>; }
<?php }
$hm_header_text = wtbx_option_sub('hm-text','rgba');
if ($hm_header_text !== '') { ?>
	.header-mobile-top .wtbx_hs_top_header .wtbx_header_part, .header-mobile-top .wtbx_hs_top_header .wtbx_h_text_color, .header-mobile-top .wtbx_hs_top_header .header_widget a { color: <?php echo esc_html($hm_header_text); ?>; }
	.header-mobile-top .wtbx_hs_top_header .overlay_button .dot, .header-mobile-top .wtbx_hs_top_header .overlay_button .dot:before, .header-mobile-top .wtbx_hs_top_header .overlay_button .dot:after, .header-mobile-top .wtbx_hs_top_header .sidearea_button .line, .header-mobile-top .wtbx_hs_top_header .wtbx_mobile_trigger .line { background-color: <?php echo esc_html($hm_header_text); ?>; }
<?php }
$hm_header_text_active = wtbx_option_sub('hm-text-active','rgba');
if ($hm_header_text_active !== '') { ?>
	.header-mobile-top .wtbx_hs_top_header .wtbx_menu_nav > ul > li.current-menu-item, .header-mobile-top .wtbx_hs_top_header .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-mobile-top .wtbx_hs_top_header .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($hm_header_text_active); ?>; }
	.header-mobile-top .wtbx_hs_top_header .header_button_alt > a, .header-mobile-top .wtbx_hs_top_header .header_cart_wrapper_prim .cart_product_count:before, .header-mobile-top .wtbx_hs_top_header .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($hm_header_text_active); ?>; }
	.header-mobile-top .wtbx_hs_top_header .wtbx_menu_nav > ul > li:before { background-color: <?php echo esc_html($hm_header_text_active); ?>; }
<?php }
$hm_border = wtbx_option_sub('hm-borders-color','rgba');
if ($hm_border !== '') { ?>
.header-mobile .header_language_trigger:before, .header-mobile .wtbx_header_login_alt a:before, .header-mobile .search_button_wrapper_alt .search_button:before { border-color: <?php echo esc_html($hm_border); ?>; }
.header-mobile .wtbx_header_border:before { background-color: <?php echo esc_html($hm_border); ?>; }
<?php }

// - side header
$hms_header_bg = wtbx_option_sub('hm-s-bg','rgba');
if ($hms_header_bg !== '') { ?>
	.header-mobile-side { background-color: <?php echo esc_html($hms_header_bg); ?>; }
<?php }
$hms_header_text = wtbx_option_sub('hm-s-text','rgba');
if ($hms_header_text !== '') { ?>
.header-mobile-side .wtbx_header_part, .header-mobile-side .wtbx_h_text_color, .header-mobile-side .header_widget a, .header-mobile-side .wtbx_menu_nav li a { color: <?php echo esc_html($hms_header_text); ?>; }
.header-mobile-side .wtbx_menu_nav ul li.current-menu-item > a, .header-mobile-side .wtbx_menu_nav ul li.current-menu-ancestor > a, .header-mobile-side .wtbx_menu_nav ul li.current-menu-parent > a { color: <?php echo esc_html($hms_header_text); ?>; }
.header-mobile-side .wtbx_hs_main .wtbx_menu_nav a > span:before, .header-mobile-side .wtbx_hs_main .wtbx_menu_nav a > span:after, .header-mobile-side .wtbx_header_border:before { background-color: <?php echo esc_html($hms_header_text); ?>; }
<?php }
$hms_header_text_active = wtbx_option_sub('hm-s-text-active','rgba');
if ($hms_header_text_active !== '') { ?>
.header-mobile-side .header_button_alt > a, .header-mobile-side .header_cart_wrapper_prim .cart_product_count:before, .header-mobile-side .header_wishlist_wrapper_prim .wishlist_count:before { background-color: <?php echo esc_html($hms_header_text_active); ?>; }
.header-mobile-side .wtbx_menu_nav > ul > li.current-menu-item > a, .header-mobile-side .wtbx_menu_nav > ul > li.current-menu-ancestor > a, .header-mobile-side .wtbx_menu_nav > ul > li.current-menu-parent > a { color: <?php echo esc_html($hms_header_text_active); ?>; }
.header-mobile-side .wtbx_hs_main .wtbx_menu_nav li.current-menu-item > a > span:before, .header-mobile-side .wtbx_hs_main .wtbx_menu_nav li.current-menu-item > a > span:after, .header-mobile-side .wtbx_hs_main .wtbx_menu_nav li.current-menu-ancestor > a > span:before, .header-mobile-side .wtbx_hs_main .wtbx_menu_nav li.current-menu-ancestor > a > span:after, .header-mobile-side .wtbx_hs_main .wtbx_menu_nav li.current-menu-parent > a > span:before, .header-mobile-side .wtbx_hs_main .wtbx_menu_nav li.current-menu-parent > a > span:after { background-color: <?php echo esc_html($hms_header_text_active); ?>; }
.header-mobile-side .wtbx_hs_main .wtbx_menu_nav li > a:active  { color: <?php echo esc_html($hms_header_text_active); ?>; }
<?php } ?>


/*---------------------------------------------------------------*/
/* Sub menu
/*---------------------------------------------------------------*/
<?php
// typography
$submenu_link_typo = wtbx_option_sub('sm-link-font', 'typography');
$submenu_title_typo = wtbx_option_sub('sm-megamenu-font', 'typography');
if ($submenu_link_typo !== '') { ?>
	#header-wrapper .wtbx_menu_nav .sub-menu-link {<?php echo wtbx_font_styling_static($submenu_link_typo); ?> }
<?php }
if ($submenu_title_typo !== '') { ?>
	#header-wrapper .wtbx_menu_nav ul.sub-menu-wide > .sub-menu-item > .menu-depth-2 > .sub-menu-item > .sub-menu-link {<?php echo wtbx_font_styling_static($submenu_title_typo); ?> }
<?php }

// colors
$submenu_bg_color = wtbx_option_sub('sm-bg', 'rgba');
$submenu_link_color = wtbx_option_sub('sm-color', 'rgba');
$submenu_link_color_hover = wtbx_option_sub('sm-color-hover', 'rgba');
$submenu_link_color_active = wtbx_option_sub('sm-color-active', 'rgba');
$submenu_link_bg_hover = wtbx_option_sub('sm-color-bg', 'rgba');
$submenu_title_color = wtbx_option_sub('sm-color-megaheading', 'rgba');

if ($submenu_bg_color !== '') { ?>
#header-wrapper .wtbx_menu_nav .menu > li > .sub-menu, #header-wrapper .wtbx_menu_nav .sub-sub-menu { background-color: <?php echo esc_html($submenu_bg_color); ?> }
<?php }
if ($submenu_link_color !== '') { ?>
#header-wrapper .wtbx_menu_nav .sub-menu-link { color: <?php echo esc_html($submenu_link_color); ?> }
<?php }
if ($submenu_link_color_hover !== '') { ?>
#header-wrapper .wtbx_menu_nav .sub-menu-link:hover { color: <?php echo esc_html($submenu_link_color_hover); ?> }
<?php }
if ($submenu_link_color_active !== '') { ?>
#header-wrapper .wtbx_menu_nav .sub-menu .sub-menu-item.current-menu-item > .sub-menu-link, #header-wrapper .wtbx_menu_nav .sub-menu .sub-menu-item.current-menu-ancestor > .sub-menu-link, #header-wrapper .wtbx_menu_nav .sub-menu .sub-menu-item.current-menu-parent > .sub-menu-link, #mobile-header .wtbx_menu_nav .sub-menu .sub-menu-item.current-menu-item > .sub-menu-link, #mobile-header .wtbx_menu_nav .sub-menu .sub-menu-item.current-menu-ancestor > .sub-menu-link, #mobile-header .wtbx_menu_nav .sub-menu .sub-menu-item.current-menu-parent > .sub-menu-link { color: <?php echo esc_html($submenu_link_color_active); ?> }
<?php }
if ($submenu_link_bg_hover !== '') { ?>
#header-wrapper .wtbx_menu_nav .menu-depth-1:not(.sub-menu-wide) > .sub-menu-item:before, #header-wrapper .wtbx_menu_nav .menu-depth-1:not(.sub-menu-wide) .menu-depth-2 .sub-menu-item:before, #header-wrapper .wtbx_menu_nav .menu-depth-3 .sub-menu-item:before { background-color: <?php echo esc_html($submenu_link_bg_hover); ?> }
<?php }
if ($submenu_title_color !== '') { ?>
#header-wrapper .wtbx_menu_nav ul.sub-menu-wide > .sub-menu-item .menu-depth-2 > .sub-menu-item > .sub-menu-link { color: <?php echo esc_html($submenu_title_color); ?> }
<?php }
?>


/*---------------------------------------------------------------*/
/* Hero section colors
/*---------------------------------------------------------------*/
<?php
$hero_title_light    = wtbx_option('header-section-title-color-light-global');
$hero_title_dark     = wtbx_option('header-section-title-color-dark-global');

$hero_title_light = $hero_title_light !== '' ? $hero_title_light : '#ffffff';
$hero_title_dark = $hero_title_dark !== '' ? $hero_title_dark : $color_text_dark;

$bc_link_d_light     = wtbx_option_sub('header-section-bc-link-color-light-global', 'regular');
$bc_link_h_light     = wtbx_option_sub('header-section-bc-link-color-light-global', 'hover');
$bc_sep_light        = wtbx_option('header-section-bc-separator-color-light-global');
$bc_link_d_dark      = wtbx_option_sub('header-section-bc-link-color-dark-global', 'regular');
$bc_link_h_dark      = wtbx_option_sub('header-section-bc-link-color-dark-global', 'hover');
$bc_sep_dark         = wtbx_option('header-section-bc-separator-color-dark-global');
if ($hero_title_light !== '') { ?>
#page-header[data-skin="light"] .page-header-inner h1,
#page-header[data-skin="light"] .page-header-author,
#page-header[data-skin="light"] .author-position,
#page-header[data-skin="light"] .author-name,
#page-header[data-skin="light"] .author-contact-link,
#page-header[data-skin="light"] .author-contact-link:hover i,
#page-header[data-skin="light"] .header-section-meta,
#page-header[data-skin="light"] .hero-meta-categories a {
	color: <?php echo esc_html($hero_title_light); ?>;
}
<?php }
if ($hero_title_light !== '') { ?>
#page-header[data-skin="light"] .author-contact-link:hover:before {
	box-shadow: 0 0 0 2px <?php echo esc_html($hero_title_light); ?>;
}
<?php }
if ($hero_title_dark !== '') { ?>
#page-header[data-skin="dark"] .page-header-inner h1,
#page-header[data-skin="dark"] .page-header-author,
#page-header[data-skin="dark"] .author-position,
#page-header[data-skin="dark"] .author-name,
#page-header[data-skin="dark"] .author-contact-link,
#page-header[data-skin="dark"] .header-section-meta,
#page-header[data-skin="dark"] .hero-meta-categories a {
	color: <?php echo esc_html($hero_title_dark); ?>;
}
<?php }
if ($hero_title_dark !== '') { ?>
#page-header[data-skin="dark"] .author-contact-link:hover:before {
	box-shadow: 0 0 0 2px <?php echo esc_html($hero_title_dark); ?>;
}
<?php }
if ($bc_link_d_light !== '') { ?>
#page-header[data-skin="light"] .wtbx-page-breadcrumbs .breadcrumbs-path,
#page-header[data-skin="light"] .wtbx-page-breadcrumbs .breadcrumbs-path a {
	color: <?php echo esc_html($bc_link_d_light); ?>;
}
<?php }
if ($bc_link_d_dark !== '') { ?>
#page-header[data-skin="dark"] .wtbx-page-breadcrumbs .breadcrumbs-path,
#page-header[data-skin="dark"] .wtbx-page-breadcrumbs .breadcrumbs-path a {
	color: <?php echo esc_html($bc_link_d_dark); ?>;
}
<?php }
if ($bc_link_h_light !== '') { ?>
#page-header[data-skin="light"] .wtbx-page-breadcrumbs .breadcrumbs-path a:hover {
	color: <?php echo esc_html($bc_link_h_light); ?>;
}
<?php }
if ($bc_link_h_dark !== '') { ?>
#page-header[data-skin="dark"] .wtbx-page-breadcrumbs .breadcrumbs-path a:hover {
	color: <?php echo esc_html($bc_link_h_dark); ?>;
}
<?php }
if ($bc_sep_light !== '') { ?>
#page-header[data-skin="light"] .wtbx-page-breadcrumbs .breadcrumbs-path .separator {
	color: <?php echo esc_html($bc_sep_light); ?>;
}
<?php }
if ($bc_sep_dark !== '') { ?>
#page-header[data-skin="dark"] .wtbx-page-breadcrumbs .breadcrumbs-path .separator {
	color: <?php echo esc_html($bc_sep_dark); ?>;
}
<?php }
if ($bc_sep_light !== '') { ?>
#page-header[data-skin="light"] .wtbx-page-breadcrumbs .wtbx-separator-angle:before {
	border-color: <?php echo esc_html($bc_sep_light); ?>;
}
<?php }
if ($bc_sep_dark !== '') { ?>
#page-header[data-skin="dark"] .wtbx-page-breadcrumbs .wtbx-separator-angle:before {
	border-color: <?php echo esc_html($bc_sep_dark); ?>;
}
<?php }
if ($bc_sep_light !== '') { ?>
#page-header[data-skin="light"] .wtbx-page-breadcrumbs .wtbx-separator-circle:before {
	background-color: <?php echo esc_html($bc_sep_light); ?>;
}
<?php }
if ($bc_sep_dark !== '') { ?>
#page-header[data-skin="dark"] .wtbx-page-breadcrumbs .wtbx-separator-circle:before {
	background-color: <?php echo esc_html($bc_sep_dark); ?>;
}
<?php } ?>

/*---------------------------------------------------------------*/
/* Lightbox
/*---------------------------------------------------------------*/
<?php
// lightbox
$lightbox_bg = wtbx_option_sub('lightbox-bg', 'rgba');
if ($lightbox_bg !== '') { ?>
.modal-backdrop, .mfp-bg { background-color: <?php echo esc_html($lightbox_bg); ?>; }
<?php } ?>

/*---------------------------------------------------------------*/
/* Portfolio
/*---------------------------------------------------------------*/
<?php
$layout_width = wtbx_option('site-width', 1200); ?>
@media only screen and (max-width: <?php echo (intval($layout_width) + 240); ?>px) {
	.portfolio-item-zigzag .portfolio-item-section:nth-child(2n-1) .portfolio-item-image-inner { margin-right: 45px;}
	.portfolio-item-zigzag .portfolio-item-section:nth-child(2n) .portfolio-item-image-inner { margin-left: 45px;}
}
@media only screen and (max-width: <?php echo (intval($layout_width) + 150); ?>px) {
	.portfolio-item-zigzag .portfolio-item-section:nth-child(2n-1) .portfolio-item-image-inner { margin-right: 105px;}
	.portfolio-item-zigzag .portfolio-item-section:nth-child(2n) .portfolio-item-image-inner { margin-left: 105px;}
}
<?php
$portfolio_title_typo = wtbx_option_sub('portfolio-item-title-typography', 'typography');
$portfolio_descr_typo = wtbx_option_sub('portfolio-item-description-typography', 'typography');
 if ($portfolio_title_typo !== '') { ?>
.container-portfolio-item .portfolio-item-title h1 { <?php echo wtbx_font_styling_static($portfolio_title_typo); ?>; }
<?php }
if ($portfolio_descr_typo !== '') { ?>
.portfolio-item-content .portfolio-item-description { <?php echo wtbx_font_styling_static($portfolio_descr_typo); ?>; }
<?php } ?>


/*---------------------------------------------------------------*/
/* Filters
/*---------------------------------------------------------------*/
<?php
$filter = array();
$filter['light-accent'] = wtbx_option('gf-light-accent', '#8571ea');
$filter['dark-accent'] = wtbx_option('gf-dark-accent', '#8571ea');

if ( isset($filter['light-accent']) ) { ?>
.wtbx-filter.wtbx-skin-light.filter-minimal.wtbx-scheme-colorful .wtbx-filter-button.active, .wtbx-filter.wtbx-skin-light.filter-minimal.wtbx-scheme-colorful .wtbx-filter-button:hover, .wtbx-filter.wtbx-skin-light.filter-slider.wtbx-scheme-colorful .wtbx-filter-button:not(.active):hover, .wtbx-filter.filter-sidebar.wtbx-skin-light.wtbx-scheme-colorful .wtbx-filter-button.active, .wtbx-filter.filter-sidebar.wtbx-skin-light.wtbx-scheme-colorful .wtbx-filter-button:hover { color: <?php echo esc_html($filter['light-accent']); ?>; }
.wtbx-filter.wtbx-skin-light.filter-slider.wtbx-scheme-colorful .knob, .wtbx-filter.wtbx-skin-light.filter-multi.wtbx-scheme-colorful .wtbx-filter-button:before, .wtbx-filter.filter-sidebar.wtbx-skin-light.wtbx-scheme-colorful .wtbx-filter-button:before { background-color: <?php echo esc_html($filter['light-accent']); ?>; }
.wtbx-filter.wtbx-skin-light.filter-slider.filter-shadow.wtbx-scheme-colorful .knob, .wtbx-filter.wtbx-skin-light.filter-multi.filter-shadow.wtbx-scheme-colorful .wtbx-filter-button:hover:before { box-shadow: 0 10px 45px -5px rgba(<?php echo wtbx_hex2rgb(esc_html($filter['light-accent'])) ?>, 0.5); }
<?php }

if ( isset($filter['dark-accent']) ) { ?>
.wtbx-filter.wtbx-skin-dark.filter-minimal.wtbx-scheme-colorful .wtbx-filter-button.active, .wtbx-filter.wtbx-skin-dark.filter-minimal.wtbx-scheme-colorful .wtbx-filter-button:hover, .wtbx-filter.wtbx-skin-dark.filter-slider.wtbx-scheme-colorful .wtbx-filter-button:hover:not(.active), .wtbx-filter.filter-sidebar.wtbx-skin-dark.wtbx-scheme-colorful .wtbx-filter-button.active, .wtbx-filter.filter-sidebar.wtbx-skin-dark.wtbx-scheme-colorful .wtbx-filter-button:hover { color: <?php echo esc_html($filter['dark-accent']); ?>; }
.wtbx-filter.wtbx-skin-dark.filter-slider.wtbx-scheme-colorful .knob, .wtbx-filter.wtbx-skin-dark.filter-multi.wtbx-scheme-colorful .wtbx-filter-button:before, .wtbx-filter.filter-sidebar.wtbx-skin-dark.wtbx-scheme-colorful .wtbx-filter-button:before { background-color: <?php echo esc_html($filter['dark-accent']); ?>; }
.wtbx-filter.wtbx-skin-dark.filter-slider.filter-shadow.wtbx-scheme-colorful .knob, .wtbx-filter.wtbx-skin-dark.filter-multi.filter-shadow.wtbx-scheme-colorful .wtbx-filter-button:hover:before { box-shadow: 0 10px 45px -5px rgba(<?php echo wtbx_hex2rgb($filter['dark-accent']) ?>, 0.5); }
<?php } ?>

/*---------------------------------------------------------------*/
/* WooCommerce
/*---------------------------------------------------------------*/
<?php
// product tile
$product_padding_top = wtbx_option_sub('product-tile-padding', 'padding-top');
$product_padding_right = wtbx_option_sub('product-tile-padding', 'padding-right');
$product_padding_bottom = wtbx_option_sub('product-tile-padding', 'padding-bottom');
$product_padding_left = wtbx_option_sub('product-tile-padding', 'padding-left');

if ($product_padding_top !== '') { ?>
.wtbx-product-single-entry .wtbx-product-image { margin-top: <?php echo esc_html($product_padding_top); ?>; }
<?php }
if ($product_padding_right !== '') { ?>
.wtbx-product-single-entry .wtbx-product-image { margin-right: <?php echo esc_html($product_padding_right); ?>; }
<?php }
if ($product_padding_bottom !== '') { ?>
.wtbx-product-single-entry .wtbx-product-image { margin-bottom: <?php echo esc_html($product_padding_bottom); ?>; }
<?php }
if ($product_padding_left !== '') { ?>
.wtbx-product-single-entry .wtbx-product-image { margin-left: <?php echo esc_html($product_padding_left); ?>; }
<?php }

$product_bg = wtbx_option('product-tile-bg');
if ($product_bg !== '') { ?>
.wtbx-product-single-entry .wtbx-product-inner { background-color: <?php echo esc_html($product_bg); ?>; }
<?php }

$product_tile_title_typo = wtbx_option_sub('product-tile-title-typography', 'typography');
if ($product_tile_title_typo !== '') { ?>
.wtbx-product-single-entry .wtbx-product-inner .wtbx-product-title h3 { <?php echo wtbx_font_styling_static($product_tile_title_typo); ?>; }
<?php }

$product_tile_subtitle_typo = wtbx_option_sub('product-tile-subtitle-typography', 'typography');
if ($product_tile_subtitle_typo !== '') { ?>
.wtbx-product-single-entry .wtbx-product-inner .wtbx-product-title .product-subtitle { <?php echo wtbx_font_styling_static($product_tile_subtitle_typo); ?>; }
<?php }

// category tile
$product_cat_tile_title_typo = wtbx_option_sub('product-cat-tile-title-typography', 'typography');
if ($product_cat_tile_title_typo !== '') { ?>
	.wtbx-product-category-entry .wtbx-product-inner .wtbx-product-category-content .wtbx-product-title { <?php echo wtbx_font_styling_static($product_cat_tile_title_typo); ?>; }
<?php }

$product_cat_tile_description_typo = wtbx_option_sub('product-cat-tile-description-typography', 'typography');
if ($product_cat_tile_description_typo !== '') { ?>
	.wtbx-product-category-entry .wtbx-product-inner .wtbx-product-category-content .wtbx-product-description  { <?php echo wtbx_font_styling_static($product_cat_tile_description_typo); ?>; }
<?php }

// badges
$sale_color = wtbx_option('product-sale-bg');
if ($sale_color !== '') { ?>
.onsale { background-color: <?php echo esc_html($sale_color); ?>; }
<?php }

$badge_color = wtbx_option('product-badge-bg');
if ($badge_color !== '') { ?>
.wtbx-product-badge { background-color: <?php echo esc_html($badge_color); ?>; }
<?php }

// product page
$product_single_title_typo = wtbx_option_sub('product-single-title-typography', 'typography');
if ($product_single_title_typo !== '') { ?>
#container.container-single-product .product .product-content-wrapper .entry-summary .product_title { <?php echo wtbx_font_styling_static($product_single_title_typo); ?>; }
<?php }

$product_single_subtitle_typo = wtbx_option_sub('product-single-subtitle-typography', 'typography');
if ($product_single_subtitle_typo !== '') { ?>
#container.container-single-product .product .product-content-wrapper .entry-summary .product_subtitle { <?php echo wtbx_font_styling_static($product_single_subtitle_typo); ?>; }
<?php }
?>


/*---------------------------------------------------------------*/
/* Buttons
/*---------------------------------------------------------------*/
<?php
$primary_selectors_array = wtbx_option('btn-primary-selectors');
$primary_selectors = $primary_selectors_hover = '';
if ( $primary_selectors_array !== '' ) {
	$primary_selectors_array = explode(',', wtbx_option('btn-primary-selectors'));
	foreach( $primary_selectors_array as $selector ) {
		$primary_selectors .= ',' . "\n" . trim($selector);
		$primary_selectors_hover .= ',' . "\n" . trim($selector) . ':hover';
	}
}

$secondary_selectors_array = wtbx_option('btn-secondary-selectors');
$secondary_selectors = $secondary_selectors_hover = '';
if ( $secondary_selectors_array !== '' ) {
	$secondary_selectors_array = explode(',', wtbx_option('btn-secondary-selectors'));
	foreach( $secondary_selectors_array as $selector ) {
		$secondary_selectors .= ',' . "\n" . trim($selector);
		$secondary_selectors_hover .= ',' . "\n" . trim($selector) . ':hover';
	}
}
?>
.wtbx-button-primary,
.wtbx-button-secondary,
.gdpr.gdpr-privacy-bar .gdpr-agreement, .gdpr.gdpr-reconsent-bar .gdpr-agreement,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper>form>footer input[type="submit"], .gdpr.gdpr-privacy-preferences .gdpr-wrapper .reconsent-form>footer input[type="submit"], .gdpr.gdpr-reconsent .gdpr-wrapper>form>footer input[type="submit"], .gdpr.gdpr-reconsent .gdpr-wrapper .reconsent-form>footer input[type="submit"], .gdpr.gdpr-general-confirmation .gdpr-wrapper>form>footer input[type="submit"], .gdpr.gdpr-general-confirmation .gdpr-wrapper .reconsent-form>footer input[type="submit"],
input[type="submit"]:not(.wtbx-button-secondary), button[type="submit"]:not(.wtbx-button-secondary), .wpcf7-submit, .widget_price_filter button[type="submit"], .woocommerce.add_to_cart_inline + .cart-label a<?php echo esc_html($primary_selectors), $secondary_selectors; ?> {
	display: inline-block;
	font-weight: 600;
	text-transform: none;
	letter-spacing: normal;
	text-align: center;
	cursor: pointer;
	white-space: nowrap;
	outline: none !important;
	line-height: 44px;
	padding: 0 25px;
	white-space: nowrap;
	-webkit-transition: all .3s ease-in-out;
	-moz-transition: all .3s ease-in-out;
	-ms-transition: all .3s ease-in-out;
	-o-transition: all .3s ease-in-out;
	transition: all .3s ease-in-out;
}
<?php // primary - default state ?>
.wtbx-button-primary, .gdpr.gdpr-privacy-bar .gdpr-agreement, .gdpr.gdpr-reconsent-bar .gdpr-agreement, input[type="submit"]:not(.wtbx-button-secondary), button[type="submit"]:not(.wtbx-button-secondary), .wpcf7-submit, .widget_price_filter button[type="submit"], .woocommerce.add_to_cart_inline + .cart-label a<?php echo esc_html($primary_selectors); ?>,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper>form>footer input[type="submit"], .gdpr.gdpr-privacy-preferences .gdpr-wrapper .reconsent-form>footer input[type="submit"], .gdpr.gdpr-reconsent .gdpr-wrapper>form>footer input[type="submit"], .gdpr.gdpr-reconsent .gdpr-wrapper .reconsent-form>footer input[type="submit"], .gdpr.gdpr-general-confirmation .gdpr-wrapper>form>footer input[type="submit"], .gdpr.gdpr-general-confirmation .gdpr-wrapper .reconsent-form>footer input[type="submit"] {
	color: <?php echo wtbx_option_sub('btn-primary-text-def','rgba'); ?> !important;
	background-color: <?php echo wtbx_option_sub('btn-primary-bg-def','rgba'); ?> !important;
	border: <?php echo wtbx_option_sub('btn-primary-border-def', 'border-top','0px'); ?> <?php echo wtbx_option_sub('btn-primary-border-def', 'border-style'); ?> <?php echo wtbx_option_sub('btn-primary-border-def', 'border-color'); ?>;
	border-radius: <?php echo intval(wtbx_option('btn-primary-border-radius-def')) . 'px'; ?>;
	<?php if ( wtbx_option('btn-primary-shadow-def') === 'shadow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(9,31,67,0.15);
	<?php } elseif ( wtbx_option('btn-primary-shadow-def') === 'glow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(<?php echo wtbx_hex2rgb(wtbx_option_sub('btn-primary-bg-def','color')); ?>, 0.6);
	<?php } ?>
}
.wtbx-loadmore-loading .wtbx-loadmore-loader, .wtbx-loading-grid {
	border-color: <?php echo wtbx_option_sub('btn-primary-bg-def','rgba'); ?>;
	background-color: <?php echo wtbx_option_sub('btn-primary-bg-def','rgba'); ?>;
<?php
	$lmc_1 = wtbx_rgba2array(wtbx_option_sub('btn-primary-bg-def','rgba'));
	$lmc_2 = wtbx_rgba2array(wtbx_option_sub('btn-primary-bg-def','rgba'));
?>
border-top-color: rgba(<?php echo esc_html($lmc_1[0]); ?>,<?php echo esc_html($lmc_1[1]); ?>,<?php echo esc_html($lmc_1[2]); ?>, 1) !important;
border-right-color: rgba(<?php echo esc_html($lmc_2[0]); ?>,<?php echo esc_html($lmc_2[1]); ?>,<?php echo esc_html($lmc_2[2]); ?>, 0.2) !important;
border-bottom-color: rgba(<?php echo esc_html($lmc_2[0]); ?>,<?php echo esc_html($lmc_2[1]); ?>,<?php echo esc_html($lmc_2[2]); ?>, 0.2) !important;
border-left-color: rgba(<?php echo esc_html($lmc_2[0]); ?>,<?php echo esc_html($lmc_2[1]); ?>,<?php echo esc_html($lmc_2[2]); ?>, 0.2) !important;

}
<?php // primary - hover state ?>
.wtbx-button-primary:hover, .gdpr.gdpr-privacy-bar .gdpr-agreement:hover, .gdpr.gdpr-reconsent-bar .gdpr-agreement:hover, input[type="submit"]:not(.wtbx-button-secondary):hover, .wpcf7-submit:hover, .widget_price_filter button[type="submit"]:hover, .woocommerce.add_to_cart_inline + .cart-label a:hover<?php echo esc_html($primary_selectors_hover); ?>,
.gdpr.gdpr-privacy-preferences .gdpr-wrapper>form>footer input[type="submit"]:hover, .gdpr.gdpr-privacy-preferences .gdpr-wrapper .reconsent-form>footer input[type="submit"]:hover, .gdpr.gdpr-reconsent .gdpr-wrapper>form>footer input[type="submit"]:hover, .gdpr.gdpr-reconsent .gdpr-wrapper .reconsent-form>footer input[type="submit"]:hover, .gdpr.gdpr-general-confirmation .gdpr-wrapper>form>footer input[type="submit"]:hover, .gdpr.gdpr-general-confirmation .gdpr-wrapper .reconsent-form>footer input[type="submit"]:hover {
	color: <?php echo wtbx_option_sub('btn-primary-text-hover','rgba'); ?> !important;
	background-color: <?php echo wtbx_option_sub('btn-primary-bg-hover','rgba'); ?> !important;
	border: <?php echo wtbx_option_sub('btn-primary-border-hover', 'border-top','0px'); ?> <?php echo wtbx_option_sub('btn-primary-border-hover', 'border-style'); ?> <?php echo wtbx_option_sub('btn-primary-border-hover', 'border-color'); ?>;
	border-radius: <?php echo intval(wtbx_option('btn-primary-border-radius-hover')) . 'px'; ?>;
	<?php if ( wtbx_option('btn-primary-shadow-hover') === 'none' ) { ?>
	box-shadow: none;
	<?php } elseif ( wtbx_option('btn-primary-shadow-hover') === 'shadow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(9,31,67,0.15);
	<?php } elseif ( wtbx_option('btn-primary-shadow-hover') === 'glow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(<?php echo wtbx_hex2rgb(wtbx_option_sub('btn-primary-bg-hover','color')); ?>, 0.6);
	<?php } ?>
}
<?php // secondary - default state ?>
.wtbx-button-secondary<?php echo esc_html($secondary_selectors); ?> {
	color: <?php echo wtbx_option_sub('btn-secondary-text-def','rgba'); ?>;
	background-color: <?php echo wtbx_option_sub('btn-secondary-bg-def','rgba'); ?>;
	border: <?php echo wtbx_option_sub('btn-secondary-border-def', 'border-top','0px'); ?> <?php echo wtbx_option_sub('btn-secondary-border-def', 'border-style'); ?> <?php echo wtbx_option_sub('btn-secondary-border-def', 'border-color'); ?>;
	border-radius: <?php echo intval(wtbx_option('btn-secondary-border-radius-def')) . 'px'; ?>;
	<?php if ( wtbx_option('btn-secondary-shadow-def') === 'none' ) { ?>
	box-shadow: none;
	<?php } elseif ( wtbx_option('btn-secondary-shadow-def') === 'shadow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(9,31,67,0.15);
	<?php } elseif ( wtbx_option('btn-secondary-shadow-def') === 'glow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(<?php echo wtbx_hex2rgb(wtbx_option_sub('btn-secondary-bg-def','color')); ?>, 0.6);
	<?php } ?>
}
<?php // secondary - hover state ?>
.wtbx-button-secondary:hover<?php echo esc_html($secondary_selectors_hover); ?> {
	color: <?php echo wtbx_option_sub('btn-secondary-text-hover','rgba'); ?>;
	background-color: <?php echo wtbx_option_sub('btn-secondary-bg-hover','rgba'); ?>;
	border: <?php echo wtbx_option_sub('btn-secondary-border-hover', 'border-top','0px'); ?> <?php echo wtbx_option_sub('btn-secondary-border-hover', 'border-style'); ?> <?php echo wtbx_option_sub('btn-secondary-border-hover', 'border-color'); ?>;
	border-radius: <?php echo intval(wtbx_option('btn-secondary-border-radius-hover')) . 'px'; ?>;
	<?php if ( wtbx_option('btn-secondary-shadow-hover') === 'none' ) { ?>
	box-shadow: none;
	<?php } elseif ( wtbx_option('btn-secondary-shadow-hover') === 'shadow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(9,31,67,0.15);
	<?php } elseif ( wtbx_option('btn-secondary-shadow-hover') === 'glow' ) { ?>
	box-shadow: 0 8px 35px -5px rgba(<?php echo wtbx_hex2rgb(wtbx_option_sub('btn-secondary-bg-hover','color')); ?>, 0.6);
	<?php } ?>
}

/*---------------------------------------------------------------*/
/* Default link
/*---------------------------------------------------------------*/
<?php
$link_text_color = wtbx_option_sub('link-text-color', 'rgba');
$link_bg_color = wtbx_option_sub('link-bg-color', 'rgba');
$link_text_color_hover = wtbx_option_sub('link-text-color-hover', 'rgba');
$link_bg_color_hover = wtbx_option_sub('link-bg-color-hover', 'rgba');

if ( $link_text_color !== '' ) { ?>
	.wtbx-link-underlined #content a, .wtbx-link-underlined-anim #content a, .wtbx-link-underlined-fill #content a, .wtbx-link-fill-left #content a, .wtbx-link-fill-bottom #content a, .wtbx-link-shift-up #content a { color: <?php echo esc_html($link_text_color);?> }
<?php }
if ( $link_bg_color !== '' ) { ?>
	.wtbx-link-underlined #content a:before, .wtbx-link-underlined-anim #content a:before, .wtbx-link-underlined-fill #content a:before, .wtbx-link-fill-left #content a:before, .wtbx-link-fill-bottom #content a:before, .wtbx-link-shift-up #content a:before { background-color: <?php echo esc_html($link_bg_color);?> }
<?php }
if ( $link_text_color_hover !== '' ) { ?>
	.wtbx-link-underlined #content a:hover, .wtbx-link-underlined-anim #content a:hover, .wtbx-link-underlined-fill #content a:hover, .wtbx-link-fill-left #content a:hover, .wtbx-link-fill-bottom #content a:hover, .wtbx-link-shift-up #content a:hover { color: <?php echo esc_html($link_text_color_hover);?> }
<?php }
if ( $link_bg_color_hover !== '' ) { ?>
	.wtbx-link-underlined #content a:hover:before, .wtbx-link-underlined-anim #content a:hover:before, .wtbx-link-underlined-fill #content a:hover:before, .wtbx-link-fill-left #content a:hover:before, .wtbx-link-fill-bottom #content a:hover:before, .wtbx-link-shift-up #content a:hover:before { background-color: <?php echo esc_html($link_bg_color_hover);?> }
<?php } ?>

/*---------------------------------------------------------------*/
/* Search
/*---------------------------------------------------------------*/
<?php
$search_panel_bg = wtbx_option_sub('search-panel-bg', 'rgba');
//$search_panel_backdrop = wtbx_option_sub('search-panel-backdrop-bg', 'rgba');
$search_panel_width = wtbx_option_sub('search-panel-content-hide', 'width');
$search_panel_height = wtbx_option_sub('search-panel-content-hide', 'height');

if ( $search_panel_bg !== '' ) { ?>
#wtbx_header_search_wrapper { background-color: <?php echo esc_html($search_panel_bg);?> }
<?php }
if ( $search_panel_width !== '' ) { ?>
@media only screen and (max-width: <?php echo intval($search_panel_width); ?>px), only screen and (max-height: <?php echo intval($search_panel_height); ?>px) {
	#wtbx_header_search_wrapper .wtbx_search_content { display: none; }
	#wtbx_header_search_wrapper { display: table; height: 100%; width: 100%; }
	#wtbx_header_search_wrapper .wtbx_header_search { display: table-cell; vertical-align: middle; width: 100%; }
	#wtbx_header_search_wrapper .wtbx-button { display: block; }
}
<?php } ?>

/*---------------------------------------------------------------*/
/* Header overlay
/*---------------------------------------------------------------*/
<?php
$overlay_panel_bg = wtbx_option_sub('ho-bg', 'rgba');

if ( $overlay_panel_bg !== '' ) { ?>
	#wtbx_header_overlay { background-color: <?php echo esc_html($overlay_panel_bg);?> }
<?php } ?>

/*---------------------------------------------------------------*/
/* Header sidearea
/*---------------------------------------------------------------*/
<?php
$sidearea_bg = wtbx_option_sub('hs-bg', 'rgba');
$sidearea_width = intval(wtbx_option('hs-width'));

if ( $sidearea_bg !== '' ) { ?>
	#wtbx_header_sidearea { background-color: <?php echo esc_html($sidearea_bg);?> }
<?php }
if ( $sidearea_width !== '' ) { ?>
	#wtbx_header_sidearea { width: <?php echo esc_html($sidearea_width);?>px }
	.wtbx_sidearea_close { right: <?php echo esc_html($sidearea_width);?>px }
<?php } ?>

/*---------------------------------------------------------------*/
/* Post entry
/*---------------------------------------------------------------*/
<?php
$post_entry_heading_font = wtbx_option_sub('post-heading-font', 'typography');
$post_entry_content_font = wtbx_option_sub('post-content-font', 'typography');

if ( $post_entry_heading_font !== '' ) { ?>
	body.single-post article.post-entry h1.entry-title { <?php echo wtbx_font_styling_static($post_entry_heading_font); ?> }
<?php }
if ( $post_entry_content_font !== '' ) { ?>
	body.single-post article.post-entry .entry-content { <?php echo wtbx_font_styling_static($post_entry_content_font); ?> }
<?php } ?>

/*---------------------------------------------------------------*/
/* Custom CSS
/*---------------------------------------------------------------*/
<?php
$custom_css = wtbx_option('custom-css');
if ( !empty($custom_css) ) {
	echo "/* Custom CSS */\n\n" . $custom_css;
}

$saved_fonts = array(
	'fonts' => WtbxFontsEnqueue::$fonts,
	'googlefonts' => WtbxFontsEnqueue::$googlefonts,
	'variants' => WtbxFontsEnqueue::$font_variants,
	'subsets' => WtbxFontsEnqueue::$font_subsets
);

update_option('scape_theme_footer_fonts', $saved_fonts);