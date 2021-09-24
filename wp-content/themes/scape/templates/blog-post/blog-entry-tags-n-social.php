<?php if( (has_tag() && wtbx_option('post-tags') === '1' ) ) : ?>

	<div class="post-tags-n-social">
		<?php if( has_tag() && wtbx_option('post-tags') === '1' ) : ?>
			<div class="post-tags">
				<?php the_tags( '<div class="tag-links"><span>','</span><span>','</span></div>' ); ?>
			</div>
		<?php endif; ?>
	</div>

<?php endif; ?>

<?php if ( wtbx_option('post-share') === '2' || wtbx_option('post-share') === '3' ) :
	wtbx_social_button(true);
endif; ?>
