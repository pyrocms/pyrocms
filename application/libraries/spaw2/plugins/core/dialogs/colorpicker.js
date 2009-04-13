function SpawColorPicker()
{
}
SpawColorPicker.current_color = new SpawColor();
SpawColorPicker.setCurrentColor = function(color, sender)
{
  SpawColorPicker.current_color = color;

  document.getElementById("color_sample").style.background = SpawColorPicker.getCurrentColor().getHtmlColor();

  if (document.getElementById("bcbar0"))
    SpawColorPicker.updateBrightnessControl();
  else
    SpawColorPicker.drawBrightnessControl();
  SpawColorPicker.positionMarkers();  
  SpawColorPicker.fillFields(sender);  
}
SpawColorPicker.getCurrentColor = function()
{
  return SpawColorPicker.current_color;
}
SpawColorPicker.setCurrentColorFromHTML = function(color, sender)
{
  var c;
  if (color.toLowerCase().indexOf('rgb(') != -1)
  {
    c = SpawColor.parseRGB(color);
  }
  else
  {
    c = new SpawColor();
    c.setRGBFromHTML(color);
  }
  SpawColorPicker.setCurrentColor(c, sender);
}
SpawColorPicker.hsClick = function(event, sender)
{
  var x;
  var y;
  if (event.offsetX != undefined)
  {
    // ie, opera
    x = event.offsetX;
    y = event.offsetY;
  }
  else
  {
    // gecko
    var elm = sender;
    x = sender.offsetLeft;
    y = sender.offsetTop;
    while ((elm = elm.offsetParent) != null)
    {
      x += elm.offsetLeft;
      y += elm.offsetTop;
    }
    x = event.clientX - x;
    y = event.clientY - y;
  }
  if (x>=0 && x<=179 && y>=0 && y<=201) // ignore clicks on border
  {
    var cc = SpawColorPicker.getCurrentColor();
    cc.setHSB(x*2, 100-Math.floor(y/2), 100);
    SpawColorPicker.setCurrentColor(cc) ;
  }  
}
SpawColorPicker.bClick = function(b)
{
  var cc = SpawColorPicker.getCurrentColor();
  cc.setHSB(null, null, b);
  SpawColorPicker.setCurrentColor(cc) ;
}
SpawColorPicker.drawBrightnessControl = function()
{
  var bcontrol = document.createElement("table");
  var tb = document.createElement("tbody");
  bcontrol.style.width = "15px";
  //bcontrol.style.height = "202px";
  bcontrol.style.padding = "0px";
  bcontrol.style.border = "1px solid black";
  bcontrol.style.cursor = "crosshair";
  bcontrol.cellPadding = "0";
  bcontrol.cellSpacing = "0";
  bcontrol.padding = "0px";
  bcontrol.margin = "0px";
  
  var curcolor = new SpawColor();
  var cc = SpawColorPicker.getCurrentColor();
  curcolor.setHSB(cc.hue, cc.saturation, 100);
  for (var i=0; i<=100; i++)
  {
    var bcrow = document.createElement("tr");
    var bcbar = document.createElement("td");
    bcbar.id = 'bcbar'+i;
    bcbar.style.height = "2px";
    bcbar.style.background = curcolor.getHtmlColor();
    curcolor.setHSB(curcolor.hue, curcolor.saturation, 100-i);
    bcbar.style.padding = "0px";
    bcbar.innerHTML = '<img src="' + SpawEngine.spaw_dir + 'plugins/core/dialogs/img/spacer.gif" style="width: 1px; height: 1px;" />';
    bcbar.style.border = "0";
    bcbar.onclick = new Function("SpawColorPicker.bClick("+(100-i)+");");
    bcrow.appendChild(bcbar);
    tb.appendChild(bcrow);
  }
  bcontrol.appendChild(tb);

  document.getElementById("brightness_control_placeholder").innerHTML = ''; // removes space needed for gecko to alocate space for the cell
  document.getElementById("brightness_control_placeholder").appendChild(bcontrol);
}
SpawColorPicker.updateBrightnessControl = function()
{
  var curcolor = new SpawColor();
  var cc = SpawColorPicker.getCurrentColor();
  curcolor.setHSB(cc.hue, cc.saturation, 100);
  for (var i=0; i<=100; i++)
  {
    var bcbar = document.getElementById("bcbar"+i);
    bcbar.style.background = curcolor.getHtmlColor();
    curcolor.setHSB(curcolor.hue, curcolor.saturation, 100-i);
  }
}

