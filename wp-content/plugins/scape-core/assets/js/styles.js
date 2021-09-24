(function( $ ) {

	function wtbx_styles_update($container) {
		var value = {};
		$container.find('.wtbx_vc_styles_input').each(function() {
			var param	= $(this).attr('name'),
				val		= $(this).val();


			if ( val !== '' ) {
				val = parseInt(val.replace(/[^0-9\.]/g, ''), 10);

				if ( !isNaN(val) ) {
					value[param] = val;
				}
			}
		});

		if ( !$.isEmptyObject(value) ) {
			value['property'] = $container.data('property');
			if ( $container.data('suffix') !== '' ) value['suffix'] = $container.data('suffix');
			value = JSON.stringify(value);
		} else {
			value = '';
		}

		$container.find('.wtbx_vc_styles_value').val(value);

	}

	function wtbx_styles_responsive_update($container) {
		var value = {};

		$container.find('.wtbx_screen_size').each(function() {
			var screen = $(this).data('screen');
			$(this).find('.wtbx_vc_styles_input').each(function() {
				var param	= $(this).attr('name'),
					val		= $(this).val();

				if ( val !== '' ) {
					val	= parseInt(val.replace(/[^0-9\.]/g, ''), 10);

					if ( !isNaN(val) ) {
						if ( $.isEmptyObject(value[screen]) ) {
							value[screen] = {};
						}
						value[screen][param] = val;
					}

				}
			});

		});

		if ( !$.isEmptyObject(value) ) {
			value['property'] = $container.data('property');
			if ( $container.data('suffix') !== '' ) value['suffix'] = $container.data('suffix');
			value = JSON.stringify(value);
		} else {
			value = '';
		}
		$container.find('.wtbx_vc_styles_value').val(value);
	}

	$(document).ready(function() {
		$('.wtbx_vc_styles_wrapper').each(function() {
			var $this = $(this);
			wtbx_styles_update($this);
			$this.find('.wtbx_vc_styles_input').on('change input', function() {
				wtbx_styles_update($this);
			});
		});

		$('.wtbx_vc_styles_responsive_wrapper').each(function() {
			var $this = $(this);
			wtbx_styles_responsive_update($this);
			$this.find('.wtbx_vc_styles_input').on('change input', function() {
				wtbx_styles_responsive_update($this);
			});

			$this.find('.wtbx_toggle_label').on('click', function() {
				if ( $this.hasClass('active') ) {
					$this.removeClass('active');
					$(this).html($(this).data('show'));
				} else {
					$this.addClass('active');
					$(this).html($(this).data('hide'));
				}
			});
		});
	});

})( jQuery );