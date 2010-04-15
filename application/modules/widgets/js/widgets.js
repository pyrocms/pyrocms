(function($)
{
	var add_area;
	var add_instance;
	var edit_instance;
	
	/*
	window.onscroll = function()
	{
		// Thanks to Johan Sundström (http://ecmanaut.blogspot.com/) and David Lantner (http://lantner.net/david) 
		// for their help getting Safari working as documented at http://www.derekallard.com/blog/post/conditionally-sticky-sidebar
		if( window.XMLHttpRequest ) { // IE 6 doesn't implement position fixed nicely...
			if (document.documentElement.scrollTop > 190 || self.pageYOffset > 190) {
				
				$('#left-col').css('position', 'fixed');
				$('#left-col').css('top', '10px');
			} else if (document.documentElement.scrollTop < 200 || self.pageYOffset < 200) {
				$('#left-col').css('position', 'absolute');
				$('#left-col').css('top', '190px');
			}
		}
	}
	*/
	
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
		return false;
	}
	
	function hide_add_instance()
	{
		$('input, select, textarea', add_instance).attr('value', '');
		
		// Hide the form
		add_instance.slideUp();
	}
	
	function show_add_instance(area_slug)
	{
		$('div#area-' + area_slug).before(add_instance.detach());
		
		add_instance.slideDown();
	}
	
	function hide_edit_instance()
	{
		$('input, select, textarea', add_instance).attr('value', '');
		
		// Hide the form
		edit_instance.slideUp();
	}
	
	function show_edit_instance(area_slug)
	{
		$('div#area-' + area_slug).before(edit_instance.detach());
		
		edit_instance.slideDown();
	}
	
	function refresh_lists()
	{
		$('.widget-list').each(function(){
			widget_area_slug = $(this).closest('.widget-area').attr('id').replace(/^area-/, '');
			$(this).load(BASE_URI + 'widgets/ajax/list_widgets/' + widget_area_slug);
		});
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
			accept: '#available-widgets li',
			drop: function(event, ui) {
				area_slug = this.id.replace(/^area-/, '');
				widget_slug = ui.draggable.attr('id').replace(/^widget-/, '');
				
				$.post(BASE_URI + 'widgets/ajax/add_widget_instance_form', { area_slug: area_slug, widget_slug: widget_slug}, function(html){
					$('form', add_instance).html(html);
					show_add_instance(area_slug);
				});
			}
		});
	}
	
	$(function() {
		
		add_area = $('div#add-area-box');
		add_instance = $('div#add-instance-box');
		edit_instance = $('div#edit-instance-box');
		
		// Widget Area add / remove --------------
		
		$('a#add-area').click(show_add_area);
		
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

		$('button#widget-area-cancel').live('click', hide_add_area);
		
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
			title = $('input[name="widget_area_id"]', this).val();
			
			form = $(this);
			
			if(!title || !widget_id || !widget_area_id) return false;

			$.post(BASE_URI + 'widgets/ajax/add_widget_instance', $(this).serialize(), function(data) {
				
				if(data.status == 'success')
				{
					hide_add_instance();
					
					refresh_lists();
				}
				
				else
				{
					form.html(data.form);
				}
				
			}, 'json');
			
			return false;
		});
		
		// Edit widget instance
		$('div#edit-instance-box form').submit(function()
		{
			title = $('input[name="title"]', this).val();
			widget_id = $('input[name="widget_id"]', this).val();
			widget_area_id = $('[name="widget_area_id"]', this).val();

			if(!title || !widget_id || !widget_area_id) return false;

			form = $(this);
			
			$.post(BASE_URI + 'widgets/ajax/edit_widget_instance', $(this).serialize(), function(data) {
				
				if(data.status == 'success')
				{
					hide_edit_instance();
					
					refresh_lists();
				}
				
				else
				{
					form.html(data.form);
				}
				
			}, 'json');
			
			return false;
		});
		
		$('button#widget-instance-cancel').live('click', hide_add_instance);

		$('.widget-area table tbody').sortable({
			handle: 'td',
			helper: fixHelper,
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
				
				$.post(BASE_URI + 'widgets/ajax/update_order', { order: order });
			}
			
		});

		
		$('.widget-area table a.edit-instance').live('click', function(){
			
			id = $(this).closest('tr').attr('id').replace('instance-', '');
			area_slug = $(this).closest('div.widget-area').attr('id').replace('area-', '');

			$.post(BASE_URI + 'widgets/ajax/edit_widget_instance_form', { instance_id: id }, function(html){
				$('form', edit_instance).html(html);
				show_edit_instance(area_slug);
			});
			
			return false;
		});
		
		$('.widget-area table a.delete-instance').live('click', function(){
			
			tr = $(this).closest('tr');
			id = tr.attr('id').replace('instance-', '');

			$.post(BASE_URI + 'widgets/ajax/delete_widget_instance', { instance_id: id }, function(html){
				tr.slideUp(function() { $(this).remove(); });
			});
			
			return false;
		});
		
	});

})(jQuery);