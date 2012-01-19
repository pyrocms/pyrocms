	<?php if (!empty($users)): ?>

			<table border="0" class="table-list">
				<thead>
					<tr>
						<th with="30" class="align-center"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
						<th><?php echo lang('user_name_label');?></th>
						<th class="collapse"><?php echo lang('user_email_label');?></th>
						<th><?php echo lang('user_group_label');?></th>
						<th class="collapse"><?php echo lang('user_active'); ?></th>
						<th class="collapse"><?php echo lang('user_joined_label');?></th>
						<th class="collapse"><?php echo lang('user_last_visit_label');?></th>
						<th width="200"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php $link_profiles = Settings::get('enable_profiles'); ?>
					<?php foreach ($users as $member): ?>
						<tr>
							<td class="align-center"><?php echo form_checkbox('action_to[]', $member->id); ?></td>
							<td>
							<?php if ($link_profiles) : ?>
								<?php echo anchor('admin/users/preview/' . $member->id, $member->full_name, 'target="_blank" class="modal-large"'); ?>
							<?php else: ?>
								<?php echo $member->full_name; ?>
							<?php endif; ?>
							</td>
							<td class="collapse"><?php echo mailto($member->email); ?></td>
							<td><?php echo $member->group_name; ?></td>
							<td class="collapse"><?php echo $member->active ? lang('global:yes') : lang('global:no') ; ?></td>
							<td class="collapse"><?php echo format_date($member->created_on); ?></td>
							<td class="collapse"><?php echo ($member->last_login > 0 ? format_date($member->last_login) : lang('user_never_label')); ?></td>
							<td class="actions">
								<?php echo anchor('admin/users/edit/' . $member->id, lang('global:edit'), array('class'=>'button edit')); ?>
								<?php echo anchor('admin/users/delete/' . $member->id, lang('global:delete'), array('class'=>'confirm button delete')); ?>
							</td>
							</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	<?php endif; ?>