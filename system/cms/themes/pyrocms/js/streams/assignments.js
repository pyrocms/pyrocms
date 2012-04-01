(function($) {
	$(function(){

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
	
				$.ajax({
					dataType: 'text',
					type: 'POST',
					data: 'order='+order+'&offset='+fields_offset+'&csrf_hash_name='+$.cookie('csrf_cookie_name'),
					url:  BASE_URL+'index.php/streams_core/ajax/update_field_order',
					success: function() {
						$('tr').removeClass('alt');
						$('tr:even').addClass('alt');
					}
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
