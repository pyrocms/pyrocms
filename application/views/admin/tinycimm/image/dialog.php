<div class="tabs">
	<ul>
		<li id="browser_tab" class="current">
			<span>
				<a href="javascript:TinyCIMMImage.showBrowser();" onmousedown="return false;">
					<?php echo lang('tinycimm_image_tab_browse'); ?>
				</a>
			</span>
		</li>
		<li id="upload_tab">
			<span>
				<a href="javascript:TinyCIMMImage.showUploader();" onmousedown="return false;">
					<?php echo lang('tinycimm_image_tab_upload'); ?>
				</a>
			</span>
		</li>
		<li id="resize_tab">
			<span>
				<a href="javascript:TinyCIMMImage.loadresizer();" onmousedown="return false;">
					<?php echo lang('tinycimm_image_tab_resize'); ?>
				</a>
			</span>
		</li>
		<li id="manager_tab">
			<span>
				<a href="#" onmousedown="return false;">
					<?php echo lang('tinycimm_image_tab_manage'); ?>
				</a>
			</span>
		</li>
		<li id="info_tab">
			<span>
				<a id="info_tab_link" href="javascript:;" onmousedown="return false;" title="reload dialog">
					<img alt="reload" border="0" src="img/loader_st.gif" onclick="this.src='img/loader.gif';TinyCIMMImage.reload()" />
				</a>
			</span>
		</li>

	</ul>
</div>

<div id="image_wrapper_panel" class="panel_wrapper">

	<!-- BROWSER PANEL -->
	<div id="browser_panel" class="panel">
		<fieldset>
			<legend>
				<?php echo lang('tinycimm_image_file_browser'); ?>
			</legend>
			<div id="filebrowser">
				<span id="loading">loading</span>
			</div>
		</fieldset>
	</div>
	
	<!-- IMAGE RESIZER PANEL -->
	<div id="resize_panel" class="panel">
		<fieldset>
			<legend>
				
				<?php echo lang('ttinycimm_image_resizer'); ?>
			</legend>
			<div id="save_size">
				<input type="submit" class="button" value="Insert" onclick="TinyCIMMImage.insertResizeImage();this.value='Please wait..';" />
			</div>
			<div class="clear" style="height:3px">&nbsp;</div>
			<div id="resizer">
				<div id="image-slider"></div>
				<div id="image-info">
					<div id="image-info-dimensions"></div>
				</div>
			</div>
		</fieldset>
	</div>

	<!-- IMAGE UPLOAD PANEL -->
	<div id="upload_panel" class="panel">
		&nbsp;
	</div>

	<!-- MANAGE IMAGE PANEL -->
	<div id="manager_panel" class="panel">
		&nbsp;
	</div>

<!-- END PANELS -->
</div>

<div id="flash-msg-wrapper">
	<span id="flash-msg"></span>
</div>
