<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr>
		<td width="178" valign="top">
			<?php echo $this->load->view($this->view_path.'fragments/leftpane', $data);?>
		</td>
		<td width="5">&nbsp;</td>
		<td valign="top">
			<div class="heading">
				<?php echo $this->load->view($this->view_path.'fragments/search_form');?>
			</div>
			<?php echo $this->load->view($this->view_path.'fragments/rightpane_'.$this->session->userdata('cimm_view'), $data);?>
		</tr>
</tbody>
</table>
