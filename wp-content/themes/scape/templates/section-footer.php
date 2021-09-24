<?php
$skin       = wtbx_option_levelled('footer-skin');
$breakpoint = wtbx_option_levelled('footer-breakpoint');

$footer_color_text          = wtbx_option_levelled('footer-color-text');
$footer_color_text_dark     = wtbx_option_levelled('footer-color-text-dark');
$footer_color_text_light    = wtbx_option_levelled('footer-color-text-light');
$footer_color_link          = wtbx_option_levelled('footer-color-link');
$footer_color_link_hover    = wtbx_option_levelled('footer-color-link-hover');

$footer_styles = '';
if ( $footer_color_text !== '' ) {
    $footer_styles .= '#footer, #footer .widget .wtbx_recent_posts_cont .entry-content, #footer .wtbx_recent_comments .wtbx-recent-comment .comment-text, #footer .widget_archive ul li, #footer .widget_categories ul li, #footer .widget_rss .rssSummary, #footer .widget_text, #footer .widget_recent_comments {color: ' . esc_html($footer_color_text) . '}';
}
if ( $footer_color_text_dark !== '' ) {
    $footer_styles .= '#footer .widget .widget-title, #footer .widget_wtbx_recent_posts_widget .entry-title a, #footer .widget_wtbx_recent_comments_widget .post-link, #footer .widget_wtbx_recent_comments_widget .url, #footer .widget:not(.widget_wtbx_login) a, #footer #wp-calendar th, #footer #wp-calendar td, #footer #wp-calendar caption, #footer .widget_rss cite, #footer .wtbx_recent_posts_cont .meta-comments:hover, #footer .wtbx_recent_posts_cont .meta-comments:hover * {color: ' . esc_html($footer_color_text_dark) . '}';
}
if ( $footer_color_text_light !== '' ) {
    $footer_styles .= '#footer .widget_rss .rss-date, #footer .wtbx_recent_posts_cont .entry-meta *, #footer .wtbx_recent_comments .entry-meta, #footer .wtbx_recent_comments .comment-meta, #footer .author-position, #footer .wtbx_author_widget .author-contact-link:not(:hover) i, #footer .wtbx_recent_comments .comments-date {color: ' . esc_html($footer_color_text_light) . '}';
}
if ( $footer_color_link !== '' ) {
	$footer_styles .= '#footer .widget a {color: ' . esc_html($footer_color_link) . '}';
}
if ( $footer_color_link_hover !== '' ) {
	$footer_styles .= '#footer .widget a:hover {color: ' . esc_html($footer_color_link_hover) . '}';
}
?>

<footer id="footer" class="wtbx_skin_<?php echo esc_attr($skin); ?>"<?php if ($breakpoint !== '') { echo ' data-breakpoint="' . esc_attr($breakpoint) . '"'; } ?>>
    <?php
    if ( !empty($footer_styles) ) {
        wtbx_js_styles($footer_styles);
    }

    $section_ID = wtbx_option_levelled('footer-block');
    if ( $section_ID !== '' ) {
	    $section_ID = wtbx_get_translated_content_block($section_ID);
	    $s_ID       = get_post($section_ID);
	    $content    = !empty($s_ID) ? $s_ID->post_content : '';
	    echo apply_filters('the_content', $content);
    }

    ?>
</footer>