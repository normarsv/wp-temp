<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();
$grid_style = 'panels';
?>

<div id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry clearfix wtbx-panels-entry wtbx-grid-entry wtbx-grid-anim-container wtbx_preloader_cont touchhover'); ?> role="article" data-postid="<?php echo esc_attr($postID); ?>">

	<?php if ( !empty($animation_style) ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="portfolio-panels-inner clearfix wtbx-reveal-cont wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">
		<div class="portfolio-panels-media wtbx-entry-media">
			<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, false, $alt); ?>
            <a href="<?php the_permalink(); ?>"></a>
        </div>
	</div>
</div>