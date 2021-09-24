<?php
// post tile size
if ( $grid_layout === 'default' ) {
	$width = $height = 1;
} else {
	$current = $current_post-$tiles*$counter;
	$width  = $layout_obj['width'][$current];
	$height = $layout_obj['height'][$current];
}
// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

// preview media ratio
$aspect_ratio = $width . ':' . $height;

// overlay
$inner_class = !empty($post_overlay_hover) && wtbx_vc_color_styles_bg($post_overlay_hover) === '' ? ' static-overlay' : '';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix wtbx-metro-entry wtbx-grid-entry wtbx-grid-anim-container' . (is_sticky() ? ' sticky' : '')); ?> data-width="<?php echo esc_attr($width); ?>" data-height="<?php echo esc_attr($height); ?>">

	<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

    <div class="post-metro-inner wtbx-entry-inner clearfix wtbx-element-reveal wtbx_appearance_animation touchhover wtbx-grid-anim-<?php echo esc_attr($animation_style . $inner_class); ?>">

        <div class="post-metro-bg">
            <?php // Background media
            include(locate_template('templates/blog-post/metro/blog-entry-bg-metro.php')); ?>
        </div>

        <?php if (  !in_array('author-image', $meta_array) ||
            !in_array('author-name', $meta_array) ||
            !in_array('like', $meta_array) ) : ?>
            <div class="post-metro-header<?php echo esc_attr($meta_class); ?>">
                <?php // Meta header
                include(locate_template('templates/blog-post/metro/blog-entry-header-metro.php')); ?>
            </div>
        <?php endif; ?>

        <div class="post-metro-footer<?php echo esc_attr($meta_class); ?>">
            <?php // Meta footer
            include(locate_template('templates/blog-post/metro/blog-entry-footer-metro.php')); ?>
        </div>

        <a href="<?php the_permalink(); ?>" rel="bookmark" class="post-metro-link"></a>
    </div>
</article>