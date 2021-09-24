<div class="entry-meta">

	<?php if (  !in_array('author-name', $meta_array) || !in_array('author-image', $meta_array) ) : ?>

		<div class="meta-wrapper">
			<a class="meta-author-link"
			   href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
			   title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>">

			<?php if ( !in_array('author-image', $meta_array) ) : ?>
				<div class="author-image">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
				</div>
			<?php endif; ?>

			<?php if ( !in_array('author-name', $meta_array) ) : ?>
				<span class="meta-author"><?php the_author(); ?></span>
			<?php endif; ?>

			</a>
		</div>

	<?php endif; ?>

	<?php if ( !in_array('categories', $meta_array) ) : ?>
    	<div class="meta-categories">
    		<div class="category-list"><?php the_category(' '); ?></div>
    	</div>
	<?php endif; ?>

</div>