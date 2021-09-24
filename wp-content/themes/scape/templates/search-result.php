<article id="search-result-<?php the_ID(); ?>" <?php post_class('wtbx-search-result search-entry'); ?>>
	<div class="wtbx-search-result-inner">
		<a class="entry-media-overlay" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">

			<span class="entry-post-type"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>

			<?php
			$img_src        = $img_srcset = '';
			$imgID          = get_post_thumbnail_id(get_the_id());
			$alt            = get_the_title();
			$src_size       = 'medium';
			$srcset_size    = 'full';

			if ($imgID) {
				$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
				$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
			?>

				<div class="entry-thumbnail">
					<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, '16:10', $alt); ?>
				</div>

			<?php } ?>

			<div class="entry-content">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="meta-date"><i class="scape-ui-clock" aria-hidden="true"></i><?php echo get_the_date('j F Y'); ?></div>
			</div>

		</a>

	</div>
</article>