<h3><?= lang('user_inactive_title');?></h3>

<p class="float-right">
	[ <a href="<?=site_url('admin/users/index');?>"><?= lang('user_active_title');?></a> ]
</p>

<?=form_open('admin/users/action'); ?>
	<table border="0" class="listTable clear-both">    
		<thead>
			<tr>
				<th class="first"><div></div></th>
				<th><a href="#"><?= lang('user_name_label');?></a></th>
				<th><a href="#"><?= lang('user_email_label');?></a></th>
				<th><a href="#"><?= lang('user_role_label');?></a></th>
				<th><a href="#"><?= lang('user_joined_label');?></a></th>
				<th class="last"><span><?= lang('user_actions_label');?></span></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="6">
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
					<td>
						<?= anchor('admin/users/activate/' . $member->id, lang('user_activate_label'));?> | 
						<?= anchor('admin/users/edit/' . $member->id, lang('user_edit_label')); ?> | 
						<?=	anchor('admin/users/delete/' . $member->id, lang('user_delete_label'), array('class'=>'confirm')); ?>
					</td>
				</tr>
				<? endforeach; ?>
			<? else: ?>
				<tr>
					<td colspan="6"><?= lang('user_no_inactives')?></td>
				</tr>
			<? endif; ?>
		</tbody>
	</table>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('activate', 'delete') )); ?>
<?=form_close(); ?>