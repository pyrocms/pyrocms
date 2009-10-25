(function($) {
	
	$(function(){
	
		var page_tree = $("div#page-tree > ul");
		page_tree.treeview({
			toggle: function() {
				expandTree(this);
				return false;
			}
		});

	
		function expandTree(item)
		{
			// Define elements
			li = $(item);
			span = li.children('span');
			a = span.children('a');
			other_a = page_tree.find('span > a');
		
			// Change which link is selected
			other_a.removeClass('selected');
			a.addClass('selected');
		
			// Folder eh? Let's do cool stuff
			if(span.hasClass('folder'))
			{
				child_ul = $('ul', li);
		
				// This is being expanded (and therefore the class has switched to collapseable to show that it is now opened)
				if(li.hasClass('collapsable'))
				{
					// We have already AJAXed in the contents of this folder
					if( child_ul.children().length == 0 )
					{
						$.get(BASE_URI + 'admin/pages/ajax_fetch_children/' + a.attr('rel').replace('page-', ''), function(data){
							var branches = $(data).appendTo(child_ul);
							page_tree.treeview({
								add: branches
							});
						});
						
						$('li span', page_tree).unbind('click');
					}
		
				}
		
			}
			
		}
	
		$('li span', page_tree).unbind('click');
		$('li a', page_tree).live('click', function()
		{
			a = $(this);
			other_a = page_tree.find('span > a');
		console.debug(other_a);
			// Change which link is selected
			other_a.removeClass('selected');
			a.addClass('selected');
			
			page_id = $(this).attr('rel').replace('page-', '');
			
			// Update the "Details" panel
			$('div#page-details').load(BASE_URI + 'admin/pages/ajax_page_details/' + page_id, function(){
				
				// Set new URL
				$('div#content-head a#new-item').attr('href',  BASE_URL + 'admin/pages/create/' + $('input#page-id').attr('value') );
				
			});
			
			
			return false;
		});

	});
  
})(jQuery);