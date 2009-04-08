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

<div class="fcc-table-buttons">
    <a href="<?=site_url('admin/staff/create');?>"><img src="/assets/img/admin/fcc/btn-add.jpg" /></a>	<? if(!empty($staff)): ?>
		<input type="image" name="btnDelete" value="Delete" src="/assets/img/admin/fcc/btn-delete.jpg" /> 	<? endif; ?>
</div>
 
<?=form_close(); ?>