jQuery(document).ready(function($) {

	$('#contenttype_name').on('change', function(){

		var plural_name = $(this).val();

		$('[name="labels[menu_name]"]').val( plural_name );
		$('[name="labels[all_items]"]').val( translations_js.all_ct + ' ' + plural_name );

	});

	$('#contenttype_singular_name').on('change', function(){

		var singular_name = $(this).val();

		$('[name="labels[view_item]"]').val( translations_js.view_ct + ' ' + singular_name );
		$('[name="labels[add_new_item]"]').val( translations_js.add_new_ct + ' ' + singular_name );
		$('[name="labels[add_new]"]').val( translations_js.add_ct + ' ' + singular_name );
		$('[name="labels[edit_item]"]').val( translations_js.edit_ct + ' ' + singular_name );
		$('[name="labels[update_item]"]').val( translations_js.update_ct + ' ' + singular_name );
		$('[name="labels[parent_item_colon]"]').val( translations_js.parent_ct + ' ' + singular_name );
	});

});