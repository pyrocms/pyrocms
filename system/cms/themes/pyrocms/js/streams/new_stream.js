jQuery(document).ready(function() {
	$('#stream_name').keyup(function() {
 	 	$('#stream_slug').val(slugify($('#stream_name').val()));
	});
});