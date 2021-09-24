<div id="wtbx_header_overlay" class="wtbx_skin_<?php echo wtbx_option('ho-skin'); ?>">
	<div class="wtbx_overlay_close"></div>
	<div class="wtbx_header_overlay_inner">
		<?php
		$content_block = wtbx_option('ho-content');
		if ( $content_block !== '' ) {
			$content_block = wtbx_get_translated_content_block($content_block);
			$s_ID = get_post($content_block);
			$content = $s_ID->post_content;
			?>

			<div class="wtbx_overlay_inner_content">
				<?php echo apply_filters('the_content', $content); ?>
			</div>
		<?php }
		?>
	</div>
</div>