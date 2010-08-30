(function($) {
	$(function(){

		form = $('form.crud');
		
		$('input[name="title"]', form).keyup(function(){
			$.post(BASE_URL + '/ajax/url_title', { title : $(this).val() }, function(slug){
				$('input[name="slug"]', form).val( slug );
			});
		});
		
		$('#news-options-tab ol li:first a').colorbox({
			srollable: false,
			innerWidth: 330,
			innerHeight: 280,
			href: BASE_URL + '/admin/news/categories/create_ajax',
			onComplete: function() {
				$.colorbox.resize();
				$('form#categories').removeAttr('action');
				$('form#categories').submit(function(e) {
					
					var form_data = $(this).serialize();
					
					$.ajax({
						url: BASE_URL + '/admin/news/categories/create_ajax',
						type: "POST",
					        data: form_data,
						success: function(data) {
							
							var obj = $.parseJSON(data);
							if(obj.status == 'ok') {
								
								//succesfull db insert do this stuff
								var select = 'select[name=category_id]';
								var opt_val = obj.category_id;
								var opt_text = obj.title;
								var option = '<option value="'+opt_val+'" selected="selected">'+opt_text+'</option>';
								
								//append to dropdown the new option
								$(select).append(option);
																
								//uniform workaround
								$('#news-options-tab li:first span').html(obj.title);
								
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