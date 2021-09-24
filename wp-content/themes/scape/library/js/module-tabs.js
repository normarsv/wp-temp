(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();


	SCAPE.tabs = {

		init: function() {
			SCAPE.tabs.tabsNav();
			SCAPE.tabs.mobileTabsNav();
			SCAPE.tabs.initTabs();
			SCAPE.tabs.accordionNav();
		},

		navigateToTabOnInit: function() {
			var hash = window.location.hash.substr(1),
				offset;
			if ( hash !== '' ) {
				if ( $('.wtbx_vc_tab[id="'+hash+'"]').length ) {
					offset = $('.wtbx_vc_tab[id="'+hash+'"]').closest('.wtbx_vc_tabs').offset().top - SCAPE.headerOffset($('.wtbx_vc_tab[id="'+hash+'"]').closest('.wtbx_vc_tabs'));
					$('.wtbx_tabs_nav_link[href="#'+hash+'"]').trigger('click');
					setTimeout(function() {
						$('html, body').animate({scrollTop:offset}, 500);
					});
				} else if (  $('.wtbx_vc_accordion_tab[data-tab="'+hash+'"]').length ) {
					$('.wtbx_vc_accordion_tab[data-tab="'+hash+'"]').closest('.wtbx_vc_accordion').find('.wtbx_vc_accordion_tab').removeClass('active').children('.wtbx_accordion_tab_inner').hide();

					setTimeout(function() {
						offset = $('.wtbx_vc_accordion_tab[data-tab="'+hash+'"]').offset().top - SCAPE.headerOffset($('.wtbx_vc_accordion_tab[data-tab="'+hash+'"]'));
						$('html, body').animate({scrollTop:offset}, 500);
						$('.wtbx_vc_accordion_tab[data-tab="'+hash+'"]').addClass('active').children('.wtbx_accordion_tab_inner').slideDown(500);
					},100);
				}
			}
		},

		initTabs: function() {
			$('.wtbx_ui_tabs:not(.tabs-init)').each(function() {
				var $tabs		= $(this),
					$tab		= $tabs.find('.wtbx_vc_tab'),
					active		= $tabs.data('active-tab') || 1;

				$tabs.find('.wtbx_tabs_nav_item').eq(active-1).addClass('active');
				$tabs.find('.wtbx_vc_tab').eq(active-1).addClass('active');

				var	index = $tabs.find('.wtbx_vc_tab.active').eq(0).index();

				$tab.each(function() {
					if ( $(this).index() < index ) {
						$(this).removeClass('active').addClass('prev');
					} else if ( $(this).index() > index ) {
						$(this).removeClass('active').addClass('next');
					}
				});

				setTimeout(function() {
					SCAPE.tabs.knob();
					setTimeout(function() {
						$tabs.addClass('tabs-init');
					},100) ;
				});

			});

			$('.wtbx_vc_accordion').each(function() {
				var $tabs		= $(this),
					active		= $tabs.data('active-tab') || 1;
				$tabs.find('.wtbx_vc_accordion_tab').eq(active-1).addClass('active').children('.wtbx_accordion_tab_inner').show();
			});

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					setTimeout(function() {
						SCAPE.tabs.knob();
					});
				}, SCAPE.timeToWaitForLast, 'tabs_knob');
			});
		},

		knob: function() {
			$('.wtbx_ui_tabs').each(function() {
				var $cont = $(this);

				if ( $cont.hasClass('wtbx_style_3') ) {
					var $knob		= $cont.find('.wtbx_tabs_knob'),
						$button		= $cont.find('.wtbx_tabs_nav_item.active').eq(0);

					if ( $button.length ) {
						var	newLeft		= Math.floor($button.position().left),
							newTop		= Math.floor($button.position().top),
							newIndex	= $button.index(),
							newWidth	= Math.floor($cont.find('.wtbx_tabs_nav_item').eq(newIndex-1).outerWidth()),
							newHeight	= Math.floor($cont.find('.wtbx_tabs_nav_item').eq(newIndex-1).outerHeight());

						var transform = SCAPE.propertyPrefix('transform');
						$knob.css({
							'width':			newWidth,
							'height':			newHeight,
							'border-radius':	newHeight
						});
						$knob.css(transform, 'translate3d('+newLeft+'px,'+newTop+'px,0)');
					}
				}
			});
		},

		tabsNav: function() {

			$('.wtbx_ui_tabs:not(.tabs-init)').each(function() {
				var $tabs = $(this),
					wrapper = $tabs.data('wrapper');

				$tabs.find('.wtbx_tab_nav_mobile').each(function() {
					$(this)
						.clone()
						.attr('class', 'wtbx_tabs_nav_item')
						.children().attr('class', 'wtbx_tabs_nav_link')
						.parent().appendTo($tabs.find('.wtbx_tabs_nav'));
				});

				$tabs.find('.wtbx_tabs_nav_item').each(function() {
					$(this).find('.wtbx_tabs_nav_title').replaceWith('<'+wrapper+' class="wtbx_tabs_nav_title">' + $(this).find('.wtbx_tabs_nav_title').html() +'</'+wrapper+'>');
					$(this).replaceWith('<li class="wtbx_tabs_nav_item">' + $(this).html() +'</li>');
				});

				if ( $tabs.hasClass('wtbx_style_4') && $tabs.hasClass('wtbx_tabs_equal') ) {
					$tabs.find('.wtbx_tabs_nav_item').css({
						'width': 100 / $tabs.find('.wtbx_tabs_nav_item').length + '%'
					});
				}

				var	$nav_item	= $tabs.find('.wtbx_tabs_nav_item'),
					$nav_link	= $nav_item.find('.wtbx_tabs_nav_link'),
					$tab		= $tabs.find('.wtbx_vc_tab');

				SCAPE.customCursor.bindClick($nav_link);

				$nav_link.on('click', function(e) {
					SCAPE.stopEvent(e);
					if ( !$(this).parent('li').hasClass('active') ) {
						var tabId		= $(this).attr('href').substr(1),
							newIndex	= $(this).parent('li').index();

						if ( $(this).closest('.wtbx_tabs_nav').find('.wtbx_tabs_knob').length ) {
							newIndex -= 1;
						}

						var $active = $tabs.find('.wtbx_vc_tab.active').attr('id');

						if ( $active.length > 0 ) {
							if ( $('#' + $active + ' .plyr').length ) {
								$.each(SCAPE.players, function(index, value) {
									var instance = SCAPE.players[index];
									if ( $(instance.elements.container).closest('#' + $active).length ) {
										instance.pause();
									}
								});
							}
						}

						var $new_tab = $tabs.find('.wtbx_vc_tab[id="'+tabId+'"]');

						$nav_item.removeClass('active');
						$tab.removeClass('active prev next');
						$(this).parent('li').addClass('active');
						$new_tab.addClass('active');

						setTimeout(function() {
							SCAPE.animatedInContainer.hide($tabs.find('.wtbx_vc_tab:not(.active)'));
							SCAPE.animatedInContainer.reveal($tabs.find('.wtbx_vc_tab[id="'+tabId+'"]'));
						});

						setTimeout(function() {
							if ( $new_tab.find('.vc_line-chart').length ) {
								$('.vc_line-chart:visible').vcLineChart({reload:!1});
							}
							if ( $new_tab.find('.vc_pie_chart').length ) {
								jQuery(".vc_pie_chart:not(.vc_ready)").vcChat();
							}
						}, 100);

						$tab.each(function() {
							$(this).removeClass('prev next');
							if ( $(this).index() < newIndex ) {
								$(this).addClass('prev');
							} else if ( $(this).index() > newIndex ) {
								$(this).addClass('next');
							}
						});

						SCAPE.tabs.knob($tabs.find('.wtbx_tabs_nav'), $(this).parent('li'));

					}
				});

			});

		},

		accordionNav: function() {

			setTimeout(function() {
				SCAPE.animatedInContainer.hide($('.wtbx_vc_accordion').find('.wtbx_vc_accordion_tab:not(.active)'));
			});

			$('.wtbx_vc_accordion').find('.wtbx_accordion_link').each(function() {
				var wrapper = $(this).closest('.wtbx_vc_accordion').data('wrapper');
				$(this).find('.wtbx_tabs_nav_title').replaceWith('<'+wrapper+' class="wtbx_tabs_nav_title">' + $(this).find('.wtbx_tabs_nav_title').html() +'</'+wrapper+'>');
			});

			$('.wtbx_accordion_link').on('click', function(e) {
				SCAPE.stopEvent(e);
				var $nav_item	= $(this),
					$container	= $nav_item.closest('.wtbx_vc_accordion'),
					$tab		= $nav_item.parent('.wtbx_vc_accordion_tab'),
					$tab_inner	= $tab.children('.wtbx_accordion_tab_inner');

				if ( !$tab.hasClass('active') ) {
					SCAPE.animatedInContainer.hide($container.find('.wtbx_vc_accordion_tab:not(.active)').find('.wtbx_appearance_animation'));

					var $active = $container.find('.wtbx_vc_accordion_tab.active').data('tab');
					if ( $active.length > 0 ) {
						if ( $('#' + $active + ' .plyr').length ) {
							$.each(SCAPE.players, function(index, value) {
								var instance = SCAPE.players[index];
								if ( $(instance.elements.container).closest('#' + $active).length ) {
									instance.pause();
								}
							});
						}
					}

					$container.find('.wtbx_vc_accordion_tab.active').children('.wtbx_accordion_tab_inner').slideUp(500);
					$container.find('.wtbx_vc_accordion_tab.active').removeClass('active');
					$tab.addClass('active');
					$tab_inner.slideDown(500, function() {
						if ( $nav_item.closest('.wtbx_scroll_tab').length ) {
							$('html, body').animate({scrollTop: $nav_item.offset().top - SCAPE.headerOffset($nav_item) - 15}, 300);
						}
					});

					setTimeout(function() {
						SCAPE.animatedInContainer.hide($container.find('.wtbx_vc_accordion_tab'));
						SCAPE.animatedInContainer.reveal($tab);
					});
				}
			});
		},

		mobileTabsNav: function() {

			$('.wtbx_ui_accordion_item').on('click', function() {
				var tabId = $(this).attr('href');
				$(this).closest('.wtbx_ui_tabs').find('.wtbx_tabs_nav').find('.wtbx_tabs_nav_link[href="'+tabId+'"]').trigger('click');
			});

		}

	};

	jQuery(document).ready(function($) {
		SCAPE.tabs.init();
		SCAPE.tabs.navigateToTabOnInit();
	});

})(jQuery);