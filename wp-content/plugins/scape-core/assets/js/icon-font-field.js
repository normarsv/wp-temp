(function($) {
	"use strict";

	$('.wtbx_vc_icon_font_wrapper').each(function() {
		var $container	= $(this),
			$fontSelect	= $container.find('.wtbx_vc_icon_font_select'),
			$fontCont	= $container.find('.wtbx_vc_icon_font_container'),
			$currIcon	= $container.find('.wtbx_vc_current_icon'),
			$input		= $container.find('#wtbx_vc_selected_icon');

		if ( $fontSelect.length  ) {
			// show font preview on start
			var activeFont	= $fontSelect.val();
			var font_arr = $input.val();
			if ( font_arr !== '' ) {
				font_arr = JSON.parse(font_arr);
				$fontCont.find('.wtbx_vc_icon_font[data-font="'+font_arr['font']+'"]').show();
				$currIcon.find('i').attr('class', font_arr['icon']);
			} else {
				font_arr = {};
				$fontCont.find('.wtbx_vc_icon_font:first').show();
			}

			// switch font preview on select change
			$fontSelect.unbind().on('change', function() {
				$fontCont.find('.wtbx_vc_icon_font').hide();
				$fontCont.find('.wtbx_vc_icon_font[data-font="'+$(this).val()+'"]').show();
			});

			// select icon
			$container.find('.wtbx_vc_icon_font input[type=radio]').unbind().on('click', function() {

				$container.find('.wtbx_vc_icon_font input.checked').removeClass('checked');
				$(this).addClass('checked');

				var	icon_name = $container.find('.wtbx_vc_icon_font input.checked').val();

				font_arr['font'] = $fontSelect.val();
				font_arr['icon'] = icon_name;

				$currIcon.find('i').attr('class', icon_name);

				$input.val(JSON.stringify(font_arr));
			});

			// remove icon
			$container.find('.wtbx_vc_current_icon_remove').unbind().on('click', function() {
				$currIcon.find('i').attr('class', '');
				$container.find('.wtbx_vc_icon_font input.checked').removeClass('checked');
				$input.val('');
			});
		}
	});

})(jQuery);