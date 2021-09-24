<?php
if ( !empty($header_style) && $header_style === 'm' ) {
	$header_skin = 'light';
}
$logo_retina    = wtbx_option_sub('h'.$header_style.'-logo-image-'.$header_skin, 'url');
$logo_width     = wtbx_option_sub('h'.$header_style.'-logo-size', 'width');
$logo_height    = wtbx_option_sub('h'.$header_style.'-logo-size', 'height');
$metadata       = wp_get_attachment_metadata(wtbx_option_sub('h'.$header_style.'-logo-image-'.$header_skin, 'id'));

empty($logo_width) && isset($metadata['width']) ? $logo_width = $metadata['width']/2 : null;
empty($logo_height) && isset($metadata['height']) ? $logo_height = $metadata['height']/2 : null;
$logo_width = intval($logo_width);
$logo_height = intval($logo_height);
$logo_default = $logo_retina !== '' ? wtbx_aq_resize( $logo_retina, $logo_width, $logo_height, null, true, false ) : $logo_retina;


$wtbx_fullscreen_slider = ( get_post_type() === 'page' && get_post_meta( get_the_id(), 'page-template-type-single', true ) === 'slider' ) ? true : false;

if ( $wtbx_fullscreen_slider ) {
    $header_skin_op = $header_skin === 'light' ? 'dark' : 'light';
	$logo_retina_op = wtbx_option_sub('h'.$header_style.'-logo-image-'.$header_skin_op, 'url');
	$metadata_op    = wp_get_attachment_metadata(wtbx_option_sub('h'.$header_style.'-logo-image-'.$header_skin_op, 'id'));
	$logo_width_op  = $logo_width;
	$logo_height_op  = $logo_height;
	empty($logo_width) && isset($metadata['width']) ? $logo_width_op = $metadata['width']/2 : null;
	empty($logo_height) && isset($metadata['height']) ? $logo_height_op = $metadata['height']/2 : null;
	$logo_default_op = $logo_retina_op !== '' ? wtbx_aq_resize( $logo_retina_op, $logo_width_op, $logo_height_op, null, true, false ) : $logo_retina_op;
}

$sticky_logo_retina = $sticky_logo_default = '';
if ( wtbx_option_levelled('sticky-style') !== 'disabled' ) {
    $sticky_header_skin = wtbx_option_levelled('sticky-skin');
	$sticky_logo_retina = wtbx_option_sub('h-sticky-logo-image-'.$sticky_header_skin, 'url');
	$sticky_logo_width = intval(wtbx_option_sub('h-sticky-logo-size', 'width'));
	$sticky_logo_height = intval(wtbx_option_sub('h-sticky-logo-size', 'height'));

    empty($sticky_logo_width) && isset($metadata['width']) ? $sticky_logo_width = $metadata['width']/2 : null;
    empty($sticky_logo_height) && isset($metadata['height']) ? $sticky_logo_height = $metadata['height']/2 : null;
	$sticky_logo_width = intval($sticky_logo_width);
	$sticky_logo_height = intval($sticky_logo_height);
	$sticky_logo_default = $sticky_logo_retina !== '' ? wtbx_aq_resize( $sticky_logo_retina, $sticky_logo_width, $sticky_logo_height, null, true, false ) : $logo_retina;
}
$has_sticky_logo = $sticky_logo_retina !== '' ? ' with_sticky_logo' : '';
?>


<div class="wtbx_header_logo_wrapper<?php echo esc_attr($has_sticky_logo); ?>">
	<a class="wtbx_header_logo" href="<?php echo esc_url( home_url('/') ); ?>">
		<?php

        if ( $logo_retina === '' ) : ?>
            <span class="wtbx_logo_title"><?php bloginfo('name') ?></span>
        <?php endif;

        // default logo
		if ( $logo_retina !== '' ) : ?>
			<img class="wtbx_logo_img" width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo esc_url($logo_retina); ?>" alt="<?php esc_attr(bloginfo()); ?>" />
		<?php endif;

		// logo for dynamic header
        if ( $wtbx_fullscreen_slider ) :
	        if ( $logo_retina !== '' && $logo_retina_op !== $logo_retina  ) : ?>
                <img class="wtbx_logo_img wtbx_logo_op" width="<?php echo esc_attr($logo_width_op); ?>" height="<?php echo esc_attr($logo_height_op); ?>" src="<?php echo esc_url($logo_retina_op); ?>" alt="<?php esc_attr(bloginfo()); ?>" />
	        <?php endif;
        endif;

		// sticky header logo
		if ( !in_array($header_style, array('m')) ) :
			if ( $sticky_logo_retina !== '' ) : ?>
				<img class="wtbx_logo_img wtbx_logo_sticky" width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo esc_url($sticky_logo_retina); ?>" alt="<?php esc_attr(bloginfo()); ?>" />
			<?php endif;
		endif; ?>
	</a>
</div>