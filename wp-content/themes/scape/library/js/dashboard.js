(function() {
	"use strict";
	var $ = jQuery.noConflict();

	function block() {
		$('#wpwrap, .envato-setup-content').block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});
	}

	function unblock() {
		$('#wpwrap, .envato-setup-content').unblock();
	}

	$(document).ready(function() {
		$('#wtbx-activate-purchase-code').on('click', function() {
			var token = $('.wtbx-validation-input[name="wtbx-validation-token"]').val();
			var code = $('.wtbx-validation-input[name="wtbx-validation-code"]').val();

			var data = {
				action: "scape_activate_purchase_code",
				client_action: "activate_purchase_code",
				nonce: scape_dashboard_params.wpnonce,
				data: {
					token: token,
					code: code
				}
			};

			block();

			$.ajax({
				type: 'POST',
				url: scape_dashboard_params.ajaxurl,
				data: data,
				success: function(response) {
					if (response) {
						response = JSON.parse(response);

						if ( response === null ) {
							$('.wtbx-dash-message span').text('Could not get response from the server. Please try again.');
							$('.wtbx-dash-message i').attr('class', 'dashicons dashicons-no-alt');
							$('.wtbx-dash-message').show();
							unblock();
							return false;
						}

						if ( !$.isEmptyObject(response['message']) ) {
							$('.wtbx-dash-message span').text(response['message']);
						}
						$('.wtbx-dash-message i').removeClass('dashicons-yes dashicons-no-alt');

						if( response.status === 'success' ) {
							$('.wtbx-dash-message i').attr('class', 'dashicons dashicons-yes');
							$('.wtbx-validation-input').attr('readonly', true);
							$('#wtbx-activate-purchase-code, .wtbx-wizard-skip').hide();
							$('#wtbx-deactivate-purchase-code, .wtbx-wizard-continue, .wtbx-dash-message, .wtbx-dash-activation-inact').show();
							$('.wtbx-dash-activation-adv, .wtbx-dash-activation-hint').hide();
							$('.wtbx-dash-block').hide();
						} else {
							$('.wtbx-dash-message').show();
							$('.wtbx-dash-message i').attr('class', 'dashicons dashicons-no-alt');
						}
						if ( !$('.envato-setup-content').length ) {
							location.reload();
						} else {
							unblock();
						}

					}
				},
				error: function (response) {
					unblock();
				}
			});
		});

		$('#wtbx-deactivate-purchase-code').on('click', function() {
			var token = $('.wtbx-validation-input[name="wtbx-validation-token"]').val();
			var code = $('.wtbx-validation-input[name="wtbx-validation-code"]').val();

			var data = {
				action: "scape_deactivate_purchase_code",
				client_action: "deactivate_purchase_code",
				nonce: scape_dashboard_params.wpnonce,
				data: {
					token: token,
					code: code
				}
			};

			block();

			$.ajax({
				type: 'POST',
				url: scape_dashboard_params.ajaxurl,
				data: data,
				success: function(response) {
					if (response) {
						response = JSON.parse(response);

						if ( !$.isEmptyObject(response['message']) ) {
							$('.wtbx-dash-message span').text(response['message']);
						}
						$('.wtbx-dash-message i').removeClass('dashicons-yes dashicons-no-alt');

						if( response.status === 'success' ) {
							$('.wtbx-dash-message i').addClass('dashicons-yes');
							$('.wtbx-validation-input').attr('readonly', false).val('');
							$('#wtbx-activate-purchase-code, .wtbx-dash-message').show();
							$('#wtbx-deactivate-purchase-code, .wtbx-dash-activation-inact').hide();
							$('.wtbx-dash-activation-adv, .wtbx-dash-activation-hint').show();
							setTimeout(function() {
								$('.wtbx-dash-message').slideToggle();
							}, 2000);
						} else {
							$('.wtbx-dash-message i').addClass('dashicons-no-alt');
							$('.wtbx-dash-message').show();
						}

						unblock();
					}
				},
				error: function (response) {
					unblock();
				}
			});
		});
	});

})(jQuery);