<input type="text" onkeypress="TinyCIMMImage.doSearch(event, this);" id="search-input" onblur="this.value=this.value==''?'search..':this.value;" onfocus="this.value=this.value=='search..'?'':this.value;" value="search.." />
<img src="img/ajax-loader-sm.gif" id="search-loading" style="margin:2px 2px 0px 0px;" class="right hidden" />
&raquo; <?=$selected_folder_info['name'];?>
