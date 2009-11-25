CodeMirror.fromTextArea('css_editor', {
    height: "30em",
    width: "41.6em",
    parserfile: "parsecss.js",
    stylesheet: APPPATH_URI + "assets/css/codemirror/csscolors.css",
    path: APPPATH_URI + "assets/js/codemirror/"
});