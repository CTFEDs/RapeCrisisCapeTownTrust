<?php
class EditorPanel extends HeadwayVisualEditorPanelAPI {
	
	
	public $id = 'editor';
	public $name = 'Editor';
	public $mode = 'design';

	
	function panel_content() {
		
		echo '
			<div class="design-editor-element-selector-container">';

				echo '<ul id="design-editor-main-elements" class="sub-tabs element-selector">';
						
					$sub_elements = array();

					$groups = HeadwayElementAPI::get_groups();

					foreach ( HeadwayElementAPI::get_all_elements() as $group => $elements ) {

						if ( $group == 'default-elements' )
							continue;

						$group_name = headway_get($group, $groups);

						if ( $group_name )
							echo '<li id="element-group-' . $group . '" class="element-group"><span>' . $group_name . '</span></li>';

						foreach ( $elements as $id => $settings ) {

							$classes = array(
								'main-element',
								'group-' . $group
							);

							/* If the element has children, then add the appropriate class to 
							show the arrow and add its sub elements to the main sub elements array */
							if ( is_array($settings['children']) && count($settings['children']) > 0 ) {
								$classes[] = 'has-children';
								$sub_elements = array_merge($sub_elements, $settings['children']);
							}

							/* Since there are so many attributes, we'll just use an array to clean things up */
							$attrs = array(
								'id="element-' . $id . '"',
								'class="' . implode(' ', $classes) . '"',
								'data-inherit-location="' . $this->get_inherit_location_data_attr($id) . '"',
								"data-instances='" . htmlspecialchars(json_encode($this->get_instances_data_attr($id)), ENT_QUOTES) . "'",
								"data-states='" . htmlspecialchars(json_encode($this->get_states_data_attr($id)), ENT_QUOTES) . "'",
								'data-selector="' . $settings['selector'] . '"'
							);

							echo '
								<li ' . trim(implode(' ', $attrs)) . '>
									<span>' . $settings['name'] . '</span>
								</li>
							';

						}
						
					}

				echo '</ul><!-- #design-editor-main-elements -->';
				
				echo '<ul id="design-editor-sub-elements" class="sub-tabs element-selector element-selector-hidden">';
							
					foreach ( $sub_elements as $id => $settings ) {

						$attrs = array(
							'id="element-' . $id . '"',
							'class="sub-element parent-element-' . $settings['parent'] . '"',
							'data-inherit-location="' . $this->get_inherit_location_data_attr($id) . '"',
							"data-instances='" . htmlspecialchars(json_encode($this->get_instances_data_attr($id)), ENT_QUOTES) . "'",
							"data-states='" . htmlspecialchars(json_encode($this->get_states_data_attr($id)), ENT_QUOTES) . "'",
							'data-selector="' . $settings['selector'] . '"'
						);

						echo '
							<li ' . trim(implode(' ', $attrs)) . '">
								<span>' . $settings['name'] . '</span>
							</li>
						';

					}
											
				echo '</ul><!-- #design-editor-sub-elements -->';

			echo '</div><!-- .design-editor-element-selector-container -->
			
			<div class="design-editor-options-container">
			
				<div class="design-editor-info" style="display: none;">
					<h4>Editing: <span></span> <strong></strong> <code class="tooltip" title="">{}</code></h4>
					
					<div class="design-editor-info-right">
						<div class="select-container instances">
							<select class="instances">
							</select>
						</div><!-- .select-container -->
						
						<div class="select-container states">
							<select class="states">
							</select>
						</div><!-- .select-container -->
						
						<span class="button button-small design-editor-info-button customize-element-for-layout">Customize For Current Layout</span>
						<span class="button button-small design-editor-info-button customize-for-regular-element">Customize Regular Element</span>
					</div>
				</div><!-- .design-editor-info -->
				
				<div class="design-editor-options" style="display:none;"></div><!-- .design-editor-options -->
				
				<p class="design-editor-options-instructions sub-tab-notice">' . __('Please select an element to the left.', 'headway') . '</p>
				
			</div><!-- .design-editor-options-container -->
		';

	}


		function get_inherit_location_data_attr($element_id) {

			$inherit_location_element = HeadwayElementAPI::get_element(HeadwayElementAPI::get_inherit_location($element_id));
			
			return is_array($inherit_location_element) ? $inherit_location_element['name'] : null;
			
		}


		function get_instances_data_attr($element_id) {

			$instances_query = HeadwayElementAPI::get_instances($element_id);
			$instances = array();
					
			if ( !is_array($instances_query) )	
				return null;
			
			foreach ( $instances_query as $instance ) {
				
				$instances[$instance['id']] = $instance;
				
			}

			return $instances;

		}


		function get_states_data_attr($element_id) {
			
			$states_query = HeadwayElementAPI::get_states($element_id);
			$states = array();		

			if ( !is_array($states_query) )	
				return null;
			
			foreach ( $states_query as $name => $selector )
				$states[strtolower($name)] = array('name' => $name, 'selector' => $selector);
				
			return $states;
				
		}
	
}
headway_register_visual_editor_panel('EditorPanel');