<?php wtbx_maintenance(true); ?>
<?php get_header(); ?>

<?php
$content_block = wtbx_option('maintenance-page');

if ( $content_block !== '' ) {
	$content_block = wtbx_get_translated_content_block($content_block);

	$s_ID = get_post($content_block);
	$content = $s_ID->post_content;
	echo apply_filters('the_content', $content);
} else { ?>

	<div id="wrapper">
		<div id="main">
			<div id="page-wrap">
				<div class="wtbx-maintenance-wrapper">
					<div class="wtbx-maintenance-inner clearfix">
						<article>
							<div class="wtbx-col-sm-9">
								<h1><?php esc_html_e('We&rsquo;ll be back soon!', 'scape'); ?></h1>
								<p><?php esc_html_e('Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. We&rsquo;ll be back online shortly!', 'scape'); ?></p>
								<p class="maintenance-team"><em><?php esc_html_e('&mdash; The Team', 'scape'); ?></em></p>
							</div>
							<div class="wtbx-col-sm-3">
								<i class="scape-ui-gear"></i>
							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>

<?php get_footer(); ?>
