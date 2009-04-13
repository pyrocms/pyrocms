// Editor class
function SpawEditor(name)
{
  this.name = name;
  this.toolbar_items = new Array();
  this.pages = new Array();
  this.tabs = new Array();
  this.controlled_editors = new Array();
  //this.event_handlers = new Array();
  this.config = new Array();
}

SpawEditor.prototype.name;

// secure config id
SpawEditor.prototype.scid;

// stylesheet
SpawEditor.prototype.stylesheet;

// config
SpawEditor.prototype.config;
SpawEditor.prototype.getConfigValue = function(name)
{
  return this.config[name];
}
SpawEditor.prototype.setConfigValue = function(name, value)
{
  this.config[name] = value;
}
SpawEditor.prototype.getRequestUriConfigValue = function()
{
  return this.getConfigValue("__request_uri");
}
// returns true if all pages are initialized
SpawEditor.prototype.isInitialized = function()
{
  var result = true;
  for (var i=0; i<this.pages.length; i++)
  {
    if (!this.pages[i].initialized)
    {
      result = false;
      break;
    }
  }
  return result;
}

// toolbars
SpawEditor.prototype.toolbar_items;
SpawEditor.prototype.addToolbarItem = function(tbi, toolbar_name)
{
  if (tbi.base_image_url)
    this.theme.preloadImages(tbi);
  tbi.editor = this;
  tbi.toolbar_name = toolbar_name;
  this.toolbar_items.push(tbi);
}
SpawEditor.prototype.getToolbarItem = function(id)
{
  for (var i=0; i<this.toolbar_items.length; i++)
  {
    if (this.toolbar_items[i].id == id)
    {
      return this.toolbar_items[i];
    }
  }
  return null;
}

// enable editing mode button
SpawEditor.prototype.enableEditingMode = function(tbi)
{
  if (tbi && tbi.editor.getActivePage().editing_mode_tbi && tbi.editor.getActivePage().editing_mode_tbi != null)
  {
    var mbt = this.document.getElementById(tbi.editor.getActivePage().editing_mode_tbi.id);
    mbt.disabled = false;
    tbi.editor.theme.buttonOut(tbi.editor.getActivePage().editing_mode_tbi, mbt);
  }
}
// disable editing mode button
SpawEditor.prototype.disableEditingMode = function(tbi)
{
  if (tbi && tbi.editor.getActivePage().editing_mode_tbi && tbi.editor.getActivePage().editing_mode_tbi != null)
  {
    var mbt = this.document.getElementById(tbi.editor.getActivePage().editing_mode_tbi.id);
    mbt.disabled = true;
    tbi.editor.theme.buttonOff(tbi.editor.getActivePage().editing_mode_tbi, mbt);
  }
}


// pages
SpawEditor.prototype.pages;
SpawEditor.prototype.addPage = function(page)
{
  this.pages.push(page);
  this.addTab(page);
}
SpawEditor.prototype.getPage = function(id)
{
  for(var i=0; i<this.pages.length; i++)
  {
    if (this.pages[i].name == id)
      return this.pages[i];
  }
  return null;
}
SpawEditor.prototype.active_page;
SpawEditor.prototype.setActivePage = function(id)
{
  if (this.active_page && (this.active_page.name != id || SpawEngine.active_editor != this))
  {
    // raise before page switch event
    SpawEngine.handleEvent("spawbeforepageswitch", null, null, this.name);
  
    this.getTab(this.active_page.name).setInactive(); 
    this.hidePage(this.active_page);
    this.enableEditingMode(this.active_page.editing_mode_tbi);
    this.active_page = this.getPage(id);
    this.getTab(this.active_page.name).setActive();
    this.showPage(this.active_page);
    this.disableEditingMode(this.active_page.editing_mode_tbi);
    SpawEngine.setActiveEditor(this);

    // raise page switch event
    SpawEngine.handleEvent("spawpageswitch", null, null, this.name);

    setTimeout(this.name + '_obj.updateToolbar();', 10); // firefox crashes if called imediatly
  }
}
SpawEditor.prototype.getActivePage = function()
{
  return this.active_page;
}

// parent object of the editing area
SpawEditor.prototype.pageOffsetParent;
SpawEditor.prototype.currentTextAreaWidth = '100%';
SpawEditor.prototype.hidePage = function(page)
{
  var pta = this.getPageInput(page.name);
  var pif = this.getPageIframeObject(page.name);

  // workaround for zero width textarea
  if (page.editing_mode == 'design')
    this.currentTextAreaWidth = pif.offsetWidth + 'px';
  else
    this.currentTextAreaWidth = pta.offsetWidth + 'px';

  pta.style.display = 'none';
  pif.style.display = 'none';
}
SpawEditor.prototype.showPage = function(page)
{
  var pta = this.getPageInput(page.name);
  var pif = this.getPageIframeObject(page.name);
  var pdoc = this.getPageDoc(page.name);
  if (page.editing_mode == 'design')
  {
    pta.style.display = 'none';
    pif.style.display = 'inline';
    if (this.Enabled)
        pdoc.designMode = 'on'; // mozilla (and probably early firefox versions) looses this when the page is hidden
  }
  else
  {
    pta.style.width = this.currentTextAreaWidth;
    pta.style.display = 'inline';
    pif.style.display = 'none';
  }
  this.focus();
}


