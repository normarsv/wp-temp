(function( $ ) {

	$(document).ready(function() {

		$('.wtbx_vc_slider_wrapper').each(function() {
			var $this	= $(this),
				$input	= $this.find('.wtbx_vc_slider_value'),
				$slider = $this.find('.wtbx_vc_slider'),
				$handle = $this.find('.wtbx_vc_slider_handle'),
				value	= parseFloat($input.val()),
				min		= parseFloat($input.data('min')) || 0,
				max		= parseFloat($input.data('max')) || 10,
				step	= parseFloat($input.data('step')) || 0.5;

			$slider.slider({
				value:	value,
				min:	min,
				max:	max,
				step:	step,
				create: function() {
					$handle.text( $(this).slider("value") );
				},
				slide: function( event, ui ) {
					$input.val( ui.value.toString() );
					$handle.text( ui.value );
				}
			});

		});

	});

})( jQuery );