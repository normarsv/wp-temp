
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.portfolioGridSlider = {

		init: function ($container) {
			$($container).each(function () {
				$container = $(this);
				SCAPE.portfolioGridSlider.setup($container);
			});
		},

		setup: function ($container) {
			var style = $container.hasClass('wtbx-grid-panels') ? 'panels' : 'slider';

			if ($container.find('.wtbx-'+style+'-entry').length) {

				var progress = function($container) {
					var $bar = $container.parent().find('.portfolio-'+style+'-progress .bar');
					var $counter = $container.parent().find('.portfolio-'+style+'-counter');
					var total = $container.data('flickity').slides.length;
					var current = $container.data('flickity').selectedIndex;
					var progress = (current+1) / total;

					var transform = SCAPE.propertyPrefix('transform');
					$bar.css(transform, 'scale3d('+progress+',1,1)');

					$counter.find('span').removeClass('active');
					$counter.find('span').eq(current).addClass('active');
				};

				var bgImage = function($container) {
					var current = $container.data('flickity').selectedIndex;
					var $bg = $container.siblings('.portfolio-slider-bg').find('.portfolio-slider-bg-inner');

					$bg.removeClass('active');
					$bg.eq(current).addClass('active');
				};

				var options = {
					prevNextButtons:	false,
					cellAlign:			style === 'panels' ? 'right' : 'left',
					adaptiveHeight:		true,
					wrapAround:			true,
					groupCells:			false,
					pageDots:			false,
					draggable:			SCAPE.viewport().width <= SCAPE.breakpoints.mobile,
					selectedAttraction:	0.08,
					friction:			0.8,
					imagesLoaded:		false,
					accessibility:		false,
					rightToLeft:		style === 'panels'
				};

				$container.flickity(options);
				$container.attr('tabindex', 0);

				var $meta = $container.siblings('.portfolio-'+style+'-content').find('.portfolio-'+style+'-meta');
				$meta.removeClass('active');
				$meta.eq(0).addClass('active');

				progress($container);

				if ( style === 'slider' && SCAPE.viewport().width > SCAPE.breakpoints.mobile ) {
					bgImage($container);
				}

				if ( style === 'slider' ) {
					SCAPE.portfolioGridSlider.fixed($container);
				}

				$container.on( 'select.flickity', function( event, index ) {
					var $meta = $container.siblings('.portfolio-'+style+'-content').find('.portfolio-'+style+'-meta');
					$meta.removeClass('active');
					$meta.eq(index).addClass('active');

					progress($container);

					if ( style === 'slider' && SCAPE.viewport().width > SCAPE.breakpoints.mobile ) {
						bgImage($container);
					}

				});

				$(window).on('resize', function() {
					SCAPE.waitForFinalEvent(function () {
						var flkty = $container.data('flickity');

						if ( SCAPE.viewport().width > SCAPE.breakpoints.mobile || style === 'panels' ) {
							flkty.options.draggable = false;
						} else {
							flkty.options.draggable = true;
						}
						flkty.updateDraggable();
					}, SCAPE.timeToWaitForLast, 'portfolio_slider');
				});

				// Button Navigation
				$container.parent().find('.portfolio-'+style+'-button.prev').on('click', function () {
					$container.flickity('previous');
					$container.trigger('focus');
				});
				$container.parent().find('.portfolio-'+style+'-button.next').on('click', function () {
					$container.flickity('next');
					$container.trigger('focus');
				});

				$(document).on('click', '.portfolio-'+style+'-inner', function(e) {
					if ( !$(this).closest('.portfolio-entry').hasClass('is-selected') ) {
						SCAPE.stopEvent(e);
						var index = $(this).closest('.portfolio-entry').index();
						$container.flickity( 'select', index );
					}
				});

				$(document).on('keydown', function(e) {
					if ( $container.is(':focus') ) {
						if ( e.keyCode === 37 ) {
							$container.flickity('previous');
						}
						if ( e.keyCode === 39 ) {
							$container.flickity('next');
						}
					}
				});

				$container.on( 'scroll.flickity', function(event, progress) {
					if ( style === 'slider' ) {
						SCAPE.portfolioGridSlider.fixed($container);
					}
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

				$slider.find('.portfolio-entry').eq(i).css('z-index', zindex);
				$slider.find('.portfolio-entry').eq(i).children('.portfolio-slider-wrapper').css({
					transform: 'translateX('+translate+'px) scale('+scale+') translateZ(0)',
					'opacity': opacity,
				}).toggleClass('slide-animated', slideOffset < 0);

			});
		}
	};

	jQuery(document).ready(function($) {
		SCAPE.portfolioGridSlider.init($('.wtbx-grid-panels, .wtbx-grid-slider'));
	});

})(jQuery);