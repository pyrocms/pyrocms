jQuery(document).ready(function(){
	jQuery(".delete").click(function (e) {
		e.preventDefault();
		if (confirm('Are you sure you want to delete this?')) {
			window.location = jQuery(this).attr("href");
        }
    });
});