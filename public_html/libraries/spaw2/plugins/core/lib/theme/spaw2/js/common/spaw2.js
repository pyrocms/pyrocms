// theme methods
function SpawThemespaw2()
{
}
SpawThemespaw2.prefix = "spaw2";

// preload button images
SpawThemespaw2.preloadImages = function(tbi)
{
  tbi.image = new Image(); 
  tbi.image.src = tbi.base_image_url;
  tbi.image_over = new Image(); 
  tbi.image_over.src = tbi.base_image_url.substring(0, tbi.base_image_url.length-4) + '_over.gif';
  tbi.image_down = new Image(); 
  tbi.image_down.src = tbi.base_image_url.substring(0, tbi.base_image_url.length-4) + '_down.gif';
  tbi.image_off = new Image(); 
  tbi.image_off.src = tbi.base_image_url.substring(0, tbi.base_image_url.length-4) + '_off.gif';
}

// button events
SpawThemespaw2.buttonOver = function(tbi, sender)
{
  if (!sender.disabled && sender.disabled != "true" && !tbi.is_pushed) // for gecko
  {
    sender.src = tbi.image_over.src;
  } 
  tbi.editor.getTargetEditor().showStatus(sender.title);
}
SpawThemespaw2.buttonOut = function(tbi, sender)
{
  if (!sender.disabled && sender.disabled != "true") // for gecko
  {
    if (!tbi.is_pushed)
      sender.src = tbi.image.src;
    else
      sender.src = tbi.image_down.src;
    
    tbi.editor.getTargetEditor().showStatus('');
  } 
}
SpawThemespaw2.buttonDown = function(tbi, sender)
{
  if (!sender.disabled && sender.disabled != "true") // for gecko
    sender.src = tbi.image_down.src; 
}
SpawThemespaw2.buttonUp = function(tbi, sender)
{
  if (!sender.disabled && sender.disabled != "true") // for gecko
    sender.src = tbi.image.src; 
}
SpawThemespaw2.buttonOff = function(tbi, sender)
{
  sender.src = tbi.image_off.src; 
}

// dropdown events
SpawThemespaw2.dropdownOver = function(tbi, sender)
{
}
SpawThemespaw2.dropdownOut = function(tbi, sender)
{
}
SpawThemespaw2.dropdownDown = function(tbi, sender)
{
}
SpawThemespaw2.dropdownUp = function(tbi, sender)
{
}
SpawThemespaw2.dropdownOff = function(tbi, sender)
{
}


// returns base part of button image file name
SpawThemespaw2.getBaseButtonImageName = function(tbi, sender)
{
  var imgsrc = sender.src;
  if (imgsrc.lastIndexOf(tbi.name)>-1)
  {
    imgsrc = imgsrc.substring(0, imgsrc.lastIndexOf(tbi.name) + tbi.name.length);
  }
  else
  {
    // default plugin image
    imgsrc = imgsrc.substring(0, imgsrc.lastIndexOf("_plugin") + "_plugin".length);
  }
  return imgsrc;
}
