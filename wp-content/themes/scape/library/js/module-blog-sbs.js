(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.blogSBS = {

		init: function($container) {
			$($container).each(function(){
				$container = $(this);
				SCAPE.blogSBS.setup($container);
				SCAPE.blogSBS.lazyScroll($container);

				$(window).scroll(function() {
					SCAPE.blogSBS.lazyScroll($container);
				});

				$(window).resize(function() {
					SCAPE.waitForFinalEvent( function() {
					}, SCAPE.timeToWaitForLast, 'blogSBStext');
				});
			});
		},

		getOptions: function($container) {
			var objName = 'wtbx_sbs_';
			return window[objName + $container.data('id')];
		},

		setup: function($container) {
			$container.each(function(){
				$(this).parent().children('.wtbx-loadmore-container').find('.wtbx-loadmore').on(SCAPE.click, function() {
					if ( SCAPE.blogSBS.loadBusy === false ) {
						SCAPE.blogSBS.loadPosts($container);
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
			if ( limit > 0 && limit >= SCAPE.blogSBS.getOptions($container).current_page ) {
				allowLoad = false;
			}
			return allowLoad;
		},

		loadPosts: function($container) {
			SCAPE.blogSBS.loadBusy = true;

			var data = {
				'action'		: 'loadmore_blog_sbs',
				'wpnonce'		: SCAPE.blogSBS.getOptions($container).wpnonce,
				'query'			: SCAPE.blogSBS.getOptions($container).query,
				'page'			: SCAPE.blogSBS.getOptions($container).current_page,
				'excerpt'		: SCAPE.blogSBS.getOptions($container).excerpt,
				'meta_array'	: SCAPE.blogSBS.getOptions($container).meta_array,
				'meta_class'	: SCAPE.blogSBS.getOptions($container).meta_class,
				'animation'		: SCAPE.blogSBS.getOptions($container).animation,
				'media_width'	: SCAPE.blogSBS.getOptions($container).media_width,
				'aspect_ratio'	: SCAPE.blogSBS.getOptions($container).aspect_ratio
			};

			$.ajax({
				url		: SCAPE.blogSBS.getOptions($container).ajaxurl,
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

							// Update filter
							SCAPE.filterGrid.filterHideShow($container);

							// Reattach filter
							SCAPE.filterGrid.filter($container);

							// Prettify like button
							SCAPE.prettyLike();

							SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));

							//SCAPE.entryReveal();
							SCAPE.blogSBS.getOptions($container).current_page++;

							var allLoadedTimer = setInterval(function() {
								if ( !$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
									SCAPE.blogSBS.loadBusy = false;
									SCAPE.blogSBS.lazyScroll($container);
									clearInterval(allLoadedTimer);
								}
							}, 200);

						}, 300);
					}
				}
			});
		},

		lazyScroll: function($container) {
			if ( SCAPE.blogSBS.getOptions($container) ) {
				if ( SCAPE.blogSBS.getOptions($container).loadmore !== '' ) {
					if ( SCAPE.blogSBS.getOptions($container).max_pages > SCAPE.blogSBS.getOptions($container).current_page && SCAPE.blogSBS.limit($container) ) {
						if ( SCAPE.blogSBS.loadBusy === false ) {
							var pages		= SCAPE.blogSBS.getOptions($container).current_page,
								loadmore	= SCAPE.blogSBS.getOptions($container).loadmore;

							if ( pages % loadmore === 0 ) {
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							} else {
								$container.parent().children('.wtbx-loadmore-container').removeClass('loadmore-visible');

								var scrollTop		= SCAPE.scrollTop.get,
									windowH			= SCAPE.viewport().height,
									containerTop	= $container.offset().top,
									containerH		= $container.outerHeight();

								if ( scrollTop + windowH > containerTop + containerH ) {
									SCAPE.blogSBS.loadPosts($container);
								}
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				} else {
					if ( SCAPE.blogSBS.getOptions($container).max_pages > SCAPE.blogSBS.getOptions($container).current_page && SCAPE.blogSBS.limit($container) ) {
						if (SCAPE.blogSBS.loadBusy === false) {
							var scrollTop		= SCAPE.scrollTop.get,
								windowH			= SCAPE.viewport().height,
								containerTop	= $container.offset().top,
								containerH		= $container.outerHeight();
							if ( scrollTop + windowH > containerTop + containerH ) {
								SCAPE.blogSBS.loadPosts($container);
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
		SCAPE.blogSBS.init($('.wtbx-grid-sbs'));
	});

})(jQuery);