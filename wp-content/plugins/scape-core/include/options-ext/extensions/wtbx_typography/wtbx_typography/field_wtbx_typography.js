(function( $ ) {

	function wtbx_match_variants($typography) {
		var object		= JSON.parse(wtbx_typography_field.object);
		var curr_font	= $typography.find('.wtbx_typography_select[data-param="font_family"] option:selected').val();
		var value		= $typography.find('.wtbx_typography_value').val();

		if ( value !== '' ) {
			value = JSON.parse($typography.find('.wtbx_typography_value').val());
		}

		var curr_label			= '',
			$variant_options	= '',
			$subset_options		= '',
			variants_array		= [];

		if (typeof curr_font !== "undefined" && curr_font !== null && curr_font.length > 0 ) {
			var curr_vars			= object[curr_font]['variants'],
				curr_subsets		= object[curr_font]['subsets'];

			if ( typeof curr_vars !== "undefined" && curr_vars !== null && curr_vars.length > 0 ) {
				variants_array = curr_vars;
			} else {
				variants_array = wtbx_default_font_variants();
			}

			if ( typeof curr_subsets !== "undefined" && curr_subsets !== null && curr_subsets.length > 0 ) {
				for( var j=0; j<curr_subsets.length; j++ ) {
					$subset_options += '<option value="'+curr_subsets[j]+'"' + ( curr_subsets[j] === value['subsets'] ? 'selected="selected"' : '' ) + '>'+curr_subsets[j]+'</option>';
				}
			}

		} else {
			variants_array = wtbx_default_font_variants();
		}

		for( var i=0; i<variants_array.length; i++ ) {
			curr_label = variants_array[i];

			if ( curr_label.indexOf('_italic') !== -1 ) {
				curr_label = curr_label.replace('_', ' ');
			}

			var variants = value['variants'] !== '' ? value['variants'] : '';
			$variant_options += '<option value="'+( variants_array[i] === 'inherit' ? '' : variants_array[i] )+'"' + ( variants_array[i] === variants ? ' selected="selected"' : '' ) + '>'+curr_label+'</option>';
		}

		$typography.find('.wtbx_typography_select[data-param="variants"]').html($variant_options);
		$typography.find('.wtbx_typography_select[data-param="subsets"]').html($subset_options);
	}

	function wtbx_default_font_variants() {
		return ['inherit', '100', '100_italic', '200', '200_italic', '300', '300_italic', '400', '400_italic', '500', '500_italic', '600', '600_italic', '700', '700_italic', '800', '800_italic', '900', '900_italic'];
	}

	function wtbx_typography_update($typography) {
		var value = {},
			final_value = '';

		$typography.find('.wtbx_typography_select').each(function() {
			var param	= $(this).data('param'),
				val		= $(this).find('option:selected').val();

			if ( typeof val === 'undefined' ) val = '';
			value[param] = val;

			if ( value[param] === '' ) {
				delete value[param];
			}
		});

		$typography.find('.wtbx_typography_input').each(function() {
			var param	= $(this).data('param'),
				val		= parseFloat($(this).val().replace(/([^\-0-9\.,])/i, ''), 10),
				units	= $(this).data('units');

			if ( isNaN(val) ) {
				value[param] = '';
			} else {
				value[param] = val + units;
			}

			if ( value[param] === '' ) {
				delete value[param];
			}

		});

		if ( $.isEmptyObject(value) ) {
			final_value = '';
		} else {
			final_value = JSON.stringify(value);
		}

		$typography.find('.wtbx_typography_value').val(final_value);

		wtbx_typography_preview($typography, value);
	}

	function wtbx_typography_preview($typography, value) {
		if ( $typography.find('.wtbx_typography_preview_inner').length ) {
			var style = ['', ''];
			if ( !$.isEmptyObject(value['variants']) ) {
				if (value['variants'].indexOf('_italic') !== -1) {
					style = value['variants'].split('_');
				} else {
					style[0] = value['variants'];
				}
			}

			var font_family		= $typography.find('.wtbx_typography_select[data-param="font_family"] option:selected').text() || '';
			var font_size		= value['font_size'] || '';
			var transform		= value['transform'] || '';
			var line_height		= value['line_height'] || '';
			var letter_spacing	= value['letter_spacing'] || '';
			var font_weight		= style[0] || '';
			var font_style		= style[1] || '';

			$typography.find('.wtbx_typography_preview_inner').css({
				'font-family':		font_family,
				'font-weight':		font_weight,
				'font-style':		font_style,
				'text-transform':	transform,
				'font-size':		font_size,
				'line-height':		line_height,
				'letter-spacing':	letter_spacing
			});
		} else {
			$typography.find('.wtbx_typography_preview_inner').removeAttr('style');
		}
	}


	$(document).ready(function() {

		var $typography = $('.wtbx_typography_wrapper');

		$typography.each(function() {
			var $this = $(this);

			wtbx_match_variants($this);
			wtbx_typography_update($this);

			$this.find('.wtbx_typography_select[data-param="font_family"]').change(function() {
				wtbx_match_variants($this);
				wtbx_typography_update($this);
			});

			$this.find('.wtbx_typography_unit').on('click', function() {
				if ( !$(this).hasClass('active') ) {
					$(this).closest('.wtbx_typography_units').find('.active').removeClass('active');
					$(this).addClass('active');
					$(this).closest('.wtbx_typography_param_wrap').find('.wtbx_typography_input').data('units', $(this).data('units'));
					wtbx_typography_update($this);
				}
			});

			$this.find('.wtbx_typography_select').change(function() {
				wtbx_typography_update($this);
			});

			$this.find('.wtbx_typography_input').on('change input', function() {
				wtbx_typography_update($this);
			});

			$this.find('.wtbx_typography_clear').on('click', function() {
				$this.find('.wtbx_typography_select, .wtbx_typography_input').each(function() {
					$(this).val('');
				});
				wtbx_typography_update($this);
			});

		});

	});

})( jQuery );