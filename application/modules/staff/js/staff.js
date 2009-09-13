function preview(img, selection) { 
	var scaleX = staffWidth / selection.width; 
	var scaleY = staffHeight / selection.height; 
	
	$('#thumbnail_preview').css({ 
		width: Math.round(scaleX * imageDataWidth) + 'px', 
		height: Math.round(scaleY * imageDataHeight) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

(function ($) { 
	
	$(function() {
	
		// Changed user dropdown list on add/edit pages
		$('select[name="user_id"]').change(function(){
			if($(this).val() > 0) {
				$('div.if-not-user').slideUp();
			} else {
				$('div.if-not-user').slideDown();
			}
		});
										
		$('#save_thumb').click(function() {
			var x1 = $('#x1').val();
			var y1 = $('#y1').val();
			var x2 = $('#x2').val();
			var y2 = $('#y2').val();
			var w = $('#w').val();
			var h = $('#h').val();
			if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
				alert(productImageNoSelection);
				return false;
			}else{
				return true;
			}
		});
	
	});

	$(window).load(function () { 
		$('#thumbnail').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview }); 
	});

})(jQuery); 