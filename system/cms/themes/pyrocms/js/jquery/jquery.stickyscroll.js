/*
 * StickyScroll - originally written by Rick Harris @iamrickharris
 * heavily edited by George Petsagourakis
 */

;(function ( $, window, document, undefined ) {

    // Create the defaults once
    var pluginName = 'stickyScroll',
        defaults = {
          autoBottomBoundary: true, // Whether the bottom boundary should be determined automatically.
          container: 'body',        // The container for the object, usually the <body>.
          topBoundary: null,        // The top boundary, scroll will not be followed above this.
          bottomBoundary: null,     // The bottom boundary, scroll will not be followed below this.
          minimumWidth: null,       // The minimum width that 
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        this.$element = $(element);

        // Auto set the autoBottomBoundary.
        if ( options.autoBottomBoundary != true && options.autoBottomBoundary != false ) {
          if ( options.container ) {
            options.autoBottomBoundary = true;
          }
          if ( options.bottomBoundary ) {
            options.autoBottomBoundary = false;
          }
        }

        this.options = $.extend( {}, defaults, options ) ;

        // Make sure user input is a jQuery object.
        this.options.container = $( this.options.container );
        if ( this.options.container === undefined || !this.options.container.length ) {
          if ( console ) {
            console.log( 'StickyScroll: the element ' + this.options.container + ' does not exist, we\'re throwing in the towel' );
          }
          return;
        }

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {
    
      init: function () {
        // Lets cache some vars, these are safe to cache globally
        var options = this.options,
            $win = $(window),
            $doc = $(document)
            plugin = this;

        // Adjust the top and bottom boundaries
        _adjustBoundaries( options );

        // Chainable
        return this.$element.each(function (index) {

          // Cache some vars, these are individual to every element passed.
          var $el = $(this),                      // The element
            id = Date.parse(new Date()) + index,  // The unique id of the element
            height = $el.outerHeight(true),           // The elements height
            namespace = '.stickyscroll-' + id;

          // Tag the element.
          $el.data('sticky-id', id);

          // Bind the scroll event using the element id in the namespace to allow the removal of the bind.
          $win.bind('scroll' + namespace, function () {
            // Cache some vars here too, these change on every event trigger.
            // top: push the object down where the document has been scrolled, and then some more for the topBoundary
            // bottom: the remaining space from the bottom of the element to the documents end
            var top = $doc.scrollTop() + options.topBoundary,
              bottom = $doc.height() - (top + height);

            // Only if this window width allows for us
            if ($win.width() > options.minimumWidth) {

              // If we are not on the top of the document.
              if ($doc.scrollTop() > 0) {
                // If the elements bottom is below the bottom boundary
                if (bottom < options.bottomBoundary) {
                  // we are setting the css top: to the document height without the bottom boundary we've set and the height of the element.

                  $el.offset({
                    top: $doc.height() - (height + options.bottomBoundary)
                  });
                } else {
                  // we are setting the css to point to the value of the `top` variable.
                  $el.offset({
                    top: top
                  });
                }
              }
              // So the window has scrolled to the top
              else if ($doc.scrollTop() === 0) {
                // forget about the css top: property, it will be handled via the css
                $el.css( { top: '' } );
              }
            }
            else {
              plugin.reset($el, false);
            }

          });

          $win.bind('resize' + namespace, function () {
            _adjustBoundaries( options );
            $(window).scroll();
          })

          // start it off
          $(window).scroll();
        });
      },

      reset : function (el) {
        $(el).css( { top: '' } );
        $(window).unbind( '.stickyscroll-' + $(el).data('sticky-id') );
      },
    
    };
    
    var _adjustBoundaries = function ( options ) {
      if ( options.autoBottomBoundary ) {
        options.topBoundary = options.container.offset().top;
        options.bottomBoundary = $(document).height() - (options.container.offset().top + (options.container.offsetHeight || 0));
      }
    };
    
    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {

      return this.each( function () {

        if ( options === 'reset' ) {

          if ( $.data(this, 'plugin_' + pluginName) ) {
            $.data( this, 'plugin_' + pluginName ).reset(this);
            $.removeData( this, 'plugin_' + pluginName );
          }
          return this;

        }

        if ( !$.data( this, 'plugin_' + pluginName ) ) {
          $.data( this, 'plugin_' + pluginName, new Plugin( this, options ) );
          //console.log($.data( this, 'plugin_' + pluginName ).options);
        }

      });

    }

})( jQuery, window, document );