/**
 * Admin
 *
 * Supporting JS for PyroCMS /admin
 */


/**
 * Show sexy loading progress
 */

NProgress.set(0.4).inc({
	ease: 'ease',
	trickleRate: 0.03,
	trickleSpeed: 100,
	speed: 200,		
});

$(document).ready(function() {

	// Some nice feedback
	NProgress.done();
});



/**
 * Full Screen Toggle
 */

$(document).on('click', '[data-toggle="fullscreen"]', function(e) {
	e.preventDefault();
	screenfull.request();
});



/**
 * Toggle Classes
 */

$(document).on('click', '[data-toggle^="class:"]', function(e) {
	e.preventDefault();
	$($(this).attr('data-target')).toggleClass($(this).attr('data-toggle').replace('class:', ''));
});