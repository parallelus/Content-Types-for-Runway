<?php 
	global $content_types_settings, $content_types_admin; 

	// Beadcrumbs
	$navText = array();
	switch ($this->navigation) {
		case 'add-post-type':{
			$navText = array(__( 'Add Post Type', 'framework' ));
		} break;
		case 'edit-post-type':{
			$navText = array(__( 'Edit Post Type', 'framework' ));
		} break;	

		case 'add-taxonomy':{
			$navText = array(__( 'Taxonomies', 'framework' ), __( 'Add taxonomy', 'framework' ));
		} break;

		case 'add-inputs':{
			$navText = array(__( 'Fields', 'framework' ), __( 'Manage inputs', 'framework' ));
		}

		case 'delete-input':{
			$navText = array(__( 'Fields', 'framework' ), __( 'Manage inputs', 'framework' ));
		}

		case 'edit-input':{
			$navText = array(__( 'Fields', 'framework' ), __( 'Manage inputs', 'framework' ));
		}
		
	}  
	$this->navigation_bar( $navText );

?>
<?php if(!in_array($this->navigation, array('add-post-type', 'add-taxonomy', 'add-field', 'add-inputs', 'add-input-field', 'delete-input'))): ?>
	<h2 class="nav-tab-wrapper tab-controlls" style="padding-top: 9px;">
		<a href="<?php echo $this->self_url(); ?>" class="nav-tab <?php if($this->navigation == '' || $this->navigation == 'edit-post-type') {echo "nav-tab-active";} ?>"><?php _e('Content Types', 'framework') ?></a>
		<a href="<?php echo $this->self_url('taxonomies'); ?>" class="nav-tab <?php if($this->navigation == 'taxonomies' || $this->navigation == 'edit-taxonomy') {echo "nav-tab-active";} ?>"><?php _e('Taxonomies', 'framework') ?></a>
		<a href="<?php echo $this->self_url('fields'); ?>" class="nav-tab <?php if($this->navigation == 'fields' || $this->navigation == 'edit-field') {echo "nav-tab-active";} ?>"><?php _e('Fields', 'framework') ?></a>
	</h2>
<?php endif; ?>

