<?php
/*
Plugin Name: Visual Categories
Plugin URI: http://www.thenappycat.com/2009/wordpress/categories/visual-categories-plugin/
Description: Take control over the way you display your categories.
Version: 1.6.0
Author: W. J. Zeallor
Author URI: http://www.thenappycat.com/
*/
/*  Copyright (C) 2009 W. J. Zeallor

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


if (!class_exists('viscats_class')) {
	if (!defined('WP_CONTENT_DIR'))
		define('WP_CONTENT_DIR', ABSPATH.'wp-content');
	if (!defined('WP_CONTENT_URL'))
		define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
	
	if (!defined('WP_PLUGIN_DIR'))
		define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');
	if (!defined('WP_PLUGIN_URL'))
		define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');

	class viscats_class {
		var $version = '1.6.0';
		var $defaults;

		var $plugin;
		var $uploads;
		var $paths;
		var $urls;
		var $admin;
		var $image;
		
		var $tree_type = 'category';
		var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

		var $to_fix = array(
			'auto_default' => array('exclude_tree', 'hierarchical', 'current_category'),
			'conditional_default' => array('cat_link_text', 'feed_link_text', 'date_format', 'cat_link_title', 'feed_link_title'),
			'displayed' => array('cat_link_before', 'cat_link_text', 'cat_link_after', 'cat_link_title', 'feed_link_before', 'feed_link_text', 'feed_link_after', 'feed_link_title'),
			'linked' => array('cat_link_text' => '%feed_link', 'feed_link_text' => '%cat_link'),
			'arr_classes' => array('category_class', 'current_class', 'current_parent_class', 'parent_class', 'child_class', 'height_class'),
			'all_classes' => array('category_class', 'current_class', 'current_parent_class', 'parent_class', 'child_class', 'height_class', 'outer_class', 'inner_class', 'children_class', 'feed_class', 'count_class', 'date_class', 'image_class'),
			'strip_tags' => array('title_li', 'cat_link_before', 'cat_link_text', 'cat_link_after', 'cat_link_title', 'feed_link_before', 'feed_link_text', 'feed_link_after', 'feed_link_title', 'count_before', 'count_after', 'date_format'),
			'strip_all' => array('cat_link_title', 'feed_link_title'),
			'integers' => array('image_w', 'image_h', 'height', 'child_of', 'depth', 'use_desc_for_title', 'pad_counts', 'wrap', 'style_is_list', 'height_enabled', 'keep_family', 'hide_empty', 'count_format', 'depth_limit'),
			'cat_ids' => array('include', 'exclude')
		);

		function viscats_class() {
			$this->plugin = array(
				'path' => trailingslashit(WP_PLUGIN_DIR).plugin_basename(dirname(__FILE__)),
				'url' => trailingslashit(WP_PLUGIN_URL).plugin_basename(dirname(__FILE__)),
				'name' => 'Visual Categories',
				'admin' => 'visual-categories',
				'short' => 'viscats',
				'dirs' => array('images' => 'images', 'uploads' => 'viscats')
			);

			$this->uploads = array(
				'wp' => wp_upload_dir(),
				'types' => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png'),
				'errors' => array('%s was uploaded successfully', '%s exceeds your server\'s max upload size', '%s exceeds the max upload size', '%s was only partially uploaded', 'No file was uploaded', 'Your server\'s missing its temporary folder', 'Failed to write file to disk', 'File upload stopped by extension')
			);

			$this->paths = array(
				'site' => untrailingslashit(ABSPATH),
				'images' => trailingslashit($this->plugin['path']).$this->plugin['dirs']['images'],
				'uploads' => trailingslashit($this->uploads['wp']['basedir']).$this->plugin['dirs']['uploads']
			);

			$this->urls = array(
				'site' => get_option('siteurl'),
				'images' => trailingslashit($this->plugin['url']).$this->plugin['dirs']['images'],
				'uploads' => trailingslashit($this->uploads['wp']['baseurl']).$this->plugin['dirs']['uploads']
			);

			$this->admin = array(
				'url' => 'options-general.php?page='.$this->plugin['admin'],
				'name' => $this->plugin['admin']
			);

			$this->image = array(
				'w' => 12,
				'h' => 12,
				'r' => $this->plugin['short'].'_resize',
				'u' => $this->get_files($this->paths['uploads']),
				'i' => $this->get_files($this->paths['images'])
			);
			
			$this->defaults = array(
				'cat_link_before' => '', 'cat_link_text' => '%cat_name',
				'cat_link_after' => '', 'cat_link_title' => 'View all posts filed under %cat_name',
				'use_desc_for_title' => 1,

				'feed_link_before' => '',
				'feed_link_text' => 'RSS', 'feed_link_after' => '',
				'feed_link_title' => 'Feed for all posts filed under %cat_name',

				'image_src' => '', 'image_upload' => '',
				'image_w' => $this->image['w'], 'image_h' => $this->image['h'],
				'image_tag' => '', 'image_admin' => '', 'image_delete' => '',

				'count_before' => '(',
				'count_after' => ')', 'count_format' => 0,
				'pad_counts' => 1,

				'date_format' => 'm/d/Y',
				'entry_layout' => '%cat_link', 'style_is_list' => 1,
				'list_type' => 'unordered', 'title_li' => 'Categories',
				'col_tag' => 'ul', 'wrap' => 1, 
				'outer_class' => 'categories', 'inner_class' => '', 'children_class' => 'cat-children',

				'category_class' => 'cat-item cat-id-%ID',
				'current_class' => 'current-cat', 'current_parent_class' => 'current-cat-parent',
				'parent_class' => 'parent-cat', 'child_class' => 'child-cat',
				'height_class' => 'cat-height col-num-%ID',

				'feed_class' => 'cat-feed feed-for-%ID', 'date_class' => 'cat-date', 
				'count_class' => 'cat-count', 'image_class' => 'cat-image',

				'height_enabled' => 0, 'height' => 0, 'keep_family' => 1,
				'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 1,
				'child_of' => 0, 'include' => '', 'exclude' => '',
				'exclude_tree' => '', 'hierarchical' => 1, 'current_category' => 0,
				'depth' => 0, 'depth_limit' => 5,
				'custom_cats' => $this->set_custom_cats()
			);
		}

		function security() {
			if (!current_user_can('manage_options'))
				die();
		}

		function install() {
			$this->security();
			$version = get_option($this->plugin['short'].'_version');
			if (!$version)
				add_option($this->plugin['short'].'_version', $this->version);
			elseif ($version != $this->version)
				$this->upgrade_settings($version);

			if (!get_option($this->plugin['short'].'_settings'))
				$this->store_settings();
				
		}

		function upgrade_settings($old_version) {
			$settings = $this->get_settings();
			if ($old_version === '1.0') {
				if (is_dir(trailingslashit($this->paths['images']).'feedimages'))
					$this->rmdirr(trailingslashit($this->paths['images']).'feedimages');
				if (isset($settings['cat_links_url'])) {
					foreach ($settings['cat_links_url'] as $cat_ID => $url)
						$settings['custom_cats'][$cat_ID]['link_href'] = $url;
					if (isset($settings['cat_links_target'])) {
						foreach ($settings['cat_links_target'] as $cat_ID => $target)
							$settings['custom_cats'][$cat_ID]['link_target'] = $target;
					}
					foreach ($settings['custom_cats'] as $cat_ID => $attributes) {
						$settings['custom_cats'][$cat_ID]['image_src'] = '0';
						$settings['custom_cats'][$cat_ID]['image_tag'] = '0';
						$settings['custom_cats'][$cat_ID]['image_w'] = $this->defaults['image_w'];
						$settings['custom_cats'][$cat_ID]['image_h'] = $this->defaults['image_h'];
					}
				} else
					$settings['custom_cats'] = $this->defaults['custom_cats'];
				$updated_settings = array(
						'feed_img_class' => '', 
						'feed_img_w' => 'image_w', 
						'feed_img_h' => 'image_h', 
						'feed_img' => '', 
						'feed_img_tag' => '', 
						'feed_img_personal' => '', 
						'cat_links_url' => '', 
						'cat_links_target' => '', 
						'feed_enabled' => '', 
						'feed_img_enabled' => '', 
						'date_enabled' => '', 
						'show_count' => ''
					);

				foreach ($updated_settings as $old => $new) {
					if ($new)
						$settings[$new] = $settings[$old];
					unset($settings[$old]);
				}
				$new_settings = array('image_src', 'image_upload', 'image_tag', 'current_parent_class', 'image_class', 'height_class', 'category_class', 'feed_class', 'image_admin', 'image_delete');
				foreach ($new_settings as $new)
					$settings[$new] = $this->defaults[$new];

			foreach ($this->to_fix['strip_tags'] as $setting)
				$settings[$setting] = str_replace('%feed_image', '%image', $settings[$setting]);
			}
			$this->store_settings($settings);
			update_option($this->plugin['short'].'_version', $this->version);
		}

		function store_settings($settings = array()) {
			if (empty($settings))
				$settings = $this->defaults;
			if (get_option($this->plugin['short'].'_settings'))
				delete_option($this->plugin['short'].'_settings');
			add_option($this->plugin['short'].'_settings', $settings);
		}

		function add_page() {
			if (current_user_can('manage_options')) {
				add_submenu_page('options-general.php', $this->plugin['name'].' Settings', $this->plugin['name'], 'manage_options', $this->admin['name'], array(&$this, 'admin_panel'));
				add_filter('plugin_action_links', array(&$this, 'filter_plugin_actions'), 10, 2);
			}
		}

		function filter_plugin_actions($links, $file) {
			static $this_plugin;
			if (!$this_plugin)
				$this_plugin = plugin_basename(__FILE__);
			if ($file == $this_plugin) {
				$settings_link = '<a href="'.$this->admin['url'].'">'.__('Settings').'</a>';
				array_unshift($links, $settings_link);
			}
			return $links;
		}

		function get_settings() {
			return get_option($this->plugin['short'].'_settings');
		}
		function admin_initialize() {
			if(function_exists('register_setting'))
				register_setting($this->plugin['admin'], $this->plugin['short'].'_settings', '');
		}
		function admin_panel() {
			$this->security();
			if (isset($_POST[$this->plugin['short'].'_save'])) {
				check_admin_referer($this->plugin['admin'].'-options');
				if (isset($_FILES[$this->plugin['short'].'_image_upload']) && !empty($_FILES[$this->plugin['short'].'_image_upload']['name'])) {
					$result = $this->process_upload($_FILES[$this->plugin['short'].'_image_upload']);
					echo '<div class="updated"><p>'.$result.'</p></div>';
				}
				update_option($this->plugin['short'].'_settings', $this->fix_values($_POST));
				echo '<div class="updated"><p>'.$this->plugin['name'].' settings saved!</p></div>';
			} elseif (isset($_POST[$this->plugin['short'].'_reset'])) {
				check_admin_referer($this->plugin['admin'].'-options');
				$this->store_settings();
				echo '<div class="updated"><p>'.$this->plugin['name'].' settings restored to default!</p></div>';
			}
			$settings = $this->get_settings();

			foreach ($this->to_fix['strip_tags'] as $setting)
				$settings[$setting] = htmlspecialchars(html_entity_decode($settings[$setting]));

			require($this->plugin['short'].'.admin.php');
		}

		function process_upload($upload) {
			if (is_array($upload))
				extract($upload);
			else
				return;

			if ($error)
				$errors[] = (isset($this->uploads['errors'][$error])) ? $this->uploads['errors'][$error] : 'An unknown error occurred and %s could not be uploaded';

			if (!in_array($type, $this->uploads['types']))
				$errors[] = '%s is not a supported file type';

			if (!$size) 
				$errors[] = '%s is not a useful file';

			if (!isset($errors)) {
				if (!file_exists($this->paths['uploads'])) {
					if (!mkdir($this->paths['uploads']))
						$errors[] = $this->paths['uploads'].' could not be created';
				}
			}

			if (!isset($errors)) {
			
				$ext = strrchr($name, '.');
				$full_name = trailingslashit($this->paths['uploads']).preg_replace('/[^\w-]/', '', substr($name, 0, -strlen($ext))).$ext;
				list($width, $height) = getimagesize($tmp_name);

				if (move_uploaded_file($tmp_name, $full_name)) {
					$this->image['u'] = $this->get_files($this->paths['uploads']);
					list($width, $height) = getimagesize($full_name);
					if ($width > 48 || $height > 48)
						image_resize($full_name, 48, 48, false, $this->image['r'], $this->paths['uploads']);
					$result = '%s was uploaded and processed successfully!';
				} else
					$errors[] = '%s could not be moved. Process failed';
			}

			if (isset($errors)) {
				$result = 'The upload failed for the following reason'.((count($error) > 1) ? 's' : '').":\n<ul style=\"list-style: disc; margin-left: 25px;\">\n";
				foreach ($errors as $error)
					$result.= '<li>Error Message ['.rand(1000, 9999)."]: $error.</li>\n";
				$result.= '</ul>';
			}
			return sprintf($result, $name);


		}

		function fix_values($posted_settings, $display_call = false) {
			if ($posted_settings) {
				$old_settings = ($display_call) ? '' : $this->get_settings();
				$defaults = $this->defaults;

				foreach ($posted_settings as $name => $value) {
					$name = str_replace($this->plugin['short'].'_', '' , $name);
					if (array_key_exists($name, $defaults))
						$new_settings[$name] = $value;
				}

				foreach ($new_settings as $name => $value) {
					if (in_array($name, $this->to_fix['integers']))
						$value = intval(trim($value));
					elseif (in_array($name, $this->to_fix['all_classes']))
						$value = preg_replace('/[^\w\s-%]/', '', trim($value));
					elseif (in_array($name, $this->to_fix['cat_ids']))
						$value = preg_replace('/[^,\d]/', '', $value);
					elseif ($name == 'entry_layout') {
						$meta_tags = array('%feed_link', '%cat_link');
						foreach ($meta_tags as $meta_tag) {
							$pos = strpos($value, $meta_tag);
							if ($pos !== false)
								$temp[$pos] = $meta_tag;
						}
						ksort($temp);
						$value = implode($temp);
					}
					$new_settings[$name] = $value;
				}

				foreach ($this->to_fix['linked'] as $setting => $tag)
					$new_settings[$setting] = str_replace($tag, '', $new_settings[$setting]);
	
	
				foreach ($this->to_fix['auto_default'] as $setting)
					$new_settings[$setting] = $defaults[$setting];
	
				foreach ($this->to_fix['conditional_default'] as $setting) {
					if (!$new_settings[$setting])
						$new_settings[$setting] = $defaults[$setting];
				}
	
				if (version_compare(PHP_VERSION, '5', '>='))
					require_once($this->plugin['short'].'.stripper5.php');
				elseif (version_compare(PHP_VERSION, '4', '>='))
					require_once($this->plugin['short'].'.stripper4.php');

				foreach ($this->to_fix['strip_tags'] as $setting) {
					if (!$display_call)
						$new_settings[$setting] = stripslashes($new_settings[$setting]);

					$new_settings[$setting] = html_entity_decode($new_settings[$setting]);
					if (in_array($setting, $this->to_fix['strip_all']))
						$new_settings[$setting] = htmlentities(strip_tags($new_settings[$setting]));
					else {
						$strip_attributes = new strip_attributes();
						$strip_attributes->allow = array('class', 'id', 'style');
						$strip_attributes->exceptions = array();  
						$strip_attributes->ignore = array();  
						$new_settings[$setting] = strip_tags($new_settings[$setting], '<span>');
						$new_settings[$setting] = htmlentities($strip_attributes->strip($new_settings[$setting]));
					}
				}

				foreach ($new_settings['custom_cats'] as $id => $attributes) {
					$url = (empty($new_settings['custom_cats'][$id]['link_href'])) ? $defaults['custom_cats'][$id]['link_href'] : $new_settings['custom_cats'][$id]['link_href'];

					$new_settings['custom_cats'][$id]['link_href'] = ($display_call) ? clean_url(strip_tags(html_entity_decode($url))) : sanitize_url(strip_tags(stripslashes($url)));
				}

				if ($new_settings['height_enabled'] && !$new_settings['height'])
					$new_settings['height'] = 3;

				if ($new_settings['depth_limit'] < $defaults['depth_limit'])
					$new_settings['depth_limit'] = $defaults['depth_limit'];

				if ($new_settings['depth_limit'] > 50)
					$new_settings['depth_limit'] = 50;

				if ($new_settings['include'] && $new_settings['exclude'])
					$new_settings['exclude'] = '';


				$img_srcs = array($new_settings['image_src']);			

				if (!$new_settings['image_w'] && !$new_settings['image_h']) {
					$new_settings['image_w'] = $defaults['image_w'];
					$new_settings['image_h'] = $defaults['image_h'];
				}


				if (!$display_call && $new_settings['image_src'] && ($new_settings['image_src'] != $old_settings['image_src']) && ($new_settings['image_w'] == $old_settings['image_w']) && ($new_settings['image_h'] == $old_settings['image_h'])) {
					list($width, $height) = getimagesize(str_replace($this->urls['site'], $this->paths['site'], $new_settings['image_src']));
					$new_settings['image_w'] = $width;
					$new_settings['image_h'] = $height;
				}

				foreach ($new_settings['custom_cats'] as $id => $attributes) {
					if (!$new_settings['custom_cats'][$id]['image_w'] && !$new_settings['custom_cats'][$id]['image_h']) {
						$new_settings['custom_cats'][$id]['image_w'] = $defaults['image_w'];
						$new_settings['custom_cats'][$id]['image_h'] = $defaults['image_h'];
					}
					if (!$display_call && $new_settings['custom_cats'][$id]['image_src'] && ($new_settings['custom_cats'][$id]['image_src'] != $old_settings['custom_cats'][$id]['image_src']) && ($new_settings['custom_cats'][$id]['image_w'] == $old_settings['custom_cats'][$id]['image_w']) && ($new_settings['custom_cats'][$id]['image_h'] == $old_settings['custom_cats'][$id]['image_h'])) {
						list($width, $height) = getimagesize(str_replace($this->urls['site'], $this->paths['site'], $new_settings['custom_cats'][$id]['image_src']));
						$new_settings['custom_cats'][$id]['image_w'] = $width;
						$new_settings['custom_cats'][$id]['image_h'] = $height;
					}

					$img_srcs[$id] = $new_settings['custom_cats'][$id]['image_src'];
				}

				if (!$display_call && $new_settings['image_delete']) {
					foreach ($img_srcs as $id => $src) {
						if ($new_settings['image_delete'] == $src) {
							if ($id < 1) {
								$new_settings['image_src'] = '';
								$new_settings['image_w'] = $this->defaults['image_w'];
								$new_settings['image_h'] = $this->defaults['image_h'];
							} else {
								$new_settings['custom_cats'][$id]['image_src'] = '';
								$new_settings['custom_cats'][$id]['image_w'] = $this->defaults['image_w'];
								$new_settings['custom_cats'][$id]['image_h'] = $this->defaults['image_h'];
							}
							$img_srcs[$id] = '';
						} 
					}
					$images[] = $this->paths['site'].$new_settings['image_delete'];
					$ext = strrchr($images[0], '.');
					$images[] = substr($images[0], 0, -strlen($ext)).'-'.$this->image['r'].$ext;
					foreach ($images as $image) {
						if (file_exists($image))
							unlink($image);
					}
					$new_settings['image_delete'] = '';
					$this->image['u'] = $this->get_files($this->paths['uploads']);
					$this->image['i'] = $this->get_files($this->paths['images']);
				}

				$alt = ' alt="Image for '.get_option('blogname').'"';
				$class = ($new_settings['image_class']) ? ' class="'.$new_settings['image_class'].'"' : '';

				foreach ($img_srcs as $id => $src) {
					if ($id < 1) {
						if ($src) {
							$width = ($new_settings['image_w']) ? " width=\"$new_settings[image_w]\"" : '';
							$height = ($new_settings['image_h']) ? " height=\"$new_settings[image_h]\"" : '';
							$new_settings['image_tag'] = "<img$width$height$alt$class src=\"$src\" />";
							$new_settings['image_admin'] = '<img height="'.(($new_settings['image_h'] > 20) ? 20 : $new_settings['image_h'])."\"$alt src=\"$src\" />";
						} else {
							$new_settings['image_tag'] = '';
							$new_settings['image_admin'] = '';
						}
					} else {
						if ($src) {
							$width = ($new_settings['custom_cats'][$id]['image_w']) ? ' width="'.$new_settings['custom_cats'][$id]['image_w'].'"' : '';
							$height = ($new_settings['custom_cats'][$id]['image_h']) ? ' height="'.$new_settings['custom_cats'][$id]['image_h'].'"' : '';
							$new_settings['custom_cats'][$id]['image_tag'] = "<img$width$height$alt$class src=\"$src\" />";
						} else
							$new_settings['custom_cats'][$id]['image_tag'] = '';
					}
				}
	
				if ($new_settings['style_is_list'])
					$new_settings['col_tag'] = ($new_settings['list_type'] == 'unordered') ? 'ul' : 'ol';
				else
					$new_settings['col_tag'] = 'div';
	
				if ($new_settings['height_enabled']) {
					if ($new_settings['keep_family'] && $new_settings['depth'] == -1)
						$new_settings['keep_family'] = '';
				}
	
				return $new_settings;
			}
		}

		function set_custom_cats() {
			$results = array();
			$cats = get_categories(array('hide_empty' => 0));
			$cat_IDs = array();
			if (!empty($cats)) {
				foreach ($cats as $key => $attributes) {
					foreach ($attributes as $attribute => $value) {
						if ($attribute == 'cat_ID')
							$cat_IDs[] = $value;
					}
				}
				foreach ($cat_IDs as $cat_ID) {
					$results[$cat_ID]['link_href'] = 'http://';
					$results[$cat_ID]['link_target'] = '0';
					$results[$cat_ID]['image_src'] = '0';
					$results[$cat_ID]['image_tag'] = '0';
					$results[$cat_ID]['image_w'] = $this->image['w'];
					$results[$cat_ID]['image_h'] = $this->image['h'];
				}
			}

			return $results;
		}


		function list_options($option = '', $tag_name = 'image_src', $cat_ID = '') {
			$settings = $this->get_settings();
			$output = '';

			switch ($option) {
				case 'parents':
					global $wpdb;
					$cats = (array)$wpdb->get_results("
						SELECT		{$wpdb->prefix}term_taxonomy.parent as parent
						FROM		{$wpdb->prefix}term_taxonomy 
						WHERE		{$wpdb->prefix}term_taxonomy.taxonomy = 'category' 
						AND			{$wpdb->prefix}term_taxonomy.parent > 0
					");
					if (!empty($cats)) {
						foreach ($cats as $cat) {
							if ($cat->parent)
								$parents[$cat->parent] = get_cat_name($cat->parent);
						}
					}
					if ($parents) {
						foreach ($parents as $id => $name) {
							$selected = '';
							if ($id == $settings['child_of'])
								$selected = ' selected="selected"';
							$output.= '<option value="'.$id.'"'.$selected.'>'.$name.'&nbsp;&nbsp;</option>';
						}
					}
				break;
				case 'images':
					$files = ($this->image['u']) ? array_unique(array_merge($this->image['u'], $this->image['i'])) : $this->image['i'];
					if (!$files)
						break;
					$images = array();
					$classes = array();
					$labels = array('Uploaded Images' => $this->plugin['dirs']['uploads'], 'Dark Background GIFs' => 'gif-dark', 'Light Background GIFs' => 'gif-light', 'Black Background JPG' => 'jpg-black', 'White Background JPGs' => 'jpg-white', 'Transparent PNGs' => 'png-trans', 'Colored PNGs' => 'png-color', 'Balloons PNGs' => 'png-balloon', 'Billboard PNGs' => 'png-billboard', 'Coffee Cup PNGs' => 'png-coffeecup', 'Newspaper Reader PNGs' => 'png-newspaper');
					foreach ($labels as $label => $dir) {
						foreach ($files as $key => $file) {
							if (strstr($file, $dir) && !strstr($file, $this->image['r'])) {
								$src = str_replace($this->paths['site'], $this->urls['site'], $file);
								$images[$dir][0] = '<optgroup label="'.$label.':&nbsp;&nbsp;&nbsp;">'."\n";
								$images[$dir][] = $src;
								unset($files[$key]);
							}
						}
					}
					if ($cat_ID)
						$option_value = (isset($settings[$tag_name][$cat_ID]['image_src'])) ? $settings[$tag_name][$cat_ID]['image_src'] : '0';
					else
						$option_value = $settings[$tag_name];

					if ($tag_name == 'image_src')
						$option_none = 'Not enabled';
					elseif ($cat_ID)
						$option_none = 'Custom image not enabled';
					else
						$option_none = 'No image chosen';
					$tag_name.= ($cat_ID) ? '['.$cat_ID.'][image_src]' : '';

					$output.= '<select name="'.$this->plugin['short'].'_'.$tag_name.'">'."\n";
					$output.= '<option value="0"'.((!$option_value) ? ' selected="selected"' : '').'> '.$option_none.'</option>'."\n";
					foreach ($images as $group) {
						foreach ($group as $key => $src) {
							if ($key < 1)
								$output.= $src;
							else {
								list($width, $height) = getimagesize(str_replace($this->urls['site'], $this->paths['site'], $src));
								$ext = strrchr($src, '.');
								$name = str_replace('/', '', strrchr(substr($src, 0, -strlen($ext)), '/'));
								$name = ((strlen($name) > 7) ? substr($name, 0, 7) : $name).$ext;
								if (strstr($src, trailingslashit($this->urls['uploads'])))
									$class = 'upl_'.substr($src, strpos($src, trailingslashit($this->urls['uploads']))+strlen(trailingslashit($this->urls['uploads'])));

								elseif (strstr($src, trailingslashit($this->urls['images'])))
									$class = substr($src, strpos($src, trailingslashit($this->urls['images']))+strlen(trailingslashit($this->urls['images'])));

								$class = $this->plugin['short'].'_'.str_replace('/', '_', substr($class, 0, strrpos($class, '.')));
								$classes[$class] = "$width,$height,$src";

								$selected = '';
								if ($src == $option_value)
									$selected = ' selected="selected"';

								$output.= '<option class="'.$class.'" value="'.$src.'"'.$selected.'>'.$width.' x '.$height.' - '.$name.'</option>'."\n";
							}
							if ($key == count($group)-1)
								$output.= '</optgroup>'."\n";
						}
					}
					$output.= '</select>'."\n";
					if ($tag_name == 'image_src') {
						$output.= '<style type="text/css">'."\n";
						foreach ($classes as $class => $info) {
							list($width, $height, $src) = explode(',', $info);
							if ($width > 48 || $height > 48) {
								$ext = strrchr($src, '.');
								$src = substr($src, 0, -strlen($ext)).'-'.$this->image['r'].$ext;
								list($width, $height) = getimagesize(str_replace($this->urls['site'], $this->paths['site'], $src));
							}
	
							switch($height) {
								default:case ($height < 11):
									$em = '1';
								break;
								case ($height < 17):
									$em = '1.1';
								break;
								case ($height < 25):
									$em = '1.2';
								break;
								case ($height < 33):
									$em = '1.3';
								break;
								case ($height > 32 ):
									$em = '1.4';
								break;
							}
							$output.= '.'.$class.' { background-image: url(\''.$src.'\'); background-position: center right; background-repeat: no-repeat; margin: 5px 0; font-size: '.$em.'em; text-indent: 5px; '.(($height > $this->image['h']) ? ' height: '.$height.'px;' : '').' }'."\n";
						}
						$output.= '</style>';
					}

				break;
				case 'cat_classes':
					$cat_classes = array('current_class' => 'current category', 'parent_class' => 'parent category', 'current_parent_class' => 'current category\'s parent', 'child_class' => 'child category');
					$output.= '<div class="alignleft"><ul><li style="padding-top: 0;"><div>Use category description as title when it\'s available?</div><input type="radio" class="radio" name="'.$this->plugin['short'].'_use_desc_for_title" value="1"'.(($settings['use_desc_for_title']) ? ' checked="checked"' : '').' /> Yes&nbsp;&nbsp;<input type="radio" class="radio" name="'.$this->plugin['short'].'_use_desc_for_title" value="0"'.((!$settings['use_desc_for_title']) ? ' checked="checked"' : '').' /> No</li></ul></div><div class="alignright">';
					foreach ($cat_classes as $name => $description)
						$output.= "<div>$description class(es)=&quot;<input name=\"{$this->plugin['short']}_$name\" type=\"text\" value=\"$settings[$name]\" size=\"6\" />&quot;&gt;</div>\n";

					$output.= '</div>';
				break;
				case 'custom_cats':
					$custom_cats = $this->set_custom_cats();
					if (empty($custom_cats))
						$output.= '<h3>You have no categories! <a href="categories.php">Go set yourself up some.</a></h3>';
					else {
						foreach ($custom_cats as $id => $attributes) {						
							if (isset($settings['custom_cats'][$id])) {
								foreach ($settings['custom_cats'][$id] as $attribute => $value)
									$custom_cats[$id][$attribute] = $value;
							}

							$output.= '<div class="heading-display">'.get_cat_name($id).':</div><div class="values">&lt;a href=&quot;<input name="'.$this->plugin['short'].'_custom_cats['.$id.'][link_href]" type="text" value="'.$custom_cats[$id]['link_href'].'" size="10" />&quot;&nbsp;&nbsp;target=&quot;<select name="'.$this->plugin['short'].'_custom_cats['.$id.'][link_target]"><option value="0"'.((!$custom_cats[$id]['link_target']) ? ' selected="selected"' : '').'>None&nbsp;&nbsp;</option><option value="_blank"'.(($custom_cats[$id]['link_target'] == '_blank') ? ' selected="selected"' : '').'>_blank&nbsp;&nbsp;</option><option value="_self"'.(($custom_cats[$id]['link_target'] == '_self') ? ' selected="selected"' : '').'>_self&nbsp;&nbsp;</option></select>&quot;&gt;&nbsp;&nbsp;&lt;img src=&quot;'.$this->list_options('images', 'custom_cats', $id).'&quot;&nbsp;&nbsp;width=&quot;<input name="'.$this->plugin['short'].'_custom_cats['.$id.'][image_w]" type="text" value="'.$custom_cats[$id]['image_w'].'" size="1" />&quot;&nbsp;&nbsp;height=&quot;<input name="'.$this->plugin['short'].'_custom_cats['.$id.'][image_h]" type="text" value="'.$custom_cats[$id]['image_h'].'" size="1" />&quot; /&gt;</div>'."\n";
						}
					}
				break;
				default:break;
			}
			return $output;
		}
		function rmdirr($dirname) {
			if (!file_exists($dirname))
				return false;

			if (is_file($dirname) || is_link($dirname))
				return unlink($dirname);

			$dir = dir($dirname);
			while (false !== $entry = $dir->read()) {
				if ($entry == '.' || $entry == '..')
					continue;
					
				$this->rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
			}
			$dir->close();
			return rmdir($dirname);
		}
		
		function get_files($from = '.') {
		    if(!is_dir($from))
		        return false;
			$files = array();
			$dirs = array($from);
			while(NULL !== ($dir = array_pop($dirs))) {
				if($dh = opendir($dir)) {
					while(false !== ($file = readdir($dh))) {
						if($file == '.' || $file == '..')
							continue;
						$path = $dir . '/' . $file;
						if(is_dir($path))
							$dirs[] = $path;
						else
							$files[] = $path;
					}
					closedir($dh);
				}
			}
			return $files;
		}

		function list_cats($user_settings = array()) {
			if (!empty($user_settings)) {
				$user_settings = array_merge($this->get_settings(), $user_settings);
				$r = $this->fix_values($user_settings, true);
			} else {
				$r = $this->get_settings();
				foreach ($r['custom_cats'] as $id => $attributes)
					$r['custom_cats'][$id]['link_href'] = clean_url(html_entity_decode($r['custom_cats'][$id]['link_href']));
			}
			foreach ($this->to_fix['strip_tags'] as $setting)
				$r[$setting] = html_entity_decode($r[$setting]);


			$r['_inner_class'] = (!empty($r['inner_class'])) ? $r['inner_class'].' ' : '';

			foreach ($this->to_fix['all_classes'] as $class) {
				if ($r[$class] && !in_array($class, $this->to_fix['arr_classes']))
					$r[$class] = " class=\"$r[$class]\"";
			}

			if ($r['height_enabled']) {
				$r['col_count'] = 0;
				$r['hgt_count'] = 0;
			}
			if ($r['exclude'] && $r['hierarchical']) {
				$r['exclude_tree'] = $r['exclude'];
				$r['exclude'] = '';
			}
			if ($r['orderby'] == 'time') {
				$r['orderby'] = $this->defaults['orderby'];
				$orderby_time = true;
			}
			extract($r);
			$categories = get_categories($r);

			if ($style_is_list)
				$output = ($wrap) ? "<ul><li$outer_class>" : '';
			else
				$output = ($wrap) ? "<div$outer_class>" : '';
		
			$output.= $title_li."\n".((!$height_enabled && $style_is_list) ? "<$col_tag$inner_class>" : '');

			if (empty($categories))
				$output.= (($style_is_list) ? '<li>' : '').__('No categories').(($style_is_list) ? '</li>' : '');
			else {
				global $wp_query;

				if (isset($orderby_time)) {
					$timestamps = array();

					foreach ($categories as $key => $attributes) {
						foreach ($attributes as $attribute => $value) {
							if ($attribute == 'cat_ID' && $this->get_last_update_timestamp($value))
								$timestamps[$key] = $this->get_last_update_timestamp($value);
						}
					}

					if (!empty($timestamps)) {
						if ($order == 'ASC')
							asort($timestamps);
						else {
							arsort($timestamps);
							if (!empty($categories))
								$categories = array_reverse($categories, true);
						}
						foreach ($timestamps as $key => $timestamp) {
							$timestamps[$key] = $categories[$key];
							unset($categories[$key]);
						}
						$categories = (!empty($categories)) ? array_values($timestamps + $categories) : $timestamps;

					}
				}

				if (empty($r['current_category']) && is_category())
					$r['current_category'] = $wp_query->get_queried_object_id();
		
				$depth = ($hierarchical) ? $r['depth'] : -1; // Flat.
				$output.= $this->walk_tree($categories, $depth, $r);
			}
		
			$output.= (!$height_enabled && $style_is_list) ? "</$col_tag>" : '';
		
			if ($style_is_list)
				$output.= ($wrap) ? '</li></ul>' : '';
			else
				$output.= ($wrap) ? '</div>' : '';
		
			return apply_filters('wp_list_categories', $output);
		}

		function walk_tree() {
			$args = func_get_args();
			return call_user_func_array(array(&$this, 'walk'), $args);
		}

		function walk($elements, $max_depth) {
			$args = array_slice(func_get_args(), 2);
			$output = '';

			if ($max_depth < -1) //invalid parameter
				return $output;
	
			if (empty($elements)) //nothing to walk
				return $output;
	
			$id_field = $this->db_fields['id'];
			$parent_field = $this->db_fields['parent'];
	

			if (-1 == $max_depth) {
				$empty_array = array();
				foreach ($elements as $e)
					$this->build_element($e, $empty_array, 1, 0, $args, $output, $heighter);

				if ($args[0]['height_enabled'])
					$output = $this->construct_heighter($heighter, $max_depth, $args);

				return $output;
			}
	
			$top_level_elements = array();
			$children_elements  = array();
			foreach ($elements as $e) {
				if (0 == $e->$parent_field)
					$top_level_elements[] = $e;
				else
					$children_elements[$e->$parent_field][] = $e;
			}
	
			if (empty($top_level_elements)) {
	
				$first = array_slice($elements, 0, 1);
				$root = $first[0];
	
				$top_level_elements = array();
				$children_elements  = array();
				foreach ($elements as $e) {
					if ($root->$parent_field == $e->$parent_field)
						$top_level_elements[] = $e;
					else
						$children_elements[$e->$parent_field][] = $e;
				}
			}
	

			foreach ($top_level_elements as $e)
				$this->build_element($e, $children_elements, $max_depth, 0, $args, $output, $heighter);

			if (($max_depth == 0) && count($children_elements) > 0) {
				$empty_array = array();
				foreach ($children_elements as $orphans)
					foreach($orphans as $op)
						$this->build_element($op, $empty_array, 1, 0, $args, $output, $heighter);
			 }


			if ($args[0]['height_enabled'])
				$output = $this->construct_heighter($heighter, $max_depth, $args);

			 return $output;
		}

		function construct_heighter($heighter, $max_depth, $args) {

			if ($args[0]['keep_family'] && $max_depth > -1) {
				$hgts_count = -1;
				foreach ($heighter as $category) {
					if ($category['level'] < 1)
						$hgts_count++;
			
					$catsbyhgt[$hgts_count][] = $category;
				}
			} else
				$catsbyhgt = array_chunk($heighter, $args[0]['height']);
			
			$result = '';
			$col_count = 0;
			foreach($catsbyhgt as $hgt_cluster) {
				$hgt_count = 0;
				$hgts_count = count($hgt_cluster);
				foreach($hgt_cluster as $key => $category) {
					$hgt_count++;
					if ($hgt_count == 1) {
						$col_count++;
						$cluster_class = array();
						if ($args[0]['_inner_class'])
							$cluster_class[] = $args[0]['_inner_class'];
						if ($args[0]['height_class'])
							$cluster_class[] = str_replace('%ID', $col_count, $args[0]['height_class']);

						$cluster_class = (!empty($cluster_class)) ? ' class="'.implode(' ', $cluster_class).'"' : '';

						$temp = "\n<".$args[0]['col_tag'].$cluster_class.">\n";
						for ($i = 1; $i <= $category['level']; $i++) {
							$temp.= ($args[0]['style_is_list']) ? "<li>\n" : '';
							$temp.= '<'.$args[0]['col_tag'].$args[0]['children_class'].">\n";
						}
						$category['output'] = "$temp$category[output]\n";
					}
			
					if ($hgt_count > 1 && $hgt_cluster[$key-1]['level'] < $category['level']) // IF 2  3
						$category['output'] = "\n<".$args[0]['col_tag'].$args[0]['children_class'].">$category[output]";
						
					if ($hgt_count < $hgts_count && $category['level'] >= $hgt_cluster[$key+1]['level']) // IF 2  2
						$category['output'].= ($args[0]['style_is_list']) ? "</li>\n" : '';
			
					if ($hgt_count < $hgts_count && $category['level'] > $hgt_cluster[$key+1]['level']) { // IF 3  2
						for ($i = 0; $i < ($category['level']-$hgt_cluster[$key+1]['level']); $i++) {
							$category['output'].= '</'.$args[0]['col_tag'].">\n";
							$category['output'].= ($args[0]['style_is_list']) ? "</li>\n" : '';
						}
					}
					if ($hgt_count == $hgts_count) {
						for ($i = 0; $i <= $category['level']; $i++) {
							$category['output'].= ($args[0]['style_is_list']) ? "</li>\n" : '';
							$category['output'].= '</'.$args[0]['col_tag'].">\n";
						}
			
					}
					$result.= $category['output'];
				}
			}
			
			return $result;
	
		}


		function build_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output, &$heighter) {
			if (!$element)
				return;
			$id_field = $this->db_fields['id'];
			$id = $element->$id_field;

			if (is_array($args[0])) {
				$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
				$args[0]['is_child'] = false;
				if ($element->parent)
					$args[0]['is_child'] = true;
			}

			if ($args[0]['height_enabled']) {

				$cb_args = array_merge(array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'start_el'), $cb_args);
				$heighter[] = array('output' => $output, 'level' => $depth);
				$output = '';
				if (($max_depth == 0 || $max_depth > $depth+1) && isset($children_elements[$id])) {
					foreach($children_elements[$id] as $child)
						$this->build_element($child, $children_elements, $max_depth, $depth+1, $args, $output, $heighter);
						unset($children_elements[$id]);
				}
	
			} else {
	
				$cb_args = array_merge(array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'start_el'), $cb_args);
		
				if (($max_depth == 0 || $max_depth > $depth+1) && isset($children_elements[$id])) {
					foreach($children_elements[$id] as $child){
						if (!isset($newlevel)) {
							$newlevel = true;
							$cb_args = array_merge(array(&$output, $depth), $args);
							call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
						}
						$this->build_element($child, $children_elements, $max_depth, $depth+1, $args, $output, $heighter);
					}
					unset($children_elements[$id]);
				}
		
				if (isset($newlevel) && $newlevel){
					$cb_args = array_merge(array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
				}
				$cb_args = array_merge(array(&$output, $element, $depth), $args);
				call_user_func_array(array(&$this, 'end_el'), $cb_args);
			}
		}
	
		function start_lvl(&$output, $depth, $args) {
			$indent = str_repeat("\t", $depth);
			$output.= "\n$indent<$args[col_tag]$args[children_class]>\n";
		}
	
		function end_lvl(&$output, $depth, $args) {
			$indent = str_repeat("\t", $depth);
			$output.= "$indent</$args[col_tag]>\n";
		}
	
		function get_last_update_timestamp($id) {
			global $wpdb;
			$post_date = (array)$wpdb->get_results("
				SELECT		UNIX_TIMESTAMP(MAX({$wpdb->prefix}posts.post_date)) as timestamp
				FROM		{$wpdb->prefix}posts, {$wpdb->prefix}terms, {$wpdb->prefix}term_taxonomy, {$wpdb->prefix}term_relationships
				WHERE		{$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id 
				AND			{$wpdb->prefix}term_relationships.object_id = {$wpdb->prefix}posts.ID
				AND			{$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id 
				AND			{$wpdb->prefix}terms.term_id  = {$wpdb->prefix}term_taxonomy.term_id 
				AND			{$wpdb->prefix}term_taxonomy.taxonomy = 'category' 
				AND			post_status = 'publish' 
				AND			post_type = 'post' 
				AND			{$wpdb->prefix}terms.term_id = {$id}
				AND			post_password = '' 
				ORDER BY	post_date_gmt DESC
			");
			return $post_date[0]->timestamp;
		}

		function start_el(&$output, $category, $depth, $args) {
			extract($args);
			$cat_name = apply_filters('list_cats', attribute_escape($category->name), $category);

			$cat_class = array();
			$_current_category = ($current_category) ? get_category($current_category) : '';

			if ($category_class)
				$cat_class[] = $category_class;
			if ($parent_class && $has_children)
				$cat_class[] = $parent_class;
			if ($child_class && $is_child)
				$cat_class[] = $child_class;
			if ($current_class && $current_category && ($category->term_id == $current_category))
				$cat_class[] =  $current_class;
			if ($current_parent_class && $_current_category && ($category->term_id == $_current_category->parent))
				$cat_class[] =  $current_parent_class;

			$cat_class = (!empty($cat_class)) ? ' class="'.implode(' ', $cat_class).'"' : '';

			if (isset($custom_cats[$category->term_id]['link_href']) && $custom_cats[$category->term_id]['link_href'] != 'http://') {
				$cat_link = $custom_cats[$category->term_id]['link_href'];
				$cat_link_title = 'Link To '.$cat_link;
			} else {
				$cat_link = get_category_link($category->term_id);
				$cat_link_title = ($cat_link_title) ? ((!$use_desc_for_title || empty($category->description)) ? str_replace('%s', $cat_name, $cat_link_title) : attribute_escape(apply_filters('category_description', $category->description, $category))) : '';
			}

			$cat_link_title = ($cat_link_title) ? " title=\"$cat_link_title\"" : '';

			$cat_link_target = (isset($custom_cats[$category->term_id]['link_target']) && $custom_cats[$category->term_id]['link_target']) ? ' target="'.$custom_cats[$category->term_id]['link_target'].'"' : '';

			$meta_tags['%cat_link'] = $cat_link_before.'<a href="'.$cat_link.'"'.$cat_link_title.$cat_class.$cat_link_target.'>'.$cat_link_text.'</a>'.$cat_link_after;

			$meta_tags['%feed_link'] = $feed_link_before.'<a href="'.get_category_feed_link($category->term_id, '').'"'.(($feed_link_title) ? ' title="'.((!$use_desc_for_title || empty($category->description)) ? str_replace('%s', $cat_name, $feed_link_title) : attribute_escape(apply_filters('category_description', $category->description, $category))).'"' : '').$feed_class.'>'.$feed_link_text.'</a>'.$feed_link_after;

			$meta_tags['%count'] = "<span$count_class>$count_before".(($count_format) ? $this->num_to_words($category->count) : $category->count )."$count_after</span>";
			$category->last_update_timestamp = $this->get_last_update_timestamp($category->term_id);
			
			$meta_tags['%date'] = ($category->last_update_timestamp) ? "<span$date_class>".gmdate($date_format, $category->last_update_timestamp).'</span>' : '';

			$image = (isset($custom_cats[$category->term_id]['image_tag']) && $custom_cats[$category->term_id]['image_tag']) ? $custom_cats[$category->term_id]['image_tag'] : $image_tag;
			if ($image)
				$meta_tags['%image'] = $image;


			$meta_tags['%cat_name'] = $cat_name;
			$meta_tags['%ID'] = $category->term_id;
	   		$entry_layout = (($args['style_is_list']) ? "<li$cat_class>" : '').$entry_layout;

			foreach ($meta_tags as $search => $replace) {
				if (strstr($entry_layout, $search))
					$entry_layout = str_replace($search, $replace, $entry_layout);
			}

	   		$output.= $entry_layout;
		}
	
		function end_el(&$output, $category, $depth, $args) {
			$output.= (($args['style_is_list']) ? '</li>' : '')."\n";
		}


		function num_to_words($x) {
		
			$nwords = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen', 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
		
			if (!is_numeric($x))
				$w = '#';
			elseif (fmod($x, 1) != 0)
				$w = '#';
			else {
				if ($x < 0) {
					$w = 'minus ';
					$x = -$x;
				} else
					$w = '';
				if ($x < 21)
					$w.= $nwords[$x];
				elseif ($x < 100) {
					$w.= $nwords[10 * floor($x/10)];
					$r = fmod($x, 10);
					if ($r > 0)
						$w .= '-'. $nwords[$r];
				} elseif ($x < 1000) {
					$w.= $nwords[floor($x/100)] .' hundred';
					$r = fmod($x, 100);
					if ($r > 0)
						$w .= ' and '. int_to_words($r);
				} elseif ($x < 1000000) {
					$w.= int_to_words(floor($x/1000)) .' thousand';
					$r = fmod($x, 1000);
					if ($r > 0) {
						$w.= ' ';
						if ($r < 100)
							$w .= 'and ';
						$w.= int_to_words($r);
					}
				} else {
					$w.= int_to_words(floor($x/1000000)) .' million';
					$r = fmod($x, 1000000);
					if($r > 0) {
						$w.= ' ';
						if($r < 100)
							$word .= 'and ';
						$w .= int_to_words($r);
					}
				}
			}
			return $w;
		}

	}

}

$viscats = new viscats_class();

require_once($viscats->plugin['short'].'.widget.php');
add_action('activate_'.trailingslashit($viscats->admin['name']).basename(__FILE__), array(&$viscats, 'install'));
add_action('admin_menu', array(&$viscats, 'add_page'));
add_action('admin_init', array($viscats, 'admin_initialize'));

if (!function_exists('get_visCats')) {
	function get_visCats($echo = 1, $settings = array()) {
		global $viscats;
		$output = $viscats->list_cats($settings);
		if ($echo)
			echo $output;
		else
			return $output;
	}
}
?>