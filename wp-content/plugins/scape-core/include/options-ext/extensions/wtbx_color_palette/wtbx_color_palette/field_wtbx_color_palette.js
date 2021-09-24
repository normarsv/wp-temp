jQuery(document).ready(function($) {

	var $selector = $('.redux-container-wtbx_color_palette');

	$( $selector ).each(
		function() {

			var el = $( this );
			var parent = el;

			var wtbx_rgba_hexToRGBA = function( hex, alpha ) {
				var result;

				if (hex === null) {
					result = '';
				} else {
					hex = hex.replace('#', '');
					var r = parseInt(hex.substring(0, 2), 16);
					var g = parseInt(hex.substring(2, 4), 16);
					var b = parseInt(hex.substring(4, 6), 16);

					result = 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
				}

				return result;
			};

			// Initialize colour picker
			var wtbx_rgba_initColorPicker = function(el){

				// Get the color scheme container
				var colorpickerInput	= el;
				var outputTransparent   = el.data('output-transparent');
				outputTransparent       = Boolean((outputTransparent === '') ? false : outputTransparent);

				var currentColor = colorpickerInput.data('color') !== '' ? colorpickerInput.data('color') : '#ffffff';

				// Color picker options
				colorpickerInput.wtbx_spectrum({
					color:                  currentColor, //'#ffffff',
					showAlpha:              true,
					showInput:              true,
					allowEmpty:             true,
					showInitial:            true,
					showPalette:            false,
					showSelectionPalette:   false,
					showPaletteOnly:        false,
					clickoutFiresChange:    false,
					showButtons:            true,
					preferredFormat:        'hex6',
					inputText:              'Select Color',

					change: function(color) {
						var colorVal, alphaVal, rgbaVal;

						if (color === null) {
							if (outputTransparent === true) {
								colorVal = 'transparent';
							} else {
								colorVal = null;
							}
							alphaVal = null;
						} else {
							colorVal = color.toHexString();
							alphaVal = color.alpha;
						}

						if (colorVal != 'transparent') {
							rgbaVal     = wtbx_rgba_hexToRGBA(colorVal, alphaVal);
						} else {
							rgbaVal     = 'transparent';
						}

						$(this).val(rgbaVal);
					}
				});
			};

			wtbx_rgba_initColorPicker(el.find('.wtbx-colorpicker-init'));

			// Add another color to palette
			el.find('.wtbx_color_palette_add').on('click', function() {

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
				var uniqueID	= generator.generate();

				el.find('.wtbx-color-palette-copy')
					.clone()
					.appendTo(el.find('.wtbx-color-palette-container'))
					.removeClass('wtbx-color-palette-copy')
					.attr('data-id', uniqueID)
					.find('.wtbx-colorpicker')
					.addClass('wtbx-colorpicker-init wtbx-colorpicker-temp')
					.attr('name', el.find('.wtbx-colorpicker-temp').attr('name')+'[custom_'+uniqueID+']');

				wtbx_rgba_initColorPicker(el.find('.wtbx-colorpicker-temp'));

				el.find('.wtbx-colorpicker-temp').closest('.wtbx-color-palette-wrapper').find('.wtbx-color-name').text(el.find('.wtbx-colorpicker-temp').closest('.wtbx-color-palette-wrapper').find('.wtbx-color-name').text() + el.find('.wtbx-color-palette-wrapper:not(.wtbx-color-palette-copy)').length)
					.closest('.wtbx-color-palette-wrapper').find('.wtbx-colorpicker-temp').removeClass('wtbx-colorpicker-temp');

			});

			// Remove color
			$(document).on('click', '.wtbx-color-remove', function() {
				var confirmation = $(this).data('confirmation');
				if ( confirm(confirmation) === true ) {
					$(this).closest('.wtbx-color-palette-wrapper').remove();
					redux_change(el);
				}
			});

			// Sortable
			$(el).find('.wtbx-color-palette-container').sortable({
				placeholder: 'wtbx-color-palette-placeholder',
				handle: '.wtbx-handle',
				stop: function(event, ui) {
					el.find('.wtbx-color-palette-wrapper:not(.wtbx-color-palette-copy)').each(function() {
						$(this).find('.wtbx-color-name').text(el.find('.wtbx-color-palette-copy').find('.wtbx-color-name').text() + ($(this).index()+1));
					});
					redux_change(el);
				}
			});
		}
	);

});
