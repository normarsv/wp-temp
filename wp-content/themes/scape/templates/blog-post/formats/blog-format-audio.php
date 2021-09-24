<?php
$custom_audio   = get_post_meta($postID, 'post-audio-external', true);
$self_hosted    = wp_get_attachment_url( get_post_meta($postID, 'post-audio-selfhosted_id', 1 ) );
$embed          = get_post_meta($postID, 'post-audio-embed', true );
$title          = $self_hosted !== '' ? get_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ))->post_title : '';

$title          = get_post_meta($postID, 'post-audio-title', true );
$thumbnail      = get_post_meta($postID, 'post-audio-thumbnail_id', 1 );
$alt            = get_the_title();

$preload        = is_single() ? 'auto' : 'metadata';

if ( $self_hosted ) { wtbx_script_queue( 'plyr' ); wp_enqueue_style('scape-plyr'); }

$audio_class = '';
if ( !empty($custom_audio) || !empty($self_hosted) ) {
	$audio_class = ' post-audio-selfhosted';
} elseif ( !empty($embed) ) {
    if ( strpos($embed, 'soundcloud') ) {
	    $audio_class = ' post-audio-embed post-audio-soundcloud';
    } elseif( strpos($embed, 'spotify') ) {
	    $audio_class = ' post-audio-embed post-audio-spotify';
    }
}

// define image size
$src_size       = 'medium';
$srcset_size    = 'full';

if ( !empty($custom_audio) || !empty($self_hosted) || !empty($embed) ) :
?>

