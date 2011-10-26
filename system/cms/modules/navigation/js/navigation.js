(function($) {

	$(function() {

		//shows (slides down) a container, anim_speed is optional (default 600)
		var show_box = function($box, anim_speed)
		{
			anim_speed = anim_speed == undefined ? 600 : anim_speed;
			$box.slideDown(anim_speed).removeClass('collapsed');
		}

		//hides (slides uo) a container
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
						pyro.add_notification($notification.find('p').text());
					}

					pyro.refresh_sort_tree($('ul.sortable'));
				}
			});			
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
		$('a.ajax').live('click', function()
		{
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
				$('section.box .title h4.group-title-'+id).html(title);

				// Update Chosen
				pyro.chosen();
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
					alert(message).html();
					pyro.add_notification($('<div class="alert error">').html($(message).find('p').text()));
				}
			});
		});

		// submit edit form via ajax
		$('#nav-edit button:submit').live('click', function(e)
		{
			e.preventDefault();
			$.post(SITE_URL + 'admin/navigation/edit/' + $('input[name="link_id"]').val(), $('#nav-edit').serialize(), function(message){
				// if message is simply "success" then it's a go. Reload!
				if (message == 'success') {
					reload_content();
				}
				else {
					pyro.add_notification($('<div class="alert error">').html($(message).find('p').text()));
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

		//initialisation
		var $boxes = $(".box .item");
		$boxes.addClass('collapsed');
		// show the first box with js to get around page jump
		show_box($boxes.first(), 0);

		$data_callback = function(event, ui) {
			// Grab the group id so we can update the right links
			return { 'group' : ui.item.parents('section.box').attr('rel') };
		}	
		
		$item_list = $('ul.sortable');
		$url = 'admin/navigation/order';
		$cookie = 'open_links';

		// $post_callback is available but not needed here

		// Get sortified
		pyro.sort_tree($item_list, $url, $cookie, $data_callback);			

	});

})(jQuery);