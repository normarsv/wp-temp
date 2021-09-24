<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$gridID = hexdec(substr(uniqid(), 6, 7));
$attachment_ids = $product->get_gallery_image_ids();

$attachments[] = array(
	'src'   => wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ),
	'thumb' => wp_get_attachment_image_url( get_post_thumbnail_id(), 'medium' )
);
if ( $attachment_ids ) {
	foreach ( (array) $attachment_ids as $imgID ) {
		$attachments[] = array(
			'src'   => wp_get_attachment_image_url( $imgID, 'full' ),
			'thumb' => wp_get_attachment_image_url( $imgID, 'medium' )
		);
	}
}

// Extra post classes
$classes = ['wtbx-product-entry', 'wtbx-product-single-entry', 'wtbx-masonry-entry', 'wtbx-grid-entry'];

// animation
$animation = wtbx_option('shop-items-animation', 'none');

?>

<li <?php wc_product_class( $classes, $product ); ?>>
		<div class="wtbx-product-wrapper wtbx-reveal-cont">
		<div class="wtbx-product-inner">

			<?php
			/**
			 * Hook: woocommerce_before_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_open - 10
			 */
            do_action( 'woocommerce_before_shop_loop_item' ); ?>

			<div class="wtbx-product-header clearfix">
				<?php
				$zoom       = wtbx_option('product-tile-zoom');
				$preview    = wtbx_option('product-tile-preview');

				if ( $preview === '1' ) { wtbx_script_queue('custom-scrollbar'); wp_enqueue_style('scape-custom-scrollbar'); }

				if ( $zoom === '1' || $preview === '1' ) : ?>

					<div class="wtbx-product-actions">
						<?php if ( $zoom === '1' && $preview === '1' ) : ?>
							<div class="product-actions-trigger">
								<span class="first"></span>
								<span class="second"></span>
								<span class="third"></span>
							</div>

							<div class="product-actions-options">
								<?php if ( $zoom === '1' ) : ?>
									<a class="wtbx-option wtbx-option-zoom wtbx-lightbox-item"<?php echo wtbx_option('product-tile-share') === '1' ? ' data-share="' . get_the_permalink() . '"' : ''; ?><?php echo wtbx_option('product-tile-link') === '1' ? ' data-itemlink="' . get_the_permalink() . '"' : ''; ?> data-dynamic="1" data-dynamicel="<?php echo esc_attr(json_encode($attachments)); ?>"<?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($gridID); ?>"><?php echo esc_html__('Zoom', 'scape'); ?><i class="scape-ui-zoom-in" aria-hidden="true"></i></a>
								<?php endif; ?>
								<?php if ( $preview === '1' ) : ?>
									<div class="wtbx-option wtbx-option-preview wtbx-lightbox-item wtbx-lightbox-item-ajax"<?php echo wtbx_option('product-tile-share') === '1' ? ' data-share="' . get_the_permalink() . '"' : ''; ?><?php echo wtbx_option('product-tile-link') === '1' ? ' data-itemlink="' . get_the_permalink() . '"' : ''; ?> data-productid="<?php echo esc_attr($product->get_id()); ?>" data-ajax="1" data-nonce="<?php echo wp_create_nonce('wtbx-grid-nonce'); ?>"><?php echo esc_html__('Quick preview', 'scape'); ?><i class="scape-ui-maximize" aria-hidden="true"></i></div>
								<?php endif; ?>
							</div>

						<?php elseif ( $zoom === '1' ) : ?>
							<a class="wtbx-option wtbx-option-single wtbx-option-zoom wtbx-lightbox-item"<?php echo wtbx_option('product-tile-share') === '1' ? ' data-share="' . get_the_permalink() . '"' : ''; ?><?php echo wtbx_option('product-tile-link') === '1' ? ' data-itemlink="' . get_the_permalink() . '"' : ''; ?> data-dynamic="1" data-dynamicel="<?php echo esc_attr(json_encode($attachments)); ?>"<?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($gridID); ?>"><i class="scape-ui-zoom-in" aria-hidden="true"></i></a>
						<?php elseif ( $preview === '1' ) : ?>
							<div class="wtbx-option wtbx-option-single wtbx-option-preview wtbx-lightbox-item wtbx-lightbox-item-ajax"<?php echo wtbx_option('product-tile-share') === '1' ? ' data-share="' . get_the_permalink() . '"' : ''; ?><?php echo wtbx_option('product-tile-link') === '1' ? ' data-itemlink="' . get_the_permalink() . '"' : ''; ?> data-productid="<?php echo esc_attr($product->get_id()); ?>" data-ajax="1"  data-nonce="<?php echo wp_create_nonce('wtbx-grid-nonce'); ?>"><i class="scape-ui-maximize" aria-hidden="true"></i></div>
						<?php endif; ?>

						<?php if ( $zoom === '1' ) : ?>
							<a class="wtbx-option wtbx-option-single wtbx-option-in-slider wtbx-option-zoom wtbx-lightbox-item"<?php echo wtbx_option('product-tile-share') === '1' ? ' data-share="' . get_the_permalink() . '"' : ''; ?><?php echo wtbx_option('product-tile-link') === '1' ? ' data-itemlink="' . get_the_permalink() . '"' : ''; ?> data-dynamic="1" data-dynamicel="<?php echo esc_attr(json_encode($attachments)); ?>"<?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($gridID); ?>"><i class="scape-ui-zoom-in" aria-hidden="true"></i></a>
						<?php endif; ?>

					</div>

				<?php endif; ?>
			</div>

			<?php
			/**
			 * Hook: woocommerce_before_shop_loop_item_title.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
            <div class="wtbx-product-title">
				<?php
				/**
				 * Hook: woocommerce_shop_loop_item_title.
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
                do_action( 'woocommerce_shop_loop_item_title' ); ?>
            </div>
			<?php
			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
            do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

			<a class="wtbx-product-link" href="<?php echo esc_url( get_the_permalink() ); ?>"></a>

			<div class="wtbx-product-footer clearfix">
				<?php do_action( 'woocommerce_wtbx_shop_loop_item_footer' ); ?>
			</div>

			<?php
			/**
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
            do_action( 'woocommerce_after_shop_loop_item' ); ?>

		</div>
	</div>
</li>
