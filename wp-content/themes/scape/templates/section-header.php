<?php

$header_style       = wtbx_option_levelled('header-style', '', '1');

if ( $header_style !== 'off' ) {

	$h_layout           = 'header-layout-' . $header_style;
	$header_skin        = wtbx_option_levelled('header-skin');
	$header_sticky      = wtbx_option_levelled('sticky-style');
	$header_sticky      = $header_sticky !== 'disabled' ? ' header_sticky header_sticky_' . $header_sticky : '';
	$sticky_skin        = wtbx_option_levelled('sticky-skin');
	$sticky_topbar      = wtbx_option('h-sticky-topbar');
	$sticky_topbar      = empty($sticky_topbar) ? ' header_sticky_no_topbar' : '';
	$sticky_bottombar   = wtbx_option('h-sticky-bottombar');
	$sticky_bottombar   = empty($sticky_bottombar) ? ' header_sticky_no_bottombar' : '';
	$breakpoint_width   = wtbx_option_sub('h'.$header_style.'-mobile-breakpoint', 'width');
	$breakpoint_height  = wtbx_option_sub('h'.$header_style.'-mobile-breakpoint', 'height');

	if ( $header_sticky !== '' ) {
		wtbx_localize_main_js('wtbxHeaderHeights', array(
			'topbar'        => wtbx_option('h'.$header_style.'-topbar-height'),
			'main_def'      => wtbx_option('h'.$header_style.'-height'),
			'main_sticky'   => wtbx_option('h-sticky-height'),
			'bottombar'     => wtbx_option('h'.$header_style.'-bottombar-height'),
		) );
	}
	?>

	<?php $wtbx_fullscreen_slider = ( get_post_type() === 'page' && get_post_meta( get_the_id(), 'page-template-type-single', true ) === 'slider' ) ? true : false; ?>

    <header id="site-header" class="<?php echo esc_attr($h_layout . $sticky_topbar . $sticky_bottombar); ?><?php if ($wtbx_fullscreen_slider) { echo ' with-fullscreen-slider'; } ?>" data-width="<?php echo esc_attr($breakpoint_width); ?>" data-height="<?php echo esc_attr($breakpoint_height); ?>" data-skin="<?php echo esc_attr($header_skin); ?>">
		<?php include(locate_template( 'templates/header/header-style-' . $header_style . '.php' )); // Include necessary header template ?>
		<?php include(locate_template( 'templates/header/header-mobile-top.php' )); // Include mobile top header template ?>
	</header><!-- #site-header -->
<?php }
