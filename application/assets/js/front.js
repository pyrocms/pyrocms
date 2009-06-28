// Set up all linkbox links
$(function() {

	/* Facebox modal window */
	$('a[rel*=modal]').facebox({
	   opacity : 0.4,
	   loadingImage : APPPATH_URI + 'assets/img/facebox/loading.gif',
	   closeImage   : APPPATH_URI + 'assets/img/facebox/closelabel.gif',
	});
   
   	// ---------------------------------------------------------
	// Name: Default Input Terms
	// Description: Used for search boxes and other input boxes
	// 				with a default value that should vanish when
	//              a user clicks within the box
	// Useage:      Give any text input a class of 'default-input-text'
	// 		        and make sure it has an ID.
	// ---------------------------------------------------------
	
	// Used to store default text input valyes
	var default_input_terms = new Array();
	
	// hides default search terms from a input box
	$('.default-input-text').focus(function() {
		
		// Store the default term if it hasnt already been stored
		if(!default_input_terms[this.id]) {
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
	// --- End of "Search Terms" -------------------------------
	
   
});
