(function($) {
	"use strict";

	var Shortcodes = vc.shortcodes;

	window.VcSectionView = VcColumnView.extend({
		designHelpersSelector: "> .vc_controls-row .vc_column-edit",
		setColumnClasses: function() {
			var disable = this.model.getParam("disable_element"),
				disableClass = "vc_hidden-xs vc_hidden-sm  vc_hidden-md vc_hidden-lg";
			this.disable_element_class && this.$el.removeClass(this.disable_element_class), _.isEmpty(disable) || (this.$el.addClass(disableClass), this.disable_element_class = disableClass)
		},
		buildDesignHelpers: function() {
			var css, $elementToPrepend, image, color, elId, matches;
			//css = this.model.getParam("css"), $elementToPrepend = this.$el.find(this.designHelpersSelector), this.$el.find("> .vc_controls-row .vc_row_color").remove(), this.$el.find("> .vc_controls-row .vc_row_image").remove(), matches = css.match(/background\-image:\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (image = matches[1]), matches = css.match(/background\-color:\s*([^\s\;]+)\b/), matches && !_.isUndefined(matches[1]) && (color = matches[1]), matches = css.match(/background:\s*([^\s]+)\b\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (color = matches[1], image = matches[2]), elId = this.model.getParam("el_id"), this.$el.find("> .vc_controls-row .vc_row-hash-id").remove(), _.isEmpty(elId) || $('<span class="vc_row-hash-id"></span>').text("#" + elId).insertAfter($elementToPrepend), image && $('<span class="vc_row_image" style="background-image: url(' + image + ');" title="' + window.i18nLocale.row_background_image + '"></span>').insertAfter($elementToPrepend), color && $('<span class="vc_row_color" style="background-color: ' + color + '" title="' + window.i18nLocale.row_background_color + '"></span>').insertAfter($elementToPrepend)

			var image = this.model.getParam('custom_bg_image'),
				color = this.model.getParam('custom_bg_color'),
				$color = '',
				$column_toggle = this.$el.find('> .vc_controls .column_edit');

			this.$el.find('> .vc_controls .vc_row_color').remove();

			// "Hide on screens sizes" preview
			this.$el.find('> .vc_controls .vc_row_screens').remove();
			var row_show_on = this.model.getParam('row_show_on');
			if(row_show_on) {
				var hide_on_screen = ' '+ row_show_on.replace(/,/gi, ' ');
			} else {
				var hide_on_screen = '';
			}
			$('<span class="vc_row_screens'+ hide_on_screen +'"><i class="device-icon device-screen"></i><i class="device-icon device-tablet2"></i><i class="device-icon device-tablet"></i><i class="device-icon device-mobile2"></i><i class="device-icon device-mobile"></i></span>').insertAfter($column_toggle);
			// End preview

			if (image || color) {
				color = color !== '' ? JSON.parse(color) : '';

				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wtbx_update_bg',
						image: image,
						color: color
					}
				}).done(function(data) {
					if ( data !== '' ) {
						data = JSON.parse(data);

						if ($color == '') {
							$color = $('<span class="vc_row_color"></span>');
							$color.insertAfter($column_toggle);
						}

						if (data.color !== '' && undefined !== data.color) {
							$color.attr('style', data.color);
						}
						if (data.image != '' && undefined !== data.image) {
							$color.addClass('image_viewer').html($('<span class="vc_row_image" style="background-image: url(' + data.image + ')"></span>'));
						}
					}

				});
			}
		},
		checkIsEmpty: function() {
			window.VcSectionView.__super__.checkIsEmpty.call(this), this.setSorting()
		},
		setSorting: function() {
			var _this = this;
			this.$content.sortable({
				forcePlaceholderSize: !0,
				placeholder: "widgets-placeholder",
				connectWith: ".wpb_main_sortable,.wpb_vc_section .vc_section_container",
				cursor: "move",
				items: "> .wpb_vc_row",
				handle: ".vc_column-move",
				cancel: ".vc-non-draggable-row",
				distance: .5,
				scroll: !0,
				scrollSensitivity: 70,
				tolerance: "intersect",
				update: function(event, ui) {
					var $elements = $("> div.wpb_sortable,> div.vc-non-draggable", _this.$content);
					$elements.each(function() {
						var model = $(this).data("model"),
							index = $(this).index();
						if (model.set("order", index), $elements.length - 1 > index && vc.storage.lock(), !_.isNull(ui.sender)) {
							var $current_container = ui.item.parent().closest("[data-model-id]"),
								parent = $current_container.data("model"),
								old_parent_id = model.get("parent_id");
							vc.storage.lock(), model.save({
								parent_id: parent.id
							}), old_parent_id && vc.app.views[old_parent_id].checkIsEmpty(), vc.app.views[parent.id].checkIsEmpty()
						}
						model.save()
					})
				},
				stop: function(event, ui) {
					$("#visual_composer_content").removeClass("vc_sorting-started"), $(".dragging_in").removeClass("dragging_in");
					var tag = ui.item.data("element_type"),
						parent_tag = ui.item.parent().closest("[data-element_type]").data("element_type");
					vc.check_relevance(parent_tag, tag) && parent_tag != tag || $(this).sortable("cancel"), $(".vc_sorting-empty-container").removeClass("vc_sorting-empty-container")
				},
				over: function(event, ui) {
					var tag = ui.item.data("element_type"),
						parent_tag = ui.placeholder.closest("[data-element_type]").data("element_type") || "",
						allowed_container_element = !!_.isUndefined(vc.map[parent_tag].allowed_container_element) || vc.map[parent_tag].allowed_container_element;
					if (!vc.check_relevance(parent_tag, tag) || parent_tag == tag) return ui.placeholder.addClass("vc_hidden-placeholder"), !1;
					var is_container = _.isObject(vc.map[tag]) && (_.isBoolean(vc.map[tag].is_container) && !0 === vc.map[tag].is_container || !_.isEmpty(vc.map[tag].as_parent));
					return is_container && !0 !== allowed_container_element && allowed_container_element !== ui.item.data("element_type").replace(/_inner$/, "") ? (ui.placeholder.addClass("vc_hidden-placeholder"), !1) : (_.isNull(ui.sender) || !ui.sender.length || ui.sender.find("> [data-element_type]:not(.ui-sortable-helper):visible").length || ui.sender.addClass("vc_sorting-empty-container"), void ui.placeholder.css({
						maxWidth: ui.placeholder.parent().width()
					}))
				},
				out: function(event, ui) {
					ui.placeholder.removeClass("vc_hidden-placeholder"), ui.placeholder.css({
						maxWidth: ui.placeholder.parent().width()
					}), _.isNull(ui.sender) || !ui.sender.length || ui.sender.find("> [data-element_type]:not(.ui-sortable-helper):visible").length || ui.sender.addClass("vc_sorting-empty-container")
				}
			})
		}
	});

	window.VcRowView = vc.shortcode_view.extend({
		change_columns_layout:false,
		events: {
			'click > .vc_controls [data-vc-control="delete"]': "deleteShortcode",
			"click > .vc_controls .set_columns": "setColumns",
			'click > .vc_controls [data-vc-control="add"]': "addElement",
			'click > .vc_controls [data-vc-control="edit"]': "editElement",
			'click > .vc_controls [data-vc-control="clone"]': "clone",
			'click > .vc_controls [data-vc-control="move"]': "moveElement",
			'click > .vc_controls [data-vc-control="toggle"]': "toggleElement",
			"click > .wpb_element_wrapper .vc_controls": "openClosedRow"
		},
		convertRowColumns: function ( layout ) {
			var layout_split = layout.toString().split( /_/ ),
				columns = Shortcodes.where( { parent_id: this.model.id } ),
				new_columns = [],
				new_layout = [],
				new_width = '';
			_.each( layout_split, function ( value, i ) {
				var column_data = _.map( value.toString().split( '' ), function ( v, i ) {
						return parseInt( v, 10 );
					} ),
					new_column_params, new_column;
				if ( 3 < column_data.length ) {
					new_width = column_data[ 0 ] + '' + column_data[ 1 ] + '/' + column_data[ 2 ] + '' + column_data[ 3 ];
				} else if ( 2 < column_data.length ) {
					new_width = column_data[ 0 ] + '/' + column_data[ 1 ] + '' + column_data[ 2 ];
				} else {
					new_width = column_data[ 0 ] + '/' + column_data[ 1 ];
				}
				new_layout.push( new_width );
				new_column_params = _.extend( ! _.isUndefined( columns[ i ] ) ? columns[ i ].get( 'params' ) : {},
					{ width: new_width } ),
					vc.storage.lock();
				new_column = Shortcodes.create( {
					shortcode: this.getChildTag(),
					params: new_column_params,
					parent_id: this.model.id
				} );
				if ( _.isObject( columns[ i ] ) ) {
					_.each( Shortcodes.where( { parent_id: columns[ i ].id } ), function ( shortcode ) {
						vc.storage.lock();
						shortcode.save( { parent_id: new_column.id } );
						vc.storage.lock();
						shortcode.trigger( 'change_parent_id' );
					} );
				}
				new_columns.push( new_column );
			}, this );
			if ( layout_split.length < columns.length ) {
				_.each( columns.slice( layout_split.length ), function ( column ) {
					_.each( Shortcodes.where( { parent_id: column.id } ), function ( shortcode ) {
						vc.storage.lock();
						shortcode.save( { 'parent_id': _.last( new_columns ).id } );
						vc.storage.lock();
						shortcode.trigger( 'change_parent_id' );
					} );
				} );
			}
			_.each( columns, function ( shortcode ) {
				vc.storage.lock();
				shortcode.destroy();
			}, this );
			this.model.save();
			this.setActiveLayoutButton( '' + layout );
			return new_layout;
		},
		changeShortcodeParams:function (model) {
			window.VcRowView.__super__.changeShortcodeParams.call(this, model), this.buildDesignHelpers(), this.setRowClasses()
		},
		setRowClasses: function() {
			var disable = this.model.getParam("disable_element"),
				disableClass = "vc_hidden-xs vc_hidden-sm  vc_hidden-md vc_hidden-lg";
			this.disable_element_class && this.$el.removeClass(this.disable_element_class), _.isEmpty(disable) || (this.$el.addClass(disableClass), this.disable_element_class = disableClass)
		},
		buildDesignHelpers: function() {
			var image = this.model.getParam('custom_bg_image'),
				color = this.model.getParam('custom_bg_color'),
				$color = '',
				$column_toggle = this.$el.find('> .vc_controls .column_toggle');

			this.$el.find('> .vc_controls .vc_row_color').remove();
			this.$el.find('> .vc_controls .vc_row_screens').remove();

			var row_show_on = this.model.getParam('row_show_on');
			if(row_show_on) {
				var hide_on_screen = ' '+ row_show_on.replace(/,/gi, ' ');
			} else {
				var hide_on_screen = '';
			}
			$('<span class="vc_row_screens'+ hide_on_screen +'"><i class="device-icon device-screen"></i><i class="device-icon device-tablet2"></i><i class="device-icon device-tablet"></i><i class="device-icon device-mobile2"></i><i class="device-icon device-mobile"></i></span>').insertAfter($column_toggle);
			// End preview

			if (image || color) {
				color = color !== '' ? JSON.parse(color) : '';

				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wtbx_update_bg',
						image: image,
						color: color
					}
				}).done(function(data) {
					if ( data !== '' ) {
						data = JSON.parse(data);

						if ($color == '') {
							$color = $('<span class="vc_row_color"></span>');
							$color.insertAfter($column_toggle);
						}

						if (data.color !== '' && undefined !== data.color) {
							$color.attr('style', data.color);
						}
						if (data.image != '' && undefined !== data.image) {
							$color.addClass('image_viewer').html($('<span class="vc_row_image" style="background-image: url(' + data.image + ')"></span>'));
						}
					}

				});
			}
		},
		addElement: function ( e ) {
			e && e.preventDefault();
			Shortcodes.create( { shortcode: this.getChildTag(), params: {}, parent_id: this.model.id } );
			this.setActiveLayoutButton();
			this.$el.removeClass( 'vc_collapsed-row' );
		},
		getChildTag: function () {
			return 'vc_row_inner' === this.model.get( 'shortcode' ) ? 'vc_column_inner' : 'vc_column';
		},
		sortingSelector: "> [data-element_type=vc_column], > [data-element_type=vc_column_inner]",
		setSorting: function () {
			var that = this;
			if ( 1 < this.$content.find( this.sortingSelector ).length ) {
				this.$content.removeClass( 'wpb-not-sortable' ).sortable( {
					forcePlaceholderSize: true,
					placeholder: "widgets-placeholder-column",
					tolerance: "pointer",
					// cursorAt: { left: 10, top : 20 },
					cursor: "move",
					//handle: '.controls',
					items: this.sortingSelector, //wpb_sortablee
					distance: 0.5,
					start: function ( event, ui ) {
						$( '#visual_composer_content' ).addClass( 'vc_sorting-started' );
						ui.placeholder.width( ui.item.width() );
					},
					stop: function ( event, ui ) {
						$( '#visual_composer_content' ).removeClass( 'vc_sorting-started' );
					},
					update: function () {
						var $columns = $( that.sortingSelector, that.$content );
						$columns.each( function () {
							var model = $( this ).data( 'model' ),
								index = $( this ).index();
							model.set( 'order', index );
							if ( $columns.length - 1 > index ) {
								vc.storage.lock();
							}
							model.save();
						} );
					},
					over: function ( event, ui ) {
						ui.placeholder.css( { maxWidth: ui.placeholder.parent().width() } );
						ui.placeholder.removeClass( 'vc_hidden-placeholder' );
					},
					beforeStop: function ( event, ui ) {
					}
				} );
			} else {
				if ( this.$content.hasClass( 'ui-sortable' ) ) {
					this.$content.sortable( 'destroy' );
				}
				this.$content.addClass( 'wpb-not-sortable' );
			}
		},
		validateCellsList: function ( cells ) {
			var return_cells = [],
				split = cells.replace( /\s/g, '' ).split( '+' ),
				b;
			var sum = _.reduce( _.map( split, function ( c ) {
				if ( c.match( /^(vc_)?span\d?$/ ) ) {
					var converted_c = vc_convert_column_span_size( c );
					if ( false === converted_c ) {
						return 1000;
					}
					b = converted_c.split( /\// );
					return_cells.push( b[ 0 ] + '' + b[ 1 ] );
					return 12 * parseInt( b[ 0 ], 10 ) / parseInt( b[ 1 ], 10 );
				} else if ( c.match( /^[1-9]|1[0-2]\/[1-9]|1[0-2]$/ ) ) {
					b = c.split( /\// );
					return_cells.push( b[ 0 ] + '' + b[ 1 ] );
					return 12 * parseInt( b[ 0 ], 10 ) / parseInt( b[ 1 ], 10 );
				}
				return 10000;

			} ), function ( num, memo ) {
				memo = memo + num;
				return memo;
			}, 0 );
			if ( 12 !== sum ) {
				return false;
			}
			return return_cells.join( '_' );
		},
		setActiveLayoutButton: function ( column_layout ) {
			if ( ! column_layout ) {
				column_layout = _.map( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
					function ( model ) {
						var width = model.getParam( 'width' );
						return ! width ? '11' : width.replace( /\//, '' );
					} ).join( '_' );
			}
			this.$el.find( '> .vc_controls .vc_active' ).removeClass( 'vc_active' );
			var $button = this.$el.find( '> .controls [data-cells-mask="' + vc_get_column_mask( column_layout ) + '"] [data-cells="' + column_layout + '"]'
			+ ', > .vc_controls [data-cells-mask="' + vc_get_column_mask( column_layout ) + '"][data-cells="' + column_layout + '"]' );
			if ( $button.length ) {
				$button.addClass( 'vc_active' );
			} else {
				this.$el.find( '> .controls [data-cells-mask=custom]' ).addClass( 'vc_active' );
			}
		},
		layoutEditor: function () {
			if ( _.isUndefined( vc.row_layout_editor ) ) {
				// vc.row_layout_editor = new vc.RowLayoutEditorPanelViewBackend( { el: $( '#vc_row-layout-panel' ) } );
				vc.row_layout_editor = new vc.RowLayoutUIPanelBackendEditor( { el: $( '#vc_ui-panel-row-layout' ) } );
			}
			return vc.row_layout_editor;
		},
		setColumns: function ( e ) {
			if ( _.isObject( e ) ) {
				e.preventDefault();
			}
			var $button = $( e.currentTarget );
			if ( 'custom' === $button.data( 'cells' ) ) {
				this.layoutEditor().render( this.model ).show();
			} else {
				if ( vc.is_mobile ) {
					var $parent = $button.parent();
					if ( ! $parent.hasClass( 'vc_visible' ) ) {
						$parent.addClass( 'vc_visible' );
						$( document ).bind( 'click.vcRowColumnsControl', function ( e ) {
							$parent.removeClass( 'vc_visible' );
							$( document ).unbind( 'click.vcRowColumnsControl' );
						} );
					}
				}
				if ( ! $button.is( '.vc_active' ) ) {
					this.change_columns_layout = true;
					_.defer( function ( view, cells ) {
						view.convertRowColumns( cells );
					}, this, $button.data( 'cells' ) );
				}
			}
			this.$el.removeClass( 'vc_collapsed-row' );
		},
		sizeRows: function () {
			var max_height = 45;
			$( '> .wpb_vc_column, > .wpb_vc_column_inner', this.$content ).each( function () {
				var content_height = $( this ).find( '> .wpb_element_wrapper > .wpb_column_container' ).css( { minHeight: 0 } ).height();
				if ( content_height > max_height ) {
					max_height = content_height;
				}
			} ).each( function () {
				$( this ).find( '> .wpb_element_wrapper > .wpb_column_container' ).css( { minHeight: max_height } );
			} );
		},
		ready: function ( e ) {
			window.VcRowView.__super__.ready.call( this, e );
			return this;
		},
		checkIsEmpty: function () {
			window.VcRowView.__super__.checkIsEmpty.call( this );
			this.setSorting();
		},
		changedContent: function ( view ) {
			if ( this.change_columns_layout ) {
				return this;
			}
			this.setActiveLayoutButton();
		},
		moveElement: function ( e ) {
			e.preventDefault();
		},
		toggleElement: function ( e ) {
			e && e.preventDefault();
			this.$el.toggleClass( 'vc_collapsed-row' );
		},
		openClosedRow: function ( e ) {
			this.$el.removeClass( 'vc_collapsed-row' );
		}
	});

	window.VcColumnView = vc.shortcode_view.extend({
		events: {
			'click > .vc_controls [data-vc-control="delete"]': "deleteShortcode",
			'click > .vc_controls [data-vc-control="add"]': "addElement",
			'click > .vc_controls [data-vc-control="edit"]': "editElement",
			'click > .vc_controls [data-vc-control="clone"]': "clone",
			'click > .vc_controls [data-vc-control="move"]': "moveElement",
			"click > .wpb_element_wrapper > .vc_empty-container": "addToEmpty"
		},
		current_column_width: !1,
		initialize: function(options) {
			window.VcColumnView.__super__.initialize.call(this, options), _.bindAll(this, "setDropable", "dropButton")
		},
		ready: function(e) {
			return window.VcColumnView.__super__.ready.call(this, e), this
		},
		render: function() {
			return window.VcColumnView.__super__.render.call(this), this.current_column_width = this.model.get("params").width || "1/1", this.$el.attr("data-width", this.current_column_width), this.setEmpty(), this
		},
		changeShortcodeParams: function(model) {
			window.VcColumnView.__super__.changeShortcodeParams.call(this, model), this.setColumnClasses(), this.buildDesignHelpers()
		},
		designHelpersSelector: "> .vc_controls .column_add",
		buildDesignHelpers: function() {
			var matches, css = this.model.getParam("css"),
				$column_toggle = this.$el.find(this.designHelpersSelector).get(0);
			//this.$el.find("> .vc_controls .vc_column_color").remove(), this.$el.find("> .vc_controls .vc_column_image").remove(), matches = css.match(/background\-image:\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (image = matches[1]), matches = css.match(/background\-color:\s*([^\s\;]+)\b/), matches && !_.isUndefined(matches[1]) && (color = matches[1]), matches = css.match(/background:\s*([^\s]+)\b\s*url\(([^\)]+)\)/), matches && !_.isUndefined(matches[1]) && (color = matches[1], image = matches[2]), image && $('<span class="vc_column_image" style="background-image: url(' + image + ');" title="' + i18nLocale.column_background_image + '"></span>').insertBefore($column_toggle), color && $('<span class="vc_column_color" style="background-color: ' + color + '" title="' + i18nLocale.column_background_color + '"></span>').insertBefore($column_toggle)
			var image = this.model.getParam('custom_bg_image'),
				color = this.model.getParam('custom_bg_color'),
				$color = '',
				$column_toggle = this.$el.find('> .vc_controls').get(0);

			this.$el.find('> .vc_controls .vc_row_color').remove();

			if (image || color) {
				color = color !== '' ? JSON.parse(color) : '';

				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wtbx_update_bg',
						image: image,
						color: color
					}
				}).done(function(data) {
					if ( data !== '' ) {
						data = JSON.parse(data);

						if ($color == '') {
							$color = $('<span class="vc_row_color"></span>');
							$color.prependTo($column_toggle);
						}

						if (data.color !== '' && undefined !== data.color) {
							$color.attr('style', data.color);
						}
						if (data.image != '' && undefined !== data.image) {
							$color.addClass('image_viewer').html($('<span class="vc_row_image" style="background-image: url(' + data.image + ')"></span>'));
						}
					}

				});
			}
		},
		setColumnClasses: function() {
			var current_css_class_width, offset = this.model.getParam("offset") || "",
				width = this.model.getParam("width") || "1/1",
				css_class_width = this.convertSize(width);
			this.current_offset_class && this.$el.removeClass(this.current_offset_class), this.current_column_width !== width && (current_css_class_width = this.convertSize(this.current_column_width), this.$el.attr("data-width", width).removeClass(current_css_class_width).addClass(css_class_width), this.current_column_width = width), offset.match(/vc_col\-sm\-\d+/) && this.$el.removeClass(css_class_width), _.isEmpty(offset) || this.$el.addClass(offset), this.current_offset_class = offset
		},
		addToEmpty: function(e) {
			e.preventDefault(), $(e.target).hasClass("vc_empty-container") && this.addElement(e)
		},
		setDropable: function() {
			return this.$content.droppable({
				greedy: !0,
				accept: "vc_column_inner" === this.model.get("shortcode") ? ".dropable_el" : ".dropable_el,.dropable_row",
				hoverClass: "wpb_ui-state-active",
				drop: this.dropButton
			}), this
		},
		dropButton: function(event, ui) {
			ui.draggable.is("#wpb-add-new-element") ? vc.add_element_block_view({
				model: {
					position_to_add: "end"
				}
			}).show(this) : ui.draggable.is("#wpb-add-new-row") && this.createRow()
		},
		setEmpty: function() {
			this.$el.addClass("vc_empty-column"), "edit" !== vc_user_access().getState("shortcodes") && this.$content.addClass("vc_empty-container")
		},
		unsetEmpty: function() {
			this.$el.removeClass("vc_empty-column"), this.$content.removeClass("vc_empty-container")
		},
		checkIsEmpty: function() {
			Shortcodes.where({
				parent_id: this.model.id
			}).length ? this.unsetEmpty() : this.setEmpty(), window.VcColumnView.__super__.checkIsEmpty.call(this)
		},
		createRow: function() {
			var row_params, column_params, row;
			return row_params = {}, void 0 !== window.vc_settings_presets.vc_row_inner && (row_params = _.extend(row_params, window.vc_settings_presets.vc_row_inner)), column_params = {
				width: "1/1"
			}, void 0 !== window.vc_settings_presets.vc_column_inner && (column_params = _.extend(column_params, window.vc_settings_presets.vc_column_inner)), row = Shortcodes.create({
				shortcode: "vc_row_inner",
				params: row_params,
				parent_id: this.model.id
			}), Shortcodes.create({
				shortcode: "vc_column_inner",
				params: column_params,
				parent_id: row.id
			}), row
		},
		convertSize: function(width) {
			var numbers = width ? width.split("/") : [1, 1],
				range = _.range(1, 13),
				num = !_.isUndefined(numbers[0]) && 0 <= _.indexOf(range, parseInt(numbers[0], 10)) && parseInt(numbers[0], 10),
				dev = !_.isUndefined(numbers[1]) && 0 <= _.indexOf(range, parseInt(numbers[1], 10)) && parseInt(numbers[1], 10);
			return !1 !== num && !1 !== dev ? "vc_col-sm-" + 12 * num / dev : "vc_col-sm-12"
		},
		deleteShortcode: function(e) {
			var parent, parent_id = this.model.get("parent_id");
			if (_.isObject(e) && e.preventDefault(), !0 !== confirm(window.i18nLocale.press_ok_to_delete_section)) return !1;
			this.model.destroy(), parent_id && !vc.shortcodes.where({
				parent_id: parent_id
			}).length ? (parent = vc.shortcodes.get(parent_id), _.contains(["vc_column", "vc_column_inner"], parent.get("shortcode")) || parent.destroy()) : parent_id && (parent = vc.shortcodes.get(parent_id)) && parent.view && parent.view.setActiveLayoutButton && parent.view.setActiveLayoutButton()
		},
		remove: function() {
			this.$content && this.$content.data("uiSortable") && this.$content.sortable("destroy"), this.$content && this.$content.data("uiDroppable") && this.$content.droppable("destroy"), delete vc.app.views[this.model.id], window.VcColumnView.__super__.remove.call(this)
		}
	});

	window.VcExpandableListView = VcBackendTtaViewInterface.extend({
		sortableSelector: "> .vc_tta-panel:not(.vc_tta-section-append)",
		sortableSelectorCancel: ".vc-non-draggable",
		sortableUpdateModelIdSelector: "data-model-id",
		defaultSectionTitle: 'Expandable list item',
		render: function() {
			return window.VcExpandableListView.__super__.render.call(this), this.$tabs = this.$el.find(".vc_tta-container"), this.$navigation = this.$content, this.$sortable = this.$content, vc_user_access().shortcodeAll("vc_tta_section") || this.$content.find(".vc_tta-section-append").hide(), this
		},
		removeSection: function(model) {
			var $viewTab, $nextTab, tabIsActive;
			$viewTab = this.findSection(model.get("id")), tabIsActive = $viewTab.hasClass(this.activeClass), tabIsActive && ($nextTab = this.getNextTab($viewTab), $nextTab.addClass(this.activeClass))
		},
		addShortcode: function(view) {
			var beforeShortcode;
			beforeShortcode = _.last(vc.shortcodes.filter(function(shortcode) {
				return shortcode.get("parent_id") === this.get("parent_id") && parseFloat(shortcode.get("order")) < parseFloat(this.get("order"))
			}, view.model)), beforeShortcode ? view.render().$el.insertAfter("[data-model-id=" + beforeShortcode.id + "]") : this.$content.prepend(view.render().el)
		},
		addSection: function(prepend) {
			var params, shortcode;
			var tabs_count = this.$tabs.find("[data-element_type=vc_expandable_list_item]").length,
				tab_title = 'List item ' + (tabs_count + 1);
			return params = {
				shortcode: "vc_expandable_list_item",
				params: {
					title: tab_title
				},
				parent_id: this.model.get("id"),
				order: _.isBoolean(prepend) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder(),
				prepend: prepend
			}, shortcode = vc.shortcodes.create(params)
		}
	});

	window.VcExpandableListItemView = window.VcColumnView.extend({
		parentObj: null,
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone",
			"click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_empty-container": "addToEmpty"
		},
		setContent: function() {
			this.$content = this.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_container_for_children")
		},
		render: function() {
			var parentObj;
			return window.VcExpandableListItemView.__super__.render.call(this), parentObj = vc.shortcodes.get(this.model.get("parent_id")), _.isObject(parentObj) && !_.isUndefined(parentObj.view) && (this.parentObj = parentObj), this.$el.addClass("vc_tta-panel"), this.$el.attr("style", ""), this.$el.attr("data-vc-toggle", "tab"), this.replaceTemplateVars(), this
		},
		replaceTemplateVars: function() {
			var title, $panelHeading;
			title = this.model.getParam("title"), _.isEmpty(title) && (title = this.parentObj && this.parentObj.defaultSectionTitle && this.parentObj.defaultSectionTitle.length ? this.parentObj.defaultSectionTitle : window.i18nLocale.section), $panelHeading = this.$el.find(".vc_tta-panel-heading");
			var template = vc.template($panelHeading.html(), vc.templateOptions.custom);
			$panelHeading.html(template({
				model_id: this.model.get("id"),
				section_title: title
			}))
		},
		getIndex: function() {
			return this.$el.index()
		},
		ready: function() {
			this.updateParentNavigation(), window.VcExpandableListItemView.__super__.ready.call(this), this.$tabs = this.$el.closest(".vc_tta-panels")
		},
		updateParentNavigation: function() {
			_.isObject(this.parentObj) && this.parentObj.view && this.parentObj.view.notifySectionRendered && this.parentObj.view.notifySectionRendered(this.model)
		},
		deleteShortcode: function(e) {
			var answer;
			return _.isObject(e) && e.preventDefault(), answer = confirm(window.i18nLocale.press_ok_to_delete_section), !0 !== answer ? !1 : (1 === vc.shortcodes.where({
				parent_id: this.model.get("parent_id")
			}).length ? (this.model.destroy(), this.parentObj && this.parentObj.destroy()) : (this.parentObj && this.parentObj.view && this.parentObj.view.removeSection && this.parentObj.view.removeSection(this.model), this.model.destroy()), !0)
		},
		changeShortcodeParams: function(model) {
			window.VcExpandableListItemView.__super__.changeShortcodeParams.call(this, model), _.isObject(this.parentObj) && this.parentObj.view && this.parentObj.view.notifySectionChanged && this.parentObj.view.notifySectionChanged(model)
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			var tabs_count = this.$tabs.find("[data-element_type=vc_expandable_list_item]").length,
				tab_title = 'List item ' + (tabs_count + 1);
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_expandable_list_item" === tag && _.extend(params, {
				tab_id: Date.now() + "-" + this.$tabs.find("[data-element_type=vc_expandable_list_item]").length + "-" + Math.floor(11 * Math.random()),
				title: tab_title
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: !0,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function (shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	});

	window.VcCustomImageView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		},
		changeShortcodeParams:function (model) {
			window.VcCustomImageView.__super__.changeShortcodeParams.call(this, model);

			var image	= this.model.getParam('image'),
				$cont	= this.$el.find('> .wpb_element_wrapper .wpb_element_title'),
				type	= this.$el.data('element_type');

			$cont.find('.vc_carousel_images').remove();

			if (image) {
				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wtbx_get_images',
						images: image
					}
				}).done(function(data) {
					$cont.find('.vc_element-icon').remove();
					if ( data !== '' ) {
						$cont.prepend('<img width="150" height="150" src="' + data + '" class="attachment-thumbnail vc_general vc_element-icon attachment_image_preview" />');
					} else {
						$cont.prepend('<i class="vc_general vc_element-icon icon-wpb-'+type+'"></i>');
					}
				});
			} else {
				$cont.find('.vc_element-icon').remove();
				$cont.prepend('<i class="vc_general vc_element-icon icon-wpb-'+type+'"></i>');
			}
		}
	});

	window.VcImageCarouselView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		},
		changeShortcodeParams:function (model) {
			window.VcImageCarouselView.__super__.changeShortcodeParams.call(this, model);

			var images = this.model.getParam('images'),
				$cont = this.$el.find('> .wpb_element_wrapper');

			$cont.find('.vc_carousel_images').remove();

			if (images) {

				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wtbx_get_images',
						images: images
					}
				}).done(function(data) {
					if ( data !== '' ) {

						var newImages = data.split(',');

						var $images = $('<span class="vc_carousel_images"></span>');
						$images.appendTo($cont);

						for ( var i=0; i<newImages.length; i++ ) {
							$images.append('<img src="' + newImages[i] + '" />');
						}

					}

				});
			}
		}
	});

	//window.VcCustomServiceView = vc.shortcode_view.extend({
	//   changeShortcodeParams:function (model) {
	//	var params = model.get('params');
	//	window.VcCustomServiceView.__super__.changeShortcodeParams.call(this, model);
	//	if (_.isObject(params) && _.isString(params.type)) {
	//		if(_.isString(params.icon_color)){
	//				var icon_style = ' style="color:'+ params.icon_color + ';"';
	//		} else {
	//				var icon_style = '';
	//		}
	//
	//		this.$el.find('.wpb_element_wrapper .admin_label_type').after('<div class="icon_name"><i'+ icon_style +' class="service-icon ' + params['icon_' + params.type] + '"></i></div>');
	//	 }
	//   }
	//});

	window.VcContentBoxView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		},
		changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcContentBoxView.__super__.changeShortcodeParams.call(this, model);
			if (_.isObject(params)) {
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'h4.title' ) );
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'span.wpb_vc_param_value' ) );
			}
		}
	});

	window.VcCustomTabsView = vc.shortcode_view.extend({
		new_tab_adding: !1,
		events: {
			"click .add_tab": "addTab",
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone"
		},
		initialize: function(params) {
			window.VcCustomTabsView.__super__.initialize.call(this, params), _.bindAll(this, "stopSorting")
		},
		render: function() {
			return window.VcCustomTabsView.__super__.render.call(this), this.$tabs = this.$el.find(".wpb_tabs_holder"), this.createAddTabButton(), this
		},
		ready: function(e) {
			window.VcCustomTabsView.__super__.ready.call(this, e)
		},
		createAddTabButton: function() {
			var new_tab_button_id = Date.now() + "-" + Math.floor(11 * Math.random());
			this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>'), this.$add_button = $('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"><i class="vc-composer-icon vc-c-icon-add"></i></a></li>').appendTo(this.$tabs.find(".tabs_controls")), vc_user_access().shortcodeAll("vc_custom_tab") || this.$add_button.hide()
		},
		addTab: function(e) {
			if (e.preventDefault(), !vc_user_access().shortcodeAll("vc_custom_tab")) return !1;
			this.new_tab_adding = !0;
			var tabs_count = this.$tabs.find("[data-element_type=vc_custom_tab]").length,
				tab_title = 'Tab ' + (tabs_count+1),
				tab_id = 'tab-' + Date.now() + "-" + tabs_count + "-" + Math.floor(11 * Math.random());
			return vc.shortcodes.create({
				shortcode: "vc_custom_tab",
				params: {
					title: tab_title,
					tab_id: tab_id
				},
				parent_id: this.model.id
			}), !1
		},
		stopSorting: function(event, ui) {
			var shortcode;
			this.$tabs.find("ul.tabs_controls li:not(.add_tab_block)").each(function(index) {
				$(this).find("a").attr("href").replace("#", "");
				shortcode = vc.shortcodes.get($("[id=" + $(this).attr("aria-controls") + "]").data("model-id")), vc.storage.lock(), shortcode.save({
					order: $(this).index()
				})
			}), shortcode && shortcode.save()
		},
		changedContent: function(view) {
			var params = view.model.get("params");
			if (this.$tabs.hasClass("ui-tabs") || (this.$tabs.tabs({
					select: function(event, ui) {
						return !$(ui.tab).hasClass("add_tab")
					}
				}), this.$tabs.find(".ui-tabs-nav").prependTo(this.$tabs), vc_user_access().shortcodeAll("vc_custom_tab") && this.$tabs.find(".ui-tabs-nav").sortable({
					axis: "vc_custom_tour" === this.$tabs.closest("[data-element_type]").data("element_type") ? "y" : "x",
					update: this.stopSorting,
					items: "> li:not(.add_tab_block)"
				})), !0 === view.model.get("cloned")) {
				var $tab_controls = (view.model.get("cloned_from"), $(".tabs_controls > .add_tab_block", this.$content)),
					$new_tab = $("<li><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>").insertBefore($tab_controls);
				this.$tabs.tabs("refresh"), this.$tabs.tabs("option", "active", $new_tab.index())
			} else $("<li><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>").insertBefore(this.$add_button), this.$tabs.tabs("refresh"), this.$tabs.tabs("option", "active", this.new_tab_adding ? $(".ui-tabs-nav li", this.$content).length - 2 : 0);
			this.new_tab_adding = !1
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_custom_tab" === tag && _.extend(params, {
				tab_id: 'tab-' + Date.now() + "-" + this.$tabs.find("[data-element-type=vc_custom_tab]").length + "-" + Math.floor(11 * Math.random())
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				id: vc_guid(),
				parent_id: parent_id,
				order: new_order,
				cloned: "vc_custom_tab" !== tag,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	});

	window.VcCustomTabView = window.VcColumnView.extend({
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone",
			"click > .wpb_element_wrapper > .vc_empty-container": "addToEmpty"
		},
		render: function() {
			var params = this.model.get("params");
			return window.VcCustomTabView.__super__.render.call(this), params.tab_id || (params.tab_id = Date.now() + "-" + Math.floor(11 * Math.random()), this.model.save("params", params)), this.id = "tab-" + params.tab_id, this.$el.attr("id", this.id), this
		},
		ready: function(e) {
			window.VcCustomTabView.__super__.ready.call(this, e), this.$tabs = this.$el.closest(".wpb_tabs_holder");
			this.model.get("params");
			return this
		},
		changeShortcodeParams: function(model) {
			var params;
			window.VcCustomTabView.__super__.changeShortcodeParams.call(this, model), params = model.get("params"), _.isObject(params) && _.isString(params.title) && _.isString(params.tab_id) && $('.ui-tabs-nav [href="#tab-' + params.tab_id + '"]').text(params.title)
		},
		deleteShortcode: function(e) {
			_.isObject(e) && e.preventDefault();
			var answer = confirm(window.i18nLocale.press_ok_to_delete_section),
				parent_id = this.model.get("parent_id");
			if (!0 !== answer) return !1;
			if (this.model.destroy(), !vc.shortcodes.where({
					parent_id: parent_id
				}).length) {
				var parent = vc.shortcodes.get(parent_id);
				return parent.destroy(), !1
			}
			var params = this.model.get("params"),
				current_tab_index = $('[href="#tab-' + params.tab_id + '"]', this.$tabs).parent().index();
			$('[href="#tab-' + params.tab_id + '"]').parent().remove();
			var tab_length = this.$tabs.find(".ui-tabs-nav li:not(.add_tab_block)").length;
			0 < tab_length && this.$tabs.tabs("refresh"), current_tab_index < tab_length ? this.$tabs.tabs("option", "active", current_tab_index) : 0 < tab_length && this.$tabs.tabs("option", "active", tab_length - 1)
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			var tabs_count = this.$tabs.find("[data-element_type=vc_custom_tab]").length,
				tab_title = 'Tab ' + (tabs_count+1);
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_custom_tab" === tag && _.extend(params, {
				tab_id: 'tab-' + Date.now() + "-" + this.$tabs.find("[data-element_type=vc_custom_tab]").length + "-" + Math.floor(11 * Math.random()),
				title: tab_title
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: !0,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	});

	window.VcCustomAccordionView = VcBackendTtaViewInterface.extend({
		sortableSelector: "> .vc_tta-panel:not(.vc_tta-section-append)",
		sortableSelectorCancel: ".vc-non-draggable",
		sortableUpdateModelIdSelector: "data-model-id",
		defaultSectionTitle: 'Accordion Tab',
		render: function() {
			this.$tabs = this.$el;
			return window.VcCustomAccordionView.__super__.render.call(this), this.$navigation = this.$content, this.$sortable = this.$content, vc_user_access().shortcodeAll("vc_tta_section") || this.$content.find(".vc_tta-section-append").hide(), this
		},
		removeSection: function(model) {
			var $viewTab, $nextTab, tabIsActive;
			$viewTab = this.findSection(model.get("id")), tabIsActive = $viewTab.hasClass(this.activeClass), tabIsActive && ($nextTab = this.getNextTab($viewTab), $nextTab.addClass(this.activeClass))
		},
		addShortcode: function(view) {
			var beforeShortcode;
			beforeShortcode = _.last(vc.shortcodes.filter(function(shortcode) {
				return shortcode.get("parent_id") === this.get("parent_id") && parseFloat(shortcode.get("order")) < parseFloat(this.get("order"))
			}, view.model)), beforeShortcode ? view.render().$el.insertAfter("[data-model-id=" + beforeShortcode.id + "]") : this.$content.prepend(view.render().el)
		},
		addSection: function(prepend) {
			var newTabTitle, params, shortcode,
				tabs_count = this.$tabs.find( '[data-element_type=vc_custom_accordion_tab]' ).length,
				tab_id = ('tab-' + Date.now() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
			var tab_title = 'Accordion Tab ' + (tabs_count+1);
			return newTabTitle = this.defaultSectionTitle, params = {
				shortcode: "vc_custom_accordion_tab",
				params: {
					title: tab_title,
					el_id: tab_id
				},
				parent_id: this.model.get("id"),
				order: _.isBoolean(prepend) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder(),
				prepend: prepend
			}, shortcode = vc.shortcodes.create(params)
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_custom_accordion_tab" === tag && _.extend(params, {
				el_id: 'tab-' + Date.now() + "-" + this.$tabs.find("[data-element_type=vc_custom_accordion_tab]").length + "-" + Math.floor(11 * Math.random())
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: !0,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	});

	window.VcCustomAccordionTabView = window.VcColumnView.extend({
		parentObj: null,
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone",
			"click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_empty-container": "addToEmpty"
		},
		setContent: function() {
			this.$content = this.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_container_for_children")
		},
		render: function() {
			var parentObj;
			return window.VcCustomAccordionTabView.__super__.render.call(this), parentObj = vc.shortcodes.get(this.model.get("parent_id")), _.isObject(parentObj) && !_.isUndefined(parentObj.view) && (this.parentObj = parentObj), this.$el.addClass("vc_tta-panel"), this.$el.attr("style", ""), this.$el.attr("data-vc-toggle", "tab"), this.replaceTemplateVars(), this
		},
		replaceTemplateVars: function() {
			var title, $panelHeading;
			title = this.model.getParam("title"), _.isEmpty(title) && (title = this.parentObj && this.parentObj.defaultSectionTitle && this.parentObj.defaultSectionTitle.length ? this.parentObj.defaultSectionTitle : window.i18nLocale.section), $panelHeading = this.$el.find(".vc_tta-panel-heading");
			var template = vc.template($panelHeading.html(), vc.templateOptions.custom);
			$panelHeading.html(template({
				model_id: this.model.get("id"),
				section_title: title
			}))
		},
		getIndex: function() {
			return this.$el.index()
		},
		ready: function() {
			this.updateParentNavigation(), window.VcCustomAccordionTabView.__super__.ready.call(this);
			this.$tabs = this.$el.closest( '.vc_tta-panels' );
			var params = this.model.get( 'params' );
			return this;
		},
		updateParentNavigation: function() {
			_.isObject(this.parentObj) && this.parentObj.view && this.parentObj.view.notifySectionRendered && this.parentObj.view.notifySectionRendered(this.model)
		},
		deleteShortcode: function(e) {
			var answer;
			return _.isObject(e) && e.preventDefault(), answer = confirm(window.i18nLocale.press_ok_to_delete_section), !0 !== answer ? !1 : (1 === vc.shortcodes.where({
				parent_id: this.model.get("parent_id")
			}).length ? (this.model.destroy(), this.parentObj && this.parentObj.destroy()) : (this.parentObj && this.parentObj.view && this.parentObj.view.removeSection && this.parentObj.view.removeSection(this.model), this.model.destroy()), !0)
		},
		changeShortcodeParams: function(model) {
			window.VcCustomAccordionTabView.__super__.changeShortcodeParams.call(this, model), _.isObject(this.parentObj) && this.parentObj.view && this.parentObj.view.notifySectionChanged && this.parentObj.view.notifySectionChanged(model)
		},
		cloneModel: function ( model, parent_id, save_order ) {
			var new_order,
				model_clone,
				params,
				tag;

			new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
			params = _.extend( {}, model.get( 'params' ) );
			tag = model.get( 'shortcode' );
			var tab_title = 'Accordion Tab ' + (this.$tabs.find( '[data-element_type=vc_custom_accordion_tab]' ).length + 1);


			if ( tag === 'vc_custom_accordion_tab' ) {
				_.extend( params,
					{
						el_id: 'tab-' + Date.now() + '-' + this.$tabs.find( '[data-element_type=vc_custom_accordion_tab]' ).length + '-' + Math.floor( Math.random() * 11 ),
						title: tab_title
					} )
			}

			model_clone = Shortcodes.create( {
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: true,
				cloned_from: model.toJSON(),
				params: params
			} );

			_.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
				this.cloneModel( shortcode, model_clone.get( 'id' ), true );
			}, this );
			return model_clone;
		}
	});

	window.VcContentSliderView = vc.shortcode_view.extend( {
		new_tab_adding: !1,
		events: {
			"click .add_tab": "addTab",
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone"
		},
		initialize: function(params) {
			window.VcContentSliderView.__super__.initialize.call(this, params), _.bindAll(this, "stopSorting")
		},
		render: function() {
			return window.VcContentSliderView.__super__.render.call(this), this.$tabs = this.$el.find(".wpb_tabs_holder"), this.createAddTabButton(), this
		},
		ready: function(e) {
			window.VcContentSliderView.__super__.ready.call(this, e)
		},
		createAddTabButton: function() {
			var new_tab_button_id = Date.now() + "-" + Math.floor(11 * Math.random());
			this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>'), this.$add_button = $('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"><i class="vc-composer-icon vc-c-icon-add"></i></a></li>').appendTo(this.$tabs.find(".tabs_controls")), vc_user_access().shortcodeAll("vc_content_slide") || this.$add_button.hide()
		},
		addTab: function(e) {
			if (e.preventDefault(), !vc_user_access().shortcodeAll("vc_content_slide")) return !1;
			this.new_tab_adding = !0;
			var tabs_count = this.$tabs.find("[data-element_type=vc_content_slide]").length,
				tab_title = 'Slide-' + (tabs_count+1),
				slide_id = Date.now() + "-" + tabs_count + "-" + Math.floor(11 * Math.random());
			return vc.shortcodes.create({
				shortcode: "vc_content_slide",
				params: {
					title: tab_title,
					slide_id: slide_id
				},
				parent_id: this.model.id
			}), !1
		},
		stopSorting: function(event, ui) {
			var shortcode;
			this.$tabs.find("ul.tabs_controls li:not(.add_tab_block)").each(function(index) {
				$(this).find("a").attr("href").replace("#", "");
				shortcode = vc.shortcodes.get($("[id=" + $(this).attr("aria-controls") + "]").data("model-id")), vc.storage.lock(), shortcode.save({
					order: $(this).index()
				})
			}), shortcode && shortcode.save()
		},
		changedContent: function(view) {
			var params = view.model.get("params");
			if (this.$tabs.hasClass("ui-tabs") || (this.$tabs.tabs({
					select: function(event, ui) {
						return !$(ui.tab).hasClass("add_tab")
					}
				}), this.$tabs.find(".ui-tabs-nav").prependTo(this.$tabs), vc_user_access().shortcodeAll("vc_content_slide") && this.$tabs.find(".ui-tabs-nav").sortable({
					axis: "vc_custom_tour" === this.$tabs.closest("[data-element_type]").data("element_type") ? "y" : "x",
					update: this.stopSorting,
					items: "> li:not(.add_tab_block)"
				})), !0 === view.model.get("cloned")) {
				var $tab_controls = (view.model.get("cloned_from"), $(".tabs_controls > .add_tab_block", this.$content)),
					$new_tab = $("<li><a href='#tab-" + params.slide_id + "'>" + params.title + "</a></li>").insertBefore($tab_controls);
				this.$tabs.tabs("refresh"), this.$tabs.tabs("option", "active", $new_tab.index())
			} else $("<li><a href='#tab-" + params.slide_id + "'>" + params.title + "</a></li>").insertBefore(this.$add_button), this.$tabs.tabs("refresh"), this.$tabs.tabs("option", "active", this.new_tab_adding ? $(".ui-tabs-nav li", this.$content).length - 2 : 0);
			this.new_tab_adding = !1
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_custom_slide" === tag && _.extend(params, {
				slide_id: Date.now() + "-" + this.$tabs.find("[data-element-type=vc_content_slide]").length + "-" + Math.floor(11 * Math.random())
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				id: vc_guid(),
				parent_id: parent_id,
				order: new_order,
				cloned: "vc_content_slide" !== tag,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	} );

	window.VcContentSlideView = window.VcColumnView.extend( {
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone",
			"click > .wpb_element_wrapper > .vc_empty-container": "addToEmpty"
		},
		render: function() {
			var params = this.model.get("params");
			return window.VcContentSlideView.__super__.render.call(this), params.slide_id || (params.slide_id = Date.now() + "-" + Math.floor(11 * Math.random()), this.model.save("params", params)), this.id = "tab-" + params.slide_id, this.$el.attr("id", this.id), this
		},
		ready: function(e) {
			window.VcContentSlideView.__super__.ready.call(this, e), this.$tabs = this.$el.closest(".wpb_tabs_holder");
			this.model.get("params");
			return this
		},
		changeShortcodeParams: function(model) {
			var params;
			window.VcContentSlideView.__super__.changeShortcodeParams.call(this, model), params = model.get("params"), _.isObject(params) && _.isString(params.title) && _.isString(params.slide_id) && $('.ui-tabs-nav [href="#tab-' + params.slide_id + '"]').text(params.title)
		},
		deleteShortcode: function(e) {
			_.isObject(e) && e.preventDefault();
			var answer = confirm(window.i18nLocale.press_ok_to_delete_section),
				parent_id = this.model.get("parent_id");
			if (!0 !== answer) return !1;
			if (this.model.destroy(), !vc.shortcodes.where({
					parent_id: parent_id
				}).length) {
				var parent = vc.shortcodes.get(parent_id);
				return parent.destroy(), !1
			}
			var params = this.model.get("params"),
				current_tab_index = $('[href="#tab-' + params.slide_id + '"]', this.$tabs).parent().index();
			$('[href="#tab-' + params.slide_id + '"]').parent().remove();
			var tab_length = this.$tabs.find(".ui-tabs-nav li:not(.add_tab_block)").length;
			0 < tab_length && this.$tabs.tabs("refresh"), current_tab_index < tab_length ? this.$tabs.tabs("option", "active", current_tab_index) : 0 < tab_length && this.$tabs.tabs("option", "active", tab_length - 1)
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			var tabs_count = this.$tabs.find("[data-element_type=vc_content_slide]").length,
				tab_title = 'Slide-' + (tabs_count+1);
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_content_slide" === tag && _.extend(params, {
				slide_id: Date.now() + "-" + this.$tabs.find("[data-element_type=vc_content_slide]").length + "-" + Math.floor(11 * Math.random()),
				title: tab_title
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: !0,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	} );

	window.VcTestimonialView = vc.shortcode_view.extend({
		changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcTestimonialView.__super__.changeShortcodeParams.call(this, model);
		}
	});

	window.VcTestimonialSliderView = vc.shortcode_view.extend({
		adding_new_tab:false,
		events:{
			'click .add_tab':'addTab',
			'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone':'clone'
		},
		render:function () {
			window.VcTestimonialSliderView.__super__.render.call(this);
			this.$content.sortable({
				axis:"y",
				handle:"h3, .vc_element-move",
				stop:function (event, ui) {
					// IE doesn't register the blur when sorting
					// so trigger focusout handlers to remove .ui-state-focus
					ui.item.prev().triggerHandler("focusout");
					$(this).find('> .wpb_sortable').each(function () {
						var shortcode = $(this).data('model');
						shortcode.save({'order':$(this).index()}); // Optimize
					});
				}
			});
			return this;
		},
		changeShortcodeParams:function (model) {
			window.VcTestimonialSliderView.__super__.changeShortcodeParams.call(this, model);
			var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
			if (this.$content.hasClass('ui-accordion')) {
				this.$content.accordion("option", "collapsible", collapsible);
			}
		},
		changedContent:function (view) {
			if (this.$content.hasClass('ui-accordion')) this.$content.accordion('destroy');
			var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
			this.$content.accordion({
				header:"h3",
				navigation:false,
				autoHeight:true,
				heightStyle: "content",
				collapsible:collapsible,
				active:this.adding_new_tab === false && view.model.get('cloned') !== true ? 0 : view.$el.index()
			});
			this.adding_new_tab = false;
		},
		addTab:function (e) {
			this.adding_new_tab = true;
			e.preventDefault();
			vc.shortcodes.create({shortcode:'vc_testimonial_slide', params:{title:window.i18nLocale.section}, parent_id:this.model.id});
		},
		_loadDefaults:function () {
			window.VcTestimonialSliderView.__super__._loadDefaults.call(this);
		}
	});

	window.VcTestimonialSlideView = vc.shortcode_view.extend({
		changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcTestimonialSlideView.__super__.changeShortcodeParams.call(this, model);
			if (!_.isString(params.name)) {
				//this.$el.find('h3.author_name').text('Testimonial');
			}
		}
	});

	window.VcTeamView = vc.shortcode_view.extend({
		changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcTeamView.__super__.changeShortcodeParams.call(this, model);
		}
	});

	window.VcTeamTableView = vc.shortcode_view.extend( {
		new_tab_adding: !1,
		events: {
			"click .add_tab": "addTab",
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone"
		},
		initialize: function(params) {
			window.VcTeamTableView.__super__.initialize.call(this, params), _.bindAll(this, "stopSorting")
		},
		render: function() {
			return window.VcTeamTableView.__super__.render.call(this), this.$tabs = this.$el.find(".wpb_tabs_holder"), this.createAddTabButton(), this
		},
		ready: function(e) {
			window.VcTeamTableView.__super__.ready.call(this, e)

		},
		createAddTabButton: function() {
			var new_tab_button_id = Date.now() + "-" + Math.floor(11 * Math.random());
			this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>'), this.$add_button = $('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"><i class="vc-composer-icon vc-c-icon-add"></i></a></li>').appendTo(this.$tabs.find(".tabs_controls")), vc_user_access().shortcodeAll("vc_team_table_member") || this.$add_button.hide()
		},
		addTab: function(e) {
			if (e.preventDefault(), !vc_user_access().shortcodeAll("vc_team_table_member")) return !1;
			this.new_tab_adding = !0;
			var tab_title = 'James Baker',
				tabs_count = this.$tabs.find("[data-element_type=vc_team_table_member]").length,
				slide_id = Date.now() + "-" + tabs_count + "-" + Math.floor(11 * Math.random());
			return vc.shortcodes.create({
				shortcode: "vc_team_table_member",
				params: {
					title: tab_title,
					slide_id: slide_id
				},
				parent_id: this.model.id
			}), !1
		},
		stopSorting: function(event, ui) {
			var shortcode;
			this.$tabs.find("ul.tabs_controls li:not(.add_tab_block)").each(function(index) {
				$(this).find("a").attr("href").replace("#", "");
				shortcode = vc.shortcodes.get($("[id=" + $(this).attr("aria-controls") + "]").data("model-id")), vc.storage.lock(), shortcode.save({
					order: $(this).index()
				})
			}), shortcode && shortcode.save()
		},
		changedContent: function(view) {
			var params = view.model.get("params");
			if (this.$tabs.hasClass("ui-tabs") || (this.$tabs.tabs({
					select: function(event, ui) {
						return !$(ui.tab).hasClass("add_tab")
					}
				}), this.$tabs.find(".ui-tabs-nav").prependTo(this.$tabs), vc_user_access().shortcodeAll("vc_team_table_member") && this.$tabs.find(".ui-tabs-nav").sortable({
					axis: "vc_custom_tour" === this.$tabs.closest("[data-element_type]").data("element_type") ? "y" : "x",
					update: this.stopSorting,
					items: "> li:not(.add_tab_block)"
				})), !0 === view.model.get("cloned")) {
				var $tab_controls = (view.model.get("cloned_from"), $(".tabs_controls > .add_tab_block", this.$content)),
					$new_tab = $("<li><a href='#tab-" + params.slide_id + "'>" + params.title + "</a></li>").insertBefore($tab_controls);
				this.$tabs.tabs("refresh"), this.$tabs.tabs("option", "active", $new_tab.index())
			} else $("<li><a href='#tab-" + params.slide_id + "'>" + params.title + "</a></li>").insertBefore(this.$add_button), this.$tabs.tabs("refresh"), this.$tabs.tabs("option", "active", this.new_tab_adding ? $(".ui-tabs-nav li", this.$content).length - 2 : 0);
			this.new_tab_adding = !1
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_team_table_member" === tag && _.extend(params, {
				slide_id: Date.now() + "-" + this.$tabs.find("[data-element-type=vc_team_table_member]").length + "-" + Math.floor(11 * Math.random())
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				id: vc_guid(),
				parent_id: parent_id,
				order: new_order,
				cloned: "vc_team_table_member" !== tag,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	} );

	window.VcTeamTableMemberView = window.VcColumnView.extend( {
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone",
			"click > .wpb_element_wrapper > .vc_empty-container": "addToEmpty"
		},
		render: function() {
			var params = this.model.get("params");
			return window.VcTeamTableMemberView.__super__.render.call(this), params.slide_id || (params.slide_id = Date.now() + "-" + Math.floor(11 * Math.random()), this.model.save("params", params)), this.id = "tab-" + params.slide_id, this.$el.attr("id", this.id), this
		},
		ready: function(e) {
			window.VcTeamTableMemberView.__super__.ready.call(this, e), this.$tabs = this.$el.closest(".wpb_tabs_holder");
			this.model.get("params");
			return this
		},
		changeShortcodeParams: function(model) {
			var params;
			window.VcTeamTableMemberView.__super__.changeShortcodeParams.call(this, model), params = model.get("params"), _.isObject(params) && _.isString(params.title) && _.isString(params.slide_id) && $('.ui-tabs-nav [href="#tab-' + params.slide_id + '"]').text(params.title);
		},
		deleteShortcode: function(e) {
			_.isObject(e) && e.preventDefault();
			var answer = confirm(window.i18nLocale.press_ok_to_delete_section),
				parent_id = this.model.get("parent_id");
			if (!0 !== answer) return !1;
			if (this.model.destroy(), !vc.shortcodes.where({
					parent_id: parent_id
				}).length) {
				var parent = vc.shortcodes.get(parent_id);
				return parent.destroy(), !1
			}
			var params = this.model.get("params"),
				current_tab_index = $('[href="#tab-' + params.slide_id + '"]', this.$tabs).parent().index();
			$('[href="#tab-' + params.slide_id + '"]').parent().remove();
			var tab_length = this.$tabs.find(".ui-tabs-nav li:not(.add_tab_block)").length;
			0 < tab_length && this.$tabs.tabs("refresh"), current_tab_index < tab_length ? this.$tabs.tabs("option", "active", current_tab_index) : 0 < tab_length && this.$tabs.tabs("option", "active", tab_length - 1)
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_team_table_member" === tag && _.extend(params, {
				slide_id: Date.now() + "-" + this.$tabs.find("[data-element_type=vc_team_table_member]").length + "-" + Math.floor(11 * Math.random())
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: !0,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function(shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	} );

	window.VcPricingView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		},
		changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcPricingView.__super__.changeShortcodeParams.call(this, model);
			if (_.isObject(params)) {
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'h4.title' ) );
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'span.wpb_vc_param_value' ) );
			}
		}
	});

	window.VcPricingFeatureView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		}
	});

    window.VcButtonView = vc.shortcode_view.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		}
    });
	
	window.VcTooltipView = window.VcColumnView.extend({
        events:{
          'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
          'click > .vc_controls .vc_control-btn-prepend':'addElement',
          'click > .vc_controls .vc_control-btn-edit':'editElement',
          'click > .vc_controls .vc_control-btn-clone':'clone',
          'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
        }
    });

	window.VcModalView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		}
	});

	window.VcStepsView = VcBackendTtaViewInterface.extend({
		sortableSelector: "> .vc_tta-panel:not(.vc_tta-section-append)",
		sortableSelectorCancel: ".vc-non-draggable",
		sortableUpdateModelIdSelector: "data-model-id",
		defaultSectionTitle: 'Step',
		render: function() {
			return window.VcStepsView.__super__.render.call(this), this.$navigation = this.$content, this.$sortable = this.$content, vc_user_access().shortcodeAll("vc_tta_section") || this.$content.find(".vc_tta-section-append").hide(), this
		},
		removeSection: function(model) {
			var $viewTab, $nextTab, tabIsActive;
			$viewTab = this.findSection(model.get("id")), tabIsActive = $viewTab.hasClass(this.activeClass), tabIsActive && ($nextTab = this.getNextTab($viewTab), $nextTab.addClass(this.activeClass))
		},
		addShortcode: function(view) {
			var beforeShortcode;
			beforeShortcode = _.last(vc.shortcodes.filter(function(shortcode) {
				return shortcode.get("parent_id") === this.get("parent_id") && parseFloat(shortcode.get("order")) < parseFloat(this.get("order"))
			}, view.model)), beforeShortcode ? view.render().$el.insertAfter("[data-model-id=" + beforeShortcode.id + "]") : this.$content.prepend(view.render().el)
		},
		addSection: function(prepend) {
			var newTabTitle, params, shortcode;
			var tabs_count = this.$el.find( '[data-element_type=vc_steps_item]' ).length + 1;
			return newTabTitle = this.defaultSectionTitle, params = {
				shortcode: "vc_steps_item",
				params: {
					title: newTabTitle + ' ' + tabs_count
				},
				parent_id: this.model.get("id"),
				order: vc.shortcodes.getNextOrder(),
				prepend: prepend
			}, shortcode = vc.shortcodes.create(params)
		}
	});

	window.VcStepsItemView = window.VcColumnView.extend({
		parentObj: null,
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone"
		},
		setContent: function() {
			this.$content = this.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_container_for_children")
		},
		render: function() {
			var parentObj;
			return window.VcStepsItemView.__super__.render.call(this), parentObj = vc.shortcodes.get(this.model.get("parent_id")), _.isObject(parentObj) && !_.isUndefined(parentObj.view) && (this.parentObj = parentObj), this.$el.addClass("vc_tta-panel"), this.$el.attr("style", ""), this.$el.attr("data-vc-toggle", "tab"), this.replaceTemplateVars(), this
		},
		replaceTemplateVars: function() {
			var title, $panelHeading;
			title = this.model.getParam("title"), _.isEmpty(title) && (title = this.parentObj && this.parentObj.defaultSectionTitle && this.parentObj.defaultSectionTitle.length ? this.parentObj.defaultSectionTitle : window.i18nLocale.section), $panelHeading = this.$el.find(".vc_tta-panel-heading");
			var template = vc.template($panelHeading.html(), vc.templateOptions.custom);
			$panelHeading.html(template({
				model_id: this.model.get("id"),
				section_title: title
			}))
		},
		getIndex: function() {
			return this.$el.index()
		},
		ready: function() {
			this.updateParentNavigation(), window.VcStepsItemView.__super__.ready.call(this), this.$tabs = this.$el.closest('[data-element_type=vc_steps_horizontal]')
		},
		updateParentNavigation: function() {
			_.isObject(this.parentObj) && this.parentObj.view && this.parentObj.view.notifySectionRendered && this.parentObj.view.notifySectionRendered(this.model)
		},
		deleteShortcode: function(e) {
			var answer;
			return _.isObject(e) && e.preventDefault(), answer = confirm(window.i18nLocale.press_ok_to_delete_section), !0 !== answer ? !1 : (1 === vc.shortcodes.where({
				parent_id: this.model.get("parent_id")
			}).length ? (this.model.destroy(), this.parentObj && this.parentObj.destroy()) : (this.parentObj && this.parentObj.view && this.parentObj.view.removeSection && this.parentObj.view.removeSection(this.model), this.model.destroy()), !0)
		},
		changeShortcodeParams: function(model) {
			window.VcStepsItemView.__super__.changeShortcodeParams.call(this, model), _.isObject(this.parentObj) && this.parentObj.view && this.parentObj.view.notifySectionChanged && this.parentObj.view.notifySectionChanged(model)
		},
		cloneModel: function(model, parent_id, save_order) {
			var new_order, model_clone, params, tag;
			var tabs_count = this.$tabs.find("[data-element_type=vc_steps_item]").length,
				tab_title = 'Step ' + (tabs_count + 1);
			return new_order = _.isBoolean(save_order) && !0 === save_order ? model.get("order") : parseFloat(model.get("order")) + vc.clone_index, params = _.extend({}, model.get("params")), tag = model.get("shortcode"), "vc_steps_item" === tag && _.extend(params, {
				tab_id: Date.now() + "-" + this.$tabs.find("[data-element_type=vc_steps_item]").length + "-" + Math.floor(11 * Math.random()),
				title: tab_title
			}), model_clone = Shortcodes.create({
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: !0,
				cloned_from: model.toJSON(),
				params: params
			}), _.each(Shortcodes.where({
				parent_id: model.id
			}), function (shortcode) {
				this.cloneModel(shortcode, model_clone.get("id"), !0)
			}, this), model_clone
		}
	});

})(window.jQuery);