// tabs
SpawEditor.prototype.tabs;
SpawEditor.prototype.addTab = function(page)
{
  this.tabs.push(new SpawTab(page));
}
SpawEditor.prototype.getTab = function(page_name)
{
  for (var i=0; i<this.tabs.length; i++)
  {
    if (this.tabs[i].page.name == page_name)
      return this.tabs[i];
  }
  return null;
}

SpawEditor.prototype.floating_mode = false;
// controlled editors (for floating mode master)
SpawEditor.prototype.controlled_editors;
SpawEditor.prototype.addControlledEditor = function(editor)
{
  this.controlled_editors.push(editor);
}
SpawEditor.prototype.isControlledEditor = function(name)
{
  for (var i=0; i<this.controlled_editors.length; i++)
  {
    if (this.controlled_editors[i].name == name)
      return true;
  }
  return false;
}

// controlled by (for floating mode slave)
SpawEditor.prototype.controlled_by;

// returns currently active editor (might need more complex logic later)
SpawEditor.prototype.getCurrentEditor = function()
{
  return SpawEngine.getActiveEditor();
}

// returns which editor is currently controlled by this editors toolbar
SpawEditor.prototype.getTargetEditor = function()
{
  if (this.controlled_by == this && this.controlled_editors.length <= 1)
    return this;
  else
    return SpawEngine.getActiveEditor();
}

// theme
SpawEditor.prototype.theme;
SpawEditor.prototype.setTheme = function(theme)
{
  this.theme = theme;
}
SpawEditor.prototype.getTheme = function()
{
  return this.theme;
}

// language
SpawEditor.prototype.lang;
SpawEditor.prototype.setLang = function(lang)
{
  this.lang = lang;
}
SpawEditor.prototype.getLang = function()
{
  return this.lang;
}
SpawEditor.prototype.output_charset;
SpawEditor.prototype.setOutputCharset = function(output_charset)
{
  this.output_charset = output_charset;
}
SpawEditor.prototype.getOutputCharset = function()
{
  return this.output_charset;
}

// hooks up to window onload event and calls initialization
SpawEditor.prototype.onLoadHookup = function()
{
  var spaw_tmpstr="";
  if (window.onload != null) 
  {
    spaw_tmpstr = window.onload.toString();
    var spaw_i = spaw_tmpstr.indexOf("{") + 2;
    spaw_tmpstr = spaw_tmpstr.substr(spaw_i,spaw_tmpstr.length-spaw_i-2);
  }
  window.onload = new Function(this.name+'_obj.initialize();'+spaw_tmpstr);   
}

// returns reference to page textarea
SpawEditor.prototype.getPageInput = function(page_name)
{
  return this.document.getElementById(page_name);
}

// returns reference to outer iframe object (differs from getPageIfram in IE only)
SpawEditor.prototype.getPageIframeObject = function(page_name)
{
  return this.document.getElementById(page_name+'_rEdit');
}

// returns reference to active page's doc
SpawEditor.prototype.getActivePageDoc = function()
{
  return this.getPageDoc(this.active_page.name);
}

// floating toolbar control
SpawEditor.prototype.currentToolbarX;
SpawEditor.prototype.currentToolbarY;
SpawEditor.prototype.lastMousePosX;
SpawEditor.prototype.lastMousePosY;
SpawEditor.prototype.isToolbarMoving = false;
SpawEditor.prototype.floatingMouseDown = function(event)
{
  this.currentToolbarX = this.document.getElementById(this.name + '_toolbox').offsetLeft;
  this.currentToolbarY = this.document.getElementById(this.name + '_toolbox').offsetTop;
  this.lastMousePosX = event.clientX;
  this.lastMousePosY = event.clientY;
  this.isToolbarMoving = true;
  SpawEngine.movingToolbar = this;
}


// floating toolbar position relative to this instance
SpawEditor.prototype.floatingToolbarX = 100;
SpawEditor.prototype.floatingToolbarY = 10;
SpawEditor.prototype.positionFloatingToolbar = function()
{
  this.document.getElementById(this.controlled_by.name + '_toolbox').style.left = this.getPageOffsetLeft() + this.floatingToolbarX + "px";   
  this.document.getElementById(this.controlled_by.name + '_toolbox').style.top = this.getPageOffsetTop() + this.floatingToolbarY + "px";   
}
SpawEditor.prototype.saveFloatingToolbarPosition = function(x, y)
{
  this.floatingToolbarX = x - this.getPageOffsetLeft();
  this.floatingToolbarY = y - this.getPageOffsetTop();
}


// page offsets
SpawEditor.prototype.getPageOffsetLeft = function()
{
  var elm = this.getPageIframeObject(this.active_page?this.active_page.name:this.name);
  var res = elm.offsetLeft;
  
  while ((elm = elm.offsetParent) != null)
  {
    res += elm.offsetLeft;
  }
  return res;
}

SpawEditor.prototype.getPageOffsetTop = function()
{
  var elm = this.getPageIframeObject(this.active_page?this.active_page.name:this.name);
  var res = elm.offsetTop;
  
  while ((elm = elm.offsetParent) != null)
  {
    res += elm.offsetTop;
  }
  return res;
}

