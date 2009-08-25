<?php echo form_open('admin/categories/delete'); ?>
	<table border="0" class="listTable">
		<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?php echo lang('cat_category_label');?></a></th>
			<th class="last width-10"><span><?php echo lang('cat_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ($categories): ?>    
			<?php foreach ($categories as $category): ?>
			<tr>
				<td><input type="checkbox" name="delete[]" value="<?php echo $category->slug;?>" /></td>
				<td><?php echo $category->title;?></td>
				<td>
					<?php echo anchor('admin/categories/edit/' . $category->slug, lang('cat_edit_label')) . ' | '; ?>
					<?php echo anchor('admin/categories/delete/' . $category->slug, lang('cat_delete_label'), array('class'=>'confirm'));?>
				</td>
			</tr>
			<?php endforeach; ?>                      
		<?php else: ?>
			<tr>
				<td colspan="3"><?php echo lang('cat_no_categories');?></td>
			</tr>
		<?php endif; ?>    
		</tbody>
	</table>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>