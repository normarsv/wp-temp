(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.pageNav = {

		init: function() {
			var $container	= $('#container.page-template-default').find('> #content > article > .entry-content');

			if ( undefined !== $container.data('page-nav') ) {
				var $slide		= $container.children('.wtbx_vc_section[id], .wtbx_vc_row[id]'),
					nav_style	= $container.data('page-nav');

				$container.addClass('navigation-container');
				$slide.addClass('navigation-section');

				if ( undefined !== nav_style ) {
					var $nav = '<div id="wtbx-page-nav" class="style_'+nav_style+'"><ul>';

					$slide.each(function() {
						var id		= $(this).attr('id'),
							anchor	= '';
						anchor = undefined !== $(this).data('anchor') ? $(this).data('anchor') : $(this).attr('id');
						var $inner = nav_style === 'lines' || nav_style === 'vertical' || nav_style === 'vertical_labels' ? '<span class="nav-bullet-inner"></span>' : '';

						$nav += '<li><a href="#'+id+'"><span class="nav-bullet">'+$inner+'</span><span class="nav-tooltip">'+anchor+'</span></a></li>';
					});

					$nav += '</ul></div>';

					$($nav).prependTo($('body'));

					SCAPE.pageNav.update();

					SCAPE.customCursor.bindClick($('#wtbx-page-nav a'));

					$(window).resize(function() {
						SCAPE.waitForFinalEvent( function() {
							SCAPE.pageNav.update();
						}, SCAPE.timeToWaitForLast, 'page_nav_resize');
					});
				}
			}

		},

		currentSection: 0,

		update: function() {
			var $container	= $('.navigation-container'),
				$slide		= $container.children('.navigation-section'),
				$nav		= $('#wtbx-page-nav'),
				$bullet		= $nav.find('li'),
				navCenter	= SCAPE.scrollTop.get + SCAPE.viewport().height / 2,
				currIndex	= 0;

			$slide.each(function(index) {
				var topEdge = $(this).offset().top;
				if ( topEdge < navCenter ) {
					currIndex = index;
				}
			});
			SCAPE.pageNav.currentSection = currIndex;

			if ( $nav.find('a.active').parent('li').index() !== SCAPE.pageNav.currentSection ) {
				if ( !$bullet.eq(currIndex).find('a').hasClass('active') ) {
					$bullet.find('a').removeClass('active');
					$bullet.eq(currIndex).find('a').addClass('active');
				}

				var skin = $slide.eq(currIndex).data('skin');

				$nav.removeClass('wtbx_skin_dark wtbx_skin_light skin_colorful');
				if ( undefined !== skin ) {
					$nav.addClass('wtbx_skin_' + skin);
				} else {
					$nav.addClass('wtbx_skin_dark');
				}
			}

			if ( $container.data('page-nav') === 'lines' || $container.data('page-nav') === 'vertical' || $container.data('page-nav') === 'vertical_labels' ) {
				var bottomEdge	= $slide.eq(currIndex+1).length ? $slide.eq(currIndex+1).offset().top - $slide.eq(currIndex).offset().top : $slide.eq(currIndex).outerHeight();
				if ( $slide.eq(currIndex).length ) {
					var progress	= ( navCenter - $slide.eq(currIndex).offset().top ) / bottomEdge;
					var transform	= SCAPE.propertyPrefix('transform');

					if ( progress < 0 ) {
						progress = 0
					} else if ( progress > 1 ) {
						progress = 1;
					}

					if ( $container.data('page-nav') === 'lines' ) {
						$nav.find('a.active').find('.nav-bullet-inner').css(transform, 'scale3d('+progress+',1,1');
					} else {
						$nav.find('a.active').find('.nav-bullet-inner').css(transform, 'scale3d(1,'+progress+',1');
					}
				}
			}
		}

	};

	jQuery(document).ready(function($) {
		SCAPE.pageNav.init();
	});

})(jQuery);