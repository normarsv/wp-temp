<?php
$row_height = get_post_meta( $postID, 'portfolio-item-grid-height', true );
$gutter     = get_post_meta( $postID, 'portfolio-item-vertical-gutter', true );
$ratio      = get_post_meta($postID, 'portfolio-item-images-ratio', true);
$src_size   = 'medium';

$layout_js_styles = '';
$layout_js_styles .= $gutter !== '' ? '.portfolio-item-grid-wrapper {grid-column-gap:'.esc_html($gutter).'px; grid-row-gap:'.esc_html($gutter).'px}' : '';
$layout_js_styles .= '.portfolio-item-grid-wrapper {grid-template-columns: repeat(2, 1fr)} .portfolio-image-wrapper:first-child {grid-column-start: 1; grid-column-end: 3;}';
$layout_js_styles .= !empty($attachments) && sizeof($attachments)  % 2 == 0 ? '.portfolio-image-wrapper:last-child {grid-column-start: 1; grid-column-end: 3;}' : '';
if ( !empty($layout_js_styles) ) {
	wtbx_js_styles($layout_js_styles);
}

if ( !empty($attachments) ) : ?>

	<div class="portfolio-item-media portfolio-item-<?php echo esc_html($media); ?> row-inner clearfix">
		<div class="portfolio-item-grid-wrapper wtbx-col-sm-12 wtbx-lightbox-container" <?php echo wtbx_lightbox_attributes(); ?>>

			<?php foreach ( (array) $attachments as $imgID => $imgURL ) {
			    ?>
				<div class="portfolio-image-wrapper wtbx-reveal-cont wtbx_preloader_cont">
					<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
						include(locate_template('templates/components/preloader.php'));
					endif; ?>
					<a class="wtbx-lightbox-item wtbx-element-reveal" href="<?php echo esc_url(wp_get_attachment_image_url( $imgID, 'full' )); ?>" data-thumbimage="<?php echo esc_attr(wp_get_attachment_image_url( $imgID, 'medium' )); ?>">
						<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, wtbx_get_alt_text($imgID), 'wtbx-entry-media'); ?>
					</a>
				</div>
			<?php } ?>

		</div>
	</div>

	<?php include(locate_template('templates/components/lightbox-nav.php')); ?>

<?php endif; ?>