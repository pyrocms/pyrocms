/* Author: 

*/
// Drop Menu
$("nav#primary ul ul").css({display: "none"});

$("nav#primary ul li").hover(function(){
	$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(400);
},function(){
	$(this).find('ul:first').css({visibility: "visible"}).slideUp(400);
});

// Disable Parent li if has child items
$("nav#primary ul li:has(ul)").hover(function () {
	$(this).children("a").click(function () {
return false;
});
});

// Pretty Photo
$('#main a:has(img)').addClass('prettyPhoto');
$("a[class^='prettyPhoto']").prettyPhoto();

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













