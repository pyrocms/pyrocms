<div class="sample-container">
	<?php if($items): ?>
		{pyro:items}
			<div class="inventory-data">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th>{pyro:helper:lang line="sample.name"}</th>
						<th>{pyro:helper:lang line="sample.slug"}</th>
					</tr>
					<tr class="even">
						<td width="100">{pyro:name}</td>
						<td width="100">{pyro:slug}</td>
					</tr>
				</table>
			</div>
		{/pyro:items}

	<?php else: ?>
	<p>No listings have been added.</p>
	<?php endif; ?>

	<?php $this->load->view('admin/partials/pagination'); ?>

</div>