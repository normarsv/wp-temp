<?php
$img_src        = $img_srcset = '';
$imgID          = get_post_thumbnail_id($postID);
$alt            = get_the_title();
$grid_style     = 'masonry';
$item_layout    = get_post_meta($postID, 'portfolio-item-media', true);
$type = $poster = $title = '';
$ratio          = '1:1';

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

?>

<article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry clearfix wtbx-masonry-entry wtbx-grid-entry wtbx-grid-anim-container touchhover'); ?>>

	<?php if ( !empty($animation_style) ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="portfolio-masonry-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation<?php if ($mousemove === 'true') {echo ' wtbx-rollhover wtbx-rollhover-static';} ?> wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

		<div class="portfolio-masonry-media wtbx-entry-media">
			<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt, 'portfolio-thumb-wrapper wtbx-rollhover-layer'); ?>
		</div>

		<div class="portfolio-entry-overlay portfolio-overlay-idle">
			<?php include(locate_template('templates/portfolio/portfolio-entry-idle.php')); ?>
		</div>

		<div class="portfolio-entry-overlay portfolio-overlay-hover">
			<?php include(locate_template('templates/portfolio/portfolio-entry-hover.php')); ?>
		</div>

	</div>
</article>