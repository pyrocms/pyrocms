<!-- Install Complete -->
<h2>Congratulations, <?php echo $admin_user['firstname'] . ' ' . $admin_user['lastname']; ?>!</h2>
<p>PyroCMS is now installed and ready to go! Please log into the admin panel with the following details.</p>

<p>
	<strong>E-mail:</strong> <?php echo $admin_user['email']; ?><br />
	<strong>Password:</strong> <?php echo $admin_user['password']; ?>
</p>

<p>Finally, <strong>delete the installer from your server</strong> as if you leave it here it can be used to hack your website.</p>

<?php echo anchor($admin_url) ?>