<?php
/*	
*	---------------------------------------------------------------------
*	WTBX Template part: hero section
*	--------------------------------------------------------------------- 
*/
?>

<?php
$postID = wtbx_get_the_id();
$page_header_classes = array();

// get appropriate type and template for header section
$type          = wtbx_option_levelled('header-section');
$section_block = wtbx_option_levelled('header-section-block');
$custom_enable = wtbx_option_levelled('header-section-custom');

// decoration
$decoration_layout  = wtbx_option_levelled('header-section-decoration-layout');
$decoration_color   = wtbx_option_levelled('header-section-decoration-color');
$decoration_layout !== '' ? $page_header_classes[] = 'with-decoration wtbx-decoration-' . $decoration_layout : null;

// scroll effect
//$scroll_effect = wtbx_option_levelled('header-section-scroll-effect');
//$scroll_effect !== '' && $type !== 'content_block' ? $page_header_classes[] = 'has-scroll-effect' : '';
//$scroll_effect !== '' && $type !== 'content_block' ? $page_header_classes[] = 'scroll-' . $scroll_effect : null;
$scroll_full = wtbx_option_levelled('header-section-scroll-full');

// general settings
$layout_number  = wtbx_option_levelled('header-section-layout');
$layout         = 'layout-' . $layout_number;

is_author() || ( is_singular('post') && in_array(wtbx_option('header-section-post'), array('custom_1', 'custom_2')) ) ? null : $page_header_classes[] = $layout ;
$page_header_classes[] = 'type-' . $type;

$min_height = wtbx_option_levelled('header-section-height');
$rel_height = wtbx_option_levelled('header-section-height-slider');

// additional padding
$padding_top    = wtbx_option_levelled('header-section-padding-top');
$padding_bottom = wtbx_option_levelled('header-section-padding-bottom');

// title
$title_styles   = wtbx_font_styling(wtbx_option_levelled('header-section-title', 'typography'));

// breadcrumbs
$bc_styles      = wtbx_font_styling(wtbx_option_levelled('header-section-bc', 'typography'));

// skin
$hero_skin      = wtbx_option_levelled('header-section-skin');

// fadeout effect
if ( wtbx_option_levelled('header-section-fadeout') === '1' ) {
    $page_header_classes[] = 'wtbx-fadeout';
}



$layouts_array  = array('layout-three', 'layout-four', 'layout-five', 'layout-six');
$header_styles = $bg_color = $bg_overlay = '';


// background image
$bg_image_styles = $imgID = $bg_opacity = '';

if ( wtbx_option_levelled('header-section-bg-featured') === 'on' && !is_archive() ) {
    $imgID = get_post_thumbnail_id($postID);
} else {
	if ( wtbx_option_levelled('header-section-bg-featured') === 'on' && class_exists('Woocommerce') && is_product_category() ) {
		$cat = get_queried_object();
		$imgID = get_term_meta( $cat->term_id, 'thumbnail_id', true );
	} else {
		$bg_image = wtbx_option_levelled('header-section-bg-image', 'background-image');
		if ( $bg_image !== '' ) {
			$imgID = attachment_url_to_postid($bg_image);
		}
    }
}

if ( $imgID !== '' ) {
	$img_src        = wp_get_attachment_image_url( $imgID, 'large' );
	$img_srcset     = wp_get_attachment_image_srcset( $imgID, 'full' );

	$bg_repeat      = wtbx_option_levelled('header-section-bg-image', 'background-repeat');
	$bg_position    = wtbx_option_levelled('header-section-bg-image', 'background-position');
	$bg_size        = wtbx_option_levelled('header-section-bg-image', 'background-size');
	$bg_attachment  = wtbx_option_levelled('header-section-bg-image', 'background-attachment');

	$bg_image_styles .= $bg_repeat !== '' ? 'background-repeat: '.$bg_repeat.';' : '';
	$bg_image_styles .= $bg_position !== '' ? 'background-position: '.$bg_position.';' : '';
	$bg_image_styles .= $bg_size !== '' ? 'background-size: '.$bg_size.';' : '';
	$bg_image_styles .= $bg_attachment !== '' ? 'background-attachment: '.$bg_attachment.';' : '';
}


// background color
$bg_color = wtbx_option_levelled('header-section-bg-image', 'background-color');

// parallax
$parallax_class = wtbx_option_levelled('header-section-parallax');
if ( $parallax_class !== '' && $parallax_class !== 'none' ) {
	$parallax_class         = ' ' . $parallax_class;
	$parallax_cont          = ' wtbx_parallax_container';
	$parallax_str           = wtbx_option_levelled('header-section-parallax-strength');
} else {
	$parallax_str = $parallax_cont = '';
}

// overlay
if ( wtbx_option('header-section-overlay-color-global') !== '' ) {
	$bg_overlay = 'background: ' . wtbx_option_levelled('header-section-overlay-color', 'rgba') . ';';
}
// scroll-down button
$scrolldown         = wtbx_option_levelled('header-section-scrolldown-style');
$scrolldown_skin    = wtbx_option_levelled('header-section-scrolldown-skin');

