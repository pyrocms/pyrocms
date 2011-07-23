jQuery(function($){

	$.extend($.ui.accordion.prototype, {
		refresh: function(){
			this.destroy();
			this.widget().accordion(this.options)
			return this;
		}
	});

	pyro.cached = {
		url_titles		: {},
		widget_forms	: {
			add		:{},
			edit	:{}
		}
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
				cancel		: '.no-sortable, a, :input, option',
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
				refreshPositions: true,

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
				tolerance	: 'pointer',

				over : function(){
					pyro.widgets.$areas.accordion('resize');
				},
				out : function(){
					pyro.widgets.$areas.accordion('resize');
				},
				drop : function(e, ui){
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
			$('.widget-area-content > .buttons > button[value=delete]').live('click-confirmed', function(e){
				e.preventDefault();

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

			// Edit Instances
			$('.widget-actions > a.button.edit').live('click', function(e){
				e.preventDefault();

				var $anchor = $(this);

				// hide
				$anchor.parents('.widget-instance').slideUp(50, function(){
					// fake loading..
					$(this).siblings('li.empty-drop-item').clone()
						// move
						.insertAfter(this)
						// show
						.show().addClass('loading clone');

						// next step
						pyro.widgets.prep_instance_form($anchor, this, 'edit');
				});
			});

			// Delete Instances
			$('.widget-actions > button[value=delete]').live('click-confirmed', function(e){
				e.preventDefault();

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
				pyro.widgets.$areas.find('> section > header').droppable({
					accept: '.widget-box',
					addClasses: false,
					greedy: true,
					tolerance: 'pointer',
					over: function(){
						pyro.widgets.$areas.accordion('option', 'active', this);
					}
				});
			});

			// Widget Areas Accordion
			pyro.widgets.$areas.accordion(pyro.widgets.ui_options.accordion);

			// Widget Boxes Draggable
			pyro.widgets.$boxes.draggable(pyro.widgets.ui_options.draggable);

			// Auto-create a short-name
			$('input[name="title"]').live('keyup', $.debounce(350, function(){

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

			// MANAGE ------------------------------------------------------------------------------

			$('#widgets-list > tbody').livequery(function(){
				$(this).sortable({
					handle: 'span.move-handle',
					stop: function(){
						$('#widgets-list > tbody > tr').removeClass('alt');
						$('#widgets-list > tbody > tr:nth-child(even)').addClass('alt');

						var order = [];

						$('#widgets-list > tbody > tr input[name="action_to\[\]"]').each(function(){
							order.push(this.value);
						});

						order = order.join(',');

						$.post(SITE_URL + 'widgets/ajax/update_order/widget', { order: order });
					}
				});
			});

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

		update_area: function(){
			var url = SITE_URL + 'admin/widgets/areas';

			pyro.widgets.$areas.load(url, function(){
				$(this).accordion('refresh');
			});
		},

		prep_instance_form: function(item, container, action)
		{
			action || (action = 'add');

			var key	= (action == 'add') ? $(item).attr('id').replace(/^widget-/, '') : $(container).attr('id').replace(/^instance-/, ''),
				url	= (action == 'add') ? SITE_URL + 'admin/widgets/instances/create/' + key : $(item).attr('href');

			// known? receive the action form
			if (key in pyro.cached.widget_forms[action])
			{
				// next step
				return pyro.widgets.add_instance_form(pyro.cached.widget_forms[action][key], container, action, key);
			}

			$.get(url, function(response){

				response = '<li id="' + action + '-instance-box" class="box hidden widget-instance no-sortable">' +
							response + '</li>';

				// write action form into cache
				pyro.cached.widget_forms[action][key] = response;

				pyro.widgets.add_instance_form(response, container, action, key);

			}, 'html');
		},

		add_instance_form: function(item, container, action, key)
		{
			var widget = {
				$item: $(item),
				$container: $(container)
			}, method = 'appendTo';

			if (action === 'edit')
			{
				widget.$container.parent().children('li.empty-drop-item.clone').slideUp(50, function(){
					$(this).remove();
				});
				method = 'insertAfter';
			}
			else
			{
				widget.$container.children('li.empty-drop-item').hide().removeClass('loading');
			}

			pyro.widgets.handle_instance_form(widget.$item[method](widget.$container).slideDown(200, function(){
				pyro.widgets.$boxes.draggable('disable');
				pyro.widgets.$areas.accordion('resize');
			}).children('form'), action, key);
		},

		handle_instance_form: function(form, action, key)
		{
			var $form		= $(form),
				$submit		= $form.find('#instance-actions button[value=save]'),
				$cancel		= $form.find('#instance-actions a.cancel')
				area_id		= $form.parents('section.widget-area-box').attr('data-id'),
				url			= $form.attr('action');

			if ($form.data('has_events'))
			{
				return;
			}

			$form.data('has_events', true);

			$cancel.click(function(e){
				e.preventDefault();

				var callback = action === 'edit' ? function(){
					$('li#instance-'+key).slideDown(function(){
						pyro.widgets.$areas.accordion('resize');
					});
				} : false;

				pyro.widgets.rm_instance_form($form, action, key, callback);
			});

			$submit.click(function(e){
				e.preventDefault();

				var data = $form.serialize() + (action === 'add' ? '&widget_area_id=' + area_id : '');

				$.post(url, data, function(response){
					var callback	= false,
						options		= {};

					if (response.status == 'success')
					{
						callback = function(){
							pyro.widgets.rm_instance_form($form, action, key, function(){
								pyro.widgets.update_area();
								var $active = pyro.widgets.$areas.find('> section > header:eq('+pyro.widgets.$areas.accordion('option', 'active')+')').parent();

								if (response.active && response.active !== ('#' + $active.attr('id') + ' header'))
								{
									pyro.widgets.$areas.accordion('option', 'active', response.active);
								}
							});
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

		rm_instance_form: function(form, action, key, callback)
		{
			$(form).parent().slideUp(50, function(){
				action === 'add'
					? $(this).remove()
					: key
						? pyro.cached.widget_forms[action][key] = $(this).detach()
						: pyro.cached.widget_forms[action] = {};

				pyro.widgets.$boxes.draggable('enable');
				pyro.widgets.$areas.accordion('resize');

				callback && callback();
			});
		}

//		,scroll_to: function(ele){
//			$('html, body').animate({
//				scrollTop: $(ele).offset().top
//			}, 1000);
//		}

	};

	pyro.widgets.init();

});