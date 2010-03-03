(function($)
{
	var add_area;
	var add_instance;
	
	function hide_add_area()
	{
		$('input[name="title"]', add_area).attr('value', '');
		$('input[name="slug"]', add_area).attr('value', '');
		
		// Hide the form
		add_area.slideUp();
	}
	
	function show_add_area()
	{
		add_area.slideDown();
	}
	
	function hide_add_instance()
	{
		$('input, select, textarea', add_instance).attr('value', '');
		
		// Hide the form
		add_instance.slideUp();
	}
	
	function show_add_instance()
	{
		add_instance.slideDown();
	}
	
	// Drag/drop stuff
	
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
				area_slug = this.id.replace(/^area-/, '');
				widget_slug = $(event.originalEvent.originalTarget).parent('li').attr('id').replace(/^widget-/, '');
				
				$.post(BASE_URI + 'widgets/ajax/show_widget_instance_form', { area_slug: area_slug, widget_slug: widget_slug}, function(html){
					$('form', add_instance).html(html);
					show_add_instance();
				});
			}
		});
	}
	
	$(function() {
		
		add_area = $('div#add-area-box');
		add_instance = $('div#add-instance-box');
		
		// Widget Area add / remove --------------
		
		$('a#add-area').click(function()
		{
			$('div#add-area-box').slideDown('slow');
			return false;
		});
		
		$('div#add-area-box form').submit(function()
		{
			title = $('input[name="title"]', this).val();
			slug = $('input[name="slug"]', this).val();
			
			if(!title || !slug) return false;
			
			$.post(BASE_URI + 'widgets/ajax/add_widget_area', { area_title: title, area_slug: slug }, function(data) {
				$('div#mid-col').append(data).children('div.widget-area:hidden').slideDown();
				
				// Done, hide this form
				hide_add_area();
				
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
		
		// Add new widget instance
		$('div#add-instance-box form').submit(function()
		{
			widget_id = $('input[name="widget_id"]', this).val();
			widget_area_id = $('input[name="widget_area_id"]', this).val();
			widget_area_slug = $('input[name="widget_area_slug"]', this).val();
			title = $('input[name="widget_area_id"]', this).val();
			
			if(!title || !widget_id || !widget_area_id) return false;

			$.post(BASE_URI + 'widgets/ajax/add_widget_instance', $(this).serialize(), function() {
				hide_add_instance();
				
				$('#area-' + widget_area_slug + ' #widget-list').load(BASE_URI + 'widgets/ajax/list_widgets/' + widget_area_slug);
			});
			
			return false;
		});
	});


})(jQuery);