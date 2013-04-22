(function($) {
	$(function(){
		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		$('.keywords_input').each(function(i, el) {
			$(this).tagsInput({
				autocomplete_url: SITE_URL + 'admin/keywords/autocomplete'
			});
		});
	});
})(jQuery);