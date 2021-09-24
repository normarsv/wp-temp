<?php
require_once(dirname(__FILE__).'/widget.php');

class WTBX_Random_Post_Widget extends WTBX_WP_Widget {
	protected $widget_base_id = 'wtbx_random_post_widget';
	protected $widget_name = 'Scape Random Post';

	protected $options;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$this->widget_args = array(
			'description' => esc_html__('Displays a random post.', 'core-extension'),
		);

		$this->options = array(
			array(
				'categories', 'checkbox', 1,
				'label'     => esc_html__('Display categories', 'core-extension'),
				'input'     =>'checkbox',
				'on_update' =>'esc_attr',
			),
			array(
				'excerpt', 'checkbox', 1,
				'label'     => esc_html__('Display excerpt', 'core-extension'),
				'input'     =>'checkbox',
				'on_update' =>'esc_attr',
			),
			array(
				'words', 'text', '10',
				'label' => esc_html__('Words in excerpt:', 'core-extension'),
				'input'=>'text',
				'on_update'=>'esc_attr',
			),
			array(
				'category', 'text', '',
				'label' => esc_html__('Show only posts in:', 'core-extension'),
				'input'=>'wp_dropdown_categories',
				'on_update'=>'esc_attr',
			),
		);

		parent::__construct();
	}
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['categories'] = strip_tags( $new_instance['categories'] );
		$instance['excerpt']    = strip_tags( $new_instance['excerpt'] );
		$instance['words']      = intval( $new_instance['words'] );
		$instance['category']   = strip_tags( $new_instance['category'] );

		return $instance;
	}
	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$this->setInstances($instance, 'filter');

		$categories     = $instance['categories'];
		$excerpt        = $instance['excerpt'];
		$words          = $instance['words'];
		$cat            = $instance['category'];

		$before_widget  = $args['before_widget'];
		$after_widget   = $args['after_widget'];
		$before_title   = $args['before_title'];
		$after_title    = $args['after_title'];

		echo $before_widget;

		if ( !empty($cat) ) {
			$tax_query = array(
				array(
					'taxonomy' => 'category',
					'field' => 'name',
					'terms' => $cat,
				),
			);
		} else {
			$tax_query = array();
		}


		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'ignore_sticky_posts' => true,
			'tax_query' => $tax_query
		);

		$wp_query = new WP_Query($args);

		while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

			<div class="wtbx_random_post_widget">
				<?php
				$post_class_elems = get_post_class();
				$post_class = implode(' ', $post_class_elems);
				$post_class .= ' wtbx_preloader_cont';
				?>
				<article class="<?php echo esc_attr($post_class); ?>">

					<?php if ( wtbx_vc_option('site-smartimage') === '1' && wtbx_vc_option('site-preloaders') === '1' ) :
						include(locate_template('templates/components/preloader.php'));
					endif; ?>

					<div class="random-post-container wtbx-element-reveal wtbx-reveal-cont">

						<div class="random-post-bg">
							<?php
							$src_size   = 'medium';
							$srcset_size= 'full';
							$postID     = get_the_ID();
							$imgID      = get_post_thumbnail_id($postID);
							$img_src    = wp_get_attachment_image_url( $imgID, $src_size );
							$img_srcset = wp_get_attachment_image_srcset( $imgID, $srcset_size );
							$alt        = get_the_title();
							$metadata   = wp_get_attachment_metadata( $imgID );
							$ratio = $excerpt ? '1:1' : '12:10';
							wtbx_image_smart_crop($imgID, $src_size, $srcset_size, $ratio, $alt);
							?>
						</div>

						<div class="random-post-content">

							<?php if ( $categories ) : ?>
								<div class="meta-categories">
									<div class="category-list"><?php the_category(); ?></div>
								</div>
							<?php endif; ?>

							<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Continue reading: %s', 'core-extension' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

							<?php if ( $excerpt ) : ?>
								<div class="entry-content clearfix">
									<?php echo wtbx_excerpt($words); ?>
								</div>
							<?php endif; ?>

						</div>
					</div>

				</article>

			</div>

		<?php endwhile; wp_reset_postdata(); ?>

		<?php

		echo $after_widget;
	}

}