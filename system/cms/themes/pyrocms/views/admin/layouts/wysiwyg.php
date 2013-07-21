<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Always force latest IE rendering engine & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?php echo $template['title']; ?></title>

	<script type="text/javascript">
		var APPPATH_URI = "<?php echo APPPATH_URI;?>";
		var BASE_URL = "<?php echo rtrim(site_url(), '/').'/';?>";
		var SITE_URL = "<?php echo rtrim(site_url(), '/').'/';?>";
		var BASE_URI = "<?php echo BASE_URI;?>";
	</script>

	<?php echo $template['metadata']; ?>

	<script type="text/javascript">

		var CKEDITOR = window.parent.CKEDITOR;

		function windowClose()
		{
			CKEDITOR.dialog.getCurrent().hide();
		}

		function insertHTML(html)
		{
			window.parent.instance.insertHtml(html);
		}

		(function($)
		{
			$(window).ready(function() {
				window.parent.jQuery('.cke_dialog_footer').hide();
			});

			$(function()
			{
				// Fancybox modal window
				$('a[rel=modal], a.modal').livequery(function() {
					$(this).fancybox({
						overlayOpacity: 0.8,
						overlayColor: '#000',
						hideOnContentClick: false,
						onClosed: function(){ location.reload(); }
					});
				});

//
//				$('a[rel="modal-large"], a.modal-large').livequery(function() {
//					$(this).fancybox({
//						overlayOpacity: 0.8,
//						overlayColor: '#000',
//						hideOnContentClick: false,
//						frameWidth: 900,
//						frameHeight: 600
//					});
//				});
//				// End Fancybox modal window

			});
		})(jQuery);
	</script>

	<?php echo Asset::css('admin/basic_layout.css'); ?>
</head>
<body>
	<?php $this->load->view('admin/partials/notices') ?>
	<?php echo $template['body']; ?>
</body>
</html>	
