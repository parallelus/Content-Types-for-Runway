<br>
<table class="wp-list-table widefat" style="width: auto; min-width: 50%;">
	<thead>
		<tr>
			<th id="field-name" class="manage-column column-name"><?php _e('Post Type', 'framework') ?></th>
			<th id="field-header" class="manage-column column-header"><?php _e('Alias', 'framework') ?></th>			
			<th id="field-header" class="manage-column column-header"><?php _e('Actions', 'framework') ?></th>			
		</tr>
	</thead>
	<tbody id="the-list">	
		<?php 
			if(!empty($this->content_types_options['content_types'])) :
			foreach ((array)$this->content_types_options['content_types'] as $content_type => $values) : 
		?>
			<tr class="active">
				<td class="column-name">
					<a href="<?php echo $this->self_url('edit-post-type'); ?>&alias=<?php echo $values['alias']; ?>"><strong><?php echo $values['labels']['name']; ?></strong></a>
				</td>
				<td class="column-alias">
					<?php echo $values['alias']; ?>
				</td>				
				<td class="column-alias">
					<a href="<?php echo $this->self_url('edit-post-type'); ?>&alias=<?php echo $values['alias']; ?>"><?php echo __('Edit', 'framework'); ?></a> |
					<a href="<?php echo $this->self_url('confirm-delete-post-type'); ?>&alias=<?php echo $values['alias']; ?>"><?php echo __('Delete', 'framework'); ?></a>
				</td>
			</tr>			
		<?php endforeach; ?>
		<?php else : ?>	
			<tr class="active">
				<td class="no-items" colspan="2">
					<?php echo __('No custom post types have been created', 'framework'); ?>.
				</td>			
			</tr>			
		<?php endif;  ?>
	</tbody>
</table>

<!-- SET Hide/Show to Standalone theme-->
<?php if( IS_CHILD && get_template() == 'runway-framework') { ?>
	<form action="<?php echo $this->self_url().'&action=update-post-type-main';?>" id="update-post-type-main" method="post">
		<div class="meta-box-sortables metabox-holder">
			<label>
				<?php if(!isset($this->content_types_options['hide_in_standalone'])) { ?>
					<input name="hide_in_standalone" id="hide_in_standalone" type="hidden" value="false">
					<input name="hide_in_standalone" id="hide_in_standalone" type="checkbox" value="true" checked>
				<?php } else { ?>
	                <input name="hide_in_standalone" id="hide_in_standalone" type="hidden" value="false">
	                <input name="hide_in_standalone" id="hide_in_standalone" type="checkbox" value="true" <?php echo ($this->content_types_options['hide_in_standalone'] == 'true')? 'checked' : ''; ?>>
	            <?php } ?>
	            <?php echo __('Hide in Standalone theme', 'framework'); ?>
	        </label><br><br>
		</div>
		<input class="button-primary" type="button" id="save-button" value="<?php _e('Save', 'framework') ?>">
	</form>
<?php } ?>

<script type="text/javascript">
	(function($){

		$('#save-button').click(function(e){
			$('#update-post-type-main').submit();
		});

	})(jQuery);
</script>