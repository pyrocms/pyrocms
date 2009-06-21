<?=form_open('admin/suppliers/delete'); ?>
<table border="0" class="listTable">	
	<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?= lang('supp_product_label');?></a></th>
			<th class="width-10"><a href="#"><?= lang('supp_updated_label');?></a></th>
			<th class="last width-15"><span><?= lang('supp_actions_label');?></span></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="4">
				<div class="inner">
					<? $this->load->view('admin/fragments/pagination'); ?>
				</div>
			</td>
		</tr>
	</tfoot>	
	<tbody>
<? if ($suppliers): ?>	
	<? foreach ($suppliers as $supplier): ?>
		<tr>
			<td><input type="checkbox" name="action_to[]" value="<?= $supplier->id; ?>" /></td>
			<td><?= $supplier->title;?></td>
			<td><?= date('M d, Y', $supplier->updated_on);?></td>
			<td><?= anchor($supplier->url, lang('supp_website_label'), 'target="_blank"') . ' | ' .
			anchor('admin/suppliers/edit/' . $supplier->id, lang('supp_edit_label')) . ' | ' .
			anchor('admin/suppliers/delete/' . $supplier->id, lang('supp_delete_label'), array('class'=>'confirm'));?>
			</td>
		</tr>
	<? endforeach; ?>	
<? else: ?>
	<tr>
		<td colspan="4"><?= lang('supp_no_suppliers');?></td>
	</tr>
<? endif; ?>	
	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close();?>