<?php

class WTBX_WP_Widget extends WP_Widget {

	protected $widget_base_id = '';
	protected $widget_name = '';
	protected $widget_args = null;
	protected $options = array();

	private $_defaults;
	private $_instance;
	private $_options;

	public function __construct() {
		$this->loadOptions();
		$this->loadDefaults();

		parent::__construct(
			$this->widget_base_id, // Base ID
			$this->widget_name, // Name
			$this->widget_args // Args
		);
	}

	/**
	 * Update widget
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		foreach ($this->options as $option) {
			$key = $option[0];
			$val = $new_instance[$key];

			$val = $this->filterByType($val, $option);
			$val = $this->filterOnUpdate($val, $option);

			$instance[$key] = $val;
		}

		return $instance;
	}

	public function filterByType($val, $option) {
		$key = $option[0];
		$type = $option[1];

		# Filter by option type
		switch ($type) {
			case 'int':
				$val = intval($val);
				break;
			case 'array':
				$val = serialize($val);
				break;
			case 'text':
			case 'textarea':
			default:
				;
		}

		return $val;
	}

	public function filterOnUpdate($val, $option) {
		# Call on_update functions
		if (isset($option['on_update'])) {
			$on_update = explode(',', $option['on_update']);

			foreach ($on_update as $on_update_func) {
				$on_update_func = trim($on_update_func);

				if (function_exists($on_update_func)) {
					$val = $on_update_func($val);
				}
			}
		}

		return $val;
	}

	public function applyFilters($val, $option) {
		# Apply filters
		if (isset($option['filters'])) {
			$filters = explode(',', $option['filters']);

			foreach ($filters as $filter) {
				$filter = trim($filter);

				$val = apply_filters($filter, $val);
			}
		}

		return $val;
	}

	/**
	 * Widget setting
	 */
	public function form( $instance ) {
		$this->setInstances($instance);

		//@TODO: Make Option like object
		$options = $this->getOptions();

		if (!is_array($options) || count($options)==0) {
			return;
		}

		foreach($options as $option) {
			$name = $option[0];

			if (isset($option['input'])) {
				$input = $option['input'];
			} else {
				$input = 'text';
			}

			$input_function = "_input_{$input}";
			if (!is_callable(array($this, $input_function))) {
				throw new Exception("Access denied to '{$input_function}'");
			}

			$this->$input_function($name);
		}
	}

