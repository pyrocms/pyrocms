jQuery(function($) {
	
	// colorbox modal window
	$('.options-modal').colorbox({
		width: '60%',
		height: '90%'
	});
	
	
	$('#cboxContent').find(':submit').live('click', function(e){
		e.preventDefault();
		var post = '';
		
		if ($(this).val() == 're-index') {
			post = 'btnAction=re-index&';
		}
		post += $('#cboxContent form.options-form').serialize();
		
		$.post(SITE_URL + 'admin/themes/options/' + $('form [name="slug"]').val(), post, function(data){
				if (data.status == 'success')
				{
					pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'});
							
				}
				else if (data.status == 'error')
				{
					pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'});
				}
		}, 'json');
	});
});