<?php
$gallery_nav = array(
	'nav'   => '<nav class="page-links wtbx-page-links wtbx-lightbox-nav clearfix wtbx-labels-appear wtbx-skin-light wtbx-transparent" role="navigation">
					<a title="'. esc_html__( 'Previous', 'scape' ) . '" class="wtbx-nav-button wtbx-nav-prev"><div class="page-links-prev"><div class="page-links-arrow"></div><span>' . esc_html__( 'Prev', 'scape' ) . '</span></div></a>
					<a title="' . esc_html__( 'Next', 'scape' ) . '" class="wtbx-nav-button wtbx-nav-next"><div class="page-links-next"><div class="page-links-arrow"></div><span>' . esc_html__( 'Next', 'scape' ) . '</span></div></a>
				</nav>'
);
wtbx_localize_main_js('wtbx_lightbox_nav', $gallery_nav);
wtbx_script_queue('plyr');
wp_enqueue_style('scape-plyr');
wtbx_script_queue('magnific-popup');
wtbx_script_queue('scape-lightbox', false);
wp_enqueue_style('scape-lightbox-style');
?>