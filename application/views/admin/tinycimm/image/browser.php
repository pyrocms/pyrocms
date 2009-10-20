<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td width="178" valign="top">
		<?= $this->load->view($this->view_path.'fragments/leftpane', $data);?>
	</td>
	<td width="5">&nbsp;</td>
	<td valign="top">
		<?= $this->load->view($this->view_path.'fragments/rightpane_'.$this->session->userdata('cimm_view'), $data);?>
	</tr>
</table>
