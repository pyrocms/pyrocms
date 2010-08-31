<!-- Install Complete -->
<h1>{congrats}, {user_firstname} {user_lastname} !</h1>

<p>{intro_text}</p>

<p>
	<strong>{email}:</strong> {user_email}<br />
	<strong>{password}:</strong> {user_password}
</p>

<p>{outro_text}</p>

<a href="<?php echo $admin_url ?>" id="next_step" class="complete"><?php echo $admin_url ?></a>