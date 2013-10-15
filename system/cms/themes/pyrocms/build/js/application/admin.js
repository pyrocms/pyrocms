/**
 * Admin
 *
 * Supporting JS for PyroCMS /admin
 */


/**
 * Initialize our application
 * - Set up listeners, etc
 */

Pyro.Initialize = function() {

	/**
	 * We're loading
	 */
	
	Pyro.Loading();

	$(document).on('click', 'a[href^="http"][target!="_blank"]:not([data-toggle="modal"])', function(e) {
		
		// Could be opening in a new window
		if (e.ctrlKey) return true;
		if (e.altKey) return true;
		if (e.metaKey) return true;

		Pyro.Loading();
	});


	/**
	 * Mobile Detection
	 */
	
	Pyro.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

	// For development
	//Pyro.isMobile = true;


	/**
	 * Collapse Tabs
	 * - For mobiles, collapse tabs to accordian
	 */
	
	if (Pyro.isMobile) {
		$('.nav.nav-tabs').tabCollapse();
		$('.nav.nav-tabs').remove(); // This prevents WYSIWYG errors
		$('.tab-content').remove(); // This prevents WYSIWYG errors
	}


	/**
	 * Sortable Lists
	 */
	
	$('.sortable').nestable();


	/**
	 * Just in case there's a form - focus on the fist input
	 */
	
	$(document).ready(function() {
		$('.input :input:visible:first').focus();
	});


	/**
	 * Toggle Classes
	 */

	$(document).on('click', '[data-toggle^="class:"]', function(e) {

		e.preventDefault();
		$($(this).attr('data-target')).toggleClass($(this).attr('data-toggle').replace('class:', ''));

		// Save persistent state
		if ($(this).attr('data-persistent') !== undefined)
			$.cookie('persistent_' + $(this).attr('data-persistent'), $($(this).attr('data-target')).hasClass($(this).attr('data-toggle').replace('class:', '')), { path: '/' });
	});


	/**
	 * Selectize
	 */
	
	$('select:not(.skip)').selectize();
	$('input[type="text"].tags').selectize({
		delimiter: ',',
		create: function(input) {
			return {
				value: input,
				text: input
			}
		}
	});


	/**
	 * Zen Inputs
	 */
	$('textarea[class="zen"]').each(function(){
		var random = Math.floor(Math.random()*111) + '_zen';
		$(this).zenForm().addClass(random).before('<a href="#" data-toggle="zen-mode" data-target=".' + random + '">Test</a>');
	});

	$(document).on('click', '[data-toggle^="zen-mode"]', function(e) {
		e.preventDefault();
		$($(e.target).attr('data-target')).trigger('init');
	});


	/**
	 * Select All Actions
	 */
	
	$(document).on('click', 'input[type="checkbox"].check-all', function(e) {
		$(e.target).closest('table').find('input[type="checkbox"][name="action_to[]"]').prop('checked', $(e.target).prop('checked'));
	});


	/**
	 * Tooltips
	 */
	
	$('[data-toggle="tooltip"]').tooltip();


	/**
	 * Popovers
	 */
	
	$(document).on('click', '[data-toggle="popover"]', function(e){e.preventDefault();});
	$('[data-toggle="popover"]').popover();


	/**
	 * Confirmation Trigger
	 */
	
	$(document).on('click', '.confirm', function(e){
		
		var href = $(this).attr('href');
		var removemsg = $(this).attr('title');

		if (confirm(removemsg || Pyro.lang.dialog_message)) {
			$(this).trigger('click-confirmed');

			if ($.data(this, 'stop-click')){
				$.data(this, 'stop-click', false);
				return;
			}
		} else {
			e.preventDefault();
			return false;
		}
	});


	/**
	 * Register Hot-Keys
	 */
	
	$(document).on('keyup', function(e) {
		
		// Ignore if we're typing or selecting something
		if ($('input, textarea, select').is(':focus')) { return true; }
		if (window.getSelection() != '') { return true; }

		// Get the character key
		var key = String.fromCharCode(e.which).toLowerCase();

		//alert(e.which);

		// Catch some funky ones
		if (e.which == 186) key = ':';
		if (e.which == 191) key = '/';

		// Detect special keys
		if (e.which == 13) key = 'enter';

		// Shift?
		if (e.shiftKey) key = 'shift+' + key;

		// Shift?
		if (e.ctrlKey) key = 'ctrl+' + key;

		// Gotta exist
		if ($('[data-hotkey^="' + key + '"]').length == 0) return true;

		// If it has a click event - trigger it
		if($('[data-hotkey^="' + key + '"]').attr('data-follow') == 'yes') {
			Pyro.Loading();
			window.location = $('[data-hotkey="' + key + '"]').attr('href');
		} else {
			$('[data-hotkey^="' + key + '"]').trigger('click');
		}
	});


	/**
	 * Search stuff
	 */
	
	$('#search .search-terms').selectize({
		delimiter: '|',
		create: function(input) {
			return {
				value: input,
				text: input
			}
		}
	});
	
	$(document).on('click', '[data-toggle^="global-search"]', function(e) {
		e.preventDefault();
		$('body').removeClass('nav-off-screen').toggleClass('search-off-screen');
		$('#search .search-terms').val('');
		$('#search .selectize-input input').focus();
	});

	$(document).on('click', '[data-toggle^="module-search"]', function(e) {
		e.preventDefault();
		$('body').removeClass('nav-off-screen').toggleClass('search-off-screen');
		$('#search .selectize-input input').val(Pyro.current_module + ':').focus();

		// Spoof a keypress
		var e = $.event('keydown');

		// (enter)
		e.which = 13;

		// Trigger it
		$('#search .selectize-input input').trigger(e);
	});

	$('#search .search-terms').on('change', function(e) {

		if ($(e.target).val().length != 0) {
			Pyro.Search();
		}
	});


	/**
	 * Code Editors
	 */
	
	$('[data-editor]').each(function() {

		// Spawn an ID
		var id = Math.floor(Math.random()*111) + '_' + $(this).attr('data-editor') + '_editor';

		// Get the language
		var language = $(this).attr('data-editor');

		// Add the ID
		$(this).attr('data-editor', id).hide().after('<div id="' + id + '" class="editor" style="height: 500px;"></div>');

		// Span an editor
		var editor = ace.edit(id);

		ace.config.set('basePath', 'system/cms/themes/pyrocms/build/js/plugins/ace/');
		editor.setTheme('ace/theme/xcode');
		editor.getSession().setMode('ace/mode/' + language);

		// Set the current value
		editor.setValue($(this).val());
	});
}


