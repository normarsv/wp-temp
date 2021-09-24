<?php if ( empty($meta_array) || !in_array('categories', $meta_array) ) : ?>
	<div class="meta-category">
        <?php echo esc_html__( 'in', 'scape' ); ?><div class="category-list"><?php the_category( ', ' ); ?></div>
	</div>
<?php endif; ?>

<?php if ( (empty($meta_array) || !in_array('like', $meta_array)) && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
	<div class="post-like">
		<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
	</div>
<?php endif; ?>