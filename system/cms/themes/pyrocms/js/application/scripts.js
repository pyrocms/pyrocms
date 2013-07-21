/*

Author: PyroCMS Dev Team / AI Web Systems, Inc. - Ryan Thompson

*/



/**
 * Messenger defaults
 */

Messenger.options = {
	extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
	theme: 'admin',
}


/**
 * Pyro object
 *
 * The Pyro object is the foundation of all PyroUI enhancements
 */
// It may already be defined in metadata partial
if (typeof(pyro) == 'undefined') {
	var pyro = {};
}


/**
 * Shortcuts
 */

$(window).keypress(function(e) {

	if (e.ctrlKey)
	{
		switch (e.which)
		{
			// Ctrl + S Shortcut = Shortcut
			case 19:
				$("#search-api .search-input").select();
				break;

			// Ctrl + D Shortcut = Dashbaord (+ shift -> new window)
			case 4:
				if (e.shiftKey)
				{
					window.open(SITE_URL + 'admin');
				}
				else
				{
					window.location = SITE_URL + 'admin';
				}
				break;
		}
	}
});



jQuery(function($) {

	// Set up an object for caching things
	pyro.cache = {
		// set this up for the slug generator
		url_titles	: {}
	}

	// Is Mobile?
	pyro.is_mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);

	/**
	 * Overload the json converter to avoid error when json is null or empty.
	 */
	$.ajaxSetup({
		converters: {
			'text json': function(text) {
				var json = $.parseJSON(text);
				if (!$.ajaxSettings.allowEmpty && (json == null || $.isEmptyObject(json)))
				{
					$.error('The server is not responding correctly, please try again later.');
				}
				return json;
			}
		},
		data: {
			csrf_hash_name: $.cookie(pyro.csrf_cookie_name)
		}
	});

	/**
	 * GUI Loading
	 */
	pyro.loading = function($item) {

		// Mark as loading or not
		$item.toggleClass('loading');

		// Append / remove loading cover
		if ($item.hasClass('loading')) {
			$item.append('<div class="is_loading"></div>');
		} else {
			$item.find('.is_loading').remove();
		}
	}

	/**
	 * Hides admin header to avoid overlapping when CKEDITOR is maximized
	 */
	pyro.init_ckeditor_maximize = function() {
		if (typeof CKEDITOR != 'undefined')
		{
			$.each(CKEDITOR.instances, function(instance) {
				CKEDITOR.instances[instance].on('maximize', function(e) {
					if(e.data == 1) //maximize
					{
						$('.	').addClass('hidden');
						$('.cke_button__maximize').addClass('ckeditor-pyro-logo');
					}
					else if(e.data == 2) //snap back
					{
						$('.hide-on-ckeditor-maximize').removeClass('hidden');
						$('.cke_button__maximize').removeClass('ckeditor-pyro-logo');
					}
				});
			});
		}
	};
	
	/**
	 * Autocomplete Search
	 */
	pyro.init_autocomplete_search = function(){

		var results = [];

		var map = {};

		$("#search-api .search-input").typeahead({

			minLength: 3,

			source: function (term, process) {

				return $.getJSON(
					SITE_URL + 'admin/search/ajax_autocomplete',
					{
						term: term
					},
					function (data) {

						$.each(data.results, function(k, v) {

							// For display
							results[k] = '<strong>' + v.title + '</strong><br/><small>' + v.singular + '</small>';

							// For other shit
							map['<strong>' + v.title + '</strong><br/><small>' + v.singular + '</small>'] = v;
						});

						return process(results);
					});
				},
			updater: function (item, event) {
				window.location = map[item].url;
			}
		});
	};

	/**
	 * This initializes all JS goodness
	 */
	pyro.init = function() {

		// Mark has_current for primary navigation
		$('header aside nav#primary ul li ul li.current').closest('ul').closest('li').addClass('has_current');

		// Check all checkboxes in container table or grid
		$(".check-all").bind('click', function () {
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
			$(".table_action_buttons .btn").prop('disabled', false);
		});

		// Table action buttons start out as disabled
		$(".table_action_buttons .btn").prop('disabled', true);

		// Enable/Disable table action buttons
		$('input[name="action_to[]"], .check-all').bind('click', function () {

			if( $('input[name="action_to[]"]:checked, .check-all:checked').length >= 1 ){
				$(".table_action_buttons .btn").prop('disabled', false);
			} else {
				$(".table_action_buttons .btn").prop('disabled', true);
			}
		});

		
		// Confirmation
		$('.confirm').on('click', function(e){
			e.preventDefault();

			var href		= $(this).attr('href'),
				removemsg	= $(this).attr('title');

			if (confirm(removemsg || pyro.lang.dialog_message))
			{
				$(this).trigger('click-confirmed');

				if ($.data(this, 'stop-click')){
					$.data(this, 'stop-click', false);
					return;
				}
				window.location.replace(href);
			}
		});


		//use a confirm dialog on "delete many" buttons
		$(':submit.confirm'.body).on('click', function(event, confirmation){

			if (confirmation)
			{
				return true;
			}

			e.preventDefault();

			var removemsg = $(this).attr('title');

			if (confirm(removemsg || pyro.lang.dialog_message))
			{
				$(this).trigger('click-confirmed');

				if ($(this).data('stop-click')){
					$(this).data('stop-click', false);
					return;
				}

				$(this).trigger('click', true);
			}
		});


		// Handle AJAX Modal
		$(document.body).on('click', '[data-toggle="modal"]', function(e) {

			e.preventDefault();

			// These pile up for some reason
			// when doing subsequent modals
			$('.modal-backdrop').remove();

			// Grab the URL
			var url = $(this).attr('href');

			// If it's a regular modal..
			// leave it
			if (url.indexOf('#') == 0)
			{
				$(url).modal('open');
			}
			else
			{
				var $modal = $('#ajax-modal');

				// Get some potential options
				var options = {};

				if ($(this).data('width') != undefined)
				{
					options.width($(this).data('width'));
				}

				// create the backdrop and wait for next modal to be triggered
				$('body').modalmanager('loading');

				$modal.html('').load(url, function(){
					$modal.modal(options);
				});

				return false;
			}
		});


		// Fire timeago
		$.timeago.settings.allowFuture = true;
		$('abbr.timeago').timeago();
		$(document).ajaxComplete(function(){ $.timeago.settings.allowFuture = true; $('abbr.timeago').timeago(); }); // And after AJAX


		// Remember last tab after reload
		$('[data-persistent-tabs]').find('a[data-toggle="tab"]').on('shown', function(e){
			//save the latest tab using a cookie:
			$.cookie('last_tab', $(e.target).attr('href'));
			$.cookie('last_tab_nav', $(e.target).closest('.nav.nav-tabs').data('persistent-tabs'));
		});

		// Activate latest tab, if it exists:
		if ($.cookie('last_tab') && $.cookie('last_tab_nav')) {
			$('[data-persistent-tabs^="' + $.cookie('last_tab_nav') + '"]').find('a[href=' + $.cookie('last_tab') + ']').tab('show');
		}


		// Collapse / Expand API
		$(document).on('click', '[data-toggle^="toggle"]', function(){

			// What are we toggling?
			var target = $(this).data('target');

			// Change em
			$(target).toggle();

			// Save state if persistent
			if ($(this).data('persistent'))
			{
				$.cookie('toggle' + target, $(target).is(':visible'), { expires: 365, path: '/' });
			}

			// Mark it
			if ($(target).is(':visible'))
			{
				$(this).find('i').removeClass('icon-chevron-' + $(this).data('collapsed-chevron')).addClass('icon-chevron-down');
			}
			else if ($(target).length > 0)
			{
				$(this).find('i').addClass('icon-chevron-down').addClass('icon-chevron-' + $(this).data('collapsed-chevron'));
			}

			// Prevent links
			return false;
		});


		// Handle persistent collapse / expand API on page load
		$('[data-toggle^="toggle"][data-persistent^="true"]').each(function(){

			// Skip ones with explicit status attributes
			if ($(this).data('state') != undefined)
			{
				return true; // same as continue;
			}

			// What are we toggling?
			var target = $(this).data('target');

			// Hidden?
			if ($.cookie('toggle' + target) == "false")	
			{
				$(target).toggle();
			}

			// Mark it
			if ($(target).is(':visible'))
			{
				$(this).find('i').removeClass('icon-chevron-' + $(this).data('collapsed-chevron')).addClass('icon-chevron-down');
			}
			else if ($(target).length > 0)
			{
				$(this).find('i').addClass('icon-chevron-down').addClass('icon-chevron-' + $(this).data('collapsed-chevron'));
			}

		});


		// Handle forced state collapse / expand API on page load
		$('[data-toggle^="toggle"][data-state]').each(function(){

			// What are we toggling?
			var target = $(this).data('target');

			// Toggle appropriatly
			if ($(this).data('state') == 'hidden')
			{
				$(target).hide();
			}
			else
			{
				$(target).show();
			}
		});
	};


	// Set up colorbox
	pyro.colorbox = function()
	{
		// Colorbox modal window
		$('[data-toggle^="colorbox"]').each(function() {

			// Get some options
			var options = { onComplete: function(){ pyro.chosen(); } }

			if ($(this).data('width') != undefined)
			{
				options.width = $(this).data('width');
			}

			if ($(this).data('height') != undefined)
			{
				options.height = $(this).data('height');
			}

			if ($(this).data('maxWidth') != undefined)
			{
				options.maxWidth = $(this).data('maxWidth');
			}
			else
			{
				options.maxWidth = '90%';
			}

			if ($(this).data('maxHeight') != undefined)
			{
				options.maxHeight = $(this).data('maxHeight');
			}
			else
			{
				options.maxHeight = '90%';
			}

			if ($(this).data('href') != undefined)
			{
				options.href = $(this).data('href');
			}

			options.onComplete = function() { pyro.chosen(); }

			$(this).colorbox(options);
		});
	}

	// Used by Pages and Navigation and is available for third-party add-ons.
	// Module must load jquery/jquery.ui.nestedSortable.js and jquery/jquery.cooki.js
	pyro.sort_tree = function($item_list, $url, $cookie, data_callback, post_sort_callback, sortable_opts)
	{
		// set options or create a empty object to merge with defaults
		sortable_opts = sortable_opts || {};
		
		// collapse all ordered lists but the top level
		$item_list.find('ul').children().hide();

		// this gets ran again after drop
		var refresh_tree = function() {

			// add the minus icon to all parent items that now have visible children
			$item_list.find('li:has(li:visible)').removeClass().addClass('minus');

			// add the plus icon to all parent items with hidden children
			$item_list.find('li:has(li:hidden)').removeClass().addClass('plus');
			
			// Remove any empty ul elements
			$('.plus, .minus').find('ul').not(':has(li)').remove();
			
			// remove the class if the child was removed
			$item_list.find("li:not(:has(ul li))").removeClass();

			// call the post sort callback
			post_sort_callback && post_sort_callback();
		}
		refresh_tree();

		// set the icons properly on parents restored from cookie
		$($.cookie($cookie)).has('ul').toggleClass('minus plus');

		// show the parents that were open on last visit
		$($.cookie($cookie)).children('ul').children().show();

		// show/hide the children when clicking on an <li>
		$item_list.find('li').bind('click', function()
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
		
		// Defaults for nestedSortable
		var default_opts = {
			delay: 100,
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
			update: function(event, ui) {

				post = {};
				// create the array using the toHierarchy method
				post.order = $item_list.nestedSortable('toHierarchy');

				// pass to third-party devs and let them return data to send along
				if (data_callback) {
					post.data = data_callback(event, ui);
				}

				// Refresh UI (no more timeout needed)
				refresh_tree();

				$.post(SITE_URL + $url, post );
			}
		};

		// init nestedSortable with options
		$item_list.nestedSortable($.extend({}, default_opts, sortable_opts));
	}

	pyro.chosen = function()
	{
		// Non-mobile only
		if( ! pyro.is_mobile ){

			// Chosen
			$('select:not(.skip)').chosen();
		}
	}

	// Create a clean slug from whatever garbage is in the title field
	pyro.generate_slug = function(input_form, output_form, space_character, disallow_dashes)
	{
		space_character = space_character || '-';

		$(input_form).slugify({ slug: output_form, type: space_character });
	}

	pyro.filter = {
		$content		: $('#filter-stage'),
		// filter form object
		$filter_form	: $('#filters form'),

		//lets get the current module,  we will need to know where to post the search criteria
		f_module		: $('input[name="f_module"]').val(),

		/**
		 * Constructor
		 */
		init: function(){

			$('a.cancel').button();

			//listener for select elements
			$('select', pyro.filter.$filter_form).on('change', function(){

				//build the form data
				form_data = pyro.filter.$filter_form.serialize();

				//fire the query
				pyro.filter.do_filter(pyro.filter.f_module, form_data);
			});

			//listener for keywords
			$('input[type="text"]', pyro.filter.$filter_form).on('keyup', function(){

				//build the form data
				form_data = pyro.filter.$filter_form.serialize();

				pyro.filter.do_filter(pyro.filter.f_module, form_data);
			
			});
	
			//clear filters
			$('a.cancel', pyro.filter.$filter_form).click(function() {
			
					//reset the defaults
					//$('select', filter_form).children('option:first').addAttribute('selected', 'selected');
					$('select', pyro.filter.$filter_form).val('0');
					
					//clear text inputs
					$('input[type="text"]').val('');
			
					//build the form data
					form_data = pyro.filter.$filter_form.serialize();
			
					pyro.filter.do_filter(pyro.filter.f_module, form_data);
			});
			
			//prevent default form submission
			pyro.filter.$filter_form.submit(function(e){
				e.preventDefault(); 
			});

			// trigger an event to submit immediately after page load
			pyro.filter.$filter_form.find('select').first().trigger('change');
		},
	
		//launch the query based on module
		do_filter: function(module, form_data, url){
			form_action	= pyro.filter.$filter_form.attr('action');
			post_url	= form_action ? form_action : SITE_URL + 'admin/' + module;

			if (typeof url !== 'undefined'){
				post_url = url;
			}

			pyro.filter.$content.fadeOut('fast', function(){
				//send the request to the server
				$.post(post_url, form_data, function(data, response, xhr) {
					
					var ct		= xhr.getResponseHeader('content-type') || '',
						html	= '';

					if (ct.indexOf('application/json') > -1 && typeof data == 'object')
					{
						html = 'html' in data ? data.html : '';

						pyro.filter.handler_response_json(data);
					}
					else {
						html = data;
					}

					//success stuff here
					pyro.chosen();
					pyro.filter.$content.html(html).fadeIn('fast');
				});
			});
		},

		handler_response_json: function(json)
		{
			if ('update_filter_field' in json && typeof json.update_filter_field == 'object')
			{
				$.each(json.update_filter_field, pyro.filter.update_filter_field);
			}
		},

		update_filter_field: function(field, data)
		{
			var $field = pyro.filter.$filter_form.find('[name='+field+']');

			if ($field.is('select'))
			{
				if (typeof data == 'object')
				{
					if ('options' in data)
					{
						var selected, value;

						selected = $field.val();
						$field.children('option').remove();

						for (value in data.options)
						{
							$field.append('<option value="' + value + '"' + (value == selected ? ' selected="selected"': '') + '>' + data.options[value] + '</option>');
						}
					}
				}
			}
		}
	};

	$(document).ready(function() {
		pyro.init();
		pyro.colorbox();
		pyro.chosen();
		pyro.filter.init();
		pyro.init_ckeditor_maximize();
		pyro.init_autocomplete_search();
	});


	// Bootstrap tooltips
	$('[data-toggle^="tooltip"]').tooltip();

	// Bootstrap popovers
	$('[data-toggle^="popover"]').popover();
	$(document).ajaxComplete(function(){ $('[data-toggle^="popover"]').popover(); }); // And after AJAX

	// Bootstrap datepicker
	$('[data-toggle^="datepicker"]').datepicker();

	// Bootstrap timepicker
	$('[data-toggle^="timepicker"]').timepicker();
	
	// Onmouseover tabs
	$('.nav.nav-tabs.mouseover li a').bind('mouseover', function(){ $(this).trigger('click'); });

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