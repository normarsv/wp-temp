(function($) {
	"use strict";

	var $colorpicker_multi	= $('.wtbx_vc_colorpicker_multi');

	if ( $colorpicker_multi.length  ) {

		$colorpicker_multi.each(function() {

			var param = $(this).data('param');

			//var $colorpicker	= $('.wtbx_vc_colorpicker_multi[data-param="'+param +'"]'),
			var	$colorpicker	= $(this),
				$preview		= $colorpicker.find('.wtbx_vc_colorpicker_preview'),
				$input			= $colorpicker.find('#wtbx_vc_selected_color'),
				$switch			= $colorpicker.find('.wtbx_vc_colorpicker_switch_label'),
				$colorpicker_input = {};

			// update value
			var wtbx_colorpicker_save = function() {
				var current_type	= $colorpicker.find('.wtbx_vc_colorpicker_switch_label.active').data('type');

				var value = $input.val();
				if ( value === '' ) {
					value = {};
				} else {
					value = JSON.parse(value);
				}

				if ( current_type === 'solid' ) {
					var section		= $(this).data('section'),
						$container		= $colorpicker.find('.wtbx_vc_colorpicker_container[data-section="solid"]'),
						$select			= $container.find('.wtbx_vc_colorpicker_select select'),
						current_option	= $select.val();

					delete value.dir;
					delete value.from;
					delete value.to;
					value['solid'] = {};

					if ( current_option === 'palette' ) {
						var id	= $container.find('.wtbx_vc_color_opt.current').data('id'),
							hex	= $container.find('.wtbx_vc_color_opt.current').data('color');
					} else {
						var id	= 'custom_color',
							hex	= $container.find('.wtbx_vc_colorpicker_custom_color').val();
					}

					if ( id === undefined ) {
						id = '';
					}
					if ( hex === undefined ) {
						hex = '';
					}

					value['solid']['id'] = id;
					value['solid']['color'] = hex;

					$colorpicker.find('.wtbx_vc_colorpicker_type[data-type="solid"]').find('.wtbx_vc_colorpicker_preview[data-section="solid"]').find('.wtbx_vc_colorpicker_current_color').css('background-color', hex);
					$colorpicker.find('.wtbx_vc_colorpicker_type[data-type="solid"]').find('.wtbx_vc_colorpicker_preview[data-section="solid"]').find('.wtbx_vc_colorpicker_current_code').text(hex);

				} else if ( current_type === 'gradient' ) {
					delete value.solid;
					var $gradient	= $colorpicker.find('.wtbx_vc_colorpicker_type[data-type="gradient"]');

					value['dir'] = $colorpicker.find('.wtbx_vc_colorpicker_gradient_dir select').val();

					$gradient.find('.wtbx_vc_colorpicker_preview').each(function() {
						var section		= $(this).data('section'),
							$container		= $colorpicker.find('.wtbx_vc_colorpicker_container[data-section="'+section+'"]'),
							$select			= $container.find('.wtbx_vc_colorpicker_select select'),
							current_option	= $select.val();

						value[section] = {};

						if ( current_option === 'palette' ) {
							var id	= $container.find('.wtbx_vc_color_opt.current').data('id'),
								hex	= $container.find('.wtbx_vc_color_opt.current').data('color');
						} else {
							var id	= 'custom_color',
								hex	= $container.find('.wtbx_vc_colorpicker_custom_color').val();
						}

						if ( id === undefined ) {
							id = '';
						}
						if ( hex === undefined ) {
							hex = '';
						}

						value[section]['id'] = id;
						value[section]['color'] = hex;

						$colorpicker.find('.wtbx_vc_colorpicker_type[data-type="gradient"]').find('.wtbx_vc_colorpicker_preview[data-section="'+section+'"]').find('.wtbx_vc_colorpicker_current_color').css('background-color', hex);
						$colorpicker.find('.wtbx_vc_colorpicker_type[data-type="gradient"]').find('.wtbx_vc_colorpicker_preview[data-section="'+section+'"]').find('.wtbx_vc_colorpicker_current_code').text(hex);

					});

				}

				$input.val(JSON.stringify(value));
			};

			// switch between solid and gradient on color click
			$switch.on('click', function() {
				if ( !$(this).hasClass('active') ) {
					$switch.removeClass('active');
					$(this).addClass('active');
					var type = $(this).data('type');
					$colorpicker.find('.wtbx_vc_colorpicker_type').hide();
					$colorpicker.find('.wtbx_vc_colorpicker_type[data-type="'+type+'"]').show();
					wtbx_colorpicker_save();
				}
			});

			$preview.each(function() {

				var	$section		= $(this),
					section			= $section.data('section'),
					$container		= $colorpicker.find('.wtbx_vc_colorpicker_container[data-section="' + section + '"]'),
					$select			= $container.find('.wtbx_vc_colorpicker_select select'),
					$options		= $container.find('.wtbx_vc_colorpicker_options'),
					$color_opt		= $container.find('.wtbx_vc_color_opt');

				$colorpicker_input[section] = $options.find('.wtbx_vc_colorpicker_custom_color');
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

				var wtbx_colorpicker_show_option = function(option, input) {
					$options.find('.wtbx_vc_colorpicker_option').hide();
					$options.find('.wtbx_vc_colorpicker_option[data-option="' + section + '-' + option + '"]').show();

					if ( option === 'custom' ) {
						//input.appendTo($options.find('.wtbx_vc_colorpicker_custom'));
						//wtbx_rgba_initColorPicker($colorpicker_input[section]);
					} else {
						input = $options.find('.wtbx_vc_colorpicker_custom_color');
						//$options.find('.wp-picker-container').remove();
					}
				};

				// show option on init
				wtbx_colorpicker_show_option($select.val(), $colorpicker_input[section]);
				wtbx_rgba_initColorPicker($colorpicker_input[section]);

				// show options on color click
				$(this).each(function() {
					$(this).on('click', function(e) {

						if ( $('.wtbx_vc_colorpicker_clear').is(e.target) ) {
							e.preventDefault();
							$('.wtbx_vc_colorpicker_container[data-section="'+ $(this).data('section') +'"]').find('.wtbx_vc_color_opt.current').removeClass('current');
							$colorpicker_input[$(this).data('section')].wtbx_spectrum('set', '');
							$(this).find('.wtbx_vc_colorpicker_current_color').attr('style', '');
							$(this).find('.wtbx_vc_colorpicker_current_code').html('');
							wtbx_colorpicker_save();

						} else {
							if ( !$(this).hasClass('active') ) {
								$(this).closest('.wtbx_vc_colorpicker_type').find('.wtbx_vc_colorpicker_container.active').removeClass('active').hide();
								$(this).closest('.wtbx_vc_colorpicker_type').find('.wtbx_vc_colorpicker_preview.active').removeClass('active');

								$(this).addClass('active');
								$container.addClass('active');
								$container.show();
							} else {
								$(this).removeClass('active');
								$container.removeClass('active');
								$container.hide();
							}
						}

					});
				});

				// close options on blur
				$(document).on('click.wtbx_colorpicker', function(e) {
					if ( !$colorpicker.is(e.target).length && !$colorpicker.has(e.target).length ) {
						$preview.removeClass('active');
						$colorpicker.find('.wtbx_vc_colorpicker_container').removeClass('active');
						$colorpicker.find('.wtbx_vc_colorpicker_container').hide();
					}
				});

				// on select option
				$select.on('change', function() {
					wtbx_colorpicker_show_option($select.val(), $colorpicker_input[section]);
					wtbx_colorpicker_save();
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

				// on gradient direction change
				$colorpicker.find('.wtbx_vc_colorpicker_gradient_dir').on('change', function() {
					wtbx_colorpicker_save();
				});

			});


		});

	}

})(jQuery);