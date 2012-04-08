/*
 * $.cachedScript(url, options)
 * $.cookie(key, val, options)
 * 
 */

$.cachedScript=function(c,b){b=$.extend(b||{},{dataType:"script",cache:!0,url:c});if("object"===typeof c){var a=c.length;for(i=0;i<a;i++)b.url=c[i],jQuery.ajax(b)}return jQuery.ajax(b)}; $.cookie=function(c,b,a){if(1<arguments.length&&"[object Object]"!==""+b){a=jQuery.extend({},a);if(null===b||void 0===b)a.expires=-1;if("number"===typeof a.expires){var e=a.expires,d=a.expires=new Date;d.setDate(d.getDate()+e)}b=""+b;return document.cookie=[encodeURIComponent(c),"=",a.raw?b:encodeURIComponent(b),a.expires?"; expires="+a.expires.toUTCString():"",a.path?"; path="+a.path:"",a.domain?"; domain="+a.domain:"",a.secure?"; secure":""].join("")}a=b||{};d=a.raw?function(a){return a}:decodeURIComponent; return(e=RegExp("(?:^|; )"+encodeURIComponent(c)+"=([^;]*)").exec(document.cookie))?d(e[1]):null};