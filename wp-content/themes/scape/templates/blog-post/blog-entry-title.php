<div class="post-entry-header">
	<?php if ( is_single() ) : ?>
        <?php if ( wtbx_option('post-title') === '1' ) : ?>
		    <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php endif; ?>
	<?php else : ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'scape' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	<?php endif; ?>
</div><!-- .entry-header -->