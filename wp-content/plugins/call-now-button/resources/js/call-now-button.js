function cnb_setup_colors() {
	// Add color picker
	jQuery('.cnb-color-field').wpColorPicker();
	jQuery('.cnb-iconcolor-field').wpColorPicker();

	// Reveal additional button placements when clicking "more"
	jQuery("#cnb-more-placements").click(function(e){
		e.preventDefault();
		jQuery(".cnb-extra-placement").css("display","block");
		jQuery("#cnb-more-placements").remove();
	});

	// TODO The input names AND radioValue might have to be changed to reflect new values
	// Option to Hide Icon is only visible when the full width button is selected
	var radioValue = jQuery("input[name='cnb[appearance]']:checked").val();
	var textValue 	= jQuery("input[name='cnb[text]']").val();
	if(radioValue != 'full' && radioValue != 'tfull') {
		jQuery('#hideIconTR').hide();
	} else if(textValue.length < 1) {
		jQuery('#hideIconTR').hide();
	}
	jQuery('input[name="cnb[appearance]"]').on("change",function(){
		var radioValue 	= jQuery("input[name='cnb[appearance]']:checked").val();
		var textValue 	= jQuery("input[name='cnb[text]']").val();
		if(radioValue != 'full' && radioValue != 'tfull') {
			jQuery('#hideIconTR').hide();
		} else if(textValue.length > 0 ) {
			jQuery('#hideIconTR').show();
		}
	});
}

function cnb_setup_sliders() {
	jQuery('#cnb_slider').on("input change", function() {
		cnb_update_sliders();
	});
	jQuery('#cnb_order_slider').on("input change", function() {
		cnb_update_sliders();
	});
	cnb_update_sliders();
}

function cnb_update_sliders() {
	// Zoom slider - show percentage
	var cnb_slider = document.getElementById("cnb_slider");
	if (cnb_slider && cnb_slider.value) {
		var cnb_slider_value = document.getElementById("cnb_slider_value");
		cnb_slider_value.innerHTML = '(' + Math.round(cnb_slider.value * 100) + '%)';
	}

	// Z-index slider - show steps
	var cnb_order_slider = document.getElementById("cnb_order_slider");
	if (cnb_order_slider && cnb_order_slider.value) {
		var cnb_order_value = document.getElementById("cnb_order_value");
		cnb_order_value.innerHTML = cnb_order_slider.value;
	}
}

function cnb_hide_on_show_always() {
	let show_always_checkbox = document.getElementById('actions_schedule_show_always');
	if (show_always_checkbox) {
		if (show_always_checkbox.checked) {
			// Hide
			jQuery('.cnb_hide_on_show_always').hide();
		} else {
			jQuery('.cnb_hide_on_show_always').show();
		}
	}
	return false;
}

function cnb_disable_api_key_when_cloud_hosting_is_disabled() {
	jQuery('.when-cloud-enabled :input').prop('disabled', !jQuery('#cloud_enabled').is(':checked'));
}

let cnb_add_condition_counter = 0;
function cnb_add_condition() {
	let template = `
		<th scope="row">Condition: <div class="cnb_font_normal cnb_font_90">new/unsaved</div></th>
		<td>
			<input type="hidden" name="condition[${cnb_add_condition_counter}][id]" value="" />
			<input type="hidden" name="condition[${cnb_add_condition_counter}][conditionType]" value="URL" />
			<input type="hidden" name="condition[${cnb_add_condition_counter}][delete]" id="cnb_condition_${cnb_add_condition_counter}_delete" value="" />
			<select name="condition[${cnb_add_condition_counter}][filterType]">
				<option value="INCLUDE">Include</option>
				<option value="EXCLUDE">Exclude</option>
			</select><br />

			<select name="condition[${cnb_add_condition_counter}][matchType]">
					<option value="SIMPLE">Page path is:</option>
					<option value="EXACT">Page URL is:</option>
					<option value="SUBSTRING">Page URL contains:</option>
					<option value="REGEX">Page URL matches RegEx:</option>
			</select><br />

			<input type="text" name="condition[${cnb_add_condition_counter}][matchValue]" value=""/><br />

			<input type="button" onclick="return cnb_remove_condition('${cnb_add_condition_counter}');" value="Remove Condition" class="button-link button-link-delete"></td>
		</td>
`;

	let table = document.getElementById('cnb_form_table_visibility');
	let container = document.getElementById('cnb_form_table_add_condition');
	let rowElement = document.createElement('tr');
	rowElement.className = 'appearance cnb_condition_new';
	rowElement.vAlign = 'top';
	rowElement.id = 'cnb_condition_' + cnb_add_condition_counter;
	rowElement.innerHTML = template;
	table.insertBefore(rowElement, container);

	cnb_add_condition_counter++;
	return false;
}

function cnb_remove_condition(id) {
	let container = document.getElementById('cnb_condition_' + id);
	let deleteElement = document.getElementById('cnb_condition_' + id + '_delete');
	deleteElement.value = 'true';
	jQuery(container).css("background-color", "#ff726f");
	jQuery(container).fadeOut(function() {
		jQuery(container).css("background-color", "");
		if (container.className.includes('cnb_condition_new')) {
			container.remove();
		}
	});
}

