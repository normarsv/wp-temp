<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id) ?>">
	<?php if( ! ( $disable_wishlist && ! is_user_logged_in() ) ): ?>
	    <div class="yith-wcwl-add-button <?php if ( $exists && ! $available_multi_wishlist ) {echo 'hide';} else {echo 'show';} ?>" style="display:<?php if ( $exists && ! $available_multi_wishlist ) {echo 'none';} else {echo 'block';} ?>">
	        <?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>
	    </div>

	    <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
		    <i class="scape-ui-heart-filled" aria-hidden="true"></i>
		    <span class="feedback"><?php echo wp_kses_post($product_added_text) ?></span>
	        <a href="<?php echo esc_url( $wishlist_url )?>" rel="nofollow">
	            <span class="wishlist-browse"><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?></span>
	        </a>
	    </div>

	    <div class="yith-wcwl-wishlistexistsbrowse <?php if ( $exists && ! $available_multi_wishlist ) {echo 'show';} else {echo 'hide';} ?>" style="display:<?php if ( $exists && ! $available_multi_wishlist ) {echo 'block';} else {echo'none';} ?>">
	        <i class="scape-ui-heart-filled" aria-hidden="true"></i>
	        <span class="feedback"><?php echo wp_kses_post($already_in_wishslist_text) ?></span>
		    <a href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow">
		        <span class="wishlist-browse"><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?></span>
	        </a>
	    </div>

	    <div style="clear:both"></div>
	    <div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" rel="nofollow" class="<?php echo str_replace( 'add_to_wishlist', '', $link_classes ) ?>" >
			<i class="scape-ui-heart-filled" aria-hidden="true"></i>
			<?php echo esc_html($label) ?>
		</a>
	<?php endif; ?>

</div>

<div class="clear"></div>