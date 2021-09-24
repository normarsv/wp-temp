<?php

$widget_area = 'h' . $id . '-' . $section . '-' . $area . '-area';

if ( is_active_sidebar( $widget_area ) ) : ?>
	<div id="<?php echo esc_attr($widget_area); ?>" class="wtbx_header_part wtbx_header_widget_area">
		<ul>
			<?php dynamic_sidebar( $widget_area ); ?>
		</ul>
	</div>
<?php endif; ?>