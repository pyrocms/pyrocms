$.validator.setDefaults({
    highlight: function (element, errorClass, validClass) {
        var $element;
        if (element.type === 'radio') {
            $element = this.findByName(element.name);
        } else {
            $element = $(element);
        }
        $element.addClass(errorClass).removeClass(validClass);
        // add the bootstrap error class
        $element.parents("div.control-group").addClass("error");
    },
    unhighlight: function (element, errorClass, validClass) {
        var $element;
        if (element.type === 'radio') {
            $element = this.findByName(element.name);
        } else {
            $element = $(element);
        }
        $element.removeClass(errorClass).addClass(validClass);
        // remove the bootstrap error class
        $element.parents("div.control-group").removeClass("error");
    }
});

$(function () {
    // make all validation errors use the bootstrap inline help class on page load if none are specified
    $('.field-validation-valid, .field-validation-error').each(function () {
        var validationMessage = $(this);
        if (!validationMessage.hasClass("help-inline") || !validationMessage.hasClass("help-block")) {
            if (validationMessage.is("p")) {                // add block to p tags
                validationMessage.addClass("help-block");
            } else if (validationMessage.is("span")) {      // add inline to span tags
                validationMessage.addClass("help-inline");
            } else {                                        // add block to another other tag
                validationMessage.addClass("help-block");
            }
        }
    });

    // if the page was rendered with an error, add the error class to the control group
    $('form').each(function () {
        $(this).find('div.control-group').each(function () {
            if ($(this).find('.field-validation-error').length > 0) {
                $(this).addClass('error');
            }
        });
    });
});