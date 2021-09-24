<?php
$orig_post = $post;
global $post;
$related_by = wtbx_option('post-related-criteria');

if ( $related_by === 'category' ) {
	$categories     = get_the_category($post->ID);
	if ($categories) {
		$category_ids   = array();
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		$args = array(
			'category__in'      => $category_ids,
			'post__not_in'      => array($post->ID),
			'posts_per_page'    => wtbx_option('post-related-total'),
			'ignore_sticky_posts'  => 1
		);
	}
} elseif ( $related_by === 'tag' ) {
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		$tag_ids = array();
		foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		$args = array(
			'tag__in'           => $tag_ids,
			'post__not_in'      => array($post->ID),
			'posts_per_page'    => wtbx_option('post-related-total'),
			'ignore_sticky_posts'  => 1
		);
	}
}

$related_query = new WP_Query( $args );

if( $related_query->have_posts() ) : ?>

	<aside class="wtbx-related-posts">
        <div class="wtbx-related-posts-inner row-inner">
            <div class="wtbx-width wtbx-large-7 wtbx-medium-8 wtbx-small-9">
                <h3 class="wtbx-related-posts-title"><?php echo esc_html__( 'Related Posts', 'scape' ); ?></h3>

                <div class="wtbx-related-posts-container">

                        <div class="wtbx-related-posts-wrapper" data-autoplay="<?php echo esc_attr(wtbx_option('post-related-autoplay')); ?>">
                        <?php while( $related_query->have_posts() ) :
                            $related_query->the_post(); ?>

                                <article class="wtbx-related-post wtbx-reveal-cont wtbx_preloader_cont">

                                    <?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
                                        include(locate_template('templates/components/preloader.php'));
                                    endif; ?>

                                    <div class="wtbx-related-post-inner wtbx-element-reveal">
                                        <?php // post thumbnail
                                        $img_src    = $img_srcset = '';
                                        $imgID      = get_post_thumbnail_id($post->ID);
                                        $alt        = get_the_title();

                                        if ($imgID) {
                                            $img_src    = wp_get_attachment_image_url( $imgID, $src_size );
                                            $img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );

                                            // get global aspect ratio
                                            $ratio = '1:1'; ?>

                                            <div class="wtbx-related-post-thumbnail">
                                                <a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                                    <?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt); ?>
                                                </a>

                                                <div class="wtbx-related-post-content">
                                                    <?php if ( wtbx_option('post-related-date-enable') ) : ?>
                                                        <div class="meta-categories">
                                                            <div class="category-list"><?php the_category(' '); ?></div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <h3 class="entry-title">
                                                        <a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                    </h3>
                                                </div>

                                            </div>

                                        <?php } ?>



                                    </div>

                                </article>

                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
	</aside>
<?php endif;

$post = $orig_post;
wp_reset_query();