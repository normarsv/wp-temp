
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.testimonialSlider = {

		init: function($container) {
			if ( !$container ) {
				$container = $('.wtbx_vc_testimonial_slider .wtbx_testimonial_slider_inner');
			}
			if ( $container.length ) {
				$container.each(function() {

					function setPrevNext(activeSlide, slideCount) {
						if ( SCAPE.viewport().width > 767  ) {
							var prev = ( activeSlide > 0 ) ? activeSlide - 1 : slideCount - 1;
							var next = ( activeSlide < (slideCount - 1) ) ? activeSlide + 1 : 0;

							$slider.find('.wtbx_vc_testimonial_slide.wtbx_slide_current').removeClass('wtbx_slide_current');
							$slider.find('.wtbx_vc_testimonial_slide.wtbx_slide_prev').removeClass('wtbx_slide_prev');
							$slider.find('.wtbx_vc_testimonial_slide.wtbx_slide_next').removeClass('wtbx_slide_next');

							$slider.find('.wtbx_vc_testimonial_slide').eq(activeSlide).addClass('wtbx_slide_current');
							$slider.find('.wtbx_vc_testimonial_slide').eq(prev).addClass('wtbx_slide_prev');
							$slider.find('.wtbx_vc_testimonial_slide').eq(next).addClass('wtbx_slide_next');
						} else {
							$slider.find('.wtbx_vc_testimonial_slide.wtbx_slide_current').removeClass('wtbx_slide_current');
							$slider.find('.wtbx_vc_testimonial_slide.wtbx_slide_prev').removeClass('wtbx_slide_prev');
							$slider.find('.wtbx_vc_testimonial_slide.wtbx_slide_next').removeClass('wtbx_slide_next');
						}
					}

					var $slider = $(this),
						align = $slider.data('align'),
						slidesToScroll = $slider.data('slides-to-scroll') === 'auto' ? true : $slider.data('slides-to-scroll'),
						dots = $slider.data('dots') === 1,
						pauseOnHover = $slider.data('pause'),
						autoplaySpeed = $slider.data('autoplay'),
						attraction = $slider.data('attraction'),
						friction = $slider.data('friction'),
						height = $slider.data('height'),
						autoplay = (autoplaySpeed !== '' && autoplaySpeed > 0) ? autoplaySpeed : false;

					var options = {
						prevNextButtons:	false,
						cellAlign:			'center',
						wrapAround:			true,
						groupCells:			slidesToScroll,
						selectedAttraction:	attraction,
						friction:			friction,
						autoPlay:			autoplay,
						adaptiveHeight: 	height,
						pauseAutoPlayOnHover: pauseOnHover
					};

					$slider.flickity(options);
					$slider.closest('.wtbx_testimonial_slider_wrapper').addClass('wtbx_slider_init');
					$slider.find('.flickity-page-dots').wrap('<div class="'+$slider.data("pagination-class")+'"></div>');

					$(window).on( 'load', function() {
						$slider.flickity('resize');
					});

					if ( $slider.closest('.wtbx_vc_testimonial_slider').find('.wtbx_testimonial_slider_pagination').hasClass('wtbx_dots_style_3') ) {
						setTimeout(function() {
							SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						});
					}

					if ( $slider.closest('.wtbx_vc_testimonial_slider').find('.wtbx_testimonial_slider_pagination').hasClass('wtbx_dots_style_3') ) {
						$(window).resize(function() {
							SCAPE.waitForFinalEvent( function() {
								SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
							}, SCAPE.timeToWaitForLast, 'testimonial_slider');
						});
					}

					setPrevNext(0, $slider.flickity('getCellElements').length);

					$slider.on( 'select.flickity', function() {
						if ( $slider.closest('.wtbx_vc_testimonial_slider').find('.wtbx_testimonial_slider_pagination').hasClass('wtbx_dots_style_3') ) {
							SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						}

						if ( $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_2') || $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_3') ) {
							setPrevNext($slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						}

						if ( $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_1') || $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_2') ) {
							$slider.closest('.wtbx_testimonial_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
						}
					});

					$slider.on( 'dragStart.flickity', function() {
						if ( $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_1') || $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_2') ) {
							$slider.closest('.wtbx_testimonial_slider_wrapper').find('.wtbx_arrows').addClass('wtbx_sliding');
						}
					});

					$slider.on( 'settle.flickity dragEnd.flickity', function() {
						$slider.closest('.wtbx_testimonial_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
					});

					$slider.on( 'scroll.flickity', function(event, progress) {
						if ( $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_1') || $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_2') ) {
							if ( !$slider.find('.flickity-viewport').hasClass('is-pointer-down') ) {
								var data = $slider.data('flickity'),
									slide_progress = (data.selectedIndex / (data.slides.length - 1));

								if ( slide_progress - progress < 0.01 ) {
									$slider.closest('.wtbx_testimonial_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
								}
							}
						}
					});

					if ( $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_1') || $slider.closest('.wtbx_vc_testimonial_slider').hasClass('wtbx_style_2') ) {
						$(window).resize(function() {
							SCAPE.waitForFinalEvent( function() {
								$slider.closest('.wtbx_testimonial_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
							}, 500, 'testimonial_slider_buttons');
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

					SCAPE.customCursor.bindClick($slider.parent().find('.wtbx_arrow'));
					SCAPE.customCursor.bindClick($slider.find('.wtbx_dots li'));

				});
			}
		}
	};

	jQuery(document).ready(function($) {
		if ( !$('body').hasClass('wtbx-frontend-editor') ) {
			SCAPE.testimonialSlider.init();
		}
	});

})(jQuery);