<h2>Step 1: Configure Database and Server</h2>

<p>Before we can check the database, we need to know where it is and what the login details are.</p>

<h3>Database Settings</h3>

<p>
	In order for the installer to check your MySQL server version it requires you to enter the hostname, username and password in the form below.
	These settings will also be used when installing the database.
</p>

<form id="install_frm" method="post" action="">
	<p><label for="server">Server</label><?php echo form_input('server', $this->session->userdata('server')); ?></p>
	<p><label for="username">Username</label><?php echo form_input('username', $this->session->userdata('username')); ?></p>
	<p><label for="password">Password</label><?php echo form_password('password', $this->session->userdata('password')); ?></p>
	<p><label for="port">Port</label><?php echo form_input('port', $port, 'class="input-text"'); ?></p>
	
	<h3>Server Settings</h3>

	<p>
		<label for="http_server">HTTP Server</label>
		<?php echo form_dropdown('http_server', $server_options); ?>
	</p>
	
	<input type="hidden" name="installation_step" value="step_1" />
	
	<p id="next_step"><input type="submit" id="submit" value="Step 2" /></p>
	<br class="clear" />
</form>
