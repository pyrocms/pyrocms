jQuery(function($){

	// Show the preview using colorbox
	$('a.colorbox').colorbox({
		'maxHeight': '100%',
		'photo': true,
		'scalePhotos': true,
		'scrolling': false,
		'opacity': 0.8,
		'onComplete': show_jcrop
	});

	// Function to add the height, width and position to the hidden fields
	function show_coords(c){
		$('#thumb_width').val(c.w);
		$('#thumb_height').val(c.h);
		$('#thumb_x').val(c.x);
		$('#thumb_y').val(c.y);
		//get the scaled image dimensions
		$('#scaled_height').val($('#cboxLoadedContent').height());
	};
	function show_jcrop(){
		$('#cboxPhoto').Jcrop({
			onSelect: show_coords,
			onChange: show_coords
		});
		
		//this shows the Options: after crop dimensions are set
		$('.crop_options').show()
	}
});