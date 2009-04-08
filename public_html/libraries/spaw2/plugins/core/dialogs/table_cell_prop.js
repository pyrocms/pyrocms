// table cell properties
function SpawTableCellPropDialog()
{
}

SpawTableCellPropDialog.showColorPicker = function(curcolor) 
{
  SpawEngine.openDialog('core', 'colorpicker', spawEditor, SpawColor.parseRGB(curcolor), '', 'SpawTableCellPropDialog.showColorPickerCallback', null, this);
}

SpawTableCellPropDialog.showColorPickerCallback = function(editor, result, tbi, sender)
{
  var bCol = result;
  try
  {
    document.getElementById('cbgcolor').value = bCol;
    document.getElementById('color_sample').style.backgroundColor = document.getElementById('cbgcolor').value;
    document.getElementById('cbgcolor').focus();
  }
  catch (excp) {}
}

SpawTableCellPropDialog.showImgPicker = function()
{
  SpawEngine.openDialog('spawfm', 'spawfm', spawEditor, document.getElementById('cbackground').value, 'type=images', 'SpawTableCellPropDialog.showImgPickerCallback', null, null);
}

SpawTableCellPropDialog.showImgPickerCallback = function(editor, result, tbi, sender)
{
  document.getElementById('cbackground').value = result;
  window.focus();
  document.getElementById('cbackground').focus();
}


SpawTableCellPropDialog.init = function()
{
  var cProps = spawArguments;
  if (cProps)
  {
    // set attribute values
    document.getElementById('cbgcolor').value = cProps.bgColor;
    document.getElementById('color_sample').style.backgroundColor = document.getElementById('cbgcolor').value;
    if (cProps.style.backgroundImage)
      document.getElementById('cbackground').value = cProps.style.backgroundImage.substring(4, cProps.style.backgroundImage.length-1);
    if (cProps.width) {
      if (!isNaN(cProps.width) || (cProps.width.substr(cProps.width.length-2,2).toLowerCase() == "px"))
      {
        // pixels
        if (!isNaN(cProps.width))
          document.getElementById('cwidth').value = cProps.width;
        else
          document.getElementById('cwidth').value = cProps.width.substr(0,cProps.width.length-2);
        document.getElementById('cwunits').options[0].selected = false;
        document.getElementById('cwunits').options[1].selected = true;
      }
      else
      {
        // percents
        document.getElementById('cwidth').value = cProps.width.substr(0,cProps.width.length-1);
        document.getElementById('cwunits').options[0].selected = true;
        document.getElementById('cwunits').options[1].selected = false;
      }
    }
    if (cProps.width) {
      if (!isNaN(cProps.height) || (cProps.height.substr(cProps.height.length-2,2).toLowerCase() == "px"))
      {
        // pixels
        if (!isNaN(cProps.height))
          document.getElementById('cheight').value = cProps.height;
        else
          document.getElementById('cheight').value = cProps.height.substr(0,cProps.height.length-2);
        document.getElementById('chunits').options[0].selected = false;
        document.getElementById('chunits').options[1].selected = true;
      }
      else
      {
        // percents
        document.getElementById('cheight').value = cProps.height.substr(0,cProps.height.length-1);
        document.getElementById('chunits').options[0].selected = true;
        document.getElementById('chunits').options[1].selected = false;
      }
    }
    
    SpawTableCellPropDialog.setHAlign(cProps.align);
    SpawTableCellPropDialog.setVAlign(cProps.vAlign);
    
    if (cProps.noWrap || cProps.style.whiteSpace == 'nowrap')
      document.getElementById('cnowrap').checked = true;
    
    
  /* spec styles for td will be used
    if (cProps.styleOptions) {
      for (i=1; i<cProps.styleOptions.length; i++)
      {
        var oOption = document.createElement("OPTION");
        td_prop.ccssclass.add(oOption);
        oOption.innerText = cProps.styleOptions[i].innerText;
        oOption.value = cProps.styleOptions[i].value;

        if (cProps.className) {
          td_prop.ccssclass.value = cProps.className;
        }
      }
    }
  */

    if (cProps.className) {
      document.getElementById('ccssclass').value = cProps.className;
      //css_class_changed();
    }
  }
  //SpawDialog.resizeDialogToContent();
}

SpawTableCellPropDialog.validateParams = function()
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