function cnb_action_appearance() {
	jQuery('#cnb_action_type').change(function (obj) {
		cnb_action_update_appearance(obj.target.value);
	});

	// Setup WHATSAPP integration
	const input = document.querySelector("#cnb_action_value_input_whatsapp");
	if (!input || !window.intlTelInput) {
		return
	}

	const iti = window.intlTelInput(input, {
		utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js',
		nationalMode: false,
		separateDialCode: true,
		hiddenInput: 'actionValueWhatsappHidden'
	});

	// here, the index maps to the error code returned from getValidationError - see readme
	const errorMap = [
		'Invalid number',
		'Invalid country code',
		'Too short',
		'Too long',
		'Invalid number'];

	const errorMsg = jQuery('#cnb-error-msg');
	const validMsg = jQuery('#cnb-valid-msg');

	const reset = function() {
		input.classList.remove('error');
		errorMsg.html('');
		errorMsg.hide();
		validMsg.hide();
	};

	const onBlur = function() {
		reset();
		if (input.value.trim()) {
			if (iti.isValidNumber()) {
				validMsg.show();
			} else {
				const errorCode = iti.getValidationError();
				if (errorCode < 0) {
					// Unknown error, ignore for now
					return
				}
				input.classList.add('error');
				errorMsg.text(errorMap[errorCode]);
				errorMsg.show();
			}
		} else {
			// Empty
			reset();
		}
	}

	// on blur: validate
	input.addEventListener('blur', onBlur);

	// on keyup / change flag: reset
	input.addEventListener('change', onBlur);
	input.addEventListener('keyup', onBlur);

	// init
	onBlur();
}

function cnb_action_update_appearance(value) {
	jQuery('.cnb-action-properties-email').hide();
	jQuery('.cnb-action-properties-email-extra').hide();
	jQuery('.cnb-action-properties-whatsapp').hide();
	jQuery('.cnb-action-properties-whatsapp-extra').hide();
	jQuery('.cnb-action-properties-map').hide();
	jQuery('.cnb-action-value').show();
	jQuery('#cnb_action_value_input').prop( 'disabled', false );
	jQuery('#cnb_action_value_input_whatsapp').prop( 'disabled', true );
	switch (value) {
		case 'PHONE':
			jQuery('#cnb_action_value').text('Phone number');
			break
		case 'ANCHOR':
			jQuery('#cnb_action_value').text('On-page anchor');
			break
		case 'LINK':
			jQuery('#cnb_action_value').text('Full URL');
			break
		case 'EMAIL':
			jQuery('#cnb_action_value').text('E-mail address');
			jQuery('.cnb-action-properties-email').show()
			break
		case 'WHATSAPP':
			jQuery('#cnb_action_value').text('Whatsapp number');
			jQuery('.cnb-action-value').hide();
			jQuery('#cnb_action_value_input').prop( 'disabled', true );
			jQuery('#cnb_action_value_input_whatsapp').prop( 'disabled', false );
			jQuery('.cnb-action-properties-whatsapp').show();
			break
		case 'MAP':
			jQuery('#cnb_action_value').text('Address');
			jQuery('.cnb-action-properties-map').show();
			break
		default:
			jQuery('#cnb_action_value').text('Action value');
	}
}

function cnb_action_update_map_link(element) {
	jQuery(element).prop("href", "https://maps.google.com?q=" + jQuery('#cnb_action_value_input').val())
}

function cnb_hide_edit_action_if_advanced() {
	var element = jQuery('#toplevel_page_call-now-button li.current a');
	if (element.text() === 'Edit action') {
		element.removeAttr('href');
		element.css('cursor', 'default');
	}
}

function cnb_hide_edit_domain_upgrade_if_advanced() {
	var element = jQuery('#toplevel_page_call-now-button li.current a');
	if (element.text() === 'Upgrade domain') {
		element.removeAttr('href');
		element.css('cursor', 'default');
	}
}

function cnb_hide_on_modal() {
	jQuery('.cnb_hide_on_modal').hide();
}

function show_advanced_view_only() {
	jQuery('.cnb_advanced_view').show();
}

function cnb_strip_beta_from_referrer() {
	var referer = jQuery('input[name="_wp_http_referer"]');
	if (referer && referer.val()) {
		referer.val(referer.val().replace('&beta', ''))
	}
}

jQuery( document ).ready(function() {
	cnb_setup_colors();
	cnb_setup_sliders();
	cnb_hide_on_show_always();
	cnb_disable_api_key_when_cloud_hosting_is_disabled();
	cnb_action_appearance();
	cnb_action_update_appearance(jQuery('#cnb_action_type').val());
	cnb_hide_edit_action_if_advanced();
	cnb_hide_edit_domain_upgrade_if_advanced();
	cnb_strip_beta_from_referrer();

	if (typeof cnb_hide_on_modal_set !== 'undefined' && cnb_hide_on_modal_set === 1) {
		cnb_hide_on_modal();
	}

	if (typeof show_advanced_view_only_set !== 'undefined' && show_advanced_view_only_set && show_advanced_view_only_set === 1) {
		show_advanced_view_only()
	}
});
