<?php get_header(); ?>
<?php $wtbx_layout = wtbx_layout_settings();
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
		<div id="content" class="<?php echo esc_attr($wtbx_layout['side_padding']); ?>">
			<?php
			$post_type = get_post_type(wtbx_get_the_id());

			if ( is_author() && wtbx_option('post-author-custom') !== '' ) {
				wtbx_is_archive(true);
				$content_block = wtbx_option('post-author-custom');
				if ( $content_block !== '' ) {
					$content_block = wtbx_get_translated_content_block($content_block);
					$s_ID = get_post($content_block);
					if ( isset($s_ID->post_content) ) {
						$content = $s_ID->post_content;
					} else {
						$content = '';
					}
					echo apply_filters('the_content', $content);
                }
			} elseif ( $post_type === 'post' ) {
				if ( !empty(get_post_meta(get_the_ID(), 'navigation-parent', true)) ) {
					$content_block = get_post_meta(get_the_ID(), 'navigation-parent', true);
				} else {
					$content_block = wtbx_option('post-archive-custom');
				}

				if ( !empty($content_block) ) {
					if ( is_archive() ) {
						wtbx_is_archive(true);
					}
					$content_block = wtbx_get_translated_content_block($content_block);

					$s_ID = get_post($content_block);
					$content = $s_ID->post_content;
					echo apply_filters('the_content', $content);
				} else {
					$meta_class = $hide_meta = '';
					$meta_array = array();
					$excerpt_length = '';
					?>

                    <div class="wtbx_blog_grid_wrapper blog-default">
                        <div class="wtbx-grid-wrapper">
                            <div class="blog-grid wtbx-grid wtbx-grid-default wtbx-container-reveal wtbx-lightbox-container row-inner clearfix" data-grid="blog">

                                <?php if ( have_posts() ) :
                                    while ( have_posts() ) : the_post();
                                        $postID = get_the_ID();
                                        include(locate_template('templates/blog-post/default/blog-entry-default.php'));
                                    endwhile;
                                else :
                                    get_template_part( 'templates/nothing-found' );
                                endif; ?>

                                <?php include(locate_template('templates/section-pagination.php')); ?>

                            </div>
                        </div>
                    </div><?php

					wp_enqueue_style('scape-blog-default-style');
					wp_enqueue_script('scape-blog-default');

				}

			} elseif ( $post_type === 'portfolio' ) {
				if ( !empty(get_post_meta(get_the_ID(), 'navigation-parent', true)) ) {
					$content_block = get_post_meta(get_the_ID(), 'navigation-parent', true);
				} else {
					$content_block = wtbx_option('portfolio-archive-custom');
				}

				if ( !empty($content_block) ) {
					if ( is_archive() ) {
						wtbx_is_archive(true);
					}
					$content_block = wtbx_get_translated_content_block($content_block);

					$s_ID = get_post($content_block);
					$content = $s_ID->post_content;
					echo apply_filters('the_content', $content);
				} else {
					echo do_shortcode('[vc_scape_portfolio_grid style="square" columns="4" gutter="30" border="4" aspect_ratio="4:3" animation_style="slideup" color_skin="light" overlay_content_separate="icon" click_action_separate="link" overlay_trigger="overlay_appear" portfolio_content_primary_separate="title" portfolio_content_secondary_separate="categories" meta_alignment="left" query="global" filter="minimal" filter_skin="light" filter_scheme="default" perpage="12" navigation="1" nav_skin="light"]');
				}
			} else {
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'templates/section-content' );
					endwhile;
				else :
					get_template_part( 'templates/nothing-found' );
				endif;
			}
			?>
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