// IE specific code

// initialize
SpawEditor.prototype.initialize = function()
{
  this.document = document;
  if (!this.document)
  {
    setTimeout(this.name+'_obj.initialize();',20);
    return;
  }

  var f_pif = this.getPageIframeObject(this.pages[0].name);

  for(var i=0; i<this.pages.length; i++)
  {
    // execute only once
    if (!this.pages[i].initialized)
    {
      var pta = this.getPageInput(this.pages[i].name);
      var pdoc = this.getPageDoc(this.pages[i].name);
      pta.style.width = f_pif.offsetWidth + 'px';
      
      if (pdoc.designMode != 'on' && eval(this.name+'_obj.enabled'))
      {
        pdoc.designMode = 'On';
      }
      // check if the editor completely loaded and schedule to try again if not
      try
      {
        if (pdoc.readyState != 'complete') // raises exception in some versions of IE6
        {
          setTimeout(this.name+'_obj.initialize();',20);
          return;
        }
      }
      catch(excp)
      {
        setTimeout(this.name+'_obj.initialize();',20);
        return;
      }
   
      // utf-8 charset
      var c_set = pdoc.createElement("meta");
      c_set.setAttribute("http-equiv","Content-Type");
      c_set.setAttribute("content","text/html; charset=utf-8");
      // stylesheet
      var s_sheet = pdoc.createElement("link");
      s_sheet.setAttribute("rel","stylesheet");
      s_sheet.setAttribute("type","text/css");
      s_sheet.setAttribute("href",this.stylesheet);
      var head = pdoc.getElementsByTagName("head");
      if (!head || head.length == 0)
      {
        head = pdoc.createElement("head");
        pdoc.childNodes[0].insertBefore(head, pdoc.body);
      }
      else
      {
        head = head[0];
      }
      head.appendChild(c_set);
      head.appendChild(s_sheet);

      // direction
      pdoc.body.dir = this.pages[i].direction;

      // mark page as initialized
      this.pages[i].initialized = true;
      SpawEngine.setActiveEditor(this);
      
      if (pdoc.readyState == 'complete')
      {    
        this.updatePageDoc(this.pages[i]);
      }

    }
  }
  // raise init event
  SpawEngine.handleEvent("spawinit", null, null, this.name);

  if (SpawEngine.isInitialized())
  {
    // add event handlers
    // context menu
    SpawEngine.addEventHandler("contextmenu",'SpawEditor.rightClick');
    SpawEngine.addEventHandler("keypress",'SpawEditor.hideContextMenu');
    SpawEngine.addEventHandler("click",'SpawEditor.hideContextMenu');
    SpawEngine.addEventHandler("click",'SpawEditor.hideContextMenu', "document");
    
    // context
    SpawEngine.addEventHandler("keyup",'SpawEditor.checkContext');
    SpawEngine.addEventHandler("mouseup",'SpawEditor.checkContext');
  
    // form submit
    SpawEngine.addEventHandler("submit",'SpawEngine.onSubmit', "form");

    // raise allinit event
    SpawEngine.handleEvent("spawallinit", null, null, null);
  }
  var frm = this.getPageInput(this.pages[0].name).form; 
  if (!frm.formSubmit)
  {
    frm.formSubmit = frm.submit;
    frm.submit = new Function(this.name+'_obj.spawSubmit();');
  }

  // commented because it's stealing focus in form
  //this.updateToolbar();
}

// returns reference to editors page iframe
SpawEditor.prototype.getPageIframe = function(page_name)
{
  return this.document.frames(page_name + '_rEdit');
}

// returns reference to content document of editors page
SpawEditor.prototype.getPageDoc = function(page_name)
{
  if (this.getPageIframe(page_name))
    return this.getPageIframe(page_name).document;
}

