<?php
headway_register_block('HeadwayContentBlock', headway_url() . '/library/blocks/content');

class HeadwayContentBlock extends HeadwayBlockAPI {
	
	
	public $id = 'content';
	
	public $name = 'Content';
		
	public $options_class = 'HeadwayContentBlockOptions';

	public $description = 'Main content area to show the current page\'s content or the latest posts.  This is considered the "Loop" in other themes.';
		
	protected $show_content_in_grid = true;
	
	
	function init() {
		
		/* Load dependencies */
		require_once 'content-display.php';
		require_once 'comments.php';
		
		/* Set up the comments template */
		if ( !(HEADWAY_CHILD_THEME_ACTIVE && file_exists(get_stylesheet_directory() . '/comments.php')) )
			add_filter('comments_template', array(__CLASS__, 'add_comments_template'), 5);
		
		/* Add .comment class to all pingbacks */
		add_filter('comment_class', array('HeadwayComments', 'add_comment_class_to_all_types'));
		
		/* Set up editor style */
		add_filter('mce_css', array(__CLASS__, 'add_editor_style'));
		
	}

	
	function add_comments_template() {
		
		return HEADWAY_LIBRARY_DIR . '/blocks/content/comments-template.php';
		
	}

	
	function add_editor_style($css) {
		
		if ( HeadwayOption::get('disable-editor-style', false, false) )
			return $css;
		
		if ( !current_theme_supports('editor-style') )
			return $css;
			
		if ( !current_theme_supports('headway-design-editor') )
			return $css;

		HeadwayCompiler::register_file(array(
			'name' => 'editor-style',
			'format' => 'css',
			'fragments' => array(
				'headway_content_block_editor_style'
			),
			'dependencies' => array(HEADWAY_LIBRARY_DIR . '/blocks/content/editor-style.php'),
			'enqueue' => false
		));

		return $css . ',' . HeadwayCompiler::get_url('editor-style');

	}

	
	function setup_elements() {
		
		$this->register_block_element(array(
			'id' => 'entry-container',
			'name' => 'Entry Container',
			'selector' => '.post',
			'properties' => array('background', 'borders', 'padding', 'rounded-corners', 'box-shadow')
		));
		
		$this->register_block_element(array(
			'id' => 'title',
			'name' => 'Title',
			'selector' => '.entry-title',
			'states' => array(
				'Hover' => '.entry-title:hover', 
				'Clicked' => '.entry-title:active'
			),
			'inherit-location' => 'default-heading'
		));
		
		$this->register_block_element(array(
			'id' => 'archive-title',
			'name' => 'Archive Title',
			'selector' => '.archive-title',
			'inherit-location' => 'default-heading'
		));
		
		$this->register_block_element(array(
			'id' => 'entry-content',
			'name' => 'Body Text',
			'selector' => 'div.entry-content',
			'inherit-location' => 'default-text'
		));
		
		$this->register_block_element(array(
			'id' => 'entry-content-hyperlinks',
			'name' => 'Body Hyperlinks',
			'selector' => 'div.entry-content a',
			'properties' => array('fonts', 'text-shadow'),
			'inherit-location' => 'default-text',
			'states' => array(
				'Hover' => 'div.entry-content a:hover', 
				'Clicked' => 'div.entry-content a:active'
			)
		));

		$this->register_block_element(array(
			'id' => 'entry-content-images',
			'name' => 'Body Images',
			'selector' => 'div.entry-content img',
			'properties' => array('background', 'borders', 'padding', 'rounded-corners', 'box-shadow')
		));
		
		$this->register_block_element(array(
			'id' => 'entry-meta',
			'name' => 'Meta',
			'selector' => 'div.entry-meta',
			'inherit-location' => 'default-text'
		));
		
		$this->register_block_element(array(
			'id' => 'heading',
			'name' => 'Heading <small>&lt;H3&gt;, &lt;H2&gt;, &lt;H1&gt;</small>',
			'selector' => 'div.entry-content h3, div.entry-content h2, div.entry-content h1',
			'inherit-location' => 'default-heading'
		));
		
		$this->register_block_element(array(
			'id' => 'sub-heading',
			'name' => 'Sub Heading <small>&lt;H4&gt;</small>',
			'selector' => 'div.entry-content h4',
			'inherit-location' => 'default-sub-heading'
		));
		
		$this->register_block_element(array(
			'id' => 'post-thumbnail',
			'name' => 'Featured Image',
			'selector' => '.block-type-content a.post-thumbnail img',
			'properties' => array('background', 'borders', 'padding', 'rounded-corners', 'box-shadow')
		));
		
		$this->register_block_element(array(
			'id' => 'more-link',
			'name' => 'Continue Reading Button',
			'selector' => 'div.entry-content a.more-link',
			'states' => array(
				'Hover' => 'div.entry-content a.more-link:hover',
				'Clicked' => 'div.entry-content a.more-link:active'
			)
		));
		
		$this->register_block_element(array(
			'id' => 'loop-navigation-link',
			'name' => 'Loop Navigation Button',
			'selector' => 'div.loop-navigation div.nav-previous a, div.loop-navigation div.nav-next a',
			'states' => array(
				'Hover' => 'div.loop-navigation div.nav-previous a:hover, div.loop-navigation div.nav-next a:hover',
				'Clicked' => 'div.loop-navigation div.nav-previous a:active, div.loop-navigation div.nav-next a:active'
			)
		));
		
		$this->register_block_element(array(
			'id' => 'comments-area',
			'name' => 'Comments Area',
			'selector' => 'ol.commentlist',
			'properties' => array('background', 'borders', 'padding', 'rounded-corners', 'box-shadow')
		));
		
		$this->register_block_element(array(
			'id' => 'comments-area-headings',
			'name' => 'Comments Area Headings',
			'selector' => 'div#comments h3'
		));

		$this->register_block_element(array(
			'id' => 'comment-container',
			'name' => 'Comment Container',
			'selector' => 'li.comment',
			'properties' => array('background', 'borders', 'padding', 'rounded-corners', 'box-shadow')
		));
		
		$this->register_block_element(array(
			'id' => 'comment-author',
			'name' => 'Comment Author',
			'selector' => 'li.comment .comment-author'
		));
		
		$this->register_block_element(array(
			'id' => 'comment-meta',
			'name' => 'Comment Meta',
			'selector' => 'li.comment .comment-meta'
		));

		$this->register_block_element(array(
			'id' => 'comment-meta-count',
			'name' => 'Comment Meta Count',
			'selector' => 'a.entry-comments'
		));
		
		$this->register_block_element(array(
			'id' => 'comment-body',
			'name' => 'Comment Body',
			'selector' => 'li.comment .comment-body p',
			'properties' => array('fonts', 'text-shadow')
		));
		
		$this->register_block_element(array(
			'id' => 'comment-reply-link',
			'name' => 'Comment Reply Link',
			'selector' => 'a.comment-reply-link',
			'states' => array(
				'Hover' => 'a.comment-reply-link:hover',
				'Clicked' => 'a.comment-reply-link:active'
			)
		));

		$this->register_block_element(array(
			'id' => 'comment-form-input-label',
			'name' => 'Comment Form Input Label',
			'selector' => 'div#respond label',
			'properties' => array('fonts', 'text-shadow')
		));
		
	}
	
	
	function content($block) {
										
		$content_block_display = new HeadwayContentBlockDisplay($block);
		$content_block_display->display();
		
	}
	
	
}


