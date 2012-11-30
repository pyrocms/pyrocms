(function($)
{
	$(function() {

		$('table tbody').sortable({
			handle: 'td',
			helper: 'clone',
			start: function(event, ui) {
				$('tr').removeClass('alt');
			},
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
				
				$.post(SITE_URL+'streams_core/ajax/ajax_entry_order_update', { order: order, offset: stream_offset, stream_id: stream_id, streams_module: streams_module, csrf_hash_name: $.cookie('csrf_cookie_name')}, function() {
				});
			},
			stop: function(event, ui) {
				$("tbody tr:nth-child(even)").livequery(function () {
					$(this).addClass("alt");
				});
			}
			
		}).disableSelection();
		
	});
})(jQuery);