<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();
$grid_style = 'metro';

// post tile size
if ( $grid_layout === 'default' ) {
	$width = $height = 1;
} elseif ( $grid_layout === 'individual' ) {
	$width  = get_post_meta($postID, 'portfolio-list-width', true);
	$height = get_post_meta($postID, 'portfolio-list-height', true);
	$width  = $width ? $width : 1;
	$height = $height ? $height : 1;
} else {
	$current = $current_post-$tiles*$counter;
	$width  = $layout_obj['width'][$current];
	$height = $layout_obj['height'][$current];
}


// preview media ratio
$aspect_ratio = $width . ':' . $height;

if ($imgID) {
	$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
	$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );

	// get global aspect ratio
	$ratio = $aspect_ratio;
}

?>

<article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry clearfix wtbx-metro-entry wtbx-grid-entry wtbx-grid-anim-container touchhover'); ?> data-width="<?php echo esc_attr($width); ?>" data-height="<?php echo esc_attr($height); ?>">

	<?php if ( !empty($animation_style) ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="portfolio-metro-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation<?php if ($mousemove === 'true') {echo ' wtbx-rollhover wtbx-rollhover-static';} ?> wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

		<div class="portfolio-metro-media wtbx-entry-media">
			<?php wtbx_image_smart_bg($imgID, $src_size, $srcset_size, $ratio, $alt, 'wtbx-rollhover-layer'); ?>
		</div>

		<div class="portfolio-entry-overlay portfolio-overlay-idle">
			<?php include(locate_template('templates/portfolio/portfolio-entry-idle.php')); ?>
		</div>

		<div class="portfolio-entry-overlay portfolio-overlay-hover">
			<?php include(locate_template('templates/portfolio/portfolio-entry-hover.php')); ?>
		</div>

	</div>
</article>