<div class="post-media<?php echo esc_attr($audio_class); ?> wtbx-reveal-cont wtbx_preloader_cont">

	<?php if (empty($blog_type) || $blog_type !== 'masonry') :
		if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) :
			include(locate_template('templates/components/preloader.php'));
		endif; ?>
        <div class="post-media-inner wtbx_appearance_animation wtbx-element-reveal">

			<?php if ( $custom_audio ): ?>
                <div class="audioplayer-wrapper<?php echo !$thumbnail ? ' no-thumbnail' : null; ?>">

					<?php if ($thumbnail && $audio_thumbnail) : ?>
                        <div class="audio-thumbnail">
							<?php wtbx_image_smart_crop($thumbnail, $src_size, $srcset_size, false, $alt); ?>
                        </div>
					<?php endif; ?>

					<?php if ($title) : ?>
                        <h2 class="audio-title wtbx-text"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>

                    <audio class="audio" preload="<?php echo esc_attr($preload); ?>" controls="controls">
                        <source id="audio-post<?php the_ID();?>" src="<?php echo esc_url($custom_audio); ?> ">
                    </audio>
                </div>
			<?php endif; ?>

			<?php if( $self_hosted ): ?>

				<?php if ( $thumbnail ) : ?>
                    <div class="wtbx-media-selfhosted wtbx-audio-selfhosted">
                        <div class="wtbx-audio-selfhosted-inner">
                            <div class="audio-poster">
								<?php wtbx_image_smart_crop($thumbnail, 'medium', 'full', '1:1', $alt); ?>
								<?php if ( $title !== '' ) : ?>
                                    <div class="audio-title wtbx-text"><?php echo esc_html($title); ?></div>
								<?php endif; ?>
                            </div>
                            <audio controls>
                                <source src="<?php echo esc_url($self_hosted); ?>" type="audio/mp3">
                            </audio>
                        </div>
                    </div>
				<?php else : ?>
                    <div class="wtbx-media-selfhosted wtbx-audio-selfhosted audio-noposter">
                        <div class="wtbx-audio-selfhosted-inner">
							<?php if ( $title !== '' ) : ?>
                                <div class="audio-title wtbx-text"><?php echo esc_html($title); ?></div>
							<?php endif; ?>
                            <audio controls>
                                <source src="<?php echo esc_url($self_hosted); ?>" type="audio/mp3">
                            </audio>
                        </div>
                    </div>
				<?php endif; ?>

			<?php endif; ?>

			<?php if( $embed ):  ?>
                <div class="audio-embed">
                    <?php
                    $consent_media = 'other';
                    if ( strpos($embed, 'soundcloud') !== false ) {
	                    $consent_media = 'soundcloud';
                    } elseif ( strpos($embed, 'spotify') !== false ) {
	                    $consent_media = 'spotify';
                    }

                    if ( in_array($consent_media, array('soundcloud', 'spotify')) && !wtbx_has_consent($consent_media) ) {
	                    echo wtbx_noconsent_content($consent_media, $thumbnail);
                    } else {
	                    echo wp_kses( $embed, wtbx_allowed_iframe_html() );
                    }
                    ?>
                </div>
			<?php endif; ?>
        </div>
	<?php else :
		// get template aspect ratio
		$imgID      = get_post_thumbnail_id($postID);
		$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
		$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
		$lightbox_item_id = hexdec(substr(uniqid(), 6, 7));

		if ( $custom_audio ) :
			$inline_url = $custom_audio ?>
            <a href="#" class="post-media-wrapper wtbx-lightbox-item" data-audio="1" data-dynamic="1" data-poster="<?php echo esc_attr( wp_get_attachment_image_url( $thumbnail, 'full' )); ?>" data-dynamicel="<?php echo esc_attr($inline_url); ?>" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($lightbox_item_id); ?>">
				<?php wtbx_image_smart_img( $imgID, $src_size, $srcset_size, $alt, '' ); ?>
                <div class="post-media-overlay">
                    <i class="post-media-button post-media-play scape-ui-play"></i>
                </div>
            </a>
		<?php elseif ( $self_hosted ) :
			$inline_url = $self_hosted ?>
            <a href="#" class="post-media-wrapper wtbx-lightbox-item" data-audio="1" data-dynamic="1" data-poster="<?php echo esc_attr( wp_get_attachment_image_url( $thumbnail, 'full' )); ?>" data-dynamicel="<?php echo esc_attr($inline_url); ?>" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($lightbox_item_id); ?>">
				<?php wtbx_image_smart_img( $imgID, $src_size, $srcset_size, $alt, '' ); ?>
                <div class="post-media-overlay">
                    <i class="post-media-button post-media-play scape-ui-play"></i>
                </div>
            </a>
		<?php elseif ( $embed ) :
			if ( strpos($embed, 'spotify') !== false && get_post_meta($postID, 'post-audio-uri', true) ) {
				$consent_media = 'spotify';
				$iframe_url = '//embed.spotify.com/?uri=' . get_post_meta($postID, 'post-audio-uri', true);
			} elseif ( strpos($embed, 'soundcloud') !== false && get_post_meta($postID, 'post-audio-uri', true) ) {
				$consent_media = 'soundcloud';
				$iframe_url = '//w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . get_post_meta($postID, 'post-audio-uri', true) . '&auto_play=false&show_artwork=true&visual=true';
			} else {
				$iframe_url = $consent_media = '';
			}
			?>
            <a href="#" class="post-media-wrapper wtbx-lightbox-item" data-iframe="1" data-dynamic="1" data-dynamicel="<?php echo esc_attr($iframe_url); ?>" <?php echo wtbx_lightbox_attributes(); ?> data-id="<?php echo esc_attr($lightbox_item_id); ?>"<?php echo (!wtbx_has_consent($consent_media) ? ' data-poster="' . wp_get_attachment_url( $thumbnail ) . '"' : '') ?>>
				<?php wtbx_image_smart_img( $imgID, $src_size, $srcset_size, $alt, '' ); ?>
                <div class="post-media-overlay">
                    <i class="post-media-button post-media-play scape-ui-play"></i>
                </div>
            </a>
		<?php endif; ?>

	<?php endif; ?>

</div>

<?php endif; ?>