(function($) {
	"use strict";

	vc.cloneMethod_vc_team_table_member = function ( data, model ) {
		data.params = _.extend( {}, data.params );
		data.params.slide_id = vc_guid() + '-cl';
		if ( ! _.isUndefined( model.get( 'active_before_cloned' ) ) ) {
			data.active_before_cloned = model.get( 'active_before_cloned' );
		}
		return data;
	};

	window.InlineShortcodeView_vc_team_table = window.InlineShortcodeView_vc_tta_accordion.extend( {
		already_build: false,
		active_model_id: false,
		$tabsNav: false,
		active: 0,
		activeClass: 'active',
		childTag: 'vc_team_table_member',
		render: function () {
			window.InlineShortcodeView_vc_team_table.__super__.render.call( this );
			_.bindAll( this, 'buildSortableNavigation', 'updateSortingNavigation' );
			this.createTabs();
			_.defer( this.buildSortableNavigation );
			return this;
		},
		initNav: function() {
			var $table = this.$el.find('.wtbx_vc_team_table');

			$table.find('.wtbx_team_member_photo').unbind().on('click', function(e) {
				SCAPE.stopEvent(e);

				if ( !$(this).hasClass('active') ) {
					var id = $(this).attr('href');

					$table.find('.wtbx_team_member_photo').removeClass('active');
					$table.find('.wtbx_vc_team_table_member').removeClass('active').parent().removeClass('active');

					$(this).addClass('active');
					$table.find('.wtbx_vc_team_table_member[data-team="'+id+'"]').addClass('active').parent().addClass('active');
				}

			});
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
		defaultSectionTitle: 'James Brown',
		addIcon: function ( model, html ) {
			// var icon, iconClass, iconHtml = '';
			// if ( '' !== model.getParam( 'icon' ) ) {
			// 	icon		= model.getParam('icon');
			// 	iconClass	= $.parseJSON(icon).icon;
			// 	iconHtml	= '<i class="' + iconClass + ' wtbx_vc_icon"></i>';
			// }
			// html = iconHtml + html;
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
				$content,
				sectionId,
				html, title, models, index, tabAdded, icon, $el, that;
			tabAdded = false;
			sectionId = model.get( 'id' );
			$navigation = this.$el.find( '.wtbx_team_table_photos' );
			$content = this.$el.find( '.wtbx_team_table_content' );
			$tabEl = $navigation.find( '[data-vc-target="[data-model-id=' + sectionId + ']"]' );
			title = model.getParam( 'title' );
			$el = this.$el;
			that = this;

			var $element = $content.find('[data-model-id="' + sectionId + '"]').find('.wtbx_team_member_photo');
			$element.attr({
				'data-vc-target-model-id': sectionId,
				'data-vc-tab': '',
				'data-vc-use-cache': false,
				'data-vc-tabs': '',
				'data-vc-target': '[data-model-id=' + sectionId + ']'
			});

			if ( $tabEl.length ) {
				setTimeout(function() {
					$tabEl.html($content.find('[data-model-id="' + sectionId + '"]').find('.wtbx_team_member_photo').html());
					$content.find('[data-model-id="' + sectionId + '"]').find('.wtbx_team_member_photo').remove();
					$content.find('[data-model-id="' + sectionId + '"]').addClass('active');
				});
			} else {
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
				setTimeout(function(){
					! tabAdded && $content.find('[data-model-id="' + sectionId + '"]').find('.wtbx_team_member_photo').clone().appendTo( $navigation );

					if ( !$navigation.find('.wtbx_team_member_photo.active').length ) {
						$el.find('.wtbx_team_member_photo:first').addClass('active');
						$el.find('.wtbx_vc_team_table_member:first').addClass('active');
					}

					that.initNav();
					that.buildPagination();
				});

			}

		},
		addSection: function ( prepend ) {
			var shortcode, params, i;

			shortcode = this.childTag;

			params = {
				shortcode: shortcode,
				parent_id: this.model.get( 'id' ),
				isActiveSection: true,
				params: {
					title: this.defaultSectionTitle
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
		getNextTab: function ( $viewTab ) {
			var lastIndex, viewTabIndex, $nextTab, $navigationSections;

			$navigationSections = this.$el.find( '.wtbx_team_table_photos' ).children();
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

			$viewTab = this.$el.find( '.wtbx_team_table_photos [data-vc-target="[data-model-id=' + modelId + ']"]');
			tabIsActive = $viewTab.hasClass( this.activeClass );

			// Make next tab active if needed
			if ( tabIsActive ) {
				$nextTab = this.getNextTab( $viewTab );
				$nextTab.trigger( 'click' );
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
			this.$el.find( '.wtbx_team_table_photos' ).sortable( {
				items: '.wtbx_team_member_photo',
				forcePlaceholderSize: true,
				forceHelperSize: false,
				placeholder: 'wtbx_tabs_placeholder',
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
			window.InlineShortcodeView_vc_team_table.__super__.updateSorting.call( this, event, ui );
			this.updateTabsPositions( this.getPanelsList() );
		},
		updateSortingNavigation: function () {
			var $tabs, self;
			self = this;
			$tabs = this.$el.find( '.wtbx_team_table_photos' );
			// we are sorting a tabs navigation
			$tabs.find( '> .wtbx_team_member_photo' ).each( function () {
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
			$tabs = this.$el.find( '.wtbx_team_table_photos' );
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
	window.InlineShortcodeView_vc_team_table_member = window.InlineShortcodeViewContainerWithParent.extend( {
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
			window.InlineShortcodeView_vc_team_table_member.__super__.render.call( this );
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

			// var params = this.model.get( 'params' );
			// this.$el.find('.wtbx_team_member_name').html(params.title);

			return this;
		},
		allowAddControl: function () {
			return vc_user_access().shortcodeAll( 'vc_team_table_member' );
		},
		clone: function ( e ) {
			vc.ttaSectionActivateOnClone = true;
			window.InlineShortcodeView_vc_team_table_member.__super__.clone.call( this, e );
		},
		addSibling: function ( e ) {
			window.InlineShortcodeView_vc_team_table_member.__super__.addSibling.call( this, e );
		},
		parentChanged: function () {
			window.InlineShortcodeView_vc_team_table_member.__super__.parentChanged.call( this );
			this.refreshContent( true );
			return this;
		},
		changed: function () {
			if ( this.allowAddControlOnEmpty() && 0 === this.$el.find( '.vc_element[data-tag]' ).length ) {
				this.$el.addClass( 'vc_empty' ).find( '.wtbx_team_member_description' ).addClass(
					'vc_empty-element' );
			} else {
				this.$el.removeClass( 'vc_empty' ).find( '.wtbx_team_member_description.vc_empty-element' ).removeClass(
					'vc_empty-element' );
			}
		},
		moveClasses: function () {
			var panelClassName;
			if ( this.previousClasses ) {
				this.$el.get( 0 ).className = this.$el.get( 0 ).className.replace( this.previousClasses, "" );
			}
			panelClassName = this.$el.find( '.wtbx_vc_team_table_member' ).get( 0 ).className;
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
			window.InlineShortcodeView_vc_team_table_member.__super__.destroy.call( this, e );
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