<?php if ( !in_array('categories', $meta_array) ) : ?>
	<div class="meta-categories">
		<div class="category-list"><?php the_category(' '); ?></div>
	</div>
<?php endif; ?>

<h1 class="entry-title">
    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
</h1>

<?php if ( !in_array('date', $meta_array) ) : ?>
		<a href="<?php the_permalink(); ?>" class="meta-date"><i class="scape-ui-clock" aria-hidden="true"></i><?php echo get_the_date('j F Y'); ?></a>
<?php endif; ?>

<?php if ( !in_array('comments', $meta_array) ) : ?>
	<a href="<?php comments_link(); ?>" title="<?php echo esc_attr__( 'View comments for: ', 'scape' ) . get_the_title( $postID ); ?>" class="post-metro-comments">
		<i class="scape-ui-comment"></i>
		<?php echo get_comments_number(); ?>
	</a>
<?php endif; ?>