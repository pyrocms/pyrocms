jQuery(document).ready(function ($) {

	// Add that cool orange bkg to the input that has focus
	$('input, select').bind({
		focusin: function () {
			$(this)
				.closest('.input')
				.addClass('block-message pyro');
		},
		focusout: function () {
			$(this)
				.closest('.input')
				.removeClass('block-message pyro');
		}
	});

	$('input[name="database"]').on('keyup', function () {
		var $db = $('input[name=database]');
		// check the database name for correct alphanumerics
		if ($db.val().match(/[^A-Za-z0-9_-]+/)) {
			$db.val($db.val().replace(/[^A-Za-z0-9_-]+/, ''));
		}
	});

	$('input[name=password]').on('keyup focus', function () {

		$.post(base_url + 'index.php/ajax/confirm_database', {
				database: $('input[name=database]').val(),
				create_db: $('input[name=create_db]').is(':checked'),
				server: $('input[name=hostname]').val(),
				port: $('input[name=port]').val(),
				username: $('input[name=username]').val(),
				password: $('input[name=password]').val()
			}, function (data) {
				var $confirm_db = $('#confirm_db');
				if (data.success === true) {
					$confirm_db
						.html(data.message)
						.removeClass('block-message error')
						.addClass('block-message success');
				} else {
					$confirm_db
						.html(data.message)
						.removeClass('block-message success')
						.addClass('block-message error');
				}
			}, 'json'
		);

	});

	$('select#http_server').change(function () {
		if ($(this).val() == 'apache_w') {
			$.post(base_url + 'index.php/ajax/check_rewrite', '', function (data) {
				if (data !== 'enabled') {
					alert(data);
				}
			});
		}
	});

	// Password Complexity
	$('#user_password').complexify({}, function (valid, complexity) {
		var $progress = $('#progress');
		if (!valid) {
			$progress
				.css({ 'width': complexity + '%' })
				.removeClass('progressbarValid')
				.addClass('password-weak');
		} else {
			$progress
				.css({ 'width': complexity + '%' })
				.removeClass('progressbarInvalid')
				.addClass('password-strong');
		}
		$('#complexity').html(Math.round(complexity) + '%');
	});

});
