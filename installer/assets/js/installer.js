$(function() {

	// Highlight current step in header
	$('#current').closest('li').addClass('current');

	// Add that cool orange bkg to the input that has focus
	$('input, select').bind({
		focusin: function() {
			var wrapper = $(this).closest('.input');
			$(wrapper).addClass('focus');
		},
		focusout: function() {
			var wrapper = $(this).closest('.input');
			$(wrapper).removeClass('focus');
		}
	});

	$('input[name=password]').bind('keyup focus', function() {

		$.post(base_url + 'index.php/ajax/confirm_database', {
				server: $('input[name=hostname]').val(),
				username: $('input[name=username]').val(),
				password: $('input[name=password]').val()
			}, function(data) {
				if (data.success == 'true') {
					 $('#confirm_db').html(data.message).removeClass('failure').addClass('success');
				}
				else {
					$('#confirm_db').html(data.message).removeClass('success').addClass('failure');
				}
			}, 'json'
		);

    });

	$('select#http_server').change(function(){
		if ($(this).val() == 'apache_w') {
			$.post(base_url + 'index.php/ajax/check_rewrite', '', function(data) {
				if (data !== 'enabled') {
					alert(data);
				}
			});
		}
	})

});