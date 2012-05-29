(function($) {
	$(function(){
		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		pyro.field_tags_input = function(form_slug)
		{
			$('#'+form_slug).tagsInput({
				autocomplete_url:'admin/keywords/autocomplete'
			});
		}

	});
})(jQuery);