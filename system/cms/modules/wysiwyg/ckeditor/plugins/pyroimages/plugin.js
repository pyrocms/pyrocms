CKEDITOR.plugins.add('pyroimages',
{
    requires: ['iframedialog'],
    init : function(editor)
    {
        CKEDITOR.dialog.addIframe('pyroimage_dialog', 'Image', SITE_URL + 'admin/wysiwyg/image',800,500)
        editor.addCommand('pyroimages', {exec:pyroimage_onclick});
        editor.ui.addButton('pyroimages',{ label:'Upload or insert images from library', command:'pyroimages', icon:this.path+'images/icon.png' });

		editor.on('selectionChange', function(evt)
		{
			/*
			 * Despite our initial hope, document.queryCommandEnabled() does not work
			 * for this in Firefox. So we must detect the state by element paths.
			 */
			var command = editor.getCommand('pyroimages'),
				element = evt.data.path.lastElement.getAscendant('img', true);

			// If nothing or a valid document
			if ( ! element || (element.getName() == 'img' && element.hasClass('pyro-image')))
			{
				command.setState(CKEDITOR.TRISTATE_OFF);
			}

			else
			{
				command.setState(CKEDITOR.TRISTATE_DISABLED);
			}
		});

		// When the "Image Properties" dialog windows is closed with the OK button, ckeditor inserts the updated element into the editor
		// without calling the dataProcessor on it.
		// This results in the image appearing as broken, as the {{ url:site }} isn't filtered out.
		// We overcome this by hooking into the dialogHide event for the "Image Properties" dialog, and triggering an event
		// which causes the newly-updated element (and everything else) to be processed by the dataProcessor.
		editor.on('dialogHide', function(e) {
			if (e.data.getName() != 'image')
				return;

			editor.getMode().loadData( editor.getData() );
		});
	},

	// Create a filter which re-writes {{ url:site }} and {{ url:base }} to the JS constants SITE_URL and BASE_URL when rendering a wysiwyg preview
	// This means that img src values can contain the above template variables, and ckeditor will render the image correctly.
	// Having {{url:site }} in image src values allows the site to change URL without all images breaking
	afterInit : function( editor )
	{
		var dataProcessor = editor.dataProcessor;
		var dataFilter = dataProcessor && dataProcessor.dataFilter;

		if ( !dataFilter )
			return;

		dataFilter.addRules(
		{
			elements:
			{
				'img': function(element)
				{
					// Replace both url-encoded and non-url-encoded forms of {{ url:site }} and {{ url: base }} with their corresponding JS constants
					// (FF produces a urlencoded version, chrome and IE don't)
					var src = element.attributes.src;
					src = src.replace("{{ url:site }}", SITE_URL).replace("%7B%7B%20url:site%20%7D%7D", SITE_URL);
					src = src.replace("{{ url:base }}", BASE_URL).replace("%7B%7B%20url:base%20%7D%7D", BASE_URL);
					element.attributes.src = src;

					return element;
				}
			}
		})
	}
});

function pyroimage_onclick(e)
{
	update_instance();
    // run when pyro button is clicked]
    CKEDITOR.currentInstance.openDialog('pyroimage_dialog')
}