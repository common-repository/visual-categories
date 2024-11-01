=== Visual Categories ===
Contributors: wzeallor 
Tags: category, categories, widget
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 1.6.0
	
Take control over the way you display your categories.

== Description ==

This plugin enables you to build "category entries" which contain a link to the category and which may contain a link to the category's feed, an image, the timestamp of when the category was last updated, and the current count of posts in the category.

== Vocabulary ==

There are a few terms used throughout this guide that require explanations:

*   Output: The output is the entire structure. It is what's displayed. 

*   Cluster: A cluster is a group of category entries. A cluster is created when a 1 or more category entries must be set apart from the others. For example, a children cluster is created when a category has 1 or more children categories. As well, a height cluster (otherwise referred to as a column cluster), is created when categories are to be divided based upon your chosen height value. By default, a cluster is wrapped in `<ul>` tags.

*   Category Entry: A category entry is more than just a link to a category. A category entry has multiple components: A link to the category and may contain a link to the category's feed, a feed (RSS) image, the timestamp of whent he category was last updated, and the current count of posts in the category. By default, a category entry is wrapped in `<li>` tags.

*   Timestamp: A timestamp is a display of a date and/or time.

== Installation ==

1.  Put the visual-categories folder into your plugins directory.

2.  Activate the plugin.

== Setup ==

1.  Configure your settings via the Visual Categories admin panel under Settings.

2.  Activate the widget or add get\_visCats() to a template file. Or do both.
  
You can have multiple instances of the output. You can add get\_visCats() to any theme template file and personalize the settings. The get\_visCats(echo, settings\_array()) template tag contains two parameters:  

*   'echo' defaults to 1 (true). To return the the output, set to 0 (false), as in get\_visCats(0);

*   'settings' is an array. It's not necessary to include the array if you do not want to deviate from the options on your settings page. However, if you want an option to display differently, use get\_visCats(1, array('name of setting' => 'value'); The name of every setting that may be personalized is in the next section and wrapped in array().

  
For example, your website has three columns. Your widgets reside in the right column. In the left column, you want to display the child categories of category 3 ordered by post count. In the appropriate template file, you would add `<?php if (function_exists(get_visCats)) get_visCats(1, array('child_of' => 3, 'orderby'=> 'count')); ?>`. The remaining settings are taken from the Visual Categories admin panel settings.

== Frequently Asked Questions ==

*   If you have a question, a thought, or have a bug to report, ask or comment at  <http://www.thenappycat.com/2009/wordpress/categories/visual-categories-plugin/>.

== Screenshots ==

1. This is a screenshot of the Preliminary Settings section. More information on the section can be found under Admin Panel and Template Tag Settings in this document. 

2. This is a screenshot of the Post Count, Timestamp, and Image Display Options section. More information on the section can be found under Admin Panel and Template Tag Settings in this document. 

3. This is a screenshot of the Feed and Category Link Display Options section. More information on the section can be found under Admin Panel and Template Tag Settings in this document.

4. This is a screenshot of the Custom Categories section. More information on the section can be found under Admin Panel and Template Tag Settings in this document.

== Admin Panel and Template Tag Settings ==

