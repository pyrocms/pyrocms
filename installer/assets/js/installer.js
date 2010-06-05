$(document).ready(function() {

    $('input[name=password]').blur(function(){
        
        server   = $('input[name=hostname]').val();
        username = $('input[name=username]').val();
        password = $('input[name=password]').val();
        port     = $('input[name=port]').val();
        
        $.ajax({
            type: 'post',
            url: base_url + 'index.php/ajax/confirm_database',
            data: {
                server: server,
                username: username,
                password: password
            },
            success: function(response) {
                if (response == 'TRUE') {
                    $('#confirm_db').html('<b>Connected to Database Successfully.</b>').removeClass('error').addClass('success');
                } else {
                    $('#confirm_db').html('<b>Unable to Connect to Database with Specified Settings.</b>').removeClass('success').addClass('error');
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