<?=form_open('admin/galleries/delete');?>		
	<table border="0" class="listTable">			
		<thead>
			<tr>
				<th class="first"><div></div></th>
				<th><a href="#"><?=lang('gal_album_label');?></a></th>
				<th><a href="#"><?=lang('gal_number_of_photo_label');?></a></th>
				<th><a href="#"><?=lang('gal_updated_label');?></a></th>
				<th class="last"><span><?=lang('gal_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
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
        <td><?= anchor('galleries/' . $gallery->slug, lang('gal_view_label'), 'target="_blank"') . ' | ' .
						anchor('admin/galleries/manage/' . $gallery->slug, lang('gal_manage_label')) . ' | ' .
						anchor('admin/galleries/edit/' . $gallery->slug, lang('gal_edit_label')) . ' | ' .
						anchor('admin/galleries/delete/' . $gallery->slug, lang('gal_delete_label'), array('class'=>'confirm')); ?>
        </td>
      </tr>
      <? gallery_row($tree, $gallery->id, $lvl+1) ?>
      <? endforeach; }?>            
			<? gallery_row($galleries, 0, 0); ?>
<? else: ?>
			<tr>
				<td colspan="5"><?=lang('gal_no_galleries_error');?></td>
			</tr>
<? endif;?>
		</tbody>
	</table>	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close(); ?>