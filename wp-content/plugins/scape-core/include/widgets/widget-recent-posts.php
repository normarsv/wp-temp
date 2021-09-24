<?php

/*
 * Recent posts widget
 */
class WTBX_Recent_Posts_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'wtbx_recent_posts_widget', // Base ID
			'Scape Recent Posts', // Name
			array( 'description' => esc_html__( 'Displays recent posts', 'core-extension' ), ) // Args
		);

	}

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = esc_html__( 'Recent posts', 'core-extension' );
		}

		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		} else {
			$count = 3;
		}

		if ( isset( $instance[ 'words' ] ) ) {
			$words = $instance[ 'words' ];
		} else {
			$words = 10;
		}

		$show_comments_checked  = ( isset( $instance['show_comments'] ) && 1 == $instance['show_comments'] ) ? ' checked="checked"' : '';
		$show_like_checked      = ( isset( $instance['show_like'] ) && 1 == $instance['show_like'] ) ? ' checked="checked"' : '';
		$show_date_checked      = ( isset( $instance['show_date'] ) && 1 == $instance['show_date'] ) ? ' checked="checked"' : '';
		$show_meta_checked      = ( isset( $instance['show_meta'] ) && 1 == $instance['show_meta'] ) ? ' checked="checked"' : '';
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'core-extension' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php _e( 'Number of posts:', 'core-extension' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'show_comments' )); ?>"><?php _e( 'Show post comments', 'core-extension' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_comments' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_comments' )); ?>" type="checkbox" <?php echo $show_comments_checked; ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'show_like' )); ?>"><?php _e( 'Show post likes', 'core-extension' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_like' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_like' )); ?>" type="checkbox" <?php echo $show_like_checked; ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php _e( 'Show post date', 'core-extension' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" type="checkbox" <?php echo $show_date_checked; ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'words' )); ?>"><?php _e( 'Words in excerpt:', 'core-extension' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'words' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'words' )); ?>" type="text" value="<?php echo esc_attr( $words ); ?>" />
		</p>

	<?php

	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['words'] = strip_tags( $new_instance['words'] );
		$instance['show_meta'] = $instance['show_date'] = $instance['show_comments'] = $instance['show_like'] = 0;
		if ( isset( $new_instance['show_meta'] ) ) {
			$instance['show_meta'] = 1;
		}
		if ( isset( $new_instance['show_date'] ) ) {
			$instance['show_date'] = 1;
		}
		if ( isset( $new_instance['show_comments'] ) ) {
			$instance['show_comments'] = 1;
		}
		if ( isset( $new_instance['show_like'] ) ) {
			$instance['show_like'] = 1;
		}

		return $instance;

	}



	public function widget( $args, $instance ) {
		extract( $args );

		$title          = apply_filters( 'widget_title', $instance['title'] );
		$count          = $instance['count'];
		$words          = $instance['words'];
		$show_meta      = $instance['show_meta'];
		$show_date      = $instance['show_date'];
		$show_comments  = $instance['show_comments'];
		$show_like      = $instance['show_like'];

		$before_widget  = $args['before_widget'];
		$after_widget   = $args['after_widget'];
		$before_title   = $args['before_title'];
		$after_title    = $args['after_title'];

		echo $before_widget;

		if ($title) {
			echo $before_title;
			echo $title;
			echo $after_title;
		} ?>
		<div class="wtbx_recent_posts_cont">
			<?php
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $count,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'orderby' => 'desc'
			);

			$wp_query = new WP_Query($args);

			// The Loop

			while ($wp_query->have_posts()) : $wp_query->the_post();
				$post_class_elems = get_post_class();
				$post_class = implode(' ', $post_class_elems);
				?>
				<article class="<?php echo esc_attr($post_class); ?>">

					<div class="entry-media wtbx_recent_posts_thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'core-extension' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                            <div class="entry-media-inner">
                                <?php
                                $src_size   = 'thumb';
                                $srcset_size= 'medium';
                                $postID     = get_the_ID();
                                $imgID      = get_post_thumbnail_id($postID);
                                $img_src    = wp_get_attachment_image_url( $imgID, $src_size );
                                $img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
                                $alt        = get_the_title();
                                $metadata   = wp_get_attachment_metadata( $imgID );
                                $ratio = '1:1';
                                wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
                                ?>
                            </div>
                        </a>
					</div>
					<div class="wtbx_recent_posts_content">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'core-extension' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

				        <?php if( !empty($show_date) && $show_date == 1 && !empty($show_comments) && $show_comments == 1 && !empty($show_like) && $show_like == 1 ) : ?>

                            <div class="entry-meta clearfix">
                                <?php if(!empty($show_date) && $show_date == 1) : ?>
                                    <div class="meta-item meta-date">
                                        <?php echo get_the_date('j F Y'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if(!empty($show_comments) && $show_comments == 1) : ?>
                                    <a href="<?php comments_link(); ?>" title="<?php echo esc_attr__( 'View comments for: ', 'core-extension' ) . get_the_title( $postID ); ?>" class="meta-item meta-comments">
                                        <i class="scape-ui-comment"></i>
                                        <?php echo get_comments_number(); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if(!empty($show_like) && $show_like == 1) : ?>
                                    <div class="meta-item post-like">
                                        <?php echo wtbx_get_simple_likes_button( get_the_ID() ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

				        <?php endif; ?>

                        <?php if(intval($words) > 0) : ?>
                            <div class="entry-content">
                                <?php echo wtbx_excerpt($words); ?>
                            </div>
                        <?php endif; ?>

                    </div>

				</article>

			<?php endwhile; wp_reset_postdata(); ?>

		</div>
		<?php

		echo $after_widget;
	}
}