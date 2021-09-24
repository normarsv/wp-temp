<div class="wtbx_header_part header_button header_button_alt wtbx_search_field_wrapper">
	<div class="search_field">
		<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" name="s" class="search-input" placeholder="<?php echo esc_attr__('Search', 'scape'); ?>" />
			<?php if ( class_exists('SitePress') ) {
				do_action( 'wpml_add_language_form_field' );
			} ?>
			<i class="scape-ui-search"></i>
		</form>
	</div>
</div>