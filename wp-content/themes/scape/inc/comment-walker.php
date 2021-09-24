<?php
/** COMMENTS WALKER */
class WTBX_Walker_Comment extends Walker_Comment {

	// init classwide variables
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	/** CONSTRUCTOR
	 * You'll have to use this if you plan to get to the top of the comments list, as
	 * start_lvl() only goes as high as 1 deep nested comments */
	function __construct() { ?>

	<?php }

	/** START_LVL
	 * Starts the list before the CHILD elements are added. Unlike most of the walkers,
	 * the start_lvl function means the start of a nested comment. It applies to the first
	 * new level under the comments that are not replies. Also, it appear that, by default,
	 * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
function start_lvl( &$output, $depth = 0, $args = array() ) {
	$GLOBALS['comment_depth'] = $depth + 1; ?>

	<ul class="children">
<?php }

	/** END_LVL
	 * Ends the children list of after the elements are added. */
function end_lvl( &$output, $depth = 0, $args = array() ) {
	$GLOBALS['comment_depth'] = $depth + 1; ?>

	</ul><!-- /.children -->

<?php }

	/** START_EL */
function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
	$depth++;
	$GLOBALS['comment_depth'] = $depth;
	$GLOBALS['comment'] = $comment;
	$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
	?>

	<li <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
	<div id="comment-body-<?php comment_ID() ?>" class="comment-body">

		<div class="comment-author vcard author">
			<?php if ( $args['avatar_size'] != 0) {echo get_avatar( $comment, $args['avatar_size'] );} ?>
		</div><!-- /.comment-author -->

		<div class="comment-container clearfix">
			<div class="comment-header">
				<cite class="fn n author-name wtbx-text"><?php echo get_comment_author_link(); ?></cite>

				<div class="reply">
					<?php $reply_args = array(
						'depth' => $depth,
						'reply_text' =>  esc_html__( 'Reply', 'scape' ),
						'max_depth' => $args['max_depth'] );

					comment_reply_link( array_merge( $args, $reply_args ) );  ?>
				</div><!-- /.reply -->
			</div>

			<?php $seconds = current_time( 'timestamp' ) - get_comment_time('U');
			if ( $seconds <= 604800 ) : ?>
				<div class="comment-meta comment-metadata wtbx-text"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'scape' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?><?php edit_comment_link( esc_html__( '(Edit)', 'scape' ) ); ?></div><!-- /.comment-meta -->
			<?php else : ?>
				<div class="comment-meta comment-metadata wtbx-text"><?php echo get_comment_time('j F Y'); ?><?php edit_comment_link( esc_html__( '(Edit)', 'scape' ) ); ?></div><!-- /.comment-meta -->
			<?php endif; ?>

			<div id="comment-content-<?php comment_ID(); ?>" class="comment-content">
                <?php if ( 'pingback' != $comment->comment_type && 'trackback' != $comment->comment_type ) : ?>
                    <?php if( !$comment->comment_approved ) : ?>
                        <em class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'scape' ); ?></em>

                    <?php else: comment_text(); ?>
				    <?php endif; ?>
                <?php endif; ?>
            </div><!-- /.comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, $reply_args ) );  ?>
			</div><!-- /.reply -->

		</div>
	</div><!-- /.comment-body -->

<?php }

function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

	</li><!-- /#comment-<?php echo get_comment_ID(); ?>-->

<?php }

	/** DESTRUCTOR
	 * I just using this since we needed to use the constructor to reach the top
	 * of the comments list, just seems to balance out :) */
	function __destruct() { ?>

	<?php }
}