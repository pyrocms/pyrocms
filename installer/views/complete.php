<!-- Install Complete -->
<h2>{congrats}, {user_firstname} {user_lastname} !</h2>
<p>{intro_text}</p>

<p>
	<strong>{email}:</strong> {user_email}<br />
	<strong>{password}:</strong> {user_password}
</p>

<p>{outro_text}</p>

<?php echo anchor($admin_url) ?>