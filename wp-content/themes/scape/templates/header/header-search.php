<div id="wtbx_header_search_wrapper" class="wtbx_skin_<?php echo esc_attr(wtbx_option('search-panel-skin')); ?>">
    <div class="wtbx_search_close"></div>
	<div class="wtbx_header_search">
		<div class="wtbx_header_search_inner row-inner">
			<?php
				$post_types = wtbx_option('search-form-post-types');
				include(locate_template('templates/components/searchform.php'));
			?>
		</div>
		<?php
			$content_block = wtbx_option('search-panel-content');
			if ( $content_block !== '' ) {
				$content_block = wtbx_get_translated_content_block($content_block);
				$s_ID = get_post($content_block);
				if ( isset( $s_ID->post_content) ) {
					$content = $s_ID->post_content;
				} else {
					$content = '';
                }
				?>

				<div class="wtbx_search_content row-inner">
					<?php echo apply_filters('the_content', $content); ?>
				</div>
			<?php }
		?>
	</div>
</div>
<div class="wtbx_search_backdrop"></div>


