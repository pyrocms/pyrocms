<input type="text" id="search-input" value="<?php echo strtolower(lang('tinycimm_image_search')); ?>.." 
	onkeypress="TinyCIMMImage.doSearch(event, this);"
	onblur="this.value=this.value==''?'<?php echo strtolower(lang('tinycimm_image_search')); ?>..':this.value;" 
	onfocus="this.value=this.value=='<?php echo strtolower(lang('tinycimm_image_search')); ?>..'?'':this.value;" />
<img src="img/ajax-loader-sm.gif" id="search-loading" class="right hidden" />
&raquo; <?php echo $selected_folder_info['name'];?>
