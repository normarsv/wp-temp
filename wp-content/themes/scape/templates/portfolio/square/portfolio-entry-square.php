<?php
$img_src    = $img_srcset = $title = $iframe_url = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();
$grid_style = 'square';

if ($imgID) {
	// get global aspect ratio
	$ratio = $aspect_ratio;

	// if empty - get it from image size
	if (!$ratio) {
		$metadata = wp_get_attachment_metadata( $imgID );
		$ratio = $metadata['width'] . ':' . $metadata['height'];
	}
}

// unique gallery ID
$lightbox_item_id = '';
if ( in_array($click_action, array('gallery_item', 'preview') )) {
	$lightbox_item_id = hexdec(substr(uniqid(), 6, 7));
}

// item media layout
$item_layout = get_post_meta($postID, 'portfolio-item-media', true);

?>

<article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-entry clearfix wtbx-masonry-entry wtbx-grid-entry wtbx-grid-anim-container '.$overlay_trigger); ?>>

	<?php if ( !empty($animation_style) ) {
		include(locate_template('templates/components/preloader.php'));
	} ?>

	<div class="portfolio-square-inner clearfix wtbx-element-reveal wtbx_appearance_animation wtbx-grid-anim-<?php echo esc_attr($animation_style); ?>">
		<div class="portfolio-square-box wtbx-entry-inner">

			<div class="portfolio-square-media wtbx-entry-media">
				<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt, 'portfolio-thumb-wrapper'); ?>
			</div>

            <?php // caption meta
            $data_caption_primary_escaped = $data_caption_secondary_escaped = '';
            if ( $click_action === 'gallery_all' || $click_action === 'gallery_item' ) {
	            if ( $caption_primary !== '' ) {
		            $data_caption_primary = wtbx_portfolio_meta_caption($caption_primary, $postID);

		            if ( $data_caption_primary !== '' ) {
			            $data_caption_primary_escaped = ' data-caption-primary="'.esc_attr($data_caption_primary).'"';
		            }
	            }
	            if ( $caption_secondary !== '' ) {
		            $data_caption_secondary = wtbx_portfolio_meta_caption($caption_secondary, $postID);

		            if ( $data_caption_secondary !== '' ) {
			            $data_caption_secondary_escaped = ' data-caption-secondary="'.esc_attr($data_caption_secondary).'"';
		            }
	            }
            } ?>

			<?php if ( $click_action === 'link' ) : ?>
				<a class="portfolio-entry-overlay portfolio-square-overlay" href="<?php the_permalink(); ?>" rel="bookmark">
					<div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
				</a>
			<?php elseif ( $click_action === 'gallery_all' ) :
				$item_layout = get_post_meta($postID, 'portfolio-item-media', true);
				$type_escaped = '';
				$share_url = '';
				if ( $item_layout === 'video' ) {
					$video_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-video-selfhosted', true));
					if ( $video_selfhosted !== '' ) {
						$url = $video_selfhosted;
						$type_escaped = ' data-video="1"';
					} elseif ( get_post_meta($postID, 'portfolio-item-video-youtube', true) ) {
						$url = '//www.youtube.com/watch?v=' . esc_attr(get_post_meta($postID, 'portfolio-item-video-youtube', true));
						$type_escaped = ' data-iframe="1"';
					} elseif ( get_post_meta($postID, 'portfolio-item-video-vimeo', true) ) {
						$url = '//vimeo.com/' . esc_attr(get_post_meta($postID, 'portfolio-item-video-vimeo', true));
						$type_escaped = ' data-iframe="1"';
					}
				} elseif ( $item_layout === 'audio' ) {
					$audio_embed = get_post_meta($postID, 'portfolio-item-audio-embed', true);
					$audio_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted', true));
					$url = '';

					if ( $audio_selfhosted !== '' ) {
						$url    = $audio_selfhosted;
						$title  = $audio_selfhosted !== '' ? get_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ))->post_title : '';
						$type_escaped   = ' data-audio="1"';
						$share_url = $url;
					} else if ( strpos($audio_embed, 'spotify') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
						$url    = '//embed.spotify.com/?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
						$type_escaped   = ' data-iframe="1"';
						$share_url = '//open.spotify.com/embed?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
					} elseif ( strpos($audio_embed, 'soundcloud') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
						$url    = '//w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true)) . '&auto_play=false&show_artwork=true&visual=true';
						$type_escaped   = ' data-iframe="1"';
						$share_url = '//w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
					} else {
						$url    = '';
					}

				} else {
					$url = wp_get_attachment_image_url( $imgID, 'full' );
					$share_url = $url;
				}

				if ( $share === 'link' ) {
					$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
				} elseif ( $share === 'media' ) {
					$data_share_escaped = ' data-share="'.esc_url($share_url).'"';
				} else {
					$data_share_escaped = '';
				}
				?>
                <a class="portfolio-entry-overlay portfolio-square-overlay wtbx-lightbox-item"
					<?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
	                <?php // This variable does not contain unescaped dynamic data - see lines: 70, 76, 79, 82, 92, 96, 100 ?>
                    <?php echo $type_escaped; ?>
                   href="<?php echo esc_url($url); ?>"
                   data-title="<?php echo esc_attr($title); ?>"
                   data-poster="<?php echo esc_attr( wp_get_attachment_image_url( get_post_meta($postID, 'portfolio-item-audio-thumbnail_id', 1 ), 'full' )); ?>"
                   data-thumbimage="<?php echo esc_url(wp_get_attachment_image_url( $imgID, 'medium' )); ?>"
	                <?php // These variables have been safely escaped on lines: 52, 59, 112, 114, 116 ?>
                    <?php echo $data_caption_primary_escaped, $data_caption_secondary_escaped, $data_share_escaped; ?>>
                    <div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
                </a>
			<?php elseif ( $click_action === 'gallery_item' ) :
				$type_escaped = '';
				// get portfolio item layout
				$attachments = $images = array();
				// get attached images
				if ( in_array($item_layout, array('slider', 'carousel', 'gallery-vertical', 'gallery-grid', 'gallery-masonry')) ) {
					$images = get_post_meta( $postID, 'portfolio-item-add-images', 1 );
					foreach ( (array) $images as $imgID => $imgURL ) {
						$attachments[] = array(
							'src'   => wp_get_attachment_image_url( $imgID, 'full' ),
							'thumb' => wp_get_attachment_image_url( $imgID, 'medium' )
						);
					}
				} else {
					$sections = get_post_meta( $postID, 'portfolio-item-section', true );
					if ( !empty($sections) ) {
						foreach ( (array) $sections as $key => $entry ) {
							if ( isset( $entry['portfolio-item-section-image_id'] ) ) {
								$imgID = $entry['portfolio-item-section-image_id'];
								$images[] = $imgID;
								$attachments[] = array(
									'src'   => wp_get_attachment_image_url( $imgID, 'full' ),
									'thumb' => wp_get_attachment_image_url( $imgID, 'medium' )
								);
							}
						}
					}
				}
				if (!empty($attachments)) :
					if ( $share === 'link' ) {
						$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
					} else {
						$data_share_escaped = '';
					}
                    ?>
					<div class="portfolio-entry-overlay portfolio-square-overlay wtbx-lightbox-item"
						<?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
                         data-dynamic="1"
                         data-dynamicel="<?php echo esc_attr(json_encode($attachments)); ?>"
                        <?php echo wtbx_lightbox_attributes(); ?>
                         data-id="<?php echo esc_attr($lightbox_item_id); ?>"
						<?php // These variables have been safely escaped on lines: 52, 59, 161, 163 ?>
                        <?php echo $data_caption_primary_escaped, $data_caption_secondary_escaped, $data_share_escaped; ?>>
						    <div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
					</div>
				<?php elseif ( $item_layout === 'video' ) :
					$video_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-video-selfhosted', true));
					if ( $video_selfhosted !== '' ) {
						$iframe_url = $video_selfhosted;
						$type_escaped = ' data-video="1"';
					} elseif ( get_post_meta($postID, 'portfolio-item-video-youtube', true) ) {
						$iframe_url = '//www.youtube.com/watch?v=' . esc_attr(get_post_meta($postID, 'portfolio-item-video-youtube', true));
						$type_escaped = ' data-iframe="1"';
					} elseif ( get_post_meta($postID, 'portfolio-item-video-vimeo', true) ) {
						$iframe_url = '//vimeo.com/' . esc_attr(get_post_meta($postID, 'portfolio-item-video-vimeo', true));
						$type_escaped = ' data-iframe="1"';
					}

					if ( $share === 'link' ) {
						$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
					} elseif ( $share === 'media' ) {
						$data_share_escaped = ' data-share="'.esc_url($iframe_url).'"';
					} else {
						$data_share_escaped = '';
					}
					?>

					<a class="portfolio-entry-overlay portfolio-square-overlay wtbx-lightbox-item"
						<?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
						<?php // This variable does not contain unescaped dynamic data - see lines: 132, 180, 183, 186 ?>
						<?php echo $type_escaped; ?>
                        data-dynamic="1"
                        data-dynamicel="<?php echo esc_attr($iframe_url); ?>"
						<?php // These variables have been safely escaped on lines: 52, 59, 190, 192, 194 ?>
						<?php echo $data_caption_primary_escaped, $data_caption_secondary_escaped, $data_share_escaped; ?>>
						<div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
					</a>

				<?php elseif ( $item_layout === 'audio' ) :
					$audio_embed = get_post_meta($postID, 'portfolio-item-audio-embed', true);
					$audio_selfhosted = wp_kses_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted', true));

					if ( $audio_selfhosted !== '' ) {
						$iframe_url = $audio_selfhosted;
						$title      = $audio_selfhosted !== '' ? get_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ))->post_title : '';
						$type_escaped = ' data-audio="1"';
					} else if ( strpos($audio_embed, 'spotify') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
						$iframe_url = '//embed.spotify.com/?uri=' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true));
						$type_escaped = ' data-iframe="1"';
					} elseif ( strpos($audio_embed, 'soundcloud') !== false && get_post_meta($postID, 'portfolio-item-audio-url', true) ) {
						$iframe_url = '//w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . esc_attr(get_post_meta($postID, 'portfolio-item-audio-url', true)) . '&auto_play=false&show_artwork=true&visual=true';
						$type_escaped = ' data-iframe="1"';
					} else {
						$iframe_url = '';
					}

					if ( $share === 'link' ) {
						$data_share_escaped = ' data-share="'.esc_attr(get_the_permalink()).'"';
					} elseif ( $share === 'media' ) {
						$data_share_escaped = ' data-share="'.esc_url($iframe_url).'"';
					} else {
						$data_share_escaped = '';
					}
					?>

					<a class="portfolio-entry-overlay portfolio-square-overlay wtbx-lightbox-item"
						<?php echo (wtbx_option('portfolio-archive-link') === '1' ? ' data-itemlink="'.esc_attr(get_the_permalink()).'"' : '') ?>
						<?php // This variable does not contain unescaped dynamic data - see lines: 216, 219, 222 ?>
						<?php echo $type_escaped; ?>
                        data-dynamic="1"
                        data-title="<?php echo esc_attr($title); ?>"
                        data-poster="<?php echo esc_attr( wp_get_attachment_image_url( get_post_meta($postID, 'portfolio-item-audio-thumbnail_id', 1 ), 'full' )); ?>"
                        data-dynamicel="<?php echo esc_attr($iframe_url); ?>"
						<?php // These variables have been safely escaped on lines: 52, 59, 228, 230, 232 ?>
						<?php echo $data_caption_primary_escaped, $data_caption_secondary_escaped, $data_share_escaped; ?>>
						<div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
					</a>

				<?php else : ?>
					<a class="portfolio-entry-overlay portfolio-square-overlay" href="<?php the_permalink(); ?>" rel="bookmark">
						<div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
					</a>
				<?php endif; ?>

			<?php elseif ( $click_action === 'preview' ) : ?>
				<div class="portfolio-entry-overlay portfolio-square-overlay wtbx-preview-trigger" data-postid="<?php echo esc_attr($postID); ?>">
					<div class="portfolio-entry-bg portfolio-square-bg"><?php echo wtbx_portfolio_overlay_content($overlay_content, $click_action, $item_layout); ?></div>
				</div>
			<?php endif; ?>

		</div>

		<?php if ( $meta_primary || $meta_secondary ) : ?>
			<div class="portfolio-entry-meta">
				<?php
					if ( $meta_primary ) echo wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary', strpos($meta_primary, '_link') !== false);
					if ( $meta_secondary ) echo wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary', strpos($meta_primary, '_link') !== false);
				?>
			</div>
		<?php endif; ?>
	</div>


</article>