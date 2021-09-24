<?php get_header();
$postID = $post->ID;

// media
$media_enable = get_post_meta($postID, 'portfolio-item-media-enable', true);
if ( $media_enable === '2' ) $media_enable = wtbx_option('portfolio-item-media-enable');

$no_media = ( $media_enable !== '1' ) ? ' no-media' : '';

// media layout
$media = get_post_meta($postID, 'portfolio-item-media', true);

// title
$title = get_post_meta($postID, 'portfolio-item-title-enable', true);
if ( $title === '2' ) $title = wtbx_option('portfolio-item-title-enable');

// content
$description = get_post_meta($postID, 'portfolio-item-description-enable', true);
if ( $description === '2' ) $description = wtbx_option('portfolio-item-description-enable');

// details
$details = get_post_meta($postID, 'portfolio-item-details-enable', true);
if ( $details === '2' ) $details = wtbx_option('portfolio-item-details-enable');

// like
$like = get_post_meta($postID, 'portfolio-item-like-enable', true);
if ( $like === '2' || $like === '' ) $like = wtbx_option('portfolio-item-like-enable');

// share
$share = get_post_meta($postID, 'portfolio-item-share-enable', true);
if ( $share === '2' || $share === '' ) { $share = wtbx_option('portfolio-share'); }
if ( $share === '2' || $share === '3' ) { wtbx_social_button(true); }

// content position
$content_position = get_post_meta($postID, 'portfolio-item-content-position', true);
if ( $content_position === 'inherit' ) $content_position = wtbx_option('portfolio-item-content-position');

// fallback for full-width media not supporting left of right content position
if ( in_array($media, array('carousel')) && in_array($content_position, array('left', 'left-sticky', 'right', 'right-sticky')) ) {
	$content_position = 'top-onecol';
}

// sticky sidebar
$sticky = in_array($content_position, array('left-sticky', 'right-sticky')) ? ' wtbx-sticky' : '';
if ( in_array($content_position, array('left-sticky', 'right-sticky')) ) { wtbx_script_queue('sticky-kit'); }

// attached images
$attachments    = get_post_meta( $postID, 'portfolio-item-add-images', 1 );

// set fallback ratio
$aspect     = 66.67;
$spacing    = '';

// set actual ratio
$ratio = get_post_meta( $postID, 'portfolio-item-images-ratio', true );
if (!$ratio)
	$ratio  = $aspect;

// portfolio details
$details_array = wtbx_option('portfolio-item-details');

// define image size
$src_size       = 'large';
$srcset_size    = 'full';

// colon
$colon = '';
if (  in_array($content_position, array('left', 'left-sticky', 'right', 'right-sticky')) ) {
	$colon = ':';
}

$wtbx_layout = wtbx_layout_settings();
$layout_js_styles = '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#sidebar{width:' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? esc_html($wtbx_layout['sidebar_width']) : '340') . 'px}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) ? '#content{width:calc(100% - ' . (!empty($wtbx_layout['sidebar_width']) && $wtbx_layout['sidebar_width'] !== -1 ? esc_html($wtbx_layout['sidebar_width']) : '340') . 'px)}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_font']) ? '#sidebar{'.esc_html(wtbx_font_styling($wtbx_layout['sidebar_font'])).'}' : '';
$layout_js_styles .= $wtbx_layout['sidebar'] !== 'no_sidebar' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) && !empty($wtbx_layout['sidebar_padding']) ? '#sidebar .page-sidebar{padding-top:' . esc_html($wtbx_layout['sidebar_padding']) . 'px}' : '';
$layout_js_styles .= !empty($wtbx_layout['content_limit']) ? '#container, .row-inner.row-content-width, .portfolio-item-media, .wtbx-like-wrapper {max-width:'.esc_html(intval($wtbx_layout['content_limit'])).'px}' : '';
if ( !empty($layout_js_styles) ) {
	wtbx_js_styles($layout_js_styles);
}
?>

