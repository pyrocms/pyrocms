function html_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: ["parsejavascript.js","parsexml.js", "parsecss.js", "parsehtmlmixed.js"],
	    stylesheet: [APPPATH_URI + "assets/css/codemirror/xmlcolors.css", APPPATH_URI + "assets/css/codemirror/csscolors.css"],
	    path: APPPATH_URI + "assets/js/codemirror/",
	    tabMode: 'spaces'
	});
}

function css_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: "parsecss.js",
	    stylesheet: APPPATH_URI + "assets/css/codemirror/csscolors.css",
	    path: APPPATH_URI + "assets/js/codemirror/"
	});
}

function js_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
	    stylesheet: APPPATH_URI + "assets/css/codemirror/jscolors.css",
	    path: APPPATH_URI + "assets/js/codemirror/"
	});
}

var fixHelper;

(function($)
{
	// Return a helper with preserved width of cells
	fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	
	$(function() {
	
		// Sort any tables with a class of 'sortable'
		var table = $('table.table-list');
		
		// A row can be selected via check or CTRL + click
		toggleRowChecked = function(row, checkbox, mode)
		{
			total_checked = $('tbody td input[type="checkbox"]:checked', table).length;
			total_checkboxes = $('tbody td input[type="checkbox"]', table).length;
			check_all = $('thead input[type="checkbox"][name="action_to_all"]', table);
			
			if(mode == 'change')
			{
				checkbox.attr('checked', checkbox.attr('checked'));
			}
			
			else
			{
				checkbox.attr('checked', !checkbox.attr('checked'));
			}
			
			if(!checkbox.attr('checked'))
			{
				// Remove selected class and uncheck the box
				row.removeClass('selected');

				// If all boxes are checked
				if(total_checked == 0)
				{
					console.log('remove ' + !check_all.attr('checked'));
					check_all.attr('checked', false);
				}
			}
		
			else
			{
				// Add seelected and check the box
				row.addClass('selected');
				
				// If all boxes are checked, check the "Check All" box
				if(total_checked == total_checkboxes)
				{
					check_all.attr('checked', true);
				}
				
			}
		}

		// CTRL + Click table select
		$('tbody td', table).click(function(e) {
			if(e.ctrlKey || e.metaKey)
			{
				row = $(this).parent('tr');
				checkbox = row.find('input[type="checkbox"]');
				
				toggleRowChecked(row, checkbox);
			}
		});
		
		// CTRL + Hover should show a pointer hand
		$('tbody td', table).hover(function(e) {
			if(e.ctrlKey || e.metaKey)
			{
				$(this).parent('tr').css('cursor', 'pointer');
			}
		}, function() {
			$(this).parent('tr').css('cursor', '');
		});
		
		
		// Checkbox ticking
		$('tbody td input[type="checkbox"]', table).change(function() {
			row = $(this).parent('td').parent('tr');
			checkbox = $(this);

			toggleRowChecked(row, checkbox, 'change');
		});
		
		// "Check All" checkboxes
		$('thead input[type="checkbox"][name="action_to_all"]', table).change(function() {
		
			$('tbody td input[type="checkbox"]', table).attr('checked', this.checked);
			
			if(this.checked)
			{
				$('tbody tr', table).addClass('selected');
			}
			
			else
			{
				$('tbody tr', table).removeClass('selected');
			}

		});

		$("#dialog-confirm").dialog({
			autoOpen: false,
			modal: true
		});

		confirm_links();
		confirm_buttons();

		// Adds the confirm_dialog handler to all confirm links
		function confirm_links()
		{
			$('a.confirm').click(confirm_dialog);
		}

		// Adds the confirm_dialog handler to all confirm buttons
		function confirm_buttons()
		{
			$('button[type="submit"].confirm, input[type="submit"].confirm').click(confirm_dialog);
		}

		function confirm_dialog(e)
		{
			e.preventDefault();

			var starting_object = $(this);
			var target_url = starting_object.attr("href");

			$("#dialog-confirm").dialog({
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					'Yes': function() {
						$("#dialog-confirm").dialog('close');
						// If it's a link then go to the link
						if(target_url)
						{
							window.location.href = target_url;
						}

						// If its a submit button then submit the form
						else
						{
							starting_object.parents('form').submit();
						}
					},
					'No': function() {
						$("#dialog-confirm").dialog('close');
					}
				}
			});
			$("#dialog-confirm").dialog('open');
		}
	
		$('.tabs').tabs();
		$('#tabs').tabs({
			// This allows for the Back button to work.
			select: function(event, ui) {
				parent.location.hash = ui.tab.hash;
			},
			load: function(event, ui) {
				confirm_links();
				confirm_buttons();
			}
		});

		
	
		$('a.close').live('click', function(){
			$(this).parents(".message").hide("fast");
			return false;
		});
	
		
		/* Control panel menu dropdowns */
		var menu = $("ul#menu li");/** define the main navigation selector **/

		menu.hover(function() {/** build animated dropdown navigation **/
			$(this).find('ul:first').show("fast").css({visibility: "visible", display: "block"});
			$(this).find('a').stop().animate({backgroundPosition:"(0 -40px)"},{duration:150});
			$(this).find('a.top-level').addClass("blue");
		
		},function(){
			$(this).find('ul:first').css({visibility: "hidden", display:"none"});
			$(this).find('a').stop().animate({backgroundPosition:"(0 0)"}, {duration:75});
			$(this).find('a.top-level').removeClass("blue");
		});
		

		$('form#change_language select').change(function(){
			$(this).parent('form').submit();
		});
		
		// Fancybox modal window
		$('a[rel=modal], a.modal').livequery(function() {
			$(this).fancybox({
				overlayOpacity: 0.8,
				overlayColor: '#000',
				hideOnContentClick: false,
				showNavArrows: false,
				autoDimensions: false
			});
		});

		$('a[rel="modal-large"], a.modal-large').livequery(function() {
			$(this).fancybox({
				overlayOpacity: 0.8,
				overlayColor: '#000',
				width: 950,
				height: 600,
				hideOnContentClick: false,
				showNavArrows: false,
				autoDimensions: false
			});
		});
		$("#new_folder").livequery(function() {
			$(this).fancybox({
				hideOnContentClick: false,
			});
		});
		// End Fancybox modal window
		
		/**
		 * Required event handlers for the versioning system
		 *
		 * @author Yorick Peterse - PyroCMS Dev Team
		 */
		// Preview
		$('#btn_preview_revision').click(function()
		{
			// Required variables
			var id 			= $('#use_revision_id').val();
			var preview_url = BASE_URL + 'admin/pages/preview_revision/' + id;
			
			// Ajax time
			$.get(preview_url, function(response)
			{
				// Show the preview using fancybox
				$('#btn_preview_revision').fancybox({
					content: response,
					overlayOpacity: 0.8,
					overlayColor: '#000',
					hideOnContentClick: false
				});
			});
		});
		
		// On compare
	    $('#btn_compare_revisions').click(function()
	    {
	        // Take the ID from both dropdowns
	        var id_1            = $('#compare_revision_1').val();
	        var id_2            = $('#compare_revision_2').val();
	        var compare_url     = BASE_URL + 'admin/pages/compare/' + id_1 + '/' + id_2;

	        // Ajax time
			$.get(compare_url, function(response)
			{
				// Show the preview using fancybox
				$('#btn_compare_revisions').fancybox({
					content: response,
					overlayOpacity: 0.8,
					overlayColor: '#000',
					hideOnContentClick: false
				});
			});    
	    });

	});
	
})(jQuery);