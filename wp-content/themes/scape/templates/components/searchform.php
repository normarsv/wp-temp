<?php
/**
 * The template for displaying the search form
 */
?>

<?php
$dropdown   = false;
if ( $post_types ) {
	foreach( $post_types as $key => $value ) {
		if ( $value  === '1' ) {
			$dropdown = true;
		} else {
			unset($post_types[$key]);
		}
	}
}
?>

<div class="wtbx_search_form_wrapper">
	<form role="search" method="get" id="wtbx_search_form" class="clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="<?php if ($dropdown) {echo 'wtbx-col-lg-7 wtbx-col-md-7 wtbx-col-sm-6';} else {echo 'wtbx-col-sm-12';} ?>">
			<div class="wtbx_search_field_wrapper wtbx_search_input_wrapper">
				<i class="scape-ui-search wtbx-click"></i>
				<input type="text" name="s" tabindex="1" class="wtbx_search_field wtbx_search_input" placeholder="<?php echo esc_attr__('Search', 'scape') ?>" />
                <?php if ( class_exists('SitePress') ) {
	                do_action( 'wpml_add_language_form_field' );
                } ?>
			</div>
		</div>
		<?php
		if ($dropdown) { ?>
			<div class="wtbx-col-lg-1 wtbx-col-md-1 wtbx-col-sm-1 wtbx-col-xs-2"><span class="wtbx_search_in"><?php esc_html_e('in', 'scape'); ?></span></div>
			<div class="wtbx-col-lg-4 wtbx-col-md-4 wtbx-col-sm-5 wtbx-col-xs-10">
				<div class="wtbx_search_field_wrapper wtbx_search_select_wrapper">
					<select tabindex="2" class="wtbx_search_field wtbx_for_custom_dropdown" name="post_type">
						<?php
							echo '<option value="any">'.esc_html__('Everywhere', 'scape').'</option>';
							foreach ( $post_types as $key => $value ) {
								$post_type = get_post_type_object($key);
								$post_type = $post_type->labels->name;
								echo '<option value="'.esc_attr($key).'">'.esc_html($post_type).'</option>';
							};
						?>
					</select>
					<div class="wtbx_search_field wtbx_search_select wtbx_with_custom_dropdown wtbx-click"></div>
				</div>
			</div>
		<?php }
		?>
		<div class="wtbx-col-sm-12">
			<input type="submit" tabindex="3" value="<?php echo esc_attr__('Search', 'scape'); ?>" class="wtbx-button wtbx-button-primary button-lg button-fw">
		</div>
	</form>
</div>