<?php
global $post;
$dynamic = isset($navigation) && $navigation === '1' ? ' wtbx-dynamic' : '';
$pagination_skin = !empty($pagination_skin) ? $pagination_skin : 'light';
?>

<nav class="wtbx-pagination wtbx-skin-<?php echo esc_attr($pagination_skin . $dynamic); ?>">
	<div class="row-inner">
		<?php
            if ( empty($custom_query) ) { $custom_query = ''; }
		    echo wtbx_navigation($custom_query);
		?>
	</div>
