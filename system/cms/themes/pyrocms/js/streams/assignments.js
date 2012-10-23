(function($) {
	$(function(){

		$('table tbody').sortable({
			handle: '.handle',
			axis: 'y',
			placeholder: 'dropzone',
			start: function(e, ui) {
				$('tr').removeClass('alt');
				ui.item.children().each(function(i, v) {
					$('<td></td>').width($(this).width()).appendTo(ui.placeholder);
				});
			},
			helper: function(e, tr) {
				var $originals = tr.children();
				var $helper = tr.clone();
				$helper.children().each(function(index)
				{
					$(this).width($originals.eq(index).width())
				});
				return $helper;
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
					data: 'order='+order+'&offset='+fields_offset+'&csrf_hash_name='+$.cookie(pyro.csrf_cookie_name),
					url:  SITE_URL+'streams_core/ajax/update_field_order',
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
