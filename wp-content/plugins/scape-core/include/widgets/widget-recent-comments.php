<?php
require_once(dirname(__FILE__).'/widget.php');

class WTBX_Recent_Comments_Widget extends WTBX_WP_Widget {
	protected $widget_base_id = 'wtbx_recent_comments_widget';
	protected $widget_name = 'Scape Recent Comments';

	protected $options;
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$this->widget_args = array(
			'description' => esc_html__('Displays recent comments.', 'core-extension')
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
				'limit', 'int', 3,
				'label' => esc_html__('Number of comments:', 'core-extension'),
				'input'=>'select',
				'values' => array('range', 'from'=>1, 'to'=>10),
			),
			array(
				'words', 'text', '10',
				'label' => esc_html__('Words in excerpt:', 'core-extension'),
				'input'=>'text',
				'on_update'=>'esc_attr',
			),
		);

		add_action( 'comment_post', array($this, 'flush_widget_cache') );
		add_action( 'edit_comment', array($this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_widget_cache') );

		parent::__construct();
	}

	function flush_widget_cache() {
		wp_cache_delete('scape_widget_recent_comments', 'widget');
	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$this->setInstances($instance, 'filter');

		$cache = wp_cache_get('scape_widget_recent_comments', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		$number = $this->getInstance('limit');

		extract($args, EXTR_SKIP);

		$before_widget  = $args['before_widget'];
		$after_widget   = $args['after_widget'];
		$before_title   = $args['before_title'];
		$after_title    = $args['after_title'];

		$output = '';

		$output .= $before_widget;

		$title = $this->getInstance('title');
		if ( ! empty( $title ) ) {
			$output .= $before_title . $title . $after_title;
		}

		global $comments, $comment;

		$arg = array(
			'post_type' => 'post',
			'number' => $number,
			'status' => 'approve',
			'post_status' => 'publish'
		);

		$comments = get_comments( $arg );

		$output .= '<ul class="wtbx_recent_comments">';

		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				$comment_text = strlen(get_comment_text($comment->comment_ID)) < 100 ? get_comment_text($comment->comment_ID) : substr(get_comment_text($comment->comment_ID), 0, 97) . '...';
				$d = "F j Y";
				$output .=  '<li class="wtbx-recent-comment">' . /* translators: comments widget: 1: comment author, 2: post link */ sprintf(_x('%1$s on %2$s', 'core-extension'), '<p class="comment-text">'.$comment_text.'</p><p class="comment-meta"><span class="author">' . get_comment_author_link() . '</span>', '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '" class="post-link" title=" " target="_blank">' . get_the_title($comment->comment_post_ID) . '</a></p>' ) . '</li>';
			}
		}

		$output .= '</ul>';

		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('scape_widget_recent_comments', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = absint( $new_instance['limit'] );
		$instance['words'] = intval( $new_instance['words'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['scape_widget_recent_comments']) )
			delete_option('scape_widget_recent_comments');

		return $instance;
	}

}
