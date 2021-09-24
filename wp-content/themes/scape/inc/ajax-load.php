<?php
/*
*	---------------------------------------------------------------------
*	Ajax Load Post and Portfolio entries
*	---------------------------------------------------------------------
*/


function wtbx_preview_product() {
	global $woocommerce;
	$productID              = sanitize_text_field($_GET['id']);
	$args['post_type']      = 'product';
	$args['p']              = $productID;
	$args['paged']          = 0;
	$args['posts_per_page'] = 1;

	$src_size = 'full';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$product = wc_get_product($productID);

			// get product item layout
			$attachments = array();

			// get attached images
			$attachments[0] = get_post_thumbnail_id();
			$attachment_ids = $product->get_gallery_image_ids();
			foreach ( $attachment_ids as $key => $value ) {
				$attachments[$key + 1] = $value;
			}

			?>

			<div class="wtbx-product-preview" data-product="<?php echo esc_attr($productID); ?>">
				<div class="wtbx-product-preview-cont">
					<div class="wtbx-product-preview-inner">

						<?php if ( !empty($attachments) ) : ?>

							<div class="wtbx-preview-gallery wtbx-slider-gallery gallery-skin-dark">
								<?php foreach ( $attachments as $key => $imgID ) {
									if ( isset($attachments[$key]) && wp_get_attachment_image_srcset( $imgID, 'full') !== false ) : ?>
										<div class="preview-slide-wrapper wtbx_preloader_cont">
											<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
												include(locate_template('templates/components/preloader.php'));
											endif; ?>
											<div class="preview-slide-inner wtbx-reveal-cont wtbx-element-reveal">
												<?php wtbx_image_smart_crop( $imgID, $src_size, 'full', $ratio = '5:6', get_the_title()); ?>
											</div>
										</div>
									<?php endif; ?>
								<?php } ?>
							</div>

						<?php else : ?>

							<div class="wtbx-preview-gallery slick-initialized wtbx-gallery-empty">
								<div class="wtbx-no-images"><?php esc_html_e('No images found', 'scape'); ?></div>
							</div>

						<?php endif; ?>

						<div class="wtbx-preview-content">
							<div class="product-content-wrapper clearfix">
								<div class="summary entry-summary">
									<?php
									woocommerce_template_single_rating();
									woocommerce_template_single_title();
									woocommerce_template_single_price();
									woocommerce_template_single_excerpt();
									woocommerce_template_single_add_to_cart();
									?>
								</div><!-- .summary -->
							</div>
						</div>

					</div>
				</div>
			</div>

		<?php endwhile; ?>
	<?php endif;?>



	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_preview_product', 'wtbx_preview_product');
add_action('wp_ajax_nopriv_preview_product', 'wtbx_preview_product');



// Lazy load portfolio entries - masonry
function wtbx_loadmore_portfolio_masonry() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$overlay_content        = sanitize_text_field($_POST['overlay_content']);
	$meta_primary           = sanitize_text_field($_POST['meta_primary']);
	$meta_secondary         = sanitize_text_field($_POST['meta_secondary']);
	$alignment              = sanitize_text_field($_POST['alignment']);
	$overlay_trigger        = sanitize_text_field($_POST['overlay_trigger']);
	$like                   = sanitize_text_field($_POST['like']);
	$overlay_mobile         = sanitize_text_field($_POST['overlay_mobile']);
	$caption_primary        = sanitize_text_field($_POST['caption_primary']);
	$caption_secondary      = sanitize_text_field($_POST['caption_secondary']);
	$share                  = sanitize_text_field($_POST['share']);
	$click_action           = sanitize_text_field($_POST['click_action']);
	$overlay_idle                          = sanitize_text_field($_POST['overlay_idle']);
	$overlay_hover                         = sanitize_text_field($_POST['overlay_hover']);
	$meta_primary_hover                    = sanitize_text_field($_POST['meta_primary_hover']);
	$meta_secondary_hover                  = sanitize_text_field($_POST['meta_secondary_hover']);
	$action_button_link                    = sanitize_text_field($_POST['action_button_link']);
	$action_button_gallery_all             = sanitize_text_field($_POST['action_button_gallery_all']);
	$action_button_gallery_item            = sanitize_text_field($_POST['action_button_gallery_item']);

	$lightbox_item_id = in_array($click_action, array('gallery_item', 'preview')) ? $lightbox_item_id = hexdec(substr(uniqid(), 6, 7)) : '';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/portfolio/masonry/portfolio-entry-masonry.php'));
		endwhile; ?>
	<?php endif;?>

	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_portfolio_masonry', 'wtbx_loadmore_portfolio_masonry');
add_action('wp_ajax_nopriv_loadmore_portfolio_masonry', 'wtbx_loadmore_portfolio_masonry');



// Lazy load portfolio entries - metro
function wtbx_loadmore_portfolio_metro() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$animation_style        = sanitize_text_field($_POST['animation']);
	$overlay_content        = sanitize_text_field($_POST['overlay_content']);
	$meta_primary           = sanitize_text_field($_POST['meta_primary']);
	$meta_secondary         = sanitize_text_field($_POST['meta_secondary']);
	$alignment              = sanitize_text_field($_POST['alignment']);
	$overlay_trigger        = sanitize_text_field($_POST['overlay_trigger']);
	$grid_layout            = sanitize_text_field($_POST['grid_layout']);
	$like                   = sanitize_text_field($_POST['like']);
	$overlay_mobile         = sanitize_text_field($_POST['overlay_mobile']);
	$caption_primary        = sanitize_text_field($_POST['caption_primary']);
	$caption_secondary      = sanitize_text_field($_POST['caption_secondary']);
	$share                  = sanitize_text_field($_POST['share']);
	$click_action           = sanitize_text_field($_POST['click_action']);
	$overlay_idle                          = sanitize_text_field($_POST['overlay_idle']);
	$overlay_hover                         = sanitize_text_field($_POST['overlay_hover']);
	$meta_primary_hover                    = sanitize_text_field($_POST['meta_primary_hover']);
	$meta_secondary_hover                  = sanitize_text_field($_POST['meta_secondary_hover']);
	$action_button_link                    = sanitize_text_field($_POST['action_button_link']);
	$action_button_gallery_all             = sanitize_text_field($_POST['action_button_gallery_all']);
	$action_button_gallery_item            = sanitize_text_field($_POST['action_button_gallery_item']);

	$lightbox_item_id = in_array($click_action, array('gallery_item', 'preview')) ? $lightbox_item_id = hexdec(substr(uniqid(), 6, 7)) : '';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	// custom grid layout
	if ( strpos($grid_layout, 'layout') !== false ) {
		$custom_layout = true;
		$layout_obj = wtbx_vc_grid_layouts($grid_layout);
		$tiles = $layout_obj['tiles'];
	}

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			$current_post = intval(sanitize_text_field($_POST['page'])) * $args['posts_per_page'] + $q->current_post;
			$counter = (int) floor($current_post / $tiles);

			include(locate_template('templates/portfolio/metro/portfolio-entry-metro.php'));
			if ($custom_layout) {
				if ( $current_post >= ($tiles-1) && ($current_post+1) % ($tiles) === 0 ) {
					$counter++;
				}
			}

		endwhile; ?>
	<?php endif;?>

	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_portfolio_metro', 'wtbx_loadmore_portfolio_metro');
add_action('wp_ajax_nopriv_loadmore_portfolio_metro', 'wtbx_loadmore_portfolio_metro');



// Lazy load portfolio entries - boxed
function wtbx_loadmore_portfolio_boxed() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$overlay_content        = sanitize_text_field($_POST['overlay_content']);
	$meta_primary           = sanitize_text_field($_POST['meta_primary']);
	$meta_secondary         = sanitize_text_field($_POST['meta_secondary']);
	$overlay_trigger        = sanitize_text_field($_POST['overlay_trigger']);
	$like                   = sanitize_text_field($_POST['like']);
	$overlay_mobile         = sanitize_text_field($_POST['overlay_mobile']);
	$caption_primary        = sanitize_text_field($_POST['caption_primary']);
	$caption_secondary      = sanitize_text_field($_POST['caption_secondary']);
	$share                  = sanitize_text_field($_POST['share']);
	$click_action           = sanitize_text_field($_POST['click_action']);
	$overlay_idle                          = sanitize_text_field($_POST['overlay_idle']);
	$overlay_hover                         = sanitize_text_field($_POST['overlay_hover']);
	$meta_primary_hover                    = sanitize_text_field($_POST['meta_primary_hover']);
	$meta_secondary_hover                  = sanitize_text_field($_POST['meta_secondary_hover']);
	$action_button_link                    = sanitize_text_field($_POST['action_button_link']);
	$action_button_gallery_all             = sanitize_text_field($_POST['action_button_gallery_all']);
	$action_button_gallery_item            = sanitize_text_field($_POST['action_button_gallery_item']);

	$lightbox_item_id = in_array($click_action, array('gallery_item', 'preview')) ? $lightbox_item_id = hexdec(substr(uniqid(), 6, 7)) : '';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/portfolio/boxed/portfolio-entry-boxed.php'));
		endwhile; ?>
	<?php endif;?>

	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_portfolio_boxed', 'wtbx_loadmore_portfolio_boxed');
add_action('wp_ajax_nopriv_loadmore_portfolio_boxed', 'wtbx_loadmore_portfolio_boxed');



// Lazy load portfolio entries - square
function wtbx_loadmore_portfolio_square() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$portfolio_overlay      = sanitize_text_field($_POST['portfolio_overlay']);
	$border                 = sanitize_text_field($_POST['border']);
	$overlay_content        = sanitize_text_field($_POST['overlay_content']);
	$meta_primary           = sanitize_text_field($_POST['meta_primary']);
	$meta_secondary         = sanitize_text_field($_POST['meta_secondary']);
	$alignment              = sanitize_text_field($_POST['alignment']);
	$overlay_trigger        = sanitize_text_field($_POST['overlay_trigger']);
	$like                   = sanitize_text_field($_POST['like']);
	$overlay_mobile         = sanitize_text_field($_POST['overlay_mobile']);
	$caption_primary        = sanitize_text_field($_POST['caption_primary']);
	$caption_secondary      = sanitize_text_field($_POST['caption_secondary']);
	$share                  = sanitize_text_field($_POST['share']);
	$click_action           = sanitize_text_field($_POST['click_action']);

	$lightbox_item_id = in_array($click_action, array('gallery_item', 'preview')) ? $lightbox_item_id = hexdec(substr(uniqid(), 6, 7)) : '';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/portfolio/square/portfolio-entry-square.php'));
		endwhile; ?>
	<?php endif;?>

	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_portfolio_square', 'wtbx_loadmore_portfolio_square');
add_action('wp_ajax_nopriv_loadmore_portfolio_square', 'wtbx_loadmore_portfolio_square');



// Lazy load portfolio entries - tiles
function wtbx_loadmore_portfolio_tiles() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$portfolio_overlay      = stripslashes(sanitize_text_field($_POST['portfolio_overlay']));
	$border                 = sanitize_text_field($_POST['border']);
	$overlay_content        = sanitize_text_field($_POST['overlay_content']);
	$meta_primary           = sanitize_text_field($_POST['meta_primary']);
	$meta_secondary         = sanitize_text_field($_POST['meta_secondary']);
	$alignment              = sanitize_text_field($_POST['alignment']);
	$overlay_trigger        = sanitize_text_field($_POST['overlay_trigger']);
	$like                   = sanitize_text_field($_POST['like']);
	$overlay_mobile         = sanitize_text_field($_POST['overlay_mobile']);
	$caption_primary        = sanitize_text_field($_POST['caption_primary']);
	$caption_secondary      = sanitize_text_field($_POST['caption_secondary']);
	$share                  = sanitize_text_field($_POST['share']);
	$like                   = sanitize_text_field($_POST['like']);
	$click_action           = sanitize_text_field($_POST['click_action']);

	$lightbox_item_id = in_array($click_action, array('gallery_item', 'preview')) ? $lightbox_item_id = hexdec(substr(uniqid(), 6, 7)) : '';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/portfolio/tiles/portfolio-entry-tiles.php'));
		endwhile; ?>
	<?php endif;?>

	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_portfolio_tiles', 'wtbx_loadmore_portfolio_tiles');
add_action('wp_ajax_nopriv_loadmore_portfolio_tiles', 'wtbx_loadmore_portfolio_tiles');



// Lazy load portfolio entries - overlap
function wtbx_loadmore_portfolio_overlap() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$meta_primary           = sanitize_text_field($_POST['meta_primary']);
	$meta_secondary         = sanitize_text_field($_POST['meta_secondary']);
	$excerpt_length         = sanitize_text_field($_POST['excerpt_length']);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/portfolio/overlap/portfolio-entry-overlap.php'));
		endwhile; ?>
	<?php endif;?>

	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_portfolio_overlap', 'wtbx_loadmore_portfolio_overlap');
add_action('wp_ajax_nopriv_loadmore_portfolio_overlap', 'wtbx_loadmore_portfolio_overlap');



// Lazy load posts - masonry
function wtbx_loadmore_blog_masonry () {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$animation_style        = sanitize_text_field($_POST['animation']);
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$preview                = sanitize_text_field($_POST['preview']);
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$blog_type              = 'masonry';

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/masonry/blog-entry-masonry.php'));
		endwhile; ?>
	<?php endif;?>



	<?php
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_masonry', 'wtbx_loadmore_blog_masonry');
add_action('wp_ajax_nopriv_loadmore_blog_masonry', 'wtbx_loadmore_blog_masonry');



// Lazy load posts - metro
function wtbx_loadmore_blog_metro() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$animation_style        = sanitize_text_field($_POST['animation']);
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$post_overlay           = stripslashes(sanitize_text_field($_POST['post_overlay']));
	$grid_layout            = sanitize_text_field($_POST['grid_layout']);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	// custom grid layout
	if ( strpos($grid_layout, 'layout') !== false ) {
		$custom_layout = true;
		$layout_obj = wtbx_vc_grid_layouts($grid_layout);
		$tiles = $layout_obj['tiles'];
		$counter = (int) floor((intval(sanitize_text_field($_POST['page'])) * $args['posts_per_page'] + $q->current_post) / $tiles);
	}

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();

			$postID = get_the_ID();
			$current_post = intval(sanitize_text_field($_POST['page'])) * $args['posts_per_page'] + $q->current_post;

			// preview media ratio
			include(locate_template('templates/blog-post/metro/blog-entry-metro.php'));
			if ($custom_layout) {
				if ( $current_post >= ($tiles-1) && ($current_post+1) % ($tiles) === 0 ) {
					$counter++;
				}
			}

		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_metro', 'wtbx_loadmore_blog_metro');
add_action('wp_ajax_nopriv_loadmore_blog_metro', 'wtbx_loadmore_blog_metro');



// Lazy load posts - sidebyside
function wtbx_loadmore_blog_sbs() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$preview                = sanitize_text_field($_POST['preview']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$media_width            = sanitize_text_field($_POST['media_width']);
	$aspect_ratio           = sanitize_text_field($_POST['aspect_ratio']);
	$audio_thumbnail        = true;
	$blog_type              = 'sbs';

	if (!$media_width) $media_width = ' post-col-6';
	!$media_width ? $media_width = '6' : null;
	$content_width = (12 - $media_width);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/sidebyside/blog-entry-sbs.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_sbs', 'wtbx_loadmore_blog_sbs');
add_action('wp_ajax_nopriv_loadmore_blog_sbs', 'wtbx_loadmore_blog_sbs');



// Lazy load posts - column
function wtbx_loadmore_blog_column() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$preview                = sanitize_text_field($_POST['preview']);
	$animation_style        = sanitize_text_field($_POST['animation']);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/column/blog-entry-column.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_column', 'wtbx_loadmore_blog_column');
add_action('wp_ajax_nopriv_loadmore_blog_column', 'wtbx_loadmore_blog_column');



// Lazy load posts - magazine
function wtbx_loadmore_blog_magazine() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$animation_style        = sanitize_text_field($_POST['animation']);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/magazine/blog-entry-magazine.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_magazine', 'wtbx_loadmore_blog_magazine');
add_action('wp_ajax_nopriv_loadmore_blog_magazine', 'wtbx_loadmore_blog_magazine');



// Lazy load posts - boxed
function wtbx_loadmore_blog_boxed() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$animation_style        = sanitize_text_field($_POST['animation']);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/boxed/blog-entry-boxed.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_boxed', 'wtbx_loadmore_blog_boxed');
add_action('wp_ajax_nopriv_loadmore_blog_boxed', 'wtbx_loadmore_blog_boxed');



// Lazy load posts - minimal
function wtbx_loadmore_blog_minimal() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$columns_minimal        = sanitize_text_field($_POST['columns_minimal']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$reading_time           = sanitize_text_field($_POST['reading_time']);

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/minimal/blog-entry-minimal.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_minimal', 'wtbx_loadmore_blog_minimal');
add_action('wp_ajax_nopriv_loadmore_blog_minimal', 'wtbx_loadmore_blog_minimal');



// Lazy load posts - default
function wtbx_loadmore_blog_default() {
	$args                   = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$preview                = sanitize_text_field($_POST['preview']);
	$animation_style        = sanitize_text_field($_POST['animation']);
	$audio_thumbnail        = true;

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/default/blog-entry-default.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_default', 'wtbx_loadmore_blog_default');
add_action('wp_ajax_nopriv_loadmore_blog_default', 'wtbx_loadmore_blog_default');



// Lazy load posts - carousel
function wtbx_loadmore_blog_carousel() {
	$args = unserialize(stripslashes(sanitize_text_field($_POST['query'])));
	$args['paged']          = intval(sanitize_text_field($_POST['page'])) + 1;
	$args['post_status']    = 'publish';
	$excerpt_length         = sanitize_text_field($_POST['excerpt']);
	$aspect_ratio           = sanitize_text_field($_POST['ascpect_ratio']);
	$meta_array             = isset($_POST['meta_array']) ? explode(',', sanitize_text_field(implode(',', $_POST['meta_array']))) : array();
	$meta_class             = wtbx_add_space_before(sanitize_text_field($_POST['meta_class']));

	check_ajax_referer( 'wtbx-grid-nonce', 'wpnonce' );

	$q = new WP_Query($args);

	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			$postID = get_the_ID();
			include(locate_template('templates/blog-post/carousel/blog-entry-carousel.php'));
		endwhile;
	endif;
	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_loadmore_blog_carousel', 'wtbx_loadmore_blog_carousel');
add_action('wp_ajax_nopriv_loadmore_blog_carousel', 'wtbx_loadmore_blog_carousel');



function wtbx_update_wishlist_count() {
	$items_in_wishlist = 'false';
	if ( class_exists('YITH_WCWL') ) {
		global $yith_wcwl;
		$items_in_wishlist = $yith_wcwl->count_products();
	}
	echo esc_html($items_in_wishlist);
	wp_die();
}

add_action('wp_ajax_update_wishlist_count', 'wtbx_update_wishlist_count');
add_action('wp_ajax_nopriv_update_wishlist_count', 'wtbx_update_wishlist_count');



function wtbx_update_bg() {
	$imageID    = sanitize_text_field($_POST['image']);
	$color      = sanitize_text_field($_POST['color']);
	$array      = array();

	if ( !empty($imageID) ) {
		$array['image'] = wp_get_attachment_image_src($imageID, 'thumbnail')[0];
	}

	if ( !empty($color) ) {
		$array['color'] = wtbx_vc_color_styles_bg(json_encode($color));
	}

	print_r(json_encode($array));
	wp_die();

}


add_action('wp_ajax_wtbx_update_bg', 'wtbx_update_bg');
add_action('wp_ajax_nopriv_wtbx_update_bg', 'wtbx_update_bg');



function wtbx_get_images() {
	$images = sanitize_text_field($_POST['images']);
	$array  = array();

	if ( isset($images) ) {
		$images = explode(',', $images);
		foreach ( $images as $image ) {
			$array[] = wp_get_attachment_image_src($image, 'thumbnail')[0];
		}
	}

	echo implode(',', $array);
	wp_die();

}

add_action('wp_ajax_wtbx_get_images', 'wtbx_get_images');
add_action('wp_ajax_nopriv_wtbx_get_images', 'wtbx_get_images');