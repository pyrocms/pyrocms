/* var obj = $("#formid").pyroForm2Obj() */
jQuery.fn.pyroForm2Obj = function(obj) {
  obj = obj || {};

  /* convert form to json object */
  jQuery.each(jQuery(this).serializeArray(), function () {
    if (obj[this.name]) {
      if (!obj[this.name].push) {
        obj[this.name] = [obj[this.name]];
      }
      obj[this.name].push(this.value || '');
    } else {
      obj[this.name] = this.value || '';
    }
  });
  obj._post_selector = this.selector;
  obj._timestamp = Number(new Date());

  return obj;
};

/* $.pyroRedirect('/goto/here') */
jQuery.pyroRedirect = function(url) {
  window.location.replace(SITE_URL + url);
};

/* block ajax request
var rtn = $.pyroAjax(posturl,json payload,ajax method, responds type);
*/
jQuery.pyroAjax = function(posturl, payload, method, type) {
  posturl = SITE_URL + posturl;
  payload = payload || {};
  method = method || 'POST';
  type = type || 'json';

  payload._posturl = posturl;
  payload._type = type;
  payload._timestamp = Number(new Date());

  var rtnjson = {};
  jQuery.ajax({
    cache: false,
    type: method,
    async: false,
    timeout: 5000, /* 5 seconds should be enough */
    url: posturl,
    dataType: type,
    data: payload,
    success: function (ajaxjson) {
      rtnjson = ajaxjson;
    },
    error: function(jqXHR, textStatus, errorThrown) {
		/* this is all browser safe because of the backend plugins.js file */
		console.log(jqXHR,textStatus,errorThrown);
    }
  });

  return rtnjson;
};

/* test if a element is on the page var bol = $("#id").exists(); */
jQuery.fn.exists = function() {
  return jQuery(this).length > 0;
};

/* create a wrapper for $.postJSON(); - uses post instead of get as in $.getJSON(); */
jQuery.extend({
  postJSON: function( url, data, callback) {
    return jQuery.post(url, data, callback, 'json');
  }
});

/* change the form action $("#formid").pyroFormAction("/send/it/here.php") */
jQuery.fn.pyroFormAction = function (url) {
  return this.each(function () {
    jQuery(this).attr('action', url);
  });
};

/* add or change a hidden form value $("#formid").pyroFormHidden("name","value") */
jQuery.fn.pyroFormHidden = function (name, value) {
  if (!name || !value) return;

  return this.each(function () {
    if (jQuery('[name="' + name + '"]').length > 0) {
      jQuery('[name="' + name + '"]').attr('value', value);
    } else {
      jQuery('<input />').attr('type', 'hidden').attr('id', name).attr('name', name).val(value).appendTo(this);
    }
  });
};