<?php
	global $content_types_settings, $wp_roles;

	if (!did_action('wp_enqueue_media'))
		wp_enqueue_media();

	global $wp_version;
	$exploded_version = explode('.', $wp_version);

	if($exploded_version[0] <= 3 && (isset($exploded_version[1]) && $exploded_version[1] < 8)) {
		wp_enqueue_style('dashicons_css', FRAMEWORK_URL.'framework/includes/themes-manager/css/dashicons.css');
	}
	wp_enqueue_style('dashicons_custom_style_css', FRAMEWORK_URL.'framework/includes/themes-manager/css/custom-style.css');
?>

<form action="<?php echo $this->self_url(); ?>&action=update-post-type<?php echo isset($post_type) ? '&alias='.$post_type['alias'] : ''; ?>" id="add-edit-contenttype" method="post">
<h3><?php echo __('Labels', 'runway'); ?></h3>
<!-- LABELS SETTINGS BOX -->
<table class="form-table">
	<tbody>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Name (Plural)', 'runway'); ?>
				<p class="description required"><?php echo __('Required', 'runway'); ?></p>
			</th>
			<td>
				<input class="input-text" id="contenttype_name" type="text" name="labels[name]" value="<?php echo (isset($post_type)) ? $post_type['labels']['name'] : ''; ?>">
				<p class="description"><?php echo __('Post type plural name. e.g. Products, Events or Movies', 'runway'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Name (Singular)', 'runway'); ?>
				<p class="description required"><?php echo __('Required', 'runway'); ?></p>
			</th>
			<td>
				<input class="input-text" id="contenttype_singular_name" type="text" name="labels[singular_name]" value="<?php echo (isset($post_type)) ? $post_type['labels']['singular_name'] : ''; ?>">
				<p class="description"><?php echo __('Name for a single item. e.g. Product, Event or Movie', 'runway'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Menu Name', 'runway'); ?>
				<p class="description required"><?php echo __('Required', 'runway'); ?></p>
			</th>
			<td>
				<input class="input-text" id="contenttype_menu_name" type="text" name="labels[menu_name]" value="<?php echo (isset($post_type)) ? $post_type['labels']['menu_name'] : ''; ?>">
				<p class="description"><?php echo __('The name shown in the admin menu', 'runway'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Hierarchical', 'runway'); ?>
			</th>
			<td>
				<input class="checkbox" type="checkbox" name="advanced[hierarchical]" value="true" <?php echo isset($post_type['advanced']['hierarchical']) ? 'checked' : ''; ?>> <?php echo __('Yes', 'runway'); ?>
				<p class="description"><?php echo __('Enable this to allow parent/child relationships. Pages are hierarchical but Posts are not', 'runway'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Parent Item', 'runway'); ?>
				<p class="description required"><?php echo __('Required', 'runway'); ?></p>
			</th>
			<td>
				<input class="input-text" id="contenttype_parent_item_colon" type="text" name="labels[parent_item_colon]" value="<?php echo (isset($post_type)) ? $post_type['labels']['parent_item_colon'] : ''; ?>">
				<p class="description"><?php echo __('Label for the parent select. In pages this shows as "Parent Page"', 'runway'); ?></p>
			</td>
		</tr>
	</tbody>
</table>
<!-- DEFAULT LABELS SETTINGS BOX -->
<div class="meta-box-sortables metabox-holder">
	<div class="postbox">
		<div class="handlediv" title="<?php echo __('Click to toggle', 'runway'); ?>"><br></div>
		<h3 class="hndle"><span> <?php echo __('Default labels', 'runway'); ?></span></h3>
		<div class="inside" style="display:none;">
			<table class="form-table">
				<tbody>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('All Items', 'runway'); ?>
						</th>
						<td>
							<input class="input-text default-label" type="text" name="labels[all_items]" value="<?php echo (isset($post_type)) ? $post_type['labels']['all_items'] : __('All Posts', 'runway'); ?>">
							<p class="description"><?php echo __('Admin menu linking to list screen. e.g. All Products, All Events or All Movies', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('View Item', 'runway'); ?>
						</th>
						<td>
							<input class="input-text default-label" type="text" name="labels[view_item]" value="<?php echo (isset($post_type)) ? $post_type['labels']['view_item'] : __('View post', 'runway'); ?>">
							<p class="description"><?php echo __('A link to see the item from the edit screen. e.g. View Product, View Event or View Movie', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Add New Item', 'runway'); ?>
						</th>
						<td>
							<input class="input-text " type="text" name="labels[add_new_item]" value="<?php echo (isset($post_type)) ? $post_type['labels']['add_new_item'] : __('Add new post', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Add New Product, Add New Event or Add New Movie', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Add New', 'runway'); ?>
						</th>
						<td>
							<input class="input-text default-label" type="text" name="labels[add_new]" value="<?php echo (isset($post_type)) ? $post_type['labels']['add_new'] : __('Add new post', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Add New, New Product, New Event or New Movie', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Edit Item', 'runway'); ?>
						</th>
						<td>
							<input class="input-text default-label" type="text" name="labels[edit_item]" value="<?php echo (isset($post_type)) ? $post_type['labels']['edit_item'] : __('Edit post', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Edit Product, Edit Event or Edit Movie', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Update Item', 'runway'); ?>
						</th>
						<td>
							<input class="input-text default-label" type="text" name="labels[update_item]" value="<?php echo (isset($post_type)) ? $post_type['labels']['update_item'] : __('Update post', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Update Product, Update Event or Update Movie', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Search Items', 'runway'); ?>
						</th>
						<td>
							<input class="input-text default-label" type="text" name="labels[search_items]" value="<?php echo (isset($post_type)) ? $post_type['labels']['search_items'] : __('Search', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Search, Search products or Search event', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Not Found', 'runway'); ?>
						</th>
						<td>
							<input class="input-text " type="text" name="labels[not_found]" value="<?php echo (isset($post_type)) ? $post_type['labels']['not_found'] : __('Not found', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Nothing found, No products found or No events found', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Not Found in Trash', 'runway'); ?>
						</th>
						<td>
							<input class="input-text " type="text" name="labels[not_found_in_trash]" value="<?php echo (isset($post_type)) ? $post_type['labels']['not_found_in_trash'] : __('Not found in trash', 'runway'); ?>">
							<p class="description"><?php echo __('e.g. Nothing found in Trash, No products found in Trash or No events found in Trash', 'runway'); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- ADVANCED SETTINGS BOX -->
<div class="meta-box-sortables metabox-holder">
	<div class="postbox">
		<div class="handlediv" title="<?php echo __('Click to toggle', 'runway'); ?>"><br></div>
		<h3 class="hndle"><span><?php echo __('Advanced', 'runway'); ?></span></h3>
		<div class="inside" style="display:none;">
			<table class="form-table">
				<tbody>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Description', 'runway'); ?>
						</th>
						<td>
							<textarea class="input-text default-label" type="text" name="advanced[description]" ><?php echo isset($post_type['advanced']['description']) ? trim($post_type['advanced']['description']) : ''; ?></textarea>
							<p class="description"><?php echo __('A short descriptive summary of the post type', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Public', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[public]" value="true" <?php echo isset($post_type['advanced']['public']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?> ><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Will this be visible to the public? Typically this should be set to yes', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Exclude from search', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[exclude_from_search]" value="true" <?php echo isset($post_type['advanced']['exclude_from_search']) ? 'checked' : ''; ?>><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Allow search results to include this content', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Manage from Admin', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[show_ui]" value="true" <?php echo isset($post_type['advanced']['show_ui']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Will the content be created and edited using the WP admin interface like pages and posts? Typically this will be enabled', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Add to Navigation Menus', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[show_in_nav_menus]" value="true" <?php echo isset($post_type['advanced']['show_in_nav_menus']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('This adds a new option to the "Appearance > Menus" for selecting these items. Similar to the Pages and Categories selection already in the menus builder', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Show in Admin Menu', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[show_in_menu]" value="true" <?php echo isset($post_type['advanced']['show_in_menu']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Include this in the admin menu like Pages and Posts? Typically this will be enabled', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Show in WP Admin Bar', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[show_in_admin_bar]" value="true" <?php echo isset($post_type['advanced']['show_in_admin_bar']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Adds new options to your admin bar at the top of the browser for managing this post type', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Admin Menu Icon', 'runway'); ?>
						</th>
						<td>
							<select name="advanced[menu_icon]" id="menu_icon">
                                <option value="menu-icon-post"
                                    <?php
                                    if(isset($post_type)){
                                        echo (isset( $post_type['advanced']['menu_icon']) && $post_type['advanced']['menu_icon'] == 'menu-icon-wp') ? 'selected="true"' : '';
                                    }else{
                                        echo '"selected"';
                                    }
                                    ?>>
                                    <?php echo __('Default WordPress icon', 'runway'); ?>
                                </option>
								<option value="custom-icon" <?php if(isset($post_type)) echo (isset( $post_type['advanced']['menu_icon']) && $post_type['advanced']['menu_icon'] == 'custom-icon') ? 'selected="true"' : ''; ?>><?php echo __('Custom icon', 'runway'); ?></option>
							</select>
							<input class='dashicon-code-selected' name="advanced[menu-dashicon-code]" type="hidden" value=<?php echo isset($post_type['advanced']['menu-dashicon-code'])? $post_type['advanced']['menu-dashicon-code'] : '';?> >
							<input class='dashicon-class-selected' name="advanced[menu-dashicon-class]" type="hidden" value=<?php echo isset($post_type['advanced']['menu-dashicon-class'])? $post_type['advanced']['menu-dashicon-class'] : '';?> >
							<?php if($_GET['navigation'] == 'add-post-type'): ?>
								<script type="text/javascript">
								  	(function($){
        								$(document).ready(function() {
//									        $("#menu_icon").val('menu-icon-page').attr('selected',true);
							            });
								    })(jQuery);
								</script>
							<?php endif;
							require_once(get_template_directory().'/framework/templates/dashicons.php');
							?>
							<div id="custom-icon-upload" style="display:none;">

								<?php
								$src = "";
								if(isset($post_type['advanced']['custom_icon_file']) && $post_type['advanced']['custom_icon_file'] != '') {
									$src = $post_type['advanced']['custom_icon_file'];
								}
								?>

								<img src="<?php echo $src; ?>" id="cusom-icon-image" alt="<?php echo __('Custom icon', 'runway'); ?>"/>
								<div id="choose-another-icon" style="display: none;">
									<a href="#"><?php echo __('Choose Another Icon', 'runway'); ?></a>
								</div>
								<div id="choose-icon">
									<input type="file" value="Select file"/>
								</div>

								<input type="hidden" name="advanced[custom_icon_file]" value="<?php echo $src; ?>" id="custom_icon_file"/>
							</div>
							<p class="description"></p>
						</td>
					</tr>

					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Permissions', 'runway'); ?>
						</th>
						<td>
							<select name="advanced[capability][level_1]" id="permission_1_level">
								<option value="same-as-posts" <?php if(isset($post_type['advanced']['capability']['level_1'])) echo ($post_type['advanced']['capability']['level_1'] == 'same-as-posts') ? 'selected="true"' : ''; ?>><?php echo __('Same as Posts', 'runway'); ?></option>
								<option value="same-as-pages" <?php if(isset($post_type['advanced']['capability']['level_1'])) echo ($post_type['advanced']['capability']['level_1'] == 'same-as-pages') ? 'selected="true"' : ''; ?>><?php echo __('Same as Pages', 'runway'); ?></option>
								<option value="custom" <?php if(isset($post_type['advanced']['capability']['level_1'])) echo ($post_type['advanced']['capability']['level_1'] == 'custom') ? 'selected="true"' : ''; ?>><?php echo __('Custom', 'runway'); ?></option>
							</select>

							<?php if($_GET['navigation'] == 'add-post-type'): ?>
								<script type="text/javascript">
								  	(function($){
        								$(document).ready(function() {

									  		function permissionSetCustomValues(){

												$("#permission_read_posts").val('read_posts');
												$("#permission_read_private_posts").val('read_private_posts');
												$("#permission_publish_posts").val('publish_posts');
												$("#permission_delete_post").val('delete_post');
												$("#permission_edit_post").val('edit_post');
												$("#permission_edit_posts").val('edit_posts');
												$("#permission_edit_others_posts").val('edit_others_posts');
									    	};

									        $("#permission_1_level").val('same-as-posts').attr('selected',true);
									        permissionSetCustomValues();
							            });
								    })(jQuery);
								</script>
							<?php endif; ?>

							<script type="text/javascript">
							  	(function($){
        							$(document).ready(function() {

								  		function permissionSetValues(arg){                         // set defaults for same as post & same as page
											if( arg == 'same-as-posts') {
												$("#permission_read_posts").val('read_posts');
												$("#permission_read_private_posts").val('read_private_posts');
												$("#permission_publish_posts").val('publish_posts');
												$("#permission_delete_post").val('delete_post');
												$("#permission_edit_post").val('edit_post');
												$("#permission_edit_posts").val('edit_posts');
												$("#permission_edit_others_posts").val('edit_others_posts');

												$("#permission_custom_set").hide();
											}
											if( arg == 'same-as-pages') {
												$("#permission_read_posts").val('read_posts');
												$("#permission_read_private_posts").val('read_private_posts');
												$("#permission_publish_posts").val('publish_posts');
												$("#permission_delete_post").val('delete_post');
												$("#permission_edit_post").val('edit_post');
												$("#permission_edit_posts").val('edit_posts');
												$("#permission_edit_others_posts").val('edit_others_posts');

												$("#permission_custom_set").hide();
											}
								    	};

								    	if( $("#permission_1_level").val() == 'custom' )
											$("#permission_custom_set").show();
										else
											permissionSetValues( $("#permission_1_level").val() );

        								$("#permission_1_level").change(function(){
								    		if( $("#permission_1_level").val() == 'custom' )
												$("#permission_custom_set").show();
											else
												permissionSetValues( $("#permission_1_level").val() );
	    								});
							        });
							    })(jQuery);
							</script>

							<div id="permission_custom_set">
								<table class="form-table">
									<tbody>
										<?php
										$caps_list = array( 'read_posts' => __('Read', 'runway'),
													'read_private_posts' => __('Read Private', 'runway'),
													'publish_posts' => __('Publish', 'runway'),
													'delete_post' => __('Delete', 'runway'),
													'edit_post' => __('Edit', 'runway'),
													'edit_posts' => __('Edit Posts', 'runway'),
													'edit_others_posts' => __('Edit Others Posts', 'runway')
										);
										foreach($caps_list as $caps_list_key => $caps_list_val): ?>
											<tr class="">
												<th scope="row" valign="top">
													<?php echo $caps_list_val; ?>
												</th>
												<td>
													<select name="advanced[capability]<?php echo '['.$caps_list_key.']'; ?>" id="<?php echo 'permission_'.$caps_list_key; ?>">
														<?php
														foreach ( $wp_roles->roles['administrator']['capabilities'] as $cap => $name ):
															$cap_name = str_replace( '_', ' ', $cap );
														?>
															<option value="<?php echo $cap ?>" <?php  if(isset($post_type['advanced']['capability'][$caps_list_key])) echo ($post_type['advanced']['capability'][$caps_list_key] == $cap) ? 'selected="true"' : ''; ?>><?php echo ucfirst( $cap_name ); ?></option>
														<?php endforeach; ?>
													</select><br>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>

							</div>

					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Features', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[supports][title]" value="title" <?php echo isset($post_type['advanced']['supports']['title']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>><?php echo __('Title', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][editor]" value="editor" <?php echo isset($post_type['advanced']['supports']['editor']) || $_GET['navigation'] == 'add-post-type'? 'checked' : ''; ?>><?php echo __('Editor', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][author]" value="author" <?php echo isset($post_type['advanced']['supports']['author']) ? 'checked' : ''; ?>><?php echo __('Author', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][thumbnail]" value="thumbnail" <?php echo isset($post_type['advanced']['supports']['thumbnail']) ? 'checked' : ''; ?>><?php echo __('Thumbnail', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][excerpt]" value="excerpt" <?php echo isset($post_type['advanced']['supports']['excerpt']) ? 'checked' : ''; ?>><?php echo __('Excerpt', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][trackbacks]" value="trackbacks" <?php echo isset($post_type['advanced']['supports']['trackbacks']) ? 'checked' : ''; ?>><?php echo __('Trackbacks', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][custom-fields]" value="custom-fields" <?php echo isset($post_type['advanced']['supports']['custom-fields']) ? 'checked' : ''; ?>><?php echo __('Custom fields', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][comments]" value="comments" <?php echo isset($post_type['advanced']['supports']['comments']) ? 'checked' : ''; ?>><?php echo __('Comments', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][revisions]" value="revisions" <?php echo isset($post_type['advanced']['supports']['revisions']) ? 'checked' : ''; ?>><?php echo __('Revisions', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][page-attributes]" value="page-attributes" <?php echo isset($post_type['advanced']['supports']['page-attributes']) ? 'checked' : ''; ?>><?php echo __('Page attributes', 'runway'); ?><br>
							<input class="checkbox" type="checkbox" name="advanced[supports][post-formats]" value="post-formats" <?php echo isset($post_type['advanced']['supports']['post-formats']) ? 'checked' : ''; ?>><?php echo __('Post formats', 'runway'); ?><br>
							<p class="description"><?php echo __('Select the controls and functionality this post type will support', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Has Archive', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[has_archive]" value="true" <?php echo isset($post_type['advanced']['has_archive']) ? 'checked' : ''; ?>>
							<p class="description"><?php echo __('Enables post type archives', 'runway'); ?></p>
						</td>
					</tr>

					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Permalink Rewrite', 'runway'); ?>
						</th>
						<td>
							<select name="advanced[rewrite][level_1]" id="rewrite_1_level">
								<option value="default" <?php if(isset($post_type['advanced']['rewrite']['level_1'])) echo ($post_type['advanced']['rewrite']['level_1'] == 'default') ? 'selected="true"' : ''; ?>><?php echo __('Default (post type name)', 'runway'); ?></option>
								<option value="disable" <?php if(isset($post_type['advanced']['rewrite']['level_1'])) echo ($post_type['advanced']['rewrite']['level_1'] == 'disable') ? 'selected="true"' : ''; ?>><?php echo __('Disable (force query strings)', 'runway'); ?></option>
								<option value="custom" <?php if(isset($post_type['advanced']['rewrite']['level_1'])) echo ($post_type['advanced']['rewrite']['level_1'] == 'custom') ? 'selected="true"' : ''; ?>><?php echo __('Custom', 'runway'); ?></option>
							</select>

							<?php if($_GET['navigation'] == 'add-post-type'): ?>
								<script type="text/javascript">
								  	(function($){
        								$(document).ready(function() {

									  		function rewriteSetCustomValues(){

												$("#rewrite_url_slug").val('item');
												$("#rewrite_with_front").val(true);
												$("#rewrite_pages").val(true);
												$("#rewrite_feeds").val(true);
									    	};

									        $("#rewrite_1_level").val('default').attr('selected',true);
									        rewriteSetCustomValues();
							            });
								    })(jQuery);
								</script>
							<?php endif; ?>

							<script type="text/javascript">
							  	(function($){
        							$(document).ready(function() {

								  		function rewriteSetValues(arg){

											if( arg == 'default') {
												$("#rewrite_url_slug").val('item');
												$("#rewrite_with_front").val(true);
												$("#rewrite_pages").val(true);
												$("#rewrite_feeds").val(true);

												$("#rewrite_custom_set").hide();
											}
											if( arg == 'disable') {
												$("#rewrite_url_slug").val('');
												$("#rewrite_with_front").val(true);
												$("#rewrite_pages").val(true);
												$("#rewrite_feeds").val(true);

												$("#rewrite_custom_set").hide();
											}
								    	};

								    	if( $("#rewrite_1_level").val() == 'custom' )
											$("#rewrite_custom_set").show();
										else
											rewriteSetValues( $("#rewrite_1_level").val() );

        								$("#rewrite_1_level").change(function(){
								    		if( $("#rewrite_1_level").val() == 'custom' )
												$("#rewrite_custom_set").show();
											else
												rewriteSetValues( $("#rewrite_1_level").val() );
	    								});
							        });
							    })(jQuery);
							</script>

							<div id="rewrite_custom_set">
								<table class="form-table">
									<tbody>
										<tr class="">
											<td>
												<?php echo __('URL Slug', 'runway'); ?>
												<br />
												<input class="input-text" id="rewrite_url_slug" type="text" name="advanced[rewrite][url_slug]" value="<?php echo ($_GET['navigation'] == 'add-post-type') ? 'item' : $post_type['advanced']['rewrite']['url_slug'] ; ?>">
												<p class="description"><?php echo __('The permalink base text. i.e. www.example.com/event/', 'runway'); ?></p>
											</td>
										</tr>
										<tr class="">
											<td>
												<?php echo __('Include URL Slug with Items', 'runway'); ?>
												<br />
												<input class="checkbox" type="checkbox" id="rewrite_with_front" name="advanced[rewrite][with_front]" value="true" <?php echo isset($post_type['advanced']['rewrite']['with_front']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>> <?php echo __('Yes', 'runway'); ?>
												<p class="description"><?php echo __('Include permalink base in single item URL. The base will use the value of "Name (Singular)" i.e. Enabled: www.example.com/calendar/event/, Disabled: www.example.com/event', 'runway'); ?></p>
											</td>
										</tr>
										<tr class="">
											<td>
												<?php echo __('Pagination', 'runway'); ?>
												<br />
												<input class="checkbox" type="checkbox" id="rewrite_pages" name="advanced[rewrite][pages]" value="true" <?php echo isset($post_type['advanced']['rewrite']['pages']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>> <?php echo __('Yes', 'runway'); ?>
												<p class="description"><?php echo __('Allow pagination for this post type', 'runway'); ?></p>
											</td>
										</tr>
										<tr class="">
											<td>
												<?php echo __('Feeds', 'runway'); ?>
												<br />
												<input class="checkbox" type="checkbox" id="rewrite_feeds" name="advanced[rewrite][feeds]" value="true" <?php echo isset($post_type['advanced']['rewrite']['feeds']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>> <?php echo __('Yes', 'runway'); ?>
												<p class="description"><?php echo __('Build feed permastruct', 'runway'); ?></p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Publicly Queryable', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[publicly_queryable]" value="true" <?php echo isset($post_type['advanced']['publicly_queryable']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>><?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Enable front end queries as part of parse_request(). Typically this is enabled', 'runway'); ?></p>
						</td>
					</tr>
					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Query', 'runway'); ?>
						</th>
						<td>
							<select name="advanced[query_var][level_1]" id="query_var_1_level">
								<option value="post-type" <?php if(isset($post_type['advanced']['query_var']['level_1'])) echo ($post_type['advanced']['query_var']['level_1'] == 'post-type') ? 'selected="true"' : ''; ?>><?php echo __('Post Type (taxonomy key)', 'runway'); ?></option>
								<option value="custom" <?php if(isset($post_type['advanced']['query_var']['level_1'])) echo ($post_type['advanced']['query_var']['level_1'] == 'custom') ? 'selected="true"' : ''; ?>><?php echo __('Custom', 'runway'); ?></option>
							</select>

							<?php if($_GET['navigation'] == 'add-post-type'): ?>
								<script type="text/javascript">
								  	(function($){
        								$(document).ready(function() {

									  		function querySetCustomValues(){

												$("#query_var_custom").val('item');
									    	};

									        $("#query_var_1_level").val('post-type').attr('selected',true);
									        querySetCustomValues();
							            });
								    })(jQuery);
								</script>
							<?php endif; ?>

							<script type="text/javascript">
							  	(function($){
        							$(document).ready(function() {

								  		function querySetValues(arg){
											if( arg == 'post-type') {
												$("#query_var_custom").val('item');

												$("#query_var_custom_set").hide();
											}
								    	};

								    	if( $("#query_var_1_level").val() == 'custom' )
											$("#query_var_custom_set").show();
										else
											querySetValues( $("#query_var_1_level").val() );

        								$("#query_var_1_level").change(function(){
								    		if( $("#query_var_1_level").val() == 'custom' )
												$("#query_var_custom_set").show();
											else
												querySetValues( $("#query_var_1_level").val() );
	    								});
							        });
							    })(jQuery);
							</script>

							<div id="query_var_custom_set">
								<table class="form-table">
									<tbody>
										<tr class="">
											<td>
												<?php echo __('Custom Query', 'runway'); ?>
												<br />
												<input class="input-text" id="query_var_custom" type="text" name="advanced[query_var][custom]" value="<?php echo ($_GET['navigation'] == 'add-post-type') ? 'item' : $post_type['advanced']['query_var']['custom'] ; ?>">
												<p class="description"><?php echo __('Custom query variable. e.g. product, event or movie', 'runway'); ?></p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<p class="description"><?php echo __('Direct query variable used in WP_Query. e.g. WP_Query( array( \'post_type\' => \'product\', \'term\' => \'car\' ) )', 'runway'); ?></p>
						</td>
					</tr>

					<tr class="">
						<th scope="row" valign="top">
							<?php echo __('Enable Export', 'runway'); ?>
						</th>
						<td>
							<input class="checkbox" type="checkbox" name="advanced[can_export]" value="true" <?php echo isset($post_type['advanced']['can_export']) || $_GET['navigation'] == 'add-post-type' ? 'checked' : ''; ?>> <?php echo __('Yes', 'runway'); ?>
							<p class="description"><?php echo __('Enable exporting with the WP import/export tool', 'runway'); ?></p>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- ASSIGNED TAXONOMIES SETTINGS BOX -->
<div class="meta-box-sortables metabox-holder">
	<div class="postbox">
		<div class="handlediv" title="<?php echo __('Click to toggle', 'runway'); ?>"><br></div>
		<h3 class="hndle"><span><?php echo __('Assigned taxonomies', 'runway'); ?></span></h3>
		<div class="inside">
			<?php
			foreach ((array)get_taxonomies( array(), $output = 'objects') as $taxonomy => $values) :
				if( !in_array( $values->label, array( 'Navigation Menus', 'Link Categories', 'Format' ) ) ): ?>
					<label>
		                <input name="taxonomies[]" value="<?php echo $values->name; ?>" type="checkbox" <?php if(isset($post_type['taxonomies'])) { echo (in_array($values->name, (array)$post_type['taxonomies'])) ? 'checked="checked"' : ''; } ?>>
		                <?php echo $values->label; ?>
		            </label><br>
	        	<?php endif; ?>
			<?php endforeach; ?>
			<?php

			?>
		</div>
	</div>
</div>
<!-- ASSIGNED FIELDS SETTINGS BOX -->
<div class="meta-box-sortables metabox-holder">
	<div class="postbox">
		<div class="handlediv" title="<?php echo __('Click to toggle', 'runway'); ?>"><br></div>
		<h3 class="hndle"><span><?php echo __('Assigned fields', 'runway'); ?></span></h3>
		<div class="inside" >
			<?php
			$fields = $this->get_custom_fields();
			if(!empty($fields)){
				foreach ((array)$fields as $field => $values) : ?>
					<?php if(!empty($values['inputs'])): ?>
					    <?php $post_type['fields'] = isset($post_type['fields'])? $post_type['fields'] : array(); ?>
						<label>
			                <input name="fields[]" value="<?php echo $values['alias'] ?>" type="checkbox" <?php if(isset($post_type)) { echo (in_array($values['alias'], (array)$post_type['fields'])) ? 'checked="checked"' : ''; } ?>>
			               	<?php echo $values['name']; ?>
			            </label><br>
			           <?php endif; ?>
				<?php endforeach;
			}else{
				echo __('No fields created', 'runway') . ".";
			} ?>
		</div>
	</div>
</div>
<input class="button-primary" type="button" id="save-button" value="<?php _e('Save Settings', 'runway') ?>">
</form>

<script type="text/javascript">
    jQuery(document).ready(function($){

        var customIconImage = $('#cusom-icon-image');

        $('#menu_icon').change(function(){
            if($(this).val() == 'custom-icon'){
                $('#custom-icon-upload').show();
                $('#icons').hide();
            }
            else {
                $('#custom-icon-upload').hide();
                $('#icons').show();
            }
        });

        if($('#menu_icon').val() == 'custom-icon'){
            $('#custom-icon-upload').css('display', '');
            $('#icons').hide();
        }

        if(customIconImage.attr('src') != undefined && customIconImage.attr('src') != '') {
				$('#choose-another-icon').css('display', '');
				$('#choose-icon').hide();
        }else{
            customIconImage.hide();
        }

		$('body').on('click', '#choose-another-icon a', function(e){
			e.preventDefault();
			e.stopPropagation();

			$('#choose-another-icon').hide();
			$('#choose-icon').css('display', '');
			$('#choose-icon input').val('');
            customIconImage.hide();
		});
		$('body').on('change', '#choose-icon input', function(){

			var data = new FormData();
			data.append('custom_icon', $(this)[0].files[0]);
			data.append('action', 'save_custom_icon');

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: data,
				cache: false,
				processData: false,
				contentType: false,
				success: function(data) {
					$('#choose-another-icon').css('display', '');
					$('#choose-icon').hide();
                    customIconImage.attr('src', data);
                    customIconImage.css('display', '');
					$('#custom_icon_file').val(data);
				}
			});
		});

		$('#save-button').click(function(e){
			var contenttype_name = $('#contenttype_name').val().trim();
			var contenttype_singular_name = $('#contenttype_singular_name').val().trim();
			var contenttype_menu_name = $('#contenttype_menu_name').val().trim();
			var contenttype_parent_item_colon = $('#contenttype_parent_item_colon').val().trim();

			if(contenttype_name == ''){
				$('#contenttype_name').css('border-color', 'Red');
			}
			else{
				$('#contenttype_name').css('border-color', '');
			}

			if(contenttype_singular_name == ''){
				$('#contenttype_singular_name').css('border-color', 'Red');
			}
			else{
				$('#contenttype_singular_name').css('border-color', '');
			}

			if(contenttype_menu_name == ''){
				$('#contenttype_menu_name').css('border-color', 'Red');
			}
			else{
				$('#contenttype_menu_name').css('border-color', '');
			}

			if(contenttype_parent_item_colon == ''){
				$('#contenttype_parent_item_colon').css('border-color', 'Red');
			}
			else{
				$('#contenttype_parent_item_colon').css('border-color', '');
			}

			if( contenttype_name &&	contenttype_singular_name && contenttype_menu_name && 	contenttype_parent_item_colon){
				$('#add-edit-contenttype').submit();
			}
		});

	})(jQuery);
</script>