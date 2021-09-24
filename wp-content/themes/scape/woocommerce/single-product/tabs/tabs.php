<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper product-tabs-wrapper">
		<div class="wtbx-product-tabs row-inner">
			<ul class="tabs product-tabs" role="tablist">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab">
						<a href="#tab-<?php echo esc_attr( $key ); ?>"><span class="tab-inner"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></span></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php foreach ( $product_tabs as $key => $product_tab ) :

				ob_start();
				call_user_func( $product_tab['callback'], $key, $product_tab );
				$tab_content = ob_get_clean();

				if (substr_count($tab_content, 'row-inner')) : ?>
					<div class="panel entry-content product-tab clearfix" id="tab-<?php echo esc_attr( $key ); ?>">
						<?php add_filter('woocommerce_product_description_heading', 'wtbx_no_product_description_heading'); call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
					</div>
				<?php else : ?>
					<div class="panel entry-content product-tab clearfix" id="tab-<?php echo esc_attr( $key ); ?>">
						<div class="wtbx-col-sm-12">
							<?php call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
						</div>
					</div>

				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>
