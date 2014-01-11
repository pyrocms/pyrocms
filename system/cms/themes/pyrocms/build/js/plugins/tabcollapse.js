!function ($) {

    "use strict";

    function accordionGroupTemplate(parentId, $heading){
        var tabSelector = $heading.attr('data-target'),
            active = $heading.parent().is('.active');

        if (!tabSelector) {
            tabSelector = $heading.attr('href');
            tabSelector = tabSelector && tabSelector.replace(/.*(?=#[^\s]*$)/, ''); //strip for ie7
        }

        var $tabContent = $(tabSelector),
            groupId = $tabContent.attr('id') + '-collapse';


        return '' +
            '<div class="panel-group">' +
            '   <div class="panel-heading">' +
            '       <h4 class="panel-title">' +
            '           <a class="accordion-toggle ' + (active ? '' : 'collapsed') + '" data-toggle="collapse" data-parent="#' + parentId + '" href="#' + groupId + '">' +
            '               ' + $heading.html() +
            '           </a>' +
            '       </h4>' +
            '   </div>' +
            '   <div id="' + groupId + '" class="panel-body collapse ' + (active ? 'in' : '') + '">' +
            '       ' + $tabContent.html() +
            '   </div>' +
            '</div>';
    }

    function accordionTemplate(id, $headings, clazz){
        var accordionTemplate = '<div class="accordion ' + clazz + '" id="' + id +'">';
        $headings.each(function(){
            var $heading = $(this);
            accordionTemplate += accordionGroupTemplate(id, $heading);
        });
        accordionTemplate += '</div>';
        return accordionTemplate;
    }


    /* TAB-COLLAPSE PLUGIN DEFINITION
     * ===================== */

    $.fn.tabCollapse = function (options) {
        return this.each(function () {
            var $this = $(this),
                $headings =  $this.find('li:not(.dropdown) [data-toggle="tab"], li:not(.dropdown) [data-toggle="pill"]');
            options = $.extend({}, $.fn.tabCollapse.defaults, options);
            var accordionHtml = accordionTemplate($this.attr('id') + '-accordion', $headings, options.accordionClass);
            $this.after(accordionHtml);
            $this.addClass(options.tabsClass);
            $this.siblings('.tab-content').addClass(options.tabsClass);
        })
    };

    $.fn.tabCollapse.defaults = {
        accordionClass: 'visible-phone',
        tabsClass: 'hidden-phone'
    }

}(window.jQuery);