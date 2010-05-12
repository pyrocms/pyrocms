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

var fixHelper;

jQuery(document).ready(function()
{
	// Return a helper with preserved width of cells
	fixHelper = function(e, ui) {
		ui.children().each(function() {
			jQuery(this).width(jQuery(this).width());
		});
		return ui;
	};
	
	jQuery(function() {
	
		// Sort any tables with a class of 'sortable'
		var table = jQuery('table.table-list');
		
		// A row can be selected via check or CTRL + click
		toggleRowChecked = function(row, checkbox, mode)
		{
			total_checked = jQuery('tbody td input[type="checkbox"]:checked', table).length;
			total_checkboxes = jQuery('tbody td input[type="checkbox"]', table).length;
			check_all = jQuery('thead input[type="checkbox"][name="action_to_all"]', table);
			
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
		jQuery('tbody td', table).click(function(e) {
			if(e.ctrlKey || e.metaKey)
			{
				row = jQuery(this).parent('tr');
				checkbox = row.find('input[type="checkbox"]');
				
				toggleRowChecked(row, checkbox);
			}
		});
		
		// CTRL + Hover should show a pointer hand
		jQuery('tbody td', table).hover(function(e) {
			if(e.ctrlKey || e.metaKey)
			{
				jQuery(this).parent('tr').css('cursor', 'pointer');
			}
		}, function() {
			jQuery(this).parent('tr').css('cursor', '');
		});
		
		
		// Checkbox ticking
		jQuery('tbody td input[type="checkbox"]', table).change(function() {
			row = jQuery(this).parent('td').parent('tr');
			checkbox = jQuery(this);

			toggleRowChecked(row, checkbox, 'change');
		});
		
		// "Check All" checkboxes
		jQuery('thead input[type="checkbox"][name="action_to_all"]', table).change(function() {
		
			jQuery('tbody td input[type="checkbox"]', table).attr('checked', this.checked);
			
			if(this.checked)
			{
				jQuery('tbody tr', table).addClass('selected');
			}
			
			else
			{
				jQuery('tbody tr', table).removeClass('selected');
			}

		});
		
		// Link confirm box
		jQuery('a.confirm').live('click', function(e) {
		
			/*e.preventDefault();
				
				link = this;
				modal_confirm("Are you sure you wish to delete this item?", function () {
					window.location.href = jQuery(link).attr('href');
				});
			*/
			
			return confirm('Are you sure you wish to delete this item?');
		});
		
		// Form submit confirm box
		jQuery('button[type="submit"].confirm, input[type="submit"].confirm').live('click', function(e) {
			/*	e.preventDefault();
				
				button = this;
				confirm("Are you sure you wish to delete these items?", function () {
					jQuery(button).parents('form').submit();
				});
			*/
	
			return confirm('Are you sure you wish to delete these items?');
		});
	
	
		jQuery('.tabs').tabs();
		jQuery('#tabs').tabs();

		
	
		jQuery('a.close').live('click', function(){
			jQuery(this).parents(".message").hide("fast");
			return false;
		});
	
		
		/* Control panel menu dropdowns */
		var menu = jQuery("ul#menu li");/** define the main navigation selector **/

		menu.hover(function() {/** build animated dropdown navigation **/
			jQuery(this).find('ul:first').show("fast").css({visibility: "visible", display: "block"});
			jQuery(this).find('a').stop().animate({backgroundPosition:"(0 -40px)"},{duration:150});
			jQuery(this).find('a.top-level').addClass("blue");
		
		},function(){
			jQuery(this).find('ul:first').css({visibility: "hidden", display:"none"});
			jQuery(this).find('a').stop().animate({backgroundPosition:"(0 0)"}, {duration:75});
			jQuery(this).find('a.top-level').removeClass("blue");
		});
		

		jQuery('form#change_language select').change(function(){
			jQuery(this).parent('form').submit();
		});
		
		// Fancybox modal window
		jQuery('a[rel=modal], a.modal').livequery(function() {
			jQuery(this).fancybox({
				overlayOpacity: 0.8,
				overlayColor: '#000',
				hideOnContentClick: false
			});
		});
		
		jQuery('a[rel="modal-large"], a.modal-large').livequery(function() {
			jQuery(this).fancybox({
				overlayOpacity: 0.8,
				overlayColor: '#000',
				hideOnContentClick: false,
				frameWidth: 900,
				frameHeight: 600
			});
		});
		// End Fancybox modal window

	});
	
})(jQuery);