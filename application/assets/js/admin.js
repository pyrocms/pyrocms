$(function() {	

	// Sort any tables with a class of 'sortable'
	$(".listTable").tablesorter();

	// Link confirm box
	$('a.confirm').click(function(e) {
	
		/*e.preventDefault();
			
			link = this;
			modal_confirm("Are you sure you wish to delete this item?", function () {
				window.location.href = $(link).attr('href');
			});
		*/
		
		return confirm('Are you sure you wish to delete this item?');
	});
	
	// Form submit confirm box
	$('button[type="submit"].confirm, input[type="submit"].confirm').click(function(e) {
		/*	e.preventDefault();
			
			button = this;
			confirm("Are you sure you wish to delete these items?", function () {
				$(button).parents('form').submit();
			});
		*/

		return confirm('Are you sure you wish to delete these items?');
	});

	
	$(".tabs").tabs();
	

	$(".close").click(function(){
		$(this).parents(".message").hide("fast");
		return false;
	});

	$(".tooltip").tooltip({  
		showBody:	" - ",
		showURL:	false
	});	

	$("#welcome").dialog({ 
		bgiframe: 	true, 
		modal:		true
	});
	
	
	/* Admin left navigation dropdowns */
	$("#side-nav li").not(".active").find("ul").hide();
	$("#side-nav .button").click(function(){
		$("#side-nav ul").hide();
		if($(this).parent("li").hasClass("active")){
			$("#side-nav>li").removeClass("active").addClass("inactive").find(".expand").removeClass("expanded");
		}else{
			$("#side-nav>li").removeClass("active").addClass("inactive").find(".expand").removeClass("expanded");
			$(this).next("ul").show();
			$(this).parent().removeClass("inactive").addClass("active");
			$(this).find(".expand").addClass("expanded");
		}
	});
	
	
	/* Facebox modal window */
   $('a[rel*=modal]').facebox({
	   opacity : 0.4,
	   loadingImage : APPPATH + "assets/img/facebox/loading.gif",
	   closeImage   : APPPATH + "assets/img/facebox/closelabel.gif",
   });
	
});