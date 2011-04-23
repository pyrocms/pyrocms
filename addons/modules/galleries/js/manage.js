jQuery(function($){
	var store_func = function(){};

	$('.images-manage ul#gallery_images_list').sortable({
		handle: 'img',
		start: function(event, ui) {
			ui.helper.find('a').unbind('click').die('click');
		},
		update: function() {
			order = new Array();
			$('li', this).each(function(){
				order.push( $(this).find('input[name="action_to[]"]').val() );
			});
			order = order.join(',');

			$.post(BASE_URL + 'index.php/admin/galleries/ajax_update_order', { order: order });
		}

	}).disableSelection();

	
	// update the folder images preview when folder selection changes
	$('select#folder_id').change(function(){

		$.get(BASE_URL + 'index.php/admin/galleries/ajax_select_folder/' + $(this).val(), function(data) {

			if (data) {
				$('input[name=title]').val(data.name);
				$('input[name=slug]').val(data.slug);
				
				// remove images from last selection
				$('#gallery_images_list').empty();
				
				// remove the original thumbnail select and images if user is on the manage page
				$('.thumbnail-manage').remove();
				$('.images-manage').remove();
				
				if (data.images) {
					
					$.each(data.images, function(i, image){
						$('#gallery_images_list').append(
						'<li>' +
							'<img src="' + BASE_URL + 'index.php/files/thumb/' + image.id + '" alt="' + image.name + '" title="Title: ' + image.name + ' -- Caption: ' + image.description + '"' +
						'</li>'
						);
						
						$('#gallery_thumbnail optgroup').append(
						'<option value="' + image.id + '">' + image.name + '</option>'
						);
					});
					$('.thumbnail-placeholder, .images-placeholder').slideDown();
				}
			}
			else {
				$('input[name=title]').val('');
				$('input[name=slug]').val('');
				$('.thumbnail-placeholder, .images-placeholder').hide();
			}

		}, 'json');
	});
});
