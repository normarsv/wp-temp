<?php
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix wtbx-magazine-entry wtbx-grid-entry wtbx-grid-anim-container' . (is_sticky() ? ' sticky' : '')); ?>>

	<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

    <div class="post-magazine-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation touchhover wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">

        <div class="post-magazine-bg">
            <?php // Background media
            include(locate_template('templates/blog-post/magazine/blog-entry-bg-magazine.php')); ?>
        </div>

        <?php if ( empty($meta_array) || !in_array('author-image', $meta_array) ||
            !in_array('author-name', $meta_array) ||
            !in_array('categories', $meta_array) ||
            !in_array('like', $meta_array) ) : ?>
            <div class="post-magazine-header<?php echo esc_attr($meta_class); ?>">
                <?php // Meta header
                include(locate_template('templates/blog-post/magazine/blog-entry-header-magazine.php')); ?>
            </div>
        <?php endif; ?>

        <div class="post-magazine-footer<?php echo esc_attr($meta_class); ?>">
            <?php // Meta footer
            include(locate_template('templates/blog-post/magazine/blog-entry-footer-magazine.php')); ?>
        </div>

        <div class="post-magazine-excerpt">
            <div class="entry-content">
                <?php echo wtbx_excerpt($excerpt_length); ?>
            </div>
        </div>

        <a class="post-magazine-link" href="<?php the_permalink(); ?>" rel="bookmark"></a>
    </div>
</article>