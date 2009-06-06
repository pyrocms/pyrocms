<? if(!empty($error_msg)) { ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td width="85%" bgcolor="#FF0000"><font color="#FFFFFF"><b><?=$error_msg;?></b></font></td>
  </tr>
</table>
<br />
<? } else { ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td width="85%" bgcolor="#CCCCCC"><?=$message;?></td>
  </tr>
</table>
<br />
<? } ?>