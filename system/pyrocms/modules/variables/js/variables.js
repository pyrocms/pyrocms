(function($) {
    
	$(function(){
		
            //click add link trigger events
            $('a[rel=ajax]').live('click', function(e) {
		
		var fetch_url = $(this).attr('href');
		
		//hide notifications
		remove_notifications();
		
		//prevent default click
		e.preventDefault();
		
                 //hide the content div in prep. to show add form
                 $('#content').slideUp('normal', function() {
		 
			//load the create form
			$('#content').load(
				       fetch_url,
				       function(data, status, xhr) {
					       $.uniform.update();
					       $(this).slideDown('normal');
				       }
		       );
		 });
		 return false;
            });
	    
	    //form submit
	    $('form#variables').live('submit', function(e) {
		
		var form_data = $(this).serialize();
		var post_url = $(this).attr('action');
		
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
		return false;
	    });
	    
	    //load index function
	    function load_list()
	    {
		$('#content').load(
				BASE_URL + '/admin/variables',
				function(data, status, xhr)
				{
					$.uniform.update();
					$(this).slideDown('fast');
				}
		);
	    }
	    
	    //hide and remove any existing notifications
	    function remove_notifications()
	    {
		$('.notification').fadeOut('fast', function() {
			$(this).remove();	
		});
	    }
	    
        });
        
})(jQuery);