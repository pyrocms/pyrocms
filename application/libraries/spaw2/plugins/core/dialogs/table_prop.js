// table properties

function SpawTablePropDialog()
{
}

SpawTablePropDialog.showColorPicker = function(curcolor) 
{
  SpawEngine.openDialog('core', 'colorpicker', spawEditor, SpawColor.parseRGB(curcolor), '', 'SpawTablePropDialog.showColorPickerCallback', null, this);
}

SpawTablePropDialog.showColorPickerCallback = function(editor, result, tbi, sender)
{
  var bCol = result;
  try
  {
    document.getElementById('tbgcolor').value = bCol;
    document.getElementById('color_sample').style.backgroundColor = document.getElementById('tbgcolor').value;
    document.getElementById('tbgcolor').focus();
  }
  catch (excp) {}
}

SpawTablePropDialog.showImgPicker = function()
{
  SpawEngine.openDialog('spawfm', 'spawfm', spawEditor, document.getElementById('tbackground').value, 'type=images', 'SpawTablePropDialog.showImgPickerCallback', null, null);
}

SpawTablePropDialog.showImgPickerCallback = function(editor, result, tbi, sender)
{
  document.getElementById('tbackground').value = result;
  window.focus();
  document.getElementById('tbackground').focus();
}

SpawTablePropDialog.init = function()
{
  var tProps = spawArguments;
  if (tProps)
  {
    // set attribute values
    document.getElementById('trows').value = '3';
    document.getElementById('trows').disabled = true;
    document.getElementById('tcols').value = '3';
    document.getElementById('tcols').disabled = true;

    document.getElementById('tborder').value = tProps.border;
    document.getElementById('tcpad').value = tProps.cellPadding;
    document.getElementById('tcspc').value = tProps.cellSpacing;
    document.getElementById('tbgcolor').value = tProps.bgColor;
    document.getElementById('color_sample').style.backgroundColor = document.getElementById('tbgcolor').value;
    if (tProps.style.backgroundImage)
      document.getElementById('tbackground').value = tProps.style.backgroundImage.substring(4, tProps.style.backgroundImage.length-1);
    if (tProps.width) {
      if (!isNaN(tProps.width) || (tProps.width.substr(tProps.width.length-2,2).toLowerCase() == "px"))
      {
        // pixels
        if (!isNaN(tProps.width))
          document.getElementById('twidth').value = tProps.width;
        else
          document.getElementById('twidth').value = tProps.width.substr(0,tProps.width.length-2);
        document.getElementById('twunits').options[0].selected = false;
        document.getElementById('twunits').options[1].selected = true;
      }
      else
      {
        // percents
        document.getElementById('twidth').value = tProps.width.substr(0,tProps.width.length-1);
        document.getElementById('twunits').options[0].selected = true;
        document.getElementById('twunits').options[1].selected = false;
      }
    }
    if (tProps.height) {
      if (!isNaN(tProps.height) || (tProps.height.substr(tProps.height.length-2,2).toLowerCase() == "px"))
      {
        // pixels
        if (!isNaN(tProps.height))
          document.getElementById('theight').value = tProps.height;
        else
          document.getElementById('theight').value = tProps.height.substr(0,tProps.height.length-2);
        document.getElementById('thunits').options[0].selected = false;
        document.getElementById('thunits').options[1].selected = true;
      }
      else
      {
        // percents
        document.getElementById('theight').value = tProps.height.substr(0,tProps.height.length-1);
        document.getElementById('thunits').options[0].selected = true;
        document.getElementById('thunits').options[1].selected = false;
      }
    }
    if (tProps.className) {
      document.getElementById('tcssclass').value = tProps.className;
      //css_class_changed();
    }
  }
  else
  {
    // set default values
    document.getElementById('trows').value = '3';
    document.getElementById('tcols').value = '3';
    document.getElementById('tborder').value = '1';
  }
//  SpawDialog.resizeDialogToContent();
}

SpawTablePropDialog.validateParams = function()
{
  // check whether rows and cols are integers
  if (isNaN(parseInt(document.getElementById('trows').value)))
  {
    alert(spawErrorMessages['error_rows_nan']);
    document.getElementById('trows').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('tcols').value)))
  {
    alert(spawErrorMessages['error_columns_nan']);
    document.getElementById('tcols').focus();
    return false;
  }
  // check width and height
  if (isNaN(parseInt(document.getElementById('twidth').value)) && document.getElementById('twidth').value != '')
  {
    alert(spawErrorMessages['error_width_nan']);
    document.getElementById('twidth').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('theight').value)) && document.getElementById('theight').value != '')
  {
    alert(spawErrorMessages['error_height_nan']);
    document.getElementById('theight').focus();
    return false;
  }
  // check border, padding and spacing
  if (isNaN(parseInt(document.getElementById('tborder').value)) && document.getElementById('tborder').value != '')
  {
    alert(spawErrorMessages['error_border_nan']);
    document.getElementById('tborder').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('tcpad').value)) && document.getElementById('tcpad').value != '')
  {
    alert(spawErrorMessages['error_cellpadding_nan']);
    document.getElementById('tcpad').focus();
    return false;
  }
  if (isNaN(parseInt(document.getElementById('tcspc').value)) && document.getElementById('tcspc').value != '')
  {
    alert(spawErrorMessages['error_cellspacing_nan']);
    document.getElementById('tcspc').focus();
    return false;
  }
  
  return true;
}

