// (function($){

// 	function get_template(field_id, input_id){
// 		$('#data-type-settings').empty();
// 		dataType = $('#select-data-type').val();
// 		// if(!dataArr){
// 			// default values
// 			var dataArr = {
// 				values: '',
// 				required: 'false',
// 				format: 'mm/dd/yy',
// 				image_size: '',
// 				validation: '',
// 				changeMonth: 'true',
// 				changeYear: 'true',
// 			};
// 		// }
// 		if(field_id){
// 			$.ajax({
// 				url: ajaxurl,
// 				async: false,
// 				data: {
// 					action: 'get_meta_field_settings',
// 					field_id: field_id,
// 					input_id: input_id,					
// 				}
// 			}).done(function(responce){
// 				// console.log(responce);
// 				$.extend(dataArr, $.parseJSON(responce));
// 			});
// 		}		

// 		$('#'+dataType)
// 			.clone()
// 			.tmpl(dataArr)
// 			.appendTo('#data-type-settings');	

// 		$('<input/>', {		    		    
// 		    type: 'hidden',
// 		    name: 'field-id',
// 		    val: $('#select-data-type option:selected').data('alias')
// 		}).appendTo('#data-type-settings');
// 	}

// 	get_template(
// 		$('#select-data-type option:selected').data('field'),
// 		$('#select-data-type option:selected').data('alias')
// 	);

// 	$('#post-body-content').on('change', '#select-data-type', function(e){		
// 		get_template();
// 	});

// })(jQuery);