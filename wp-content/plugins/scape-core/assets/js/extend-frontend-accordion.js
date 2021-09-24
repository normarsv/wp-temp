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



	vc.cloneMethod_vc_custom_accordion_tab = function ( data, model ) {
		data.params = _.extend( {}, data.params );
		data.params.el_id = 'tab-' + vc_guid() + '-cl';
		if ( ! _.isUndefined( model.get( 'active_before_cloned' ) ) ) {
			data.active_before_cloned = model.get( 'active_before_cloned' );
		}
		return data;
	};

	window.InlineShortcodeView_vc_custom_accordion = window.InlineShortcodeViewContainer.extend( {
		events: {},
		childTag: 'vc_custom_accordion_tab',
		activeClass: 'active',
		// controls_selector: '#vc_controls-template-vc_tta_accordion',
		defaultSectionTitle: window.i18nLocale.tab,
		initialize: function () {
			_.bindAll( this, 'buildSortable', 'updateSorting' );
			window.InlineShortcodeView_vc_custom_accordion.__super__.initialize.call( this );
		},
		render: function () {
			window.InlineShortcodeViewContainer.__super__.render.call( this );
			this.content(); // just to remove span inline-container anchor..
			this.buildPagination();
			return this;
		},
		addControls: function () {
			this.$controls = $( '<div class="no-controls"></div>' );
			this.$controls.appendTo( this.$el );
			return this;
		},
		/**
		 * Add new element to Accordion.
		 * @param e
		 */
		addElement: function ( e ) {
			e && e.preventDefault();
			this.addSection( 'parent.prepend' === $( e.currentTarget ).data( 'vcControl' ) );
		},
		appendElement: function ( e ) {
			return this.addElement( e );
		},
		prependElement: function ( e ) {
			return this.addElement( e );
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
					el_id: tab_id
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
		},
		initNav: function() {

			this.$el.find('.wtbx_accordion_link').on('click', function(e) {
				SCAPE.stopEvent(e);
				var $nav_item	= $(this),
					$container	= $nav_item.closest('.wtbx_vc_accordion'),
					$tab		= $nav_item.closest('.wtbx_vc_accordion_tab'),
					$tab_inner	= $tab.find('.wtbx_accordion_tab_inner');

				if ( !$tab.hasClass('active') ) {
					$container.find('.wtbx_vc_accordion_tab.active').find('.wtbx_accordion_tab_inner').slideUp(500);
					$container.find('.wtbx_vc_accordion_tab.active').removeClass('active');
					$tab.addClass('active');
					$tab_inner.slideDown(500);
				}
			});
		},
		getSiblingsFirstPositionIndex: function () {
			var order,
				shortcodeFirst;
			order = 0;
			shortcodeFirst = vc.shortcodes.sort().findWhere( { parent_id: this.model.get( 'id' ) } );
			if ( shortcodeFirst ) {
				order = shortcodeFirst.get( 'order' ) - 1;
			}
			return order;
		},
		changed: function () {
			vc.frame_window.vc_iframe.buildTTA();
			window.InlineShortcodeView_vc_custom_accordion.__super__.changed.call( this );
			_.defer( this.buildSortable );
			this.buildPagination();
		},
		updated: function () {
			window.InlineShortcodeView_vc_custom_accordion.__super__.updated.call( this );
			_.defer( this.buildSortable );
			this.buildPagination();
		},
		buildSortable: function () {
			if ( ! vc_user_access().shortcodeEdit( this.model.get( 'shortcode' ) ) ) {
				return
			}
			if ( this.$el ) {
				this.$el.find( '.wtbx_vc_accordion_inner' ).sortable( {
					forcePlaceholderSize: true,
					placeholder: 'wtbx_tabs_placeholder wtbx_vc_accordion_tab', // TODO: fix placeholder
					start: this.startSorting,
					over: function ( event, ui ) {
						ui.placeholder.css( { maxWidth: ui.placeholder.parent().width() } );
						ui.placeholder.removeClass( 'vc_hidden-placeholder' );
					},
					items: '> .vc_element',
					handle: '.wtbx_accordion_link, .vc_child-element-move',// TODO: change vc_column to vc_tta_section
					update: this.updateSorting
				} );
			}
		},
		startSorting: function ( event, ui ) {
			ui.placeholder.width( ui.item.width() );
		},
		updateSorting: function ( event, ui ) {
			var self = this;
			this.getPanelsList().find( '> .vc_element' ).each( function () {
				var shortcode, modelId, $this;

				$this = $( this );
				modelId = $this.data( 'modelId' );
				shortcode = vc.shortcodes.get( modelId );
				shortcode.save( { 'order': self.getIndex( $this ) }, { silent: true } );
			} );
			// re-render pagination
			this.buildPagination();
		},
		getIndex: function ( $element ) {
			return $element.index();
		},
		getPanelsList: function () {
			return this.$el.find( '.wtbx_vc_accordion_inner' );
		},
		parentChanged: function () {
			window.InlineShortcodeView_vc_custom_accordion.__super__.parentChanged.call( this );

			if ( 'undefined' !== typeof(vc.frame_window.vc_round_charts) ) {
				vc.frame_window.vc_round_charts( this.model.get( 'id' ) );
			}

			if ( 'undefined' !== typeof(vc.frame_window.vc_line_charts) ) {
				vc.frame_window.vc_line_charts( this.model.get( 'id' ) );
			}
		},
		buildPagination: function () {
			this.initNav();
		},
		removePagination: function () {
			this.$el.find( '.vc_tta-panels-container' ).find( ' > .vc_pagination' ).remove(); // TODO: check this
		},
		getPaginationList: function () {
			var $accordions,
				classes,
				styleChunks,
				that,
				html,
				params;

			params = this.model.get( 'params' );
			if ( ! _.isUndefined( params.pagination_style ) && params.pagination_style.length ) {
				$accordions = this.$el.find( '[data-vc-accordion]' );
				classes = [];
				classes.push( 'vc_general' );
				classes.push( 'vc_pagination' );
				styleChunks = params.pagination_style.split( '-' );
				classes.push( 'vc_pagination-style-' + styleChunks[ 0 ] );
				classes.push( 'vc_pagination-shape-' + styleChunks[ 1 ] );

				if ( ! _.isUndefined( params.pagination_color ) && params.pagination_color.length ) {
					classes.push( 'vc_pagination-color-' + params.pagination_color );
				}
				html = [];
				html.push( '<ul class="' + classes.join( ' ' ) + '">' );

				that = this;
				$accordions.each( function () {
					var sectionClasses,
						activeSection,
						$this,
						$closestPanel,
						selector,
						aHtml;

					$this = $( this );
					$closestPanel = $this.closest( '.vc_tta-panel' );
					activeSection = $closestPanel.hasClass( that.activeClass );
					sectionClasses = [ 'vc_pagination-item' ];
					if ( activeSection ) {
						sectionClasses.push( that.activeClass );
					}

					selector = $this.attr( 'href' );
					if ( 0 !== selector.indexOf( '#' ) ) {
						selector = '';
					}
					if ( $this.attr( 'data-vc-target' ) ) {
						selector = $this.attr( 'data-vc-target' );
					}
					aHtml = '<a href="javascript:;" data-vc-target="' + selector + '" class="vc_pagination-trigger" data-vc-tabs data-vc-container=".vc_tta"></a>';
					html.push( '<li class="' + sectionClasses.join( ' ' ) + '" data-vc-tab>' + aHtml + '</li>' );
				} );

				html.push( '</ul>' );
				return $( html.join( '' ) );
			}
			return null;
		}
	} );

	window.InlineShortcodeView_vc_custom_accordion_tab = window.InlineShortcodeViewContainerWithParent.extend( {
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
			return this;
		},
		allowAddControl: function () {
			return vc_user_access().shortcodeAll( 'vc_custom_accordion_tab' );
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
				this.$el.addClass( 'vc_empty' ).find( '.wtbx_accordion_tab_inner' ).addClass(
					'vc_empty-element' );
			} else {
				this.$el.removeClass( 'vc_empty' ).find( '.wtbx_accordion_tab_inner.vc_empty-element' ).removeClass(
					'vc_empty-element' );
			}
		},
		moveClasses: function () {
			var panelClassName;
			if ( this.previousClasses ) {
				this.$el.get( 0 ).className = this.$el.get( 0 ).className.replace( this.previousClasses, "" );
			}
			panelClassName = this.$el.find( '.wtbx_vc_accordion_tab' ).get( 0 ).className;
			this.$el.attr( 'data-vc-content', this.$el.find( '.vc_tta-panel' ).data( 'vcContent' ) );
			this.previousClasses = panelClassName;
			//this.$el.find( '.wtbx_vc_tab' ).get( 0 ).className = "";
			this.$el.get( 0 ).className = this.$el.get( 0 ).className + " " + this.previousClasses;
			//Fix data-vc-target for accordions:
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
	});


})(jQuery);