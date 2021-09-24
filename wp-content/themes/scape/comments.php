<?php
/**
 * The template for displaying Comments
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<h3 class="comments-title">
		<span class="comments-title-inner">
			<?php printf( _n( '1&nbsp;Comment', '%1$s&nbsp;Comments', get_comments_number(), 'scape' ), number_format_i18n( get_comments_number() ) ); 		?>
		</span>
	</h3>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'walker'        => new WTBX_Walker_Comment,
				'style'         => 'ol',
				'short_ping'    => true,
				'avatar_size'   => 60,
				'format'        => 'html5',
                'max_depth'     => 10
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation clearfix" role="navigation">
		<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'scape' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'scape' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php endif; // have_comments() ?>


	<?php 
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		
		$form = array(
		'fields' => apply_filters( 'comment_form_default_fields', array(
			  'author' =>
				'<div class="comment-form-info-fields col_container"><div class="col_3 comment-form-author"><label for="author">' . esc_html__( 'Name', 'scape' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30"' . $aria_req . ' /></div>',

			  'email' =>
				'<div class="col_3 comment-form-email"><label for="email">' . esc_html__( 'Email', 'scape' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30"' . $aria_req . ' /></div>',

			  'url' =>
				'<div class="col_3 comment-form-url"><label for="url">' . esc_html__( 'Website', 'scape' ) . '</label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" size="30" /></div></div>',
			)
		),	
		'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'scape' ) . '</p>',
		'comment_notes_after'  => '',
		'class_submit'         => 'submit wtbx-button wtbx-button-primary button-md',
		'cancel_reply_link'    => '&#40;'. esc_html__( 'Cancel reply', 'scape') .'&#41;'
		);

		comment_form($form);
	?>

</div><!-- #comments -->