(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.isotopeMetro = {

		init: function($container) {
			$($container).each(function(){
				SCAPE.isotopeMetro.setup($(this));
				$container = $(this);
				SCAPE.isotopeMetro.lazyScroll($container);
				$(window).scroll(function() {
					SCAPE.isotopeMetro.lazyScroll($container);
				});
			});
		},

		getOptions: function($container) {
			var objName = 'wtbx_metro_';
			return window[objName + $container.data('id')];
		},

		tileSize: function($container) {
			if ( $container.find('.wtbx-metro-entry').length ) {
				var $item	= $container.find('.wtbx-metro-entry');
				var columns	= $container.data('columns');
				var layout_cols = $container.data('layout-cols') || columns;
				var gutter	= $container.data('gutter') || 0;
				var layout;

				var min_width	= $container.data('minwidth') || 0;
				var breakpoint1 = min_width > 0 ? min_width*2 : 600,
					breakpoint2 = min_width > 0 ? min_width*4 : 1100,
					breakpoint3 = min_width > 0 ? min_width*6 : 1700;

				var width		= $container.outerWidth();
				var paddingH	= gutter,
					paddingV	= gutter;

				if ( width - Math.min(paddingH,15) * 2 < 400 ) {
					gutter		= Math.min(gutter,15);
					paddingH	= gutter;
					paddingV	= gutter;
				}

				$item.each(function() {
					var tile_width	= $(this).data('width'),
						tile_height	= $(this).data('height'),
						col_width, item_width, item_height;

					if ( width - paddingH * 2 < breakpoint1 ) {
						item_width	= width - gutter * 2;
						item_height	= width - gutter * 2;
					} else if (width - paddingH * 2 < breakpoint2) {
						layout_cols = Math.min(2,layout_cols);
						item_width = item_height = ( width - gutter * (layout_cols - 1) - paddingH * 2 ) / layout_cols;
					} else if (width - paddingH * 2 < breakpoint3) {
						if ( undefined === $container.data('layout-cols') ) {
							layout_cols = Math.min(4,layout_cols);
						}
						col_width	= Math.floor(( width - gutter * ( layout_cols - 1 ) - paddingH * 2 ) / layout_cols);
						item_width	= col_width * tile_width + gutter * ( tile_width - 1 );
						item_height	= col_width * tile_height + gutter * ( tile_height - 1 );
					} else {
						col_width	= Math.floor(( width - gutter * ( layout_cols - 1 ) - paddingH * 2 ) / layout_cols);
						item_width	= col_width * tile_width + gutter * ( tile_width - 1 );
						item_height	= col_width * tile_height + gutter * ( tile_height - 1 );
					}

					$(this).css({
						width: Math.floor(item_width) + 'px',
						height: Math.floor(item_height) + 'px'
					});

				});

				$container.parent().children('.wtbx-pagination').find('.wtbx-pagination-inner').css({
					'padding': '0 ' + paddingH + 'px'
				});

				$container.css({
					'padding': paddingV + 'px ' + paddingH + 'px'
				});
				$container.closest('.wtbx_item_grid_wrapper').find('.filter-sidebar').css({
					'padding-top': paddingV + 'px',
					'padding-bottom': paddingV + 'px'
				});
			}
		},

		layout: function($container) {
			var columns	= $container.data('columns');
			var gutter	= $container.data('gutter') || 0;
			var border	= $container.data('border') || 0;

			SCAPE.isotopeMetro.tileSize($container);

			if ( $container.parent().outerWidth() - Math.min(gutter,15) * 2 < 400 ) {
				gutter = Math.min(gutter,15);
			}

			$container.isotope({
				itemSelector : '.wtbx-metro-entry',
				percentPosition: false,
				layoutMode : 'packery',
				transitionDuration: '0s',
				packery: {
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

			$container.find('.wtbx-entry-inner').css({ 'border-radius': border + 'px' });

			$container.on('arrangeComplete', function() {
				setTimeout(function() {
					$container.removeClass('wtbx_overflow');
				},300);
			});
			SCAPE.filterGrid.filter($container);
		},

		setup: function($container) {
			SCAPE.isotopeMetro.layout($container);

			setTimeout(function() {
				SCAPE.isotopeMetro.layout($container);
			}, 1000);

			$(window).on('resize', function(){
				SCAPE.isotopeMetro.layout($container);
			});

			$container.parent().children('.wtbx-loadmore-container').find('.wtbx-loadmore').on(SCAPE.click, function() {
				if ( SCAPE.isotopeMetro.loadBusy === false ) {
					SCAPE.isotopeMetro.loadPosts($container);
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
		},

		loadBusy: false,

		limit: function($container) {
			var limit		= parseInt($container.data('limit')),
				allowLoad	= true;
			if ( limit > 0 && limit >= SCAPE.isotopeMetro.getOptions($container).current_page ) {
				allowLoad = false;
			}
			return allowLoad;
		},

		loadPosts: function($container) {
			SCAPE.isotopeMetro.loadBusy = true;
			var gridType = $container.data('grid');
			var data = {};
			if ( gridType === 'blog' ) {
				data = {
					'action'		: 'loadmore_blog_metro',
					'wpnonce'		: SCAPE.isotopeMetro.getOptions($container).wpnonce,
					'query'			: SCAPE.isotopeMetro.getOptions($container).query,
					'page'			: SCAPE.isotopeMetro.getOptions($container).current_page,
					'animation'		: SCAPE.isotopeMetro.getOptions($container).animation,
					'meta_array'	: SCAPE.isotopeMetro.getOptions($container).meta_array,
					'meta_class'	: SCAPE.isotopeMetro.getOptions($container).meta_class,
					'post_overlay'	: SCAPE.isotopeMetro.getOptions($container).post_overlay,
					'grid_layout'	: SCAPE.isotopeMetro.getOptions($container).grid_layout,
					'loadmore'		: SCAPE.isotopeMetro.getOptions($container).loadmore
				};
			} else if ( gridType === 'portfolio' ) {
				data = {
					'action'			: 'loadmore_portfolio_metro',
					'wpnonce'			: SCAPE.isotopeMetro.getOptions($container).wpnonce,
					'query'				: SCAPE.isotopeMetro.getOptions($container).query,
					'page'				: SCAPE.isotopeMetro.getOptions($container).current_page,
					'animation'			: SCAPE.isotopeMetro.getOptions($container).animation,
					'portfolio_overlay'	: SCAPE.isotopeMetro.getOptions($container).portfolio_overlay,
					'portfolio_overlay_h'	: SCAPE.isotopeMetro.getOptions($container).portfolio_overlay_hover,
					'overlay_content'	: SCAPE.isotopeMetro.getOptions($container).overlay_content,
					'meta_primary'		: SCAPE.isotopeMetro.getOptions($container).meta_primary,
					'meta_secondary'	: SCAPE.isotopeMetro.getOptions($container).meta_secondary,
					'overlay_trigger'	: SCAPE.isotopeMetro.getOptions($container).overlay_trigger,
					'grid_layout'		: SCAPE.isotopeMetro.getOptions($container).grid_layout,
					'like'				: SCAPE.isotopeMetro.getOptions($container).like,
					'overlay_mobile'	: SCAPE.isotopeMetro.getOptions($container).overlay_mobile,
					'click_action'		: SCAPE.isotopeMetro.getOptions($container).click_action,
					'overlay_idle'                          : SCAPE.isotopeMetro.getOptions($container).overlay_idle,
					'overlay_hover'                         : SCAPE.isotopeMetro.getOptions($container).overlay_hover,
					'meta_primary_hover'                    : SCAPE.isotopeMetro.getOptions($container).meta_primary_hover,
					'meta_secondary_hover'                  : SCAPE.isotopeMetro.getOptions($container).meta_secondary_hover,
					'action_button_link'                    : SCAPE.isotopeMetro.getOptions($container).action_button_link,
					'action_button_gallery_all'             : SCAPE.isotopeMetro.getOptions($container).action_button_gallery_all,
					'action_button_gallery_item'            : SCAPE.isotopeMetro.getOptions($container).action_button_gallery_item,
					'caption_primary'   : SCAPE.isotopeMetro.getOptions($container).caption_primary,
					'caption_secondary'	: SCAPE.isotopeMetro.getOptions($container).caption_secondary,
					'share'				: SCAPE.isotopeMetro.getOptions($container).share,
					'loadmore'			: SCAPE.isotopeMetro.getOptions($container).loadmore
				};
			}

			$.ajax({
				url		: SCAPE.isotopeMetro.getOptions($container).ajaxurl,
				data	: data,
				type	: 'POST',
				success	: function(data){
					if( data ) {
						var $loadmore = $container.parent().children('.wtbx-loadmore-container');
						$loadmore.removeClass('loadmore-visible');

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
							SCAPE.isotopeMetro.layout($container);
							SCAPE.filterGrid.filter($container);

							// Update filter
							SCAPE.filterGrid.filterHideShow($container);
							SCAPE.filterGrid.filterKnob($container.closest('.filter-slider').find('.wtbx-filter'), $container.closest('.filter-slider').find('.wtbx-filter-button').filter('.active'));

							// Prettify like button
							SCAPE.prettyLike();

							SCAPE.waypoints($container.find('.wtbx-element-reveal:not(.wtbx-element-visible)'));

							SCAPE.isotopeMetro.getOptions($container).current_page++;

							var allLoadedTimer = setInterval(function() {
								if ( !$container.find('.wtbx-element-reveal:not(.wtbx-element-visible)').length ) {
									SCAPE.isotopeMetro.loadBusy = false;
									SCAPE.isotopeMetro.lazyScroll($container);
									clearInterval(allLoadedTimer);
								}
							}, 200);

						}, 300);
					}
				}
			});
		},

		lazyScroll: function($container) {
			if ( SCAPE.isotopeMetro.getOptions($container) ) {
				if ( SCAPE.isotopeMetro.getOptions($container).loadmore !== '' ) {
					if ( SCAPE.isotopeMetro.getOptions($container).max_pages > SCAPE.isotopeMetro.getOptions($container).current_page && SCAPE.isotopeMetro.limit($container) ) {
						if ( SCAPE.isotopeMetro.loadBusy === false ) {
							var pages		= SCAPE.isotopeMetro.getOptions($container).current_page,
								loadmore	= SCAPE.isotopeMetro.getOptions($container).loadmore;

							if ( pages % loadmore === 0 ) {
								$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-visible');
							} else {
								$container.parent().children('.wtbx-loadmore-container').removeClass('loadmore-visible');

								var scrollTop		= SCAPE.scrollTop.get,
									windowH			= SCAPE.viewport().height,
									containerTop	= $container.offset().top,
									containerH		= $container.outerHeight();

								if ( scrollTop + windowH > containerTop + containerH ) {
									SCAPE.isotopeMetro.loadPosts($container);
								}
							}
						}
					} else {
						$container.parent().children('.wtbx-loadmore-container').addClass('loadmore-hidden');
					}
				} else {
					if ( SCAPE.isotopeMetro.getOptions($container).max_pages > SCAPE.isotopeMetro.getOptions($container).current_page && SCAPE.isotopeMetro.limit($container) ) {
						if (SCAPE.isotopeMetro.loadBusy === false) {
							var scrollTop		= SCAPE.scrollTop.get,
								windowH			= SCAPE.viewport().height,
								containerTop	= $container.offset().top,
								containerH		= $container.outerHeight();
							if ( scrollTop + windowH > containerTop + containerH ) {
								SCAPE.isotopeMetro.loadPosts($container);
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
		setTimeout(function() {
			SCAPE.isotopeMetro.init($('.wtbx-grid-metro'));
		});
		setTimeout(function() {
			SCAPE.isotopeMetro.tileSize($('.wtbx-grid-metro'));
		});
	});

})(jQuery);