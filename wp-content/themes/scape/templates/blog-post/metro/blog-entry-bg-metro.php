<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();

if ($imgID) { ?>
	<div class="post-media wtbx-entry-media">
		<div class="post-metro-overlay"></div>
		<?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, false, $alt); ?>
	</div>
<?php } ?>

