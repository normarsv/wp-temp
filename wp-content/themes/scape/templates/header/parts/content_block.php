<div class="wtbx_header_part wtbx_content_block header_button_height">
	<?php
	$content_block = wtbx_option('h'.$header_style.'-content-block');

	if ( $content_block !== '' ) {
		$content_block = wtbx_get_translated_content_block($content_block);
		$s_ID = get_post($content_block);
		$content = $s_ID->post_content;
		?>

		<div class="wtbx_content_block_inner row-inner">
			<?php echo apply_filters('the_content', $content); ?>
		</div>
	<?php }
	?>
</div>