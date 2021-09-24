/* global redux_change, wp */

(function($) {
    "use strict";
    $.redux = $.redux || {};
    $(document).ready(function() {
        $.redux.wbc_importer();
    });
    $.redux.wbc_importer = function() {

		var $popup = $('.importer-popup');
		$popup.find('.importer-popup-backdrop').on('click', function() {
			if ( !$popup.hasClass('progress') ) {
				$popup.removeClass('active');
			}
		});

        $('.wrap-importer .import-demo-data, #wbc-importer-reimport').unbind('click').on('click', function(e) {
            e.preventDefault();

            var parent = jQuery(this).closest('.theme');

            var reimport = false;

            var message = 'Import Demo Content';

            if (e.target.id == 'wbc-importer-reimport') {
                reimport = true;
                message  = 'Re-Import Content';

                if (!jQuery(this).hasClass('rendered')) {
                    parent = jQuery(this).parents('.wrap-importer');
                }
            }

            if (parent.hasClass('imported') && reimport == false) return;

			$popup.find('.importer-popup-plugins, .importer-popup-options').text('');
			$popup.find('img').attr('src', '');
			$popup.find('.wbc-progress-back').remove();

            $popup.find('img').attr('src', parent.find('.wbc_image').attr('src'));

			var plugins = parent.data('plugins');
			for ( var p = 0; p < plugins.length; p++ ) {
				$popup.find('.importer-popup-plugins').append('<span class="importer-popup-plugin">' + plugins[p] + '</span>');
			}

			var options = parent.data('options');
			for ( var o = 0; o < options.length; o++ ) {
			    var name = options[o].toLowerCase().replace(/ /g, '-');
				$popup.find('.importer-popup-options').append('<label class="importer-popup-option" for="' + name + '"><input type="checkbox" id="' + name + '" value="' + name + '" checked="checked" />' + options[o] + '</label>');
			}

			if ( parent.data('demo-id') === 'wbc-import-12' ) {
				var $hint = '<div class="importer-content-hint">';
				$hint += '<label class="importer-popup-option" for="import-all"><input type="checkbox" id="import-all" value="import-all" checked="checked" />Import everything</label>';
				$hint += '<label class="importer-popup-option" for="import-page"><input type="checkbox" id="import-page" value="import-page" />Pages</label>';
				$hint += '<label class="importer-popup-option" for="import-post"><input type="checkbox" id="import-post" value="import-post" />Posts</label>';
				$hint += '<label class="importer-popup-option" for="import-portfolio"><input type="checkbox" id="import-portfolio" value="import-portfolio" />Portfolio</label>';
				$hint += '<label class="importer-popup-option" for="import-content_block"><input type="checkbox" id="import-content_block" value="import-content_block" />Content block</label>';
				$hint += '<label class="importer-popup-option" for="import-product"><input type="checkbox" id="import-product" value="import-product" />Products</label>';
				$hint += '</div>';
				$popup.find('.importer-popup-option[for="demo-content"]').append($hint);
			}

			// $('.importer-popup-option #demo-content').on('change', function() {
			// 	if ( $(this).attr('checked') !== 'checked' ) {
			// 		$('#attachments, #generate-resized-image-copies').removeAttr('checked').parent('label').addClass('disabled');
			// 		$('.importer-popup-option #import-all, .importer-popup-option #import-page, .importer-popup-option #import-post, .importer-popup-option #import-portfolio, .importer-popup-option #import-content_block, .importer-popup-option #import-product').removeAttr('checked');
			// 	} else {
			// 		$('#attachments').parent('label').removeClass('disabled');
			//
			// 		if ( $('#attachments').attr('checked') === 'checked' ) {
			// 			$('#generate-resized-image-copies').parent('label').removeClass('disabled');
			// 		}
			//
			// 		var checked = false;
			// 		$(this).siblings('.importer-content-hint').find('checkbox').each(function() {
			//
			// 			if ( $(this).attr('checked') === 'checked' ) {
			// 				checked = true;
			// 			}
			// 		});
			//
			// 		if ( !checked ) {
			// 			$('.importer-popup-option #import-all').attr('checked', 'checked');
			// 		}
			//
			// 	}
			// });

			// $('.importer-popup-option #import-all').on('change', function() {
			// 	if ( $(this).attr('checked') === 'checked' ) {
			// 		$('.importer-popup-option #import-page, .importer-popup-option #import-post, .importer-popup-option #import-portfolio, .importer-popup-option #import-content_block, .importer-popup-option #import-product').removeAttr('checked');
			// 	}
			// });
			//
			// $('.importer-popup-option #import-page, .importer-popup-option #import-post, .importer-popup-option #import-portfolio, .importer-popup-option #import-content_block, .importer-popup-option #import-product').on('change', function() {
			// 	if ( $(this).attr('checked') === 'checked' ) {
			// 		$('.importer-popup-option #import-all').removeAttr('checked');
			// 	}
			// });

			// $('.importer-popup-option #import-page, .importer-popup-option #import-post, .importer-popup-option #import-portfolio, .importer-popup-option #import-content_block, .importer-popup-option #import-product, .importer-popup-option #import-all').on('change', function() {
			// 	if ( $(this).attr('checked') === 'checked' ) {
			// 		$('.importer-popup-option #demo-content').attr('checked', 'checked');
			// 		$('#attachments').parent('label').removeClass('disabled');
			// 	} else {
			// 		var checked = false;
			// 		$(this).siblings().each(function() {
			// 			if ( $(this).attr('checked') === 'checked' ) {
			// 				checked = true;
			// 			}
			// 		});
			//
			// 		if ( !checked ) {
			// 			$('.importer-popup-option #demo-content').removeAttr('checked');
			// 			$('#attachments, #generate-resized-image-copies').removeAttr('checked').parent('label').addClass('disabled');
			// 		}
			// 	}
			// });

			$('.importer-popup-option #attachments').on('change', function() {
				if ( $(this).checked ) {
					$('#generate-resized-image-copies').removeAttr('checked').parent('label').addClass('disabled');
				} else {
					$('#generate-resized-image-copies').parent('label').removeClass('disabled');
				}
			});

			$('.importer-popup-option #theme-options, .importer-popup-option #demo-content').on('change', function() {
				if ( $('#theme-options').attr('checked') !== 'checked' && $('#demo-content').attr('checked') !== 'checked' ) {
					$popup.find('.importer-popup-import').addClass('disabled');
				} else {
					$popup.find('.importer-popup-import').removeClass('disabled');
				}
			});

			$popup.removeClass('progress');
			$popup.addClass('active');

			$('.importer-popup-import').unbind('click').on('click', function() {
				var r = confirm(message);

				if (r == false) return;

				if (reimport == true) {
					parent.removeClass('active imported').addClass('not-imported');
				}

				parent.removeClass('active imported');
				parent.find('.importer-button').hide();

				var data = jQuery(this).data();
				var imported_demo = false;

				data.action = "redux_wbc_importer";
				data.demo_import_id = parent.attr("data-demo-id");
				data.nonce = parent.attr("data-nonce");
				data.type = 'import-demo-content';
				data.wbc_import = (reimport == true) ? 're-importing' : ' ';

				data.options = {};
				$popup.find('.importer-popup-options input').each(function() {
				    data.options[$(this).attr('id')] = $(this).attr('checked') === 'checked';
                });

				$popup.addClass('progress');

				jQuery.post(ajaxurl, data, function(response) {
					parent.find('.wbc_image').css('opacity', '1');

					if (response.length > 0 && response.match(/Have fun!/gi)) {

						if (reimport == false) {
							parent.addClass('rendered').find('.wbc-importer-buttons .importer-button').removeClass('import-demo-data');

							var reImportButton = '<div id="wbc-importer-reimport" class="wbc-importer-buttons button-primary import-demo-data importer-button">Re-Import</div>';
							parent.find('.theme-actions .wbc-importer-buttons').append(reImportButton);
						}
						// parent.find('.importer-button:not(#wbc-importer-reimport)').removeClass('button-primary').text('Imported').show();
						// parent.find('.importer-button').attr('style', '');
						parent.addClass('imported active').removeClass('not-imported');
						imported_demo = true;
						wbc_show_progress(data);
						window.onbeforeunload = null;
						location.reload(true);
					} else {
						parent.find('.import-demo-data').show();

						if (reimport == true) {
							parent.find('.importer-button:not(#wbc-importer-reimport)').removeClass('button-primary').addClass('button').text('Imported').show();
							parent.find('.importer-button').attr('style', '');
							parent.addClass('imported active').removeClass('not-imported');
						}

						imported_demo = true;

						alert('There was an error importing demo content: \n\n' + response.replace(/(<([^>]+)>)/gi, ""));
					}
				});

				function progress_bar(){
					var progress = '<div class="wbc-progress-back"><div class="wbc-progress-bar"><span class="wbc-progress-count">0%</span></div>';
					$popup.find('.importer-popup-content').append(progress);
					setTimeout(function(){
						wbc_show_progress(data);
					},2000);
				}

				progress_bar();

				function wbc_show_progress( data ){

					data.action = "redux_wbc_importer_progress";

					if(imported_demo == false){

						jQuery.ajax({
							url: ajaxurl,
							data: data,
							success:function(response){
								var obj = jQuery.parseJSON(response);
								if (response.length > 0 && typeof obj == 'object'){
									var percentage = Math.floor((obj.imported_count / obj.total_post ) * 100);

									percentage = (percentage > 0) ? percentage - 1 : percentage;
									$popup.find('.wbc-progress-bar').css('width',percentage+"%");
									$popup.find('.wbc-progress-count').text(percentage+"%");
									setTimeout(function(){
										wbc_show_progress(data);
									},2000);
								}
							}
						});

					}else{
						// $popup.removeClass('progress');
						$popup.find('.wbc-progress-back').remove();
					}
				}
            });

            return false;
        });
    };
})(jQuery);