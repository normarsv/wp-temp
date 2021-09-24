(function() {
	"use strict";

	var $ = jQuery.noConflict();


	function debounce(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	}

	function fixedRows() {
		// $('.wtbx_force_align_bottom').each(function() {
		// 	var $el = $(this).children('.wtbx_vc_inner_row_container'),
		// 		$cont = $(this).closest('.wtbx_vc_row, .wtbx_vc_section');
		//
		// 	$el.css({
		// 		'position': 'absolute',
		// 		'top': $cont.offset().top + $cont.height() - $el.height()
		// 	});
		//
		// });
	}

	$(document).on('ready', function() {
		$('body').removeClass('wtbx-page-init');
		$('#wtbx-site-preloader').hide();
		SCAPE.waypoints();
		SCAPE.gridReveal($('.wtbx-grid, .wtbx-grid-products').find('.wtbx-element-reveal:not(.wtbx-element-visible)'));
		SCAPE.revealNoLazy();

		setTimeout(function() {
			SCAPE.forms();
		});

		setInterval(function() {
			SCAPE.equalHeightEl.calculate();
		},2000);

		$('#content').bind('DOMNodeInserted', function(e) {
			if ( $(e.target).find('.wtbx_appearance_animation').length ) {
				setTimeout(function() {
					$(e.target).find('.wtbx_appearance_animation').addClass('wtbx_to_be_animated wtbx_animated');
				}, 500);
			}
		});

		$('#content').bind('DOMNodeInserted', function(e) {
			SCAPE.revealNoLazy();
		});

		// fixedRows();
		// $(window).on('resize', function() {
		// 	fixedRows();
		// });

		$(document).bind('DOMNodeInserted', '.vc_element-container, .wtbx_row_content_inner', function(e) {
			if ( $(e.target).hasClass('vc_element') ) {
				// setTimeout(function() {
					debounce(function() {
						$(window).trigger('resize');
					}, 900);
				// },100);

				// if ( $(e.target).find('.wtbx-grid-products').length ) {
				// 	SCAPE.woocommerce.productGrid.layout($(e.target).find('.wtbx-grid-products'));
				// }

				if ( $(e.target).find('.flickity-enabled').length ) {
					setTimeout(function() {
						$(e.target).find('.flickity-enabled').flickity('resize');
					}, 1000);
				}

				if ( $(e.target).closest('.wtbx_vc_modal').length ) {
					var modal		= $(e.target).closest('.wtbx_vc_modal'),
						id			= modal.find('.wtbx_modal_wrapper').attr('id');
					var model_id	= modal.closest('.vc_vc_modal').data('model-id');
					var $newModal;

					setTimeout(function() {
						$('body > .wtbx_vc_modal').each(function() {
							if ( $(this).data('model') && model_id === $(this).data('model') ) {
								$(this).remove();
							}
						});
						$newModal = modal.clone();
						$newModal.attr('data-model', model_id).find('.vc_controls').remove();
						$newModal.appendTo('body');
					}, 1000);
				}

				if ( $(e.target).find('.wpcf7-form').length ) {
					if (! $(e.target).find('.wpcf7-form').find('.wtbx_field_init').length ) {
						SCAPE.forms();
					}
				}

				if ( $(e.target).find('.wtbx-grid-products').length ) {
					setTimeout(function() {
						SCAPE.woocommerce.productCarousel($(e.target).find('.wtbx-grid-products'));
					}, 1000);
				}
			}
		});

		$('#header-wrapper').on('mouseenter', function() {
			var height = $(this).outerHeight(true);
			$(window).on('mousemove.headerHide', function(e) {
				if ( e.pageY < height ) {
					$('#site-header').addClass('header-hidden');
				} else {
					$('#site-header').removeClass('header-hidden');
					$(window).off('mousemove.headerHide');
				}
			});
		});

		$('#header-wrapper-mobile').on('mouseenter', function() {
			var height = $(this).outerHeight(true);
			$(window).on('mousemove.headerHideM', function(e) {
				if ( e.pageY < height ) {
					$('#site-header').addClass('header-hidden');
				} else {
					$('#site-header').removeClass('header-hidden');
					$(window).off('mousemove.headerHideM');
				}
			});
		});

	});

})(jQuery);