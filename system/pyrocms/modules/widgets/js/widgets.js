(function($){$(function(){

	pyro.widgets = {
		add_area		: null,
		edit_area		: null,
		add_instance	: null,
		edit_instance	: null,

		init: function(){
			$.extend(true, pyro.widgets, {
				add_area 		: $('#add-area-box'),
				edit_area		: $('#edit-area-box'),
				add_instance	: $('#add-instance-box'),
				edit_instance	: $('#edit-instance-box'),
				sort_options	: {
					cancel: '.no-sortable,:input,option',
					update: function(){
						var order = [];

						$('li', this).each(function(){
							order.push($(this).attr('id').replace(/^instance-/, ''));
						});

						$.post(SITE_URL + 'widgets/ajax/update_order', { order: order.join(',') });
					}
				}
			});

			pyro.widgets.set_draggable();
			pyro.widgets.set_droppable();

			// Widget Areas Accordion
			$(".accordion").accordion({
				collapsible	: true,
				header		: 'header',
				autoHeight	: true,
				clearStyle	: true
			});

			//Init Sortable
			$('.widget-list ol').sortable(pyro.widgets.sort_options);

			$('#add-area').click(function(e){
				e.preventDefault();

				pyro.widgets.toogle_area('show', 'add');
			});

			$('.edit-area').live('click', function(e){
				e.preventDefault();

				var a_slug	= this.id.replace(/^edit-area-/, ''),
					a_title	= $(this).attr('data-title');

				$('#edit-area-box form').append('<input type="hidden" name="area_id" value="'+a_slug+'" />');

				$('#edit-area-box input[name=title]').val(a_title);
				$('#edit-area-box input[name=slug]').val(a_slug);

				pyro.widgets.toogle_area('show', 'edit');
			});

			$('#widget-area-cancel, #widget-edit-area-cancel').live('click', function(e){
				e.preventDefault();

				pyro.widgets.toogle_area('hide', (this.id.indexOf('edit') !== -1 ? 'edit': 'add'));
			});

			// Auto-create a short-name
			$('input[name="title"]').live('keyup', $.debounce(350, function(e){
				var form = $(this).parents('form');
				$.post(SITE_URL + 'ajax/url_title', { title : $(this).val() }, function(slug){
					$('input[name="slug"]', form).val(slug);
				});
			}));

			$('#add-area-box form').live('submit', function(e){
				e.preventDefault();

				var title	= $('input[name="title"]', this).val();
				var slug	= $('input[name="slug"]', this).val();
				
				if ( ! (title || slug)) return;
				
				$.post(SITE_URL + 'widgets/ajax/add_widget_area', { area_title: title, area_slug: slug }, function(data){

					$('#widget-areas .accordion')
						.append(data)
						.accordion('destroy')
						.accordion({ collapsible: true,	header: 'header', autoHeight: false });
					
					// Open the newly appended area
					$('.widget-area-header:last').click();
					
					// Done, hide this form
					pyro.widgets.toogle_area('hide', 'add');

					// Re-bind the droppable areas
					pyro.widgets.set_droppable();
					
				}, 'html');
			});

			$('#edit-area-box form').live('submit', function(e){
				e.preventDefault();

				var form_data = $(this).serialize();

				$.post(SITE_URL + 'widgets/ajax/edit_widget_area', form_data, function(data){

					pyro.widgets.toogle_area('hide', 'edit');

					if (data.status == 'success'){

						//update the dom with new area slug
						$('section#area-'+data.find).attr('id', 'area-'+data.replace);
						$('section#area-'+data.replace+' h3 a').html(data.title);
						$('a#edit-area-'+data.find).attr({'id': 'edit-area-'+data.replace, 'data-title': data.title});
						$('a#delete-area-'+data.find).attr('id', 'delete-area-'+data.replace);

						var old_tag = $('section#area-'+data.replace+' p.tag').html(),
							new_tag = old_tag.replace(data.find, data.replace);

						$('section#area-'+data.replace+' p.tag').html(new_tag);
					}

					//todo: handle errors

				}, 'json')
			});

			$('a.button.delete-area').live('click-confirmed', function(e){
				e.preventDefault();
				$.data(this, 'stop-click', true);

				var slug	= this.id.replace(/^delete-area-/, ''),
					box		= $('#area-' + slug);

				$.post(SITE_URL + 'widgets/ajax/delete_widget_area', { area_slug: slug }, function(){
					box.slideUp(function(){
						$(this).remove()
					});
				});
			});

			// Add new widget instance
			$('#add-instance-box form').live('submit', function(e){
				e.preventDefault();

				var widget_id = $('input[name="widget_id"]', this).val(),
					widget_area_id = $('input[name="widget_area_id"]', this).val(),
					title = $('input[name="title"]', this).val(),

					form = $(this),

					active_id = $( "#widget-areas .accordion" ).accordion( "option", "active" );

				if ( ! (title || widget_id || widget_area_id)) return false;
		
				$.post(SITE_URL + 'widgets/ajax/add_widget_instance', form.serialize(), function(data){
			
					if (data.status == 'success')
					{
						pyro.widgets.hide_instance('add');
						pyro.widgets.refresh_lists();
						pyro.widgets.re_accordion(active_id);
					}
					else
					{
						form.html(data.form);
					}

				}, 'json');
			});

			// Edit widget instance
			$('#edit-instance-box form').live('submit', function(e){
				e.preventDefault();

				var title			= $('input[name="title"]', this).val(),
					widget_id		= $('input[name="widget_id"]', this).val(),
					widget_area_id	= $('[name="widget_area_id"]', this).val(),

					form = $(this);

				if ( ! (title || widget_id || widget_area_id)) return false;

				$.post(SITE_URL + 'widgets/ajax/edit_widget_instance', form.serialize(), function(data){
			
					if (data.status == 'success')
					{
						pyro.widgets.hide_instance('edit');
						pyro.widgets.refresh_lists();
					}
					else
					{
						form.html(data.form);
					}
			
				}, 'json');
			});

			$('#widget-instance-cancel').live('click', function(e){
				e.preventDefault();

				pyro.widgets.hide_instance(['add','edit']);
				pyro.widgets.re_accordion();
			});

			$('a.edit-instance').live('click', function(e){
				e.preventDefault();

				var id			= $(this).closest('li').attr('id').replace('instance-', ''),
					area_slug	= $(this).closest('section').attr('id').replace('area-', '');

				$.post(SITE_URL + 'widgets/ajax/edit_widget_instance_form', { instance_id: id }, function(html){
					// Insert the form into the edit_instance li node
					$('form', pyro.widgets.edit_instance).html(html);

					pyro.widgets.show_edit_instance(area_slug, id);
				});
			});

			$('a.delete-instance').live('click-confirmed', function(e){
				e.preventDefault();
				$.data(this, 'stop-click', true);

				var li	= $(this).closest('li'),
					id	= li.attr('id').replace('instance-', '');

				$.post(SITE_URL + 'widgets/ajax/delete_widget_instance', { instance_id: id }, function(html){
					li.slideUp(function() { 
						$(this).remove();
						$("#widget-areas .accordion").accordion("resize");
					});
				});
			});
		},

		toogle_area: function(display, action){

			if (display == 'show')
			{
				pyro.widgets[action+'_area'].slideDown(function(){
					pyro.widgets.scroll_to(this);
				});
			} else {
				pyro.widgets[action+'_area'].slideUp(function(){
					$('input[name="title"]', this).attr('value', '');
					$('input[name="slug"]', this).attr('value', '');
				});
			}
		},

		scroll_to: function(ele){
			$('html, body').animate({
				scrollTop: $(ele).offset().top
			}, 1000);
		},

		show_add_instance: function(area_slug){
			var my_area = '#area-' + area_slug + ' ol';

			$(my_area).append(pyro.widgets.add_instance.detach());
			$('.widget-list .empty-drop-item').css('display', 'none');

			pyro.widgets.add_instance.css('display', 'block');

			$('#widget-areas .accordion').accordion('resize');

			pyro.widgets.scroll_to(pyro.widgets.add_instance);
		},

		show_edit_instance: function(area_slug, id){
			var my_area = '#area-' + area_slug + ' ol';

			$(my_area + " #instance-"+ id).after(pyro.widgets.edit_instance.detach().removeClass('hidden'));
			$('.widget-list .empty-drop-item').css('display', 'none');

			pyro.widgets.edit_instance.css('display', 'block').slideDown(function(){
				setTimeout(function(){
					$('#widget-areas .accordion').accordion('resize');
				}, 10);
			});
		},

		hide_instance: function(action){

			if (action instanceof Array)
			{
				for (i in action)
				{
					pyro.widgets.hide_instance(action[i]);
				}
				return;
			}

			// Hide the form
			pyro.widgets[action + '_instance'].slideUp(function(){

				// Clean up
				$('input, select, textarea', this).attr('value', '');
				$('#'+action+'-instance-box').detach();
				$('#widget-list .accordion').accordion('resize');
			});
		},

		refresh_lists: function(){
			$('.widget-list').each(function(){
				var widget_area_slug = $(this).parent().parent().attr('id').replace(/^area-/, '');

				$(this).load(SITE_URL + 'widgets/ajax/list_widgets/' + widget_area_slug, function(){
					$('.widget-list ol').sortable('destroy').sortable(pyro.widgets.sort_options);
					$('.accordion').accordion('resize');
				});
			});
		},

		re_accordion: function(active_id){
			$('#widget-areas .accordion').accordion('destroy').accordion({
				collapsible: true,
				header: 'header',
				autoHeight: false,
				clearStyle: true,
				active: active_id
			});
		},

		set_droppable: function(){
			$("#widget-areas .accordion-content").droppable({
				hoverClass : 'drop-hover',
				accept : '.widget-box',
				greedy : true,
				over : function(event, ui){
					$(".accordion").accordion('resize');
					$('li.empty-drop-item').show();
				},
				out : function(event, ui){
					$("li.emptydrop-item").hide();
					$(".accordion").accordion('resize');
				},
				drop : function(event, ui){
					var area_slug	= $(this).parent().attr('id').replace(/^area-/, ''),
						widget_slug	= ui.draggable.attr('id').replace(/^widget-/, '');

					$.post(SITE_URL + 'widgets/ajax/add_widget_instance_form', { area_slug: area_slug, widget_slug: widget_slug}, function(data){
						if (data.status == 'success')
						{
							$('form', pyro.widgets.add_instance).html(data.html);

							pyro.widgets.show_add_instance(area_slug);
						}
					}, 'json');
				}
			});
		},

		set_draggable: function(){
			$(".widget-box").draggable({
				revert : 'invalid',
				cursor : 'move',
				helper : 'clone',
				cursorAt : { left: 100 },
				start : function(event, ui) {
					// Grab our desired width from the widget area list
					var width = $(".widget-list").css("width");

					// Setup our new dragging object
					$(this).addClass('widget-drag')
					$(ui).css("width", width + " !important");
				},
				stop: function() {
					$(this).removeClass('widget-drag');
				}
			});
		}
	};

	pyro.widgets.init();

});})(jQuery);