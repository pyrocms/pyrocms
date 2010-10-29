<?php if (!empty($users)): ?>
	<?php if ($this->method == 'index'): ?>
		<h3><?php echo lang('user_registred_title');?></h3>
	<?php else: ?>
		<h3><?php echo lang('user_inactive_title');?></h3>
	<?php endif; ?>

	<?php echo form_open('admin/users/action'); ?>
		<table border="0" class="table-list">
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('user_name_label');?></th>
					<th><?php echo lang('user_email_label');?></th>
					<th><?php echo lang('user_group_label');?></th>
					<th><?php echo lang('user_joined_label');?></th>
					<th><?php echo lang('user_last_visit_label');?></th>
					<th><?php echo lang('user_actions_label');?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="7">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>  
			<tbody>
				<?php foreach ($users as $member): ?>
					<tr>
						<td align="center"><?php echo form_checkbox('action_to[]', $member->id); ?></td>
						<td><?php echo anchor('admin/users/edit/' . $member->id, $member->full_name); ?></td>
						<td><?php echo mailto($member->email); ?></td>
						<td><?php echo $member->role_title; ?></td>
						<td><?php echo date('M d, Y', $member->created_on); ?></td>
						<td><?php echo ($member->last_login > 0 ? date('M d, Y', $member->last_login) : lang('user_never_label')); ?></td>
						<td>
							<?php echo anchor('admin/users/edit/' . $member->id, lang('user_edit_label'), array('class'=>'minibutton')); ?>  
							<?php echo anchor('admin/users/delete/' . $member->id, lang('user_delete_label'), array('class'=>'confirm minibutton')); ?>
						</td>
						</tr>
				<?php endforeach; ?>
			</tbody>	
		</table>
	
	<div class="float-right">
		<?php if ($this->method == 'index'): ?>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		<?php else: ?>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )); ?>
		<?php endif; ?>
	</div>
	
<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
	
		<img src="<?php echo site_url('system/pyrocms/modules/users/img/user.png') ?>" />
		
		<h2><?php echo lang($this->method == 'index' ? 'user_no_registred' : 'user_no_inactives');?></h2>
	</div>
<?php endif; ?>
		