// collect styles
$header_styles .= $padding_top !== '' ? '#page-header .page-header-inner { padding-top: '.intval(esc_html($padding_top)).'px}' : '';
$header_styles .= $padding_bottom !== '' ? '#main #page-header .page-header-inner, #main #page-header.layout-two .wtbx-page-breadcrumbs { padding-bottom: '.intval(esc_html($padding_bottom)).'px}' : '';

$header_styles .= ($rel_height !== '' && $rel_height !== '0' && $rel_height !== '-1') ? '#page-header { height: '.intval(esc_html($rel_height)).'vh}' : '';
$header_styles .= ($min_height !== '' && $min_height !== '0' && $min_height !== '-1') ? '#page-header { min-height: '.intval(esc_html($min_height)).'px; height: '.intval(esc_html($min_height)).'px}' : '';
$header_styles .= $bg_color !== '' ? '#page-header { background-color: '.esc_html($bg_color).'}' : '';
$header_styles .= $bg_overlay !== '' ? '.page-header-overlay {'.esc_html($bg_overlay).'}' : '';
$header_styles .= $bg_image_styles !== '' ? '.page-header-image .wtbx-bg-image .wtbx-bg-image-inner .wtbx-lazy {'.esc_html($bg_image_styles).'}' : '';
$header_styles .= $title_styles !== '' ? '#page-header .page-header-inner .wtbx-page-title, #page-header .page-header-inner .wtbx-page-title h1 {'.$title_styles.'}' : '';
$header_styles .= $bc_styles !== '' ? '#page-header .wtbx-page-breadcrumbs .breadcrumbs-path, #page-header .wtbx-page-breadcrumbs .breadcrumbs-path a { '.$bc_styles.'}' : '';

// compile header class
$page_header_classes = implode(' ', $page_header_classes);

if ( ( $type !== '' && $type !== 'off') || is_author() ) {
    wp_enqueue_style('scape-hero');
	wp_enqueue_script('scape-pageheader');
	wp_enqueue_script('scape-parallax');

	if ( is_author() ) {
		include(locate_template( 'templates/hero/hero-author.php' ));
	} elseif ( is_singular('post') && in_array(wtbx_option('header-section-post'), array('custom_1', 'custom_2')) ) {
		include(locate_template( 'templates/hero/hero-post.php' ));
	} else {
		if ( $type === 'content_block' && $section_block !== '' ) {

			if ( $section_block !== '' ) {
				$section_block = wtbx_get_translated_content_block($section_block);
				$s_ID = get_post($section_block);
				$content = $s_ID->post_content;
				?>

				<div id="page-header" class="<?php echo esc_attr($page_header_classes); ?>" data-fullscroll="<?php echo esc_attr($scroll_full); ?>">
					<?php echo apply_filters('the_content', $content);
					if ( $decoration_layout !== '') {
						wtbx_decoration($decoration_layout, $decoration_color);
					} ?>

					<?php wtbx_scroll_down_button($scrolldown, $scrolldown_skin); ?>

				</div>
			<?php }

		} elseif ( $type === 'default' ) { ?>
            
			<?php wtbx_js_styles($header_styles); ?>

            <div id="page-header" class="<?php echo esc_attr($page_header_classes); ?> wtbx_parallax_wrapper" data-layout="<?php echo esc_attr($layout_number); ?>" data-decoration="<?php echo esc_attr($decoration_layout); ?>" data-fullscroll="<?php echo esc_attr($scroll_full); ?>" data-skin="<?php echo esc_attr($hero_skin); ?>">
				<div class="page-header-bg-wrapper">
					<div class="page-header-bg wtbx-element-reveal wtbx-reveal-cont<?php echo esc_attr($parallax_cont); ?>">
						<div class="page-header-image-wrapper">
							<div class="page-header-image wtbx-entry-media <?php echo esc_attr($parallax_class); ?>" data-parallax-strength="<?php echo esc_attr($parallax_str); ?>">
								<?php if ( $imgID !== '' ) {
									wtbx_image_smart_bg($imgID, 'large', 'full', false, wtbx_get_alt_text($imgID));
								} ?>
							</div>
						</div>
						<div class="page-header-shadow"></div>
					</div>
				</div>
				<div class="page-header-overlay"></div>

				<div class="page-header-inner<?php if ($parallax_class === ' wtbx_parallax_mousemove') { echo ' wtbx-parallax-capture'; } ?>">

					<?php if ( $layout === 'layout-two' ) {
						echo wtbx_breadcrumbs();
					} ?>

                    <div class="page-header-content clearfix">

					<?php echo in_array($layout, $layouts_array) ? '<div class="row-inner clearfix"><div class="wtbx-col-sm-12"><div class="page-header-wrapper">' : ''; ?>

					<div class="wtbx-page-title">
						<div class="row-inner clearfix">
							<div class="wtbx-col-sm-12">
								<h1><?php echo wtbx_get_the_title($postID); ?></h1>
							</div>
						</div>
					</div>

					<?php if ( $layout !== 'layout-two' ) {
						echo wtbx_breadcrumbs();
					} ?>

					<?php echo in_array($layout, $layouts_array) ? '</div></div></div>' : ''; ?>

                    </div>

					<?php wtbx_scroll_down_button($scrolldown, $scrolldown_skin); ?>

                </div>

				<?php

				if ( $decoration_layout !== '' ) {
					wtbx_decoration($decoration_layout, $decoration_color);
				}
				?>

			</div>

		<?php }
	}


}