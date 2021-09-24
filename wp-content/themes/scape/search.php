<?php get_header(); ?>
<?php
$wtbx_layout = wtbx_layout_settings();
$layout_js_styles = '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#sidebar{width:' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? esc_html($wtbx_layout['sidebar_width']) : '340') . 'px}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#content{width:calc(100% - ' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? esc_html($wtbx_layout['sidebar_width']) : '340') . 'px)}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_font']) ? '#sidebar{'.esc_html(wtbx_font_styling($wtbx_layout['sidebar_font'])).'}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_padding']) ? '#sidebar .page-sidebar{padding-top:' . esc_html($wtbx_layout['sidebar_padding']) . 'px}' : '';
$layout_js_styles .= $wtbx_layout['content_limit'] !== '' ? '#container {max-width:'.esc_html(intval($wtbx_layout['content_limit'])).'px}' : '';
if ( !empty($layout_js_styles) ) {
	wtbx_js_styles($layout_js_styles);
}
?>

	<div id="container" class="row-inner <?php echo (is_active_sidebar($wtbx_layout['sidebar_widgetarea']) || $wtbx_layout['sidebar'] === 'no_sidebar' ? esc_attr($wtbx_layout['sidebar']) : '') .  $wtbx_layout['fullwidth']; ?>">
		<div id="content">

			<?php if ( have_posts() ) : ?>
                <div class="wtbx-search-page-count">
					<?php echo sprintf(esc_html__('%s results found', 'scape'), $wp_query->found_posts); ?>
                </div>
			<?php endif; ?>

			<h2 class="wtbx-search-page-label">
				<?php esc_html_e( 'Searching for:', 'scape' ); ?>
			</h2>

			<div id="wtbx-search-page-searchform">
				<?php
					$post_types = wtbx_option('search-page-post-types');
					include(locate_template('templates/components/searchform.php'));
				?>
			</div>

			<?php
				if ( have_posts() ) : ?>
					<div class="results-container">
						<?php while ( have_posts() ) : the_post();
								include(locate_template( 'templates/search-result.php' ));
							endwhile; ?>
					</div>
				<?php else : ?>
					<div class="wtbx-search-page-count">
						<?php echo esc_html__('No results found', 'scape'); ?>
					</div>
				<?php endif; ?>

			<nav class="wtbx-pagination wtbx-skin-light">
				<div class="row-inner">
					<?php echo wtbx_navigation(); ?>
				</div>
			</nav>

		</div><!-- #content -->

		<?php if ( in_array( $wtbx_layout['sidebar'], array('sidebar_left', 'sidebar_left_sticky', 'sidebar_right', 'sidebar_right_sticky') ) && $wtbx_layout['sidebar_widgetarea'] !== 'none' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) )  : ?>

            <div id="sidebar" class="<?php echo esc_attr($wtbx_layout['sidebar_skin']), esc_attr($wtbx_layout['sidebar_sticky']); ?>">
                <div class="page-sidebar">
					<div class="widget-area">
						<?php dynamic_sidebar($wtbx_layout['sidebar_widgetarea']); ?>
					</div>
				</div>
			</div><!-- #sidebar -->

		<?php endif; ?>

	</div><!-- #container -->

<?php get_footer(); ?>