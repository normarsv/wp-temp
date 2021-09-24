
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.isotopeShop = {

		init: function($container) {
			$($container).each(function(){
				$container = $(this);
			});
		},

		setup: function($container) {
			if ( $container.find('.wtbx-masonry-entry').length ) {
				$(window).on('resize', function(){
					SCAPE.waitForFinalEvent( function() {
					}, SCAPE.timeToWaitForLast, 'shop_grid');
				});
			}
		},

		layout: function($container) {
			var $item	= $container.find('.wtbx-product-entry');

			var width		= $container.outerWidth(true);
			var columns		= $container.data('columns');
			var cat_columns	= $container.data('cat-columns');
			var animate		= $container.data('animate');
			var border		= $container.data('border') || 0;

			if (width < 500) {
				columns = 1;
			} else if (width < 850) {
				columns = Math.min(2,columns);
			} else if (width < 1200) {
				columns = Math.min(3,columns);
			}

			if (width < 500) {
				cat_columns = 1;
			} else if (width < 900) {
				cat_columns = Math.min(2,cat_columns);
			} else if (width < 1200) {
				cat_columns = Math.min(3,cat_columns);
			}

			var column_width		= Math.floor( width / columns );
			var cat_column_width	= Math.floor( width / cat_columns );

			$container.find('.wtbx-product-single-entry').css({
				'width': column_width + 'px'
			});
			$container.find('.wtbx-product-category-entry').css({
				'width': cat_column_width + 'px'
			});

			$container.isotope({
				itemSelector : '.wtbx-masonry-entry',
				resizable : true,
				layoutMode : 'masonry',
				masonry: {
					gutter: 0
				},
				transitionDuration: animate,
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				}
			});

			if ( !$container.hasClass('wtbx-isotope-init') ) {
				$container.find('.wtbx-product-wrapper').each(function(index) {
					var $this = $(this);
					setTimeout(function() {
						$this.addClass('wtbx-element-visible');
					}, index * 100);
				});
			}

			$container.addClass('wtbx-isotope-init');

		}

	};



	SCAPE.woocommerceModule = {

		quantity: function($el) {

			if ( !$el ) {
				$el = $('.wtbx-quantity');
			}

			$el.each(function() {
				var $container	= $(this),
					$input		= $container.find('input'),
					$plus		= $container.find('.plus'),
					$minus		= $container.find('.minus'),
					step		= parseInt($container.find('.qty').attr('step'));

				$plus.unbind().on('click', function() {
					var value	= parseInt($input.val()),
						max		= $input.attr('max');
					if ( value < max || !max ) {
						$input.val(value + step);
					}
					if ( isNaN(value) ) {
						$input.val(1);
					}
					$( 'div.woocommerce > form button[name="update_cart"], .wc-proceed-to-checkout > [name="update_cart"]' ).prop( 'disabled', false );
				});
				$minus.unbind().on('click', function() {
					var value	= parseInt($input.val()),
						min		= $input.attr('min') || 1;

					value = value - step;
					if ( value < min ) {
						value = min;
					}
					$input.val(value);

					$( 'div.woocommerce > form button[name="update_cart"], .wc-proceed-to-checkout > [name="update_cart"]' ).prop( 'disabled', false );
				});

				$input.on('blur', function() {
					if ( $input.val() === '' || $input.val() === '0' ) {
						$input.val(1);
					}
				});

				var $variations	= $('.single_variation_wrap');
				if ( $variations.length ) {
					var $select	= $variations.find('.variation_id');
					$select.on('change', function() {
						setTimeout(function() {
							var value	= parseInt($input.val()),
								max		= $input.attr('max');
							if ( max && value > max ) {
								$input.val(max);
							}
						},100);
					});
				}

			});
		},

		variations: function() {
			var $variations	= $('.single_variation_wrap');
			if ( $variations.length ) {
				var $gallery = $variations.closest('.product').find('.images');
				var $form	 = $variations.closest('.variations_form');
				$gallery.on( 'woocommerce_gallery_reset_slide_position', function() {
					var $curr_image		= $gallery.find('.thumbnails').find('.thumb-wrapper.active a'),
						curr_image_id	= $curr_image.data('image'),
						new_image_id	= $form.attr('current-image');

					if ( curr_image_id && curr_image_id !== new_image_id ) {
						$gallery.find('.thumbnails').find('a[data-image="' + new_image_id + '"]').closest('.thumb-wrapper').trigger('click');
					}
				} );
			}
		},

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
					$thumbnails.find('.thumb-wrapper').on('click', function() {
						$thumbnails.find('.thumb-wrapper').removeClass('active');
						$(this).addClass('active');
						$mainSlider.slick('slickGoTo', $(this).index());
					});

				}

				// image zoom
				$mainSlider.find('.thumb-wrapper')
					.on('mouseenter', function() {
						$(this).addClass('active');
						$(this).find('.thumb-fullsize').css('opacity', '1');
					})
					.on('mouseleave', function() {
						var $this = $(this);
						$this.removeClass('active');
						$this.find('.thumb-fullsize').css('opacity', '0');
						setTimeout(function() {
							if ( !$this.hasClass('active') ) {
								$this.find('.thumb-fullsize').attr('style', '');
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

		productActions: function() {
			var $actions = $('.wtbx-product-actions');
			if ($actions.length) {
				$actions.each(function() {
					var $actions = $(this).closest('.wtbx-product-actions');
					var $trigger = $actions.find('.product-actions-trigger');

					$trigger.on('mouseenter touchend', function(e) {
						if( !$actions.hasClass('active') ) {
							$actions.addClass('active');
						}
					});

					$actions.on('mouseleave touchend', function(e) {
						var $actions = $(this);
						if( $actions.hasClass('active') ) {
							$actions.removeClass('active');
						}
					});
				});
			}
		},

		productCarousel: function($el) {

			if ( !$el ) {
				$el = $('.wtbx-grid-products');
			}

			$el.each(function() {
				if ( !$(this).hasClass('product-carousel-init') ) {
					if ( $(this).parent().parent('.woocommerce').length && $(this).closest('.product-slider').length ) {
						var columns = $(this).attr('class');
						columns = columns.split('columns-')[1];
						columns = columns.split(' ')[0];
						$(this).addClass('wtbx-product-carousel');
						$(this).attr('data-perpage', columns);
					}
				}
			});

			$('.wtbx-product-carousel').each(function() {
				var $slider		= $(this);

				if ( !$slider.hasClass('product-carousel-init') ) {
					var options = {
						prevNextButtons:	false,
						wrapAround:			true,
						cellAlign:			'left',
						selectedAttraction:	0.08,
						friction:			0.8,
						pageDots:			false
					};

					setTimeout(function() {
						$slider.flickity(options);
					});
					$slider.addClass('product-carousel-init');

					setTimeout(function() {
						$slider.flickity('resize');
					}, 500);
				}
			});
		},

		productGrid: {

			init: function() {
				$('.wtbx-grid-products').each(function(){
					if ( !$(this).parent().parent('.woocommerce').length ) {
						var $container = $(this);
						SCAPE.woocommerceModule.productGrid.setup($container);
					}
				});
			},

			setup: function($container) {
				if ( $container.find('.wtbx-grid-entry').length ) {
					SCAPE.woocommerceModule.productGrid.layout($container);
					$(window).on('resize', function(){
						SCAPE.woocommerceModule.productGrid.layout($container);
					});

					setTimeout(function() {
						SCAPE.woocommerceModule.productGrid.layout($container);
					}, 1000);
				}
			},

			layout: function($container) {
				var $item		= $container.find('.wtbx-grid-entry');
				var count		= $container.find('.wtbx-product-single-entry').length;
				var count_cat	= $container.find('.wtbx-product-category-entry').length;
				var width		= $container.width();
				var columns		= $container.data('columns');
				var cat_columns	= $container.data('cat-columns');
				var animate		= $container.data('animate');
				var border		= $container.data('border') || 0;

				if ( width < 540 ) {
					columns = 1;
				} else if ( width < 810 ) {
					columns = 2;
				} else {
					if ( columns === 4 ) {
						if ( width < 1080 ) {
							if ( count % 3 === 0 ) {
								columns = 3;
							} else {
								columns = 2;
							}
						}
					} else if ( columns === 5 ) {
						if ( width < 1080 ) {
							if ( count % 3 === 0 ) {
								columns = 3;
							} else {
								columns = 2;
							}
						} else if ( width < 1350 ) {
							if ( count % 4 === 0 ) {
								columns = 4;
							} else if ( count % 3 === 0 ) {
								columns = 3;
							}
						}
					} else if ( columns === 6 ) {
						if ( width < 1080 ) {
							columns = 3;
						} else if ( width < 1350 ) {
							if ( count % 4 === 0 ) {
								columns = 4;
							} else {
								columns = 3;
							}
						} else if ( width < 1620 ) {
							if ( count % 5 === 0 ) {
								columns = 5;
							} else if ( count % 4 === 0 ) {
								columns = 4;
							} else {
								columns = 3;
							}
						}
					}
				}

				if ( width < 700 ) {
					cat_columns = 1;
				} else if ( width < 1050 ) {
					cat_columns = 2;
				} else if ( width < 1400 ) {
					if ( cat_columns === 4 ) {
						if ( count_cat % 3 === 0 ) {
							cat_columns = 3;
						} else {
							cat_columns = 2;
						}
					}
				}

				var column_width		= Math.floor( width / columns );
				var cat_column_width	= Math.floor( width / cat_columns );

				$container.find('.wtbx-product-single-entry').css({
					'width': column_width + 'px'
				});
				$container.find('.wtbx-product-category-entry').css({
					'width': cat_column_width + 'px'
				});

				$('.wtbx-product-single-entry').each(function(index) {
					$(this).removeClass('first last');
					if ( (index + 1) % columns === 0 ) {
						$(this).addClass('last').next().addClass('first');
					}
				});
				$('.wtbx-product-category-entry').each(function(index) {
					$(this).removeClass('first last');
					if ( (index + 1) % cat_columns === 0 ) {
						$(this).addClass('last').next().removeClass('first last').addClass('first');
					}
				});
			}

		},

		wishlist: function() {
			var $table			= $('.wtbx-wishlist-form'),
				$button			= $table.find('.remove, .add_to_cart_button');

			$(document).on('click', '.remove, .add_to_cart_button', function(evt) {
				$table.addClass('processing');
			});
			$(document).on('removed_from_wishlist added_to_cart', function() {
				$table.removeClass('processing');
			});

			$(document).on('added_to_wishlist removed_from_wishlist', function() {
				$.ajax({
					url: yith_wcwl_l10n.ajax_url,
					type: 'POST',
					data: {
						action: 'update_wishlist_count'
					},
					success: function(data) {
						if ( data !== 'false' ) {
							$('.header_wishlist .wishlist_count').html(data);
						}
					}
				})
			});
		},

		widgets: function() {
			$('.woocommerce.widget_layered_nav .wc-layered-nav-term span, .woocommerce.widget_product_categories .cat-item span').each(function() {
				$(this).html($(this).html().replace('(', '').replace(')', ''));
			});
		}

	};

	jQuery(document).ready(function($) {
		// SCAPE.isotopeShop.init($('.wtbx-grid-products'));

		SCAPE.woocommerceModule.variations();
		SCAPE.woocommerceModule.productGrid.init();
		SCAPE.woocommerceModule.productActions();
		SCAPE.woocommerceModule.productCarousel();
		SCAPE.woocommerceModule.widgets();

		SCAPE.woocommerceModule.quantity();
		$(document.body).on( 'updated_cart_totals', function() {
			SCAPE.woocommerceModule.quantity();
			SCAPE.woocommerceModule.productCarousel();
		});

		SCAPE.woocommerceModule.wishlist();
	});

})(jQuery);