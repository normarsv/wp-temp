<?php
/**
 * The template for displaying search forms
 */
?>
<div class="searchform-wrapper">
	<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" name="s" class="search-input" placeholder="<?php esc_attr_e('Search...', 'scape') ?>" />
		<?php if ( class_exists('SitePress') ) {
			do_action( 'wpml_add_language_form_field' );
		} ?>
		<input type="submit" class="search-submit" value="<?php esc_attr_e('Search', 'scape') ?>" />
	</form>
</div>