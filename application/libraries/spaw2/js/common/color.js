// color class
function SpawColor()
{
}
SpawColor.prototype.hue = 359;
SpawColor.prototype.saturation = 100;
SpawColor.prototype.brightness = 100;
SpawColor.prototype.red = 255;
SpawColor.prototype.green = 255;
SpawColor.prototype.blue = 255;

SpawColor.prototype.setHSB = function(h, s, b)
{
  if (h != null)
    this.hue = h;
  if (s != null)
    this.saturation = s;
  if (b != null)
    this.brightness = b;
  this.updateRGBFromHSB();
}
SpawColor.prototype.setRGB = function(r, g, b)
{
  if (r != null)
    this.red = r;
  if (g != null)
    this.green = g;
  if (b != null)
    this.blue = b;
  this.updateHSBFromRGB();
}
SpawColor.prototype.setRGBFromHTML = function(val)
{
  var sval = val;
  if ((sval.length != 4 && sval.length != 7) || sval.charAt(0) != '#') 
  {
    // try named colors
    sval = this.getHTMLColorFromKeyword(sval);
  }

  if (sval != null && (sval.length == 4 || sval.length == 7) && sval.charAt(0) == '#')
  { 
    if (sval.length == 4)
    {
      this.red = this.hex2dec(sval.charAt(1)+sval.charAt(1));
      this.green = this.hex2dec(sval.charAt(2)+sval.charAt(2));
      this.blue = this.hex2dec(sval.charAt(3)+sval.charAt(3));
    }
    else
    {
      this.red = this.hex2dec(sval.substring(1,3));
      this.green = this.hex2dec(sval.substring(3,5));
      this.blue = this.hex2dec(sval.substring(5,7));
    }
    this.updateHSBFromRGB();
  }
}
SpawColor.prototype.getHTMLColorFromKeyword = function(kwd)
{
  var named_colors = new Array();
  named_colors['aliceblue']='#f0f8ff';
  named_colors['antiquewhite']='#faebd7';
  named_colors['aqua']='#00ffff';
  named_colors['aquamarine']='#7fffd4';
  named_colors['azure']='#f0ffff';
  named_colors['beige']='#f5f5dc';
  named_colors['bisque']='#ffe4c4';
  named_colors['black']='#000000';
  named_colors['blanchedalmond']='#ffebcd';
  named_colors['blue']='#0000ff';
  named_colors['blueviolet']='#8a2be2';
  named_colors['brown']='#a52a2a';
  named_colors['burlywood']='#deb887';
  named_colors['cadetblue']='#5f9ea0';
  named_colors['chartreuse']='#7fff00';
  named_colors['chocolate']='#d2691e';
  named_colors['coral']='#ff7f50';
  named_colors['cornflowerblue']='#6495ed';
  named_colors['cornsilk']='#fff8dc';
  named_colors['crimson']='#dc143c';
  named_colors['cyan']='#00ffff';
  named_colors['darkblue']='#00008b';
  named_colors['darkcyan']='#008b8b';
  named_colors['darkgoldenrod']='#b8860b';
  named_colors['darkgray']='#a9a9a9';
  named_colors['darkgreen']='#006400';
  named_colors['darkkhaki']='#bdb76b';
  named_colors['darkmagenta']='#8b008b';
  named_colors['darkolivegreen']='#556b2f';
  named_colors['darkorange']='#ff8c00';
  named_colors['darkorchid']='#9932cc';
  named_colors['darkred']='#8b0000';
  named_colors['darksalmon']='#e9967a';
  named_colors['darkseagreen']='#8fbc8f';
  named_colors['darkslateblue']='#483d8b';
  named_colors['darkslategray']='#2f4f4f';
  named_colors['darkturquoise']='#00ced1';
  named_colors['darkviolet']='#9400d3';
  named_colors['deeppink']='#ff1493';
  named_colors['deepskyblue']='#00bfff';
  named_colors['dimgray']='#696969';
  named_colors['dodgerblue']='#1e90ff';
  named_colors['firebrick']='#b22222';
  named_colors['floralwhite']='#fffaf0';
  named_colors['forestgreen']='#228b22';
  named_colors['fuchsia']='#ff00ff';
  named_colors['gainsboro']='#dcdcdc';
  named_colors['ghostwhite']='#f8f8ff';
  named_colors['gold']='#ffd700';
  named_colors['goldenrod']='#daa520';
  named_colors['gray']='#808080';
  named_colors['green']='#008000';
  named_colors['greenyellow']='#adff2f';
  named_colors['honeydew']='#f0fff0';
  named_colors['hotpink']='#ff69b4';
  named_colors['indianred']='#cd5c5c';
  named_colors['indigo']='#4b0082';
  named_colors['ivory']='#fffff0';
  named_colors['khaki']='#f0e68c';
  named_colors['lavender']='#e6e6fa';
  named_colors['lavenderblush']='#fff0f5';
  named_colors['lawngreen']='#7cfc00';
  named_colors['lemonchiffon']='#fffacd';
  named_colors['lightblue']='#add8e6';
  named_colors['lightcoral']='#f08080';
  named_colors['lightcyan']='#e0ffff';
  named_colors['lightgoldenrodyellow']='#fafad2';
  named_colors['lightgreen']='#90ee90';
  named_colors['lightgrey']='#d3d3d3';
  named_colors['lightpink']='#ffb6c1';
  named_colors['lightsalmon']='#ffa07a';
  named_colors['lightseagreen']='#20b2aa';
  named_colors['lightskyblue']='#87cefa';
  named_colors['lightslategray']='#778899';
  named_colors['lightsteelblue']='#b0c4de';
  named_colors['lightyellow']='#ffffe0';
  named_colors['lime']='#00ff00';
  named_colors['limegreen']='#32cd32';
  named_colors['linen']='#faf0e6';
  named_colors['magenta']='#ff00ff';
  named_colors['maroon']='#800000';
  named_colors['mediumaquamarine']='#66cdaa';
  named_colors['mediumblue']='#0000cd';
  named_colors['mediumorchid']='#ba55d3';
  named_colors['mediumpurple']='#9370db';
  named_colors['mediumseagreen']='#3cb371';
  named_colors['mediumslateblue']='#7b68ee';
  named_colors['mediumspringgreen']='#00fa9a';
  named_colors['mediumturquoise']='#48d1cc';
  named_colors['mediumvioletred']='#c71585';
  named_colors['midnightblue']='#191970';
  named_colors['mintcream']='#f5fffa';
  named_colors['mistyrose']='#ffe4e1';
  named_colors['moccasin']='#ffe4b5';
  named_colors['navajowhite']='#ffdead';
  named_colors['navy']='#000080';
  named_colors['oldlace']='#fdf5e6';
  named_colors['olive']='#808000';
  named_colors['olivedrab']='#6b8e23';
  named_colors['orange']='#ffa500';
  named_colors['orangered']='#ff4500';
  named_colors['orchid']='#da70d6';
  named_colors['palegoldenrod']='#eee8aa';
  named_colors['palegreen']='#98fb98';
  named_colors['paleturquoise']='#afeeee';
  named_colors['palevioletred']='#db7093';
  named_colors['papayawhip']='#ffefd5';
  named_colors['peachpuff']='#ffdab9';
  named_colors['peru']='#cd853f';
  named_colors['pink']='#ffc0cb';
  named_colors['plum']='#dda0dd';
  named_colors['powderblue']='#b0e0e6';
  named_colors['purple']='#800080';
  named_colors['red']='#ff0000';
  named_colors['rosybrown']='#bc8f8f';
  named_colors['royalblue']='#4169e1';
  named_colors['saddlebrown']='#8b4513';
  named_colors['salmon']='#fa8072';
  named_colors['sandybrown']='#f4a460';
  named_colors['seagreen']='#2e8b57';
  named_colors['seashell']='#fff5ee';
  named_colors['sienna']='#a0522d';
  named_colors['silver']='#c0c0c0';
  named_colors['skyblue']='#87ceeb';
  named_colors['slateblue']='#6a5acd';
  named_colors['slategray']='#708090';
  named_colors['snow']='#fffafa';
  named_colors['springgreen']='#00ff7f';
  named_colors['steelblue']='#4682b4';
  named_colors['tan']='#d2b48c';
  named_colors['teal']='#008080';
  named_colors['thistle']='#d8bfd8';
  named_colors['tomato']='#ff6347';
  named_colors['turquoise']='#40e0d0';
  named_colors['violet']='#ee82ee';
  named_colors['wheat']='#f5deb3';
  named_colors['white']='#ffffff';
  named_colors['whitesmoke']='#f5f5f5';
  named_colors['yellow']='#ffff00';
  named_colors['yellowgreen']=['#9acd32'];
  if (named_colors[kwd.toLowerCase()] != null)
    return named_colors[kwd.toLowerCase()];
  else
    return null;
}
SpawColor.parseRGB = function(rgbstr)
{
  var nc = new SpawColor();
  var r, g, b;
  if (!isNaN(parseInt(rgbstr)))
  {
    // number representation
    var n = parseInt(rgbstr);
    r = n%256;
    n = Math.floor(n/256);
    g = n%256;
    n = Math.floor(n/256);
    b = n%256;
    nc.setRGB(r, g, b);
  }
  else if (rgbstr.toLowerCase().indexOf('rgb(') == 0)
  {
    r = parseInt(rgbstr.substring(4, rgbstr.indexOf(',')));
    g = parseInt(rgbstr.substring(rgbstr.indexOf(',')+1, rgbstr.lastIndexOf(',')));
    b = parseInt(rgbstr.substring(rgbstr.lastIndexOf(',')+1, rgbstr.indexOf(')')));
    nc.setRGB(r, g, b);
  }
  else
  {
    nc.setRGBFromHTML(rgbstr);
  }
  return nc;
}

