// Insert methods

// hyperlink
SpawPGcore.hyperlinkClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var a = editor.getSelectedElementByTagName("a");
    editor.stripAbsoluteUrl(a);
    SpawEngine.openDialog('core', 'hyperlink', editor, a, '', 'SpawPGcore.hyperlinkClickCallback', tbi, sender);
  }
}
SpawPGcore.hyperlinkClickCallback = function(editor, result, tbi, sender)
{
  if (result)
  {
    var newa = result;
    var pdoc = editor.getActivePageDoc();
    var a = editor.getSelectedElementByTagName("a");
    if (!a)
    {
      // new link
      var sel = editor.getNodeAtSelection();
      if (sel.nodeType == 1 && sel.tagName.toLowerCase() == 'span' ) // workaround for IE
      {
        newa.innerHTML = sel.innerHTML;
      }
      else
      {
        newa.appendChild(sel);
      }
      
      // if link is set on empty space use links title or url as link text
      if (SpawUtils.trim(newa.innerHTML) == '' && SpawUtils.trim(newa.href) != '' && newa.href != pdoc.location.href) // protect anchors from this action
      {
        if (newa.title)
          newa.innerHTML = newa.title;
        else
          newa.innerHTML = editor.getStrippedAbsoluteUrl(newa.href, false);
      }
      
      if (newa.href == pdoc.location.href)
        newa.removeAttribute("href");
      
      editor.insertNodeAtSelection(newa);
    }
  }
  editor.updateToolbar();
  editor.focus();
}

SpawPGcore.isHyperlinkEnabled = function(editor, tbi)
{
  if (editor.isInDesignMode())
  {
    return editor.getActivePageDoc().queryCommandEnabled("createlink"); 
  }
  else
  {
    return false;
  }
}


// image
SpawPGcore.imageClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    SpawEngine.openDialog('spawfm', 'spawfm', editor, '', 'type=images', 'SpawPGcore.imageClickCallback', null, null);  
  }
}
SpawPGcore.imageClickCallback = function(editor, result, tbi, sender)
{
  if (result)
  {
    var img = document.createElement("IMG");
    img.src = result;
    img.border = 0;
    img.alt = "";
    editor.insertNodeAtSelection(img);
  }
  editor.updateToolbar();
  editor.focus();
}

SpawPGcore.imagePropClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var i = editor.getSelectedElementByTagName("img");
    if (i)
    {
      // editing
      editor.stripAbsoluteUrl(i);
      SpawEngine.openDialog('core', 'image_prop', editor, i, '', '', tbi, sender);
    }
    else
    {
      // new image
      SpawEngine.openDialog('core', 'image_prop', editor, i, '', 'SpawPGcore.imagePropClickCallback', tbi, sender);
    }
  }
}
SpawPGcore.imagePropClickCallback = function(editor, result, tbi, sender)
{
  if (result)
  {
    editor.insertNodeAtSelection(result);
  }
  editor.updateToolbar();
  editor.focus();
}
SpawPGcore.flashPropClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var i = editor.getSelectedElementByTagName("img");
    if (i)
    {
      // editing
      editor.stripAbsoluteUrl(i);
      SpawEngine.openDialog('core', 'flash_prop', editor, i, '', '', tbi, sender);
    }
    else
    {
      // new flash
      SpawEngine.openDialog('core', 'flash_prop', editor, i, '', 'SpawPGcore.flashPropClickCallback', tbi, sender);
    }
  }
}
SpawPGcore.flashPropClickCallback = function(editor, result, tbi, sender)
{
  if (result)
  {
    editor.insertNodeAtSelection(result);
  }
  editor.updateToolbar();
  editor.focus();
}

// horizontal rule (hr)
SpawPGcore.insertHorizontalRuleClick = function(editor, tbi, sender)
{
  if (tbi.is_enabled)
  {
    var pdoc = editor.getActivePageDoc();
    var hr = pdoc.createElement("HR");
    editor.insertNodeAtSelection(hr);
  }
}
