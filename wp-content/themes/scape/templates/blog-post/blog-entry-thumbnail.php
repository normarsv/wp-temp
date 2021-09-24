<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();

if ($imgID) {
	$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
	$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );

	// get global aspect ratio
	$ratio = $aspect_ratio;

	// if empty - get it from image size
	if (!$ratio) {
		$metadata = wp_get_attachment_metadata( $imgID );
		$ratio = $metadata['width'] . ':' . $metadata['height'];
	}
	?>

	<div class="post-media wtbx-reveal-cont wtbx_preloader_cont">
		<?php if ( !in_array($blog_type, array('sbs', 'masonry', 'boxed')) ) :
			if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
				include(locate_template('templates/components/preloader.php'));
			endif; ?>
			<div class="post-media-inner wtbx_appearance_animation wtbx-element-reveal">
		<?php endif; ?>
			<div class="post-media-wrapper">
				<?php
				// get template aspect ratio
				wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
				?>
				<a class="post-media-overlay"  href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"></a>
			</div>

		<?php if ( !in_array($blog_type, array('sbs', 'masonry', 'boxed')) ) { ?>
			</div>
		<?php } ?>
	</div>

<?php } ?>

