(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.parallaxBackground = {

		init: function() {
			SCAPE.parallaxBackground.scroll();
			SCAPE.parallaxBackground.scale();
			SCAPE.parallaxBackground.mousemove();
			SCAPE.parallaxBackground.segments();

			$(window).on('resize', function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.parallaxBackground.segments();
					SCAPE.parallaxBackground.scroll();
					SCAPE.parallaxBackground.scale();
					SCAPE.parallaxBackground.mousemove(true);
				}, SCAPE.timeToWaitForLast, 'parallax');
			});
		},

		segments: function() {
			$('.wtbx_row_bg_anim, .wtbx_section_bg_anim').each(function() {
				var disable = parseInt($(this).data('disable')) || 0;

				if ( disable === 0 || disable < SCAPE.viewport().width ) {
					$(this).removeClass('hidden');
					$(this).find('.wtbx_anim_segment_shadow').each(function() {
						var top		= parseFloat($(this).css('top')),
							width	= parseFloat($(this).css('width')),
							height	= parseFloat($(this).css('height')),
							left	= parseFloat($(this).css('left')),
							right	= left + width,
							bottom	= top + height;

						$(this).closest('.wtbx_anim_segment').find('.wtbx_anim_image').css('clip', 'rect('+top+'px,'+right+'px,'+bottom+'px,'+left+'px)');
					});
				} else {
					$(this).addClass('hidden');
				}
			});
		},

		scroll: function() {
			var scrollTop		= SCAPE.scrollTop.get,
				windowHeight	= SCAPE.viewport().height;

			var transform = SCAPE.propertyPrefix('transform');

			$('.wtbx_parallax_container').each(function() {
				if ($(this).has('.wtbx_parallax_scroll')) {
					var $container = $(this),
						buffer = 1.05,
						offset = $container.offset().top,
						height = $container.outerHeight();

					// Check if above or below viewport
					if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
						return;
					}

					$container.find('.wtbx_parallax_scroll').each(function(){
						var $this = $(this),
							strength = parseFloat($this.attr('data-parallax-strength')),
							parStrength = strength / 15;

						if ( 'undefined' === typeof strength || strength === 0 ) {
							$this.css(transform, 'translate3d(-50%,0,0)');
							$this.css({'height': '100%', 'width': '100%' });
						} else {
							var position = - (offset - scrollTop) * parStrength;
							$this.css(transform, 'translate3d(-50%,'+position+'px,0)');

							if ( !$this.hasClass('wtbx_parallax_init') && !$this.hasClass('wtbx_anim_segment_container') ) {
								var newSize = Math.ceil((height * (1 + parStrength)) / height * 100 * buffer);
								$this.css({'height': newSize + '%', 'width': newSize + '%' });
							}
						}

						$this.addClass('wtbx_parallax_init');
					});
				}
			});
		},

		scale: function() {
			var scrollTop		= SCAPE.scrollTop.get,
				windowHeight	= SCAPE.viewport().height;

			$('.wtbx_parallax_container').each(function() {
				if ( $(this).has('.wtbx_parallax_scale') ) {
					var $container	= $(this),
						offset			= $container.offset().top,
						height			= $container.height();

					// Check if above or below viewport
					if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
						return;
					}

					$(this).find('.wtbx_parallax_scale').each(function() {
						var $this			= $(this),
							scaleStrength	= parseFloat(($this.attr('data-scale-strength'))) / 6;

						var maxScale	= windowHeight + height,
							step		= scaleStrength / maxScale,
							scale;

						if ( scaleStrength >= 0 ) {
							scale = 1 + (scrollTop + windowHeight - offset) * step;
						} else {
							scale = 1 - (-scrollTop + height + offset) * step;
						}

						$this.css({'transform':'translate3d(-50%,-50%,0) scale3d('+scale+','+scale+',1)'});
						$this.addClass('wtbx_parallax_init');
					});
				}
			});
		},

		mousemove: function(resize) {

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

			if ( resize ) {
				$('.wtbx_parallax_mousemove').each(function() {
					var $this			= $(this),
						$container		= $this.closest('.wtbx_parallax_container'),
						cont_height		= $container.height(),
						cont_width		= $container.width(),
						parStrength 	= parseInt($this.attr('data-parallax-strength')) / 10 / 4,
						top				= - cont_height * (1 + parStrength) / 2,
						left			= - cont_width * (1 + parStrength) / 2;

					$this.addClass('parallax-resizing');
					SCAPE.transform($this[0], 'translate3d('+left+'px,'+top+'px,0)');

					setTimeout(function() {
						$this.removeClass('parallax-resizing');
					});
				});
			} else {
				$('.wtbx_parallax_wrapper').each(function() {

					$(this).on('mousemove', function(e) {
						$(this).find('.wtbx_parallax_mousemove').each(function(index) {
							var $this		= $(this),
								$container	= $(this).closest('.wtbx_parallax_container'),
								parStrength	= parseFloat($this.attr('data-parallax-strength')) / 10 / 4;

							if ( $(e.target).is('#page-header path') || $(e.target).is('#page-header div.left') || $(e.target).is('#page-header div.right') ) {
								return false;
							}

							var cont_height		= $container.height(),
								cont_width		= $container.width(),
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

							SCAPE.transform($this[0], 'translate3d('+shift_left+'px,'+shift_top+'px,0)')
						});
					});

					$(this).find('.wtbx_parallax_mousemove').each(function(index) {
						var $this = $(this),
							$container = $(this).closest('.wtbx_parallax_container'),
							parStrength = parseInt($this.attr('data-parallax-strength')) / 10 / 4,
							newSize = Math.round(($container.height() * (1 + parStrength) ) / $container.height() * 100);

						if ( !$this.hasClass('wtbx_parallax_init') ) {
							$this.css({
								'height': newSize + '%',
								'width': newSize + '%'
							});
						}

						$this.addClass('wtbx_parallax_init');
					});

				});

			}
		}

	};

	jQuery(document).ready(function($) {
		SCAPE.parallaxBackground.init();
	});

})(jQuery);