<?= form_open('admin/pages/delete');?><table border="0" class="listTable">
    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Page</a></th>
		<th><a href="#">Parent</a></th>
		<th><a href="#">Language</a></th>
		<th><a href="#">Updated</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
  <tbody>	<? if ($pages):		
		foreach ($pages as $page): ?>			<tr>
				<td><input type="checkbox" name="delete[<?=$page->id;?>]" <?=($page->slug == 'home') ? 'disabled="disabled"' : '' ?> /></td>                    <td><?=$page->title;?></td>                    <td><?=@$this->pages_m->getPage(array('id'=>$page->parent))->title;?></td>
                    <td><?=isset($languages[$page->lang]) ? $languages[$page->lang] : 'Unknown';?></td>                    <td><?= date('M d, Y', $page->updated_on); ?></td>                    <td><?= anchor('/' . $page->slug, 'View', 'target="_blank"') . ' | '                          . anchor('admin/pages/edit/' . $page->id, 'Edit') . ' | '                          . anchor('admin/pages/delete/' . $page->id, 'Delete', array('class'=>'confirm'));?></td>			</tr>		<? endforeach; ?>
			<? else: ?>		<tr><td colspan="5">There are no pages.</td></tr>	<? endif; ?>	</tbody></table><div class="fcc-table-buttons">	<a href="<?=site_url('admin/pages/create')?>"><img src="/assets/img/admin/fcc/btn-new.jpg" alt="New" title="New" /></a>	<input type="image" src="/assets/img/admin/fcc/btn-delete.jpg" alt="Delete" name="btnDelete" value="Delete" /></div>
<?=form_close(); ?>