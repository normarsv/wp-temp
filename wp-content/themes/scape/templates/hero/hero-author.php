<?php if ( class_exists('SCAPE_Core_Extend') ) {
	wtbx_js_styles($header_styles);
} ?>

<div id="page-header" class="<?php echo esc_attr($page_header_classes); ?> page-header-author-wrapper wtbx_parallax_wrapper" data-layout="<?php echo esc_attr($layout_number); ?>" data-decoration="<?php echo esc_attr($decoration_layout); ?>" data-fullscroll="<?php echo esc_attr($scroll_full); ?>" data-skin="<?php echo esc_attr($hero_skin); ?>">
	<div class="page-header-bg-wrapper">
		<div class="page-header-bg wtbx-element-reveal wtbx-reveal-cont<?php echo esc_attr($parallax_cont); ?>">
			<div class="page-header-image-wrapper">
				<div class="page-header-image wtbx-entry-media <?php echo esc_attr($parallax_class); ?>" data-parallax-strength="<?php echo esc_attr($parallax_str); ?>">
					<?php if ( $imgID !== '' ) {
						wtbx_image_smart_bg($imgID, 'large', 'full', false, wtbx_get_alt_text($imgID));
					} ?>
				</div>
			</div>
			<div class="page-header-shadow"></div>
			<div class="page-header-overlay"></div>
		</div>
	</div>

	<div class="page-header-inner page-header-author<?php if ($parallax_class === ' wtbx_parallax_mousemove') { echo ' wtbx-parallax-capture'; } ?>">
        <div class="page-header-content clearfix">

            <div class="row-inner clearfix">
                <div class="wtbx-col-sm-12">

                    <?php if ( wtbx_option('post-author-image-enable') === '1' ) : ?>
                        <div class="author-image">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 90 ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="author-title">
                        <?php if ( wtbx_option('post-author-name-enable') === '1' ) : ?>
                            <h1 class="author-name"><?php the_author_meta( 'display_name' ); ?> </h1>
                        <?php endif; ?>
                        <?php if ( wtbx_option('post-author-position-enable') === '1' ) : ?>
                            <?php $info = get_the_author_meta( 'author_info' );
                            if ($info) : ?>
                                <div class="author-position"><?php echo esc_html($info); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ( wtbx_option('post-author-description-enable') === '1' ) : ?>
                        <?php $description =  get_the_author_meta( 'description' );
                        if ($description) : ?>
                            <div class="author-info"><?php the_author_meta( 'description' ); ?></div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( wtbx_option('post-author-social-enable') === '1' ) :
                        $contactmethods = wtbx_social_networks();
                        $contacts       = array();
	                    $are_contacts = false;

                        if ( $contactmethods ) {
	                        foreach ( $contactmethods as $contact => $props ) {
		                        $contacts[$contact] = get_the_author_meta($contact);
	                        }
	                        unset($contacts['Author Info']);

	                        $are_contacts = (array_filter($contacts)) ? true : false;

	                        if ($are_contacts) : ?><div class="author-contacts clearfix"><?php endif;
                                foreach($contacts as $id => $link) {
                                    $title = $contactmethods[$id][0];
                                    $icon = $contactmethods[$id][1];
                                    if ($link) {
                                        echo '<a href="'.esc_url($link) .'"' . ( wtbx_option('social_open_blank') === '1' ? ' target="_blank"' : '' ) . ' class="author-contact-link author-'.esc_attr(str_replace(' ', '',  strtolower($title))).'" aria-label="'.esc_attr($title).'"><i class="'.esc_attr($icon).'"></i></a>';
                                    }
                                }
	                        if ($are_contacts) : ?></div><?php endif;
                        }

                    endif; ?>

                </div>
            </div>
        </div>

		<?php wtbx_scroll_down_button($scrolldown, $scrolldown_skin); ?>

	</div>

	<?php
	if ( $decoration_layout !== '' ) {
		wtbx_decoration($decoration_layout, $decoration_color);
	}
	?>
</div>