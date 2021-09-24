<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews clearfix">
	<div id="comments" class="wtbx-col-md-6">
		<h3 class="woocommerce-Reviews-title product-tab-title">
            <?php
            $count = $product->get_review_count();
            if ( $count && wc_review_ratings_enabled() ) {
	            /* translators: 1: reviews count 2: product name */
	            $reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
	            echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
            } else {
	            esc_html_e( 'Reviews', 'woocommerce' );
            }
            ?>
        </h3>

		<?php if ( have_comments() ) : ?>
			<ol class="commentlist comment-list">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
//				echo '<nav class="woocommerce-pagination">';
//				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
//					'prev_text' => '&larr;',
//					'next_text' => '&rarr;',
//					'type'      => 'list',
//				) ) );
//				echo '</nav>';
			?>
				<nav class="woocommerce-pagination wtbx-pagination wtbx-skin-light paged-comments-nav">
					<div class="wtbx-pagination-inner clearfix">
						<?php
						echo paginate_comments_links( apply_filters( 'woocommerce_pagination_args', array(
							'prev_text'    => '<div class="page-prev page-numbers"><span class="wtbx-nav-button page-link"></span></div>',
							'next_text'    => '<div class="page-next page-numbers"><span class="wtbx-nav-button page-link"></span></div>',
							'type'         => 'plain',
						) ) );
						?>
					</div>
				</nav>
			<?php endif; ?>

		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper" class="wtbx-col-md-6">
			<div id="review_form" class="clearfix">
				<?php
				$commenter = wp_get_current_commenter();

				$your_rating = $rating = '';
				/* translators: %s is product title */
				if ( wc_review_ratings_enabled() ) {
					$rating = '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
						</select></p>';
				}

				if ( !is_user_logged_in() ) {
					$your_rating = $rating;
				}

				$comment_form = array(
					'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
					'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'fields'               => array(
						'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
									'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
						'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
									'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						'rating' => $your_rating
					),
					'label_submit'  => esc_html__( 'Submit', 'woocommerce' ),
					'class_submit'  => 'wtbx-button wtbx-button-primary button-sm',
					'logged_in_as'  => '',
					'comment_field' => ''
				);

				if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
					$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
				}

				$comment_form['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

				if ( is_user_logged_in() ) {
					$comment_form['comment_field'] .= $rating;
				}

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
