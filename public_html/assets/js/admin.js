$(function() {	

	// Sort any tables with a class of 'sortable'
	$(".listTable").tablesorter();
	
	// Make all delete confirmation links required a confirmation
	$('a.confirm').click(function(){
		return confirm('Are you sure you would like to delete this entry?');
	});
	
	// Set all date input boxes as datepickers
	$('input[type="text"].datepicker, input.date').datepicker({
		dateFormat: $.datepicker.W3C,
	    showOn: "both", 
	    buttonImage: "/assets/img/icons/calendar.gif",
	    buttonImageOnly: true 
	});
	
	
	$(".tabs").tabs();
	$.ui.dialog.defaults.bgiframe = true;
	
	
	$("#welcome").dialog({ 
		bgiframe: 	true, 
		modal:		true
	});

	$(".features").click(function(){
		$("#features").dialog({ 
			bgiframe: 	true, 
			modal:		true,
			width: 		600 

		});			
	});

	$(".close").click(function(){
		$(this).parents(".message").hide("fast");
		return false;
	});
	
	$(".tooltip").tooltip({  
		showBody:	" - ",
		showURL:	false
	});	
	
	$("#postList").tablesorter({ 
        headers: { 
            0: { 
                sorter: false 
            }
		}
     });
	
	
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
	
});