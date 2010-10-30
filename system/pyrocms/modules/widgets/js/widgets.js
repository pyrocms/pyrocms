(function($)
{
	var add_area;
	var edit_area;
	var add_instance;
	var edit_instance;
	var sort_options;
	
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
		return false;
	}
	
	function show_add_area()
	{
		add_area.slideDown();
		return false;
	}
	
	function show_edit_area()
	{
		edit_area.slideDown();
		do_scrollto('#edit-area-box');
	}
	
	function hide_edit_area()
	{
		$('input[name="title"]', edit_area).attr('value', '');
		$('input[name="slug"]', edit_area).attr('value', '');
		edit_area.slideUp();
	}
	
	function hide_add_instance()
	{
		$('input, select, textarea', add_instance).attr('value', '');
		
		// Hide the form
		add_instance.slideUp();
	}
	
	function show_add_instance(area_slug)
	{
		my_area = '#area-' + area_slug + ' .widget-list ol';
		
		$(my_area + ' .empty-drop-item').before(add_instance.detach());
	
		$(my_area = ' .empty-drop-item').css('display', 'none');
		
		add_instance.css('display', 'block');
		
		$('#widget-wrapper .accordion').accordion({
			clearStyle: true,
			autoHeight: true
		});
		$('#widget-wrapper .accordion').accordion('resize');
		
		do_scrollto('#add-instance-box');
	}
	
	function hide_edit_instance()
	{
		$('input, select, textarea', add_instance).attr('value', '');
		
		// Hide the form
		edit_instance.slideUp();
		
		$('.accordion').accordion('resize');
		
	}
	
	function show_edit_instance(area_slug)
	{
		$('section#area-' + area_slug).after(edit_instance.detach());
		
		edit_instance.slideDown();
	}
	
	function refresh_lists()
	{
		$('.widget-list').each(function()
		{
			widget_area_slug = $(this).parent().parent().attr('id').replace(/^area-/, '');
			
			$(this).load(BASE_URI + 'index.php/widgets/ajax/list_widgets/' + widget_area_slug, function() {
				$('.widget-list ol').sortable('destroy').sortable(sort_options);
			});
		});
		
		$('.accordion').accordion('resize');
	}
	
	function do_scrollto(ele)
	{
		$('html, body').animate({
			scrollTop: $(ele).offset().top
		}, 1000);
	}
	
	// Drag/drop stuff
	
	function set_draggable()
	{
		$(".widget-box").draggable({
			revert: 'invalid',
			cursor: 'move',
			helper: 'clone',
			start: function(event, ui) {
				$(this).addClass('widget-drag');
			}
		});
	}
	
	function set_droppable()
	{
		$("#widget-wrapper .accordion-content").droppable({
			accept: '.widget-box',
			hoverClass: 'drop-hover',
			greedy: true,
			over: function(event, ui) {
				$(".accordion").accordion('resize');
				$('li.empty-drop-item').show();
			},
			out: function(event, ui) {
				$(".accordion").accordion('resize');
			},
			drop: function(event, ui) {			
				area_slug = $(this).parent().attr('id').replace(/^area-/, '');
				widget_slug = ui.draggable.attr('id').replace(/^widget-/, '');
				
				$.post(BASE_URI + 'index.php/widgets/ajax/add_widget_instance_form', { area_slug: area_slug, widget_slug: widget_slug}, function(html){
					$('form', add_instance).html(html);
					show_add_instance(area_slug);
				});
			}
		});
	}
	
	function re_accordion(active_id)
	{
		$('#widget-wrapper .accordion').accordion('destroy').accordion({
						collapsible: true,
						header: 'header',
						autoHeight: false,
						clearStyle: true,
						active: active_id
					});
	}
	
	$(function() {
		
		add_area = $('#add-area-box');
		edit_area = $('#edit-area-box');
		add_instance = $('#add-instance-box');
		edit_instance = $('#edit-instance-box');
		sort_options = {
				update: function() {
				    order = new Array();
				    $('li', this).each(function(){
					id = $(this).attr('id').replace('instance-', '');
					    order.push( id );
				    });
				    order = order.join(',');
    
				    $.post(BASE_URL + '/widgets/ajax/update_order', { order: order });
				}
		};
		
		// Widget Area add / remove --------------
		
		$('a#add-area').click(show_add_area);
		
		$('#add-area-box form').live('submit', function(e)
		{
			e.preventDefault();
			title = $('input[name="title"]', this).val();
			slug = $('input[name="slug"]', this).val();
			
			if(!title || !slug) return false;
			
			$.post(BASE_URI + 'index.php/widgets/ajax/add_widget_area', { area_title: title, area_slug: slug }, function(data) {
				$('#widget-wrapper .accordion').append(data).accordion('destroy').accordion({collapsible: true,	header: 'header', autoHeight: false });
				
				// Done, hide this form
				hide_add_area();
				
				// Re-bind the droppable areas
				set_droppable();
				
			});
		});
		
		$('#edit-area-box form').live('submit', function(e) {
			e.preventDefault();
			
			form_data = $(this).serialize();
			
			$.post(BASE_URI + 'index.php/widgets/ajax/edit_widget_area', form_data, function(data) {
				if(data.status == 'success')
				{
					hide_edit_area();
					
					//update the dom with new area slug
					$('section#area-'+data.find).attr('id', 'area-'+data.replace);
					$('section#area-'+data.replace+' h3 a').html(data.title);
					$('a#edit-area-'+data.find).attr('id', 'edit-area-'+data.replace);
					$('a#delete-area-'+data.find).attr('id', 'delete-area-'+data.replace);
					
					old_tag = $('section#area-'+data.replace+' p.tag').html();
					new_tag = old_tag.replace(data.find, data.replace);
					
					$('section#area-'+data.replace+' p.tag').html(new_tag);
				}
				else
				{
					//todo: handle errors
					hide_edit_area();
				}
			}, 'json')
		});

		$('button#widget-area-cancel').live('click', hide_add_area);
		
		//hide edit area
		$('button#widget-edit-area-cancel').live('click', function(e) {
			e.preventDefault();
			hide_edit_area();	
		});
		
		// Auto-create a short-name
		$('.new-area-title').keyup(function(){
			var new_val = $(this).val().toLowerCase().replace(/ /g, '_');
		
			$('.new-area-slug').val(new_val);
		});
		
		$('a.edit-area').live('click', function(e) {
			
			e.preventDefault();

			a_slug = this.id.replace('edit-area-', '');
			a_title = a_slug.replace('_', ' ');
			
			//append hidden form field with area-slug
			$('#edit-area-box form').append('<input type="hidden" name="area_id" value="'+a_slug+'" />');
			
			
			$('#edit-area-box input[name=title]').val(a_title);
			$('#edit-area-box input[name=slug]').val(a_slug);
			
			show_edit_area();
		});
		
		$('a.delete-area').live('click', function(e)
		{
			e.preventDefault();
			// all div.box have an id="area-slug"
			slug = this.id.replace('delete-area-', '')
			box = $('#area-' + slug);
			
			if(confirm('Are you sure you wish to delete this item?'))
			{
				$.post(BASE_URI + 'index.php/widgets/ajax/delete_widget_area', { area_slug: slug }, function()
				{
					box.slideUp(function(){ $(this).remove() });
				});
			}
		});
		
		// Widget controls -----------------------
		
		set_draggable();
		set_droppable();
		
		// Add new widget instance
		$('#add-instance-box form').live('submit', function(e)
		{
			e.preventDefault();
			widget_id = $('input[name="widget_id"]', this).val();
			widget_area_id = $('input[name="widget_area_id"]', this).val();
			title = $('input[name="title"]', this).val();
			
			form = $(this);
			
			if(!title || !widget_id || !widget_area_id) return false;
			
			var active_id = $( "#widget-wrapper .accordion" ).accordion( "option", "active" );
			
			$.post(BASE_URI + 'index.php/widgets/ajax/add_widget_instance', form.serialize(), function(data) {
				
				if(data.status == 'success')
				{
					hide_add_instance();
					
					refresh_lists();
					
					re_accordion(active_id);
					
				} else
				{
					form.html(data.form);
				}
				
			}, 'json');
		});
		
		// Edit widget instance
		$('#edit-instance-box form').live('submit', function(e)
		{
			e.preventDefault();
			title = $('input[name="title"]', this).val();
			widget_id = $('input[name="widget_id"]', this).val();
			widget_area_id = $('[name="widget_area_id"]', this).val();

			if(!title || !widget_id || !widget_area_id) return false;

			form = $(this);
			
			$.post(BASE_URI + 'index.php/widgets/ajax/edit_widget_instance', $(this).serialize(), function(data) {
				
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
		});
		
		$('button#widget-instance-cancel').live('click', function(e) {
			e.preventDefault();
			hide_add_instance();
		});

		$('.widget-area table tbody').sortable({
			handle: 'td',
			helper: function(e, ui) {
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
			},
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
				
				$.post(BASE_URI + 'index.php/widgets/ajax/update_order', { order: order });
			}
			
		});

		
		$('.accordion a.edit-instance').live('click', function(e){
			e.preventDefault();
			id = $(this).closest('li').attr('id').replace('instance-', '');
			area_slug = $(this).closest('section').attr('id').replace('area-', '');

			$.post(BASE_URI + 'index.php/widgets/ajax/edit_widget_instance_form', { instance_id: id }, function(html){
				$('form', edit_instance).html(html);
				show_edit_instance(area_slug);
			});
		});
		
		$('.accordion a.delete-instance').live('click', function(){
			
			li = $(this).closest('li');
			id = li.attr('id').replace('instance-', '');

			if(confirm('Are you sure you wish to delete this item?'))
			{
				$.post(BASE_URI + 'index.php/widgets/ajax/delete_widget_instance', { instance_id: id }, function(html){
					li.slideUp(function() { 
						$(this).remove(); 
						
						$('.accordion').accordion('resize');
					});
				});
			}

			return false;
		});
		
		// Widget Areas Accordion
		$(".accordion").accordion({
			collapsible: true,
			header: 'header',
			autoHeight: true,
			clearStyle: true
		});
		
		//Init Sortable
		$('.widget-list ol').sortable(sort_options);		
	});

})(jQuery);