/**
 * Loading
 * - Pass boolean
 * - Prevents clicking
 */

Pyro.Loading = function(loading) {

	// Catch default
	if (loading == undefined) loading = true;

	if (loading)
		$('#loading').addClass('animated-fast pulse').fadeIn(200);
	else
		$('#loading').removeClass().fadeOut(200);
}


/**
 * Generate a slug from text
 */

Pyro.GenerateSlug = function(input_form, output_form, space_character, disallow_dashes) {
	
	var slug, value;

	$(document).on('keyup', input_form, function(){
		value = $(input_form).val();

		if ( ! value.length ) return;
		space_character = space_character || '-';
		disallow_dashes = disallow_dashes || false;
		var rx = /[a-z]|[A-Z]|[0-9]|[áàâąбćčцдđďéèêëęěфгѓíîïийкłлмñńňóôóпúùûůřšśťтвýыžżźзäæœчöøüшщßåяюжαβγδεέζηήθιίϊκλμνξοόπρστυύϋφχψωώ]/,
			value = value.toLowerCase(),
			chars = Pyro.foreign_characters,
			space_regex = new RegExp('[' + space_character + ']+','g'),
			space_regex_trim = new RegExp('^[' + space_character + ']+|[' + space_character + ']+$','g'),
			search, replace;
		

		// If already a slug then no need to process any further
		if (!rx.test(value)) {
			slug = value;
		} else {
			value = $.trim(value);

			for (var i = chars.length - 1; i >= 0; i--) {
				// Remove backslash from string
				search = chars[i].search.replace(new RegExp('/', 'g'), '');
				replace = chars[i].replace;

				// create regex from string and replace with normal string
				value = value.replace(new RegExp(search, 'g'), replace);
			};



			slug = value.replace(/[^-a-z0-9~\s\.:;+=_]/g, '')
						.replace(/[\s\.:;=+]+/g, space_character)
						.replace(space_regex, space_character)
						.replace(space_regex_trim, '');

			// Remove the dashes if they are
			// not allowed.
			if (disallow_dashes)
			{
				slug = slug.replace(/-+/g, '_');
			}
		}

		$(output_form).val(slug);
	});
}


/**
 * Search
 */

Pyro.Search = function() {

	Pyro.Loading(true);

	$.ajax({
		type: 'POST',
		url: BASE_URL + 'admin/search/results',
		data: {
			'terms': $('#search input.search-terms').val(),
			'csrf_hash_name': $.cookie(Pyro.csrf_cookie_name),
		},
		dataType: 'JSON',
		success: function(json) {
			
			var results = $('#search-results');
				
			results.html('');

			if (json.length != 0) {
				$.each(json.results, function(i, result) {
					results.append(
						'<ul>' +
							'<li>' +
								'<a href="' + BASE_URL + result.cp_uri + '"><strong>' + result.title + '</strong></a>' +
								'<p>' + result.description + '</p>' +
								'<a href="' + BASE_URL + result.cp_uri + '"><small>' + BASE_URL + result.cp_uri + '</small></a>' +
							'</li>' +
						'</ul>'
						);
				});
			}

			Pyro.Loading(false);
		},
		error: function function_name () {
			Pyro.Loading(false);
		}

	});
}


// Go.
Pyro.Initialize();


$(document).ready(function() {
	Pyro.Loading(false);
});