// resizing control
SpawEditor.prototype.isResizing = false;
SpawEditor.prototype.isVerticalResizingAllowed = function()
{
  var res = this.getConfigValue("resizing_directions");
  res = res?res.toLowerCase():res;
  if (res == 'vertical' || res == 'both')
    return true;
  else
    return false;
}
SpawEditor.prototype.isHorizontalResizingAllowed = function()
{
  var res = this.getConfigValue("resizing_directions");
  res = res?res.toLowerCase():res;
  if (res == 'horizontal' || res == 'both')
    return true;
  else
    return false;
}
SpawEditor.prototype.resizingGripMouseDown = function(event)
{
  this.lastMousePosX = event.clientX;
  this.lastMousePosY = event.clientY;
  this.isResizing = true;
  SpawEngine.resizingEditor = this;

  //SpawEngine.resizingEditor.hidePage(SpawEngine.resizingEditor.getActivePage());
  // prevent gecko from dragging image
  if (event.preventDefault)
    event.preventDefault();
}
SpawEditor.prototype.finalizeResizing = function()
{
  var resobj = this.isInDesignMode()?this.getPageIframeObject(this.getActivePage().name):this.getPageInput(this.getActivePage().name);

  for (var i=0; i<this.pages.length; i++)
  {
    var pif = this.getPageIframeObject(this.pages[i].name);
    var pta = this.getPageInput(this.pages[i].name);
    pif.style.height = resobj.offsetHeight + 'px';    
    pta.style.height = resobj.offsetHeight + 'px';    
    pta.style.width = resobj.offsetWidth + 'px';
  }
} 

// active toolbar control
SpawEditor.prototype.updateToolbar = function()
{
  if (this.controlled_by != this)
    this.updateEditorToolbar(this.controlled_by);
  this.updateEditorToolbar(this);
}
SpawEditor.prototype.updateEditorToolbar = function(ed)
{
  for(var i=0; i<ed.toolbar_items.length; i++)
  {
    // check if item is enabled
    if (ed.toolbar_items[i].on_enabled_check && ed.toolbar_items[i].on_enabled_check != '')
    {
      if(eval("SpawPG"+ed.toolbar_items[i].module 
              + '.' + ed.toolbar_items[i].on_enabled_check + '(this, ed.toolbar_items[i])'))
      {
        this.document.getElementById(ed.toolbar_items[i].id).disabled = false;
        ed.toolbar_items[i].is_enabled = true;
        if (ed.toolbar_items[i].on_click)
        { 
          // button     
          ed.theme.buttonOut(ed.toolbar_items[i], this.document.getElementById(ed.toolbar_items[i].id));
        }
        else
        {
          // dropdown
          ed.theme.dropdownOut(ed.toolbar_items[i], this.document.getElementById(ed.toolbar_items[i].id));
        }
        
        // check if button is pushed
        if (ed.toolbar_items[i].on_pushed_check && ed.toolbar_items[i].on_pushed_check != '')
        {
          if (eval("SpawPG"+ed.toolbar_items[i].module 
                  + '.' + ed.toolbar_items[i].on_pushed_check + '(this, ed.toolbar_items[i])'))
          {
            ed.toolbar_items[i].is_pushed = true;
            ed.theme.buttonDown(ed.toolbar_items[i], this.document.getElementById(ed.toolbar_items[i].id));
          }
          else
          {
            ed.toolbar_items[i].is_pushed = false;
            ed.theme.buttonOut(ed.toolbar_items[i], this.document.getElementById(ed.toolbar_items[i].id));
          }
        } 
        // update drowpdown value
        if (ed.toolbar_items[i].on_status_check && ed.toolbar_items[i].on_status_check != '')
        {
          var val = eval("SpawPG"+ed.toolbar_items[i].module 
                        + '.' + ed.toolbar_items[i].on_status_check + '(this, ed.toolbar_items[i])');
          var dd = this.document.getElementById(ed.toolbar_items[i].id);
          if (val)
          {
            for(var oi=0; oi<dd.options.length; oi++)
            {
              if (dd.options[oi].value == val)
                dd.options[oi].selected = true;
            }
          }
          else
          {
            dd.selectedIndex = 0;
          }
        }
        
      }
      else
      {
        this.document.getElementById(ed.toolbar_items[i].id).disabled = true;
        ed.toolbar_items[i].is_enabled = false;
        if (ed.toolbar_items[i].on_click)
        { 
          // button     
          ed.theme.buttonOff(ed.toolbar_items[i], this.document.getElementById(ed.toolbar_items[i].id));
        }
        else
        {
          // dropdown
          ed.theme.dropdownOff(ed.toolbar_items[i], this.document.getElementById(ed.toolbar_items[i].id));
        }
      }
    }
  }
}

