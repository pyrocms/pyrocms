<?php if ($categories): ?>

	<h3><?php echo lang('cat_list_title'); ?></h3>

	<?php echo form_open('admin/blog/categories/delete'); ?>

	<table border="0" class="table-list">
		<thead>
		<tr>
			<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
			<th><?php echo lang('cat_category_label'); ?></th>
			<th width="200" class="align-center"><span><?php echo lang('cat_actions_label'); ?></span></th>
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
			<?php foreach ($categories as $category): ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $category->id); ?></td>
				<td><?php echo $category->title; ?></td>
				<td class="align-center buttons buttons-small">
					<?php echo anchor('admin/blog/categories/edit/' . $category->id, lang('cat_edit_label'), 'class="button edit"'); ?>
					<?php echo anchor('admin/blog/categories/delete/' . $category->id, lang('cat_delete_label'), 'class="confirm button delete"') ;?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
	</div>

	<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('cat_no_categories'); ?></h2>
	</div>
<?php endif; ?>