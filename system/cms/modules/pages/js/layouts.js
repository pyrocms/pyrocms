$(function() {
	var new_page_layout_count = 1;
	var layout_id = $('#add_page_layout_variable').attr('data-layout-id');

	$('#add_page_layout_variable').click(function(e) {
		$('#page-layout-variables table tbody').append("<tr>\
			<td>\
				<input type='hidden' name='new_variable[" + new_page_layout_count + "][layout_id]' value='" + layout_id + "'>\
				<input type='text' name='new_variable[" + new_page_layout_count + "][name]' value=''>\
			</td>\
			<td>\
				<input type='text' name='new_variable[" + new_page_layout_count + "][description]' value=''>\
			</td>\
			<td>\
				<select name='new_variable[" + new_page_layout_count + "][type]'>\
					<option value='image'>Image</option>\
					<option value='text'>Text</option>\
					<option value='dropdown'>Dropdown</option>\
				</select>\
			</td>\
			<td>\
				<input type='text' name='new_variable[" + new_page_layout_count + "][options]' value=''>\
			</td>\
			<td>\
				<input type='button' class='remove_tmp_variable' value='remove'>\
			</td>\
		</tr>");
		new_page_layout_count++;
	});

	$('#page-layout-variables table tbody').on('click', '.remove_tmp_variable', function(e) {
		$(this).parent().parent().remove();
	});
});