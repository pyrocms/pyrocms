(function($) {
		
	$(function() {
		
		// show page details
		$('#page-list li a').live('click', function()
		{
			page_id = $(this).attr('rel');
			
			// Load the details box in
			$('div#page-details').load(BASE_URI + 'index.php/admin/pages/ajax_page_details/' + page_id);
			return false;
		});
		
		// collapse all ordered lists but the top level
		$('#page-list ol:not(.sortable)').children().hide();
		
		//this gets ran again after drop
		function update_tree() {
			
			// add the minus icon to all parent items that now have visible children
			$('#page-list ol').children('li:has(li:visible)').removeClass().addClass('minus');
			
			// add the plus icon to all parent items with hidden children
			$('#page-list ol').children('li:has(li:hidden)').removeClass().addClass('plus');
			
			// remove the class if the child was removed
			$('#page-list ol').children('li:not(:has(ol))').removeClass();
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
				order = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
				
				// refresh the tree
				update_tree();
				
				$.post(BASE_URL + 'index.php/admin/pages/order', { 'order': order },
					function(data){
						// status message
					}, "json");
			}
		});
	});
  
})(jQuery);