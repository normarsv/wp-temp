(function($) {

	tinymce.PluginManager.add('wtbx_mce_button', function( editor, url ) {
		editor.addButton('wtbx_mce_button', {
			text: 'Font weight',
			icon: false,
			type: 'listbox',
			classes: 'fixed-width wtbx-weight',
			'values': [
				{text: '100', value: '100'},
				{text: '200', value: '200'},
				{text: '300', value: '300'},
				{text: '400', value: '400'},
				{text: '500', value: '500'},
				{text: '600', value: '600'},
				{text: '700', value: '700'},
				{text: '800', value: '800'},
				{text: '900', value: '900'}
			],
			onselect: function() {
				editor.focus();
				var text = editor.selection.getContent({'format': 'html'});
				if (text && text.length > 0) {
					editor.execCommand('mceInsertContent', false, '<span class="wtbx-weight" style="font-weight:'+this.value()+'">'+text+'</span>');
				}
			}
		});

		editor.on('click', function() {
			var selection	= editor.selection.getStart({'format': 'html'}),
				weight		= $(selection).css('font-weight');
			$('.mce-wtbx-weight').find('.mce-txt').html(weight);
		});
	});




})(jQuery);