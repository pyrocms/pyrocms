<h3><?php echo lang('user_inactive_title');?></h3>

<p class="float-right">
	[ <a href="<?php echo site_url('admin/users/index');?>"><?php echo lang('user_active_title');?></a> ]
</p>

<?php echo form_open('admin/users/action'); ?>
	<table border="0" class="table-list clear-both">    
		<thead>
			<tr>
				<th><?php echo form_checkbox('action_to_all');?></th>
				<th><?php echo lang('user_name_label');?></th>
				<th><?php echo lang('user_email_label');?></th>
				<th><?php echo lang('user_role_label');?></th>
				<th><?php echo lang('user_joined_label');?></th>
				<th><span><?php echo lang('user_actions_label');?></span></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="6">
						<div class="inner"><?php $this->load->view('admin/fragments/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>  
			<tbody>
			<?php if (!empty($users)): ?>
				<?php foreach ($users as $member): ?>
				<tr>
					<td align="center"><input type="checkbox" name="action_to[]" value="<?php echo $member->id; ?>" /></td>
					<td><?php echo anchor('admin/users/edit/' . $member->id, $member->full_name); ?></td>
					<td><?php echo mailto($member->email); ?></td>
					<td><?php echo $member->role; ?></td>
					<td><?php echo date('M d, Y', $member->created_on); ?></td>
					<td>
						<?php echo anchor('admin/users/activate/' . $member->id, lang('user_activate_label'));?> | 
						<?php echo anchor('admin/users/edit/' . $member->id, lang('user_edit_label')); ?> | 
						<?php echo anchor('admin/users/delete/' . $member->id, lang('user_delete_label'), array('class'=>'confirm')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="6"><?php echo lang('user_no_inactives')?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('activate', 'delete') )); ?>
<?php echo form_close(); ?>