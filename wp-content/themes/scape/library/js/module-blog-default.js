(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.blogDefault = {

		init: function($container) {
			$($container).each(function(){
				$container = $(this);
				SCAPE.blogDefault.setup($container);
				SCAPE.blogDefault.lazyScroll($container);

				$(window).scroll(function() {
					SCAPE.blogDefault.lazyScroll($container);
				});

			});
		},

		getOptions: function($container) {
			var objName = 'wtbx_default_';
			return window[objName + $container.data('id')];
		},

		setup: function($container) {
			$container.each(function(){
				$(this).parent().children('.wtbx-loadmore-container').find('.wtbx-loadmore').on(SCAPE.click, function() {
					if ( SCAPE.blogDefault.loadBusy === false ) {
						SCAPE.blogDefault.loadPosts($container);
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
			});
		},

		loadBusy: false,

		limit: function($container) {
			var limit		= parseInt($container.data('limit')),
				allowLoad	= true;
			if ( limit > 0 && limit >= SCAPE.blogDefault.getOptions($container).current_page ) {
				allowLoad = false;
			}
			return allowLoad;
		},

		loadPosts: function($container) {
			SCAPE.blogDefault.loadBusy = true;

			var data = {
				'action'		: 'loadmore_blog_default',
				'wpnonce'		: SCAPE.blogDefault.getOptions($container).wpnonce,
				'query'			: SCAPE.blogDefault.getOptions($container).query,
				'page'			: SCAPE.blogDefault.getOptions($container).current_page,
				'preview'		: SCAPE.blogDefault.getOptions($container).preview,
				'excerpt'		: SCAPE.blogDefault.getOptions($container).excerpt,
				'meta_array'	: SCAPE.blogDefault.getOptions($container).meta_array,
				'meta_class'	: SCAPE.blogDefault.getOptions($container).meta_class
			};

			$.ajax({
				url		: SCAPE.blogDefault.getOptions($container).ajaxurl,
				data	: data,
				type	: 'POST',
				success	: function(data){
					if( data ) {
						var $loadmore = $container.parent().children('.wtbx-loadmore-container');
						$loadmore.removeClass('loadmore-visible');

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

							// Initiate media in newly loaded posts
							SCAPE.initPostMedia.media_selfhosted();
							SCAPE.initPostMedia.media_iframe();

							$container.find('.post-gallery').each(function() {
								if ( !$(this).hasClass('slick-slider') ) {
									SCAPE.initPostMedia.gallery($(this), true);
									$(this).slick('slickGoTo', 0);
								}
							});

							SCAPE.customCursor.bindClick($container.find('.wtbx-arrow'));
							SCAPE.customCursor.bindClick($container.find('.slick-dots li'));

							SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));

							SCAPE.blogDefault.getOptions($container).current_page++;

							var allLoadedTimer = setInterval(function() {
								if ( !$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
									SCAPE.blogDefault.loadBusy = false;
									SCAPE.blogDefault.lazyScroll($container);
									clearInterval(allLoadedTimer);
								}
							}, 200);

						}, 300);
					}
				}
			});
		},

		lazyScroll: function($container) {
			if ( SCAPE.blogDefault.getOptions($container) ) {
				if ( SCAPE.blogDefault.getOptions($container).loadmore !== '' ) {
					if ( SCAPE.blogDefault.getOptions($container).max_pages > SCAPE.blogDefault.getOptions($container).current_page && SCAPE.blogDefault.limit($container) ) {
						if ( SCAPE.blogDefault.loadBusy === false ) {
							var pages		= SCAPE.blogDefault.getOptions($container).current_page,
								loadmore	= SCAPE.blogDefault.getOptions($container).loadmore;

							if ( pages % loadmore === 0 ) {
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							} else {
								$container.parent().children('.wtbx-loadmore-container').removeClass('loadmore-visible');

								var scrollTop		= SCAPE.scrollTop.get,
									windowH			= SCAPE.viewport().height,
									containerTop	= $container.offset().top,
									containerH		= $container.outerHeight();

								if ( scrollTop + windowH > containerTop + containerH ) {
									SCAPE.blogDefault.loadPosts($container);
								}
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				} else {
					if ( SCAPE.blogDefault.getOptions($container).max_pages > SCAPE.blogDefault.getOptions($container).current_page && SCAPE.blogDefault.limit($container) ) {
						if (SCAPE.blogDefault.loadBusy === false) {
							var scrollTop		= SCAPE.scrollTop.get,
								windowH			= SCAPE.viewport().height,
								containerTop	= $container.offset().top,
								containerH		= $container.outerHeight();
							if ( scrollTop + windowH > containerTop + containerH ) {
								SCAPE.blogDefault.loadPosts($container);
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

	jQuery(document).ready(function($) {
		SCAPE.blogDefault.init($('.wtbx-grid-default'));
	});

})(jQuery);