<h3><?php echo lang('user_registred_title');?></h3>

<p class="float-right">
	[
	<a href="<?php echo site_url('admin/users/inactive');?>"><?php echo lang('user_inactive_title');?>
	<?php if($inactive_user_count > 0): ?><strong>(<?php echo $inactive_user_count ?>)</strong><?php endif; ?></a> 
	]
</p>

<?php echo form_open('admin/users/action'); ?>
	<table border="0" class="table-list clear-both">
		<thead>
		<tr>
			<th><?php echo form_checkbox('action_to_all');?></th>
			<th><a href="#"><?php echo lang('user_name_label');?></a></th>
			<th><a href="#"><?php echo lang('user_email_label');?></a></th>
			<th><a href="#"><?php echo lang('user_role_label');?></a></th>
			<th><a href="#"><?php echo lang('user_joined_label');?></a></th>
			<th><a href="#"><?php echo lang('user_last_visit_label');?></a></th>
			<th><span><?php echo lang('user_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
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
					<td><?php echo ($member->last_login > 0 ? date('M d, Y', $member->last_login) : lang('user_never_label')); ?></td>
					<td>
						<?php echo anchor('admin/users/edit/' . $member->id, lang('user_edit_label')); ?> | 
						<?php echo anchor('admin/users/delete/' . $member->id, lang('user_delete_label'), array('class'=>'confirm')); ?>
					</td>
					</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="7"><?php echo lang('user_no_registred');?></td>
			</tr>
		<?php endif; ?>
		</tbody>	
	</table>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>
