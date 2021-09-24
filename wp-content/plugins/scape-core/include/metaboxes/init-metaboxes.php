<?php

require_once( 'assets/init.php');
require_once( 'custom-metabox.php');
require_once( 'boxes-global.php');
require_once( 'boxes-post.php');
require_once( 'boxes-portfolio.php');
require_once( 'boxes-product.php');
require_once( 'boxes-conditionals.php');

function wtbx_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'CMB2' ) ) {

		/**
		 * Gets a number of terms and displays them as options
		 * @param  string       $taxonomy Taxonomy terms to retrieve. Default is category.
		 * @param  string|array $args     Optional. get_terms optional arguments
		 * @return array                  An array of options that matches the CMB2 options array
		 */
		function cmb2_get_term_options( $taxonomy = 'category', $args = array() ) {

			$args['taxonomy'] = $taxonomy;
			// $defaults = array( 'taxonomy' => 'category' );
			$args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

			$taxonomy = $args['taxonomy'];

			$terms = (array) get_terms( $taxonomy, $args );

			// Initate an empty array
			$term_options = array();
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$term_options[ $term->term_id ] = $term->name;
				}
			}

			return $term_options;
		}

		// Metaboxes scripts
		if (is_edit_page()) {
			wp_register_script( 'metaboxes', WTBX_PLUGIN_URL . '/include/metaboxes/js/metaboxes.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'metaboxes' );
		}

		add_action( 'admin_head', 'wtbx_backend_css', 11 );
		function wtbx_backend_css() { ?>
			<?php
				if ( is_edit_page() ) {
					global $post;
					$id = $post->ID;

					if ( (int) $id === (int) get_option('page_for_posts') ) { ?>
						<style type="text/css" media="screen">#metabox-global-single {display: none;}</style>
					<?php }
				}
			?>

			<style type="text/css" media="screen">div[id^="tmp-metabox"], div[id^="metabox-post"], #metabox-global-single, .wtbx-hidden {display: none;} #metabox-global-single.wtbx-visible, div[id^="tmp-metabox"].wtbx-visible, div[id^="metabox-post"].wtbx-visible {display: block !important;} </style>
		<?php }
	}
}
add_action( 'init', 'wtbx_initialize_cmb_meta_boxes', 9959 );