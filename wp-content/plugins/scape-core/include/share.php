<?php

add_action('woocommerce_product_meta_end', 'wtbx_share_woocommerce', 10);

function wtbx_share_woocommerce() {
	if ( wtbx_vc_option('product-share') !== '1' ) {
		echo '<div class="tags-n-share">';
			echo '<div class="product_share item-field">';
				echo '<div class="item-label">'. esc_html__( 'Share:', 'core-extension' ) . '</div>';
				echo '<div class="item-value clearfix">';
					wtbx_share_buttons();
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
}

function wtbx_share_buttons() {
	$post_type  = get_post_type();
	$data_title = get_the_title();
	$data_link  = isset($data_link) ? $data_link : get_permalink();

	if ( wtbx_vc_option($post_type.'-share-facebook') === '1' ) {
		echo '<div class="wtbx-share wtbx-share-mini wtbx-click" data-share="facebook" data-url="' . esc_url($data_link) . '"><i class="scape-ui-facebook"></i></div>';
	}

	if ( wtbx_vc_option($post_type.'-share-googleplus') === '1' ) {
		echo '<div class="wtbx-share wtbx-share-mini wtbx-click" data-share="googleplus" data-url="' . esc_url($data_link) . '"><i class="scape-ui-google-plus"></i></div>';
	}

	if ( wtbx_vc_option($post_type.'-share-linkedin') === '1' ) {
		echo '<div class="wtbx-share wtbx-share-mini wtbx-click" data-share="linkedin" data-url="' . esc_url($data_link) . '"><i class="scape-ui-linkedin"></i></div>';
	}

	if ( wtbx_vc_option($post_type.'-share-pinterest') === '1' )  {
		echo '<div class="wtbx-share wtbx-share-mini wtbx-click" data-share="pinterest" data-url="' . esc_url($data_link) . '"><i class="scape-ui-pinterest"></i></div>';
	}

	if ( wtbx_vc_option($post_type.'-share-twitter') === '1' ) {
		echo '<div class="wtbx-share wtbx-share-mini wtbx-click" data-share="twitter" data-title="' . esc_attr($data_title) . '" data-url="' . esc_url($data_link) . '"><i class="scape-ui-twitter"></i></div>';
	}

	if ( wtbx_vc_option($post_type.'-share-vkontakte') === '1' ) {
		echo '<div class="wtbx-share wtbx-share-mini wtbx-click" data-share="vk" data-title="' . esc_attr($data_title) . '" data-url="' . esc_url($data_link) . '"><i class="scape-ui-vk"></i></div>';
	}
}