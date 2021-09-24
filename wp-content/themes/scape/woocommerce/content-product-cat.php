<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop;

// animation
$animation = wtbx_option('shop-items-animation', 'none');

$classes = ['wtbx-product-entry', 'wtbx-product-category-entry', 'wtbx-masonry-entry', 'wtbx-grid-entry'];

?>
<li <?php wc_product_cat_class( $classes, $category ); ?>>
	<?php if ( $animation !== '' ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>
	<div class="wtbx-product-wrapper wtbx-reveal-cont wtbx-element-reveal wtbx-grid-anim-<?php echo esc_html($animation); ?>">
		<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" class="wtbx-product-inner clearfix content-<?php echo esc_attr(wtbx_option('product-cat-tile-title-position')); ?>">

			<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

			<?php if ( $category->count > 0 && wtbx_option('product-cat-tile-count') === '1' ) : ?>
				<span class="category-product-count"><?php echo esc_html($category->count) . ($category->count > 1 ? esc_html__(' items', 'scape') : esc_html__(' item', 'scape') ); ?></span>
			<?php endif; ?>

			<div class="wtbx-product-category-content">
				<?php do_action( 'woocommerce_before_subcategory_title', $category ); ?>
				<div class="wtbx-product-title">
					<?php do_action( 'woocommerce_shop_loop_subcategory_title', $category ); ?>
				</div>
				<?php do_action( 'woocommerce_after_subcategory_title', $category ); ?>

				<?php $description = $category->description;
				if ( !empty($description) ) { ?>
					<div class="wtbx-product-description"><p><?php echo esc_html($description); ?></p></div>
				<?php } ?>

			</div>

			<div class="wtbx-product-image">
				<?php
				$thumbnail_size  	= 'shop_catalog';
				$thumbnail_id  		= get_term_meta( $category->term_id, 'thumbnail_id', true  );

				if ( $thumbnail_id ) {
					$src_size       = 'medium';
					$srcset_size    = 'large';
					$imgID          = $thumbnail_id;
					$img_src        = wp_get_attachment_image_url( $imgID, $src_size );
					$img_srcset     = wp_get_attachment_image_srcset( $imgID, $srcset_size );
					$alt            = $category->name;

					$ratio = wtbx_option('product-cat-tile-ratio');

					if ( isset($ratio['width']) && isset($ratio['height']) && $ratio['width'] !== '' && $ratio['height'] !== '' ) {
						$ratio = $ratio['width'] . ':' . $ratio['height'];
					} else {
						$metadata = wp_get_attachment_metadata( $imgID );
						if ( isset($metadata['width']) && isset($metadata['height']) ) {
							$ratio = $metadata['width'] . ':' . $metadata['height'];
						} else {
							$ratio = '1:1';
						}
					}

					wtbx_image_smart_crop($imgID, $src_size, $srcset_size, false, $alt);

				} else {

					echo sprintf( '<img src="%s" alt="%s" class="wp-post-image wtbx-nolazy" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'scape' ) );

				}

				?>
			</div>

			<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

		</a>
	</div>

</li>
