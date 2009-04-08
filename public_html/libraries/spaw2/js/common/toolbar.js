// Toolbar item
function SpawTbItem(module, name, id)
{
  this.module = module;
  this.name = name;
  this.id = id;
  this.is_enabled = true;
}
// module (plugin)
SpawTbItem.prototype.module;
// command name
SpawTbItem.prototype.name;
// control id
SpawTbItem.prototype.id;
// belongs to editor
SpawTbItem.prototype.editor;
// belongs to toolbar
SpawTbItem.prototype.toolbar_name;
// is toolbar item enabled?
SpawTbItem.prototype.is_enabled;

// Toolbar image
function SpawTbImage(module, name, id)
{
  this.constructor(module, name, id);
}
SpawTbImage.prototype = new SpawTbItem;

// Toolbar button
function SpawTbButton(module, name, id, on_enabled_check, on_pushed_check, on_click, base_image_url, show_in_context_menu)
{
  this.constructor(module, name, id);
  this.on_enabled_check = on_enabled_check;
  this.on_pushed_check = on_pushed_check;
  this.on_click = on_click;  
  this.base_image_url = base_image_url;
  if (show_in_context_menu)
    this.show_in_context_menu = show_in_context_menu;
  else
    this.show_in_context_menu = false; 
}
SpawTbButton.prototype = new SpawTbItem;
SpawTbButton.prototype.on_enabled_check;
SpawTbButton.prototype.on_pushed_check;
SpawTbButton.prototype.on_click;
SpawTbButton.prototype.is_pushed = false;
SpawTbButton.prototype.show_in_context_menu = false;

// images
SpawTbButton.prototype.base_image_url;
SpawTbButton.prototype.image;
SpawTbButton.prototype.image_over;
SpawTbButton.prototype.image_down;
SpawTbButton.prototype.image_off;

// Toolbar dropdown
function SpawTbDropdown(module, name, id, on_enabled_check, on_status_check, on_change)
{
  this.constructor(module, name, id);
  this.on_enabled_check = on_enabled_check;
  this.on_status_check = on_status_check;
  this.on_change = on_change;  
}
SpawTbDropdown.prototype = new SpawTbItem;
SpawTbDropdown.prototype.on_enabled_check;
SpawTbDropdown.prototype.on_status_check;
SpawTbDropdown.prototype.on_change;
