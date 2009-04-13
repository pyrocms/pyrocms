function SpawFm()
{
}

SpawFm.items = new Array();
SpawFm.view_mode = 0;
SpawFm.selectedItem = -1;
SpawFm.itemsLoaded = false;
SpawFm.allowModify = false;
SpawFm.allowModifySubdirectories = false;
SpawFm.txtFileSize = 'Size';
SpawFm.txtFileDate = 'Date modified';
SpawFm.txtNoFileSelected = 'No file selected!';
SpawFm.txtConfirmDelete = 'Are you sure you want to delete file [*file*]?';
SpawFm.txtRename = 'Enter the new name for "[*FILE*]":';
SpawFm.txtCreateDirectory = 'Enter the name of the new directory:';
SpawFm.txtConfirmDeleteDir = 'Are you sure you want to delete directory "[*DIR*]"?';
SpawFm.txtDownload = '[download file]';
SpawFm.previewImgObj = false;
SpawFm.pathSeparator = '|';
SpawFm.onloadSelectFile = false;

SpawFm.addFile = function(name, size, date, descr, icon, icon_big, thumb, other) {
  var item = new Array();
  item['type'] = 'F';
  item['name'] = name;
  item['size'] = size;
  item['date'] = date;
  item['descr'] = descr;
  item['icon'] = icon;
  item['icon_big'] = icon_big;
  item['thumb'] = thumb;
  item['other'] = other;
  SpawFm.items[SpawFm.items.length] = item;
}

SpawFm.addDirectory = function(name, size, date, descr, icon, icon_big, thumb, other) {
  var item = new Array();
  item['type'] = 'D';
  item['name'] = name;
  item['size'] = size;
  item['date'] = date;
  item['descr'] = descr;
  item['icon'] = icon;
  item['icon_big'] = icon_big;
  item['thumb'] = thumb;
  item['other'] = other;
  SpawFm.items[SpawFm.items.length] = item;
}

SpawFm.setViewMode = function(mode) {
  SpawFm.view_mode = mode;
}

// output list of files to target frame
SpawFm.listItems = function() {
  if (SpawFm.itemsLoaded)
    return false;
  var doc = SpawFm.getTargetFrame();
  
  // load stylesheets
  SpawFm.loadStylesheet(1, true);
  SpawFm.loadStylesheet(0, false);
  
  // populate items list
  for (var i=0; i<SpawFm.items.length; i++) {
    var item = SpawFm.items[i];
    var newBlock = doc.createElement('div');
    newBlock.className = 'fm_file';
    newBlock.setAttribute('id', 'item_'+i);
    // thumb
    var divBlock = doc.createElement('div');
    divBlock.className = 'fm_file_thumb';
    var img = doc.createElement('img');
    img.setAttribute('src', item['thumb']);
    divBlock.appendChild(img);
    newBlock.appendChild(divBlock);
    // icon big
    var divBlock = doc.createElement('div');
    divBlock.className = 'fm_file_icon_big';
    var img = doc.createElement('img');
    img.setAttribute('src', item['icon_big']);
    divBlock.appendChild(img);
    newBlock.appendChild(divBlock);
    // icon
    var divBlock = doc.createElement('div');
    divBlock.className = 'fm_file_icon';
    var img = doc.createElement('img');
    img.setAttribute('src', item['icon']);
    divBlock.appendChild(img);
    newBlock.appendChild(divBlock);
    // title
    var divTitle = doc.createElement('div');
    divTitle.className = 'fm_file_title';
    divBlock.setAttribute('id', 'file_title_'+i);
    var txt = doc.createTextNode(item['name']);
    divTitle.appendChild(txt);
    newBlock.appendChild(divTitle);
    // size, type, date - TO DO
    
    doc.body.appendChild(newBlock);
    
    // set events handlers
    SpawFm.addEventHandler(divTitle, 'click', 'SpawFm.onSelectItem('+i+')');
    SpawFm.addEventHandler(divBlock, 'click', 'SpawFm.onSelectItem('+i+')');
    if (item['type'] == 'F') {
      SpawFm.addEventHandler(divTitle, 'dblclick', 'SpawFm.okClick()');
      SpawFm.addEventHandler(divBlock, 'dblclick', 'SpawFm.okClick()');
    } else if (item['type'] == 'D') {
      SpawFm.addEventHandler(divTitle, 'dblclick', 'SpawFm.folderSelect()');
      SpawFm.addEventHandler(divBlock, 'dblclick', 'SpawFm.folderSelect()');
    }    
  }
  SpawFm.itemsLoaded = true;
}

