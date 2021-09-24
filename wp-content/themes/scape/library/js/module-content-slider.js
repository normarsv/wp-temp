
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.contentSlider = {

		init: function($container) {
			if ( !$container ) {
				$container = $('.wtbx_vc_content_slider .wtbx_content_slider_inner');
			}
			if ( $container.length ) {
				$container.each(function() {

					function setPrevNext(activeSlide, slideCount) {
						if ( SCAPE.viewport().width > 767  ) {
							var prev = ( activeSlide > 0 ) ? activeSlide - 1 : slideCount - 1;
							var next = ( activeSlide < (slideCount - 1) ) ? activeSlide + 1 : 0;

							$slider.find('.wtbx_vc_content_slide.wtbx_slide_current').removeClass('wtbx_slide_current');
							$slider.find('.wtbx_vc_content_slide.wtbx_slide_prev').removeClass('wtbx_slide_prev');
							$slider.find('.wtbx_vc_content_slide.wtbx_slide_next').removeClass('wtbx_slide_next');

							$slider.find('.wtbx_vc_content_slide').eq(activeSlide).addClass('wtbx_slide_current');
							$slider.find('.wtbx_vc_content_slide').eq(prev).addClass('wtbx_slide_prev');
							$slider.find('.wtbx_vc_content_slide').eq(next).addClass('wtbx_slide_next');
						} else {
							$slider.find('.wtbx_vc_content_slide.wtbx_slide_current').removeClass('wtbx_slide_current');
							$slider.find('.wtbx_vc_content_slide.wtbx_slide_prev').removeClass('wtbx_slide_prev');
							$slider.find('.wtbx_vc_content_slide.wtbx_slide_next').removeClass('wtbx_slide_next');
						}
					}


					var $slider = $(this),
						align = $slider.data('align'),
						slidesToScroll = $slider.data('slides-to-scroll') === 'auto' ? true : $slider.data('slides-to-scroll'),
						attraction = $slider.data('attraction'),
						friction = $slider.data('friction'),
						dots = $slider.data('dots') === 1,
						pauseOnHover = $slider.data('pause'),
						initialSlide = $slider.data('initial'),
						autoplaySpeed = $slider.data('autoplay'),
						freescroll = $slider.data('freescroll'),
						autoplay = (autoplaySpeed !== '' && autoplaySpeed > 0) ? autoplaySpeed : false,
						height = $slider.data('height'),
						drag = $slider.data('drag') === 1;

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
						freescroll:			freescroll
					};

					$slider.flickity(options);
					$slider.closest('.wtbx_content_slider_wrapper').addClass('wtbx_slider_init');
					$slider.find('.flickity-page-dots').wrap('<div class="'+$slider.data("pagination-class")+'"></div>');
					if ( $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_fixed') || $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_fixed_content') ) {
						SCAPE.contentSlider.fixed($slider);
					}

					$(window).on( 'load', function() {
						$slider.flickity('resize');
					});

					if ( $slider.find('.vc_chart').length ) {
						setInterval(function() {
							$slider.flickity('resize');
						}, 2000);
					}

					if ( $slider.closest('.wtbx_vc_content_slider').find('.wtbx_content_slider_pagination').hasClass('wtbx_dots_style_3') ) {
						SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
					}
					if ($slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_boxed_overlap')) {
						setPrevNext($slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
					}

					if ( $slider.closest('.wtbx_vc_content_slider').find('.wtbx_content_slider_pagination').hasClass('wtbx_dots_style_3') ) {
						$(window).resize(function() {
							SCAPE.waitForFinalEvent( function() {
								SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
							}, SCAPE.timeToWaitForLast, 'content_slider');
						});
					}

					$slider.on( 'select.flickity', function() {
						if ( $slider.closest('.wtbx_vc_content_slider').find('.wtbx_content_slider_pagination').hasClass('wtbx_dots_style_3') ) {
							SCAPE.sliderPagination($slider, $slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						}

						if ($slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_boxed_overlap')) {
							setPrevNext($slider.data('flickity').selectedIndex, $slider.flickity('getCellElements').length);
						}

						if ( $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_boxed_scale') ) {
							$slider.closest('.wtbx_content_slider_wrapper').find('.wtbx_arrows').addClass('wtbx_sliding');
						}
					});

					$slider.on( 'dragStart.flickity', function() {
						if ( $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_boxed_scale') ) {
							$slider.closest('.wtbx_content_slider_wrapper').find('.wtbx_arrows').addClass('wtbx_sliding');
						}
					});

					$slider.on( 'settle.flickity dragEnd.flickity', function() {
						$slider.closest('.wtbx_content_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
					});

					$slider.on( 'scroll.flickity', function(event, progress) {
						if ( $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_boxed_scale') ) {
							if ( !$slider.find('.flickity-viewport').hasClass('is-pointer-down') ) {
								var data = $slider.data('flickity'),
									slide_progress = (data.selectedIndex / (data.slides.length - 1));

								if ( slide_progress - progress < 0.01 ) {
									$slider.closest('.wtbx_content_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
								}
							}
						}

						if ( $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_fixed') || $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_fixed_content') ) {
							SCAPE.contentSlider.fixed($slider);
						}
					});

					if ( $slider.closest('.wtbx_vc_content_slider').hasClass('wtbx_style_boxed_scale') ) {
						$(window).resize(function() {
							SCAPE.waitForFinalEvent( function() {
								$slider.closest('.wtbx_content_slider_wrapper').find('.wtbx_arrows').removeClass('wtbx_sliding');
							}, 500, 'content_slider_buttons');
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

				});
			}
		},

		fixed: function($slider) {
			var flkty = $slider.data('flickity');
			var transform = SCAPE.propertyPrefix('transform');

			flkty.slides.forEach( function( slide, i ) {
				var scale = 1;
				var translate = 0;
				var rotate = 0;
				var zindex = 2;
				var opacity = 1;

				var slideOffset = $(slide.cells[0].element).offset().left - $slider.offset().left;
				var ratio = slideOffset / slide.cells[0].size.width;

				if ( Math.ceil(slideOffset, 1) < 0 ) {
					zindex = 1;
				}

				if ( slideOffset < 0 ) {
					scale = 1 + (ratio / 5);
					opacity = 1 + ratio;
					translate = slideOffset * -1;
					rotate = (slideOffset / 25) * -1;
				} else {
					scale = 1;
					opacity = 1;
					translate = 0;
					rotate = 0;
				}

				$slider.find('.wtbx_vc_content_slide').eq(i).css('z-index', zindex);
				$slider.find('.wtbx_vc_content_slide').eq(i).children('.wtbx_vc_content_slide_container').css({
					transform: 'translateX('+translate+'px) scale('+scale+') translateZ(0)',
					'opacity': opacity,
				}).toggleClass('slide-animated', slideOffset < 0);

			});
		}

	};

	jQuery(document).ready(function($) {
		if ( !$('body').hasClass('wtbx-frontend-editor') ) {
			SCAPE.contentSlider.init();
		}
	});

})(jQuery);