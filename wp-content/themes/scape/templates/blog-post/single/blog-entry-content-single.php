<?php
global $multipage, $more;
$post_multi = $multipage ? ' content-multipage' : '';
?>

<div class="entry-content<?php echo esc_attr($post_multi); ?>">
	<?php the_content(esc_html__('Continue reading', 'scape')); ?>
	<?php get_template_part( 'templates/section-multipage-nav' ); ?>
</div><!-- .entry-content -->