SpawFm.loadStylesheet = function(mode, isdisabled) {
  var doc = SpawFm.getTargetFrame();
  var s_sheet = doc.createElement('link');
  s_sheet.setAttribute("rel","stylesheet");
  s_sheet.setAttribute("type","text/css");
  s_sheet.setAttribute('href', '../plugins/spawfm/lib/filelist'+mode+'.css');
  s_sheet.setAttribute('title', mode);
  s_sheet.disabled = isdisabled;
  var head = doc.getElementsByTagName("head");
  if (!head || head.length == 0) {
    head = doc.createElement("head");
    doc.childNodes[0].insertBefore(head, doc.body);
  } else {
    head = head[0];
  }
  head.appendChild(s_sheet);
}

// apply view to listed files
SpawFm.applyViewMode = function(mode) {
  SpawFm.setViewMode(mode);
  
  // get target frame
  var doc = SpawFm.getTargetFrame();
  
  // switch stylesheet
  for(i=0; (a = doc.getElementsByTagName('link')[i]); i++) {
    if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == mode) {
        a.disabled = false;
      }
    }
  }
}


SpawFm.getTargetFrame = function() {
  var trg = document.getElementById('dir_cont');
  if (trg && trg.contentDocument) {
    return trg.contentDocument;
  } else if (trg && document.frames('dir_cont').document) {
    return document.frames('dir_cont').document;
  }
  return false;
}

SpawFm.onSelectItem = function(itemno) {
  if (SpawFm.selectedItem != itemno) {
    SpawFm.unselectItem();
    SpawFm.selectedItem = itemno;
    SpawFm.selectItem(itemno, true);
    document.forms[0].ok_button.disabled = false;
    SpawFm.showItemDetails(itemno);
    if (SpawFm.items[itemno].type == 'F' && SpawFm.allowModify) {
      document.forms[0].delete_button.disabled = false;
      document.forms[0].rename_button.disabled = false;
    } else if (SpawFm.items[itemno].type == 'D' && SpawFm.allowModifySubdirectories) {
      document.forms[0].delete_button.disabled = false;
      document.forms[0].rename_button.disabled = false;
    }
  }
}

SpawFm.selectItem = function(itemno, select) {
  var trg = SpawFm.getTargetFrame();
  if (!trg) return false;
  var sitem = trg.getElementById('item_'+itemno);
  if (!sitem) return false;
  str = '';
  if (sitem.hasChildNodes()) {
    var ch = sitem.childNodes;
    for (i=0; i<ch.length; i++) {
      var node = ch[i];
      suffixpos = node.className.lastIndexOf('_sel');
      if (select && suffixpos == -1) {
        node.className = node.className + '_sel';
      } else if (!select && suffixpos > 0) {
        node.className = node.className.substr(0, suffixpos);
        SpawFm.selectedItem = -1;
      }
      str += node.className+'; ';
    }
  }
  if (select) {
    // stop bubbling event
    //SpawFm.stopBubble();
  }
}

SpawFm.unselectItem = function() {
  if (SpawFm.selectedItem >= 0) {
    // unselect file
    SpawFm.selectItem(SpawFm.selectedItem, false);
    document.forms[0].ok_button.disabled = true;
    document.forms[0].delete_button.disabled = true;
    document.forms[0].rename_button.disabled = true;
    SpawFm.hideItemDetails();
  }
}