// editor content
// updates code editor content from wysiwyg editor
SpawEditor.prototype.updatePageInput = function(page)
{
  var pdoc = this.getPageDoc(page.name);
  var pta = this.getPageInput(page.name);
  pta.value = this.getPageHtml(page); 
}
// updates wysiwyg editor content from code editor
SpawEditor.prototype.updatePageDoc = function(page)
{
  var pdoc = this.getPageDoc(page.name);
  var pta = this.getPageInput(page.name);

  var htmlValue = pta.value;
  
  // hr workaround for IE (HR sometimes causes unpredictable behavior in IE)
  // replace HR with SPAW:HR tags
  if (document.attachEvent) // ie
  {
    var hrRgx = new RegExp('(<HR(\/?)>)|(<HR ([^>]*)>)','gi');
    htmlValue = htmlValue.replace(hrRgx, '<SPAW:HR $2$4/>').replace("//>","/>");
  }

  // workaround for chewed up script, style and other tags under IE when content starts with them
  if (document.attachEvent) // ie
  {
    htmlValue = '<span id="spaw2_script_workaround">.</span>' + htmlValue;
  }

  // assign value  
  pdoc.body.innerHTML = htmlValue;
  
  // hr workaround for IE (HR sometimes causes unpredictable behavior in IE)
  // replace SPAW:HRs back to HR
  if (document.attachEvent) // ie
  {
    var HRs = pdoc.getElementsByTagName('hr');
    if (HRs && HRs.length > 0)
    {
      for (var i = (HRs.length - 1); i>=0; i--)
      {
        var realHR = pdoc.createElement('hr');
        realHR.mergeAttributes(HRs[i]);
        HRs[i].replaceNode(realHR);
      }
    } 
  }
  
  // workaround for chewed up script, style and other tags under IE when content starts with them
  if (document.attachEvent) // ie
  {
    var tmpSpan = pdoc.getElementById("spaw2_script_workaround");
    tmpSpan.parentNode.removeChild(tmpSpan);
  }  
  
  this.flash2img();
}
// returns html of the current page
SpawEditor.prototype.getPageHtml = function(page)
{
  // raise get html event
  SpawEngine.handleEvent("spawgethtml", null, "page_doc", this.name);

  var pdoc = this.getPageDoc(page.name);
  var pta = this.getPageInput(page.name);
  var result;
  if (page.editing_mode == "html")
  {
    // html mode
    result = pta.value;
  }
  else if(page.editing_mode == "design")
  {
    // remove glyphs
    this.removeGlyphs(pdoc.body);
    // replace flash placeholders
    this.img2flash();
    // strip absolute urls
    this.stripAbsoluteUrls();
    // wysiwyg mode
    if (this.getConfigValue("rendering_mode") == "builtin")
    {
      // let browser handle html rendering
      result = pdoc.body.innerHTML;
    }
    else
    {
      // call custom html renderer
      result = this.dom2xml(pdoc.body, '');
      // workaround for broken DOM tree
      pta.value = result;
      this.updatePageDoc(page);
    }
  }
  if (this.getConfigValue('convert_html_entities'))
    result = this.convertToEntities(result);

  return result;
} 
SpawEditor.updateFields = function(editor, event)
{
  editor.updateFields();
}
SpawEditor.prototype.updateFields = function()
{
  for(var i=0; i<this.pages.length; i++)
  {
    this.updatePageInput(this.pages[i]);
  }
}
SpawEditor.prototype.spawSubmit = function()
{
  SpawEngine.updateFields();
  var frm = this.getPageInput(this.pages[0].name).form;
  document.forms[0].setAttribute("__spawsubmiting","true");
  frm.formSubmit();
}

