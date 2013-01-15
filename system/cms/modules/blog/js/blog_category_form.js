(function ($) {
	$(function () {
		// generate a slug when the user types a title in

		$("body").on("keyup", "#categories.create" ,function(e) {
			pyro.generate_slug($(this).find('input[name="title"]'), $(this).find('input[name="slug"]'));
		});
		
	});
})(jQuery);