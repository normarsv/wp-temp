<?php if ( !in_array('date', $meta_array) || $reading_time === '1' ) : ?>
	<div class="meta-wrapper">

		<?php if ( !in_array('date', $meta_array) ) : ?>
			<span class="meta-date wtbx-text"><?php echo get_the_date('j M Y'); ?></span>
		<?php endif; ?>

		<?php if ( $reading_time === '1' ) : ?>
			<span class="meta-read wtbx-text"><i class="scape-ui-clock" aria-hidden="true"></i><?php echo wtbx_reading_time($postID); ?></span>
		<?php endif; ?>

		<?php if ( !in_array('comments', $meta_array) ) : ?>
            <a href="<?php comments_link(); ?>" title="<?php echo esc_attr__( 'View comments for: ', 'scape' ) . get_the_title( get_the_id() ); ?>" class="post-sbs-comments">
                <i class="scape-ui-comment"></i>
				<?php echo get_comments_number(); ?>
            </a>
		<?php endif; ?>

		<?php if ( !in_array('like', $meta_array) && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
            <span class="post-like">
				<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
            </span>
		<?php endif; ?>

	</div>
<?php endif; ?>