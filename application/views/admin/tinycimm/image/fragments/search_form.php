<input type="text" id="search-input" value="search.." 
	onkeypress="TinyCIMMImage.doSearch(event, this);"
	onblur="this.value=this.value==''?'search..':this.value;" 
	onfocus="this.value=this.value=='search..'?'':this.value;" />
<img src="img/ajax-loader-sm.gif" id="search-loading" class="right hidden" />
&raquo; <?=$selected_folder_info['name'];?>
