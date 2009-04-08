// Context menu
function SpawContextMenu(editor)
{
  this.editor = editor;
}
SpawContextMenu.prototype.editor;
SpawContextMenu.prototype.enclosure;
SpawContextMenu.prototype.show = function(event)
{
  var last_tbn = '';
  this.enclosure = document.createElement("div");
  this.enclosure.className = this.editor.theme.prefix+'contextmenu';
  this.enclosure.style.position = "absolute";  
  this.enclosure.style.left = this.editor.getPageOffsetLeft() + event.clientX + "px";  
  this.enclosure.style.top = this.editor.getPageOffsetTop() + event.clientY + "px"; 
  this.enclosure.style.zIndex = 15000; 
  
  // add items
  var ed = this.editor.controlled_by;
  for(var i=0; i<ed.toolbar_items.length; i++)
  {
    if (ed.toolbar_items[i].on_enabled_check && ed.toolbar_items[i].on_enabled_check != '')
    {
      // check if item is button and if it wants to be included in context menu
      if (ed.toolbar_items[i].on_click && ed.toolbar_items[i].show_in_context_menu)
      {
        // check if item is enabled
        if(eval("SpawPG"+ed.toolbar_items[i].module 
                + '.' + ed.toolbar_items[i].on_enabled_check + '(this.editor, ed.toolbar_items[i])'))
        {
          if (last_tbn != '' && ed.toolbar_items[i].toolbar_name != last_tbn)
          {
            // insert separator
            var sep = document.createElement("div");
            sep.className = this.editor.theme.prefix + 'contextmenuseparator';
            this.enclosure.appendChild(sep);             
          } 
          last_tbn = ed.toolbar_items[i].toolbar_name;
          var mitem = document.createElement("div");
          var checkmark = document.createElement("img");
          checkmark.src = SpawEngine.getSpawDir() + 'plugins/core/lib/theme/'+this.editor.theme.prefix+'/img/checkmark.gif';
          checkmark.style.visibility = 'hidden';
          checkmark.className = this.editor.theme.prefix + 'checkmark';
          if (ed.toolbar_items[i].on_pushed_check && ed.toolbar_items[i].on_pushed_check != '')
          {
            if(eval("SpawPG"+ed.toolbar_items[i].module 
                    + '.' + ed.toolbar_items[i].on_pushed_check + '(this.editor, ed.toolbar_items[i])'))
            {
              checkmark.style.visibility = 'visible';
            }
          }          
          mitem.appendChild(checkmark);
          
          mitem.appendChild(document.createTextNode(document.getElementById(ed.toolbar_items[i].id).title));
          mitem.style.cursor = "default";
          mitem.style.whiteSpace = "nowrap";
          mitem.setAttribute("unselectable","on");
          mitem.className = this.editor.theme.prefix + "contextmenuitem";
          mitem.onmouseover = new Function("this.className = '" + this.editor.theme.prefix + "contextmenuitemover'");
          mitem.onmouseout = new Function("this.className = '" + this.editor.theme.prefix + "contextmenuitem'");
          if (mitem.attachEvent)
          {
            // IE
            mitem.attachEvent("onclick", 
              new Function("SpawEngine.active_context_menu.hide(); SpawEngine.active_context_menu = null;"
                + "SpawPG"+ed.toolbar_items[i].module + '.' + ed.toolbar_items[i].on_click + '(' + this.editor.name + '_obj, ' + ed.name + '_obj.toolbar_items[' + i + '], null)'));
            //alert(mitem.outerHTML);
          }
          else if (mitem.addEventListener)
          {
            // Gecko
            mitem.addEventListener("click", 
              new Function("SpawEngine.active_context_menu.hide(); SpawEngine.active_context_menu = null;"
                + "SpawPG"+ed.toolbar_items[i].module + '.' + ed.toolbar_items[i].on_click + '(' + this.editor.name + '_obj, ' + ed.name + '_obj.toolbar_items[' + i + '], null)'), false);
          }
          //alert(mitem.onclick);
          this.enclosure.appendChild(mitem);             
        }
      }
    }
  }  
  
  if (this.enclosure.innerHTML != '')
  {
    document.body.appendChild(this.enclosure);
    return true;
  }
  else
  {
    return false;
  }
}
SpawContextMenu.prototype.hide = function()
{
  if (this.enclosure != null)
  {
    document.body.removeChild(this.enclosure);
  }
}
