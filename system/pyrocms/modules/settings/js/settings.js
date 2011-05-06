jQuery(function($){
	var parents = '.box-container div.tabs fieldset';
	
	$(parents +' ol').sortable({
		handle: 'span.move-handle',
		update: function() {
			$(parents +' ol li').removeClass('even');
			$(parents +' ol li:nth-child(even)').addClass('even');
			order = new Array();
			$(parents +' li').each(function(){
				order.push( this.id );
			});
			order = order.join(',');

			$.post(SITE_URL + 'admin/settings/ajax_update_order', { order: order });
		}

	});
});