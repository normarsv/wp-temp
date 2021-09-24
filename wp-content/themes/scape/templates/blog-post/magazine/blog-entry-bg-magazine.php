<?php
$img_src    = $img_srcset = '';
$imgID      = get_post_thumbnail_id($postID);
$alt        = get_the_title();

if ($imgID) {
	$src_size = 'medium';
	?>
    <div class="post-magazine-overlay"></div>
    <?php wtbx_image_smart_crop($imgID, $src_size, $srcset_size, '16:10', $alt); ?>

<?php } ?>