<?php include(locate_template('templates/section-pagination-single-top.php')); ?>

    <?php if ( $media_enable === '1' && in_array($content_position, array('bottom-onecol', 'bottom-twocol' )) && in_array($media, array('carousel')) ) {
        // portfolio item media
        include(locate_template('templates/portfolio/single/portfolio-item-' . $media . '.php'));
    } ?>

    <div id="container" class="row-inner container-portfolio-item container-portfolio-<?php echo esc_attr($media), esc_attr($no_media); ?> <?php echo esc_attr($wtbx_layout['sidebar']), $wtbx_layout['fullwidth'], in_array($content_position, array('top-twocol', 'bottom-twocol')) ? ' container-twocol' : ''; ?>">

	    <?php if ( $media_enable === '1' && in_array($content_position, array('bottom-onecol', 'bottom-twocol' )) && in_array($media, array('slider', 'audio', 'video', 'gallery-vertical', 'gallery-grid', 'gallery-random' )) ) {
		    // portfolio item media
		    include(locate_template('templates/portfolio/single/portfolio-item-' . $media . '.php'));
	    } ?>

        <div class="wtbx-content-body wtbx-<?php echo get_post_type(); ?>-body clearfix">
            <div id="content" class="content-<?php echo esc_html($content_position); ?> clearfix row-inner">
                <div class="wtbx-width wtbx-large-7 wtbx-medium-8 wtbx-small-9 clearfix">
                    <?php if ( $media === 'custom' ) :
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                    else : ?>

                        <div class="portfolio-content-wrapper row-inner clearfix<?php echo esc_attr($sticky); ?>">

                            <?php if ( $title === '1' ) : ?>
                                <div class="portfolio-item-title"><h1><?php the_title(); ?></h1></div>
                            <?php endif; ?>

                            <?php // portfolio content ?>
                            <?php if ( $description === '1' || $details === '1' ) : ?>
                                <div class="portfolio-item-content clearfix<?php echo (($description === '1' && $details === '' ) || ($description === '' && $details === '1' ) ) ? ' onecol' : ''; ?>">

                                    <?php // portfolio item custom fields
                                    $has_details = false;
                                    if ( !empty($details_array) ) {
                                        foreach( $details_array as $id => $label ) {
                                            if ( isset($label) ) {
                                                if  ( get_post_meta($postID, 'portfolio-detail-' . $id, true) !== '' ) {
                                                    $has_details = true;
                                                }
                                            }
                                        }
                                    }

                                    if ( $details === '1' && $has_details ) : ?>
                                        <div class="portfolio-item-details">
                                            <p class="item-fields">
                                                <?php foreach( $details_array as $id => $label ) {
                                                    if ( isset($label) ) {
                                                        $field = get_post_meta($postID, 'portfolio-detail-' . $id, true);

                                                        if ( !empty($field) ) { ?>
                                                            <?php if ( class_exists('SitePress') && has_filter('wpml_translate_single_string') ) {
                                                                $label = apply_filters( 'wpml_translate_single_string', $label, 'scape', 'Portfolio detail - ' . $label);
                                                            } ?>
                                                            <span class="item-field">
                                                                <span class="item-label"><?php echo esc_html($label . $colon); ?></span>
                                                                <span class="item-value">
                                                                    <?php if ( strpos($field, '//') !== false ) {
                                                                        $link = substr($field, strpos($field, '//')+2 );
                                                                        echo '<a href="'.esc_url($field).'" title="'.esc_attr($link).'" target="_blank" ref="nofollow">'.$link.'</a>';
                                                                    } else {
                                                                        echo nl2br(esc_html($field));
                                                                    } ?>
                                                                </span>
                                                            </span>
                                                        <?php }

                                                    }
                                                } ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <?php // portfolio item description
                                    if ( $description === '1' ) :
                                        while (have_posts()) : the_post();
                                            $the_content = get_the_content();
                                            if ($the_content) : ?>
                                                <div class="portfolio-item-description">
                                                    <?php the_content(); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>

                        </div>

                        <?php if ( $media_enable === '1' && in_array($content_position, array('left', 'left-sticky', 'right', 'right-sticky' )) ) {
                            // portfolio item media
                            include(locate_template('templates/portfolio/single/portfolio-item-' . $media . '.php'));
                        } ?>

                    <?php endif; ?>

                </div>
            </div><!-- #content -->

        <?php if ( in_array( $wtbx_layout['sidebar'], array('sidebar_left', 'sidebar_left_sticky', 'sidebar_right', 'sidebar_right_sticky') ) && $wtbx_layout['sidebar_widgetarea'] !== 'none' && is_active_sidebar($wtbx_layout['sidebar_widgetarea']) )  : ?>
            <div id="sidebar" class="<?php echo esc_attr($wtbx_layout['sidebar_skin']), esc_attr($wtbx_layout['sidebar_sticky']); ?>">
                <div class="page-sidebar">
                    <div class="widget-area">
                        <?php dynamic_sidebar($wtbx_layout['sidebar_widgetarea']); ?>
                    </div>
                </div>
            </div><!-- #sidebar -->
        <?php endif; ?>
        </div>
    </div><!-- #container -->

<?php if ( $media_enable === '1' && in_array($content_position, array('top-onecol', 'top-twocol' )) && $media !== 'custom' ) :
	// portfolio item media
	include(locate_template('templates/portfolio/single/portfolio-item-' . $media . '.php'));
endif; ?>

<?php if ( $like === '1' && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
    <div class="wtbx-like-wrapper wtbx-page-like-wrapper">
        <div class="wtbx-like-inner">
            <?php echo wtbx_get_simple_likes_button( get_the_ID(), true ); ?>
        </div>
    </div>
<?php endif; ?>

<?php
$post_type      = get_post_type(wtbx_get_the_id());
$nav_layout     = wtbx_option($post_type.'-navigation-layout');
if ( $nav_layout === 'images' ) :
	include(locate_template('templates/section-pagination-single-images.php'));
else : ?>
    <div class="row-inner row-content-width">
        <div class="wtbx-width<?php echo in_array($content_position, array('bottom-onecol', 'bottom-twocol' )) ? ' wtbx-large-7 wtbx-medium-8 wtbx-small-9' : '' ?>"><?php
            include(locate_template('templates/section-pagination-single-bottom.php')); ?>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>