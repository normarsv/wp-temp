(function( $ ) {

	function wtbx_design_update($container) {
		var value = {};

		$container.find('.wtbx_vc_design_tab').each(function() {
			var screen = $(this).data('screen');
			$(this).find('.wtbx_vc_design_input').each(function() {
				var param	= $(this).attr('name'),
					val		= $(this).val();

				if ( val !== '' ) {

					if ( !$(this).hasClass('wtbx_vc_border_style') ) {
						//val	= parseInt(val.replace(/[^0-9\.]/g, ''), 10);

						if ( $(this).attr('name').indexOf('padding') !== -1 || $(this).attr('name').indexOf('margin') !== -1 ) {
							if ( val.indexOf('%') !== -1 ) {
								val	= parseInt(val, 10);

								if ( isNaN(val) ) {
									return true;
								} else {
									val += '%';
								}
							}
						} else {
							val	= parseInt(val, 10);

							if ( isNaN(val) ) {
								return true;
							}
						}
					}

					if ( $.isEmptyObject(value[screen]) ) {
						value[screen] = {};
					}
					value[screen][param] = val;

				}
			});

		});

		if ( !$.isEmptyObject(value) ) {
			value.property = $container.data('property');
			value = JSON.stringify(value);
		} else {
			value = '';
		}
		$container.find('.wtbx_vc_design_value').val(value);
	}

	$(document).ready(function() {
		$('.wtbx_vc_design_wrapper').each(function() {
			var $this = $(this);

			$this.find('.wtbx_vc_design_input').change();

			wtbx_design_update($this);

			$this.find('.wtbx_vc_design_input').on('change', function() {
				if ( $(this).attr('name') === 'padding-left' || $(this).attr('name') === 'padding-right' ) {
					if ( $(this).val() === '' && $(this).data('paddingh') !== '' ) {
						$(this).val($(this).data('paddingh'));
					}
				}
				if ( $(this).attr('name') === 'padding-top' || $(this).attr('name') === 'padding-bottom' ) {
					if ( $(this).val() === '' && $(this).data('paddingv') !== '' ) {
						$(this).val($(this).data('paddingv'));
					}
				}
				wtbx_design_update($this);
			});

			$this.find('.wtbx_vc_design_input').on('input', function() {
				wtbx_design_update($this);
			});

			$this.find('.wtbx_vc_design_tabs_label').on('click', function() {
				if ( !$(this).hasClass('active') ) {
					var screen = $(this).data('screen');
					$this.find('.wtbx_vc_design_tab').removeClass('active');
					$this.find('.wtbx_vc_design_tab[data-screen="'+screen+'"]').addClass('active');
					$this.find('.wtbx_vc_design_tabs_label').removeClass('active');
					$(this).addClass('active');
				}
			});
		});

	});

})( jQuery );