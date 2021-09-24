<div class="wtbx_header_part wtbx_header_login">
	<?php if (!is_user_logged_in()): ?>
		<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="wtbx_login_modal_trigger wtbx_header_link wtbx_h_text_color wtbx_h_text_color_hover" data-reveal-id="wtbx_login_modal">
			<i class="scape-ui-log-in"></i>
			<?php esc_html_e('Sign in', 'scape'); ?>
		</a>

		<div id="wtbx_login_modal" class="wtbx_login_modal">
			<div class="wtbx_login_modal_backdrop"></div>
			<div class="wtbx_login_modal_cont">
				<div class="wtbx_login_modal_popup">
					<div class="wtbx_login_modal_wrapper">
                        <div class="wtbx_login_modal_close"><i class="scape-ui-x"></i></div>
                        <div class="wtbx_login_modal_inner">
							<div class="wtbx_login_modal_signin">
								<?php
                                wtbx_login_form();
								$content_block = wtbx_option('login-form-content-after');
								if ( !empty($content_block) ) {
									$content_block = wtbx_get_translated_content_block($content_block);
									$s_ID = get_post($content_block);
									if ( isset($s_ID->post_content) ) {
										$content = $s_ID->post_content;
									} else {
										$content = '';
									}
									echo apply_filters('the_content', $content);
                                }
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else: ?>
		<a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" class="wtbx_header_link wtbx_h_text_color wtbx_h_text_color_hover">
			<i class="scape-ui-log-out"></i>
			<?php esc_html_e('Sign out', 'scape'); ?>
		</a>
	<?php endif; ?>
</div>