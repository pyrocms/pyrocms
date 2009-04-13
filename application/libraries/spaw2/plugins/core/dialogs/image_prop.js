// Image properties
function SpawImagePropDialog()
{
}
SpawImagePropDialog.init = function() 
{
  // size preview box
  document.getElementById("img_preview_sizer").height = document.getElementById("img_preview_box").offsetHeight - document.getElementById("img_data").offsetHeight - 10;  

  var iProps = spawArguments;
  if (iProps)
  {
    // set attribute values
    if (iProps.width) {
      var wd = iProps.width;
      if (isNaN(wd) && wd.indexOf("px") != -1)
        wd = wd.substring(0, wd.length-2);
      document.getElementById('cwidth').value = wd;
    }
    if (iProps.height) {
      var ht = iProps.height;
      if (isNaN(ht) && ht.indexOf("px") != -1)
        ht = ht.substring(0, ht.length-2);
      document.getElementById('cheight').value = ht;
    }
    SpawImagePropDialog.setAspectRatio();
    if (iProps.src) {
      document.getElementById('csrc').value = spawEditor.getStrippedAbsoluteUrl(iProps.src, true);
      SpawImagePropDialog.previewImage(document.getElementById('csrc').value);
    }
    
    SpawImagePropDialog.setAlign(iProps.align);
    
    if (iProps.alt) {
      document.getElementById('calt').value = iProps.alt;
    }
    if (iProps.title) {
      document.getElementById('ctitle').value = iProps.title;
    }
    if (iProps.border) {
      document.getElementById('cborder').value = iProps.border;
    }
    if (iProps.hspace && iProps.hspace>-1) {
      document.getElementById('chspace').value = iProps.hspace;
    }
    if (iProps.vspace && iProps.vspace>-1) {
      document.getElementById('cvspace').value = iProps.vspace;
    }
    if (iProps.className) {
      document.getElementById('ccssclass').value = iProps.className;
    }
  }
  
  //SpawDialog.resizeDialogToContent();
}

SpawImagePropDialog.validateParams = function()
{
  // check width and height
  if (isNaN(parseInt(document.getElementById('cwidth').value)) && document.getElementById('cwidth').value != '')
  {
    alert(spawErrorMessages['error_width_nan']);
    document.getElementById('cwidth').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('cheight').value)) && document.getElementById('cheight').value != '')
  {
    alert(spawErrorMessages['error_height_nan']);
    document.getElementById('cheight').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('cborder').value)) && document.getElementById('cborder').value != '')
  {
    alert(spawErrorMessages['error_border_nan']);
    document.getElementById('cborder').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('chspace').value)) && document.getElementById('chspace').value != '')
  {
    alert(spawErrorMessages['error_hspace_nan']);
    document.getElementById('chspace').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('cvspace').value)) && document.getElementById('cvspace').value != '')
  {
    alert(spawErrorMessages['error_vspace_nan']);
    document.getElementById('cvspace').focus();
    return false;
  }
  
  return true;
}

SpawImagePropDialog.imageBrowseClick = function() 
{
  SpawEngine.openDialog('spawfm', 'spawfm', spawEditor, document.getElementById('csrc').value, 'type=images', 'SpawImagePropDialog.imageBrowseClickCallback', null, null);
}
SpawImagePropDialog.imageBrowseClickCallback = function(editor, result, tbi, sender)
{
  document.getElementById('csrc').value = result;
  window.focus();
  document.getElementById('csrc').focus();
  SpawImagePropDialog.previewImage(document.getElementById('csrc').value, 0);
}

SpawImagePropDialog.okClick = function() {
  // validate paramters
  if (SpawImagePropDialog.validateParams())    
  {
    var pdoc = spawEditor.getActivePageDoc();
    var iProps = spawArguments;
    if (iProps == null)
      iProps = pdoc.createElement("img");
    iProps.className = (document.getElementById('ccssclass').value != 'default')?document.getElementById('ccssclass').value:'';
    if (!iProps.className || iProps.className == '')
      iProps.removeAttribute("class"); 
    iProps.align = (document.getElementById('calign').value)?(document.getElementById('calign').value):'';
    if (!iProps.align || iProps.align == '')
      iProps.removeAttribute("align"); 
    iProps.width = (document.getElementById('cwidth').value)?(document.getElementById('cwidth').value):'';
    if (!iProps.width || iProps.width == '')
      iProps.removeAttribute("width");
    else
      iProps.style.width = (document.getElementById('cwidth').value)?(document.getElementById('cwidth').value):'' + "px";
    iProps.height = (document.getElementById('cheight').value)?(document.getElementById('cheight').value):'';
    if (!iProps.height || iProps.height == '')
      iProps.removeAttribute("height"); 
    else
      iProps.style.height = (document.getElementById('cheight').value)?(document.getElementById('cheight').value):'' + "px";  
    iProps.border = (document.getElementById('cborder').value)?(document.getElementById('cborder').value):'';
    if (!iProps.border || iProps.border == '')
      iProps.removeAttribute("border"); 
    iProps.src = (document.getElementById('csrc').value)?(document.getElementById('csrc').value):'';
    if (!iProps.src || iProps.src == '')
      iProps.removeAttribute("src"); 
    iProps.alt = (document.getElementById('calt').value)?(document.getElementById('calt').value):'';
    if (!iProps.alt || iProps.alt == '')
      iProps.setAttribute("alt",""); // alt attribute is mandatory
    iProps.title = (document.getElementById('ctitle').value)?(document.getElementById('ctitle').value):'';
    if (!iProps.title || iProps.title == '')
      iProps.removeAttribute("title"); 
    iProps.hspace = (document.getElementById('chspace').value)?(document.getElementById('chspace').value):'';
    if (!iProps.hspace || iProps.hspace == '')
      iProps.removeAttribute("hspace"); 
    iProps.vspace = (document.getElementById('cvspace').value)?(document.getElementById('cvspace').value):'';
    if (!iProps.vspace || iProps.vspace == '')
      iProps.removeAttribute("vspace"); 

    if (spawArgs.callback)
    {
      eval('window.opener.'+spawArgs.callback + '(spawEditor, iProps, spawArgs.tbi, spawArgs.sender)');
    }
    window.close();
  }
}

