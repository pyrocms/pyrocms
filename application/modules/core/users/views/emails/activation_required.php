<p><?php echo sprintf(lang('email_greeting'), $full_name) ?></p>

<p><?php echo sprintf(lang('user_activated_email_content_line1'), $this->settings->item('site_name'));?></p>

<p><?php echo anchor('users/activate/'.$id.'/'.$activation_code);?></p>

<p><?php echo lang('user_activated_email_content_line2') ?></p>

<p><?php echo site_url('users/activate');?></p>

<p><strong><?php echo lang('user_activation_code'); ?>:</strong> <?php echo $activation_code;?></p>

<p>
	<?php echo lang('email_signature') ?><br />
	<?php echo $this->settings->item('site_name'); ?>.
</p>