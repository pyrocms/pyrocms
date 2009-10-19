<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td width="178" valign="top">
		<?= $this->load->niew($this->view_path.'leftpane');?>
	</td>
	<td width="5">&nbsp;</td>
	<td valign="top">
		<?= $this->load->view($this->view_path.$rightpane);?>
	</tr>
</table>
