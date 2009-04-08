// Page class
function SpawEditorPage(name, caption, direction)
{
  this.name = name;
  this.caption = caption;
  if (direction != null)
    this.direction = direction;
  else
    this.direction = "ltr";
}
SpawEditorPage.prototype.name;
SpawEditorPage.prototype.caption;
SpawEditorPage.prototype.direction;
SpawEditorPage.prototype.value;
SpawEditorPage.prototype.is_initialized = false;
SpawEditorPage.prototype.document;
// editing mode (design or html)
SpawEditorPage.prototype.editing_mode = "design";
// current editing mode toolbar item
SpawEditorPage.prototype.editing_mode_tbi;
