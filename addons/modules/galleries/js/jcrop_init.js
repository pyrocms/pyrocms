jQuery(document).ready(function($)
{
	// Turn the thumbnail URL into a full sized image URL
	var image_url 	= $('#current_thumbnail').attr('src');
	image_url		= image_url.replace('/thumbs/', '/full/');
	image_url		= image_url.replace('_thumb','');

	$('#thumbnail_actions').change(function()
	{
		// Get the specified action
		var action = $(this).val();

		if (action == 'crop')
		{
			// Show the preview using fancybox
			$.colorbox({
				'html': '<div><img src="' + image_url + '" id="jcrop_thumbnail" /></div>',
				'overlayOpacity': 0.8,
				'hideOnContentClick': false,
				'onComplete': show_jcrop
			});
		}
	});

	// Function to add the height, width and position to the hidden fields
	function show_coords(c)
	{
		$('#thumb_width').val(c.w);
		$('#thumb_height').val(c.h);
		$('#thumb_x').val(c.x);
		$('#thumb_y').val(c.y);
	};
	function show_jcrop()
	{
		$('#jcrop_thumbnail').Jcrop(
		{
			onSelect: show_coords,
			onChange: show_coords
		});
	}
});
