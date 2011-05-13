(function($) {
		
	$(function() {
		
		// show page details
		$('#page-list li a').live('click', function()
		{
			page_id = $(this).attr('rel');
			$('#page-list a').removeClass('selected');
			$(this).addClass('selected');
			
			// Load the details box in
			$('div#page-details').load(SITE_URL + 'admin/pages/ajax_page_details/' + page_id);
			return false;
		});
		
		// collapse all ordered lists but the top level
		$('#page-list ol:not(.sortable)').children().hide();
		
		//this gets ran again after drop
		var update_tree = function() {
			
			// add the minus icon to all parent items that now have visible children
			$('#page-list ol').children('li:has(li:visible)').removeClass().addClass('minus');
			
			// add the plus icon to all parent items with hidden children
			$('#page-list ol').children('li:has(li:hidden)').removeClass().addClass('plus');
			
			// remove the class if the child was removed
			$('#page-list ol').children('li:not(:has(ol))').removeClass();
			
			// refresh the page details pane if it exists
			if($('#page-details #page-id').val() > 0)
			{
				// Load the details box in
				$('div#page-details').load(SITE_URL + 'admin/pages/ajax_page_details/' + $('#page-details #page-id').val());				
			}
		}
		update_tree();
		
		// set the icons properly on parents restored from cookie
		$($.cookie('open_pages')).has('ol').toggleClass('minus plus');
		
		// show the parents that were open on last visit
		$($.cookie('open_pages')).children('ol').children().show();
		
		// show/hide the children when clicking on an <li>
		$('#page-list li').live('click', function()
		{
			$(this).children('ol').children().slideToggle('fast');
			 
			$(this).has('ol').toggleClass('minus plus');
			 
			var pages = [];
			 
			// get all of the open parents
			$('#page-list').find('li.minus:visible').each(function(){ pages.push('#' + this.id) });

			// save open parents in the cookie
			$.cookie('open_pages', pages.join(', '), { expires: 1 });
			 
			 return false;
		});
		
		$('ol.sortable').nestedSortable({
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .4,
			placeholder: 'placeholder',
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			stop: function(event, ui) {
				// create the array using the toHierarchy method
				order = $('ol.sortable').nestedSortable('toHierarchy');
				
				root_pages = [];
				// grab an array of root page ids
				$('ol.sortable').children('li').each(function(){
					root_pages.push($(this).attr('id').replace('page_', ''));
				});
		
				// refresh the tree icons - needs a timeout to allow nestedSort
				// to remove unused elements before we check for their existence
				setTimeout(update_tree, 5);
			
				$.post(SITE_URL + 'admin/pages/order', { 'order': order, 'root_pages': root_pages } );
			}
		});
	});
  
})(jQuery);