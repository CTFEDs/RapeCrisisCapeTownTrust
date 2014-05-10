<?php
function headway_register_visual_editor_panel($class) {

	add_action('headway_visual_editor_init', create_function('', 'return headway_register_visual_editor_panel_callback(\'' . $class . '\');'), 999);
	
}


function headway_register_visual_editor_panel_callback($class) {

	if ( !class_exists($class) )
		return new WP_Error('panel_class_does_not_exist', __('Error: The panel class being registered does not exist.', 'headway'), $class);
	
	$panel = new $class();
	$panel->register();
	
	return true;
	
}


abstract class HeadwayVisualEditorPanelAPI {
	
	
	/**
	 *	Slug/ID of panel.  Will be used for HTML IDs and whatnot.
	 **/
	public $id;
	
	
	/**
	 * Name of panel.  This will be shown in the tabs.
	 **/
	public $name;
	
	
	/**
	 * Sub tabs.  This is not always used.
	 **/
	public $tabs;
	
	
	/**
	 * Inputs.  This is not always used.
	 **/
	public $inputs;
	
	
	/**
	 * Which mode to display the panel on.
	 **/
	public $mode;
	
	
	/**
	 * Which options group to save in by default
	 **/
	public $options_group = 'general';
	
	
	/** 
	 * Define whether or not this panel is for a block or not
	 **/
	public $is_block = false;
	
	
	/**
	 * If it's a block, then we need to also have ID of block
	 **/
	public $block_id = null;
	
	
	
	/**
	 * Register the panel.
	 * 
	 * @param string Name of panel to be displayed
	 * @param string ID of panel for HTML and options
	 **/
	public function register() {
		
		$mode = HeadwayVisualEditor::get_current_mode();

		/* Forward old Manage panels to Design */
		if ( $this->mode == 'manage' )
			$this->mode = 'design';
		
		if ( strtolower($this->mode) !== strtolower($mode) )
			return false;
		
		/* Since there is a message that's displayed if there is no panel content, we have to tell it not to display the message now that
		 * we're registering a panel */
		remove_action('headway_visual_editor_panel_top', array('HeadwayVisualEditorDisplay', 'add_default_panel_link'));
		remove_action('headway_visual_editor_content', array('HeadwayVisualEditorDisplay', 'add_default_panel'));
			
		add_action('headway_visual_editor_panel_top', array($this, 'panel_link'));
		add_action('headway_visual_editor_content', array($this, 'build_panel'));
					
	}
	
	
	public function modify_arguments($args = false) {
		
		//Allow developers to modify the properties of the class and use functions since doing a property 
		//outside of a function will not allow you to.
		
	}
	
	
	public function parse_function_args($array) {
		
		if ( !is_array($array) || count($array) === 0 )
			return $array;
			
		foreach ( $array as $key => $value ) {
			
			if ( !is_string($value) )
				continue;
			
			//Check if it's a function
			if ( preg_match("/^[a-z0-9_]*(\(\))$/", $value) ) {				
				$array[$key] = call_user_func(array($this, str_replace('()', '', $value)));
			} else {
				continue;
			}
			
		}
		
		return $array;
		
	}
	
	
	public function panel_link() {
		
		echo '<li><a href="#' . $this->id . '-tab">' . $this->name . '</a></li>';
		
	}
	
	
	public function build_panel($id) {
		
		$class = ($this->tabs) ? ' sub-tab' : null;
			
		echo '<div id="' . $this->id . '-tab" class="panel' . $class . '">';
		
			$this->panel_content();
		
		echo '</div>';
					
	}
	
	
	public function panel_content($args = false) {

		//Allow developers to modify the properties of the class and use functions since doing a property 
		//outside of a function will not allow you to.
		$this->modify_arguments($args);
		
		if ( $this->tabs && $this->inputs ) {
			
			echo '<ul class="sub-tabs">';
			
				foreach ($this->tabs as $id => $name) {
					
					echo '<li id="sub-tab-' . $id . '"><a href="#sub-tab-' . $id . '-content">' . $name . '</a></li>';
					
				}
			
			echo '</ul>';
			
			echo '<div class="sub-tabs-content-container">';
			
			foreach ($this->tabs as $id => $name) {
				
				echo '<div class="sub-tabs-content" id="sub-tab-' . $id . '-content">';
					
					//Display notice for tab if one exists.
					if ( isset($this->tab_notices[$id]) )
						echo '<p class="sub-tab-notice">' . $this->tab_notices[$id] . '</p>';
				
					$this->sub_tab_content($id, $name);
				
				echo '</div><!-- div#sub-tab-' . $id . '-content -->';
				
			}
			
			echo '</div><!-- .sub-tabs-content-container -->';
						
		}
		
	}
	
	
	public function sub_tab_content($id, $name = false) {
		
		$this->create_inputs($id);
					
	}