SpawFm.showItemDetails = function(itemno) {
  var descrDiv = document.getElementById('file_details');
  if (!descrDiv) return false;
  SpawFm.hideItemDetails();
  
  var itemdata = SpawFm.items[itemno];
  if (!itemdata) return false;
  
  var base_href = (spawEditor && spawEditor.getConfigValue('base_href')) ? spawEditor.getConfigValue('base_href') : '';
  if (base_href.charAt(base_href.length-1) == '/') {
    // strip trailing slash
    base_href = base_href.substring(0, base_href.length-1);
  }
  
  // image preview
  var ext = itemdata['name'].substr(itemdata['name'].lastIndexOf('.')+1).toLowerCase();
  if (itemdata['type'] == 'F' && (ext == 'gif' || ext == 'jpg' || ext == 'png' || ext == 'jpeg')) {
    // prepare block for viewing
    var image = document.createElement('div');
    image.className = 'filedescr_img_preview';
    var img = document.createElement('img');
    img.setAttribute('src', '../spacer.gif');
    img.setAttribute('id', 'img_preview');
    img.setAttribute('alt', itemdata['name']);
    img.className = 'img_preview';
    image.appendChild(img);
    descrDiv.appendChild(image);
    
    // preview
    SpawFm.previewImgObj = new Image();
    SpawFm.previewImgObj.src = base_href+SpawFm.filePath+itemdata['name'];
    SpawFm.previewImage(SpawFm.previewImgObj);
  }
  
  // title
  var titlediv = document.createElement('div');
  titlediv.className = 'filedescr_title';
  var titletext = document.createTextNode(itemdata['name']);
  titlediv.appendChild(titletext);
  descrDiv.appendChild(titlediv);
  
  // descr
  var descr = document.createElement('div');
  descr.className = 'filedescr_br';
  var text = document.createTextNode(itemdata['descr']);
  descr.appendChild(text);
  descrDiv.appendChild(descr);
  
  // size
  if (itemdata['type'] == 'F') {
    var sizediv = document.createElement('div');
    sizediv.className = 'filedescr_common';
    var text = document.createTextNode(SpawFm.txtFileSize + ': ' + SpawFm.niceSize(itemdata['size']));
    sizediv.appendChild(text);
    descrDiv.appendChild(sizediv);
  }
  
  // date modified
  var datediv = document.createElement('div');
  datediv.className = 'filedescr_common';
  var text = document.createTextNode(SpawFm.txtFileDate + ': ' + itemdata['date']);
  datediv.appendChild(text);
  descrDiv.appendChild(datediv);
  
  // other info
  if (itemdata['other'].length) {
    var other = document.createElement('div');
    other.className = 'filedescr_common';
    var text = document.createTextNode(itemdata['other']);
    other.appendChild(text);
    descrDiv.appendChild(other);
  }
  
  // file download link
  if (itemdata['type'] == 'F') {
    var dl = document.createElement('div');
    var dl_a = document.createElement('a');
    dl_a.setAttribute('href', base_href+SpawFm.filePath+itemdata['name']);
    dl_a.setAttribute('target', '_blank');
    var dl_a_txt = document.createTextNode(SpawFm.txtDownload);
    dl_a.appendChild(dl_a_txt);
    dl.appendChild(dl_a);
    dl.className = 'filedescr_download';
    descrDiv.appendChild(dl);
  }
}

SpawFm.hideItemDetails = function() {
  var descrDiv = document.getElementById('file_details');
  if (!descrDiv) return false;
  var ch = descrDiv.childNodes;
  while (descrDiv.childNodes.length) {
    descrDiv.removeChild(descrDiv.firstChild);
  }
}

