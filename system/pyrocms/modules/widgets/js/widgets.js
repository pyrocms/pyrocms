(function($){$(function(){

	$.extend($.ui.accordion.prototype, {
		refresh: function(){
			this.destroy();
			this.widget().accordion(this.options)
			return this;
		}
	});

	pyro.cached = {
		widget_forms: {},
		url_titles: {}
	}

	pyro.widgets = {

		$areas		: null,
		$boxes		: null,
		$instances	: null,
		$container	: null,
		selector	: {
			container	: 'null',
			instances	: 'null'
		},

		ui_options: {
			// Widget Areas
			accordion: {
				collapsible	: true,
				header		: '> section > header',
				autoHeight	: false,
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

					$(this).children('li').each(function(){
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
				cursorAt	: {left: 100},

				start : function(e, ui){
					// Grab our desired width from the widget area list
					var width = pyro.widgets.$instances.width() - 22;

					// Setup our new dragging object
					$(this).addClass('widget-drag')
					$(ui.helper).css('width', width);
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
					pyro.widgets.$areas.accordion('resize');
				},
				out : function(){
					pyro.widgets.$areas.accordion('resize');
				},
				drop : function(e, ui){
					//.attr('id').replace(/^widget-/, '')
					$('li.empty-drop-item', this).show().addClass('loading');

					pyro.widgets.prep_instance_form(ui.draggable, $(pyro.widgets.selector.instances, this));
					
				}
			}
		},

		init: function()
		{
			// Create/Edit Areas
			$('a.create-area, .widget-area-content > .buttons > a.edit').livequery(function(){
				$(this).colorbox({
					scrolling	: false,
					width		:'600',
					height		:'400',

					onComplete	: function(){
						pyro.widgets.handle_area_form(this);
					}
				});
			});

			// Delete Areas
			$('.widget-area-content > .buttons > button[value=delete]').live('click', function(e){
				e.preventDefault();

				if ( ! $.data(this, 'confirmed'))
				{
					return;
				}

				var $area	= $(this).parents('section.widget-area-box'),
					id		= $area.attr('data-id'),
					url		= SITE_URL + 'admin/widgets/areas/delete/' + id;

				$.post(url, {}, function(response){					
					if (response.status == 'success')
					{
						$area.slideUp(function(){
							$(this).remove();
						});
					}
					pyro.add_notification(response.message);
				}, 'json');
			});

			// Delete Instances
			$('.widget-actions > button[value=delete]').live('click', function(e){
				e.preventDefault();

				if ( ! $.data(this, 'confirmed'))
				{
					return;
				}

				var $item	= $(this).parents('li.widget-instance'),
					id		= $item.attr('id').replace(/instance-/, ''),
					url		= SITE_URL + 'admin/widgets/instances/delete/' + id;

				$.post(url, {}, function(response){					
					if (response.status == 'success')
					{
						$item.slideUp(50, function(){
							$(this).remove();
						});
					}
					pyro.add_notification(response.message);
				}, 'json');

				pyro.widgets.$areas.accordion('resize');
			});

			$.extend(true, pyro.widgets, {
				$areas		: $('#widget-areas-list'),
				$boxes		: $('.widget-box'),
				selector	: {
					instances	: '.widget-list > ol',
					container	: '.widget-area-content'
				}
			});

			// Widget Instances Sortable
			pyro.widgets.$areas.bind('accordioncreate', function(){
				pyro.widgets.$instances = $(pyro.widgets.selector.instances).sortable(pyro.widgets.ui_options.sortable);
			});

			// Widget Instances Droppable
			pyro.widgets.$areas.bind('accordioncreate', function(){
				pyro.widgets.$container = $(pyro.widgets.selector.container).droppable(pyro.widgets.ui_options.droppable);
			});

			// Widget Areas Accordion
			pyro.widgets.$areas.accordion(pyro.widgets.ui_options.accordion);

			// Widget Boxes Draggable
			pyro.widgets.$boxes.draggable(pyro.widgets.ui_options.draggable);

			// Auto-create a short-name
			$('input[name="title"]').live('keyup blur', $.debounce(350, function(){

				var $title	= $(this),
					$form	= $title.parents('form'),
					$slug	= $form.find('input[name=slug]'),
					data	= { title: $title.val().toLowerCase() };

				if ( ! data.title.length) return;

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

						if (response.html)
						{
							pyro.widgets.$areas
								.html(response.html)
								.accordion('refresh');

							if (response.active)
							{
								pyro.widgets.$areas.accordion('option', 'active', response.active);
							}
						}

						url.match(/create/) && $form.get(0).reset();

						callback = function(){
							$.colorbox.resize();
							$.colorbox.close();
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
			var $form		= $(form),
				$submit		= $form.find('#instance-actions button[value=save]'),
				$cancel		= $form.find('#instance-actions a.cancel')
				area_id		= $form.parents('section.widget-area-box').attr('data-id'),
				url			= $form.attr('action');

			$cancel.click(function(e){
				e.preventDefault();

				pyro.widgets.rm_instance_form($form);
			});

			$submit.click(function(e){
				e.preventDefault();

				var data = $form.serialize() + '&widget_area_id=' + area_id;

				$.post(url, data, function(response){
					var callback	= false,
						options		= {};

					if (response.status == 'success')
					{
						callback = function(){
							pyro.widgets.rm_instance_form($form);
							pyro.widgets.update_area();
						}
					}
					else
					{
						options = {
							ref: $form.children('header:eq(0)')
						}
					}

					pyro.add_notification(response.message, options, callback);

				}, 'json');
			});
		},

		update_area: function(){
			var url = SITE_URL + 'admin/widgets/areas';

			pyro.widgets.$areas.load(url, function(){
				$(this).accordion('refresh');
			});
		},

		prep_instance_form: function(item, container)
		{
			var slug = $(item).attr('id').replace(/^widget-/, '');

			if (slug in pyro.cached.widget_forms)
			{
				return pyro.widgets.add_instance_form(pyro.cached.widget_forms[slug], container);
			}

			$.get(SITE_URL + 'admin/widgets/instances/create/' + slug, function(response){

				response = '<li id="add-instance-box" class="box hidden widget-instance no-sortable">' +
							response + '</li>';

				pyro.widgets.add_instance_form(pyro.cached.widget_forms[slug] = response, container);

			}, 'html');
		},

		add_instance_form: function(item, container)
		{
			var widget = {
				$item: $(item),
				$container: $(container)
			};

			widget.$container.children('li.empty-drop-item').hide().removeClass('loading');

			pyro.widgets.handle_instance_form(widget.$item.appendTo(widget.$container).slideDown(200, function(){
				pyro.widgets.$boxes.draggable('disable');
				pyro.widgets.$areas.accordion('resize');
			}).children('form'));
		},

		rm_instance_form: function(form)
		{
			$(form).parent().slideUp(50, function(){
				$(this).remove();
				pyro.widgets.$boxes.draggable('enable');
				pyro.widgets.$areas.accordion('resize');
			});
		}

//		scroll_to: function(ele){
//			$('html, body').animate({
//				scrollTop: $(ele).offset().top
//			}, 1000);
//		},

	};

	pyro.widgets.init();

});})(jQuery);