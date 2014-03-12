/**
 * Admin
 *
 * Supporting JS for PyroCMS /admin
 */


/**
 * Overload the json converter to avoid error when json is null or empty.
 */
$.ajaxSetup({
    //allowEmpty: true,
    converters: {
        'text json': function (text) {
            var json = jQuery.parseJSON(text);
            if (!jQuery.ajaxSettings.allowEmpty == true && (json == null || jQuery.isEmptyObject(json))) {
                jQuery.error('The server is not responding correctly, please try again later.');
            }
            return json;
        }
    },
    data: {
        csrf_hash_name: $.cookie(Pyro.csrf_cookie_name)
    }
});


/**
 * Initialize our application
 * - Set up listeners, etc
 */

Pyro.Initialize = function () {

    /**
     * We're loading
     */

    Pyro.Loading();

    $(document).on('click', 'a[href^="http"][target!="_blank"]:not([data-toggle="modal"]):not(.confirm):not(.double-confirm):not(.ignore-loading):not(.ajax)', function (e) {

        // Could be opening in a new window
        if (e.ctrlKey) return true;
        if (e.altKey) return true;
        if (e.metaKey) return true;

        // Ya.. we're loading..
        Pyro.Loading();

        // Automate exist
        $('[data-exit-animation]').each(function () {
            $(this).addClass('animated-zing').addClass($(this).attr('data-exit-animation'));
        });
    });


    /**
     * Mobile Detection
     */

    Pyro.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    // For development
    //Pyro.isMobile = true;


    /**
     * Collapse Tabs
     * - For mobiles, collapse tabs to accordian
     */

    if (Pyro.isMobile) {
        $('.nav.nav-tabs').tabCollapse();
        $('.nav.nav-tabs').remove(); // This prevents WYSIWYG errors
        $('.tab-content').remove(); // This prevents WYSIWYG errors
    }

    /**
     * Persistent Tabs
     */
    $('.nav-tabs').on('click', 'a', function (e) {
        e.preventDefault();
        window.location.hash = $(this).attr('href');
        $(this).tab('show');
    });

    if (window.location.hash) {
        $('.nav-tabs').find('a[href="' + window.location.hash + '"]').tab('show');
    }

    /**
     * Clean modals after hiding because we recycle it
     */
    $(document).on('click', 'a[data-toggle="modal"][data-target="#modal"]', function (e) {

        // This is broken.. leave it for now

        // Empty it!
        $('#modal').html('');

        // Fixes a bootstrap bug that prevents
        // a modal from being reused
        $('#modal').load($(e.target).attr('href'));
    });


    /**
     * Sortable Lists
     */

    $('.sortable').nestable({
        group: $(this).attr('id'),
        maxDepth: $(this).attr('data-max-depth') == undefined ? 5 : $(this).attr('data-max-depth'),
        listNodeName: 'ul'
    });

    $(document).on('change', '.sortable', function (e) {
        $.ajax({
            type: 'POST',
            url: $(e.target).attr('data-order-url'),
            dataType: 'json',
            data: {
                'ids': $(e.target).nestable('serialize')
            },
            success: function (data) {
                alert(data);
            }
        });
    });


    /**
     * Just in case there's a form - focus on the fist input
     */

    $(document).ready(function () {
        $('.input :input:visible:first').focus();
    });


    /**
     * Toggle Classes
     */

    $(document).on('click', '[data-toggle^="class:"]', function (e) {

        e.preventDefault();
        $($(this).attr('data-target')).toggleClass($(this).attr('data-toggle').replace('class:', ''));

        // Save persistent state
        if ($(this).attr('data-persistent') !== undefined)
            $.cookie('persistent_' + $(this).attr('data-persistent'), $($(this).attr('data-target')).hasClass($(this).attr('data-toggle').replace('class:', '')), { path: '/' });
    });


    /**
     * Selectize
     */

    $('select:not(.skip):not(.selectized)').selectize();
    $('input[type="text"].tags').selectize({
        delimiter: ',',
        create: function (input) {
            return {
                value: input,
                text: input
            }
        }
    });


    /**
     * Zen Inputs
     */
    $('textarea[class="zen"]').each(function () {
        var random = Math.floor(Math.random() * 111) + '_zen';
        $(this).zenForm().addClass(random).before('<a href="#" data-toggle="zen-mode" data-target=".' + random + '">Test</a>');
    });

    $(document).on('click', '[data-toggle^="zen-mode"]', function (e) {
        e.preventDefault();
        $($(e.target).attr('data-target')).trigger('init');
    });


    /**
     * Select All Actions
     */

    $(document).on('click', 'input[type="checkbox"].check-all', function (e) {
        $(e.target).closest('table').find('input[type="checkbox"][name="action_to[]"]').prop('checked', $(e.target).prop('checked'));
    });


    /**
     * Tooltips
     */

    $('[data-toggle="tooltip"]').tooltip();


    /**
     * Popovers
     */

    $(document).on('click', '[data-toggle="popover"]', function (e) {
        e.preventDefault();
    });
    $('[data-toggle="popover"]').popover();


    /**
     * Confirmation Trigger
     */

    $(document).on('click', '.confirm', function (e) {

        var href = $(this).attr('href');
        var removemsg = $(this).attr('title');

        if (confirm(removemsg || Pyro.lang.dialog_message)) {
            $(this).trigger('click-confirmed');

            if ($.data(this, 'stop-click')) {
                $.data(this, 'stop-click', false);
                return;
            }
        } else {
            e.preventDefault();
            return false;
        }
    });

    $(document).on('click', '.double-confirm', function (e) {

        var href = $(this).attr('href');
        var removemsg = $(this).attr('title');
        var secondremovemsg = $(this).attr('alt');

        if (confirm(removemsg || Pyro.lang.dialog_message) && confirm(secondremovemsg || Pyro.lang.dialog_message)) {
            $(this).trigger('click-confirmed');

            if ($.data(this, 'stop-click')) {
                $.data(this, 'stop-click', false);
                return;
            }
        } else {
            e.preventDefault();
            return false;
        }
    });


    /**
     * Register Hot-Keys
     */

    $(document).on('keyup', function (e) {

        // Ignore if we're typing or selecting something
        if ($('input, textarea, select').is(':focus')) {
            return true;
        }
        if (window.getSelection() != '') {
            return true;
        }

        // Get the character key
        var key = String.fromCharCode(e.which).toLowerCase();

        //alert(e.which);

        // Catch some funky ones
        if (e.which == 186) key = ':';
        if (e.which == 191) key = '/';

        // Detect special keys
        if (e.which == 13) key = 'enter';

        // Shift?
        if (e.shiftKey) key = 'shift+' + key;

        // Shift?
        if (e.ctrlKey) key = 'ctrl+' + key;

        // Gotta exist
        if ($('[data-hotkey^="' + key + '"]').length == 0) return true;

        // If it has a click event - trigger it
        if ($('[data-hotkey^="' + key + '"]').attr('data-follow') == 'yes') {
            Pyro.Loading();
            window.location = $('[data-hotkey="' + key + '"]').attr('href');
        } else {
            $('[data-hotkey^="' + key + '"]').trigger('click');
        }
    });


    /**
     * Search stuff
     */

    $('#search .search-terms').selectize({
        delimiter: '|',
        create: function (input) {
            return {
                value: input,
                text: input
            }
        }
    });

    $(document).on('click', '[data-toggle^="global-search"]', function (e) {
        e.preventDefault();
        if ($('body').hasClass('search-off-screen')) return false;
        $('body').removeClass('nav-off-screen').toggleClass('search-off-screen');
        $('#actions').toggleClass('scrollable');
        $('#search .search-terms').val('');
        $('#search .selectize-input input').focus();
    });

    $(document).on('click', '[data-toggle^="module-search"]', function (e) {
        e.preventDefault();
        $('body').removeClass('nav-off-screen').toggleClass('search-off-screen');
        $('#search .selectize-input input').val(Pyro.current_module + ':').focus();

        // Spoof a keypress
        var e = $.event('keydown');

        // (enter)
        e.which = 13;

        // Trigger it
        $('#search .selectize-input input').trigger(e);
    });

    $('#search .search-terms').on('change', function (e) {
        if ($(e.target).val().length != 0) {
            Pyro.Search();
        }
    });

    $(document).on('click', '[data-dismiss^="global-search"]', function (e) {
        e.preventDefault();
        if ($('body').hasClass('search-off-screen'))
            $('body').removeClass('search-off-screen');
    });

    $(document).on('keydown', function (e) {
        if ($('body').hasClass('search-off-screen') && e.which == 27)
            $('body').removeClass('search-off-screen');
    });


    /**
     * Code Editors
     */

    $('[data-editor]').each(function () {

        // The thing
        var editor_input = $(this);

        // Spawn an ID
        var id = Math.floor(Math.random() * 111) + '_' + editor_input.attr('data-editor') + '_editor';

        // Get the language
        var language = $(this).attr('data-editor');

        // Add the ID
        editor_input.attr('data-editor', id).hide().after('<div id="' + id + '" class="editor" style="height: 500px;"></div>');

        // Span an editor
        var editor = ace.edit(id);

        ace.config.set('basePath', 'system/cms/themes/pyrocms/build/js/plugins/ace/');
        editor.setTheme('ace/theme/xcode');
        editor.getSession().setMode('ace/mode/' + language);

        // Set the current value
        editor.setValue(editor_input.val());

        // Listen for submission
        if (editor_input.is('textarea')) {
            editor_input.closest('form').on('submit', function () {
                editor_input.val(editor.getValue());
            });
        }
    });


    /**
     * Input Masks
     */

    $('input[data-mask]').each(function () {
        $(this).mask($(this).attr('data-mask'));
    });


    /**
     * Datepicker
     */

    $('[data-toggle^="datepicker"]').each(function () {
        $(this).datepicker({
            autoclose: true
        });

        $(this).datepicker('update', $(this).data('date'));
    });


    /**
     * Timepicker
     */

    $('[data-toggle^="timepicker"]').timepicker({ template: false, minuteStep: 5, defaultTime: false });

    /**
     * Nowrap table cols with overflow-ellipsis
     */

    $('table td.overflow-ellipsis').each(function () {
        $(this).css('max-width', '1px');
    });

    /**
     * Autosize textarea
     */

    $('textarea.autosize').autosize();
}