SpawColorPicker.positionMarkers = function()
{
  var hsm = document.getElementById("hs_marker");
  var hsg = document.getElementById("hs_grid");
  var cc = SpawColorPicker.getCurrentColor();
  hsm.style.left = SpawUtils.getPageOffsetLeft(hsg) + Math.round(cc.hue/2) - 3;
  hsm.style.top = SpawUtils.getPageOffsetTop(hsg) + 202 - (cc.saturation*2) - 5;
  hsm.style.visibility = 'visible';
  
  var bc = document.getElementById('bcbar'+ (100 - cc.brightness));
  var bm = document.getElementById('b_marker');

  bm.style.left = SpawUtils.getPageOffsetLeft(bc) + bc.offsetWidth + 3;
  bm.style.top = SpawUtils.getPageOffsetTop(bc) - 5;
  bm.style.visibility = 'visible';
}
SpawColorPicker.fillFields = function(sender)
{
  var cc = SpawColorPicker.getCurrentColor();
  if (sender != document.getElementById('iHue')) 
    document.getElementById('iHue').value = cc.hue;  
  if (sender != document.getElementById('iSaturation')) 
    document.getElementById('iSaturation').value = cc.saturation;  
  if (sender != document.getElementById('iBrightness')) 
    document.getElementById('iBrightness').value = cc.brightness;  

  if (sender != document.getElementById('iRed')) 
    document.getElementById('iRed').value = cc.red;  
  if (sender != document.getElementById('iGreen')) 
    document.getElementById('iGreen').value = cc.green;  
  if (sender != document.getElementById('iBlue')) 
    document.getElementById('iBlue').value = cc.blue;  

  if (sender != document.getElementById('iHex')) 
    document.getElementById('iHex').value = cc.getHtmlColor();  
}
SpawColorPicker.inputKeyUp = function(event, itype, sender)
{
  var cc = SpawColorPicker.getCurrentColor();
  var sval = sender.value;
  var val = parseInt(sender.value);
  var cchanged = false;
  if (!isNaN(val) || itype == 'x')
  {
    switch(itype)
    {
      case 'h':
        if (val >=0 && val <=359)
        {
          cc.setHSB(val, null, null);
          cchanged = true;
        }
        break;
      case 's':
        if (val >=0 && val <=100)
        {
          cc.setHSB(null, val, null);
          cchanged = true;
        }
        break;
      case 'v':
        if (val >=0 && val <=100)
        {
          cc.setHSB(null, null, val);
          cchanged = true;
        }
        break;
      case 'r':
        if (val >=0 && val <=255)
        {
          cc.setRGB(val, null, null);
          //alert(cc.hue + ':' + cc.saturation + ':'+cc.brightness);
          cchanged = true;
        }
        break;
      case 'g':
        if (val >=0 && val <=255)
        {
          cc.setRGB(null, val, null);
          cchanged = true;
        }
        break;
      case 'b':
        if (val >=0 && val <=255)
        {
          cc.setRGB(null, null, val);
          cchanged = true;
        }
        break;
      case 'x':
//        if ((sval.length == 4 || sval.length == 7) && sval.charAt(0) == '#')
        {
          // rgb
          cc.setRGBFromHTML(sval);
          cchanged = true;
        }
        break;
    }
    if (cchanged)
      SpawColorPicker.setCurrentColor(cc, sender);
  }
}

SpawColorPicker.init = function()
{
  SpawColorPicker.setCurrentColor(spawArguments);
}

SpawColorPicker.okClick = function()
{
  if (spawArgs.callback)
  {
    eval('window.opener.'+spawArgs.callback + '(spawEditor, SpawColorPicker.getCurrentColor().getHtmlColor(), spawArgs.tbi, spawArgs.sender)');
  }
  window.close();
}

SpawColorPicker.cancelClick = function()
{
  window.close();
}


if (document.attachEvent)
{
  // ie
  window.attachEvent("onload", new Function("SpawColorPicker.init();"));
}
else
{
  window.addEventListener("load", new Function("SpawColorPicker.init();"), false);
}
