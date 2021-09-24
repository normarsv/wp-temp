
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.woocommerceLightbox = {

		quantity: function ($el) {

			if (!$el) {
				$el = $('.wtbx-quantity');
			}

			$el.each(function () {
				var $container = $(this),
					$input = $container.find('input'),
					$plus = $container.find('.plus'),
					$minus = $container.find('.minus');

				$plus.unbind().on('click', function () {
					var value = parseInt($input.val()),
						max = $input.attr('max');
					if (value < max || !max) {
						$input.val(value + 1);
					}
					if (isNaN(value)) {
						$input.val(1);
					}
					$('div.woocommerce > form input[name="update_cart"]').prop('disabled', false);
				});
				$minus.unbind().on('click', function () {
					var value = parseInt($input.val()),
						min = $input.attr('min') || 1;
					if (value > min) {
						$input.val(value - 1);
					}
					$('div.woocommerce > form input[name="update_cart"]').prop('disabled', false);
				});

				$input.on('blur', function () {
					if ($input.val() === '' || $input.val() === '0') {
						$input.val(1);
					}
				});

				var $variations = $('.single_variation_wrap');
				if ($variations.length) {
					var $select = $variations.find('.variation_id');
					$select.on('change', function () {
						setTimeout(function () {
							var value = parseInt($input.val()),
								max = $input.attr('max');
							if (max && value > max) {
								$input.val(max);
							}
						}, 100);
					});
				}

			});
		}
	}

	SCAPE.lightbox = function() {

		var centerThumbnails = function($thumbnails, i, $cont) {
			if ($thumbnails.length) {
				var $track			= $thumbnails.children(),
					trackW			= $track.width,
					$active			= $thumbnails.find('.mfp-thumb').eq(i),
					screenW			= SCAPE.viewport().width / 2,
					activeW			= $active.width() / 2,
					activeOffset	= $active.position().left,
					offset			= screenW - activeOffset - activeW;
				SCAPE.transform($track[0], 'translate3d('+offset+'px,0,0)');
			}
			var thumbsWidth = 0;
			$cont.find('.mfp-thumb').each(function() {
				thumbsWidth += $(this).outerWidth(true);
			});
			$cont.find('.mfp-thumbnails-inner').css('min-width', thumbsWidth+1);
		};

		$(document).on('click', '.wtbx-lightbox-item', function(e) {
			if ( $(this).closest('.flickity-enabled') ) {
				var slider_data = $(this).closest('.flickity-enabled').data('flickity');
				if ( slider_data && slider_data.isAnimating ) {
					return false;
				}
			}
			SCAPE.stopEvent(e);
			var $this		= $(this),
				$container	= $this.closest('.wtbx-lightbox-container'),
				counter		= $container.data('counter') || $this.data('counter'),
				objName		= 'wtbx_lightbox_',
				dataId		= $container.data('id') || $this.data('id'),
				object		= window[objName + 'nav'],
				scrollNav	= $container.data('scroll') || $this.data('scroll'),
				iframe		= $this.data('iframe'),
				ajax		= $this.data('ajax'),
				video		= $this.data('video'),
				audio		= $this.data('audio'),
				poster		= $this.data('poster'),
				type		= 'image',
				player,
				hammer;

			var	thumbnail	= $container.data('thumbnail') || $this.data('thumbnail');

			//if it's a grid item and there is filter
			var	$filters = $container.closest('.wtbx-grid-wrapper').parent().children('.wtbx-filter').find('.wtbx-filter-button.active');
			if ( $filters.length ) {
				var category	= $container.data('filter-prefix'),
					$filter		= $container.closest('.wtbx-grid-wrapper').parent().children('.wtbx-filter'),
					selector	= [];

				if ( $filter.hasClass('filter-multi') && $filter.data('operator') === 'and' ) {
					$filters.each(function(index) {
						selector[index] = '.'+category+'-'+$(this).data('filter');
					});
					selector = selector.join('') + ' .wtbx-lightbox-item';
				} else {
					$filters.each(function(index) {
						var data_filter = $(this).data('filter');
						selector[index] = (data_filter === '*' ? '' : '.'+category+'-'+data_filter + ' ' ) +  '.wtbx-lightbox-item';
					});
					selector = selector.join(', ');
				}
			} else {
				if ( $this.closest('.slick-slide:not(.wtbx-product-entry)').length ) {
					selector = '.slick-slide:not(.slick-cloned) .wtbx-lightbox-item';
				} else {
					if ( $this.hasClass('wtbx-lightbox-item-ajax') ) {
						selector = '.wtbx-lightbox-item-ajax';
					} else {
						selector = '.wtbx-lightbox-item';
					}
				}
			}

			// open correct slide number
			var items		= [],
				thumbs		= [],
				slideNum	= 0;

			var video_markup = function(src) {
				return 	'<div class="mfp-figure mfp-iframe-figure">'+
					'<div class="mfp-iframe-scaler">'+
					'<div class="mfp-iframe-wrapper">'+
					'<div class="mfp-selfhosted mfp-sh-video">'+
					'<video controls>'+
					'<source src="' + src + '" type="video/mp4">' +
					'</video>'+
					'</div>'+
					'</div>'+
					'<div class="mfp-bottom-bar"></div>'+
					'</div>'+
					'<div class="mfp-counter"></div>'+
					'</div>';
			};

			var audio_markup = function(src) {
				return 	'<div class="mfp-figure mfp-iframe-figure">'+
					'<div class="mfp-iframe-scaler mfp-audio-scaler">'+
					'<div class="mfp-selfhosted mfp-sh-audio">'+
					'<div class="mfp-audio-poster">'+
					'<div class="mfp-audio-title"></div>'+
					'</div>'+
					'<audio preload="metadata" controls>'+
					'<source src="' + src + '" type="audio/mp3"></audio>'+
					'</div>'+
					'<div class="mfp-bottom-bar"></div>'+
					'</div>'+
					'<div class="mfp-counter"></div>'+
					'</div>';
			};

			var noconsent_markup = function(consent, poster) {
				return 	'<div class="mfp-figure mfp-iframe-figure">'+
					'<div class="mfp-iframe-scaler">'+
					'<div class="wtbx-gdpr-noconsent-wrapper wtbx-gdpr-noconsent-lightbox" data-type="' + consent + '">' +
					'<div class="wtbx-gdpr-noconsent-poster">' +
					'<div class="wtbx-gdpr-bg" style="background-image: url(' + poster + ')"></div>' +
					'</div>'+
					'<div class="wtbx-gdpr-noconsent-content">' +
					'<div class="wtbx-gdpr-noconsent-inner">' +
					'<div class="wtbx-gdpr-noconsent-icon">' + wtbxNoConsentLightbox.icons[consent] + '</div>'+
					'<div class="wtbx-gdpr-noconsent-text">' + wtbxNoConsentLightbox.text + '</div>' +
					'</div>'+
					'</div>'+
					'</div>'+
					'<div class="mfp-bottom-bar"></div>'+
					'</div>'+
					'</div>'+
					'<div class="mfp-counter"></div>'+
					'</div>'
			};

			var init_noconsent_content = function(popup) {
				setTimeout(function() {
					popup.container.removeClass('mfp-anim-next-in');
					popup.container.removeClass('mfp-anim-prev-in');
					popup.wrap.addClass('mfp-image-loaded');
					popup.container.addClass('mfp-s-ready');
					popup.wrap.addClass('mfp-anim-complete');
				}, 300);
			};

			var init_selfhosted_media = function(popup, poster) {
				setTimeout(function() {
					if ( $(popup.container).find('.mfp-selfhosted').length ) {

						var options = {
							volume: 8,
							controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'fullscreen', 'duration']
						};

						player = new Plyr($(popup.container).find('.mfp-selfhosted').find('audio, video'), options);

						$(popup.container).find('.mfp-selfhosted').find('.mfp-audio-title').html(popup.currItem.data.title);

						if ( SCAPE.isMobile() ) {
							if ( $(popup.container).find('.mfp-selfhosted').find('audio').length && poster ) {
								$('<img/>').attr('src', poster).load(function() {
									$(this).remove();
									$('.mfp-selfhosted .mfp-audio-poster').css('background-image', 'url('+poster+')');

									setTimeout(function() {
										popup.container.removeClass('mfp-anim-next-in');
										popup.container.removeClass('mfp-anim-prev-in');
										popup.wrap.addClass('mfp-image-loaded');
										popup.container.addClass('mfp-s-ready');
										popup.wrap.addClass('mfp-anim-complete');
									}, 300);
									setTimeout(function() {
										if ( $(popup.container).find('.mfp-selfhosted').find('audio source').attr('src') !== undefined ) {
											player.play();
										}
									}, 800);
								});
							} else {
								setTimeout(function() {
									popup.container.removeClass('mfp-anim-next-in');
									popup.container.removeClass('mfp-anim-prev-in');
									popup.wrap.addClass('mfp-image-loaded');
									popup.container.addClass('mfp-s-ready');
									popup.wrap.addClass('mfp-anim-complete');
								}, 300);
								setTimeout(function() {
									if ( $(popup.container).find('.mfp-selfhosted').find('video source').attr('src') !== undefined ) {
										player.play();
									}
								}, 800);
							}
						} else {
							player.on('ready', function(event) {
								var this_player = $(this);
								if ( $(popup.container).find('.mfp-selfhosted').find('audio').length && poster ) {
									$('<img/>').attr('src', poster).load(function() {
										$(this).remove();
										$('.mfp-selfhosted .mfp-audio-poster').css('background-image', 'url('+poster+')');

										setTimeout(function() {
											popup.container.removeClass('mfp-anim-next-in');
											popup.container.removeClass('mfp-anim-prev-in');
											popup.wrap.addClass('mfp-image-loaded');
											popup.container.addClass('mfp-s-ready');
											popup.wrap.addClass('mfp-anim-complete');
										}, 300);
										setTimeout(function() {
											if ( $(popup.container).find('.mfp-selfhosted').find('audio source').attr('src') !== undefined ) {
												player.play();
											}
										}, 800);
									});

								} else {
									setTimeout(function() {
										popup.container.removeClass('mfp-anim-next-in');
										popup.container.removeClass('mfp-anim-prev-in');
										popup.wrap.addClass('mfp-image-loaded');
										popup.container.addClass('mfp-s-ready');
										popup.wrap.addClass('mfp-anim-complete');
									}, 300);
									setTimeout(function() {
										if ( $(popup.container).find('.mfp-selfhosted').find('video source').attr('src') !== undefined ) {
											player.play();
										}
									}, 800);
								}
							});
						}

						if ($(popup.container).find('.mfp-selfhosted').find('audio').length && !poster) {
							$(popup.container).find('.mfp-selfhosted').addClass('mfp-audio-noposter');
						}
					}
				});
			};

			var destroy_selfhosted_media = function(popup) {
				if ( $(popup.container).find('.plyr').length ) {
					if ( player !== undefined ) {
						player.stop();
						$(popup.container).find('.plyr').find('audio, video').attr('src', '');
						player.destroy();
					}
				}
			};

			var add_share_buttons = function(popup, share) {
				var share_buttons = $container.data('share-buttons') || $this.data('share-buttons');
				$(popup.container).find('.mfp-share-buttons').remove();
				if ( share_buttons !== '' && share_buttons !== undefined ) {
					share_buttons = share_buttons.split(',');

					var $buttons = '<ul class="mfp-share-buttons">';

					for ( var i= 0; i < share_buttons.length; i++ ) {
						var icon_class = share_buttons[i];
						icon_class = icon_class.replace('vkontakte', 'vk');
						$buttons += '<li class="wtbx-share wtbx-lightbox-share" data-share="'+icon_class+'" data-url="'+share+'">';
						icon_class = icon_class.replace('googleplus', 'google-plus');
						$buttons += '<i class="scape-ui-'+icon_class+'"></i>';
						$buttons += '</li>';
					}

					$buttons += '</ul>';

					$(popup.wrap).find('.mfp-buttons').append($buttons);

				}
			};

			var align_buttons = function($cont) {
				var $img		= $cont.find('.mfp-img'),
					$buttons	= $cont.find('.mfp-buttons');
				if ( $img.length ) {
					setTimeout(function() {
						$buttons.css('top', $img.position().top).addClass('init');
					}, 1000);
				}
			};

			var add_item_link = function(popup, url) {
				var $link = '<a href="'+ url +'" class="mfp-item-link"><i class="scape-ui-corner-up-right"></i></a>';
				$(popup.wrap).find('.mfp-buttons').append($link);
			};

			var check_media_type = function(src, type) {
				var p = {
					youtube: /(?:youtu\.be\/|youtube\.com\/|ytimg\.com\/)(?:embed\/|v\/|vi\/|vi_webp\/|watch\?v=|watch\?.+&v=)((\w|-){11})(?:\S+)?$/,
					vimeo: /https?:\/\/(?:vimeo\.com\/|player\.vimeo\.com\/)(?:video\/|(?:channels\/staffpicks\/|channels\/)|)((\w|-){7,9})/,
					soundcloud: /\/\/(?:w\.|www\.|)(?:soundcloud\.com\/)/,
					spotify: /\/\/(?:embed\.|open\.)(?:spotify\.com\/)(?:track\/|\?uri=spotify)/
				};

				var matches = src.match(p[type]);
				if ( matches ) {
					return true;
				} else {
					return false;
				}
			};

			if ( $this.data('dynamic') ) {
				var share		= $this.data('share');
				var itemlink	= $(this).data('itemlink');
				if ( video == '1' ) {
					type = 'inline';
					items = { src: video_markup($this.data('dynamicel')) };
					items['caption_primary'] = $this.data('caption-primary');
					items['caption_secondary'] = $this.data('caption-secondary');
					items['share'] = share;
					items['itemlink'] = itemlink;
				} else if ( audio == '1' ) {
					type = 'inline';
					items = {
						'src': audio_markup($this.data('dynamicel')),
						'poster': $this.data('poster'),
						'title': $this.data('title')
					};
					items['caption_primary'] = $this.data('caption-primary');
					items['caption_secondary'] = $this.data('caption-secondary');
					items['share'] = share;
					items['itemlink'] = itemlink;
				} else if ( iframe == '1' ) {
					var consent = '';
					var href = $this.data('dynamicel');
					if (check_media_type(href, 'spotify') ) {
						consent = 'spotify';
					} else if ( check_media_type(href, 'soundcloud') ) {
						consent = 'soundcloud';
					} else if ( check_media_type(href, 'youtube') ) {
						consent = 'youtube';
					} else if ( check_media_type(href, 'vimeo') ) {
						consent = 'vimeo';
					}

					if ( !SCAPE.has_consent(consent) ) {
						items = {'src': noconsent_markup(consent, $(this).data('poster'))};
						type = 'inline';
					} else {
						type = 'iframe';
						items = { src: $this.data('dynamicel') };
						items['caption_primary'] = $this.data('caption-primary');
						items['caption_secondary'] = $this.data('caption-secondary');
						items['share'] = share;
						items['itemlink'] = itemlink;
					}
				} else {
					items = $this.data('dynamicel');
					for (var i = 0; i < items.length; i++) {
						if ( false === items[i]['src'] || false === items[i]['thumb'] ) {
							items.splice(i, 1);
						} else {
							thumbs[i] = items[i]['thumb'];
							items[i]['share'] = items[i]['src'];
							items[i]['caption_primary'] = $this.data('caption-primary');
							items[i]['caption_secondary'] = $this.data('caption-secondary');
							items[i]['share'] = share;
							items[i]['itemlink'] = itemlink;
						}
					}
				}
			} else {
				var slide_count = 0;
				$container.find(selector).each(function(index) {
					var share		= $(this).data('share');
					var itemlink	= $(this).data('itemlink');
					if ( ajax == '1' ) {
						items[index] = { src: window['wtbx_products_grid_' + $container.data('id')].ajaxurl + '&id=' + $(this).data('productid') + '&wpnonce=' + $(this).data('nonce') };
						items[index]['type'] = 'ajax';
					} else if ( $(this).data('video') == '1' ) {
						items[index] = {'src': video_markup($(this).attr('href'))};
						items[index]['type'] = 'inline';
					} else if ( $(this).data('audio') == '1' ) {
						items[index] = {'src': audio_markup($(this).attr('href'))};
						items[index]['type'] = 'inline';
						items[index]['poster'] = $(this).data('poster');
						items[index]['title'] = $(this).data('title');
					} else if ( $(this).data('iframe') == '1' ) {
						var consent = '';
						var href = $(this).attr('href');
						if ( check_media_type(href, 'spotify') ) {
							consent = 'spotify';
						} else if ( check_media_type(href, 'soundcloud') ) {
							consent = 'soundcloud';
						} else if ( check_media_type(href, 'youtube') ) {
							consent = 'youtube';
						} else if ( check_media_type(href, 'vimeo') ) {
							consent = 'vimeo';
						}

						if ( !SCAPE.has_consent(consent) ) {
							items[index] = {'src': noconsent_markup(consent, $(this).data('poster'))};
							items[index]['type'] = 'inline';
						} else {
							items[index] = {'src': $(this).attr('href')};
							items[index]['type'] = 'iframe';
						}
					} else {
						items[index] = {'src': $(this).attr('href')};
						items[index]['type'] = 'image';
					}

					// caption
					items[index]['caption_primary'] = $(this).data('caption-primary');
					items[index]['caption_secondary'] = $(this).data('caption-secondary');

					// share
					items[index]['share'] = share;

					// item page link
					items[index]['itemlink'] = itemlink;

					slide_count ++;
				});
				if ( $this.closest('.slick-slide').length ) {
					slideNum = parseInt($this.closest('.slick-slide').data('slick-index'));
					if ( slideNum >= slide_count ) {
						slideNum = slideNum - slide_count;
					}
				} else {
					slideNum = $container.find(selector).index($this);
				}
			}

			// counter
			if (counter) {
				counter = '<div class="pages-current">%curr%</div> / <div class="pages-total">%total%</div>';
			} else {
				counter = '';
			}

			// navigation with mouse scroll
			var slideOnScroll = function(e) {
				e			= window.event || e;
				var delta	= Math.max(-1, Math.min(1, (e.wheelDelta || -e.deltaY || -e.detail)));
				var popup	= $.magnificPopup.instance;

				if ( scrollNav ) {
					if ( !$(e.target).closest('.wtbx-product-preview-cont').length ) {
						SCAPE.stopEvent(e);
						if (delta < 0  && $(popup.wrap).hasClass('mfp-anim-complete') ) {
							popup.next();
						} else if ( delta > 0  && $(popup.wrap).hasClass('mfp-anim-complete') ) {
							popup.prev();
						}
						return false
					}
				}
			};

			var resizeEmbed = function($cont, src) {
				if ( 'string' !== typeof src ) {
					return false;
				}

				var ratio, maxW, minW, resize = false;
				if ( src.indexOf('spotify') !== -1 ) {
					$cont.removeClass('mfp-soundcloud mfp-video');
					$cont.addClass('mfp-spotify');

					if ( SCAPE.viewport().width > 250 ) {
						ratio	= 1.2666;
					} else {
						ratio	= (SCAPE.viewport().width - 30) / 80;
					}
					maxW	= 640;
					minW	= 200;
					resize	= true;
				} else if ( src.indexOf('soundcloud') !== -1 ) {
					$cont.removeClass('mfp-spotify mfp-video');
					$cont.addClass('mfp-soundcloud');
					ratio	= 0.8;
					maxW	= 720;
					minW	= 200;
					resize	= true;
				} else if (src.indexOf('youtube') !== -1 || src.indexOf('vimeo') !== -1  ) {
					$cont.removeClass('mfp-spotify mfp-soundcloud');
					$cont.addClass('mfp-video');
					ratio	= 0.5625;
					maxW	= 1440;
					minW	= 200;
					resize	= true;
				} else if (src.indexOf('mfp-sh-video') !== -1 ) {
					$cont.removeClass('mfp-spotify mfp-soundcloud mfp-video');
					ratio	= 0.5625;
					maxW	= 1440;
					minW	= 200;
					resize	= true;
				} else if (src.indexOf('mfp-sh-audio') !== -1 ) {
					$cont.removeClass('mfp-spotify mfp-soundcloud mfp-video');
					ratio	= 1;
					maxW	= 640;
					minW	= 200;
					resize	= true;
				} else {
					$cont.removeClass('mfp-spotify mfp-soundcloud mfp-video');
				}

				if ( resize === true ) {
					var contW	= $cont.innerWidth() - parseInt($cont.css('padding-left')) - parseInt($cont.css('padding-right')),
						contH	= $cont.find('.mfp-content').height(),
						newW	= Math.min(contH / ratio, (contW));
					newW	= Math.min(newW, maxW);
					newW	= Math.max(newW, minW);

					$cont.find('.mfp-figure').css({
						'width': newW + 'px',
						'margin-left': -newW/2 + 'px'
					});
				} else {
					$cont.find('.mfp-figure').css({
						'width': '',
						'margin-left': ''
					});
				}
			};

			if ( items.length === 0 ) {
				return false;
			}

			var galleryOptions = {
				type:	type,
				items:	items,
				image: {
					markup:
					'<div class="mfp-figure mfp-image-holder">'+
					'<div class="mfp-img-wrapper">'+
					'<div class="mfp-img"></div>'+
					'<div class="mfp-bottom-bar"></div>'+
					'</div>'+
					'<div class="mfp-counter"></div>'+
					'</div>'
				},
				gallery: {
					enabled:			true, // set to true to enable gallery
					preload:			[1,2], // read about this option in next Lazy-loading section
					navigateByImgClick:	false,
					tCounter:			counter,
					arrowMarkup:		''
				},
				iframe: {
					markup: '<div class="mfp-figure mfp-iframe-figure">'+
					'<div class="mfp-iframe-scaler">'+
					'<div class="mfp-iframe-wrapper">'+
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
					'</div>'+
					'<div class="mfp-bottom-bar"></div>'+
					'</div>'+
					'<div class="mfp-counter"></div>'+
					'</div>'
				},
				fixedContentPos:true,
				fixedBgPos:		true,
				overflowY:		'hidden',
				closeBtnInside:	false,
				closeOnBgClick:	false,
				tLoading:		'<div class="wtbx-preloader-wrapper wtbx-preloader-el"><div class="wtbx-preloader-container"><div class="wtbx-preloader wtbx-preloader-2"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10" stroke-linecap="round"/></svg></div></div></div>',
				mainClass:		'mfp-zoom-in',
				midClick:		true,
				removalDelay:	300,
				key:	1,
				closeMarkup:	'<button type="button" class="mfp-close"></button>',
				callbacks:		{
					open: function() {
						var popup = $.magnificPopup.instance;

						if ( !$('.page-slider').length ) {
							var header_selector = $('#header-wrapper').hasClass('header_sticky') && !$('#header-wrapper').hasClass('header-boxed') ? ', #header-wrapper' : '';
							$('body, .wtbx-fixed' + header_selector).css({
								'padding-right': SCAPE.scrollbarWidth() + 'px'
							});
							if ( $('#header-wrapper').hasClass('header-boxed') ) {
								$('#header-wrapper').css({
									'margin-left': - SCAPE.scrollbarWidth()/2 + 'px'
								});
							}
						}

						// if more than 1 item
						if ( popup.items.length > 1 ) {

							// go to initial slide
							var initialSlide = $this.closest('.wtbx_with_lightbox').data('slide') - 1;
							if ( !isNaN(initialSlide) && initialSlide !== '' && initialSlide != 'undefined' ) {
								popup.goTo(initialSlide);
							}

							var $carousel_item = $this.closest('.wtbx_carousel_item');
							if ( $carousel_item.length ) {
								popup.goTo($carousel_item.index());
							}

							// append nav buttons
							$(popup.container).append(object.nav);

							// navigation buttons
							$(popup.container).find('.wtbx-nav-prev').on('click', function(e) {
								SCAPE.stopEvent(e);
								popup.prev();
							});
							$(popup.container).find('.wtbx-nav-next').on('click', function(e) {
								SCAPE.stopEvent(e);
								popup.next();
							});

							// navigation with mouse scroll
							SCAPE.mouseWheelHandler.add($(popup.container)[0], slideOnScroll);

							// navigation with swipe
							hammer = new Hammer($(popup.wrap)[0]);
							hammer.on('swipeleft panleft', function(e) {
								if ( !$(e.target).closest('.wtbx-product-preview-cont').length ) {
									SCAPE.stopEvent(e);
									if ( e.distance > 100 || e.velocity > 0.3 ) {
										if ( $(popup.wrap).hasClass('mfp-anim-complete') ) {
											popup.next();
										}
									}
								}
							});
							hammer.on('swiperight panright', function(e) {
								if ( !$(e.target).closest('.wtbx-product-preview-cont').length ) {
									SCAPE.stopEvent(e);
									if ( e.distance > 100 || e.velocity > 0.3 ) {
										if ( $(popup.wrap).hasClass('mfp-anim-complete') ) {
											popup.prev();
										}
									}
								}
							});

							// prevent scroll on mobile
							$(document).on('touchmove.lightbox', function(e) {
								SCAPE.stopEvent(e);
							});

							// navigation with thumbnails
							if (thumbnail && popup.currItem.type !== 'ajax' ) {
								$(popup.wrap).addClass('mfp-with-thumbnails');
								$(popup.container).append('<div class="mfp-thumbnails"><div class="mfp-thumbnails-inner"></div></div>');
								if ( $this.data('dynamic') ) {
									for (var i=0; i<thumbs.length; i++) {
										$(popup.container).find('.mfp-thumbnails-inner').append('<img src="'+thumbs[i]+'" class="mfp-thumb" data-slide="'+i+'">')
									}
								} else {
									$container.find(selector).each(function(i) {
										$(popup.container).find('.mfp-thumbnails-inner').append('<img src="'+$(this).data('thumbimage')+'" class="mfp-thumb" data-slide="'+i+'">')
									});
								}
								$(popup.container).find('.mfp-thumb').on('click', function(e) {
									SCAPE.stopEvent(e);
									var slideNum = $(this).data('slide');
									if ( popup.index !== slideNum ) {
										$(this).addClass('active');
										popup.goTo(slideNum);
									}
								});
								$(popup.container).find('.mfp-thumb').eq(popup.index).addClass('active');
								setTimeout(function() {
									centerThumbnails($(popup.container).find('.mfp-thumbnails'), popup.index, $(popup.container));
								},100);
								setTimeout(function() {
									$(popup.container).find('.mfp-thumbnails').addClass('init');
								},400);

								$(window).on('resize.thumbnails', function() {
									SCAPE.waitForFinalEvent( function() {
										centerThumbnails($(popup.container).find('.mfp-thumbnails'), popup.index, $(popup.container));
									}, SCAPE.timeToWaitForLast, 'thumbnails');
								});
							}
						}

						// set container padding
						var paddingH = Math.max($(popup.container).find('.wtbx-nav-prev').outerWidth(), $(popup.container).find('.wtbx-nav-next').outerWidth()) + 45;
						if ( popup.currItem.data.share ) {
							paddingH += 40;
							$(popup.container).addClass('mfp-with-share');
						}
						$(popup.container).css('padding', '0 ' + paddingH + 'px');

						// embed resizing
						var currSrc = popup.currItem.src;
						setTimeout(function() {
							resizeEmbed($(popup.container), popup.currItem.src);
						});

						// close lightbox on background click
						$(popup.wrap).on('click.lightboxClose', function(e) {
							if ( iframe == '1' || $(popup.wrap).hasClass('mfp-anim-complete') ) {
								if (	!$(e.target).closest('.mfp-selfhosted').length &&
									!$(e.target).parents('.mfp-figure').length &&
									!$(e.target).closest('.wtbx-product-preview-cont').length ) {
									popup.close();
								}
							}
						});
						$(popup.wrap).find('.mfp-img-wrapper').on('click.lightboxClose', function(e) {
							if ( !$(popup.wrap).find('.mfp-img-wrapper').find(e.target).length ) {
								$(popup.wrap).trigger('click.lightboxClose');
							}
						});

						$.magnificPopup.instance.goTo = function(slideNum) {
							if ( !$(popup.wrap).hasClass('mfp-removing') ) {
								var self = this;
								self.wrap.removeClass('mfp-image-loaded');
								self.wrap.removeClass('mfp-anim-complete');
								setTimeout(function() {
									$.magnificPopup.proto.goTo.call(self, slideNum);
									resizeEmbed($(popup.container), popup.currItem.src);
								}, 120);
							}
						};

						//overwrite default prev + next function. Add timeout for css3 crossfade animation
						$.magnificPopup.instance.next = function() {
							if ( !$(popup.wrap).hasClass('mfp-removing') && this.items.length > 1 ) {
								var self = this;
								self.wrap.removeClass('mfp-image-loaded');
								self.wrap.removeClass('mfp-anim-complete');
								self.container.addClass('mfp-anim-next-out');
								setTimeout(function() {
									$.magnificPopup.proto.next.call(self);
									self.container.addClass('mfp-anim-next-in').removeClass('mfp-anim-next-out');
									resizeEmbed($(popup.container), popup.currItem.src);
								}, 300);
							}
						};
						$.magnificPopup.instance.prev = function() {
							if ( !$(popup.wrap).hasClass('mfp-removing') && this.items.length > 1 ) {
								var self = this;
								self.wrap.removeClass('mfp-image-loaded');
								self.wrap.removeClass('mfp-anim-complete');
								self.container.addClass('mfp-anim-prev-out');
								setTimeout(function() {
									$.magnificPopup.proto.prev.call(self);
									self.container.addClass('mfp-anim-prev-in').removeClass('mfp-anim-prev-out');
									resizeEmbed($(popup.container), popup.currItem.src);
								}, 300);
							}
						};

						if ( popup.currItem.type === 'ajax' ) {
							var self = this;
							self.wrap.addClass('mfp-ready');
							self.wrap.addClass('mfp-anim-complete');

							$(window).off('resize.preview').on('resize.preview', function() {
								SCAPE.waitForFinalEvent( function() {
									var sharePadding = 0;
									if ( popup.currItem && popup.currItem.data.share ) {
										sharePadding = 40;
										$(popup.container).addClass('mfp-with-share');
									}

									if ( SCAPE.viewport().width < 940 + paddingH * 2 ) {
										$(popup.container).find('.wtbx-nav-button').addClass('no-label');
										var newPaddingH = 40 + sharePadding;

										$(popup.container).css('padding', '0 40px');
									} else {
										$(popup.container).find('.wtbx-nav-button').removeClass('no-label');
										$(popup.container).css('padding', '0 ' + paddingH + 'px');
									}
									if ( SCAPE.viewport().width < 1080 || SCAPE.viewport().height < 620 ) {
										popup.close();
									}
								}, SCAPE.timeToWaitForLast, 'show_hide_preview');
							});
						}
					},
					change: function() {
						var popup = $.magnificPopup.instance;
						destroy_selfhosted_media(popup);
						$(popup.container).find('.mfp-thumb.active').removeClass('active');
						$(popup.container).find('.mfp-thumb').eq(popup.index).addClass('active');
						init_selfhosted_media(popup, popup.currItem.data.poster);
						init_noconsent_content(popup);
						centerThumbnails($(popup.container).find('.mfp-thumbnails'), popup.index, $(popup.container));
						$(window).off('resize.embed').on('resize.embed', function() {
							SCAPE.waitForFinalEvent( function() {
								if ( popup.currItem && popup.currItem.src ) {
									resizeEmbed($(popup.container), popup.currItem.src);
									var $img		= $(popup.container).find('.mfp-img'),
										$buttons	= $(popup.container).find('.mfp-buttons');
									if ( $img.length ) {
										$buttons.css('top', $img.position().top);
									}
								}
							}, SCAPE.timeToWaitForLast, 'resize_embed');
						});
					},
					beforeAppend: function() {
						var popup = $.magnificPopup.instance;
						var self = this;
						self.container.removeClass('mfp-s-ready');
						if (this.content.length ) {
							this.content.find('iframe, .mfp-selfhosted').on('load', function() {
								self.wrap.addClass('mfp-image-loaded');
								self.container.removeClass('mfp-anim-next-in');
								self.container.removeClass('mfp-anim-prev-in');
								self.container.addClass('mfp-s-ready');
								setTimeout(function() {
									self.wrap.addClass('mfp-anim-complete');
								},500);
							});
						}
					},
					updateStatus: function(data) {

						setTimeout(function() {
							if ( data.status === 'ready' ) {
								var popup			= $.magnificPopup.instance;
								if ( null !== popup.currItem ) {
									var currPrimary		= popup.currItem.data.caption_primary;
									var currSecondary	= popup.currItem.data.caption_secondary;

									// caption
									$(popup.container).find('.mfp-bottom-bar').html('');
									$(popup.container).removeClass('with-caption-primary with-caption-secondary');
									if ( currPrimary !== undefined ) {
										$(popup.container).find('.mfp-bottom-bar').append('<span class="mfp-caption-primary">'+currPrimary+'</span>');
										$(popup.container).addClass('with-caption-primary');
									}
									if ( currSecondary !== undefined ) {
										$(popup.container).find('.mfp-bottom-bar').append('<span class="mfp-caption-secondary">'+currSecondary+'</span>');
										$(popup.container).addClass('with-caption-secondary');
									}

									if ( (popup.currItem.data.share !== '' && popup.currItem.data.share !== undefined) || (popup.currItem.data.itemlink !== '' && popup.currItem.data.itemlink !== undefined) ) {
										$(popup.container).find('.mfp-buttons').remove();
										$(popup.wrap).find('.mfp-iframe-scaler, .mfp-image-holder .mfp-img-wrapper, .wtbx-product-preview-cont').append('<div class="mfp-buttons"></div>');
									}

									// share
									if ( popup.currItem.data.share !== '' && popup.currItem.data.share !== undefined ) {
										add_share_buttons(popup, popup.currItem.data.share);
									}

									// itemlink
									if ( popup.currItem.data.itemlink !== '' && popup.currItem.data.itemlink !== undefined ) {
										add_item_link(popup, popup.currItem.data.itemlink);
									}
								}
							}

						});
					},
					imageLoadComplete: function() {
						var popup = $.magnificPopup.instance;
						var self = this;
						setTimeout(function() {
							self.wrap.addClass('mfp-image-loaded');
							self.container.removeClass('mfp-anim-next-in');
							self.container.removeClass('mfp-anim-prev-in');
							align_buttons($(popup.container));
						}, 16);
						setTimeout(function() {
							self.wrap.addClass('mfp-anim-complete');
						},500);
					},
					parseAjax: function(mfpResponse) {
					},
					ajaxContentAdded: function() {
						// Ajax content is loaded and appended to DOM
						var popup = $.magnificPopup.instance;
						var self = this;
						setTimeout(function() {
							self.wrap.addClass('mfp-image-loaded');
							self.container.addClass('mfp-s-ready');
							self.wrap.addClass('mfp-anim-complete');
						},300);

						SCAPE.dropdown(this.content.find('.wtbx_for_custom_dropdown'));
						self.content.find('.wtbx-preview-gallery').slick({
							speed			: 400,
							slidesToShow	: 1,
							slidesToScroll	: 1,
							swipeToSlide	: true,
							infinite		: true,
							autoplay		: false,
							touchThreshold	: 8,
							adaptiveHeight	: true,
							useTransform	: true,
							dots			: true,
							prevArrow		: '<div class="wtbx-arrow wtbx-prev"></div>',
							nextArrow		: '<div class="wtbx-arrow wtbx-next"></div>',
							cssEase			: 'cubic-bezier(0.6, 0, 0.2, 1)'
						});
						SCAPE.woocommerceLightbox.quantity(this.content.find('.wtbx-quantity'));

						self.content.find('.wtbx-preview-content').mCustomScrollbar({
							scrollInertia: 100,
							mouseWheel:{
								scrollAmount:188,
								normalizeDelta:true
							},
							callbacks:{
								onScroll: function(){
									self.content.find('.wtbx-preview-content').removeClass('full-scroll');
								},
								onTotalScroll: function(){
									self.content.find('.wtbx-preview-content').addClass('full-scroll');
								}
							}
						});
					},
					beforeClose: function() {
						var popup = $.magnificPopup.instance;
						destroy_selfhosted_media(popup);
					},
					close: function() {
						var popup = $.magnificPopup.instance;

						if ( !$('.page-slider').length ) {
							var header_selector = $('#header-wrapper').hasClass('header_sticky') ? ', #header-wrapper' : '';
							$('body, .wtbx-fixed' + header_selector).css({
								'padding-right': ''
							});
							if ($('#header-wrapper').hasClass('header-boxed')) {
								$('#header-wrapper').css({
									'margin-left': ''
								});
							}
						}

						if ( popup.items.length > 1 ) {
							SCAPE.mouseWheelHandler.remove($(popup.container)[0], slideOnScroll);
							hammer.off('swipeleft swiperight panright panleft');
							$(document).off('touchmove.lightbox');
							$(popup.container).find('.wtbx-nav-prev').off('click');
							$(popup.container).find('.wtbx-nav-next').off('click');
						}
						$(window).off('resize.thumbnails click.lightboxClose resize.embed');

						popup.popupsCache = {};
					}
				}
			};

			$.magnificPopup.open(galleryOptions, slideNum);

		});
	};

	jQuery(document).ready(function($) {
		SCAPE.lightbox();
	});

})(jQuery);