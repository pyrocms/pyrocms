<p><?=sprintf(lang('email_greeting'), $full_name) ?></p>

<p><?=sprintf(lang('user_reset_pass_email_body'), $this->settings->item('site_name'), mailto($this->settings->item('contact_email')) ); ?></p>

<p><strong><?=lang('user_password') ?>:</strong> <?=$new_password;?></p>

<p><?=anchor('users/login');?></p>

<p>
	<?=lang('email_signature') ?><br />
	<?=$this->settings->item('site_name'); ?>.
</p>