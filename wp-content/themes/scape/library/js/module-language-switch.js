(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.languageSwitch = {

		init: function() {

			SCAPE.viewport = function() {
				var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
				return { width:x,height:y }
			};

			SCAPE.languageSwitch.layout();
			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.languageSwitch.layout();
				}, SCAPE.timeToWaitForLast, 'languageDropdown');
			});

			var $trigger = $('.header_language_trigger');
			$trigger.on('click', function() {
				var $wrapper	= $(this).closest('.header_language_wrapper'),
					$dropdown	= $wrapper.find('.header_language_dropdown');

				if ( !$wrapper.hasClass('active') ) {
					var offset = $wrapper.offset().top,
						height = $wrapper.outerHeight(true) + $dropdown.outerHeight(true);

					$dropdown.removeClass('dropdown_top');
					$dropdown.removeClass('dropdown_opposite');

					if ( offset + height > SCAPE.scrollTop.get + SCAPE.viewport().height ) {
						$dropdown.addClass('dropdown_top');
					} else {
						$dropdown.removeClass('dropdown_top');
					}
					if ( $dropdown.offset().left < 0 ) {
						$dropdown.addClass('dropdown_opposite');
					} else {
						$dropdown.removeClass('dropdown_opposite');
					}

					$wrapper.addClass('active');
					$(document).on('click.lang_dropdown', function(e) {
						if ( !$wrapper.is(e.target) && !$wrapper.find(e.target).length ) {
							$wrapper.removeClass('active');
						}
					});
				} else {
					$wrapper.removeClass('active');
					$(document).off('click.lang_dropdown');
				}
			});
		},

		layout: function() {
			var $trigger = $('.header_language_trigger');

			$trigger.each(function () {
				var $dropdown = $(this).next('.header_language_dropdown');

				if ($trigger.offset().left + $trigger.width() - $dropdown.width() < 0) {
					$dropdown.addClass('dropdown_opposite');
				} else {
					$dropdown.removeClass('dropdown_opposite');
				}
			});
		}

	};

	jQuery(document).ready(function($) {
		SCAPE.languageSwitch.init();
	});

})(jQuery);