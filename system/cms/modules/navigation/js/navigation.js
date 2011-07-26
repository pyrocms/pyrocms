(function($) {

	$(function() {

		// show the first box with js to get around page jump
		$('.box .box-container:first').slideDown(600).removeClass('collapsed');

		// show and hide the sections
		$('.box header').click(function(){
			if ($(this).next('div.box-container').hasClass('collapsed')) {
				$('.box .box-container').slideUp(600).addClass('collapsed');
				$(this).next('div.collapsed').slideDown(600).removeClass('collapsed');
			}
		});

		// load edit via ajax
		$('a.ajax').live('click', function(){
			// make sure we load it into the right one
			var id = $(this).attr('rel');
			if ($(this).hasClass('add')) {
				// if we're creating a new one remove the selected icon from link in the tree
				$('.group-'+ id +' #link-list a').removeClass('selected');
			}
			// Load the form
			$('div#link-details.group-'+ id +'').load($(this).attr('href'), '', function(){
				$('div#link-details.group-'+ id +'').fadeIn();
				// display the create/edit title in the header
				var title = $('#title-value-'+id).html();
				$('section.box header h3.group-title-'+id).html(title);
			});
			return false;
		});

		// submit create form via ajax
		$('#nav-create button:submit').live('click', function(e){
			e.preventDefault();
			$.post(SITE_URL + 'admin/navigation/create', $('#nav-create').serialize(), function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('nav#shortcuts').after(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});
		});

		// submit edit form via ajax
		$('#nav-edit button:submit').live('click', function(e){
			e.preventDefault();
			$.post(SITE_URL + 'admin/navigation/edit/' + $('input[name="link_id"]').val(), $('#nav-edit').serialize(), function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('nav#shortcuts').after(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});

		});

		// Pick a rule type, show the correct field
		$('input[name="link_type"]').live('change', function(){
			$(this).parents('ul').find('#navigation-' + $(this).val())

			// Show only the selected type
			.show().siblings().hide()

			// Reset values when switched
			.find('input:not([value="http://"]), select').val('');

		// Trigger default checked
		}).filter(':checked').change();

		// show link details
		$('#link-list li a').live('click', function()
		{
			var id = $(this).attr('rel');
			link_id = $(this).attr('alt');
			$('.group-'+ id +' #link-list a').removeClass('selected');
			$(this).addClass('selected');

			// Load the details box in
			$('div#link-details.group-'+ id +'').load(SITE_URL + 'admin/navigation/ajax_link_details/' + link_id, '', function(){
				$('div#link-details.group-'+ id +'').fadeIn();
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
				$('div#link-details').load(SITE_URL + 'admin/navigation/ajax_link_details/' + $('#link-details #link-id').val());
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
			$('.box-container').find('li.minus').each(function(){ links.push('#' + this.id) });

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
				order = $(this).nestedSortable('toHierarchy');

				// get the group id
				var group = $(this).parents('section').attr('rel');

				// refresh the tree icons - needs a timeout to allow nestedSort
				// to remove unused elements before we check for their existence
				setTimeout(update_tree, 5);

				$.post(SITE_URL + 'admin/navigation/order', { 'order': order, 'group': group } );
			}
		});
	});

})(jQuery);