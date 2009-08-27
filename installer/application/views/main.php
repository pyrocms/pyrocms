<!-- Welcome -->
<h2>Welcome</h2>
<p>Thank you for choosing PyroCMS! Installing PyroCMS is very easy, just follow the steps and messages on the screen. In case you have any problems installing the system don't worry, the installer will explain what you need to do.</p>
<h3>Database Settings</h3>
<p>In order for the installer to check your MySQL server version it requires you to enter the hostname, username and password in the form below. These settings will also be used when installing the database.</p>
<form id="install_frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<p><label for="server">Server</label><input type="text" id="server" name="server" class="input_text" /></p>
	<p><label for="username">Username</label><input type="text" id="username" name="username" class="input_text" /></p>
	<p><label for="password">Password</label><input type="password" id="password" name="password" class="input_text" /></p>
	<p id="next_step"><input type="submit" id="submit" value="Step 1" /></p>
	<div class="clear" />
</form>
