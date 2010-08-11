<p><?php echo sprintf(lang('email_greeting'), $full_name) ?></p>

<p><?php echo sprintf(lang('user_activation_email_body'), $this->settings->site_name);?></p>

<p><?php echo anchor('users/login');?></p>

<p>
	<?php echo lang('email_signature') ?><br />
	<?php echo $this->settings->site_name; ?>.
</p>