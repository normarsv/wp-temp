(function($){
	"use strict";

	$(document).ready( function($) {

		var post_format 	= '#post-formats-select .post-format, .editor-post-format .components-select-control__input',
			$body			= $('body'),
			metabox			= 'div[id^="metabox-"]',
			metabox_tmp		= 'div[id^="tmp-metabox"]',
			page_template	= $('#page_template');


		function togglePostBoxes(select) {
			var format = '';

			if (select.hasClass('post-format')) {
				format = select.attr('id');
			} else {
				format = 'post-format-' + select.val();
			}
			$(metabox + '.wtbx-visible').removeClass('wtbx-visible');
			$('#metabox-' + format).addClass('wtbx-visible');
		}

		function toggleTemplateBoxes() {
			$(metabox_tmp).each(function() {
				var box_template	= $(this).find('.wtbx-hidden').data('template');
				var	curr_template	= page_template.val();

				if ( box_template === curr_template ) {
					moveToTabs($(this));
					$(this).slideToggle().addClass('metabox-visible');
				} else {
					$(this).hide().removeClass('metabox-visible');
				}
			});
		}

		function moveToTabs($metabox) {
			if ( $metabox.find('.wtbx-tabnames').length && !$metabox.hasClass('wtbx-tabbed') ) {
				var $formTable	= $metabox.find('.cmb2-wrap.form-table'),
					$fieldList	= $formTable.children('.cmb-field-list'),
					$formRow	= $fieldList.children('.cmb-row'),
					tabs		= [],
					tabNames	= [];

				// get classNames and tab numbers
				$formRow.each(function() {
					var classes		= $(this)[0].classList,
						tabClass	= classes[classes.length-1],
						tabNum		= parseInt(tabClass.split('_')[1]);
					$(this).attr('data-tabnum', tabNum);
					tabs.push(tabNum);
				});

				if ( tabs.length > 0 ) {
					// keep only unique tab numbers
					tabs = tabs.filter(function(elem, index, self) {
						return index === self.indexOf(elem);
					});

					// append tab navigation
					$fieldList.prepend(	'<ul class="wtbx-meta-nav"></ul>');

					// get tab names
					tabNames = $fieldList.find('.wtbx-tabnames').data('tabnames').split(',');

					for ( var i=1; i<=tabs.length; i++ ) {

						// append tab navigation
						$fieldList.children('ul').append('<li><a id="wtbx-tab-tab_'+i+'" class="wtbx-meta-tab" data-metatab="wtbx-content-tab_'+i+'">'+tabNames[i-1]+'</a></li>');

						// append content wrappers
						$fieldList.append('<div class="wtbx-meta-content" data-metacontent="wtbx-content-tab_'+i+'" data-tabnum="'+i+'" style="display:none;"></div>');
					}

					$formRow.each(function() {
						var tabNum = $(this).data('tabnum');
						$(this).appendTo($fieldList.find('.wtbx-meta-content').filter('[data-tabnum="'+tabNum+'"]'));
					});

					$fieldList.find('.wtbx-meta-tab').eq(0).addClass('wtbx-tab-active');
					$fieldList.find('.wtbx-meta-content').eq(0).show();

					$fieldList.find('.wtbx-meta-tab').on('click', function() {
						if ( !$(this).hasClass('wtbx-tab-active') ) {
							$fieldList.find('.wtbx-meta-tab').removeClass('wtbx-tab-active');
							$(this).addClass('wtbx-tab-active');
						}
					});

					$metabox.addClass('wtbx-tabbed wtbx-visible').css('display', 'block');
				}
			}
		}

		// If post type = post
		if ( $body.hasClass('post-type-post') ) {
			setTimeout(function() {
				$(post_format).each(function() {
					if ( this.checked || $(this).hasClass('components-select-control__input') ) {
						togglePostBoxes($(this));
					}
				});
			});

			$(document).on('change', '#post-formats-select .post-format, .editor-post-format .components-select-control__input', function() {
				togglePostBoxes($(this));
			});
		} else if ( $body.hasClass('post-type-page') ) {
			toggleTemplateBoxes();
			page_template.change(function() {
				toggleTemplateBoxes();
			});
		}

		$(metabox).each(function() {
			moveToTabs($(this));
		});

		$(document).on('click', '.wtbx-meta-tab', function() {
			var tab = $(this).data('metatab');
			$(this).closest('.cmb-field-list').find('.wtbx-meta-content').hide();
			$(this).closest('.cmb-field-list').find('.wtbx-meta-content[data-metacontent="'+tab+'"]').show();
		});

		// Handle media remove in custom background field
		$('.cmb-type-wtbx-background').on('click', '.cmb2-remove-file-button', function() {
			var rel = $(this).attr('rel');
			$(this).closest('.cmb-type-wtbx-background').find( 'input[name="' + rel + '"]' ).val('');
		});

	});
})(jQuery);