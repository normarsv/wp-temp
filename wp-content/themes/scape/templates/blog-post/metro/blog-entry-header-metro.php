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
				<span class="meta-author"><?php echo esc_html__('By', 'scape'). ' ' . get_the_author(); ?></span>
			<?php endif; ?>

			</a>
		</div>

	<?php endif; ?>

	<?php if ( !in_array('like', $meta_array) && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
		<div class="post-like">
			<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
		</div>
	<?php endif; ?>

</div>