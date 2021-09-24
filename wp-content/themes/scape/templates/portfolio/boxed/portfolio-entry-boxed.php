<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();
$grid_style = 'boxed';

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

<article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry clearfix wtbx-masonry-entry wtbx-grid-entry touchhover'.$inner_content); ?>>

	<?php if ( !empty($animation_style) ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>
	<div class="wtbx-rollhover-container">
		<div class="wtbx-rollhover wtbx-grid-anim-container">
			<div class="portfolio-boxed-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

				<div class="portfolio-boxed-media wtbx-entry-media">
					<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt, 'portfolio-thumb-wrapper'); ?>
				</div>

                <div class="portfolio-entry-overlay portfolio-overlay-idle">
                    <?php include(locate_template('templates/portfolio/portfolio-entry-idle.php')); ?>
                </div>

                <div class="portfolio-entry-overlay portfolio-overlay-hover">
                    <?php include(locate_template('templates/portfolio/portfolio-entry-hover.php')); ?>
                </div>

			</div>
		</div>
	</div>
</article>