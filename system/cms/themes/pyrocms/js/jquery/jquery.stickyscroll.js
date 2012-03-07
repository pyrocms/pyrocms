/*
 * StickyScroll
 * written by Rick Harris - @iamrickharris
 * edited by George Petsagourakis
 * 
 * Requires jQuery 1.4+
 * 
 * Make elements stick to the top of your page as you scroll
 *
 * Usage: 
 *   
 *   $('selector').stickyScroll({ container: $(container-element) })
 * 
 *  The above is 'auto' mode. The sticky element will never cross the boundaries of 
 * the specified container.
 * 
 *   $('selector').stickyScroll()
 * 
 *  The above is also 'auto' mode, but the container will be the <body> tag.
 *
 *   $('selector').stickyScroll({ topBoundary: '100px', bottomBoundary: '200px' })
 *
 *  The above is "manual" mode. The boundaries are relative to the top and bottom of 
 * the document, and the sticky element will never cross those boundaries. So, 
 * in the example given, the top of the sticky element(s) will never be above 
 * 100 pixels from the top of the document and the bottom of the sticky 
 * element(s) will never be below 200 pixels from the bottom of the document.
 * 
 * $('selector').stickyScroll('reset')
 * 
 * Use the command above to rid an element of any stickiness
 */

(function($) {
  $.fn.stickyScroll = function(options) {
    var methods = {
      init : function(options) {

        var settings;
        
        if (options.autoBottomBoundary != true && options.autoBottomBoundary != false) {
          if (options.container) {
            options.autoBottomBoundary = true;
          }
          if (options.bottomBoundary) {
            options.autoBottomBoundary = false;
          }
        }
        
        settings = $.extend({
          autoBottomBoundary: true,
          container: $('body'),
          topBoundary: null,
          bottomBoundary: null,
          minimumWidth: null,
        }, options);
        
        function bottomBoundary() {
          return $(document).height() - settings.container.offset().top - settings.container.attr('offsetHeight');
        }

        function topBoundary() {
          return settings.container.offset().top
        }

        function elHeight(el) {
          var height = $(el).outerHeight();
          return height;
        }
        
        // make sure user input is a jQuery object
        settings.container = $(settings.container);
        if(!settings.container.length) {
          if(console) {
            console.log('StickyScroll: the element ' + options.container + ' does not exist, we\'re throwing in the towel');
          }
          return;
        }

        function autoCalculateBottomBoundary()
        {
          if(settings.autoBottomBoundary) {
            settings.topBoundary = topBoundary();
            settings.bottomBoundary = bottomBoundary();
          }
        }
        
        autoCalculateBottomBoundary();

        return this.each(function(index) {

          var el = $(this),
            win = $(window),
            id = Date.parse(new Date()) + index,
            height = elHeight(el);
            
          el.data('sticky-id', id);
          
          win.bind('scroll.stickyscroll-' + id, function() {
            var top = $(document).scrollTop() + settings.topBoundary,
            bottom = $(document).height() - top - elHeight(el);
            if( $(window).width() > settings.minimumWidth) {
              if(bottom <= settings.bottomBoundary) {
                el.offset({
                  top: $(document).height() - settings.bottomBoundary - elHeight(el)
                })
                .removeClass('sticky-active sticky-inactive')
                .addClass('sticky-stopped');
              }
            
              else if(top > settings.topBoundary) {
                el.offset({
                  top: $(window).scrollTop() + settings.topBoundary
                })
                .removeClass('sticky-stopped sticky-inactive')
                .addClass('sticky-active');
              }
            
              else if(top < settings.topBoundary || $(document).scrollTop() === 0) {
                el.css({
                  position: '', 
                  top: '',
                })
                .removeClass('sticky-stopped sticky-active')
                .addClass('sticky-inactive');
              }
            } else {
              methods.reset.apply(this);
            }
          });
          
          win.bind('resize.stickyscroll-' + id, function() {
            autoCalculateBottomBoundary();
            height = elHeight(el);
            $(this).scroll();
          })
          
          el.addClass('sticky-processed');
          
          // start it off
          win.scroll();

        });
        
      },
      
      reset : function() {
        return this.each(function() {
          var el = $(this),
          id = el.data('sticky-id');
            
          el.css({
            position: '',
            top: '',
            bottom: ''
          })
          .removeClass('sticky-stopped')
          .removeClass('sticky-active')
          .removeClass('sticky-inactive')
          .removeClass('sticky-processed');
          
          $(window).unbind('.stickyscroll-' + id);
        });
      }
      
    };
    
    // if options is a valid method, execute it
    if (methods[options]) {
      return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
    }
    // or, if options is a config object, or no options are passed, init
    else if (typeof options === 'object' || !options) {
      return methods.init.apply(this, arguments);
    }
    
    else if(console) {
      console.log('Method' + options + ' does not exist on jQuery.stickyScroll');
    }

  };
})(jQuery);