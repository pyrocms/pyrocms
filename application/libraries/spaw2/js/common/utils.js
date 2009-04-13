// utility functions
function SpawUtils()
{
}
SpawUtils.ltrim = function(txt)
{
  var spacers = " \t\r\n";
  while (txt.length>0 && spacers.indexOf(txt.charAt(0)) != -1)
  {
    txt = txt.substr(1);
  }
  return(txt);
}
SpawUtils.rtrim = function(txt)
{
  var spacers = " \t\r\n";
  while (txt.length>0 && spacers.indexOf(txt.charAt(txt.length-1)) != -1)
  {
    txt = txt.substr(0,txt.length-1);
  }
  return(txt);
}
SpawUtils.trim = function(txt)
{
  return(SpawUtils.ltrim(SpawUtils.rtrim(txt)));
}
SpawUtils.trimLineBreaks = function(txt)
{
  var spacers = "\r\n";
  while (txt.length>0 && spacers.indexOf(txt.charAt(txt.length-1)) != -1)
  {
    txt = txt.substr(0,txt.length-1);
  }
  while (txt.length>0 && spacers.indexOf(txt.charAt(0)) != -1)
  {
    txt = txt.substr(1);
  }
  return(txt);  
}
SpawUtils.htmlEncode = function(txt)
{
  return txt.replace(/&/gm,'&amp;').replace(/</gm,'&lt;').replace(/>/gm, '&gt;').replace(/\u00A0/g, "&nbsp;");
}
SpawUtils.getPageOffsetLeft = function(obj)
{
    var elm = obj;
    x = obj.offsetLeft;
    while ((elm = elm.offsetParent) != null)
    {
      x += elm.offsetLeft;
    }
    return x;
}
SpawUtils.getPageOffsetTop = function(obj)
{
    var elm = obj;
    y = obj.offsetTop;
    while ((elm = elm.offsetParent) != null)
    {
      y += elm.offsetTop;
    }
    return y;
}