/**
 * Loading
 * - Pass boolean
 * - Prevents clicking
 */

Pyro.Loading = function (loading) {

    // Catch default
    if (loading == undefined) loading = true;

    if (loading)
        $('#loading').addClass('animated-fast pulse').fadeIn(200);
    else
        $('#loading').removeClass().fadeOut(200);
}


/**
 * Generate a slug from text
 */

Pyro.GenerateSlug = function (input_form, output_form, space_character, disallow_dashes) {

    var slug, value;

    $(document).on('keyup', input_form, function () {
        value = $(input_form).val();

        if (value == '') return;

        space_character = space_character || '-';
        disallow_dashes = disallow_dashes || false;
        var rx = /[a-z]|[A-Z]|[0-9]|[áàâąбćčцдđďéèêëęěфгѓíîïийкłлмñńňóôóпúùûůřšśťтвýыžżźзäæœчöøüшщßåяюжαβγδεέζηήθιίϊκλμνξοόπρστυύϋφχψωώ]/,
            value = value.toLowerCase(),
            chars = Pyro.foreign_characters,
            space_regex = new RegExp('[' + space_character + ']+', 'g'),
            space_regex_trim = new RegExp('^[' + space_character + ']+|[' + space_character + ']+$', 'g'),
            search, replace;


        // If already a slug then no need to process any further
        if (!rx.test(value)) {
            slug = value;
        } else {
            value = $.trim(value);

            if (chars !== undefined) {
                for (var i = chars.length - 1; i >= 0; i--) {
                    // Remove backslash from string
                    search = chars[i].search.replace(new RegExp('/', 'g'), '');
                    replace = chars[i].replace;

                    // create regex from string and replace with normal string
                    value = value.replace(new RegExp(search, 'g'), replace);
                }
                ;
            }

            slug = value.replace(/[^-a-z0-9~\s\.:;+=_]/g, '')
                .replace(/[\s\.:;=+]+/g, space_character)
                .replace(space_regex, space_character)
                .replace(space_regex_trim, '');

            // Remove the dashes if they are
            // not allowed.
            if (disallow_dashes) {
                slug = slug.replace(/-+/g, '_');
            }
        }

        $(output_form).val(slug);
    });
}


