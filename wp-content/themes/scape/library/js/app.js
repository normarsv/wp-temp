
/*
SCAPE app scripts
 */

(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();


	SCAPE.viewport = function() {
		var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
		return { width:x,height:y }
	};



	SCAPE.raf = function() {
		return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || window.oRequestAnimationFrame;
	};



	SCAPE.waitForFinalEvent = (function() {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
			if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
			timers[uniqueId] = setTimeout(callback, ms);
		};
	}());



	SCAPE.timeToWaitForLast = 100;



	SCAPE.debounce = function (func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) {
					func.apply(context, args);
				}
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) {
				func.apply(context, args);
			}
		};
	};


	SCAPE.players = [];



	SCAPE.propertyPrefix = function(prop) {
		var doc = document.body || document.documentElement;
		var s = doc.style;
		var property = [ 'WebkitTransform', 'MozTransform', 'OTransform', 'msTransform' ];
		var prefix;
		for( var i in property ){
			if( s[ property[i] ] !== undefined ){
				prefix = '-' + property[i].replace( 'Transform', '' ).toLowerCase();
			}
		}
		var transform = prefix + '-' + prop;
		return transform;
	};



	SCAPE.transform = function($el, transform) {
		$el.style['-webkit-transform'] = transform;
		$el.style['-moz-transform'] = transform;
		$el.style['-ms-transform'] = transform;
		$el.style['-o-transform'] = transform;
		$el.style['transform'] = transform;
	};



	SCAPE.scrollTop = {
		update: function() {
			SCAPE.scrollTop.get = $(window).scrollTop();
		},
		get: 0,
		last: 0
	};



	SCAPE.isMobile = function() {
		var isMobile,
			$body	= $('body');
		isMobile	= $('html').hasClass('touch') ? true : false;
		if (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0)) {
			isMobile = true;
		};
		return isMobile;
	};



	SCAPE.bindEscape = function(event_id, callback) {
		$(document).on('keyup.'+event_id, function(e) {
			e = e || window.event;
			var isEscape = false;
			if ("key" in e) {
				isEscape = (e.key == "Escape" || e.key == "Esc");
			} else {
				isEscape = (e.keyCode == 27);
			}
			if (isEscape) {
				callback();
				$(document).off('keyup.'+event_id);
			}
		});
	};



	SCAPE.scrollbarWidth = function() {
		var $body = $('body');
		var scrollDiv = document.createElement('div');
		scrollDiv.className = 'modal-scrollbar-measure';
		$body.append(scrollDiv);
		var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
		$body[0].removeChild(scrollDiv);
		return scrollbarWidth;
	};



	SCAPE.lazyload = function() {
		window.lazySizesConfig = window.lazySizesConfig || {};
		lazySizesConfig.loadedClass = 'wtbx-lazyloaded';
		lazySizesConfig.preloadAfterLoad = true;
		lazySizesConfig.expand = 500;
		lazySizesConfig.expFactor = 2;
		lazySizesConfig.init = false;
		document.addEventListener('lazybeforeunveil', function(e){

			var $img 		= $(e.target),
				bgImg		= $img.data('bg'),
				srcset		= '',
				ratio		= $img.data('ratio'),
				imgratio	= $img.data('imgratio'),
				aspectratio = $img.data('aspectratio');

			if ( $img.hasClass('wtbx_before_after_image') ) {
				if ( imgratio !== '' && imgratio !== undefined ) {
					var imgwidth	= $img.closest('.wtbx-element-reveal').width(),
						imgheight	= Math.round(imgwidth * imgratio);
					$img.attr('sizes', imgwidth);
				}
			}

			// var $tile = $img.closest('.wtbx-metro-entry');
			// if ( $tile.length ) {
			// 	var tileW = $tile.data('width');
			// 	var tileH = $tile.data('height');
			// 	var tileRatio = tileH / tileW;
			// 	var sizes = parseInt($img.attr('sizes').replace('w', ''));
			// 	$img.attr('sizes', (sizes * tileRatio * aspectratio) + 'px');
			// }

			// var $cont = $img.closest('.wtbx-element-reveal');
			// if ( $cont.length ) {
			// 	var W = $cont.data('width');
			// 	var H = $cont.data('height');
			// 	var Ratio = H / W;
			// 	var sizes = parseInt($img.attr('sizes').replace('w', ''));
			// 	$img.attr('sizes', (sizes * Ratio * aspectratio) + 'px');
			// }

			var path = $img.data('path');
			var dims = $img.data('dims');
			var dataSrcset = [];
			var join;

			if ( undefined !== dims ) {
				for ( var j=0; j<dims.length; j++ ) {
					if ( dims[j][0] !== '.' ) {
						join = '-';
					} else {
						join = '';
					}

					dataSrcset[j] = path + join + dims[j];
				}

				dataSrcset = dataSrcset.join(', ');
				$img.removeAttr('data-path');
				$img.removeAttr('data-dims');

				if ( bgImg == false ) {
					$img.attr('data-srcset', dataSrcset);
				} else {
					$img.attr('data-bgset', dataSrcset);
				}
			}

		});

		document.addEventListener('imageLazyLoaded', function(e){
			if (e.target.closest('.wtbx-grid, .wtbx-reveal-cont')) {
				SCAPE.entryReveal(e.target.closest('.wtbx-element-reveal'));
				$(e.target).removeAttr('data-srcset').removeAttr('data-src');
				if ( true === $(e.target).data('bg') ) {
					setTimeout(function() {
						$(e.target).addClass('wtbx-bg-loaded');
					});
				}
			}
			SCAPE.debounce(SCAPE.verticalAlign(), 250);
		});

		lazySizes.init();
	};



	SCAPE.transitionEvent = function() {
		var t;
		var el = document.createElement('fakeelement');
		var transitions = {
			'transition':'transitionend',
			'OTransition':'oTransitionEnd',
			'MozTransition':'transitionend',
			'WebkitTransition':'webkitTransitionEnd'
		};
		for(t in transitions){
			if( el.style[t] !== undefined ){
				return transitions[t];
			}
		}
	};


	SCAPE.animationEvent = function() {
		var t;
		var el = document.createElement('fakeelement');
		var transitions = {
			'WebkitAnimation' : 'webkitAnimationEnd',
			'OAnimation' : 'oAnimationEnd',
			'msAnimation' : 'MSAnimationEnd',
			'animation' : 'animationend'
		};
		for(t in transitions){
			if( el.style[t] !== undefined ){
				return transitions[t];
			}
		}
	};



	SCAPE.stopEvent = function(e) {
		if(!e) var e = window.event;
		e.cancelBubble = true;
		e.returnValue = false;
		if ( e.stopPropagation ) e.stopPropagation();
		if ( e.preventDefault ) e.preventDefault();
		return false;
	};



	SCAPE.resizeRows = function() {

		$('.row-wrapper.fixed_height').each(function() {
			var $this = $(this),
				height = $this.data('height'),
				windowHeight = SCAPE.viewport(),
				wH = windowHeight.height;

			if ( $('#wpadminbar').length ) wH -= $('#wpadminbar').height();
			if ( $('.preview__header').length ) wH -= $('.preview__header').height();

			$this.css({height: wH * height / 100 + 'px'});
		});

	};



	SCAPE.scrollbar = {

		hide: function($el) {
			var ww				= SCAPE.viewport().width,
				width			= $('body').outerWidth(),
				$header			= $('#header-wrapper'),
				scrollbarWidth	= ww - width;

			$el = $el !== '' ? ', ' + $el : $el;

			$('html').addClass('wtbx_html_fixed');
			$('html').css({'margin-right': scrollbarWidth + 'px'});
			$('body'+$el).css({'padding-right': scrollbarWidth + 'px'});
			$('.wtbx-footer-under #footer').css({'right': scrollbarWidth + 'px'});

			if ( $header.hasClass('header_sticky_default') || ( $header.hasClass('header_sticky_scroll') && !$header.hasClass('header_sticky_scrolldown') && $header.hasClass('header_sticky_scroll_scrollup') ) ) {
				$header.css({'padding-right': scrollbarWidth + 'px'});
			}

		},

		show: function($el) {
			var ww				= SCAPE.viewport().width,
				width			= $('body').outerWidth(),
				$header			= $('#header-wrapper'),
				scrollbarWidth	= ww - width;

			$el = $el !== '' ? ', ' + $el : $el;

			$('html').removeClass('wtbx_html_fixed');
			$('html').css({'margin-right': ''});
			$('body'+$el).css({'padding-right': ''});
			$('.wtbx-footer-under #footer').css({'right': ''});

			if ( $header.hasClass('header_sticky_default') || ( $header.hasClass('header_sticky_scroll') && !$header.hasClass('header_sticky_scrolldown') && $header.hasClass('header_sticky_scroll_scrollup') ) ) {
				$header.css({'padding-right': ''});
			}
		}

	};



	SCAPE.search = function() {
		var $overlay = $('#wtbx_header_search_wrapper');

		$('.search_button').on('click', function () {

			SCAPE.scrollbar.hide('.wtbx_header_search');
			$overlay.addClass('search_active');
			$overlay.find('.wtbx_for_custom_dropdown').change();

			if ( $('body').hasClass('mobile-header-open') ) {
				$('body').removeClass('mobile-header-open');
			}

			setTimeout(function () {
				$overlay.find('.wtbx_search_input').focus();
			}, 1600);

			$(document).on('keyup.enter_search', function(e) {
				e = e || window.event;
				if (e.which == 13 || event.keyCode == 13) {
					if ( $overlay.find('.wtbx_search_input').val() !== '' ) {
						$('#wtbx_header_search_wrapper #wtbx_search_form').submit();
					}
				}
			});

			SCAPE.bindEscape('search_panel', function() {
				$overlay.removeClass('search_active');
				$overlay.find('.wtbx_search_input').val('');
				setTimeout(function() {
					SCAPE.scrollbar.show('.wtbx_header_search');
				}, 800);
			});
		});

		$('.wtbx_search_backdrop, .wtbx_search_close').on('click', function() {
			$overlay.removeClass('search_active');
			$overlay.find('.wtbx_search_input').val('');
			setTimeout(function() {
				SCAPE.scrollbar.show('.wtbx_header_search');
			}, 800);
		});

		$('.wtbx_search_field_wrapper i').on('click', function() {
			if ( $(this).prev('input').val() !== '' ) {
				$(this).closest('form').submit();
			}
		});

		// Search page form
		var $searchPageForm = $('#wtbx-search-page-searchform');

		if ( $searchPageForm.length ) {
			var match,
				pl     = /\+/g,  // Regex for replacing addition symbol with a space
				search = /([^&=]+)=?([^&]*)/g,
				decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
				query  = window.location.search.substring(1);

			var urlParams = {};
			while (match = search.exec(query)) {
				urlParams[decode(match[1])] = decode(match[2]);
			}

			if ( undefined !== urlParams['s'] ) {
				$searchPageForm.find('.wtbx_search_input').val(urlParams['s']);
			}
			if ( undefined !== urlParams['post_type'] ) {
				$searchPageForm.find('select.wtbx_search_field').val(urlParams['post_type']);
			}

			$(document).on('keyup.enter_searchpage', function(e) {
				e = e || window.event;
				if (e.which == 13 || event.keyCode == 13) {
					if ( $searchPageForm.find('.wtbx_search_input').val() !== '' && $searchPageForm.find('.wtbx_search_input').is(':focus') ) {
						$searchPageForm.find('#wtbx_search_form').submit();
					}
				}
			});
		}


	};



	SCAPE.headerOverlay = (function() {
		var $overlay	= $('#wtbx_header_overlay'),
			$close		= $overlay.find('.wtbx_overlay_close');

		$('.overlay_button').on('click', function () {
			SCAPE.scrollbar.hide();
			$overlay.show();
			setTimeout(function() {
				$overlay.addClass('overlay_active');

				SCAPE.bindEscape('header_overlay', function() {
					$overlay.removeClass('overlay_active');
					setTimeout(function() {
						SCAPE.scrollbar.show();
					}, 600);
				});
			}, 100);
		});

		$close.on('click', function() {
			$overlay.removeClass('overlay_active');
			setTimeout(function() {
				SCAPE.scrollbar.show();
				$overlay.hide();
			}, 600);
		});

	}());



	SCAPE.headerSidearea = (function() {
		var $sidearea = $('#wtbx_header_sidearea');

		$('.sidearea_button').on('click', function () {
			$sidearea.addClass('sidearea_active');
			SCAPE.scrollbar.hide();

			SCAPE.bindEscape('header_sidearea', function() {
				$sidearea.removeClass('sidearea_active');
				setTimeout(function() {
					SCAPE.scrollbar.show();
				}, 600);
			});
		});

		$('.wtbx_sidearea_close, .wtbx_sidearea_backdrop').on('click', function() {
			$sidearea.removeClass('sidearea_active');
			setTimeout(function() {
				SCAPE.scrollbar.show();
			}, 600);
		});

	}());



	SCAPE.dropdown = function($el) {

		if ( !SCAPE.isMobile() ) {

			if ( !$el ) {
				$el = $('.wtbx_for_custom_dropdown');
			}

			$('.wtbx_for_custom_dropdown').each(function() {
				$(this).siblings('.wtbx_with_custom_dropdown').html($(this).find('option:selected').html());
			});

			$(document.body).unbind('change.dropdown').on('change.dropdown', '.wtbx_for_custom_dropdown', function() {
				$(this).siblings('.wtbx_with_custom_dropdown').html($(this).find('option:selected').html());
			});

			$('.wtbx_with_custom_dropdown').unbind('click.dropdown').on('click.dropdown', function() {
				var $select			= $(this),
					$selectOriginal	= $select.siblings('.wtbx_for_custom_dropdown'),
					style			= window.getComputedStyle(this),
					lineHeight		= style.lineHeight,
					font			= style.font,
					padding			= style.padding,
					borderWidth		= style.borderWidth,
					width			= $select.outerWidth(),
					offsetTop		= $select.offset().top,
					offsetLeft		= $select.offset().left;

				var $dropdown = $('<ul class="wtbx_dropdown"></ul>');

				$selectOriginal.find('option').each(function() {
					if ( $(this).val() !== $selectOriginal.val() ) {
						$dropdown.append('<li class="wtbx_dropdown_option wtbx-click" data-value="' + $(this).val() + '">' + $(this).html() + '</li>');
					}
				});

				var totalHeight = (($selectOriginal.find('option').length - 1) * 40) + parseFloat(lineHeight) + 10;

				if (totalHeight > 400) {
					totalHeight = 400;
				}

				if ( offsetTop + totalHeight < SCAPE.scrollTop.get + SCAPE.viewport().height ) {
					$dropdown.prepend('<li class="wtbx_dropdown_option option_active wtbx-click" data-value="' + $selectOriginal.val() + '">' + $selectOriginal.find('option:selected').html() + '</li>');
					$dropdown.css('padding-bottom', '10px');
				} else {
					$dropdown.append('<li class="wtbx_dropdown_option option_active wtbx-click" data-value="' + $selectOriginal.val() + '">' + $selectOriginal.find('option:selected').html() + '</li>');
					offsetTop = offsetTop - (totalHeight - parseFloat(lineHeight) );
					$dropdown.css('padding-top', '10px');
				}

				$dropdown.css({
					'width': width + 'px',
					'line-height': lineHeight,
					'left': offsetLeft,
					'top': offsetTop
				});

				$dropdown.children().css({
					'padding': padding,
					'border-width': borderWidth
				});

				$dropdown.children('.option_active').css({
					'font': font,
				});

				$('body').append($dropdown);

				$dropdown.find('.wtbx_dropdown_option').on('click', function() {
					$selectOriginal.val($(this).data('value')).change();
					$dropdown.remove();
					$(document).off('click.custom_dropdown');
					$selectOriginal.focus();
				});

				setTimeout(function() {

					$(document).on('click.custom_dropdown', function(e) {
						if ( !$dropdown.is(e.target) && !$dropdown.find(e.target).length ) {
							$dropdown.remove();
							$(document).off('click.custom_dropdown');
							$selectOriginal.focus();
						}
					});

					SCAPE.bindEscape('custom_dropdown', function() {
						$dropdown.remove();
						$selectOriginal.focus();
					});
				});

			});

			SCAPE.customCursor.bindClick($('.wtbx_with_custom_dropdown'));

		}

	};



	SCAPE.toTop = function() {
		if ( $('.wtbx_bottom_navigation').length && !$('.wtbx_bottom_navigation').find('.wtbx-nav-next').length ) {
			$('.wtbx-totop').addClass('shifted');
		}
		$('.wtbx-totop').on('click', function(e) {
			SCAPE.stopEvent(e);
			var speed   = 2,
				time    = Math.abs(SCAPE.scrollTop.get) / speed;
			$('html, body').animate({scrollTop:0}, 1000);
			$('.wtbx_fixed_navigation').addClass('invisible');
		});
	};



	SCAPE.socialButtons = function() {
		if ( $('.wtbx_bottom_navigation').length && !$('.wtbx_bottom_navigation').find('.wtbx-nav-prev').length ) {
			$('.wtbx-social-wrapper').addClass('shifted');
		}

		var $cont = $('.wtbx-social-wrapper');
		var $copy = $cont.find('.wtbx-copy');
		$('.wtbx-social-trigger').on('click', function(e) {
			if ( !$(this).parent().hasClass('active') ) {
				var width = Math.max($cont.find('.wtbx-social-inner').width(), 290);
				var height = Math.max($cont.find('.wtbx-social-inner').height(), 66);

				$cont.find('.wtbx-social-container').css({
					'width': width,
					'height': height
				});
				setTimeout(function() {
					$(document).on('click.share', function(e) {
						if ( !$(e.target).closest('.wtbx-social-container').length ) {
							$cont.find('.wtbx-social-container').css({
								'width': 44,
								'height': 44
							});
							$cont.removeClass('active');
							$(document).off('click.share');
						}
					});
					
					$cont.find('.wtbx-social-close').on('click', function() {
						$(document).trigger('click.share');
					});
				});
			} else {
				$cont.find('.wtbx-social-container').css({
					'width': 44,
					'height': 44
				});
			}
			$cont.toggleClass('active');
		});

		$cont.find('.copy-value').on('click', function() {
			$(this).select();
		});

		$copy.on('click', function() {
			$(this).siblings('.copy-value').select();
			document.execCommand('copy');
		});
	};



	SCAPE.share = {

		getData: function($el, attr) {
			var val = $el.data(attr);
			return (val === undefined || val === null) ? false : val;
		},

		options: function($el) {
			return {
				facebook: {
					link: '//www.facebook.com/sharer/sharer.php',
					params: {
						u: SCAPE.share.getData($el, 'url')
					}
				},
				googleplus: {
					link: '//plus.google.com/share',
					params: {
						url: SCAPE.share.getData($el, 'url')
					}
				},
				linkedin: {
					link: '//www.linkedin.com/shareArticle',
					params: {
						url: SCAPE.share.getData($el, 'url')
					}
				},
				twitter: {
					link: '//twitter.com/intent/tweet/',
					params: {
						text: SCAPE.share.getData($el, 'title'),
						url: SCAPE.share.getData($el, 'url')
					}
				},
				pinterest: {
					link: '//www.pinterest.com/pin/create/button/',
					params: {
						url: SCAPE.share.getData($el, 'url'),
						description: SCAPE.share.getData($el, 'description')
					}
				},
				vk: {
					link: '//vk.com/share.php',
					params: {
						url: SCAPE.share.getData($el, 'url'),
						title: SCAPE.share.getData($el, 'title'),
						description: SCAPE.share.getData($el, 'caption')
					}
				}
			}
		},

		init: function() {

			$(document).on('click', '.wtbx-share', function() {
				var type	= $(this).data('share'),
					url		= SCAPE.share.options($(this))[type]['link'],
					params	= SCAPE.share.options($(this))[type]['params'];

				var p = params || {},
					keys = Object.keys(p),
					i,
					str = keys.length > 0 ? '?' : '';
				for (i = 0; i < keys.length; i++) {
					if (str !== '?') {
						str += '&';
					}
					if (p[keys[i]]) {
						str += keys[i] + '=' + encodeURIComponent(p[keys[i]]);
					}
				}

				url += str;

				var popWidth = 600,
					popHeight = 480,
					left = window.innerWidth / 2 - popWidth / 2 + window.screenX,
					top = window.innerHeight / 2 - popHeight / 2 + window.screenY,
					popParams = 'scrollbars=no, width=' + popWidth + ', height=' + popHeight + ', top=' + top + ', left=' + left,
					newWindow = window.open(url, '', popParams);
			});
		}

	};



	SCAPE.mediaelements = [];



	SCAPE.initPostMedia =  {

		audioplayer: function($audio, each) {
		},

		media_selfhosted: function() {
		},

		media_iframe: function() {
			$('.audio-embed iframe, .video-embed iframe').each(function() {
				$(this).on('load', function() {
					var $cont = $(this).closest('.wtbx_preloader_cont');
					$cont.find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
					$cont.find('.wtbx-element-reveal').addClass('wtbx-element-visible');
				});
			});
		},

		video_embedded: function() {
		},

		video_selfhosted: function($video) {
		},

		gallery: function($gallery, each) {
			var autoplay = $gallery.closest('.wtbx-grid-masonry').length ? true : false;

			var options = {
				speed			: 700,
				autoplay		: autoplay,
				touchThreshold	: 8,
				adaptiveHeight	: false,
				useTransform	: true,
				cssEase			: 'cubic-bezier(0.6, 0, 0.2, 1)',
				prevArrow		: '<div class="wtbx-arrow wtbx-prev"></div>',
				nextArrow		: '<div class="wtbx-arrow wtbx-next"></div>',
				dots			: true
			};

			if (each === true) {
				$gallery.each(function() {
					$(this).slick(options);
				});
			} else {
				$gallery.slick(options);
			}

			SCAPE.customCursor.bindClick($gallery.find('.wtbx-arrow'));
			SCAPE.customCursor.bindClick($gallery.find('.slick-dots li'));

			setTimeout(function() {
				SCAPE.refreshIsotope($gallery.closest('.wtbx-grid-masonry'));
			});
		}

	};



	SCAPE.isRetina = function() {
		var mediaQuery = "(-webkit-min-device-pixel-ratio: 1.5),\
			(min--moz-device-pixel-ratio: 1.5),\
			(-o-min-device-pixel-ratio: 3/2),\
			(min-resolution: 1.5dppx)";
		if (window.devicePixelRatio > 1) {
			return true;
		} else if (window.matchMedia && window.matchMedia(mediaQuery).matches) {
			return true;
		}
		return false;
	};



	SCAPE.initLogo = (function() {
		var $logo	= $('#site-logo img'),
			retina	= $logo.data('rsrc');

		if ( SCAPE.isRetina() && retina !== '' ) {
			$logo.attr('src', retina);
		}
	}());



	SCAPE.initHeaderSeven = (function() {
		var $header = $('.header-style-7');
		if ( $header.length ) {
			$header.find('.wtbx_ha_header_main, .wtbx_ha_header_right_hidden').find('.wtbx_header_part:not(.wtbx_menu_nav, .wtbx_header_space)').addClass('wtbx_header_anim_item');
			$header.find('.wtbx_ha_header_main, .wtbx_ha_header_right_hidden').find('.menu-item').addClass('wtbx_header_anim_item');

			$('.wtbx_header_trigger').on('click', function() {
				var $headerWrapper = $('#header-wrapper');
				if ( $headerWrapper.hasClass('header_active') ) {
					$('#header-wrapper').removeClass('header_active');
					$header.find('.wtbx_header_anim_item').each(function(index) {
						var $this = $(this);
						setTimeout(function() {
							if ( !$headerWrapper.hasClass('header_active') ) {
								$this.removeClass('item_active');
							}
						}, 50 * index);
					});
				} else {
					$headerWrapper.addClass('header_active');
					$($header.find('.wtbx_header_anim_item').get().reverse()).each(function(index) {
						var $this = $(this);
						setTimeout(function() {
							if ( $headerWrapper.hasClass('header_active') ) {
								$this.addClass('item_active');
							}
						}, 50 * (index+1));
					});
				}
			});
		}
	}());



	SCAPE.headerOverlayHeight = function() {
		var $header		= $('#header-wrapper'),
			$overlay	= $('.wtbx_header_overlay_layer');

		if ( $header.hasClass('header_active') ) {
			$('.wtbx_header_overlay_layer').css('height', SCAPE.viewport().height + 'px');
		}
	};



	SCAPE.initHeaderTenEleven = (function() {
		var $header = $('.header-style-10, .header-style-11');
		if ( $header.length ) {

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.headerOverlayHeight();
				}, SCAPE.timeToWaitForLast, 'header_overlay_height');
			});

			$header.find('.wtbx_header_overlay_layer').find('.wtbx_header_part:not(.wtbx_menu_nav)').addClass('wtbx_header_anim_item');
			$header.find('.wtbx_header_overlay_layer').find('.menu-item').addClass('wtbx_header_anim_item');
			setTimeout(function() {
				$header.find('.wtbx_hs_header').addClass('wtbx_ready');
			});

			$('.wtbx_header_trigger').on('click', function() {
				var $body		= $('body'),
					$wrapper	= $('#header-wrapper'),
					width		= $body.outerWidth(),
					windowSize	= SCAPE.viewport(),
					ww			= windowSize.width;

				// Get the scrollbar width
				var scrollbarWidth = ww - width;

				if ( $wrapper.hasClass('header_active') ) {
					$wrapper.find('.wtbx_header_anim_item').removeClass('item_active');
					$wrapper.removeClass('header_active');
					SCAPE.transitionEvent() && $('.wtbx_header_overlay_layer').one(SCAPE.transitionEvent(), function(e) {
						SCAPE.scrollbar.show('.wtbx_ha_overlay_header, .wtbx_ha_overlay_main, .wtbx_ha_overlay_footer');
					});
				} else {
					$wrapper.addClass('header_active');
					SCAPE.headerOverlayHeight();
					SCAPE.scrollbar.hide('.wtbx_ha_overlay_header, .wtbx_ha_overlay_main, .wtbx_ha_overlay_footer');
					$header.find('.wtbx_header_anim_item').each(function(index) {
						var $this = $(this);
						setTimeout(function() {
							$this.addClass('item_active');
						}, 700 + 125 * (index+1));
					});

					SCAPE.bindEscape('overlay_header', function() {
						$wrapper.find('.wtbx_header_anim_item').removeClass('item_active');
						$wrapper.removeClass('header_active');
						SCAPE.transitionEvent() && $('.wtbx_header_overlay_layer').one(SCAPE.transitionEvent(), function() {
							SCAPE.scrollbar.show('.wtbx_ha_overlay_header, .wtbx_ha_overlay_main, .wtbx_ha_overlay_footer');
						});
					});
				}
			});
		}
	}());



	SCAPE.initHeaderFourteen = (function() {
		var $header = $('.header-layout-14');
		if ( $header.length ) {
			$header.find('.wtbx_header_trigger').on('click', function() {
				if ( $('#site-header').hasClass('header_active') ) {
					$('#site-header').removeClass('header_active');
				} else {
					$('#site-header').addClass('header_active');
				}

				$header.find('.header_backdrop').on('click', function() {
					$('#site-header').removeClass('header_active');
				});

				SCAPE.bindEscape('header_backdrop', function() {
					$('#site-header').removeClass('header_active');
				});
			});
		}
	}());



	SCAPE.menuId = function() {
		$('#header-wrapper').find('.menu-item').each(function() {
			var id = $(this).data('id');

			if ( id !== '' ) {
				$(this).attr('id', id);
				$(this).removeAttr('data-id');
			}
		});
	};



	SCAPE.duplicateMenu = function() {
		var $placeholder = $('.wtbx_header_placeholder');
		if ( $placeholder.length ) {
			var menuName = $placeholder.data('slug');
			var $menu = $('#header-wrapper #menu-' + menuName);
			$menu.clone().appendTo($placeholder.parent());
			$placeholder.remove();
		}
	};

	SCAPE.duplicateMenu();



	SCAPE.megamenu = function() {
		"use strict";
		var $window = $(window),
			$header = $('#header-wrapper');

		$('#site-header').find('.wtbx_ha_header_main, .wtbx_ha_main_main').find('nav.wtbx_menu_nav').accessibleMegaMenu({
			/* prefix for generated unique id attributes, which are required
			 to indicate aria-owns, aria-controls and aria-labelledby */
			uuidPrefix: "accessible-megamenu",
			/* css class used to define the megamenu styling */
			menuClass: "nav-menu",
			/* css class for a top-level navigation item in the megamenu */
			topNavItemClass: "nav-item",
			/* css class for a megamenu panel */
			panelClass: "sub-menu",
			/* css class for a group of items within a megamenu panel */
			panelGroupClass: "sub-menu-group",
			/* css class for the hover state */
			hoverClass: "hover",
			/* css class for the focus state */
			focusClass: "focus",
			/* css class for the open state */
			openClass: "open"
		})
		.on('megamenu:open', function(e, el) {

			var $el = $(el),
				$sub_nav;

			if ($el.is('.main-menu-link.open') && $el.siblings('div.sub-menu').length>0) {
				$sub_nav = $el.siblings('div.sub-menu');
			} else if ($el.is('div.sub-menu')) {
				$sub_nav = $el;
				$el = $sub_nav.siblings('.main-menu-link');
			} else {
				return true;
			}

			var $header_wrapper = $sub_nav.closest('.header-wrapper');

			if( $header_wrapper.hasClass('header-style-1') ||
				$header_wrapper.hasClass('header-style-2') ||
				$header_wrapper.hasClass('header-style-3') ||
				$header_wrapper.hasClass('header-style-4') ||
				$header_wrapper.hasClass('header-style-5') ||
				$header_wrapper.hasClass('header-style-6') ||
				$header_wrapper.hasClass('header-style-7') ||
				$header_wrapper.hasClass('header-style-8') ||
				$header_wrapper.hasClass('header-style-9') ||
				$header_wrapper.hasClass('header-style-10') ||
				$header_wrapper.hasClass('header-style-11') ||
				$header_wrapper.hasClass('header-style-15') ||
				$header_wrapper.hasClass('header-style-16')) {

				$sub_nav.css('max-width', '').css('width', '').css('margin-left', '').removeClass('sub-menu-onecol');

				$sub_nav.find('ul.sub-menu-wide').each(function(){
					var $ul = $(this);

					if ( !$ul.hasClass('sub-menu-full-width') ) {
						var total_width = 1;

						$ul.children().each(function(){
							total_width += $(this).outerWidth();
						});

						$ul.innerWidth(total_width);
					}
				});

				var w_width = $window.width();
				var sub_nav_width = $sub_nav.width();
				var sub_nav_margin = 0;
				var $header = $el.closest('.wtbx_hs_inner');

				$sub_nav.css({'max-width' : w_width});

				if ( $sub_nav.find('ul.sub-menu-wide').hasClass('sub-menu-full-width') ) {
					$sub_nav.css({'width' : w_width - 10});
				} else {
					var $col = $sub_nav.find('ul.sub-menu-wide').children();
					var col_width = 0;

					$col.each(function() {
						col_width += $(this).outerWidth();
					});
					$sub_nav.find('ul.sub-menu-wide').css({'width' : Math.ceil(col_width) + 'px'});
				}

				sub_nav_width = $sub_nav.width();

				if (sub_nav_width > w_width) {
					$sub_nav.addClass('sub-menu-onecol');
					sub_nav_width = $sub_nav.width();
				}

				if ( $el.hasClass('main-menu-link') ) {
					$el = $el.parents();
				}

				var el_width = $el.outerWidth();
				var el_offset_left = $el.offset().left;
				var el_offset_right = $header.outerWidth() - ($el.offset().left - $header.offset().left) - el_width;

				if(el_offset_left < 0) {
					sub_nav_margin = -(el_offset_left - sub_nav_width/2 + el_width/2);
				}

				if ($sub_nav.find('ul.sub-menu-wide').hasClass('sub-menu-full-width')) {
					sub_nav_margin = - el_offset_left + 5;
				} else if (el_offset_right < (sub_nav_width - el_width)) {
					sub_nav_margin = - (sub_nav_width - el_width - el_offset_right) - 10;
				}

				$sub_nav.css('margin-left', sub_nav_margin);

			} else if (
				$header_wrapper.hasClass('header-style-12') ||
				$header_wrapper.hasClass('header-style-13') ||
				$header_wrapper.hasClass('header-style-14') ) {

				$sub_nav.removeClass('sub-menu-onecol');

				$sub_nav.each(function(){
					var $cont		= $(this),
						$wrapper	= $('.header-style-12, .header-style-13, .header-style-14'),
						$hCont		= $wrapper.find('#header-container'),
						$ul			= $cont.find('ul.sub-menu'),
						space		= 5;

					if ( $cont.children('.sub-menu-full-width').length ) {
						$cont = $cont.children();
					}
					if ( $cont.children('.sub-menu-wide').length ) {
						$ul = $cont.children();
					}

					// If megamenu equal columns
					if ( ($ul.is('[class*="mega-menu-col-"]') && $ul.is('.sub-menu-wide')) ) {

						var colNumber	= parseInt($ul.attr('class').split('mega-menu-col-')[1][0]),
							$col		= $ul.children(),
							width		= 0,
							w_width		= $window.width(),
							h_width		= $wrapper.outerWidth();

						$col.removeAttr('style');

						$col.each(function() {
							var el_width = $(this).outerWidth();
							if ( el_width > width ) {
								width = el_width;
							}
						});

						if ( w_width < (h_width + width * colNumber) ) {
							$col.css({
								'width': (w_width - h_width - space * 2) / colNumber,
								'clear': 'none'
							});
							$ul.css('width', w_width - h_width - space * 2);
						} else {
							$col.css({
								'width': width,
								'clear': 'none'
							});
							$ul.css('width', (width * colNumber));
						}
					}

					var div_height		= $cont.outerHeight(),
						w_height		= $window.height(),
						cont_offset		= $hCont.offset().top,
						w_scrolltop		= $window.scrollTop(),
						li_offset		= ($cont.closest('.menu-item').offset().top - w_scrolltop),
						li_height		= $cont.closest('.menu-item').outerHeight(),
						left_offset		= $hCont.outerWidth(),
						ul_padding		= parseInt($ul.css('padding-top')),
						sub_nav_margin	= 0,
						translate		= 0;

					if ( $cont.is('.sub-menu-full-width') ) {

						sub_nav_margin = li_offset - cont_offset + w_scrolltop + li_height/2 - div_height/2 - translate;

						if ( (sub_nav_margin + div_height + translate) > (w_height + w_scrolltop - cont_offset - space) ) {
							sub_nav_margin = w_height + w_scrolltop - cont_offset - div_height - translate - space;
						}
						if ( (sub_nav_margin + translate) < - (cont_offset - w_scrolltop - space) ) {
							sub_nav_margin = w_scrolltop - cont_offset - translate + space;
						}

						$cont = $cont.parent();

					} else if ( $cont.hasClass('sub-menu-wide') || $cont.children().hasClass('sub-menu-wide') ) {

						sub_nav_margin = li_offset - cont_offset + w_scrolltop + li_height/2 - div_height/2 - translate;

						if ( (sub_nav_margin + div_height + translate) > (w_height + w_scrolltop - cont_offset - space) ) {
							sub_nav_margin = w_height + w_scrolltop - cont_offset - div_height - translate - space;
						}
						if ( (sub_nav_margin + translate) < - (cont_offset - w_scrolltop - space) ) {
							sub_nav_margin = w_scrolltop - cont_offset - translate + space;
						}

					} else {

						sub_nav_margin = li_offset - cont_offset + w_scrolltop - translate;

						if ( (sub_nav_margin + div_height + translate) > (w_height + w_scrolltop - cont_offset - space) ) {
							sub_nav_margin = w_height + w_scrolltop - cont_offset - div_height - translate - space;
						}
						if ( (sub_nav_margin + translate) < - (cont_offset - w_scrolltop - space) ) {
							sub_nav_margin = w_scrolltop - cont_offset - translate + space;
						}
					}

					$cont.css({
						'left':  left_offset,
						'margin-top': sub_nav_margin
					});
				});

			}
		});


		$('.sub-menu-link').on('hover', function() {
			if ( !$(this).closest('.mega-menu-item').length ) {

				var submenu = $(this).siblings('ul');

				if ( submenu.length ) {
					submenu.removeClass('sub-menu-narrow sub-menu-rev');

					var opposite = $(this).closest('.sub-menu-opposite').length;

					if ( !opposite ) {
						if ( submenu.offset().left + submenu.width() > SCAPE.viewport().width ) {
							submenu.addClass('sub-menu-narrow');

							if ( submenu.offset().left + submenu.width() > SCAPE.viewport().width ) {
								submenu.addClass('sub-menu-rev');
							}
						}
					} else {
						if ( submenu.offset().left < 0 ) {
							submenu.addClass('sub-menu-narrow');

							if ( submenu.offset().left < 0 ) {
								submenu.addClass('sub-menu-rev');
							}
						}
					}
				}
			}
		});
	};


	SCAPE.stickyHeader = function() {
		var $header;

		if ( $('body').hasClass('mobile-header-active') ) {
			$header = $('#header-wrapper-mobile');
		} else {
			$header = $('#header-wrapper');
		}

		if ( !$header.hasClass('header-style-12') && !$header.hasClass('header-style-13') && !$header.hasClass('header-style-14') ) {
			var lastScrollTop	= 0;
			var delta			= 5;
			var header_h		= 0;
			var shift_left		= $header.hasClass('header-boxed') ? '-50%' : '0';

			if ( $header.hasClass('header_sticky_default') ) {
				var	scrolled = SCAPE.scrollTop.get;

				if ( scrolled > 0 ) {
					$header.addClass('header_sticky_active header_sticky_hide_bottombar');
					var shift_top	= 0,
						transform	= SCAPE.propertyPrefix('transform');

					if ( $header.parent().hasClass('header_sticky_no_topbar') && $header.find('.wtbx_hs_topbar').length ) {
						shift_top  += $header.find('.wtbx_hs_topbar').height();
					}

					if ( ($header.hasClass('header-style-3') || $header.hasClass('header-style-4') ) && $header.parent().hasClass('header_sticky_no_bottombar') && $header.find('.wtbx_hs_bottombar').length ) {
						shift_top  += $header.find('.wtbx_hs_bottombar').height();
					}

					$header.css(transform, 'translate3d('+shift_left+',-'+shift_top+'px,0)');
				} else {
					$header.removeClass('header_sticky_active header_sticky_hide_bottombar');
					$header.attr('style','');
				}
			} else if ( $header.hasClass('header_sticky_scroll') ) {
				var st = SCAPE.scrollTop.get;
				var transform	= SCAPE.propertyPrefix('transform');
				lastScrollTop = SCAPE.scrollTop.last;
				header_h = $header.height();

				// If scrolled down and are past the header
				if ( st <= 0 ) {
					$header.removeClass('header_sticky_active header_sticky_scrollup header_sticky_scrolldown header_sticky_hide_bottombar');
					$header.attr('style','');
				} else {
					// Make sure they scroll more than delta
					if(Math.abs(lastScrollTop - st) <= delta) {
						return;
					}

					if ( st > lastScrollTop && st > header_h + 200 ) {
						// Scroll Down
						$header.removeClass('header_sticky_scrollup').addClass('header_sticky_scrolldown header_sticky_hide_bottombar');
						$header.attr('style','');
					} else if ( st > header_h + 200 ) {
						// Scroll Up
						if( st + $(window).height() < $(document).height() ) {
							$header.removeClass('header_sticky_scrolldown').addClass('header_sticky_active header_sticky_scrollup header_sticky_hide_bottombar');

							var shift_top	= 0;

							if ( $header.parent().hasClass('header_sticky_no_topbar') ) {
								shift_top  += $header.find('.wtbx_hs_topbar').outerHeight(true);
							}

							if ( ($header.hasClass('header-style-3') || $header.hasClass('header-style-4') ) && $header.parent().hasClass('header_sticky_no_bottombar') ) {
								shift_top  += $header.find('.wtbx_hs_bottombar').outerHeight(true);
							}

							$header.css(transform, 'translate3d('+shift_left+',-'+shift_top+'px,0)');
						}
					} else {
						if ( !$header.hasClass('header_sticky_scrollup') ) {
							$header.removeClass('header_sticky_active header_sticky_scrollup header_sticky_scrolldown header_sticky_hide_bottombar');
							$header.attr('style','');
						}
					}
				}

				SCAPE.scrollTop.last = st;
			}
		}
	};



	SCAPE.mobileHeader = {

		init: function() {
			var $trigger	= $('.wtbx_mobile_trigger'),
				$close		= $('.wtbx_mobile_backdrop, .wtbx_mobile_close'),
				$header		= $('#mobile-header'),
				$body		= $('body'),
				$nav_wrapper = $('.mobile-nav-wrapper');

			SCAPE.mobileHeader.breakpoint();

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.mobileHeader.breakpoint();
					SCAPE.mobileHeader.width();
				}, SCAPE.timeToWaitForLast, 'mobile_header');
			});

			$trigger.on('click', function() {
				$body.addClass('mobile-header-open');

				if ( $header.hasClass('wtbx_design_slide') ) {
					$header.slideDown(300);

				} else {
					var scrollWidth = $nav_wrapper.width() - $header.width();
					$nav_wrapper.css('right', -scrollWidth + 'px');
				}

				$header.focus();
			});
			$close.on('click', function() {
				$body.removeClass('mobile-header-open');
				if ( $header.hasClass('wtbx_design_slide') ) {
					$header.slideUp(300);
				}
			});
			SCAPE.mobileHeader.submenuReveal();
		},

		width: function() {
			var $header = $('#mobile-header'),
				w_width = SCAPE.viewport().width;

			if ( $header.data('width') <= w_width  ) {
				$header.css('width', '');
			} else {
				$header.css('width', '100%');
			}
		},

		submenuReveal: function() {
			var $mmenu	= $('#mobile-header'),
				$parent		= $mmenu.find('.has-submenu');

			$parent.each(function() {
				var $this		= $(this),
					$child		= $this.find('ul:first'),
					height		= 0;
				$this.children('a').append('<span></span>');

				var $trigger	= $this.children('a').children('span');

				$trigger.on('click', function(e) {
					SCAPE.stopEvent(e);

					if ( !$this.hasClass('expanded') ) {
						$child.children('li').each(function() {
							height += $(this).height();
						});

						$this.addClass('expanded');

						if ( $this.is('.mega-menu-item, menu-item-depth-0') ) {
							$this.find('.menu-item-depth-1.has-submenu').addClass('expanded');
						}

						$child.animate({height: height},300, function() {
							$child.css('height', 'auto');
						});
					} else {
						$child.animate({height: 0 + 'px'},300, function() {
							$this.removeClass('expanded');
						});
						height = 0;
					}
				});
			});

			$parent.children('a').on('click', function(e) {
				if ( $(this).children('span').length && $(this).attr('href') === undefined ) {
					SCAPE.stopEvent(e);
					$(this).children('span').trigger('click');
				}
			});
		},

		breakpoint: function() {
			var $body = $('body'),
				$header_mobile	= $('#header-wrapper-mobile, #mobile-header, .wtbx_mobile_backdrop'),
				width	= $('#site-header').data('width'),
				height	= $('#site-header').data('height');

			if ( (width && SCAPE.viewport().width < width) || (height && SCAPE.viewport().height < height) ) {
				$body.addClass('mobile-header-active');
				$('#header-wrapper').removeClass('header_active');
				$('#wtbx_header_overlay').removeClass('overlay_active');
				$('#wtbx_header_sidearea').removeClass('sidearea_active');
				$('#site-header').removeClass('header_active');
				SCAPE.scrollbar.show();

				$('#mobile-header a').removeAttr('tabindex');
			} else {
				$('body').removeClass('mobile-header-active mobile-header-open');
				$('#mobile-header a').attr('tabindex', -1);
			}
		}
	};



	SCAPE.observeDOM = function() {
		'use strict';
		var MutationObserver = window.MutationObserver || window.WebKitMutationObserver,
			eventListenerSupported = window.addEventListener;

		return function(obj, callback){
			if( MutationObserver ){
				// define a new observer
				var obs = new MutationObserver(function(mutations, observer){
					if( mutations[0].addedNodes.length || mutations[0].removedNodes.length )
						callback();
				});
				// have the observer observe foo for changes in children
				obs.observe( obj, { childList:true, subtree:true });
			}
			else if( eventListenerSupported ){
				obj.addEventListener('DOMNodeInserted', callback, false);
				obj.addEventListener('DOMNodeRemoved', callback, false);
			}
		};
	};



	SCAPE.refreshIsotope = function($container) {
		if ($container.length) {
			if ( $container.hasClass('wtbx-isotope-init') ) {
				$container.isotope('layout');
			}
		}
	};



	SCAPE.prettyLike = function() {
		$('.wtbx-grid').each(function() {
			var fullLabel = false;
			if ( $(this).hasClass('wtbx-grid-magazine') ) {
				fullLabel = true;
			}

			if ( fullLabel ) {
				$(this).find('.sl-button .sl-count').each(function() {
					var count = $(this).text();
					count = parseInt(count);
					switch (count) {
						case 1:
							count += ' ' + simpleLikes.likes_single;
							break;
						default:
							count += ' ' + simpleLikes.likes_plural
					}
					$(this).text(count);
				});
			}
		});

		$('.wtbx-like-wrapper .sl-count').each(function() {
			var count = $(this).text();
			count = parseInt(count);
			switch (count) {
				case 0:
					count = '';
					break;
				case 1:
					count += ' ' + simpleLikes.likes_single;
					break;
				default:
					count += ' ' + simpleLikes.likes_plural
			}
			$(this).text(count);
		});

	};



	SCAPE.entryIsVisible = function($el) {
		var $lazyImage	= $el.find('.wtbx-entry-media .wtbx-lazy'),
			scrollTop	= SCAPE.scrollTop.get,
			screenH		= SCAPE.viewport().height,
			offsetTop	= $el.offset().top;

		if ( $lazyImage.length ) {
			if ( (scrollTop + screenH) >= offsetTop && $lazyImage.hasClass('wtbx-lazyloaded') ) {
				return true;
			} else {
				return false;
			}
		} else {
			if ( (scrollTop + screenH) >= offsetTop ) {
				return true;
			} else {
				return false;
			}
		}
	};



	SCAPE.revealId = {};



	SCAPE.entryReveal = function(el) {

		var elClass		= 'wtbx-element-reveal',
			revealClass	= 'wtbx-element-visible',
			$el;

		if ( el === undefined ) {
			$el = $('.'+elClass+':not(.'+revealClass+')');
		} else {
			$el = $(el);
		}

		$el.each(function() {
			var $this	= $(this);

			var timerId = setInterval(function() {
				SCAPE.revealId[timerId] = timerId;
				if ( !$this.hasClass(revealClass) ) {
					if ( $this.closest('.wtbx-grid').length ) {
						$this.addClass('wtbx_to_be_revealed');

						if ( $this.closest('.wtbx-grid').find('.wtbx_vc_row').length ) {
							$this.addClass(revealClass);
						}
					} else {
						if ( $this.find('.wtbx-lazy').hasClass('wtbx-lazyloaded') ) {
							$this.addClass(revealClass);
							$this.closest('.wtbx-grid-entry, .wtbx_preloader_cont').find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
						}
						if ( $this.closest('.slick-slider').length || $this.closest('.flickity-enabled').length ) {
							if ( $this.closest('.slick-slider').hasClass('slick-initialized') && $this.hasClass('wtbx-reveal-cont') ) {
								setTimeout(function() {
									$this.addClass(revealClass);
									$(window).trigger('resize');
								});
							}

							if ( $this.closest('.flickity-enabled').length ) {
								SCAPE.debounce($this.closest('.flickity-enabled').flickity('resize'), 250);
							}
						} else {
							if ( $this.hasClass('wtbx-reveal-cont') ) {
								setTimeout(function() {
									$this.addClass(revealClass);
									$this.closest('.wtbx-grid-entry, .wtbx_preloader_cont').find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
									if ( $this.closest('.wtbx_with_image').hasClass('wtbx_to_be_animated') ) {
										$this.closest('.wtbx_with_image').addClass('wtbx_animated');
									}
								});
							}
						}

						if ( $this.closest('.flickity-enabled').length && $this.closest('.flickity-enabled').data('flickity') ) {
							$this.closest('.flickity-enabled').flickity('resize');
						}
					}
				} else {
					SCAPE.imageCascade.layout();
					SCAPE.beforeAfter($this.closest('.wtbx_before_after_inner'));
					clearInterval(timerId);
				}
			},100);
		});
	};



	SCAPE.hidePreloader = function() {
		$(document).on('wtbx_hide_preloader', '.wtbx-preloader-wrapper', function() {
			var $this = $(this);
			setTimeout(function() {
				$this.addClass('preloader-display-none');
			},500);
		});
	};



	SCAPE.revealNoLazy = function() {
		var elClass		= 'wtbx-element-reveal',
			revealClass	= 'wtbx-element-visible',
			$el = $('.'+elClass+':not(.'+revealClass+')');

		$el.each(function() {
			var $this = $(this);
			if ( $this.find('.wtbx-nolazy').length || !$this.find('.wtbx-lazy').length ) {
				if ( !$(this).closest('.wtbx-grid-entry').length ) {
					$this.addClass(revealClass);
					$this.closest('.wtbx-grid-entry, .wtbx_preloader_cont').children('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
					if ( $this.hasClass('wtbx-reveal-cont') ) {
						$this.addClass(revealClass);
					}
				}
			}
		});
	};



	SCAPE.scrolling = false;



	SCAPE.waypoints = function($el, direction) {
		if ( !$el ) {
			$el = $('.wtbx_appearance_animation');
		}
		var waypoints = $el.waypoint(function(direction) {
			var $this = undefined === $(this.element)[0] ? $(this) : $(this.element);

			// if ( SCAPE.scrolling === false ) {
			if ( $this.closest('.wtbx-grid').length ) {
				
				if ( $this.closest('.wtbx-grid-entry').css('display') === 'none' ) {
					$this.addClass('wtbx_to_be_animated_when_visible');
				} else {
					$this.addClass('wtbx_to_be_animated');
				}

				if ( !$this.find('.wtbx-lazy').length ) {
					$this.addClass('wtbx_to_be_revealed');
				}

				var gridReveal = setInterval(function() {
					var grid = $this.closest('.wtbx-grid');
					var notRevealed = grid.find('.wtbx-element-reveal.wtbx_to_be_revealed');
					var toBeAnimated = grid.find('.wtbx-element-reveal.wtbx_to_be_animated');

					if ( notRevealed.length > 0 ) {
						toBeAnimated.each(function(index) {
							var $item = $(this);
							if ( grid.data('seq') == '1' ) {
								$item.addClass('wtbx-element-visible');
								$item.closest('.wtbx-grid-entry, .wtbx_preloader_cont').find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
								SCAPE.refreshIsotope($this.closest('.wtbx-grid'));
							} else {
								setTimeout(function() {
									$item.addClass('wtbx-element-visible');
									$item.closest('.wtbx-grid-entry, .wtbx_preloader_cont').find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
									SCAPE.refreshIsotope($this.closest('.wtbx-grid'));
								}, index * 150);
							}
						});
						if ( !grid.find('.wtbx_to_be_animated:not(.wtbx-element-visible)').length ) {
							clearInterval(gridReveal);
						}
					}

				}, 100);
			} else {
				$this.addClass('wtbx_to_be_animated');
			}

			if ( !$this.find('.wtbx-element-reveal .wtbx-lazy').length || $this.find('.wtbx-element-reveal').hasClass('wtbx-element-visible') || $this.hasClass('wtbx_vc_content_box') ) {
				$this.addClass('wtbx_animated');
			}

			if ( $this.hasClass('wtbx_vc_split_text') ) {
				SCAPE.splitText.trigger($this);
			}

			if ( $this.hasClass('wtbx_vc_pie') && $this.is(':visible') ) {
				SCAPE.pie.trigger($this);
			}
			// }

		}, {
			offset: '100%'
		});
	};


	SCAPE.atvHover = function() {
		if ( !SCAPE.isMobile() ) {
			$(document).unbind('.mousemove.atvHover').on('mousemove.atvHover', '.wtbx-rollhover', function(e) {
				var $el = $(this),
					elHeight = $el.outerHeight(),
					elWidth = $el.outerWidth(),
					itemCenterX = elWidth / 2,
					itemCenterY = elHeight / 2,
					xPos = e.pageX - $el.offset().left - itemCenterX,
					yPos = e.pageY - $el.offset().top - itemCenterY,
					scale = 1.02,
					maxRotate = 8,
					maxTranslate = 1,
					transitionDuration = 0;

				var bdst = $('body').scrollTop() || $('html').scrollTop(),
					bdsl = $('body').scrollLeft(),
					pageX = e.pageX,
					pageY = e.pageY,
					elem = $($el)[0],
					offsets = elem.getBoundingClientRect(),
					w = elem.clientWidth || elem.offsetWidth || elem.scrollWidth, // width
					h = elem.clientHeight || elem.offsetHeight || elem.scrollHeight, // height
					wMultiple = Math.min($el.width(), $el.height())/2/w,
					offsetX = 0.52 - (pageX - offsets.left - bdsl)/w, //cursor position X
					offsetY = 0.52 - (pageY - offsets.top - bdst)/h, //cursor position Y
					dy = (pageY - offsets.top - bdst) - h / 2, //@h/2 = center of container
					dx = (pageX - offsets.left - bdsl) - w / 2, //@w/2 = center of container
					yRotate = (offsetX - dx)*(0.07 * wMultiple), //rotation for container Y
					xRotate = (dy - offsetY)*(0.1 * wMultiple); //rotation for container X

				function getValue(pos, size, max) {
					return pos / size * max;
				}

				function getLayerFactor(layer) {
					if (layer == 0) {
						return 0;
					}
					return .1 * (1 - Math.pow(.85, Math.abs(layer)));
				}

				if ( !$el.hasClass('wtbx-rollhover-static') ) {
					$el.css({
						'transform': 'translate3d(' + -1 * (getValue(xPos, elWidth, maxTranslate)) + 'px, ' + -1 * (getValue(yPos, elHeight, maxTranslate)) + 'px, 0) rotateX(' + getValue(yPos, elHeight, maxRotate) + 'deg) rotateY(' + -1 * getValue(xPos, elHeight, maxRotate) + 'deg)'
					});
				}

				$el.mouseleave(function() {
					var $el = $(this);
					$el.css({
						'transform': '',
						'transition-duration': ''
					});

					$el.find('.wtbx-rollhover-layer').css({
						'transform': '',
						'transition-duration': ''
					});

					$el.closest('.wtbx-rollhover-container').css({
						'transform': ''
					});

					$el.closest('.wtbx-rollhover-container').removeClass('wtbx-hover');

				}).mouseenter(function() {
					$el.closest('.wtbx-rollhover-container').addClass('wtbx-hover');
				});

				var revNum = $el.find('.wtbx-rollhover-layer').length,
					totalLayers = $el.find('.wtbx-rollhover-layer').length;
				$el.find('.wtbx-rollhover-layer').each(function(index) {
					var layer = parseInt($(this).data("layer")) > 0 ? parseInt($(this).data("layer")) : index+1,
						factor = getLayerFactor(layer),
						ly = index;

					$(this).css({
						'transform': 'translate3d('+ factor*(getValue(xPos, itemCenterX, itemCenterX)) +'px, '+ factor*(getValue(yPos, itemCenterY, itemCenterY)) +'px,0)'
					});
					revNum--;
				});

				$el.closest('.wtbx-rollhover-container').css({
					'transform': 'scale3d('+scale+','+scale+',1)'
				});
			});
		}

	};



	SCAPE.scrollDown = function() {
		var $button = $('.wtbx-scrolldown-button');

		$button.on(SCAPE.click, function() {

			var $page	= $('#page-wrap'),
				offset	= $page.offset().top - SCAPE.headerOffset($page),
				speed	= .8,
				time	= Math.abs(SCAPE.scrollTop.get - offset) / speed;

			$('html, body').animate({scrollTop: offset}, time);
		});
	};



	SCAPE.headerOffset = function($el) {
		var $wrapper	= $('#site-header'),
			$header		= $('#header-wrapper'),
			$header_m	= $('#header-wrapper-mobile'),
			scrolled	= SCAPE.scrollTop.get,
			newScroll	= $el.offset().top,
			offset	= 0;

		if ( $('body').hasClass('mobile-header-active') ) {
			$header = $header_m;
		}

		if ( $header.hasClass('header_sticky_scroll') ) {
			if ( newScroll <= 0 ) {
				if ( $('body').hasClass('mobile-header-active') ) {
					offset += $header_m.outerHeight();
				} else {
					if ( !isNaN(parseInt(wtbxHeaderHeights.main_def)) ) {
						offset += parseInt(wtbxHeaderHeights.main_def);
					}
					if ( !$wrapper.hasClass('header_sticky_no_topbar') && !isNaN(parseInt(wtbxHeaderHeights.topbar)) && $header.find('.wtbx_hs_topbar').length ) {
						offset += $header.find('.wtbx_hs_topbar').outerHeight();
					}
					if ( !$wrapper.hasClass('header_sticky_no_bottombar') && !isNaN(parseInt(wtbxHeaderHeights.bottombar)) && $header.find('.wtbx_hs_bottombar').length ) {
						offset += $header.find('.wtbx_hs_bottombar').outerHeight();
					}
				}
			} else if ( newScroll < scrolled ) {
				if ( $('body').hasClass('mobile-header-active') ) {
					offset += $header_m.outerHeight();
				} else {
					if (!isNaN(parseInt(wtbxHeaderHeights.main_sticky))) {
						offset += parseInt(wtbxHeaderHeights.main_sticky);
					}
					if (!$wrapper.hasClass('header_sticky_no_topbar') && !isNaN(parseInt(wtbxHeaderHeights.topbar)) && $header.find('.wtbx_hs_topbar').length) {
						offset += $header.find('.wtbx_hs_topbar').outerHeight();
					}
					if (!$wrapper.hasClass('header_sticky_no_bottombar') && !isNaN(parseInt(wtbxHeaderHeights.bottombar)) && $header.find('.wtbx_hs_bottombar').length) {
						offset += $header.find('.wtbx_hs_bottombar').outerHeight();
					}
				}
			}
		} else if ( $header.hasClass('header_sticky_default') ) {
			if ( newScroll > 0 ) {
				if ( $('body').hasClass('mobile-header-active') ) {
					offset += $header_m.outerHeight();
				} else {
					if (!isNaN(parseInt(wtbxHeaderHeights.main_sticky))) {
						offset += parseInt(wtbxHeaderHeights.main_sticky);
					}
					if (!$wrapper.hasClass('header_sticky_no_topbar') && !isNaN(parseInt(wtbxHeaderHeights.topbar)) && $header.find('.wtbx_hs_topbar').length) {
						offset += $header.find('.wtbx_hs_topbar').outerHeight();
					}
					if (!$wrapper.hasClass('header_sticky_no_bottombar') && !isNaN(parseInt(wtbxHeaderHeights.bottombar)) && $header.find('.wtbx_hs_bottombar').length) {
						offset += $header.find('.wtbx_hs_bottombar').outerHeight();
					}
				}
			}
		}

		return offset;
	};



	SCAPE.bottomNav = function() {
		$('.wtbx-navigation-wrapper.wtbx-layout-sticky').appendTo('.wtbx_bottom_navigation');
	};

	SCAPE.bottomNav();



	SCAPE.filterGrid = {

		filter: function($container) {
			var $filter = $container.parent().prev('.wtbx-filter');
			if ( $filter.length ) {
				var $active	= $filter.find('.wtbx-filter-button.active'),
					$button	= $filter.find('.wtbx-filter-button'),
					prefix	= $container.data('filter-prefix'),
					$item	= $container.find('.wtbx-grid-entry'),
					useHash	= $filter.data('hash'),
					showAll	= $filter.hasClass('filter-minimal') || $filter.hasClass('filter-slider');
				if ( !$filter.hasClass('filter-init') ) {
					var hashValue = SCAPE.filterGrid.filterHash($container, $filter);
					var	fDefault;

					if ( useHash && undefined !== hashValue && false !== hashValue ) {
						fDefault = hashValue.split(',');
					} else {
						fDefault = JSON.parse($filter.attr('data-default'));
					}

					var filterDefault = [];
					if ( showAll && $.type(fDefault) === 'array' ) {
						filterDefault = fDefault;
					} else {
						filterDefault[0] = fDefault;
					}
					var filterArray = [];
					for (var i=0; i<filterDefault.length; i++) {
						var	$defButton = $button.filter('[data-filter="'+filterDefault[i]+'"]');
						if ($defButton.length) {
							$defButton.addClass('active');
							filterArray[i] = filterDefault[i] === '*' ? '*' : '.' + prefix + '-' + filterDefault[i];
						} else if ( !$filter.hasClass('filter-multi') ) {
							$button.eq(0).addClass('active');
							filterArray[i] = '.' + prefix + '-' + $button.eq(0).data('filter');
						}
						if ( $filter.hasClass('filter-slider') ) {
							SCAPE.filterGrid.filterKnob($filter, $defButton);
							setTimeout(function() {
								$filter.find('.knob').removeClass('hidden');
							},500);
							$(window).resize(function() {
								SCAPE.waitForFinalEvent( function() {
									SCAPE.filterGrid.filterKnob($filter, $button.filter('.active'));
								}, SCAPE.timeToWaitForLast, 'filterKnob');
							});
						}
					}
					var filterOp = $filter.data('operator') === 'and' ? '' : ', ';
					var filterValue = filterArray.join(filterOp);
					filterValue = (filterValue === '' || !$item.filter(filterValue).length ) ? '*' : filterValue;
					if ( $container.closest('.blog-boxed').length ) {
						$item.filter(filterValue).removeClass('hidden').appendTo($container);
						$item.not(filterValue).addClass('hidden').detach();
					} else {
						$container.isotope({ filter: filterValue });
					}
					SCAPE.filterGrid.filterHideShow($container);
					SCAPE.filterGrid.filterHashUpdate(useHash, $container, $button);
					$filter.addClass('filter-init');

					setTimeout(function() {
						if ('undefined' !== typeof SCAPE.isotopeMasonry) {
							SCAPE.isotopeMasonry.layout($container);
						}
						if ('undefined' !== typeof SCAPE.isotopeMetro) {
							SCAPE.isotopeMetro.layout($container);
						}
					});
				}
				$button.unbind().on('click', function() {
					var $this		= $(this),
						filterValue	= $this.attr('data-filter') === '*' ? '*' : '.' + prefix + '-' + $this.attr('data-filter'),
						filters		= [],
						$oldButton	= $filter.find('.wtbx-filter-button.active') || $filter.find('.show-all');
					if ( !$filter.hasClass('filter-multi') ) {
						if ( $this.is('.active') ) {
							return false;
						} else {
							if ( $filter.hasClass('filter-slider') ) {
								SCAPE.filterGrid.filterKnob($filter, $this);
							}
							$oldButton.removeClass('active');
							$this.addClass('active');
						}
					} else {
						if ( !$this.is('.active') ) { $this.addClass('active');}
						else { $this.removeClass('active'); }
						$button.filter('.active').each(function() {
							var value = $(this).attr('data-filter') === '*' ? '*' : '.' + prefix + '-' + $(this).attr('data-filter');
							filters.push(value);
						});
						var filterOp = $filter.data('operator') === 'and' ? '' : ', ';
						filterValue = filters.join(filterOp);
					}
					filterValue = (filterValue === '' || !$item.filter(filterValue).length ) ? '*' : filterValue;
					$container.addClass('wtbx_overflow');
					$item.removeClass('hidden');
					$item.removeClass('filtered');
					$item.removeClass('unveiled');
					$item.addClass('filtering');
					setTimeout(function() {
						if ( $container.closest('.blog-boxed').length ) {
							$item.filter(filterValue).removeClass('hidden').appendTo($container);
							$item.not(filterValue).addClass('hidden').detach();
						} else {
							$container.isotope({ filter: filterValue });
						}
						SCAPE.filterGrid.filterHashUpdate(useHash, $container, $button);
						$item.filter(filterValue).each(function(index) {
							var $that = $(this);
							$that.addClass('filtered');
							$that.find('.wtbx_to_be_animated_when_visible').addClass('wtbx_to_be_animated').closest('.wtbx-grid-entry, .wtbx_preloader_cont').find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
							setTimeout(function() {
								$that.removeClass('filtered').addClass('unveiled');
							}, (index+1) * 100);
						});
						$filter.trigger('touchstart');
					},500);
				});
			}
		},

		filterHashUpdate: function(useHash, $container, $button) {
			var id = $container.data('id');
			if ( useHash && history.pushState ) {
				var hashFilterValues = [];
				$button.each(function(index) {
					if ($(this).is('.active:visible')) {
						hashFilterValues.push($(this).data('filter'));
					}
				});

				hashFilterValues = hashFilterValues.join();

				if ( hashFilterValues.length && hashFilterValues !== '*' ) {
					hashFilterValues = '?filter=' + hashFilterValues;

				} else {
					hashFilterValues = window.location.pathname;
				}
				history.pushState(null, null, hashFilterValues);
			}
		},

		filterKnob: function($filter, $button) {
			if ( $filter.find('.knob').length && $filter.hasClass('filter-slider')) {
				var $knob		= $filter.find('.knob'),
					newLeft		= Math.floor($button.position().left + Number($button.css('margin-left').replace('px',''))),
					newTop		= Math.floor($button.position().top + Number($button.css('margin-top').replace('px',''))),
					newIndex	= $button.index(),
					newWidth	= Math.floor($filter.find('.wtbx-filter-button').eq(newIndex).outerWidth());
				$knob.css({ 'width': newWidth });
				SCAPE.transform($knob[0], 'translate3d('+newLeft+'px,'+newTop+'px,0)');
			}
		},

		filterHideShow: function($container) {
			var $filter = $container.parent().prev('.wtbx-filter');
			if ( $filter.length ) {
				var $button = $filter.find('.wtbx-filter-button'),
					prefix = $container.data('filter-prefix'),
					$item = $container.find('.wtbx-grid-entry');

				$button.each(function() {
					if ( $(this).attr('data-filter') !== '*' ) {
						var value = '.' + prefix + '-' + $(this).attr('data-filter');
						if ( !$container.find(value).length ) {
							$(this).hide();
						} else {
							$(this).show();
						}
					}
				});
			}
		},

		filterHash: function($container, $filter) {
			var url		= window.location.href;

			var match,
				pl     = /\+/g,  // Regex for replacing addition symbol with a space
				search = /([^&=]+)=?([^&]*)/g,
				decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
				query  = window.location.search.substring(1);

			var urlParams = {};
			while (match = search.exec(query)) {
				urlParams[decode(match[1])] = decode(match[2]);
			}

			if ( !$filter.length ) {
				return false;
			} else if ( undefined !== urlParams['filter'] ) {
				var id, filter;

				id = urlParams['grid'];

				filter = urlParams['filter'];

				return filter;

			} else {
				return false;
			}
		}
	};



	SCAPE.revealNoImage = function($el) {
		if ( !$('body').hasClass('wtbx-smartimages-off') ) {
			$el.each(function() {
				if ( !$(this).find('.wtbx-lazy').length && !$(this).closest('.wtbx-grid').length ) {
					$(this).find('.wtbx-element-reveal:not(.wtbx-element-visible)').addClass('wtbx-element-visible');
					$(this).closest('.wtbx-grid-entry, .wtbx_preloader_cont').children('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
				}
			});
		}
	};



	SCAPE.isotopeGrid = {

		init: function($container) {
			$($container).each(function(){
				$container = $(this);
				SCAPE.isotopeGrid.setup($container);
			});
		},

		setup: function($container) {
			if ( $container.find('.wtbx_grid_entry').length ) {
				SCAPE.isotopeGrid.layout($container);
				$(window).on('resize', function(){
					SCAPE.isotopeGrid.layout($container);
				});
			}
		},

		layout: function($container) {
			var $item	= $container.find('.wtbx_grid_entry');
			var gutter	= $container.data('gutter') || 0;
			var width	= $container.outerWidth();
			var columns	= $container.data('columns');
			var border	= $container.data('border') || 0;
			var type	= $container.data('grid');
			var layout_cols = $container.data('layout-cols') || columns;
			var column_width, layout;

			var paddingH	= gutter;

			if ( width - Math.min(paddingH,15) * 2 < 400 ) {
				gutter		= Math.min(gutter,15);
				paddingH	= gutter;
			}

			if ( type === 'metro' ) {

				layout = 'packery';

				$item.each(function() {
					var tile_width = $(this).data('width'),
						tile_height = $(this).data('height'),
						col_width, item_width, item_height;

					if ( width < 360 ) {
						item_width	= width - gutter * 2;
						item_height	= width - gutter * 2;
						$container.find('.wtbx_hide_responsive').hide();
					} else if (width < 640) {
						layout_cols = Math.min(2,layout_cols);
						item_width = item_height = ( width - (layout_cols - 1) * gutter - paddingH * 2 ) / layout_cols;
						$container.find('.wtbx_hide_responsive').hide();
					} else {
						col_width	= Math.floor(( width - gutter * ( layout_cols - 1 ) - paddingH * 2 ) / layout_cols);
						item_width	= col_width * tile_width + gutter *  ( tile_width - 1 );
						item_height	= col_width * tile_height + gutter * ( tile_height - 1 );
						$container.find('.wtbx_hide_responsive').show();
					}

					$(this).css({
						width: item_width + 'px',
						height: item_height + 'px'
					});
				});

			} else {
				layout = 'masonry';

				if (width < 500) {
					columns = 1;
				} else if (width < 850) {
					columns = Math.min(2,columns);
				}

				column_width = ( width - (columns - 1) * gutter - paddingH * 2 ) / columns;
				$item.css({
					'width': column_width + 'px',
					'margin-bottom': gutter + 'px'
				});
			}


			$container.css({
				'padding': '0 ' + gutter + 'px'
			});

			$container.isotope({
				itemSelector : '.wtbx_grid_entry',
				resizable : false,
				layoutMode : layout,
				masonry: {
					gutter: gutter
				},
				packery: {
					gutter: gutter
				},
				transitionDuration: '0s',
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				}
			});

			$container.addClass('wtbx-isotope-init');

		}

	};



	SCAPE.isotopeMasonry = {

		init: function($container) {
			$($container).each(function(){
				$container = $(this);
				SCAPE.isotopeMasonry.setup($container);
				SCAPE.isotopeMasonry.lazyScroll($container);
				$(window).scroll(function() {
					SCAPE.isotopeMasonry.lazyScroll($container);
				});

				if ( $container.siblings('.filter-sidebar').length ) {
					setTimeout(function() {
						SCAPE.isotopeMasonry.layout($container);
					},1000);
				}
			});
		},

		getOptions: function($container) {
			var objName = 'wtbx_masonry_';
			return window[objName + $container.data('id')];
		},

		setup: function($container) {
			if ( $container.find('.wtbx-masonry-entry').length ) {
				$(window).on('resize', function(){
					SCAPE.waitForFinalEvent( function() {
						SCAPE.isotopeMasonry.layout($container);
					}, SCAPE.timeToWaitForLast, 'portfolioMasonry');
				});
				$container.parent().children('.wtbx-loadmore-container').find('.wtbx-loadmore').on(SCAPE.click, function() {
					if ( SCAPE.isotopeMasonry.loadBusy === false ) {
						SCAPE.isotopeMasonry.loadPosts($container);
						var $button = $(this),
							$loader = $button.find('.wtbx-loadmore-loader');
						$loader.css({
							height	: $button.height(),
							width	: $button.height()
						});
						setTimeout(function() {
							$button.addClass('wtbx-loadmore-loading');
						});
						setTimeout(function() {
							SCAPE.transitionEvent() && $loader.one(SCAPE.transitionEvent(), function(e) {
								$loader.addClass('loading-animate');
							});
						},600);
					}
				});
				SCAPE.revealNoImage($container.find('.wtbx-masonry-entry'));
				SCAPE.isotopeMasonry.layout($container);
			}
		},

		layout: function($container) {
			var $item		= $container.find('.wtbx-masonry-entry');
			var gutter		= $container.data('gutter') || 0;
			var paddingH	= 0,
				paddingV	= 0,
				min_width	= $container.data('minwidth') || 0;

			var breakpoint1 = min_width > 0 ? min_width*2 : 650,
				breakpoint2 = min_width > 0 ? min_width*3 : 1000,
				breakpoint3 = min_width > 0 ? min_width*4 : 1300,
				breakpoint4 = min_width > 0 ? min_width*6 : 1600;

			if ( $item.hasClass('portfolio-entry') ) {
				if ( $container.hasClass('wtbx-grid-metro') || $container.hasClass('wtbx-grid-boxed') ) {
					paddingH = gutter;
				}
			}

			var width	= $container.outerWidth();
			var columns	= $container.data('columns');
			var animate	= $container.data('animate');
			var border	= $container.data('border') || 0;

			if (width - paddingH*2 < breakpoint1) {
				columns = 1;
			} else if (width - paddingH*2 < breakpoint2) {
				columns = Math.min(2,columns);
			} else if (width - paddingH*2 < breakpoint3) {
				columns = Math.min(3,columns);
			} else if (width - paddingH*2 < breakpoint4) {
				columns = Math.min(4,columns);
			}

			var column_width = Math.floor((width - ( gutter * (columns-1) ) - paddingH*2 ) / columns);

			if ( $item.hasClass('portfolio-entry') ) {
				var margin = gutter;

				if ( width - Math.min(paddingH,15) * 2 < 500 && !$container.hasClass('wtbx-grid-boxed') ) {
					gutter		= Math.min(gutter,15);
					paddingH	= gutter;
				}

				column_width = Math.floor((width - ( gutter * (columns-1) ) - paddingH*2 ) / columns);

				$container.css({
					'padding': '0 ' + paddingH + 'px'
				});
				$container.parent().children('.wtbx-pagination').find('.wtbx-pagination-inner').css({
					'padding': '0 ' + paddingH + 'px'
				});
				$item.css({
					'margin-bottom': margin + 'px'
				});
				$item.find('.portfolio-masonry-inner, .portfolio-thumbnail, .portfolio-masonry-overlay').css({
					'border-radius': border + 'px',
					'overflow': 'hidden'
				});

				var padding_top = $container.parent('.wtbx-grid-wrapper').prev('.wtbx-filter').length ? Math.min(15,gutter) : gutter;
				$container.css({'padding-top': padding_top + 'px'});
			}

			if ( $container.hasClass('wtbx-grid-masonry') ) {
				$item.css({
					'margin-bottom': gutter + 'px'
				});
			}

			$item.css({
				'width': column_width + 'px'
			});

			$container.isotope({
				itemSelector : '.wtbx-masonry-entry',
				layoutMode: 'masonry',
				masonry: {
					gutter: gutter
				},
				transitionDuration: animate,
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				}
			});

			$container.find('.post-gallery').each(function() {
				if ( !$(this).hasClass('slick-slider') ) {
					SCAPE.initPostMedia.gallery($(this), false);
					$(this).slick('slickGoTo', 0);
				}
			});

			SCAPE.customCursor.bindClick($container.find('.wtbx-arrow'));
			SCAPE.customCursor.bindClick($container.find('.slick-dots li'));

			$container.addClass('wtbx-isotope-init');

			$container.find('.wtbx-entry-inner').css({ 'border-radius': border + 'px' });

			$container.on('arrangeComplete', function() {
				setTimeout(function() {
					$container.removeClass('wtbx_overflow');
				},300);

			});
			SCAPE.filterGrid.filter($container);

		},

		loadBusy: false,

		limit: function($container) {
			var limit		= parseInt($container.data('limit')),
				allowLoad	= true;
			if ( limit > 0 && limit >= SCAPE.isotopeMasonry.getOptions($container).current_page ) {
				allowLoad = false;
			}
			return allowLoad;
		},

		loadPosts: function($container) {
			SCAPE.isotopeMasonry.loadBusy = true;
			var gridType = $container.data('grid');
			var data = {};

			if ( gridType === 'blog' ) {
				data = {
					'action'		: 'loadmore_blog_masonry',
					'wpnonce'		: SCAPE.isotopeMasonry.getOptions($container).wpnonce,
					'query'			: SCAPE.isotopeMasonry.getOptions($container).query,
					'page'			: SCAPE.isotopeMasonry.getOptions($container).current_page,
					'preview'		: SCAPE.isotopeMasonry.getOptions($container).preview,
					'post_opacity'	: SCAPE.isotopeMasonry.getOptions($container).post_opacity,
					'excerpt'		: SCAPE.isotopeMasonry.getOptions($container).excerpt,
					'aspect_ratio'	: SCAPE.isotopeMasonry.getOptions($container).aspect_ratio,
					'animation'		: SCAPE.isotopeMasonry.getOptions($container).animation,
					'meta_array'	: SCAPE.isotopeMasonry.getOptions($container).meta_array,
					'meta_class'	: SCAPE.isotopeMasonry.getOptions($container).meta_class,
					'post_overlay'	: SCAPE.isotopeMasonry.getOptions($container).post_overlay
				};
			} else if ( gridType === 'portfolio' ) {
				if ( $container.hasClass('wtbx-grid-masonry') ) {
					data = {
						'action'			: 'loadmore_portfolio_masonry',
						'wpnonce'			: SCAPE.isotopeMasonry.getOptions($container).wpnonce,
						'query'				: SCAPE.isotopeMasonry.getOptions($container).query,
						'page'				: SCAPE.isotopeMasonry.getOptions($container).current_page,
						'aspect_ratio'		: SCAPE.isotopeMasonry.getOptions($container).aspect_ratio,
						'animation'			: SCAPE.isotopeMasonry.getOptions($container).animation,
						'overlay_content'	: SCAPE.isotopeMasonry.getOptions($container).overlay_content,
						'meta_primary'		: SCAPE.isotopeMasonry.getOptions($container).meta_primary,
						'meta_secondary'	: SCAPE.isotopeMasonry.getOptions($container).meta_secondary,
						'alignment'         : SCAPE.isotopeMasonry.getOptions($container).alignment,
						'overlay_trigger'   : SCAPE.isotopeMasonry.getOptions($container).overlay_trigger,
						'like'              : SCAPE.isotopeMasonry.getOptions($container).like,
						'overlay_mobile'    : SCAPE.isotopeMasonry.getOptions($container).overlay_mobile,
						'click_action'    	: SCAPE.isotopeMasonry.getOptions($container).click_action,
						'overlay_idle'                          : SCAPE.isotopeMasonry.getOptions($container).overlay_idle,
						'overlay_hover'                         : SCAPE.isotopeMasonry.getOptions($container).overlay_hover,
						'meta_primary_hover'                    : SCAPE.isotopeMasonry.getOptions($container).meta_primary_hover,
						'meta_secondary_hover'                  : SCAPE.isotopeMasonry.getOptions($container).meta_secondary_hover,
						'action_button_link'                    : SCAPE.isotopeMasonry.getOptions($container).action_button_link,
						'action_button_gallery_all'             : SCAPE.isotopeMasonry.getOptions($container).action_button_gallery_all,
						'action_button_gallery_item'            : SCAPE.isotopeMasonry.getOptions($container).action_button_gallery_item,
						'caption_primary'   : SCAPE.isotopeMasonry.getOptions($container).caption_primary,
						'caption_secondary'	: SCAPE.isotopeMasonry.getOptions($container).caption_secondary,
						'share'				: SCAPE.isotopeMasonry.getOptions($container).share,
						'loadmore'          : SCAPE.isotopeMasonry.getOptions($container).loadmore
					};
				} else if ( $container.hasClass('wtbx-grid-boxed') ) {
					data = {
						'action'			: 'loadmore_portfolio_boxed',
						'wpnonce'			: SCAPE.isotopeMasonry.getOptions($container).wpnonce,
						'query'				: SCAPE.isotopeMasonry.getOptions($container).query,
						'page'				: SCAPE.isotopeMasonry.getOptions($container).current_page,
						'portfolio_opacity'	: SCAPE.isotopeMasonry.getOptions($container).portfolio_opacity,
						'aspect_ratio'		: SCAPE.isotopeMasonry.getOptions($container).aspect_ratio,
						'animation'			: SCAPE.isotopeMasonry.getOptions($container).animation,
						'overlay_content'	: SCAPE.isotopeMasonry.getOptions($container).overlay_content,
						'meta_primary'		: SCAPE.isotopeMasonry.getOptions($container).meta_primary,
						'meta_secondary'	: SCAPE.isotopeMasonry.getOptions($container).meta_secondary,
						'alignment'         : SCAPE.isotopeMasonry.getOptions($container).alignment,
						'overlay_trigger'   : SCAPE.isotopeMasonry.getOptions($container).overlay_trigger,
						'like'              : SCAPE.isotopeMasonry.getOptions($container).like,
						'overlay_mobile'    : SCAPE.isotopeMasonry.getOptions($container).overlay_mobile,
						'click_action'    	: SCAPE.isotopeMasonry.getOptions($container).click_action,
						'overlay_idle'                          : SCAPE.isotopeMasonry.getOptions($container).overlay_idle,
						'overlay_hover'                         : SCAPE.isotopeMasonry.getOptions($container).overlay_hover,
						'meta_primary_hover'                    : SCAPE.isotopeMasonry.getOptions($container).meta_primary_hover,
						'meta_secondary_hover'                  : SCAPE.isotopeMasonry.getOptions($container).meta_secondary_hover,
						'action_button_link'                    : SCAPE.isotopeMasonry.getOptions($container).action_button_link,
						'action_button_gallery_all'             : SCAPE.isotopeMasonry.getOptions($container).action_button_gallery_all,
						'action_button_gallery_item'            : SCAPE.isotopeMasonry.getOptions($container).action_button_gallery_item,
						'caption_primary'   : SCAPE.isotopeMasonry.getOptions($container).caption_primary,
						'caption_secondary'	: SCAPE.isotopeMasonry.getOptions($container).caption_secondary,
						'share'				: SCAPE.isotopeMasonry.getOptions($container).share,
						'loadmore'          : SCAPE.isotopeMasonry.getOptions($container).loadmore
					};
				} else if ( $container.hasClass('wtbx-grid-square') ) {
					data = {
						'action'			: 'loadmore_portfolio_square',
						'wpnonce'			: SCAPE.isotopeMasonry.getOptions($container).wpnonce,
						'query'				: SCAPE.isotopeMasonry.getOptions($container).query,
						'page'				: SCAPE.isotopeMasonry.getOptions($container).current_page,
						'aspect_ratio'		: SCAPE.isotopeMasonry.getOptions($container).aspect_ratio,
						'animation'			: SCAPE.isotopeMasonry.getOptions($container).animation,
						'border'			: SCAPE.isotopeMasonry.getOptions($container).border,
						'overlay_content'	: SCAPE.isotopeMasonry.getOptions($container).overlay_content,
						'meta_primary'		: SCAPE.isotopeMasonry.getOptions($container).meta_primary,
						'meta_secondary'	: SCAPE.isotopeMasonry.getOptions($container).meta_secondary,
						'alignment'         : SCAPE.isotopeMasonry.getOptions($container).alignment,
						'overlay_trigger'   : SCAPE.isotopeMasonry.getOptions($container).overlay_trigger,
						'like'              : SCAPE.isotopeMasonry.getOptions($container).like,
						'overlay_mobile'    : SCAPE.isotopeMasonry.getOptions($container).overlay_mobile,
						'click_action'    	: SCAPE.isotopeMasonry.getOptions($container).click_action,
						'caption_primary'   : SCAPE.isotopeMasonry.getOptions($container).caption_primary,
						'caption_secondary'	: SCAPE.isotopeMasonry.getOptions($container).caption_secondary,
						'share'				: SCAPE.isotopeMasonry.getOptions($container).share,
						'loadmore'          : SCAPE.isotopeMasonry.getOptions($container).loadmore
					};
				} else if ( $container.hasClass('wtbx-grid-tiles') ) {
					data = {
						'action'			: 'loadmore_portfolio_tiles',
						'wpnonce'			: SCAPE.isotopeMasonry.getOptions($container).wpnonce,
						'query'				: SCAPE.isotopeMasonry.getOptions($container).query,
						'page'				: SCAPE.isotopeMasonry.getOptions($container).current_page,
						'aspect_ratio'		: SCAPE.isotopeMasonry.getOptions($container).aspect_ratio,
						'animation'			: SCAPE.isotopeMasonry.getOptions($container).animation,
						'border'			: SCAPE.isotopeMasonry.getOptions($container).border,
						'overlay_content'	: SCAPE.isotopeMasonry.getOptions($container).overlay_content,
						'meta_primary'		: SCAPE.isotopeMasonry.getOptions($container).meta_primary,
						'meta_secondary'	: SCAPE.isotopeMasonry.getOptions($container).meta_secondary,
						'alignment'         : SCAPE.isotopeMasonry.getOptions($container).alignment,
						'overlay_trigger'   : SCAPE.isotopeMasonry.getOptions($container).overlay_trigger,
						'like'              : SCAPE.isotopeMasonry.getOptions($container).like,
						'overlay_mobile'    : SCAPE.isotopeMasonry.getOptions($container).overlay_mobile,
						'click_action'    	: SCAPE.isotopeMasonry.getOptions($container).click_action,
						'caption_primary'   : SCAPE.isotopeMasonry.getOptions($container).caption_primary,
						'caption_secondary'	: SCAPE.isotopeMasonry.getOptions($container).caption_secondary,
						'share'				: SCAPE.isotopeMasonry.getOptions($container).share,
						'loadmore'          : SCAPE.isotopeMasonry.getOptions($container).loadmore
					};
				}
			}

			$.ajax({
				url		: SCAPE.isotopeMasonry.getOptions($container).ajaxurl,
				data	: data,
				type	: 'POST',
				success	: function(data){
					if( data ) {
						var $loadmore = $container.parent().children('.wtbx-loadmore-container');
						$loadmore.removeClass('loadmore-visible');

						$container.addClass('wtbx_overflow');

						// Process and insert new posts
						setTimeout(function() {
							$loadmore.find('.wtbx-loadmore').removeClass('wtbx-loadmore-loading');
							$loadmore.find('.wtbx-loadmore-loader').removeClass('loading-animate');
							$loadmore.find('.wtbx-loadmore-loader').css({
								height	: $loadmore.find('.wtbx-loadmore').outerHeight(),
								width	: $loadmore.find('.wtbx-loadmore').outerWidth()
							});

							data = $.trim(data);
							data = $.parseHTML(data);
							$container.append(data);
							$container.isotope('appended', data);

							// Initiate media in newly loaded posts
							$container.find('.post-gallery').each(function() {
								if ( !$(this).hasClass('slick-slider') ) {
									SCAPE.initPostMedia.gallery($(this), false);
									$(this).slick('slickGoTo', 0);
								}
							});

							SCAPE.customCursor.bindClick($container.find('.wtbx-arrow'));
							SCAPE.customCursor.bindClick($container.find('.slick-dots li'));

							// Reveal posts
							SCAPE.revealNoImage($container.find('.wtbx-masonry-entry'));

							// Update filter
							SCAPE.filterGrid.filterHideShow($container);

							// Reattach filter
							SCAPE.filterGrid.filter($container);
							SCAPE.filterGrid.filterKnob($container.closest('.filter-slider').find('.wtbx-filter'), $container.closest('.filter-slider').find('.wtbx-filter-button').filter('.active'));

							// Prettify like button
							SCAPE.prettyLike();

							// Reinit hover effect
							SCAPE.atvHover();

							SCAPE.isotopeMasonry.layout($container);

							SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));

							SCAPE.isotopeMasonry.getOptions($container).current_page++;

							var allLoadedTimer = setInterval(function() {
								if ( !$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
									SCAPE.isotopeMasonry.loadBusy = false;
									SCAPE.isotopeMasonry.lazyScroll($container);
									clearInterval(allLoadedTimer);
								}
							}, 200);

						}, 300);

					}
				}
			});
		},

		updateLayout: function($container) {

			// Initiate media in newly loaded posts
			$container.find('.post-gallery').each(function() {
				if ( !$(this).hasClass('slick-slider') ) {
					SCAPE.initPostMedia.gallery($(this), false);
					$(this).slick('slickGoTo', 0);
				}
			});

			SCAPE.customCursor.bindClick($container.find('.wtbx-arrow'));
			SCAPE.customCursor.bindClick($container.find('.slick-dots li'));

			// Reveal posts
			SCAPE.revealNoImage($container.find('.wtbx-masonry-entry'));

			// Update filter
			SCAPE.filterGrid.filterHideShow($container);

			// Reattach filter
			SCAPE.filterGrid.filter($container);

			// Prettify like button
			SCAPE.prettyLike();

			// Reinit hover effect
			SCAPE.atvHover();

			SCAPE.isotopeMasonry.layout($container);

			SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));

			var allLoadedTimer = setInterval(function() {
				if ( $container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
					SCAPE.isotopeMasonry.loadBusy = false;
					SCAPE.isotopeMasonry.lazyScroll($container);
					clearInterval(allLoadedTimer);
				}
			}, 200);
		},

		lazyScroll: function($container) {
			if ( SCAPE.isotopeMasonry.getOptions($container) ) {
				if ( SCAPE.isotopeMasonry.getOptions($container).loadmore !== '' ) {
					if ( SCAPE.isotopeMasonry.getOptions($container).max_pages > SCAPE.isotopeMasonry.getOptions($container).current_page && SCAPE.isotopeMasonry.limit($container) ) {
						if ( SCAPE.isotopeMasonry.loadBusy === false ) {
							var pages		= SCAPE.isotopeMasonry.getOptions($container).current_page,
								loadmore	= SCAPE.isotopeMasonry.getOptions($container).loadmore;

							if ( pages % loadmore === 0 ) {
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							} else {
								$container.parent().children('.wtbx-loadmore-container').removeClass('loadmore-visible');

								var scrollTop		= SCAPE.scrollTop.get,
									windowH			= SCAPE.viewport().height,
									containerTop	= $container.offset().top,
									containerH		= $container.outerHeight();

								if ( scrollTop + windowH > containerTop + containerH ) {
									SCAPE.isotopeMasonry.loadPosts($container);
								}
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				} else {
					if ( SCAPE.isotopeMasonry.getOptions($container).max_pages > SCAPE.isotopeMasonry.getOptions($container).current_page && SCAPE.isotopeMasonry.limit($container) ) {
						if (SCAPE.isotopeMasonry.loadBusy === false) {
							var scrollTop		= SCAPE.scrollTop.get,
								windowH			= SCAPE.viewport().height,
								containerTop	= $container.offset().top,
								containerH		= $container.outerHeight();
							if ( scrollTop + windowH > containerTop + containerH ) {
								SCAPE.isotopeMasonry.loadPosts($container);
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				}
			}
		}
	};



	SCAPE.relatedPosts = function() {
		var $container		= $('.wtbx-related-posts-wrapper'),
			autoplaySpeed	= $container.data('autoplay'),
			autoplay		= false,
			infinite		= false;

		if ( $container.length ) {
			if ( autoplaySpeed > 0 ) {
				infinite = true;
				autoplaySpeed *= 1000;
				autoplay = true;
			}


			var slickOptions = {
				slidesToShow: 6,
				slidesToScroll: 1,
				swipeToSlide: true,
				speed: 700,
				autoplay: autoplay,
				autoplaySpeed: autoplaySpeed,
				infinite: infinite,
				adaptiveHeight: true,
				useTransform: true,
				cssEase: 'cubic-bezier(0.6, 0, 0.2, 1)',
				dots: false,
				arrows: false,
				respondTo: 'slider',
				responsive: [{
					breakpoint: 1400,
					settings: {
						slidesToShow: 4
					}
				}, {
					breakpoint: 950,
					settings: {
						slidesToShow: 3
					}
				}, {
					breakpoint: 700,
					settings: {
						slidesToShow: 2
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: 1
					}
				}]
			};
			$container.slick(slickOptions);
		}

	};



	SCAPE.breakpoints = {
		mobile: 767,
		tablet: 991
	};



	SCAPE.click = 'click touchend';



	SCAPE.stickyElement = function($el, offset) {
		$el.each(function($el) {
			$el = $(this);

			var breakpoint = $el.hasClass('side-meta') ? 640 : SCAPE.breakpoints.tablet;

			if ( $el.hasClass('wtbx_disable_scroll_tablet_landscape') ) { breakpoint = 1024; }
			if ( $el.hasClass('wtbx_disable_scroll_tablet_portrait') ) { breakpoint = 991; }
			if ( $el.hasClass('wtbx_disable_scroll_mobile_landscape') ) { breakpoint = 767; }
			if ( $el.hasClass('wtbx_disable_scroll_mobile_portrait') ) { breakpoint = 479; }

			if ( $el.hasClass('wtbx_vc_column') && $el.parent().hasClass('vc_vc_column') ) {
				$el.removeClass('wtbx-sticky');
				$el.parent().addClass('wtbx-sticky');
			}

			var $header = $('#header-wrapper'),
				header_height = 0,
				sidebar_offset = 0;

			if ($header.hasClass('header_sticky_default') || $header.hasClass('header_sticky_scroll')) {
				header_height = $header.height();

				if ($header.parent().hasClass('header_sticky_no_bottombar') && $header.find('.wtbx_hs_bottombar').length ) {
					header_height -= $header.find('.wtbx_hs_bottombar').height();
				}
				if ($header.parent().hasClass('header_sticky_no_topbar') && $header.find('.wtbx_hs_topbar').length ) {
					header_height -= $header.find('.wtbx_hs_topbar').height();
				}
			}

			if ($el.children('.page-sidebar').length) {
				sidebar_offset = $el.children('.page-sidebar').css('padding-top').replace('px', '');
			}

			if (SCAPE.viewport().width > breakpoint) {
				var offsetTop = Math.min($el.offset().top, header_height + offset) - sidebar_offset;
				$el.stick_in_parent({
					offset_top: offsetTop,
					bottoming: true
				});
			}

			$(window).resize(function () {
				SCAPE.waitForFinalEvent(function () {
					if (SCAPE.viewport().width > breakpoint) {
						var offsetTop = Math.min($el.offset().top, header_height + offset) - sidebar_offset;
						$el.stick_in_parent({
							offset_top: offsetTop,
							bottoming: true
						});
					} else {
						$el.trigger("sticky_kit:detach");
					}
					$(document.body).trigger("sticky_kit:recalc");
				}, SCAPE.timeToWaitForLast, 'sticky_element');
			});
		});
	};



	SCAPE.portfolioSingle = {

		slider: function($container) {
			if ( $container.length) {

				var slickOptions = {
					slidesToShow	: 1,
					slidesToScroll	: 1,
					touchThreshold	: 8,
					speed			: 700,
					infinite		: true,
					useTransform	: true,
					cssEase			: 'cubic-bezier(0.6, 0, 0.2, 1)',
					prevArrow		: '<div class="wtbx-arrow wtbx-prev"></div>',
					nextArrow		: '<div class="wtbx-arrow wtbx-next"></div>',
					dots			: true
				};
				$container.slick(slickOptions);
			}

			SCAPE.customCursor.bindClick($container.find('.wtbx-arrow'));
			SCAPE.customCursor.bindClick($container.find('.slick-dots li'));

		},

		masonry: function($container) {
			if ( $container.length) {

				var layout = function() {

					if ( $container.closest('.container-fullwidth').length ) {
						$container.parent().css({
							'padding': '0 ' + gutter + 'px'
						});
					}
					var padding = gutter;
					var width	= $container.width();
					var columns	= $container.data('columns');
					if (width < 500) {
						columns = 1;
					} else if (width < 850) {
						columns = Math.min(2,columns);
					} else if (width < 1100) {
						columns = Math.min(3,columns);
					}

					var column_width = Math.floor( (width - ( gutter * (columns+1) ) ) / columns );

					$item.css('margin-bottom', gutter + 'px');
					$item.css('width', column_width + 'px');
					$container.css('padding', '0 ' + gutter + 'px')
				};

				var $item	= $container.find('.portfolio-image-wrapper');
				var gutter	= $container.data('gutter') || 0;

				layout();

				$container.isotope({
					itemSelector : '.wtbx-masonry-entry',
					resizable : true,
					layoutMode : 'masonry',
					masonry: {
						gutter: gutter
					},
					hiddenStyle: {
						opacity: 0
					},
					visibleStyle: {
						opacity: 1
					}
				});

				$container.addClass('wtbx-isotope-init');

				$(window).resize(function() {
					SCAPE.waitForFinalEvent( function() {
						layout();
					}, SCAPE.timeToWaitForLast, 'portfolio_single_masonry');
				});

			}
		}

	};




	SCAPE.sliderPagination = function($slider, index, slideCount) {
		var $pagination	= $slider.siblings('.wtbx_slider_pagination');

		var slides_desktop, slides_tablet, slides_mobile, slides,
			width = SCAPE.viewport().width;

		slides_desktop	= $slider.data('slides-desktop');
		slides_desktop	= isNaN(parseInt(slides_desktop)) ? 1 : slides_desktop;
		slides_tablet	= $slider.data('slides-tablet') || slides_desktop;
		slides_mobile	= $slider.data('slides-mobile') || slides_tablet || slides_desktop;

		if ( width < 768 ) {
			slides = slides_mobile;
		} else if ( width < 1025 ) {
			slides = slides_tablet;
		} else {
			slides = slides_desktop;
		}
		slides = Math.ceil(slideCount / parseInt(slides));

		$pagination.find('.wtbx_pagination_total').html('<span class="wtbx_pagination_separator">/</span>' + slides);

		if ( $pagination.find('ul li').length !== $slider.find('.wtbx_dots .dot').length ) {
			$pagination.find('ul li').remove();
			$.each($slider.find('.wtbx_dots .dot'), function(index) {
				$('<li>' + (index+1) + '</li>').appendTo($pagination.find('ul'));
			});
		}

		var $dot = $pagination.find('li');

		$dot.removeClass('wtbx_dot_active wtbx_dot_prev wtbx_dot_next');
		$dot.eq(index).addClass('wtbx_dot_active');
		$dot.eq(index-1).addClass('wtbx_dot_prev');

		if ( $dot.eq(index+1).length ) {
			$dot.eq(index+1).addClass('wtbx_dot_next');
		} else {
			$dot.eq(0).addClass('wtbx_dot_next');
		}

		if ( $dot.eq(index-1).length ) {
			$dot.eq(index-1).addClass('wtbx_dot_prev');
		} else {
			$dot.eq($dot.length).addClass('wtbx_dot_prev');
		}

	};



	SCAPE.postLike = function() {
		$(document).on('click', '.sl-button', function(e) {
			SCAPE.stopEvent(e);
			var button		= $(this);
			var post_id		= button.attr('data-post-id');
			var security	= button.attr('data-nonce');
			var iscomment	= button.attr('data-iscomment');
			var allbuttons;
			var heart		= button.find('i');
			var inner		= button.children('*');
			if ( iscomment === '1' ) { /* Comments can have same id */
				allbuttons	= $('.sl-comment-button-'+post_id);
			} else {
				allbuttons	= $('.sl-button-'+post_id);
			}
			var loader		= allbuttons.next('#sl-loader');
			if (post_id !== '') {
				$.ajax({
					type: 'POST',
					url: simpleLikes.ajaxurl,
					data : {
						action : 'process_simple_like',
						post_id : post_id,
						nonce : security,
						is_comment : iscomment
					},
					beforeSend:function(){
						button.addClass('loading');
					},
					success: function(response){
						var icon = response.icon;
						var count = response.count;
						count = count == 1 ? count + ' ' + simpleLikes.likes_single : count + ' ' +  simpleLikes.likes_plural;
						if ( button.closest('.blog-metro, .blog-masonry, .blog-carousel, .blog-minimal, .blog-boxed, .portfolio-masonry, .portfolio-metro, .portfolio-panels, .portfolio-square, .portfolio-tiles, .wtbx_recent_posts_cont, .header-section-meta-block').length ) {
							count = parseInt(count);
							if (isNaN(count)) {
								count = 0;
							}
						}

						if ( button.closest('.wtbx-like-wrapper').length && parseInt(count) === 0 ) {
							count = '';
						}

						count = '<span class="sl-count like-count">' + count + '</span>';
						var like_text = '';

						if(response.status === 'unliked') {
							like_text = simpleLikes.like;
							allbuttons.removeClass('liked');
						} else {
							like_text = simpleLikes.unlike;
							allbuttons.addClass('liked');
						}

						allbuttons.each(function() {
							if ( !$(this).hasClass('filled') ) {
								$(this).html(icon+count);
								$(this).prop('title', like_text);
							} else {
								$(this).find('.sl-count').html(count);
								$(this).siblings('.wtbx-like-label').find('.wtbx-like-label-prefix').text(like_text);
							}
						});

						button.removeClass('loading');
					}
				});

			}
			return false;
		});
	};



	SCAPE.fullscreen = function() {
		var $elFullheight = $('.wtbx-fullscreen-h'),
			$elFullwidth = $('.wtbx-fullscreen-w'),
			scrHeight = SCAPE.viewport().height,
			scrWidth = SCAPE.viewport().width;

		// height
		$elFullheight.each(function() {
			$(this).css('height', scrHeight);
		});

		// width
		$elFullwidth.each(function() {
			$(this).css('width', scrHeight);
		});
	};




	SCAPE.woocommerce = {

		thumbnails: function() {

			$('.woocommerce-product-gallery').each(function() {
				var $container = $(this),
					$thumbnails	= $container.find('.thumbnails'),
					$mainImg	= $container.find('.woocommerce-main-image'),
					$mainSlider = $container.find('.product-main-image');

				if ( $thumbnails.length ) {
					// add thumbnail images to main image slider

					$thumbnails.find('.thumb-wrapper').each(function() {
						$(this).clone().appendTo($mainSlider).find('a').addClass('wtbx-lightbox-item');
					});

					$mainSlider.find('.thumb-wrapper:first').clone().addClass('active').prependTo($thumbnails).find('.wtbx-lightbox-item').removeClass('wtbx-lightbox-item').addClass('thumb-image').end().find('.wtbx-preloader-wrapper').remove();

					$thumbnails.find('.thumb-fullsize').remove();

					$mainSlider.slick({
						speed			: 400,
						slidesToShow	: 1,
						slidesToScroll	: 1,
						swipeToSlide	: true,
						infinite		: false,
						autoplay		: false,
						touchThreshold	: 8,
						adaptiveHeight	: true,
						useTransform	: true,
						draggable		: false,
						dots			: false,
						arrows			: false,
						swipe			: false,
						cssEase			: 'cubic-bezier(0.6, 0, 0.2, 1)'
					});

					// change main image on thumbnail click
					$thumbnails.find('.thumb-wrapper').on(SCAPE.click, function() {
						$thumbnails.find('.thumb-wrapper').removeClass('active');
						$(this).addClass('active');
						$mainSlider.slick('slickGoTo', $(this).index());
					});

				}

				// image zoom
				$mainSlider.find('.thumb-wrapper')
					.on('mouseenter', function() {
						$(this).addClass('active');
						$(this).find('.thumb-fullsize').css('opacity', '1')
					})
					.on('mouseleave', function() {
						var $this = $(this);
						$this.removeClass('active');
						$this.find('.thumb-fullsize').css('opacity', '0');
						setTimeout(function() {
							if ( !$this.hasClass('active') ) {
								$this.find('.thumb-fullsize').attr('style', '')
							}
						}, 500);
					})
					.on('mousemove', function(e) {
						var $el		= $(this),
							$full	= $el.find('.thumb-fullsize'),
							xPos	= (e.pageX - $el.offset().left) / $el.width() * ($full.width() - $el.width()),
							yPos	= (e.pageY - $el.offset().top) / $el.height() * ($full.width() - $el.width());

						var transform = SCAPE.propertyPrefix('transform');
						$full.css(transform, 'translate3d(-'+xPos+'px,-'+yPos+'px,0)');
					});

				$container.addClass('initialized');
			});

		},


		tabDecoration: function() {
			var $tabs = $('.product-tabs');
			if ( $tabs.length && !$('#container').hasClass('sidebar_left') && !$('#container').hasClass('sidebar_left_sticky') && !$('#container').hasClass('sidebar_right') && !$('#container').hasClass('sidebar_right_sticky') ) {
				var windowW		= SCAPE.viewport().width,
					$liFirst	= $tabs.find('li:first-child'),
					$liLast		= $tabs.find('li:last-child');

				var $before		= $liFirst.find('.before');
				var	$after		= $liLast.find('.after');

				var totalW		= 0;

				$tabs.find('li .tab-inner').each(function() {
					totalW += $(this).outerWidth(true) + 45;
				});

				if ( windowW > totalW + 30 ) {
					$tabs.removeClass('no-decoration');
					if ( !$before.length ) {
						$liFirst.append('<span class="tab-decor before"></span>');
						$before		= $liFirst.find('.before');
					}
					if ( !$after.length ) {
						$liLast.append('<span class="tab-decor after"></span>');
						$after		= $liLast.find('.after');
					}

					var beforePos	= $liFirst.offset().left + 50;
					var afterPos	= windowW - $after.offset().left + 50;

					$before.css({ width: beforePos + 'px' });
					$after.css({ width: afterPos + 'px' });
				} else {
					$tabs.addClass('no-decoration');
				}
			}
		}

	};



	SCAPE.mouseWheelHandler = {

		add: function(el, handler) {
			if (el.addEventListener) {
				el.addEventListener("mousewheel", handler, false);
				el.addEventListener("wheel", handler, false)
			} else {
				el.attachEvent("onmousewheel", handler)
			}
		},

		remove: function(el, handler) {
			if (el.addEventListener) {
				el.removeEventListener('mousewheel', handler, false);
				el.removeEventListener('wheel', handler, false)
			} else {
				el.detachEvent("onmousewheel", handler)
			}
		}

	};



	SCAPE.verticalAlign = function() {
		setTimeout(function() {
			$('.wtbx-valign-cont').each(function() {
				var $container	= $(this),
					breakpoint	= $container.data('breakpoint'),
					maxH		= 0;
				if ( SCAPE.viewport().width > SCAPE.breakpoints.mobile ) {
					$container.find('.wtbx-valign-element').each(function() {
						$(this).removeAttr('style');
						var currH	= $(this).outerHeight();
						if ( currH > maxH ) {
							maxH = currH + parseInt($(this).parent().css('padding-top')) + parseInt($(this).parent().css('padding-bottom'));
						}
					});
					$container.children().css({ 'min-height': maxH, 'height': maxH });
				} else {
					$(this).children().removeAttr('style');
				}
				$container.addClass('wtbx-valigned');
			});
		}, 100);
	};



	SCAPE.exp_list = (function() {
		var $list_item = $('.wtbx_vc_exp_list_item');

		$list_item.each(function() {
			var	$trigger			= $(this).find('.wtbx_exp_list_title_wrapper'),
				$content_wrapper	= $(this).find('.wtbx_exp_list_content_wrapper');

			$trigger.on('click', function() {
				$content_wrapper.slideToggle(400);
				$(this).closest('.wtbx_vc_exp_list_item').toggleClass('active').parent().toggleClass('active');
			});
		});
	}());



	SCAPE.counter = {

		count: function($el) {

			$el.each(function(){

				var $this = $(this);
				var $settings = {
					delay: $this.data('delay'),
					time: $this.data('time')
				};

				var countUp = function() {
					var nums = [];
					var divisions = $settings.time / $settings.delay;
					var num = $this.attr('data-to');
					var from = parseInt($this.attr('data-from'));
					var isComma = /[0-9]+,[0-9]+/.test(num);
					var isSpace = /[0-9]+ [0-9]+/.test(num);
					num = num.replace(/,/g, '');
					num = num.replace(/ /g, '');
					var isInt = /^[0-9]+$/.test(num);
					var isFloat = /^[0-9]+\.[0-9]+$/.test(num);
					var decimalPlaces = isFloat ? (num.split('.')[1] || []).length : 0;

					// Generate list of incremental numbers to display
					for (var i = divisions; i >= 1; i--) {

						// Preserve as int if input was int
						var newNum = parseInt((num - from) / divisions * i + from);

						// Preserve float if input was float
						if (isFloat) {
							newNum = parseFloat((num - from) / divisions * i + from).toFixed(decimalPlaces);
						}

						// Preserve commas if input had commas
						if (isComma) {
							while (/(\d+)(\d{3})/.test(newNum.toString())) {
								newNum = newNum.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
							}
						}

						// Preserve spaces if input had spaces
						if (isSpace) {
							while (/(\d+)(\d{3})/.test(newNum.toString())) {
								newNum = newNum.toString().replace(/(\d+)(\d{3})/, '$1'+' '+'$2');
							}
						}

						nums.unshift(newNum);
					}

					$this.data('counterup-nums', nums);

					// Updates the number until we're done
					var f = function() {
						if ( $this.data('counterup-nums') ) {
							$this.text($this.data('counterup-nums').shift());
							if ($this.data('counterup-nums').length) {
								setTimeout($this.data('counterup-func'), $settings.delay);
							} else {
								delete $this.data('counterup-nums');
								$this.data('counterup-nums', null);
								$this.data('counterup-func', null);
							}
						}
					};
					$this.data('counterup-func', f);

					// Start the count up
					setTimeout($this.data('counterup-func'), $settings.delay);

					$el.addClass('init');
				};

				// Perform counts when the element gets into view
				$this.waypoint({
					handler: countUp,
					offset: 'bottom-in-view',
					triggerOnce: true
				});

			});

		},

		init: function() {
			SCAPE.counter.count($('.wtbx_counter_number'));
		}

	};



	SCAPE.equalHeightEl = {

		init: function() {
			SCAPE.equalHeightEl.calculate();

			setTimeout(function() {
				if ( $(this).find('.vc_line-chart').length ) {
					$('.vc_line-chart:visible').vcLineChart({reload:!1});
				}
				if ( $(this).find('.vc_pie_chart').length ) {
					jQuery(".vc_pie_chart:not(.vc_ready)").vcChat();
				}
			}, 500);

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.equalHeightEl.calculate();
				}, SCAPE.timeToWaitForLast, 'equal_height_el');
			});
		},

		calculate: function() {
			var el				= '.wtbx_equal_height',
				viewport_width	= SCAPE.viewport().width;
			$('.wtbx_vc_row').each(function() {
				if ( $(this).find(el).length ) {
					var $row = $(this),
						max_height	= 0,
						height		= 0,
						container = '.wtbx_equal_height_cont';
					$(this).find(el).each(function() {
						var $this = $(this);

						if ( viewport_width > $this.data('equal') ) {
							if ( $this.hasClass('wtbx_vc_content_box') ) {
								var height = $this.find('.wtbx_content_box_content').height() + parseInt($this.find('.wtbx_content_box_container').css('padding-top')) + parseInt($this.find('.wtbx_content_box_container').css('padding-bottom'));
							} else if ( ($this.hasClass('wtbx_vc_team_member') && $this.hasClass('wtbx_style_1')) || ($this.hasClass('wtbx_vc_team_member') && $this.hasClass('wtbx_style_2')) || ($this.hasClass('wtbx_vc_team_member') && $this.hasClass('wtbx_style_3'))  ) {
								height = $this.find('figure').height() + parseInt($this.find('figure').css('padding-top')) + parseInt($this.find('figure').css('padding-bottom'));
							}
							if ( height > max_height ) max_height = height;
						}
					});

					$row.find(el).each(function() {
						var newHeight = '';

						if ( viewport_width > $(this).data('equal') ) {
							newHeight = max_height;
						}
						$(this).find(container).css('height', newHeight);
						$(this).addClass('wtbx_equal_height_init');
					});

				}
			})
		}

	};



	SCAPE.imageCascade = {

		init: function() {
			setTimeout(function() {
				SCAPE.imageCascade.layout();
			});

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.imageCascade.layout();
				}, SCAPE.timeToWaitForLast, 'image_cascade');
			});
		},

		layout: function() {

			$('.wtbx_vc_image_cascade').each(function() {
				var maxHeight = 0;
				$(this).find('.wtbx_image_wrapper').each(function() {
					var height = $(this).outerHeight();
					if ( height > maxHeight ) {
						maxHeight = height;
					}
				});

				$(this).find('.wtbx_image_cascade_inner').css('height', maxHeight);
			})
		}

	};



	SCAPE.countdown = function() {
		$('.wtbx_countdown_wrapper').each(function() {
			var event	= $(this).data('event'),
				format	= $(this).data('format');

			$(this).countdown(event)
				.on('update.countdown', function(event) {
					$(this).html(event.strftime(format));
				})
				.on('finish.countdown', function(event) {
					var insert = $(format);
					insert.find('.wtbx_countdown_block span').html('0');
					insert.find('.wtbx_countdown_time').html('00');
					$(this).html(insert);
				});
			;
		});
	};



	SCAPE.imageBox = {
		init: function() {
			SCAPE.imageBox.svg();
			SCAPE.imageBox.height();
			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.imageBox.height();
				}, SCAPE.timeToWaitForLast, 'image_box');
			});
		},

		svg : function() {
			$('.wtbx_vc_image_box.wtbx_style_1').find('svg').on(SCAPE.click, function() {
				$(this).closest('.wtbx_image').find('.wtbx_image_overlay').trigger('click');
			});
			$('.wtbx_vc_image_box.wtbx_style_1').find('path').on(SCAPE.click, function(e) {
				SCAPE.stopEvent(e);
			})
		},

		height: function() {
			$('.wtbx_vc_image_box.wtbx_style_2').each(function() {
				if ( SCAPE.viewport().width > 767 ) {
					var content_h	= parseInt($(this).find('.wtbx_image_box_content').outerHeight()) + $(this).find('.wtbx_image_box_content').position().top,
						image_h		= $(this).find('.wtbx_image').height(),
						maxHeight	= Math.max(content_h, image_h);
					$(this).find('.wtbx_image_inner').css('height', maxHeight + 'px');
				} else {
					$(this).find('.wtbx_image_inner').css('height', '');
				}
			});
		}
	};


	SCAPE.imageBox.init();

	SCAPE.autoFillFix = function($input) {
		if (!$input.val()) {
			var style = window.getComputedStyle($input[0]);
			if (style.animationName !== 'autofill') {
				return false;
			}
		}
		$input.addClass('wtbx_not_empty');
		return true;
	};


	SCAPE.forms = function() {
		$('.cf-minimal .wpcf7-form').find('input[type="text"],input[type="tel"],input[type="number"],input[type="email"],input[type="password"], input[type="url"], input[type="date"], textarea, select').each(function() {
			if ( $(this).hasClass('wpcf7-quiz') ) {
				$(this).closest('label').addClass('wtbx_field_cont');
			} else {
				var $wrap		= $(this).closest('.wpcf7-form-control-wrap'),
					$input		= $(this),
					$cont		= $wrap.parent(),
					$label		= $cont.find('label[for="'+$input.attr('name')+'"]') || $cont.find('label');

				if ( !$label.length && !$input.hasClass('wpcf7-bwsgooglecaptcha') ) {
					$cont.addClass('wtbx_field_cont wtbx_field_nolabel');
				} else if ( !$input.hasClass('wpcf7-bwsgooglecaptcha') ) {
					$cont.addClass('wtbx_field_cont');
					$input.after($label);
				}

				if ( $input.is('select:not([multiple])') ) {
					$wrap.addClass('wtbx_select_wrap');
				}

				if ( $input.val() !== '' || $input.find(':selected').length ) {
					$input.addClass('wtbx_not_empty');
				} else {
					$input.removeClass('wtbx_not_empty');
				}

				$input.on('change input', function() {
					if ( $input.val() !== '' || $input.find(':selected').length ) {
						$input.addClass('wtbx_not_empty');
					} else {
						$input.removeClass('wtbx_not_empty');
					}
				});

				$input.closest('.wtbx_field_cont').addClass('wtbx_field_init');
			}
		});

		$('.wpcf7-list-item').each(function() {
			$(this).find('.wpcf7-list-item-label').on('click', function(e) {
				var $input = $(this).closest('.wpcf7-list-item').find('input');

				if ( !$input.closest('label').length ) {
					$input.trigger('click');
				}
			});
		});

		$('.wpcf7-acceptance').each(function() {
			var $input = $(this).find('input');
			$input.after('<label class="wpcf7-list-item-label" for="'+ $input.attr('name') +'"></label>').closest('.wpcf7-form-control-wrap').addClass('wtbx_acceptance');
			$input.next('label').on('click', function() {
				$input.trigger('click');
			});
		});

		$('select:not([multiple]):not(.wtbx_for_custom_dropdown):not(#rating):not(.select2-hidden-accessible)').wrap('<span class="wtbx-select"></span>');

		$('.wtbx_login_modal_trigger').on('click', function (e) {
			var $this = $(this);
			if (	SCAPE.viewport().width >= $this.next('.wtbx_login_modal').find('.wtbx_login_modal_wrapper').width() &&
					SCAPE.viewport().height >= $this.next('.wtbx_login_modal').find('.wtbx_login_modal_wrapper').height() ) {
				SCAPE.stopEvent(e);
				$this.next('.wtbx_login_modal').addClass('active');

				SCAPE.bindEscape('login_popup', function() {
					$this.next('.wtbx_login_modal').removeClass('active');
				});

				$this.next('.wtbx_login_modal').find('.wtbx_login_modal_close').on('click', function() {
					$('.wtbx_login_modal_backdrop').trigger('click');
				})
			}
		});

		$('.wtbx_login_modal_backdrop').on('click', function() {
			$(this).closest('.wtbx_login_modal').removeClass('active');
			$(document).off('keyup.login_popup');
		});

	};



	SCAPE.cartWidget = function() {

		$('.header_cart_wrapper').each(function() {
			var $button		= $(this),
				$dropdown	= $button.find('.header_cart_widget');

			$(this).on('mouseenter', function() {
				if ( !$(this).hasClass('active') ) {
					if ( $button.offset().left + $button.outerWidth(true) - 5 < $dropdown.outerWidth() ) {
						if ( $button.offset().left + $dropdown.outerWidth() + 10 < SCAPE.viewport().width ) {
							$dropdown.addClass('dropdown_opposite');
							$(this).addClass('active');
						}
					} else {
						$dropdown.removeClass('dropdown_opposite');
						$(this).addClass('active');
					}
				}
			}).on('mouseleave', function() {
				if ( $(this).hasClass('active') ) {
					$(this).removeClass('active');
				}
			})
		});
	};

	SCAPE.cartWidget();



	SCAPE.splitText = {

		init: function() {
		},

		trigger: function($el) {
			if ( !$el ) {
				$el = $('.wtbx_vc_split_text');
			}
			$el.find('.wtbx_split_text_wrapper').each(function(index) {
				var $this = $(this),
					delay = $this.data('delay');
				setTimeout(function() {
					$this.addClass('wtbx_split_animated');
				}, index * 200 + delay );
			});
		}

	};



	SCAPE.pie = {

		init: function() {
			$(window).on('wtbx_hide', function(e, $el) {
				var $pie = $($el).find('.wtbx_pie_cont');

				var val			= 0,
					ratio		= parseFloat($pie.data('ratio')),
					$circle		= $pie.find('svg .bar');

				var r = $circle.attr('r');

				var c = Math.PI*(r*2);

				if (val < 0) { val = 0;}
				if (val > 100) { val = 100;}

				var pct = - c - (val / 100) * c;

				$pie.find('svg .bar').css({ strokeDashoffset: pct});
				$pie.find('.wtbx_pie_value div').addClass('counted').text(0);
				SCAPE.pie.counted = true;
				clearInterval(SCAPE.pie.timer);
			});
		},

		counted: false,

		timer: '',

		trigger: function($el) {
			setTimeout(function() {
				$el.find('.wtbx_pie_cont').each(function() {

					var val			= parseFloat($(this).data('value')),
						label		= parseFloat($(this).data('label')),
						ratio		= parseFloat($(this).data('ratio')),
						duration	= parseInt($(this).data('duration')),
						$value		= $(this).find('.wtbx_pie_value div'),
						$circle		= $(this).find('svg .bar');

					if ( !$value.hasClass('counted') ) {

						var counted = false;

						var r = $circle.attr('r');
						var c = Math.PI*(r*2);

						if (val < 0) { val = 0;}
						if (val > 100) { val = 100;}

						var pct = - c - (val / 100) * c;

						$circle.css({ strokeDashoffset: pct});

						var checker = 0, interval = 100;

						var pieTimer = setInterval(function() {
							if ( checker <= (duration/interval) ) {
								if ( !counted ) {
									$value.text(Math.round( (checker * interval / (1-ratio)) / duration * label ));
									checker++;
								}
							} else {
								counted = true;
								$value.addClass('counted');
								clearInterval(pieTimer);
							}
						}, interval);
					}
				});
			});

		}
	};



	SCAPE.animatedText = function() {
		$('.wtbx_vc_animated_text:not(.init)').each(function() {
			var $this = $(this),
				$cont = $this.find('.wtbx_anim_text');

			if ('undefined' !== typeof Typed) {
				var typed = new Typed('.' + $this.data('id') + " .wtbx_anim_text span", {
					strings:	$cont.data('text-strings'),
					typeSpeed:	parseInt($cont.data('typespeed')),
					startDelay:	parseInt($cont.data('startdelay')),
					backSpeed:	parseInt($cont.data('backspeed')),
					backDelay:	parseInt($cont.data('backdelay')),
					loop:		true,
					showCursor:	true
				});

				$this.addClass('init');
			}
		});
	};



	SCAPE.beforeAfter = function($el) {
		$el.each(function() {
			$el = $(this);
			if ( 'undefined' !== typeof $el && !$el.hasClass('initialized') ) {
				if ( $el.closest('.wtbx_vc_image_before_after').hasClass('wtbx_appearance_animation') ) {
					$el.closest('.wtbx_vc_image_before_after').addClass('wtbx_to_be_animated wtbx_animated');
				}
				$el.removeAttr('style');
				$el.beforeAfter();
				$el.addClass('initialized');
			}
		});
	};



	SCAPE.dismissAlert = function() {
		$('.wtbx_vc_message').find('.wtbx_message_button').on('click', function() {
			var $this = $(this);
			$this.closest('.wtbx_vc_message').addClass('dismiss');
			setTimeout(function() {
				$this.closest('.wtbx_vc_message').slideToggle(200, function() {
					$this.closest('.wtbx_vc_message').remove();
				});
			},300);
		});
	};



	SCAPE.revsliderChange = function() {
		$(window).on('revolution.slide.onchange', function() {
			var skin = $('#wrapper').find('.active-revslide').data('skin');
			if ( skin === 'dark' || skin === 'light' ) {
				var $header = $('#header-wrapper');
				if ($header.hasClass('header-style-1') ||
					$header.hasClass('header-style-2') ||
					$header.hasClass('header-style-3') ||
					$header.hasClass('header-style-4') ||
					$header.hasClass('header-style-5') ||
					$header.hasClass('header-style-6') ||
					$header.hasClass('header-style-8') ||
					$header.hasClass('header-style-9') ||
					$header.hasClass('header-style-15') ||
					$header.hasClass('header-style-16') ) {
					$header.removeClass('header-skin-light header-skin-dark');
					$header.addClass('header-skin-'+skin);
				}
			}
		});
	};



	SCAPE.animatedInContainer = {
		reveal: function($el) {
			var $anim = $el.find('.wtbx_appearance_animation');
			if( !$anim.hasClass('portfolio-slider-inner') ) {
				$anim.addClass('wtbx_to_be_animated wtbx_animated');
			} else {
				$anim.addClass('wtbx-element-visible');
			}

			if ( $anim.hasClass('wtbx_vc_split_text') ) {
				SCAPE.splitText.trigger($anim);
			}

			if ( $anim.hasClass('wtbx_vc_pie') ) {
				$anim.find('.counted').removeClass('counted');
				SCAPE.pie.trigger($anim);
			}

			if ( $el.find('.wtbx_vc_banner').hasClass('wtbx_image_mousemove') ) {
				SCAPE.bannerMousemove.layout($el.find('.wtbx_vc_banner'));
			}

			SCAPE.counter.count($el.find('.wtbx_counter_number'));

			$el.find('.slick-slider').slick('setPosition');

			$.each(SCAPE.icons, function(index, value) {
				if ( $el.find($(SCAPE.icons[index]['parentEl'])).length ) {
					SCAPE.icons[index].reset().play();
				}
			});

			$(window).trigger('resize');
			$el.find('.flickity-enabled').flickity('resize');

		},

		hide: function($el) {
			var $anim = $el.find('.wtbx_appearance_animation');
			if( !$anim.hasClass('portfolio-slider-inner') ) {
				$anim.removeClass('wtbx_to_be_animated wtbx_animated');
			}

			if ( $anim.hasClass('wtbx_vc_split_text') ) {
				$anim.find('.wtbx_split_text_wrapper').removeClass('wtbx_split_animated');
			}

			if ( $anim.hasClass('wtbx_vc_pie') ) {
				var $pie = $anim.find('.wtbx_pie_cont');

				var val			= 0,
					ratio		= parseFloat($pie.data('ratio')),
					$circle		= $pie.find('svg .bar');

				var r = $circle.attr('r');
				var c = Math.PI*(r*2);

				if (val < 0) { val = 0;}
				if (val > 100) { val = 100;}

				var pct = - c - (val / 100) * c;

				$pie.find('svg .bar').css({ strokeDashoffset: pct});
				$pie.find('.wtbx_pie_value div').addClass('counted').text(0);
			}

			if ( $el.find('.plyr').length ) {
				$.each(SCAPE.players, function(index, value) {
					var instance = SCAPE.players[index];
					if ( $el.has(instance.elements.container) ) {
						instance.pause();
					}
				});
			}

		}
	};



	SCAPE.innerNav = {

		init: function() {
			$("a[href*='#']:not([href='#']):not([href*='#modal-'])").on('click', function(e) {
				var link = $(this)[0].hash;

				var newPath		= $(this)[0].href.match(/(^[^#]*)/)[0],
					currPath	= window.location.href.match(/(^[^#]*)/)[0],
					href		= $(this).attr('href'),
					ignore		= true;

				var ignoreEls	= ['.wtbx_vc_el_inner', '#wtbx-page-nav', '.wtbx_menu_nav', '.widget_nav_menu'];

				for ( var i=0; i<ignoreEls.length; i++ ) {
					if ( $(this).closest(ignoreEls[i]).length) {
						if ( !$(this).closest('.wtbx_tabs_nav_link, .wtbx_tab_mobile_link, .wtbx_accordion_link').length ) {
							ignore = false;
						} else {
							SCAPE.stopEvent(e);
						}
					}
				}

				if ( !ignore ) {
					if ( $(this).attr('href') !== '' && currPath === newPath ) {
						SCAPE.stopEvent(e);
						SCAPE.innerNav.sectionScroll(link, true);

						if ( $(this).closest('#mobile-header').length ) {
							$('body').removeClass('mobile-header-open');
						}
					}
				}

			});

			if ( history.pushState ) {
				window.onpopstate = function(e) {
					if (e.state) {
						var hash = e.state.hash;
						if ( $(hash).length ) {
							SCAPE.innerNav.sectionScroll(hash, false);
						}
					}
				};
			} else {
				window.onhashchange = function(e) {
					var hash = window.location.hash;
					if ( $(hash).length ) {
						SCAPE.innerNav.sectionScroll(hash, true);
					}
				};
			}

			var loadHash = window.location.hash;
			if ( $(loadHash).length ) {
				if ('scrollRestoration' in history) {
					history.scrollRestoration = 'manual';
				}
				SCAPE.innerNav.sectionScroll(loadHash, true);
			}

			// Cache selectors
			var lastId,
				$menu = $('.wtbx_menu_nav, .widget_nav_menu'),
				menuItems = $menu.find('a');

			// Anchors corresponding to menu items
			var linkArray = menuItems.map(function(){
				var item = $($(this)[0].hash);
				var newPath		= $(this)[0].href.match(/(^[^#]*)/)[0],
					currPath	= window.location.href.match(/(^[^#]*)/)[0];
				if (item.length && newPath === currPath) {
					return $(this)[0].hash;
				}
			});

			linkArray = $.unique(linkArray);

			var scrollItems = linkArray.map(function(){
				return $(this);
			});

			// Bind to scroll
			$(window).scroll(function(){
				// Get container scroll position
				var fromTop = SCAPE.scrollTop.get + (SCAPE.viewport().height / 2);

				// Get id of current scroll item
				var cur = scrollItems.map(function(){
					var current;

					if ($(this).offset().top < fromTop) {
						SCAPE.innerNav.lastCurrent = this;

						if ( $(this).offset().top > SCAPE.innerNav.lastCurrent.offset().top ) {
							current = this;
						} else {
							current = SCAPE.innerNav.lastCurrent;
						}

						return current;
					}
				});

				// Get the id of the current element
				cur = cur[cur.length-1];
				var id = cur && cur.length ? cur[0].id : "";

				if (lastId !== id && id !== '') {
					lastId = id;
					// Set/remove active class
					menuItems
						.parents('.current-menu-ancestor').removeClass('current-menu-ancestor')
						.end().filter('[href*="#'+id+'"]').parents('.sub-menu-item, .menu-item').addClass('current-menu-ancestor');
				}
			});

			var menuLinks = $menu.find('a');
			menuLinks.each(function() {
				var hash	= $(this)[0].hash;
				if ( hash !== '' ) {
					$(this).parents('.sub-menu-item, .menu-item').removeClass('current-menu-ancestor');
				}
			});
		},

		lastCurrent: '',

		sectionScroll: function(link, scroll) {

			if ( $('.page-slide').length ) {
				if ( $('.fp-section[data-anchor="'+link.replace('#','',link)+'"]').length ) {
					$.fn.fullpage.moveTo(link.replace('#','',link));
				}
			} else if ( $(link).length ) {
				var delay = 0;

				if ( $(link).hasClass('wtbx_vc_tab') || $(link).hasClass('wtbx_vc_accordion_tab') ) {
					$(link).closest('.wtbx_vc_el_inner').find('.wtbx_tabs_nav_link, .wtbx_tab_mobile_link, .wtbx_accordion_link').filter('[href="'+link+'"]').trigger('click');
					delay = 100;
				}

				if ( SCAPE.scrolling === false ) {
					SCAPE.scrolling = true;

					setTimeout(function() {
						var speed   = 2,
							offset  = $(link).offset().top - SCAPE.headerOffset($(link)),
							time    = Math.abs(SCAPE.scrollTop.get - offset) / speed;

						$('html, body').animate({scrollTop: offset}, time, function(){
							if(history.pushState) {
								if ( SCAPE.scrolling === true ) {
									if (scroll) {
										history.pushState({hash: link}, null, link);
									}
									SCAPE.scrolling = false;
								}
							} else {
								if ( SCAPE.scrolling === true ) {
									parent.location.hash = link;
									SCAPE.scrolling = false;
								}
							}

							var nav_item = $('.widget_nav_menu').find('[href*="'+link+'"]');
							if ( nav_item.length ) {
								nav_item.closest('.menu-item-depth-0.has-submenu').children('.menu-link').addClass('active').next('.sub-menu').slideDown(300);
							}

						});
					}, delay);
				}

			}
		}

	};



	SCAPE.fadeout = {

		offsets: {

		},

		hero: function() {
			$('#page-header.type-default.wtbx-fadeout').each(function() {
				var $container	= $(this);
				var windowHeight	= SCAPE.viewport(),
				contOffset		= $container.offset().top,
				$inner			= $container.find('.page-header-inner'),
				$content		= $inner.find('.page-header-content'),
				scrollTop		= SCAPE.scrollTop.get,
				scrolled		= scrollTop - contOffset,
				contHeight		= $container.outerHeight(),
				innerHeight		= $inner.outerHeight(),
				contentHeight	= $content.outerHeight();

				if (contOffset + contHeight <= scrollTop || contOffset >= scrollTop + windowHeight) {
					return;
				}

				var add;
				if (isNaN(SCAPE.fadeout.offsets['hero'])) {
					add = 0;
				} else {
					add = SCAPE.fadeout.offsets['hero'];
				}

				var path		= (innerHeight - ( contentHeight + ($content.offset().top - $inner.offset().top) ) + add) / innerHeight,
					shift		= Math.max(scrolled * path, 0),
					opacity		= 1 - scrolled / (contHeight - ( contentHeight + ($content.offset().top - $inner.offset().top) ) + add),
					transform	= SCAPE.propertyPrefix('transform');

				opacity = Math.min(Math.max(opacity,0),1);

				$content.css({
					transform: 'translate3d(0,'+shift+'px,0)',
					opacity: opacity
				});

				SCAPE.fadeout.offsets['hero'] = shift;
				$container.find('.wtbx-scrolldown-button, .header-section-meta, .post-header-section-meta, .page-header-inner > .wtbx-page-breadcrumbs').toggleClass('fade', scrolled > 0);
			});
		},

		row: function() {
			$('.wtbx_vc_row.wtbx-fadeout').each(function() {
				var $container		= $(this),
				windowHeight	= SCAPE.viewport(),
				contOffset		= $container.offset().top,
				$inner			= $(this),
				$content		= $inner.find('.wtbx_row_content_inner'),
				scrollTop		= SCAPE.scrollTop.get,
				scrolled		= scrollTop - contOffset,
				contHeight		= $container.outerHeight();

				if (contOffset + contHeight <= scrollTop || contOffset >= scrollTop + windowHeight) {
					return;
				}

				var shift		= Math.max(scrolled/2, 0),
					opacity		= 1 - (scrolled / contHeight * 2),
					transform	= SCAPE.propertyPrefix('transform');

				opacity = Math.min(Math.max(opacity,0),1);

				$content.css({
					transform: 'translate3d(0,'+shift+'px,0)',
					opacity: opacity
				});
			});
		}

	};



	SCAPE.footer = {

		init: function() {
			if ( $('#main').hasClass('wtbx-footer-under') ) {
				SCAPE.footer.layout();

				$(window).on('resize', function() {
					SCAPE.waitForFinalEvent( function() {
						SCAPE.footer.layout();
					}, SCAPE.timeToWaitForLast, 'footer');
				});
			}
		},

		layout: function() {
			if ( !parseInt($('#footer').data('breakpoint')) || SCAPE.viewport().width > parseInt($('#footer').data('breakpoint')) ) {
				$('#page-wrap').css({
					'margin-bottom': $('#footer').outerHeight(true) + 'px'
				});
				$('#main').addClass('active');
			} else {
				$('#page-wrap').css({
					'margin-bottom': ''
				});
				$('#main').removeClass('active');
			}
		}

	};



	SCAPE.mediaplayer = function($el) {
		var options = {
			volume: 8,
			autoplay: false,
			iconUrl: 'undefined' !== typeof wtbxMediaPlayer ? wtbxMediaPlayer.iconUrl : '',
			controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'fullscreen', 'duration'],
		};

		if ( !$el ) {
			$el = $('.wtbx_video_player_embed, .wtbx-media-selfhosted video, .wtbx-media-selfhosted audio');
		}

		$el.each(function(index) {
			SCAPE.players[index] = new Plyr($(this), options);
		});

		var media_players = SCAPE.players;

		$.each(media_players, function(index, value) {
			var $this = $(media_players[index].elements.container);

			if ( undefined !== media_players[index] && ( $this.closest('.widget_media_video').length || $this.closest('.widget_media_audio').length ) ) {
				media_players[index].destroy();
			}

			if ( $this.find('.wtbx_video_player_embed').length ) {
				media_players[index].on('pause ended', function() {
					$this.closest('.wtbx_video_player_wrapper').removeClass('active');
				});
				media_players[index].on('play', function() {
					$this.closest('.wtbx_video_player_wrapper').addClass('active');
				});

				$this.closest('.wtbx_video_player_wrapper').find('.wtbx_video_player_front').on('click', function() {
					$this.closest('.wtbx_video_player_wrapper').addClass('active');

					if ( media_players[index].ready ) {
						media_players.forEach(function(instance) {
							instance.pause();
						});
						media_players[index].play();
					} else {
						media_players[index].on('ready', function() {
							media_players.forEach(function(instance) {
								instance.pause();
							});
							media_players[index].play();
						});
					}
				});
			} else if ( $(media_players[index].elements.container).closest('.wtbx-media-selfhosted').length ) {
				if ( SCAPE.isMobile() && $this.find('video') ) {
					$this.closest('.wtbx-media-selfhosted').addClass('wtbx-media-init');
					if ( $this.closest('.wtbx-media-selfhosted').find('.wtbx-lazy').length === 0 ) {
						var $cont = $this.closest('.wtbx_preloader_cont');
						$cont.find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
						$cont.find('.wtbx-element-reveal').addClass('wtbx-element-visible');
					}
				} else {
					media_players[index].on('ready', function() {
						$this.closest('.wtbx-media-selfhosted').addClass('wtbx-media-init');
						if ( $this.closest('.wtbx-media-selfhosted').find('.wtbx-lazy').length === 0 ) {
							var $cont = $this.closest('.wtbx_preloader_cont');
							$cont.find('.wtbx-preloader-wrapper').addClass('preloader-hidden').trigger('wtbx_hide_preloader');
							$cont.find('.wtbx-element-reveal').addClass('wtbx-element-visible');
						}
					});
				}
			}
		});
	};



	SCAPE.sidebarMenu = function() {
		$('#sidebar').find('.widget_nav_menu > ul > li.has-submenu').each(function() {
			$(this).children('.menu-link').on('click', function(e) {
				if ( !$(this).attr('href') || $(this).attr('href') === '' || $(this).attr('href') === '#' ) {
					SCAPE.stopEvent(e);
					$(this).toggleClass('active');
					$(this).siblings('.sub-menu').slideToggle(300);
				}
			});

			if ( $(this).hasClass('current-menu-parent') ) {
				$(this).children('.menu-link').addClass('active').next('.sub-menu').slideDown(300);
			}
		});
	};



	SCAPE.gdpr = function() {
		$(document).on('click', '.gdpr-overlay', function() {
			$('.gdpr-privacy-preferences, .gdpr-reconsent, .gdpr-general-confirmation').find('.gdpr-close').trigger('click');
		});

		$(document).on('click', '.gdpr.gdpr-privacy-preferences .gdpr-close', function(e) {
			setTimeout(function() {
				$('body').css('top', '');
			});
		});
	};



	SCAPE.has_consent = function(consent) {
		if ( "function" === typeof has_consent && !has_consent(consent) ) {
			return false;
		} else {
			return true;
		}
	};



	SCAPE.is_allowed_cookie = function(cookie) {
		if ( "function" === typeof is_allowed_cookie && !is_allowed_cookie(cookie) ) {
			return false;
		} else {
			return true;
		}
	};



	SCAPE.scrollHover = {

		init: function() {
			setTimeout(function() {
				if ( !$('body.compose-mode').length ) {
					var body = document.body,
						timer;

					window.addEventListener('scroll', function() {
						clearTimeout(timer);
						if(!body.classList.contains('scrolling')) {
							body.classList.add('scrolling')
						}

						timer = setTimeout(function(){
							body.classList.remove('scrolling')
						}, 200);
					}, false);
				}
			});
		},

		scrolling: false

	};



	SCAPE.icons = [];



	SCAPE.animIcons = function() {
		$('.icon_anim_viewport, .icon_anim_viewport_hover').each(function() {
			var id		= $(this).attr('id'),
				file	= $(this).data('file');
			if ( file ) {
				var icon = new Vivus( id, {
					type: 'delayed',
					pathTimingFunction: Vivus.EASE_OUT,
					animTimingFunction: Vivus.LINEAR,
					delayStart: 400,
					duration: 100,
					file: file
				});
				SCAPE.icons.push(icon);

				if ( $(this).hasClass('icon_anim_viewport_hover') ) {
					$(this).closest('.icon_anim_container').on('mouseenter', function() {
						icon.reset().play();
					});
				}
			}
		});
	};



	SCAPE.gridReveal = function($el) {
		$el.each(function(index) {
			var $this = $(this);
			setTimeout(function() {
				$this.addClass('wtbx-element-visible');
			}, index * 100);
		});
	};



	SCAPE.touchHover = function() {
		if ( SCAPE.isMobile() ) {
			$(document).on('touchstart', '.touchhover', function(e) {
				if ( !$(e.target).is('[href]') ) {
					$(this).toggleClass('hover');
				}
			});
		} else {
			$(document).on('mouseenter', '.touchhover', function(e) {
				SCAPE.stopEvent(e);
				$(this).addClass('hover');
			}).on('mouseleave', '.touchhover', function(e) {
				SCAPE.stopEvent(e);
				$(this).removeClass('hover');
			});
		}
	};



	SCAPE.smoothScroll = function() {
		if ( $('body').data('smoothscroll') ) {
			wtbx_smoothScroll();
		}
	};



	SCAPE.columnScroll = {

		vars: {},

		init: function() {
			$('.wtbx_column_scroll').each(function(index) {
				SCAPE.columnScroll.vars[index] = {};
				SCAPE.columnScroll.vars[index].el = $(this);
				SCAPE.columnScroll.vars[index].vStrength = parseInt($(this).data('shift'));
				SCAPE.columnScroll.vars[index].sStrength = parseInt($(this).data('scale'));
				SCAPE.columnScroll.vars[index].oStrength = parseInt($(this).data('opacity'));
			});
		},

		calc: function() {

			$.each(SCAPE.columnScroll.vars, function(index) {
				var $el = SCAPE.columnScroll.vars[index].el.find('.wtbx_column_content, .wtbx_inner_column_content').eq(0);
				var $container = SCAPE.columnScroll.vars[index].el;
				var	offset = $container.offset().top;
				var	height = $container.height();

				var vStrength = SCAPE.columnScroll.vars[index].vStrength / 20;
				var sStrength = Math.sqrt(SCAPE.columnScroll.vars[index].sStrength) / 6;
				var oStrength = Math.sqrt(SCAPE.columnScroll.vars[index].oStrength);

				isNaN(vStrength) ? vStrength = 0 : null;
				isNaN(sStrength) ? sStrength = 0 : null;
				isNaN(oStrength) ? oStrength = 0 : null;


				var scrollTop		= SCAPE.scrollTop.get,
					windowHeight	= SCAPE.viewport().height;

				var transform = SCAPE.propertyPrefix('transform');

				// Check if above or below viewport
				if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
					return;
				}

				// vertical shift
				var vValue = - (offset - scrollTop) * vStrength;

				// scale
				var sValue = (scrollTop - offset) / windowHeight * sStrength;
				sValue = sValue < 0 ? -sValue : sValue;
				sValue = Math.min(Math.max(1.1 - sValue, 0), 1);

				// opacity
				var oValue = (scrollTop - offset) / windowHeight / 1.5 * oStrength;
				oValue = oValue < 0 ? -oValue : oValue;
				oValue = Math.min(Math.max(1.5 - oValue, 0), 1);

				$el.css(transform, 'translate3d(0,'+vValue+'px,0) scale3d('+sValue+','+sValue+',1)');
				$el.css('opacity', oValue);
			});
		}
	};



	SCAPE.customCursor = {

		cursor: '',
		clientX: -100,
		clientY: -100,
		transform: SCAPE.propertyPrefix('transform'),


		init: function() {
			if ( typeof wtbxCustomCursor !== 'undefined' ) {
				SCAPE.customCursor.create();
				SCAPE.customCursor.render();
			}
		},

		bindClick: function($el) {
			// $el.on('mouseenter.customCursor', function() {
			// 	// SCAPE.customCursor.cursor.removeClass('wtbx-cursor-text');
			// 	SCAPE.customCursor.cursor.addClass('wtbx-cursor-click');
			// }).on('mouseleave.customCursor', function() {
			// 	SCAPE.customCursor.cursor.removeClass('wtbx-cursor-click');
			// }).on('mousedown', function() {
			// 	var removeClick;
			// 	if ( typeof removeClick !== "undefined" ) {
			// 		clearTimeout(removeClick);
			// 	}
			//
			// 	SCAPE.customCursor.cursor.addClass('wtbx-cursor-mousedown');
			//
			// 	removeClick = setTimeout(function() {
			// 		SCAPE.customCursor.cursor.removeClass('wtbx-cursor-mousedown');
			// 	}, 300);
			// });
		},

		bindText: function($el) {
			// $el.on('mouseenter.customCursor', function() {
			// 	setTimeout(function() {
			// 		if ( !SCAPE.customCursor.cursor.hasClass('wtbx-cursor-click') ) {
			// 			SCAPE.customCursor.cursor.addClass('wtbx-cursor-text');
			// 		}
			// 	});
			// }).on('mouseleave.customCursor', function() {
			// 	SCAPE.customCursor.cursor.removeClass('wtbx-cursor-text');
			// });
		},

		create: function() {
			// var style = wtbxCustomCursor.cursorStyle;
			// $('body').append('<div class="wtbx-cursor-inner wtbx-cursor-'+style+'"><span></span></div><div class="wtbx-cursor-outer wtbx-cursor-'+style+'"><span></span></div>');
			// $('.wtbx-cursor-inner span').css('background-color', wtbxCustomCursor.cursorColorPrimary);
			// $('.wtbx-cursor-outer span').css('border-color', wtbxCustomCursor.cursorColorSecondary);
			//
			// SCAPE.customCursor.cursor = $('.wtbx-cursor-inner, .wtbx-cursor-outer');
			//
			// $(document).on('mousemove.customCursor', function(e) {
			// 	SCAPE.customCursor.calc(e);
			// });
			//
			// SCAPE.customCursor.bindText($('p, h1, h2, h3, h4, h5, h6, input, .wtbx-text, figcaption, .woocommerce-Price-amount'));
			// SCAPE.customCursor.bindClick($('a, a *, a .wtbx-text, .wtbx-click, .wtbx_header_trigger, .wtbx_search_close, .wtbx-close, .ui-slider-handle, .wtbx-quantity-change, .wtbx-lightbox-item, .wtbx-arrow, .slick-dots li, .gdpr-slider, .gdpr-cookies span, .header_button, .header_language_wrapper, input[type="submit"], input[type="range"], button'));
		},

		calc: function(e) {
			// SCAPE.customCursor.clientX = e.clientX;
			// SCAPE.customCursor.clientY = e.clientY;
			//
			// requestAnimationFrame(SCAPE.customCursor.render);
		},

		render: function() {
			// SCAPE.customCursor.cursor.css(SCAPE.customCursor.transform, 'translate3d('+SCAPE.customCursor.clientX+'px,'+SCAPE.customCursor.clientY+'px,0)');
		}
	};



	SCAPE.pageTransition = {

		fired: false,

		init: function() {
			if ( $('body').data('transition') ) {
				$("a[href]:not([href^='#']):not([href*='uploads']):not([href*='#modal-'])").on('click', function(e) {
					var url = $(this)[0].href;

					var fire = true;
					if ( url.indexOf('mailto') > -1 ) { fire = false; }
					if ( $(this).closest('.flickity-slider').length ) { fire = false; }
					if ( $(this).closest('.wtbx_login_modal_trigger').length ) { fire = false; }
					if ( $(this).closest('.wtbx-lightbox-item').length ) { fire = false; }
					if ( $(this).closest('.ajax_add_to_cart').length ) { fire = false; }
					if ( $(this).closest('.add_to_wishlist').length ) { fire = false; }

					if ( fire ) {
						SCAPE.stopEvent(e);

						if (e.ctrlKey || e.metaKey || $(this).attr('target') === '_blank' ) {
							window.open(url, '_blank');
						} else {
							setTimeout(function() {
								window.location = url;
								SCAPE.pageTransition.animate();
							}, 100);
						}
					}
				});
			}
		},

		animate: function() {
			if ( SCAPE.pageTransition.fired === false ) {
				SCAPE.pageTransition.fired = true;
				var transition = $('body').data('transition');
				if (transition) {
					var $transition = $('<div id="wtbx-site-transition" class="wtbx-transition-' + transition + '"></div>').appendTo($('body'));
					$('body').addClass('wtbx-transition-' + transition);
				}
			}
		}

	};

	SCAPE.pageTransition.init();



	SCAPE.status = {
		scripts: false,
		typekit: window.wtbxTypekit && wtbxTypekit.used ? true : false,
		typekit_ready: false
	};



	SCAPE.setup = function() {
		var $body = $('body');

		if ( SCAPE.isMobile() ) {
			$body.removeClass('device-desktop').addClass('device-mobile');
		} else {
			$body.removeClass('device-mobile').addClass('device-desktop');
		}

		if ( $body.hasClass('page') && !$body.hasClass('woocommerce-page') && !$('#container').find('.wtbx_vc_row').length ) {
			$body.addClass('wtbx-def-page');
		}
	};



	SCAPE.dynamicStyles = function() {

		if ( 'undefined' !== typeof wtbx_dynamic_styles ) {
			var head = document.head;
			var s = document.createElement("style");
			var css = wtbx_dynamic_styles.css;
			s.setAttribute("type", "text/css");

			if ( css !== '' ) {
				if (s.styleSheet) {
					s.styleSheet.cssText = css;
				} else {
					s.appendChild(document.createTextNode(css));
				}

				head.appendChild(s);
				var footerStyles = document.getElementById("footer-dynamic-styles");
				if (footerStyles !== null && footerStyles.length) {
					footerStyles.outerHTML = "";
				}
			}
		}

	};



	SCAPE.onSiteReveal = function() {
		SCAPE.megamenu();
		SCAPE.sidebarMenu();
		SCAPE.revsliderChange();

		$(window).scroll(function(){
			SCAPE.onScroll();
		});

		$(window).scroll();

		setTimeout(function() {
			SCAPE.scrollDown();
			SCAPE.search();
			SCAPE.postLike();
			SCAPE.dismissAlert();

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					$(window).scroll();
					SCAPE.resizeRows();
					SCAPE.verticalAlign();
					SCAPE.fullscreen();
					SCAPE.woocommerce.tabDecoration();
				}, SCAPE.timeToWaitForLast, 'uniqueId');
			});

		}, 1000);

	};



	jQuery(document).ready(function($) {
		SCAPE.setup();
		SCAPE.menuId();
		SCAPE.dynamicStyles();
		SCAPE.smoothScroll();
		SCAPE.scrollTop.update();
		SCAPE.lazyload();
		SCAPE.revealNoLazy();
		SCAPE.hidePreloader();
		SCAPE.mobileHeader.init();
		SCAPE.touchHover();
		SCAPE.toTop();
		SCAPE.socialButtons();
		SCAPE.innerNav.init();
		SCAPE.initPostMedia.media_selfhosted();
		SCAPE.initPostMedia.media_iframe();
		SCAPE.initPostMedia.audioplayer($('.post.format-audio'), true);
		SCAPE.initPostMedia.video_embedded();
		SCAPE.initPostMedia.gallery($('.post-gallery'), true);
		SCAPE.forms();
		SCAPE.dropdown();
		SCAPE.stickyHeader();
		SCAPE.relatedPosts();
		SCAPE.share.init();

		SCAPE.isotopeGrid.init($('.wtbx_isotope_grid'));

		if( $('.wtbx-grid-masonry, .wtbx-grid-boxed, .wtbx-grid-square, .wtbx-grid-tiles').length ) {
			SCAPE.isotopeMasonry.init($('.wtbx-grid-masonry, .wtbx-grid-boxed, .wtbx-grid-square, .wtbx-grid-tiles'));
		}

		SCAPE.portfolioSingle.slider($('.portfolio-item-slider .wtbx-slider-gallery'));
		SCAPE.portfolioSingle.masonry($('.portfolio-item-masonry-wrapper'));

		SCAPE.prettyLike();
		SCAPE.atvHover();
		SCAPE.verticalAlign();
		SCAPE.fullscreen();

		SCAPE.columnScroll.init();
		SCAPE.columnScroll.calc();

		// woocommerce
		SCAPE.woocommerce.tabDecoration();
		SCAPE.woocommerce.thumbnails();

		//shortcodes
		SCAPE.splitText.init();
		SCAPE.pie.init();
		SCAPE.imageCascade.init();
		SCAPE.counter.init();
		SCAPE.countdown();
		SCAPE.animatedText();
		SCAPE.beforeAfter($('.wtbx_before_after_inner'));
		SCAPE.animIcons();
		SCAPE.equalHeightEl.init();
		SCAPE.mediaplayer();
		SCAPE.gdpr();
		SCAPE.stickyElement($('.wtbx-sticky'), 30);

		SCAPE.footer.init();

		SCAPE.ticking = false;

		SCAPE.onScroll = function() {
			SCAPE.scrollTop.update();

			if(!SCAPE.ticking) {
				var raf = SCAPE.raf();
				raf(function() {
					SCAPE.ticking = false;

					SCAPE.stickyHeader();
					SCAPE.fadeout.hero();
					SCAPE.fadeout.row();
					SCAPE.columnScroll.calc();
					if ( $('.wtbx_parallax_container').length ) {
						SCAPE.parallaxBackground.scroll();
						SCAPE.parallaxBackground.scale();
					}
					if ( $('#wtbx-page-nav').length ) {
						SCAPE.pageNav.update();
					}
					SCAPE.waitForFinalEvent( function() {
						var windowHeight = SCAPE.viewport();
						if ( $('html').height() - 70 > windowHeight.height && SCAPE.scrollTop.get + windowHeight.height > $('html').height() - 70 ) {
							$('.wtbx_fixed_navigation').addClass('invisible');
						} else {
							$('.wtbx_fixed_navigation').removeClass('invisible');
						}
						if ( SCAPE.scrollTop.get > windowHeight.height/2 ) {
							$('.wtbx_fixed_navigation').removeClass('totop-invisible');
						} else {
							$('.wtbx_fixed_navigation').addClass('totop-invisible');
						}

						SCAPE.debounce(SCAPE.equalHeightEl.calculate(), 1000);
					}, SCAPE.timeToWaitForLast, 'wait_for_scroll');
				});
			}
			SCAPE.ticking = true;
		};

		SCAPE.status.scripts = true;

		SCAPE.imagesLoaded = {
			total: 0,
			count: 0
		};

		SCAPE.imagesPreload = function() {
			var $progressBar = $('#wtbx-site-preloader').find('.wtbx-preloader-12, .wtbx-preloader-13, .wtbx-preloader-14');
			var isProgress = $progressBar.length > 0;
			var isProgressNum = $('#wtbx-site-preloader').find('.wtbx-preloader-17').length > 0;
			var initial = 0.2;
			var transform = SCAPE.propertyPrefix('transform');

			if ( isProgress ) {
				$progressBar.css(transform, 'scale3d('+initial+',1,1)');
			}
			if ( isProgressNum ) {
				$('#wtbx-preloader-counter').text(2);
			}

			$('#site').imagesLoaded({ background: '.wtbx-bg-image-inner > div' })
				.always(function(instance) {
					var delay = isProgress ? 300 : 0;
					$progressBar.css(transform, 'scale3d(1,1,1)');
					setTimeout(function() {
						SCAPE.siteReveal();
					}, delay);
				})
				.progress(function(instance, image) {
					var progress = 0;

					if ( isProgress ) {
						SCAPE.imagesLoaded.total = instance.images.length;
						SCAPE.imagesLoaded.count++;
						$progressBar.css(transform, 'scale3d('+progress+',1,1)');
						progress = SCAPE.imagesLoaded.count / SCAPE.imagesLoaded.total;
					}

					if ( isProgressNum ) {
						SCAPE.imagesLoaded.total = instance.images.length;
						SCAPE.imagesLoaded.count++;
						progress = Math.ceil(SCAPE.imagesLoaded.count / SCAPE.imagesLoaded.total * 100);
						$('#wtbx-preloader-counter').text(progress);
					}
				});
		};



		SCAPE.revealed = false;



		SCAPE.siteReveal = function() {

			if ( window.location.href.indexOf('transitions') > -1 && SCAPE.revealed === false ) {
				SCAPE.revealed = true;
				setTimeout(SCAPE.siteReveal(), 1000);
				return false;
			}

			var checker = 0;
			var readyTimer = setInterval(function() {
				if ( checker < 50 ) {
					clearInterval(readyTimer);
					$('body').removeClass('wtbx-page-init');
					setTimeout(function() {
						SCAPE.onSiteReveal();
						if ( !$('.page-slide').length ) {
							SCAPE.waypoints();
						}
						$('.wtbx-filter').each(function() {
							SCAPE.filterGrid.filterKnob($(this), $(this).find('.wtbx-filter-button').filter('.active'));
						});
					}, 800);
					setTimeout(function () {
						$('#wtbx-site-preloader').remove();
					}, 1200);
					checker++;
				} else {
					$('body').removeClass('wtbx-page-init');
					setTimeout(function() {
						SCAPE.onSiteReveal();
						if ( !$('.page-slide').length ) {
							SCAPE.waypoints();
						}
						$('.wtbx-filter').each(function() {
							SCAPE.filterGrid.filterKnob($(this), $(this).find('.wtbx-filter-button').filter('.active'));
						});
					}, 800);
					setTimeout(function () {
						$('#wtbx-site-preloader').remove();
					}, 1200);
					clearInterval(readyTimer);
				}
			},100);
		};

		if ( $('#wtbx-site-preloader').length ) {
			SCAPE.imagesPreload();
		} else {
			SCAPE.siteReveal();
		}

	});

})(jQuery);