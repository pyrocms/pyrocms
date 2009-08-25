<?php echo form_open('admin/pages/delete'); ?>
<table border="0" class="listTable">    
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#"><?php echo lang('page_page_label');?></a></th>
		<th><a href="#"><?=lang('page_parent_label');?></a></th>
		<!-- <th><a href="#"><?//=lang('page_language_label');?></a></th> -->
		<th class="width-10"><a href="#"><?php echo lang('page_updated_label');?></a></th>
		<th class="last width-15"><span><?php echo lang('page_actions_label');?></span></th>
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
			<td><input type="checkbox" name="action_to[]" value="<?php echo $page->id;?>" <?php echo ($page->slug == 'home' && $page->parent_id == 0 ) ? 'disabled="disabled"' : '' ?> /></td>
	        <td><?php echo $page->title;?></td>
	        
			<?php if($page->parent_id > 0): ?>
	        <td><?php echo @$this->pages_m->getById($page->parent_id)->title;?></td>
	        <?php else: ?>
	        <td><?php echo lang('page_no_selection_label'); ?></td>
	        <?php endif; ?>
	        
	        <!-- <td><?//=isset($languages[$page->lang]['name']) ? $languages[$page->lang]['name'] : lang('page_unknown_label');?></td> -->
	        <td><?php echo date('M d, Y', $page->updated_on); ?></td>
	        <td>
				<?php //echo anchor('/' . $page->slug, lang('page_view_label'), 'target="_blank"') . ' | '; ?>
				<?php echo anchor('admin/pages/edit/' . $page->id, lang('page_edit_label')) . ' | '; ?>
				<?php echo anchor('admin/pages/delete/' . $page->id, lang('page_delete_label'), array('class'=>'confirm')); ?>
	        </td>
		</tr>
		<? endforeach; ?>		
	<? else: ?>
		<tr>
			<td colspan="5"><?php echo lang('page_no_pages');?></td>
		</tr>
	<? endif; ?>
	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>