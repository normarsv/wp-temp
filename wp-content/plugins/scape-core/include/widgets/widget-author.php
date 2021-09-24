<?php
require_once(dirname(__FILE__).'/widget.php');

class WTBX_Author_Widget extends WTBX_WP_Widget {
	protected $widget_base_id = 'wtbx_author_widget';
	protected $widget_name = 'Scape Author';

	protected $options;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$this->widget_args = array(
			'description' => esc_html__('Display author info.', 'core-extension'),
		);

		$this->options = array(
			array(
				'position', 'checkbox', 1,
				'label'     => esc_html__('Display author job/position', 'core-extension'),
				'input'     =>'checkbox',
				'on_update' =>'esc_attr',
			),
			array(
				'description', 'checkbox', 1,
				'label'     => esc_html__('Display author bio/info', 'core-extension'),
				'input'     =>'checkbox',
				'on_update' =>'esc_attr',
			),
			array(
				'social', 'checkbox', 1,
				'label'     => esc_html__('Display social icons', 'core-extension'),
				'input'     =>'checkbox',
				'on_update' =>'esc_attr',
			),
			array(
				'author', 'text', '',
				'label' => esc_html__('Display this author:', 'core-extension'),
				'input'=>'wp_dropdown_authors',
				'on_update'=>'esc_attr',
			),
		);

		parent::__construct();
	}
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['author'] = strip_tags( $new_instance['author'] );
		$instance['position'] = strip_tags( $new_instance['position'] );
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['social'] = strip_tags( $new_instance['social'] );

		return $instance;
	}
	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$this->setInstances($instance, 'filter');

		$author         = $instance['author'];
		$position       = $instance['position'];
		$description    = $instance['description'];
		$social         = $instance['social'];

		$before_widget  = $args['before_widget'];
		$after_widget   = $args['after_widget'];
		$before_title   = $args['before_title'];
		$after_title    = $args['after_title'];

		echo $before_widget;

        $id = !empty($author) ? $author : get_the_author_meta( 'ID' );

		?>

		<div class="wtbx_author_widget">
			<div class="author-image">
				<div class="author-image-inner">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
				</div>
			</div>

			<div class="author-bio">
				<a class="author-name" href="<?php echo get_author_posts_url( $id ); ?>"><?php the_author_meta( 'display_name', $id ); ?> </a>

				<?php if ( !empty($position) && $position == 1 ) : ?>

					<?php $info = get_the_author_meta( 'author_info', $id );
					if ($info) : ?>
						<div class="author-position"><?php echo esc_html($info); ?></div>
					<?php endif; ?>

					<?php $description =  get_the_author_meta( 'description', $id );

					if ($description) : ?>
						<div class="author-info"><?php the_author_meta( 'description', $id ); ?></div>
					<?php endif; ?>
				<?php endif;

				if ( !empty($social) && $social == 1 ) :

					$contactmethods = wtbx_vc_social_networks();
					$contacts       = array();
					foreach ( $contactmethods as $contact => $props ) {
						$contacts[$contact] = get_the_author_meta($contact, $id);
					}
					unset($contacts['Author Info']);

					$contacts_start = $contacts_end = '';
					if (array_filter($contacts)) {
						$contacts_start = '<div class="author-contacts clearfix">';
						$contacts_end   = '</div>';
					}

					echo $contacts_start;
					foreach($contacts as $id => $link) {
						$title = $contactmethods[$id][0];
						$icon = $contactmethods[$id][1];
						if ($link) {
							echo '<a href="'.esc_url($link) .'" class="author-contact-link author-'.esc_attr(str_replace(' ', '',  strtolower($title))).'" aria-label="'.esc_attr($title).'"><i class="'.esc_attr($icon).'"></i></a>';
						}
					}
					echo $contacts_end;

				endif; ?>

			</div>
		</div>

		<?php wp_reset_postdata(); ?>

		<?php

		echo $after_widget;
	}

}