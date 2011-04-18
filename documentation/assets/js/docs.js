//---------------------------------------------------------------
// MAIN FUNCTIONS
//---------------------------------------------------------------

//---------------------------------------------------------------

/* Load page.
 * This function loads a single page into
 * the #content_bin div.
 *
 */
function load_page() {
	
	if(window.location.hash.substr(1))
	{
		//get url segments
		var segments = window.location.hash.substr(1).split('/');
		
		// Load the menu file in case visitor came from external link
		$('#menu_bin').load(segments[0] + '/menu.html', $('#menu-tab').show());
	
		//ajax load the page content
		$('#content_bin').load(window.location.hash.substr(1), $('#menu_bin').slideUp('fast'));
		
		//uppercase the first letter of the segment for the current class
		var first = segments[0].substring(0, 1);
		var last = segments[0].substring(1);

		// Set the current class
		$('#nav-main a').removeClass('current');
		$('#nav-main a:contains(' + first.toUpperCase() + last + ')').addClass('current');	
	}
}

//---------------------------------------------------------------
// RUN-TIME ACTIONS
//---------------------------------------------------------------

$(document).ready(function(){

	//hide Table of Contents. It will be shown later if tab/menu.html loads successfully
	$('#menu-tab').hide();
	
	// load page content whenever uri changes
	$(window).hashchange( function(){

		//lets the Back button work on home page also
		if( ! window.location.hash.substr(1))
		{
			window.location.href = window.location;
		}
	
		//if it's a hash uri load it
		load_page();
	  
	});
	
	//call load_page() on dom ready for external referrals
	load_page();

	/* 
		Hook up category loading 
	*/
	$('#nav-main a').click(function(){
		
		var tab_name = $(this).text().toLowerCase();
	
		window.location.hash = tab_name + '/index.html'

		//don't follow the link
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
	$('#menu_bin a:not([target="_blank"]), #content_bin a:not([target="_blank"])').live('click', function(){
		
		var url = $(this).attr('href');

		//change the url and hashchange() will take over
		window.location.hash = url
		
		//stop default action
		return false;
		
	});

});

/*
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,e,b){var c="hashchange",h=document,f,g=$.event.special,i=h.documentMode,d="on"+c in e&&(i===b||i>7);function a(j){j=j||location.href;return"#"+j.replace(/^[^#]*#?(.*)$/,"$1")}$.fn[c]=function(j){return j?this.bind(c,j):this.trigger(c)};$.fn[c].delay=50;g[c]=$.extend(g[c],{setup:function(){if(d){return false}$(f.start)},teardown:function(){if(d){return false}$(f.stop)}});f=(function(){var j={},p,m=a(),k=function(q){return q},l=k,o=k;j.start=function(){p||n()};j.stop=function(){p&&clearTimeout(p);p=b};function n(){var r=a(),q=o(m);if(r!==m){l(m=r,q);$(e).trigger(c)}else{if(q!==m){location.href=location.href.replace(/#.*/,"")+q}}p=setTimeout(n,$.fn[c].delay)}$.browser.msie&&!d&&(function(){var q,r;j.start=function(){if(!q){r=$.fn[c].src;r=r&&r+a();q=$('<iframe tabindex="-1" title="empty"/>').hide().one("load",function(){r||l(a());n()}).attr("src",r||"javascript:0").insertAfter("body")[0].contentWindow;h.onpropertychange=function(){try{if(event.propertyName==="title"){q.document.title=h.title}}catch(s){}}}};j.stop=k;o=function(){return a(q.location.href)};l=function(v,s){var u=q.document,t=$.fn[c].domain;if(v!==s){u.title=h.title;u.open();t&&u.write('<script>document.domain="'+t+'"<\/script>');u.close();q.location.hash=v}}})();return j})()})(jQuery,this);