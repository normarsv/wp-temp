/*global jQuery, document, redux_change, redux*/

(function( $ ) {
	"use strict";

	redux.field_objects = redux.field_objects || {};
	redux.field_objects.wtbx_sidebars = redux.field_objects.wtbx_sidebars || {};

	var scroll = '';

	redux.field_objects.wtbx_sidebars.init = function( selector ) {

		if ( !selector ) {
			selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-wtbx_sidebars:visible' );
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
				el.find( ".redux-wtbx_sidebars" ).sortable(
					{
						handle: ".drag",
						placeholder: "placeholder",
						opacity: 0.7,
						scroll: false,
						out: function( event, ui ) {
							if ( !ui.helper ) return;
							if ( ui.offset.top > 0 ) {
								scroll = 'down';
							} else {
								scroll = 'up';
							}
							redux.field_objects.wtbx_sidebars.scrolling( $( this ).parents( '.redux-field-container:first' ) );
						},

						over: function( event, ui ) {
							scroll = '';
						},

						deactivate: function( event, ui ) {
							scroll = '';
						},

						update: function() {
							redux_change( $( this ) );
						}
					}
				);

				el.find( '.wtbx_sidebars-add' ).on('click', function() {

						function IDGenerator() {
							this.length = 16;
							this.timestamp = +new Date;

							var _getRandomInt = function( min, max ) {
								return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
							}

							this.generate = function() {
								var ts = this.timestamp.toString();
								var parts = ts.split( "" ).reverse();
								var id = "";

								for( var i = 0; i < this.length; ++i ) {
									var index = _getRandomInt( 0, parts.length - 1 );
									id += parts[index];
								}

								return id;
							}
						}

						var generator	= new IDGenerator();
						//var uniqueID	= generator.generate();

						//var new_number = parseInt( $( this ).attr( 'data-add_number' ) );
						var new_number = generator.generate();
						var id = $( this ).attr( 'data-id' );
						var el_id = $( this ).attr( 'data-el-id' );
						var name = $( this ).attr( 'data-name' );

						//var new_number = el.find('li').filter(':not(.wtbx-text-sortable-copy)').length + 1;
						var new_input = el.find('.wtbx-text-sortable-copy').clone();
						new_input.find('input').attr('id', new_input.find('input').attr('id') + '[' + new_number + ']');
						new_input.find('input').attr('name', new_input.find('input').attr('name') + '[' + new_number + ']');
						new_input.removeClass('wtbx-text-sortable-copy');
						new_input.appendTo(el.find('ul'));
						$( this ).attr( 'data-add_number', new_number + 1 );
						redux_change( $( this ) );
					}
				);

				$(document).unbind().on('click', '.wtbx-text-sortable-item-remove', function() {
						var confirmation = $(this).data('confirmation');
						if ( confirm(confirmation) === true ) {
							$(this).closest('.wtbx-text-sortable-item').remove();
							redux_change(el);
						}
					}
				);
			}
		);
	};

	redux.field_objects.wtbx_sidebars.scrolling = function( selector ) {
		if (selector === undefined) {
			return;
		}

		var $scrollable = selector.find( ".redux-wtbx_sidebars" );

		if ( scroll == 'up' ) {
			$scrollable.scrollTop( $scrollable.scrollTop() - 20 );
			setTimeout( redux.field_objects.wtbx_sidebars.scrolling, 50 );
		} else if ( scroll == 'down' ) {
			$scrollable.scrollTop( $scrollable.scrollTop() + 20 );
			setTimeout( redux.field_objects.wtbx_sidebars.scrolling, 50 );
		}
	};

})( jQuery );