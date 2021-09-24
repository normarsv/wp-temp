<?php
$content_width = intval(wtbx_option('site-width', 1200));
?>
.wp-block {
	max-width: <?php echo esc_html($content_width); ?>px;
}
/* Width of "wide" blocks */
.wp-block[data-align="wide"] {
    max-width: <?php echo esc_html($content_width); ?>px;
}
/* Width of "full-wide" blocks */
.wp-block[data-align="full"] {
    max-width: none;
}
<?php
$typo_general = wtbx_font_styling('typo-general', false);
if ( $typo_general !== '' ) { ?>
.editor-styles-wrapper .wp-block,
.editor-styles-wrapper .editor-post-title__block .editor-post-title__input {<?php print_r($typo_general);?> }
<?php }

$typo_h = wtbx_font_styling('typo-h', false);
if ( $typo_h !== '' ) { ?>
.editor-styles-wrapper .wp-block h1,
.editor-styles-wrapper .wp-block h2,
.editor-styles-wrapper .wp-block h3,
.editor-styles-wrapper .wp-block h4,
.editor-styles-wrapper .wp-block h5,
.editor-styles-wrapper .wp-block h6,
.editor-styles-wrapper .editor-post-title__block .editor-post-title__input {<?php print_r($typo_h);?> }
<?php }

$typo_h1 = wtbx_font_styling('typo-h1', false);
if ( $typo_h1 !== '' ) { ?>
.editor-styles-wrapper .wp-block h1,
.editor-styles-wrapper .editor-post-title__block .editor-post-title__input {<?php echo esc_html($typo_h1);?> }
<?php }

$typo_h2 = wtbx_font_styling('typo-h2', false);
if ( $typo_h2 !== '' ) { ?>
.editor-styles-wrapper .wp-block h2 {<?php echo esc_html($typo_h2);?> }
<?php }

$typo_h3 = wtbx_font_styling('typo-h3', false);
if ( $typo_h3 !== '' ) { ?>
.editor-styles-wrapper .wp-block h3 {<?php echo esc_html($typo_h3);?> }
<?php }

$typo_h4 = wtbx_font_styling('typo-h4', false);
if ( $typo_h4 !== '' ) { ?>
.editor-styles-wrapper .wp-block h4 {<?php echo esc_html($typo_h4);?> }
<?php }

$typo_h5 = wtbx_font_styling('typo-h5', false);
if ( $typo_h5 !== '' ) { ?>
.editor-styles-wrapper .wp-block h5 {<?php echo esc_html($typo_h5);?> }
<?php }

$typo_h6 = wtbx_font_styling('typo-h6', false);
if ( $typo_h6 !== '' ) { ?>
.editor-styles-wrapper .wp-block h6 {<?php echo esc_html($typo_h6);?> }
<?php }

$color_text_def = wtbx_option('color-main-text-color');
if ($color_text_def !== '') { ?>
.editor-styles-wrapper .wp-block {
	color: <?php echo esc_html($color_text_def); ?>;
}
<?php }

$color_text_dark = wtbx_option('color-main-text-dark');
if ($color_text_dark !== '') { ?>
.wp-block-heading h1,
.wp-block-heading h2,
.wp-block-heading h3,
.wp-block-heading h4,
.wp-block-heading h5,
.wp-block-heading h6,
.editor-styles-wrapper blockquote,
.editor-styles-wrapper .wp-caption figcaption,
.wp-block-pullquote,
.wp-block-latest-comments__comment-meta, .wp-block-latest-comments__comment-meta a:not(:hover),
.wp-block-latest-posts a:not(:hover),
.wp-block-categories a:not(:hover) {
	color: <?php echo esc_html($color_text_dark); ?>;
}
<?php }

$color_text_light = wtbx_option('color-main-text-light');
if ($color_text_light !== '') { ?>
.wp-block-latest-comments__comment-date,
.wp-block-latest-posts__post-date {
	color: <?php echo esc_html($color_text_light); ?>;
}
<?php }

$color_accent = wtbx_option('color-main-accent');
if ($color_accent !== '') { ?>
.editor-styles-wrapper .wp-block-quote.is-style-default {
	border-color: <?php echo esc_html($color_accent); ?>;
}
.editor-styles-wrapper a {
	color: <?php echo esc_html($color_accent); ?>;
}
<?php }
?>

.editor-styles-wrapper blockquote {
	margin: 3em 3em;
	position: relative;
	text-align: center;
}

.editor-styles-wrapper.editor-block-preview__content blockquote {
	margin: 0;
}

.wp-block-quote:not(.is-large):not(.is-style-large) {
	border-left-style: none;
	border-left-width: 0;
	padding-left: 0;
}

.editor-styles-wrapper .wp-block-quote.is-style-default {
	border-left-style: solid;
	border-left-width: 2px;
	padding-left: 1em;
	text-align: start;
}

.editor-styles-wrapper blockquote p,
.editor-styles-wrapper .wp-block-quote.is-style-large p {
	font-style: italic;
	font-size: 1.285714em;
	font-weight: 500;
}

.wp-block-freeform.block-library-rich-text__tinymce blockquote {
	border-left: none;
	padding-left: 0;
}

.editor-styles-wrapper .wp-block-button__link {
	font-weight: 600;
}

.editor-styles-wrapper a {
	text-decoration: none;
	outline: none !important;
}

.editor-styles-wrapper .wp-block-latest-comments__comment {
	margin-bottom: 2em;
}

.editor-styles-wrapper .wp-block-latest-comments__comment-meta {
	font-weight: 600;
}

.block-editor .editor-styles-wrapper .wp-block-latest-posts {
	list-style: none;
	padding-left: 0;
}

.editor-styles-wrapper .wp-block-latest-posts li {
	margin-bottom: 1em;
}

.editor-styles-wrapper .wp-block-latest-posts li:last-child {
	margin-bottom: 0;
}

.editor-styles-wrapper .wp-block-latest-posts a {
	font-weight: 600;
}

.block-editor .editor-styles-wrapper .wp-block-categories__list {
	list-style: none;
	padding-left: 0;
}

.editor-styles-wrapper .wp-block-categories__list li {
	margin-bottom: 10px;
}

.editor-styles-wrapper .wp-block-categories__list li:last-child {
	margin-bottom: 0;
}

.editor-styles-wrapper .wp-block-categories__list a {
	font-weight: 600;
}

.editor-styles-wrapper .wp-block-categories__dropdown {
	display: block;
	height: 44px;
	line-height: 44px;
	padding: 0 15px;
	margin: 0;
	border-radius: 6px;
	vertical-align: middle;
}