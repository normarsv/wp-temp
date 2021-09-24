<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>" />
		<?php wp_head(); ?>
	</head>

	<?php
    $wtbx_page_defaults = wtbx_page_defaults();
	$global_site_preloader = $wtbx_page_defaults['global_site_preloader'];
	$global_site_transition = $wtbx_page_defaults['global_site_transition'];
	$global_site_reveal = $wtbx_page_defaults['global_site_reveal'];
	$smoothscroll = $wtbx_page_defaults['smoothscroll'];
	?>

	<body <?php body_class(); echo ( $smoothscroll == true ) ? ' data-smoothscroll="'. esc_attr($smoothscroll) .'"' : ''; echo ( !empty($global_site_transition) ) ? ' data-transition="'. esc_attr($global_site_transition) .'"' : '' ?>>
	<?php wp_body_open(); ?>
    <?php do_action('wtbx_body_start'); ?>

	<?php if ( $global_site_preloader !== '' ) {
		wp_enqueue_script( 'imagesloaded' );
		$preloader_type = 'global'; ?>
		<div id="wtbx-site-preloader" class="preloader_<?php echo esc_attr($global_site_reveal); ?>">
			<div class="wtbx-site-preloader-inner">
				<?php include(locate_template('templates/components/preloader.php')); ?>
			</div>
		</div>
	<?php } ?>

    <div id="site">

	<?php if ( !wtbx_maintenance() && 'content_block' !== get_post_type() ) { get_template_part( 'templates/header/header-mobile-side' ); } ?>

	<!-- Wrapper start -->
	<div id="wrapper">
		<?php if ( !wtbx_maintenance() && 'content_block' !== get_post_type() ) { get_template_part('templates/section', 'header'); } ?>

		<!-- Main start -->
		<div id="main" class="<?php echo esc_attr('wtbx-footer-' . wtbx_option_levelled('footer-style')); ?>">

			<?php $wtbx_fullscreen_slider = ( get_post_type() === 'page' && get_post_meta( get_the_id(), 'page-template-type-single', true ) === 'slider' ) ? true : false; ?>
			<?php if ( !wtbx_maintenance() && !$wtbx_fullscreen_slider && 'content_block' !== get_post_type() ) { get_template_part( 'templates/section', 'hero' ); } ?>

			<!-- Page-wrap start -->
			<div id="page-wrap" class="clearfix<?php if ($wtbx_fullscreen_slider) {echo ' page-wrap-slider';} ?>">