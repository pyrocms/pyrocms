(function($) {

	$(function(){

	pyro.generate_slug('input[name="field_name"]', 'input[name="field_slug"]');

	$('#field_type').change(function() {

		var field_type = $(this).val();

		$.ajax({
			dataType: 'text',
			type: 'POST',
			data: 'data='+field_type+'&csrf_hash_name='+$.cookie('csrf_cookie_name'),
			url:  BASE_URL+'index.php/streams_core/ajax/build_parameters',
			success: function(returned_html){
				$('.streams_param_input').remove();
				$('.form_inputs > ul').append(returned_html);
				pyro.chosen();
			}
		});

	});

	});

})(jQuery);
