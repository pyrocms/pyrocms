<h1><?php echo $user->full_name; ?></h1>

<p style="float:left; width: 40%;">
	<?php echo anchor('user/' . $user->username, NULL, 'target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/users/edit/' . $user->id, lang('buttons.edit'), ' target="_parent"'); ?>
</p>

<iframe src="<?php echo site_url('user/' . $user->username); ?>" width="99%" height="400"></iframe>