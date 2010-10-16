(function($) {
	$(function(){
		//define th widths prevents jumping
		add_styles();
		
		/**
		 * Loads create and list views
		 */
		$('a[rel=ajax]').live('click', function() {
		    add_styles();
		    var fetch_url = $(this).attr('href');
		    
		    //hide notifications
		    remove_notifications();
		   
		     //hide the content div in prep. to show add form
		     $('#content').slideUp('normal', function() {
		     
			    //load the create form
			    $('#content').load(
					   fetch_url,
					   function(data, status, xhr) {
						    add_styles();
						   $.uniform.update();
						   $(this).slideDown('normal');
					   }
			   );
		     });
		     return false;
		});
	    
	    /**
	     * Cancel button click behavior
	     */
	    $('a.button').live('click', function() {
		remove_notifications();
		$('#content').slideUp('normal', function() {
			load_list();
		});
	    });
	    	
	    /**
	     * In Line Edit Event Behavior
	     */
	    $('a[rel=ajax-eip]').live('click', function() {
		
		add_styles();
		
		var load_url = $(this).attr('href');
		var orig_tr = $(this).parents('tr');
		var orig_html = orig_tr.html();
		
		var input_find = $('td').children('input[name=name]').val();
		
		if(typeof input_find != 'undefined')
		{
			return false;
		}
		
		orig_tr.fadeOut('normal', function() {
			
			orig_tr.load(load_url,
				     function(data, status, xhr) {
					add_styles();
					$.uniform.update();
				     }
				     );
			orig_tr.fadeIn('slow');
		});	
		
		return false;
	    });
	    
	    /**
	     * Form submit behavior, both create and edit trigger
	     */
	    $('button.button').live('click', function() {
		
		var name_data = $('input[name=name]').val();
		var data_data = $('input[name=data]').val();
		var variable_id = $('input[name=variable_id]').val();
		
		if(typeof variable_id != 'undefined') {
			var post_url = BASE_URL + '/admin/variables/edit/'+ variable_id;
		} else {
			var post_url = BASE_URL + '/admin/variables/create';
		}
		
		var form_data = { name : name_data, data : data_data };
		
		do_submit(form_data, post_url);
				
		return false;
	    });
	    
	    /**
	     * Loads the list view of variables
	     */
	    function load_list()
	    {
		$('#content').load(
				BASE_URL + '/admin/variables',
				function(data, status, xhr)
				{
					add_styles();
					$.uniform.update();
					$(this).slideDown('fast');
				}
		);
	    }
	    
	    /**
	     * Removes any existing user notifications before adding anymore
	     */
	    function remove_notifications()
	    {
		$('.notification').fadeOut('fast', function() {
			$(this).remove();	
		});
	    }
	    
	    /**
	     * Handles submits for both edit and create forms
	     */
	    function do_submit(form_data, post_url) {
		
		//remove notifications
		remove_notifications();
				
		$.ajax({
			type: "POST",
			url: post_url,
			data: form_data,
			dataType: "json",
			success: function(data, status, xhr) {
					//prepare the html notification
					var notification = '<div class="closable notification ' + data.status + '">'+data.message+'<a class="close" href="#">close</a></div>';
					
					//add the notification message to the DOM
					$('#shortcuts').after(notification);
					
					if(data.status == 'success')
					{
						//load the index
						$('.notification').fadeIn('normal', function() {
							
							$('#content').slideUp('normal', function() {
								load_list();
							});
						});
						return;
					}
					
					$('.notification').fadeIn('normal');
				}
		}
		);
	    }
	    
	    /**
	     * Adds styles to th elements to prevent "jumping"
	     */
	    function add_styles()
	    {
		$('th:eq(0)').css('width', '5%');
		$('th:eq(1)').css('width', '20%');
		$('th:eq(2)').css('width', '20%');
		$('th:eq(3)').css('width', '20%');
		$('th:eq(4)').css('width', '20%');
	    }
        });
        
})(jQuery);