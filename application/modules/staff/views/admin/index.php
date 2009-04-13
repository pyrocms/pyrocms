<?=form_open('admin/staff/delete'); ?>

<table border="0" class="listTable">
    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Staff Member</a></th>
		<th><a href="#">Updated</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="4">
  			<div class="inner"></div>
  		</td>
  	</tr>
  </tfoot>
		<tbody>
    <? if ($staff):?>    	<? foreach ($staff as $member): ?>        	<tr>				<td><input type="checkbox" name="delete[<?=$member->slug;?>]" /></td>				<td><?=anchor('admin/staff/edit/' . $member->slug, $member->name);?></td>				<td><?=date('M d, Y', $member->updated_on);?></td>
				<td>
					<?=anchor('staff/' . $member->slug, 'View', 'target="_blank"');?> | 
					<?=anchor('admin/staff/edit/' . $member->slug, 'Edit');?> | 
					<?=anchor('admin/staff/delete/' . $member->slug, 'Delete', array('class'=>'confirm'));?>
                </td>			</tr>		<? endforeach; ?>
			<? else: ?>		<tr><td colspan="4">There are no staff.</td></tr>    <? endif; ?>
 	</tbody>
</table>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>
 
<?=form_close(); ?>