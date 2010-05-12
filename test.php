<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
		<script type="text/javascript" src="/pyrocms/application/assets/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="/pyrocms/application/assets/js/jquery/jquery-ui.min.js"></script>
		<link href="/pyrocms/application/assets/css/jquery/jquery-ui.css" type="text/css" rel="stylesheet" />

		<script type="text/javascript">
			$(document).ready(function() {
				$("#dialog-confirm").dialog({
					autoOpen: false,
					modal: true
				});

				// Link confirm box
				$('a.confirm').click(function(e) {
					e.preventDefault();

					var target_url = $(this).attr("href");

					$("#dialog-confirm").dialog({
						resizable: false,
						height:140,
						modal: true,
						buttons: {
							'Yes': function() {
								$("#dialog-confirm").dialog('close');
								window.location.href = target_url;
							},
							'No': function() {
								$("#dialog-confirm").dialog('close');
							}
						}
					});
					$("#dialog-confirm").dialog('open');
				});
			});
		</script>
		<style type="text/css">
			body {font: 11px "Trebuchet MS", sans-serif;}

		</style>
    </head>
    <body>

		<div id="dialog-confirm" title="Are you sure?">
			<p>Are you sure you want to delete this item?</p>
		</div>
		<a href="#" class="confirm">Delete</a>
    </body>
</html>
