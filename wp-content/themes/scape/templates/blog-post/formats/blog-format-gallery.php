<?php

$attachments    = get_post_meta( $postID, 'post-add-slides', 1 );
$skin           = get_post_meta( $postID, 'post-slides-skin', 1 );
$skin           = $skin !== '' ? $skin : 'light';

// get global aspect ratio
$ratio = isset($aspect_ratio) ? $aspect_ratio :'';

// if empty - get it from image size
if ($ratio === '') {
	$ratio = get_post_meta( $postID, 'post-slides-ratio', true );
}

if ( !empty($attachments) ) : ?>

	<div class="post-media wtbx-reveal-cont wtbx_preloader_cont">
		<?php if (empty($blog_type) || $blog_type !== 'masonry' ) {
			if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
				include(locate_template('templates/components/preloader.php'));
			endif; ?>
			<div class="post-media-inner wtbx_appearance_animation wtbx-element-reveal">
		<?php } ?>

			<div class="post-gallery wtbx-slider-gallery gallery-skin-<?php echo esc_attr($skin); ?>">
				<?php foreach ( (array) $attachments as $imgID => $imgURL ) : ?>
                    <div class="post-gallery-image">
                        <?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, wtbx_get_alt_text($imgID)); ?>
                    </div>
				<?php endforeach; ?>
			</div>

		<?php if (empty($blog_type) || $blog_type !== 'masonry' ) { ?>
		</div>
		<?php } ?>
	</div>

<?php endif; ?>