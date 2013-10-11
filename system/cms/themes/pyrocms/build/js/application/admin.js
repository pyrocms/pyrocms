/**
 * Admin
 *
 * Supporting JS for PyroCMS /admin
 */


// Get ready to rumble
Pyro = Ember.Application.create();



/**
 * Initialize our application
 * - Set up listeners, etc
 */

Pyro.Initialize = function(params) {

	/**
	 * We're loading
	 */
	
	Pyro.Loading();

	$(document).on('click', 'a[href^="http"][target!="_blank"]', function() { Pyro.Loading(); });


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
	});

	// Save persistent state
	if ($(this).attr('data-persistent') !== undefined)
		$.cookie('persistent_' + $(this).attr('data-persistent'), $($(this).attr('data-target')).hasClass($(this).attr('data-toggle').replace('class:', '')), { path: '/' });


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

		if (confirm(removemsg || params.lang.dialog_message)) {
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
		
		// Ignore if we're typing
		if ($('input, textarea, select').is(':focus')){ return true; }

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
	
	$(document).on('click', '[data-toggle^="global-search"]', function(e) {
		e.preventDefault();
		$('body').removeClass('nav-off-screen').toggleClass('search-off-screen');
		$('#search .search-terms').val('');
		$('#search .selectize-input input').focus();
	});

	$(document).on('click', '[data-toggle^="module-search"]', function(e) {
		e.preventDefault();
		$('body').removeClass('nav-off-screen').toggleClass('search-off-screen');
		$('#search .selectize-input input').val(params.current_module + ':').focus();

		// Spoof a keypress
		var e = $.event('keydown');

		// (enter)
		e.which = 13;

		// Trigger it
		$('#search .selectize-input input').trigger(e);
	});

	/*$('#search .search-terms').typeahead({
		name: 'twitter-oss',
		prefetch: 'http://twitter.github.io/typeahead.js/data/repos.json',
		template: [
			'<p class="repo-language">{{language}}</p>',
			'<p class="repo-name">{{name}}</p>',
			'<p class="repo-description">{{description}}</p>'
		].join(''),
		engine: {
			compile: function(template) {
				return {
					render: function(context) {
						return template.replace(/\{\{(\w+)\}\}/g, function (match,p1) { return context[p1]; });
					}
				}
			}
		}
	});*/
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


$(document).ready(function() {
	Pyro.Loading(false);
});