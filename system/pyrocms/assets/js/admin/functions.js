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
		$(".closable").append('<a href="#" class="close">close</a>');

		// Close the notifications when the close link is clicked
		$("a.close").live('click', function () {
			$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
			$(this).parent().fadeTo(200, 0);
			$(this).parent().slideUp(400);
			return false;
		});

		// Fade in the notifications
		$(".notification").fadeIn("slow");

		// Check all checkboxes in table
		$(".check-all").live('click', function () {
			$(this).parents("table").find("tbody input[type='checkbox']").each(function () {
				if($(".check-all").is(":checked") && !$(this).is(':checked'))
				{
					$(this).click();
				}
				else if(!$(".check-all").is(":checked") && $(this).is(':checked'))
				{
					$(this).click();
				}
			});
			$.uniform.update();
		});

		// Confirmation
		$("a.confirm").live('click', function(){
			removemsg = $("em").attr("title");
			if (removemsg === undefined) {
				var answer = confirm(DIALOG_MESSAGE);
			} else {
				var answer = confirm(removemsg);
			}

			if (answer) {
				return true;
			}
			return false;
		});
		
		//minibutton fix
		$("a.minibutton, a.button").live('click', function(e) {
			e.preventDefault();
			window.location.href = $(this).attr("href");
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
		$("select, input[type=checkbox], input[type=radio], input[type=file], input[type=submit], a.button, a.minibutton, button, textarea").livequery(function () {
			$(this).uniform();
		});
	}

	$(document).ready(function() {
		pyro.init();
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