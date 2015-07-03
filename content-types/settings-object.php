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
		add_action( 'load_conditional_script', array( $this, 'load_conditional_script_func' ), 10, 1 );

		/* Do something with the data entered */
		add_action( 'save_post', array($this, 'save_postdata') );

		add_action('wp_ajax_get_meta_field_settings', array($this, 'get_meta_field_settings'));
		add_action('wp_ajax_save_inputs_fields', array($this, 'save_inputs_fields'));

		add_action('wp_ajax_save_custom_icon', array($this, 'save_custom_icon'));

		add_action('wp_ajax_get_custom_icon', array($this, 'get_custom_icon'));

		add_action('admin_head', array($this, 'set_icon_styles_to_post_type'));

		//add_action('init', array($this, 'init'));

	}

	public function add_some_meta_box(){
		$current_post_type = get_post_type();
		$current_post = get_post();
		$content_type = $this->get_custom_content_types($current_post_type);

		wp_enqueue_style('content_types_css', FRAMEWORK_URL.'extensions/content-types/css/content-types.css');
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_style('rw_nouislider_css', FRAMEWORK_URL.'data-types/range-slider/css/jquery.nouislider.css');
		wp_enqueue_style('styles_css', FRAMEWORK_URL.'framework/css/styles.css');

		//need to test this
		wp_enqueue_script('ace', FRAMEWORK_URL.'data-types/code-editor/js/ace/src-noconflict/ace.js');
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('rw_nouislider', FRAMEWORK_URL.'data-types/range-slider/js/jquery.nouislider.min.js');

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
		do_action('load_conditional_script', $content_type);
		if(!empty($content_type) && !empty($content_type['fields'])){
			foreach ($content_type['fields'] as $key => $value) {
				$field = $this->get_custom_fields($value);
				if( ! empty($field['inputs']) ) {
					$data_types_path = $this->data_types_path;

					add_filter('formsbuilder_name_attr_title', array($this, 'get_formsbuilder_name_attr_title'), 5, 4);
					add_filter('formsbuilder_dev_description', array($this, 'get_formsbuilder_dev_description'), 5, 4);
					//remove default formsbuilder filter
					remove_filter('formsbuilder_name_attr_title', array('FormsBuilder', 'get_formsbuilder_name_attr_title'), 20);
					remove_filter('formsbuilder_dev_description', array('FormsBuilder', 'get_formsbuilder_dev_description'), 20);

					add_meta_box(
						$field['alias'], rf__($field['name']), function($post) use ($field) {
							global $libraries, $content_types_settings, $content_types_admin, $post, $contentTypeMetaBox;
							$contentTypeMetaBox = true;
							$form_builder = $libraries['FormsBuilder'];
							$form_settings = json_decode(json_encode($field['inputs']), false);

							$content_types_admin->data = $form_builder->get_custom_options_vals($form_settings->settings->alias . '_' . $post->ID);
							$content_types_admin->elements = $form_settings->elements;
							$content_types_admin->builder_page = $form_settings;

							$alias = 'formsbuilder_' . $form_settings->settings->alias . '_' . $post->ID;
							$form_builder->render_form($form_settings, false, $content_types_settings, $content_types_admin, $alias);
						},
						$current_post_type, 'advanced', 'high'
					);
				}
			}
		}
	}

	public static function get_formsbuilder_name_attr_title($content, $field_alias, $title, $alias) {
		$title = '<span title="get_options_meta(\''.$field_alias.'\')">'. $title .'</span>';

		return $title;
	}

	public static function get_formsbuilder_dev_description($content, $fieldCaption, $field_alias, $alias) {
		$fieldCaption .= '<span class="developerMode"><code class="data-function">get_options_meta(\''.$field_alias.'\')</code></span>';

		return $fieldCaption;
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

	function save_custom_icon() {
		ini_set('LimitRequestLine', '65535');
		if(!function_exists('WP_Filesystem'))
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;


		if(!is_dir(__DIR__.'/tmp_custom_image')) {
			$wp_filesystem->mkdir(__DIR__.'/tmp_custom_image');
		}

        $localFile = __DIR__.'/tmp_custom_image/' . $_FILES["custom_icon"]["name"];

        move_uploaded_file($_FILES["custom_icon"]["tmp_name"], $localFile);

        $image = wp_get_image_editor($localFile);

        if($image->supports_mime_type($_FILES["custom_icon"]['type']) && !is_wp_error($image)){

            $image->resize(16, 16);
            $image->save($localFile);

        }

        $file_data = $wp_filesystem->get_contents($localFile);
		echo "data:".$_FILES["custom_icon"]['type'].";base64,".base64_encode($file_data);
		die();
	}

	function get_custom_icon() {
		$data = get_option($this->option_key);

		if(!isset($_REQUEST['content_type']) || (isset($_REQUEST['content_type']) && !isset($data['content_types'][$_REQUEST['content_type']])))
			die();

		$imgstr = $data['content_types'][$_REQUEST['content_type']]['advanced']['custom_icon_file'];
		if($imgstr == '')
			die();
		if (!preg_match('/data:([^;]*);base64,(.*)/', $imgstr, $matches)) {
		    die();
		}

		$content = base64_decode($matches[2]);

		header('Content-Type: '.$matches[1]);
		header('Content-Length: '.strlen($content));

		echo $content;
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

		if(!function_exists('WP_Filesystem'))
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
		global $wp_filesystem;


		if(is_dir(__DIR__.'/tmp_custom_image')) {
			$wp_filesystem->rmdir(__DIR__.'/tmp_custom_image', true);
		}

		if ( isset( $_REQUEST['navigation'] ) && !empty( $_REQUEST['navigation'] ) ) {
			$content_types_admin->navigation = $_REQUEST['navigation'];
		}

		if( isset( $_REQUEST['action'] ) && !empty( $_REQUEST['action'] ) ){
			$content_types_admin->action = $_REQUEST['action'];
		}

		//php redirection instead javascript in admin.php
		if ( $content_types_admin->action == 'update-post-type' || $content_types_admin->action == 'update-post-type-main') {
			switch ($content_types_admin->action) {
				case 'update-post-type':{
					if ( isset($_POST['labels']['name'], $_POST['labels']['singular_name'], $_POST['labels']['menu_name'], $_POST['labels']['parent_item_colon'])) {
						$options = $_POST;
						foreach($options['labels'] as $key => $value) {
							$options['labels'][$key] = stripslashes($value);
						}
						$options['alias'] = isset($_GET['alias']) ? $_GET['alias'] :  sanitize_title($_POST['labels']['name']);
						$content_types_admin->add_custom_content_type($options);
						//admin.php?page=content-types

						header('Location: '.admin_url('admin.php?page=content-types'));
						die();

					} else {
						flush_rewrite_rules();
					}
				} break;

				case 'update-post-type-main':{
					$options = $_POST;
					$content_types_admin->save_main_options($options);
					header('Location: '.admin_url('admin.php?page=content-types'));
					die();
				} break;
			}
		}
	}

	function load_conditional_script_func($content_type = array()){
		if( isset($content_type['fields']) && count($content_type['fields']) ) {
			wp_enqueue_script('condition-script', FRAMEWORK_URL.'framework/includes/options-page-render/js/condition-script.js');
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