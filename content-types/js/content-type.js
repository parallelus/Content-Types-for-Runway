(function($){

	//main
	$('#save-button-main').click(function(e){console.log("save-main");
		$('#update-post-type-main').submit();
	});

	// add post-type
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

	$('#save-button-post-type').click(function(e){
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

	// add-taxonomy
	$('#save-button-taxonomy').click(function(e){
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

	// add-field
	$('#save-button-field').click(function(e){
		// var headerTitle = $('#header-title').val().trim();
		name = $('#name').val().trim()

		if(name == ''){
			$('#name').css('border-color', 'Red');
		}
		else{
			$('#name').css('border-color', '');
		}

		if( name ){
			$('#add-field').submit();
		}
	});



	if($('.permissionSetCustomValues').length) {
        $("#permission_1_level").val('same-as-posts').attr('selected',true);
        permissionSetCustomValues();
	}

	if($('.rewriteSetCustomValues').length) {
        $("#rewrite_1_level").val('default').attr('selected',true);
        rewriteSetCustomValues();
	}

	if($('.querySetCustomValues').length) {
        $("#query_var_1_level").val('post-type').attr('selected',true);
        querySetCustomValues();
	}

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

	if( $("#query_var_1_level").val() == 'custom' )
		$("#query_var_custom_set").show();
	else
		querySetValues( $("#query_var_1_level").val() );

	$("#query_var_1_level").change(function() {
		if( $("#query_var_1_level").val() == 'custom' )
			$("#query_var_custom_set").show();
		else
			querySetValues( $("#query_var_1_level").val() );
	});

	function permissionSetCustomValues() {
		$("#permission_read_posts").val('read_posts');
		$("#permission_read_private_posts").val('read_private_posts');
		$("#permission_publish_posts").val('publish_posts');
		$("#permission_delete_post").val('delete_post');
		$("#permission_edit_post").val('edit_post');
		$("#permission_edit_posts").val('edit_posts');
		$("#permission_edit_others_posts").val('edit_others_posts');
	};

	function permissionSetValues(arg) {                         // set defaults for same as post & same as page
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

	function rewriteSetCustomValues() {
		$("#rewrite_url_slug").val('item');
		$("#rewrite_with_front").val(true);
		$("#rewrite_pages").val(true);
		$("#rewrite_feeds").val(true);
	};

	function rewriteSetValues(arg) {
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

	function querySetCustomValues() {
		$("#query_var_custom").val('item');
	};

	function querySetValues(arg) {
		if( arg == 'post-type') {
			$("#query_var_custom").val('item');

			$("#query_var_custom_set").hide();
		}
	};

})(jQuery);