class HeadwayContentBlockOptions extends HeadwayBlockOptionsAPI {
	
	
	public $tab_notices = array(
		'mode' => 'The content block is extremely versatile.  If the default mode is selected, it will do what you expect it to do.  For example, if you add this on a page, it will display that page\'s content.  If you add it on the Blog Index layout, it will list the posts like a normal blog template and if you add this box on a category layout, it will list posts of that category.  If you wish to change what the content block displays, change the mode to <em>Custom Query</em> and use the settings in the <em>Query Filters</em> tab.',
		'query-setup' => 'For more control over queries and how the query is displayed, Headway works perfectly out-of-the-box with <a href="http://pluginbuddy.com/purchase/loopbuddy/" target="_blank">LoopBuddy</a>.',
		'meta' => 'The entry meta is the information that appears below the post title and below the post content.  By default, it will contain information about the entry author, the categories, and comments.'
	);
	
	
	public $tabs = array(
		'mode' => 'Mode',
		'query-filters' => 'Query Filters',
		'display' => 'Display',
		'meta' => 'Meta',
		'comments' => 'Comments',
		'post-thumbnails' => 'Featured Images'
	);

	
	public $inputs = array(
		
		'mode' => array(
			'mode' => array(
				'type' => 'select',
				'name' => 'mode',
				'label' => 'Query Mode',
				'tooltip' => '',
				'options' => array(
					'default' => 'Default Behavior',
					'custom-query' => 'Custom Query'
				),
				'toggle'    => array(
					'custom-query' => array(
						'show' => array(
							'li#sub-tab-query-filters'
						)
					),
					'default' => array(
						'hide' => array(
							'li#sub-tab-query-filters'
						)
					)
				)
			)
		),

		'query-filters' => array(
			'fetch-page-content' => array(
				'type' => 'select',
				'name' => 'fetch-page-content',
				'label' => 'Fetch Page Content',
				'tooltip' => '',
				'options' => 'get_pages()'
			),
			
			'categories' => array(
				'type' => 'multi-select',
				'name' => 'categories',
				'label' => 'Categories',
				'tooltip' => '',
				'options' => 'get_categories()'
			),
			
			'categories-mode' => array(
				'type' => 'select',
				'name' => 'categories-mode',
				'label' => 'Categories Mode',
				'tooltip' => '',
				'options' => array(
					'include' => 'Include',
					'exclude' => 'Exclude'
				)
			),
			
			'post-type' => array(
				'type' => 'multi-select',
				'name' => 'post-type',
				'label' => 'Post Type',
				'tooltip' => '',
				'options' => 'get_post_types()'
			),
			
			'author' => array(
				'type' => 'multi-select',
				'name' => 'author',
				'label' => 'Author',
				'tooltip' => '',
				'options' => 'get_authors()'
			),
			
			'number-of-posts' => array(
				'type' => 'integer',
				'name' => 'number-of-posts',
				'label' => 'Number of Posts',
				'tooltip' => '',
				'default' => 10
			),
			
			'paginate' => array(
				'type' => 'checkbox',
				'name' => 'paginate',
				'label' => 'Paginate Posts',
				'tooltip' => '',
				'default' => true
			),
			
			'offset' => array(
				'type' => 'integer',
				'name' => 'offset',
				'label' => 'Offset',
				'tooltip' => 'The offset is the number of entries or posts you would like to skip.  If the offset is 1, then the first post will be skipped.',
				'default' => 0
			),
			
			'order-by' => array(
				'type' => 'select',
				'name' => 'order-by',
				'label' => 'Order By',
				'tooltip' => '',
				'options' => array(
					'date' => 'Date',
					'title' => 'Title',
					'rand' => 'Random',
					'ID' => 'ID'
				)
			),
			
			'order' => array(
				'type' => 'select',
				'name' => 'order',
				'label' => 'Order',
				'tooltip' => '',
				'options' => array(
					'desc' => 'Descending',
					'asc' => 'Ascending',
				)
			)
		),
	
		'display' => array(
			'read-more-text' => array(
				'type' => 'text',
				'label' => 'Read More Text',
				'name' => 'read-more-text',
				'default' => 'Continue Reading',
				'tooltip' => 'If excerpts are being shown or a featured post is truncated using WordPress\' read more shortcode, then this will be shown after the excerpt or truncated content.'
			),
			
			'show-titles' => array(
				'type' => 'checkbox',
				'name' => 'show-titles',
				'label' => 'Show Titles',
				'default' => true,
				'tooltip' => 'If you wish to only show the content and meta of the entry, you can hide the entry (post or page) titles with this option.'
			),
			
			'entry-content-display' => array(
				'type' => 'select',
				'name' => 'entry-content-display',
				'label' => 'Entry Content Display',
				'tooltip' => 'The entry content is the actual body of the entry.  This is what you enter in the rich text area when creating an entry (post or page).  When set to normal, Headway will determine if full entries or excerpts should be displayed based off of the <em>Featured Posts</em> setting and what page is being displayed.<br /><br /><strong>Tip:</strong> Set this to <em>Hide Entry Content</em> to create a simple listing of posts.',
				'default' => 'normal',
				'options' => array(
					'normal' => 'Normal',
					'full-entries' => 'Show Full Entries',
					'excerpts' => 'Show Excerpts',
					'hide' => 'Hide Entry Content'
				)
			),
			
			'show-entry' => array(
				'type' => 'checkbox',
				'name' => 'show-entry',
				'label' => 'Show Entry',
				'default' => true,
				'tooltip' => 'By default, the entries will always be shown.  However, there may be certain cases where you wish to show the entry content in one Content Block, but the comments in another.  With this option, you can do that.'
			),
			
			'comments-visibility' => array(
				'type' => 'select',
				'name' => 'comments-visibility',
				'label' => 'Comments Visibility',
				'default' => 'auto',
				'options' => array(
					'auto' => 'Automatic',
					'hide' => 'Always Hide Comments',
					'show' => 'Always Show Comments'
				),
				'tooltip' => 'When set to automatic, the comments will only show on single post pages.  However, there may be times where you want to force comment visibility to allow comments on pages.  Or, you may hide the comments if you wish to not see them at all.<br /><br /><strong>Tip:</strong> Create unique layouts by using this option in conjunction with the Show Entry option to show the entry content in one Content Block and show the comments in another Content Block.'
			),
			
			'featured-posts' => array(
				'type' => 'integer',
				'name' => 'featured-posts',
				'label' => 'Featured Posts',
				'default' => 1,
				'tooltip' => 'Featured posts are the posts where all of the content is displayed, unless limited by using the WordPress more tag.  After the featured posts are displayed, the content will automatically switch to showing automatically truncated excerpts.'
			),
			
			'show-single-post-navigation' => array(
				'type' => 'checkbox',
				'name' => 'show-single-post-navigation',
				'label' => 'Show Single Post Navigation',
				'default' => true,
				'tooltip' => 'By default, Headway will show links to the previous and next posts below an entry when viewing only one entry at a time.  You can choose to hide those links with this option.'
			),

			'show-edit-link' => array(
				'type' => 'checkbox',
				'name' => 'show-edit-link',
				'label' => 'Show Edit Link',
				'default' => true,
				'tooltip' => 'The edit link is a convenient link that will be shown next to the post title.  It will take you straight to the WordPress admin to edit the entry.'
			),
		),
		
		'meta' => array(
			'show-entry-meta-post-types' => array(
				'type' => 'multi-select',
				'name' => 'show-entry-meta-post-types',
				'label' => 'Entry Meta Display (Per Post Type)',
				'tooltip' => 'Choose which post types you wish for the entry meta to appear on.',
				'options' => 'get_post_types()',
				'default' => array('post')
			),
			
			'entry-meta-above' => array(
				'type' => 'textarea',
				'label' => 'Meta Above Content',
				'name' => 'entry-meta-above',
				'default' => 'Posted on %date% by %author% &bull; %comments%',
				'tooltip' => '
					<strong>Available Variables:</strong>
					<ul>
						<li>%date%</li>
						<li>%time%</li>
						<li>%comments%</li>
						<li>%comments_no_link%</li>
						<li>%respond%</li>
						<li>%author%</li>
						<li>%author_no_link%</li>
						<li>%categories%</li>
						<li>%tags%</li>
					</ul>'
			),
			
			'entry-utility-below' => array(
				'type' => 'textarea',
				'label' => 'Meta Below Content',
				'name' => 'entry-utility-below',
				'default' => 'Filed Under: %categories%',
				'tooltip' => '
					<strong>Available Variables:</strong>
					<ul>
						<li>%date%</li>
						<li>%time%</li>
						<li>%comments%</li>
						<li>%comments_no_link%</li>
						<li>%respond%</li>
						<li>%author%</li>
						<li>%author_no_link%</li>
						<li>%categories%</li>
						<li>%tags%</li>
					</ul>'
			),
			
			'date-format' => array(
				'type' => 'select',
				'name' => 'date-format',
				'label' => 'Date Format'
			),

			'time-format' => array(
				'type' => 'select',
				'name' => 'time-format',
				'label' => 'Time Format'
			)
			
		),
		
		'comments' => array(
			'comments-area-heading' => array(
				'name' => 'comments-area-heading',
				'type' => 'heading',
				'label' => 'Comments Area'
			),

				'leave-reply' => array(
					'type' => 'text',
					'label' => 'Comment Form Title',
					'name' => 'leave-reply',
					'default' => 'Leave a reply',
					'tooltip' => 'This is the text that displays above the comment form.'
				),

				'leave-reply-to' => array(
					'type' => 'text',
					'label' => 'Reply Form Title',
					'name' => 'leave-reply-to',
					'default' => 'Leave a Reply to %s',
					'tooltip' => 'The title of comment form when replying to a comment.'
				),

				'cancel-reply-link' => array(
					'type' => 'text',
					'label' => 'Cancel Reply Text',
					'name' => 'cancel-reply-link',
					'default' => 'Cancel reply',
					'tooltip' => 'The text for the cancel reply button.'
				),

				'label-submit-text' => array(
					'type' => 'text',
					'label' => 'Submit Text',
					'name' => 'label-submit-text',
					'default' => 'Post Comment',
					'tooltip' => 'The submit button text.'
				),

			'comments-meta-heading' => array(
				'name' => 'comments-meta-heading',
				'type' => 'heading',
				'label' => 'Meta'
			),

				'comment-format' => array(
					'type' => 'text',
					'label' => 'Comment Format &ndash; More Than 1 Comment',
					'name' => 'comment-format',
					'default' => '%num% Comments',
					'tooltip' => 'Controls what the %comments% and %comments_no_link% variables will output in the entry meta if there is <strong>more than 1 comment</strong> on the entry.'
				),
				
				'comment-format-1' => array(
					'type' => 'text',
					'label' => 'Comment Format &ndash; 1 Comment',
					'name' => 'comment-format-1',
					'default' => '%num% Comment',
					'tooltip' => 'Controls what the %comments% and %comments_no_link% variables will output in the entry meta if there is <strong>just 1 comment</strong> on the entry.'
				),
				
				'comment-format-0' => array(
					'type' => 'text',
					'label' => 'Comment Format &ndash; 0 Comments',
					'name' => 'comment-format-0',
					'default' => '%num% Comments',
					'tooltip' => 'Controls what the %comments% and %comments_no_link% variables will output in the entry meta if there are <strong>0 comments</strong> on the entry.'

				),
				
				'respond-format' => array(
					'type' => 'text',
					'label' => 'Respond Format',
					'name' => 'respond-format',
					'default' => 'Leave a comment!',
					'tooltip' => 'Determines the %respond% variable for the entry meta.'
				)
		),

		'post-thumbnails' => array(
			'show-post-thumbnails' => array(
				'type' => 'checkbox',
				'name' => 'show-post-thumbnails',
				'label' => 'Show Featured Images',
				'default' => true
			),

			'post-thumbnail-position' => array(
				'type' => 'select',
				'name' => 'post-thumbnail-position',
				'label' => 'Image Position',
				'default' => 'left',
				'options' => array(
					'left' => 'Left',
					'right' => 'Right',
					'above-title' => 'Above Title',
					'above-content' => 'Above Content'
				)
			),

			'use-entry-thumbnail-position' => array(
				'type' => 'checkbox',
				'name' => 'use-entry-thumbnail-position',
				'label' => 'Use Per-Entry Featured Image Positions',
				'default' => true,
				'tooltip' => 'In the WordPress write panel, there is a Headway meta box that allows you to change the featured image position for the entry being edited.<br /><br />By default, the block will use that value, but you may uncheck this so that the blocks thumbnail position is always used.'
			),

			'thumbnail-sizing-heading' => array(
				'name' => 'thumbnail-sizing-heading',
				'type' => 'heading',
				'label' => 'Featured Image Sizing'
			),

				'post-thumbnail-size' => array(
					'type' => 'slider',
					'name' => 'post-thumbnail-size',
					'label' => 'Featured Image Size (Left/Right)',
					'default' => 125,
					'slider-min' => 20,
					'slider-max' => 400,
					'slider-interval' => 1,
					'tooltip' => 'Adjust the size of the featured image sizes.  This is used for both the width and height of the images.',
					'unit' => 'px'
				),

				'post-thumbnail-height-ratio' => array(
					'type' => 'slider',
					'name' => 'post-thumbnail-height-ratio',
					'label' => 'Featured Image Height Ratio (Above Title/Content)',
					'default' => 35,
					'slider-min' => 10,
					'slider-max' => 200,
					'slider-interval' => 5,
					'tooltip' => 'Adjust the height of feature images when set to the above title or above content positions.  This value controls what percent the height of the image will be in regards to the width of the block.<br /><br />Example: If the block width is 500 pixels and the ratio is 50% then the feature image size will be 500px by 250px.',
					'unit' => '%'
				),

				'crop-post-thumbnails' => array(
					'type' => 'checkbox',
					'name' => 'crop-post-thumbnails',
					'label' => 'Crop Featured Images',
					'default' => true
				)
		)
		
	);
	

