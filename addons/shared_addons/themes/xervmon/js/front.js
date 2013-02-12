(function($)
{
	$(function() {

		// Fancybox modal window
		$('a[rel=modal], a.modal').fancybox({
			overlayOpacity: 0.8,
			overlayColor: '#000',
			hideOnContentClick: false
		});
	   
	   	// ---------------------------------------------------------
		// Name: Default Input Text
		// Description: Used for search boxes and other input boxes
		// 				with a default value that should vanish when
		//              a user clicks within the box
		// Useage:      Give any text input a class of 'default-input-text'
		// 		        and make sure it has an ID.
		// ---------------------------------------------------------
		
		// Used to store default text input valyes
		var default_input_terms = new Array();
		
		// hides default input text from a input box
		$('.default-input-text').focus(function() {
			
			// Store the default text if it hasnt already been stored
			if(typeof default_input_terms[this.id] == 'undefined') {
				default_input_terms[this.id] = $(this).val();
			}
			
			// If the current value is the default value, hide it
			if($(this).val() == default_input_terms[this.id]) {
				$(this).val('').removeClass('default-input-text').addClass('non-default-input-text');
			}
			
			// when the event is blured, put the default message back if they havent written anything
			$(this).blur( function () {
				default_term = default_input_terms[this.id];
				if($(this).val() == '') $(this).removeClass('non-default-input-text').addClass('default-input-text').val(default_term);
			} );

		});
		
	});
})(jQuery);