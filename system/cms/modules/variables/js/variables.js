(function($){

	// Live typing for var names.
	$('input[name=name]').live('keyup', function() {
		$('#var_'+$(this).attr('id')).html($('input[name=name]').val()).replace(/[a-zA-Z]+[0-9]+/), '';
	});
	
	$(function(){

	var variables = {
		$content : $('#content-body'),

		/**
		 * Constructor
		 */
		init: function(){

			/**
			 * Loads create and list views
			 */
			$('a[rel=ajax]').live('click', function(e){
				var fetch_url = $(this).attr('href');

				pyro.clear_notifications();

				// Hide the content div in prep. to show add form
				variables.$content.slideUp(function(){
					// Load the create form
					$(this).load(fetch_url, function(){
						$(this).slideDown();
					});
				});

				e.preventDefault();
			});

			/**
			 * Cancel button click behavior
			 */
			$('a.button.cancel').live('click', function(e){
				pyro.clear_notifications();

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

					input_find = $('td').children('input[name=name]').val();

				if (input_find !== undefined)
				{
					return false;
				}
				
				orig_tr.fadeOut(function(){
					orig_tr.load(load_url);
					orig_tr.fadeIn();
				});

				e.preventDefault();
			});

			/**
			 * Form submit behavior, both create and edit trigger
			 */
			$('button[value=save]').live('click', function(e){
				e.preventDefault();

				var form_data	= {
					name: $('input[name=name]').val(),
					data: $('input[name=data]').val()
				},
				id			= $('input[name=variable_id]').val(),
				has_id		= id !== undefined,
				post_url	= SITE_URL + 'admin/variables/' + (has_id ? 'edit/' + id : 'create'),
				callback	= ( $(this).val() == 'save_exit' || $(this).parent('td.actions').size() > 0 ) ? variables.load_list : false;
				
				if(has_id){form_data.variable_id=id;}

				variables.do_submit(form_data, post_url, callback);
			});
		},

		/**
		 * Loads the list view of variables
		 */
		load_list: function(){
			var list_page = SITE_URL + 'admin/variables';

			if (window.location.href.match(/variables\/(edit|create)/))
			{
				window.location.replace(list_page);
			}

			variables.$content.load(list_page, function(){
				$(this).slideDown();
			});
		},

		/**
		 * Handles submits for both edit and create forms
		 */
		do_submit: function(form_data, post_url, callback) {

			// Remove notifications
			pyro.clear_notifications();

			$.post(post_url, form_data, function(data, status, xhr) {

				if (data.title)
				{
					variables.$content.children('h3:eq(0)').text(data.title);
				}

				if (data.status == 'success')
				{
					// Load the index
					pyro.add_notification(data.message, {}, function(){
						callback && variables.$content.slideUp(callback);
					});

					return;
				}

				pyro.add_notification(data.message);

			}, 'json');
		}
	};
	
	variables.init();

});})(jQuery);