<?php
	if ( class_exists('YITH_WCWL') ) {
		global $yith_wcwl;

		$items_in_wishlist = $yith_wcwl->count_products();
		$href = $yith_wcwl->get_wishlist_url();
		$title = esc_html__('View your wishlist', 'scape');
		?>

		<div class="wtbx_header_part header_button header_wishlist_wrapper header_button_alt header_wishlist_wrapper_alt">
			<a href="<?php echo esc_url($href); ?>" title="<?php echo esc_attr($title); ?>" class="header_wishlist header_alt_button">
				<i class="scape-ui-heart"></i>
				<span class="wishlist_count"><?php echo esc_html($items_in_wishlist); ?></span>
			</a>
		</div>
	<?php } ?>

