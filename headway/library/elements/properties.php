<?php
class HeadwayElementProperties {
	
	
	protected static $properties = array(

		/* Fonts */
			'font-family' => array(
				'group' => 'Fonts',
				'name' => 'Font Family',
				'type' => 'font-family-select',
				'js-callback' => 'propertyInputCallbackFontFamily(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_font_family'
			),

			'font-size' => array(
				'group' => 'Fonts',
				'name' => 'Font Size',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"font-size": params.value + "px"});',
				'unit' => 'px',
				'options' => 'HeadwayPropertyInputs::font_size_options()'
			),

			'color' => array(
				'group' => 'Fonts',
				'name' => 'Color',
				'type' => 'color',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"color": params.value});',
				'default' => '000000'
			),

			'line-height' => array(
				'group' => 'Fonts',
				'name' => 'Line Height',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"line-height": params.value + "%"});',
				'unit' => '%',
				'options' => 'HeadwayPropertyInputs::line_height_options()'
			),

			'font-styling' => array(
				'group' => 'Fonts',
				'name' => 'Font Styling',
				'type' => 'select',
				'options' => array(
					'normal' => 'Normal',
					'bold' => 'Bold',
					'italic' => 'Italic',
					'bold-italic' => 'Bold Italic'
				),
				'js-callback' => 'propertyInputCallbackFontStyling(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_font_styling'
			),
			
			'text-align' => array(
				'group' => 'Fonts',
				'name' => 'Alignment',
				'type' => 'select',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right'
				),
				'js-callback' => 'stylesheet.update_rule(params.selector, {"text-align": params.value});'
			),

			'capitalization' => array(
				'group' => 'Fonts',
				'name' => 'Capitalization',
				'type' => 'select',
				'options' => array(
					'none' => 'Normal',
					'uppercase' => 'Uppercase',
					'lowercase' => 'Lowercase',
					'small-caps' => 'Small Caps',
				),
				'js-callback' => 'propertyInputCallbackCapitalization(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_capitalization'
			),
			
			'letter-spacing' => array(
				'group' => 'Fonts',
				'name' => 'Letter Spacing',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"letter-spacing": params.value + "px"});',
				'unit' => 'px',
				'options' => array(
					'0' => '0',
					'1' => '1px',
					'2' => '2px',
					'3' => '3px',
					'-1' => '-1px',
					'-2' => '-2px',
					'-3' => '-3px'
				)
			),
			
			'text-decoration' => array(
				'group' => 'Fonts',
				'name' => 'Underline',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"text-decoration": params.value});',
				'options' => array(
					'none' => 'No Underline',
					'underline' => 'Underline',
				)
			),

		/* Background */
			'background-color' => array(
				'group' => 'Background',
				'name' => 'Color',
				'type' => 'color',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"background-color": params.value});',
				'default' => 'ffffff'
			),

			'background-image' => array(
				'group' => 'Background',
				'name' => 'Image',
				'type' => 'image',
				'js-callback' => 'propertyInputCallbackBackgroundImage(params);'
			),

			'background-repeat' => array(
				'group' => 'Background',
				'name' => 'Image Repeat',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"background-repeat": params.value});',
				'options' => array(
					'repeat' => 'Tile',
					'no-repeat' => 'No Tiling',
					'repeat-x' => 'Tile Horizontally',
					'repeat-y' => 'Tile Vertically'
				)
			),

			'background-position' => array(
				'group' => 'Background',
				'name' => 'Image Position',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"background-position": params.value});',
				'options' => array(
					'left top' => 'Left Top',
					'left center' => 'Left Center',
					'left bottom' => 'Left Bottom',
					'right top' => 'Right Top',
					'right center' => 'Right Center',
					'right bottom' => 'Right Bottom',
					'center top' => 'Center Top',
					'center center' => 'Center Center',
					'center bottom' => 'Center Bottom'
				)
			),

			'background-attachment' => array(
				'group' => 'Background',
				'name' => 'Image Attachment',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"background-attachment": params.value});',
				'options' => array(
					'scroll' => 'Stay at top of document (Scroll)',
					'fixed' => 'Move with scroll (Fixed)'
				)
			),
		
		/* Borders */
			'border-color' => array(
				'group' => 'Borders',
				'name' => 'Border Color',
				'type' => 'color',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-color": params.value});',
				'default' => '000000'
			),

			'border-style' => array(
				'group' => 'Borders',
				'name' => 'Border Style',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-style": params.value});',
				'options' => array(
					'none' => 'Hidden',
					'solid' => 'Solid',
					'dashed' => 'Dashed',
					'dotted' => 'Dotted',
					'double' => 'Double',
					'groove' => 'Grooved',
					'inset' => 'Inset',
					'outset' => 'Outset',
					'ridge' => 'Ridged'
				)
			),

			'border-top-width' => array(
				'group' => 'Borders',
				'name' => 'Top Border Width',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-top-width": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),
			
			'border-right-width' => array(
				'group' => 'Borders',
				'name' => 'Right Border Width',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-right-width": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),
			
			'border-bottom-width' => array(
				'group' => 'Borders',
				'name' => 'Bottom Border Width',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-bottom-width": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),
			
			'border-left-width' => array(
				'group' => 'Borders',
				'name' => 'Left Border Width',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-left-width": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),
			

		/* Padding */
			'padding-top' => array(
				'group' => 'Padding',
				'name' => 'Top',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"padding-top": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),

			'padding-right' => array(
				'group' => 'Padding',
				'name' => 'Right',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"padding-right": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),

			'padding-bottom' => array(
				'group' => 'Padding',
				'name' => 'Bottom',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"padding-bottom": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),

			'padding-left' => array(
				'group' => 'Padding',
				'name' => 'Left',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"padding-left": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),


		/* Margin */
			'margin-top' => array(
				'group' => 'Margins',
				'name' => 'Top',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"margin-top": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),

			'margin-right' => array(
				'group' => 'Margins',
				'name' => 'Right',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"margin-right": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),

			'margin-bottom' => array(
				'group' => 'Margins',
				'name' => 'Bottom',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"margin-bottom": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),

			'margin-left' => array(
				'group' => 'Margins',
				'name' => 'Left',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"margin-left": params.value + "px"});updateInspectorVisibleBoxModal();',
				'unit' => 'px',
				'default' => 0
			),


		/* Rounded Corners (Border Radius) */
			'border-top-left-radius' => array(
				'group' => 'Rounded Corners',
				'name' => 'Top Left',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-top-left-radius": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),

			'border-top-right-radius' => array(
				'group' => 'Rounded Corners',
				'name' => 'Top Right',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-top-right-radius": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),

			'border-bottom-left-radius' => array(
				'group' => 'Rounded Corners',
				'name' => 'Bottom Left',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-bottom-left-radius": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),

			'border-bottom-right-radius' => array(
				'group' => 'Rounded Corners',
				'name' => 'Bottom Right',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"border-bottom-right-radius": params.value + "px"});',
				'unit' => 'px',
				'default' => 0
			),

		/* Box Shadow */
			'box-shadow-horizontal-offset' => array(
				'group' => 'Box Shadow',
				'name' => 'Horizontal Offset',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => 0
			),

			'box-shadow-vertical-offset' => array(
				'group' => 'Box Shadow',
				'name' => 'Vertical Offset',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => 0
			),

			'box-shadow-blur' => array(
				'group' => 'Box Shadow',
				'name' => 'Blur',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => 0
			),

			'box-shadow-color' => array(
				'group' => 'Box Shadow',
				'name' => 'Color',
				'type' => 'color',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => '000000'
			),

			'box-shadow-position' => array(
				'group' => 'Box Shadow',
				'name' => 'Position',
				'type' => 'select',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'options' => array(
					'outside' => 'Outside',
					'inset' => 'Inset'
				)
			),

		/* Text Shadow */
			'text-shadow-horizontal-offset' => array(
				'group' => 'Text Shadow',
				'name' => 'Horizontal Offset',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => 0
			),

			'text-shadow-vertical-offset' => array(
				'group' => 'Text Shadow',
				'name' => 'Vertical Offset',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => 0
			),

			'text-shadow-blur' => array(
				'group' => 'Text Shadow',
				'name' => 'Blur',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => 0
			),

			'text-shadow-color' => array(
				'group' => 'Text Shadow',
				'name' => 'Color',
				'type' => 'color',
				'js-callback' => 'propertyInputCallbackShadow(params);',
				'complex-property' => 'HeadwayElementProperties::complex_property_shadow',
				'default' => '000000'
			),

		/* List Styling */
			'list-style' => array(
				'group' => 'Lists',
				'name' => 'List Style',
				'type' => 'select',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"list-style": params.value});',
				'options' => array(
					'none' => 'No Bullet/Style',
					'disc' => 'Bullet',
					'circle' => 'Circle',
					'square' => 'Square',
					'decimal' => 'Decimal Numbers (1., 2., etc)',
					'lower-alpha' => 'Alphabetical (Lowercase)',
					'upper-alpha' => 'Alphabetical (Uppercase)',
					'lower-roman' => 'Roman Numerals (Lowercase)',
					'upper-roman' => 'Roman Numerals (Uppercase)',
				),
				'default' => 'disc'
			),

		/* Nudging */
			'top' => array(
				'group' => 'Nudging',
				'name' => 'Vertical Offset',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"top": params.value + "px"});',
				'default' => 0
			),

			'left' => array(
				'group' => 'Nudging',
				'name' => 'Horizontal Offset',
				'type' => 'integer',
				'unit' => 'px',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"left": params.value + "px"});',
				'default' => 0
			),

			'position' => array(
				'group' => 'Nudging',
				'name' => 'Method',
				'type' => 'select',
				'default' => 'static',
				'options' => array(
					'static' => 'Static',
					'relative' => 'Relative',
					'absolute' => 'Absolute',
					'fixed' => 'Floating (Fixed)'
				),
				'js-callback' => 'stylesheet.update_rule(params.selector, {"position": params.value});',
			),

			'z-index' => array(
				'group' => 'Nudging',
				'name' => 'Layer Index (z-index)',
				'type' => 'integer',
				'js-callback' => 'stylesheet.update_rule(params.selector, {"z-index": params.value});',
				'default' => 1
			),

		/* Overflow */
			'overflow' => array(
				'group' => 'Overflow',
				'name' => 'Visibility',
				'type' => 'select',
				'options' => array(
					'visible' => 'Visible',
					'hidden' => 'Hidden',
					'scroll' => 'Scroll',
				),
				'js-callback' => 'stylesheet.update_rule(params.selector, {"overflow": params.value});',
			)

	);
	
	
	public static function get_property($property) {
				
		return isset(self::$properties[$property]) ? self::$properties[$property] : null;
		
	}
	
	
	public static function get_properties_by_group($group) { 
		
		//Filter though all of the properties to make sure they are in the selected group
		$filtered_properties = array_filter(self::$properties, create_function('$property', 'return ($property[\'group\'] === \'' . $group . '\');'));
		
		if ( !is_array($filtered_properties) || count($filtered_properties) === 0 )
			return null;
		else
			return $filtered_properties;
	
	}


	public static function get_properties() {

		return self::$properties;

	}
	
	
	public static function output_css($selector, $properties = array()) {
				
		if ( !isset($selector) || $selector == false )
			return null;
			
		if ( !is_array($properties) || count($properties) === 0 )
			return null;
					
		$output = '';
		
		$output .= $selector . ' {' . "\n";
	
			//Loop through properties
			foreach ( $properties as $property_id => $value ) {
			
				//If the value is an empty string, false, or null, don't attempt to put anything.
				if ( !isset($value) || $value === '' || $value === false || $value === null || $value == 'null' )
					continue;
			
				//Look up the property to figure out how to handle it
				$property = self::get_property($property_id);
				
				//If the property does not exist, skip it.
				if ( !$property )
					continue;
							
				//If it's a complex property, pass everything through it.
				if ( headway_get('complex-property', $property) && is_callable(headway_get('complex-property', $property)) ) {
					$output .= call_user_func(headway_get('complex-property', $property), array(
						'selector' => $selector, 
						'property_id' => $property_id, 
						'value' => $value, 
						'properties' => $properties, 
						'property' => $property
					));
					
					continue;
				}
				
				//Format the $value by adding the unit or hex indicator if it's a color
				if ( headway_get('unit', $property) !== null )
					$value = $value . $property['unit'];
				
				if ( headway_get('type', $property) === 'color' )
					$value = headway_format_color($value);
				
				if ( headway_get('type', $property) === 'image' && $value != 'none' )
					$value = 'url(' . $value . ')';
			
				$output .= $property_id . ': ' . $value . ';' . "\n";
			
			} //foreach: Regular Properties
	
		$output .= '}' . "\n";
		
		return $output;
		
	}
	

	public static function complex_property_font_family($args) {

		extract($args);

		$font_fragments = explode('|', $value);

		/* Web Font */
		if ( count($font_fragments) === 2 )
			$stack = $font_fragments[1];

		/* Traditional Font */
		else
			$stack = HeadwayFonts::get_stack($value);

		return 'font-family: ' . $stack . ';';

	}

	
	public static function complex_property_shadow($args) {
		
		extract($args);
												
		$shadow_type = (strpos($property_id, 'box-shadow') !== false) ? 'box-shadow' : 'text-shadow';		
		
		global $headway_complex_property_check;
		
		//If the complex property check isn't even set, make it an empty array.
		if ( !is_array($headway_complex_property_check) )
			$headway_complex_property_check = array($shadow_type => array());
						
		//Since the complex property is a combination of a bunch of properties, we only want it to output once.
		if ( isset($headway_complex_property_check[$shadow_type][$selector]) && $headway_complex_property_check[$shadow_type][$selector] == true )
			return;
			
		$headway_complex_property_check[$shadow_type][$selector] = true;
		
		if ( !isset($properties[$shadow_type . '-color']) )
			return null;

		$shadow_color = headway_format_color($properties[$shadow_type . '-color']);

		if ( $shadow_color == 'transparent' )
			return null;

		$shadow_hoffset = isset($properties[$shadow_type . '-horizontal-offset']) ? $properties[$shadow_type . '-horizontal-offset'] : '0';
		$shadow_voffset = isset($properties[$shadow_type . '-vertical-offset']) ? $properties[$shadow_type . '-vertical-offset'] : '0';
		$shadow_blur = isset($properties[$shadow_type . '-blur']) ? $properties[$shadow_type . '-blur'] : '0';
		$shadow_inset = (headway_get($shadow_type . '-position', $properties, 'outside') == 'inset') ? ' inset' : null;
				
		return $shadow_type . ': ' . $shadow_color . ' ' . $shadow_hoffset . 'px ' . $shadow_voffset . 'px ' . $shadow_blur . 'px' . $shadow_inset . ';';
		
	}
			
		
	public static function complex_property_capitalization($args) {
		
		extract($args);
		
		$data = '';
		
		if ( $value == 'none' ) {
			
			$data .= 'text-transform: none;';
			$data .= 'font-variant: normal;';
			
		} elseif ( $value == 'small-caps' ) {
			
			$data .= 'text-transform: none;';
			$data .= 'font-variant: small-caps;';

		} else {
			
			$data .= 'text-transform: ' . $value . ';';
			$data .= 'font-variant: normal;';
			
		}
		
		return $data;
		
	}
	
	
	public static function complex_property_font_styling($args) {
		
		extract($args);
		
		$data = '';
		
		if ( $value == 'normal' ) {
			
			$data .= 'font-style: normal;';
			$data .= 'font-weight: normal;';
			
		} elseif ( $value == 'bold' ) {
			
			$data .= 'font-style: normal;';
			$data .= 'font-weight: bold;';

		} elseif ( $value == 'italic' ) {

			$data .= 'font-style: italic;';
			$data .= 'font-weight: normal;';

		} elseif ( $value == 'bold-italic' ) {
			
			$data .= 'font-style: italic;';
			$data .= 'font-weight: bold;';
			
		}
		
		return $data;
		
	}		

	
}