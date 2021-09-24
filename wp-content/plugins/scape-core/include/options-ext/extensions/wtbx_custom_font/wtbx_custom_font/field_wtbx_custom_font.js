jQuery(document).ready(function($) {

	$('#wtbx_scape-custom_fonts').each(function() {

		var $fonts_field	= $(this);
		var $google_key		= $fonts_field.find('#wtbx_googlefonts_key');
		var $input			= $fonts_field.find('input[name="wtbx_scape[custom_fonts][fonts]"]');
		var $fontpool		= $fonts_field.find('#wtbx_fontpool');

		var wtbx_font_to_upload = {
			'name': '',
			'ttf': '',
			'eot': '',
			'woff': '',
			'woff2': '',
			'svg': ''
		};

		$fonts_field.closest('td').prev('th').css({'width': '0', 'padding': '0'});

		function wtbx_getCustomFontValue() {
			var value		= $input.val(),
				font_value	= {},
				font		= {};

			if ( value === '' || 'undefined' === typeof value ) {
				font_value = {
					googleapikey: '',
					fonts: {},
					typekit_apikey: '',
					typekit_kitid: ''
				}
			} else {
				font_value = JSON.parse(value);
			}

			if ( 'undefined' === typeof font_value['fonts'] || $.isEmptyObject(font_value['fonts']) ) {
				font['fonts'] = {};
			} else {
				font['fonts'] = font_value['fonts'];
			}

			if ( 'undefined' === typeof font_value['googleapikey'] || $.isEmptyObject(font_value['googleapikey']) ) {
				font['googleapikey'] = '';
			} else {
				font['googleapikey'] = font_value['googleapikey'];
			}

			if ( 'undefined' === typeof font_value['typekit_apikey'] || $.isEmptyObject(font_value['typekit_apikey']) ) {
				font['typekit_apikey'] = '';
			} else {
				font['typekit_apikey'] = font_value['typekit_apikey'];
			}

			if ( 'undefined' === typeof font_value['typekit_kitid'] || $.isEmptyObject(font_value['typekit_kitid']) ) {
				font['typekit_kitid'] = '';
			} else {
				font['typekit_kitid'] = font_value['typekit_kitid'];
			}

			return font;
		}

		function wtbx_initCustomFonts() {
			var value = wtbx_getCustomFontValue();

			if ( 'undefined' !== typeof value['fonts'] && value['fonts'] !== '' ) {
				$.each( value['fonts'], function( key, value ) {
					var type = value['type'];
					var family = value['name'];
					$fonts_field.find('.wtbx_font_container[data-type="'+type+'"]').find('.wtbx_font_row[data-family="'+family+'"]').addClass('added');
				});
			}
		}

		function wtbx_addLoading() {
			$fonts_field.find('.wtbx_font_pool_wrapper').addClass('loading');
		}

		function wtbx_removeLoading() {
			$fonts_field.find('.wtbx_font_pool_wrapper').removeClass('loading');
		}

		function wtbx_newCustomFont( type, att_id, att_filename, url ) {
			wtbx_font_to_upload[type] = att_filename;
		}

		function wtbx_checkIfNoFontsAdded($value) {
			if ( $.isEmptyObject($value['fonts']) ) {
				$fontpool.find('.wtbx_font_row_empty').removeClass('wtbx_font_row_hidden');
			} else {
				$fontpool.find('.wtbx_font_row_empty').addClass('wtbx_font_row_hidden');
			}
		}

		wtbx_initCustomFonts();

		function wtbx_uploadCustomFontFormat( event, selector, mime, type, select ) {
			event.preventDefault();

			var jQueryel = $( this );

			var clicked = $(this), options = clicked.data();
			options.input_target = $('#'+options.target);
			// Create the media frame.
			var frame = wp.media(
				{
					multiple: false,
					library: { type: mime },
					button:  { text: select }
				});

			frame.on(
				'select', function() {

					var attachment = frame.state().get( 'selection' ).first();
					frame.close();
					wtbx_addLoading();

					$.ajax({
						type: "POST",
						url: wtbx_custom_font_ajax.ajaxurl,
						data: {
							'action':	'custom_font_add_type',
							'id':		attachment.attributes.id,
							'filename':	attachment.attributes.filename
						},
						success: function(response) {
							if ( response ) {
								$fonts_field.find('.media_upload_button[data-type="'+type+'"]').addClass('button-primary').attr('disabled', 'disabled');
								$fonts_field.find('.media_upload_button[data-type="'+type+'"]').prev().addClass('added');
								if ( $('.wtbx_custom_font_family').val() !== '' ) {
									$('#wtbx_make_custom_font').removeAttr('disabled');
								}
								wtbx_newCustomFont(type, attachment.attributes.id, attachment.attributes.filename, response);
								wtbx_removeLoading();
							}
						}
					});
				}
			);

			frame.open();
		}


		$fonts_field.find( '.media_upload_button' ).unbind().on(
			'click', function( event ) {
				if ( 'disabled' !== $(this).attr('disabled') ) {
					wtbx_uploadCustomFontFormat( event, $( this ).parents( 'fieldset.redux-field:first' ), $(this).data('mime'), $(this).data('type'), $(this).data('select') ) ;
				}
			}
		);

		$(document).on('click', '#wtbx_make_custom_font', function()  {
				if ( 'disabled' !== $(this).attr('disabled') ) {
					wtbx_font_to_upload['name'] = $fonts_field.find('.wtbx_custom_font_family').val();
					wtbx_addLoading();

					$.ajax({
						type: "POST",
						url: wtbx_custom_font_ajax.ajaxurl,
						data: {
							'action':	'custom_font_create',
							'info':		wtbx_font_to_upload
						},
						success: function(response) {
							if ( response ) {
								response = JSON.parse(response);
								wtbx_removeLoading();
								$fonts_field.find('.wtbx_font_file_uploaded.added').removeClass('added');
								$fonts_field.find('.media_upload_button').removeClass('button-primary').removeAttr('disabled');
								$fonts_field.find('.wtbx_custom_font_family').val('');

								if ( response['error'] === '' ) {
									$(response['html']).appendTo($fontpool);
									var font_info = response['object'];
									var $value = wtbx_getCustomFontValue();
									$value['fonts'][font_info['id']] = font_info;
									$input.val(JSON.stringify($value));
									$(window).scroll();
								} else {
									console.log(response['error']);
								}

								$('#redux_save').trigger('click');

							}
						}
					});
				}
			}
		);

		$(document).on('change input', '.wtbx_custom_font_family', function() {
			if ( $(this).val() !== '' && $fonts_field.find('.wtbx_upload_buttons').find('.wtbx_font_file_uploaded.added').length  ) {
				$( '#wtbx_make_custom_font').removeAttr('disabled');
			} else {
				$( '#wtbx_make_custom_font').attr('disabled', 'disabled');
			}
		});



		$(document).on('click', '.wtbx_font_container_header', function() {
			var $font_cont = $(this).closest('.wtbx_font_container');
			$font_cont.toggleClass('active');
		});


		$(document).on('change input', '#wtbx_googlefonts_key', function() {
			var $value = wtbx_getCustomFontValue();
			$value['googleapikey'] = $google_key.val();
			$input.val(JSON.stringify($value));
			redux_change($google_key);
		});

		$(document).on('click', '.wtbx_fonts_nav_item', function() {
			if ( !$(this).hasClass('active') ) {
				$(this).closest('.wtbx_font_wrapper').find('.wtbx_fonts_tab').removeClass('active');
				$(this).closest('.wtbx_font_wrapper').find('.wtbx_fonts_tab[data-group="'+$(this).data('tab')+'"]').addClass('active');
				$(this).parent().children('.active').removeClass('active');
				$(this).addClass('active');
			}
		});

		$(document).on('click', '.wtbx_add_to_pool', function() {
			var $this	= $(this),
				$font	= $this.closest('.wtbx_font_row'),
				newFont	= {},
				family	= newFont['family'];

			newFont	= $this.data('font');

			if ( !$font.hasClass('added') ) {
				wtbx_addLoading();

				if ( newFont['type'] === 'google' ) {
					$.ajax({
						type: "POST",
						url: wtbx_custom_font_ajax.ajaxurl,
						data: {
							'action':	'unique_font_id'
						},
						success: function(response) {
							if ( response ) {
								var $value = wtbx_getCustomFontValue();
								response = response.toString().replace(/\n/g, '');

								newFont.id = response;
								$value.fonts[response] = newFont;

								$this.attr('data-font', JSON.stringify(newFont));
								var $poolRow = $font.clone();
								$poolRow.find('.wtbx_font_family').after('<div class="wtbx_font_cell wtbx_font_source wtbx_font_google"><span>Google</span></div>');
								$poolRow.appendTo($fontpool);
								$fontpool.find('.wtbx_add_to_pool').removeClass('wtbx_add_to_pool').addClass('wtbx_remove_from_pool');
								$font.addClass('added');

								$input.val(JSON.stringify($value));
								wtbx_checkIfNoFontsAdded($value);
								//redux_change($input);
								wtbx_removeLoading();
								$('#redux_save').trigger('click');
							}
						}
					});
				} else if( newFont['type'] === 'fontsquirrel' ) {
					var urlname = newFont['url'];
					$.ajax({
						type: "POST",
						url: wtbx_custom_font_ajax.ajaxurl,
						data: {
							'action':	'add_fontsquirrel_font',
							'urlname':	urlname,
							'name':	newFont['name']
						},
						success: function(response) {
							if ( response ) {
								response = JSON.parse(response);
								$(response['html']).appendTo($fontpool);
								var $value = wtbx_getCustomFontValue();
								var newFonts = response['object'];

								$.each( newFonts, function( key, value ) {
									$value['fonts'][key] = value;
									var type = value['type'];
									$fonts_field.find('.wtbx_font_container[data-type="'+type+'"]').find('.wtbx_font_row[data-family="'+family+'"]').addClass('added');
								});
								$input.val(JSON.stringify($value));
								wtbx_checkIfNoFontsAdded($value);
								//redux_change($input);
								wtbx_removeLoading();
								$('#redux_save').trigger('click');
							}
						}
					});
				}

				$(window).scroll();

			}
		});

		$(document).on('click', '.wtbx_remove_from_pool', function() {
			var $font = $(this).closest('.wtbx_font_row'),
				confirm_text	= $fontpool.data('confirmation');

			if ( confirm(confirm_text) === true ) {
				var value		= wtbx_getCustomFontValue();
				var fontName	= $(this).data('font');
				var type		= fontName['type'];
				var id			= fontName['id'];
				var folder		= fontName['name'];
				wtbx_addLoading();

				if ( 'google' === type ) {
					$font.remove();
					setTimeout(function() {
						delete value['fonts'][id];
						if ( undefined !== value['fonts'].length && !value['fonts'].length ) {
							value['fonts'] = {};
						}
						$input.val(JSON.stringify(value));
						$fonts_field.find('.wtbx_font_container[data-type="'+type+'"]').find('.wtbx_font_row[data-family="'+fontName['name']+'"]').removeClass('added');
						wtbx_checkIfNoFontsAdded(value);
						//redux_change($input);
						wtbx_removeLoading();
						$('#redux_save').trigger('click');
					});

				} else if ( 'fontsquirrel' === type ) {

					var urlname = fontName['name'];
					var countFonts = 0;

					$fontpool.find('.wtbx_remove_from_pool').each(function() {
						var data = $(this).data('font');
						if ( data['name'] === urlname ) {
							countFonts++;
						}
					});

					if ( countFonts <= 1 ) {

						$.ajax({
							type: "POST",
							url: wtbx_custom_font_ajax.ajaxurl,
							data: {
								'action':	'remove_theme_font',
								'folder':	folder
							},
							success: function(response) {
								if ( response && response === 'removed' ) {
									$font.remove();
									setTimeout(function() {
										delete value['fonts'][id];
										if (undefined !== value['fonts'].length && !value['fonts'].length) {
											value['fonts'] = {};
										}
										$input.val(JSON.stringify(value));
										wtbx_checkIfNoFontsAdded(value);
										$fonts_field.find('.wtbx_font_container[data-type="' + type + '"]').find('.wtbx_font_row[data-family="' + urlname + '"]').removeClass('added');
										wtbx_removeLoading();
										$('#redux_save').trigger('click');
									});
								}
							}
						});

					} else {
						$font.remove();
						setTimeout(function() {
							delete value['fonts'][id];
							if (undefined !== value['fonts'].length && !value['fonts'].length) {
								value['fonts'] = {};
							}
							$input.val(JSON.stringify(value));
							wtbx_checkIfNoFontsAdded(value);
							//redux_change($input);
							wtbx_removeLoading();
							$('#redux_save').trigger('click');
						});
					}

				} else if ( 'custom' === type ) {

					$.ajax({
						type: "POST",
						url: wtbx_custom_font_ajax.ajaxurl,
						data: {
							'action':	'remove_theme_font',
							'folder':	folder
						},
						success: function(response) {
							if ( response && response === 'removed' ) {
								$font.remove();
								setTimeout(function() {
									delete value['fonts'][id];
									if (undefined !== value['fonts'].length && !value['fonts'].length) {
										value['fonts'] = {};
									}
									$input.val(JSON.stringify(value));
									$fonts_field.find('.wtbx_font_container[data-type="' + type + '"]').find('.wtbx_font_row[data-family="' + urlname + '"]').removeClass('added');
									wtbx_checkIfNoFontsAdded(value);
									wtbx_removeLoading();
									$('#redux_save').trigger('click');
								});
							}
						}
					});

				}
			}
		});

		$(document).on('click', '#wtbx_typekit_save', function() {
			var $value	= wtbx_getCustomFontValue(),
				apikey	= $('#wtbx_typekit_apikey').val(),
				kitid	= $('#wtbx_typekit_kitid').val();

			$value['typekit_apikey'] = apikey;
			$value['typekit_kitid'] = kitid;
			$input.val(JSON.stringify($value));

			wtbx_addLoading();

			$.ajax({
				type: "POST",
				url: wtbx_custom_font_ajax.ajaxurl,
				data: {
					'action':	'typekit_sync',
					'apikey':	apikey,
					'kitid':	kitid
				},
				success: function(response) {
					if ( response ) {
						response = JSON.parse(response);

						if ( response.status === 'success' ) {
							var newFonts = response['object'];

							if ( !$.isEmptyObject($value['fonts']) ) {
								$.each( $value['fonts'], function( key, value ) {
									if ( value['type'] === 'typekit' ) {
										delete $value['fonts'][key];
									}
								});
							}

							$fontpool.find('.wtbx_font_row[data-type="typekit"]').remove();

							if ( !$.isEmptyObject(newFonts) ) {
								$.each( newFonts, function( key, value ) {
									value.family = value.family.replace(/ /g, '-').toLowerCase();
									$value['fonts'][key] = value;
								});

								$input.val(JSON.stringify($value));
								$(response['html']).appendTo($fontpool);
								wtbx_removeLoading();
								$('#redux_save').trigger('click');
							}
						} else {
							console.warn(response.message);
							wtbx_removeLoading();
						}

					}
				},
				error: function(response) {
					if ( response ) {
						console.warn(response.message);
						wtbx_removeLoading();
					}
				}
			});
		});

		$(document).on('click', '#wtbx_typekit_reset', function() {
			var $value	= wtbx_getCustomFontValue(),
				confirm_text	= $(this).data('confirmation');

			if ( confirm(confirm_text) === true ) {
				delete $value['typekit_apikey'];
				delete $value['typekit_kitid'];
				$input.val(JSON.stringify($value));
				$('#redux_save').trigger('click');
			}
		});

	});

});
