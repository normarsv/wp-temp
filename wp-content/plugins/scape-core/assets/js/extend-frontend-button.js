(function ( $ ) {
	window.InlineShortcodeView_vc_button_default = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_button_default.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			var align_small = params.align_small;
			if ( display === '' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			if ( align_small !== '' ) {
				this.$el.addClass('wtbx_block_' + align_small);
			} else {
				this.$el.removeClass('wtbx_block_tablet_landscape wtbx_block_tablet_portrait wtbx_block_mobile_landscape wtbx_block_mobile_portrait' );
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_button_link = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_button_link.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			var align_small = params.align_small;
			if ( display === '' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			if ( align_small !== '' ) {
				this.$el.addClass('wtbx_block_' + align_small);
			} else {
				this.$el.removeClass('wtbx_block_tablet_landscape wtbx_block_tablet_portrait wtbx_block_mobile_landscape wtbx_block_mobile_portrait' );
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_button_glowing = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_button_glowing.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			var align_small = params.align_small;
			if ( display === '' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			if ( align_small !== '' ) {
				this.$el.addClass('wtbx_block_' + align_small);
			} else {
				this.$el.removeClass('wtbx_block_tablet_landscape wtbx_block_tablet_portrait wtbx_block_mobile_landscape wtbx_block_mobile_portrait' );
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_button_filling = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_button_filling.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			var align_small = params.align_small;
			if ( display === '' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			if ( align_small !== '' ) {
				this.$el.addClass('wtbx_block_' + align_small);
			} else {
				this.$el.removeClass('wtbx_block_tablet_landscape wtbx_block_tablet_portrait wtbx_block_mobile_landscape wtbx_block_mobile_portrait' );
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_button_custom = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_button_custom.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			var align_small = params.align_small;
			if ( display === '' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			if ( align_small !== '' ) {
				this.$el.addClass('wtbx_block_' + align_small);
			} else {
				this.$el.removeClass('wtbx_block_tablet_landscape wtbx_block_tablet_portrait wtbx_block_mobile_landscape wtbx_block_mobile_portrait' );
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_button_arrow = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_button_arrow.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			var align_small = params.align_small;
			if ( display === '' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			if ( align_small !== '' ) {
				this.$el.addClass('wtbx_block_' + align_small);
			} else {
				this.$el.removeClass('wtbx_block_tablet_landscape wtbx_block_tablet_portrait wtbx_block_mobile_landscape wtbx_block_mobile_portrait' );
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_icon = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_icon.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			if ( display === 'wtbx_display_inline_block' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			return this;
		}
	} );

	window.InlineShortcodeView_vc_text_element = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_vc_text_element.__super__.render.call( this );
			var params = this.model.get( 'params' );
			var display = params.display;
			if ( display === 'wtbx_display_inline_block' ) {
				this.$el.addClass('wtbx_display_inline');
			} else {
				this.$el.removeClass('wtbx_display_inline');
			}
			return this;
		}
	} );
})( window.jQuery );