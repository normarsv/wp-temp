<?php
$imgID      = get_post_meta( $postID, 'post-add-image_id', 1 );
$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
$alt        = get_the_title();

if ( !empty($imgID) ) : ?>
	<div class="post-media wtbx-reveal-cont wtbx_preloader_cont">
		<?php if (is_single()) :
			// If single post page ?>
		<?php else :
			// If blog template or archive page

			if (empty($blog_type) ||  $blog_type !== 'masonry' ) {
				if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
					include(locate_template('templates/components/preloader.php'));
				endif; ?>
				<div class="post-media-inner wtbx-element-reveal">
			<?php } ?>

			<div class="post-media-wrapper">
				<?php // get template aspect ratio
				$ratio = $aspect_ratio;
				wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
				?>
				<a class="post-media-overlay"  href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<i class="post-media-button post-media-link scape-ui-link"></i>
				</a>
			</div>

			<?php if (empty($blog_type) ||  $blog_type !== 'masonry' ) { ?>
				</div>
			<?php }
		endif; ?>
	</div>

<?php endif; ?>