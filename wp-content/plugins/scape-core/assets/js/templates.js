(function() {
	"use strict";
	var $ = jQuery.noConflict();

	$.fn.isInViewport = function() {
		var elementTop = $(this).offset().top;
		var container = $(this).closest('.vc_ui-template-list');
		var elementBottom = elementTop + $(this).outerHeight();
		var viewportTop = container.scrollTop();
		var viewportBottom = viewportTop + container.height();
		return elementTop < viewportBottom;
	};

	$(document).ready(function() {
		var $container = $('.wtbx-templates-container');
		var $categories = $('.wtbx-sorting-container');

		$categories.find('li').each(function(index) {
			if ( index === 0 ) {
				$(this).find('.count').text($container.find('.vc_ui-template').length);
			} else {
				var cat = $(this).data('filter');
				$(this).find('.count').text($container.find('.' + cat).length);
			}
		});

		$(document).on('click', '.wtbx-sorting-container li', function() {
			if ( !$(this).hasClass('active') ) {
				$categories.find('li').removeClass('active');
				$(this).addClass('active');

				var cat = $(this).data('filter');
				$container.find('.vc_ui-template').addClass('hidden');
				$container.find('.' + cat).removeClass('hidden');

				setTimeout(function() {
					$container.find('.' + cat).find('img').each(function() {
						if ( $(this).isInViewport() && $(this).is(':visible') && !$(this).hasClass('loaded') ) {
							$(this).attr('src', $(this).data('src')).addClass('loaded');
						}
					});
				});

			}
		});

		$container.find('.vc_ui-template-list img').each(function(index) {
			if ( index < 18 ) {
				$(this).attr('src', $(this).data('src')).on('load', function() {
					$(this).addClass('loaded');
				});
			}
		});

		$container.find('.vc_ui-template-list').on('resize scroll', function() {
			$(this).find('img').each(function() {
				if ( $(this).isInViewport() && $(this).is(':visible') && !$(this).hasClass('loaded') ) {
					$(this).attr('src', $(this).data('src')).addClass('loaded');
				}
			});
		});

	});

})(jQuery);