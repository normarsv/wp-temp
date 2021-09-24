<?php
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

$post_format = get_post_format();
$format = $post_format ?  '-' . $post_format : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry wtbx-column-entry clearfix' . (is_sticky() ? ' sticky' : '')); ?>>

	<div class="post-column-inner wtbx-entry-inner">
        <?php // Media
        if ( $preview === 'post_media' ) {
            if ( file_exists(locate_template('templates/blog-post/formats/blog-format' . $format . '.php')) ) {
                include(locate_template('templates/blog-post/formats/blog-format' . $format . '.php'));
            }
        } elseif ( $preview === 'featured_image' ) {
            include(locate_template('templates/blog-post/blog-entry-thumbnail.php'));
        } ?>

		<div class="post-entry-header">
			<?php if ( !in_array('categories', $meta_array) ) : ?>
            <div class="meta-category">
                <span class="category-list"><?php the_category( ', ' ); ?></span>
            </div>
			<?php endif; ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</div><!-- .entry-header -->

		<?php if (  !in_array('author-name', $meta_array) ||
			!in_array('date', $meta_array) ||
			!in_array('categories', $meta_array) ) : ?>

			<div class="entry-meta">

				<?php if ( !in_array('date', $meta_array) ) : ?>
					<a href="<?php the_permalink(); ?>" class="meta-date"><?php echo get_the_date('j F Y'); ?></a>
				<?php endif; ?>

				<?php if ( !in_array('author-name', $meta_array) ) : ?>
					<span class="meta-author"><?php echo esc_html__( 'by', 'scape' ); ?>
						<a class="meta-author-link"
						   href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
						   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>"><?php echo get_the_author(); ?></a>
			        </span>
				<?php endif; ?>

			</div>

		<?php endif;

		// Content ?>
		<div class="entry-content clearfix wtbx-text">
<!--            --><?php //the_content(); ?>
			<?php echo wtbx_excerpt($excerpt_length, esc_html__('Read more', 'scape')); ?>
		</div><!-- .entry-content -->

	</div>
</article>