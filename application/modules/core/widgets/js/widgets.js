(function($)
{
	function set_draggable()
	{
		$("#available-widgets li").draggable({
			revert: 'invalid',
			cursor: 'move',
			helper: 'clone'
		});
	}
	
	function set_droppable()
	{
		$(".widget-area").droppable({
			drop: function(event, ui) {
				alert('dropped!');
			}
		});
	}
	
	$(function() {
		
		// Widget Area add / remove --------------
		
		$('a#add-area').click(function()
		{
			$('div#add-area-box').slideDown('slow');
			return false;
		});
		
		$('div#add-area-box form').submit(function()
		{
			title = $('input[name="title"]', this);
			slug = $('input[name="slug"]', this);
			
			if(!title.val() || !slug.val()) return false;
			
			$.post(BASE_URI + 'widgets/ajax/add_widget_area', {
				area_title: title.val(), area_slug: slug.val()
			}, function(data) {
				$('div#mid-col').append(data).children('div.box:hidden').slideDown();
				
				title.val('');
				slug.val('');
				
				// Hide the form
				$('div#add-area-box').slideUp();
				
				// Re-bind the droppable areas
				set_droppable();
			});
			
			return false;
		});

		$('a.delete-area').live('click', function()
		{
			// all div.box have an id="area-slug"
			slug = this.id.replace('delete-area-', '')
			box = $('div#area-' + slug);
			
			if(confirm(''))
			{
				$.post(BASE_URI + 'widgets/ajax/delete_widget_area', { area_slug: slug }, function()
				{
					box.slideUp(function(){ $(this).remove() });
				});
			}
			
			return false;
		});
		
		// Widget controls -----------------------
		
		set_draggable();
		set_droppable();
	});


})(jQuery);