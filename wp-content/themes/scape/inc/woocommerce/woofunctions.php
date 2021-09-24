<?php
/*	
*	---------------------------------------------------------------------
*	Woocommerce functions
*	--------------------------------------------------------------------- 
*/

if ( class_exists( 'WooCommerce' ) ) {

	// Add Support
	add_theme_support( 'scape' );
	
	// Disable WooCommerce styles 
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	
	// Define Wrapper
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	// Remove Breadcrumbs
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

	// Remove sale flash from inappropriate place
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

	// Remove woocommerce tab heading when Visual Composer is used
	if ( ! function_exists( 'wtbx_no_product_description_heading' ) ) {
		function wtbx_no_product_description_heading() {
			return '';
		}
	}

	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open' );
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail' );
	remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );
	remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close' );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
	remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
	remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );



	add_action( 'woocommerce_before_shop_loop_item_title', 'wtbx_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_shop_loop_item_title', 'wtbx_loop_rating', 9 );
	add_action( 'woocommerce_shop_loop_item_title', 'wtbx_loop_product_title', 10 );
	add_action( 'woocommerce_wtbx_shop_loop_item_footer', 'wtbx_loop_price', 8 );
	add_action( 'woocommerce_wtbx_shop_loop_item_footer', 'wtbx_loop_add_to_cart', 10 );
	add_action( 'woocommerce_wtbx_shop_loop_item_footer', 'wtbx_loop_add_to_wishlist', 9 );
	add_action( 'woocommerce_after_single_product_summary', 'wtbx_upsells_args', 15 );
	add_action( 'woocommerce_shop_loop_subcategory_title', 'wtbx_loop_category_title', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 1 );
	add_action( 'woocommerce_widget_shopping_cart_buttons', 'wtbx_widget_shopping_cart_button_view_cart', 10 );
	add_action( 'woocommerce_widget_shopping_cart_buttons', 'wtbx_widget_shopping_cart_proceed_to_checkout', 20 );
	add_filter( 'woocommerce_output_related_products_args', 'wtbx_related_products_args' );
	add_filter( 'yith_wcwl_added_to_cart_message', 'wtbx_wishlist_to_cart_message' );
	add_filter( 'woocommerce_show_page_title', 'wtbx_hide_shop_title' );



	if ( ! function_exists( 'wtbx_hide_shop_title' ) ) {
		function wtbx_hide_shop_title( ) {
			return false;
		}
	}



	if ( ! function_exists( 'wtbx_widget_shopping_cart_button_view_cart' ) ) {
		function wtbx_widget_shopping_cart_button_view_cart( $args = array() ) {
			echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward wtbx-button wtbx-button-secondary button-sm">' . esc_html__( 'View cart', 'scape' ) . '</a>';
		}
	}



	if ( ! function_exists( 'wtbx_widget_shopping_cart_proceed_to_checkout' ) ) {
		function wtbx_widget_shopping_cart_proceed_to_checkout( $args = array() ) {
			echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward wtbx-button wtbx-button-primary button-sm">' . esc_html__( 'Checkout', 'scape' ) . '</a>';
		}
	}



	if ( ! function_exists( 'wtbx_loop_add_to_cart' ) ) {
		function wtbx_loop_add_to_cart( $args = array() ) {
			global $product;

			if ( $product ) {
				$defaults = array(
					'quantity' => 1,
					'class'    => implode( ' ', array_filter( array(
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
					) ) )
				);

				$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

				wc_get_template( 'loop/add-to-cart.php', $args );
			}
		}
	}



	if ( ! function_exists( 'wtbx_wishlist_add_to_cart' ) ) {
		function wtbx_wishlist_add_to_cart( $args = array() ) {
			global $product;

			if ( $product ) {
				$defaults = array(
					'quantity' => 1,
					'class'    => implode( ' ', array_filter( array(
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
					) ) )
				);

				$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

				wc_get_template( 'wishlist-add-to-cart.php', $args );
			}
		}
	}



	if ( ! function_exists( 'wtbx_wishlist_to_cart_message' ) ) {
		function wtbx_wishlist_to_cart_message( $message ) {
			return esc_html__( "Product has been added to your cart", 'scape' );
		}
	}



	// upsells per view
	if ( ! function_exists( 'wtbx_upsells_args' ) ) {
		function wtbx_upsells_args() {
			$product_count = wtbx_option('product-upsells-total', 12);
//			$product_count = $product_count === '' ? 12 : $product_count;
			woocommerce_upsell_display($product_count);
		}
	}



	// related products per view
	if ( ! function_exists( 'wtbx_related_products_args' ) ) {
		function wtbx_related_products_args( $args ) {
			$product_count = wtbx_option('product-related-total', 12);
//			$product_count = $product_count === '' ? 12 : $product_count;
			$args['posts_per_page'] = $product_count; // 4 related products
			return $args;
		}
	}



	// cross sells on cart page
	if ( ! function_exists( 'wtbx_cross_sell_display' ) ) {
		function wtbx_cross_sell_display( $posts_per_page = 2, $columns = 2, $orderby = 'rand' ) {
			wc_get_template( 'cart/cross-sells.php', array(
				'posts_per_page' => $posts_per_page,
				'orderby'        => $orderby,
				'columns'        => $columns
			) );
		}
	}



	if ( ! function_exists( 'wtbx_loop_add_to_wishlist' ) ) {
		function wtbx_loop_add_to_wishlist( $args = array() ) {
		    if ( class_exists('YITH_WCWL') ) {
			    global $product;

			    if ( $product && wtbx_option('product-wishlist') === '1' ) {
				    ob_start();
				    include(locate_template('woocommerce/wishlist-button.php'));
				    echo ob_get_clean();
			    }
            }
		}
	}



	if ( ! function_exists( 'wtbx_loop_product_thumbnail' ) ) {
		function wtbx_loop_product_thumbnail() {
			global $post, $product;

			$imgID_main     = get_post_thumbnail_id();
			$src_size       = 'medium';
			$srcset_size    = 'large';

			echo '<div class="wtbx-product-image">';

                if ( wtbx_option('shop-items-animation', 'none') !== '' && $imgID_main ) {
                    include(locate_template('templates/components/preloader.php'));
                }

                echo '<div class="wtbx-product-image-wrapper' . (wtbx_option('smart-images') === '1' ? ' wtbx-element-reveal' : '') . '">';

                    echo '<div class="wtbx-product-thumb">';
                        $imgID          = $imgID_main;
                        $img_src        = wp_get_attachment_image_url( $imgID, $src_size );
                        $img_srcset     = wp_get_attachment_image_srcset( $imgID, $srcset_size );
                        $alt            = $product->get_name();

                        $ratio = wtbx_option('product-tile-ratio');

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

                        if ( !empty($imgID) ) {
	                        wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
                        } else {
                            if ( !empty($ratio) && strpos($ratio, ':') !== false ) {
                                $ratios = explode(':', $ratio);
                                $padding = ' style="padding-bottom:' . $ratios[1] / $ratios[0] * 100 . '%"';
                            } else {
                                $padding = '';
                            }
                            echo '<div class="wtbx-no-image" data-text="'.esc_attr__('No image found', 'scape').'"'.$padding.'></div>';
                        }

                    echo '</div>';

                    if ( wtbx_option('product-tile-hover') === '1' ) {
                        $attachment_ids = $product->get_gallery_image_ids();

                        if ( $attachment_ids && isset($attachment_ids[0]) ) {
                            $imgID          = $attachment_ids[0];
                            $img_src        = wp_get_attachment_image_url( $imgID, $src_size );
                            $img_srcset     = wp_get_attachment_image_srcset( $imgID, $srcset_size );
                            $alt            = $product->get_name();

                            $ratio = wtbx_option('product-tile-ratio');

                            if ( $img_src !== false && $img_srcset !== false ) {
                                echo '<div class="wtbx-product-secondary">';

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
	                            wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
                                echo '</div>';
                            }
                        }
                    }

			    echo '</div>';
			echo '</div>';
		}
	}



	if ( ! function_exists( 'wtbx_subcategory_thumbnail' ) ) {
		function wtbx_subcategory_thumbnail( $category ) {
			global $post;

			$thumbnail_size  	= 'shop_catalog';
			$thumbnail_id  		= get_term_meta( $category->term_id, 'thumbnail_id', true  );

			if ( $thumbnail_id ) {
				$props          = wc_get_product_attachment_props( $thumbnail_id, $post );
				$src_size       = 'medium';
				$srcset_size    = 'large';
				$imgID          = $thumbnail_id;
				$img_src        = wp_get_attachment_image_url( $imgID, $src_size );
				$img_srcset     = wp_get_attachment_image_srcset( $imgID, $srcset_size );
				$alt            = $category->name;

				$ratio = wtbx_option('product-tile-ratio');

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

				wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);

			} else {
				echo wc_placeholder_img_src();
			}
		}
	}



	if (  ! function_exists( 'wtbx_loop_product_title' ) ) {
		function wtbx_loop_product_title() {
			global $post;
			echo '<h3>' . get_the_title() . '</h3>';

			if ( wtbx_option('product-tile-subtitle') === '1' ) {
				$subtitle = get_post_meta($post->ID, 'product-subtitle', true);
				if ($subtitle) {
					echo '<h4 class="product-subtitle">' . esc_html($subtitle) . '</h4>';
				}
			}

		}
	}



	if (  ! function_exists( 'wtbx_loop_category_title' ) ) {
		function wtbx_loop_category_title( $category ) { ?>
			<h3><?php echo esc_html($category->name); ?></h3>
		<?php
		}
	}



	if ( ! function_exists( 'wtbx_loop_price' ) ) {
		function wtbx_loop_price() {
			wc_get_template( 'loop/price.php' );
		}
	}



	if ( ! function_exists( 'wtbx_loop_rating' ) ) {
		function wtbx_loop_rating() {
			if ( wtbx_option('product-tile-rating') === '1' ) {
				wc_get_template( 'loop/rating.php' );
			}
		}
	}

    add_filter( 'woocommerce_format_sale_price', 'wtbx_sale_price', 10, 3 );

	if ( ! function_exists( 'wtbx_sale_price' ) ) {
		function wtbx_sale_price( $price, $regular_price, $sale_price ) {
			$price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
			return $price;
		}
    }



	if ( ! function_exists( 'wtbx_shop_link' ) ) {
		function wtbx_shop_link() {
		    $page = wtbx_option('shop-custom-page');
		    if ( !empty($page) ) {
			    return get_the_permalink($page);
            }
            return false;
		}
	}



	// Products per row
	if ( ! function_exists('wtbx_loop_columns') ) {
		function wtbx_loop_columns() {
			return wtbx_option('shop-columns', '4');
		}
	}
