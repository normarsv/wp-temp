(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.pageHeader = {

		init: function() {
			SCAPE.pageHeader.layout();
			SCAPE.pageHeader.fullScroll();
			SCAPE.pageHeader.scrollEffect();

			$(window).on('resize', function(){
				SCAPE.waitForFinalEvent( function() {
					SCAPE.pageHeader.layout();
				}, 500, 'page_header');
			});
		},

		layout: function() {
		},

		scrollEffect: function() {

			if ( $('#page-header').hasClass('has-scroll-effect') && !SCAPE.isMobile() ) {

				var $page_header	= $('#page-header'),
					$page_header_i	= $page_header.find('.page-header-inner'),
					$bg_cont		= $page_header.find('.page-header-image'),
					$bg_wrapper		= $page_header.find('.page-header-image-wrapper'),
					$bg				= $page_header.find('.wtbx-bg-image'),
					$bg_shadow		= $page_header.find('.page-header-shadow'),
					$bg_overlay		= $page_header.find('.page-header-overlay'),
					$page			= $('#page-wrap'),
					header_height	= $page_header.outerHeight(),
					bg_cont_height	= $bg_cont.height(),
					bg_height		= $bg.height(),
					bg_width		= $bg.width(),
					height_diff		= (bg_height - bg_cont_height) / 2,
					multiplier		= .4,
					to_center_top	= bg_height / 2,
					to_center_left	= bg_width / 2,
					scale			= 1,
					ratio			= 1.5,
					$background;

				if ( $page_header.hasClass('scroll-cont_zoom_in') && $page_header.has('.page-header-bg-wrapper') ) {
					$background = $page_header.find('.page-header-bg-wrapper');
					var background_h = SCAPE.viewport().height + Math.ceil(header_height / 1.5);
					$background.css('height', background_h + 'px');
				}

				var onScroll = function() {

					var scrollTop		= window.pageYOffset,
						scrolled_part	= scrollTop / header_height;

					if ( $page_header.hasClass('scroll-hs_3d_slide') ) {

						scale = (1 - scrolled_part) * multiplier + 1;
						var bg_scale = (1 - scrolled_part) * multiplier * .8 +  1 - multiplier * .8;

						if ( scrollTop > header_height ) {
							$bg_wrapper.css('transform', '');
							$bg_shadow.css('transform', '');
							$page_header_i.css('transform', '');
						} else {
							SCAPE.transform($('.page-header-bg-wrapper')[0], 'scale3d('+Math.sqrt(bg_scale)+','+Math.sqrt(bg_scale)+',1)');
							SCAPE.transform($page_header_i[0], 'scale3d('+scale/(1+multiplier)+','+scale/(1+multiplier)+',1)');
						}

					} else if ( $page_header.hasClass('scroll-cont_zoom_in') ) {

						scale = (scrolled_part * ratio) * multiplier * multiplier + 1 - multiplier * multiplier;
						scale = Math.sqrt(Math.min(scale,1));

						var transform = SCAPE.propertyPrefix('transform');

						if ( scale === 1 ) {
							$page.css('will-change', '');
							$page.css('transform', '');
							$page.css(transform, '');
							$page.addClass('scrolled-into-view');
						} else {
							$page.css('will-change', transform);
							$page.css(transform, 'scale3d('+scale+','+scale+',1)');
							$page.removeClass('scrolled-into-view');
						}
					}
				};

				var raf = SCAPE.raf();

				$(window).scroll(function() {
					raf(onScroll);
				});

			}
		},

		fullScroll: function() {

			var $page_header	= $('#page-header');
			if ( $page_header.length ) {
				var header_offset	= $page_header.offset().top,
					header_height	= $page_header.height();

				var slideOnScroll = function(e) {
					e				= window.event || e;
					var delta		= Math.max(-1, Math.min(1, (e.wheelDelta || -e.deltaY || -e.detail)));
					var scrollTop	= SCAPE.scrollTop.get;
					var $body		= $('body');
					var $page		= $('#page-wrap'),
						offset		= $page.offset().top - SCAPE.headerOffset($page);

					if ( delta < 0 && scrollTop < header_offset + offset - 100 ) {
						// SCAPE.stopEvent(e);
						if ( !$body.hasClass('scrolling') ) {
							$body.addClass('scrolling');
							$('html, body').animate({scrollTop: offset}, 800, function() {
								$body.removeClass('scrolling');
							});
						}
					} else if ( delta > 0 && scrollTop < header_offset + offset ) {
						// SCAPE.stopEvent(e);
						if ( !$body.hasClass('scrolling') ) {
							$body.addClass('scrolling');
							$('html, body').animate({scrollTop: 0}, 600, function() {
								$body.removeClass('scrolling');
							});
						}
					}
					return false;
				};

				if ( $page_header.data('fullscroll') === 1 ) {
					SCAPE.mouseWheelHandler.add(window, slideOnScroll);
				}
			}

		}

	};

	jQuery(document).ready(function($) {
		SCAPE.pageHeader.init();
	});

})(jQuery);