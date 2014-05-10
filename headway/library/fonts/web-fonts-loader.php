<?php
class HeadwayWebFontsLoader {


	public static function init() {

		add_filter('headway_general_css', array(__CLASS__, 'google_compiler_add_fragment'));
		add_filter('headway_general_css_dependencies', array(__CLASS__, 'google_compiler_add_dependency'));		

		add_action('wp', array(__CLASS__, 'enqueue_webfont_api_for_design_editor'));
		add_action('headway_visual_editor_save', array(__CLASS__, 'flush_cache'));

	}


	public static function enqueue_webfont_api_for_design_editor() {

		if ( !HeadwayRoute::is_visual_editor_iframe('design') )
			return;

		wp_enqueue_script('webfont', 'http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');

	}


	/* Google Web Fonts */
		public static function google_check_if_should_load() {

			$webfonts_in_use = self::get_fonts_in_use();

			if ( !is_array($webfonts_in_use) || count($webfonts_in_use) == 0 || !isset($webfonts_in_use['google']) )
				return false;

			return $webfonts_in_use;

		}


		public static function google_compiler_add_fragment($fragments) {

			if ( !self::google_check_if_should_load() )
				return $fragments;

			array_unshift($fragments, array('HeadwayWebFontsLoader', 'google_css_import'));

			return $fragments;

		}


		public static function google_compiler_add_dependency($deps) {

			if ( !self::google_check_if_should_load() )
				return $deps;

			$deps[] = HEADWAY_LIBRARY_DIR . '/fonts/web-fonts-loader.php';

			return $deps;
			
		}


		public static function google_css_import() {

			if ( !$webfonts_in_use = self::google_check_if_should_load() )
				return;

			foreach ( $webfonts_in_use['google'] as $key => $font )
				$webfonts_in_use['google'][$key] = urlencode($font);

			return '@import url(' . headway_format_url_ssl('http://fonts.googleapis.com/css?family=' . implode('|', $webfonts_in_use['google'])) . ');';

		}
	/* End Google Web Fonts */


	public static function get_fonts_in_use() {

		/* If cache exists then use it */
		$cache = HeadwayOption::get('webfont-cache');

		if ( is_array($cache) )
			return $cache;

		/* Build cache otherwise */
		self::cache();

		return HeadwayOption::get('webfont-cache');

	}


	public static function cache() {

		$raw_webfonts = self::pluck_webfonts(HeadwayElementsData::get_all_elements());
		$sorted_webfonts = array();

		foreach ( $raw_webfonts as $webfont ) {

			$fragments = explode('|', $webfont);

			$sorted_webfonts[$fragments[0]][] = $fragments[1];
			$sorted_webfonts[$fragments[0]] = array_unique($sorted_webfonts[$fragments[0]]);

		}

		return HeadwayOption::set('webfont-cache', $sorted_webfonts);

	}


		public static function pluck_webfonts($array) {

			$web_fonts = array();

			foreach ( $array as $key => $value ) {

				/* If the value is an array, then loop this function to pluck the font values out of instances, states, etc */
				if ( is_array($value) ) {

					$web_fonts = array_merge($web_fonts, self::pluck_webfonts($value));

				/* We've found a font family property.  Now make sure that the font is a web font by checking for the | delimiter */
				} else if ( $key === 'font-family' && strpos($value, '|') ) {

					$web_fonts[] = $value;

				}

			}

			return array_unique($web_fonts);

		}


	public static function flush_cache() {

		return HeadwayOption::delete('webfont-cache');

	}


}