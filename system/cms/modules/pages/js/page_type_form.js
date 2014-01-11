(function($) {
	$(function(){

		// Generate a slug from the title
		Pyro.GenerateSlug('input[name="title"]', 'input[name="slug"]', '_');

	});

})(jQuery);