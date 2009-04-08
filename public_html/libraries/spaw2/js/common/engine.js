// Spaw Engine related data and operations
function SpawEngine()
{
}

// spaw directory
SpawEngine.spaw_dir;
SpawEngine.setSpawDir = function(spaw_dir)
{
  SpawEngine.spaw_dir = spaw_dir;
}
SpawEngine.getSpawDir = function()
{
  return (SpawEngine.spaw_dir);
}

// platform (php/asp.net)
SpawEngine.platform;
SpawEngine.setPlatform = function(platform)
{
  SpawEngine.platform = platform;
}
SpawEngine.getPlatform = function()
{
  return (SpawEngine.platform);
}

SpawEngine.addBrowserEventHandler = function(obj, evt, func)
{
  if (document.attachEvent)
  {
    // ie
    obj.attachEvent("on"+evt, func);
  }
  else
  {
    obj.addEventListener(evt, func, false);
  }
}

// plugin registry
SpawEngine.plugins = new Array();
// registers plugin object or class
SpawEngine.registerPlugin = function(plugin_object)
{
  SpawEngine.plugins.push(plugin_object);
}
// returns plugin class or object
SpawEngine.getPlugin = function(name)
{
  for (var i=0; i<SpawEngine.plugins.length; i++)
  {
    if (SpawEngine.plugins[i].name == name)
      return SpawEngine.plugins[i];
  }
  return null;
}

// editor registry
SpawEngine.editors = new Array();
SpawEngine.registerEditor = function(editor)
{
  SpawEngine.editors.push(editor);
}
SpawEngine.isEditorRegistered = function(name)
{
  for (var i=0; i<SpawEngine.editors.length; i++)
  {
    if (SpawEngine.editors[i].name == name)
      return true;
  }
  return false;
}
SpawEngine.getEditor = function(name)
{
  for (var i=0; i<SpawEngine.editors.length; i++)
  {
    if (SpawEngine.editors[i].name == name)
      return SpawEngine.editors[i];
  }
  return null;
}
// returns true if all editors are initialized
SpawEngine.isInitialized = function()
{
  var result = true;
  for (var i=0; i<SpawEngine.editors.length; i++)
  {
    if (!SpawEngine.editors[i].isInitialized())
    {
      result = false;
      break;
    }
  }
  return result;
}
SpawEngine.updateFields = function()
{
  if (!document.forms[0].getAttribute("__spawsubmiting"))
  {
    for(var i=0; i<SpawEngine.editors.length; i++)
    {
      SpawEngine.editors[i].updateFields();
    }
  }
}
SpawEngine.onSubmit = function()
{
  // raise before submit event
  SpawEngine.handleEvent("spawbeforesubmit", null, null, null);
  SpawEngine.updateFields();
}

SpawEngine.active_editor;
SpawEngine.setActiveEditor = function(editor)
{
  if (SpawEngine.active_editor != editor)
  {
    SpawEngine.active_editor = editor;
    if (editor.floating_mode)
      editor.positionFloatingToolbar();
  }
}
SpawEngine.getActiveEditor = function()
{
  return SpawEngine.active_editor;
}

