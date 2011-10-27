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

	// Set up an object for caching things
	pyro.cache = {
		// set this up for the slug generator
		url_titles	: {}
	}

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

		// Drop Menu
		$(".topbar ul ul").css({display: "none"});
	
		$(".topbar ul li a").click(function(e){
			$a = $(this).parent(':not(#dashboard-link)');
			($a.find('ul:first:hidden').css({visibility: "visible",display: "none"}).slideDown(400).length > 0) ||
			$a.find('ul:first:visible').slideUp(400);

			if ($a.has('ul').length > 0) {
				e.preventDefault();
			};
		});
		
		$('.topbar ul li').mouseleave(function(){
			$(this).find('ul').slideUp(400);
		});
	
		// Add class to show is dropdown
		$(".topbar ul li:has(ul)").children("a").addClass("menu");

		// Add the close link to all alert boxes
		$('.alert').livequery(function(){
			$(this).append('<a href="#" class="close">close</a>');
		});

		// Close the notifications when the close link is clicked
		$('a.close').live('click', function(e){
			e.preventDefault();
			$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
			$(this).parent().fadeTo(200, 0);
			$(this).parent().slideUp(400, function(){
				$(window).trigger('notification-closed');
				$(this).remove();
			});
		});

		$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});

		// Fade in the notifications
		$('.alert').livequery(function(){
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
			
			// Check all? 
			$(".table_action_buttons .btn").removeAttr('disabled');
		});

		// Table action buttons start out as disabled
		$(".table_action_buttons .btn").attr('disabled', 'disabled');

		// Enable/Disable table action buttons
		$('input[name="action_to[]"], .check-all').live('click', function () {
		
			if( $('input[name="action_to[]"]:checked, .check-all:checked').length >= 1 ){
				$(".table_action_buttons .btn").removeAttr('disabled');
			} else {
				$(".table_action_buttons .btn").attr('disabled', 'disabled');
			}
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

		$('#main, .tabs').livequery(function () {
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
		$('.alert .close').click();

		return pyro;
	};

	pyro.add_notification = function(notification, options, callback)
	{
		var defaults = {
			clear	: true,
			ref		: '#content-body',
			method	: 'prepend'
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
	
	// Used by Pages and Navigation and is available for third-party add-ons.
	// Module must load jquery/jquery.ui.nestedSortable.js and jquery/jquery.cooki.js
	pyro.sort_tree = function($item_list, $url, $cookie, data_callback, post_sort_callback)
	{
		// collapse all ordered lists but the top level
		$item_list.find('ul').children().hide();
		
		// this gets ran again after drop
		var refresh_tree = function() {
			
			// add the minus icon to all parent items that now have visible children
			$item_list.parent().find('ul li:has(li:visible)').removeClass().addClass('minus');
			
			// add the plus icon to all parent items with hidden children
			$item_list.parent().find('ul li:has(li:hidden)').removeClass().addClass('plus');
			
			// remove the class if the child was removed
			$item_list.parent().find('ul li:not(:has(ul))').removeClass();
			
			// call the post sort callback
			post_sort_callback && post_sort_callback();
		}
		refresh_tree();
		
		// set the icons properly on parents restored from cookie
		$($.cookie($cookie)).has('ul').toggleClass('minus plus');
		
		// show the parents that were open on last visit
		$($.cookie($cookie)).children('ul').children().show();
		
		// show/hide the children when clicking on an <li>
		$item_list.find('li').live('click', function()
		{
			$(this).children('ul').children().slideToggle('fast');
			 
			$(this).has('ul').toggleClass('minus plus');
			 
			var items = [];
			 
			// get all of the open parents
			$item_list.find('li.minus:visible').each(function(){ items.push('#' + this.id) });

			// save open parents in the cookie
			$.cookie($cookie, items.join(', '), { expires: 1 });
			 
			 return false;
		});
		
		$item_list.nestedSortable({
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .4,
			placeholder: 'placeholder',
			tabSize: 25,
			listType: 'ul',
			tolerance: 'pointer',
			toleranceElement: '> div',
			stop: function(event, ui) {
				
				post = {};
				// create the array using the toHierarchy method
				post.order = $item_list.nestedSortable('toHierarchy');

				// pass to third-party devs and let them return data to send along
				if (data_callback) {
					post.data = data_callback(event, ui);
				}

				// refresh the tree icons - needs a timeout to allow nestedSort
				// to remove unused elements before we check for their existence
				setTimeout(refresh_tree, 5);
			
				$.post(SITE_URL + $url, post );
			}
		});

	}
	
	pyro.chosen = function()
	{
		// Chosen
		$('select').addClass('chzn');
		$(".chzn").chosen();
	}
	
	// Create a clean slug from whatever garbage is in the title field
	pyro.generate_slug = function(input_form, output_form)
	{
		$(input_form).live('keyup', $.debounce(350, function(){

				data	= { 'title' : $(input_form).val().toLowerCase() };

			if ( ! data.title.length) return;

			if (data.title in pyro.cache.url_titles)
			{
				$(output_form).val(pyro.cache.url_titles[data.title]);

				return;
			}

			$.post(SITE_URL + 'ajax/url_title', data, function(slug){
				pyro.cache.url_titles[data.title] = slug;

				$(output_form).val(slug);
			});

		}));
	}

	$(document).ajaxError(function(e, jqxhr, settings, exception) {
		pyro.add_notification($('<div class="alert error">'+exception+'</div>'));
	});

	$(document).ready(function() {
		pyro.init();
		pyro.chosen();
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