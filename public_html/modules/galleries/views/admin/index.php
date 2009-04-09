<?=form_open('admin/galleries/delete');?>
	
<table border="0" class="listTable">
    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Album</a></th>
		<th><a href="#">Number of photos</a></th>
		<th><a href="#">Updated</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="5">
  			<div class="inner"></div>
  		</td>
  	</tr>
  </tfoot>

	<tbody>
	<? if (!empty($galleries)): ?>
		
		<? function gallery_row($tree, $parent, $lvl) { ?>
		<? if(isset($tree[$parent])) foreach ($tree[$parent] as $gallery): ?>
			<tr>
				<td><input type="checkbox" name="delete[<?= $gallery->slug;?>]" /></td>
                <td><?=repeater('-- ', $lvl);?> <?=$gallery->title;?></td>
                <td><?=$gallery->num_photos;?></td>
                <td><?=date('M d, Y', $gallery->updated_on);?></td>
                <td><?= anchor('galleries/' . $gallery->slug, 'View', 'target="_blank"') . ' | ' .
						anchor('admin/galleries/edit/' . $gallery->slug, 'Edit') . ' | ' .
						anchor('admin/galleries/upload/' . $gallery->slug, 'Upload') . ' | ' .
						anchor('admin/galleries/delete/' . $gallery->slug, 'Delete', array('class'=>'confirm')); ?>
                    </td>
                 </tr>
                 <? gallery_row($tree, $gallery->id, $lvl+1) ?>
            <? endforeach; }?>
            
		<? gallery_row($galleries, 0, 0); ?>

	<? else: ?>
		<tr><td colspan="5">There are no galleries.</td></tr>
	<? endif;?>
	</tbody>
</table>
	
<div class="fcc-table-buttons">
	<a href="<?=site_url('admin/galleries/create')?>"><img src="/assets/img/admin/fcc/btn-new.jpg" alt="New" title="New" /></a>
	<input type="image" src="/assets/img/admin/fcc/btn-delete.jpg" alt="Delete" name="btnDelete" value="Delete" />
</div>

<?=form_close(); ?>