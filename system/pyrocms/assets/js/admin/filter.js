(function($) {
    $(function() {
        //filter form object
        var filter_form = $('form.filter');
        
        //lets get the current module,  we will need to know where to post the search criteria
        var f_module = $('input[name="f_module"]').val();
        
        //listener for select elements
        $('select', filter_form).live('change', function() {
                
                //build the form data
                form_data = filter_form.serialize();
        
                //fire the query
                do_filter(f_module, form_data);
        });
        
        //listener for keywords
        $('input[type="text"]', filter_form).live('keypress', function() {
                
                //build the form data
                form_data = filter_form.serialize();
        
                field_val = $(this).val();
        
                //fire the query as soon as user has entered more than five characters
                if(field_val.length > 5)
                {
                        do_filter(f_module, form_data);
                }
        
        });
        
        //launch the query based on module
        function do_filter(module, form_data)
        {
                //send the request to the server
                $.post(BASE_URI + '/admin/'+module+'/ajax_filter', form_data, function(data, response, xhr) {
                        //success stuff here
                        $('#content').html(data);
                });
        }
        
        //clear filters
        $('button[name="f_clear"]', filter_form).click(function() {
        
                //reset the defaults
                //$('select', filter_form).children('option:first').addAttribute('selected', 'selected');
                $('select', filter_form).val('0');
                
                //clear text inputs
                $('input[type="text"]').val('');
                
                //build the form data
                form_data = filter_form.serialize();
        
                do_filter(f_module, form_data);
        });        
    });
})(jQuery);