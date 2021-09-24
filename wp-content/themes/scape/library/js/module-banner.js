
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();


	SCAPE.bannerMousemove = {

		init: function() {
			SCAPE.bannerMousemove.layout();
			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					$('.wtbx_vc_banner.wtbx_image_mousemove .wtbx_banner_bg').each(function() {
						var transition	= SCAPE.propertyPrefix('transition');
						$(this).css(transition, 'all 0s');
						SCAPE.transform($(this)[0], 'translate3d(-50%,-50%,0)');
						var $this = $(this);
						setTimeout(function() {
							$this.css(transition, '');
						})
					})
				}, SCAPE.timeToWaitForLast, 'banner');
			});
		},

		layout: function($el) {

			if ( undefined === $el ) {
				$el = $('.wtbx_vc_banner.wtbx_image_mousemove');
			}

			$el.each(function() {

				function normalCDF(x) {
					var T		= 1 / ( 1 + .2316419 * Math.abs(x) );
					var D		= .3989423 * Math.exp( -x * x / 2 );
					var prob	= D * T * ( .3193815 + T * ( -.3565638 + T * ( 1.781478 + T * ( - 1.821256 + T * 1.330274 ))));
					if ( x > 0 ) {
						prob = 1 - prob
					}
					return prob
				}

				function compute(x, m, sd) {
					var prob = 1;

					if ( sd == 0 ) {
						if ( x < m ){
							prob = 0
						} else {
							prob = 1
						}
					} else {
						prob = normalCDF( (x - m) / sd );
						prob = Math.round(100000 * prob) / 100000;
					}

					return prob;
				}

				var $container	= $(this).find('.wtbx_banner_wrapper'),
					$this		= $(this).find('.wtbx_banner_bg'),
					parStrength = 0.1,
					newSize		= Math.round(($container.outerHeight() * (1 + parStrength) ) / $container.outerHeight() * 100);

				$container.unbind().on('mousemove', function(e) {

					requestAnimationFrame(function() {
						var cont_height		= $container.outerHeight(),
							cont_width		= $container.outerWidth(),
							cont_center_v	= $container.offset().top + cont_height / 2,
							cont_center_h	= $container.offset().left + cont_width / 2,
							shift_top_max	= cont_height * parStrength,
							shift_left_max	= cont_width * parStrength,
							delta_top		= (e.pageY - cont_center_v),
							delta_left		= (e.pageX - cont_center_h),
							norm_top		= compute( delta_top, 0, cont_height / 4),
							norm_left		= compute( delta_left, 0, cont_width / 4),
							delta_top_norm	= shift_top_max / 2 * norm_top,
							delta_left_norm	= shift_left_max / 2 * norm_left,
							shift_top		= - delta_top_norm - cont_height * (1 + parStrength) / 2 + shift_top_max / 4,
							shift_left		= - delta_left_norm - cont_width * (1 + parStrength) / 2 + shift_left_max / 4;

						SCAPE.transform($this[0], 'translate3d('+shift_left+'px,'+shift_top+'px,0)');
					});

				});

				$this.css({
					'height': newSize + '%',
					'width': newSize + '%'
				});

				$this.addClass('wtbx_parallax_init');
			});
		}

	};

	jQuery(document).ready(function($) {
		SCAPE.bannerMousemove.init();
	});

})(jQuery);