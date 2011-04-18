/**
 * Pyro object
 *
 * The Pyro object is the foundation of all PyroUI enhancements
 */
var pyro = {};

jQuery(function($) {

	/**
	 * This initializes all JS goodness
	 */
	pyro.init = function() {
		$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
		$("#main-nav li ul").hide();
		$("#main-nav li a.current").parent().find("ul").toggle();
		$("#main-nav li a.current:not(.no-submenu)").addClass("bottom-border");

		$("#main-nav li a.top-link").click(function () {
			if($(this).hasClass("no-submenu"))
			{
				return false;
			}
			$(this).parent().siblings().find("ul").slideUp("normal");
			$(this).parent().siblings().find("a").removeClass("bottom-border");
			$(this).next().slideToggle("normal");
			$(this).toggleClass("bottom-border");
			return false;
		});

		$("#main-nav li a.no-submenu").click(function () {
			window.location.href = $(this).attr("href");
			return false;
		});

		// Add the close link to all boxes with the closable class
		$('.closable').livequery(function(){
			$(this).append('<a href="#" class="close">close</a>');
		});

		// Close the notifications when the close link is clicked
		$('a.close').live('click', function(e){
			e.preventDefault();
			$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
			$(this).parent().fadeTo(200, 0);
			$(this).parent().slideUp(400, function(){
				$(this).remove();
			});
		});

		// Fade in the notifications
		$('.notification').livequery(function(){
			$(this).fadeIn('slow');
		});

		// Check all checkboxes in container table or grid
		$(".check-all").live('click', function () {
			var check_all		= $(this),
				all_checkbox	= $(this).is('.grid-check-all')
					? $(this).parents(".list-items").find(".grid input[type='checkbox']")
					: $(this).parents("table").find("tbody input[type='checkbox']");

			all_checkbox.each(function () {
				if (check_all.is(":checked") && ! $(this).is(':checked'))
				{
					$(this).click();
				}
				else if ( ! check_all.is(":checked") && $(this).is(':checked'))
				{
					$(this).click();
				}
			});

			// Update uniform if enabled
			$.uniform && $.uniform.update();
		});

		// Confirmation
		$('a.confirm').live('click', function(e){
			e.preventDefault();

			var href		= $(this).attr('href'),
				removemsg	= $(this).attr('title');

			if (confirm(removemsg || DIALOG_MESSAGE))
			{
				$(this).trigger('click-confirmed');

				if ($.data(this, 'stop-click')){
					$.data(this, 'stop-click', false);
					return;
				}

				//submits it whether uniform likes it or not
				window.location.replace(href);
			}
		});
		
		//use a confirm dialog on "delete many" buttons
		$(':submit.confirm').live('click', function(e){

			if ($.data(this, 'confirmed'))
			{
				$.data(this, 'confirmed', false);

				return true;
			}

			e.preventDefault();

			var removemsg = $(this).attr('title');

			if (confirm(removemsg || DIALOG_MESSAGE))
			{
				$.data(this, 'confirmed', true).click();
			}
		});

		// Table zerbra striping
		$("tbody tr:nth-child(even)").livequery(function () {
			$(this).addClass("alt");
		});

		$('.tabs').livequery(function () {
			$(this).tabs();
		});
		$('#tabs').livequery(function () {
			$(this).tabs({
				// This allows for the Back button to work.
				select: function(event, ui) {
					parent.location.hash = ui.tab.hash;
				},
				load: function(event, ui) {
					confirm_links();
					confirm_buttons();
				}
			});
		});

		$("select, textarea, input[type=text], input[type=file], input[type=submit]").livequery(function(){
			$(this).not('.no-uniform').uniform().addClass('no-uniform');
		});

		var current_module = $('#page-header h1 a').text();
		// Fancybox modal window
		$('a[rel=modal], a.modal').livequery(function() {
			$(this).colorbox({
				width: "60%",
				maxHeight: "90%",
				current: current_module + " {current} / {total}"
			});
		});

		$('a[rel="modal-large"], a.modal-large').livequery(function() {
			$(this).colorbox({
				width: "90%",
				height: "95%",
				iframe: true,
				scrolling: false,
				current: current_module + " {current} / {total}"
			});
		});
		// End Fancybox modal window
	}

	$(document).ready(function() {
		pyro.init();
	});
	
	//close colorbox only when cancel button is clicked
	$('#cboxLoadedContent a.cancel').live('click', function(e) {
		e.preventDefault();
		$.colorbox.close();
	});
});

//functions for codemirror
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


/*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);