<form action="<?php echo $this->self_url( 'fields' ); ?>&action=update-field<?php echo isset( $field ) ? '&alias='.$field['alias'] : ''; ?>" id="add-field" method="post">
	<?php wp_nonce_field( 'update-field', 'update-field-nonce' ); ?>
	<table class="form-table">
		<tbody>
			<tr class="">
				<th scope="row" valign="top">
					<?php echo __( 'Name', 'runway' ); ?>
					<p class="description required"><?php echo __( 'Required', 'runway' ); ?></p>
				</th>
				<td>
					<input class="input-text " id="name" type="text" name="name" value="<?php echo ( isset( $field ) ) ? $field['name'] : ''; ?>">
					<p class="description"><?php echo __( 'General name for the taxonomy type, usually plural', 'runway' ); ?></p>
				</td>
			</tr>
			<tr class="">
				<th scope="row" valign="top"><?php echo __( 'Used with post types', 'runway' ); ?></th>
				<td>
					<?php foreach ( get_post_types( array(), 'objects' ) as $post_type => $values ) : ?>
						<?php if( ! in_array( $values->name, array( 'attachment', 'revision', 'nav_menu_item' ) ) ) : ?>
							<label>
								<input class="input-check" type="checkbox" value="<?php echo $values->name; ?>" <?php if( isset( $field['post_types'] ) ) echo ( in_array( $values->name, $field['post_types'] ) ) ? 'checked' : ''; ?> name="post_types[]"> <?php echo $values->label; ?>
							</label><br>
						<?php endif ?>
					<?php endforeach; ?>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="meta-box-sortables metabox-holder">
		<div class="postbox">
			<div class="handlediv" title="<?php echo __( 'Click to toggle', 'runway' ); ?>"><br></div>
			<h3 class="hndle"><span> <?php echo __( 'Advanced settings', 'runway' ); ?></span></h3>
			<div class="inside" style="display:none;">
				<table class="form-table">
					<tbody>
						<tr class="">
							<th scope="row" valign="top"><?php echo __( 'Default position', 'runway' ); ?></th>
							<td>
								<label>
									<input class="input-radio" type="radio" name="position" value="right" <?php if( isset( $field['position'] ) ) echo ( $field['position'] == 'right' ) ? 'checked="checked"' : ''; ?>> <?php echo __( 'Right', 'runway' ); ?>
								</label><br>
								<label>
									<input class="input-radio" type="radio" name="position" value="left" <?php if( isset( $field['position'] ) ) echo ( $field['position'] == 'left' ) ? 'checked="checked"' : ''; ?>> <?php echo __( 'Left', 'runway' ); ?>
								</label>
								<p class="description"><?php echo __( 'The default column the box will appear in. Note that a user can move boxes on the Write/Edit page as they see fit', 'runway' ); ?>.</p>
							</td>
		 				</tr>
						<tr class="">
							<th scope="row" valign="top">
								<?php echo __( 'Roles to access', 'runway' ); ?>
								<p class="description"><?php echo __( 'The roles for which this field will be visible', 'runway' ); ?>.</p>
							</th>
							<td>
								<?php
									  global $wp_roles;
									  foreach ( $wp_roles->roles as $key => $values ) : ?>
											<label>
												<input class="input-check" type="checkbox" value="<?php echo $key; ?>" name="more_access_cap[]" <?php  if(isset($field['more_access_cap'])) echo (in_array($key, $field['more_access_cap'])) ? 'checked' : ''; ?>> <?php echo $values['name']; ?>
											</label><br>
								<?php endforeach; ?>
							</td>
			 			</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<input class="button-primary" type="button" id="save-button-field" value="<?php _e( 'Save Settings', 'runway' ) ?>">
</form>
