<?php
$post_type      = get_post_type(wtbx_get_the_id());
$nav_layout     = wtbx_option($post_type.'-navigation-layout');

$previous       = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
$next           = get_adjacent_post( false, '', false );

$prev_label = $next_label = '';

$prev_label = $previous ? $previous->post_title : '';
$next_label = $next ? $next->post_title : '';

$prev_subtitle = $next_subtitle = '';

$obj = get_post_type_object( get_post_type() );

$prev_subtitle = !empty($previous) ? esc_html__('Previous ', 'scape') . ('post' === get_post_type() ? $obj->labels->singular_name : '') : '';
$next_subtitle = !empty($next) ? esc_html__('Next ', 'scape') . ('post' === get_post_type() ? $obj->labels->singular_name : '') : '';

$src_size           = 'medium';
$srcset_size        = 'full';
$prev_imgID         = !empty($previous) ? get_post_thumbnail_id( $previous->ID ) : '';
$next_imgID         = !empty($next) ? get_post_thumbnail_id( $next->ID ) : '';

$prev_thumb = $next_thumb = '';
$prev_thumb = $prev_imgID ? '<div class="wtbx-nav-thumb">' . wtbx_image_smart_crop($prev_imgID, $src_size, $srcset_size, '1:1', $prev_label, '', true) . '</div>' : '';
$next_thumb = $next_imgID ? '<div class="wtbx-nav-thumb">' . wtbx_image_smart_crop($next_imgID, $src_size, $srcset_size, '1:1', $prev_label, '', true) . '</div>' : '';

?>

<div class="wtbx-navigation-wrapper <?php echo esc_attr($post_type); ?>-nav-wrapper wtbx-page-nav-wrapper wtbx-layout-<?php echo esc_attr($nav_layout); ?>">
    <nav class="wtbx-navigation <?php echo esc_attr($post_type); ?>-nav wtbx-page-nav">
        <div class="wtbx-nav-inner <?php echo esc_attr($post_type); ?>-nav-inner">
            <div class="wtbx-overlay wtbx-overlay-prev"><?php previous_post_link('%link', ''); ?></div>
            <div class="wtbx-overlay wtbx-overlay-next"><?php next_post_link('%link', ''); ?></div>
            <ul class="wtbx-nav-controls clearfix">
                <li class="wtbx-nav-prev">
                    <div class="wtbx-nav-image">
		                <?php wtbx_image_smart_crop($prev_imgID, $src_size, $srcset_size, false, $prev_label) ?>
                    </div>
                    <div class="wtbx-nav-content">
                        <span class="wtbx-nav-meta wtbx-nav-meta-prev"><?php echo !empty($previous) ? esc_html__('Previous ', 'scape') . esc_html($obj->labels->singular_name) : '' ?></span>
                        <span class="wtbx-nav-title wtbx-nav-title-prev"><?php if ($previous) {echo esc_html($previous->post_title);} ?></span>
                    </div>
                    <div class="wtbx-gradient"></div>
                </li>
                <li class="wtbx-nav-next">
                    <div class="wtbx-nav-image">
		                <?php wtbx_image_smart_crop($next_imgID, $src_size, $srcset_size, false, $next_label) ?>
                    </div>
                    <div class="wtbx-nav-content">
                        <span class="wtbx-nav-meta wtbx-nav-meta-next"><?php echo !empty($next) ? esc_html__('next ', 'scape') . esc_html($obj->labels->singular_name) : '' ?></span>
                        <span class="wtbx-nav-title wtbx-nav-title-next"><?php if ($next) {echo esc_html($next->post_title);} ?></span>
                    </div>
                    <div class="wtbx-gradient"></div>
                </li>
            </ul>
        </div>
    </nav>
</div>