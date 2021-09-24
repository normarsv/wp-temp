
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.steps = {

		init: function() {
			SCAPE.steps.spaceBelow();
			SCAPE.steps.tabbedStyle();
			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.steps.spaceBelow();
				}, SCAPE.timeToWaitForLast, 'steps');
			});
		},

		spaceBelow: function() {

			$('.wtbx_vc_steps_horizontal.wtbx_style_2').each(function() {
				var $cont	= $(this).find('.wtbx_steps_nav'),
					$inner	= $(this).find('.wtbx_step_inner'),
					height, maxHeight = 0;

				if ( SCAPE.viewport().width > 767 ) {
					$inner.each(function() {
						height = parseInt($(this).outerHeight(true)) + 15;
						if ( height > maxHeight ) {
							maxHeight = height;
						}
					});

					$cont.css('padding-bottom', maxHeight + 'px');
				} else {
					$cont.css('padding-bottom', '0');
				}
			});

			$('.wtbx_vc_steps_horizontal.wtbx_style_3').each(function() {
				var $cont	= $(this).find('.wtbx_step_wrapper'),
					$inner	= $(this).find('.wtbx_step_inner'),
					height, maxHeight = 0;

				if ( SCAPE.viewport().width > 767 ) {
					$inner.each(function() {
						height = parseInt($(this).outerHeight(true)) + 15;
						if ( height > maxHeight ) {
							maxHeight = height;
						}
					});

					$cont.css('height', maxHeight + 'px');
					$cont.closest('.wtbx_vc_el_inner').css('padding-bottom', maxHeight + 'px');
				} else {
					$cont.css('height', '0');
					$cont.closest('.wtbx_vc_el_inner').css('padding-bottom', '0');
				}
			});

		},

		tabbedStyle: function() {

			$('.wtbx_vc_steps_horizontal.wtbx_style_3').each(function() {
				var $wrap = $(this),
					menu = $(this).find('.wtbx_step_bullet, .wtbx_steps_header'),
					cont = $(this).find('.wtbx_step_content');

				$(this).find('.wtbx_steps_nav_item').eq(0).addClass('active');
				cont.eq(0).addClass('active');

				menu.on('click', function() {
					var $item = $(this).closest('.wtbx_steps_nav_item');

					var i = $(this).closest('.wtbx_steps_nav_item').index();
					$wrap.find('.wtbx_steps_nav_item').removeClass('active');
					cont.removeClass('active');
					//$item.addClass('active');
					$wrap.find('.wtbx_steps_nav_item').filter(function(index) {
						return index <= i;
					}).addClass('active');
					cont.eq(i).addClass('active');

				});
			});
		}
	};


	jQuery(document).ready(function($) {
		SCAPE.steps.init();
	});


})(jQuery);