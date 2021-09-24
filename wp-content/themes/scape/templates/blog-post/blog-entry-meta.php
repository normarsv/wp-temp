<div class="entry-meta single-post-meta">

	<?php if ( wtbx_option('post-author') === '1' ) : ?>
		<span class="meta-author"><?php echo esc_html__( 'By', 'scape' ); ?>
			<a class="meta-author-link"
			   href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
			   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>"><?php echo get_the_author(); ?></a>
		</span>
	<?php endif; ?>

	<?php if ( wtbx_option('post-category') === '1' && has_category() ) : ?>
		<span class="meta-category">
            <?php echo esc_html__( 'in', 'scape' ); ?><span class="category-list"><?php the_category( ', ' ); ?></span>
		</span>
	<?php endif; ?>

</div>