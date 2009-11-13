<?php echo form_open('admin/services/delete');?>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th><?php echo form_checkbox('action_to_all');?></th>
		<th><a href="#"><?php echo lang('service_label');?></a></th>
		<th><a href="#"><?php echo lang('service_price_label');?></a></th>
		<th><a href="#"><?php echo lang('service_updated_label');?></a></th>
		<th><span><?php echo lang('service_actions_label');?></span></th>
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
			<td><input type="checkbox" name="action_to[]" value="<?php echo $service->id; ?>" /></td>
			<td><?php echo $service->title; ?></td>
			<td><?php echo sprintf(lang('service_price_format'), $this->settings->item('currency'), $service->price, $pay_per_options[$service->pay_per]);?></td>
			<td><?php echo date('M d, Y', $service->updated_on); ?></td>
			<td>
				<?php echo anchor('services/' . $service->slug, lang('service_view_label'), 'target="_blank"');?> | 
				<?php echo anchor('admin/services/edit/' . $service->slug, lang('service_edit_label'));?> | 
				<?php echo anchor('admin/services/delete/' . $service->id, lang('service_delete_label'), array('class'=>'confirm')); ?>
			</td>
		</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr>
			<td colspan="5"><?php echo lang('service_no_services');?></td>
		</tr>
	<? endif; ?>
	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close();?>