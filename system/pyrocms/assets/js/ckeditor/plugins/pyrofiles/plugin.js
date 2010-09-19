(function() {

	var pluginName = 'customvideo';

	CKEDITOR.plugins.add('pyrofiles',
	{
	} );

})();

function pyrofiles_onclick(e)
{
	update_instance();
    // run when custom button is clicked]
    CKEDITOR.currentInstance.openDialog('pyrofiles_dialog')
}

/*CKEDITOR.plugins.pyrofiles =
{
	/**
	 *  Get the surrounding link element of current selection.
	 * @param editor
	 * @example CKEDITOR.plugins.link.getSelectedLink( editor );
	 * @since 3.2.1
	 * The following selection will all return the link element.
	 *	 <pre>
	 *  <a href="#">li^nk</a>
	 *  <a href="#">[link]</a>
	 *  text[<a href="#">link]</a>
	 *  <a href="#">li[nk</a>]
	 *  [<b><a href="#">li]nk</a></b>]
	 *  [<a href="#"><b>li]nk</b></a>
	 * </pre>
	getSelectedLink : function( editor )
	{
		var range;
		try { range  = editor.getSelection().getRanges()[ 0 ]; }
		catch( e ) { return null; }

		range.shrink( CKEDITOR.SHRINK_TEXT );
		var root = range.getCommonAncestor();
		return root.getAscendant( 'a', true );
	}
}; */