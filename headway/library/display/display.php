<?php
class HeadwayDisplay {
	
	
	public static function init() {
		
		Headway::load(array(
			'display/head' => true,
			'display/grid-renderer'
		));
				
		add_filter('body_class', array(__CLASS__, 'body_class'));

		if ( HeadwayRoute::is_visual_editor_iframe() ) {

			Headway::load('visual-editor/preview', 'VisualEditorPreview');

			HeadwayAdminBar::remove_admin_bar();

		}
		
	}
	
	
	public static function layout() {
	
		get_header();
		
		echo "\n\n";
						
			if ( current_theme_supports('headway-grid') ) {
		
				$layout = new HeadwayGridRenderer;
				$layout->display();
						
			} else {
			
				echo '<div class="alert alert-yellow"><p>The Headway Grid is not supported in this Child Theme.</p></div>';
			
			}
			
		echo "\n\n";
						
		get_footer();
		
	}
	
	
	/**
	 * Assembles the classes for the body element.
	 **/
	public static function body_class($c) {

		global $wp_query, $authordata;
		
		$c[] = 'custom';

		/* User Agents */
			if ( !HeadwayCompiler::is_plugin_caching() ) {
				
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
			
				/* IE */
				if ( $ie_version = headway_is_ie() ) {
									
					$c[] = 'ie';
					$c[] = 'ie' . $ie_version;
					
				}
				
				/* Modern Browsers */
				if ( stripos($user_agent, 'Safari') !== false )
					$c[] = 'safari';
					
				elseif ( stripos($user_agent, 'Firefox') !== false )
					$c[] = 'firefox';
					
				elseif ( stripos($user_agent, 'Chrome') !== false )
					$c[] = 'chrome';
					
				elseif ( stripos($user_agent, 'Opera') !== false )
					$c[] = 'opera';

				/* Rendering Engines */
				if ( stripos($user_agent, 'WebKit') !== false )
					$c[] = 'webkit';
					
				elseif ( stripos($user_agent, 'Gecko') !== false )
					$c[] = 'gecko';
					
				/* Mobile */
				if ( stripos($user_agent, 'iPhone') !== false )
					$c[] = 'iphone';
				
				elseif ( stripos($user_agent, 'iPod') !== false )
					$c[] = 'ipod';
				
				elseif ( stripos($user_agent, 'iPad') !== false )
					$c[] = 'ipad';
					
				elseif ( stripos($user_agent, 'Android') !== false )
					$c[] = 'android';
				
			}
		/* End User Agents */		

		/* Responsive Grid */
			if ( HeadwayResponsiveGrid::is_enabled() )
				$c[] = 'responsive-grid-enabled';

			if ( HeadwayResponsiveGrid::is_active() )
				$c[] = 'responsive-grid-active';

		/* Pages */			
			if ( is_page() && isset($wp_query->post) && isset($wp_query->post->ID) ) {
								
				$c[] = 'pageid-' . $wp_query->post->ID;
				$c[] = 'page-slug-' . $wp_query->post->post_name;
							
			}

		/* Posts & Pages */
			if ( is_singular() && isset($wp_query->post) && isset($wp_query->post->ID)  ) {

				//Add the custom classes from the meta box
				if ( $custom_css_class = HeadwayLayoutOption::get($wp_query->post->ID, 'css-class', null) ) {
					
					$custom_css_classes = str_replace('  ', ' ', str_replace(',', ' ', htmlspecialchars(strip_tags($custom_css_class))));

					$c = array_merge($c, array_filter(explode(' ', $custom_css_classes)));
					
				}

			}

		/* Layout IDs, etc */
		$c[] = 'layout-' . HeadwayLayout::get_current();
		$c[] = 'layout-using-' . HeadwayLayout::get_current_in_use();

		if ( HeadwayRoute::is_visual_editor_iframe() )
			$c[] = 've-iframe';
		
		if ( headway_get('ve-iframe-mode') && HeadwayRoute::is_visual_editor_iframe() )
			$c[] = 'visual-editor-mode-' . headway_get('ve-iframe-mode');

		if ( !current_theme_supports('headway-design-editor') )
			$c[] = 'design-editor-disabled';

		$c = array_unique(array_filter($c));

		return $c;
		
	}

	
	public static function html_open() {
				
		echo apply_filters('headway_doctype', '<!DOCTYPE HTML>');
		echo '<html '; language_attributes(); echo '>' . "\n";
		
		do_action('headway_html_open');
		
		echo "\n" . '<head>' . "\n";
		
	}


	public static function html_close() {
		
		echo "\n\n";
		
		do_action('headway_html_close');

		echo "\n" . '</html>';
		
	}
	
	
	public static function body_open() {	
			
		echo "\n" . '</head><!-- End <head> -->' . "\n\n";
		
		echo '<body '; body_class(); echo '>' . "\n\n";

		do_action('headway_body_open');

		echo "\n" . '<div id="whitewrap">' . "\n";
		
		do_action('headway_whitewrap_open');

		do_action('headway_page_start');
		
	}


	public static function body_close() {
		
		echo "\n\n";
		
		do_action('headway_whitewrap_close');

		echo '</div><!-- #whitewrap -->' . "\n";
		
		do_action('headway_body_close');
		
		echo "\n" . '</body>';
			
	}
	
	
}