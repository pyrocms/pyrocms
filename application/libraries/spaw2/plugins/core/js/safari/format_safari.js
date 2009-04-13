// specific format functions
SpawPGcore.bgColorClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var cl = editor.getPageDoc(editor.getActivePage().name).queryCommandValue("hilitecolor"); 
    if (cl == null)
      cl = '#ffffff';
    SpawEngine.openDialog('core', 'colorpicker', editor, SpawColor.parseRGB(cl), '', 'SpawPGcore.bgColorClickCallback', tbi, sender);
  }
}
SpawPGcore.bgColorClickCallback = function(editor, result, tbi, sender)
{
  var pdoc = editor.getPageDoc(editor.active_page.name);
  try
  {
    pdoc.execCommand('hilitecolor', false, result);
    editor.focus();
  }
  catch(e)
  {}
}
SpawPGcore.isBgColorEnabled = function(editor, tbi)
{
  if(editor.isInDesignMode())
  {
    try
    {
      return editor.getActivePageDoc().queryCommandEnabled("hilitecolor");
    }
    catch(e)
    {
      return false;
    }
  }
  else
  {
    return false;
  }
}
