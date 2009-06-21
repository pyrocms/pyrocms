<?= form_open('admin/categories/delete'); ?>
	<table border="0" class="listTable">
		<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?=lang('cat_category_label');?></a></th>
			<th class="last width-10"><span><?=lang('cat_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<? if ($categories): ?>    
			<? foreach ($categories as $category): ?>
			<tr>
				<td><input type="checkbox" name="delete[]" value="<?= $category->slug;?>" /></td>
				<td><?=$category->title;?></td>
				<td>
					<?=anchor('admin/categories/edit/' . $category->slug, lang('cat_edit_label')) . ' | '; ?>
					<?=anchor('admin/categories/delete/' . $category->slug, lang('cat_delete_label'), array('class'=>'confirm'));?>
				</td>
			</tr>
			<? endforeach; ?>                      
		<? else: ?>
			<tr>
				<td colspan="3"><?=lang('cat_no_categories');?></td>
			</tr>
		<? endif; ?>    
		</tbody>
	</table>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close(); ?>