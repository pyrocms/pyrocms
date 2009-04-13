<?=form_open('admin/services/delete');?>

<table border="0" class="listTable">
    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Service</a></th>
		<th><a href="#">Price</a></th>
		<th><a href="#">Updated</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="5">
  			<div class="inner"></div>
  		</td>
  	</tr>
  </tfoot>

	<tbody>
	<? if ($services): ?>
		<? foreach ($services as $service): ?>
			<tr>
				<td><input type="checkbox" name="delete[<?= $service->slug; ?>]" /></td>
				<td><?= $service->title; ?></td>
				<td><?= $this->settings->item('currency').$service->price . ' ' . $pay_per_options[$service->pay_per];?></td>
				<td><?= date('M d, Y', $service->updated_on); ?></td>
				<td>
					<?= anchor('services/' . $service->slug, 'View', 'target="_blank"') . ' | '.
						anchor('admin/services/edit/' . $service->slug, 'Edit') . ' | '.
						anchor('admin/services/delete/' . $service->slug, 'Delete', array('class'=>'confirm')); ?>
				</td>
			  </tr>
		<? endforeach; ?>

	<? else: ?>
		<tr><td colspan="5">There are no services.</td></tr>
	<? endif; ?>
	</tbody>
</table>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>

<?=form_close();?>