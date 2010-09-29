$(document).ready(function() {
	
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
    
	$('input[name=user_confirm_password]').bind('keyup focus', function() {
        
        password                = $('input[name=user_password]').val();
        password_confirmation   = $(this).val();
        
        if (password == password_confirmation) {
            $('#confirm_pass').html('<b>Passwords Match.</b>').removeClass('failure').addClass('success');
        } else {
            $('#confirm_pass').html('<b>Passwords Don\'t Match.</b>').removeClass('success').addClass('failure');
        }
        
    });

});