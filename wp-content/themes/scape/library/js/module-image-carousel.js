
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.imageCarousel = {

		init: function($container) {
			if ( !$container ) {
				$container = $('.wtbx_vc_image_carousel .wtbx_image_carousel_inner');
			}
			if ( $container.length ) {
				$container.each(function() {

					function setPrevNext(activeSlide, slideCount) {
						if ( SCAPE.viewport().width > 767  ) {
							var prev = ( activeSlide > 0 ) ? activeSlide - 1 : slideCount - 1;
							var next = ( activeSlide < (slideCount - 1) ) ? activeSlide + 1 : 0;

							$slider.find('.wtbx_carousel_item.wtbx_slide_current').removeClass('wtbx_slide_current');
							$slider.find('.wtbx_carousel_item.wtbx_slide_prev').removeClass('wtbx_slide_prev');
							$slider.find('.wtbx_carousel_item.wtbx_slide_next').removeClass('wtbx_slide_next');

							$slider.find('.wtbx_carousel_item').eq(activeSlide).addClass('wtbx_slide_current');
							$slider.find('.wtbx_carousel_item').eq(prev).addClass('wtbx_slide_prev');
							$slider.find('.wtbx_carousel_item').eq(next).addClass('wtbx_slide_next');
						} else {
							$slider.find('.wtbx_carousel_item.wtbx_slide_current').removeClass('wtbx_slide_current');
							$slider.find('.wtbx_carousel_item.wtbx_slide_prev').removeClass('wtbx_slide_prev');
							$slider.find('.wtbx_carousel_item.wtbx_slide_next').removeClass('wtbx_slide_next');
						}
					}

					var $slider = $(this),
						align = $slider.data('align'),
						slidesToScroll = $slider.data('slides-to-scroll'),
						attraction = $slider.data('attraction'),
						friction = $slider.data('friction'),
						dots = $slider.data('dots') === 1,
						pauseOnHover = $slider.data('pause'),
						initialSlide = $slider.data('initial'),
						autoplaySpeed = $slider.data('autoplay'),
						height = $slider.data('height'),
						freescroll = $slider.data('freescroll'),
						autoplay = (autoplaySpeed !== '' && autoplaySpeed > 0) ? autoplaySpeed : false;

					var options = {
						prevNextButtons:	false,
						cellAlign:			align,
						wrapAround:			true,
						groupCells:			slidesToScroll,
						selectedAttraction:	attraction,
						friction:			friction,
						initialIndex:		initialSlide,
						autoPlay:			autoplay,
						adaptiveHeight: 	height,
						pauseAutoPlayOnHover: pauseOnHover,
						freeScroll:			freescroll
					};

					$slider.flickity(options);
					$slider.closest('.wtbx_image_carousel_wrapper').addClass('wtbx_slider_init');
					$slider.find('.flickity-page-dots').wrap('<div class="'+$slider.data("pagination-class")+'"></div>');
					SCAPE.customCursor.bindClick($slider.find('.flickity-page-dots').find('li'));

					$(window).on( 'load', function() {
						$slider.flickity('resize');
					});

					if ( $slider.closest('.wtbx_vc_image_carousel').find('.wtbx_image_carousel_pagination').hasClass('wtbx_dots_style_3') ) {
						SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
					}

					if ( $slider.closest('.wtbx_vc_image_carousel').find('.wtbx_image_carousel_pagination').hasClass('wtbx_dots_style_3') ) {
						$(window).resize(function() {
							SCAPE.waitForFinalEvent( function() {
								SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
							}, SCAPE.timeToWaitForLast, 'image_carousel');
						});
					}

					if ($slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_overlap') || $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_centered')) {
						setPrevNext($slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
					}

					$slider.on( 'select.flickity', function() {
						if ( $slider.closest('.wtbx_vc_image_carousel').find('.wtbx_image_carousel_pagination').hasClass('wtbx_dots_style_3') ) {
							SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						}

						if ($slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_overlap') || $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_centered')) {
							setPrevNext($slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						}

						if ( $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_scale') || $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_centered') ) {
							$slider.closest('.wtbx_image_carousel_wrapper').find('.wtbx_arrows').addClass('wtbx_sliding');
							setTimeout(function() {
								$slider.closest('.wtbx_image_carousel_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
							}, 1000);
						}
					});

					$slider.on( 'dragStart.flickity', function() {
						if ( $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_scale') || $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_centered') ) {
							$slider.closest('.wtbx_image_carousel_wrapper').find('.wtbx_arrows').addClass('wtbx_sliding');
						}
					});

					$slider.on( 'settle.flickity dragEnd.flickity', function() {
						$slider.closest('.wtbx_image_carousel_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
					});

					$slider.on( 'scroll.flickity', function(event, progress) {
						if ( $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_scale') || $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_centered') ) {
							if ( !$slider.find('.flickity-viewport').hasClass('is-pointer-down') ) {
								var data = $slider.data('flickity'),
									slide_progress = (data.selectedIndex / (data.slides.length - 1));

								if ( slide_progress - progress < 0.01 ) {
									$slider.closest('.wtbx_image_carousel_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
								}
							}
						}
					});

					if ( $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_scale') || $slider.closest('.wtbx_vc_image_carousel').hasClass('wtbx_style_centered') ) {
						$(window).resize(function() {
							SCAPE.waitForFinalEvent( function() {
								$slider.closest('.wtbx_image_carousel_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
							}, 500, 'image_carousel_buttons');
						});
					}

					// Button Navigation
					$slider.parent().find('.wtbx_arrow_prev').on('click', function () {
						$slider.flickity('previous');
						$slider.trigger('focus');
					});
					$slider.parent().find('.wtbx_arrow_next').on('click', function () {
						$slider.flickity('next');
						$slider.trigger('focus');
					});
				});
			}
		}
	};

	jQuery(document).ready(function($) {
		if ( !$('body').hasClass('wtbx-frontend-editor') ) {
			SCAPE.imageCarousel.init();
		}
	});


})(jQuery);