// insert node at selection
SpawEditor.prototype.insertNodeAtSelection = function(newNode)
{
  this.focus();
  var pdoc = this.getPageDoc(this.getActivePage().name);
  var sel = pdoc.selection.createRange();
  var val;
  if (newNode.nodeType == 3) // text node
  {
    val = newNode.nodeValue;
  }
  else
  {
    val = newNode.outerHTML;
  }
 
  if (pdoc.selection.type == "Control")
  {
    sel(0).outerHTML = val;
  }
  else // text node
  {
    sel.pasteHTML(val);
  } 

  this.addGlyphs(pdoc.body);
}

// returns currently selected node
SpawEditor.prototype.getNodeAtSelection = function()
{
  this.focus();
  var result = null;
  
  var pdoc = this.getPageDoc(this.getActivePage().name);
  var sel = pdoc.selection.createRange();
  
  if (pdoc.selection.type == "Control")
  {
    result = sel(0);
  }
  else // text node
  {
    // IE can't use document fragment as normal node 
    // so we have to create a fake span surrouning selection
    result = pdoc.createElement("SPAN");
    result.innerHTML = sel.htmlText;
  } 

  return result;
}

// returns selection's parent element (closest current element)
SpawEditor.prototype.getSelectionParent = function()
{
  this.focus();
  var result = null;
  
  var pdoc = this.getPageDoc(this.getActivePage().name);
  var sel = pdoc.selection.createRange();
  
  if (pdoc.selection.type == "Control")
  {
    result = sel(0);
  }
  else // text node
  {
    result = sel.parentElement();
  } 

  return result;
}

// borders on borderless objects
SpawEditor.prototype.addGlyphs = function(root)
{
  if (this.show_glyphs)
  {
    if (root.nodeType == 1) // element
    {
      if (root.tagName.toLowerCase() == 'table'
          && (!root.border || root.border == "0" || root.border == "")
          && (!root.style.borderWidth || root.style.borderWidth == "0" || root.style.borderWidth == "")
         )
      {
        root.runtimeStyle.borderWidth = "1px";
        root.runtimeStyle.borderStyle = "dashed";
        root.runtimeStyle.borderColor = "#aaaaaa";
        var cls = root.getElementsByTagName("td");
        for (var i=0; i<cls.length; i++)
        {
          cls[i].runtimeStyle.borderWidth = "1px";
          cls[i].runtimeStyle.borderStyle = "dashed";
          cls[i].runtimeStyle.borderColor = "#aaaaaa";
        }
        cls = root.getElementsByTagName("th");
        for (var i=0; i<cls.length; i++)
        {
          cls[i].runtimeStyle.borderWidth = "1px";
          cls[i].runtimeStyle.borderStyle = "dashed";
          cls[i].runtimeStyle.borderColor = "#aaaaaa";
        }
      }  
    }
    if (root.hasChildNodes())
    {
      var tbls = root.getElementsByTagName("table");
      for(var i=0; i<tbls.length; i++)
        this.addGlyphs(tbls[i]);
    }
  }
}
SpawEditor.prototype.removeGlyphs = function(root)
{
  if (root.nodeType == 1) // element
  {
    root.runtimeStyle.borderWidth = "";
    root.runtimeStyle.borderStyle = "";
    root.runtimeStyle.borderColor = "";
  }
  if (root.hasChildNodes())
  {
    for(var i=0; i<root.childNodes.length; i++)
      this.removeGlyphs(root.childNodes[i]);
  }
}
SpawEditor.prototype.selectionWalk = function(func)
{
  this.focus();
  
  var pdoc = this.getPageDoc(this.getActivePage().name);
  var sel = pdoc.selection.createRange();

  if (pdoc.selection.type.toLowerCase() != "control")
  {
    // text range
    // insert fake start and end markers
    var start_rng = sel.duplicate();
    start_rng.collapse();
    start_rng.pasteHTML('<span id="_spaw_start_container"></span>');
    var end_rng = sel.duplicate();
    end_rng.collapse(false);
    end_rng.pasteHTML('<span id="_spaw_end_container"></span>');
    
    this._in_selection = false;
    this.selectionNodeWalk(sel.parentElement(), null, func);
    
    // remove fake start and end markers
    pdoc.getElementById("_spaw_start_container").parentNode.removeChild(pdoc.getElementById("_spaw_start_container"));
    pdoc.getElementById("_spaw_end_container").parentNode.removeChild(pdoc.getElementById("_spaw_end_container"));
  }
  else
  {
    // control range
    this._in_selection = true;
    this.selectionNodeWalk(sel(0), null, func);
  }
}
SpawEditor.prototype._in_selection;
SpawEditor.prototype.selectionNodeWalk = function(node, rng, func)
{
    if (this._in_selection || (node.nodeType == 1 && (node.id == '_spaw_start_container' || node.id == '_spaw_end_container')))
    {
      if (node.nodeType != 1 || (node.id != '_spaw_start_container' && node.id != '_spaw_end_container'))
        func(node, null, null);
      if (node.nodeType == 1 && node.id == '_spaw_end_container')
        this._in_selection = false;
      else
        this._in_selection = true; 
    }
    if (node.childNodes && node.childNodes.length>0)
    {
      for (var i=0; i<node.childNodes.length; i++)
      {
        var cnode = node.childNodes[i];
        this.selectionNodeWalk(cnode, rng, func);
      }
    }
}
SpawEditor.prototype.insertHtmlAtSelection = function(source)
{
  var pdoc = this.getPageDoc(this.getActivePage().name);
  var sel = pdoc.selection.createRange();
  try
  {
    if (pdoc.selection.type == "Control") // control node
    {
      sel(0).outerHTML = source;
      this.focus();
    }
    else
    {
      sel.pasteHTML(source);
    }
  }
  catch(excp)
  {
    sel.collapse();
    try
    {
      sel.pasteHTML(source);
    }
    catch(excp)
    {
      // everything failed so do nothing
    }
  }
}

