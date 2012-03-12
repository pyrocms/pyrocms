jQuery(function($) {
	
	// Add the close link to all boxes with the closable class
	$(".closable").append('<a href="#" class="close">x</a>');
	
	// Close the notifications when the close link is clicked
	$("a.close").click(function () {
		
		// This is a hack so that the close link fades out in IE
		$(this).fadeTo(200, 0);
		
		$(this).parent()
			.fadeTo(200, 0)
			.slideUp(400);
		
		return false;
	});
	
	// Fade in the notifications
	$(".notification").fadeIn("slow");
	
	// Some easy way to center a div.
	$.fn.center = function () {
		// We will need this.
		var w = $(window)

		// Position to center via CSS.
		this.css({
			position: 'absolute',
			top: ( this.height() < w.height()) ? ((w.height() - this.height()) / 2) + w.scrollTop()  + 'px' : '0px',
			left: ( this.width() < w.width() ) ? ( (w.width() - this.width() ) / 2) + w.scrollLeft() + "px" : '0px',
		});
		// Make the function chainable.
		return this;
	}
	
	function login_box_center() {
		if( $(window).width() > 480) {
			// Center the box
			$('#login-box-container').center();	
		} else {
			$('#login-box-container').css({position:'inherit',top:'inherit',left:'inherit'});
		}
	}
	
	login_box_center();
	
	// Re-position on scroll and resize.
	$(window).bind('scroll.centerDiv resize.centerDiv',function(){
		login_box_center();
	});

});