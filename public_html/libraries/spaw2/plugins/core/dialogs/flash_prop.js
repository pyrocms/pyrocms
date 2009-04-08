// Flash properties
function SpawFlashPropDialog()
{
}
SpawFlashPropDialog.init = function() 
{
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
    if (iProps.src) {
      document.getElementById('csrc').value = spawEditor.getStrippedAbsoluteUrl(iProps.src, true);
      document.getElementById('csrc').value = document.getElementById('csrc').value.substring(document.getElementById('csrc').value.indexOf("src=")+4);
    }
  }
  SpawDialog.resizeDialogToContent();
}

SpawFlashPropDialog.validateParams = function()
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
  return true;
}

SpawFlashPropDialog.browseClick = function() 
{
  SpawEngine.openDialog('spawfm', 'spawfm', spawEditor, document.getElementById('csrc').value, 'type=flash', 'SpawFlashPropDialog.browseClickCallback', null, null);
}
SpawFlashPropDialog.browseClickCallback = function(editor, result, tbi, sender)
{
  document.getElementById('csrc').value = result;
  window.focus();
  document.getElementById('csrc').focus();
}

SpawFlashPropDialog.okClick = function() {
  // validate paramters
  if (SpawFlashPropDialog.validateParams())    
  {
    var pdoc = spawEditor.getActivePageDoc();
    var iProps = spawArguments;
    if (iProps == null)
    {
      iProps = pdoc.createElement("img");
  	  iProps.style.cssText = "border: 1px solid #000000; background: url(" + SpawEngine.spaw_dir + "img/flash.gif);";
    }
    iProps.width = (document.getElementById('cwidth').value)?(document.getElementById('cwidth').value):'';
    if (!iProps.width || iProps.width == '')
      iProps.removeAttribute("width"); 
    iProps.height = (document.getElementById('cheight').value)?(document.getElementById('cheight').value):'';
    if (!iProps.height || iProps.height == '')
      iProps.removeAttribute("height"); 
    iProps.src = (document.getElementById('csrc').value)?(SpawEngine.spaw_dir + 'img/spacer100.gif?imgtype=flash&src=' + document.getElementById('csrc').value):'';
    if (!iProps.src || iProps.src == '')
      iProps.removeAttribute("src"); 

    if (spawArgs.callback)
    {
      eval('window.opener.'+spawArgs.callback + '(spawEditor, iProps, spawArgs.tbi, spawArgs.sender)');
    }
    window.close();
  }
}

SpawFlashPropDialog.cancelClick = function() {
  window.close();
}

if (document.attachEvent)
{
  // ie
  window.attachEvent("onload", new Function("SpawFlashPropDialog.init();"));
}
else
{
  window.addEventListener("load", new Function("SpawFlashPropDialog.init();"), false);
}
