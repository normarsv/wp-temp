<?php
$self_hosted    = wp_get_attachment_url( get_post_meta($postID, 'portfolio-item-video-selfhosted_id', 1 ) );
$youtube        = get_post_meta($postID, 'portfolio-item-video-youtube', true);
$vimeo          = get_post_meta($postID, 'portfolio-item-video-vimeo', true);

if ( $self_hosted ) { wtbx_script_queue( 'plyr' ); wp_enqueue_style('scape-plyr'); }
?>

	<div class="portfolio-item-media portfolio-item-<?php echo esc_html($media); ?> row-inner clearfix">
		<div class="portfolio-video-wrapper wtbx-col-sm-12">

			<?php if ($self_hosted): ?>

				<div class="wtbx-media-selfhosted wtbx-video-selfhosted">
					<video controls>
						<source src="<?php echo esc_url($self_hosted); ?>" type="video/mp4">
					</video>
				</div>

			<?php elseif ($youtube): ?>
				<?php
				$consent_media = 'youtube';
				if ( !wtbx_has_consent($consent_media) ) { ?>
                    <div class="post-youtube video-embed video-embed-noconsent"><?php
					echo wtbx_noconsent_content($consent_media, get_post_meta($postID, 'portfolio-item-video-poster_id', 1 )); ?>
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
                    <div class="post-vimeo video-embed video-embed-noconsent"><?php
					echo wtbx_noconsent_content($consent_media, get_post_meta($postID, 'portfolio-item-video-poster_id', 1 )); ?>
                    </div><?php
				} else { ?>
                    <div class="post-vimeo video-embed">
                        <iframe src='//player.vimeo.com/video/<?php echo esc_attr($vimeo); ?>?portrait=0' width='640' height='360'></iframe>
                    </div>
				<?php }
				?>
			<?php endif; ?>

		</div>
	</div>
