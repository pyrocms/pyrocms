CKEDITOR.plugins.add('pyroimages',{
    requires: ['iframedialog'],
    init:function(a){
        CKEDITOR.dialog.addIframe('pyroimages_dialog', 'Images', BASE_URI + 'admin/wysiwyg/images',800,500)
        var cmd = a.addCommand('pyroimages', {exec:pyroimages_onclick})
        cmd.modes={wysiwyg:1}
        cmd.canUndo=false
        a.ui.addButton('pyroimages',{ label:'Select form from library', command:'pyroimages', icon:this.path+'images/icon.png' })
    }
});

function pyroimages_onclick(e)
{
	update_instance();
    // run when custom button is clicked]
    CKEDITOR.currentInstance.openDialog('pyroimages_dialog')
}