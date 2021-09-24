<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */


defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $post, $woocommerce, $product;
$gridID = hexdec(substr(uniqid(), 6, 7));
$attachment_count = count( $product->get_gallery_image_ids() );
$has_thumbnails = $attachment_count > 0 ? ' has-thumbnails' : 'no-thumbnails';
$thumbnails_pos = wtbx_option('product-thumbnails-position', 'bottom');

if ( wtbx_demo() ) {
	if ( get_the_ID() === 4042 ) {
		$thumbnails_pos = 'left';
	}
}

$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
//	'woocommerce-product-gallery--' . $placeholder,
//	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
	'thumbnails-' . $thumbnails_pos,
	$has_thumbnails
) );

$src_size       = 'medium';
$srcset_size    = 'full';
$imgID          = get_post_thumbnail_id();
$img_src        = wp_get_attachment_image_url( $imgID, $src_size );
$img_src_lb     = wp_get_attachment_image_url( $imgID, 'full' );
$img_srcset     = wp_get_attachment_image_srcset( $imgID, $srcset_size );
$alt            = get_the_title();

?>
<div class="product-gallery <?php echo esc_attr(implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-thumbnails="<?php echo esc_attr($thumbnails_pos); ?>">
	<figure class="woocommerce-product-gallery__wrapper clearfix">
		<?php wc_get_template( 'single-product/sale-flash.php' ); ?>

		<div class="product-main-image wtbx-lightbox-container" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($gridID); ?>">

			<?php if ( has_post_thumbnail() ) {
				$ratio = wtbx_option('product-image-ratio');
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

				$html  = '<div class="thumb-wrapper wtbx_preloader_cont">';
				if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
					ob_start();
					include(locate_template('templates/components/preloader.php'));
					$html .= ob_get_clean();
				endif;
				$html .= '<div class="woocommerce-product-gallery__image--placeholder thumb-inner wtbx-reveal-cont wtbx-element-reveal">';
				$html .= '<a href="'.esc_url($img_src_lb) .'" data-image="' . esc_attr($imgID) . '" itemprop="image" class="woocommerce-main-image wtbx-lightbox-item" data-thumbimage="'. esc_url(wp_get_attachment_image_url(  get_post_thumbnail_id(), 'medium' )) .'">';
				$html .= wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt, 'wp-post-image', true);
				$html .= '<img src="'.wp_get_attachment_url($imgID).'" alt="'.esc_attr($alt).'" class="thumb-fullsize" />';
				$html .= '</a>';
				$html .= '</div>';
				$html .= '</div>';
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $product->get_image_id() );

			?>

			<?php include(locate_template('templates/components/lightbox-nav.php')); ?>

		</div>

		<?php do_action( 'woocommerce_product_thumbnails' ); ?>

	</figure>
</div>
