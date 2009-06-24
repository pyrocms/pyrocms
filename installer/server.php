<?php
require_once('includes/core_class.php');
$core 		= new Core();

// Get the versions
$php_ver 	= phpversion();
$mysql_ver 	= $core->mysql_version();
$GDArray 	= gd_info();
$gd_ver		= ereg_replace('[[:alpha:][:space:]()]+', '', $GDArray['GD Version']);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- Extinguisher 1.0, by Yorick Peterse : http://www.yorickpeterse.com -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- Stylesheets -->
		<link rel="stylesheet" href="css/reset.css" type="text/css" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		
		<title>Extinguisher 1.0 | Server info</title>
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
				<ul id="server_info">
					<li id="php_ver" class="<?php 	if($php_ver 	> '5')	{echo 'passed';}	else{echo 'failed';} ?>"><p><strong>PHP version</strong> : <?php echo $php_ver ?></p></li>	
					<li id="mysql_ver" class="<?php if($mysql_ver 	> '5')	{echo 'passed';}	else{echo 'failed';} ?>"><p><strong>MySQL version</strong> : <?php echo $mysql_ver; ?></p></li>
					<li id="gd_ver" class="<?php 	if($gd_ver 	> '2')	{echo 'passed';}	else{echo 'failed';} ?>"><p><strong>GD version</strong> : <?php echo $gd_ver; ?></p></li>
				</ul>
				<p id="go_back"><a href="index.php" title="Back to the dashboard">Dashboard</a></p>
			</div>
		</div>
	</body>
</html>