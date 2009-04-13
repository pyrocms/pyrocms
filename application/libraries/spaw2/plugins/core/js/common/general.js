// common plugin functions
// returns true if current page is in design mode
SpawPGcore.isInDesignMode = function(editor, tbi)
{
  return editor.isInDesignMode();
}
SpawPGcore.isInHtmlMode = function(editor, tbi)
{
  return !editor.isInDesignMode();
}
