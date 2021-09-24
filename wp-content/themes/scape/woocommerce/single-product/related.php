<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products && wtbx_option('product-related-total') !== '0' ) : ?>

	<section class="related products">
		<div class="row-inner clearfix">
			<div class="wtbx-col-sm-12">
				<div class="wtbx-section-title">
					<h2 class="related-products-title"><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>
				</div>
			</div>

			<div class="wtbx-product-carousel clearfix" data-perpage="<?php echo esc_attr(wtbx_option('product-related-columns', 4)); ?>">

				<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );
					$animation  = 'fadein';

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; ?>

			</div>

			<div class="wtbx_dots wtbx_dots_style_2 wtbx_nav_skin_light"></div>
		</div>
	</section>

<?php endif;

wp_reset_postdata();