		public function create_inputs($tab) {

			if ( isset($this->inputs[$tab]) && is_array($this->inputs[$tab]) ) {

				foreach ( $this->inputs[$tab] as $name => $input )
					$this->render_input($input);

			}

		}
	
	
	public function render_input($input) {
						
		//Fill defaults
		$defaults = array(
			'tooltip' => false,
			'default' => false,
			'callback' => null
		);
		
		//Merge defaults
		$input = array_merge($defaults, $input);
		
		//Fix up inputs
		$input = $this->parse_function_args($input);
		
		if ( !isset($input['name']) || !isset($input['type']) )
			return;
		
		$input['tooltip'] = (isset($input['tooltip']) && $input['tooltip'] != false) ? $input['tooltip'] : false;
		$input['name'] = strtolower($input['name']);

		/* Setup Variables */
			//Put this code here to reduce repetition of code throughout input methods
			$input['default'] = ( isset($input['default']) ) ? $input['default'] : null;
			$input['group'] = ( isset($input['group']) ) ? $input['group'] : $this->options_group;
			
			//Set up all of the name attributes
			$block_id = ($this->is_block && $this->block['id']) ? ' block_id="' . $this->block['id'] . '"' : null;
			$is_block = ($block_id !== null) ? 'true' : 'false';
			$input_id = ( $is_block == 'true' ) ? 'input-' . $this->block['id'] . '-' . $input['name'] : 'input-' . $input['group'] . '-' . $input['name'];
									
			//Figure out if it's a regular option, layout option, or block setting
			if ( $this->is_block && isset($this->block) && !isset($input['value']) )
				$input['value'] = HeadwayBlocksData::get_block_setting($this->block, $input['name'], $input['default']);
			elseif ( !isset($input['value']) )
				$input['value'] = HeadwayOption::get($input['name'], $input['group'], $input['default']);

			//Set up the callback
			$block_js_var = ($this->is_block && $this->block['id']) ? 'var block = $i(\'.block[data-id="' . $this->block['id'] . '"]\');' : 'var block = null;';
			$callback = 'callback="' . htmlspecialchars('(function(args){var input=args.input;var value=args.value;' . $block_js_var . $input['callback'] . '})') . '"';
			$toggle = headway_get('toggle', $input) ? 'toggle=' . json_encode($input['toggle']) : '';
				
			//No save inputs
			$no_save = headway_get('no-save', $input, false) ? ' no-save="true"' : null;

			//Fill attributes for the hidden input
			$input['attributes'] = 'id="' . $input_id . '" is_block="' . $is_block . '"' . $block_id . ' name="' . $input['name'] . '" group="' . $input['group'] . '" ' . $callback . $toggle . $no_save;

		/* If it's a repeater then handle it before it's handled as an input */
			if ( $input['type'] == 'repeater' )
				return $this->repeater($input);
			
		/* Handle regular input */				
			if ( method_exists($this, 'input_' . str_replace('-', '_', $input['type'])) ) {
				
				echo '<div class="input input-' . $input['type'] . '" id="input-' . $input['name'] . '">';
									
					if ( $input['tooltip'] )
						echo '<div class="tooltip-button" title="' . htmlspecialchars($input['tooltip']) . '"></div>';
				
					call_user_func(array($this, 'input_' . str_replace('-', '_', $input['type'])), $input);

				echo '</div><!-- #input-' . $input['name'] . ' -->';

				
			}
		/* End regular input handling */
		
	}


	public function repeater($input) {

		$repeater_sortable_class = headway_get('sortable', $input) ? ' repeater-sortable' : null;

		echo '<div class="repeater' . $repeater_sortable_class . '" data-repeater-limit="' . headway_get('limit', $input, '0') . '">';

			if ( $repeater_label = headway_get('label', $input) ) {

				$this->render_input(array(
					'name' => 'repeater-' . $input['name'] . '-heading',
					'type' => 'heading',
					'label' => $repeater_label,
					'tooltip' => headway_get('tooltip', $input)
				));

			}

			/* If the value is non-existent then show an empty group. */
				if ( !isset($input['value']) || !is_array($input['value']) || empty($input['value']) ) {

					$this->repeater_group(array_merge($input, array(
						'single' => true
					)));

			/* Values are valid, loop them. */
				} else {

					foreach ( $input['value'] as $group_index => $value_group )
						$this->repeater_group($input, $group_index);

				}

			/* Add the template repeater group that's cloned when a new group is added */
				$this->repeater_group(array_merge($input, array(
					'template' => true,
					'value' => null
				)));

			/* Hidden Input */
				echo '<input ' . $input['attributes'] . ' type="hidden" value="" class="repeater-group-input" />';
 				
		echo '</div><!-- .repeater -->';

	}
	

