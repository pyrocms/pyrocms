<?php
// Only load the classes in case the user submitted the form
if($_POST) {
	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');
	
	$core 		= new Core();
	$database 	= new Database();
	
	
	// Validate the post data
	if($core->validate_post($_POST) == true)
	{		
		// First create the database
		if($database->create_database($_POST) == false)
		{
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		}
		
		// Fill the database with the default data
		if($database->create_tables($_POST) == false)
		{
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		}
		
		// Check to see if the user wants to insert dummy data
		if(isset($_POST['dummy_data']))
		{
			if($database->dummy_data($_POST) == false)
			{
				$message = $core->show_message('error',"The dummy data could not be inserted, please verify your settings.");
			}
		}
		
		// Write the config file
		if($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod PyroCMS's database.php file to 777");
		}
		
		// Check to see if any errors popped up
		if(!isset($message)) {
			// Display the message
			$message = $core->show_message('success','PyroCMS has been installed succesfully');
		}		
	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username and database name are required.');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- PyroCMS Installer 1.0, by Yorick Peterse : http://www.yorickpeterse.com -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- Stylesheets -->
		<link rel="stylesheet" href="css/reset.css" type="text/css" />
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		
		<title>PyroCMS Installer 1.0 | Installer</title>
	</head>
	<body>
		<!-- Main wrapper -->
		<div id="wrapper">
			<!-- The header -->
			<div id="header">
				<h1><img src="img/logo.png" alt="PyroCMS Installer 1.0" width="170" height="80" /></h1>	
			</div>
			<?php if(isset($message)) {echo $message;}?>
			
			<!-- The content -->
			<div id="content">
				<form id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h2>Database settings</h2>
					<p><label for="hostname">Host</label><input type="text" id="hostname" class="input_text" name="hostname" /></p>
					<p><label for="username">Username</label><input type="text" id="username" class="input_text" name="username" /></p>
					<p><label for="password">Password</label><input type="password" id="password" class="input_text" name="password" /></p>
					<p><label for="database">Database</label><input type="text" id="database" class="input_text" name="database" /></p>
					<h2>Optional settings</h2>
					<p><label for="dummy_data" id="dummy_label">Install dummy data</label><input type="checkbox" name="dummy_data" value="Install dummy data" id="dummy_data" /></p>
					<p id="go_back"><span id="link_align"><a href="index.php" title="Back to the dashboard">Dashboard</a></span><span id="button_align"><input type="submit" value="Install" id="submit" /><input type="reset" value="Clear fields" id="reset" /></span></p>
					<div class="clear"></div>
				</form>
				
				
			</div>
		</div>
		<!-- jQuery -->
		<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
				// Fade the messages
				$('.message').hide();
				$('.message').fadeIn('slow');
				// Hide any messages when the user clicks the clear fields button
				$('#reset').click(function() {
					$('.message').fadeOut('slow');
				});
			});
		</script>		
	</body>
</html>