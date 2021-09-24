
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();


	SCAPE.videoBg = {

		init: function() {
			SCAPE.videoBg.vimeoInit();
			SCAPE.videoBg.videoSelfhosted();

			$('.wtbx_bg_youtube').each(function() {
				SCAPE.videoBg.youtubeInit($(this));
			});

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					SCAPE.videoBg.videoSize();
				}, SCAPE.timeToWaitForLast, 'video_bg');
			});
		},

		vimeoInit: function() {

			$('.wtbx_bg_vimeo').each(function() {
				var $this		= $(this),
					video_id	= $this.data('id'),
					$poster		= $this.closest('.wtbx_bg_video_wrapper').find('.wtbx_bg_video_poster'),
					mute		= $this.data('mute');

				$.getJSON('https://vimeo.com/api/oembed.json?url=https://vimeo.com/' + video_id, {format: "json"}, function(data) {
					var details	= data,
						width	= details.width,
						height	= details.height,
						thumb	= details.thumbnail_url,
						$el		= '<iframe class="wtbx_bg_player" data-width="'+width+'" data-height="'+height+'" src="//player.vimeo.com/video/'+ video_id + '?api=1&amp;background=1&amp;muted='+mute+'&amp;title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=0&amp;autoplay=1&amp;loop=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

					if ( $poster.data('poster') !== 1 ) {
						var $poster_el = '<div class="wtbx_bg_video_poster_native" style="background-image: url('+thumb+')"></div>';
						$($poster_el).appendTo($poster);
					}

					$($el).appendTo($this);
					SCAPE.videoBg.videoSize($this);

					if (window.addEventListener) {
						window.addEventListener('message', onMessageReceived, false);
					} else {
						window.attachEvent('onmessage', onMessageReceived, false);
					}

					function onMessageReceived(e) {
						var origin = e.origin || e.originalEvent.origin;
						if (origin !== 'https://player.vimeo.com' && origin !== 'http://player.vimeo.com') {
							return;
						}

						if ( e.data.length ) {
							var data = JSON.parse(e.data);
							switch (data.event) {
								case 'ready':
									$this.closest('.wtbx_bg_video_wrapper').addClass('wtbx_poster_hidden');
									$this.closest('.wtbx_row_bg_inner').addClass('wtbx-element-visible');
									break;
							}
						}
					}
				});
			});
		},

		// youtube
		youtubeInit: function($el, counter) {
			var $this		= $el,
				video_id	= $this.data('id'),
				$container	= $this.find('.wtbx_bg_player'),
				$poster		= $this.closest('.wtbx_bg_video_wrapper').find('.wtbx_bg_video_poster'),
				mute		= $this.data('mute');

			if ( 'undefined' === typeof( YT.Player ) ) {
				// wait for youtube iframe api to load. try for 10sec, then abort
				counter = 'undefined' === typeof( counter ) ? 0 : counter;
				if ( counter > 100 ) {
					console.warn( 'Too many attempts to load YouTube api' );
					return;
				}

				setTimeout( function () {
					SCAPE.videoBg.youtubeInit( $el, counter ++ );
				}, 100 );

				return;
			}

			var thumb = '//i1.ytimg.com/vi/'+video_id+'/maxresdefault.jpg';
			if ( $poster.data('poster') !== 1 ) {
				var $poster_el = '<div class="wtbx_bg_video_poster_native" style="background-image: url('+thumb+')"></div>';
				$($poster_el).appendTo($poster);
			}

			var player;
			player = new YT.Player( $container[ 0 ], {
				videoId: video_id,
				playerVars: {
					playlist: video_id,
					iv_load_policy: 3, // hide annotations
					enablejsapi: 1,
					disablekb: 1,
					autoplay: 1,
					controls: 1,
					showinfo: 0,
					rel: 0,
					loop: 1,
					wmode: "transparent"
				},
				events: {
					onReady: function ( event ) {
						if ( mute === 1 ) event.target.mute();
						event.target.setLoop(true);

						$(document).on('wtbx_fullpage_slider_changed', function() {
							if ( Math.abs($this.offset().top - $(window).scrollTop()) < 200 ) {
								event.target.playVideo();
							}
						});
					},
					onStateChange: function( event ) {
						if ( event.target.getPlayerState() === 1 ){
							SCAPE.videoBg.youtubeReveal($this);
						}
					}
				}
			} );

		},

		youtubeReveal: function($el) {
			$el.closest('.wtbx_bg_video_wrapper').addClass('wtbx_poster_hidden');
			$el.closest('.wtbx_row_bg_inner').addClass('wtbx-element-visible');
			SCAPE.videoBg.videoSize($el);
		},

		// self-hosted
		videoSelfhosted: function() {

			$('.wtbx_bg_selfhosted').each(function(index) {
				var $this	= $(this),
					mute	= $this.data('mute');

				$this.find('.wtbx_bg_player').mediaelementplayer({
					features: ['volume'],
					pauseOtherPlayers: false,
					loop: true,
					startVolume: mute,
					muted: mute,
					autoplay: true,
					playsinline: 1,
					success: function(mediaElement, domObject) {
						if ( !mediaElement.paused || $('body').hasClass('device-desktop') )  {
							mediaElement.pause();
							mediaElement.load();
							mediaElement.addEventListener('loadeddata', function(e) {
								SCAPE.videoBg.videoSize($this);
								mediaElement.play();
								$this.closest('.wtbx_bg_video_wrapper').addClass('wtbx_poster_hidden');
								$this.closest('.wtbx_row_bg_inner').addClass('wtbx-element-visible');
							});
						}

						SCAPE.mediaelements[index] = mediaElement;
					},
					error:  function(domObject) {
						$(domObject).closest('.mejs-container').remove();
					}
				});
			});

		},

		videoSize: function($el) {
			if ( $el === undefined ) {
				$el = $('.wtbx_bg_video');
			}

			$el.each(function() {
				var $this   = $(this),
					$iframe = $this.find('.wtbx_bg_player'),
					$target, wW, wH;

				if ( $this.hasClass('wtbx_bg_youtube') ) {
					$target = $iframe.closest('.wtbx_bg_youtube');
					wW = 16;
					wH = 9;
				} else if ( $this.hasClass('wtbx_bg_selfhosted') ) {
					$target = $iframe;
					wW = $this.data('width');
					wH = $this.data('height');
				} else {
					$target = $iframe;
					wW = $iframe.data('width');
					wH = $iframe.data('height');
				}

				var pW = $this.closest('.wtbx_bg_video_wrapper').width(),
					pH = $this.closest('.wtbx_bg_video_wrapper').height(),
					wR = wW/pW,
					hR = wH/pH,
					scale = Math.min(wR,hR),
					add = 0,
					rH = (wH/scale)+add,
					rW = (wW/scale)+add/wH*wW;

				$target.css({
					'height':	rH+'px',
					'width':	rW+'px'
				});
			});
		}
	};

	jQuery(document).ready(function($) {
		SCAPE.videoBg.init();
	});

})(jQuery);