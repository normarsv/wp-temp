<?php
/**
 * The general template for displaying post content
 */

global $post;
$postID = $post->ID;

// get post format
$post_format = get_post_format();
$format = $post_format ?  '-' . $post_format : '';

// enable audio thumbnail
$audio_thumbnail = true;

// define image size
$src_size       = 'large';
$srcset_size    = 'full';

// Media
if ( !empty($format) && wtbx_option_sub('post-hide-media', $post_format) !== '1' ) {
    if ( file_exists(locate_template('templates/blog-post/formats/blog-format' . $format . '.php')) ) {
        include(locate_template('templates/blog-post/formats/blog-format' . $format . '.php'));
    }
}

// Title
get_template_part( 'templates/blog-post/blog-entry-title' );
// Meta
get_template_part( 'templates/blog-post/blog-entry-meta' );
// Content
get_template_part( 'templates/blog-post/single/blog-entry-content-single' );
// Tags
get_template_part( 'templates/blog-post/blog-entry-tags-n-social' );

// Like button
if ( wtbx_option('post-like-enable') === '1' && class_exists('SCAPE_Core_Extend') && wtbx_has_consent('like-system') ) : ?>
	<div class="wtbx-like-wrapper wtbx-page-like-wrapper">
		<div class="wtbx-like-inner">
			<?php echo wtbx_get_simple_likes_button( get_the_ID(), true ); ?>
		</div>
	</div>
<?php endif;

// Author info
get_template_part( 'templates/blog-post/blog-entry-author' );

?>