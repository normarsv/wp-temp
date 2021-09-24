<?php
require_once(dirname(__FILE__).'/widget.php');

class WTBX_Newsletter_Widget extends WTBX_WP_Widget {
	protected $widget_base_id = 'wtbx_newsletter_widget';
	protected $widget_name = 'Scape Newsletter';

	protected $options;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$this->widget_args = array(
			'description' => esc_html__('Newsletter subscribe form', 'core-extension'),
		);

		$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		$contact_forms = array();
		if ( $cf7 ) {
			foreach ( $cf7 as $cform ) {
				$contact_forms[ $cform->post_title ] = $cform->ID;
			}
		} else {
			$contact_forms[ esc_html__( 'No contact forms found', 'core-extension' ) ] = 0;
		}

		$this->options = array(
			array(
				'title', 'text', '',
				'label' => esc_html__('Title:', 'core-extension'),
				'input'=>'text',
				'filters'=>'widget_title',
				'on_update'=>'esc_attr',
			),
			array(
				'form', 'select', 1,
				'label'     => esc_html__('Contact form:', 'core-extension'),
				'input'     =>'dropdown',
				'values' => $contact_forms,
				'on_update' =>'esc_attr',
			),
			array(
				'style', 'select', 1,
				'label'     => esc_html__('Contact form style:', 'core-extension'),
				'input'     =>'dropdown',
				'values' => array(
					esc_html__('Default', 'core-extension') => 'cf-default',
					esc_html__('Minimal', 'core-extension') => 'cf-minimal',
					esc_html__('Subscribe default', 'core-extension') =>'cf-subscribe-default',
					esc_html__('Subscribe regular', 'core-extension') => 'cf-subscribe-regular',
					esc_html__('Subscribe modern', 'core-extension') =>'cf-subscribe-modern',
				),
				'on_update' =>'esc_attr',
			),
			array(
				'skin', 'select', 1,
				'label'     => esc_html__('Contact form color skin:', 'core-extension'),
				'input'     =>'dropdown',
				'values' => array(
					esc_html__('Light', 'core-extension') => '',
					esc_html__('Dark', 'core-extension') => 'cf-dark',
				),
				'on_update' =>'esc_attr',
			),
		);

		parent::__construct();
	}
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['form'] = strip_tags( $new_instance['form'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$instance['skin'] = strip_tags( $new_instance['skin'] );

		return $instance;
	}
	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$this->setInstances($instance, 'filter');

		$id          = $instance['form'];
		$style       = $instance['style'];
		$skin        = $instance['skin'];

		if ( $style !== '' ) {
			$style = ' ' . $style;
		}

		if ( $skin !== '' ) {
			$style .= ' ' . $skin;
		}

		$before_widget  = $args['before_widget'];
		$after_widget   = $args['after_widget'];
		$before_title   = $args['before_title'];
		$after_title    = $args['after_title'];

		echo $before_widget;

		$title = $this->getInstance('title');
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		?>

		<div class="wtbx_newsletter_widget<?php echo esc_attr($style); ?>">
			<?php echo do_shortcode('[contact-form-7 id="'.esc_attr($id).'"]'); ?>
		</div>


		<?php

		echo $after_widget;
	}

}