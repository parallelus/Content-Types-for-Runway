<?php
class Content_Types_Settings_Object extends Runway_Object {
	public $content_types_options, $data_types_path;

	public function __construct($settings){
		parent::__construct($settings);
		
		$this->option_key = $settings['option_key'];	
		$this->content_types_options = get_option($this->option_key); // get content types options
		$this->data_types_path = FRAMEWORK_DIR.'data-types/';

		// add actions
		add_action( 'init', array($this, 'register_custom_content_type'));

	}

	public function register_custom_content_type()	{
		if(isset($this->content_types_options['content_types']))
		foreach ((array)$this->content_types_options['content_types'] as $content_type => $values) {
			$menu_icon = null;

			if(isset($values['advanced']['menu_icon']) && $values['advanced']['menu_icon'] != '' && $values['advanced']['menu_icon'] == 'custom-icon'){
				$menu_icon = $values['advanced']['custom_icon_file'];
			}

			$args = array(
				'label'               => isset($values['alias'])? rf__($values['alias']) : '',
				'description'         => isset($values['advanced']['description'])? rf__($values['advanced']['description']) : '',
				'supports'            => (isset($values['advanced']['supports']) )? (array)$values['advanced']['supports'] : array(),
				'hierarchical'        => (isset($values['advanced']['hierarchical'])) ? (bool)$values['advanced']['hierarchical'] : false,
				'public'              => (isset($values['advanced']['public'])) ? (bool)$values['advanced']['public'] : false,
				'show_ui'             => (isset($values['advanced']['show_ui'])) ? (bool)$values['advanced']['show_ui'] : false,
				'show_in_menu'        => (isset($values['advanced']['show_in_menu'])) ? (bool)$values['advanced']['show_in_menu'] : false,
				'show_in_nav_menus'   => (isset($values['advanced']['show_in_nav_menus'])) ? (bool)$values['advanced']['show_in_nav_menus'] : false,
				'show_in_admin_bar'   => (isset($values['advanced']['show_in_admin_bar'])) ? (bool)$values['advanced']['show_in_admin_bar'] : false,
				'menu_position'       => 5,
				'menu_icon'           => $menu_icon,
				'can_export'          => (isset($values['advanced']['can_export'])) ? (bool)$values['advanced']['can_export'] : false,
				'has_archive'         => (isset($values['advanced']['has_archive'])) ? (bool)$values['advanced']['has_archive'] : false,
				'exclude_from_search' => (isset($values['advanced']['exclude_from_search'])) ? (bool)$values['advanced']['exclude_from_search'] : false,
				'publicly_queryable'  => (isset($values['advanced']['publicly_queryable'])) ? (bool)$values['advanced']['publicly_queryable'] : false,
				'rewrite'  			  => (isset($values['advanced']['rewrite']['level_1']) && $values['advanced']['rewrite']['level_1'] == 'custom')?
												                (isset($values['advanced']['rewrite']['with_front'])? array ( 'slug' => $values['alias'] . '/' . $values['advanced']['rewrite']['url_slug'],
												                                 											  'with_front' => true) : 
												                													  array ( 'slug' => '', 'with_front' => true) ) :
															    array ( 'slug' => '', 'with_front' => true)
				// 'capability_type'     => $values['advanced']['capability'],
			);
			$values = array_merge($values, $args);			
			unset($values['advanced']);

			$values = stripslashes_deep($values);

			register_post_type( $values['alias'], $values );
		}
	}	
} 
?>