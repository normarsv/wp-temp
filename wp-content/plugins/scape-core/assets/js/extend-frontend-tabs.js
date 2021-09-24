(function($) {
	"use strict";

	var SCAPE = window.SCAPE || {};
	window.SCAPE = SCAPE;

	SCAPE.stopEvent = function(e) {
		if(!e) var e = window.event;
		e.cancelBubble = true;
		e.returnValue = false;
		if ( e.stopPropagation ) e.stopPropagation();
		if ( e.preventDefault ) e.preventDefault();
		return false;
	};

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

	SCAPE.waitForFinalEvent = (function() {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
			if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
			timers[uniqueId] = setTimeout(callback, ms);
		};
	}());

	SCAPE.timeToWaitForLast = 100;

	vc.cloneMethod_vc_custom_tab = function ( data, model ) {
		data.params = _.extend( {}, data.params );
		data.params.tab_id = 'tab-' + vc_guid() + '-cl';
		if ( ! _.isUndefined( model.get( 'active_before_cloned' ) ) ) {
			data.active_before_cloned = model.get( 'active_before_cloned' );
		}
		return data;
	};

	window.InlineShortcodeView_vc_custom_tabs = window.InlineShortcodeView_vc_tta_accordion.extend( {
		already_build: false,
		active_model_id: false,
		$tabsNav: false,
		active: 0,
		activeClass: 'active',
		childTag: 'vc_custom_tab',
		render: function () {
			window.InlineShortcodeView_vc_custom_tabs.__super__.render.call( this );
			_.bindAll( this, 'buildSortableNavigation', 'updateSortingNavigation' );
			this.createTabs();
			_.defer( this.buildSortableNavigation );
			return this;
		},
		initNav: function() {
			var $tabs = this.$el.find('.wtbx_vc_tabs');

			var knob = function() {
				var $cont = $tabs;

				if ( $cont.hasClass('wtbx_style_3') ) {
					var $knob		= $cont.find('.wtbx_tabs_knob'),
						$button		= $cont.find('.wtbx_tabs_nav_item.active').eq(0);

					if ( $button.length ) {
						var	newLeft		= Math.floor($button.position().left),
							newTop		= Math.floor($button.position().top),
							newIndex	= $button.index(),
							newWidth	= Math.floor($cont.find('.wtbx_tabs_nav_item').eq(newIndex-1).outerWidth()),
							newHeight	= Math.floor($cont.find('.wtbx_tabs_nav_item').eq(newIndex-1).outerHeight());

						var transform = SCAPE.propertyPrefix('transform');
						$knob.css({
							'width':			newWidth,
							'height':			newHeight,
							'border-radius':	newHeight
						});
						$knob.css(transform, 'translate3d('+newLeft+'px,'+newTop+'px,0)');
					}
				}
			};

			if ( $tabs.hasClass('wtbx_style_4') && $tabs.hasClass('wtbx_tabs_equal') ) {
				$tabs.find('.wtbx_tabs_nav_item').css({
					'width': 100 / $tabs.find('.wtbx_tabs_nav_item').length + '%'
				});
			}

			var	$nav_item	= $tabs.find('.wtbx_tabs_nav_item'),
				$nav_link	= $nav_item.find('.wtbx_tabs_nav_link'),
				$tab		= $tabs.find('.wtbx_vc_tab');

			// $tabs.find('.active').removeClass('active');

			if ( !$tabs.find('.active').length ) {
				$tabs.each(function() {
					var $tabs		= $(this),
						$tab		= $tabs.find('.wtbx_vc_tab'),
						active		= 1;

					$tabs.find('.wtbx_tabs_nav_item').eq(active-1).addClass('active');
					$tabs.find('.vc_vc_custom_tab').eq(active-1).children().addClass('active');

					var	index = $tabs.find('.wtbx_vc_tab.active').eq(0).index();

					$tab.each(function() {
						if ( $(this).index() < index ) {
							$(this).removeClass('active').addClass('prev');
						} else if ( $(this).index() > index ) {
							$(this).removeClass('active').addClass('next');
						}
					});
				});
			}

			$nav_link.unbind().on('click', function(e) {
				SCAPE.stopEvent(e);
				if ( !$(this).parent('li').hasClass('active') ) {
					var tabId		= $(this).attr('href').substr(1),
						newIndex	= $(this).parent('li').index();

					var $active = $tabs.find('.wtbx_vc_tab.active').attr('id');

					$nav_item.removeClass('active');
					$tabs.find('.wtbx_vc_tab').removeClass('active prev next');
					$(this).parent('li').addClass('active');
					$tabs.find('.wtbx_vc_tab[id="'+tabId+'"]').addClass('active');

					$tab.each(function() {
						if ( $(this).index() < newIndex ) {
							$(this).addClass('prev');
						} else if ( $(this).index() > newIndex ) {
							$(this).addClass('next');
						}
					});
				}
				knob();
			});

			setTimeout(function() {
				knob();
			});

			$(window).resize(function() {
				SCAPE.waitForFinalEvent( function() {
					setTimeout(function() {
						knob();
					});
				}, SCAPE.timeToWaitForLast, 'tabs_knob');
			});

			$tabs.addClass('tabs-init');

		},
		createTabs: function () {
			var models = _.sortBy( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
				function ( model ) {
					return model.get( 'order' );
				} );
			_.each( models, function ( model ) {
				this.sectionUpdated( model, true );
			}, this );
		},
		defaultSectionTitle: window.i18nLocale.tab,
		addIcon: function ( model, html ) {
			var icon, iconClass, iconHtml = '';
			if ( '' !== model.getParam( 'icon' ) ) {
				icon		= model.getParam('icon');
				iconClass	= $.parseJSON(icon).icon;
				iconHtml	= '<i class="' + iconClass + ' wtbx_vc_icon"></i>';
			}
			html = iconHtml + html;
			return html;
		},
		/**
		 *
		 * @param {Backbone.Model}model
		 */
		sectionUpdated: function ( model, justAppend ) {
			// update builded tabs, remove/add check orders and title/target

			var $tabEl,
				$navigation,
				sectionId,
				html, title, models, index, tabAdded, tab_id, icon;
			tabAdded = false;
			sectionId = model.get( 'id' );
			$navigation = this.$el.find( '.wtbx_tabs_nav' );
			$tabEl = $navigation.find( '[data-vc-target="[data-model-id=' + sectionId + ']"]' );
			title = model.getParam( 'title' ),
			tab_id = model.getParam( 'tab_id' );

			if ( $tabEl.length ) {
				html = '<div class="wtbx_tabs_nav_title">' + title + '</div>';
				html = this.addIcon( model, html );
				$tabEl.attr('href', '#' + tab_id);
				$tabEl.html( html );
			} else {
				var $element;
				html = '<div class="wtbx_tabs_nav_title">' + title + '</div>';
				html = this.addIcon( model, html );
				$element = $( '<li class="wtbx_tabs_nav_item" data-vc-target-model-id="' + sectionId + '" data-vc-tab><a class="wtbx_tabs_nav_link" href="#'+tab_id+'" data-vc-use-cache="false" data-vc-tabs data-vc-target="[data-model-id=' + sectionId + ']" data-vc-container=".vc_tta">' + html + '</a></li>' );
				if ( true !== justAppend ) {
					models = _.pluck( _.sortBy( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
						function ( childModel ) {
							return childModel.get( 'order' );
						} ), 'id' );
					index = models.indexOf( model.get( 'id' ) ) - 1;
					if ( index > - 1 && $navigation.find( '[data-vc-tab]:eq(' + index + ')' ).length ) {
						$element.insertAfter( $navigation.find( '[data-vc-tab]:eq(' + index + ')' ) );
						tabAdded = true;
					}
				}
				! tabAdded && $element.appendTo( $navigation );
			}

			this.initNav();
			this.buildPagination();
		},
		addSection: function ( prepend ) {
			var shortcode, params, i;

			shortcode = this.childTag;

			var tab_id = 'tab-' + vc_guid() + '-cl';

			params = {
				shortcode: shortcode,
				parent_id: this.model.get( 'id' ),
				isActiveSection: true,
				params: {
					title: this.defaultSectionTitle,
					tab_id: tab_id
				}
			};

			if ( prepend ) {
				vc.activity = 'prepend';
				params.order = this.getSiblingsFirstPositionIndex();
			}

			vc.builder.create( params );

			// extend default params with settings presets if there are any
			for ( i = vc.builder.models.length - 1;
				  i >= 0;
				  i -- ) {
				shortcode = vc.builder.models[ i ].get( 'shortcode' );
			}

			vc.builder.render();
			this.initNav();
		},
		getNextTab: function ( $viewTab ) {
			var lastIndex, viewTabIndex, $nextTab, $navigationSections;

			$navigationSections = this.$el.find( '.wtbx_tabs_nav' ).children();
			lastIndex = $navigationSections.length - 1; // -1 because length starts from 1
			viewTabIndex = $viewTab.index();

			if ( viewTabIndex !== lastIndex ) {
				$nextTab = $navigationSections.eq( viewTabIndex + 1 );
			} else {
				// If we are the last tab in in navigation lets make active previous
				$nextTab = $navigationSections.eq( viewTabIndex - 1 );
			}
			return $nextTab;
		},
		removeSection: function ( modelId ) {
			var $viewTab, $nextTab, tabIsActive;

			$viewTab = this.$el.find( '.wtbx_tabs_nav [data-vc-target="[data-model-id=' + modelId + ']"]').parent();
			tabIsActive = $viewTab.hasClass( this.activeClass );

			// Make next tab active if needed
			if ( tabIsActive ) {
				$nextTab = this.getNextTab( $viewTab );
				$nextTab.find( '[data-vc-target]' ).trigger( 'click' );
			}
			// Remove tab from navigation
			$viewTab.remove();
			this.buildPagination();
		},
		buildSortableNavigation: function () {
			if ( ! vc_user_access().shortcodeEdit( this.model.get( 'shortcode' ) ) ) {
				return
			}

			// this should be called when new tab added/removed/changed.
			this.$el.find( '.wtbx_tabs_nav' ).sortable( {
				items: '.wtbx_tabs_nav_item',
				forcePlaceholderSize: true,
				forceHelperSize: false,
				placeholder: 'wtbx_tabs_placeholder wtbx_tabs_nav_item',
				helper: this.renderSortingHelper,
				start: function ( event, ui ) {
					//ui.placeholder.height( ui.item.height() );
					ui.placeholder.width( ui.item.width() );
				},
				over: function ( event, ui ) {
					ui.placeholder.css( { maxWidth: ui.placeholder.parent().width() } );
					ui.placeholder.removeClass( 'vc_hidden-placeholder' );
				},
				update: this.updateSortingNavigation
			} );
		},
		updateSorting: function ( event, ui ) {
			window.InlineShortcodeView_vc_custom_tabs.__super__.updateSorting.call( this, event, ui );
			this.updateTabsPositions( this.getPanelsList() );
		},
		updateSortingNavigation: function () {
			var $tabs, self;
			self = this;
			$tabs = this.$el.find( '.wtbx_tabs_nav' );
			// we are sorting a tabs navigation
			$tabs.find( '> .wtbx_tabs_nav_item' ).each( function () {
				var shortcode, modelId, $li;

				$li = $( this ).removeAttr( 'style' ); // TODO: Attensiton maybe e need to create method with filter
				modelId = $li.data( 'vcTargetModelId' );
				shortcode = vc.shortcodes.get( modelId );
				shortcode.save( { 'order': self.getIndex( $li ) }, { silent: true } );
				// now we need to sort panels
			} );
			this.updatePanelsPositions( $tabs );

			var $cont = this.$el.find('.wtbx_vc_tabs');
			if ( $cont.hasClass('wtbx_style_4') && $cont.hasClass('wtbx_tabs_equal') ) {
				$cont.find('.wtbx_tabs_nav_item').css({
					'width': 100 / $cont.find('.wtbx_tabs_nav_item').length + '%'
				});
			}
		},
		updateTabsPositions: function ( $panels ) {
			var $tabs, $elements, tabSortableData;
			$tabs = this.$el.find( '.wtbx_tabs_nav' );
			if ( $tabs.length ) {
				$elements = [];
				tabSortableData = $panels.sortable( 'toArray', { attribute: 'data-model-id' } );
				_.each( tabSortableData, function ( value ) {
					$elements.push( $tabs.find( '[data-vc-target-model-id="' + value + '"]' ) );
				}, this );
				$tabs.prepend( $elements );
			}
			this.buildPagination();
		},
		updatePanelsPositions: function ( $tabs ) {
			var $elements, tabSortableData, $panels;
			$panels = this.getPanelsList();
			$elements = [];
			tabSortableData = $tabs.sortable( 'toArray', { attribute: 'data-vc-target-model-id' } );
			_.each( tabSortableData, function ( value ) {
				$elements.push( $panels.find( '[data-model-id="' + value + '"]' ) );
			}, this );
			$panels.prepend( $elements );
			this.buildPagination();
		},
		renderSortingHelper: function ( event, currentItem ) {
			var helper, currentItemWidth, currentItemHeight;
			helper = currentItem;
			//currentItemWidth = currentItem.width() + 1;
			currentItemHeight = currentItem.height();
			//helper.width( currentItemWidth );
			helper.height( currentItemHeight );
			return helper;
		},
		buildPagination: function () {
			var params;
			this.removePagination();
			// If tap-pos top append:
			params = this.model.get( 'params' );
			if ( ! _.isUndefined( params.pagination_style ) && params.pagination_style.length ) {
				if ( 'top' === params.tab_position ) {
					this.$el.find( '.vc_tta-panels-container' ).append( this.getPaginationList() );
				} else {
					this.getPaginationList().insertBefore( this.$el.find( '.vc_tta-container .vc_tta-panels' ) ); // TODO: change this
				}
			}
		}
	} );

	window.InlineShortcodeView_vc_custom_tour = window.InlineShortcodeView_vc_tta_accordion.extend( {
		already_build: false,
		active_model_id: false,
		$tabsNav: false,
		active: 0,
		activeClass: 'active',
		childTag: 'vc_custom_tab',
		render: function () {
			window.InlineShortcodeView_vc_custom_tour.__super__.render.call( this );
			_.bindAll( this, 'buildSortableNavigation', 'updateSortingNavigation' );
			this.createTabs();
			_.defer( this.buildSortableNavigation );
			return this;
		},
		initNav: function() {
			var $tabs = this.$el.find('.wtbx_vc_tour');

			if ( $tabs.hasClass('wtbx_style_4') && $tabs.hasClass('wtbx_tabs_equal') ) {
				$tabs.find('.wtbx_tabs_nav_item').css({
					'width': 100 / $tabs.find('.wtbx_tabs_nav_item').length + '%'
				});
			}

			var	$nav_item	= $tabs.find('.wtbx_tabs_nav_item'),
				$nav_link	= $nav_item.find('.wtbx_tabs_nav_link'),
				$tab		= $tabs.find('.wtbx_vc_tab');

			// $tabs.find('.active').removeClass('active');

			if ( !$tabs.find('.active').length ) {
				$tabs.each(function() {
					var $tabs		= $(this),
						$tab		= $tabs.find('.wtbx_vc_tab'),
						active		= 1;

					$tabs.find('.wtbx_tabs_nav_item').eq(active-1).addClass('active');
					$tabs.find('.vc_vc_custom_tab').eq(active-1).children().addClass('active');

					var	index = $tabs.find('.wtbx_vc_tab.active').eq(0).index();

					$tab.each(function() {
						if ( $(this).index() < index ) {
							$(this).removeClass('active').addClass('prev');
						} else if ( $(this).index() > index ) {
							$(this).removeClass('active').addClass('next');
						}
					});
				});
			}

			$nav_link.unbind().on('click', function(e) {
				SCAPE.stopEvent(e);
				if ( !$(this).parent('li').hasClass('active') ) {
					var tabId		= $(this).attr('href').substr(1),
						newIndex	= $(this).parent('li').index();

					var $active = $tabs.find('.wtbx_vc_tab.active').attr('id');

					$nav_item.removeClass('active');
					$tabs.find('.wtbx_vc_tab').removeClass('active prev next');
					$(this).parent('li').addClass('active');
					$tabs.find('.wtbx_vc_tab[id="'+tabId+'"]').addClass('active');

					$tab.each(function() {
						if ( $(this).index() < newIndex ) {
							$(this).addClass('prev');
						} else if ( $(this).index() > newIndex ) {
							$(this).addClass('next');
						}
					});
				}
			});

			$tabs.addClass('tabs-init');

		},
		createTabs: function () {
			var models = _.sortBy( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
				function ( model ) {
					return model.get( 'order' );
				} );
			_.each( models, function ( model ) {
				this.sectionUpdated( model, true );
			}, this );
		},
		defaultSectionTitle: window.i18nLocale.tab,
		addIcon: function ( model, html ) {
			var icon, iconClass, iconHtml = '';
			if ( '' !== model.getParam( 'icon' ) ) {
				icon		= model.getParam('icon');
				iconClass	= $.parseJSON(icon).icon;
				iconHtml	= '<i class="' + iconClass + ' wtbx_vc_icon"></i>';
			}
			html = iconHtml + html;
			return html;
		},
		/**
		 *
		 * @param {Backbone.Model}model
		 */
		sectionUpdated: function ( model, justAppend ) {
			// update builded tabs, remove/add check orders and title/target

			var $tabEl,
				$navigation,
				sectionId,
				html, title, models, index, tabAdded, tab_id, icon;
			tabAdded = false;
			sectionId = model.get( 'id' );
			$navigation = this.$el.find( '.wtbx_tabs_nav' );
			$tabEl = $navigation.find( '[data-vc-target="[data-model-id=' + sectionId + ']"]' );
			title = model.getParam( 'title' ),
			tab_id = model.getParam( 'tab_id' );

			if ( $tabEl.length ) {
				html = '<div class="wtbx_tabs_nav_title">' + title + '</div>';
				html = this.addIcon( model, html );
				$tabEl.attr('href', '#' + tab_id);
				$tabEl.html( html );
			} else {
				var $element;
				html = '<div class="wtbx_tabs_nav_title">' + title + '</div>';
				html = this.addIcon( model, html );
				$element = $( '<li class="wtbx_tabs_nav_item" data-vc-target-model-id="' + sectionId + '" data-vc-tab><a class="wtbx_tabs_nav_link" href="#'+tab_id+'" data-vc-use-cache="false" data-vc-tabs data-vc-target="[data-model-id=' + sectionId + ']" data-vc-container=".vc_tta">' + html + '</a></li>' );
				if ( true !== justAppend ) {
					models = _.pluck( _.sortBy( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
						function ( childModel ) {
							return childModel.get( 'order' );
						} ), 'id' );
					index = models.indexOf( model.get( 'id' ) ) - 1;
					if ( index > - 1 && $navigation.find( '[data-vc-tab]:eq(' + index + ')' ).length ) {
						$element.insertAfter( $navigation.find( '[data-vc-tab]:eq(' + index + ')' ) );
						tabAdded = true;
					}
				}
				! tabAdded && $element.appendTo( $navigation );
				//if ( model.get( 'isActiveSection' ) ) {
				//	$element.addClass( this.activeClass );
				//}
			}

			this.initNav();
			this.buildPagination();
		},
		addSection: function ( prepend ) {
			var shortcode, params, i;

			shortcode = this.childTag;

			var tab_id = 'tab-' + vc_guid() + '-cl';

			params = {
				shortcode: shortcode,
				parent_id: this.model.get( 'id' ),
				isActiveSection: true,
				params: {
					title: this.defaultSectionTitle,
					tab_id: tab_id
				}
			};

			if ( prepend ) {
				vc.activity = 'prepend';
				params.order = this.getSiblingsFirstPositionIndex();
			}

			vc.builder.create( params );

			// extend default params with settings presets if there are any
			for ( i = vc.builder.models.length - 1;
				  i >= 0;
				  i -- ) {
				shortcode = vc.builder.models[ i ].get( 'shortcode' );
			}

			vc.builder.render();
			this.initNav();
		},
		getNextTab: function ( $viewTab ) {
			var lastIndex, viewTabIndex, $nextTab, $navigationSections;

			$navigationSections = this.$el.find( '.wtbx_tabs_nav' ).children();
			lastIndex = $navigationSections.length - 1; // -1 because length starts from 1
			viewTabIndex = $viewTab.index();

			if ( viewTabIndex !== lastIndex ) {
				$nextTab = $navigationSections.eq( viewTabIndex + 1 );
			} else {
				// If we are the last tab in in navigation lets make active previous
				$nextTab = $navigationSections.eq( viewTabIndex - 1 );
			}
			return $nextTab;
		},
		removeSection: function ( modelId ) {
			var $viewTab, $nextTab, tabIsActive;

			$viewTab = this.$el.find( '.wtbx_tabs_nav [data-vc-target="[data-model-id=' + modelId + ']"]').parent();
			tabIsActive = $viewTab.hasClass( this.activeClass );

			// Make next tab active if needed
			if ( tabIsActive ) {
				$nextTab = this.getNextTab( $viewTab );
				$nextTab.find( '[data-vc-target]' ).trigger( 'click' );
			}
			// Remove tab from navigation
			$viewTab.remove();
			this.buildPagination();
		},
		buildSortableNavigation: function () {
			if ( ! vc_user_access().shortcodeEdit( this.model.get( 'shortcode' ) ) ) {
				return
			}
			var $tabs = this.$el;

			// this should be called when new tab added/removed/changed.
			this.$el.find( '.wtbx_tabs_nav' ).sortable( {
				items: '.wtbx_tabs_nav_item',
				forcePlaceholderSize: true,
				placeholder: 'wtbx_tabs_placeholder wtbx_tabs_nav_item',
				helper: this.renderSortingHelper,
				start: function ( event, ui ) {
					//ui.placeholder.height( ui.item.height() );
					ui.placeholder.width( ui.item.width() );
				},
				over: function ( event, ui ) {
					ui.placeholder.css( { maxWidth: ui.placeholder.parent().width() } );
					ui.placeholder.removeClass( 'vc_hidden-placeholder' );
				},
				update: this.updateSortingNavigation
			} );
		},
		updateSorting: function ( event, ui ) {
			window.InlineShortcodeView_vc_custom_tour.__super__.updateSorting.call( this, event, ui );
			this.updateTabsPositions( this.getPanelsList() );
		},
		updateSortingNavigation: function () {
			var $tabs, self;
			self = this;
			$tabs = this.$el.find( '.wtbx_tabs_nav' );
			// we are sorting a tabs navigation
			$tabs.find( '> .wtbx_tabs_nav_item' ).each( function () {
				var shortcode, modelId, $li;

				$li = $( this ).removeAttr( 'style' ); // TODO: Attensiton maybe e need to create method with filter
				modelId = $li.data( 'vcTargetModelId' );
				shortcode = vc.shortcodes.get( modelId );
				shortcode.save( { 'order': self.getIndex( $li ) }, { silent: true } );
				// now we need to sort panels
			} );
			this.updatePanelsPositions( $tabs );
		},
		updateTabsPositions: function ( $panels ) {
			var $tabs, $elements, tabSortableData;
			$tabs = this.$el.find( '.wtbx_tabs_nav' );
			if ( $tabs.length ) {
				$elements = [];
				tabSortableData = $panels.sortable( 'toArray', { attribute: 'data-model-id' } );
				_.each( tabSortableData, function ( value ) {
					$elements.push( $tabs.find( '[data-vc-target-model-id="' + value + '"]' ) );
				}, this );
				$tabs.prepend( $elements );
			}
			this.buildPagination();
		},
		updatePanelsPositions: function ( $tabs ) {
			var $elements, tabSortableData, $panels;
			$panels = this.getPanelsList();
			$elements = [];
			tabSortableData = $tabs.sortable( 'toArray', { attribute: 'data-vc-target-model-id' } );
			_.each( tabSortableData, function ( value ) {
				$elements.push( $panels.find( '[data-model-id="' + value + '"]' ) );
			}, this );
			$panels.prepend( $elements );
			this.buildPagination();
		},
		renderSortingHelper: function ( event, currentItem ) {
			var helper, currentItemWidth, currentItemHeight;
			helper = currentItem;
			//currentItemWidth = currentItem.width() + 1;
			currentItemHeight = currentItem.height();
			//helper.width( currentItemWidth );
			helper.height( currentItemHeight );
			return helper;
		},
		buildPagination: function () {
			var params;
			this.removePagination();
			// If tap-pos top append:
			params = this.model.get( 'params' );
			if ( ! _.isUndefined( params.pagination_style ) && params.pagination_style.length ) {
				if ( 'top' === params.tab_position ) {
					this.$el.find( '.vc_tta-panels-container' ).append( this.getPaginationList() );
				} else {
					this.getPaginationList().insertBefore( this.$el.find( '.vc_tta-container .vc_tta-panels' ) ); // TODO: change this
				}
			}
		}
	} );

	vc.ttaSectionActivateOnClone = false;
	window.InlineShortcodeView_vc_custom_tab = window.InlineShortcodeViewContainerWithParent.extend( {
		events: {
			'click > .vc_controls [data-vc-control="destroy"]': 'destroy',
			'click > .vc_controls [data-vc-control="edit"]': 'edit',
			'click > .vc_controls [data-vc-control="clone"]': 'clone',
			'click > .vc_controls [data-vc-control="prepend"]': 'prependElement',
			'click > .vc_controls [data-vc-control="append"]': 'appendElement',
			'click > .vc_controls [data-vc-control="parent.destroy"]': 'destroyParent',
			'click > .vc_controls [data-vc-control="parent.edit"]': 'editParent',
			'click > .vc_controls [data-vc-control="parent.clone"]': 'cloneParent',
			'click > .vc_controls [data-vc-control="parent.append"]': 'addSibling',
			'click .vc_empty-element': 'appendElement',
			'click > .vc_controls .vc_control-btn-switcher': 'switchControls',
			'mouseenter': 'resetActive',
			'mouseleave': 'holdActive'
		},

		controls_selector: '#vc_controls-template-vc_tta_section',
		previousClasses: false,
		activeClass: 'vc_active',
		render: function () {
			var model = this.model;
			window.InlineShortcodeView_vc_custom_tab.__super__.render.call( this );
			_.bindAll( this, 'bindAccordionEvents' );
			this.refreshContent();
			this.moveClasses();
			_.defer( this.bindAccordionEvents );
			if ( this.isAsActiveSection() ) {
				window.vc.frame_window.vc_iframe.addActivity( function () {
					var $accordion = window.vc.frame_window.jQuery(
						'[data-vc-accordion][data-vc-target="[data-model-id=' + model.get( 'id' ) + ']"]' );
					$accordion.trigger( 'click' );
				} );
			}

			var $this = this.$el;
			setTimeout(function() {
				var $nav = $this.closest('.wtbx_ui_tabs').find('.wtbx_tabs_nav');
				var $content = $this.closest('.wtbx_tabs_content');
				if ( $nav.find('.active').length ) {
					$content.find('.wtbx_vc_tab[id="'+$nav.find('.active').children('.wtbx_tabs_nav_link').attr('href').replace('#','')+'"]').addClass('active');
				}
			});

			return this;
		},
		allowAddControl: function () {
			return vc_user_access().shortcodeAll( 'vc_custom_tab' );
		},
		clone: function ( e ) {
			vc.ttaSectionActivateOnClone = true;
			window.InlineShortcodeView_vc_custom_tab.__super__.clone.call( this, e );
		},
		addSibling: function ( e ) {
			window.InlineShortcodeView_vc_custom_tab.__super__.addSibling.call( this, e );
		},
		parentChanged: function () {
			window.InlineShortcodeView_vc_custom_tab.__super__.parentChanged.call( this );
			this.refreshContent( true );
			return this;
		},
		changed: function () {
			if ( this.allowAddControlOnEmpty() && 0 === this.$el.find( '.vc_element[data-tag]' ).length ) {
				this.$el.addClass( 'vc_empty' ).find( '.wtbx_tab_wrapper' ).addClass(
					'vc_empty-element' );
			} else {
				this.$el.removeClass( 'vc_empty' ).find( '.wtbx_tab_wrapper.vc_empty-element' ).removeClass(
					'vc_empty-element' );
			}
		},
		moveClasses: function () {
			var panelClassName;
			if ( this.previousClasses ) {
				this.$el.get( 0 ).className = this.$el.get( 0 ).className.replace( this.previousClasses, "" );
			}
			panelClassName = this.$el.find( '.wtbx_vc_tab' ).get( 0 ).className;
			this.$el.attr( 'data-vc-content', this.$el.find( '.vc_tta-panel' ).data( 'vcContent' ) );
			this.previousClasses = panelClassName;
			//this.$el.find( '.wtbx_vc_tab' ).get( 0 ).className = "";
			this.$el.get( 0 ).className = this.$el.get( 0 ).className + " " + this.previousClasses;
			// Fix data-vc-target for accordions:
			//this.$el.find( '.vc_tta-panel-title [data-vc-target]' ).attr( 'data-vc-target',
			//	'[data-model-id=' + this.model.get( 'id' ) + ']' );
		},
		refreshContent: function ( noSectionUpdate ) {
			var $controlsIcon, $controlsIconsPositionEl, parentModel, parentParams, paramsMap, parentLayout;

			parentModel = vc.shortcodes.get( this.model.get( 'parent_id' ) );
			if ( _.isObject( parentModel ) ) {
				paramsMap = vc.getDefaultsAndDependencyMap( parentModel.get( 'shortcode' ) );
				parentParams = _.extend( {}, paramsMap.defaults, parentModel.get( 'params' ) );
				$controlsIcon = this.$el.find( '.vc_tta-controls-icon' );
				if ( parentParams && ! _.isUndefined( parentParams.c_icon ) && 0 < parentParams.c_icon.length ) {
					if ( $controlsIcon.length ) {
						$controlsIcon.attr( 'data-vc-tta-controls-icon', parentParams.c_icon );
					} else {
						this.$el.find( '[data-vc-tta-controls-icon-wrapper]' ).append(
							$( '<i class="vc_tta-controls-icon" data-vc-tta-controls-icon="' + parentParams.c_icon + '"></i>' )
						);
					}
					if ( ! _.isUndefined( parentParams.c_position ) && 0 < parentParams.c_position.length ) {
						$controlsIconsPositionEl = this.$el.find( '[data-vc-tta-controls-icon-position]' );
						if ( $controlsIconsPositionEl.length ) {
							$controlsIconsPositionEl.attr( 'data-vc-tta-controls-icon-position',
								parentParams.c_position );
						}
					}
				} else {
					$controlsIcon.remove();
					this.$el.find( '[data-vc-tta-controls-icon-position]' ).attr( 'data-vc-tta-controls-icon-position',
						'' );
				}
				if ( true !== noSectionUpdate && parentModel.view && parentModel.view.sectionUpdated ) {
					parentModel.view.sectionUpdated( this.model );
				}
			}
		},
		setAsActiveSection: function ( isActive ) {
			this.model.set( 'isActiveSection', ! ! isActive );
		},
		isAsActiveSection: function () {
			return ! ! this.model.get( 'isActiveSection' );
		},
		bindAccordionEvents: function () {
			var that = this;
			window.vc.frame_window.jQuery( '[data-vc-target="[data-model-id=' + this.model.get( 'id' ) + ']"]' )
				.on( 'show.vc.accordion hide.vc.accordion',
					function ( e ) {
						that.setAsActiveSection( 'show' === e.type );
					} );

		},
		destroy: function ( e ) {
			var parentModel, parentId;
			parentId = this.model.get( 'parent_id' );
			window.InlineShortcodeView_vc_custom_tab.__super__.destroy.call( this, e );
			parentModel = vc.shortcodes.get( parentId );
			if ( ! vc.shortcodes.where( { parent_id: parentId } ).length ) {
				parentModel.destroy();
			} else {
				parentModel.view && parentModel.view.removeSection && parentModel.view.removeSection( this.model.get(
					'id' ) );
			}
		}
	} );

})(jQuery);