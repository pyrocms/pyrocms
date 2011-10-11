<section class="title"></section>
<section class="item">
	
<div class="hidden">
	<div id="files-uploader">
		
		<div class="files-uploader-browser">
			<?php echo form_open_multipart('admin/files/upload'); ?>
			<label for="userfile" class="upload"><?php echo lang('files.upload_title'); ?></label>
				<?php echo form_upload('userfile', NULL, 'multiple="multiple"'); ?>
			<?php echo form_close(); ?>
			<ul id="files-uploader-queue" class="ui-corner-all"></ul>
		</div>
		
		<div class="buttons align-right padding-top">
			<a href="#" title="" class="button start-upload"><?php echo lang('files.upload_label'); ?></a>
			<a href="#" title="" class="button cancel-upload"><?php echo lang('buttons.cancel');?></a>
		</div>
		
	</div>
</div>

<div class="one_quarter" style="border-right: 1px solid #eeeeee;">
	<nav>
		<?php echo $template['partials']['nav']; ?>
	</nav>
</div>

<div class="two_third last">
	<?php echo $content; ?>
</div>

</section>

<script type="text/javascript">
(function($){
	// Store data for filesUpload plugin
	$('#files-uploader form').data('fileUpload', {
		lang : {
			start : 'Start',
			cancel : '<?php echo lang('global:delete'); ?>'
		}
	});
})(jQuery);
</script>
