(function($)
{
	$(function() {

		// Pick a rule type, show the correct field
		$('input[name="link_type"]').change(function() {
			$('#navigation-' + $(this).val())
			
			// Show only the selected type
			.show().siblings().hide()
			
			// Reset values when switched
			.find('input:not([value="http://"]), select').val('');
		});
		

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
				
				$.post(BASE_URI + 'index.php/admin/navigation/ajax_update_positions', { order: order }, function() {
					$('tr').removeClass('alt');
					$('tr:even').addClass('alt');
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