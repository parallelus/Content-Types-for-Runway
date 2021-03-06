<?php

	// Beadcrumbs
	$navText = array();

	switch ($this->navigation) {
		case 'add-post-type': {
			$navText = array( __( 'Add Post Type', 'runway' ) );
			wp_enqueue_script( 'auto-fill', FRAMEWORK_URL.'extensions/content-types/js/auto_fill.js' );
		} break;
		case 'edit-post-type': {
			$navText = array( __( 'Edit Post Type', 'runway' ) );
		} break;
		case 'confirm-delete-post-type': {
			$navText = array( __( 'Delete Post Type', 'runway' ) );
		} break;

		case 'add-taxonomy': {
			$navText = array( __( 'Add taxonomy', 'runway' ) );
		} break;
		case 'edit-taxonomy': {
			$navText = array( __( 'Edit Taxonomy', 'runway' ) );
		} break;
		case 'confirm-delete-taxonomy': {
			$navText = array( __( 'Delete Taxonomy', 'runway' ) );
		} break;

		case 'add-field': {
			$navText = array( '<a href="'.admin_url( 'admin.php?page=content-types&navigation=fields' ).'">'.__( 'Fields', 'runway' ).'</a>', __( 'Add Field', 'runway' ) );
		} break;
		case 'edit-field': {
			$navText = array( '<a href="'.admin_url( 'admin.php?page=content-types&navigation=fields' ).'">'.__( 'Fields', 'runway' ).'</a>', __( 'Edit Field', 'runway' ) );
		} break;
		case 'confirm-delete-field': {
			$navText = array( '<a href="'.admin_url( 'admin.php?page=content-types&navigation=fields' ).'">'.__( 'Fields', 'runway' ).'</a>', __( 'Delete Field', 'runway' ) );
		} break;

		case 'add-inputs': {
			$navText = array( '<a href="'.admin_url( 'admin.php?page=content-types&navigation=fields' ).'">'.__( 'Fields', 'runway' ).'</a>', __( 'Manage inputs', 'runway' ) );
		} break;

		case 'delete-input': {
			$navText = array( '<a href="'.admin_url( 'admin.php?page=content-types&navigation=fields' ).'">'.__( 'Fields', 'runway' ).'</a>', __( 'Manage inputs', 'runway' ) );
		} break;

		case 'edit-input': {
			$navText = array( '<a href="'.admin_url( 'admin.php?page=content-types&navigation=fields' ).'">'.__( 'Fields', 'runway' ).'</a>', __( 'Manage inputs', 'runway' ) );
		} break;

	}

	if( $this->navigation != '' && $this->navigation != 'taxonomies' && $this->navigation != 'fields' )
		$this->navigation_bar( $navText );

?>
<?php if( ! in_array( $this->navigation, array( 'add-post-type', 'edit-post-type', 'confirm-delete-post-type', 'add-taxonomy', 'edit-taxonomy', 'confirm-delete-taxonomy', 'add-field', 'edit-field', 'confirm-delete-field', 'add-inputs', 'add-input-field', 'delete-input' ) ) ): ?>
	<h2 class="nav-tab-wrapper tab-controlls" style="padding-top: 9px;">
		<a href="<?php echo $this->self_url(); ?>" class="nav-tab <?php if( $this->navigation == '' || $this->navigation == 'edit-post-type' ) {echo "nav-tab-active";} ?>"><?php _e( 'Content Types', 'runway' ) ?></a>
		<a href="<?php echo $this->self_url( 'taxonomies' ); ?>" class="nav-tab <?php if( $this->navigation == 'taxonomies' || $this->navigation == 'edit-taxonomy' ) {echo "nav-tab-active";} ?>"><?php _e( 'Taxonomies', 'runway' ) ?></a>
		<a href="<?php echo $this->self_url( 'fields' ); ?>" class="nav-tab <?php if( $this->navigation == 'fields' || $this->navigation == 'edit-field' ) {echo "nav-tab-active";} ?>"><?php _e( 'Fields', 'runway' ) ?></a>
	</h2>
<?php endif; ?>

<?php
	// navigation handling
	switch ( $this->action ) {

		case 'update-taxonomy': {
			check_admin_referer( 'update-taxonomy', 'update-taxonomy-nonce' );

			if( isset($_POST['labels']['name'], $_POST['labels']['singular_name'], $_POST['labels']['menu_name'], $_POST['labels']['parent_item_colon'])){
				$options = $_POST;
				foreach($options['labels'] as $key => $value)
					$options['labels'][$key] = stripslashes($value);
				$options['alias'] = isset($_GET['alias']) ? $_GET['alias'] : sanitize_title($_POST['labels']['name']);
				$content_types_admin->add_custom_taxonomy($options);
			}
		} break;

		case 'update-field':{
			check_admin_referer( 'update-field', 'update-field-nonce' );

			if ( isset( $_POST['name'] ) ) {
				$options          = $_POST;
				$options['name']  = stripslashes( $options['name'] );
				$options['alias'] = isset( $_GET['alias'] ) ? $_GET['alias'] : sanitize_title( $_POST['name'] );
				$content_types_admin->add_custom_field( $options );
			}
		} break;

		case 'update-default-post-type':{
			$taxonomies = (!empty($_REQUEST['taxonomies'])) ? $_REQUEST['taxonomies'] : array();
			$fields = (!empty($_REQUEST['fields'])) ? $_REQUEST['fields'] : array();
			$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'post';
			$content_types_admin->update_default_content_type($taxonomies, $fields, $type);
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
			$action_url_yes = wp_nonce_url(admin_url('admin.php?page=content-types&navigation=delete-taxonomy&alias='.$_GET['alias']), 'delete-taxonomy');
			$action_url_no = admin_url('admin.php?page=content-types&navigation=taxonomies');

			require_once(get_template_directory().'/framework/templates/delete-confirmation.php');
		} break;

		case 'delete-taxonomy':{
			check_admin_referer('delete-taxonomy');

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
			$action_url_yes = wp_nonce_url(admin_url('admin.php?page=content-types&navigation=delete-field&alias='.$_GET['alias']), 'delete-field');
			$action_url_no = admin_url('admin.php?page=content-types&navigation=fields');

			require_once(get_template_directory().'/framework/templates/delete-confirmation.php');
		} break;

		case 'delete-field':{
			check_admin_referer('delete-field');
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
			$action_url_yes = wp_nonce_url(admin_url('admin.php?page=content-types&navigation=delete-post-type&alias='.$_GET['alias']), 'delete-post-type');
			$action_url_no = admin_url('admin.php?page=content-types');

			require_once(get_template_directory().'/framework/templates/delete-confirmation.php');
		} break;

		case 'delete-post-type':{
			check_admin_referer('delete-post-type');

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