// global event listeners
SpawEngine.mouseMove = function(event)
{
  if (event == null && window.event != null)
  {
    // workaround for IE
    event = window.event;
    if (event.button != undefined && event.button != 1)
    {
      // if button was released outside window edges (works in IE only)
      if (SpawEngine.resizingEditor != null)
      {
        SpawEngine.resizingEditor.isResizing = false;
        //SpawEngine.resizingEditor.showPage(SpawEngine.resizingEditor.getActivePage());
        SpawEngine.resizingEditor.finalizeResizing();
        SpawEngine.resizingEditor = null;
      }
      if (SpawEngine.movingToolbar != null)
      {
        SpawEngine.movingToolbar.isMouseMoving = false;
        SpawEngine.movingToolbar = null;
      }
    }
  }
  if (SpawEngine.movingToolbar != null && SpawEngine.movingToolbar.isToolbarMoving)
  {
    document.getElementById(SpawEngine.movingToolbar.name + '_toolbox').style.left = SpawEngine.movingToolbar.currentToolbarX + event.clientX - SpawEngine.movingToolbar.lastMousePosX + "px";   
    document.getElementById(SpawEngine.movingToolbar.name + '_toolbox').style.top = SpawEngine.movingToolbar.currentToolbarY + event.clientY - SpawEngine.movingToolbar.lastMousePosY + "px";   
    SpawEngine.movingToolbar.currentToolbarX = document.getElementById(SpawEngine.movingToolbar.name + '_toolbox').offsetLeft;
    SpawEngine.movingToolbar.currentToolbarY = document.getElementById(SpawEngine.movingToolbar.name + '_toolbox').offsetTop;
    SpawEngine.movingToolbar.lastMousePosX = event.clientX;
    SpawEngine.movingToolbar.lastMousePosY = event.clientY;
    SpawEngine.getActiveEditor().saveFloatingToolbarPosition(SpawEngine.movingToolbar.currentToolbarX, SpawEngine.movingToolbar.currentToolbarY); 
  }
  if (SpawEngine.resizingEditor != null && SpawEngine.resizingEditor.isResizing)
  {
    if (SpawEngine.resizingEditor.isHorizontalResizingAllowed() && !event.ctrlKey) // vertical resizing only with ctrl pressed
    {
      var encwidth = document.getElementById(SpawEngine.resizingEditor.name + "_enclosure").offsetWidth;
      var w_delta = event.clientX - SpawEngine.resizingEditor.lastMousePosX;
      var resobj = SpawEngine.resizingEditor.getPageInput(SpawEngine.resizingEditor.getActivePage().name);
      if (!SpawEngine.resizingEditor.isInDesignMode()) // resize textarea
      {
        resobj.style.width = resobj.offsetWidth + w_delta + "px";
      }
      document.getElementById(SpawEngine.resizingEditor.name + "_enclosure").style.width = encwidth + w_delta + "px";
      if (!SpawEngine.resizingEditor.isInDesignMode() 
        && (document.getElementById(SpawEngine.resizingEditor.name + "_enclosure").offsetWidth - w_delta) > (encwidth)) // resize textarea
      {
        // fix resizing
        //resobj.style.width = resobj.offsetWidth - w_delta + (document.getElementById(SpawEngine.resizingEditor.name + "_enclosure").offsetWidth - encwidth) + "px";
      }
      SpawEngine.resizingEditor.lastMousePosX = event.clientX;
    }
    if (SpawEngine.resizingEditor.isVerticalResizingAllowed() && !event.shiftKey) // horizontal resizing only with shift pressed
    {
      //document.getElementById(SpawEngine.resizingEditor.name + "_enclosure").style.height = document.getElementById(SpawEngine.resizingEditor.name + "_enclosure").offsetHeight + event.clientY - SpawEngine.resizingEditor.lastMousePosY + "px";
      var resobj;
      if (SpawEngine.resizingEditor.isInDesignMode())
        resobj = SpawEngine.resizingEditor.getPageIframeObject(SpawEngine.resizingEditor.getActivePage().name);
      else
        resobj = SpawEngine.resizingEditor.getPageInput(SpawEngine.resizingEditor.getActivePage().name);
      resobj.style.height = resobj.offsetHeight + event.clientY - SpawEngine.resizingEditor.lastMousePosY + "px";
      document.getElementById(SpawEngine.resizingEditor.name+'_enclosure').style.height = resobj.style.height; 
      SpawEngine.resizingEditor.lastMousePosY = event.clientY;
    }
  }
}
SpawEngine.addBrowserEventHandler(document, "mousemove", SpawEngine.mouseMove);
SpawEngine.mouseUp = function(event)
{
  if (SpawEngine.resizingEditor != null)
  {
    SpawEngine.resizingEditor.isResizing = false;
    //SpawEngine.resizingEditor.showPage(SpawEngine.resizingEditor.getActivePage());
    SpawEngine.resizingEditor.finalizeResizing();
    SpawEngine.resizingEditor = null;
  }
  if (SpawEngine.movingToolbar != null)
  {
    SpawEngine.movingToolbar.isMouseMoving = false;
    SpawEngine.movingToolbar = null;
  }
}
SpawEngine.addBrowserEventHandler(document, "mouseup", SpawEngine.mouseUp);
SpawEngine.resizingEditor;
SpawEngine.movingToolbar;

// context menu
SpawEngine.active_context_menu;

// opens standard dialog
SpawEngine.openDialog = function(module, dialog, editor, arguments, querystring, callback, tbi, sender)
{
  var posX = screen.availWidth/2 - 275;
  var posY = screen.availHeight/2 - 250;
  var durl = SpawEngine.spaw_dir + 'dialogs/dialog.' + SpawEngine.platform + '?module=' + module + '&dialog=' + dialog 
    + '&theme=' + editor.theme.prefix + '&lang=' + editor.getLang() 
    + '&charset=' + editor.getOutputCharset() 
    + '&scid=' + editor.scid + "&" + querystring + editor.getRequestUriConfigValue();
  
  var args = new Object();
  args.editor = editor;
  args.arguments = arguments;
  args.callback = callback;
  args.tbi = tbi;
  args.sender = sender;
  var wnd = window.open(durl, module + '_' + dialog, 'status=no,resizable=yes,width=350,height=250,left='+posX+',top='+posY);
  window.dialogArguments = args;
  wnd.focus();   
  return wnd;
}

