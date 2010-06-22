<div id="toolbar-buttons">
	<div class="pyro-button" id="add-channel"><a href="#">Add Channel</a></div>
</div>
<p>This will be a list of channels.</p>
<div class="modal-boxes" style="display: none;">
	<div id="add-channel-form" class="slide-form">
		<?php echo form_open('admin/channels'); ?>
		<h2>New Channel</h2>
		<p>
			<label for="name">Name</label>
			<?php echo form_input('name'); ?>
		</p>
		<p>
			<label for="name">URL Slug</label>
			<?php echo form_input('slug'); ?>
		</p>
		<p>
			<?php echo form_submit('submit', 'Add Channel'); ?>
		</p>
	</div>
</div>
<script type="text/javascript">
(function($){
	
	$("#add-channel a").colorbox({width:"30%", inline:true, href:"#add-channel-form"});
	
})(jQuery);
</script>