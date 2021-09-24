(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.sideareaScroll = function() {
		if ( $('.header-sidearea').length ) {
			if ( $('body').hasClass('device-desktop') ) {

				$('.header-sidearea').on('mousewheel', function(e) {
					var scrollCont = $(this).find('.header-container-side'),
						wrapper = $('.header-wrapper-side'),
						maxScroll = scrollCont.outerHeight() - wrapper.outerHeight(),
						scrolled	= e.deltaY * e.deltaFactor;

					if (maxScroll > 0) {
						scrolled = getMenuScroll($(this), maxScroll, scrolled, e);
					} else {
						scrolled = 0;
					}
					scrollCont.css({
						'-webkit-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'-moz-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'-ms-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'-o-transform': 'translate3d(0,' + scrolled + 'px,0)',
						'transform': 'translate3d(0,' + scrolled + 'px,0)'
					});
					scrollCont.find('li.sub-menu-full-width > div').css({
						'-webkit-transform': 'translate3d(0,' + -scrolled + 'px,0)',
						'-moz-transform': 'translate3d(0,' + -scrolled + 'px,0)',
						'-ms-transform': 'translate3d(0,' + -scrolled + 'px,0)',
						'-o-transform': 'translate3d(0,' + -scrolled + 'px,0)',
						'transform': 'translate3d(0,' + -scrolled + 'px,0)'
					});
				});
			} else if ( $('body').hasClass('device-mobile') ) {

				$(document).on('touchstart', function(e) {
					if ( $(e.target).is('#header-container, #header-container *')  ) {
						SCAPE.stopEvent(e);
					}
				});

				var scrollDiv	= document.getElementById('header-container'),
					scrollCont	= $('.header-container-side'),
					wrapper		= $('.header-wrapper-side'),
					maxScroll	= scrollCont.outerHeight() - wrapper.outerHeight(),
					scrolled	= 0,
					offset;

				var hammer = new Hammer(scrollDiv,
					{
						drag: true,
						velocityY: 1,
						preventDefault: true
					});
				hammer.get('pan').set({ direction: Hammer.DIRECTION_ALL });

				hammer.on('panstart', function(e) {
					offset = getMenuScroll($('.header-sidearea'), maxScroll, 0, e);
				});

				hammer.on('pan', function(e) {
					scrolled = e.deltaY + offset;
					scrolled = Math.min(scrolled,0);
					scrolled = Math.max(-maxScroll,scrolled);

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
		SCAPE.sideareaScroll();
	});

})(jQuery);