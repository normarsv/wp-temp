<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review-meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta">
        <em class="woocommerce-review__awaiting-approval">
            <?php esc_attr_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
        </em>
    </p>

<?php } else { ?>

	<div class="comment-header">
		<span class="woocommerce-review__author author-name" itemprop="author"><?php comment_author(); ?></span> <?php

		if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
			echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')</em> ';
		}

		?>
	</div>

	<?php $seconds = current_time( 'timestamp' ) - get_comment_time('U');
	if ( $seconds <= 604800 ) : ?>
		<time class="woocommerce-review__published-date comment-meta comment-metadata" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'woocommerce' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>
	<?php else : ?>
		<time class="woocommerce-review__published-date comment-meta comment-metadata" datetime="<?php echo get_comment_time('j F Y'); ?>"><?php echo get_comment_time('j F Y'); ?></time>
	<?php endif; ?>


<?php }
