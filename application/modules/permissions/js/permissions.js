$(function()
{
	// Pick a rule type, show the correct field
	$("input[name='role_type']").change(function() {
		
		if($(this).val() == 'user') {
			$("[name='permission_role_id']").parent().hide();
			$("[name='user_id']").parent().show();
		}
		
		else if($(this).val() == 'role') {
			$("[name='user_id']").parent().hide();
			$("[name='permission_role_id']").parent().show();
		}
		
		else {
			$("[name='user_id']").parent().hide();
			$("[name='permission_role_id']").parent().hide();
		}
		
	});

	// When module changes grab a list of controllers
	$("select[name='module']").change(function() {
		if(this.value != '') get_controllers($(this).val());
	});
	
	// When controller changes get a list of methods
	$("select[name='controller']").change(function() {
		if(this.value != '') get_methods($("select[name='module']").val(), $(this).val());
	});
	
	$('a.delete_role').click(function()
	{
		return confirm(roleDeleteConfirm);
	});
	
});

function get_controllers(module, selected) {

	controller_select = "select[name='controller']";
	
	$(controller_select).hide().empty();
	get_methods();
	
	$.getJSON(BASE_URI + "admin/permissions/module_controllers/" + module, function(data){
         
         $("<option/>").attr("value", '*').text(permControllerSelectDefault).appendTo(controller_select);
         
         $.each(data, function(i,controller){
           if(controller == module) label = controller + ' (default)';
           else { label = controller; }
           option = $("<option/>").attr("value", controller).text(label);
           
           // If the current one is the supplied selected method
           if(selected == controller) option.attr("selected", "selected");
           
           option.appendTo(controller_select);
         });
         
         $(controller_select).fadeIn('slow');
    });
}

function get_methods(module, controller, selected) {
	
	method_select = "select[name='method']";
	
	$(method_select).hide().empty();
	
    $("<option/>").attr("value", '*').text(permMethodSelectDefault).appendTo(method_select);
         
	$.getJSON(BASE_URI + "admin/permissions/controller_methods/" + module + "/" + controller, function(data){
         $.each(data, function(i,method){
           option = $("<option/>").attr("value", method).text(method);
			
			// If the current one is the supplied selected method
           if(selected == method) option.attr("selected", "selected");

           option.appendTo(method_select);
         });
         
         $(method_select).fadeIn('slow');
    });
}