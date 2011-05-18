jQuery(function($) {
	
	// colorbox modal window
	$('.options-modal').colorbox({
		width: '60%',
		maxHeight: '90%',
		minHeight: '50%'
	});
	
	
	$('#cboxContent').find(':submit').live('click', function(e){
		e.preventDefault();
		var post = $('#cboxContent form.options-form').serialize();
		
		$.post(SITE_URL + 'admin/themes/options/' + $('form [name="slug"]').val(), post, function(data){
				if (data.status == 'success')
				{
					pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, $.colorbox.resize);
							
				}
				else if (data.status == 'error')
				{
					pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, $.colorbox.resize);
				}
		}, 'json');
	});
});