		public function repeater_group($input, $group_index = null) {

			$classes = array('repeater-group');

			if ( headway_get('template', $input) )
				$classes[] = 'repeater-group-template';

			if ( headway_get('single', $input) )
				$classes[] = 'repeater-group-single';

			echo '<div class="' . implode(' ', $classes) . '">';

				if ( headway_get('sortable', $input) )
					echo '<span class="sortable-handle"><span></span><span></span><span></span></span>';

				foreach ( $input['inputs'] as $index => $input_options ) {

					$input_value = headway_get($input_options['name'], $input['value'][$group_index], headway_get('default', $input_options));

					if ( empty($input_value) )
						$input_value = null;

					$this->render_input(array_merge($input_options, array(
						'value' => $input_value
					)));

				}

				echo '<span class="remove-group"></span>';
				echo '<span class="add-group"></span>';

			echo '</div><!-- .repeater-group -->';	

		}
	

	public function input_checkbox($input) {
		
		$checked_class = ( (bool)$input['value'] === true ) ? ' class="checkbox-checked"' : null;

		echo '
			<div class="input-left">
				<label' . $checked_class . '>' . $input['label'] . '</label>
			</div>
			
			<div class="input-right">
				<span' . $checked_class . '></span>
				<input ' . $input['attributes'] . ' type="hidden" value="' . ($input['value'] ? 'true' : 'false') . '" />
			</div>
		';
		
	}
	
	
	public function input_text($input) {
	
		$readonly = ( isset($input['readonly']) && $input['readonly'] === true )  ? ' disabled' : null;
		
		echo '
			<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
			
			<div class="input-right">
				<input type="text" ' . $input['attributes'] . ' placeholder="' . stripslashes(htmlspecialchars(headway_get('placeholder', $input))) . '" value="' . stripslashes(htmlspecialchars($input['value'])) . '" class="text"' . $readonly . ' />';
				
			if ( isset($input['suffix']) ) echo '<span class="suffix">' . $input['suffix'] . '</span>';

		echo '
			</div>
		';

	}
	
	
	public function input_textarea($input) {

		echo '
			<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
			
			<div class="input-right">
				<span class="textarea-open pencil-icon tooltip" title="View Textarea"></span>
				<div class="textarea-container">
					<textarea ' . $input['attributes'] . '>' . stripslashes(htmlspecialchars($input['value'])) . '</textarea>
				</div>
			</div>
		';
		
	}


	public function input_wysiwyg($input) {

		echo '
			<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
			
			<div class="input-right">
				<span class="wysiwyg-open pencil-icon tooltip" title="View Editor"></span>
				<div class="wysiwyg-container">
					<textarea ' . $input['attributes'] . '>' . stripslashes(htmlspecialchars($input['value'])) . '</textarea>
				</div>
			</div>
		';
		
	}
	

