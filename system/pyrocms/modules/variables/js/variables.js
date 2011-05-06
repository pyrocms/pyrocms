(function($){$(function(){

	var variables = {
		$content		: $('#content'),
		$notification	: $('.notification'),

		/**
		 * Constructor
		 */
		init: function(){

			/**
			 * Loads create and list views
			 */
			$('a[rel=ajax]').live('click', function(e){
				var fetch_url = $(this).attr('href');

				variables.remove_notifications();
		
				// Hide the content div in prep. to show add form
				variables.$content.slideUp(function(){
					// Load the create form
					$(this).load(fetch_url, function(){
						$.uniform.update('input[type=checkbox], button');
						$(this).slideDown();
					});
				});

				e.preventDefault();
			});

			/**
			 * Cancel button click behavior
			 */
			$('a.button.cancel').live('click', function(e){
				variables.remove_notifications();

				variables.$content.slideUp(function(){
					variables.load_list();
				});

				e.preventDefault();
			});

			/**
			 * In Line Edit Event Behavior
			 */
			$('a.button.edit').live('click', function(e){
				var load_url	= $(this).attr('href'),
					orig_tr		= $(this).parents('tr'),
					orig_html	= orig_tr.html(),

					input_find = $('td').children('input[name=name]').val();

				if (typeof input_find != 'undefined')
				{
					return false;
				}

				orig_tr.fadeOut(function(){
					orig_tr.load(load_url, function(){
						$.uniform.update('input[type=checkbox], button');
					});
					orig_tr.fadeIn();
				});

				e.preventDefault();
			});

			/**
			 * Form submit behavior, both create and edit trigger
			 */
			$('button[value=save]').live('click', function(e){
				var form_data	= {
						name: $('input[name=name]').val(),
						data: $('input[name=data]').val()
					},
					variable_id	= $('input[name=variable_id]').val(),
					post_url	= SITE_URL + 'admin/variables/'
								+ ((typeof variable_id != 'undefined')
								? 'edit/' + variable_id : 'create'),
					callback	= ( $(this).parent('td.actions').is('td') )
								? variables.load_list : false;

					variables.do_submit(form_data, post_url, callback);

				e.preventDefault();
			});
		},

		/**
		 * Removes any existing user notifications before adding anymore
		 */
		remove_notifications: function(){
			variables.$notification.fadeOut(function(){
				$(this).remove();
			});
		},

		/**
		 * Loads the list view of variables
		 */
		load_list: function(){
			variables.$content.load(SITE_URL + 'admin/variables', function(){
				$.uniform.update('input[type=checkbox], button');
				$(this).slideDown();
			});
		},

		/**
		 * Handles submits for both edit and create forms
		 */
		do_submit: function(form_data, post_url, callback){

			// Remove notifications
			variables.remove_notifications();

			$.post(post_url, form_data, function(data, status, xhr){
				// Prepare the html notification
				var notification = '<div class="closable notification ' + data.status + '">'
								 + data.message + '<a class="close" href="#">close</a></div>';

				// Add the notification message to the DOM
				$('#shortcuts').after(notification);

				variables.$notification = $('.notification');

				if (data.title)
				{
					variables.$content.children('h3:eq(0)').text(data.title);
				}

				if (data.status == 'success')
				{
					// Load the index
					variables.$notification.fadeIn(function(){
						if ($.isFunction(callback))
						{
							variables.$content.slideUp(function(){
								callback();
							});
						}
					});

					return;
				}

				variables.$notification.fadeIn();
			}, 'json');
		}
	}; variables.init();

});})(jQuery);