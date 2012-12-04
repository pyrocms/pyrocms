jQuery(document).ready(function ($) {

	var updateEngineFields = function(enabled_driver) {
		$('section#db-settings .input').each(function() {
			$input = $(this);
			if ($input.hasClass(enabled_driver)) $input.show();
			else $input.hide();
		});
	};

	// If any are checked then show the right fields
	updateEngineFields($('section#db-driver input[name=db_driver]:checked').val());

	// Show relevant input options for DB driver
	$('section#db-driver input[name=db_driver]').change(function(){ updateEngineFields($(this).val()); });

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

	$('input[name=password]').bind('keyup focus', function() {

		$.post(base_url + 'index.php/ajax/confirm_database', {
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
	$("input#password").complexify({}, function (valid, complexity) {
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