	public function input_integer($input) {

		$readonly = ( isset($input['readonly']) && $input['readonly'] === true )  ? ' disabled' : null;
		
		echo '<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
			
			<div class="input-right">
				<input type="text" ' . $input['attributes'] . ' value="' . (int)$input['value'] . '" class="text"'. $readonly .' />';
				
			if ( isset($input['unit']) ) echo '<span class="suffix">' . $input['unit'] . '</span>';
			
		echo '
			</div>
		';
						
	}
	
	
	public function input_select($input) {
				
		echo '
			<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
		';
		
				
		echo '<div class="input-right">';
			
			echo '<div class="select-container"><select ' . $input['attributes'] . '>';

			foreach($input['options'] as $value => $text) {
				
				$selected = ( $input['value'] === $value ) ? ' selected' : null;
						
				echo '<option value="' . $value . '"' . $selected . '>' . $text . '</option>';
				
			}

			echo '</select></div><!-- .select-container -->';

		echo '</div>';
										
	}
	
	
	public function input_multi_select($input) {
				
		echo '
			<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
		';				
				
		echo '<div class="input-right">';
	
			echo '<span class="multi-select-open pencil-icon tooltip" title="View Options"></span>';
			echo '<div class="multi-select-container">';
						
				echo '<select ' . $input['attributes'] . ' multiple="multiple" class="tooltip" title="Hold Ctrl (Windows) or Command (Mac) to select multiple options.">';

				foreach ( $input['options'] as $value => $text ) {
					
					$selected = ( is_array($input['value']) && in_array($value, $input['value']) ) ? ' selected' : null;
		
					echo '<option title="' . $text . '" value="' . $value . '"' . $selected . '>' . $text . '</option>';
					
				}

				echo '</select>';
			
			echo '</div><!-- .multi-select-container -->';
	
		echo '</div>';
										
	}

	
	public function input_colorpicker($input) {
		
		$input['value'] = headway_format_color($input['value']);
		
		echo '
			<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div>
			
			<div class="input-right">
				<div class="colorpicker-box-container">
					<div class="colorpicker-box-transparency"></div>
					<div class="colorpicker-box" style="background-color:' . $input['value'] . ';"></div>
				</div><!-- .colorpicker-box-container -->

				<input ' . $input['attributes'] . ' type="hidden" value="' . $input['value'] . '" />
			</div>
		';
		
	}
	
	
	public function input_image($input) {
		
		$src_visibility = ( $input['value'] !== null && is_string($input['value']) ) ? '' : ' style="display:none;"';
		
		echo '<div class="input-left"><label>' . $input['label'] . '</label></div><!-- .input-left -->';		
				
		echo '<div class="input-right"><span class="src"' . $src_visibility . '>' . end(explode('/', $input['value'])) . '</span>
		<span class="delete-image"' . $src_visibility . '>Delete</span>';
						
		echo '<span class="button">Choose Image</span>
			<input ' . $input['attributes'] . ' type="hidden" value="' . $input['value'] . '" /></div><!-- .input-right -->';
		
	}


	public function input_slider($input) {
				
		$input['slider-interval'] = (isset($input['slider-interval'])) ? $input['slider-interval'] : 1;
			
		echo '<div class="input-left">
				<label>' . $input['label'] . '</label>
			</div><!-- .input-left -->
	
			<div class="input-right">
				<div class="input-slider-bar" slider_min="' . $input['slider-min'] . '" slider_max="' . $input['slider-max'] . '" slider_interval="' . $input['slider-interval'] . '"></div><!-- .input-slider-bar -->
			
				<div class="input-slider-bar-text">
					<span class="slider-value">' . $input['value'] . '</span>';
	
		if ( isset($input['unit']) && $input['unit'] !== false ) echo '<span class="slider-unit">' . $input['unit'] . '</span>';
		
		echo '</div><!-- .input-slider-bar-text -->';
		echo '</div><!-- .input-right -->';

		echo '<input type="hidden" value="' . $input['value'] . '" ' . $input['attributes'] . ' class="input-slider-bar-hidden" />';

	}


	public function input_heading($input) {

		echo '
			<h3 class="options-heading">' . $input['label'] . '</h3>
		';
		
	}


	public function input_notice($input) {

		echo '<p class="sub-tab-notice">' . $input['notice'] . '</p>';

	}


	public function input_button($input) {
							
		if ( isset($input['label']) && !empty($input['label']) ) {

			echo '<div class="input-left">
					<label>' . $input['label'] . '</label>
				</div><!-- .input-left -->';

		}
	
		echo '<div class="input-right">
				<span class="button" ' . $input['attributes'] . '>' . $input['button-label'] . '</span>
			</div><!-- .input-right -->';

	}


	public function input_import_file($input) {
							
		if ( isset($input['label']) && !empty($input['label']) ) {

			echo '<div class="input-left">
					<label>' . $input['label'] . '</label>
				</div><!-- .input-left -->';

		}

		echo '<div class="input-right">';
								
			echo '<span class="button">' . $input['button-label'] . '</span>';
			echo '<input type="file" ' . $input['attributes'] . ' />';

			$src_visibility = ( $input['value'] !== null && is_string($input['value']) ) ? '' : ' style="display:none;"';

			echo '<span class="src"' . $src_visibility . '>' . end(explode('/', $input['value'])) . '</span>
			<span class="delete-file"' . $src_visibility . '>Delete</span>';

		echo '</div><!-- .input-right -->';

	}


}