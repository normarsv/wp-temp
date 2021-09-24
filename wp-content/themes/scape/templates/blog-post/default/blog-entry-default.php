<?php
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

$post_format = get_post_format();
$format = $post_format ?  '-' . $post_format : '';

wtbx_script_queue('sticky-kit');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry wtbx-default-entry clearfix' . (is_sticky() ? ' sticky' : '')); ?>>

	<?php if ( !in_array('date', $meta_array) ) : ?>
        <div class="side-meta wtbx-sticky">
            <div class="meta meta-date wtbx-text"><span class="d"><?php echo get_the_date('d'); ?></span><span class="m"><?php echo get_the_date('M'); ?></span></div>
        </div>
	<?php endif; ?>

	<div class="post-default-inner wtbx-entry-inner<?php echo esc_attr($meta_class); ?>">
        <?php // Media
        if ( $preview === 'post_media' ) {
            if ( file_exists(locate_template('templates/blog-post/formats/blog-format' . $format . '.php')) ) {
                include(locate_template('templates/blog-post/formats/blog-format' . $format . '.php'));
            }
        } elseif ( $preview === 'featured_image' ) {
            include(locate_template('templates/blog-post/blog-entry-thumbnail.php'));
        } ?>

		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if (  !in_array('author-name', $meta_array) || !in_array('categories', $meta_array) ) : ?>

			<div class="entry-meta">

				<?php if ( !in_array('date', $meta_array) ) : ?>
                    <span class="meta meta-date wtbx-text"><?php echo get_the_date(); ?></span>
				<?php endif; ?>

				<?php if ( !in_array('author-name', $meta_array) ) : ?>
					<span class="meta meta-author">
						<a class="meta-author-link"
						   href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
						   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>"><?php echo get_the_author(); ?></a>
			        </span>
				<?php endif; ?>

				<?php if ( !in_array('categories', $meta_array) ) : ?>
                    <span class="meta meta-category">
                        <span class="category-list"><?php the_category( ', ' ); ?></span>
                    </span>
				<?php endif; ?>

				<?php if ( !in_array('like', $meta_array) && ( class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) ) : ?>
                    <span class="meta post-like">
						<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
                    </span>
				<?php endif; ?>

			</div>

		<?php endif;

		// Content ?>
		<div class="entry-content clearfix wtbx-text">
			<?php echo wtbx_excerpt($excerpt_length, esc_html__('Read more', 'scape')); ?>
		</div><!-- .entry-content -->

	</div>
</article>