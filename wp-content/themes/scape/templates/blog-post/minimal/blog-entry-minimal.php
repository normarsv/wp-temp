<?php
// columns
if ( $columns_minimal === '2' ) {
	$columns = ' wtbx-col-md-6';
} else {
	$columns = ' wtbx-col-sm-12';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry wtbx-grid-entry wtbx-minimal-entry wtbx-grid-anim-container clearfix' . $columns . (is_sticky() ? ' sticky' : '')); ?>>

	<div class="post-minimal-inner wtbx-entry-inner wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">
		<div class="post-entry-header">

			<?php if ( !in_array('date', $meta_array) ) : ?>
				<a href="<?php the_permalink(); ?>" class="meta-date"><?php echo get_the_date(); ?></a>
			<?php endif; ?>

			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>

			<?php if ( !in_array('categories', $meta_array) ) : ?>
				<div class="meta-categories">
					<div class="category-list"><?php the_category(' '); ?></div>
				</div>
			<?php endif; ?>

		</div><!-- .entry-header -->

		<div class="entry-content clearfix wtbx-text">
			<?php echo wtbx_excerpt($excerpt_length); ?>
		</div><!-- .entry-content -->

		<?php if (  !in_array('comments', $meta_array) || !in_array('like', $meta_array) || $reading_time === '1' ) : ?>
			<div class="post-entry-footer clearfix">

				<?php if ( !in_array('author-name', $meta_array) || !in_array('author-image', $meta_array) ) : ?>
                    <div class="meta-author">
                        <a class="meta-author-link"
                           href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"
                           title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), get_the_author() ); ?>">
							<?php if ( !in_array('author-image', $meta_array) ) : ?>
                                <div class="author-image">
									<?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?>
                                </div>
							<?php endif; ?>
							<?php if ( !in_array('author-name', $meta_array) ) : ?>
                                <span><?php echo esc_html__( 'By', 'scape' ) . ' ' . get_the_author(); ?></span>
							<?php endif; ?>
                        </a>
                    </div>
				<?php endif; ?>

				<?php if ( !in_array('like', $meta_array) && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
					<div class="post-entry-footer-section">
						<div class="post-like">
							<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( !in_array('comments', $meta_array) ) : ?>
					<div class="post-entry-footer-section">
						<a href="<?php comments_link(); ?>" title="<?php echo esc_attr__( 'View comments for: ', 'scape' ) . get_the_title( get_the_id() ); ?>" class="post-sbs-comments">
							<i class="scape-ui-comment"></i><?php echo get_comments_number(); ?></a>
					</div>
				<?php endif; ?>

				<?php if ( $reading_time === '1' ) : ?>
					<div class="post-entry-footer-section wtbx-text">
						<i class="scape-ui-clock" aria-hidden="true"></i><?php echo wtbx_reading_time($postID, false); ?>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

	</div>
</article>