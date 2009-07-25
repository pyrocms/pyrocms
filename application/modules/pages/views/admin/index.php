<?= form_open('admin/pages/delete');?>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#"><?=lang('page_page_label');?></a></th>
		<th><a href="#"><?=lang('page_parent_label');?></a></th>
		<th><a href="#"><?=lang('page_language_label');?></a></th>
		<th><a href="#"><?=lang('page_updated_label');?></a></th>
		<th class="last"><span><?=lang('page_actions_label');?></span></th>
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
	<? if (!empty($pages)): ?>
		<? foreach ($pages as $page): ?>
		<tr>
			<td><input type="checkbox" name="action_to[]" value="<?=$page->id;?>" <?=($page->slug == 'home') ? 'disabled="disabled"' : '' ?> /></td>
	        <td><?=$page->title;?></td>
	        <td><?=@$this->pages_m->getById($page->parent, TRUE)->title;?></td>
	        <td><?=isset($languages[$page->lang]['name']) ? $languages[$page->lang]['name'] : lang('page_unknown_label');?></td>
	        <td><?= date('M d, Y', $page->updated_on); ?></td>
	        <td>
				<?= anchor('/' . $page->slug, lang('page_view_label'), 'target="_blank"') . ' | '; ?>
				<?= anchor('admin/pages/edit/' . $page->id, lang('page_edit_label')) . ' | '; ?>
				<?= anchor('admin/pages/delete/' . $page->id, lang('page_delete_label'), array('class'=>'confirm')); ?>
	        </td>
		</tr>
		<? endforeach; ?>		
	<? else: ?>
		<tr>
			<td colspan="5"><?=lang('page_no_pages');?></td>
		</tr>
	<? endif; ?>
	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close(); ?>