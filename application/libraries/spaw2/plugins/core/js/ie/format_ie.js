// specific format functions
SpawPGcore.bgColorClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var cl = editor.getPageDoc(editor.getActivePage().name).queryCommandValue("backcolor"); 
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
    pdoc.execCommand('backcolor', false, result);
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
      return editor.getActivePageDoc().queryCommandEnabled("backcolor");
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
