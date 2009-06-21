<?=form_open('admin/services/delete');?>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#"><?=lang('service_label');?></a></th>
		<th><a href="#"><?=lang('service_price_label');?></a></th>
		<th><a href="#"><?=lang('service_updated_label');?></a></th>
		<th class="last"><span><?=lang('service_actions_label');?></span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="5">
  			<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
  		</td>
  	</tr>
  </tfoot>
	<tbody>
	<? if ($services): ?>
		<? foreach ($services as $service): ?>
		<tr>
			<td><input type="checkbox" name="action_to[]" value="<?= $service->id; ?>" /></td>
			<td><?= $service->title; ?></td>
			<td><?=sprintf(lang('service_price_format'), $this->settings->item('currency'), $service->price, $pay_per_options[$service->pay_per]);?></td>
			<td><?= date('M d, Y', $service->updated_on); ?></td>
			<td>
				<?= anchor('services/' . $service->slug, lang('service_view_label'), 'target="_blank"');?> | 
				<?= anchor('admin/services/edit/' . $service->slug, lang('service_edit_label'));?> | 
				<?= anchor('admin/services/delete/' . $service->id, lang('service_delete_label'), array('class'=>'confirm')); ?>
			</td>
		</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr>
			<td colspan="5"><?=lang('service_no_services');?></td>
		</tr>
	<? endif; ?>
	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close();?>