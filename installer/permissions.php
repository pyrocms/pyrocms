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
				<h2>Folder Permissions</h2>
				<p>The CHMOD values of the following folders must be changed to 777 (in some cases 775 works too).</p>
				<ul class="perm_list" id="perm_folders">
					<li>codeigniter/cache</li>
					<li>codeigniter/logs</li>
					<li>application/cache</li>
					<li>application/uploads</li>
					<li>application/assets/img/galleries</li>
					<li>application/assets/img/products</li>
					<li>application/assets/img/staff</li>
					<li>application/assets/img/suppliers</li>
				</ul>
				<h2>File Permissions</h2>
				<p>The CHMOD values of the following files must be changed to 777 (in some cases 775 works too). It's very important to change the file permissions of the database file <em>before</em> installing PyroCMS.</p>
				<ul class="perm_list" id="perm_files">
					<li>application/config/config.php</li>
					<li>application/config/database.php</li>
				</ul>
				<p id="go_back"><a href="index.php" title="Back to the dashboard">Dashboard</a></p>
			</div>
	</body>
</html>