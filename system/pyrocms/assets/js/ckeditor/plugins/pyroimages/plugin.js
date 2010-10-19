CKEDITOR.plugins.add('pyroimages',{
    requires: ['iframedialog'],
    init : function(editor)
	{
        CKEDITOR.dialog.addIframe('pyroimage_dialog', 'Image', BASE_URI + 'cms/wysiwyg/image',800,500)
        var cmd = editor.addCommand('pyroimages', {exec:pyroimage_onclick})
        cmd.modes={wysiwyg:1}
        editor.ui.addButton('pyroimages',{ label:'Upload or insert images from library', command:'pyroimage', icon:this.path+'images/icon.png' });

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
    }
});

function pyroimage_onclick(e)
{
	update_instance();
    // run when pyro button is clicked]
    CKEDITOR.currentInstance.openDialog('pyroimage_dialog')
}