SpawColor.prototype.updateRGBFromHSB = function()
{
  var r,g,b;
  var fS = this.saturation/100;
  var fB = this.brightness/100;
  var hi = Math.floor(this.hue / 60) % 6;
  var f = this.hue / 60 - hi;
  var p = fB * (1 - fS);
  var q = fB * (1 - f * fS);
  var t = fB * (1 - (1 - f) * fS);
  switch (hi)
  {
  case 0:
    r = Math.round(fB * 255);
    g = Math.round(t * 255);
    b = Math.round(p * 255);
    break;
  case 1:
    r = Math.round(q * 255);
    g = Math.round(fB * 255);
    b = Math.round(p * 255);
    break;
  case 2:
    r = Math.round(p * 255);
    g = Math.round(fB * 255);
    b = Math.round(t * 255);
    break;
  case 3:
    r = Math.round(p * 255);
    g = Math.round(q * 255);
    b = Math.round(fB * 255);
    break;
  case 4:
    r = Math.round(t * 255);
    g = Math.round(p * 255);
    b = Math.round(fB * 255);
    break;
  case 5:
    r = Math.round(fB * 255);
    g = Math.round(p * 255);
    b = Math.round(q * 255);
    break;
  }
  this.red = r;
  this.green = g;
  this.blue = b;
}
SpawColor.prototype.updateHSBFromRGB = function()
{
  var h,s;
  var r = this.red/255;
  var g = this.green/255;
  var b = this.blue/255;
  var mx = Math.max(this.red, this.green, this.blue)/255;
  var mn = Math.min(this.red, this.green, this.blue)/255;
  if (mx == mn)
  {
    h = 0;
  }
  else if (mx == r && g>=b)
  {
    h = 60*(g - b)/(mx - mn);
  }
  else if (mx == r && g<b)
  {
    h = 60*(g - b)/(mx - mn) + 360;
  }
  else if (mx == g)
  {
    h = 60*(b - r)/(mx - mn) + 120;
  }
  else if (mx == b)
  {
    h = 60*(r - g)/(mx - mn) + 240;
  }
  
  if (mx == 0)
    s = 0;
  else
    s = Math.round((1 - mn/mx));
    
  this.hue = Math.round(h);
  this.saturation = Math.round(s*100);
  this.brightness = Math.round(mx*100);
}
SpawColor.prototype.dec2hex = function(dec)
{
  var result = '';
  var num = dec;
  while (num/16 >= 1 || num%16 > 0)
  {
    var ch = num%16;
    if (ch>=10)
    {
      switch(ch)
      {
        case 10:
          ch = 'a';
          break;
        case 11:
          ch = 'b';
          break;
        case 12:
          ch = 'c';
          break;
        case 13:
          ch = 'd';
          break;
        case 14:
          ch = 'e';
          break;
        case 15:
          ch = 'f';
          break;
      }
    }
    result = '' + ch + result;
    num = Math.floor(num/16);
  }
  return result;
}
SpawColor.prototype.hex2dec = function(hex)
{
  var l = hex.length;
  var p = 0;
  var result = 0;
  for(var i = l-1; i>=0; i--)
  {
    p = l-i-1;
    var c = hex.charAt(i);
    if (!isNaN(parseInt(c)))
    {
      result += parseInt(c)*Math.pow(16, p); 
    }
    else
    {
      switch(c.toLowerCase())
      {
        case 'a':
          result += 10*Math.pow(16, p);
          break; 
        case 'b':
          result += 11*Math.pow(16, p);
          break; 
        case 'c':
          result += 12*Math.pow(16, p);
          break; 
        case 'd':
          result += 13*Math.pow(16, p);
          break; 
        case 'e':
          result += 14*Math.pow(16, p);
          break; 
        case 'f':
          result += 15*Math.pow(16, p);
          break; 
      }
    }
  }
  return result; 
}
SpawColor.prototype.addZeroes = function(source, num)
{
  var result = source;
  while(result.length<num)
  {
    result = '0' + result;
  }
  return result;
}
SpawColor.prototype.getHtmlColor = function()
{
  return result = '#' + this.addZeroes(this.dec2hex(this.red),2) + this.addZeroes(this.dec2hex(this.green),2) + this.addZeroes(this.dec2hex(this.blue),2);  
}
