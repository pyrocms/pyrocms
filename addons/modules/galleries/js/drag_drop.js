jQuery(document).ready(function($)
{
		var store_func = function() {};

		$('ul#gallery_images_list').sortable({
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

				$.post(BASE_URI + 'admin/galleries/ajax_update_order', { order: order });

			}

		}).disableSelection();
});
