<h1 class="entry-title">
    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
</h1>

<?php if ( !in_array('date', $meta_array) ) : ?>
    <div class="meta-date"><?php echo get_the_date('j F Y'); ?></div>
<?php endif; ?>

<?php if ( !in_array('like', $meta_array) && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
    <div class="post-like">
		<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
    </div>
<?php endif; ?>

<?php if ( !in_array('comments', $meta_array) ) : ?>
	<div class="post-magazine-comments">
		<i class="scape-ui-comment"></i>
		<?php echo get_comments_number(); ?>
	</div>
<?php endif; ?>
