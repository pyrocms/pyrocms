//---------------------------------------------------------------
// MAIN FUNCTIONS
//---------------------------------------------------------------

/* Change Tabs function 
 * This function handles the main content category
 * changes. Loads the menu file for that category
 * then calls the load_page function to handle the page.
 *
 * @param	string	tab_name - the name of the tab to load.
 */
function change_tab(tab_name)
{
	// Clear the menu area, just in case there's no menu file
	$('#menu_bin').slideUp().html('');

	// Load the menu file
	$('#menu_bin').load(tab_name + '/menu.html');

	document.location.hash = tab_name + '/index.html'

	// Load the index page for that category.
	$('#content_bin').load(tab_name + '/index.html');

	// Don't follow the link
	return false;
}

//---------------------------------------------------------------

/* Load page.
 * This function loads a single page into
 * the #content_bin div.
 *
 * @param	string	url - The name of the page to load.
 */
function load_page(url) {
	
	$('#content_bin').load(url);

	// Don't follow the link
	return false;
}

//---------------------------------------------------------------
// RUN-TIME ACTIONS
//---------------------------------------------------------------

$(document).ready(function(){

	document.location.hash.substr(1) && load_page(document.location.hash.substr(1))

	/* 
		Hook up category loading 
	*/
	$('#nav-main a').click(function(){
		
		var tab_name = $(this).text().toLowerCase();
		
		change_tab(tab_name);
		
		// Reset our current class
		$('#nav-main a').removeClass('current');
		$(this).addClass('current');

		return false;
	});
	
	/*
		Hook up menu animations
	*/
	$('#menu-tab').click(function(){
		
		$('#menu_bin').slideToggle();
		
		return false;
	});
	
	/*
		Make sure all (internal) links will load properly
	*/
	$('#menu_bin a, #content_bin a:not([target="_blank"])').live('click', function(){
		
		var url = $(this).attr('href');

		document.location.hash = url

		return load_page(url);
	});

});