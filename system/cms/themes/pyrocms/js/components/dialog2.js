/*
 * Dialog2: Yet another dialog plugin for jQuery.
 * 
 * This time based on bootstrap styles with some nice ajax control features, 
 * zero dependencies to jQuery.UI and basic options to control it.
 * 
 * Licensed under the MIT license 
 * http://www.opensource.org/licenses/mit-license.php 
 * 
 * @version: 2.0.0 (22/03/2012)
 * 
 * @requires jQuery >= 1.4 
 * 
 * @requires jQuery.form plugin (http://jquery.malsup.com/form/) >= 2.8 for ajax form submit 
 * @requires jQuery.controls plugin (https://github.com/Nikku/jquery-controls) >= 0.9 for ajax link binding support
 * 
 * @requires bootstrap styles (twitter.github.com/bootstrap) in version 2.x to look nice
 * 
 * @author nico.rehwaldt
 */
(function($) {
    
    /**
     * Dialog html markup
     */
    var __DIALOG_HTML = "<div class='modal' style=\"display: none;\">" + 
        "<div class='modal-header loading'>" +
        "<a href='#' class='close'></a>" + 
        "<span class='loader'></span><h3></h3>" + 
        "</div>" + 
        "<div class='modal-body'>" + 
        "</div>" + 
        "<div class='modal-footer'>" + 
        "</div>" + 
        "</div>";
    
    /**
     * Constructor of Dialog2 internal representation 
     */
    var Dialog2 = function(element, options) {
        this.__init(element, options);
        
        var dialog = this;
        var handle = this.__handle;
        
        this.__ajaxCompleteTrigger = $.proxy(function() {
            this.trigger("dialog2.ajax-complete");
            this.trigger("dialog2.content-update");
        }, handle);
        
        this.__ajaxStartTrigger = $.proxy(function() {
            this.trigger("dialog2.ajax-start");
        }, handle);
        
		/* 
		 * Allows us to change the xhr based on our dialog, e.g. 
		 * attach url parameter or http header to identify it) 
		 */
		this.__ajaxBeforeSend = $.proxy(function(xhr, settings) {
			handle.trigger("dialog2.before-send", [xhr, settings]);
			
			if ($.isFunction($.fn.dialog2.defaults.beforeSend)) {
				$.fn.dialog2.defaults.beforeSend.call(this, xhr, settings);
			}
		}, handle);
		
        this.__removeDialog = $.proxy(this.__remove, this);
        
        handle.bind("dialog2.ajax-start", function() {
            dialog.options({buttons: options.autoAddCancelButton ? localizedCancelButton() : {}});
            handle.parent().addClass("loading");
        });
        
        handle.bind("dialog2.content-update", function() {
            dialog.__ajaxify();
            dialog.__updateMarkup();
            dialog.__focus();
        });
        
        handle.bind("dialog2.ajax-complete", function() {
            handle.parent().removeClass("loading");
        });
        
        // Apply options to make title and stuff shine
        this.options(options);

        // We will ajaxify its contents when its new
        // aka apply ajax styles in case this is a inpage dialog
        handle.trigger("dialog2.content-update");
    };
    
    /**
     * Dialog2 api; methods starting with underscore (__) are regarded internal
     * and should not be used in production environments
     */
    Dialog2.prototype = {
    
        /**
         * Core function for creating new dialogs.
         * Transforms a jQuery selection into dialog content, following these rules:
         * 
         * // selector is a dialog? Does essentially nothing
         * $(".selector").dialog2();
         * 
         * // .selector known?
         * // creates a dialog wrapped around .selector
         * $(".selector").dialog2();
         * 
         * // creates a dialog wrapped around .selector with id foo
         * $(".selector").dialog2({id: "foo"});
         * 
         * // .unknown-selector not known? Creates a new dialog with id foo and no content
         * $(".unknown-selector").dialog2({id: "foo"});
         */    
        __init: function(element, options) {
            var selection = $(element);
            var handle;

            if (!selection.is(".modal-body")) {
                var overlay = $('<div class="modal-backdrop"></div>').hide();
                var parentHtml = $(__DIALOG_HTML);
                
                if (options.modalClass) {
                    parentHtml.addClass(options.modalClass);
                    delete options.modalClass;
                }
                
                $(".modal-header a.close", parentHtml)
                    .text(unescape("%D7"))
                    .click(function(event) {
                        event.preventDefault();

                        $(this)
                            .parents(".modal")
                            .find(".modal-body")
                                .dialog2("close");
                    });

                $("body").append(overlay).append(parentHtml);
                
                handle = $(".modal-body", parentHtml);

                // Create dialog body from current jquery selection
                // If specified body is a div element and only one element is 
                // specified, make it the new modal dialog body
                // Allows us to do something like this 
                // $('<div id="foo"></div>').dialog2(); $("#foo").dialog2("open");
                if (selection.is("div") && selection.length == 1) {
                    handle.replaceWith(selection);
                    selection.addClass("modal-body").show();
                    handle = selection;
                }
                // If not, append current selection to dialog body
                else {
                    handle.append(selection);
                }

                if (options.id) {
                    handle.attr("id", options.id);
                }
            } else {
                handle = selection;
            }
            
            this.__handle = handle;
            this.__overlay = handle.parent().prev(".modal-backdrop");
            
            this.__addFocusCatchers(parentHtml);
        }, 
        
        __addFocusCatchers: function(parentHandle) {
            parentHandle.prepend(new FocusCatcher(this.__handle, true));
            parentHandle.append(new FocusCatcher(this.__handle, false));
        }, 
        
        /**
         * Parse dialog content for markup changes (new buttons or title)
         */
        __updateMarkup: function() {
            var dialog = this;
            var e = dialog.__handle;
            
            e.trigger("dialog2.before-update-markup");
            
            // New options for dialog
            var options = {};

            // Add buttons to dialog for all buttons found within 
            // a .form-actions area inside the dialog
			
			// Instead of hiding .form-actions we remove it from view to fix an issue with ENTER not submitting forms 
			// when the submit button is not displayed
            var actions = $(".form-actions", e).css({ position: "absolute", left: "-9999px", height: "1px" });
			
            var buttons = actions.find("input[type=submit], input[type=button], input[type=reset], button, .btn");

            if (buttons.length) {
                options.buttons = {};

                buttons.each(function() {
                    var button = $(this);
                    var name = button.is("input") ? button.val() || button.attr("type") : button.html();

                    options.buttons[name] = {
                        primary: button.is("input[type=submit] .btn-primary"),
                        type: button.attr("class"), 
                        click: function(event) {
                            if (button.is("a")) { window.location = button[0].href }
                            // simulate click on the original button
                            // to not destroy any event handlers
                            button.click();

                            if (button.is(".close-dialog")) {
                            	event.preventDefault();
                                dialog.close();
                            }
                        }
                    };
                });
            }

            // set title if content contains a h1 element
            var titleElement = e.find("h1").hide();
            if (titleElement.length > 0) {
                options.title = titleElement.html();
            }

            // apply options on dialog
            dialog.options(options);
            
            e.trigger("dialog2.after-update-markup");
        },
        
        /**
         * Apply ajax specific dialog behavior to the dialogs contents
         */
        __ajaxify: function() {
            var dialog = this;
            var e = this.__handle;

            e.trigger("dialog2.before-ajaxify");
            
            e.find("a.ajax").click(function(event) {
                var url = $(this).attr("href");
                dialog.load(url);
                event.preventDefault();
            }).removeClass("ajax");

            // Make submitable for an ajax form 
            // if the jquery.form plugin is provided
            if ($.fn.ajaxForm) {
				var options = {
                    target: e,
                    success: dialog.__ajaxCompleteTrigger,
                    beforeSubmit: dialog.__ajaxStartTrigger, 
					beforeSend: dialog.__ajaxBeforeSend, 
                    error: function() {
                        throw dialogError("Form submit failed: " + $.makeArray(arguments));
                    }
                };
				
                $("form.ajax", e)
					.removeClass("ajax")
					.ajaxForm(options);
            }
            
            e.trigger("dialog2.after-ajaxify");
        },
        
        /**
         * Removes the dialog instance and its 
         * overlay from the DOM
         */
        __remove: function() {
            this.__overlay.remove();
            this.__handle.removeData("dialog2").parent().remove();
        }, 
        
        /**
         * Focuses the dialog which will essentially focus the first
         * focusable element in it (e.g. a link or a button on the button bar).
         * 
         * @param backwards whether to focus backwards or not
         */
        __focus: function(backwards) {
            var dialog = this.__handle;
            
            // Focus first focusable element in dialog
            var focusable = dialog
                              .find("a, input:not([type=hidden]), .btn, select, textarea, button")
                              .not("[tabindex='0']")
                              .filter(function() {
                                  return $(this).parents(".form-actions").length == 0;
                              }).eq(0);
            
            // may be a button, too
            var focusableButtons = dialog
                                      .parent()
                                      .find(".modal-footer")
                                      .find("input[type=submit], input[type=button], .btn, button");
            
            var focusableElements = focusable.add(focusableButtons);
            var focusedElement = focusableElements[backwards ? "last" : "first"]();
            
            // Focus the element
            focusedElement.focus();
            
            dialog.trigger("dialog2.focussed", [focusedElement.get(0)]);
            return this;
        }, 
        
        /**
         * Focuses the dialog which will essentially focus the first
         * focusable element in it (e.g. a link or a button on the button bar).
         */
        focus: function() {
            return this.__focus();
        }, 
        
        /**
         * Close the dialog, removing its contents from the DOM if that is
         * configured.
         */
        close: function() {
            var dialog = this.__handle;
            var overlay = this.__overlay;
            
            overlay.hide();
            
            dialog
                .parent().hide().end()
                .trigger("dialog2.closed")
                .removeClass("opened");
        },
        
        /**
         * Open a dialog, if it is not opened already
         */
        open: function() {
            var dialog = this.__handle;
            
            if (!dialog.is(".opened")) {
                this.__overlay.show();
                
                dialog
                    .trigger("dialog2.before-open")
                    .addClass("opened")
                    .parent()
                        .show()
                        .end()
                    .trigger("dialog2.opened");
                    
                this.__focus();
            }
        }, 
        
        /**
         * Add button with the given name and options to the dialog
         * 
         * @param name of the button
         * @param options either function or options object configuring 
         *        the behaviour and markup of the button
         */
        addButton: function(name, options) {
            var handle = this.__handle;
            
            var callback = $.isFunction(options) ? options : options.click;
            var footer = handle.siblings(".modal-footer");

            var button = $("<a href='#' class='btn'></a>")
                                .html(name)
                                .click(function(event) {
                                    callback.apply(handle, [event]);
                                    event.preventDefault();
                                });

            // legacy
            if (options.primary) {
                button.addClass("btn-primary");
            }

            if (options.type) {
                button.addClass(options.type);
            }

            footer.append(button);
        }, 
        
        /**
         * Remove button with the given name
         * 
         * @param name of the button to be removed
         */
        removeButton: function(name) {
            var footer = this.__handle.siblings(".modal-footer");
                
            footer
                .find("a.btn")
                    .filter(function(i, e) {return $(e).text() == name;})
                        .remove();
			
			return this;
        }, 
        
        /**
         * Load the given url as content of this dialog
         * 
         * @param url to be loaded via GET
         */
        load: function(url) {
            var handle = this.__handle;
            
            if (handle.is(":empty")) {
                var loadText = this.options().initialLoadText;
                handle.html($("<span></span>").text(loadText));
            }
            
			handle
				.trigger("dialog2.ajax-start");
			
			dialogLoad.call(handle, url, this.__ajaxCompleteTrigger, this.__ajaxBeforeSend);
			
			return this;
        },
        
        /**
         * Apply the given options to the dialog
         * 
         * @param options to be applied
         */
        options: function(options) {
            var storedOptions = this.__handle.data("options");
            
            // Return stored options if getter was called
            if (!options) {
                return storedOptions;
            }
            
            var buttons = options.buttons;
            delete options.buttons;
            
            // Store options if none have been stored so far
            if (!storedOptions) {
                this.__handle.data("options", options);
            }
            
            var dialog = this;
            
            var handle = dialog.__handle;
            var overlay = dialog.__overlay;
            
            var parentHtml = handle.parent();
            
            if (options.title) {
                $(".modal-header h3", parentHtml).html(options.title);
            }
            
            if (buttons) {
                if (buttons.__mode != "append") {
                    $(".modal-footer", parentHtml).empty();
                }
                
                $.each(buttons, function(name, value) {
                    dialog.addButton(name, value);
                });
            }
            
            if (__boolean(options.closeOnOverlayClick)) {
                overlay.unbind("click");
                
                if (options.closeOnOverlayClick) {
                    overlay.click(function(event) {
                        if ($(event.target).is(".modal-backdrop")) {
                            dialog.close();
                        }
                    });
                }
            }
            
            if (__boolean(options.showCloseHandle)) {
                var closeHandleMode = options.showCloseHandle ? "show" : "hide";
                $(".modal-header .close", parentHtml)[closeHandleMode]();
            }
            
            if (__boolean(options.removeOnClose)) {
                handle.unbind("dialog2.closed", this.__removeDialog);
                
                if (options.removeOnClose) {
                    handle.bind("dialog2.closed", this.__removeDialog);
                }
            }
            
            if (options.autoOpen === true) {
                this.open();
            }
            
            if (options.content) {
                this.load(options.content);
            }
            
            delete options.buttons;
            
            options = $.extend(true, {}, storedOptions, options);
            this.__handle.data("options", options);
            
            return this;
        }, 
        
        /**
         * Returns the html handle of this dialog
         */
        handle: function() {
            return this.__handle;
        }
    };
    
    /**
     * Returns a simple DOM node which -- while being invisible to the user -- 
     * should focus the given argument when the focus is directed to itself. 
     */
    function FocusCatcher(dialog, reverse) {
        return $("<span />")
            .css({"float": "right", "width": "0px"})
            .attr("tabindex", 0)
            .focus(function(event) {
                  $(dialog).dialog2("__focus", reverse);
                  event.preventDefault();
            });
    };
    
    /**
     * Plugging the extension into the jQuery API
     */
    $.extend($.fn, {
        
        /**
         * options = {
         *   title: "Some title", 
         *   id: "my-id", 
         *   buttons: {
         *     "Name": Object || function   
         *   }
         * };
         * 
         * $(".selector").dialog2(options);
         * 
         * or 
         * 
         * $(".selector").dialog2("method", arguments);
         */
        dialog2: function() {
            var args = $.makeArray(arguments);
            var arg0 = args.shift();
            
            var dialog = $(this).data("dialog2");
            if (!dialog) {
                var options = $.extend(true, {}, $.fn.dialog2.defaults);
                if ($.isPlainObject(arg0)) {
                    options = $.extend(true, options, arg0);
                }
                
                dialog = new Dialog2(this, options);
                dialog.handle().data("dialog2", dialog);
            } else {
                if (typeof arg0 == "string") {
                    var method = dialog[arg0];
                    if (method) {
                        var result = dialog[arg0].apply(dialog, args);
                        return (result == dialog ? dialog.handle() : result);
                    } else {
                        throw new __error("Unknown API method '" + arg0 + "'");
                    }
                } else 
                if ($.isPlainObject(arg0)) {
                    dialog.options(arg0);
                } else {
                    throw new __error("Unknown API invocation: " + arg0 + " with args " + args);
                }
            }

            return dialog.handle();
        }
    });
    
    /***********************************************************************
     * Closing dialog via ESCAPE key
     ***********************************************************************/
    
    $(document).ready(function() {
        $(document).keyup(function(event) {
            if (event.which == 27) { // ESCAPE key pressed
                $(this).find(".modal > .opened").each(function() {
                    var dialog = $(this);
                    if (dialog.dialog2("options").closeOnEscape) {
                        dialog.dialog2("close");
                    }
                });
            }
        });
    });
    
    
    /***********************************************************************
     * Limit TAB integration in open modals via keypress
     ***********************************************************************/

    $(document).ready(function(event) {

        $(document).keyup(function(event) {
            if (event.which == 9) { // TAB key pressed
                // There is actually a dialog opened
                if ($(".modal .opened").length) {
                    // Set timeout (to let the browser perform the tabbing operation
                    // and check the active element)
                    setTimeout(function() {
                        var activeElement = document.activeElement;
                        if (activeElement) {
                            var activeElementModal = $(activeElement).parents(".modal").find(".modal-body.opened");
                            // In the active modal dialog! Everything ok
                            if (activeElementModal.length != 0) {
                                return;
                            }
                        }
    
                        // Did not return; have to focus active modal dialog
                        $(".modal-body.opened").dialog2("focus");
                    }, 0);
                }
            }
        });
    });

    /**
     * Random helper functions; today: 
     * Returns true if value is a boolean
     * 
     * @param value the value to check
     * @return true if the value is a boolean
     */
    function __boolean(value) {
        return typeof value == "boolean";
    };
    
    /**
     * Creates a dialog2 error with the given message
     * 
     * @param errorMessage stuff to signal the user
     * @returns the error object to be thrown
     */
    function __error(errorMessage) {
        new Error("[jquery.dialog2] " + errorMessage);
    };
    
    /**
     * Dialog2 plugin defaults (may be overriden)
     */
    $.fn.dialog2.defaults = {
        autoOpen: true, 
        closeOnOverlayClick: true, 
        removeOnClose: true, 
        showCloseHandle: true, 
        initialLoadText: "", 
        closeOnEscape: true, 
		beforeSend: null
    };
    
    /***********************************************************************
     * Localization
     ***********************************************************************/
    
    $.fn.dialog2.localization = {
        "de": {
            cancel: "Abbrechen"
        },
        "en": {
            cancel: "Cancel"
        }
    };
    
    var lang = $.fn.dialog2.localization["en"];
    
    /**
     * Localizes a given key using the selected language
     * 
     * @param key the key to localize
     * @return the localization of the key or the key itself if it could not be localized.
     */
    function localize(key) {
        return lang[key.toLowerCase()] || key;
    };
    
    /**
     * Creates a localized button and returns the buttons object specifying 
     * a number of buttons. May pass a buttons object to add the button to.
     * 
     * @param name to be used as a button label (localized)
     * @param functionOrOptions function or options to attach to the button
     * @param buttons object to attach the button to (may be null to create new one)
     * 
     * @returns buttons object or new object with the button added
     */
    function localizedButton(name, functionOrOptions, buttons) {
        buttons = buttons || {};
        buttons[localize(name)] = functionOrOptions;
        return buttons;
    };
    
    /**
     * Expose some localization helper methods via $.fn.dialog2.localization
     */
    $.extend($.fn.dialog2.localization, {
        localizedButton: localizedButton, 
        get: localize, 
        
        setLocale: function(key) {
            var localization = $.fn.dialog2.localization[key];

            if (localization == null) {
                throw new Error("No localizaton for language " + key);
            } else {
                lang = localization;
            }
        }
    });
    
    /**
     * Returns a localized cancel button
     * @return a buttons object containing a localized cancel button 
     *         (including its close functionality)
     */
    function localizedCancelButton() {
        return localizedButton("close", function() {
            $(this).dialog2("close");
        });
    };
    
    /***********************************************************************
     * jQuery load with before send integration
	 * copied from jQuery.fn.load but with beforeSendCallback support
     ***********************************************************************/
    
	function dialogLoad(url, completeCallback, beforeSendCallback) {
		// Don't do a request if no elements are being requested
		if ( !this.length ) {
			return this;
		}

		var selector, type, response,
			self = this,
			off = url.indexOf(" ");

		if ( off >= 0 ) {
			selector = url.slice( off, url.length );
			url = url.slice( 0, off );
		}
		
		// Request the remote document
		jQuery.ajax({
			url: url,

			// if "type" variable is undefined, then "GET" method will be used
			type: type,
			dataType: "html",
			beforeSend: beforeSendCallback, 
			complete: function( jqXHR, status ) {
				if ( completeCallback ) {
					self.each( completeCallback, response || [ jqXHR.responseText, status, jqXHR ] );
				}
			}
		}).done(function( responseText ) {

			// Save response for use in complete callback
			response = arguments;

			// See if a selector was specified
			self.html( selector ?

				// Create a dummy div to hold the results
				jQuery("<div>")

					// inject the contents of the document in, removing the scripts
					// to avoid any 'Permission Denied' errors in IE
					.append( responseText.replace( rscript, "" ) )

					// Locate the specified elements
					.find( selector ) :

				// If not, just inject the full result
				responseText );

		});

		return this;
	}
	
    /***********************************************************************
     * Integration with jquery.controls
     ***********************************************************************/
    
    /**
     * Register opening of a dialog on annotated links
     * (works only if jquery.controls plugin is installed). 
     */
    if ($.fn.controls && $.fn.controls.bindings) {
        $.extend($.fn.controls.bindings, {
            "a.open-dialog": function() {
                var a = $(this).removeClass("open-dialog");
                
                var id = a.attr("rel");
                var content = a.attr("href");
                
                var options = {
                    modal: true
                };

                var element;

                if (id) {
                    var e = $("#" + id);
                    if (e.length) element = e;
                }

                if (!element) {
                    if (id) {
                        options.id = id;
                    }
                }
                
                if (a.attr("data-dialog-class")) {
                    options.modalClass = a.attr("data-dialog-class");
                }
                
                if (a.attr("title")) {
                    options.title = a.attr("title");
                }
                
                $.each($.fn.dialog2.defaults, function(key, value) {
                    if (a.attr(key)) {
                        options[key] = a.attr(key) == "true";
                    }
                });
                
                if (content && content != "#") {
                    options.content = content;
                    
                    a.click(function(event) {
                        event.preventDefault();
                        $(element || "<div></div>").dialog2(options);
                    });
                } else {
                    options.removeOnClose = false;
                    options.autoOpen = false;
                    
                    element = element || "<div></div>";
                    
                    // Pre initialize dialog
                    $(element).dialog2(options);
                    
                    a.attr("href", "#")
                     .click(function(event) {
                         event.preventDefault();
                         $(element).dialog2("open");
                     });
                }
            }
        });
    };
})(jQuery);


