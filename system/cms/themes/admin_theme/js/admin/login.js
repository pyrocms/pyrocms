
	$(document).ready(function() {
		// Add the close link to all boxes with the closable class
		$(".closable").append('<a href="#" class="close">close</a>');

		// Close the notifications when the close link is clicked
		$("a.close").click(function () {
			$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
			$(this).parent().fadeTo(200, 0);
			$(this).parent().slideUp(400);
			return false;
		});

		// Fade in the notifications
		$(".notification").fadeIn("slow");
	});