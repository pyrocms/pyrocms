<div id="top">
	<h1><?php echo anchor('admin', $this->settings->item('site_name')); ?></h1>
	<p id="userbox">
		<strong><?php echo sprintf(lang('cp_logged_in_welcome'), $user->first_name.' '.$user->last_name); ?></strong>
		&nbsp;| &nbsp;<?php echo anchor('edit-profile', lang('cp_edit_profile_label')); ?>
		&nbsp;| &nbsp;<?php echo anchor('admin/logout', lang('cp_logout_label')); ?>
		<br />
	<small>Last Login: 12 May 2009</small></p>
	<span class="clearFix">&nbsp;</span>
</div>

<ul id="menu">
	<li class="selected"><a href="#">Dashboard</a></li>
	<li>
		<a class="top-level" href="#">Users <span>&nbsp;</span></a>
		<ul>
			<li><a href="#">Add User</a></li>
			<li><a href="#">Edit Users</a></li>
		</ul>
	</li>
	<li><a href="#">Pages</a></li>
	<li><a href="#">Modules</a></li>
	<li>
		<a class="top-level" href="#">Settings <span>&nbsp;</span></a>
		<ul>
			<li><a href="#">Site Settings</a></li>
			<li><a href="#">File Paths</a></li>
			<li><a href="#">User Profiles</a></li>
	    </ul>
    </li>
</ul>

<span class="clearFix">&nbsp;</span>