(function($){

    var filterDefaults = {
        filter_onload: true,
        content: '#filter-stage',
        module: '', // the current module name
		module_selector: 'input[name="f_module"]'
    };
 
    function Filter(form, opts)
    {
		this._opts = $.extend({}, filterDefaults, opts || {});
		this.form = form;
        this.$form = $(form);
		this.$content = (typeof this._opts.content === "string") ? $(this._opts.content) : this._opts.content;
        
        // get the current module name
        this.module = this.module || $(this.module_selector).val();
        
        //and off we go!
        this.init();
    }

    
    Filter.prototype.init = function(){
        var self = this;

        $('a.cancel').button();

        //listener for select elements
        $('select', this.$form).on('change', function(){
            self.do_filter();
        });

        //listener for keywords
        $('input[type="text"]', this.$form).on('keyup', $.debounce(500, function(){
            self.do_filter();

        }));

        //listener for pagination
        $('body').on('click', '.pagination a', function(e){
            e.preventDefault();
            url = $(this).attr('href');
            self.do_filter(self.$form.serialize(), url);
        });
            
        //clear filters
        $('a.cancel', this.$form).click(function() {
        
                //reset the defaults
                $('select', this.$form).val('0');
                
                //clear text inputs
                $('input[type="text"]', this.$form).val('');
        
                self.do_filter();
        });
        
        //prevent default form submission
        this.$form.submit(function(e){
            e.preventDefault(); 
        });
        
		// trigger an event to submit immediately after page load
		if (this._opts.filter_onload)
        {
			this.refresh();
		}
    };
    
	Filter.prototype.getInstance = function(){
		return this;
	};
	
	Filter.prototype.refresh = function(){
		this.do_filter();
	};
    //launch the query based on module
    Filter.prototype.do_filter = function(form_data, url) {
        var self = this,
			form_action = this.$form.attr('action'),
            post_url = url;
			
		// No data, serialize form
		if (!form_data) form_data = self.$form.serialize();
		
		// No url? then use the form action or build one from module name
		if (!post_url) post_url = form_action ? form_action : SITE_URL + 'admin/' + this.module;

        // clear notifications
		pyro.clear_notifications();

		// hide content
        this.$content.fadeOut('fast', function(){

            //send the request to the server
            $.post(post_url, form_data, function(data, response, xhr) {
                var ct      = xhr.getResponseHeader('content-type') || '',
                    html    = '';

                if (ct.indexOf('application/json') > -1 && typeof data == 'object')
                {
                    html = 'html' in data ? data.html : '';

                    self.handler_response_json(data);
                }
                else {
                    html = data;
                }

                //success stuff here
                pyro.chosen();
                self.$content.html(html).fadeIn('fast');
            });
        });
    };

    Filter.prototype.handler_response_json = function(json)
    {
        var self = this;
        if ('update_filter_field' in json && typeof json.update_filter_field == 'object')
        {
            $.each(json.update_filter_field, self.update_filter_field);
        }
    };
    
    Filter.prototype.update_filter_field = function(field, data)
    {
        var $field = $('[name='+field+']', this.$form);
    
        if ($field.is('select'))
        {
            if ($.isPlainObject(data))
            {
                if ('options' in data)
                {
                    var selected, value;
    
                    selected = $field.val();
                    $field.children('option').remove();
    
                    for (value in data.options)
                    {
                        $field.append('<option value="' + value + '"' + (value == selected ? ' selected="selected"': '') + '>' + data.options[value] + '</option>');
                    }
                }
            }
        }
    };

    $.fn.pyroFilter = function (method) {

            var $fn = this.data('pyrofilter');
            
			// if we have a object and method exists
            if ($fn && $fn[method]) {
                // call the respective method
				return $fn[method].apply($fn, Array.prototype.slice.call(arguments, 1));
            
			
			// if an object is given as method OR nothing is given as argument
            } else if (typeof method === 'object' || !method) {
                return this.each(function() {
                    var $el = $(this);
                    if (!$el.data('pyrofilter')) {
						// create and store filter instance
                        $el.data('pyrofilter', new Filter(this, method));
                    }
                });
            } else {
                // trigger an error
                $.error( 'Method "' + method + '" does not exist in pyroFilter plugin!');
            }    

    };
})(jQuery);

$(function(){
    $('#filters form').pyroFilter();
});