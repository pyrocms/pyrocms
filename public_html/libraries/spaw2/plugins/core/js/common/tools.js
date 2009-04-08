SpawPGcore.toggleBordersClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var pdoc = editor.getActivePageDoc();
    editor.show_glyphs = !editor.show_glyphs; // flip mode
    if (editor.show_glyphs)
    {
      editor.addGlyphs(pdoc.body);
    }
    else
    {
      editor.removeGlyphs(pdoc.body);
    }
    editor.updateToolbar();
    editor.focus();
  }
}
SpawPGcore.toggleBordersPushed = function(editor, tbi)
{
  if (editor.isInDesignMode())
  {
    return editor.show_glyphs;
  }
  else
  {
    return false;
  }
}

// code cleanup
SpawPGcore.codeCleanupClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    editor.cleanPageCode(null);
    editor.updateToolbar();
    editor.focus();
  }
}
