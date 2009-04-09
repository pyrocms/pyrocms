<?=form_open('admin/suppliers/delete'); ?>

<table border="0" class="listTable">
	
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Product</a></th>
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
	<? if ($suppliers):
	foreach ($suppliers as $supplier) {
		echo '<tr>
                  <td><input type="checkbox" name="delete[' . $supplier->slug . ']" /></td>
                    <td>' . $supplier->title . '</td>
                    <td>' . date('M d, Y', $supplier->updated_on) . '</td>
                    <td>' . anchor('suppliers/' . $supplier->slug, 'View', 'target="_blank"') . ' | ' .
						anchor('admin/suppliers/edit/' . $supplier->slug, 'Edit') . ' | ' .
						anchor('admin/suppliers/delete/' . $supplier->slug, 'Delete', array('class'=>'confirm')) . '
                    </td>
        	</tr>';
	} ?>

	<? else: ?>
        <tr><td colspan="4">There are no suppliers.</td></tr>
        <? endif; ?>
        
  </tbody>
</table>

<div class="fcc-table-buttons">
	<a href="<?=site_url('admin/suppliers/create');?>"><img src="/assets/img/admin/fcc/btn-add.jpg" /></a>
        <? if ($suppliers):?>
		<input type="image" name="btnDelete" value="Delete" src="/assets/img/admin/fcc/btn-delete.jpg" />
	<? endif; ?>
</div>
        
<?=form_close();?>