<?php
	// navigation handling
	switch ($this->action) {	
		case 'update-post-type':{
			if( isset($_POST['labels']['name'], $_POST['labels']['singular_name'], $_POST['labels']['menu_name'], $_POST['labels']['parent_item_colon'])){
				$options = $_POST;
				foreach($options['labels'] as $key => $value)
					$options['labels'][$key] = stripslashes($value);
				$options['alias'] = isset($_GET['alias']) ? $_GET['alias'] :  sanitize_title($_POST['labels']['name']);
				$content_types_admin->add_custom_content_type($options);

				$link = admin_url('admin.php?page=content-types&action=update-post-type');
			    $redirect = '<script type="text/javascript">window.location = "'.$link.'";</script>';
			    echo $redirect;
			}
			else 
				flush_rewrite_rules();
		} break;

		case 'update-taxonomy':{
			if( isset($_POST['labels']['name'], $_POST['labels']['singular_name'], $_POST['labels']['menu_name'], $_POST['labels']['parent_item_colon'])){
				$options = $_POST;
				foreach($options['labels'] as $key => $value)
					$options['labels'][$key] = stripslashes($value);
				$options['alias'] = isset($_GET['alias']) ? $_GET['alias'] : sanitize_title($_POST['labels']['name']);
				$content_types_admin->add_custom_taxonomy($options);
			}
		} break;

		case 'update-field':{
			if(isset($_POST['name'])){
				$options = $_POST;
				$options['name'] = stripslashes($options['name']);
				$options['alias'] = isset($_GET['alias']) ? $_GET['alias'] :  sanitize_title($_POST['name']);
				$content_types_admin->add_custom_field($options);
			}
		} break;

		case 'update-default-post-type':{
			$taxonomies = (!empty($_REQUEST['taxonomies'])) ? $_REQUEST['taxonomies'] : array();
			$fields = (!empty($_REQUEST['fields'])) ? $_REQUEST['fields'] : array();
			$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'post';				
			$content_types_admin->update_default_content_type($taxonomies, $fields, $type);
		} break;

		case 'update-post-type-main':{
				$options = $_POST;
				$content_types_admin->save_main_options($options);
				$link = admin_url('admin.php?page=content-types');
			    $redirect = '<script type="text/javascript">window.location = "'.$link.'";</script>';
			    echo $redirect;
		} break;

		default: { } break;
	}
	// navigation handling
	switch ($this->navigation) {		
		case 'taxonomies':{
			$this->view('taxonomies');
		} break;

		case 'add-taxonomy':{
			$this->view('add-taxonomy');
		} break;

		case 'edit-taxonomy':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				$val['taxonomy'] = $content_types_admin->get_custom_taxonomies($_GET['alias']);
				$this->view('add-taxonomy', false, $val);
			}
		} break;

		case 'confirm-delete-taxonomy':{
			$item_confirm = 'taxonomy';
			$item_title = $content_types_admin->content_types_options['taxonomies'][$_GET['alias']]['labels']['name'];
			$action_url_yes = admin_url('admin.php?page=content-types&navigation=delete-taxonomy&alias='.$_GET['alias']);
			$action_url_no = admin_url('admin.php?page=content-types&navigation=taxonomies');

			require_once(get_template_directory().'/framework/templates/delete-confirmation.php');
		} break;

		case 'delete-taxonomy':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				$content_types_admin->delete_custom_taxonomy($_GET['alias']);
				$val = (isset($val))? $val : array();

				$link = admin_url('admin.php?page=content-types&navigation=taxonomies');
			    $redirect = '<script type="text/javascript">window.location = "'.$link.'";</script>';
			    echo $redirect;				
			}
		} break;

		case 'fields':{
			$this->view('fields');
		} break;

		case 'add-field':{
			$this->view('add-field');
		} break;

		case 'edit-field':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				$val['field'] = $content_types_admin->get_custom_fields($_GET['alias']);
				$this->view('add-field', false, $val);
			}
		} break;

		case 'confirm-delete-field':{
			$item_confirm = 'field';
			$item_title = $content_types_admin->content_types_options['fields'][$_GET['alias']]['name'];
			$action_url_yes = admin_url('admin.php?page=content-types&navigation=delete-field&alias='.$_GET['alias']);
			$action_url_no = admin_url('admin.php?page=content-types&navigation=fields');

			require_once(get_template_directory().'/framework/templates/delete-confirmation.php');
		} break;

		case 'delete-field':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				$content_types_admin->delete_custom_field($_GET['alias']);
				$val = (isset($val) )? $val : array();

				$link = admin_url('admin.php?page=content-types&navigation=fields');
			    $redirect = '<script type="text/javascript">window.location = "'.$link.'";</script>';
			    echo $redirect;
			}
		} break;

		case 'add-inputs':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				
				global $libraries;
				$form_builder = $libraries['FormsBuilder'];
				
				// Set resolutions to used elements
				$form_builder->resolutions = array(
					'title' => false,
					'alias' => false,
					'settings' => false,
					'options-tabs' => false,
					'options-containers' => false,
					'options-fields' => true,

				);

				$form_builder->save_action = 'save_inputs_fields';

				$form = array();
				$form = $content_types_admin->get_custom_fields($_GET['alias']);
				$form_builder->default_form_settings['page']['settings']['alias'] = $_GET['alias'];

				if(!empty($form['inputs'])){
					$options = array(
						'new_page_id' => time(),
						'page' => $form['inputs'],
						'settings' => array(
							'tabs' => true,
							'containers' => true,
							'fields' => true,
							'page_settings' => true
						),
						'page_json' => addslashes( json_encode($form['inputs']))
					);
					$form_builder->form_builder($options);
				}
				else{
					$form_builder->form_builder();
				}
			}
		} break;

		case 'add-post-type':{
			$this->view('add-post-type');
		} break;

		case 'edit-post-type':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				$val['post_type'] = $content_types_admin->get_custom_content_types($_GET['alias']);
				$this->view('add-post-type', false, $val);
			}
		} break;

		case 'confirm-delete-post-type':{
			$item_confirm = 'content type';
			$item_title = $content_types_admin->content_types_options['content_types'][$_GET['alias']]['labels']['name'];
			$action_url_yes = admin_url('admin.php?page=content-types&navigation=delete-post-type&alias='.$_GET['alias']);
			$action_url_no = admin_url('admin.php?page=content-types');

			require_once(get_template_directory().'/framework/templates/delete-confirmation.php');
		} break;

		case 'delete-post-type':{
			if(isset($_GET['alias']) && $_GET['alias'] != ''){
				$content_types_admin->delete_custom_content_type($_GET['alias']);

				$link = admin_url('admin.php?page=content-types');
			    $redirect = '<script type="text/javascript">window.location = "'.$link.'";</script>';
			    echo $redirect;
			}
		} break;

		case 'edit-default-post-type':{
			if(isset($_GET['type'])){
				$val['post_type'] = $content_types_admin->content_types_options['default_content_types'][$_GET['type']];
				$this->view('edit-default-post-type', false, $val);
			}
		} break;

		default: {
			$this->view('main');
		} break;
	} 
?>