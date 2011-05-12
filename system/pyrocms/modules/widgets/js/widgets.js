(function($){$(function(){

	pyro.cached = {
		url_titles: {}
	}

	pyro.widgets = {

		$areas		: null,
		$container	: null,
		$instances	: null,
		$boxes		: null,

		ui_options: {
			// Widget Areas
			accordion: {
				collapsible	: true,
				header		: '> section > header',
				autoHeight	: true,
				clearStyle	: true
			},
			// Widget Instances List
			sortable: {
				cancel		: '.no-sortable, :input, option',
				placeholder	: 'empty-drop-item',

				start: function(){
					pyro.widgets.$areas.accordion('resize');
				},

				stop: function(){
					pyro.widgets.$areas.accordion('resize');
				},

				update: function(){
					var order = [];

					$('li', this).each(function(){
						order.push($(this).attr('id').replace(/^instance-/, ''));
					});

					$.post(SITE_URL + 'widgets/ajax/update_order', { order: order.join(',') });
				}
			},
			// Widget Box
			draggable: {
				revert		: 'invalid',
				cursor		: 'move',
				helper		: 'clone',
				cursorAt	: { left: 100 },

				start : function(e, ui){
					// Grab our desired width from the widget area list
					var width = $('.widget-list').css('width');

					// Setup our new dragging object
					$(this).addClass('widget-drag')
					console.log($(ui).css('width', width + ' !important'));
				},
				stop: function() {
					$(this).removeClass('widget-drag');
				}
			},
			// Widget Instances List
			droppable: {
				hoverClass	: 'drop-hover',
				accept		: '.widget-box',
				greedy		: true,

				over : function(){
					$('li.empty-drop-item').show();
					pyro.widgets.$areas.accordion('resize');
				},
				out : function(){
					$('li.empty-drop-item').hide();
					pyro.widgets.$areas.accordion('resize');
				},
				drop : function(e, ui){
					var data = {
						area_slug	: $(this).parent().attr('id').replace(/^area-/, ''),
						widget_slug	: ui.draggable.attr('id').replace(/^widget-/, '')
					};

					$.post(SITE_URL + 'widgets/instances/create', data, function(response)
					{
						if (response.status == 'success')
						{
							//$('form', pyro.widgets.add_instance).html(response.html);
							//pyro.widgets.show_add_instance(data.area_slug);
						}
					}, 'json');
				}
			}
		},

		init: function()
		{

			// Create/Edit Areas
			$('a.create-area, a.edit-area').livequery(function(){
				$(this).colorbox({
					scrolling	: false,
					width		:'600',
					height		:'400',

					onComplete	: function(){
						pyro.widgets.handle_area_form(this);
					}
				});
			});

			// Create/Edit Instances
			$('a.create-instance, a.edit-instance').livequery(function(){
				$(this).colorbox({
					scrolling	: false,
					width		:'600',
					height		:'400',

					onComplete	: function(){
						pyro.widgets.handle_instance_form(this);
					}
				});
			});

			$.extend(true, pyro.widgets, {
				$areas		: $('#widget-areas-list'),
				$container	: $('.widget-area-content'),
				$instances	: $('.widget-list ol'),
				$boxes		: $('.widget-box')
			});

			// Widget Areas Accordion
			pyro.widgets.$areas.accordion(pyro.widgets.ui_options.accordion);

			// Widget Instances Sortable
			pyro.widgets.$instances.sortable(pyro.widgets.ui_options.sortable);

			// Widget Boxes Draggable
			pyro.widgets.$boxes.draggable(pyro.widgets.ui_options.draggable);

			// Widget Instances Droppable
			pyro.widgets.$container.droppable(pyro.widgets.ui_options.droppable);

			// Auto-create a short-name
			$('input[name="title"]').live('keyup blur', $.debounce(350, function(){

				var $title	= $(this),
					$form	= $title.parents('form'),
					$slug	= $form.find('input[name=slug]'),
					data	= { title: $title.val().toLowerCase() };

				if (data.title in pyro.cached.url_titles)
				{
					$slug.val(pyro.cached.url_titles[data.title]);

					return;
				}

				$.post(SITE_URL + 'ajax/url_title', data, function(slug){
					pyro.cached.url_titles[data.title] = slug;

					$slug.val(slug);
				});

			}));

//			// Add new widget instance
//			$('#add-instance-box form').live('submit', function(e){
//				e.preventDefault();
//
//				var widget_id = $('input[name="widget_id"]', this).val(),
//					widget_area_id = $('input[name="widget_area_id"]', this).val(),
//					title = $('input[name="title"]', this).val(),
//
//					form = $(this),
//
//					active_id = $( "#widget-areas-list" ).accordion( "option", "active" );
//
//				if ( ! (title || widget_id || widget_area_id)) return false;
//		
//				$.post(SITE_URL + 'widgets/ajax/add_widget_instance', form.serialize(), function(data){
//			
//					if (data.status == 'success')
//					{
//						pyro.widgets.hide_instance('add');
//						pyro.widgets.refresh_lists();
//						pyro.widgets.re_accordion(active_id);
//					}
//					else
//					{
//						form.html(data.form);
//					}
//
//				}, 'json');
//			});
//
//			// Edit widget instance
//			$('#edit-instance-box form').live('submit', function(e){
//				e.preventDefault();
//
//				var title			= $('input[name="title"]', this).val(),
//					widget_id		= $('input[name="widget_id"]', this).val(),
//					widget_area_id	= $('[name="widget_area_id"]', this).val(),
//
//					form = $(this);
//
//				if ( ! (title || widget_id || widget_area_id)) return false;
//
//				$.post(SITE_URL + 'widgets/ajax/edit_widget_instance', form.serialize(), function(data){
//			
//					if (data.status == 'success')
//					{
//						pyro.widgets.hide_instance('edit');
//						pyro.widgets.refresh_lists();
//					}
//					else
//					{
//						form.html(data.form);
//					}
//			
//				}, 'json');
//			});

//			$('#widget-instance-cancel').live('click', function(e){
//				e.preventDefault();
//
//				pyro.widgets.hide_instance(['add','edit']);
//				pyro.widgets.re_accordion();
//			});
//
//			$('a.edit-instance').live('click', function(e){
//				e.preventDefault();
//
//				var id			= $(this).closest('li').attr('id').replace('instance-', ''),
//					area_slug	= $(this).closest('section').attr('id').replace('area-', '');
//
//				$.post(SITE_URL + 'widgets/ajax/edit_widget_instance_form', {instance_id: id}, function(html){
//					// Insert the form into the edit_instance li node
//					$('form', pyro.widgets.edit_instance).html(html);
//
//					pyro.widgets.show_edit_instance(area_slug, id);
//				});
//			});
//
//			$('a.delete-instance').live('click-confirmed', function(e){
//				e.preventDefault();
//				$.data(this, 'stop-click', true);
//
//				var li	= $(this).closest('li'),
//					id	= li.attr('id').replace('instance-', '');
//
//				$.post(SITE_URL + 'widgets/ajax/delete_widget_instance', {instance_id: id}, function(html){
//					li.slideUp(function() { 
//						$(this).remove();
//						$("#widget-areas-list").accordion("resize");
//					});
//				});
//			});
		},

		handle_area_form: function(anchor)
		{
			var $loading	= $('#cboxLoadingOverlay, #cboxLoadingGraphic'),
				$cbox		= $('#cboxLoadedContent'),
				$submit		= $cbox.find('button[value=save]'),
				$cancel		= $cbox.find('.button.cancel'),
				$form		= $cbox.find('form'),
				url			= $(anchor).attr('href');

			$cancel.click(function(e){
				e.preventDefault();

				$.colorbox.close();
			});

			$submit.click(function(e){
				e.preventDefault();

				var data = $form.slideUp().serialize();

				$loading.show();

				$.post(url, data, function(response){
					var callback = false;

					if (response.status == 'success')
					{
						if (response.title)
						{
							// editing replace area title
						}

						//url.match(/create/) && $form.get(0).reset();

						$form.attr({
							action: window.location.href,
							method: 'GET'
						}).find(':input').remove();

						var $refresh = $('<button type="submit">list</button>');

						$form.append($refresh);

						callback = function(){
							$.colorbox.resize();
							$.colorbox.close();

							$refresh.click();
						};
					}
					else
					{
						callback = $.colorbox.resize;
					}

					$loading.hide();
					$form.slideDown();

					pyro.add_notification(response.message, {ref: $cbox, method: 'prepend'}, callback);

				}, 'json');
			});

			$.colorbox.resize();
		},

		handle_instance_form: function(form)
		{
			var //$loading	= $('#cboxLoadingOverlay, #cboxLoadingGraphic'),
				//$cbox		= $('#cboxLoadedContent'),
				$form		= $(form),
				$submit		= $form.find('button[value=save]'),
				$cancel		= $form.find('.button.cancel'),
				url			= $form.attr('action');

			$cancel.click(function(e){
				e.preventDefault();

				// remove form
			});

			$submit.click(function(e){
				e.preventDefault();

				var data = $form.slideUp().serialize();

				//$loading.show();

				$.post(url, data, function(response){
					var callback = false;

					if (response.status == 'success')
					{
						if (response.title)
						{
							// editing replace area title
						}

						//url.match(/create/) && $form.get(0).reset();

						$form.attr({
							action: window.location.href,
							method: 'GET'
						}).find(':input').remove();

						var $refresh = $('<button type="submit">list</button>');

						$form.append($refresh);

						callback = pyro.widgets.close_instance_form;
					}
					else
					{
						//callback = false;
					}

					//$loading.hide();
					//$form.slideDown();

					pyro.add_notification(response.message, callback);

				}, 'json');
			});

			$.colorbox.resize();
		},

		close_instance_form: function()
		{
			//
		}

//		scroll_to: function(ele){
//			$('html, body').animate({
//				scrollTop: $(ele).offset().top
//			}, 1000);
//		},
//
//		show_add_instance: function(area_slug){
//			var my_area = '#area-' + area_slug + ' ol';
//
//			$('li.empty-drop-item', my_area).before(pyro.widgets.add_instance.detach()).hide();
//
//			pyro.widgets.add_instance.fadeIn();
//
//			$('.widget-box').draggable('disable');
//			$('#widget-areas-list').accordion('resize');
//
//			pyro.widgets.scroll_to(pyro.widgets.add_instance);
//		},
//
//		show_edit_instance: function(area_slug, id){
//			var my_area = '#area-' + area_slug + ' ol';
//
//			$(my_area + " #instance-"+ id).after(pyro.widgets.edit_instance.detach().removeClass('hidden'));
//			$('.widget-list .empty-drop-item').css('display', 'none');
//
//			pyro.widgets.edit_instance.css('display', 'block').slideDown(function(){
//				setTimeout(function(){
//					$('#widget-areas-list').accordion('resize');
//				}, 10);
//			});
//		},
//
//		hide_instance: function(action){
//
//			if (action instanceof Array)
//			{
//				for (i in action)
//				{
//					pyro.widgets.hide_instance(action[i]);
//				}
//				return;
//			}
//
//			// Hide the form
//			pyro.widgets[action + '_instance'].slideUp(function(){
//
//				// Clean up
//				$('input, select, textarea', this).attr('value', '');
//				$('#'+action+'-instance-box').detach();
//				$('#widget-areas-list').accordion('resize');
//				$('.widget-box').draggable('enable');
//			});
//		},
//
//		refresh_lists: function(){
//			$('.widget-list').each(function(){
//				var widget_area_slug = $(this).parent().parent().attr('id').replace(/^area-/, '');
//
//				$(this).load(SITE_URL + 'widgets/ajax/list_widgets/' + widget_area_slug, function(){
//					$('.widget-list ol').sortable('destroy').sortable(pyro.widgets.sort_options);
//					$('#widget-areas-list').accordion('resize');
//				});
//			});
//		},
//
//		re_accordion: function(active_id){
//			$('#widget-areas-list').accordion('destroy').accordion({
//				collapsible: true,
//				header: 'header',
//				autoHeight: false,
//				clearStyle: true,
//				active: active_id
//			});
//		}
	};

	pyro.widgets.init();

});})(jQuery);