// renders xhtml
SpawEditor.prototype.dom2xml = function(node, indent, inParagraph)
{
    var xbuf = '';
    var f_indent = '';
    var e_indent = '';
    var f_crlf = '';
    var e_crlf = '';
    for (var i=0; i<node.childNodes.length; i++)
    {
      var chnode = node.childNodes[i];
      if (chnode.nodeType == 3) // text node
      {
        if (SpawUtils.trim(chnode.nodeValue).length > 0)
          xbuf += SpawUtils.trimLineBreaks(SpawUtils.htmlEncode(chnode.nodeValue));
        else if (chnode.nodeValue.length > 0)
          xbuf += " "; // add single space
      }
      else if (chnode.nodeType == 8) // comment node
      {
        xbuf += "<!--" + chnode.nodeValue + "-->";
      }
      else if (chnode.nodeType == 1) // html element
      {
        if (chnode.getAttribute("__spawprocessed") == null) // workaround to prevent elements from doubling
        {
          chnode.setAttribute("__spawprocessed",true);
          // form attributes string
          var attr_str = '';
          for(var j=0; j<chnode.attributes.length; j++)
          {
            var attr = chnode.attributes[j];
            if (attr.nodeValue != null 
                && (chnode.getAttribute(attr.nodeName, 2)!=null || chnode.getAttribute(attr.nodeName, 0) != null)
                && attr.specified && attr.nodeName.toLowerCase()!="__spawprocessed" 
                && attr.nodeName.toLowerCase().indexOf("_moz") != 0)
            {
              var attrval = chnode.getAttribute(attr.nodeName, 2);
              if (attrval == null)
                attrval = chnode.getAttribute(attr.nodeName, 0);
              
              if (chnode.tagName.toLowerCase() != 'font')
              {
                if (attr.nodeName.toLowerCase() != 'class' && attr.nodeName.toLowerCase() != 'style'
                   && attr.nodeName.toLowerCase() != 'href' && attr.nodeName.toLowerCase() != 'src' 
                   && attr.nodeName.toLowerCase() != 'shape' && attr.nodeName.toLowerCase() != 'coords' // coords and shape attributes are lost in area tag in IE 
                   && attr.nodeName.toLowerCase() != 'type' && attr.nodeName.toLowerCase() != 'value' && attr.nodeName.toLowerCase() != 'enctype') // type and value get lost on IE in input tags
                  attr_str += ' ' + attr.nodeName.toLowerCase() + '="' + attrval + '"';
              }
              else
              {
                // replace font tag with span
                if (attr.nodeName.toLowerCase() == 'face')
                  chnode.style.fontFamily = attrval;
                else if (attr.nodeName.toLowerCase() == 'size')
                {
                  switch(attrval)
                  {
                    case '1':
                      attrval = 'xx-small';
                      break;
                    case '2':
                      attrval = 'x-small';
                      break;
                    case '3':
                      attrval = 'small';
                      break;
                    case '4':
                      attrval = 'medium';
                      break;
                    case '5':
                      attrval = 'large';
                      break;
                    case '6':
                      attrval = 'x-large';
                      break;
                    case '7':
                      attrval = 'xx-large';
                      break;
                    default:
                      attrval = 'medium';
                      break;
                  }
                  chnode.style.fontSize = attrval;
                } 
                else if (attr.nodeName.toLowerCase() == 'color')
                  chnode.style.color = attrval; 
                  
                // crop attribute string
                attr_str = '';
              }
            }
            
          }
          // style attribute
          if (chnode.style.cssText && chnode.style.cssText != '')
            attr_str += ' style="' + chnode.style.cssText + '"';
        
          // class attribute
          if (chnode.className && chnode.className != '')
            attr_str += ' class="' + chnode.className + '"';

          if (chnode.type && chnode.type != '')
            attr_str += ' type="' + chnode.type + '"';
          if (chnode.value && chnode.value != '' 
            && !(chnode.tagName.toLowerCase() == 'li' && chnode.value == '-1')) // workaround for firefox 
            attr_str += ' value="' + chnode.value + '"';
          if (chnode.enctype && chnode.enctype != '' && chnode.enctype != 'application/x-www-form-urlencoded')
            attr_str += ' enctype="' + chnode.enctype + '"';

          // replace & to &amp; in href and src attributes
          if (chnode.href && chnode.href != '' && chnode.tagName.toLowerCase() != 'img')
            attr_str += ' href="' +  this.getStrippedAbsoluteUrl(chnode.href, false).replace(/&amp;/g,"&").replace(/&/g,"&amp;") + '"';
          if (chnode.src && chnode.src != '')
            attr_str += ' src="' +  this.getStrippedAbsoluteUrl(chnode.src, true).replace(/&amp;/g,"&").replace(/&/g,"&amp;") + '"';
        
          // shape and coords attributes
          if (chnode.coords && chnode.coords != '') 
            attr_str += ' coords="' + chnode.coords + '"'; 
          if (chnode.shape && chnode.shape != '') 
            attr_str += ' shape="' + chnode.shape + '"'; 

          if (this.getConfigValue("beautify_xhtml_output"))
          {
            switch(chnode.tagName.toLowerCase())
            {
              case "p":
              case "td":
              case "th":
              case "label":
              case "li":
                f_indent = indent;
                f_crlf = '\n';
                e_indent = '';
                e_crlf = '';
                break;
              case "table":
              case "thead":
              case "tfoot":
              case "tbody":
              case "tr":
              case "div":
              case "ul":
              case "ol":
              case "script":
              case "style":
                f_indent = indent;
                f_crlf = '\n';
                e_indent = indent;
                e_crlf = '\n';
                break;
              default:
                f_indent = '';
                f_crlf = '';
                e_indent = '';
                e_crlf = '';
            }
          }  
          if (chnode.tagName.toLowerCase() != "script" && chnode.tagName.toLowerCase() != "style" )
          {
            // replace font with span
            var tag_name = (chnode.tagName.toLowerCase() != 'font')?chnode.tagName.toLowerCase():'span';

            // workaround for invalid HTML in IE
            var pInParagraph = false;
            var closingP = '';
            if (document.attachEvent) // ie
            {
              if (inParagraph == true && tag_name == 'p')
              {
                closingP = '</p>';
                pInParagraph = false;
                inParagraph = false;
              }
              else if (inParagraph == true || tag_name == 'p')
                pInParagraph = true;
            }            
            
            if (chnode.childNodes.length>0)
            {
            
              var innercode = this.dom2xml(chnode, indent + ((f_indent!="tmp")?"  ":""), pInParagraph);
              if (SpawUtils.trim(innercode) == '')
                innercode = '&nbsp;';

              // workaround for invalid HTML in IE
              var closingTag = "</" + tag_name + ">";
              if (document.attachEvent) // ie
              {
                if (tag_name == 'p' && innercode.indexOf("</p>") != -1)
                  closingTag = "";
              }        

              xbuf += closingP + f_crlf + f_indent + "<" + SpawUtils.trim(tag_name + attr_str) + ">" + innercode + e_crlf + e_indent + closingTag;
            }
            else if (chnode.tagName.indexOf("/") == -1)// empty tag (sometimes ending tag is passed as a separate node)
            {
              if (tag_name == "img"
                || tag_name == "br"
                || tag_name == "wbr"
                || tag_name == "hr"
                || tag_name == "input")
              {
                xbuf += f_crlf + f_indent + "<" + SpawUtils.trim(tag_name + attr_str) + " />" + e_crlf + e_indent;
              }
              else
              {
                // don't generate empty useless tags
                if (tag_name != "b"
                  && tag_name != "i"
                  && tag_name != "u"
                  && tag_name != "strike"
                  && tag_name != "strong"
                  && tag_name != "em"
                  && tag_name != "i"
                  && tag_name != "span"
                  )
                {
                  var innercode = '';
                  if (tag_name == 'p')
                    innercode = '&nbsp;';
                  xbuf += f_crlf + f_indent + "<" + SpawUtils.trim(tag_name + attr_str) + ">" + innercode + "</" + tag_name + ">";
                }
              }
            }
          }
          else // script & style
          {
            xbuf += f_crlf + f_indent + "<" + SpawUtils.trim(chnode.tagName.toLowerCase() + attr_str) + ">" + SpawUtils.trim(chnode.innerHTML) + e_crlf + e_indent + "</" + chnode.tagName.toLowerCase() + ">";                    
          }
        }
      }
    }

    return xbuf;
}