//	add_filter('loop_shop_columns', 'wtbx_loop_columns');

	// Redefine woocommerce_output_related_products
	if ( ! function_exists( 'woocommerce_related_products' ) ) {
			function woocommerce_output_related_products() {
				$args = array(
					'posts_per_page' => 3,
					'columns' => 3,
					'orderby' => 'rand'
				);
			woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
		}
	}



	// product comment gravatar
	if ( ! function_exists( 'woocommerce_review_display_gravatar' ) ) {
		function woocommerce_review_display_gravatar( $comment ) {
			echo '<div class="comment-author">';
			echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' );
			echo '</div>';
		}
	}



	// Products per page
	add_filter('loop_shop_per_page', 'wtbx_custom_product_count');
	if (!function_exists('custom_product_count')) {
		function wtbx_custom_product_count() {
			$product_count = wtbx_option('shop-perpage', '12');
			return $product_count;
		}
	}



	// The cart fragment (ensures the cart button updates via AJAX)
	add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_cart_button_fragment');
	function woocommerce_cart_button_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		wtbx_woocommerce_cart_button();
		$fragments['.header_cart_button'] = ob_get_clean();
		return $fragments;
	}



	// Displays the cart button in header
	function wtbx_woocommerce_cart_button($alt = false) {
		global $woocommerce;
		?>
		<span class="header_cart_button">
			<?php if ($alt) {
				echo '<i class="scape-ui-shopping-bag"></i>';
			} else {
				echo '<i class="scape-ui-shopping-bag"></i>';
			} ?>
			<?php
				echo '<span class="cart_product_count">'. $woocommerce->cart->get_cart_contents_count() .'</span>';
			?>
		</span>
		<?php
	}



	// Displays the cart content
	function woocommerce_cart_widget() {
		global $woocommerce;
		if ( ! is_cart() && ! is_checkout() ) {
			echo '<div class="header_cart_widget">';
				the_widget( 'WC_Widget_Cart', 'title=' );
			echo '</div>';
		}
	}

}