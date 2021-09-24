(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.sideHeader = {

		init: function() {
			SCAPE.sideHeader.layout();
			SCAPE.sideHeader.scroll();
			SCAPE.sideHeader.maxScroll = $('.header-style-12, .header-style-13, .header-style-14').find('#header-container').outerHeight() - $('.header-style-12, .header-style-13, .header-style-14').outerHeight();

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.sideHeader.layout();
					SCAPE.sideHeader.maxScroll = $('.header-style-12, .header-style-13, .header-style-14').find('#header-container').outerHeight() - $('.header-style-12, .header-style-13, .header-style-14').outerHeight();

					if ( SCAPE.sideHeader.maxScroll === 0 ) {
						$('.header-style-12, .header-style-13, .header-style-14').find('#header-container').attr('style', '');
					}

				}, SCAPE.timeToWaitForLast, 'sideHeader');
			});
		},

		layout: function() {
			var $header = $('.header-style-12, .header-style-13, .header-style-14'),
				headerH	= $header.outerHeight(true),
				totalH	= 0;

			if ( $header.length ) {
				$header.find('.wtbx_hs').each(function() {
					totalH += $(this).outerHeight(true);
				});

				if ( totalH > headerH ) {
					$header.addClass('header_stack');
				} else {
					$header.removeClass('header_stack');
				}
			}
		},

		scrolledTotal: 0,

		maxScroll: 0,

		scroll: function() {
			var $header = $('.header-style-12, .header-style-13, .header-style-14'),
				scrollCont = $header.find('#header-container'),
				wrapper = $header;

			if ( $('body').hasClass('device-desktop') ) {

				$header.on('mousewheel', function(e) {
					SCAPE.sideHeader.maxScroll = $('.header-style-12, .header-style-13, .header-style-14').find('#header-container').outerHeight() - $('.header-style-12, .header-style-13, .header-style-14').outerHeight();
					var scrolled = e.deltaY * e.deltaFactor,
						maxScroll = SCAPE.sideHeader.maxScroll,
						scrolledTotal = SCAPE.sideHeader.scrolledTotal;

					SCAPE.stopEvent(e);

					if (maxScroll > 0) {
						scrolled = scrolledTotal + scrolled;
						SCAPE.sideHeader.scrolledTotal = scrolled;
					} else {
						scrolled = 0;
					}

					if ( scrolled > 0 ) {
						scrolled = 0;
						SCAPE.sideHeader.scrolledTotal = 0;
					} else if ( -scrolled > maxScroll  ) {
						scrolled = -maxScroll;
						SCAPE.sideHeader.scrolledTotal = -maxScroll;
					}

					scrollCont.css({
						'-webkit-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'-moz-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'-ms-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'-o-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'transform': 'translate3d(0,' + scrolled + 'px,0)'
					});
				});
			} else if ( $('body').hasClass('device-mobile') ) {

				$(document).on('touchstart', function(e) {
					if ( $header.is(e.target) || $header.find(e.target).length ) {
						SCAPE.stopEvent(e);
					}
				});

				var scrollDiv	= document.getElementById('header-container'),
					scrolled	= 0,
					maxScroll,
					scrolledTotal;

				var hammer = new Hammer(scrollDiv, {
					drag: true,
					velocityY: 1,
					preventDefault: true
				});
				hammer.get('pan').set({ direction: Hammer.DIRECTION_VERTICAL });

				hammer.on('panstart', function(e) {
					SCAPE.sideHeader.maxScroll = $('.header-style-12, .header-style-13, .header-style-14').find('#header-container').outerHeight() - $('.header-style-12, .header-style-13, .header-style-14').outerHeight();
					maxScroll = SCAPE.sideHeader.maxScroll;
					scrolledTotal = SCAPE.sideHeader.scrolledTotal;
				});

				hammer.on('pan', function(e) {
					scrolled = e.deltaY + scrolledTotal;
					scrolled = Math.min(scrolled,0);
					scrolled = Math.max(-maxScroll,scrolled);
					SCAPE.sideHeader.scrolledTotal = scrolled;

					scrollCont.css({
						'-webkit-transform'	: 'translate3d(0,'+ scrolled +'px,0)',
						'-moz-transform'	: 'translate3d(0,'+ scrolled +'px,0)',
						'-ms-transform'		: 'translate3d(0,'+ scrolled +'px,0)',
						'-o-transform'		: 'translate3d(0,'+ scrolled +'px,0)',
						'transform'			: 'translate3d(0,'+ scrolled +'px,0)'
					});
				});
			}
		}

	};


	jQuery(document).ready(function($) {
		SCAPE.sideHeader.init();
	});

})(jQuery);