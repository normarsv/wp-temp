(function($) {
	"use strict";

	var $colorpicker = $('.wtbx_vc_colorpicker_solid');

	if ( $colorpicker.length  ) {

		$colorpicker.each(function() {

			var param = $(this).data('param');

			//var $colorpicker	= $('.wtbx_vc_colorpicker_solid[data-param="'+param +'"]'),
			var $colorpicker	= $(this),
				$select			= $colorpicker.find('.wtbx_vc_colorpicker_select select'),
				$options		= $colorpicker.find('.wtbx_vc_colorpicker_options'),
				$container		= $colorpicker.find('.wtbx_vc_colorpicker_container'),
				$preview		= $colorpicker.find('.wtbx_vc_colorpicker_preview'),
				$color_opt		= $colorpicker.find('.wtbx_vc_color_opt'),
				$current_color	= $colorpicker.find('.wtbx_vc_colorpicker_current_color'),
				$current_code	= $colorpicker.find('.wtbx_vc_colorpicker_current_code'),
				$wp_colorpicker	= $colorpicker.find('.wtbx_vc_colorpicker_solid_field'),
				$input			= $colorpicker.find('#wtbx_vc_selected_color');

			var $colorpicker_input = $options.find('.wtbx_vc_colorpicker_custom_color');
			//$options.find('.wtbx_vc_colorpicker_custom_color').remove();

			// Modified ColorPicker
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

				var currentColor = colorpickerInput.parent().data('color') !== null ? colorpickerInput.parent().data('color') : '#ffffff';

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

						colorpickerInput.val(rgbaVal);

						wtbx_colorpicker_save();
					}
				});
			};

			// update value
			var wtbx_colorpicker_save = function() {
				var $current_option = $select.val(),
					value = {
						id: '',
						color: ''
					};

				if ( $current_option === 'palette' ) {
					var id	= $colorpicker.find('.wtbx_vc_color_opt.current').data('id'),
						hex	= $colorpicker.find('.wtbx_vc_color_opt.current').data('color');
				} else {
					var id	= 'custom_color',
						hex	= $colorpicker.find('.wtbx_vc_colorpicker_custom_color').val();
				}

				if ( id !== '' && hex !== '' ) {
					value['id'] = id;
					value['color'] = hex;
				}

				$current_color.css('background-color', hex);
				$current_code.text(hex);

				$input.val(JSON.stringify(value));
			};

			var wtbx_colorpicker_show_option = function(option, input) {
				$options.find('.wtbx_vc_colorpicker_option').hide();
				$options.find('.wtbx_vc_colorpicker_option[data-option="' + option + '"]').show();

				if ( option === 'custom' ) {
					//input.appendTo($options.find('.wtbx_vc_colorpicker_custom'));
					//wtbx_rgba_initColorPicker($colorpicker_input);
				} else {
					input = $options.find('.wtbx_vc_colorpicker_custom_color');
					//$options.find('.wp-picker-container').remove();
				}
			};

			// show option on init
			wtbx_colorpicker_show_option($select.val(), $colorpicker_input);

			// close options on blur
			$(document).on('click.wtbx_colorpicker', function(e) {
				if ( !$colorpicker.is(e.target).length && !$colorpicker.has(e.target).length ) {
					$colorpicker.removeClass('active');
					$container.hide();
				}
			});

			// on select option
			$select.on('change', function() {
				wtbx_colorpicker_show_option($select.val(), $colorpicker_input);
				wtbx_colorpicker_save();
			});

			wtbx_rgba_initColorPicker($colorpicker_input);

			// show options on color click
			$preview.on('click', function(e) {
				if ( $('.wtbx_vc_colorpicker_clear').is(e.target) ) {
					e.preventDefault();
					$colorpicker.find('.wtbx_vc_color_opt.current').removeClass('current');
					$colorpicker_input.wtbx_spectrum('set', '');
					$current_color.attr('style', '');
					$current_code.html('');
					$input.val('');
				} else {
					$colorpicker.toggleClass('active');
					$container.toggle();
				}
			});

			// on color select from palette
			$color_opt.on('click', function() {
				if ( $(this).hasClass('current') ) {
					$color_opt.removeClass('current');
				} else {
					$color_opt.removeClass('current');
					$(this).addClass('current');
				}
				wtbx_colorpicker_save();
			});
		});

	}

})(jQuery);