SpawTablePropDialog.okClick = function()
{
  // validate paramters
  if (SpawTablePropDialog.validateParams())    
  {
    var pdoc = spawEditor.getActivePageDoc();
    var newtable = spawArguments;
    if (newtable == null)
    {
      newtable = pdoc.createElement("TABLE");
      for(var ri=0; ri<parseInt(document.getElementById('trows').value); ri++)
      {
        var r = pdoc.createElement("TR");
        for(var ci=0; ci<parseInt(document.getElementById('tcols').value); ci++)
        {
          var c = pdoc.createElement("TD");
          c.innerHTML = "&nbsp;"; // otherwise it doesn't show cell borders in opera and gecko
          r.appendChild(c);
        }
        newtable.appendChild(r);
      }
    }
    newtable.className = (document.getElementById('tcssclass').value != 'default')?document.getElementById('tcssclass').value:null;
    if (!newtable.className || newtable.className == '')
      newtable.removeAttribute("class"); 
    if (!document.getElementById('twidth').disabled)
    {
        newtable.width = (document.getElementById('twidth').value)?(document.getElementById('twidth').value + document.getElementById('twunits').value):'';
        if (!newtable.width || newtable.width == '')
          newtable.removeAttribute("width"); 
        newtable.height = (document.getElementById('theight').value)?(document.getElementById('theight').value + document.getElementById('thunits').value):'';
        if (!newtable.height || newtable.height == '')
          newtable.removeAttribute("height"); 
        newtable.border = document.getElementById('tborder').value;
        if (!newtable.border || newtable.border == '')
          newtable.removeAttribute("border"); 
        newtable.cellPadding = document.getElementById('tcpad').value;
        if (!newtable.cellPadding || newtable.cellPadding == '')
          newtable.removeAttribute("cellPadding"); 
        newtable.cellSpacing = document.getElementById('tcspc').value;
        if (!newtable.cellSpacing || newtable.cellSpacing == '')
          newtable.removeAttribute("cellSpacing"); 
        newtable.bgColor = document.getElementById('tbgcolor').value;
        if (!newtable.bgColor || newtable.bgColor == '')
          newtable.removeAttribute("bgColor"); 
        newtable.style.backgroundImage = 'url(' + document.getElementById('tbackground').value + ')';
        if (!document.getElementById('tbackground').value || document.getElementById('tbackground').value == '')
          newtable.style.backgroundImage = ''; 
    }
    if (spawArgs.callback)
    {
      eval('window.opener.'+spawArgs.callback + '(spawEditor, newtable, spawArgs.tbi, spawArgs.sender)');
    }
    window.close();
  }
}

SpawTablePropDialog.cancelClick = function()
{
  window.close();
}

SpawTablePropDialog.setSample = function()
{
  try {
    document.getElementById('color_sample').style.backgroundColor = document.getElementById('tbgcolor').value;
  }
  catch (excp) {}
}

SpawTablePropDialog.cssClassChanged = function()
{
/*
  // disable/enable non-css class controls
	if (document.getElementById('tcssclass').value && document.getElementById('tcssclass').value!='default')
	{
		// disable all controls
		document.getElementById('twidth').disabled = true;
		document.getElementById('twunits').disabled = true;
		document.getElementById('theight').disabled = true;
		document.getElementById('thunits').disabled = true;
		document.getElementById('tborder').disabled = true;
		document.getElementById('tcpad').disabled = true;
		document.getElementById('tcspc').disabled = true;
		document.getElementById('tbgcolor').disabled = true;
		document.getElementById('tcolorpicker').src = document.getElementById('tcolorpicker').src.substring(0, document.getElementById('tcolorpicker').src.indexOf("tb_colorpicker")+14) + '_off.gif';
		document.getElementById('tcolorpicker').disabled = true;
		document.getElementById('tbackground').disabled = true;
		document.getElementById('timg_picker').src = document.getElementById('timg_picker').src.substring(0, document.getElementById('timg_picker').src.indexOf("tb_image_insert")+15) + '_off.gif';
		document.getElementById('timg_picker').disabled = true;
	}
	else
	{
		// enable all controls
		document.getElementById('twidth').disabled = false;
		document.getElementById('twunits').disabled = false;
		document.getElementById('theight').disabled = false;
		document.getElementById('thunits').disabled = false;
		document.getElementById('tborder').disabled = false;
		document.getElementById('tcpad').disabled = false;
		document.getElementById('tcspc').disabled = false;
		document.getElementById('tbgcolor').disabled = false;
		document.getElementById('tcolorpicker').src = document.getElementById('tcolorpicker').src.substring(0, document.getElementById('tcolorpicker').src.indexOf("tb_colorpicker")+14) + '.gif';
		document.getElementById('tcolorpicker').disabled = false;
		document.getElementById('tbackground').disabled = false;
		document.getElementById('timg_picker').src = document.getElementById('timg_picker').src.substring(0, document.getElementById('timg_picker').src.indexOf("tb_image_insert")+15) + '.gif';
		document.getElementById('timg_picker').disabled = false;
	}
	*/
}

if (document.attachEvent)
{
  // ie
  window.attachEvent("onload", new Function("SpawTablePropDialog.init();"));
}
else
{
  window.addEventListener("load", new Function("SpawTablePropDialog.init();"), false);
}

