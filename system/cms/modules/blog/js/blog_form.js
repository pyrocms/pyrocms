(function($) {
	$(function(){
		
		// generate a slug when the user types a title in
		pyro.generate_slug('input[name="title"]', 'input[name="slug"]');
		
	$.ajaxSetup({
		allowEmpty: true
	});

		$('#keywords').tagsInput({
			autocomplete_url:'admin/keywords/autocomplete'
		});
		
		// editor switcher
		$('select[name^=type]').live('change', function() {
			chunk = $(this).closest('li.editor');
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
		
		$('#blog-options-tab ul li:first a').colorbox({
			srollable: false,
			innerWidth: 600,
			innerHeight: 280,
			href: SITE_URL + 'admin/blog/categories/create_ajax',
			onComplete: function() {
				$.colorbox.resize();
				$('form#categories').removeAttr('action');
				$('form#categories').live('submit', function(e) {
					
					var form_data = $(this).serialize();
					
					$.ajax({
						url: SITE_URL + 'admin/blog/categories/create_ajax',
						type: "POST",
					        data: form_data,
						success: function(obj) {
							
							if(obj.status == 'ok') {
								
								//succesfull db insert do this stuff
								var select = 'select[name=category_id]';
								var opt_val = obj.category_id;
								var opt_text = obj.title;
								var option = '<option value="'+opt_val+'" selected="selected">'+opt_text+'</option>';
								
								//append to dropdown the new option
								$(select).append(option);
																
								// TODO work this out? //uniform workaround
								$('#blog-options-tab li:first span').html(obj.title);
								
								//close the colorbox
								$.colorbox.close();
							} else {
								//no dice
							
								//append the message to the dom
								$('#cboxLoadedContent').html(obj.message + obj.form);
								$('#cboxLoadedContent p:first').addClass('notification error').show();
							}
						}
						
						
					});
					e.preventDefault();
				});
				
			}
		});
	});
})(jQuery);