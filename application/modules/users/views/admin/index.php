<h3><?= lang('user_registred_title');?></h3>

<p class="float-right">
	[
	<a href="<?=site_url('admin/users/inactive');?>"><?=lang('user_inactive_title');?>
	<? if($inactive_user_count > 0): ?><strong>(<?=$inactive_user_count ?>)</strong><? endif; ?></a> 
	]
</p>

<?=form_open('admin/users/action'); ?>
	<table border="0" class="listTable clear-both">
		<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?=lang('user_name_label');?></a></th>
			<th><a href="#"><?=lang('user_email_label');?></a></th>
			<th><a href="#"><?=lang('user_role_label');?></a></th>
			<th><a href="#"><?=lang('user_joined_label');?></a></th>
			<th><a href="#"><?=lang('user_last_visit_label');?></a></th>
			<th class="last"><span><?=lang('user_actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>  
		<tbody>
		<? if (!empty($users)): ?>
			<? foreach ($users as $member): ?>
				<tr>
					<td align="center"><input type="checkbox" name="action_to[]" value="<?= $member->id; ?>" /></td>
					<td><?=anchor('admin/users/edit/' . $member->id, $member->full_name); ?></td>
					<td><?=mailto($member->email); ?></td>
					<td><?=$member->role; ?></td>
					<td><?=date('M d, Y', $member->created_on); ?></td>
					<td><?=($member->last_login > 0 ? date('M d, Y', $member->last_login) : lang('user_never_label')); ?></td>
					<td>
						<?= anchor('admin/users/edit/' . $member->id, lang('user_edit_label')); ?> | 
						<?= anchor('admin/users/delete/' . $member->id, lang('user_delete_label'), array('class'=>'confirm')); ?>
					</td>
					</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan="7"><?=lang('user_no_registred');?></td>
			</tr>
		<? endif; ?>
		</tbody>	
	</table>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close(); ?>
