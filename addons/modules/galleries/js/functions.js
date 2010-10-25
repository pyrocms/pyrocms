
jQuery(function($) {
	
	$(".upload_colorbox").colorbox({
		width:"500",
		height:"510",
		iframe:true,
		onClosed:function(){ location.reload(); }
	});
	
});

function closeBox()
{
	jQuery(function($) {
		$.colorbox.close();
	});
}