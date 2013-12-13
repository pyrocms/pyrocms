$(function(){
	
	
	//ID Parses
	//Following convention, strips and returns parts
	function parseCrudInfo(obj) {
		
		id = $(obj).attr('id');
		parts = id.split("-");
		
		//Get All Classes
		var classes = new Array();
		var classList =$(obj).attr('class').split(/\s+/);
		
			$.each( classList, function(index, item){
			
			classes.push(item);
			
			});
		
				
		
				
		data = { 
						"namespace":  parts[0],
						"field" : parts[1],
						"type" : parts[2],
						"classes" : classes						
				
		};
		return data;
			
		
	}
	
	
	
	//Change Sorting for Crud
	$('#filter-stage').on('click', '.smi-sort', function(e) {
		
		e.preventDefault();
		
		//Field Data	
		var data = {};
		data['field_data'] = parseCrudInfo($(this));
		var current_url = $('#current_url').val();
			
		$.ajax({
			url: '/admin/smiajax/smicrud/sortheader',
			type: 'POST',
			data: data,
			dataType: 'html',
  			success: function(results) {
    			
				//Returns true if successfully update the sort session variables
				if(results) {	
					window.location = current_url;
				} else {	
					alert("Error updating the sort direction on this table.");	
				}
					
  			}	
		
		});
		
	});
	
	
	
	
	/*
	
	Field Masks
	Global usage, but some require the library to be loaded as well
	We won't load all of them all of the time, it will be required on template->add_js
			
	*/
	
	
	/*
	Class: moneynocents
	Function: Show Currency but don't allow decimals
	*/
	
	$('.moneynocents').blur(function() {
			$(this).formatCurrency({ roundToDecimalPlace: 0, eventOnDecimalsEntered: true });
	});
	
	
	/*
	Class: moneynopunc
	Function: return integeers, no commas or dollar signs
	*/
	
	//@todo
	//Move this somewhere else on forms where this is needed. Throws error if class doesn't exist
	if ($(".moneynopunc").length > 0) {
	
	$('.moneynopunc').jStepper({minValue:0, maxValue:9999999999, minLength:1});
	
	}
	
	
	/*
	Class: uppercase
	Function: Force any text inputs with this class to go to uppercase
	*/
	$('.uppercase').keyup(function(e) {
		
		newval = $(this).val();
		newval = newval.toUpperCase();		
		$(this).val(newval);
		
	});
	

	
	
	

});