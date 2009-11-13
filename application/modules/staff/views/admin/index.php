<?php echo form_open('admin/staff/delete'); ?>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th><?php echo form_checkbox('action_to_all');?></th>
		<th><a href="#"><?php echo lang('staff_member_label');?></a></th>
		<th><a href="#"><?php echo lang('staff_updated_label');?></a></th>
		<th><span><?php echo lang('staff_actions_label');?></span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="4">
  			<div class="inner"><?php $this->load->view('admin/fragments/pagination'); ?></div>
  		</td>
  	</tr>
  </tfoot>	
	<tbody>
  <?php if ($staff):?>
    <?php foreach ($staff as $member): ?>
    	<tr>
				<td><input type="checkbox" name="delete[<?php echo $member->slug;?>]" /></td>
				<td><?php echo anchor('admin/staff/edit/' . $member->slug, $member->name);?></td>
				<td><?php echo date('M d, Y', $member->updated_on);?></td>
				<td>
					<?php echo anchor('staff/' . $member->slug, lang('staff_view_label'), 'target="_blank"');?> | 
					<?php echo anchor('admin/staff/edit/' . $member->slug, lang('staff_edit_label'));?> | 
					<?php echo anchor('admin/staff/delete/' . $member->slug, lang('staff_delete_label'), array('class'=>'confirm'));?>
        </td>
			</tr>
		<?php endforeach; ?>		
	<?php else: ?>
		<tr>
			<td colspan="4"><?php echo lang('staff_no_staff');?></td>
		</tr>
  <?php endif; ?>
 	</tbody>
</table>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?> 
<?php echo form_close(); ?>