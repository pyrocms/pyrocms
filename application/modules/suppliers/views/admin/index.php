<?=form_open('admin/suppliers/delete'); ?>

<table border="0" class="listTable">
	
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Product</a></th>
		<th class="width-10"><a href="#">Updated</a></th>
		<th class="last width-15"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="4">
  			<div class="inner"><? $this->load->view('admin/layout_fragments/pagination'); ?></div>
  		</td>
  	</tr>
  </tfoot>
	
	<tbody>
	<? if ($suppliers): ?>
		
		<? foreach ($suppliers as $supplier): ?>
		<tr>
              <td><input type="checkbox" name="action_to[]" value="<?= $supplier->id; ?>" /></td>
                <td><?= $supplier->title;?></td>
                <td><?= date('M d, Y', $supplier->updated_on);?></td>
                <td><?= anchor($supplier->url, 'Website', 'target="_blank"') . ' | ' .
                		anchor('admin/suppliers/edit/' . $supplier->id, 'Edit') . ' | ' .
						anchor('admin/suppliers/delete/' . $supplier->id, 'Delete', array('class'=>'confirm'));?>
                </td>
    	</tr>
		<? endforeach; ?>

	<? else: ?>
        <tr><td colspan="4">There are no suppliers.</td></tr>
        <? endif; ?>
        
  </tbody>
</table>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>
        
<?=form_close();?>