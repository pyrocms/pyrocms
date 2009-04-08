$(document).ready(function() {
	
	// Changed user dropdown list on add/edit pages
	$('select[name="user_id"]').change(function(){
		if($(this).val() > 0) {
			$('div.if-not-user').slideUp();
		} else {
			$('div.if-not-user').slideDown();
		}
	});
});