<?php

if ( wtbx_demo() ) { ?>
	<div class="wtbx_header_part header_button wtbx_header_icons_wrapper">
		<ul class="wtbx_header_icons clearfix">
			<li class="wtbx_social_icon">
				<a href="#" class="wtbx_h_text_color wtbx_h_text_color_hover header_button_height">
					<i class="scape-ui-facebook"></i>
				</a>
			</li>
			<li class="wtbx_social_icon">
				<a href="#" class="wtbx_h_text_color wtbx_h_text_color_hover header_button_height">
					<i class="scape-ui-linkedin"></i>
				</a>
			</li>
			<li class="wtbx_social_icon">
				<a href="#" class="wtbx_h_text_color wtbx_h_text_color_hover header_button_height">
					<i class="scape-ui-twitter"></i>
				</a>
			</li>
		</ul>
	</div>
<?php } else {
	$icons = wtbx_social_networks();

	if ( $icons ) {
		echo '<div class="wtbx_header_part header_button wtbx_header_icons_wrapper">';
		echo '<ul class="wtbx_header_icons clearfix">';

		foreach ( $icons as $icon => $props ) {

			$url = wtbx_option('social_'.$icon);

			if ( $url !== '' && isset($icons[$icon][1]) ) {
				echo '<li class="wtbx_social_icon">';
				echo '<a href="'.esc_url($url).'"' . ( wtbx_option('social_open_blank') === '1' ? ' target="_blank"' : '' ) . ' class="wtbx_h_text_color wtbx_h_text_color_hover header_button_height">';
				echo '<i class="'.esc_attr($icons[$icon][1]).'"></i>';
				echo '</a>';
				echo '</li>';
			}
		}
		echo '</ul>';
		echo '</div>';
	}
}