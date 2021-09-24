<?php
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

$post_format = get_post_format();
$format = $post_format ?  '-' . $post_format : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry wtbx-sbs-entry wtbx-grid-entry wtbx-grid-anim-container clearfix' . (is_sticky() ? ' sticky' : '')); ?>>

	<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="post-sbs-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

		<div class="post-sbs-media-wrapper wtbx-col-sm-<?php echo esc_attr($media_width); ?>">
			<div class="post-sbs-media wtbx-entry-media">
				<?php // Media
                    if ( is_sticky() ) { ?>
                        <span class="wtbx-sticky-badge"><?php esc_html_e('Popular', 'scape'); ?></span>
                    <?php }
					include(locate_template('templates/blog-post/blog-entry-thumbnail.php'));
				?>
            </div>
		</div>

		<div class="post-sbs-content-wrapper wtbx-col-sm-<?php echo esc_attr($content_width); ?>">
			<div class="post-sbs-content">

				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<?php if (  !in_array('date', $meta_array) ||
					!in_array('read', $meta_array) ||
					!in_array('categories', $meta_array) ||
					!in_array('comments', $meta_array) ||
					!in_array('like', $meta_array) ) : ?>
                    <div class="post-sbs-meta<?php echo esc_attr($meta_class); ?>">
						<?php // Meta
						include(locate_template('templates/blog-post/sidebyside/blog-entry-header-sbs.php')); ?>
                    </div><!-- .entry-header -->
				<?php endif; ?>

				<div class="entry-content clearfix wtbx-text">
					<?php echo wtbx_excerpt($excerpt_length); ?>
				</div><!-- .entry-content -->

				<?php if (  !in_array('author-image', $meta_array) ||
					!in_array('author-name', $meta_array) ) : ?>

					<div class="post-sbs-footer<?php echo esc_attr($meta_class); ?>">
						<?php // Meta header
						include(locate_template('templates/blog-post/sidebyside/blog-entry-footer-sbs.php')); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>

	</div>
</article>