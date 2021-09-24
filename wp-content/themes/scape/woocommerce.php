<?php get_header(); ?>
<?php
$wtbx_layout = wtbx_layout_settings();
$layout_js_styles = '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#sidebar{width:' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? esc_html($wtbx_layout['sidebar_width']) : '340') . 'px}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#content{width:calc(100% - ' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? esc_html($wtbx_layout['sidebar_width']) : '340') . 'px)}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_font']) ? '#sidebar {'.esc_html(wtbx_font_styling($wtbx_layout['sidebar_font'])).'}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_padding']) ? '#sidebar .page-sidebar{padding-top:' . esc_html($wtbx_layout['sidebar_padding']) . 'px}' : '';
$layout_js_styles .= $wtbx_layout['content_limit'] !== '' ? '#container {max-width:'.esc_html(intval($wtbx_layout['content_limit'])).'px}' : '';

if ( !empty($layout_js_styles) ) {
    wtbx_js_styles($layout_js_styles);
}
?>

<?php
$container_class = '';
if ( is_product() ) {
	$container_class = 'container-single-product ';
} elseif ( is_shop() || is_product_category() || is_product_tag() ) {
	$container_class = 'container-woocommerce ';
}
?>

<div id="container" class="<?php echo esc_attr($container_class); ?>row-inner <?php echo (is_active_sidebar($wtbx_layout['sidebar_widgetarea']) || $wtbx_layout['sidebar'] === 'no_sidebar' ? esc_attr($wtbx_layout['sidebar']) : '') .  $wtbx_layout['fullwidth']; ?>">

	<?php if ( is_product() ) {
		include(locate_template('templates/section-pagination-single-top.php'));
	} ?>

	<div id="content">

        <?php if ( wtbx_demo() ) {
            if ( isset($_GET['onlycat']) && $_GET['onlycat'] === '1' ) {
                woocommerce_product_loop_start();
                woocommerce_output_product_categories();
                woocommerce_product_loop_end();
            } else {
                woocommerce_content();
            }
        } else {
            woocommerce_content();
        } ?>

	</div><!-- #content -->

	<?php if ( in_array( $wtbx_layout['sidebar'], array('sidebar_left', 'sidebar_left_sticky', 'sidebar_right', 'sidebar_right_sticky') ) && $wtbx_layout['sidebar_widgetarea'] !== 'none' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) )  : ?>

        <div id="sidebar" class="<?php echo esc_attr($wtbx_layout['sidebar_skin']), esc_attr($wtbx_layout['sidebar_sticky']); ?>">
			<?php  ?>
            <div class="page-sidebar">
				<div class="widget-area">
					<?php dynamic_sidebar($wtbx_layout['sidebar_widgetarea']); ?>
				</div>
			</div>
		</div><!-- #sidebar -->

	<?php endif; ?>

</div><!-- #container -->

<?php if ( is_product() ) {
	include(locate_template('templates/section-pagination-single-bottom.php'));
} ?>

<?php get_footer(); ?>