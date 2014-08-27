<?php

class Content_Types_Admin_Object extends Runway_Admin_Object {
	public $dynamic;

	public $content_types_options, $data_types_path;

	public function __construct($settings){
		parent::__construct($settings);

		$this->option_key = $settings['option_key'];	
		$this->content_types_options = get_option($this->option_key); // get content types options
		$this->data_types_path = FRAMEWORK_DIR.'data-types/';

		// add actions
		//add_action( 'init', array($this, 'register_custom_content_type'));
		add_action( 'add_meta_boxes', array( $this, 'add_some_meta_box' ) );

		/* Do something with the data entered */
		add_action( 'save_post', array($this, 'save_postdata') );

		add_action('wp_ajax_get_meta_field_settings', array($this, 'get_meta_field_settings'));
		add_action('wp_ajax_save_inputs_fields', array($this, 'save_inputs_fields'));		

		add_action('admin_head', array($this, 'set_icon_styles_to_post_type'));

	}

	public function add_some_meta_box(){	
		$current_post_type = get_post_type();
		$current_post = get_post();
		$content_type = $this->get_custom_content_types($current_post_type);

		switch ($current_post_type) {
			case 'post':{
				// add metaboxes to posts
				$content_types['fields'] = $this->get_assigned_fields();
				$this->add_meta_box($content_types, $current_post_type);
			} break;
			
			case 'page':{
				// add metaboxes to pages
				$content_types['fields'] = $this->get_assigned_fields('page');
				$this->add_meta_box($content_types, $current_post_type);
			} break;

			default:{
				if($content_type && !empty($content_type)){
		    		// include all needed js and css files
		    		 wp_enqueue_script( 'jquery' );
		    		 wp_enqueue_script( 'wp-color-picker' );		            		 
		    		 wp_enqueue_script( 'jqueryui', FRAMEWORK_URL.'framework/js/jquery-ui.min.js' );

		    		 wp_enqueue_style( 'wp-color-picker' );
		    		 wp_enqueue_style( 'jquerycss', FRAMEWORK_URL.'framework/css/smoothness/jquery-ui-1.8.23.custom.css' );

		    		 if(isset($content_type['fields']) ){
						$this->add_meta_box($content_type, $current_post_type);
		    		}
				}
			} break;
		}
	}		

	// get assigned fields by post type
	function get_assigned_fields($post_type = 'post'){
		$assigned_fields = array();
		$fields = $this->get_custom_fields();
		if(!empty($fields)){
			foreach ($fields as $field_key => $field_values) {
				if(isset($field_values['post_types']) && in_array($post_type, $field_values['post_types'])){
					array_push($assigned_fields, $field_key);
				}
			}
		}
		return $assigned_fields;
	}

	function add_meta_box($content_type = array(), $current_post_type = 'post'){
		if(!empty($content_type) && !empty($content_type['fields'])){
			foreach ($content_type['fields'] as $key => $value) {				
				$field = $this->get_custom_fields($value);
				if( ! empty($field['inputs']) ) {
					$data_types_path = $this->data_types_path;
					add_meta_box( 
			            $field['alias'], 
			            rf__($field['name']),
			            function($post) use ($field){
			            	global $libraries, $content_types_settings, $content_types_admin, $post;
							$form_builder = $libraries['FormsBuilder'];						
							$form_settings = json_decode(json_encode($field['inputs']), false);			
							
							$content_types_admin->data = $form_builder->get_custom_options_vals($form_settings->settings->alias.'_'.$post->ID);
							$content_types_admin->elements = $form_settings->elements;
							$content_types_admin->builder_page = $form_settings;			

	                        $alias = 'formsbuilder_'.$form_settings->settings->alias.'_'.$post->ID;
							$form_builder->render_form($form_settings, false, $content_types_settings, $content_types_admin, $alias);
			            },
			            $current_post_type,
			            'advanced',
			            'high'
			        );
				}
			}
		}
	}

