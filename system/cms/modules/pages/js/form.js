(function($) {
	$(function(){

		// Generate a slug from the title
		pyro.generate_slug('input[name="title"]', 'input[name="slug"]');

		$('button[value="save"]').click(function(e) {
			e.preventDefault();
			pyroSave($.pyroAjax('admin/pages/upsert', $("#page-form").pyroForm2Obj()));
			
		});

		$('button[value="save_exit"]').click(function(e) {
			e.preventDefault();
			pyroSave($.pyroAjax('admin/pages/upsert', $("#page-form").pyroForm2Obj()));
			$.pyroRedirect('admin/pages');
		});

		// add another page chunk
		$('a.add-chunk').live('click', function(e){
			e.preventDefault();

			var html = $.pyroAjax('admin/pages/page_chunk', {}, 'post', 'text');

			$('#page-content > ul li:last').before(html);
			
			// initialize the editor
			pyro.init_ckeditor();
			
			// Update Chosen
			pyro.chosen();
		});
		
		$('a.remove-chunk').live('click', function(e) {
			e.preventDefault();
			
			var name = $(this).parent().children('input').attr('name');
			var chunk_id = name.match(/\[(.*?)\]/);

			if (chunk_id[1].length < 32)
			{
				$.pyroAjax('admin/pages/delete_chunk/' + chunk_id[1]);
			}

			$(this).closest('li.page-chunk').slideUp('slow', function(){ $(this).remove(); });
		});
		
		$('select[name^=chunk_type]').live('change', function() {
			chunk = $(this).closest('li.page-chunk');
			textarea = $('textarea', chunk);
			
			// Destroy existing WYSIWYG instance
			if (textarea.hasClass('wysiwyg-simple') || textarea.hasClass('wysiwyg-advanced')) 
			{
				textarea.removeClass('wysiwyg-simple');
				textarea.removeClass('wysiwyg-advanced');
					
				var instance = CKEDITOR.instances[textarea.attr('id')];
			    instance && instance.destroy();
			}
		
			// Set up the new instance
			textarea.addClass(this.value);
			
			pyro.init_ckeditor();
		});
		
	});
	
})(jQuery);

function pyroSave(reply) {
	// remove any dynamic alerts that might be on the screen
	jQuery(".alert").remove();

	if (reply.valid)
	{
		jQuery("#page-form").pyroFormHidden('id',reply.id);
		jQuery("#page-form").pyroFormHidden('old_slug',reply.old_slug);

		var ary = reply.replace;
		for (a in ary)
		{
			jQuery('[name="chunk_body[' + ary[a][0] + ']"]').attr('name','chunk_body[' + ary[a][1] + ']');
			jQuery('[name="chunk_slug[' + ary[a][0] + ']"]').attr('name','chunk_slug[' + ary[a][1] + ']');
			jQuery('[name="chunk_type[' + ary[a][0] + ']"]').attr('name','chunk_type[' + ary[a][1] + ']');
		}

		// is valid so show saved notice after the cancel button
		jQuery(".btn.gray.cancel").after(reply.msg);
		jQuery(".save_alert").delay(3000).slideUp(500);
	}
	else
	{
		// is not valid so show errors at the top of the page
		jQuery("#content-body").before(reply.msg);
		// let's scroll to the top of the page so they can see the msg
		jQuery('html body').animate({scrollTop:1}, 100);
	}
	
}