SpawFm.previewImage = function(img) {
  if (img == false) {
    return false;
  } else if (!img.complete) {
    setTimeout('SpawFm.previewImage(SpawFm.previewImgObj)', 100);
    return false;
  }
  var maxwidth = 168;
  var maxheight = 142;
  var w = SpawFm.previewImgObj.width;
  var h = SpawFm.previewImgObj.height;
  
  // calculate resize ratio
  var ratio = 1;
  if (w > maxwidth) ratio = w / maxwidth;
  if (h > maxheight && h/maxheight > ratio) ratio = h/maxheight;
  img.width = Math.round(w / ratio);
  img.height = Math.round(h / ratio);
  img.className = 'img_preview';
  // workaround for vertical image align
  var vspace = Math.round((maxheight - img.height)/2);
  img.style.marginTop = vspace;
  
  
  // show preview image
  var imgelm = document.getElementById('img_preview');
  if (!imgelm) return false;
  imgelm.parentNode.replaceChild(img, imgelm);
}

SpawFm.niceSize = function(bytes) {
  if (bytes / (1024*1024) > 1) {
    return Math.round((bytes/(1024*1024))*100)/100 + ' MB';
  } else if (bytes / 1024 > 1) {
    return Math.round((bytes/1024)*100)/100 + ' KB';
  } else {
    return bytes + ' B';
  }
}

SpawFm.init = function() {
  if (document.attachEvent) {
    document.frames('dir_cont').document.attachEvent("onkeydown",new Function("event","SpawFm.handleKeyPress(event);"));
  } else {
    document.getElementById('dir_cont').contentDocument.addEventListener("keydown",new Function("event","SpawFm.handleKeyPress(event);"), false);
  }
}

SpawFm.initIframe = function() {
  SpawFm.listItems();
  SpawFm.applyViewMode(SpawFm.view_mode);
  // select file on load
  if (SpawFm.onloadSelectFile != false) {
    SpawFm.onSelectItem(SpawFm.onloadSelectFile);
    SpawFm.scrollListIntoView();
  }
}

SpawFm.handleKeyPress = function(e) {
  if (!e.keyCode) return false;
  if (e.keyCode == 38 && SpawFm.selectedItem > 0) {
    SpawFm.cancelEvent(e);
    SpawFm.onSelectItem(SpawFm.selectedItem - 1);
    SpawFm.scrollListIntoView();
  } else if (e.keyCode == 40 && SpawFm.selectedItem < (SpawFm.items.length - 1)) {
    SpawFm.cancelEvent(e);
    SpawFm.onSelectItem(SpawFm.selectedItem + 1);
    SpawFm.scrollListIntoView();
  } else if (e.keyCode == 13) {
    SpawFm.scrollListIntoView();
    SpawFm.okClick();
    SpawFm.cancelEvent(e);
    return false;
  } else if (SpawFm.selectedItem >= 0 && e.keyCode == 46) {
    SpawFm.scrollListIntoView();
    SpawFm.deleteClick();
    SpawFm.cancelEvent(e);
  } else if (SpawFm.selectedItem >= 0 && e.keyCode == 33) {
    SpawFm.scrollListPageUp(e);
  } else if (SpawFm.selectedItem >= 0 && e.keyCode == 34) {
    SpawFm.scrollListPageDown(e);
  } else if (SpawFm.selectedItem >= 0 && e.keyCode == 36) {
    // home
    SpawFm.onSelectItem(0);
    SpawFm.scrollListIntoView();
    SpawFm.cancelEvent(e);
  } else if (SpawFm.selectedItem >= 0 && e.keyCode == 35) {
    // end
    SpawFm.onSelectItem(SpawFm.items.length-1);
    SpawFm.scrollListIntoView();
    SpawFm.cancelEvent(e);
  }
  /*
  else if (SpawFm.selectedItem >= 0) {
    alert(e.keyCode);
  }
  */
}

SpawFm.scrollListIntoView = function() {
  // check if there are items selected
  if (SpawFm.selectedItem == -1) 
    return false; 
  var doc = SpawFm.getTargetFrame();
  var frm = window.frames['dir_cont'];
  var selitem = doc.getElementById('item_'+SpawFm.selectedItem);
  var iframe_height = frm.document.body.clientHeight;
  var item_pos = selitem.offsetTop;
  var item_h = selitem.offsetHeight;
  var iframe_pos = frm.document.body.scrollTop;
  if (item_pos+item_h > iframe_pos+iframe_height) {
    // wind back
    frm.scrollTo(0, item_pos-iframe_height+item_h);
  } else if (item_pos < iframe_pos) {
    // wind forward
    frm.scrollTo(0, item_pos);
  }
}

