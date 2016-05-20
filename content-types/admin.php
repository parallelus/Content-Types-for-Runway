<?php
	global $content_types_settings, $content_types_admin;

	// navigation handling
	if ( $this->action == 'update-post-type' || $this->action == 'update-post-type-main') {
		switch ($this->action) {
			case 'update-post-type':{
				if ( isset($_POST['labels']['name'], $_POST['labels']['singular_name'], $_POST['labels']['menu_name'], $_POST['labels']['parent_item_colon'])) {
					_e('Saving...', 'runway');
					$options = $_POST;
					foreach($options['labels'] as $key => $value) {
						$options['labels'][$key] = stripslashes($value);
					}
					$options['alias'] = isset($_GET['alias']) ? $_GET['alias'] :  sanitize_title($_POST['labels']['name']);
					$content_types_admin->add_custom_content_type($options);

					$link = admin_url('admin.php?page=content-types');
				    $redirect = '<script type="text/javascript">window.location = "'.$link.'";</script>';
				    echo $redirect;
				} else {
					flush_rewrite_rules();
				}
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
	} else {

		require_once('views/template.php');

	}
