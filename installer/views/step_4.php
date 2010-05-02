<h2>Step 4: Create database</h2>
<p>Complete the form below and hit the button labelled "Finish" to install PyroCMS. Be sure to install PyroCMS into the right database since all existing changes will be lost!</p>
<form id="install_frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<h3>Database Settings</h3>
	<p>
		<label for="database">Database</label>
		<input type="text" id="database" class="input_text" name="database" />
	</p>
	<p>
		<label for="create_db">Create Database</label>
		<input type="checkbox" name="create_db" value="true" id="create_db" /><small>(You might need to do this yourself)</small>
	</p>
	<h3>Default User</h3>
	<p>
		<label for="user_username">Email</label>
		<input type="text" id="user_username" class="input_text" name="user_email" />
	</p>
	<p>
		<label for="user_password">Password</label>
		<input type="password" id="user_password" class="input_text" name="user_password" />
	</p>
	<p>
		<label for="user_confirm_password">Confirm Password</label>
		<input type="password" id="user_confirm_password" class="input_text" name="user_confirm_password" />
	</p>
	<p id="next_step"><input type="submit" id="submit" value="Finish" /></p>
	<br class="clear" />
</form>