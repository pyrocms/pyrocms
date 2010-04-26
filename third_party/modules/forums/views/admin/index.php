<?php echo form_open('admin/forums');?>

<div class="box">

	<h3><?php echo lang('forums_list_categories_title');?></h3>

	<div class="box-container">

		<?php if (!empty($categories)): ?>

			<table border="0" class="table-list">
				<thead>
					<tr>
						<th><?php echo form_checkbox('action_to_all');?></th>
						<th><?php echo lang('forums_category_label');?></th>
						<th class="width-10"><span><?php echo lang('forums_actions_label');?></span></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="6">
							<div class="inner"><?php //$this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($categories as $cat): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $cat->id);?></td>
							<td><?php echo $cat->title;?></td>
							<td>
								<?php echo anchor('admin/forums/edit_category/' . $cat->id, lang('forums_edit_label'));?> |
								<?php echo anchor('admin/forums/delete/category/' . $cat->id, lang('forums_delete_label'), array('class'=>'confirm')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

		<?php else: ?>
			<p><?php echo lang('forums_no_categories');?></p>
		<?php endif; ?>
	</div>
</div>

<?php echo form_close();?>
