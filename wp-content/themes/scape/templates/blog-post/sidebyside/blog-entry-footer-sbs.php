<div class="entry-meta">

	<?php if ( !in_array('author-image', $meta_array) ) : ?>
	<a class="author-image"
	   href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
	   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 30 ); ?>
	</a>
	<?php endif; ?>

	<?php if ( !in_array('author-name', $meta_array) ) : ?>
		<div class="meta-author-link">
			<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
			   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>"><?php echo get_the_author(); ?></a>
		</div>
	<?php endif; ?>

</div>