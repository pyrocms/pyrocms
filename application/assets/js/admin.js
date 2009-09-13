(function($)
{
	$(function() {
	
		// Sort any tables with a class of 'sortable'
		$('table.listTable').livequery(function() {
			$(this).tablesorter();
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
	
	
		$('div.tabs').livequery(function() {
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
	
		
		/* Admin left navigation dropdowns */
		/* TODO: PS - This functioanlity is being overritten when AJAXify is bound to the click event. */
		$("#side-nav li:not(.active)").find("ul").hide();
		$("#side-nav .button").click(function(){
			$("#side-nav ul").hide();
			
			li = $(this).parent('li');
			
			if(li.hasClass("active"))
			{
				$(this).parent('li').siblings().removeClass("active").addClass("inactive").find(".expand").removeClass("expanded");
			}
			
			else
			{
				li.removeClass("inactive").addClass("active").find(".expand").addClass("expanded");
				$(this).parent('li').siblings().removeClass("active").addClass("inactive").find(".expand").removeClass("expanded");
				$(this).next("ul").show();
				$(this).parent().removeClass("inactive").addClass("active");
				$(this).find(".expand").addClass("expanded");
			}
			
			return false;
		});
		
		// AJAX Links ----
		$('a.ajax').livequery(function() {
			$(this).each(function() {
				// Takes the BASE URL out of the URL
				$(this).attr('href', $(this).attr('href').replace(BASE_URL, BASE_URI));
			});
			
			$(this).ajaxify({
		         target: '#content',
		         tagToload: '#content',
		         loadHash:'attr:href',
		         title: DEFAULT_TITLE,
		         
		         animateOut:{opacity:'0'},
	             animateOutSpeed:500,
	             animateIn:{opacity:'1'},
	             animateInSpeed:500
			});
		});
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
		
		// Facebox modal window
		$('a[rel*=modal]').livequery(function() {
			$(this).facebox({
				opacity : 0.4,
				loadingImage : APPPATH_URI + "assets/img/facebox/loading.gif",
				closeImage   : APPPATH_URI + "assets/img/facebox/closelabel.gif",
			 });
		});
		// End Facebox modal window

	});
})(jQuery);