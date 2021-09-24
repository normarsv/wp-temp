<?php wtbx_script_queue('scape-sidearea'); ?>

<div id="wtbx_header_sidearea" class="wtbx_skin_<?php echo wtbx_option('hs-skin'); ?>">
	<div class="wtbx_header_sidearea_inner">
		<?php
		$content_block = wtbx_option('hs-content');
		if ( $content_block !== '' ) {
			$content_block = wtbx_get_translated_content_block($content_block);
			$s_ID = get_post($content_block);
			$content = $s_ID->post_content;
			?>

			<div class="wtbx_sidearea_inner_content">
				<?php echo apply_filters('the_content', $content); ?>
			</div>
		<?php }
		?>
	</div>
</div>
<div class="wtbx_sidearea_backdrop">
	<div class="wtbx_sidearea_close"></div>
</div>