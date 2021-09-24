(function($) {
	"use strict";

	vc.cloneMethod_vc_testimonial_slide = function ( data, model ) {
		data.params = _.extend( {}, data.params );
		data.params.tab_id = vc_guid() + '-cl';
		if ( ! _.isUndefined( model.get( 'active_before_cloned' ) ) ) {
			data.active_before_cloned = model.get( 'active_before_cloned' );
		}
		return data;
	};

	window.InlineShortcodeView_vc_testimonial_slider = window.InlineShortcodeView_vc_tta_accordion.extend( {
		already_build: false,
		active_model_id: false,
		$tabsNav: false,
		active: 0,
		activeClass: 'active',
		childTag: 'vc_testimonial_slide',
		render: function () {
			window.InlineShortcodeView_vc_testimonial_slider.__super__.render.call( this );
			_.bindAll( this, 'buildSortableNavigation', 'updateSortingNavigation' );
			this.createTabs();
			_.defer( this.buildSortableNavigation );
			return this;
		},
		initNav: function() {
			var $nav		= this.$el.find('.wtbx_testimonials_nav'),
				$content	= this.$el.find('.wtbx_testimonial_slider_inner'),
				$dots		= this.$el.find('.wtbx_dots'),
				$prev		= this.$el.find('.wtbx_arrow_prev'),
				$next		= this.$el.find('.wtbx_arrow_next');

			$nav.find('.wtbx_testimonials_nav_item').unbind().on('click', function() {
				if ( !$(this).hasClass('active') ) {
					$nav.children().removeClass('active');
					$content.find('.vc_vc_testimonial_slide').removeClass('active');
					$dots.find('.dot').removeClass('is-selected');

					$(this).addClass('active');
					$dots.find('.dot').eq($(this).index()).addClass('is-selected');
					$content.find($(this).data('vc-target')).addClass('active');
				}
			});

			$prev.unbind().on('click', function() {
				var index = $nav.find('.active').index() - 1;
				index = index < 0 ? $nav.children().length - 1 : index;
				$nav.children().removeClass('active');
				$content.find('.vc_vc_testimonial_slide').removeClass('active');
				$dots.find('.dot').removeClass('is-selected');

				$nav.children().eq(index).addClass('active');
				$dots.find('.dot').eq(index).addClass('is-selected');
				$content.find('.vc_vc_testimonial_slide').eq(index).addClass('active');
			});

			$next.unbind().on('click', function() {
				var index = $nav.find('.active').index() + 1;
				index = index > $nav.children().length-1 ? 0 : index;
				$nav.children().removeClass('active');
				$content.find('.vc_vc_testimonial_slide').removeClass('active');
				$dots.find('.dot').removeClass('is-selected');

				$nav.children().eq(index).addClass('active');
				$dots.find('.dot').eq(index).addClass('is-selected');
				$content.find('.vc_vc_testimonial_slide').eq(index).addClass('active');
			});

			if ( !$nav.find('.active').length && !$content.find('.active').length ) {
				$nav.children().eq(0).addClass('active');
				$dots.find('.dot').eq(0).addClass('is-selected');
				$content.find('.vc_vc_testimonial_slide').eq(0).addClass('active');
			}

			setTimeout(function() {
				if ($nav.find('.active').length && !$content.find('.active').length) {
					$content.find($nav.find('.active').data('vc-target')).addClass('active');
				}
			});

			this.$el.find('.wtbx_testimonial_slider_wrapper').addClass('wtbx_slider_init');
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
		/**
		 *
		 * @param {Backbone.Model}model
		 */
		sectionUpdated: function ( model, justAppend ) {
			// update builded tabs, remove/add check orders and title/target

			var $tabEl,
				$navigation,
				sectionId,
				html, title, models, index, tabAdded, tab_id, $content, $dots;
			tabAdded	= false;
			sectionId	= model.get( 'id' );
			$navigation = this.$el.find( '.wtbx_testimonials_nav' );
			$content	= this.$el.find('.wtbx_testimonial_slider_inner');
			$dots		= this.$el.find('.wtbx_dots');
			$tabEl		= $navigation.find( '[data-vc-target="[data-model-id=' + sectionId + ']"]' );
			title		= model.getParam( 'author_name' ),
			tab_id		= model.getParam( 'tab_id' );

			if ( title === '' ) {
				title = 'Testimonial ' + ($tabEl.index() + 1);
			}

			if ( $tabEl.length ) {
				html = '<div class="wtbx_testimonials_nav_title">' + title + '</div>';
				$tabEl.html( html );
			} else {
				var $element;
				html = '<div class="wtbx_testimonials_nav_title">' + title + '</div>';
				$element = $( '<li class="wtbx_testimonials_nav_item" data-vc-target-model-id="' + sectionId + '" data-vc-target="[data-model-id=' + sectionId + ']" data-vc-tab>' + html + '</li>' );
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

				$dots.children('ol').append('<li class="dot"></li>');

				$navigation.children().removeClass(this.activeClass);
				$content.find('.vc_vc_testimonial_slide').removeClass(this.activeClass);
				$dots.find('.dot').removeClass('is-selected');

				if ( !justAppend && model.get( 'isActiveSection' ) ) {
					$element.addClass(this.activeClass);
					$dots.find('.dot').eq($navigation.find('.active').index()).addClass('is-selected');
					$content.find($element.data('vc-target')).addClass(this.activeClass);
				} else {
					if ( !$navigation.find('.active').length ) {
						$element.addClass(this.activeClass);
						$dots.find('.dot').eq($navigation.find('.active').index()).addClass('is-selected');
						$content.find($element.data('vc-target')).addClass(this.activeClass);
					}
				}

			}

			this.initNav();
			this.buildPagination();
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

			$navigationSections = this.$el.find( '.wtbx_testimonials_nav' ).children();
			lastIndex = $navigationSections.length - 1; // -1 because length starts from 1
			viewTabIndex = $viewTab.index();

			if ( viewTabIndex !== lastIndex ) {
				$nextTab = $navigationSections.eq( viewTabIndex + 1 );
			} else {
				// If we are the last tab in in navigation lets make active previous
				$nextTab = $navigationSections.eq( viewTabIndex - 1 );
			}
			return $nextTab.index();
		},
		removeSection: function ( modelId ) {
			var $viewTab, $nextTab, tabIsActive, $dots, $nav;

			$viewTab = this.$el.find( '.wtbx_testimonials_nav [data-vc-target="[data-model-id=' + modelId + ']"]');
			tabIsActive = $viewTab.hasClass( this.activeClass );
			this.$el.find('.wtbx_dots').find('li').eq($viewTab.index()).remove();

			// Make next tab active if needed
			$viewTab.remove();

			if ( tabIsActive ) {
				$nextTab = this.getNextTab( $viewTab );
				this.$el.find( '.wtbx_testimonials_nav' ).children().eq($nextTab).trigger( 'click' );
			}
			// Remove tab from navigation
			this.buildPagination();
		},
		buildSortableNavigation: function () {
			if ( ! vc_user_access().shortcodeEdit( this.model.get( 'shortcode' ) ) ) {
				return
			}

			// this should be called when new tab added/removed/changed.
			this.$el.find( '.wtbx_testimonials_nav' ).sortable( {
				items: '.wtbx_testimonials_nav_item',
				forcePlaceholderSize: true,
				forceHelperSize: false,
				placeholder: 'wtbx_tabs_placeholder wtbx_testimonials_nav_item',
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
			window.InlineShortcodeView_vc_testimonial_slider.__super__.updateSorting.call( this, event, ui );
			this.updateTabsPositions( this.getPanelsList() );
		},
		updateSortingNavigation: function () {
			var $tabs, self;
			self = this;
			$tabs = this.$el.find( '.wtbx_testimonials_nav' );
			// we are sorting a tabs navigation
			$tabs.find( '> .wtbx_testimonials_nav_item' ).each( function () {
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
			$tabs = this.$el.find( '.wtbx_testimonials_nav' );
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
	window.InlineShortcodeView_vc_testimonial_slide = window.InlineShortcodeViewContainerWithParent.extend( {
		events: {
			'click > .vc_controls [data-vc-control="destroy"]': 'destroy',
			'click > .vc_controls [data-vc-control="edit"]': 'edit',
			'click > .vc_controls [data-vc-control="clone"]': 'clone',
			// 'click > .vc_controls [data-vc-control="prepend"]': 'prependElement',
			// 'click > .vc_controls [data-vc-control="append"]': 'appendElement',
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
			window.InlineShortcodeView_vc_testimonial_slide.__super__.render.call( this );
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
			return vc_user_access().shortcodeAll( 'vc_testimonial_slide' );
		},
		clone: function ( e ) {
			vc.ttaSectionActivateOnClone = true;
			window.InlineShortcodeView_vc_testimonial_slide.__super__.clone.call( this, e );
		},
		addSibling: function ( e ) {
			window.InlineShortcodeView_vc_testimonial_slide.__super__.addSibling.call( this, e );
		},
		parentChanged: function () {
			window.InlineShortcodeView_vc_testimonial_slide.__super__.parentChanged.call( this );
			this.refreshContent( true );
			return this;
		},
		changed: function () {
			// if ( this.allowAddControlOnEmpty() && 0 === this.$el.find( '.vc_element[data-tag]' ).length ) {
			// 	this.$el.addClass( 'vc_empty' ).find( '.wtbx_tab_wrapper' ).addClass(
			// 		'vc_empty-element' );
			// } else {
			// 	this.$el.removeClass( 'vc_empty' ).find( '.wtbx_tab_wrapper.vc_empty-element' ).removeClass(
			// 		'vc_empty-element' );
			// }
		},
		moveClasses: function () {
			var panelClassName = '';
			if ( this.previousClasses ) {
				this.$el.get( 0 ).className = this.$el.get( 0 ).className.replace( this.previousClasses, "" );
			}
			// panelClassName = this.$el.find( '.wtbx_vc_testimonial_slide' ).get( 0 ).className;
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
			window.InlineShortcodeView_vc_testimonial_slide.__super__.destroy.call( this, e );
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