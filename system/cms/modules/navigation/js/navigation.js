(function($) {

	$(function() {

		//shows (slides down) a container, anim_speed is optional (default 600)
		var show_box = function($box, anim_speed)
		{
			anim_speed = anim_speed == undefined ? 600 : anim_speed;
			$box.slideDown(anim_speed).removeClass('collapsed');
		}

		//shows (slides down) a container, anim_speed is optional (default 600)
		var hide_box = function($box)
		{
			$box.slideUp(600).addClass('collapsed');
		}		

		//saves the 'state' of some elements in the navigation admin
		var save_state = function()
		{
			var attrs = {'box': 0, 'navigation': '', 'tree': []};

			$("#content .box .item").each(
				function(idx, ele) {
					if(!$(ele).hasClass('collapsed')) {
						attrs['box'] = idx;
						attrs['navigation'] = $(ele).find("#link-list a.selected").closest('li').attr("id");
						$('.box .item').find('li.minus').each(function(){ attrs['tree'].push('#' + this.id) });
						//since there can be only one opened .item, we're done here
						return;
					}
				}
			);

			return attrs;
		}

		//restores the 'state' of some elements in the navigation admin
		var restore_state = function(attrs)
		{
			$boxes = $(".box .item");
			$boxes.addClass('collapsed');

			//there is always an open container, but not always a selected navigation element (create)
			if(attrs['navigation'] != '')
			{
				var a_alt = attrs['navigation'].substr(attrs['navigation'].lastIndexOf('_')+1);
				$("#" + attrs['navigation'] + " a[alt=" + a_alt + "]").click();	
			}

			if(attrs['tree'].length > 0)
			{
				for(var x=0;x<attrs['tree'].length;x++) {
					//again, just click it
					$(attrs['tree']).click();	
				}			
			}

			//show the previously opened box
			show_box($boxes.eq(attrs['box']), 0);
		};

		//reloads the content of the navigation admin
		var reload_content = function()
		{
			$.ajax({
				url: window.location,
				method: 'GET',
				dataType: 'HTML',
				success: function(data) {

					//save the state of the navigation pane, reload the pane and restore the state
					$state = save_state();
					$("#content-body").html($(data).find("#content-body").html());
					restore_state($state);

					//check if a notification should be display
					var $notification = $(".notification", data);
					if($notification.length > 0) {
						$("#content").prepend($notification);
					}

					//re-initialise all the stuff in the navigation content
					init_navigation_content(true);
				}
			});			
		}

	
		//this gets ran again after drop
		var update_tree = function()
		{
			// add the minus icon to all parent items that now have visible children
			$('#link-list ul').children('li:has(li:visible)').removeClass().addClass('minus');

			// add the plus icon to all parent items with hidden children
			$('#link-list ul').children('li:has(li:hidden)').removeClass().addClass('plus');

			// remove the class if the child was removed
			$('#link-list ul').children('li:not(:has(ul))').removeClass();

			// refresh the link details pane if it exists
			if($('#link-details #link-id').val() > 0)
			{
				// Load the details box in
				$('div#link-details').load(SITE_URL + 'admin/navigation/ajax_link_details/' + $('#link-details #link-id').val());
			}
		}

		var init_navigation_content = function(restore)
		{
			if(!restore) {
				// collapse all ordered lists but the top level, but only if we didn't to a restore
				$('#link-list ul:not(.sortable)').children().hide();			
			}

			$('ul.sortable').nestedSortable({
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
			
			update_tree();		
		}	

		// show and hide the sections
		$('.box .title').live('click', function()
		{
			//check first if we have to open the container which fired the click event
			var open_this = $(this).next('.box .item').hasClass('collapsed');
			hide_box($('.box .item'));
			if (open_this) {
				show_box($($(this).next('.collapsed')));
			}
		});

		// load edit via ajax
		$('a.ajax').live('click', function(e)
		{
			e.preventDefault();

			// make sure we load it into the right one
			var id = $(this).attr('rel');

			if ($(this).hasClass('add')) {
				// if we're creating a new one remove the selected icon from link in the tree
				$('.group-'+ id +' #link-list a').removeClass('selected');
				// and check if the container is visible
				var $box = $('.group-'+ id);
				if($box.find('.item').hasClass('collapsed')) {
					$box.find('.title').click();
				}
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
		$('#nav-create button[type=submit]').live('click', function(e)
		{
			e.preventDefault();

			$.post(SITE_URL + 'admin/navigation/create', $('#nav-create').serialize(), function(message){
				// if message is simply "success" then it's a go. Reload!
				if (message == 'success') {
					reload_content();
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
				// if message is simply "success" then it's a go. Reload!
				if (message == 'success') {
					reload_content();
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
		$('input[name="link_type"]').live('change', function()
		{
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
	
		// show/hide the children when clicking on an <li>
		$('#link-list li').live('click', function()
		{
			$(this).children('ul').children().slideToggle('fast');

			$(this).has('ul').toggleClass('minus plus');

			 return false;
		});	

		//initialisation
		$boxes = $(".box .item");
		$boxes.addClass('collapsed');
		// show the first box with js to get around page jump
		show_box($boxes.first(), 0);

		init_navigation_content();

	});

})(jQuery);