
(function() {
	"use strict";

	jQuery(document).ready(function($) {

		var $custom_font_field = $('#wtbx_scape-custom_icon_font');
		$custom_font_field.find( '.media_upload_button' ).unbind().on(
			'click', function( event ) {
				wtbx_addIconFont( event, $( this ).parents( 'fieldset.redux-field:first' ) );
			}
		);

		$(document).on('click', '#wtbx_scape-custom_icon_font .notice-dismiss', function() {
			$(this).closest('.notice').fadeOut(300,function() {
				$(this).remove();
			});
		});


		$(document).on('click', '#wtbx_scape-custom_icon_font .wtbx-font-preview-remove', function() {
			var $this			= $(this),
				font			= $this.data('remove'),
				confirm_text	= $this.data('confirmation');

			if ( confirm(confirm_text) === true ) {
				$.ajax({
					type: "POST",
					url: wtbx_icon_font_ajax.ajaxurl,
					data: {
						'action':	'remove_icon_font',
						'font':		font
					},
					success: function(response) {
						if ( response ) {
							$custom_font_field.find('.wtbx-font-preview[data-font="'+font+'"]').remove();

							var fonts = $custom_font_field.find('.custom_icon_font_folder').val();
							if ( fonts !== "" ) {
								fonts = JSON.parse(fonts);
							} else {
								fonts = [];
							}
							var index = fonts.indexOf(font);
							if (index > -1) {
								fonts.splice(index, 1);
							}
							$custom_font_field.find('.custom_icon_font_folder').val(JSON.stringify(fonts));
							$("#redux_save").trigger("click");

							//redux_change( $custom_font_field.find( '.custom_icon_font_folder' ) );
							//console.log(response);
						}
					},
					error: function(response) {
						//console.log(response);
					}
				});
			}

		});

		// Add a file via the wp.media function
		var wtbx_addIconFont = function( event, selector ) {
			event.preventDefault();

			var jQueryel = $( this );

			// var clicked = $(this), options = clicked.data();
			// options.input_target = $('#'+options.target);

			// Create the media frame.
			var frame = wp.media(
				{
					multiple: false,
					library: { type: 'application/octet-stream, application/zip' },
					button:  { text: $custom_font_field.find( '.media_upload_button').data('select') }
				});

			frame.on(
				'select', function() {

					var attachment = frame.state().get( 'selection' ).first();
					frame.close();
					var data = $( selector ).find('.data').data();

					$.ajax({
						type: "POST",
						url: wtbx_icon_font_ajax.ajaxurl,
						data: {
							'action':	'unzip_icon_font',
							'id':		attachment.attributes.id,
							'filename':	attachment.attributes.filename
						},
						success: function(response) {
							if ( response ) {
								$('.wtbx-font-preview-container').append(response);
							}
						},
						error: function(response) {

						}
					});
				}
			);

			frame.open();
		};
	});

})(jQuery);