SpawTableCellPropDialog.okClick = function()
{
  // validate paramters
  if (SpawTableCellPropDialog.validateParams())    
  {
    var cprops = spawArguments;
    cprops.className = (document.getElementById('ccssclass').value != 'default')?document.getElementById('ccssclass').value:'';
    if (!cprops.className || cprops.className == '')
      cprops.removeAttribute("class"); 
    if (!document.getElementById('cwidth').disabled)
    {
      cprops.align = (document.getElementById('chalign').value)?(document.getElementById('chalign').value):'';
      if (!cprops.align || cprops.align == '')
        cprops.removeAttribute("align"); 
      cprops.vAlign = (document.getElementById('cvalign').value)?(document.getElementById('cvalign').value):'';
      if (!cprops.vAlign || cprops.vAlign == '')
        cprops.removeAttribute("vAlign"); 
      cprops.width = (document.getElementById('cwidth').value)?(document.getElementById('cwidth').value + document.getElementById('cwunits').value):'';
      if (!cprops.width || cprops.width == '')
        cprops.removeAttribute("width"); 
      cprops.height = (document.getElementById('cheight').value)?(document.getElementById('cheight').value + document.getElementById('chunits').value):'';
      if (!cprops.height || cprops.height == '')
        cprops.removeAttribute("height"); 
      cprops.bgColor = document.getElementById('cbgcolor').value;
      if (!cprops.bgColor || cprops.bgColor == '')
        cprops.removeAttribute("bgColor"); 
      cprops.style.whiteSpace = (document.getElementById('cnowrap').checked)?"nowrap":'';
      cprops.style.backgroundImage = 'url(' + document.getElementById('cbackground').value + ')';
      if (!document.getElementById('cbackground').value || document.getElementById('cbackground').value == '')
        cprops.style.backgroundImage = ''; 
    }
    if (spawArgs.callback)
    {
      eval('window.opener.'+spawArgs.callback + '(spawEditor, cprops, spawArgs.tbi, spawArgs.sender)');
    }
    window.close();
  }
}

SpawTableCellPropDialog.cancelClick = function()
{
  window.close();
}

SpawTableCellPropDialog.setSample = function()
{
  try {
    document.getElementById('color_sample').style.backgroundColor = document.getElementById('cbgcolor').value;
  }
  catch (excp) {}
}

SpawTableCellPropDialog.setHAlign = function(alignment)
{
  switch (alignment) {
    case "left":
      document.getElementById('ha_left').className = "buttonOn";
      document.getElementById('ha_center').className = "buttonOff";
      document.getElementById('ha_right').className = "buttonOff";
      break;
    case "center":
      document.getElementById('ha_left').className = "buttonOff";
      document.getElementById('ha_center').className = "buttonOn";
      document.getElementById('ha_right').className = "buttonOff";
      break;
    case "right":
      document.getElementById('ha_left').className = "buttonOff";
      document.getElementById('ha_center').className = "buttonOff";
      document.getElementById('ha_right').className = "buttonOn";
      break;
  }
  document.getElementById('chalign').value = alignment;
}

SpawTableCellPropDialog.setVAlign = function(alignment)
{
  switch (alignment) {
    case "middle":
      document.getElementById('ha_middle').className = "buttonOn";
      document.getElementById('ha_baseline').className = "buttonOff";
      document.getElementById('ha_bottom').className = "buttonOff";
      document.getElementById('ha_top').className = "buttonOff";
      break;
    case "baseline":
      document.getElementById('ha_middle').className = "buttonOff";
      document.getElementById('ha_baseline').className = "buttonOn";
      document.getElementById('ha_bottom').className = "buttonOff";
      document.getElementById('ha_top').className = "buttonOff";
      break;
    case "bottom":
      document.getElementById('ha_middle').className = "buttonOff";
      document.getElementById('ha_baseline').className = "buttonOff";
      document.getElementById('ha_bottom').className = "buttonOn";
      document.getElementById('ha_top').className = "buttonOff";
      break;
    case "top":
      document.getElementById('ha_middle').className = "buttonOff";
      document.getElementById('ha_baseline').className = "buttonOff";
      document.getElementById('ha_bottom').className = "buttonOff";
      document.getElementById('ha_top').className = "buttonOn";
      break;
  }
  document.getElementById('cvalign').value = alignment;
}

