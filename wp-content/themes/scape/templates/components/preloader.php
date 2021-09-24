<?php

if (isset($preloader_type) && $preloader_type === 'global' ) {
	$preloader = wtbx_option_levelled('preloader-site-style');
	$type      = 'wtbx-preloader-global';

	if ( wtbx_demo() && sanitize_text_field($_GET['transition']) === 'random' ) {
		$preloader = wtbx_page_defaults()['global_site_preloader'];
	}

	if ( wtbx_demo() && get_the_ID() === 13  ) {
		$preloader = '17';
	}

	$type .= $preloader === '12' || $preloader === '13' || $preloader === '14' ? ' full-width' : '';
	$type .= $preloader === '14' ? ' full-height' : '';
} else {
	$preloader = wtbx_option('preloader-elements-style');
	$type      = 'wtbx-preloader-el';
}

?>

<div class="wtbx-preloader-wrapper <?php echo esc_attr($type); ?>">
	<div class="wtbx-preloader-container">

		<?php if ( $preloader === '1' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-1"></div>

		<?php } elseif ( $preloader === '2' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-2">
				<svg class="circular" viewBox="25 25 50 50">
					<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" stroke="<?php echo esc_attr(wtbx_option('color-main-accent')); ?>" stroke-linecap="round"/>
				</svg>
			</div>

		<?php } elseif ( $preloader === '3' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-3">
				<svg class="circular" viewBox="25 25 50 50">
					<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round"/>
				</svg>
			</div>

		<?php } elseif ( $preloader === '4' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-4"></div>

		<?php } elseif ( $preloader === '5' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-5">
				<div class="ldr-blk"></div>
				<div class="ldr-blk"></div>
				<div class="ldr-blk"></div>
				<div class="ldr-blk"></div>
			</div>

		<?php } elseif ( $preloader === '6' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-6">
				<div class="rect1"></div>
				<div class="rect2"></div>
				<div class="rect3"></div>
				<div class="rect4"></div>
				<div class="rect5"></div>
			</div>

		<?php } elseif ( $preloader === '7' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-7">
				<div class="sk-circle1 sk-circle"></div>
				<div class="sk-circle2 sk-circle"></div>
				<div class="sk-circle3 sk-circle"></div>
				<div class="sk-circle4 sk-circle"></div>
				<div class="sk-circle5 sk-circle"></div>
				<div class="sk-circle6 sk-circle"></div>
				<div class="sk-circle7 sk-circle"></div>
				<div class="sk-circle8 sk-circle"></div>
				<div class="sk-circle9 sk-circle"></div>
				<div class="sk-circle10 sk-circle"></div>
				<div class="sk-circle11 sk-circle"></div>
				<div class="sk-circle12 sk-circle"></div>
			</div>

		<?php } elseif ( $preloader === '8' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-8">
				<div class="pulsation"></div>
			</div>

		<?php } elseif ( $preloader === '9' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-9">
				<div class="ball ball-1"></div>
				<div class="ball ball-2"></div>
			</div>

		<?php } elseif ( $preloader === '10' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-10">
				<?php if ( wtbx_option('preloader-site-label') === 'text' ) : ?>
					<span><?php esc_html_e('Loading', 'scape'); ?></span>
				<?php elseif ( wtbx_option('preloader-site-label') === 'image' && wtbx_option_sub('preloader-site-image', 'url') !== '' ) :
					$image = wtbx_option_sub('preloader-site-image', 'url'); ?>
					<img class="wtbx-preloader-image" src="<?php echo esc_attr($image) ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="40" height="40" />
				<?php endif; ?>
				<div class="line"></div>
			</div>

		<?php } elseif ( $preloader === '11' ) { ?>

			<div class="wtbx-preloader wtbx-preloader-11">
				<?php if ( wtbx_option('preloader-site-label') === 'text' ) : ?>
					<span><?php esc_html_e('Loading', 'scape'); ?></span>
				<?php elseif ( wtbx_option('preloader-site-label') === 'image' && wtbx_option_sub('preloader-site-image', 'url') !== '' ) :
					$image = wtbx_option_sub('preloader-site-image', 'url'); ?>
					<img class="wtbx-preloader-image" src="<?php echo esc_attr($image) ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="40" height="40" />
				<?php endif; ?>
				<div class="circle"></div>
			</div>

		<?php } elseif ( $preloader === '12' ) { ?>

            <div class="wtbx-preloader wtbx-preloader-12"></div>

		<?php } elseif ( $preloader === '13' ) { ?>

            <div class="wtbx-preloader wtbx-preloader-13"></div>

		<?php } elseif ( $preloader === '14' ) { ?>

            <div class="wtbx-preloader wtbx-preloader-14"></div>

		<?php } elseif ( $preloader === '15' ) { ?>

        <div class="wtbx-preloader wtbx-preloader-15">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

		<?php } elseif ( $preloader === '16' ) { ?>

            <div class="wtbx-preloader wtbx-preloader-16">
                <?php
                if ( !empty(wtbx_option_sub('preloader-site-image', 'url')) ) {
	                $image = wtbx_option_sub('preloader-site-image', 'url');
	                $metadata = wp_get_attachment_metadata( wtbx_option_sub('preloader-site-image', 'id') );
	                ?>
                    <img class="wtbx-preloader-image" src="<?php echo esc_attr($image) ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="<?php echo $metadata['width'] / 2; ?>" height="<?php echo $metadata['height'] / 2; ?>" />
                <?php } ?>
            </div>

		<?php } elseif ( $preloader === '17' ) { ?>

            <div class="wtbx-preloader wtbx-preloader-17">
				<?php
				if ( !empty(wtbx_option_sub('preloader-site-image', 'url')) ) {
					$image = wtbx_option_sub('preloader-site-image', 'url');
					$metadata = wp_get_attachment_metadata( wtbx_option_sub('preloader-site-image', 'id') );
					?>
                    <img class="wtbx-preloader-image" src="<?php echo esc_attr($image) ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="<?php echo $metadata['width'] / 2; ?>" height="<?php echo $metadata['height'] / 2; ?>" />
				<?php } ?>
                <div id="wtbx-preloader-counter"></div>
            </div>

		<?php } ?>
	</div>
</div>