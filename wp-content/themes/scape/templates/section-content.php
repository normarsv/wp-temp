<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix'); ?>>
	<?php if ( is_single() ) :
		// Title
		get_template_part( 'templates/blog-post/blog-entry-title' );
		// Meta
		get_template_part( 'templates/blog-post/blog-entry-meta' );
		// Content
		get_template_part( 'templates/blog-post/single/blog-entry-content-single' );
	else :
		// Title
		get_template_part( 'templates/blog-post/blog-entry-title' );
		// Meta
		get_template_part( 'templates/blog-post/blog-entry-meta' );
		// Content
		get_template_part( 'templates/blog-post/single/blog-entry-content-single' );
	endif; ?>
</article><!-- #post-## -->