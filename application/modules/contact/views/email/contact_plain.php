<?=sprintf(lang('contact_mail_text'), $this->config->item('site_name'));?>

	<?=sprintf(lang('contact_mail_ip_label'), $sender_ip);?>
	<?=sprintf(lang('contact_mail_os_label'), $sender_os);?>
	<?=sprintf(lang('contact_mail_agent_label'), $sender_agent);?>
    
<?=lang('contact_mail_above_message_label');?>

<?=$message;?>

<?=lang('contact_mail_below_message_label');?>

<?=sprintf(lang('contact_mail_name_label'), $contact_name);?>
<?=sprintf(lang('contact_mail_company_label', $company_name));?>