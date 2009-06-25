<?=form_open('admin/staff/delete'); ?>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#"><?= lang('staff_member_label');?></a></th>
		<th><a href="#"><?= lang('staff_updated_label');?></a></th>
		<th class="last"><span><?= lang('staff_actions_label');?></span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="4">
  			<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
  		</td>
  	</tr>
  </tfoot>	
	<tbody>
  <? if ($staff):?>
    <? foreach ($staff as $member): ?>
    	<tr>
				<td><input type="checkbox" name="delete[<?=$member->slug;?>]" /></td>
				<td><?=anchor('admin/staff/edit/' . $member->slug, $member->name);?></td>
				<td><?=date('M d, Y', $member->updated_on);?></td>
				<td>
					<?=anchor('staff/' . $member->slug, lang('staff_view_label'), 'target="_blank"');?> | 
					<?=anchor('admin/staff/edit/' . $member->slug, lang('staff_edit_label'));?> | 
					<?=anchor('admin/staff/delete/' . $member->slug, lang('staff_delete_label'), array('class'=>'confirm'));?>
        </td>
			</tr>
		<? endforeach; ?>		
	<? else: ?>
		<tr>
			<td colspan="4"><?= lang('staff_no_staff');?></td>
		</tr>
  <? endif; ?>
 	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?> 
<?=form_close(); ?>