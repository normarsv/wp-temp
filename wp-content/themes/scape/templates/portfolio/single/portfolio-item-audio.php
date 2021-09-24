<?php
$self_hosted    = wp_get_attachment_url( get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ) );
$embed          = get_post_meta($postID, 'portfolio-item-audio-embed', true );
$poster         = get_post_meta($postID, 'portfolio-item-audio-thumbnail_id', 1 );
$audio_title    = $self_hosted !== '' ? get_post(get_post_meta($postID, 'portfolio-item-audio-selfhosted_id', 1 ))->post_title : '';
$alt            = $audio_title !== '' ? $audio_title : get_the_title();

if ( $self_hosted ) { wtbx_script_queue( 'plyr' ); wp_enqueue_style('scape-plyr'); }
?>


<div class="portfolio-item-media portfolio-item-<?php echo esc_html($media); ?> row-inner clearfix">
	<div class="portfolio-audio-wrapper wtbx-col-sm-12">
		<?php if ( $self_hosted ) : ?>
			<?php if ( $poster ) : ?>
				<div class="wtbx-media-selfhosted wtbx-audio-selfhosted wtbx_preloader_cont">
					<?php if ( wtbx_option('site-smartimage') === '1' && wtbx_option('site-preloaders') === '1' ) {
						include(locate_template('templates/components/preloader.php'));
					} ?>
					<div class="wtbx-audio-selfhosted-inner wtbx-reveal-cont wtbx-element-reveal">
						<div class="audio-poster">
							<?php wtbx_image_smart_crop($poster, 'medium', 'full', '1:1', $alt); ?>
							<?php if ( $audio_title !== '' ) : ?>
								<div class="audio-title wtbx-text"><?php echo esc_html($audio_title); ?></div>
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
						<?php if ( $audio_title !== '' ) : ?>
							<div class="audio-title wtbx-text"><?php echo esc_html($audio_title); ?></div>
						<?php endif; ?>
						<audio controls>
							<source src="<?php echo esc_url($self_hosted); ?>" type="audio/mp3">
						</audio>
					</div>
				</div>
			<?php endif; ?>
		<?php elseif( $embed ):  ?>
            <div class="audio-embed">
				<?php
				$consent_media = 'other';
				if ( strpos($embed, 'soundcloud') !== false ) {
					$consent_media = 'soundcloud';
				} elseif ( strpos($embed, 'spotify') !== false ) {
					$consent_media = 'spotify';
				}

				if ( in_array($consent_media, array('soundcloud', 'spotify')) && !wtbx_has_consent($consent_media) ) {
					echo wtbx_noconsent_content($consent_media, $poster);
				} else {
					echo wp_kses( $embed, wtbx_allowed_iframe_html() );
				}
				?>
            </div>
		<?php endif; ?>
	</div>
</div>

