/* 

Author: PyroCMS Dev Team

*/

// Title toggle
$('a.toggle').click(function() {
   $(this).parent().next('.item').slideToggle(500);
});

// Draggable / Droppable
$("#sortable").sortable({ 
	placeholder : 'dropzone',
    handle : '.draggable', 
    update : function () { 
      var order = $('#sortable').sortable('serialize'); 
    } 
}); 
	
// Drop Menu
$(".topbar ul ul").css({display: "none"});

$(".topbar ul li").hover(function(){
	$(this).find('ul:first').css({visibility: "visible",display: "none"}).stop(true,true).slideDown(400);
},function(){
	$(this).find('ul:first').css({visibility: "visible"}).stop(true,true).slideUp(400);
});

// Disable Parent li if has child items
$(".topbar ul li:has(ul)").hover(function () {
	$(this).children("a").click(function () {
		return false;
	});
});

// Add class to show is dropdown
$(".topbar ul li:has(ul)").children("a").addClass("menu");

// Pretty Photo
$('#main a:has(img)').addClass('prettyPhoto');
$("a[class^='prettyPhoto']").prettyPhoto();

// Tipsy
$('.tooltip').tipsy({
	gravity: $.fn.tipsy.autoNS,
	fade: true,
	html: true
});

$('.tooltip-s').tipsy({
	gravity: 's',
	fade: true,
	html: true
});

$('.tooltip-e').tipsy({
	gravity: 'e',
	fade: true,
	html: true
});

$('.tooltip-w').tipsy({
	gravity: 'w',
	fade: true,
	html: true
});

// Tabs
$( "#main" ).tabs();

// Chosen
$('select').addClass('chzn');
$(".chzn").chosen();

//functions for codemirror
function html_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: ["parsejavascript.js","parsexml.js", "parsecss.js", "parsehtmlmixed.js"],
	    stylesheet: [pyro.admin_theme_url + "/css/codemirror/xmlcolors.css", pyro.admin_theme_url + "/css/codemirror/csscolors.css"],
	    path: pyro.admin_theme_url,
	    tabMode: 'spaces'
	});
}

function css_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: "parsecss.js",
	    stylesheet: pyro.admin_theme_url + "/css/codemirror/csscolors.css",
	    path: pyro.admin_theme_url
	});
}

function js_editor(id, width)
{
	CodeMirror.fromTextArea(id, {
	    height: "30em",
	    width: width,
	    parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
	    stylesheet: pyro.admin_theme_url + "/css/codemirror/jscolors.css",
	    path: pyro.admin_theme_url
	});
}