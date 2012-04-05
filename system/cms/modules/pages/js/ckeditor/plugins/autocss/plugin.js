// Allows customers to insert a link to a CMS/DB page.
CKEDITOR.plugins.add('autocss', {
	CONFIG : {
		defaultBackgroundColor : 'white'
	},
	init : function(editor) {
		var customCssForCkeditor = [];
		var stylesheets = $('link[rel=stylesheet]');
		for(var i = 0; i < stylesheets.length; i++) {
			var href = stylesheets[i].getAttribute('href');

			// skip ckeditor
			if(href.indexOf('ckeditor') === -1) {
				customCssForCkeditor.push(href);
			}
		}
		editor.config.contentsCss = customCssForCkeditor;

		// override any html/body backgrounds from the injected css
		// so that the editor area will 'bleed thru' to the main page
		// locate applicable bg color
		var bgColor = this.CONFIG.defaultBackgroundColor, e = $(editor.element.$).parent();
		while(true) {
			var eBgColor = e.css('background-color');
			if(eBgColor !== 'rgba(0, 0, 0, 0)' && eBgColor !== 'transparent') {
				bgColor = eBgColor;
				break;
			}

			// break out; we don't need to go past <html> or we hit a weird jQuery bug on Document
			if(e.is('html'))
				break;

			// traverse up the dom
			e = e.parent();
			if(!e)
				break;
		}
		editor.addCss("html,body { background: " + bgColor + "; width:100%; }");
	}
});

