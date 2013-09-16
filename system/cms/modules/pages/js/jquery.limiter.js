(function($){
    $.fn.limit  = function(options) {
        var defaults = {
        limit: 200,
        id_result: false,
        alertClass: false
        }
        var options = $.extend(defaults,  options);
        return this.each(function() {
            var characters = options.limit;
            if(options.id_result != false)
            {
                $("#"+options.id_result).append("You have <strong>"+  characters+"</strong> characters remaining");
            }
            $(this).keyup(function(){
                if($(this).val().length > characters){
                    $(this).val($(this).val().substr(0, characters));
                }
                if(options.id_result != false)
                {
                    var remaining =  characters - $(this).val().length;
                    $("#"+options.id_result).html("You have <strong>"+  remaining+"</strong> characters remaining");
                    if(remaining <= 10)
                    {
                        $("#"+options.id_result).addClass(options.alertClass);
                    }
                    else
                    {
                        $("#"+options.id_result).removeClass(options.alertClass);
                    }
                }
            });
        });
    };
})(jQuery);