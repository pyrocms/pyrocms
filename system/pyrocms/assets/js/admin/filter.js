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
        $('input[type="text"]', filter_form).live('keyup', function() {
                        
                field_val = $(this).val();
        
                //fire the query as soon as user has entered more than three characters
                if(field_val.length >= 3 || field_val.length == 0)
                {
                    //build the form data
                    form_data = filter_form.serialize();
                    
                    do_filter(f_module, form_data);
                }
                
        
        });
        
        //launch the query based on module
        function do_filter(module, form_data)
        {
                $('#content').fadeOut('fast', function() {
                    //send the request to the server
                    $.post(BASE_URL + '/admin/'+module+'/ajax_filter', form_data, function(data, response, xhr) {
                            //success stuff here
                            $.uniform.update();
                            $('#content').html(data).fadeIn('fast');
                    });
                });
        }
        
        //clear filters
        $('button[name="f_clear"]', filter_form).click(function() {
        
                //reset the defaults
                //$('select', filter_form).children('option:first').addAttribute('selected', 'selected');
                $('select', filter_form).val('0');
                
                //clear text inputs
                $('input[type="text"]').val('');
                $.uniform.update();
                //build the form data
                form_data = filter_form.serialize();
        
                do_filter(f_module, form_data);
        });        
    });
})(jQuery);