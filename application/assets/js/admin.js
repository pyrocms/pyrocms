function html_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: ["parsexml.js", "parsecss.js", "parsehtmlmixed.js"],
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

(function($)
{
	$(function() {
	
		// Sort any tables with a class of 'sortable'
		$('table.table-list').livequery(function() {
			
			var table = this;
			
			// TODO PJS Removed as it only sorted the current page, and was breaking some inputs
			//($("thead th", table).length === $('tbody td', table).length) && $(table).tablesorter();
			
			// A row can be selected via check or CTRL + click
			toggleRowChecked = function(row, checkbox)
			{
				total_checked = $('tbody td input[type="checkbox"]:checked', table).length;
				total_checkboxes = $('tbody td input[type="checkbox"]', table).length;
				
				if(row.hasClass('selected'))
				{
					// Remove selected class and uncheck the box
					row.removeClass('selected');
					checkbox.removeAttr('checked');

					// If all boxes are checked
					if(total_checked === 0)
					{
						$('thead input[type="checkbox"][name="action_to_all"]', table).removeAttr('checked');
					}
				}
			
				else
				{
					// Add seelected and check the box
					row.addClass('selected');
					checkbox.attr('checked', true);
					
					// If all boxes are checked, check the "Check All" box
					if(total_checked == total_checkboxes)
					{
						$('thead input[type="checkbox"][name="action_to_all"]', table).attr('checked', true);
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
			
			// Checkbox ticking
			$('tbody td input[type="checkbox"]', table).change(function() {
				row = $(this).parent('td').parent('tr');
				checkbox = $(this);

				toggleRowChecked(row, checkbox);
			});
			
			// "Check All" checkboxes
			$('thead input[type="checkbox"][name="action_to_all"]', table).change(function() {
				
				if( $(this).attr('checked') == true )
				{
					$('tbody td input[type="checkbox"]:not(:checked)', table).change();
				}
				
				else
				{
					$('tbody td input[type="checkbox"]:checked', table).change();
				}
			});
			
		});
		
		// Link confirm box
		$('a.confirm').live('click', function(e) {
		
			/*e.preventDefault();
				
				link = this;
				modal_confirm("Are you sure you wish to delete this item?", function () {
					window.location.href = $(link).attr('href');
				});
			*/
			
			return confirm('Are you sure you wish to delete this item?');
		});
		
		// Form submit confirm box
		$('button[type="submit"].confirm, input[type="submit"].confirm').live('click', function(e) {
			/*	e.preventDefault();
				
				button = this;
				confirm("Are you sure you wish to delete these items?", function () {
					$(button).parents('form').submit();
				});
			*/
	
			return confirm('Are you sure you wish to delete these items?');
		});
	
	
		$('.tabs').livequery(function() {
			$(this).tabs();
		});
		
	
		$('a.close').live('click', function(){
			$(this).parents(".message").hide("fast");
			return false;
		});
	
		/* This was part of the design but is not used
		 * $('.tooltip').livequery(function() {
			$(this).tooltip({  
				showBody:	" - ",
				showURL:	false
			});
		});*/
	
		
		/* Control panel menu dropdowns */
		var menu = $("ul#menu li");/** define the main navigation selector **/

		/*
		$('a', menu).click(function(){
			$(this).parent('li')
				.addClass("selected")
				.siblings().removeClass("selected");
				
			return false;
		});
		*/
		
		menu.hover(function() {/** build animated dropdown navigation **/
			$(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).show("fast");
			$(this).find('a').stop().animate({backgroundPosition:"(0 -40px)"},{duration:150});
			$(this).find('a.top-level').addClass("blue");
		
		},function(){
			$(this).find('ul:first').css({visibility: "hidden", display:"none"});
			$(this).find('a').stop().animate({backgroundPosition:"(0 0)"}, {duration:75});
			$(this).find('a.top-level').removeClass("blue");
		});
		
		// AJAX Links ----
		/*
		$('a.ajax').livequery(function() {
			$(this).each(function() {
				// Takes the BASE URL out of the URL
				$(this).attr('href', $(this).attr('href').replace(BASE_URL, BASE_URI));
			});
			
			$(this).ajaxify({
				target: '#content',
				tagToload: '#content',
				loadHash: 'attr:href',
				title: DEFAULT_TITLE,
				cache: false,
				animateOut: {opacity: '0'},
				animateOutSpeed: 500,
				animateIn: {opacity: '1'},
				animateInSpeed:500
			});
		});
		*/
		// End AJAX links ----
	
		$('.languageSelector a').click(function()
		{
			// If AJAXify has been run on this page and there is a link hash, use it.
			if(window.location.hash != '' & window.location.hash.substring(0, 2) == '#/')
			{
				window.location.href = window.location.hash.replace('#', '') + $(this).attr('href');
				return false;
			}
		});
		
		// Fancybox modal window
		$('a[rel=modal], a.modal').livequery(function() {
			$(this).fancybox({
				overlayOpacity: 0.8,
				overlayColor: '#000',
				hideOnContentClick: false
			});
		});
		
		$('a[rel="modal-large"], a.modal-large').livequery(function() {
			$(this).fancybox({
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
