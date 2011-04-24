(function($) {
		
	$(function() {
		
		// load create/edit via ajax
		$('.box header .ajax, a.ajax').live('click', function(){

			$('#link-list').removeClass('empty');
			$('#link-list a').removeClass('selected');
			// Load the form
			$('div#link-details').load($(this).attr('href'), '', function(){
				$('#link-details').fadeIn();
			});
			return false;			
		});
		
		// submit create form via ajax
		$('#nav-create button:submit').live('click', function(e){
			e.preventDefault();
			$.post(BASE_URL + 'index.php/admin/navigation/create', $('#nav-create').serialize(), function(message){
				$('nav#shortcuts').after(message);
				// Fade in the notifications
				$(".notification").fadeIn("slow");
			});
		});
		
		// submit edit form via ajax
		$('#nav-edit button:submit').live('click', function(e){
			e.preventDefault();
			$.post(BASE_URL + 'index.php/admin/navigation/edit/' + $('input[name="link_id"]').val(), $('#nav-edit').serialize(), function(message){
				$('nav#shortcuts').after(message);
				// Fade in the notifications
				$(".notification").fadeIn("slow");
			});
		});
		
		// Pick a rule type, show the correct field
		$('input[name="link_type"]').live('change', function(){
			$('#navigation-' + $(this).val())
			
			// Show only the selected type
			.show().siblings().hide()
			
			// Reset values when switched
			.find('input:not([value="http://"]), select').val('');

		// Trigger default checked
		}).filter(':checked').change();
		
		// show link details
		$('#link-list li a').live('click', function()
		{			
			link_id = $(this).attr('rel');
			$('#link-list a').removeClass('selected');
			$(this).addClass('selected');
			
			// Load the details box in
			$('div#link-details').load(BASE_URI + 'index.php/admin/navigation/ajax_link_details/' + link_id, '', function(){
				$('#link-details').fadeIn();
			});
			return false;
		});
		
		// collapse all ordered lists but the top level
		$('#link-list ol:not(.sortable)').children().hide();
		
		//this gets ran again after drop
		var update_tree = function() {
			
			// add the minus icon to all parent items that now have visible children
			$('#link-list ol').children('li:has(li:visible)').removeClass().addClass('minus');
			
			// add the plus icon to all parent items with hidden children
			$('#link-list ol').children('li:has(li:hidden)').removeClass().addClass('plus');
			
			// remove the class if the child was removed
			$('#link-list ol').children('li:not(:has(ol))').removeClass();
			
			// refresh the link details pane if it exists
			if($('#link-details #link-id').val() > 0)
			{
				// Load the details box in
				$('div#link-details').load(BASE_URI + 'index.php/admin/navigation/ajax_link_details/' + $('#link-details #link-id').val());				
			}
		}
		update_tree();
		
		// set the icons properly on parents restored from cookie
		$($.cookie('open_links')).has('ol').toggleClass('minus plus');
		
		// show the parents that were open on last visit
		$($.cookie('open_links')).children('ol').children().show();
		
		// show/hide the children when clicking on an <li>
		$('#link-list li').live('click', function()
		{
			$(this).children('ol').children().slideToggle('fast');
			 
			$(this).has('ol').toggleClass('minus plus');
			 
			var links = [];
			 
			// get all of the open parents
			$('#link-list').find('li.minus:visible').each(function(){ links.push('#' + this.id) });

			// save open parents in the cookie
			$.cookie('open_links', links.join(', '), { expires: 1 });
			 
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
		
				// refresh the tree icons - needs a timeout to allow nestedSort
				// to remove unused elements before we check for their existence
				setTimeout(update_tree, 5);
			
				$.post(BASE_URI + 'index.php/admin/navigation/order', { 'order': order } );
			}
		});
	});
  
})(jQuery);