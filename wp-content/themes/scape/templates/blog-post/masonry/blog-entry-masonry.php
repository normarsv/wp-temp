<?php
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix wtbx-masonry-entry wtbx-grid-entry wtbx-grid-anim-container' . (is_sticky() ? ' sticky' : '')); ?>>

	<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="post-masonry-inner clearfix wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?> with-<?php echo esc_attr($preview);?>">

		<?php if ( empty($meta_array) || !in_array('author-image', $meta_array) ||
			!in_array('author-name', $meta_array) ||
			!in_array('date', $meta_array) ||
			!in_array('comments', $meta_array) ) : ?>
			<div class="post-masonry-header<?php echo esc_attr($meta_class); ?>">
				<?php // Meta header
				include(locate_template('templates/blog-post/masonry/blog-entry-header-masonry.php')); ?>
			</div>
		<?php endif; ?>

		<?php
		$post_format = get_post_format();
		$format = $post_format ?  '-' . $post_format : '';
		$format_array[] = $post_format; ?>

		<?php if ( !empty($post_format) ) { ?>

			<div class="post-masonry-media wtbx-entry-media">
				<?php
				// Media
				if ( $preview == 'featured_image' ) {
					include(locate_template('templates/blog-post/blog-entry-thumbnail.php'));
				} else {
					include(locate_template('templates/blog-post/formats/blog-format' . $format . '.php'));
				}
				?>
			</div>

		<?php } ?>


		<div class="post-masonry-content<?php echo (  !empty($meta_array) && in_array('categories', $meta_array) && in_array('like', $meta_array) ? ' no-footer' : '' ) ?>">
			<?php // Title
			get_template_part( 'templates/blog-post/blog-entry-title' ); ?>

			<div class="entry-content clearfix wtbx-text">
				<?php echo wtbx_excerpt($excerpt_length); ?>
			</div><!-- .entry-content -->
		</div>

		<?php if ( empty($meta_array) || !in_array('categories', $meta_array) ||
			!in_array('like', $meta_array) ) : ?>
			<div class="post-masonry-footer clearfix">
				<?php // Meta footer
				include(locate_template('templates/blog-post/masonry/blog-entry-footer-masonry.php')); ?>
			</div>
		<?php endif; ?>

	</div>
</article>