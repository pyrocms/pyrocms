<?php echo form_open('admin/galleries/delete');?>		
	<table border="0" class="table-list">			
		<thead>
			<tr>
				<th><?php echo form_checkbox('action_to_all');?></th>
				<th><?php echo lang('gal_album_label');?></th>
				<th><?php echo lang('gal_number_of_photo_label');?></th>
				<th><?php echo lang('gal_updated_label');?></th>
				<th><span><?php echo lang('gal_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
<?php if (!empty($galleries)): ?>		
		<?php function gallery_row($tree, $parent, $lvl) { ?>
		<?php if(isset($tree[$parent])) foreach ($tree[$parent] as $gallery): ?>
			<tr>
				<td><input type="checkbox" name="delete[<?php echo $gallery->slug;?>]" /></td>
        <td><?php echo repeater('-- ', $lvl);?> <?php echo $gallery->title;?></td>
        <td><?php echo $gallery->num_photos;?></td>
        <td><?php echo date('M d, Y', $gallery->updated_on);?></td>
        <td><?php echo anchor('galleries/' . $gallery->slug, lang('gal_view_label'), 'target="_blank"') . ' | ' .
						anchor('admin/galleries/manage/' . $gallery->slug, lang('gal_manage_label')) . ' | ' .
						anchor('admin/galleries/edit/' . $gallery->slug, lang('gal_edit_label')) . ' | ' .
						anchor('admin/galleries/delete/' . $gallery->slug, lang('gal_delete_label'), array('class'=>'confirm')); ?>
        </td>
      </tr>
      <?php gallery_row($tree, $gallery->id, $lvl+1) ?>
      <?php endforeach; }?>            
			<?php gallery_row($galleries, 0, 0); ?>
<?php else: ?>
			<tr>
				<td colspan="5"><?php echo lang('gal_no_galleries_error');?></td>
			</tr>
<?php endif;?>
		</tbody>
	</table>	
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>