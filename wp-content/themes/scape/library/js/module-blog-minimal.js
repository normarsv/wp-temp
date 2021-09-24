(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.blogMinimal = {

		init: function($container) {
			$($container).each(function(){
				$container = $(this);
				SCAPE.blogMinimal.setup($container);
				SCAPE.blogMinimal.lazyScroll($container);

				$(window).scroll(function() {
					SCAPE.blogMinimal.lazyScroll($container);
				});

				$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').each(function(index) {
					var $that = $(this).closest('.wtbx-minimal-entry');
					setTimeout(function() {
						SCAPE.revealNoImage($that);
					}, index * 100);
				});

			});
		},

		getOptions: function($container) {
			var objName = 'wtbx_minimal_';
			return window[objName + $container.data('id')];
		},

		setup: function($container) {
			$container.each(function(){
				$(this).parent().children('.wtbx-loadmore-container').find('.wtbx-loadmore').on(SCAPE.click, function() {
					if ( SCAPE.blogMinimal.loadBusy === false ) {
						SCAPE.blogMinimal.loadPosts($container);
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
			if ( limit > 0 && limit >= SCAPE.blogMinimal.getOptions($container).current_page ) {
				allowLoad = false;
			}
			return allowLoad;
		},

		loadPosts: function($container) {
			SCAPE.blogMinimal.loadBusy = true;

			var data = {
				'action'			: 'loadmore_blog_minimal',
				'wpnonce'			: SCAPE.blogMinimal.getOptions($container).wpnonce,
				'query'				: SCAPE.blogMinimal.getOptions($container).query,
				'page'				: SCAPE.blogMinimal.getOptions($container).current_page,
				'excerpt'			: SCAPE.blogMinimal.getOptions($container).excerpt,
				'meta_array'		: SCAPE.blogMinimal.getOptions($container).meta_array,
				'meta_class'		: SCAPE.blogMinimal.getOptions($container).meta_class,
				'columns_minimal'	: SCAPE.blogMinimal.getOptions($container).columns_minimal,
				'animation'			: SCAPE.blogMinimal.getOptions($container).animation,
				'reading_time'		: SCAPE.blogMinimal.getOptions($container).reading_time
			};

			$.ajax({
				url		: SCAPE.blogMinimal.getOptions($container).ajaxurl,
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
							SCAPE.prettyLike();

							$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').each(function(index) {
								var $that = $(this).closest('.wtbx-minimal-entry');
								setTimeout(function() {
									SCAPE.revealNoImage($that);
								}, index * 100);
							});

							SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));
							SCAPE.blogMinimal.getOptions($container).current_page++;

							var allLoadedTimer = setInterval(function() {
								if ( !$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
									SCAPE.blogMinimal.loadBusy = false;
									SCAPE.blogMinimal.lazyScroll($container);
									clearInterval(allLoadedTimer);
								}
							}, 200);

						}, 300);
					}
				}
			});
		},

		lazyScroll: function($container) {
			if ( SCAPE.blogMinimal.getOptions($container) ) {
				if ( SCAPE.blogMinimal.getOptions($container).loadmore !== '' ) {
					if ( SCAPE.blogMinimal.getOptions($container).max_pages > SCAPE.blogMinimal.getOptions($container).current_page && SCAPE.blogMinimal.limit($container) ) {
						if ( SCAPE.blogMinimal.loadBusy === false ) {
							var pages		= SCAPE.blogMinimal.getOptions($container).current_page,
								loadmore	= SCAPE.blogMinimal.getOptions($container).loadmore;

							if ( pages % loadmore === 0 ) {
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							} else {
								$container.parent().children('.wtbx-loadmore-container').removeClass('loadmore-visible');

								var scrollTop		= SCAPE.scrollTop.get,
									windowH			= SCAPE.viewport().height,
									containerTop	= $container.offset().top,
									containerH		= $container.outerHeight();

								if ( scrollTop + windowH > containerTop + containerH ) {
									SCAPE.blogMinimal.loadPosts($container);
								}
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				} else {
					if ( SCAPE.blogMinimal.getOptions($container).max_pages > SCAPE.blogMinimal.getOptions($container).current_page && SCAPE.blogMinimal.limit($container) ) {
						if (SCAPE.blogMinimal.loadBusy === false) {
							var scrollTop		= SCAPE.scrollTop.get,
								windowH			= SCAPE.viewport().height,
								containerTop	= $container.offset().top,
								containerH		= $container.outerHeight();
							if ( scrollTop + windowH > containerTop + containerH ) {
								SCAPE.blogMinimal.loadPosts($container);
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
		SCAPE.blogMinimal.init($('.wtbx-grid-minimal'));
	});

})(jQuery);