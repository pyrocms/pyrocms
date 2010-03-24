(function($) {
	$(function(){

		form = $('form.crud');
		
		$('input[name="title"]', form).keyup(function(){
			$.post(BASE_URL + 'ajax/url_title', { title : $(this).val() }, function(slug){
				$('input[name="slug"]', form).val( slug );
			});
		});
		
	});
})(jQuery);