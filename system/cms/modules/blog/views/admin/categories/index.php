<section class="title">
	<h4><?php echo lang('cat_list_title'); ?></h4>
</section>

<section class="item">
	
	<?php if ($categories): ?>

		<?php echo form_open('admin/blog/categories/delete'); ?>

		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('cat_category_label'); ?></th>
				<th><?php echo lang('global:slug'); ?></th>
				<th width="120"></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($categories as $category): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $category->id); ?></td>
					<td><?php echo $category->title; ?></td>
					<td><?php echo $category->slug; ?></td>
					<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/blog/categories/edit/'.$category->id, lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/blog/categories/delete/'.$category->id, lang('global:delete'), 'class="confirm button delete"') ;?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>

		<?php echo form_close(); ?>

	<?php else: ?>
		<div class="no_data"><?php echo lang('cat_no_categories'); ?></div>
	<?php endif; ?>
</section>