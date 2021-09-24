jQuery(document).ready(function($) {
	"use strict";
    var icon_field;

	$('#wtbx-generator ul.icons-list li').each(function() {
		var $self = $(this);
		var selected = $self.hasClass('crdash-wine_alt') ? 'checked' : '';
		var $class = $self.find('label').attr('class');
		var $label = $self.find('label');
		$self.prepend('<input name="name" type="radio" value="'+$class+'" id="'+$class+'" '+selected+'>');
	});

	setTimeout(function() {
		$('.wtbx-iconname').each(function() {
			var value = $(this).val();

			if ( value !== '' ) {
				value = JSON.parse(value);
				var icon_name = value['icon'];
				$(this).next('.wtbx-menu-icon-wrapper').find('.wtbx-selected-icon').addClass(icon_name);
			}
		});
	});



    // Custom popup box
    $(document).on('click', '.wtbx-add-icon', function(){

		var $button = $(this),
			saved_icon;
        icon_field = $(this).parent().siblings('.wtbx-iconname');

        $("#wtbx-generator-wrap, #wtbx-generator-overlay").show();
		$('.ui-dialog').hide();

		var saved_value = icon_field.val();
		if ( saved_value !== '' ) {
			saved_value = JSON.parse(saved_value);

			$('#wtbx-generator-wrap #wtbx-library-select').val(saved_value['font']).change();
			$('#wtbx-generator-wrap .wtbx-font-preview-icon input[id="'+saved_value['icon']+'"]').prop('checked', true);
		} else {
			$('#wtbx-generator-wrap #wtbx-library-select').find('option:first').prop('selected', true).change();

		}
		
        $('#wtbx-generator-insert').on('click', function(event) {
			
            $('.wtbx-generator-icon-select input:checked').addClass("wtbx-generator-attr");
            $('.wtbx-generator-icon-select input:not(:checked)').removeClass("wtbx-generator-attr");

			var value = {
				'font': '',
				'icon': ''
			};

			var icon_font = $('#wtbx-library-select').val();
			var icon_name = $('.wtbx-generator-icon-select input:checked').val();

			if ( icon_name === 'no-icon' ) {
				icon_name = '';
				icon_font = '';
			}

			value['font'] = icon_font;
			value['icon'] = icon_name;
            icon_field.val(JSON.stringify(value));

			$button.siblings('.wtbx-selected-icon').attr('class', 'wtbx-selected-icon ' + icon_name);

			$('.ui-dialog').show();
            $("#wtbx-generator-wrap, #wtbx-generator-overlay").hide();

            // Prevent default action
            event.preventDefault();

            return false;
        });

        return false;
    });

	$(document).on('click', '.wtbx-delete-icon', function(){
		var $button = $(this);
		var input = $(this).parent().siblings('.wtbx-iconname');

		input.val('');
		$button.siblings('.wtbx-selected-icon').attr('class', 'wtbx-selected-icon');
	});

	$(document).on('click', '#wtbx-generator-close', function(e){
		$("#wtbx-generator-wrap, #wtbx-generator-overlay").hide();
		$('.ui-dialog').show();
		e.preventDefault();
		return false;
    });

    // Icon pack select
	$(document).on('change', '#wtbx-library-select', function(){
		$('.wtbx-icon-list').hide();
		$('.wtbx-icon-list.'+ $(this).val()).show();
	});


});