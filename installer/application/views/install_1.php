<!-- Step 1 -->
<h2>Step 1: Configure database</h2>
<p>Before we can check the database, we need to know where it is and what the login details are.</p>
<h3>Database Settings</h3>
<p>In order for the installer to check your MySQL server version it requires you to enter the hostname, username and password in the form below. These settings will also be used when installing the database.</p>
<form id="install_frm" method="post" action="">
	<p><label for="server">Server</label><input type="text" id="server" name="server" class="input_text" /></p>
	<p><label for="username">Username</label><input type="text" id="username" name="username" class="input_text" /></p>
	<p><label for="password">Password</label><input type="password" id="password" name="password" class="input_text" /></p>
	<p id="next_step"><input type="submit" id="submit" value="Step 2" /></p>
	<br class="clear" />
</form>
