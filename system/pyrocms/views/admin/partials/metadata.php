<script type="text/javascript">
    var APPPATH_URI = "<?php echo APPPATH_URI;?>";
    var BASE_URL = "<?php echo site_url();?>";
    var BASE_URI = "<?php echo BASE_URI;?>";
    var DEFAULT_TITLE = "<?php echo $this->settings->site_name; ?>";
</script>

<?php echo $template['metadata']; ?>
<script type="text/javascript">
	// Confirmation
	(function($) {
		$("a.confirm").live('click', function(){
			removemsg = $("em").attr("title");
			if (removemsg === undefined) {
				var answer = confirm('<?php echo lang('dialog_confirm'); ?>');
			} else {
				var answer = confirm(removemsg);
			}

			if (answer) {
				return true;
			}
			return false;
		});
	})(jQuery);
</script>