SpawFm.scrollListPageUp = function(e) {
  // allow default action if no file selected
  if (SpawFm.selectedItem == -1 || !SpawFm.countItemsInPage()) 
    return;
  var doc = SpawFm.getTargetFrame();
  var selitem = doc.getElementById('item_'+SpawFm.selectedItem);
  var item_pos = selitem.offsetTop;
  var item_h = selitem.offsetHeight;
  var frm = window.frames['dir_cont'];
  var iframe_height = frm.document.body.clientHeight;
  var iframe_pos = frm.document.body.scrollTop;
  
  if (item_pos > iframe_pos) { // select first visible
    var sel = selitem;
    var sel_no = SpawFm.selectedItem;
    for (var i=SpawFm.selectedItem; i>=0; i--) {
      var item = doc.getElementById('item_' + i);
      if (item.offsetTop+item.offsetHeight >= iframe_pos) {
        sel = item;
        sel_no = i;
      } else {
        break;
      }
    }
    SpawFm.onSelectItem(sel_no);
    frm.scrollTo(0, sel.offsetTop);
  } else { // if first in page selected - go page up
    var sel = SpawFm.selectedItem - SpawFm.countItemsInPage();
    if (sel < 0)
      sel = 0;
    SpawFm.onSelectItem(sel);
    var item = doc.getElementById('item_' + sel);
    frm.scrollTo(0, item.offsetTop);
  }
  SpawFm.cancelEvent(e);
}
SpawFm.scrollListPageDown = function(e) {
  // allow default action if no file selected
  if (SpawFm.selectedItem == -1 || !SpawFm.countItemsInPage()) 
    return;
  var doc = SpawFm.getTargetFrame();
  var selitem = doc.getElementById('item_'+SpawFm.selectedItem);
  var item_pos = selitem.offsetTop;
  var item_h = selitem.offsetHeight;
  var frm = window.frames['dir_cont'];
  var iframe_height = frm.document.body.clientHeight;
  var iframe_pos = frm.document.body.scrollTop;
  
  if (item_pos+item_h < iframe_pos+iframe_height) { // select last visible
    var sel = selitem;
    var sel_no = SpawFm.selectedItem;
    for (var i=SpawFm.selectedItem; i<=(SpawFm.items.length-1); i++) {
      var item = doc.getElementById('item_' + i);
      if (item.offsetTop <= iframe_pos+iframe_height) {
        sel = item;
        sel_no = i;
      } else {
        break;
      }
    }
    SpawFm.onSelectItem(sel_no);
    frm.scrollTo(0, sel.offsetTop - iframe_height + item_h);
  } else { // go page down
    var sel = SpawFm.selectedItem + SpawFm.countItemsInPage();
    if (sel >= SpawFm.items.length)
      sel = SpawFm.items.length-1;
    SpawFm.onSelectItem(sel);
    var item = doc.getElementById('item_' + sel);
    item_pos = item.offsetTop;
    frm.scrollTo(0, item.offsetTop - iframe_height + item_h);
  }  
  
  SpawFm.cancelEvent(e);
}
// returns no of file items in page
SpawFm.countItemsInPage = function() {
  if (SpawFm.selectedItem == -1 || !SpawFm.items.length) return 0;
  var doc = SpawFm.getTargetFrame();
  var selitem = doc.getElementById('item_'+SpawFm.selectedItem);
  var item_pos = selitem.offsetTop;
  var item_h = selitem.offsetHeight;
  var frm = window.frames['dir_cont'];
  var iframe_height = frm.document.body.clientHeight;
  var iframe_pos = frm.document.body.scrollTop;
  return Math.floor(iframe_height / item_h);
}

