<?php
class DesignSkinsPanel extends HeadwayVisualEditorPanelAPI {
	
	public $id = 'skins';
	public $name = 'Skins';
	public $mode = 'design';
	
	public $tabs = array(
		'import' => 'Import',
		'export' => 'Export'
	);
	
	public $tab_notices = array(
		'import' => 'Skins are simple files that you may upload to get a rapid start designing your site.  Once you import a skin, you may customize it to your likings.',
		'export' => 'Simply click the Export button below to export your Design Editor settings as a skin.  Feel free to share this skin with other Headway users!<br /><br /><strong>Notice:</strong> Instances and layout-specific customizations are <strong>NOT</strong> included in a skin export.'
	);
	
	public $inputs = array(
		'import' => array(			
			'skin-import-live-css' => array(
				'type' => 'checkbox',
				'name' => 'skin-import-live-css',
				'label' => 'Overwrite Live CSS with Skin\'s Live CSS',
				'value' => true,
				'no-save' => true
			),

			'skin-import-layout-templates' => array(
				'type' => 'checkbox',
				'name' => 'skin-import-layout-templates',
				'label' => 'Include Skin Layout Templates',
				'value' => true,
				'no-save' => true
			),

			'skin-import-file' => array(
				'type' => 'import-file',
				'name' => 'skin-import-file',
				'label' => 'Import',
				'button-label' => 'Select File &amp Apply Skin',
				'no-save' => true,
				'callback' => 'initiateSkinImport(input);'
			)
		),

		'export' => array(	
			'skin-export-name' => array(
				'type' => 'text',
				'name' => 'skin-export-name',
				'label' => 'Skin Name',
				'placeholder' => 'Unnamed',
				'no-save' => true
			),

			'skin-export-live-css' => array(
				'type' => 'checkbox',
				'name' => 'skin-export-live-css',
				'label' => 'Include Live CSS',
				'value' => true,
				'no-save' => true
			),

			'skin-export-templates' => array(
				'type' => 'multi-select',
				'name' => 'skin-export-templates',
				'label' => 'Included Layout Templates',
				'no-save' => true,
				'options' => 'get_templates()'
			),

			'skin-export' => array(
				'type' => 'button',
				'name' => 'skin-export',
				'label' => 'Export',
				'button-label' => 'Download Skin File',
				'no-save' => true,
				'callback' => 'exportSkinButtonCallback(input);'
			)
		)
	);


	function get_templates() {

		return HeadwayLayout::get_templates();

	}

	
}
headway_register_visual_editor_panel('DesignSkinsPanel');