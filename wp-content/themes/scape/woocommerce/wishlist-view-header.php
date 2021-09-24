<?php
/**
 * Wishlist header
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist \YITH_WCWL_Wishlist Current wishlist
 * @var $is_custom_list bool Whether current wishlist is custom
 * @var $can_user_edit_title bool Whether current user can edit title
 * @var $form_action string Action for the wishlist form
 * @var $page_title string Page title
 * @var $fragment_options array Array of items to use for fragment generation
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<div class="row-inner">
	<div class="wtbx-col-sm-12">

		<?php do_action( 'yith_wcwl_before_wishlist_form', $wishlist_meta ); ?>

		<form id="yith-wcwl-form" action="<?php echo esc_attr($form_action) ?>" method="post" class="woocommerce wtbx-wishlist-form wtbx-cart">

			<?php wp_nonce_field( 'yith-wcwl-form', 'yith_wcwl_form_nonce' ) ?>

		    <!-- TITLE -->
		    <?php
		    do_action( 'yith_wcwl_before_wishlist_title', $wishlist_meta );

		    if( ! empty( $page_title ) ) :
		    ?>
			    <div class="wishlist-title <?php if ( $is_custom_list ) {echo 'wishlist-title-with-form';} ?>">
		            <?php echo apply_filters( 'yith_wcwl_wishlist_title', '<h2>' . $page_title . '</h2>' ); ?>
				    <?php if( $is_custom_list ): ?>
		                <a class="btn button show-title-form">
		                    <?php echo apply_filters( 'yith_wcwl_edit_title_icon', '<i class="scape-ui-pencil"></i>' )?>
		                    <?php esc_html_e( 'Edit title', 'scape' ) ?>
		                </a>
		            <?php endif; ?>
		        </div>
			    <?php if( $is_custom_list ): ?>
		            <div class="hidden-title-form">
		                <input type="text" value="<?php echo esc_attr($page_title) ?>" name="wishlist_name"/>
		                <button>
		                    <?php echo apply_filters( 'yith_wcwl_save_wishlist_title_icon', '<i class="scape-ui-check"></i>' )?>
		                    <?php esc_html_e( 'Save', 'scape' )?>
		                </button>
		                <a class="hide-title-form btn button">
		                    <?php echo apply_filters( 'yith_wcwl_cancel_wishlist_title_icon', '<i class="scape-ui-trash-2"></i>' )?>
		                    <?php esc_html_e( 'Cancel', 'scape' )?>
		                </a>
		            </div>
		        <?php endif; ?>
		    <?php
		    endif;

		    do_action( 'yith_wcwl_before_wishlist', $wishlist_meta ); ?>

