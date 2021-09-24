<?php
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry wtbx-grid-entry wtbx-boxed-entry wtbx-grid-anim-container' . (is_sticky() ? ' sticky' : '')); ?>>

	<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="post-boxed-inner wtbx-entry-inner wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

        <div class="post-boxed-media wtbx-entry-media">
	        <?php
	        $img_src    = $img_srcset = '';
	        $imgID      = get_post_thumbnail_id($postID);
	        $alt        = get_the_title();

	        if ($imgID) {
		        $src_size = 'medium';
		        wtbx_image_smart_crop($imgID, $src_size, $srcset_size, '16:10', $alt);
	        } ?>

	        <?php if ( empty($meta_array) || !in_array('categories', $meta_array) ) : ?>
                <div class="meta-categories">
                    <div class="category-list"><?php the_category(' '); ?></div>
                </div>
	        <?php endif; ?>

            <a href="<?php the_permalink(); ?>" class="post-boxed-button">
                <i class="scape-ui-chevron-right"></i>
            </a>
        </div>

        <div class="post-entry-content<?php echo esc_attr($meta_class); ?>">
            <div class="post-entry-header">

		        <?php if ( !in_array('date', $meta_array) ) : ?>
                    <div class="meta-date wtbx-text"><?php echo get_the_date('j F Y'); ?></div>
		        <?php endif; ?>

                <h1 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h1>

            </div>

            <?php if ( $excerpt_length !== '' && $excerpt_length > 0 ) : ?>
                <div class="entry-content wtbx-text">
                    <?php echo wtbx_excerpt($excerpt_length); ?>
                </div>
            <?php endif; ?>

            <?php if ( empty($meta_array) || !in_array('author-name', $meta_array) || !in_array('author-image', $meta_array) || !in_array('comments', $meta_array) || !in_array('like', $meta_array) ) : ?>
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
                                    <span><?php the_author(); ?></span>
				                <?php endif; ?>
                            </a>
                        </div>
			        <?php endif; ?>

	                <?php if ( empty($meta_array) || !in_array('like', $meta_array) || !in_array('comments', $meta_array) ) : ?>

                        <div class="post-entry-footer-right">

	                        <?php if ( !in_array('comments', $meta_array) ) : ?>
                                <div class="post-entry-footer-section">
                                    <a href="<?php comments_link(); ?>" title="<?php echo esc_attr__( 'View comments for: ', 'scape' ) . get_the_title( get_the_id() ); ?>" class="post-sbs-comments">
                                        <i class="scape-ui-comment"></i>
				                        <?php echo get_comments_number(); ?>
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

                        </div>

	                <?php endif; ?>

                </div>
	        <?php endif; ?>
        </div>

	</div>
</article>