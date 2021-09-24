(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.gridGeneral = {

		init: function($container, type, postType) {
			$($container).each(function(){
				$container = $(this);
				SCAPE.gridGeneral.setup($container, type, postType);
				SCAPE.gridGeneral.lazyScroll($container, type, postType);

				$(window).scroll(function() {
					SCAPE.gridGeneral.lazyScroll($container, type, postType);
				});

				$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').each(function(index) {
					var $that = $(this).closest('.wtbx-grid-entry');
					setTimeout(function() {
						SCAPE.revealNoImage($that);
					}, index * 100);
				});

			});
		},

		getOptions: function($container, type, postType) {
			var objName = 'wtbx_' + type + '_';
			return window[objName + $container.data('id')];
		},

		setup: function($container, type, postType) {
			$container.each(function(){
				SCAPE.filterGrid.filter($container);

				$(this).siblings('.wtbx-loadmore-container').find('.wtbx-loadmore').on(SCAPE.click, function() {
					if ( SCAPE.gridGeneral.loadBusy === false ) {
						SCAPE.gridGeneral.loadPosts($container, type, postType);
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
						}, 600);
					}
				});
			});
		},

		loadBusy: false,

		limit: function($container, type, postType) {
			var limit		= parseInt($container.data('limit')),
				allowLoad	= true;
			if ( limit > 0 && limit >= SCAPE.gridGeneral.getOptions($container, type, postType).current_page ) {
				allowLoad = false;
			}
			return allowLoad;
		},

		loadPosts: function($container, type, postType) {
			SCAPE.gridGeneral.loadBusy = true;
			var data = {};

			if ( postType === 'blog' ) {
				data = {
					'action'			: 'loadmore_blog_' + type,
					'wpnonce'			: SCAPE.gridGeneral.getOptions($container, type, postType).wpnonce,
					'query'				: SCAPE.gridGeneral.getOptions($container, type, postType).query,
					'page'				: SCAPE.gridGeneral.getOptions($container, type, postType).current_page,
					'excerpt'			: SCAPE.gridGeneral.getOptions($container, type, postType).excerpt,
					'meta_array'		: SCAPE.gridGeneral.getOptions($container, type, postType).meta_array,
					'meta_class'		: SCAPE.gridGeneral.getOptions($container, type, postType).meta_class,
					'columns'			: SCAPE.gridGeneral.getOptions($container, type, postType).columns_minimal,
					'animation'			: SCAPE.gridGeneral.getOptions($container, type, postType).animation,
					'preview'			: SCAPE.gridGeneral.getOptions($container, type, postType).preview
				};
			} else if ( postType === 'portfolio' ) {
				data = {
					'action'			: 'loadmore_portfolio_' + type,
					'wpnonce'			: SCAPE.gridGeneral.getOptions($container, type, postType).wpnonce,
					'query'				: SCAPE.gridGeneral.getOptions($container, type, postType).query,
					'page'				: SCAPE.gridGeneral.getOptions($container, type, postType).current_page,
					'aspect_ratio'		: SCAPE.gridGeneral.getOptions($container, type, postType).aspect_ratio,
					'animation'			: SCAPE.gridGeneral.getOptions($container, type, postType).animation,
					'meta_primary'		: SCAPE.gridGeneral.getOptions($container, type, postType).meta_primary,
					'meta_secondary'	: SCAPE.gridGeneral.getOptions($container, type, postType).meta_secondary,
					'excerpt_length'	: SCAPE.gridGeneral.getOptions($container, type, postType).excerpt_length,
					'loadmore'          : SCAPE.gridGeneral.getOptions($container, type, postType).loadmore
				};
			}

			$.ajax({
				url		: SCAPE.gridGeneral.getOptions($container, type, postType).ajaxurl,
				data	: data,
				type	: 'POST',
				success	: function(data) {
					if ( data ) {
						var $loadmore = $container.siblings('.wtbx-loadmore-container');
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
								var $that = $(this).closest('.wtbx-grid-entry');
								setTimeout(function() {
									SCAPE.revealNoImage($that);
								}, index * 100);
							});

							SCAPE.filterGrid.filter($container);
							SCAPE.filterGrid.filterHideShow($container);
							SCAPE.filterGrid.filterKnob($container.closest('.filter-slider').find('.wtbx-filter'), $container.closest('.filter-slider').find('.wtbx-filter-button').filter('.active'));

							SCAPE.mediaplayer($container.find('.wtbx_video_player_embed, .wtbx-media-selfhosted video, .wtbx-media-selfhosted audio'));
							SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));
							SCAPE.gridGeneral.getOptions($container, type, postType).current_page++;

							var allLoadedTimer = setInterval(function() {
								if ( !$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
									SCAPE.gridGeneral.loadBusy = false;
									SCAPE.gridGeneral.lazyScroll($container, type, postType);
									clearInterval(allLoadedTimer);
								}
							}, 200);

						}, 300);
					}
				}
			});
		},

		lazyScroll: function($container, type, postType) {
			if ( SCAPE.gridGeneral.getOptions($container, type, postType) ) {
				if ( SCAPE.gridGeneral.getOptions($container, type, postType).loadmore !== '' ) {
					if ( SCAPE.gridGeneral.getOptions($container, type, postType).max_pages > SCAPE.gridGeneral.getOptions($container, type, postType).current_page && SCAPE.gridGeneral.limit($container, type, postType) ) {
						if ( SCAPE.gridGeneral.loadBusy === false ) {
							var pages		= SCAPE.gridGeneral.getOptions($container, type, postType).current_page,
								loadmore	= SCAPE.gridGeneral.getOptions($container, type, postType).loadmore;

							if ( pages % loadmore === 0 ) {
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							} else {
								$container.parent().children('.wtbx-loadmore-container').removeClass('loadmore-visible');

								var scrollTop		= SCAPE.scrollTop.get,
									windowH			= SCAPE.viewport().height,
									containerTop	= $container.offset().top,
									containerH		= $container.outerHeight();

								if ( scrollTop + windowH > containerTop + containerH ) {
									SCAPE.gridGeneral.loadPosts($container, type, postType);
								}
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				} else {
					if ( SCAPE.gridGeneral.getOptions($container, type, postType).max_pages > SCAPE.gridGeneral.getOptions($container, type, postType).current_page && SCAPE.gridGeneral.limit($container, type, postType) ) {
						if (SCAPE.gridGeneral.loadBusy === false) {
							var scrollTop		= SCAPE.scrollTop.get,
								windowH			= SCAPE.viewport().height,
								containerTop	= $container.offset().top,
								containerH		= $container.outerHeight();
							if ( scrollTop + windowH > containerTop + containerH ) {
								SCAPE.gridGeneral.loadPosts($container, type, postType);
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
		SCAPE.gridGeneral.init($('.wtbx-grid-column'), 'column', 'blog');
		SCAPE.gridGeneral.init($('.wtbx-grid-magazine'), 'magazine', 'blog');
		SCAPE.gridGeneral.init($('.blog-grid.wtbx-grid-boxed'), 'boxed', 'blog');
		SCAPE.gridGeneral.init($('.wtbx-grid-overlap'), 'overlap', 'portfolio');
	});

})(jQuery);