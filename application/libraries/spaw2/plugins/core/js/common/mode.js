// mode switching functions
SpawPGcore.isDesignModeEnabled = function(editor, tbi)
{
  return (tbi.editor.getActivePage().editing_mode != "design");
}
SpawPGcore.isHtmlModeEnabled = function(editor, tbi)
{
  return (tbi.editor.getActivePage().editing_mode != "html");
}
SpawPGcore.designModeClick = function(editor, tbi, sender)
{
  var ap = tbi.editor.getActivePage();
  if (ap.editing_mode != "design")
  {
    // raise before mode switch event
    SpawEngine.handleEvent("spawbeforemodeswitch", null, "page_doc", tbi.editor.name);
    editor.updatePageDoc(ap)
    tbi.editor.enableEditingMode(ap.editing_mode_tbi);
    ap.editing_mode = "design";
    ap.editing_mode_tbi = tbi;
    tbi.editor.showPage(ap);
    // raise mode switch event
    SpawEngine.handleEvent("spawmodeswitch", null, "page_doc", tbi.editor.name);
    setTimeout(tbi.editor.name + '_obj.updateToolbar();', 10); // firefox crashes if called imediatly
    tbi.editor.disableEditingMode(ap.editing_mode_tbi);
    editor.addGlyphs(editor.getActivePageDoc().body);
  } 
}
SpawPGcore.htmlModeClick = function(editor, tbi, sender)
{
  var ap = tbi.editor.getActivePage();
  if (ap.editing_mode != "html")
  {
    // raise before mode switch event
    SpawEngine.handleEvent("spawbeforemodeswitch", null, "page_doc", tbi.editor.name);
    editor.updatePageInput(ap);
    tbi.editor.enableEditingMode(ap.editing_mode_tbi);
    ap.editing_mode = "html";
    ap.editing_mode_tbi = tbi;
    tbi.editor.showPage(ap);
    // raise mode switch event
    SpawEngine.handleEvent("spawmodeswitch", null, "page_doc", tbi.editor.name);
    setTimeout(tbi.editor.name + '_obj.updateToolbar();', 10); // firefox crashes if called imediatly
    tbi.editor.disableEditingMode(ap.editing_mode_tbi);
  } 
}