/*
 * Dialog2: Yet another dialog plugin for jQuery.
 * 
 * This time based on bootstrap styles with some nice ajax control features, 
 * zero dependencies to jQuery.UI and basic options to control it.
 * 
 * Licensed under the MIT license 
 * http://www.opensource.org/licenses/mit-license.php 
 * 
 * @version: 2.0.0 (22/03/2012)
 * 
 * @requires jQuery >= 1.4 
 * 
 * @requires jQuery.form plugin (http://jquery.malsup.com/form/) >= 2.8 for ajax form submit 
 * @requires jQuery.controls plugin (https://github.com/Nikku/jquery-controls) >= 0.9 for ajax link binding support
 * 
 * @requires bootstrap styles (twitter.github.com/bootstrap) in version 2.x to look nice
 * 
 * @author nico.rehwaldt
 */

/**
 * This script file extends the plugin to provide helper functions
 * alert(), confirm() and prompt()
 * 
 * Thanks to ulrichsg for the contribution
 */
(function($) {
    var localizedButton = $.fn.dialog2.localization.localizedButton;
    
    var __helpers = {
        
        /**
         * Creates an alert displaying the given message.
         * Will call options.close on close (if specified).
         * 
         *   $.fn.dialog2.alert("This dialog is non intrusive", { 
         *       close: function() {
         *           alert("This one is!");
         *       }
         *   });
         * 
         * @param message to be displayed as the dialog body
         * @param options (optional) to be used when creating the dialog
         */
        alert: function(message, options) {
            options = $.extend({}, options);
            var labels = $.extend({}, $.fn.dialog2.helpers.defaults.alert, options);
            
            var dialog = $("<div />");
            
            var closeCallback = options.close;
            delete options.close;
            
            var buttons = localizedButton(labels.buttonLabelOk, __closeAndCall(closeCallback, dialog));
            
            return __open(dialog, message, labels.title, buttons, options);
        }, 
        
        /**
         * Creates an confirm dialog displaying the given message.
         * 
         * Will call options.confirm on confirm (if specified).
         * Will call options.decline on decline (if specified).
         * 
         *   $.fn.dialog2.confirm("Is this dialog non intrusive?", {
         *       confirm: function() { alert("You said yes? Well... no"); }, 
         *       decline: function() { alert("You said no? Right choice!") }
         *   });
         * 
         * @param message to be displayed as the dialog body
         * @param options (optional) to be used when creating the dialog
         */
        confirm: function(message, options) {
            options = $.extend({}, options);
            var labels = $.extend({}, $.fn.dialog2.helpers.defaults.confirm, options);
            
            var dialog = $("<div />");
            
            var confirmCallback = options.confirm;
            delete options.confirm;
            
            var declineCallback = options.decline;
            delete options.decline;
            
            var buttons = {};
            localizedButton(labels.buttonLabelYes, __closeAndCall(confirmCallback, dialog), buttons);
            localizedButton(labels.buttonLabelNo, __closeAndCall(declineCallback, dialog), buttons);
            
            return __open(dialog, message, labels.title, buttons, options);
        },
        
        /**
         * Creates an prompt dialog displaying the given message together with 
         * an element to input text in.
         * 
         * Will call options.ok on ok (if specified).
         * Will call options.cancel on cancel (if specified).
         * 
         *   $.fn.dialog2.prompt("What is your age?", {
         *       ok: function(event, value) { alert("Your age is: " + value); }, 
         *       cancel: function() { alert("Better tell me!"); }
         *   });
         * 
         * @param message to be displayed as the dialog body
         * @param options (optional) to be used when creating the dialog
         */
        prompt: function(message, options) {
            // Special: Dialog has to be closed on escape or multiple inputs
            // with the same id will be added to the DOM!
            options = $.extend({}, options, {closeOnEscape: true});
            var labels = $.extend({}, $.fn.dialog2.helpers.defaults.prompt, options);
            
            var inputId = 'dialog2.helpers.prompt.input.id';
            var input = $("<input type='text' class='span6' />")
                                .attr("id", inputId)
                                .val(options.defaultValue || "");
                                
            var html = $("<form class='form-stacked'></form>");
            html.append($("<label/>").attr("for", inputId).text(message));
            html.append(input);
            
            var dialog = $("<div />");
            
            var okCallback;
            if (options.ok) {
                var fn = options.ok;
                okCallback = function(event) { fn.call(dialog, event, input.val()); };
            }
            delete options.ok;
            
            var cancelCallback = options.cancel;
            delete options.cancel;
            
            var buttons = {};
            localizedButton(labels.buttonLabelOk, __closeAndCall(okCallback, dialog), buttons);
            localizedButton(labels.buttonLabelCancel, __closeAndCall(cancelCallback, dialog), buttons);
            
            // intercept form submit (on ENTER press)
            html.bind("submit", __closeAndCall(okCallback, dialog));
            
            __open(dialog, html, labels.title, buttons, options);
        }, 
        
        /**
         * Default helper options
         */
        defaults: {}
    };
    
    function __closeAndCall(callback, dialog) {
        return $.proxy(function(event) {
            event.preventDefault();
            
            $(this).dialog2("close");
            
            if (callback) {
                callback.call(this, event);
            }
        }, dialog || this);
    };
    
    function __open(e, message, title, buttons, options) {
        options.buttons = buttons;
        options.title = title;
        
        return e.append(message).dialog2(options);
    };
    
    $.extend(true, $.fn.dialog2, {
        helpers: __helpers
    });
    
    $.extend($.fn.dialog2.helpers.defaults, {
        alert: {
            title: 'Alert', 
            buttonLabelOk: 'Ok' 
        }, 
        
        prompt: {
            title: 'Prompt',
            buttonLabelOk: 'Ok', 
            buttonLabelCancel: 'Cancel' 
        }, 
        
        confirm: {
            title: 'Confirmation',
            buttonLabelYes: 'Yes',
            buttonLabelNo: 'No'
        }
    });
})(jQuery);
