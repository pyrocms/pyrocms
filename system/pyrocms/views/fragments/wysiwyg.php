<!-- CKEditor -->
<?php echo js('ckeditor/ckeditor.js'); ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		CKEDITOR.replaceAll( 'wysiwyg-advanced', {
			customConfig : '<?php echo js_path('ckeditor/config_advanced.js'); ?>'
		});

		CKEDITOR.replaceAll( 'wysiwyg-simple', {
			customConfig : '<?php echo js_path('ckeditor/config_simple.js'); ?>'
		});
	});
</script>
<!-- /CKEditor -->
