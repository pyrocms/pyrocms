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

			$.post(SITE_URL + 'admin/galleries/ajax_update_order', { order: order });
		}

	}).disableSelection();

	
	// update the folder images preview when folder selection changes
	$('select#folder_id').change(function(){

		$.get(SITE_URL + 'admin/galleries/ajax_select_folder/' + $(this).val(), function(data) {

			if (data) {
				$('input[name=title]').val(data.name);
				$('input[name=slug]').val(data.slug);
				
				// remove images from last selection
				$('#gallery_images_list').empty();
				$('#gallery_thumbnail optgroup, .images-manage').remove();
				
				if (data.images) {
					
					$('#gallery_thumbnail').append(
						'<optgroup label="Thumbnails">'+
							'<option selected value="0">No Thumbnail</option>'+
						'</optgroup>'
					);
					
					$.each(data.images, function(i, image){
						$('#gallery_images_list').append(
						'<li>' +
							'<img src="' + SITE_URL + 'files/thumb/' + image.id + '" alt="' + image.name + '" title="Title: ' + image.name + ' -- Caption: ' + image.description + '"' +
						'</li>'
						);
						
						$('#gallery_thumbnail optgroup[label="Thumbnails"]').append(
						'<option value="' + image.id + '">' + image.name + '</option>'
						);
					});
					$('.images-placeholder').slideDown();
				}
			}
			else {
				$('input[name=title]').val('');
				$('input[name=slug]').val('');
				$('.images-placeholder').hide();
			}
			$.uniform.update('#gallery_thumbnail')

		}, 'json');
	});
});
