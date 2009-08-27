<h2>Step 4: Create database</h2>
<p>Complete the form below and hit the button labelled "Finish" to install PyroCMS. Be sure to install PyroCMS into the right database since all existing changes will be lost!</p>
<form id="install_frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<h3>Database Settings</h3>
	<p><label for="database">Database</label><input type="text" id="database" class="input_text" name="database" /></p>
	<p><label for="dummy_data">Install dummy data</label><input type="checkbox" name="dummy_data" value="true" id="dummy_data" /></p>
	<p><label for="create_db">Create Database</label><input type="checkbox" name="create_db" value="true" id="create_db" /><small>In some cases you might have to create the database yourself.</small></p>
	
	<p id="next_step"><input type="submit" id="submit" value="Finish" /></p>
	<br class="clear" />
</form>