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
})(jQuery);