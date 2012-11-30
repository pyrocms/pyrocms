(function($) {
	$(function(){
		
		// generate a slug when the user types a title in
		pyro.generate_slug('#categories.create input[name="title"]', 'input[name="slug"]');
		
	});
})(jQuery);