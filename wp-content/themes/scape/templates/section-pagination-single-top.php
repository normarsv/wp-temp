<?php
$post_type      = get_post_type(wtbx_get_the_id());
$nav_layout     = wtbx_option($post_type.'-navigation-layout');

if ( $nav_layout === 'top' ) {
	$parent         = wtbx_option($post_type.'-navigation-parent');
	$parent_link    = get_post_type_archive_link( get_post_type(wtbx_get_the_id()) );
	$buttons        = wtbx_option($post_type.'-navigation-buttons');
	$skin           = wtbx_option($post_type.'-navigation-skin', 'light');

	if ( $post_type === 'post' || $post_type === 'portfolio' ) {
		if ( !empty(get_post_meta(get_the_id(), 'navigation-parent', true)) ) {
			$nav_index = get_post_meta(get_the_id(), 'navigation-parent', true);
			wtbx_nav_parent($nav_index);
			$parent_link = get_permalink($nav_index);
		}
	}

	$previous   = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next       = get_adjacent_post( false, '', false );

	$prev_label = $next_label = '';

	$prev_label = $previous ? $previous->post_title : '';
	$next_label = $next ? $next->post_title : '';

	$prev_subtitle = $next_subtitle = '';

	if ( 'post' === get_post_type() ) {
		$prev_subtitle = !empty($previous) ? '<i class="scape-ui-clock" aria-hidden="true"></i>' . get_the_date('j F Y', $previous->ID) : '';
		$next_subtitle = !empty($next) ? '<i class="scape-ui-clock" aria-hidden="true"></i>' . get_the_date('j F Y', $next->ID) : '';
	}

	$src_size           = 'thumbnail';
	$srcset_size        = 'medium';
	$prev_imgID         = !empty($previous) ? get_post_thumbnail_id( $previous->ID ) : '';
	$next_imgID         = !empty($next) ? get_post_thumbnail_id( $next->ID ) : '';

	$prev_thumb         = wtbx_image_smart_crop($prev_imgID, $src_size, $srcset_size, '1:1', $prev_label, '', true);
	$next_thumb         = wtbx_image_smart_crop($next_imgID, $src_size, $srcset_size, '1:1', $prev_label, '', true);

	?>

	<div class="wtbx-navigation-wrapper <?php echo esc_attr($post_type); ?>-nav-wrapper wtbx-page-nav-wrapper wtbx-layout-<?php echo esc_attr($nav_layout); ?>">
		<nav class="wtbx-navigation <?php echo esc_attr($post_type); ?>-nav wtbx-page-nav wtbx-skin-<?php echo esc_attr($skin); ?>">
			<div class="wtbx-nav-inner <?php echo esc_attr($post_type); ?>-nav-inner clearfix">
				<ul class="wtbx-col-sm-12 wtbx-nav-column">

					<?php // Back button
					if ( $parent === '1' ) : ?>
						<li><a class="wtbx-nav-back <?php echo esc_attr($post_type); ?>-back" href="<?php echo esc_url($parent_link); ?>" title="<?php echo esc_attr__( 'Back', 'scape' ); ?>">
							<div class="wtbx-nav-back-inner">
								<div class="dot first"></div>
								<div class="dot second"></div>
								<div class="dot third"></div>
							</div>
						</a></li>
					<?php endif;

					// Buttons
					if ( !empty($buttons) ) :
						previous_post_link(
							'<li class="wtbx-nav-prev '.$post_type.'-prev clearfix wtbx-element-reveal wtbx-reveal-cont">%link</li>',
							'<div class="wtbx-nav-thumb">'.$prev_thumb.'</div><div class="wtbx-nav-content"><span class="wtbx-nav-title wtbx-nav-title-prev">'.$prev_label.'</span><span class="wtbx-nav-meta wtbx-nav-meta-prev">'.$prev_subtitle.'<span></div>');
						next_post_link(
							'<li class="wtbx-nav-next '.$post_type.'-prev clearfix wtbx-element-reveal wtbx-reveal-cont">%link</li>',
							'<div class="wtbx-nav-content"><span class="wtbx-nav-title wtbx-nav-title-next">'.$next_label.'</span><span class="wtbx-nav-meta wtbx-nav-meta-next">'.$next_subtitle.'<span></div><div class="wtbx-nav-thumb">'.$next_thumb.'</div>');
					endif; ?>
				</ul>
			</div>
		</nav>
	</div>

<?php } ?>