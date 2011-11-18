jQuery(function($){
	var parents = 'div.tabs fieldset';
	
	$(parents +' ul').sortable({
		handle: 'span.move-handle',
		update: function() {
			$(parents +' ul li').removeClass('even');
			$(parents +' ul li:nth-child(even)').addClass('even');
			order = new Array();
			$(parents +' li').each(function(){
				order.push( this.id );
			});
			order = order.join(',');

			$.post(SITE_URL + 'admin/settings/ajax_update_order', { order: order });
		}

	});
});