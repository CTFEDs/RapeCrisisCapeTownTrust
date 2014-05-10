<?php
class HeadwayResponsiveGridDynamicMedia {
	
	
	static function content() {

		$content = self::computers();		
		$content .= self::ipad_landscape();
		$content .= self::ipad_portrait();
		$content .= self::smartphones();
		
		return apply_filters('headway_responsive_grid_css', $content);
		
	}


	static function computers() {

		return '
			/* --- Computers (Laptops/Desktops) --- */
			@media only screen and (min-width: 1024px) {

				/* Responsive Block Hiding */
				.responsive-block-hiding-device-computers {
					display: none !important;
				}

			}
		';
		
	}
	
	
	static function ipad_landscape() {

		$grid_width = HeadwayGrid::get_grid_width();
		$wrapper_width = $grid_width + 30; /* 30 is default padding compensation */
		
		$screen_max_width = ( $wrapper_width < 1024 ) ? $wrapper_width : 1024;
		
		return '
			/* --- iPad Landscape --- */
			@media only screen and (min-width : 600px) and (max-width: ' . $screen_max_width . 'px) and (orientation : landscape) {

				.responsive-grid-active .block img {
					max-width: 100%;
					height: auto;
				}

				.responsive-grid-active .block-fixed-height:not(.block-type-navigation) {
					height: auto;
					min-height: 40px;
				}
				
				.responsive-grid-active .block-type-footer p.footer-responsive-grid-link-container {
					display: block;
				}

				/* Responsive Block Hiding */
				.responsive-block-hiding-device-tablets-landscape {
					display: none !important;
				}

			}
		';
		
	}
	
	
	static function ipad_portrait() {

		$grid_width = HeadwayGrid::get_grid_width();
		$wrapper_width = $grid_width + 30; /* 30 is default padding compensation */
		
		$screen_max_width = ( $wrapper_width < 1024 ) ? $wrapper_width : 1024;
		
		return '
			/* --- iPad Portrait --- */
			@media only screen and (min-width : 600px) and (max-width : ' . $screen_max_width . 'px) and (orientation : portrait) {

				/* Responsive Block Hiding */
				.responsive-block-hiding-device-tablets-portrait {
					display: none !important;
				}

			}
		';
		
	}
	
	
	static function smartphones() {
		
		$wrapper_margin = HeadwayOption::get('disable-wrapper-margin-for-smartphones', false, true) ? '.responsive-grid-active div.wrapper { margin:0; }' : null;		
				
		return '
			/* --- Smartphones and small Tablet PCs --- */
			@media only screen and (max-width : 600px) {
				
				' . $wrapper_margin . '

				/* Set all blocks/columns to be 100% width */
				.responsive-grid-active .block, .responsive-grid-active .row, .responsive-grid-active .column {
					width: 100%;
					margin-left: 0;
					margin-right: 0;
				}

				/* Take the minimum height off of fluid blocks. */
				.responsive-grid-active .block-fluid-height {
					min-height: 40px;
				}

				/* Responsive Block Hiding */
				.responsive-block-hiding-device-smartphones {
					display: none !important;
				}

				/* Navigation Block */
					.responsive-grid-active .block-type-navigation {
						height: auto;
						min-height: 40px;
					}
					
					.responsive-grid-active .block-type-navigation .tinynav { display: block; }
					.responsive-grid-active .block-type-navigation ul.menu.tinynav-active { display: none; }
				/* End Navigation Block */

				/* Content Block */
					.responsive-grid-active .block-type-content a.post-thumbnail {
						width: 100%;
						margin: 20px 0;
						text-align: center;
					}

						.responsive-grid-active .block-type-content a.post-thumbnail img {
							max-width: 100%;
							height: auto;
						}
						
					.responsive-grid-active .block-type-content .loop-navigation {
						text-align: center;
					}
					
						.responsive-grid-active .block-type-content .loop-navigation .nav-previous, 
						.responsive-grid-active .block-type-content .loop-navigation .nav-next {
							float: none;
							margin: 0 10px;
						}
						
						.responsive-grid-active .block-type-content .loop-navigation .nav-next {
							margin-top: 20px;
						}
				/* End Content Block */

				/* Footer Block */
				.responsive-grid-active .block-type-footer div.footer > * {
					clear: both;
					float: none;
					display: block;
					margin: 15px 0;
					text-align: center;
				}
				/* End Footer Block */

			}
		';
		
	}
	
	
	static function fitvids() {
		
		return 'jQuery(document).ready(function() { jQuery(document).fitVids(); });';
		
	}
	
	
}