<?php
function wtbx_wp_scripts_and_styles() {

	if (!is_admin()) {

		/*
		 * Styles
		 */

		// register main stylesheet
		wp_register_style( 'scape-style', get_template_directory_uri() . '/library/css/app.css', array(), SCAPE_VERSION, 'all' );

		// register supplementary stylesheets
		wp_register_style( 'scape-woocommerce', get_template_directory_uri() . '/library/css/woocommerce.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog', get_template_directory_uri() . '/library/css/blog.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio', get_template_directory_uri() . '/library/css/portfolio.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-tabs', get_template_directory_uri() . '/library/css/module-tabs.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-tour', get_template_directory_uri() . '/library/css/module-tour.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-explist', get_template_directory_uri() . '/library/css/module-explist.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-listitem', get_template_directory_uri() . '/library/css/module-listitem.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-testimonial', get_template_directory_uri() . '/library/css/module-testimonial.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-contentslider', get_template_directory_uri() . '/library/css/module-contentslider.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-testimonialslider', get_template_directory_uri() . '/library/css/module-testimonialslider.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-videobutton', get_template_directory_uri() . '/library/css/module-videobutton.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-stepshor', get_template_directory_uri() . '/library/css/module-stepshor.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-icons', get_template_directory_uri() . '/library/css/module-icons.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-teammember', get_template_directory_uri() . '/library/css/module-teammember.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-pricing', get_template_directory_uri() . '/library/css/module-pricing.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-imagecascade', get_template_directory_uri() . '/library/css/module-imagecascade.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-imagecaption', get_template_directory_uri() . '/library/css/module-imagecaption.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-socialicons', get_template_directory_uri() . '/library/css/module-sicons.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-accordion', get_template_directory_uri() . '/library/css/module-accordion.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-service', get_template_directory_uri() . '/library/css/module-service.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-rating', get_template_directory_uri() . '/library/css/module-rating.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-banner', get_template_directory_uri() . '/library/css/module-banner.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-videoplayer', get_template_directory_uri() . '/library/css/module-videoplayer.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-gmaps', get_template_directory_uri() . '/library/css/module-gmaps.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-gdpr', get_template_directory_uri() . '/library/css/module-gdpr.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-filter', get_template_directory_uri() . '/library/css/module-filter.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-share', get_template_directory_uri() . '/library/css/module-share.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-sideheader', get_template_directory_uri() . '/library/css/module-sideheader.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-topheader', get_template_directory_uri() . '/library/css/module-topheader.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-fullscreen', get_template_directory_uri() . '/library/css/module-fullscreen.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-hero', get_template_directory_uri() . '/library/css/module-hero.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-widgets', get_template_directory_uri() . '/library/css/module-widgets.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-lightbox-style', get_template_directory_uri() . '/library/css/module-lightbox.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-plyr', get_template_directory_uri() . '/library/css/module-plyr.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-custom-scrollbar', get_template_directory_uri() . '/library/css/module-scrollbar.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-default-style', get_template_directory_uri() . '/library/css/module-blog-default.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-column-style', get_template_directory_uri() . '/library/css/module-blog-column.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-sbs-style', get_template_directory_uri() . '/library/css/module-blog-sbs.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-masonry-style', get_template_directory_uri() . '/library/css/module-blog-masonry.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-metro-style', get_template_directory_uri() . '/library/css/module-blog-metro.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-minimal-style', get_template_directory_uri() . '/library/css/module-blog-minimal.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-boxed-style', get_template_directory_uri() . '/library/css/module-blog-boxed.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-blog-magazine-style', get_template_directory_uri() . '/library/css/module-blog-magazine.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-comments', get_template_directory_uri() . '/library/css/module-comments.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-common', get_template_directory_uri() . '/library/css/module-portfolio-common.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-masonry', get_template_directory_uri() . '/library/css/module-portfolio-masonry.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-metro', get_template_directory_uri() . '/library/css/module-portfolio-metro.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-boxed', get_template_directory_uri() . '/library/css/module-portfolio-boxed.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-overlap', get_template_directory_uri() . '/library/css/module-portfolio-overlap.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-panels', get_template_directory_uri() . '/library/css/module-portfolio-panels.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-slider', get_template_directory_uri() . '/library/css/module-portfolio-slider.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-square', get_template_directory_uri() . '/library/css/module-portfolio-square.css', array(), SCAPE_VERSION, 'all' );
		wp_register_style( 'scape-portfolio-tiles', get_template_directory_uri() . '/library/css/module-portfolio-tiles.css', array(), SCAPE_VERSION, 'all' );


		// register custom stylesheet
		wp_register_style( 'scape-style-preloaders', wtbx_custom_styles_dir(true) . 'style-custom-preloaders.css', 'scape-style', time(), 'all' );
		wp_register_style( 'scape-style-custom', wtbx_custom_styles_dir(true) . 'style-custom.css', 'scape-style', time(), 'all' );


		// register theme UI font
		wp_register_style( 'scape-ui-font', get_template_directory_uri() . '/library/fonts/scape-ui.min.css', 'scape-style', SCAPE_VERSION, 'all' );



		/*
		 * Scripts
		 */

		// Comment reply script for threaded comments
		if ( !is_admin() && is_singular() && comments_open() && get_option('thread_comments') ) {
			if ( (get_post_type() === 'post' && wtbx_option('post-comments') === '1') || ( get_post_type() === 'page' && wtbx_option('page-comments') !== '0' ) ) {
				wp_enqueue_script('comment-reply');
			}
		}

		wp_deregister_script('isotope');
		wp_deregister_script('fullpage');
		wp_deregister_script('lazyload');

		// Add 3rd party plugins and libraries
		wp_register_script( 'lazyload', WTBX_URI . '/library/js/libs/min/lazyload.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'scape-waypoints', WTBX_URI . '/library/js/libs/min/jquery.waypoints.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'mega-menu', WTBX_URI . '/library/js/libs/min/jquery.mega-menu.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'hammer', WTBX_URI . '/library/js/libs/min/hammer.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'mousewheel', WTBX_URI . '/library/js/libs/min/jquery.mousewheel.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'slick', WTBX_URI . '/library/js/libs/min/slick.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'flickity', WTBX_URI . '/library/js/libs/min/flickity.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'smoothscroll', WTBX_URI . '/library/js/libs/min/smoothscroll.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'vivus', WTBX_URI . '/library/js/libs/min/vivus.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'countdown', WTBX_URI . '/library/js/libs/min/countdown.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'before-after', WTBX_URI . '/library/js/libs/min/before-after.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'typed', WTBX_URI . '/library/js/libs/min/typed.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'fullpage', WTBX_URI . '/library/js/libs/min/jquery.fullPage.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'custom-scrollbar', WTBX_URI . '/library/js/libs/min/custom-scrollbar.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'magnific-popup', WTBX_URI . '/library/js/libs/min/magnific-popup.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'packery', WTBX_URI . '/library/js/libs/min/packery.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'isotope', WTBX_URI . '/library/js/libs/min/isotope.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'plyr', WTBX_URI . '/library/js/libs/min/plyr.min.js', '', SCAPE_VERSION, true );
		wp_register_script( 'sticky-kit', WTBX_URI . '/library/js/libs/min/sticky-kit.min.js', '', SCAPE_VERSION, true );

		// Add theme scripts
		wp_register_script( 'scape-lightbox', WTBX_URI . '/library/js/module-lightbox.js', array('jquery', ), SCAPE_VERSION, true );
		wp_register_script( 'scape-modal', WTBX_URI . '/library/js/module-modal.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-gmaps', WTBX_URI . '/library/js/module-gmaps.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-videobg', WTBX_URI . '/library/js/module-videobg.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-portfolio-slider', WTBX_URI . '/library/js/module-portfolio-slider.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-woocommerce', WTBX_URI . '/library/js/module-woocommerce.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-fullpage', WTBX_URI . '/library/js/module-fullpage.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-testimonial-slider', WTBX_URI . '/library/js/module-testimonial-slider.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-content-slider', WTBX_URI . '/library/js/module-content-slider.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-steps', WTBX_URI . '/library/js/module-steps.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-sideheader', WTBX_URI . '/library/js/module-sideheader.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-sidearea', WTBX_URI . '/library/js/module-sidearea.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-language-switch', WTBX_URI . '/library/js/module-language-switch.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-banner', WTBX_URI . '/library/js/module-banner.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-tabs', WTBX_URI . '/library/js/module-tabs.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-pagenav', WTBX_URI . '/library/js/module-pagenav.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-image-carousel', WTBX_URI . '/library/js/module-image-carousel.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-pageheader', WTBX_URI . '/library/js/module-pageheader.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-parallax', WTBX_URI . '/library/js/module-parallax.js', array('jquery'), SCAPE_VERSION, true );

		wp_register_script( 'scape-blog-sbs', WTBX_URI . '/library/js/module-blog-sbs.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-blog-minimal', WTBX_URI . '/library/js/module-blog-minimal.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-blog-default', WTBX_URI . '/library/js/module-blog-default.js', array('jquery', 'plyr', 'slick'), SCAPE_VERSION, true );
		wp_register_script( 'scape-grid-metro', WTBX_URI . '/library/js/module-grid-metro.js', array('jquery'), SCAPE_VERSION, true );
		wp_register_script( 'scape-grid-general', WTBX_URI . '/library/js/module-grid-general.js', array('jquery', 'plyr', 'slick'), SCAPE_VERSION, true );


		/*
		 * Enqueue
		 */

		$post_type = get_post_type();
		if ( $post_type === 'post' ) {
			wp_enqueue_style('scape-blog');
			wp_enqueue_style('scape-share');
		} else if ( $post_type === 'portfolio' ) {
			wp_enqueue_style('scape-portfolio');
			wp_enqueue_style('scape-share');
		}


		if ( class_exists( 'Woocommerce' ) ) {
			wp_enqueue_style( 'scape-woocommerce' );
			wtbx_script_queue('scape-woocommerce');
		}


		if ( class_exists( 'GDPR' ) ) {
			wp_enqueue_style( 'scape-gdpr' );
		}


		// enqueue styles and scripts
		wp_enqueue_style( 'scape-style' );
		wp_enqueue_style( 'scape-style-preloaders' );
		wp_enqueue_style( 'scape-ui-font' );

		wtbx_page_defaults(false);

		// enqueue header styles
		$header_style = wtbx_option_levelled('header-style', '', '1');
		if ( in_array( $header_style, array( '12', '13', '14' ) ) ) {
			wp_enqueue_style( 'scape-sideheader' );
			wtbx_script_queue( 'scape-sideheader' );
		} else if ( in_array( $header_style, array( '10', '11' ) ) ) {
			wp_enqueue_style( 'scape-topheader' );
		}

		if ( $header_style !== 'off' && $header_style !== '' ) {
			wp_enqueue_style( 'scape-header-style', wtbx_custom_styles_dir(true) . 'style-custom-header-' . $header_style . '.css', 'scape-style', SCAPE_VERSION, 'all' );
		}


		// Add custom styles
		wtbx_add_styles();

		// Dynamic styles script
		add_action( 'wp_footer', 'wtbx_add_footer_styles' );

	}
}

function wtbx_admin_scripts_and_styles() {
	wp_enqueue_style( 'scape-custom-fields', get_template_directory_uri() . '/library/css/wtbx-custom-fields.css', array(), SCAPE_VERSION, 'all' );
	wp_enqueue_style( 'scape-theme-options', get_template_directory_uri() . '/library/css/theme-options.css', array(), SCAPE_VERSION, 'all' );
	wp_enqueue_style( 'scape-theme-dashboard', get_template_directory_uri() . '/library/css/theme-dashboard.css', array(), SCAPE_VERSION, 'all' );
	wp_enqueue_style( 'scape-ui-font', get_template_directory_uri() . '/library/fonts/scape-ui.min.css', 'scape-style', SCAPE_VERSION, 'all' );
	wp_enqueue_script( 'scape-blockui', WTBX_URI . '/library/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
	wp_enqueue_script( 'scape-dashboard', WTBX_URI . '/library/js/dashboard.js', array( 'jquery' ), SCAPE_VERSION, true );
}

function wtbx_gutenberg_styles() {
	if ( is_admin() ) {
		wp_enqueue_style( 'scape-gutenberg', get_template_directory_uri() . '/library/css/scape-gutenberg.css', array( 'wp-edit-blocks' ), SCAPE_VERSION, 'all' );
	}
}


function wtbx_add_styles() {

	// page content background and padding
	$content_bg = wtbx_option_levelled('page-layout-content-bg');
	$content_bg = $content_bg !== '' ? ' background-color:' . $content_bg . ';' : '';
	$content_padding_top = wtbx_option_levelled('page-layout-content-padding-top');
	$content_padding_top = $content_padding_top !== '' ? ' padding-top:' . intval($content_padding_top) . 'px;' : '';
	$content_padding_bottom = wtbx_option_levelled('page-layout-content-padding-bottom');
	$content_padding_bottom = $content_padding_bottom !== '' ? ' padding-bottom:' . intval($content_padding_bottom) . 'px;' : '';

	if ( $content_bg !== '' || $content_padding_top !== '' || $content_padding_bottom !== '' ) {
		wtbx_js_styles('#page-wrap {' . $content_bg . $content_padding_top . $content_padding_bottom .'}');
	}


	// extra page space
	$page_padding_top = wtbx_option_levelled('page-layout-space', 'padding-top');
	$page_padding_right = wtbx_option_levelled('page-layout-space', 'padding-right');
	$page_padding_bottom = wtbx_option_levelled('page-layout-space', 'padding-bottom');
	$page_padding_left = wtbx_option_levelled('page-layout-space', 'padding-left');

	$page_space_styles = '';
	$page_space_styles .= !empty($page_padding_top) ? ' padding-top:' . $page_padding_top . ';' : '';
	$page_space_styles .= !empty($page_padding_right) ? ' padding-right:' . $page_padding_right . ';' : '';
	$page_space_styles .= !empty($page_padding_bottom) ? ' padding-bottom:' . $page_padding_bottom . ';' : '';
	$page_space_styles .= !empty($page_padding_left) ? ' padding-left:' . $page_padding_left . ';' : '';

	if ( !empty($page_space_styles) ) {
		wtbx_js_styles('#main {' . $page_space_styles . '}');
	}

	// preloader styles
	$preloader_css = '.wtbx-site-preloader-inner {visibility:hidden; opacity: 0;}';
	wp_add_inline_style( 'scape-style', $preloader_css );

}