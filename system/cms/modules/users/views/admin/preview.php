<?php

	// Use display_name if no first_name or
	// last_name are present.
	if ( ! isset($user->first_name) or ! isset($user->last_name)) {
		$name = $user->display_name;
	} else {
		$name = $user->first_name.' '.$user->last_name;
	}

?>

<h1><?php echo $name; ?></h1>

<p style="float:left; width: 40%;">
	<?php echo anchor('user/' . $user->username, null, 'target="_blank"') ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/users/edit/' . $user->id, lang('buttons:edit'), ' target="_parent"') ?>
</p>

<iframe src="<?php echo site_url('user/' . $user->username) ?>" width="99%" height="400"></iframe>