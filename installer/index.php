<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- Stylesheets -->
		<link rel="stylesheet" href="css/reset.css" type="text/css" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		
		<title>PyroCMS Installer</title>
	</head>
	<body>
		<!-- Main wrapper -->
		<div id="wrapper">
			<!-- The header -->
			<div id="header">
				<h1><img src="img/logo.png" alt="PyroCMS Installer 1.0" width="170" height="80" /></h1>	
			</div>
			<!-- The content -->
			<div id="content">
				<ul id="dashboard">
					<li id="server"><a href="server.php" title="Server information">Server information</a></li>
					<li id="permissions"><a href="permissions.php" title="Required File Permissions">File Permissions</a></li>
					<li id="install"><a href="install.php" title="Install PyroCMS">Install PyroCMS</a></li>	
					<li id="cache"><a href="cache.php" title="Empty cache" id="cache_link">Empty cache</a></li>
				</ul>
			</div>
		</div>
		<!-- jQuery -->
		<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
				$('#cache_link').click(function()
				{
					// Add the loading icon
					$('#cache p').append("<img src='img/loader.gif' alt='loader' id='loader' />");
					
					$.post("cache.php", function(data){
						// Remove the loader
						$('#loader').remove();
						
						// Show a message
						alert('The cache has been emptied!');
					});
					
					// Block browser behaviour
					return false;
				});
			});
		</script>
	</body>
</html>