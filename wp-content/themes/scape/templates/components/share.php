<?php
$post_type = get_post_type();

if ( wtbx_option($post_type.'-share') === '3' ) :
	echo wp_kses_post(wtbx_option($post_type.'-share-custom'));
 elseif ( wtbx_option($post_type.'-share') === '2' && function_exists('wtbx_share_buttons') ) : ?>

	 <div class="wtbx-share-buttons">
		 <?php wtbx_share_buttons(); ?>
	 </div>

<?php endif; ?>

<?php if ( wtbx_option($post_type.'-copy') === '1' ) : ?>
    <div class="wtbx-copy-link-wrap">
        <form>
            <input type="text" class="copy-value" value="<?php the_permalink(); ?>" readonly="">
            <a class="wtbx-button wtbx-button-primary button-medium wtbx-copy"><?php echo esc_html__('Copy', 'scape'); ?></a>
        </form>
    </div>
<?php endif; ?>