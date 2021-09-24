<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$columns        = wtbx_option('shop-columns', 4);
$cat_columns    = wtbx_option('shop-cat-columns', 2);
$gridID         = hexdec(substr(uniqid(), 6, 7));

if ( wtbx_demo() ) {
	if (isset($_GET['col'])) {
		$columns = intval($_GET['col']);
	}

	if ( isset($_GET['layout']) && $_GET['layout'] === 'shop-no-sidebar' ) {
		$columns = 4;
	}
}
?>
<div class="wtbx-grid-wrapper wtbx-product-grid-wrapper">
	<?php
		include_once(locate_template('templates/components/lightbox-nav.php'));
        wtbx_script_queue('isotope');
	?>

	<ul class="products wtbx-grid-products wtbx-container-reveal wtbx-lightbox-container clearfix columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>" data-columns="<?php echo esc_attr($columns); ?>" data-cat-columns="<?php echo esc_attr($cat_columns); ?>" data-id="<?php echo esc_attr($gridID); ?>" data-grid="product" <?php echo wtbx_lightbox_attributes(); ?>>

	<?php
	$ajax_settings = array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php?action=' . 'preview_product',
	);
    wtbx_localize_main_js('wtbx_products_grid_' . $gridID, $ajax_settings);

	?>