<h3><?php echo lang('cat_list_title');?></h3>

<?php echo form_open('admin/news/categories/delete'); ?>
	<table border="0" class="table-list">
		<thead>
		<tr>
			<th style="width: 20px;"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
			<th><?php echo lang('cat_category_label');?></th>
			<th style="width:10em"><span><?php echo lang('cat_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ($categories): ?>
			<?php foreach ($categories as $category): ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $category->id); ?></td>
				<td><?php echo $category->title;?></td>
				<td>
					<?php echo anchor('admin/news/categories/edit/' . $category->id, lang('cat_edit_label')) . ' | '; ?>
					<?php echo anchor('admin/news/categories/delete/' . $category->id, lang('cat_delete_label'), array('class'=>'confirm'));?>
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
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>