<?php if (!empty($users)): ?>
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th with="30" class="align-center"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('user:name_label');?></th>
				<th class="collapse"><?php echo lang('global:email');?></th>
				<th><?php echo lang('user:group_label');?></th>
				<th class="collapse"><?php echo lang('user:active') ?></th>
				<th class="collapse"><?php echo lang('user:joined_label');?></th>
				<th class="collapse"><?php echo lang('user:last_visit_label');?></th>
				<th width="200"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php $link_profiles = Settings::get('enable_profiles') ?>
			<?php foreach ($users as $member): ?>
				<tr>
					<td class="align-center"><?php echo form_checkbox('action_to[]', $member->id) ?></td>
					<td>
					<?php if ($link_profiles) : ?>
						<?php echo anchor('admin/users/preview/' . $member->id, $member->display_name ?: $member->username, 'target="_blank" class="modal-large"') ?>
					<?php else: ?>
						<?php echo $member->display_name ?: $member->username ?>
					<?php endif ?>
					</td>
					<td class="collapse"><?php echo mailto($member->email) ?></td>
					<td>
						<ul>
							<?php foreach ($member->getGroups() as $group) echo "<li>{$group->description}</li>" ?>
						</ul>
					</td>
					<td class="collapse"><?php echo $member->isActivated() ? lang('global:yes') : lang('global:no')  ?></td>
					<td class="collapse"><?php echo format_date($member->created_on) ?></td>
					<td class="collapse"><?php echo ($member->last_login ? format_date($member->last_login) : lang('user:never_label')) ?></td>
					<td class="actions">
						<?php echo anchor('admin/users/edit/' . $member->id, lang('global:edit'), array('class'=>'button edit')) ?>
						<?php if ($this->current_user->id != $member->id): ?>
							<?php echo anchor('admin/users/delete/' . $member->id, lang('global:delete'), array('class'=>'confirm button delete')) ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif;
