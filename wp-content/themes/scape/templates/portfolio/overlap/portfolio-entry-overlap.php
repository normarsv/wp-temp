<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();
$grid_style = 'overlap';

if ($imgID) {
	// get global aspect ratio
	$ratio = $aspect_ratio;

	// if empty - get it from image size
	if (!$ratio) {
	    $metadata = wp_get_attachment_metadata( $imgID );
		if ( isset($metadata['width']) && isset($metadata['height']) ) {
			$ratio = $metadata['width'] . ':' . $metadata['height'];
		} else {
			$ratio = '1:1';
		}
	}
}

// unique gallery ID
if ( in_array($click_action, array('gallery_item', 'preview') )) {
	$lightbox_item_id = hexdec(substr(uniqid(), 6, 7));
}

$inner_content = ' content-' . $content;

?>

<article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry wtbx-grid-entry wtbx-grid-anim-container'); ?>>

	<?php if ( !empty($animation_style) ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

    <div class="portfolio-overlap-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

        <div class="portfolio-overlap-media wtbx-entry-media">
            <a href="<?php the_permalink(); ?>" class="portfolio-overlap-media-link">
                <?php wtbx_image_smart_bg($imgID, $src_size, $srcset_size, $ratio, $alt, 'portfolio-thumb-wrapper' ); ?>
            </a>
        </div>

	    <?php if ( $meta_primary || $meta_secondary ) : ?>
        <div class="portfolio-overlap-meta">
            <div class="portfolio-entry-meta">
			    <?php
			    if ( $meta_secondary ) echo wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary', strpos($meta_primary, '_link') !== false);
			    if ( $meta_primary ) echo wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary', strpos($meta_primary, '_link') !== false);
			    ?>
            </div>
            <?php if ( $excerpt_length ) : ?>
                <div class="portfolio-overlap-excerpt wtbx-text"><?php echo wtbx_excerpt($excerpt_length); ?></div>
            <?php endif; ?>
            <div class="portfolio-meta-button">
                <a href="<?php the_permalink(); ?>" class="portfolio-overlap-button">See Details</a>
            </div>
        </div>
	    <?php endif; ?>

    </div>
</article>