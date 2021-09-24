
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();


	SCAPE.pageSlider = {

		init: function() {
			$('#page-wrap .page-template-slider').each(function() {
				var $container	= $(this).find('> #content > article > .entry-content'),
					$slide		= $container.children('.wtbx_vc_section, .wtbx_vc_row'),
					nav_style	= $container.data('nav'),
					anchors		= [],
					tooltips	= [];

				if ( undefined !== nav_style ) {
					$slide.each(function(index) {
						var anchor	= '';
						if ( undefined !== $(this).data('anchor') ) {
							anchor = $(this).data('anchor');
						} else {
							anchor = (index + 1).toString();
						}
						anchors.push(anchor);
					});

					if ( $('#footer').length ) {
						anchors.push('footer');
					}
					$('#page-wrap').after('<div id="fp-nav" class="page-slider-nav style_'+nav_style+'"><ul></ul></div>');
				}

				$container.addClass('page-slider');
				$slide.addClass('page-slide');
				$('.page-slide.wtbx_vc_section').find('.wtbx_section_content').addClass('page-slide-inner').wrap('<div class="page-slide-wrapper"></div>');
				$('.page-slide.wtbx_vc_row').find('.wtbx_row_content').addClass('page-slide-inner').wrap('<div class="page-slide-wrapper"></div>');

				$('#footer').addClass('with-fullscreen');

				var scrolling = false;

				$container.fullpage({
					//Navigation
					menu: '.page-slider-nav',
					navigation: true,
					navigationPosition: 'right',
					navigationTooltips: anchors,

					//Scrolling
					css3: true,
					scrollingSpeed: 1000,
					easingcss3: 'cubic-bezier(0.7, 0, 0.3, 1)',
					dragAndMove: false,
					fadingEffect: false,
					scrollOverflow: false,
					scrollOverflowReset: false,
					scrollOverflowOptions: null,
					touchSensitivity: 15,
					normalScrollElementTouchThreshold: 5,

					//Accessibility
					recordHistory: true,

					//Design
					controlArrows: true,
					verticalCentered: true,

					//Custom selectors
					sectionSelector: '.page-slide',

					lazyLoading: false,

					//events
					onLeave: function(index, nextIndex, direction){
						$('.page-slide').eq(nextIndex-1).addClass('animating');
						var dir = direction[0].toUpperCase() + direction.slice(1);
						var animation = $container.data('anim');
						$('.page-slide').eq(index-1).addClass(animation + dir + 'Out');
						$('.page-slide').eq(nextIndex-1).addClass(animation + dir + 'In');

						var skin = $('.page-slide').eq(nextIndex-1).data('skin');
						$('.page-slider-nav').removeClass('wtbx_skin_light wtbx_skin_dark skin_colorful');
						$('.page-slider-nav').addClass('animating wtbx_skin_'+skin);

						var transform = SCAPE.propertyPrefix('transform');
						$('#footer').removeClass('fullscreen-active');
						$('#footer, .page-wrap-slider').css(transform, 'translate3d(0,0,0)');

						for (var i=0; i<SCAPE.mediaelements.length; i++) {
							if ( $('.page-slide').eq(index-1).find('#' + SCAPE.mediaelements[i].id).length ) {
								SCAPE.mediaelements[i].pause();
							}
							if ( $('.page-slide').eq(nextIndex-1).find('#' + SCAPE.mediaelements[i].id).length ) {
								SCAPE.mediaelements[i].play();
							}
						}

						setTimeout(function() {
							SCAPE.animatedInContainer.hide($('.page-slide').eq(index-1));
						}, 1000);
						SCAPE.animatedInContainer.hide($('.page-slide').eq(nextIndex-1));

						if ( scrolling ) {
							return false;
						} else {
							scrolling = true;
						}

					},
					afterLoad: function(anchorLink, index){
						var animation = $container.data('anim');
						$('.page-slide').eq(index-1).removeClass(animation + 'UpIn ' + animation + 'DownIn');
						$('.page-slide').removeClass(animation + 'UpOut ' + animation + 'DownOut');

						var skin = $('.page-slide').eq(index-1).data('skin');
						$('.page-slider-nav').removeClass('animating');
						$('.page-slider-nav').addClass('wtbx_skin_'+skin);

						var $header = $('#header-wrapper');
						var header_skin = $('#site-header').data('skin');

						if (	$header.hasClass('header-style-1') ||
							$header.hasClass('header-style-2') ||
							$header.hasClass('header-style-3') ||
							$header.hasClass('header-style-4') ||
							$header.hasClass('header-style-5') ||
							$header.hasClass('header-style-6') ||
							$header.hasClass('header-style-8') ||
							$header.hasClass('header-style-9') ||
							$header.hasClass('header-style-10') ||
							$header.hasClass('header-style-11') ||
							$header.hasClass('header-style-15') ||
							$header.hasClass('header-style-16') ) {

							$header.removeClass('header-skin-light header-skin-dark skin_colorful');
							$header.addClass('header-skin-'+skin);
							$('#site-header').removeClass('with-fullscreen-slider');

							if ( $header.find('.wtbx_header_logo .wtbx_logo_op').length ) {
								if (skin.indexOf(header_skin) !== -1) {
									$header.removeClass('show-logo-op');
									$header.addClass('show-logo-def');
								} else {
									$header.removeClass('show-logo-def');
									$header.addClass('show-logo-op');
								}
							}
						}

						$('.page-slide').eq(index-1).removeClass('animating');

						setTimeout(function() {
							SCAPE.animatedInContainer.reveal($('.page-slide').eq(index-1));
						});

						$(document).trigger('wtbx_fullpage_slider_changed');
						scrolling = false;
					},
					afterRender: function(){
						$(document).trigger('resize');
					},
					afterResize: function(){},
					afterResponsive: function(isResponsive){}
				});

				SCAPE.customCursor.bindClick($('.page-slider-nav a'));
			});
		}
	};

	jQuery(document).ready(function($) {
		if ( !$('body').hasClass('wtbx-frontend-editor') && !SCAPE.isMobile() ) {
			SCAPE.pageSlider.init();
		}
	});

})(jQuery);