	protected function _input_textarea($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );
		?>
		<p>
			<label for="<?php echo esc_attr($input_id); ?>"><?php echo $label; ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($input_id); ?>" name="<?php echo esc_attr($input_name); ?>"><?php echo $value; ?></textarea>
		</p>
	<?php
	}

	protected function _input_text($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );
		?>
		<p>
			<label for="<?php echo esc_attr($input_id); ?>"><?php echo $label; ?></label>
			<input class="widefat" id="<?php echo esc_attr($input_id); ?>" name="<?php echo esc_attr($input_name); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
		</p>
	<?php
	}

	protected function _input_select($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );

		$values = $option['values'];
		$generator_name = $values[0];
		if ($generator_name!='range') {
			throw new Exception("Undefined generator '{$generator_name}'");
		}

		$from = $values['from'];
		$to = $values['to'];
		?>
		<p>
			<label for="<?php echo esc_attr($input_id); ?>"><?php echo esc_attr($label); ?></label>
			<select class="widefat" name="<?php echo esc_attr($input_name); ?>" id="<?php echo esc_attr($input_id); ?>">
				<?php for ( $i=$from; $i<=$to; $i++ ) { ?>
					<option <?php selected( $value, $i ) ?> value="<?php echo esc_attr($i); ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
	<?php
	}

	protected function _input_dropdown($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );

		$values = $option['values'];

		?>
		<p>
			<label for="<?php echo esc_attr($input_id); ?>"><?php echo esc_attr($label); ?></label>
			<select class="widefat" name="<?php echo esc_attr($input_name); ?>" id="<?php echo esc_attr($input_id); ?>">
				<?php foreach ( $values as $title => $id ) { ?>
					<option <?php selected( $value, $id ) ?> value="<?php echo esc_attr($id); ?>"><?php echo $title; ?></option>
				<?php } ?>
			</select>
		</p>
	<?php
	}

	protected function _input_checkbox($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );
		?>
		<p>
			<label for="<?php echo esc_attr($input_id); ?>"><?php echo $label; ?></label>
			<input type="checkbox"  id="<?php echo esc_attr($input_id); ?>" name="<?php echo esc_attr($input_name); ?>" value="1" <?php checked( '1', $value ); ?> />&nbsp;
		</p>
	<?php
	}

	protected function _input_wp_dropdown_categories($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );

		$categories = get_categories();

		echo '<p>';
		echo '<label for="'.esc_attr($input_id).'">'.$label.'</label>';
		echo '<select id="'.esc_attr($input_id).'" name="'.esc_attr($input_name).'">';
		echo '<option value="">'.esc_html__('All categories' , 'core-extension').'</option>';
		foreach ($categories as $cat) {
			$selected = (selected($cat->slug, $value));
			echo '<option value="'.esc_attr($cat->slug).'" '.$selected.'> '.$cat->name.'</option>';
		}
		echo '</select>';
		echo '</p>';
	}

	protected function _input_wp_dropdown_authors($name) {
		$option = $this->getOption($name);

		$value = $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );

		global $wpdb;

		$query_args = array(
			'orderby' => 'name', 'order' => 'ASC', 'number' => '',
			'exclude' => '', 'include' => ''
		);

		$query_args['fields'] = 'ids';
		$authors = get_users( $query_args );

		$author_count = array();
		foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author" ) as $row ) {
			$author_count[$row->post_author] = $row->count;
		}

		echo '<p>';
		echo '<label for="'.esc_attr($input_id).'">'.$label.'</label>';
		echo '<select id="'.esc_attr($input_id).'" name="'.esc_attr($input_name).'">';
		echo '<option value="">'.esc_html__('Current post author' , 'core-extension').'</option>';
		foreach ($authors as $author_id) {
			$author = get_userdata($author_id);
			$posts = isset($author_count[$author->ID]) ? $author_count[$author->ID] : 0;

			if (!$posts) {
				continue;
			}

			if ( $author->first_name && $author->last_name ) {
				$author_name = "$author->first_name $author->last_name";
			} else {
				$author_name = $author->display_name;
			}

			$selected = (selected($author_id, $value));
			echo '<option value="'.esc_attr($author_id).'" '.$selected.'> '.$author_name.'</option>';
		}
		echo '</select>';
		echo '</p>';
	}

	protected function _input_wp_category_checklist($name) {
		$option = $this->getOption($name);

		$value = (array) $this->getInstance($name);
		$label = $option['label'];

		$input_id = esc_attr( $this->get_field_id($name) );
		$input_name = esc_attr( $this->get_field_name($name) );

		$categories = get_categories();

		echo '<p>';
		echo '<label for="'. esc_attr($input_id) .'">'.$label.'</label>';
		echo '<ul>';
		foreach ($categories as $cat) {
			$checked = ($cat->slug === $value) ? 'checked="checked"' : '';
			echo '<li><label><input type="checkbox" name="'.esc_attr($input_name).'[]" value="'.esc_attr($cat->slug).'" '.$checked.'/> '.$cat->name.'</label><li>';
		}
		echo '</ul>';
		echo '</p>';
		?>

	<?php
	}

	private function loadOptions() {
		foreach((array) $this->options as $option) {
			$key = $option[0];
			$this->_options[$key] = $option;
		}
	}

	public function getOptions() {
		if (!$this->_options) {
			$this->loadOptions();
		}

		return $this->_options;
	}

	public function getOption($key) {
		if (!$this->_options) {
			$this->loadOptions();
		}

		if (isset($this->_options[$key])) {
			return $this->_options[$key];
		} else {
			return '';
		}
	}

	protected function loadDefaults() {
		foreach((array) $this->options as $option) {
			$key = $option[0];

			if (isset($option[2])) {
				$default = $option[2];
			} else {
				$default = '';
			}

			$this->_defaults[$key] = $default;
		}
	}

	public function getDefaults() {
		if (!$this->_defaults) {
			$this->loadDefaults();
		}

		return $this->_defaults;
	}

	public function getDefault($key) {
		if (!$this->_defaults) {
			$this->loadDefaults();
		}

		if (isset($this->_defaults[$key])) {
			return $this->_defaults[$key];
		}

		throw new Exception("Default value for '{$key}' no exist.");
	}

	public function setInstances($instances, $filters='on_update') {
		$instances = wp_parse_args(
			(array)$instances,
			$this->getDefaults()
		);

		foreach($instances as $key => $val) {
			$option = $this->getOption($key);

			switch ($filters) {
				case 'on_update':
					$instances[$key] = $this->filterOnUpdate($val, $option);
					break;
				case 'filters':
					$instances[$key] = $this->applyFilters($val, $option);
					break;
			}
		}

		$this->_instance = $instances;
	}

	public function getInstance($key) {
		if (isset($this->_instance[$key])) {
			return maybe_unserialize($this->_instance[$key]);
		} else {
			return $this->getDefault($key);
		}
	}
}
