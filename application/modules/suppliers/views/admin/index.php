<?php echo form_open('admin/suppliers/delete'); ?>
<table border="0" class="listTable">	
	<thead>
		<tr>
			<th><?php echo form_checkbox('action_to_all');?></th>
			<th><a href="#"><?php echo lang('supp_product_label');?></a></th>
			<th class="width-10"><a href="#"><?php echo lang('supp_updated_label');?></a></th>
			<th class="width-15"><span><?php echo lang('supp_actions_label');?></span></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="4">
				<div class="inner">
					<?php $this->load->view('admin/fragments/pagination'); ?>
				</div>
			</td>
		</tr>
	</tfoot>	
	<tbody>
<?php if ($suppliers): ?>	
	<?php foreach ($suppliers as $supplier): ?>
		<tr>
			<td><input type="checkbox" name="action_to[]" value="<?php echo $supplier->id; ?>" /></td>
			<td><?php echo $supplier->title;?></td>
			<td><?php echo date('M d, Y', $supplier->updated_on);?></td>
			<td><?php echo anchor($supplier->url, lang('supp_website_label'), 'target="_blank"') . ' | ' .
			anchor('admin/suppliers/edit/' . $supplier->id, lang('supp_edit_label')) . ' | ' .
			anchor('admin/suppliers/delete/' . $supplier->id, lang('supp_delete_label'), array('class'=>'confirm'));?>
			</td>
		</tr>
	<?php endforeach; ?>	
<?php else: ?>
	<tr>
		<td colspan="4"><?php echo lang('supp_no_suppliers');?></td>
	</tr>
<?php endif; ?>	
	</tbody>
</table>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close();?>