SpawTableCellPropDialog.cssClassChanged = function()
{
/*
	// disable/enable non-css class controls
  if (document.getElementById('ccssclass').value && document.getElementById('ccssclass').value!='default')
  {
    // disable all controls
    document.getElementById('cwidth').disabled = true;
    document.getElementById('cwunits').disabled = true;
    document.getElementById('cheight').disabled = true;
    document.getElementById('chunits').disabled = true;
    document.getElementById('cnowrap').disabled = true;
    document.getElementById('cbgcolor').disabled = true;
    document.getElementById('ha_left').src = '<?php echo $theme_path.'img/'?>tb_left_off.gif';
    document.getElementById('ha_left').disabled = true;
    document.getElementById('ha_center').src = '<?php echo $theme_path.'img/'?>tb_center_off.gif';
    document.getElementById('ha_center').disabled = true;
    document.getElementById('ha_right').src = '<?php echo $theme_path.'img/'?>tb_right_off.gif';
    document.getElementById('ha_right').disabled = true;
    document.getElementById('ha_top').src = '<?php echo $theme_path.'img/'?>tb_top_off.gif';
    document.getElementById('ha_top').disabled = true;
    document.getElementById('ha_middle').src = '<?php echo $theme_path.'img/'?>tb_middle_off.gif';
    document.getElementById('ha_middle').disabled = true;
    document.getElementById('ha_bottom').src = '<?php echo $theme_path.'img/'?>tb_bottom_off.gif';
    document.getElementById('ha_bottom').disabled = true;
    document.getElementById('ha_baseline').src = '<?php echo $theme_path.'img/'?>tb_baseline_off.gif';
    document.getElementById('ha_baseline').disabled = true;
    document.getElementById('ccolorpicker').src = '<?php echo $theme_path.'img/'?>tb_colorpicker_off.gif';
    document.getElementById('ccolorpicker').disabled = true;
    document.getElementById('cbackground').disabled = true;
    document.getElementById('cimg_picker').src = '<?php echo $theme_path.'img/'?>tb_image_insert_off.gif';
    document.getElementById('cimg_picker').disabled = true;
  }
  else
  {
    // enable all controls
    document.getElementById('cwidth').disabled = false;
    document.getElementById('cwunits').disabled = false;
    document.getElementById('cheight').disabled = false;
    document.getElementById('chunits').disabled = false;
    document.getElementById('cnowrap').disabled = false;
    document.getElementById('cbgcolor').disabled = false;
    document.getElementById('ha_left').src = '<?php echo $theme_path.'img/'?>tb_left.gif';
    document.getElementById('ha_left').disabled = false;
    document.getElementById('ha_center').src = '<?php echo $theme_path.'img/'?>tb_center.gif';
    document.getElementById('ha_center').disabled = false;
    document.getElementById('ha_right').src = '<?php echo $theme_path.'img/'?>tb_right.gif';
    document.getElementById('ha_right').disabled = false;
    document.getElementById('ha_top').src = '<?php echo $theme_path.'img/'?>tb_top.gif';
    document.getElementById('ha_top').disabled = false;
    document.getElementById('ha_middle').src = '<?php echo $theme_path.'img/'?>tb_middle.gif';
    document.getElementById('ha_middle').disabled = false;
    document.getElementById('ha_bottom').src = '<?php echo $theme_path.'img/'?>tb_bottom.gif';
    document.getElementById('ha_bottom').disabled = false;
    document.getElementById('ha_baseline').src = '<?php echo $theme_path.'img/'?>tb_baseline.gif';
    document.getElementById('ha_baseline').disabled = false;
    document.getElementById('ccolorpicker').src = '<?php echo $theme_path.'img/'?>tb_colorpicker.gif';
    document.getElementById('ccolorpicker').disabled = false;
    document.getElementById('cbackground').disabled = false;
    document.getElementById('cimg_picker').src = '<?php echo $theme_path.'img/'?>tb_image_insert.gif';
    document.getElementById('cimg_picker').disabled = false;
  }
  */
}

if (document.attachEvent)
{
  // ie
  window.attachEvent("onload", new Function("SpawTableCellPropDialog.init();"));
}
else
{
  window.addEventListener("load", new Function("SpawTableCellPropDialog.init();"), false);
}