	function modify_arguments($args) {
		
		global $pluginbuddy_loopbuddy;
		
		if ( class_exists('pluginbuddy_loopbuddy') && isset($pluginbuddy_loopbuddy) ) {
			
			//Remove the old tabs
			unset($this->tabs['mode']);
			unset($this->tabs['meta']);
			unset($this->tabs['display']);
			unset($this->tabs['query-filters']);
			unset($this->tabs['post-thumbnails']);

			unset($this->inputs['mode']);
			unset($this->inputs['meta']);
			unset($this->inputs['display']);
			unset($this->inputs['query-filters']);
			unset($this->inputs['post-thumbnails']);
			
			//Add in new tabs
			$this->tabs['loopbuddy'] = 'LoopBuddy';
			
			$this->inputs['loopbuddy'] = array(
				'loopbuddy-query' => array(
					'type' => 'select',
					'name' => 'loopbuddy-query',
					'label' => 'LoopBuddy Query',
					'options' => 'get_loopbuddy_queries()',
					'tooltip' => 'Select a LoopBuddy query to the right.  Queries determine what content (posts, pages, etc) will be displayed.  You can modify/add queries in the WordPress admin under LoopBuddy.',
					'default' => ''
				),
				
				'loopbuddy-layout' => array(
					'type' => 'select',
					'name' => 'loopbuddy-layout',
					'label' => 'LoopBuddy Layout',
					'options' => 'get_loopbuddy_layouts()',
					'tooltip' => 'Select a LoopBuddy layout to the right.  Layouts determine how the query will be displayed.  This includes the order of the content in relation to the title, meta, and so on.  You can modify/add layouts in the WordPress admin under LoopBuddy.',
					'default' => ''
				)
			);
			
			$this->tab_notices = array(
				'loopbuddy' => '<strong>Even though we have the options to choose a LoopBuddy layout and query here, we recommend you configure LoopBuddy using its <a href="' . admin_url('admin.php?page=pluginbuddy_loopbuddy'). '" target="_blank">options panel</a>.</strong><br /><br />The options below are more useful if you\'re using two Content Blocks on one layout and wish to configure them separately.  <strong>Note:</strong> You MUST have a query selected in order to also select a LoopBuddy layout.'
			);
			
			return;
			
		}
		
		$this->inputs['meta']['date-format']['options'] = array(
			'wordpress-default' => 'WordPress Default',
			'F j, Y' => date('F j, Y'),
			'm/d/y' => date('m/d/y'),
			'd/m/y' => date('d/m/y'),
			'M j' => date('M j'),
			'M j, Y' => date('M j, Y'),
			'F j' => date('F j'),
			'F jS' => date('F jS'),
			'F jS, Y' => date('F jS, Y')
		);

		$this->inputs['meta']['time-format']['options'] = array(
			'wordpress-default' => 'WordPress Default',
			'g:i A' => date('g:i A'),
			'g:i A T' => date('g:i A T'),
			'g:i:s A' => date('g:i:s A'),
			'G:i' => date('G:i'),
			'G:i T' => date('G:i T')
		);
		
	}
	
	
	function get_pages() {
		
		$page_options = array('&ndash; Do Not Fetch &ndash;');
		
		$page_select_query = get_pages();
		
		foreach ($page_select_query as $page)
			$page_options[$page->ID] = $page->post_title;
		
		return $page_options;
		
	}
	
	
	function get_categories() {
		
		$category_options = array();
		
		$categories_select_query = get_categories();
		
		foreach ($categories_select_query as $category)
			$category_options[$category->term_id] = $category->name;

		return $category_options;
		
	}
	
	
	function get_authors() {
		
		$author_options = array();
		
		$authors = get_users(array(
			'orderby' => 'post_count',
			'order' => 'desc',
			'who' => 'authors'
		));
		
		foreach ( $authors as $author )
			$author_options[$author->ID] = $author->display_name;
			
		return $author_options;
		
	}
	
	
	function get_post_types() {
		
		$post_type_options = array();

		$post_types = get_post_types(false, 'objects'); 
			
		foreach($post_types as $post_type_id => $post_type){
			
			//Make sure the post type is not an excluded post type.
			if(in_array($post_type_id, array('revision', 'nav_menu_item'))) 
				continue;
			
			$post_type_options[$post_type_id] = $post_type->labels->name;
		
		}
		
		return $post_type_options;
		
	}
	
	
	function get_loopbuddy_queries() {
		
		$loopbuddy_options = get_option('pluginbuddy_loopbuddy');
		
		$queries = array(
			'' => '&ndash; Use Default Query &ndash;'
		);
				
		foreach ( $loopbuddy_options['queries'] as $query_id => $query ) {
						
			$queries[$query_id] = $query['title'];
			
		}
		
		return $queries;
		
	}
	
	
	function get_loopbuddy_layouts() {
		
		$loopbuddy_options = get_option('pluginbuddy_loopbuddy');
		
		$layouts = array(
			'' => '&ndash; Use Default Layout &ndash;'
		);
				
		foreach ( $loopbuddy_options['layouts'] as $layout_id => $layout ) {
			
			$layouts[$layout_id] = $layout['title'];
			
		}
		
		return $layouts;
		
	}
	
	
}