<?php
$arrows     = get_post_meta($postID, 'portfolio-item-arrows', true);
$bullets    = get_post_meta($postID, 'portfolio-item-bullets', true);
$ratio      = get_post_meta($postID, 'portfolio-item-images-ratio', true);

if ( $attachments != '' ) : ?>

	<div class="portfolio-item-media portfolio-item-<?php echo esc_html($media); ?>">
		<?php
			$carousel_images = array();
			foreach ( (array) $attachments as $imgID => $imgURL ) {
				$carousel_images[] = $imgID;
			}
			$carousel_images = implode(',', $carousel_images);

			echo do_shortcode('[vc_image_carousel images="'.esc_attr($carousel_images).'" aspect_ratio="'.esc_attr($ratio).'" style="centered" radius="3px" navigation_skin="'.esc_attr($arrows).'" slider_pagination="style_2" pagination_skin="'.esc_attr($bullets).'" autoheight="false" slider_speed="20" autoplay="0" stop_hover="true" lazy="" preloader="" pagination="style_2"]');
		?>
	</div>

<?php endif; ?>