// Hyperlink dialog
function SpawHyperlinkDialog()
{
}
SpawHyperlinkDialog.init = function() 
{
  var aProps = spawArguments;
  document.getElementById("prop_table").style.height = document.getElementById("prop_table").offsetHeight + 'px'; 
  if (aProps && (aProps.href || aProps.name))
  {
    // set attribute values
    if (aProps.href) {
      document.getElementById("chref").value = spawEditor.getStrippedAbsoluteUrl(aProps.href, false);
    }
    if (aProps.name) {
      document.getElementById("cname").value = aProps.name;
    }

    SpawHyperlinkDialog.setTarget(aProps.target);
    
    if (aProps.title) {
      document.getElementById("ctitle").value = aProps.title;
    }
  }

  var found = SpawHyperlinkDialog.setAnchors(aProps?aProps.href:'');
  var atype = "link";
  if (aProps)
  {
    if (aProps.name)
    {
      atype = "anchor";	
    }
    else if (found)
    {
      atype = "link2anchor";
    }
  }
  if (document.getElementById("canchor").options.length<=1)
  {
    // no anchors found, disable link to anchor feature
    document.getElementById("catype").remove(2);
  }
  SpawHyperlinkDialog.changeType(atype);    
  
  // size quicklinks equally to title field
  if (document.getElementById("cquicklinks"))
  {
    document.getElementById("cquicklinks").style.width = document.getElementById("ctitle").offsetWidth + "px"; 
  }
}

SpawHyperlinkDialog.okClick = function() {
  var aProps = spawArguments;
  var pdoc = spawEditor.getActivePageDoc();

  if (!aProps) // new hyperlink
  {
    if (document.getElementById("cname").value)
    {
      // MSIE workaround
      try
      {
        aProps = pdoc.createElement('<A NAME="'+document.getElementById("cname").value + '"></A>');
      }
      catch(excp)
      {
        // non-ie fallback
        aProps = pdoc.createElement("A");
      }
    }
    else
    {
      aProps = pdoc.createElement("A");
    }
  }
  if (document.getElementById("catype").options[document.getElementById("catype").selectedIndex].value == "link2anchor")
    aProps.href = (document.getElementById("canchor").options[document.getElementById("canchor").selectedIndex].value)?(document.getElementById("canchor").options[document.getElementById("canchor").selectedIndex].value):'';
  else
    aProps.href = (document.getElementById("chref").value)?(document.getElementById("chref").value):'';
  if (!aProps.href || aProps.href == '' || aProps.href == window.location.href)
    aProps.removeAttribute("href"); 
  aProps.name = (document.getElementById("cname").value)?(document.getElementById("cname").value):'';
  if (!aProps.name || aProps.name == '')
    aProps.removeAttribute("name"); 
  aProps.target = (document.getElementById("ctarget").value)?(document.getElementById("ctarget").value):'';
  if (!aProps.target || aProps.target == '' || aProps.target == '_self' )
    aProps.removeAttribute("target"); 
  aProps.title = (document.getElementById("ctitle").value)?(document.getElementById("ctitle").value):'';
  if (!aProps.title || aProps.title == '')
    aProps.removeAttribute("title"); 

  SpawDialog.returnValue(aProps);
  window.close();
}

SpawHyperlinkDialog.cancelClick = function() {
  window.close();
}

SpawHyperlinkDialog.browseClick = function() 
{
  SpawEngine.openDialog('spawfm', 'spawfm', spawEditor, document.getElementById('chref').value, 'type=any', 'SpawHyperlinkDialog.browseClickCallback', null, null);
}
SpawHyperlinkDialog.browseClickCallback = function(editor, result, tbi, sender)
{
  document.getElementById('chref').value = result;
  window.focus();
  document.getElementById('chref').focus();
}

SpawHyperlinkDialog.setTarget = function(target)
{
  for (i=0; i<document.getElementById("ctarget").options.length; i++)  
  {
    tg = document.getElementById("ctarget").options.item(i);
    if (tg.value == target.toLowerCase()) {
      document.getElementById("ctarget").selectedIndex = tg.index;
    }
  }
}

SpawHyperlinkDialog.setAnchors = function(anchor)
{
	var found = false;
	var anchors = spawEditor.getAnchors();
	for(var i=0; i<anchors.length; i++)
  {
    var opt = document.createElement("OPTION");
    document.getElementById("canchor").options.add(opt);
    opt.appendChild(document.createTextNode(anchors[i].name));
    opt.value = '#'+anchors[i].name;
    if (opt.value == anchor)
    {
      opt.selected = true;
      found = true;
    }
  }
  return found;
}

SpawHyperlinkDialog.changeType = function(new_type)
{
  document.getElementById("catype").selectedIndex = 0;
  if (new_type == "anchor")
  {
    document.getElementById("catype").selectedIndex = 1;
  }
  else if (new_type == "link2anchor")
  {
    document.getElementById("catype").selectedIndex = 2;
  }

  document.getElementById("url_row").style.display = new_type=="link"?"":"none";
	document.getElementById("name_row").style.display = new_type=="anchor"?"":"none";
	document.getElementById("anchor_row").style.display = new_type=="link2anchor"?"":"none";
	document.getElementById("target_row").style.display = (new_type=="link"||new_type=="link2anchor")?"":"none";
	if (document.getElementById("quick_links_row"))
    document.getElementById("quick_links_row").style.display = new_type=="link"?"":"none";
	
  //SpawDialog.resizeDialogToContent();
}

SpawHyperlinkDialog.changeQuickLink = function(new_url)
{
  document.getElementById("chref").value = new_url;
}

if (document.attachEvent)
{
  // ie
  window.attachEvent("onload", new Function("SpawHyperlinkDialog.init();"));
}
else
{
  window.addEventListener("load", new Function("SpawHyperlinkDialog.init();"), false);
}

