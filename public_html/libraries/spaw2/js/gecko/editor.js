// Gecko specific code

// initialize
SpawEditor.prototype.initialize = function()
{
  this.document = document;
  if (!this.document)
  {
    setTimeout(this.name+'_obj.initialize();',50);
    return;
  }

  for(var i=0; i<this.pages.length; i++)
  {
    if (i>0)
    {
      this.hidePage(this.pages[i-1]);
      this.showPage(this.pages[i]);
    }

    // execute only once
    if (!this.pages[i].initialized)
    {
      var pta = this.getPageInput(this.pages[i].name);
      var pdoc = this.getPageDoc(this.pages[i].name);
      
      try
      {
        if(pdoc.designMode != 'on' && eval(this.name+'_obj.enabled'))
        {
          pdoc.designMode = 'on';
          pdoc.designMode = 'off';
          pdoc.designMode = 'on';
        }
      }
      catch(e)
      {
  	    //setTimeout(new Function('try{'+this.name+'_obj.getPageDoc('+this.name+'_obj.pages['+i+'].name).designMode = "on";}catch(e){}'), 20);
        setTimeout(this.name+'_obj.initialize();',50);
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
      if (window.location.href.toLowerCase().indexOf("https") == 0 && this.stylesheet.indexOf("/") == 0)
      {
        // workaround for HTTPS mode
        this.stylesheet = window.location.href.substring(0, window.location.href.indexOf("/", 9)) + this.stylesheet;
      }
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

      if (pta.value != null && pta.value != "\n" && pta.value != '') //cursor isn't visible in Gecko if one of these is assigned
        this.updatePageDoc(this.pages[i]);
    }

    if (this.pages.length>1)
      this.hidePage(this.pages[i]);
    else if (window.location.href.toLowerCase().indexOf("https") == 0)
    {
      // workaround for HTTPS mode
      this.pages[0].editing_mode = "html";
      this.showPage(this.pages[0]);
      this.pages[0].editing_mode = "design";
      this.showPage(this.pages[0]);
    }

  }
  if (this.pages.length>1)
    this.showPage(this.pages[0]);
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
  setTimeout(this.name + '_obj.updateToolbar();', 10); // firefox crashes if called imediatly
}

// returns reference to editors page iframe same as getPageIframeObject under Gecko
SpawEditor.prototype.getPageIframe = function(page_name)
{
  return this.getPageIframeObject(page_name);
}

// returns reference to content document of editors page
SpawEditor.prototype.getPageDoc = function(page_name)
{
  if (this.getPageIframe(page_name))
    return this.getPageIframe(page_name).contentDocument;
}

// insert node at selection
SpawEditor.prototype.insertNodeAtSelection = function(newNode)
{
  var pif = this.getPageIframe(this.getActivePage().name);
  var pdoc = this.getPageDoc(this.getActivePage().name);
  
  var sel = pif.contentWindow.getSelection();
  var rng = sel.getRangeAt(0);
  rng.deleteContents();

  var container = rng.startContainer;
  var startpos = rng.startOffset;

  rng = pdoc.createRange();
  switch(container.nodeType)
  {
    case 3: // text node
      var txt = container.nodeValue;
      var afterTxt = txt.substring(startpos);
      container.nodeValue = txt.substring(0, startpos);
      if (container.nextSibling == null)
      {
        container.parentNode.appendChild(newNode);
        container.parentNode.appendChild(pdoc.createTextNode(afterTxt));
      }
      else
      {
        var afterNode = pdoc.createTextNode(afterTxt);
        container.parentNode.insertBefore(afterNode, container.nextSibling);
        container.parentNode.insertBefore(newNode, afterNode);
      }
      rng.setStart(container.parentNode.childNodes[1], 0);
      rng.setEnd(container.parentNode.childNodes[2], 0);
      break;
    default: // element node
      container.insertBefore(newNode, container.childNodes[startpos]);
      rng.setEnd(container.childNodes[startpos], 0);
      rng.setStart(container.childNodes[startpos], 0);
      break;
  }
  
  sel.removeAllRanges();
 // sel.addRange(rng);
 
  this.addGlyphs(pdoc.body);
}

// returns currently selected node
SpawEditor.prototype.getNodeAtSelection = function()
{
  var pif = this.getPageIframe(this.getActivePage().name);
  
  var sel = pif.contentWindow.getSelection();
  if (sel && sel.rangeCount>0)
  {
    var rng = sel.getRangeAt(0);

    return rng.cloneContents();
  }
  else
  {
    return null;
  }
}

// returns selection's parent element (closest current element)
SpawEditor.prototype.getSelectionParent = function()
{
  var result;

  var pif = this.getPageIframe(this.getActivePage().name);
  var pdoc = this.getActivePageDoc();
  
  var sel = pif.contentWindow.getSelection();
  if (sel && sel.rangeCount>0)
  {
    var rng = sel.getRangeAt(0);
  
    var container = rng.commonAncestorContainer;
    result = container;
    
    if (container.nodeType == 3) // text node
    {
      result = container.parentNode;
    }
    else if (rng.startContainer.nodeType == 1 && rng.startContainer == rng.endContainer && (rng.endOffset-rng.startOffset)<=1)
    {
      // single object selected
      result = rng.startContainer.childNodes[rng.startOffset];
    }
  }
  else
  {
    result = pdoc.body;
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
          && (!root.getAttribute("__spawglyphed")) 
         )
      {
        root.style.border = "1px dashed #aaaaaa";
        root.setAttribute("__spawglyphed", true);
        var cls = root.getElementsByTagName("td");
        for (var i=0; i<cls.length; i++)
        {
          cls[i].style.border = "1px dashed #aaaaaa";
          cls[i].setAttribute("__spawglyphed", true);
        }
        cls = root.getElementsByTagName("th");
        for (var i=0; i<cls.length; i++)
        {
          cls[i].style.border = "1px dashed #aaaaaa";
          cls[i].setAttribute("__spawglyphed", true);
        }
      }  
    }
    if (root.hasChildNodes())
    {
      for(var i=0; i<root.childNodes.length; i++)
        this.addGlyphs(root.childNodes[i]);
    }
  }
}
SpawEditor.prototype.removeGlyphs = function(root)
{
  if (root.nodeType == 1 && root.getAttribute("__spawglyphed")) // element
  {
    root.style.border = "";
    root.removeAttribute("__spawglyphed");
  }
  if (root.hasChildNodes())
  {
    for(var i=0; i<root.childNodes.length; i++)
      this.removeGlyphs(root.childNodes[i]);
  }
}
SpawEditor.prototype.selectionWalk = function(func)
{
  var pif = this.getPageIframe(this.getActivePage().name);
  
  var sel = pif.contentWindow.getSelection();
  if (sel && sel.rangeCount>0)
  {
    var rng = sel.getRangeAt(0);
    var ancestor = rng.commonAncestorContainer;

    this.selectionNodeWalk(ancestor, rng, func);
  }
}
SpawEditor.prototype.selectionNodeWalk = function(node, rng, func)
{
    if (rng.isPointInRange(node, 0) || rng.startContainer == node || rng.endContainer == node)
    {
      func(node, (rng.startContainer == node)?rng.startOffset:null, (rng.endContainer == node)?rng.endOffset:null);
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
  var elm = pdoc.createElement("span");
  var frag = pdoc.createDocumentFragment();
  elm.innerHTML = source;
  while(elm.hasChildNodes())
    frag.appendChild(elm.childNodes[0]);
  this.insertNodeAtSelection(frag);
}

// applies style setting or css class to selection
SpawEditor.prototype.applyStyleToSelection = function(cssClass, styleName, styleValue)
{
  var sel = this.getNodeAtSelection();
  var pnode = this.getSelectionParent();
  if (sel)
  {
    if (sel.nodeType == 1) // element
    {
      if (cssClass != '')
        sel.className = cssClass;
      if (styleName != '')
        sel.style[styleName] = styleValue;
      this.insertNodeAtSelection(sel);
    }
    else
    {
      var pdoc = this.getActivePageDoc();
      var spn = pdoc.createElement("SPAN");
      if (cssClass != '')
        spn.className = cssClass;
      if (styleName != '')
        spn.style[styleName] = styleValue;
      spn.appendChild(sel);
      if (spn.innerHTML.length > 0) // something selected
      {
        if (spn.innerHTML != pnode.innerHTML || pnode.tagName.toLowerCase() == "body") // this is a new snippet, set class on it
          this.insertNodeAtSelection(spn);
        else // change class
        {
          if (cssClass != '')
            pnode.className = cssClass;
          if (styleName != '')
            pnode.style[styleName] = styleValue;
        }        
      }
      else // nothing is select, set class on the parent
      {
        if (pnode.tagName.toLowerCase() != "body") // there's a parent, set class on it
        {
          if (cssClass != '')
            pnode.className = cssClass;
          if (styleName != '')
            pnode.style[styleName] = styleValue;
        }
        else
        {
          spn.innerHTML = pnode.innerHTML;
          pnode.innerHTML = '';
          pnode.appendChild(spn);
        }        
      }
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
    while(pnode && pnode.tagName.toLowerCase() != "body" && !pnode.style[styleName])
    {
      pnode = pnode.parentNode;
    }
      
    if (pnode && pnode.tagName.toLowerCase() != "body")
    {
      pnode.style[styleName] = '';
    }
  }
}
