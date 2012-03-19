/* 
 * Author: Scott Parry - iKreativ
*/


// Slider
$('.flexslider').flexslider({
	animation: "fade",              //String: Select your animation type, "fade" or "slide"
	slideDirection: "vertical",   //String: Select the sliding direction, "horizontal" or "vertical"
	slideshow: true,                //Boolean: Animate slider automatically
	slideshowSpeed: 8000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
	animationDuration: 1000,         //Integer: Set the speed of animations, in milliseconds
	directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
	controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
	keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
	mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
	prevText: "Previous",           //String: Set the text for the "previous" directionNav item
	nextText: "Next",               //String: Set the text for the "next" directionNav item
	pausePlay: false,               //Boolean: Create pause/play dynamic element
	pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
	playText: 'Play',               //String: Set the text for the "play" pausePlay item
	randomize: false,               //Boolean: Randomize slide order
	slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
	animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
	pauseOnAction: false,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
	pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
	controlsContainer: "",          //Selector: Declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
	manualControls: "",             //Selector: Declare custom control navigation. Example would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
	start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
	before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
	after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
	end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
});

// Drop Menu
$("nav#primary ul ul").css({display: "none"});

$("nav#primary ul li").hover(function(){
	$(this).find('ul:first').css({visibility: "visible",display: "none"}).fadeIn(400);
},function(){
	$(this).find('ul:first').css({visibility: "visible"}).fadeOut(400);
});

// Disable Parent li if has child items
$("nav#primary ul li:has(ul)").hover(function () {
	$(this).children("a").click(function () {
		return false;
	});
});

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

// Chosen
$(".chzn").chosen();

// Prettyprint
$('pre').addClass('prettyprint linenums');