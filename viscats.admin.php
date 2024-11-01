<div class="wrap">
	<style type="text/css">
		#<?php echo $this->plugin['short']; ?>_options { font-size: 12px; color: #333; }
		#<?php echo $this->plugin['short']; ?>_options .heading-section { font-size: 1.5em; margin-bottom: 0; padding-bottom: 0; color: #333;}
		#<?php echo $this->plugin['short']; ?>_options .heading-display { clear: both; font-weight: bold; padding: 10px 0 15px 1px; }
		#<?php echo $this->plugin['short']; ?>_options .submit { clear: both; }
		#<?php echo $this->plugin['short']; ?>_options ul { line-height: 1.3em; list-style: disc; margin-left: 20px; padding-top: 1px; }
		#<?php echo $this->plugin['short']; ?>_options ul li { padding-top: 4px; }
		#<?php echo $this->plugin['short']; ?>_options ul.rules { margin: 0 30px 15px 5px; border-left: 1px solid #A6A6A6; background: #E0FFFF; padding: 4px 15px 4px 30px; color: #000; }
		#<?php echo $this->plugin['short']; ?>_options .alignleft,
		#<?php echo $this->plugin['short']; ?>_options .alignright { margin: 5px 0; display: inline; }
		#<?php echo $this->plugin['short']; ?>_options .preliminary .alignleft,
		#<?php echo $this->plugin['short']; ?>_options .preliminary .alignright { width: 49%; }
		#<?php echo $this->plugin['short']; ?>_options .components .one { width: 280px; margin-left: 10px; }
		#<?php echo $this->plugin['short']; ?>_options .components .two { width: 230px; }
		#<?php echo $this->plugin['short']; ?>_options .components .three { width: 60px; margin-right: 5px;}
		#<?php echo $this->plugin['short']; ?>_options .components .four { width: 400px; overflow: hidden; margin-top: 0;}
		#<?php echo $this->plugin['short']; ?>_options .components .four .alignleft { width: 40%; }
		#<?php echo $this->plugin['short']; ?>_options .components .four .alignright { width: 60%; }
		#<?php echo $this->plugin['short']; ?>_options .links .one { width: 95px; margin-left: 5px; }
		#<?php echo $this->plugin['short']; ?>_options .links .two { width: 260px; }
		#<?php echo $this->plugin['short']; ?>_options .links .three { width: 310px; text-align: right; margin-right: 10px; }
		#<?php echo $this->plugin['short']; ?>_options .links .offset { margin-left: 100px; width: 570px; }
		#<?php echo $this->plugin['short']; ?>_options .links .offset .alignleft { width: 200px; }
		#<?php echo $this->plugin['short']; ?>_options .links .offset .alignright { width: 370px; text-align: right; }
		#<?php echo $this->plugin['short']; ?>_options .offset .alignleft div,
		#<?php echo $this->plugin['short']; ?>_options .offset .alignright div { margin-bottom: 10px; }
		#<?php echo $this->plugin['short']; ?>_options .custom .values { border-left: 1px solid #A6A6A6; padding: 2px 0 2px 10px; margin: 5px 0; }
		#<?php echo $this->plugin['short']; ?>_options input,
		#<?php echo $this->plugin['short']; ?>_options select { font-size: 11px; border: 1px solid #999; vertical-align: middle; }
		#<?php echo $this->plugin['short']; ?>_options input.radio { border-color: #FFF; }
	</style>
	<h2><?php echo $this->plugin['name'].' '.$this->version; ?> Settings</h2>
	<form method="post" enctype="multipart/form-data" action="<?php echo $this->admin['url']; ?>" id="<?php echo $this->plugin['short']; ?>_options"><?php settings_fields($this->plugin['admin']); ?>
		<div style="width: 1050px;">
			<h2 class="heading-section">Preliminary Settings</h2>
			<div style="width: 100%;" class="clear preliminary">
				<div style="width: 49%;" class="alignleft"><h3>Styling Options</h3>
					<div class="clear">
						<div class="alignleft">Wrap the entire Output?</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_wrap" value="1"<?php if($settings['wrap']) echo ' checked="checked"'; ?> /> Yes
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_wrap" value="0"<?php if(!$settings['wrap']) echo ' checked="checked"'; ?> /> No
						</div>
					</div>
					<div class="clear">
						<div class="alignleft">Output Title:</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_title_li" type="text" value="<?php echo $settings['title_li']; ?>" size="10" /></div>
					</div>
					<div class="clear">
						<div class="alignleft">Style in List Tags?</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_style_is_list" value="1"<?php if($settings['style_is_list']) echo ' checked="checked"'; ?> /> Yes (list tags)
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_style_is_list" value="0"<?php if(!$settings['style_is_list']) echo ' checked="checked"'; ?> /> No (div tags)
						</div>
					</div>
					<div class="clear">
						<div class="alignleft">Type of List:</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_list_type" value="unordered"<?php if($settings['list_type'] == 'unordered') echo ' checked="checked"'; ?> /> Unordered
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_list_type" value="ordered"<?php if($settings['list_type'] == 'ordered') echo ' checked="checked"'; ?> /> Ordered
						</div>
					</div>
					<div class="clear">
						<div class="alignleft">Order Categories By:</div>
						<div class="alignright">
							<select name="<?php echo $this->plugin['short']; ?>_orderby">
								<option value="ID"<?php if($settings['orderby'] == 'ID') echo ' selected="selected"'; ?>>ID Number </option>
								<option value="name"<?php if($settings['orderby'] == 'name') echo ' selected="selected"'; ?>>Name </option>
								<option value="slug"<?php if($settings['orderby'] == 'slug') echo ' selected="selected"'; ?>>Slug </option>
								<option value="count"<?php if($settings['orderby'] == 'count') echo ' selected="selected"'; ?>>Post Count</option>
								<option value="time"<?php if($settings['orderby'] == 'time') echo ' selected="selected"'; ?>>Timestamp of Most Recent Post&nbsp;&nbsp;</option>
							</select>
						</div>
					</div>
					<div class="clear">
						<div class="alignleft">Direction of Order:</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_order" value="ASC"<?php if($settings['order'] == 'ASC') echo ' checked="checked"'; ?> /> Ascending (1..4) (A..D)<br />
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_order" value="DESC"<?php if($settings['order'] == 'DESC') echo ' checked="checked"'; ?> /> Descending (4..1) (D..A)
						</div>
					</div>
				</div>			
				<div style="width: 49%;" class="alignright"><h3>Height Options</h3>
					<div class="clear">
						<div class="alignleft">Enable Height?</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_height_enabled" value="1"<?php if($settings['height_enabled']) echo ' checked="checked"'; ?> /> Yes
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_height_enabled" value="0"<?php if(!$settings['height_enabled']) echo ' checked="checked"'; ?> /> No
							<ul>
								<li>This option splits the category entries into columns based upon the value you enter below.</li>
							</ul>
						</div>
					</div>	
					<div class="clear">	
						<div class="alignleft">Number of Categories in Height:</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_height" type="text" value="<?php echo $settings['height']; ?>" size="10" /></div>
					</div>	
					<div class="clear">						
						<div class="alignleft">Keep Child with Parent?</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_keep_family" value="1"<?php if($settings['keep_family']) echo ' checked="checked"'; ?> /> Yes
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_keep_family" value="0"<?php if(!$settings['keep_family']) echo ' checked="checked"'; ?> /> No
						</div>
					</div>	
					<div class="clear">	
						<div class="alignleft">Height Cluster Class:</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_height_class" type="text" value="<?php echo $settings['height_class']; ?>" size="10" /></div>
					</div>	
				</div>
			</div>
			<div style="width: 100%;" class="clear preliminary">
				<div style="width: 49%;" class="alignleft"><h3>Class Names</h3>	
					<div class="clear">
						<ul class="rules">
							<li>You may enter multiple class names in each class textbox. Class names must be separated by a space. All characters except alphanumeric characters (ABC123), the hyphen (-), the underscore (_), and the space ( ) will be removed. </li>
							<li>Seperate class names with spaces.</li>
						</ul>
					</div>	
					<div class="clear">
						<div class="alignleft">Outer Class(es):</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_outer_class" type="text" value="<?php echo $settings['outer_class']; ?>" size="10" /></div>
					</div>	
					<div class="clear">
						<div class="alignleft">Inner Class(es):</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_inner_class" type="text" value="<?php echo $settings['inner_class']; ?>" size="10" /></div>
					</div>	
					<div class="clear">		
						<div class="alignleft">Children Cluster Class(es):</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_children_class" type="text" value="<?php echo $settings['children_class']; ?>" size="10" /></div>
					</div>
				</div>
				<div style="width: 49%;" class="alignright"><h3>Categories Display Options</h3>
					<div class="clear">
						<div class="alignleft">Depth:</div>
						<div class="alignright">
							<select name="<?php echo $this->plugin['short']; ?>_depth">
								<option value="-1"<?php if($settings['depth'] == -1) echo ' selected="selected"'; ?>>-1 - All Categories Displayed in Flat</option>
								<option value="0"<?php if($settings['depth'] == 0) echo ' selected="selected"'; ?>>0 - All Categories Displayed in Hierarchy&nbsp;&nbsp;</option>
								<option value="1"<?php if($settings['depth'] == 1) echo ' selected="selected"'; ?>>1 - Top level Categories Only </option>
								<option value="2"<?php if($settings['depth'] == 2) echo ' selected="selected"'; ?>>2 - up to 2nd level Categories</option>
								<option value="3"<?php if($settings['depth'] == 3) echo ' selected="selected"'; ?>>3 - up to 3rd level Categories</option>
								<option value="4"<?php if($settings['depth'] == 4) echo ' selected="selected"'; ?>>4 - up to 4th level Categories</option>
								<option value="5"<?php if($settings['depth'] == 5) echo ' selected="selected"'; ?>>5 - up to 5th level Categories</option>
								<?php if ($settings['depth_limit'] > 5) {
									for ($i = 6; $i <= $settings['depth_limit']; $i++)
										echo '<option value="'.$i.'"'.(($settings['depth'] == $i) ? ' selected="selected"' : '').'>'.$i.' - up to '.$i.'th level Categories</option>';
								} ?>
							</select>
						</div>
					</div>	
					<div class="clear">	
						<div class="alignleft">What's your category depth?</div>
						<div class="alignright">
							<input name="<?php echo $this->plugin['short']; ?>_depth_limit" type="text" value="<?php echo $settings['depth_limit']; ?>" size="3" />
							<ul>
								<li>If you have more than five category levels and want a higher cut-off point to appear in the dropdown menu above, enter the numerical level here and save the settings.</li>
							</ul>
						</div>
					</div>	
					<div class="clear">
						<div class="alignleft">Display Categories with No Posts?</div>
						<div class="alignright">
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_hide_empty" value="0"<?php if(!$settings['hide_empty']) echo ' checked="checked"'; ?> /> Yes
							<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_hide_empty" value="1"<?php if($settings['hide_empty']) echo ' checked="checked"'; ?> /> No
						</div>
					</div>	
					<div class="clear">						
						<div class="alignleft">Display Only the Child Categories Of:</div>
						<div class="alignright">
							<select name="<?php echo $this->plugin['short']; ?>_child_of">
								<option value="0"<?php if(!$settings['child_of']) echo ' selected="selected"'; ?>>N/A&nbsp;&nbsp;</option>
								<?php echo $this->list_options('parents'); ?>
							</select>
						</div>
					</div>	
					<div class="clear">
						<div class="alignleft">Include/Exclude:</div>
						<div class="alignright">
							<ul class="rules">
								<li><a href="http://codex.wordpress.org/Template_Tags/wp_list_categories#Include_or_Exclude_Categories" target="_blank">Click here for more information.</a></li>
								<li>Use only commas to seperate the category IDs (e.g. 1,44,6).</li>
							</ul>
						</div>
					</div>	
					<div class="clear">
						<div class="alignleft">Categories to Include:</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_include" type="text" value="<?php echo $settings['include']; ?>" size="10" /></div>
					</div>	
					<div class="clear">
						<div class="alignleft">Categories to Exclude:</div>
						<div class="alignright"><input name="<?php echo $this->plugin['short']; ?>_exclude" type="text" value="<?php echo $settings['exclude']; ?>" size="10" /></div>
					</div>
				</div>
			</div>
			<div class="submit">
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_save" value="<?php _e('Save All of These Settings'); ?>" />
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_reset" onClick="return confirm('Are you sure?')" value="<?php _e('Restore Default Settings'); ?>" />
			</div>	
			<h2 class="heading-section">Category Entry Display Settings</h2>
			<div style="width: 100%;" class="clear components">
				<h3>Post Count, Timestamp, and Image Display Options</h3>
				<div>
					<ul class="rules">
						<li>Each option allows you to build a display that can be included in or around your feed and category links.</li>
						<li>You may add %count, %date, and %image to the link display textboxes in the next section. This plugin assumes that you want the component to display when you add its respective % tag to a textbox in the next section.</li>
						<li>You may enter multiple class names in each class textbox. Class names must be separated by a space. All characters except alphanumeric characters (ABC123), the hyphen (-), the underscore (_), the space ( ), and the '%' will be removed. </li>
						<li>Standard-looking feed images taken from <a href="http://www.feedicons.com/" target="_blank">here</a>. Trendy feed images taken from <a href="http://fasticon.com/freeware/" target="_blank">here</a></li>
					</ul>
				</div>			
				<div class="heading-display">Display the current count of posts in each category (%count):</div>
				<div class="clear">
					<div class="alignleft one">&lt;span class(es)=&quot;<input name="<?php echo $this->plugin['short']; ?>_count_class" type="text" value="<?php echo $settings['count_class']; ?>" size="6" />&quot;&gt;</div>
					<div class="alignleft two"><input name="<?php echo $this->plugin['short']; ?>_count_before" type="text" value="<?php echo $settings['count_before']; ?>" size="1" /><select name="<?php echo $this->plugin['short']; ?>_count_format"><option value="0"<?php if(!$settings['count_format']) echo ' selected="selected"'; ?>>0, 1..10</option><option value="1"<?php if($settings['count_format']) echo ' selected="selected"'; ?>>zero, one..ten</option></select><input name="<?php echo $this->plugin['short']; ?>_count_after" type="text" value="<?php echo $settings['count_after']; ?>" size="1" /></div>
					<div class="alignleft three">&lt;/span&gt;</div>
					<div class="alignleft four">Pad the count calculation with child categories?&nbsp;&nbsp;<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_pad_counts" value="1"<?php if($settings['pad_counts']) echo ' checked="checked"'; ?> /> Yes&nbsp;&nbsp;<input type="radio" class="radio" name="<?php echo $this->plugin['short']; ?>_pad_counts" value="0"<?php if(!$settings['pad_counts']) echo ' checked="checked"'; ?> /> No</div>
				</div>	
						
				<div class="heading-display">Display the timestamp of when the category was last updated (%date):</div>
				<div class="clear">
					<div class="alignleft one">&lt;span class(es)=&quot;<input name="<?php echo $this->plugin['short']; ?>_date_class" type="text" value="<?php echo $settings['date_class']; ?>" size="6" />&quot;&gt;</div>
					<div class="alignleft two"><input name="<?php echo $this->plugin['short']; ?>_date_format" type="text" value="<?php echo $settings['date_format']; ?>" size="9" /></div>
					<div class="alignleft three">&lt;/span&gt;</div>
					<div class="alignleft four"><a href="http://www.php.net/manual/en/function.date.php" target="_blank">How to format your timestamp (currently: <?php echo $settings['date_format']; ?>)</a></div>
				</div>		

				<div class="heading-display">Display an image (%image):</div>
				<div class="clear">
					<div class="alignleft one">&lt;img class(es)=&quot;<input name="<?php echo $this->plugin['short']; ?>_image_class" type="text" value="<?php echo $settings['image_class']; ?>" size="6" />&quot;</div>
					<div class="alignleft two">width=&quot;<input name="<?php echo $this->plugin['short']; ?>_image_w" type="text" value="<?php echo $settings['image_w']; ?>" size="1" />&quot;&nbsp;&nbsp;height=&quot;<input name="<?php echo $this->plugin['short']; ?>_image_h" type="text" value="<?php echo $settings['image_h']; ?>" size="1" />&quot;</div>
					<div class="alignleft three" style="text-align: right;">src=&quot;</div>
					<div class="alignleft four">
						<div style="clear">
							<div class="alignleft">The default feed image:</div>
							<div class="alignright">
								<?php echo $this->list_options('images'); ?>&nbsp;<?php echo $settings['image_admin'] ?>
								<ul>
									<li>If you can't see the images in the dropdown box above, refer to this handy-dandy <a href="<?php echo trailingslashit($this->plugin['url']).$this->plugin['short']; ?>.images.png" target="_blank">image guide</a>.</li>
								</ul>
							</div>
							<div class="clear"></div>
						</div>
						<div style="clear">
							<div class="alignleft">Upload an image:</div>
							<div class="alignright">
								<input type="file" name="<?php echo $this->plugin['short']; ?>_image_upload" size="15" style="width: 177px;" />
								<ul>
									<li>Upon saving, your uploaded image will be available in the dropdown box above.</li>
								</ul>
							</div>
							<div class="clear"></div>
						</div>
						<div style="clear">
							<div class="alignleft">Delete an image:</div>
							<div class="alignright"><?php echo $this->list_options('images', 'image_delete'); ?></div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="alignleft">&nbsp;&quot; /&gt;</div>
				</div>

			</div>
			
			<div class="submit">
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_save" value="<?php _e('Save All of These Settings'); ?>" />
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_reset" onClick="return confirm('Are you sure?')" value="<?php _e('Restore Default Settings'); ?>" />
			</div>
			<div style="width: 100%;" class="clear links">
				<h3>Feed and Category Link Display Options</h3>
				<div>
					<ul class="rules">
						<li>In this section, you may add %cat_name (displays the category name), %ID (displays the category ID), %count (displays the current count of posts), %date (displays the timestamp of when the category was last updated), and %image (displays an image) to any textbox but a class textbox. You can add the % tags as many times as you desire.</li>
						<li>You may enter multiple class names in each class textbox. Class names must be separated by a space. All characters except alphanumeric characters (ABC123), the hyphen (-), the underscore (_), the space ( ), and the '%' will be removed. </li>
						<li>If you've chosen to style as a list, the category link classes will also be added to the &lt;li&gt; tags that wrap each category entry. You will need to use li.class and a.class in your stylesheet to differentiate. </li>
						<li>If you want to display a link to each category's feed, add %feed_link to the textbox with the <span style="color: 1px solid #FF0000;">red border</span> below, before or after %cat_link. Only %cat_link and %feed_link may be entered into the textbox. All other text will be removed.</li>
						<li><input name="<?php echo $this->plugin['short']; ?>_entry_layout" type="text" value="<?php echo $settings['entry_layout']; ?>" size="10" style="border: 1px solid #FF0000; font-size: 1.1em;" /></li>
					</ul>
				</div>			
				<div class="heading-display">Display a link to each category's RSS feed (%feed_link):</div>
				<div class="clear">
					<div class="alignleft one"><input name="<?php echo $this->plugin['short']; ?>_feed_link_before" type="text" value="<?php echo $settings['feed_link_before']; ?>" size="3" /></div>
					<div class="alignleft two">&lt;a title=&quot;<input name="<?php echo $this->plugin['short']; ?>_feed_link_title" type="text" value="<?php echo $settings['feed_link_title']; ?>" size="9" />&quot;</div>
					<div class="alignleft three"> class(es)=&quot;<input name="<?php echo $this->plugin['short']; ?>_feed_class" type="text" value="<?php echo $settings['feed_class']; ?>" size="8" />&quot;&gt;</div>
					<div class="alignleft four"><input name="<?php echo $this->plugin['short']; ?>_feed_link_text" type="text" value="<?php echo $settings['feed_link_text']; ?>" size="7" />&nbsp;&nbsp;&lt;/a&gt;</div>
					<div class="alignleft five"><input name="<?php echo $this->plugin['short']; ?>_feed_link_after" type="text" value="<?php echo $settings['feed_link_after']; ?>" size="3" /></div>
				</div>
				<div class="heading-display">Display a link to each category (%cat_link):</div>
				<div class="clear">		
					<div class="alignleft one"><input name="<?php echo $this->plugin['short']; ?>_cat_link_before" type="text" value="<?php echo $settings['cat_link_before']; ?>" size="3" /></div>
					<div class="alignleft two">&lt;a title=&quot;<input name="<?php echo $this->plugin['short']; ?>_cat_link_title" type="text" value="<?php echo $settings['cat_link_title']; ?>" size="9" />&quot;</div>
					<div class="alignleft three">category item class(es)=&quot;<input name="<?php echo $this->plugin['short']; ?>_category_class" type="text" value="<?php echo $settings['category_class']; ?>" size="6" />&quot;&gt;</div>
					<div class="alignleft four"><input name="<?php echo $this->plugin['short']; ?>_cat_link_text" type="text" value="<?php echo $settings['cat_link_text']; ?>" size="7" />&nbsp;&nbsp;&lt;/a&gt;</div>
					<div class="alignleft five"><input name="<?php echo $this->plugin['short']; ?>_cat_link_after" type="text" value="<?php echo $settings['cat_link_after']; ?>" size="3" /></div>
				</div>
				<div class="clear offset">
					<?php echo $this->list_options('cat_classes'); ?>
				</div>
			</div>
			<div class="submit">
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_save" value="<?php _e('Save All of These Settings'); ?>" />
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_reset" onClick="return confirm('Are you sure?')" value="<?php _e('Restore Default Settings'); ?>" />
			</div>
			<h2 class="heading-section">Custom Categories</h2>
			<div style="width: 100%;" class="clear custom">
				<div>
					<ul class="rules">
						<li>This is <em>not</em> where you set your permalink structure. Enter a custom link only if you, for whatever reason, need to override the URL to which your category is linked.</li>
						<li>You can change the URL to which each category is linked. This will override the category link's title tag. For example, if category 'A' is set to http://google.com, the title tag will contain "Link To http://google.com"</li>
						<li>Additionally, you can set the category link's target attribute, which will be applied to the category link whether or not you've entered a custom link, and the category entry's image, which will be applied to the %image tag used in the Feed and Category Link Display Options section.</li>
						<li>Because these values are stored in a multi-dimensional array, it is recommended that you do not personalize these settings in get_visCats().</li>
					</ul>
				</div>
				<div class="clear">
						<?php echo $this->list_options('custom_cats'); ?>
				</div>
			</div>
			<div class="submit">
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_save" value="<?php _e('Save All of These Settings'); ?>" />
				<input type="submit" name="<?php echo $this->plugin['short']; ?>_reset" onClick="return confirm('Are you sure?')" value="<?php _e('Restore Default Settings'); ?>" />
			</div>
		</div>	
			
	</form>
</div>