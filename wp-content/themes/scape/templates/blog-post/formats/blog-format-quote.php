<?php
$quote      = get_post_meta( $postID, 'post-quote-text', true );
$author     = get_post_meta( $postID, 'post-quote-author', true );

$imgID      = get_post_meta( $postID, 'post-quote-image_id', 1 );

$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );

$alt        = get_the_title();

if ( !empty($quote) && !empty($imgID) ) :
?>

<div class="post-media wtbx-reveal-cont wtbx_preloader_cont">
	<div class="post-media-inner">
		<div class="post-quote-wrapper">
			<figure class="post-quote-inner">
				<i class="scape-ui-quote post-quote-icon"></i>

				<?php if ($quote !== '') : ?>
					<div class="post-quote-text wtbx-text">"<?php echo esc_html($quote); ?>"</div>
				<?php endif; ?>

				<?php if ($author !== '') : ?>
					<div class="post-quote-author wtbx-text">- <?php echo esc_html($author); ?></div>
				<?php endif; ?>

				<?php if ( $imgID ) :
					wtbx_image_smart_crop($imgID, $src_size, $srcset_size, false, $alt);
				endif; ?>

			</figure>
		</div>
	</div>
</div>

<?php endif; ?>