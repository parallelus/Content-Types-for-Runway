<form action="<?php echo $this->self_url( 'taxonomies' ); ?>&action=update-taxonomy<?php echo isset( $taxonomy ) ? '&alias='.$taxonomy['alias'] : ''; ?>" id="add-taxonomy" method="post">
<h3><?php echo __( 'Labels', 'runway' ); ?></h3>
<table class="form-table">
	<tbody>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __( 'Name', 'runway' ); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="name" name="labels[name]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['name'] : ''; ?>">
				<p class="description"><?php echo __( 'General name for the taxonomy type, usually plural', 'runway' ); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __( 'Singular Name', 'runway' ); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="singular_name" name="labels[singular_name]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['singular_name'] : ''; ?>">
				<p class="description"><?php echo __( 'Name for one object of this taxonomy type. Defaults to value of name', 'runway' ); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __( 'Menu Name', 'runway' ); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="menu_name" name="labels[menu_name]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['menu_name'] : ''; ?>">
				<p class="description"><?php echo __( 'The menu name text', 'runway' ); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __( 'Parent Item Colon', 'runway' ); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="parent_item_colon" name="labels[parent_item_colon]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['parent_item_colon'] : ''; ?>">
				<p class="description"><?php echo __( 'The parent text', 'runway' ); ?></p>
			</td>
		</tr>
		<tr class="">
			<th scope="row" valign="top">
				<?php echo __('All Items', 'runway'); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text default-label" type="text" id="all_items" name="labels[all_items]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['all_items'] : __( 'All Taxonomies', 'runway' ); ?>">
				<p class="description"><?php echo __( 'The all items text used in the menu', 'runway' ); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Add New Item', 'runway'); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text " type="text" id="add_new_item" name="labels[add_new_item]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['add_new_item'] : __( 'Add new taxonomy', 'runway' ); ?>">
				<p class="description"><?php echo __( 'The add new item text', 'runway' ); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __('Edit Item', 'runway'); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text default-label" id="edit_item" type="text" name="labels[edit_item]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['edit_item'] : __( 'Edit taxonomy', 'runway' ); ?>">
				<p class="description"><?php echo __( 'The edit item text', 'runway' ); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __( 'Update Item', 'runway' ); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text default-label" id="update_item" type="text" name="labels[update_item]" value="<?php echo ( isset($taxonomy ) ) ? $taxonomy['labels']['update_item'] : __( 'Update taxonomy', 'runway' ); ?>">
				<p class="description"><?php echo __( 'The update item text', 'runway' ); ?></p>
			</td>
		</tr>
<tr class="">
			<th scope="row" valign="top">
				<?php echo __( 'Search Items', 'runway' ); ?>
				<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
			</th>
			<td>
				<input class="input-text default-label" id="search_items" type="text" name="labels[search_items]" value="<?php echo ( isset( $taxonomy ) ) ? $taxonomy['labels']['search_items'] : __( 'Search', 'runway' ); ?>">
				<p class="description"><?php echo __( 'The search items text', 'runway' ); ?></p>
			</td>
		</tr>
	</tbody>
</table>
<input class="button-primary" type="button" id="save-button-taxonomy" value="<?php _e( 'Save Settings', 'runway' ) ?>">
</form>
