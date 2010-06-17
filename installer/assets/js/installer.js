$(document).ready(function() {

    $('input[name=password]').keyup(function(){
        
        server   = $('input[name=hostname]').val();
        username = $('input[name=username]').val();
        password = $('input[name=password]').val();
        port     = $('input[name=port]').val();
        
        $.ajax({
            type: 'post',
            url: base_url + 'index.php/ajax/confirm_database',
            dataType: 'json',
            data: {
                server: server,
                username: username,
                password: password
            },
            success: function(response) {
                if (response.success == 'true') {
                    $('#confirm_db').html(response.message).removeClass('error').addClass('success');
                } else {
                    $('#confirm_db').html(response.message).removeClass('success').addClass('error');
                }
            }
        });
        
    });
    
    $('input[name=user_confirm_password]').keyup(function() {
        
        password                = $('input[name=user_password]').val();
        password_confirmation   = $(this).val();
        
        if (password == password_confirmation) {
            $('#confirm_pass').html('<b>Passwords Match.</b>').removeClass('error').addClass('success');
        } else {
            $('#confirm_pass').html('<b>Passwords Don\'t Match.</b>').removeClass('success').addClass('error');
        }
        
    });

});

function confirmPassword() {
    
}