	public function update_default_content_type($taxonomies = array(), $fields = array(), $type = ''){
		switch ($type) {
			case 'post':{
				$this->content_types_options['default_content_types']['post']['taxonomies'] = $taxonomies;
				$this->content_types_options['default_content_types']['post']['fields'] = $fields;
			} break;
			
			case 'pages':{
				$this->content_types_options['default_content_types']['pages']['taxonomies'] = $taxonomies;
				$this->content_types_options['default_content_types']['pages']['fields'] = $fields;
			} break;
		}
		update_option( $this->option_key, $this->content_types_options );
	}

	public function save_postdata($post_id){
		global $libraries;
		$form_builder = $libraries['FormsBuilder'];
		$content_type = array();
		if(isset($_POST['post_type']))
			switch ($_POST['post_type']) {
				case 'post':{
					$content_type['fields'] = $this->get_assigned_fields();
				} break;
				
				case 'page':{
					$content_type['fields'] = $this->get_assigned_fields('page');
				} break;

				default:{
					$content_type = $this->get_custom_content_types($_POST['post_type']);
				} break;
			}
		else 
			$content_type = array();

		if(isset($content_type) && !empty($content_type['fields'])){
			foreach ($content_type['fields'] as $key => $field_alias) {				
				$options = array();
				$field = $this->get_custom_fields($field_alias);
				
				if( ! empty($field['inputs']) ) {
					foreach ($field['inputs']['elements'] as $field_key => $field_values) {
						if(isset($field_values['alias'])){
							$options['form_key'] = $field_alias.'_'.$post_id;
							$options['types'][$field_values['alias']] = $field_values['type'];
							$options['vals'][$field_values['alias']] = (isset($_POST[$field_values['alias']])) ? $_POST[$field_values['alias']] : '';
							update_post_meta($post_id, $field_values['alias'], $options['vals'][$field_values['alias']]); 
						}
					}
					$form_builder->save_custom_options($options);
				}
			}		
		}
	}

	// Function to ajax request
	public function get_meta_field_settings(){
		$field_id = $_REQUEST['field_id'];
		$input_id = $_REQUEST['input_id'];
		$field = $this->get_custom_fields($field_id);
		echo json_encode($field['inputs'][$input_id]);
		die();
	}

	public function get_custom_content_types($alias = null)	{
		if($alias == null){
			return $this->content_types_options['content_types'];
		}
		else{ 
			return isset($this->content_types_options['content_types'][$alias]) ? $this->content_types_options['content_types'][$alias] : false;
		}
	}

	public function add_custom_content_type($options = array())	{
		if(!empty($options) && isset($options['alias'])){
			$this->content_types_options['content_types'][$options['alias']] = $options;
			update_option( $this->option_key, $this->content_types_options );
		}
	}

	public function delete_custom_content_type($alias = null)	{
		if($alias != null){
			unset($this->content_types_options['content_types'][$alias]);
			update_option($this->option_key, $this->content_types_options);
		}
	}

	public function get_default_content_types() {
		$default_posts_types_keys = get_post_types(array());
		$default_posts_types = array();
		foreach ($default_posts_types_keys as $post_type) {
			if(!in_array($post_type, $this->content_types_options['post_types'])){				
				$default_posts_types[$post_type] = get_post_type_object($post_type);
			}
		}
		return $default_posts_types;
	}

	public function add_custom_taxonomy($options = array()){
		if(!empty($options) && isset($options['alias'])){
			$this->content_types_options['taxonomies'][$options['alias']] = $options;
			update_option( $this->option_key, $this->content_types_options );
		}
	}

	public function delete_custom_taxonomy($alias = null){		
		if($alias != null){
			unset($this->content_types_options['taxonomies'][$alias]);
			update_option($this->option_key, $this->content_types_options);
		}
	}

	public function get_custom_taxonomies($alias = null){
		if($alias == null){
			return $this->content_types_options['taxonomies'];
		}
		else{
			return $this->content_types_options['taxonomies'][$alias];
		}
	}

