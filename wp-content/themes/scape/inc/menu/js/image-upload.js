jQuery(document).ready(function($) {
	'use strict';
    $('.upload_image_button').each(function() {
		var custom_uploader, attachment;
		var $self;
		$self = $(this);
		$self.on('click', function(e) {
			e.preventDefault();
			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}

			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				attachment = custom_uploader.state().get('selection').first().toJSON();
				$self.siblings('.upload_image').val(attachment.url);
				$self.siblings('.image_uploaded').attr('src',attachment.url).css('display','block');
				custom_uploader.close();
			});

			//Open the uploader dialog
			custom_uploader.open();

		});
    });
	$('.remove_image_button').each(function() {
		var $self = $(this);
		$self.on('click', function(e) {
			e.preventDefault();
			var $self = $(this);
			$self.siblings('.upload_image').val('');
			$self.siblings('.image_uploaded').attr('src','').css('display','none');
		});
	});
	$('.edit-menu-item-_wtbx_mega_menu_enabled').each(function() {
		var $self 				= $(this);
		var $image_select 		= $self.parent().parent().siblings('.field-_wtbx_mega_menu_image');
		var $image_position 	= $self.parent().parent().siblings('.field-_wtbx_mega_menu_bg_position');
		var $image_repeat 		= $self.parent().parent().siblings('.field-_wtbx_mega_menu_bg_repeat');
		var $submenu_opposite	= $self.parent().parent().siblings('.field-_wtbx_mega_menu_opposite');
		var $megamenu_columns	= $self.parent().parent().siblings('.field-_wtbx_mega_menu_columns');
		if($self.val() == 0) {
			$image_select.hide();
			$image_position.hide();
			$image_repeat.hide();
			$megamenu_columns.hide();
		} else if ($self.val() == 1) {
			$submenu_opposite.hide();
		}

		$self.change(function() {
			if($self.val() == 1) {
				$image_select.show();
				$image_position.show();
				$image_repeat.show();
				$submenu_opposite.hide();

				//if ($self.parent().parent().siblings().find('.edit-menu-item-_wtbx_full_width_menu_enabled').val() == 1) {
					$megamenu_columns.show();
				//}
			}else {
				$image_select.hide();
				$image_position.hide();
				$image_repeat.hide();
				$megamenu_columns.hide();
				$submenu_opposite.show();
			}
		});
	});
});