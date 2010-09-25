CKEDITOR.plugins.add('pyrofiles',{
    requires: ['iframedialog'],
    init:function(a){
        CKEDITOR.dialog.addIframe('pyrofiles_dialog', 'Files', BASE_URI + 'admin/wysiwyg/files',800,500)
        var cmd = a.addCommand('pyrofiles', {exec:pyrofiles_onclick})
        cmd.modes={wysiwyg:1}
        cmd.canUndo=false
        a.ui.addButton('pyrofiles',{ label:'Select form from library', command:'pyrofiles', icon:this.path+'images/icon.png' })
    }
});

function pyrofiles_onclick(e)
{
	update_instance();
    // run when custom button is clicked]
    CKEDITOR.currentInstance.openDialog('pyrofiles_dialog')
}