// cleans up code
SpawEditor.prototype.getCleanCode = function(node, clean_type) // clean_type reserved for future use
{
  var xbuf = '';
  for (var i=0; i<node.childNodes.length; i++)
  {
    var chnode = node.childNodes[i];
    if (chnode.nodeType == 3) // text node
    {
      if (SpawUtils.trim(chnode.nodeValue).length > 0)
        xbuf += chnode.nodeValue.replace(/\u00A0/g, "&nbsp;");
    }
    else if (chnode.nodeType == 8) // comment node
    {
      xbuf += "<!--" + chnode.nodeValue + "-->";
    }
    else if (chnode.nodeType == 1) // html element
    {
      if (chnode.getAttribute("__spawprocessed") == null) // workaround to prevent elements from doubling
      {
        chnode.setAttribute("__spawprocessed",true);
        // form attributes string
        var attr_str = '';
        for(var j=0; j<chnode.attributes.length; j++)
        {
          var attr = chnode.attributes[j];
          if (attr.nodeValue != null && chnode.getAttribute(attr.nodeName, 2)!=null && attr.specified && attr.nodeName.toLowerCase()!="__spawprocessed" && attr.nodeName.toLowerCase().indexOf("_moz") != 0)
          {
            var attrval = chnode.getAttribute(attr.nodeName, 2);
            
            if (attr.nodeName.toLowerCase() != 'class' && attr.nodeName.toLowerCase() != 'style'
              && attr.nodeName.toLowerCase() != 'type' && attr.nodeName.toLowerCase() != 'value' && attr.nodeName.toLowerCase() != 'enctype') // type and value get lost on IE in input tags
              attr_str += ' ' + attr.nodeName.toLowerCase() + '="' + attrval + '"';
          }
          
        }

        if (chnode.type && chnode.type != '')
          attr_str += ' type="' + chnode.type + '"';
        if (chnode.value && chnode.value != '')
          attr_str += ' value="' + chnode.value + '"';
        if (chnode.enctype && chnode.enctype != '' && chnode.enctype != 'application/x-www-form-urlencoded')
          attr_str += ' enctype="' + chnode.enctype + '"';
      
        if (chnode.tagName.toLowerCase() != "script")
        {
          if (chnode.childNodes.length>0)
          {
            if (chnode.tagName.indexOf(":") == -1 && chnode.tagName.toLowerCase() != 'font' && chnode.tagName.toLowerCase() != 'div' && chnode.tagName.toLowerCase() != 'span')
              xbuf += "<" + SpawUtils.trim(chnode.tagName.toLowerCase() + attr_str) + ">" + this.getCleanCode(chnode, clean_type) + "</" + chnode.tagName.toLowerCase() + ">";
            else
              xbuf += this.getCleanCode(chnode, clean_type);
          }
          else if (chnode.tagName.indexOf("/") == -1)// empty tag (sometimes ending tag is passed as a separate node)
          {
            if (chnode.tagName.indexOf(":") == -1 && chnode.tagName.toLowerCase() != 'font' && chnode.tagName.toLowerCase() != 'div' && chnode.tagName.toLowerCase() != 'span')
            {
              if (chnode.tagName.toLowerCase() == "img"
                || chnode.tagName.toLowerCase() == "br"
                || chnode.tagName.toLowerCase() == "wbr"
                || chnode.tagName.toLowerCase() == "hr"
                || chnode.tagName.toLowerCase() == "input")
              {
                xbuf += "<" + SpawUtils.trim(chnode.tagName.toLowerCase() + attr_str) + " />";
              }
              else
              {
                xbuf += "<" + SpawUtils.trim(chnode.tagName.toLowerCase() + attr_str) + "></" + chnode.tagName.toLowerCase() + ">";
              }
            }
          }
        }
        else // script
        {
          xbuf += "<" + SpawUtils.trim(chnode.tagName.toLowerCase() + attr_str) + ">" + chnode.innerHTML + "</" + chnode.tagName.toLowerCase() + ">";                    
        }
      }
    }
  }
  return xbuf;
}
// cleans current page code
SpawEditor.prototype.cleanPageCode = function(clean_type) // clean_type reserved for future use
{
  var pname = this.getActivePage().name;
  var pdoc = this.getActivePageDoc();
  var pta = this.getPageInput(pname);

  pta.value = this.getCleanCode(pdoc.body, clean_type);
  this.updatePageDoc(this.getActivePage());     
}


