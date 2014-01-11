(function($) {
	$(function(){

		// Generate a slug from the title
		pyro.generate_slug('input[name="title"]', 'input[name="slug"]', '_');

	});

})(jQuery);