/**
 * Admin
 *
 * Supporting JS for PyroCMS /admin
 */

// Start loading progress
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