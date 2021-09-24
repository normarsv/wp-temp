<?php
$post_author = get_post_field( 'post_author', get_the_id() );
?>

<?php wtbx_js_styles($header_styles); ?>

<div id="page-header" class="<?php echo esc_attr($page_header_classes); ?> wtbx_parallax_wrapper" data-layout="<?php echo esc_attr($layout_number); ?>" data-decoration="<?php echo esc_attr($decoration_layout); ?>" data-fullscroll="<?php echo esc_attr($scroll_full); ?>" data-skin="<?php echo esc_attr($hero_skin); ?>">
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

	<div class="page-header-inner page-header-post page-header-post-<?php echo esc_attr(wtbx_option('header-section-post')); ?> clearfix<?php if ($parallax_class === ' wtbx_parallax_mousemove') { echo ' wtbx-parallax-capture'; } ?>">
        <div class="page-header-content">
            <div class="row-inner clearfix">

                <?php if ( wtbx_option('header-section-post') === 'custom_1' ) : ?>
                    <div class="wtbx-col-sm-12">

	                    <?php if ( wtbx_option('post-header-categories-enable') === '1' ) : ?>
                            <div class="hero-meta-categories">
                                <div class="category-list"><?php the_category( ' ' ); ?></div>
                            </div>
	                    <?php endif; ?>

                        <h1 class="entry-title"><?php the_title(); ?></h1>

                    </div>

                <?php elseif ( wtbx_option('header-section-post') === 'custom_2' ) : ?>

                    <div class="wtbx-col-sm-12">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </div>

                <?php endif; ?>

            </div>
        </div>

		<?php if ( wtbx_option('header-section-post') === 'custom_1' ) : ?>

			<?php if ( wtbx_option('post-header-categories-enable') === '1' || wtbx_option('post-header-comments-enable') === '1' || wtbx_option('post-header-like-enable') === '1' ) : ?>
                <div class="header-section-meta">

	                <?php if ( wtbx_option('post-header-author-name-enable') === '1' ) : ?>
                        <span class="hero-meta-author">
                            <a href="<?php echo esc_url(get_author_posts_url( $post_author )); ?>"
                               title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'scape' ), the_author_meta( 'display_name', $post_author ) ); ?>"><?php the_author_meta( 'display_name', $post_author ); ?></a>
		                </span>
	                <?php endif; ?>

	                <?php if ( wtbx_option('post-header-date-enable') === '1' ) : ?>
                        <span class="hero-meta-date">
                           <?php echo esc_html__( ' on ', 'scape' ); ?> <span><?php echo get_the_date(); ?></span>
                        </span>
	                <?php endif; ?>

                </div>
			<?php endif; ?>

		<?php elseif ( wtbx_option('header-section-post') === 'custom_2' ) : ?>

            <div class="post-header-section-meta">

                <div class="row-inner clearfix">

                    <div class="wtbx-col-xs-6">
						<?php if ( wtbx_option('post-header-author-image-enable') ) : ?>
                            <a class="author-image" href="<?php echo esc_url( get_author_posts_url( $post_author ) ); ?>">
								<?php echo get_avatar( $post_author, 50 ); ?>
                            </a>
						<?php endif; ?>

						<?php if ( wtbx_option('post-header-author-name-enable') === '1' ) : ?>

                            <div class="author-content">
								<?php if ( wtbx_option('post-author-name-enable') === '1' ) : ?>
                                    <a class="author-name" href="<?php echo esc_url( get_author_posts_url( $post_author ) ); ?>"><?php the_author_meta( 'display_name', $post_author ); ?> </a>
								<?php endif; ?>

								<?php if ( wtbx_option('post-header-author-social-enable') === '1' ) :
									$contactmethods = wtbx_social_networks();
									$contacts       = array();
									$are_contacts = false;

									if ( $contactmethods ) {
										foreach ( $contactmethods as $contact => $props ) {
											$contacts[$contact] = get_the_author_meta($contact, $post_author);
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
						<?php endif; ?>
                    </div>

                    <div class="wtbx-col-xs-6">
                        <div class="header-section-meta">

							<?php if ( wtbx_option('post-header-categories-enable') === '1' ) : ?>
                                <div class="meta-categories">
                                    <div class="category-list"><?php the_category(' '); ?></div>
                                </div>
							<?php endif; ?>

							<?php if ( wtbx_option('post-header-date-enable') === '1' ) : ?>
                                <div class="meta-date header-section-meta-block">
                                    <span class="meta-date"><?php echo get_the_date(); ?></span>
                                </div>
							<?php endif; ?>

							<?php if ( wtbx_option('post-header-like-enable') === '1' && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
                                <div class="header-section-meta-block">
                                    <div class="post-like">
										<?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
                                    </div>
                                </div>
							<?php endif; ?>

							<?php if ( wtbx_option('post-header-comments-enable') === '1' ) : ?>
                                <div class="header-section-meta-block">
                                    <i class="scape-ui-comment"></i>
                                    <span><?php echo get_comments_number(); ?></span>
                                </div>
							<?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>

		<?php endif; ?>

	</div>

	<?php
	if ( $decoration_layout !== '' ) {
		wtbx_decoration($decoration_layout, $decoration_color);
	}
	?>
</div>