<?php

$arrows = get_post_meta($postID, 'portfolio-item-arrows', true);
$bullets = get_post_meta($postID, 'portfolio-item-bullets', true);

if ( $attachments != '' ) : ?>
<div class="portfolio-item-media portfolio-item-<?php echo esc_html($media); ?> row-inner clearfix">
    <div class="portfolio-slider-container wtbx-reveal-cont wtbx-col-sm-12 wtbx_preloader_cont">

        <?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
            include(locate_template('templates/components/preloader.php'));
        endif; ?>

        <div class="portfolio-slider wtbx-slider-gallery arrows-skin-<?php echo esc_attr($arrows); ?> bullets-skin-<?php echo esc_attr($bullets); ?> wtbx-element-reveal">
            <?php foreach ( (array) $attachments as $imgID => $imgURL ) : ?>
                <div class="portfolio-slide">
	                <?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, wtbx_get_alt_text($imgID)); ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
<?php endif; ?>