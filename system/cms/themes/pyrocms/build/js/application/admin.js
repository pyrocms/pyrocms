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

Pyro.Initialize = function() {

	Pyro.Loading();

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
	 * Tooltips
	 */
	
	$('[data-toggle="tooltip"]').tooltip();


	/**
	 * Popovers
	 */
	
	$(document).on('click', '[data-toggle="popover"]', function(e){e.preventDefault();});
	$('[data-toggle="popover"]').popover();
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
		$('#loading').addClass('animated-fast pulse').fadeIn();
	else
		$('#loading').removeClass().fadeOut();
}


// Go.
Pyro.Initialize();

$(document).ready(function() {
	Pyro.Loading(false);
});