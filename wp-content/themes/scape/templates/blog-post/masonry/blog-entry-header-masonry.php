<div class="entry-meta">

	<?php if ( !in_array('author-image', $meta_array) ) : ?>
	<div class="author-image">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 30 ); ?>
	</div>
	<?php endif; ?>

	<?php if (  !in_array('author-name', $meta_array) ||
				!in_array('date', $meta_array) ) : ?>

		<div class="meta-wrapper">

			<?php if ( !in_array('author-name', $meta_array) ) : ?>
				<a class="meta-author-link"
				   href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
				   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>"><?php echo get_the_author(); ?></a>
			<?php endif; ?>

			<?php if ( !in_array('date', $meta_array) ) : ?>
				<a href="<?php the_permalink(); ?>" class="meta-date"><?php echo get_the_date('j M Y'); ?></a>
			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php if ( !in_array('comments', $meta_array) ) : ?>
		<a href="<?php comments_link(); ?>" title="<?php echo esc_attr__( 'View comments for: ', 'scape' ) . get_the_title( $postID ); ?>" class="post-masonry-comments">
			<i class="scape-ui-comment"></i>
			<?php echo get_comments_number(); ?>
		</a>
	<?php endif; ?>

</div>