<table width="100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
	<tr>
		<td colspan="3"><?php echo sprintf(lang('contact_mail_text'), $this->settings->item('site_name'));?></td>
	</tr>
	<tr>
		<td width="33%"><?php echo sprintf('<strong>'.lang('contact_mail_ip_label').'</strong>', $sender_ip);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('contact_mail_os_label').'</strong>', $sender_os);?></td>
		<td width="33%"><?php echo sprintf('<strong>'.lang('contact_mail_agent_label').'</strong>', $sender_agent);?></td>
	</tr>
	<tr>
		<td colspan="3">
			<hr />
			<?php echo nl2br($message);?>
			<br />
			<?php echo sprintf('<strong>'.lang('contact_mail_name_label').'</strong>', $contact_name);?><br/>
			<?php echo sprintf('<strong>'.lang('contact_mail_company_label').'</strong>', $company_name);?>
		</td>
  </tr>
</table>
