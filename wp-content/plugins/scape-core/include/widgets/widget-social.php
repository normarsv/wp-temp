<?php
require_once(dirname(__FILE__).'/widget.php');

class WTBX_Social_Widget extends WTBX_WP_Widget {
	protected $widget_base_id = 'wtbx_social_widget';
	protected $widget_name = 'Scape Social Icons';

	protected $options;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$this->widget_args = array(
			'description' => esc_html__('Displays social icons.', 'core-extension'),
		);

		$this->options = array(
			array(
				'title', 'text', '',
				'label' => esc_html__('Title:', 'core-extension'),
				'input'=>'text',
				'filters'=>'widget_title',
				'on_update'=>'esc_attr',
			),
			array(
				'style', 'select', 1,
				'label'     => esc_html__('Icons style', 'core-extension'),
				'input'     =>'select',
				'values' => array( 'range', 'from'=> 1, 'to'=> 4 ),
				'on_update' =>'esc_attr',
			),
		);

		parent::__construct();
	}
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = strip_tags( $new_instance['style'] );

		return $instance;
	}
	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$this->setInstances($instance, 'filter');

		$style          = $instance['style'];

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

		<div class="wtbx_social_widget wtbx_style_<?php echo esc_attr($style); ?>">
			<ul>
				<?php
				$variants = wtbx_vc_social_networks();

				if ( $variants ) {
					foreach ( $variants as $id => $opts ) {
						$url = wtbx_vc_option('social_'.$id);
						if ( $url !== '' && isset($variants[$id][1]) ) : ?>
							<li>
								<a class="widget-social-icon social-icon-<?php echo esc_attr($id);?>" href="<?php echo esc_url($url); ?>">
									<i class="<?php echo esc_attr($variants[$id][1]); ?>"></i>
									<?php if ( $style == 3 ) : ?>
										<span><?php echo esc_attr($variants[$id][0]); ?></span>
									<?php endif; ?>
								</a>
							</li>
						<?php endif;
					}
				}
				?>
			</ul>
		</div>


		<?php

		echo $after_widget;
	}

}