/**
 * Search
 */

Pyro.Search = function () {

    Pyro.Loading(true);

    $.ajax({
        type: 'POST',
        url: BASE_URL + 'admin/search/results',
        data: {
            'terms': $('#search input.search-terms').val(),
            'csrf_hash_name': $.cookie(Pyro.csrf_cookie_name)
        },
        dataType: 'JSON',
        success: function (json) {

            var results = $('#search-results');

            results.html('');

            if (json.length != 0) {
                $.each(json.results, function (i, result) {
                    var template = '<ul>' +
                        '<li>' +
                        '<h3><a href="' + BASE_URL + result.cp_uri + '">' + result.module + ' > ' + result.entry_singular + ' > ' + result.title + '</a></h3>' +
                        '<p>' + result.description + '</p>' +
                        '<a href="' + BASE_URL + result.cp_uri + '" class="btn btn-xs btn-warning">Admin URL</a> ' +
                        '<a href="' + BASE_URL + result.uri + '" class="btn btn-xs btn-success" target="_blank">Public URL</a>' +
                        '</li>' +
                        '</ul>';
                    results.append(template);
                });
            }

            Pyro.Loading(false);
        },
        error: function function_name() {
            Pyro.Loading(false);
        }

    });
}


// Go.
Pyro.Initialize();


$(document).ready(function () {
    Pyro.Loading(false);
});