// status bar
SpawEditor.prototype.showStatus = function(message)
{
  var sb = this.document.getElementById(this.name + '_status');
  if (sb && !document.attachEvent) // disable status bar in IE cause it breaks undo/redo
  {
    sb.innerHTML = message;
  }
}

// right click
SpawEditor.rightClick = function(editor, event)
{
  editor.rightClick(editor, event);
}
SpawEditor.prototype.rightClick = function(editor, event)
{
  if (SpawEngine.active_context_menu != null)
    SpawEngine.active_context_menu.hide();
  var cm = new SpawContextMenu(this);
  if (cm.show(event))
  {
    SpawEngine.active_context_menu = cm;
    if (event.preventDefault)
      event.preventDefault();
    else
      event.returnValue = false;
  }
}
// hide context menu
SpawEditor.hideContextMenu = function(editor, event)
{
  editor.hideContextMenu(editor, event);
}
SpawEditor.prototype.hideContextMenu = function(editor, event)
{
  if (SpawEngine.active_context_menu)
  {
    SpawEngine.active_context_menu.hide();
    SpawEngine.active_context_menu = null;
  }
}

// returns specified element surrounding current selection, returns null if selection is not inside such element 
SpawEditor.prototype.getSelectedElementByTagName = function(tagName)
{
  var result = null;
  var elm = this.getSelectionParent();
  
  while (elm && elm.tagName && elm.tagName.toLowerCase() != tagName.toLowerCase() && elm.tagName.toLowerCase() != 'body')
    elm = elm.parentNode;
    
  if (elm && elm.tagName && elm.tagName.toLowerCase() != 'body')
    result = elm;
    
  return result;
}

// returns all anchors on the active page
SpawEditor.prototype.getAnchors = function()
{
  var anchors = new Array();
  var pdoc = this.getActivePageDoc();
  var links = pdoc.getElementsByTagName("a");
  for (var i=0; i<links.length; i++)
  {
    if (links[i].name && links[i].name != '')
      anchors.push(links[i]); 
  }
  return anchors;
}

// show borders on borderless objects
SpawEditor.prototype.show_glyphs = true;

// returns true if active page is in design mode
SpawEditor.prototype.isInDesignMode = function()
{
  return (this.getActivePage().editing_mode == "design");
}

// removes absolute path portion from url
SpawEditor.prototype.getStrippedAbsoluteUrl = function(url, host_only)
{
  if (this.getConfigValue('strip_absolute_urls'))
  {
    var pdoc = this.getActivePageDoc();

  	var curl = pdoc.location.href;
  	var di = curl.lastIndexOf('/', curl.lastIndexOf('?')!=-1?curl.lastIndexOf('?'):curl.length);
  	var cdir = curl;
  	if (di != -1)
  		cdir = curl.substr(0,di+1);
  	var chost = curl;
  	var hi = curl.indexOf('/',curl.indexOf('://')!=-1?(curl.indexOf('://')+3):curl.length);
  	if (hi != -1)
  		chost = curl.substr(0,hi);
   	if (url.toLowerCase().indexOf(curl.toLowerCase())==0 && !host_only)
  	{
  		url = url.substr(curl.length);
  	}
  	else if (url.toLowerCase().indexOf(cdir.toLowerCase())==0 && !host_only)
  	{
  		url = url.substr(cdir.length);
  	}
  	else if (url.toLowerCase().indexOf(chost.toLowerCase())==0)
  	{
  		url = url.substr(chost.length);
  	}
	}
	return url;
}
SpawEditor.prototype.stripAbsoluteUrls = function()
{
  if (this.getConfigValue('strip_absolute_urls'))
  {
    var pdoc = this.getActivePageDoc();
   
    var links = pdoc.getElementsByTagName("a");
    for(var i=0; i<links.length; i++)
    {
      if (links[i].href && links[i].href != '')
        links[i].href = this.getStrippedAbsoluteUrl(links[i].href, false); 
    } 
    var imgs = pdoc.getElementsByTagName("img");
    for(var i=0; i<imgs.length; i++)
    {
      if (imgs[i].src && imgs[i].src != '')
        imgs[i].src = this.getStrippedAbsoluteUrl(imgs[i].src, true); 
    } 
  }
}
// strips absolute url from single object
SpawEditor.prototype.stripAbsoluteUrl = function(elm)
{
  if (this.getConfigValue('strip_absolute_urls') && elm && elm.nodeType == 1)
  {
    if (elm.tagName.toLowerCase() == 'a' && elm.href && elm.href != "")
    {
      elm.href = this.getStrippedAbsoluteUrl(elm.href, false); 
    }
    else if (elm.tagName.toLowerCase() == 'img' && elm.src && elm.src != "")
    {
      elm.src = this.getStrippedAbsoluteUrl(elm.src, true); 
    }
  }
}

