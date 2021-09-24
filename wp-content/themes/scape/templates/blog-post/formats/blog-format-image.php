<?php
$imgID      = get_post_meta( $postID, 'post-add-image_id', 1 );
if ( empty($imgID) ) { $imgID = get_post_thumbnail_id($postID); }
$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
$alt        = get_the_title();

if ( !empty($imgID) ) : ?>
	<div class="post-media wtbx-reveal-cont wtbx_preloader_cont">

		<?php if (is_single() && (!isset($is_content_block) || !$is_content_block)) :
			// If single post page

			if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
				include(locate_template('templates/components/preloader.php'));
			endif; ?>
			<div class="post-media-inner wtbx-element-reveal">
				<?php wtbx_image_smart_img($imgID, $src_size, $srcset_size, $alt); ?>
			</div>

		<?php else :
			// If blog template or archive page
			if (empty($blog_type) || $blog_type !== 'masonry' ) {
				if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
					include(locate_template('templates/components/preloader.php'));
				endif; ?>
				<div class="post-media-inner wtbx_appearance_animation wtbx-element-reveal">
			<?php } ?>

			<div class="post-media-wrapper">
				<?php
				// get template aspect ratio
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
				wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
				?>
				<a class="post-media-overlay"  href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<i class="post-media-button post-media-link scape-ui-link"></i>
				</a>
			</div>

			<?php if (empty($blog_type) || $blog_type !== 'masonry' ) { ?>
				</div>
			<?php }
		endif; ?>

	</div>

<?php endif; ?>