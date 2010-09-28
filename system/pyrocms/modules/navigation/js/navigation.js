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
		
	});

	$(function() {
		// Show the list of links for the selected link group
		$('select[name="navigation_group_id"]').change(function() {
			$.ajax({
				dataType: 'json',
				type: 'post',
				cache: false,
				url: 'admin/navigation/ajax_get_navigation_links',
				data: {navigation_group_id: $(this).val()},
				success: function(response){
							$select = $('select[name="parent_link_id"]')
							$select.val('-1');
							$select.html('');
							$('<option value="-1">-- TOP LEVEL --</option>').appendTo($select);
							 $.each(response, function(key, value){
							 	$('<option value="'+key+'">'+value+'</option>').appendTo($select);
							 });
						 }
			});
		});
	});
})(jQuery);
