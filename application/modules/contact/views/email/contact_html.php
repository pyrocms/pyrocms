<table width="100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
<tr>
  <td colspan="3">This message was sent via the contact form on
    <?=$this->config->item('site_name');?> with the following details</td>
</tr>
<tr>
  <td width="33%"><strong>IP:</strong> <?=$sender_ip;?></td>
  <td width="33%"><strong>OS:</strong> <?=$sender_os;?></td>
  <td width="33%"><strong>Agent:</strong> <?=$sender_agent;?></td>
</tr>
<tr>
  <td colspan="3">
    <hr />

    <?=$message;?>

    <p><hr /></p>
    
    <strong>Name:</strong> <?=$contact_name;?><br/>
    <strong>Company:</strong> <?=$company_name;?>
    </td>
  </tr>
</table>
