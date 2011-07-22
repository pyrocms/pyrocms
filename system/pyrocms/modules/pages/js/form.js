(function($) {
	$(function(){

		form = $('form.crud');

		$('input[name="title"]', form).keyup($.debounce(300, function(){

			slug = $('input[name="slug"]', form);

			if(slug.val() == 'home' || slug.val() == '404')
			{
				return;
			}

			$.post(SITE_URL + 'ajax/url_title', { title : $(this).val() }, function(new_slug){
				slug.val( new_slug );
			});
		}));

		// add another page chunk
		$('a.add-chunk').live('click', function(e){
			e.preventDefault();
	
			// The date in hexdec
			key = Number(new Date()).toString(16);
			
			$('#page-content ul li:last').before('<li class="page-chunk">' +
				'<input type="text" name="chunk_slug[' + key + ']"/>' +
				'<select name="chunk_type[' + key + ']" class="no-uniform">' +
				'<option value="html">html</option>' +
				'<option value="wysiwyg-simple">wysiwyg-simple</option>' +
				'<option selected="selected" value="wysiwyg-advanced">wysiwyg-advanced</option>' +
				'</select>' +
				'<textarea class="wysiwyg-advanced" rows="50" cols="90" name="chunk_body[' + key + ']"></textarea>' +
			'</li>');
			
			// initialize the editor using the view from fragments/wysiwyg.php
			pyro.init_ckeditor();
		});
		
		$('a.remove-chunk').live('click', function(e){
			e.preventDefault();
			
			$(this).closest('li.page-chunk').slideUp('slow', function(){ $(this).remove(); });
		});
	});
})(jQuery);
