<?php
$youtube        = get_post_meta($postID, 'post-video-youtube', true);
$vimeo          = get_post_meta($postID, 'post-video-vimeo', true);
$self_hosted    = wp_get_attachment_url( get_post_meta($postID, 'post-video-selfhosted_id', 1 ) );
$poster         = wp_get_attachment_url( get_post_meta($postID, 'post-video-poster_id', 1 ) );

$video_meta     = wp_get_attachment_metadata( get_post_meta($postID, 'post-video-selfhosted_id', 1 ) );
$image_meta     = wp_get_attachment_metadata( get_post_meta($postID, 'post-video-poster_id', 1 ) );

$alt            = get_the_title();

if ( $self_hosted ) { wtbx_script_queue( 'plyr' ); wp_enqueue_style('scape-plyr'); }

if ( isset($video_meta['width']) && isset($video_meta['height']) && isset($image_meta['width']) && isset($image_meta['height']) ) {
	$image_height   = $image_meta['width'] / $video_meta['width'] * $video_meta['height'];
	$poster         = wtbx_aq_resize($poster, $image_meta['width'], $image_height, null, true, false);
}

if ( !empty($youtube) || !empty($vimeo) || !empty($self_hosted) ) :
?>

<div class="post-media wtbx-reveal-cont wtbx_preloader_cont">
		<?php if (empty($blog_type) || $blog_type !== 'masonry') :
			if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
				include(locate_template('templates/components/preloader.php'));
			endif; ?>
			<div class="post-media-inner wtbx-element-reveal">

				<?php if ($youtube): ?>
						<?php
						$consent_media = 'youtube';
						if ( !wtbx_has_consent($consent_media) ) { ?>
                            <div class="post-youtube video-embed video-embed-noconsent"><?php
							    echo wtbx_noconsent_content($consent_media, get_post_meta($postID, 'post-video-poster_id', 1 )); ?>
                            </div><?php
                        } else { ?>
                            <div class="post-youtube video-embed">
                                <iframe width="640" height="360" src="https://www.youtube.com/embed/<?php echo esc_attr($youtube); ?>?wmode=opaque" class="youtube-video" allowfullscreen></iframe>
                            </div>
						<?php }
						?>
				<?php endif;
				if ( $vimeo ) : ?>
						<?php
						$consent_media = 'vimeo';
						if ( !wtbx_has_consent($consent_media) ) { ?>
                            <div class="post-youtube video-embed video-embed-noconsent"><?php
							echo wtbx_noconsent_content($consent_media, get_post_meta($postID, 'post-video-poster_id', 1 )); ?>
                            </div><?php
						} else { ?>
                            <div class="post-vimeo video-embed">
                                <iframe src='//player.vimeo.com/video/<?php echo esc_attr($vimeo); ?>?portrait=0' width='640' height='360'></iframe>
                            </div>
						<?php }
						?>
				<?php endif;

				if ($self_hosted): ?>
					<div class="wtbx-media-selfhosted wtbx-video-selfhosted">
						<video id="post-video-<?php the_ID();?>" class="post-sh-video" poster="<?php echo esc_attr($poster); ?>" controls>
							<source src="<?php echo esc_url($self_hosted); ?>" type="video/mp4">
						</video>
					</div>
				<?php endif; ?>
			</div>
		<?php else :
			// get template aspect ratio
			$imgID      = get_post_thumbnail_id($postID);
			$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
			$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
			$lightbox_item_id = hexdec(substr(uniqid(), 6, 7));
			if ( $youtube && get_post_meta($postID, 'post-video-youtube', true) ) :
				$consent_media = 'youtube';
				$iframe_url = '//www.youtube.com/watch?v=' . get_post_meta($postID, 'post-video-youtube', true); ?>
				<a href="#" class="post-media-wrapper wtbx-lightbox-item" data-iframe="1" data-dynamic="1" data-dynamicel="<?php echo esc_attr($iframe_url); ?>" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($lightbox_item_id); ?>"<?php echo (!wtbx_has_consent($consent_media) ? ' data-poster="' . $poster . '"' : '') ?>>
					<?php wtbx_image_smart_crop( $imgID, $src_size, $srcset_size, $alt, '' ); ?>
					<div class="post-media-overlay">
						<i class="post-media-button post-media-play scape-ui-play"></i>
					</div>
				</a>

			<?php elseif ( $vimeo && get_post_meta($postID, 'post-video-vimeo', true) ) :
				$consent_media = 'vimeo';
				$iframe_url = '//vimeo.com/' . get_post_meta($postID, 'post-video-vimeo', true); ?>
				<a href="#" class="post-media-wrapper wtbx-lightbox-item" data-iframe="1" data-dynamic="1" data-dynamicel="<?php echo esc_attr($iframe_url); ?>" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($lightbox_item_id); ?>"<?php echo (!wtbx_has_consent($consent_media) ? ' data-poster="' . $poster . '"' : '') ?>>
					<?php wtbx_image_smart_crop( $imgID, $src_size, $srcset_size, $alt, '' ); ?>
					<div class="post-media-overlay">
						<i class="post-media-button post-media-play scape-ui-play"></i>
					</div>
				</a>
			<?php elseif ( $self_hosted ) :
				$inline_url = $self_hosted; ?>
				<a href="#" class="post-media-wrapper wtbx-lightbox-item" data-video="1" data-dynamic="1" data-dynamicel="<?php echo esc_attr($inline_url); ?>" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($lightbox_item_id); ?>">
					<?php wtbx_image_smart_crop( $imgID, $src_size, $srcset_size, $alt, '' ); ?>
					<div class="post-media-overlay">
						<i class="post-media-button post-media-play scape-ui-play"></i>
					</div>
				</a>
			<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>