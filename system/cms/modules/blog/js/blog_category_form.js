(function ($) {
	$(function () {
		
		// generate a slug when the user types a title in
		pyro.generate_slug('input[name="title"]', 'input[name="slug"]');
		
	});
})(jQuery);