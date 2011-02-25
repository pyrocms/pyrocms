jQuery(function($){
	$(".upload_colorbox").colorbox({
		width:"600",
		height:"400",
		iframe:true,
		onClosed:function(){ location.reload(); }
	});
	
});

function closeBox(){
	jQuery(function($) {
		$.colorbox.close();
	});
}