if (document.attachEvent) {
  // ie
  window.attachEvent("onload", new Function("SpawFm.init();"));
} else {
  window.addEventListener("load", new Function("SpawFm.init();"), false);
}

SpawFm.addEventHandler = function(obj, event, funcname) {
  if (document.attachEvent) {
    // ie
    obj.attachEvent("on"+event, new Function(funcname));
  } else {
    obj.addEventListener(event, new Function(funcname), false);
  }
}

SpawFm.folderSelect = function() {
  var currpath = document.forms[0].dir.options[document.forms[0].dir.selectedIndex].value;
  if (currpath.indexOf(spawEditor.getConfigValue('spawfm_path_separator')) >= 0) {
    var newpath = currpath + SpawFm.items[SpawFm.selectedItem]['name'] + '/';
  } else {
    var newpath = currpath + spawEditor.getConfigValue('spawfm_path_separator') + SpawFm.items[SpawFm.selectedItem]['name'] + '/';
  }
  document.forms[0].dir.options[document.forms[0].dir.options.length] = new Option(
    SpawFm.items[SpawFm.selectedItem]['name'], newpath, false, true
  );
  document.forms[0].submit();
}

SpawFm.okClick = function() {
  if (!SpawFm.items.length || SpawFm.selectedItem == -1 || !SpawFm.items[SpawFm.selectedItem]) {
    alert(SpawFm.txtNoFileSelected);
  } else {
    // add base_href if defined
    var base_href = spawEditor.getConfigValue('base_href');
    if (!base_href) {
      base_href = '';
    } else if (base_href.charAt(base_href.length-1) == '/') {
      // strip trailing slash
      base_href = base_href.substring(0, base_href.length-1);
    }
    if (spawArgs.callback) {
      eval('window.opener.'+spawArgs.callback + '(spawEditor, base_href+SpawFm.filePath+SpawFm.items[SpawFm.selectedItem][\'name\'], spawArgs.tbi, spawArgs.sender)');
    }
    window.close();
  }
}
SpawFm.cancelClick = function() {
  window.close();
}

SpawFm.deleteClick = function() {
  if ((SpawFm.items[SpawFm.selectedItem]['type'] == 'F' && confirm(SpawFm.txtConfirmDelete.replace('[*file*]', SpawFm.items[SpawFm.selectedItem]['name']))) ||
      (SpawFm.items[SpawFm.selectedItem]['type'] == 'D' && confirm(SpawFm.txtConfirmDeleteDir.replace('[*DIR*]', SpawFm.items[SpawFm.selectedItem]['name'])))) {
    document.forms[0].delete_file.value = SpawFm.items[SpawFm.selectedItem]['name'];
    document.forms[0].submit();
  }
}

SpawFm.renameClick = function() {
  var oldname = SpawFm.items[SpawFm.selectedItem]['name'];
  var newname = prompt(SpawFm.txtRename.replace('[*FILE*]', oldname), oldname);
  if (newname && newname != oldname) {
    document.forms[0].rename_from.value = SpawFm.items[SpawFm.selectedItem]['name'];
    document.forms[0].rename_to.value = newname;
    document.forms[0].submit();
  }
}

SpawFm.createDirectoryClick = function() {
  var dirname = prompt(SpawFm.txtCreateDirectory);
  if (dirname) {
    document.forms[0].new_folder.value = dirname;
    document.forms[0].submit();
  }
}

SpawFm.goUpClick = function() {
  var sel = document.forms[0].dir.selectedIndex;
  if (sel && sel > 0) {
    sel--;
    document.forms[0].dir.options[sel].selected = true;
    document.forms[0].submit();
  }
}

SpawFm.cancelEvent = function(e) {
	if (!e) var e = window.event;
	e.cancelBubble = true;
	e.returnValue = false;
	if (e.stopPropagation) e.stopPropagation();
	if (e.preventDefault) e.preventDefault();
}
