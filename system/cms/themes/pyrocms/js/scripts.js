/* 

Author: PyroCMS Dev Team

*/

/**
 * Pyro object
 *
 * The Pyro object is the foundation of all PyroUI enhancements
 */
var pyro = {};

jQuery(function($) {

	/**
	 * Overload the json converter to avoid error when json is null or empty.
	 */
	$.ajaxSetup({
		//allowEmpty: true,
		converters: {
			'text json': function(text) {
				var json = jQuery.parseJSON(text);
				if (!jQuery.ajaxSettings.allowEmpty == true && (json == null || jQuery.isEmptyObject(json)))
				{
					jQuery.error('The server is not responding correctly, please try again later.');
				}
				return json;
			}
		}
	});

	/**
	 * This initializes all JS goodness
	 */
	pyro.init = function() {

		$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});

		$("#main-nav li a.top-link").click(function () {
			if($(this).hasClass("no-submenu"))
			{
				return true;
			}
			$(this).parent().find('ul').toggle();
			$(this).parent().siblings().find('ul').hide();
			return false;
		});
		
		$('#main-nav ul li').mouseleave(function(){
			$(this).find('ul').fadeOut();
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
			$(this).fadeIn('slow', function(){
				$(window).trigger('notification-complete');
			});
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
		$(':submit.confirm').live('click', function(e, confirmation){

			if (confirmation)
			{
				return true;
			}

			e.preventDefault();

			var removemsg = $(this).attr('title');

			if (confirm(removemsg || DIALOG_MESSAGE))
			{
				$(this).trigger('click-confirmed');

				if ($(this).data('stop-click')){
					$(this).data('stop-click', false);
					return;
				}

				$(this).trigger('click', true);
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
	};

	pyro.clear_notifications = function()
	{
		$('.notification .close').click();

		return pyro;
	};

	pyro.add_notification = function(notification, options, callback)
	{
		var defaults = {
			clear	: true,
			ref		: '#shortcuts',
			method	: 'after'
		}, opt;
		
		// extend options
		opt = $.isPlainObject(options) ? $.extend(defaults, options) : defaults;

		// clear old notifications
		opt.clear && pyro.clear_notifications();

		// display current notifications
		$(opt.ref)[opt.method](notification);
	
		// call callback
		$(window).one('notification-complete', function(){
			callback && callback();
		});

		return pyro;
	};

	$(document).ajaxError(function(e, jqxhr, settings, exception) {
		pyro.add_notification($('<div class="closable notification error">'+exception+'</div>'));
	});

	$(document).ready(function() {
		pyro.init();
	});
	
	//close colorbox only when cancel button is clicked
	$('#cboxLoadedContent a.cancel').live('click', function(e) {
		e.preventDefault();
		$.colorbox.close();
	});
	
	
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
	$('.html_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'text/html',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});

	$('.css_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'css',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});
	
	$('.js_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'javascript',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});
});