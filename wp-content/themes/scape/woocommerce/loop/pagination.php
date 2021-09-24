<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>
<nav class="woocommerce-pagination wtbx-pagination wtbx-skin-light">
	<div class="wtbx-pagination-inner clearfix">
		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : (isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 1);

		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$url_parts    = explode( '?', $pagenum_link );
		$link = '';

		// Merge additional query vars found in the original URL into 'add_args' array.
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $url_query_args );
			$add_args = urlencode_deep( $url_query_args );
			$link = '/' . add_query_arg( $url_query_args, $link );
		}

		$page_url = explode("?", get_pagenum_link(1, false));
		$base = $page_url[0] . '%_%';
		$prev_link = $prev_link_escaped = '';
		$next_link = $next_link_escaped = '';
		$format = 'page/%#%';
		if ($paged - 1 > 0) {
			$prev_link = $page_url[0] . 'page/' . ($paged - 1) . $link;
			$prev_link_escaped =  '<div class="page-prev page-numbers"><a class="wtbx-nav-button page-links-prev" href="'.esc_url($prev_link).'"></a></div>';
		}
		if ($paged < $wp_query->max_num_pages) {
			$next_link = $page_url[0] . 'page/' . ($paged + 1) . $link;
			$next_link_escaped =  '<div class="page-next page-numbers"><a class="wtbx-nav-button page-links-next" href="'.esc_url($next_link).'"></a></div>';
		}

		// This variable does not contain unescaped dynamic data - see line: 40
		echo $prev_link_escaped;

		echo '<div class="wtbx-nav-pages wtbx-pagination-pages">';
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'       => '',
			'add_args'     => false,
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'prev_next'       => false,
			'type'         => 'plain',
			'end_size'     => 2,
			'mid_size'     => 2
		) ) );
		echo '</div>';

		// This variable does not contain unescaped dynamic data - see line: 44
		echo $next_link_escaped;

		?>
	</div>
</nav>
