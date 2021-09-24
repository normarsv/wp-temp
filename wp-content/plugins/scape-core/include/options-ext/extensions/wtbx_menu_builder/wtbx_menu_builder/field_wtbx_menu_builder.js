/*global jQuery, document, redux_change, redux*/

(function( $ ) {
	"use strict";



	redux.field_objects = redux.field_objects || {};
	redux.field_objects.wtbx_menu_builder = redux.field_objects.wtbx_menu_builder || {};

	redux.field_objects.wtbx_menu_builder.init = function( selector ) {

		if ( !selector ) {
			selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-wtbx_menu_builder:visible' );
		}

		$( selector ).each(
			function() {
				var el = $( this );
				var parent = el;
				if ( !el.hasClass( 'redux-field-container' ) ) {
					parent = el.parents( '.redux-field-container:first' );
				}
				if ( parent.is( ":hidden" ) ) { // Skip hidden fields
					return;
				}
				if ( parent.hasClass( 'redux-field-init' ) ) {
					parent.removeClass( 'redux-field-init' );
				} else {
					return;
				}

				var $row = selector.closest('tr');
				$row.children('th').css('width', 'auto');
				$row.children('td').css('width', '100%');

				if ( !selector.find('.wtbx_mb_area_main').find('.wtbx_mb_item').length ) {
					selector.find('.wtbx_mb_area_main .wtbx_mb_drop').append('<div class="wtbx_mb_item wtbx_mb_el wtbx_mb_parent_menu wtbx_mb_item_menu" data-item="menu"></div>');
				}

				function saveMenu() {
					var $dropzone	= selector.find('.wtbx_mb_dropzone'),
						$input		= selector.find('.wtbx_mb_value'),
						value		= {};


					$dropzone.find('.wtbx_mb_section').each(function() {
						var $section	= $(this),
							section_id	= $section.data('section');

						$section.find('.wtbx_mb_area').each(function() {
							var $area = $(this),
								area_id	= $area.data('area');

							$area.find('.wtbx_mb_item').each(function(index) {
								var id		= $(this).data('item'),
									label	= $(this).data('label'),
									parent	= $(this).data('parent'),
									nav		= $(this).data('nav') === undefined ? '' : $(this).data('nav');

								if ( $.isEmptyObject(value[section_id]) ) {
									value[section_id] = {};
								}
								if ( $.isEmptyObject(value[section_id][area_id]) ) {
									value[section_id][area_id] = [];
								}

								value[section_id][area_id].push({
									id: id,
									label: label,
									parent: parent,
									nav: nav
								});
							});
						});
					});

					if ( $.isEmptyObject(value.header) ) {
						value.header = {};
					}

					if ( $dropzone.parent().hasClass('wtbx_mb_style_mobile') && $.isEmptyObject(value.top_header) ) {
						value.top_header = { right: [] };
					}

					if ( $dropzone.parent().hasClass('wtbx_mb_style_7') && $.isEmptyObject(value.header.right_idle) ) {
						value.header.right_idle = [];
					}

					$input.val(JSON.stringify(value));
				};

				selector.find('.wtbx_mb_area:not(.wtbx_mb_area_logo):not(.wtbx_mb_area_main):not(.wtbx_mb_area_trigger) .wtbx_mb_drop').each(function() {
					$(this).sortable({
						connectWith: '.wtbx_mb_area:not(.wtbx_mb_area_logo) .wtbx_mb_drop',
						placeholder: 'wtbx_mb_drop_placeholder wtbx_mb_el',
						forcePlaceholderSize: true,
						stack: '.wtbx_mb_item',
						cursor: 'move',
						update: function (e, ui) {
							if ( ($(this).closest('.wtbx_mb_area').hasClass('wtbx_mb_area_logo') && !$(ui.item).is('[data-item^="logo"]')) ||
								( $(this).closest('.wtbx_mb_area').hasClass('wtbx_mb_area_logo') && $(this).children().length > 1 ) ) {
								if ( $(ui.sender).hasClass('wtbx_mb_drop') ) {
									$(ui.sender).sortable('cancel');
								} else {
									$(ui.item).remove();
								}
							}

							if ( $(this).closest('.wtbx_mb_area').data('restrict') !== '' ) {
								var restrict	= $(this).closest('.wtbx_mb_area').data('restrict').split(','),
									item		= $(ui.item).data('item');

								if ( $.inArray( item, restrict ) !== -1 ) {
									if ( $(ui.sender).hasClass('wtbx_mb_drop') ) {
										$(ui.sender).sortable('cancel');
									} else {
										$(ui.item).remove();
									}
								}
							}
							saveMenu();
						},
						activate: function(e, ui) {
							var $this = $(this);

							selector.find('.wtbx_mb_area').each(function() {
								if ( $(this).data('restrict') !== '' && $(this).data('restrict') !== undefined ) {
									var restrict = $(this).data('restrict').split(',');
									if ( $.inArray( $(ui.item).data('item'), restrict ) !== -1 ) {
										$(this).addClass('area_restricted');
									} else {
										$(this).addClass('area_allowed');
									}
								} else {
									$(this).addClass('area_allowed');
								}
							});
						},
						deactivate: function(e, ui) {
							selector.find('.wtbx_mb_area').removeClass('area_restricted area_allowed');
						}

					}).disableSelection();
				});

				selector.find('.wtbx_mb_area:not(.wtbx_mb_area_logo):not(.wtbx_mb_area_main):not(.wtbx_mb_area_trigger) .wtbx_mb_drop').each(function() {
					$(this).droppable({
						accept: '.wtbx_mb_item',
						drop: function (e, ui) {
							var $el = ui.draggable;
							var $cont = $(this);
							setTimeout(function() {
								$el.removeAttr('style');
							});
							saveMenu();
						}
					}).disableSelection();
				});

				selector.find('.wtbx_mb_items .wtbx_mb_item').draggable({
					helper: 'clone',
					connectToSortable: '.wtbx_mb_area:not(.wtbx_mb_area_logo):not(.wtbx_mb_area_main):not(.wtbx_mb_area_trigger) .wtbx_mb_drop',
					cursor: 'move',
				});

				$(document).on('click', '.wtbx_mb_drop .wtbx_mb_item_remove', function() {
					$(this).closest('.wtbx_mb_item').remove();
					saveMenu();
				});

				selector.find('.wtbx_mb_clear').on('click', function() {
					var confirm_text = $(this).data('confirm');
					if ( confirm(confirm_text) ) {
						selector.find('.wtbx_mb_drop').find('.wtbx_mb_item').remove();
						saveMenu();
					}
				});

				saveMenu();

			}
		);
	};

})( jQuery );