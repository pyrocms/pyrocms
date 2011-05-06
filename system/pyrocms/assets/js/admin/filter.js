(function($){$(function(){

	pyro.filter = {
		$content		: $('#content'),
		$notification	: $('.notification'),
		// filter form object
		$filter_form	: $('.filter form'),

		//lets get the current module,  we will need to know where to post the search criteria
		f_module		: $('input[name="f_module"]').val(),

		/**
		 * Constructor
		 */
		init: function(){

			$('a.cancel').button();

			//listener for select elements
			$('select', pyro.filter.$filter_form).live('change', function(){

				//build the form data
				form_data = pyro.filter.$filter_form.serialize();

				//fire the query
				pyro.filter.do_filter(pyro.filter.f_module, form_data);
			});

			//listener for keywords
			$('input[type="text"]', pyro.filter.$filter_form).live('keyup', $.debounce(500, function(){

				//build the form data
				form_data = pyro.filter.$filter_form.serialize();

				pyro.filter.do_filter(pyro.filter.f_module, form_data);
			
			}));
	
			//listener for pagination
			$('.pagination a').live('click', function(e){
				e.preventDefault();
				url = $(this).attr('href');
				form_data = pyro.filter.$filter_form.serialize();
				pyro.filter.do_filter(pyro.filter.f_module, form_data, url);
			});
			
			//clear filters
			$('a.cancel', pyro.filter.$filter_form).click(function() {
			
					//reset the defaults
					//$('select', filter_form).children('option:first').addAttribute('selected', 'selected');
					$('select', pyro.filter.$filter_form).val('0');
					
					//clear text inputs
					$('input[type="text"]').val('');
			
					//build the form data
					form_data = pyro.filter.$filter_form.serialize();
			
					pyro.filter.do_filter(pyro.filter.f_module, form_data);
			});
			
			//prevent default form submission
			pyro.filter.$filter_form.submit(function(e){
				e.preventDefault(); 
			});
		},
	
		//launch the query based on module
		do_filter: function(module, form_data, url){
			post_url = SITE_URL + 'admin/' + module;

			if (typeof url !== 'undefined'){
				post_url = url;
			}

			pyro.filter.remove_notifications();

			pyro.filter.$content.fadeOut('fast', function(){
				//send the request to the server
				$.post(post_url, form_data, function(data, response, xhr) {
					//success stuff here
					$.uniform.update('select, input');
					pyro.filter.$content.html(data).fadeIn('fast');

					pyro.filter.$notification = $('.notification');
				});
			});
		},

		/**
		 * Removes any existing user notifications before adding anymore
		 */
		remove_notifications: function(){
			this.$notification.fadeOut(function(){
				$(this).remove();
			});
		}
	};

	pyro.filter.init();

});})(jQuery);