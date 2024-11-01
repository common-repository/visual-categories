<?php
global $wp_version;

if (version_compare($wp_version, '2.7', '>=') && version_compare($wp_version, '2.8', '<') && class_exists('viscats_class')) {
	class viscats_widget extends viscats_class {
		
		function widget() {
			if (!function_exists('wp_register_sidebar_widget'))
				return;

			wp_register_sidebar_widget($this->admin['name'], $this->plugin['name'], array(&$this, 'display'), array('description' => __('Take control over the way you display your categories')));
			wp_register_widget_control($this->admin['name'], $this->plugin['name'], array(&$this, 'control'));

		}

		function display($args) {
			extract($args);
			echo $before_widget.$this->list_cats().$after_widget;
		}

		function control() {
			echo '<p>To configure this widget, please visit the <a href="'.$this->admin['url'].'">'.$this->plugin['name'].' Settings page</a>.</p>';
		}
	}
	
	$viscats_widget = new viscats_widget();
	add_action('widgets_init', array(&$viscats_widget, 'widget'));
	
} elseif (version_compare($wp_version, '2.8', '>=') && class_exists('WP_Widget')) {
	class viscats_widget extends WP_Widget {

		var $viscats;
		function viscats_widget() {
			$this->viscats = new viscats_class();
			$widget_ops = array('classname' => 'widget_'.$this->viscats->plugin['short'], 'description' => __('Take control over the way you display your categories'));
			$this->WP_Widget($this->viscats->admin['name'], $this->viscats->plugin['name'], $widget_ops);
		}

		function widget($args, $instance) {
			extract($args);				
				
			echo $before_widget.(($instance['title']) ? $before_title.$instance['title'].$after_title : '').$this->viscats->list_cats().$after_widget;
		}

		function form($instance) {
			$instance = wp_parse_args((array)$instance, array('title' => ''));
			$title = strip_tags($instance['title']);
			
			echo '<p><label for="'.$this->get_field_id('title').'">'._e('Title:').'</label><input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'" /></p>';
			echo '<p>To configure this widget, please visit the <a href="'.$this->viscats->admin['url'].'">'.$this->viscats->plugin['name'].' Settings page</a>.</p>';
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

	}
	function register_viscats_widget() {
		register_widget('viscats_widget');
	}
	add_action('widgets_init', 'register_viscats_widget');
}

?>