// applies style setting or css class to selection
SpawEditor.prototype.applyStyleToSelection = function(cssClass, styleName, styleValue)
{
  this.focus();

  var sel = this.getNodeAtSelection(); // for IE this always returns span for non-objects
  var pnode = this.getSelectionParent();
  if (sel)
  {
    if (sel.innerHTML.length>0 && sel.innerHTML != pnode.outerHTML) // setting class on a new snippet
    {
      if (cssClass != '')
        sel.className = cssClass;
      if (styleName != '')
        sel.style.setAttribute(styleName, styleValue, 0);
      this.insertNodeAtSelection(sel);
    }
    else if (sel.innerHTML.length == 0) // empty selection, set class on the parent
    {
      if (pnode && pnode.tagName.toLowerCase() != "body")
      {
        if (cssClass != '')
          pnode.className = cssClass;
        if (styleName != '')
          pnode.style.setAttribute(styleName, styleValue, 0);
      }
      else // parent is body
      {
        sel.innerHTML = pnode.innerHTML;

        if (cssClass != '')
          sel.className = cssClass;
        if (styleName != '')
          sel.style.setAttribute(styleName, styleValue, 0);

        pnode.innerHTML = sel.outerHTML;
      }
    }
    else // changing class on an element
    {
      if (cssClass != '')
        pnode.className = cssClass;
      if (styleName != '')
        pnode.style.setAttribute(styleName, styleValue, 0);
    }
  }
}

// removes style from selection
SpawEditor.prototype.removeStyleFromSelection = function(cssClass, styleName)
{
  this.focus();
  
  var pnode = this.getSelectionParent();
  
  if (cssClass)
  {
    while(pnode && pnode.tagName.toLowerCase() != "body" && (!pnode.className || pnode.className == ""))
    {
      pnode = pnode.parentNode;
    }
      
    if (pnode && pnode.tagName.toLowerCase() != "body")
    {
      pnode.removeAttribute("class");
      pnode.removeAttribute("className");
    }
  }
  
  if (styleName)
  {
    while(pnode && pnode.tagName.toLowerCase() != "body" && !pnode.style.getAttribute(styleName))
    {
      pnode = pnode.parentNode;
    }
      
    if (pnode && pnode.tagName.toLowerCase() != "body")
    {
      pnode.style.removeAttribute(styleName);
    }
  }
}