SpawImagePropDialog.cancelClick = function() {
  window.close();
}


SpawImagePropDialog.setAlign = function(alignment)
{
  for (i=0; i<document.getElementById('calign').options.length; i++)  
  {
    al = document.getElementById('calign').options.item(i);
    if (al.value == alignment.toLowerCase()) {
      document.getElementById('calign').selectedIndex = al.index;
    }
  }
}
SpawImagePropDialog.previewImgObj = null;
SpawImagePropDialog.previewImage = function(img_src, time_elapsed) 
{
  if (!time_elapsed)
    time_elapsed = 0;
  if (time_elapsed == 0) 
  {
    SpawImagePropDialog.previewImgObj = new Image();
    SpawImagePropDialog.previewImgObj.src = img_src;
  }
  if (!SpawImagePropDialog.previewImgObj.complete) 
  {
    if (time_elapsed < 2000)
    {
      setTimeout('SpawImagePropDialog.previewImage("'+img_src+'", ' + (time_elapsed + 100) + ')', 100);
      return false;
    }
  }
  // show preview image
  if (SpawImagePropDialog.previewImgObj.complete && SpawImagePropDialog.previewImgObj.width>0 && SpawImagePropDialog.previewImgObj.height>0)
  {
    var maxwidth = 200;//document.getElementById("img_preview_placeholder").offsetWidth - 2;
    var maxheight = document.getElementById("img_preview_box").offsetHeight - document.getElementById("img_data").offsetHeight - 20;
    var w = SpawImagePropDialog.previewImgObj.width;
    var h = SpawImagePropDialog.previewImgObj.height;
    
    // calculate resize ratio
    var ratio = 1;
    if (w > maxwidth) ratio = w / maxwidth;
    if (h > maxheight && h/maxheight > ratio) ratio = h/maxheight;
    
    var imgelm = document.getElementById('img_preview');
    imgelm.src = SpawImagePropDialog.previewImgObj.src;
    imgelm.width = Math.round(w / ratio);
    imgelm.height = Math.round(h / ratio);
    var dimensions = document.getElementById("img_dimensions");
    dimensions.innerHTML = SpawImagePropDialog.previewImgObj.width + "x" + SpawImagePropDialog.previewImgObj.height;
    if (document.getElementById('cwidth').value == '' && document.getElementById('cheight').value == '')
    {
      document.getElementById('cwidth').value = SpawImagePropDialog.previewImgObj.width;
      document.getElementById('cheight').value = SpawImagePropDialog.previewImgObj.height;
      SpawImagePropDialog.setAspectRatio();
    }

    document.getElementById('img_preview_placeholder').style.visibility = 'visible';
    document.getElementById('img_data').style.visibility = 'visible';
  }
  else
  {
    // timeout or broken url
    document.getElementById('img_preview_placeholder').style.visibility = 'hidden';
    document.getElementById('img_data').style.visibility = 'hidden';
  }
}

SpawImagePropDialog.resetDimensions = function()
{
  if (SpawImagePropDialog.previewImgObj.complete && SpawImagePropDialog.previewImgObj.width>0 && SpawImagePropDialog.previewImgObj.height>0)
  {
    document.getElementById("cwidth").value = SpawImagePropDialog.previewImgObj.width;
    document.getElementById("cheight").value = SpawImagePropDialog.previewImgObj.height;
    SpawImagePropDialog.setAspectRatio();
  }
  return false;
} 

SpawImagePropDialog.aspectRatio = 0;
SpawImagePropDialog.setAspectRatio = function()
{
  if (!isNaN(document.getElementById('cwidth').value) && !isNaN(document.getElementById('cheight').value))
  {
    SpawImagePropDialog.aspectRatio = parseFloat(document.getElementById('cwidth').value)/parseFloat(document.getElementById('cheight').value);
  }
}
SpawImagePropDialog.widthChanged = function()
{
  if (document.getElementById("cproportions").checked && SpawImagePropDialog.aspectRatio != 0)
  {
    var width = parseInt(document.getElementById("cwidth").value);
    document.getElementById("cheight").value = Math.round(width/SpawImagePropDialog.aspectRatio);
  }
}

SpawImagePropDialog.heightChanged = function()
{
  if (document.getElementById("cproportions").checked && SpawImagePropDialog.aspectRatio != 0)
  {
    var height = parseInt(document.getElementById("cheight").value);
    document.getElementById("cwidth").value = Math.round(height*SpawImagePropDialog.aspectRatio);
  }
}
SpawImagePropDialog.proportionsClick = function()
{
  if (document.getElementById("cproportions").checked)
  {
    // set new aspect ratio
    SpawImagePropDialog.setAspectRatio();
  }
}

SpawImagePropDialog.cssClassChanged = function()
{
}

if (document.attachEvent)
{
  // ie
  window.attachEvent("onload", new Function("SpawImagePropDialog.init();"));
}
else
{
  window.addEventListener("load", new Function("SpawImagePropDialog.init();"), false);
}
