<p><?=sprintf(lang('email_greeting'), $full_name) ?></p>

<p><?=sprintf(lang('user_activated_email_content_line1'), $this->settings->item('site_name'));?></p>

<p><?=anchor('users/activate/'.$id.'/'.$activation_code);?></p>

<p><?=lang('user_activated_email_content_line2') ?></p>

<p><?=site_url('users/activate');?></p>

<p><strong><?=lang('user_activation_code'); ?>:</strong> <?=$activation_code;?></p>

<p>
	<?=lang('email_signature') ?><br />
	<?=$this->settings->item('site_name'); ?>.
</p>