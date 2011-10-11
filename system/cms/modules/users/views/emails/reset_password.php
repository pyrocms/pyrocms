<p><?php echo sprintf(lang('email_greeting'), $full_name) ?></p>

<p><?php echo sprintf(lang('user_reset_pass_email_body'), $this->settings->site_name, mailto($this->settings->item('contact_email')) ); ?></p>

<p><strong><?php echo lang('user_password') ?>:</strong> <?php echo $new_password;?></p>

<p><?php echo anchor('users/login');?></p>

<p>
	<?php echo lang('email_signature') ?><br />
	<?php echo $this->settings->site_name; ?>.
</p>