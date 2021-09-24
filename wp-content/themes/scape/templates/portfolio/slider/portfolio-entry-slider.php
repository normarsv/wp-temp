<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();
$grid_style = 'slider';
?>

<div id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry wtbx-slider-entry wtbx-grid-entry wtbx-grid-anim-container touchhover'); ?> role="article" data-postid="<?php echo esc_attr($postID); ?>">
    <div class="portfolio-slider-wrapper wtbx_preloader_cont">
	    <?php if ( !empty($animation_style) ) {
		    include(locate_template('templates/components/preloader.php'));
	    } ?>
        <div class="portfolio-slider-inner clearfix wtbx-reveal-cont wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">
            <div class="portfolio-slider-media wtbx-entry-media wtbx-click">
                <?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, false, $alt); ?>
                <a href="<?php the_permalink(); ?>"></a>
            </div>
        </div>
    </div>
</div>