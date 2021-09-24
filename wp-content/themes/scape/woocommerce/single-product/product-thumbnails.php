<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$src_size       = 'thumbnail';
$srcset_size    = 'medium';

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && $product->get_image_id() ) { ?>
	<div class="thumbnails-wrapper">
		<ul class="thumbnails flex-control-nav"><?php

			foreach ( $attachment_ids as $attachment_id ) {

				$imgID          = $attachment_id;
				$img_src        = wp_get_attachment_image_url( $imgID, $src_size );
				$img_src_lb     = wp_get_attachment_image_url( $imgID, 'full' );
				$img_srcset     = wp_get_attachment_image_srcset( $imgID, $srcset_size );
				$alt            = get_the_title();

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

				$html  = '<li class="thumb-wrapper wtbx_preloader_cont">';
				$html .= '<div class="thumb-inner wtbx-reveal-cont wtbx-element-reveal">';
				$html .= '<a class="thumb-image" href="'.esc_url($img_src_lb).'" data-image="' . esc_attr($imgID) . '" data-thumbimage="'. esc_url(wp_get_attachment_image_url(  $imgID, 'medium' )) .'" data-largeimg="'.esc_url(wp_get_attachment_image_url( $imgID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) )) .'">';
				$html .= wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt, '', true);
				$html .= '<img src="'.wp_get_attachment_url($imgID).'" alt="'.esc_attr($alt).'" class="thumb-fullsize" />';
				$html .= '</a>';
				$html .= '</div>';
				$html .= '</li>';

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );

			} ?>

		</ul>
	</div>

	<?php
}
