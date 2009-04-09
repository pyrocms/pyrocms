<table border="0" class="listTable">
    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Category</a></th>
		<th class="last width-10"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="3">
  			<div class="inner"></div>
  		</td>
  	</tr>
  </tfoot>	<tbody>    <? if ($categories): ?>
        	<? foreach ($categories as $category): ?>
		<tr>
			<td><input type="checkbox" name="delete[<?= $category->slug;?>]" /></td>
			<td><?=$category->title;?></td>
			<td><?=anchor('admin/categories/edit/' . $category->slug, 'Edit') . ' | ' . 
			anchor('admin/categories/delete/' . $category->slug, 'Delete', array('class'=>'confirm'));?>
			</td>
		</tr>
		<? endforeach; ?>
                          <? else: ?>        <tr>
        	<td colspan="3">There are no categories.</td>
        </tr>    <? endif; ?>
    
    </tbody>
</table>
    
<div class="fcc-table-buttons">
    <a href="<?=site_url('admin/categories/create');?>"><img src="/assets/img/admin/fcc/btn-add.jpg" /></a> 	<? if (!empty($categories)):?>
 		<input type="image" name="btnDelete" value="Delete" alt="Delete" src="/assets/img/admin/fcc/btn-delete.jpg" /> 	<? endif; ?>
 	
</div>

 <?=form_close(); ?>