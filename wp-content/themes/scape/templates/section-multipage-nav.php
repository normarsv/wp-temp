<?php
global $multipage, $more;
$post_multi = $multipage ? ' content-multipage' : '';

if ( $multipage ) :
	$more = 1; ?>

	<nav class="wtbx-pagination paged-post-nav wtbx-skin-light">
		<?php global $page; ?>
		<div class="wtbx-pagination-inner page-<?php echo esc_attr($page); ?> clearfix">
			<?php
			wp_link_pages( array(
				'before'            => '',
				'after'             => '',
				'next_or_number'    => 'number',
				'nextpagelink'      => '<div class="page-next page-numbers"></div>',
				'previouspagelink'  => '<div class="page-prev page-numbers"></div>',
			) );
			?>
		</div>
	</nav>

<?php endif; ?>