(function($) {
	$(function(){

		form = $('form.crud');
		
		$('input[name="title"]', form).keyup(function(){
		
			slug = $('input[name="slug"]', form);
			
			if(slug.val() == 'home' || slug.val() == '404')
			{
				return;
			}
			
			$.post(BASE_URI + 'index.php/ajax/url_title', { title : $(this).val() }, function(new_slug){
				slug.val( new_slug );
			});
		});
		
		//compare revisions
		$('#btn_compare_revisions').click(function() {
			//first revision
			first = $('#compare_revision_1').val();
			second = $('#compare_revision_2').val();
			
			$.colorbox({
				width: "85%",
				height: "85%",
				href: BASE_URI + 'index.php/admin/pages/compare/' + first + '/' + second
			});
		});
		
		//view revision
		$('#btn_preview_revision').click(function() {
			revision = $('#use_revision_id').val();
			
			$.colorbox({
				width: "85%",
				height: "85%",
				href: BASE_URI + 'index.php/admin/pages/preview_revision/' + revision
			})
		});
		
	});
})(jQuery);
