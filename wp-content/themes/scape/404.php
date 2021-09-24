<?php get_header(); ?>
<?php $wtbx_layout = wtbx_layout_settings();
$layout_js_styles = '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#sidebar{width:' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? $wtbx_layout['sidebar_width'] : '340') . 'px}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#content{width:calc(100% - ' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? $wtbx_layout['sidebar_width'] : '340') . 'px)}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && $wtbx_layout['sidebar_font'] !== '' ? '#sidebar{'.wtbx_font_styling($wtbx_layout['sidebar_font']).'}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_padding']) ? '#sidebar .page-sidebar{padding-top:' . esc_html($wtbx_layout['sidebar_padding']) . 'px}' : '';
$layout_js_styles .= $wtbx_layout['content_limit'] !== '' ? '#container {max-width:'.intval($wtbx_layout['content_limit']).'px}' : '';
if ( !empty($layout_js_styles) ) {
	wtbx_js_styles($layout_js_styles);
}
?>

	<div id="container" class="row-inner <?php echo esc_attr($wtbx_layout['sidebar'], $wtbx_layout['fullwidth']); ?>">
		<div id="content">
			<article id="post-0" class="post error404 not-found clearfix">

				<?php if ( wtbx_option('404-style') === 'default' ) : ?>

				<div class="entry-content error-content">
					<div class="row-inner">
						<div class="wtbx-col-sm-12">
							<h1><?php esc_html_e( '404', 'scape' ); ?></h1>
							<h2><?php esc_html_e( 'Page not found', 'scape' ); ?></h2>
							<p><?php esc_html_e( 'Looks like the page you were looking for doesn\'t exist. This could be a spelling error in the URL or a removed page.', 'scape' ); ?></p>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wtbx-button wtbx-button-primary button-lg"><?php esc_html_e('Go back to home page', 'scape'); ?></a>
						</div>
					</div>
				</div><!-- .entry-content -->

				<?php elseif ( wtbx_option('404-style') === 'custom' && wtbx_option('404-style-custom') !== '' ) :

					$content_block = wtbx_option('404-style-custom');
					if ( $content_block !== '' ) {
						$content_block = wtbx_get_translated_content_block($content_block);
						$s_ID = get_post($content_block);
						if ( isset( $s_ID->post_content) ) {
							$content = $s_ID->post_content;
						} else {
							$content = '';
						}
						echo apply_filters('the_content', $content);
                    }

				endif; ?>

			</article><!-- #post-0 -->
		</div><!-- #content -->

		<?php if ( in_array( $wtbx_layout['sidebar'], array('sidebar_left', 'sidebar_left_sticky', 'sidebar_right', 'sidebar_right_sticky') ) && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ) : ?>

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