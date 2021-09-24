<?php

$margin = get_post_meta( $postID, 'portfolio-item-vertical-gutter', true );
$src_size = 'large';

if ( $margin !== '' && $margin != '0' ) {
    wtbx_js_styles('.portfolio-item-gallery-vertical .portfolio-image-wrapper {margin: 30px 0 0;}');
}

if ( $attachments != '' ) : ?>

	<div class="portfolio-item-media portfolio-item-<?php echo esc_html($media); ?> wtbx-lightbox-container row-inner clearfix"<?php echo wtbx_lightbox_attributes(); ?>>
		<?php foreach ( (array) $attachments as $imgID => $imgURL ) { ?>
			<a class="wtbx-lightbox-item portfolio-image-wrapper wtbx-reveal-cont wtbx-col-sm-12 wtbx_preloader_cont" href="<?php echo esc_url(wp_get_attachment_image_url( $imgID, 'full' )); ?>" data-thumbimage="<?php echo esc_attr(wp_get_attachment_image_url( $imgID, 'medium' )); ?>">
				<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
					include(locate_template('templates/components/preloader.php'));
				endif; ?>
				<div class="portfolio-image-inner wtbx-element-reveal">
					<?php wtbx_image_smart_img($imgID, $src_size, $srcset_size, wtbx_get_alt_text($imgID), 'portfolio-image'); ?>
				</div>
			</a>
		<?php } ?>
	</div>

	<?php include(locate_template('templates/components/lightbox-nav.php')); ?>

<?php endif; ?>