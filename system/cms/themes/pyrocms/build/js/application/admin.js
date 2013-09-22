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
 * Toggle Sidebar Mode
 */

$(document).on('click', '[data-toggle="sidebar"]', function(e) {
	e.preventDefault();
	$(e.target).closest('aside').toggleClass('nav-vertical').toggleClass('only-icon');
});



/**
 * Full Screen Toggle
 */

$(document).on('click', '[data-toggle="fullscreen"]', function(e) {
	e.preventDefault();
	screenfull.request();
});