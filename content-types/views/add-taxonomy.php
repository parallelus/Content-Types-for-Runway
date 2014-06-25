<form action="<?php echo $this->self_url('taxonomies'); ?>&action=update-taxonomy<?php echo isset($taxonomy) ? '&alias='.$taxonomy['alias'] : ''; ?>" id="add-taxonomy" method="post">
<h3><?php echo __('Labels', 'framework'); ?></h3>
<table class="form-table">
	<tbody>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Name', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="name" name="labels[name]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['name'] : ''; ?>">
				<p class="description"><?php echo __('General name for the taxonomy type, usually plural', 'framework'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Singular Name', 'framework'); ?>				
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="singular_name" name="labels[singular_name]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['singular_name'] : ''; ?>">
				<p class="description"><?php echo __('Name for one object of this taxonomy type. Defaults to value of name', 'framework'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Menu Name', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="menu_name" name="labels[menu_name]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['menu_name'] : ''; ?>">
				<p class="description"><?php echo __('The menu name text', 'framework'); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Parent Item Colon', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="parent_item_colon" name="labels[parent_item_colon]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['parent_item_colon'] : ''; ?>">
				<p class="description"><?php echo __('The parent text', 'framework'); ?></p>
			</td>
		</tr>		
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('All Items', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>							
			</th>
			<td>
				<input class="input-text default-label" type="text" id="all_items" name="labels[all_items]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['all_items'] : 'All Taxonomies'; ?>">
				<p class="description"><?php echo __('The all items text used in the menu', 'framework'); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Add New Item', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>						
			</th>
			<td>
				<input class="input-text " type="text" id="add_new_item" name="labels[add_new_item]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['add_new_item'] : 'Add new taxonomy'; ?>">
				<p class="description"><?php echo __('The add new item text', 'framework'); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Edit Item', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>						
			</th>
			<td>
				<input class="input-text default-label" id="edit_item" type="text" name="labels[edit_item]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['edit_item'] : 'Edit taxonomy'; ?>">
				<p class="description"><?php echo __('The edit item text', 'framework'); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Update Item', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>						
			</th>
			<td>
				<input class="input-text default-label" id="update_item" type="text" name="labels[update_item]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['update_item'] : 'Update taxonomy'; ?>">
				<p class="description"><?php echo __('The update item text', 'framework'); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Search Items', 'framework'); ?>
				<p class="description required"><?php echo __('Required', 'framework'); ?></p>							
			</th>
			<td>
				<input class="input-text default-label" id="search_items" type="text" name="labels[search_items]" value="<?php echo (isset($taxonomy)) ? $taxonomy['labels']['search_items'] : 'Search'; ?>">
				<p class="description"><?php echo __('The search items text', 'framework'); ?></p>
			</td>
		</tr>
	</tbody>
</table>
<input class="button-primary" type="button" id="save-button" value="<?php _e('Save Settings', 'framework') ?>">
</form>

<script type="text/javascript">
	(function($){
		$('#save-button').click(function(e){			
			// var headerTitle = $('#header-title').val().trim();
			name = $('#name').val().trim()
			singular_name = $('#singular_name').val().trim()
			menu_name = $('#menu_name').val().trim()
			parent_item_colon = $('#parent_item_colon').val().trim()
			all_items = $('#all_items').val().trim()
			add_new_item = $('#add_new_item').val().trim()
			edit_item = $('#edit_item').val().trim()
			update_item = $('#update_item').val().trim()
			search_items = $('#search_items').val().trim()			
			
			if(name == ''){
				$('#name').css('border-color', 'Red');
			}
			else{
				$('#name').css('border-color', '');	
			}

			if(singular_name == ''){
				$('#singular_name').css('border-color', 'Red');
			}
			else{
				$('#singular_name').css('border-color', '');	
			}

			if(menu_name == ''){
				$('#menu_name').css('border-color', 'Red');
			}
			else{
				$('#menu_name').css('border-color', '');	
			}

			if(parent_item_colon == ''){
				$('#parent_item_colon').css('border-color', 'Red');
			}
			else{
				$('#parent_item_colon').css('border-color', '');	
			}

			if(all_items == ''){
				$('#all_items').css('border-color', 'Red');
			}
			else{
				$('#all_items').css('border-color', '');	
			}

			if(add_new_item == ''){
				$('#add_new_item').css('border-color', 'Red');
			}
			else{
				$('#add_new_item').css('border-color', '');	
			}

			if(edit_item == ''){
				$('#edit_item').css('border-color', 'Red');
			}
			else{
				$('#edit_item').css('border-color', '');	
			}

			if(update_item == ''){
				$('#update_item').css('border-color', 'Red');
			}
			else{
				$('#update_item').css('border-color', '');	
			}

			if(search_items == ''){
				$('#search_items').css('border-color', 'Red');
			}
			else{
				$('#search_items').css('border-color', '');	
			}			
			
			if( name && singular_name && menu_name && parent_item_colon && all_items && add_new_item && edit_item && update_item && search_items){
				$('#add-taxonomy').submit();
			}
		});

	})(jQuery);
</script>