*   Preliminary Settings
  
	*   Styling Options:  
  
		*   Wrap the entire Output?  
  
			*   If yes, the output will be wrapped in either `<ul>` or `<div>` tags, depending on your 'Style in List Tags?' setting.

			*   Defaults to Yes

			*   array('wrap' => 1 or 0)
  
		*   Output Title:  
	  
			*   The text that appears directly after the tag that follows the opening wrap tag.

			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.

			*   Defaults to 'Categories'  

			*   array('title\_li' => 'Categories')  
  
		*   Style in List Tags?  
  
			*   If yes, clusters and category entries will be in the appropriate list tags.  

			*   If no, clusters will be wrapped in <div> tags.  

			*   Defaults to Yes  

			*   array('style\_is\_list' => 1 or 0)  
		  
		*   Type of List:  
  
			*   Only works if 'Style in List Tags?' is yes.  

			*   'Unordered' wraps the clusters of category entries in unordered list tags.  

			*   'Ordered' wraps the clusters of category entries in <ol> tags.  

			*   Defaults to 'Unordered'  

			*   array('col\_tag' => 'ul' or 'ol')  
  
		*   Order Categories By:  
  
			*   Defaults to 'Name'

			*	When 'Timestamp of Most Recent Post' is selected, parent categories do not inherit the timestamp of its most recently posted in child category. Also, if categories with no posts are displayed, they are sorted by name in ascending order.

			*   array('orderby' => 'name', 'ID', 'slug', 'count', or 'time')  
  
		*   Direction of Order:  
  
			*   Defaults to 'Ascending (1..4) (A..D)'  

			*   array('order' => 'ASC' or 'DESC')  

  
	*   Class Names:  
  
		*   You may enter multiple class names in each class textbox. Class names must be separated by a space. All characters except alphanumeric characters (ABC123), the hyphen (-), the underscore (_), and the space ( ) will be removed.   
  
		*   Outer Class(es):

			*   Defaults to 'categories'  

			*   array('outer\_class' => 'categories')  
  
		*   Inner Class(es):  
  
			*   By default, this setting is blank  

			*   array('inner\_class' => '')  
  
		*   Children Cluster Class(es):  
  
			*   Defaults to 'cat-children'  

			*   array('children\_class' => 'cat-children')  
  
	*   Height Options:  
  
		*   Enable Height?  
  
			*   If yes, the category entries are split into column clusters based upon the value you enter below.  

			*   Defaults to 'No'  

			*   array('height\_enabled' => 0 or 1)  
  
  
		*   Number of Categories in Height:  
  
			*   The number of category entries that each column cluster will contain. Depending on your amount of categories, the final column cluster may contain less than this value.  

			*   If you enable height and do not enter a value, this value become 3.  

			*   Defaults to 0  

			*   array('height' => 0 or 1)  
  
		*   Keep Child with Parent?  
  
			*   If yes, the 'height' value will be applied only to top level categories. As such, a child category is never without its parent. One column cluster may contain 8 column entries (2 top level categories and 6 children) and another may contain 3 ( 2 top level categories and 1 child).  

			*   If no, the 'height' value will be strictly applied. If a child category is the first category entry in a column cluster, it will begin at a level relative to its parent category that is contained within a previous column cluster.  

			*   Defaults to Yes  

			*   array('keep\_family' => 1 or 0)  
		  
  
		*   Height Cluster Class:  
  
			*   The class name that is applied to each column cluster. 
			
			*   %ID displays the column number.
 
			*   Defaults to 'cat-height col-num-%ID'  

			*   array('height\_class' => 'cat-height col-num-%ID')  
  
  
	*   Categories Display Options:  
  
		*   Depth:  
  
			*   Unless -1, depth is the maximum level that your hierarchy of category entries descends.  

			*   If -1, all categories are displayed and parent and child categories are treated as the same level.  

			*   If 0, all categories are displayed in a hierarchical structure.  

			*   If 1, all top level categories are displayed and hierarchy is irrelevant.  

			*   If >1, all category levels up to this level are displayed in a hierarchical structure.  

			*   Defaults to 0  

			*   array('depth' => 0, -1, 1, or a number >1)  
  
		*   What's your category depth?  
  
			*   If you have more than 5 category levels, enter your desired value here. The largest value that may be entered is 50.

			*   Defaults to 5

			*   array('depth\_limit' => 5)  
  
		*   Display Categories with No Posts?  
  
			*   If yes, a category that has no posts assigned to it will be displayed.  

			*   If no, a category that has no posts assigned to it will not be displayed.  

			*   Defaults to No  

			*   array('hide\_empty' => 1 or 0)  
  
		*   Display Only the Child Categories Of:  
  
			*   If you only want the child categories of a particular parent category displayed, choose a parent category. 
 
			*   By default, this setting is blank  

			*   array(child\_of' => 0 or the category ID of a parent category)  
  
		*   Categories to Include:  
  
			*   If you only want particular categories to be displayed, enter their IDs here.  

			*   Use only commas to separate the category IDs (e.g. 1,44,6).  

			*   By default, this setting is blank  

			*   array('include' => '')  
  
		*   Categories to Exclude:  
  
			*   If you want particular categories to not be displayed, enter their IDs here.  

			*   Use only commas to separate the category IDs (e.g. 1,44,6).  

			*   If 'Categories to Include' contains one or more IDs, this setting is ignored.  

			*   By default, this setting is blank  

			*   array('exclude' => '')  
  
  
*   Category Entry Display Settings
  
	*   Each option allows you to build a display that can be included in or around your feed and category links.  

	*   You may add %count, %date, and %image to the link display textboxes in the next section. This plugin assumes that you want the component to display when you add its respective % tag to a textbox in the next section.

	*   You may enter multiple class names in each class textbox. Class names must be separated by a space. All characters except alphanumeric characters (ABC123), the hyphen (-), the underscore (_), the space ( ), and the '%' will be removed. 

	*   Standard-looking images taken from <http://www.feedicons.com/> Trendy images taken from <http://fasticon.com/freeware/>

	*   Post Count Options (%count):  
  
		*   Span Class(es):  
  
			*   Defaults to 'cat-count'  

			*   array('count\_class' => 'cat-count')  

		*   Text before the count:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   Defaults to '('  

			*   array('count\_before' => '(')  

		*   The Count:  
  
			*   Either numerical [0] or textual [1]. Text is displayed in lowercase.  

			*   Defaults to 0 [numberical]  

			*   array('count\_format' => 0 or 1)  
  
		*   Text after the count:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   Defaults to ')'  

			*   array('count\_after' => ')')  
  
		*   Pad the count calculation with child categories?  
  
			*   If yes, a parent category's child category's post count is added to the parent category's post count.  

			*   If no, a parent category's child category's post count is not added to the parent category's post count. 
 
			*   For example, Category A has 2 posts assigned to it. Category A's children categories, B and C, have 20 and 15 assigned posts, respectively. If the count is padded, Category A's count will be 37. Otherwise, its count will be 2.  

			*   Defaults to Yes  

			*   array('pad\_counts' => 1 or 0)  
  
	*   Timestamp Display Options (%date):  

		*   Span Class(es):  
  
			*   Defaults to 'cat-date'  

			*   array('date\_class' => 'cat-date')  
  
		*   The Timestamp:  
		
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  
  
			*   Defaults to 'm/d/Y'  

			*   array('date\_format' => 'm/d/Y')  
  
	*   Image Display Options (%image):  
    
		*   Span Class(es):  
  
			*   Defaults to 'cat-image'  

			*   array('image\_class' => 'cat-image')  
  
		*   Image Width:  
  
			*   Defaults to 12  

			*   array('image\_w' => 12)  
  
		*   Image Height:  
  
			*   Defaults to 12  

			*   array('image\_h' => 12)  
  
		*   The Image:  
  
			*   You may use choose an image from the included images or upload your own. Upon saving, your uploaded image will be available in the dropdown box.
 
			*   If you change from your own image to an included image, the width and height settings will change to the included image's width and height.

			*   If you can't see the images in the dropdown box, refer to viscats.images.png.

			*   Defaults to 'Not Enabled'  

			*   array('image_src' => '')  

			*   To personalize this setting in your template tag, include array('image_src' => 'http://www.mysite.com/path/to/the/image.png')  

			*   The 'image_src' value must begin with your site url and include the full path to the image. The included images are likely located at http://www.mysite.com/wp-content/plugins/visual-categories/images/[directory]/[image].[ext]
  
	*   In this section, you may add %cat_name (displays the category name), %ID (displays the category ID), %count (displays the current count of posts), %date (displays the timestamp of when the category was last updated), and %image (displays an image) to any textbox but a class textbox. You can add the % tags as many times as you desire.
	
	*   You may enter multiple class names in each class textbox. Class names must be separated by a space. All characters except alphanumeric characters (ABC123), the hyphen (-), the underscore (_), the space ( ), and the '%' will be removed. 

	*   If you want to display a link to each category's feed, add %feed_link to the textbox with the red border, before or after %cat_link. Only %cat_link and %feed_link may be entered into the textbox. All other text will be removed.
	
	*   Feed Link Display Options (%feed_link):  
  
		*   Text Before the Link:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   By default, this setting is blank  

			*   array('feed\_link\_before' => '')  
  
		*   Title Tag Text:  
  
			*   Text will be placed within the link's title tag. %cat_name is replaced by the category name.  

			*   Defaults to 'Feed for all posts filed under %cat_name'  

			*   array('feed\_link\_title' => 'Feed for all posts filed under %cat_name')  
  
		*   Link Class:  
  
			*   Class name will be applied to the link.  

			*   Defaults to 'cat-feed'  

			*   array('feed\_class' => 'cat-feed')  
  
		*   Link Text:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   Text will be placed within the anchor tags.  

			*   Defaults to RSS  

			*   array('feed\_link\_text' => 'RSS')  
  
		*   Text After the Link:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   By default, this setting is blank  

			*   array('feed\_link\_after' => '')  
  
	*   Category Link Display Options (%cat_link):  
  
		*   Text Before the Link:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   By default, this setting is blank  

			*   array('cat\_link\_before' => '')  
  
		*   Title Tag Text:  
  
			*   Text will be placed within the link's title tag. %cat_name is replaced by the category name.  

			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   Defaults to 'View all posts filed under %cat_name'  

			*   array('cat\_link\_title' => 'View all posts filed under %cat_name')  
  
		*   Use category description as title when it's available?  
  
			*   If yes, the 'Title Tag Text' is replaced with the category's description if you've entered a description for the category.  

			*   Defaults to Yes  

			*   array('use\_desc\_for\_title' => 1 or 0)  

		  
		*   Class Names:  
  
			*   These class names will be applied to each category link. The 'category item class' will be applied to every link. The application of the other four will depend on the category's context.  

			*   If you've chosen to style as a list, the category link classes will also be added to the `<li>` tags that wrap each category entry. You will need to use li.class and a.class in your stylesheet to differentiate.

			*   Category Item Class:  
	  
				*   Displayed as class="[class name] cat-id-[category ID]"  

				*   Defaults to 'cat-item cat-id-%ID'  

				*   array('category\_class' => 'cat-item cat-id-%ID')  
	  
			*   Current Category Class:  
	  
				*   Applied to the category when it is the current category. The current category is decided by an internal WordPress mechanism.  

				*   Defaults to 'current-cat'  

				*   array('current\_class' => 'current-cat')  
	  
			*   Parent Category Class:  
	  
				*   Applied to the category when it is a parent category.  

				*   Defaults to 'parent-cat'  

				*   array('parent\_class' => 'parent-cat')  
	
			*   Current Category's Parent Class:  
	  
				*   If it has one, applied to the current category's parent.  

				*   Defaults to 'current-cat-parent'  

				*   array('current\_parent\_class' => 'current-cat-parent')  
	
			*   Child Category Class:  
	  
				*   Applied to the category when it is a child category.  

				*   Defaults to 'child-cat'  

				*   array('child\_class' => 'child-cat')  
  
		*   Link Text:  
  
			*   Text will be placed within the anchor tags.  

			*   Defaults to %cat\_name  

			*   array('cat\_link\_text' => '%cat\_name')  
  
		*   Text After the Link:  
  
			*   This text may be wrapped in `<span>` tags. The allowed attributes are class, id, and style.  

			*   By default, this setting is blank  

			*   array('cat\_link\_after' => '')  
  
  
  
*   Custom Categories
  
	*   This is not where you set your permalink structure. Enter a custom link only if you, for whatever reason, need to override the URL to which your category is linked. 

	*   You can change the URL to which each category is linked. This will override the category link's title tag. For example, if category 'A' is set to http://google.com, the title tag will contain "Link To http://google.com"

	*   Additionally, you can set the category link's target attribute, which will be applied to the category link whether or not you've entered a custom link, and the category entry's image, which will be applied to the %image tag used in the Feed and Category Link Display Options section.
	
	*   Because these values are stored in a multi-dimensional array, it is recommended that you do not personalize these settings in get\_visCats().

	*   Category Link URL:  
  
		*   Defaults to 'http://'  
  
	*   Category Link Target:  
  
		*   Defaults to 'None'

	*   Category Image:  
  
		*   Defaults to 'Custom image not enabled'

	*   Category Image Width:  
  
		*   Defaults to 12

	*   Category Image Height:  
  
		*   Defaults to 12

== Readme Generator == 

This Readme file was generated using <a href = 'http://sudarmuthu.com/projects/wp-readme.php'>wp-readme</a>, which generates readme files for WordPress Plugins.