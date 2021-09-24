<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $upsells && wtbx_option('product-upsells-total') !== '0' ) : ?>

	<section class="upsells products">
		<div class="row-inner clearfix">
			<div class="wtbx-col-sm-12">
				<div class="wtbx-section-title">
					<h2 class="upsells-products-title"><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>
				</div>
			</div>

			<div class="wtbx-product-carousel clearfix" data-perpage="<?php echo esc_attr(wtbx_option('product-upsells-columns', 4)); ?>" data-slide="">

				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>

			</div>

			<div class="wtbx_dots wtbx_dots_style_2 wtbx_nav_skin_light"></div>

		</div>
	</section>

<?php endif;

wp_reset_postdata();
