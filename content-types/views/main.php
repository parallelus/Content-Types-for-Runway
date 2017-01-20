<br>
<table class="wp-list-table widefat" style="width: auto; min-width: 50%;">
	<thead>
		<tr>
			<th id="field-name" class="manage-column column-name"><?php _e( 'Post Type', 'runway' ) ?></th>
			<th id="field-header" class="manage-column column-header"><?php _e( 'Alias', 'runway' ) ?></th>
			<th id="field-header" class="manage-column column-header"><?php _e( 'Actions', 'runway' ) ?></th>
		</tr>
	</thead>
	<tbody id="the-list">
		<?php
			if( ! empty( $this->content_types_options['content_types'] ) ) :
			foreach ( (array)$this->content_types_options['content_types'] as $content_type => $values ) :
		?>
			<tr class="active">
				<td class="column-name">
					<a href="<?php echo $this->self_url( 'edit-post-type' ); ?>&alias=<?php echo $values['alias']; ?>"><strong><?php echo $values['labels']['name']; ?></strong></a>
				</td>
				<td class="column-alias">
					<?php echo $values['alias']; ?>
				</td>
				<td class="column-alias">
					<a href="<?php echo $this->self_url( 'edit-post-type' ); ?>&alias=<?php echo $values['alias']; ?>"><?php echo __( 'Edit', 'runway' ); ?></a> |
					<a href="<?php echo $this->self_url( 'confirm-delete-post-type' ); ?>&alias=<?php echo $values['alias']; ?>"><?php echo __( 'Delete', 'runway' ); ?></a>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php else : ?>
			<tr class="active">
				<td class="no-items" colspan="2">
					<?php echo __( 'No custom post types have been created', 'runway' ); ?>.
				</td>
			</tr>
		<?php endif;  ?>
	</tbody>
</table>

<!-- SET Hide/Show to Standalone theme-->
<?php if( IS_CHILD && get_template() == 'runway-framework' ) { ?>
	<form action="<?php echo wp_nonce_url($this->self_url().'&action=update-post-type-main', 'update-post-type-main', 'update-post-type-main-nonce');?>" id="update-post-type-main" method="post">
		<div class="meta-box-sortables metabox-holder">
			<hr>
			<p>
				<label>
				<?php if( ! isset( $this->content_types_options['hide_in_standalone'] ) ) { ?>
					<input name="hide_in_standalone" id="hide_in_standalone" type="hidden" value="false">
					<input name="hide_in_standalone" id="hide_in_standalone" type="checkbox" value="true" checked>
				<?php } else { ?>
					<input name="hide_in_standalone" id="hide_in_standalone" type="hidden" value="false">
					<input name="hide_in_standalone" id="hide_in_standalone" type="checkbox" value="true" <?php echo ( $this->content_types_options['hide_in_standalone'] == 'true' ) ? 'checked' : ''; ?>>
				<?php }
					_e( 'Hide the Content Types admin from standalone themes?', 'runway' ); ?>
				</label>
	        </p>
	        <p class="description"><?php _e( 'Hidden from standalone themes by default. Only the admin interface is hidden. All content and settings created in this area will continue to function.', 'runway' ); ?></p>
			<hr>
	        <br>
		</div>
		<input class="button-primary" type="button" id="save-button-main" value="<?php _e( 'Save Settings', 'runway' ) ?>">
	</form>
<?php } ?>
