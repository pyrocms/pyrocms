<p><?=sprintf(lang('email_greeting'), $full_name) ?></p>

<p><?=sprintf(lang('user_activation_email_body'), $this->settings->item('site_name'));?></p>

<p><?=anchor('users/login');?></p>

<p>
	<?=lang('email_signature') ?><br />
	<?=$this->settings->item('site_name'); ?>.
</p>