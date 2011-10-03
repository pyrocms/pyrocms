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
    }
});

function pyroimage_onclick(e)
{
	update_instance();
    // run when pyro button is clicked]
    CKEDITOR.currentInstance.openDialog('pyroimage_dialog')
}