// workaround functions to deal with flash objects
// replaces flash movies with image placeholders
SpawEditor.prototype.flash2img = function()
{
  var pdoc = this.getActivePageDoc();
  var flashs_elm = pdoc.getElementsByTagName("EMBED");

  // create a copy that wont be affected by changes to document
  var flashs = new Array();
  for (var i=0; i<flashs_elm.length; i++)
  {
    flashs[i] = flashs_elm[i];
  }

  for (var i=0; i<flashs.length; i++)
  {
    if (flashs[i].attributes.getNamedItem('src') != null /*&& flashs[i].attributes.getNamedItem('src').nodeValue.indexOf(".swf") != -1*/)
    {
  	  var flash = pdoc.createElement("IMG");
  	  flash.setAttribute('src', SpawEngine.spaw_dir + 'img/spacer100.gif?imgtype=flash&src='+flashs[i].getAttribute("src"));
    	if (flashs[i].style.cssText != '') // save original style
    	{
        flash.setAttribute("__spaw_style", flashs[i].style.cssText);
        if (flashs[i].style.width != '')
          flash.setAttribute('width',flashs[i].style.width);
        if (flashs[i].style.height != '')
          flash.setAttribute('height',flashs[i].style.height);
      }  
      // set attributes
      for(var j=0; j<flashs[i].attributes.length; j++)
      {
        var attr = flashs[i].attributes[j];
        if (attr.nodeValue != null 
            && (flashs[i].getAttribute(attr.nodeName, 2)!=null || flashs[i].getAttribute(attr.nodeName, 0) != null)
            && attr.specified 
            && attr.nodeName.toLowerCase().indexOf("_moz") != 0
            && attr.nodeName.toLowerCase() != "src")
        {
          var attrval = flashs[i].getAttribute(attr.nodeName, 2);
          if (attrval == null)
            attrval = flashs[i].getAttribute(attr.nodeName, 0);
          flash.setAttribute(attr.nodeName.toLowerCase(), attrval);
        }
      }
  	  flash.style.cssText = "border: 1px solid #000000; background: url(" + SpawEngine.spaw_dir + "img/flash.gif);";

      flashs[i].parentNode.replaceChild(flash, flashs[i]);
    }
  }
}
// replaces image placeholders for flash movies into embed tags
SpawEditor.prototype.img2flash = function()
{
  var pdoc = this.getActivePageDoc();
  var imgs_elm = pdoc.getElementsByTagName("IMG");

  // create a copy that wont be affected by changes to document
  var imgs = new Array();
  for (var i=0; i<imgs_elm.length; i++)
  {
    imgs[i] = imgs_elm[i];
  }
  
  
  for (var i=0; i<imgs.length; i++)
  {
    if (imgs[i].src.indexOf("spacer100.gif?imgtype=flash") != -1)
    {
      var flash = pdoc.createElement('EMBED');
  	  flash.setAttribute('type','application/x-shockwave-flash');
  	  flash.setAttribute('src',imgs[i].src.substring(imgs[i].src.indexOf("src=")+4));

      // set attributes
      for(var j=0; j<imgs[i].attributes.length; j++)
      {
        var attr = imgs[i].attributes[j];
        if (attr.nodeValue != null 
            && (imgs[i].getAttribute(attr.nodeName, 2)!=null || imgs[i].getAttribute(attr.nodeName, 0) != null)
            && attr.specified 
            && attr.nodeName.toLowerCase().indexOf("_moz") != 0
            && attr.nodeName.toLowerCase() != "src"
            && attr.nodeName.toLowerCase() != "type"
            && attr.nodeName.toLowerCase() != "style")
        {
          var attrval = imgs[i].getAttribute(attr.nodeName, 2);
          if (attrval == null)
            attrval = imgs[i].getAttribute(attr.nodeName, 0);
          flash.setAttribute(attr.nodeName.toLowerCase(), attrval);
        }
      }
    	if (imgs[i].getAttribute("__spaw_style", 2) != null) // restore original style
    	{
        flash.style.cssText = imgs[i].getAttribute("__spaw_style", 2);
        flash.removeAttribute("__spaw_style");
      }  
        	   
  	  imgs[i].parentNode.replaceChild(flash, imgs[i]);
    }
  }
}

// context
SpawEditor.prototype.current_context;
SpawEditor.checkContext = function(editor, event)
{
  editor.checkContext(editor, event);
}
SpawEditor.prototype.checkContext = function(editor, event)
{
  if (SpawEngine.getActiveEditor() != this)
    SpawEngine.setActiveEditor(this);

  var sp = this.getSelectionParent();
  if (this.current_context != sp)
  {
    this.updateToolbar();
    this.current_context = sp;
  }  
}

// focus
SpawEditor.prototype.focus = function()
{
  var obj = (this.isInDesignMode())?this.getPageIframe(this.getActivePage().name):this.getPageInput(this.getActivePage().name);
  if (obj.contentWindow) // gecko
    obj.contentWindow.focus();
  else
    obj.focus();
}