	public function add_custom_field($options = array()){
		if(!empty($options) && $options['alias'] != ''){
			$inputs = array();
			if(!empty($this->content_types_options['fields'][$options['alias']]['inputs'])){
				$inputs = $this->content_types_options['fields'][$options['alias']]['inputs']; // bacup inputs
			}
			// Assign field on checked posts types
			if(isset($this->content_types_options['content_types']))
				foreach ($this->content_types_options['content_types'] as $key => $value) {				
					if(isset($options['post_types']) && in_array($key, $options['post_types'])){
						if(isset($this->content_types_options['content_types'][$key]['fields']) && !in_array($options['alias'], $this->content_types_options['content_types'][$key]['fields'])){
							$this->content_types_options['content_types'][$key]['fields'][] = $options['alias'];
						}					
					}
				}
			
			$this->content_types_options['fields'][$options['alias']] = $options;
			$this->content_types_options['fields'][$options['alias']]['inputs'] = $inputs;

			update_option( $this->option_key, $this->content_types_options );
		}
	}

	public function delete_custom_field($alias = null){		
		if($alias != null){
			foreach($this->content_types_options['content_types'] as $key => $value) {
				if(isset($value['fields'])) {
					foreach($value['fields'] as $field_key => $field_value) {
				 		if($field_value == $alias)
							unset($this->content_types_options['content_types'][$key]['fields'][$field_key]);
					}
				}
			}

			unset($this->content_types_options['fields'][$alias]);
			update_option($this->option_key, $this->content_types_options);
		}
	}

	public function get_custom_fields($alias = null){
		if($alias == null){
			return isset($this->content_types_options['fields'])? $this->content_types_options['fields'] : '';
		}
		else{
			return $this->content_types_options['fields'][$alias];
		}
	}

	function save_inputs_fields(){
		$json_form = $_REQUEST['json_form'];
		$form = json_decode(stripslashes($json_form), true);
		$this->content_types_options['fields'][$form['settings']['alias']]['inputs'] = $form;
		update_option($this->option_key, $this->content_types_options);

		$link = admin_url('admin.php?page=content-types&navigation=add-inputs&alias='.$form['settings']['alias']);

		$message = '';
		$page_id = $form['settings']['page_id'];
		$return = array(
			'message' => $message,
			'page_id' => $page_id,
			'reload_url' => $link,
		);

		echo json_encode($return);
		die();
	}

	public function set_icon_styles_to_post_type(){
		$post_type = null; $icon = null;
		if(isset($this->content_types_options['content_types']) )
			foreach ($this->content_types_options['content_types'] as $key => $value) {
				if(isset($value['advanced']['menu_icon']) && $value['advanced']['menu_icon'] != 'custom-icon'){
				    ?>
				    <script type="text/javascript">			    			         
						(function($){
							$(function(){
								$('#menu-posts-<?php echo $key; ?>').addClass("<?php echo $value['advanced']['menu_icon']; ?>")
							});
						})(jQuery);
			        </script>
			        <?php
				}
			}
	}

	function save_main_options($options = array()) {
		if(!empty($options)) {
			foreach($options as $key => $value)
				$this->content_types_options[$key] = $value;
			update_option( $this->option_key, $this->content_types_options );
		}
  	}

	// Add hooks & crooks
	function add_actions() {
		$this->dynamic = true;
		// Init action
		add_action( 'init', array( $this, 'init' ) );
	}

	function init() {		
		global $content_types_admin;
		
		if ( isset( $_REQUEST['navigation'] ) && !empty( $_REQUEST['navigation'] ) ) {
			$content_types_admin->navigation = $_REQUEST['navigation'];
		}

		if( isset( $_REQUEST['action'] ) && !empty( $_REQUEST['action'] ) ){
			$content_types_admin->action = $_REQUEST['action'];
		}

	}

	function after_settings_init() {
		
		/* nothing */

  	}

	function validate_sumbission() {

		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $content_types_settings;		
		$this->data = $content_types_settings->load_objects();
		return $this->data;
	}

	function load_admin_js() {
		/* none */		
	} 

}
?>